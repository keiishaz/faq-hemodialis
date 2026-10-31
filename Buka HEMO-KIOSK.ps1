param ([switch] $CheckPhp)

$ErrorActionPreference = 'Stop'

$projectPath = $PSScriptRoot
$serverUrl = 'http://localhost:8000'
$readinessUrl = 'http://127.0.0.1:8000'
$port = 8000

function Get-LaragonRoots {
    $roots = @()
    $directory = Get-Item -LiteralPath $projectPath

    while ($directory) {
        if (Test-Path -LiteralPath (Join-Path $directory.FullName 'laragon.exe') -PathType Leaf) {
            $roots += $directory.FullName
        }

        $directory = $directory.Parent
    }

    if ($env:LARAGON_ROOT) {
        $roots += $env:LARAGON_ROOT
    }

    if ($env:SystemDrive) {
        $roots += (Join-Path $env:SystemDrive 'laragon')
    }

    $roots += @(Get-Command laragon.exe -All -ErrorAction SilentlyContinue | ForEach-Object { Split-Path $_.Source -Parent })

    return $roots | Where-Object { $_ -and (Test-Path -LiteralPath (Join-Path $_ 'laragon.exe') -PathType Leaf) } | Select-Object -Unique
}

function Get-PhpExecutable {
    param ([string[]] $laragonRoots)

    $paths = @()

    foreach ($root in $laragonRoots) {
        $phpDirectory = Join-Path $root 'bin\php'

        if (Test-Path -LiteralPath $phpDirectory -PathType Container) {
            $paths += @(Get-ChildItem -LiteralPath $phpDirectory -Directory | ForEach-Object { Join-Path $_.FullName 'php.exe' })
            $paths += (Join-Path $phpDirectory 'php.exe')
        }
    }

    $paths += @(Get-Command php.exe -All -ErrorAction SilentlyContinue | ForEach-Object { $_.Source })
    $available = foreach ($path in ($paths | Where-Object { $_ } | Select-Object -Unique)) {
        if (-not (Test-Path -LiteralPath $path -PathType Leaf)) {
            continue
        }

        try {
            $versionOutput = & $path -r 'echo PHP_VERSION;' 2>$null
        } catch {
            continue
        }

        if ($LASTEXITCODE -ne 0) {
            continue
        }

        $versionText = ($versionOutput -join '').Trim()

        try {
            $version = [Version]::Parse($versionText)
        } catch {
            continue
        }

        if ($version -ge [Version]'8.3.0' -and $version -lt [Version]'9.0.0') {
            [pscustomobject]@{ Path = $path; Version = $version }
        }
    }

    return $available | Sort-Object Version -Descending | Select-Object -First 1
}

function Show-LaunchError {
    param ([string] $message)

    Add-Type -AssemblyName System.Windows.Forms
    [System.Windows.Forms.MessageBox]::Show(
        $message,
        'HEMO-KIOSK',
        [System.Windows.Forms.MessageBoxButtons]::OK,
        [System.Windows.Forms.MessageBoxIcon]::Error
    ) | Out-Null
}

function Test-AppReady {
    try {
        $response = Invoke-WebRequest -Uri $readinessUrl -UseBasicParsing -TimeoutSec 2
        return $response.StatusCode -eq 200 -and $response.Content.Contains('HEMO-KIOSK')
    } catch {
        return $false
    }
}

try {
    if (-not (Test-Path -LiteralPath (Join-Path $projectPath 'artisan') -PathType Leaf)) {
        throw "Folder proyek tidak ditemukan: $projectPath"
    }

    $laragonRoots = @(Get-LaragonRoots)
    $php = Get-PhpExecutable -laragonRoots $laragonRoots

    if (-not $php) {
        throw 'PHP 8.3 atau lebih baru (di bawah 9.0) tidak ditemukan. Pasang PHP di Laragon atau tambahkan php.exe ke PATH.'
    }

    $phpExecutable = $php.Path

    if ($CheckPhp) {
        Write-Output "PHP $($php.Version): $phpExecutable"
        exit 0
    }

    $laragonExecutable = $null

    foreach ($root in $laragonRoots) {
        $phpDirectory = (Join-Path $root 'bin\php') + [System.IO.Path]::DirectorySeparatorChar

        if ($phpExecutable.StartsWith($phpDirectory, [StringComparison]::OrdinalIgnoreCase)) {
            $laragonExecutable = Join-Path $root 'laragon.exe'
            break
        }
    }

    if (-not $laragonExecutable -and $laragonRoots.Count -gt 0) {
        $laragonExecutable = Join-Path $laragonRoots[0] 'laragon.exe'
    }

    $databaseListener = Get-NetTCPConnection -LocalPort 3306 -State Listen -ErrorAction SilentlyContinue | Select-Object -First 1

    if (-not $databaseListener -and $laragonExecutable -and -not (Get-Process -Name laragon -ErrorAction SilentlyContinue)) {
        Start-Process -FilePath $laragonExecutable
    }

    $listener = Get-NetTCPConnection -LocalPort $port -State Listen -ErrorAction SilentlyContinue | Select-Object -First 1

    if (-not $listener) {
        $serverProcess = Start-Process -FilePath $phpExecutable -ArgumentList "artisan serve --host=127.0.0.1 --port=$port --tries=1" -WorkingDirectory $projectPath -WindowStyle Hidden -PassThru -RedirectStandardOutput (Join-Path $projectPath 'storage\logs\hemo-kiosk-server.log') -RedirectStandardError (Join-Path $projectPath 'storage\logs\hemo-kiosk-server-error.log')
    }

    $deadline = (Get-Date).AddSeconds(30)

    while ((Get-Date) -lt $deadline) {
        if (Test-AppReady) {
            break
        }

        if ($serverProcess -and $serverProcess.HasExited) {
            throw 'Server gagal dijalankan. Periksa storage\logs\hemo-kiosk-server-error.log.'
        }

        Start-Sleep -Milliseconds 500
    }

    if (-not (Test-AppReady)) {
        throw 'Aplikasi belum siap. Klik Start All di Laragon jika MySQL belum aktif, lalu klik shortcut lagi. Pastikan port 8000 tidak dipakai aplikasi lain. Detail server ada di storage\logs\hemo-kiosk-server-error.log.'
    }

    Start-Process -FilePath $serverUrl
} catch {
    if ($CheckPhp) {
        [Console]::Error.WriteLine($_.Exception.Message)
        exit 1
    }

    Show-LaunchError $_.Exception.Message
    exit 1
}
