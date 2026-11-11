param ([switch] $CheckPhp, [switch] $NoBrowser)

$ErrorActionPreference = 'Stop'

$projectPath = $PSScriptRoot
$serverUrl = 'http://localhost:8000'
$readinessUrl = 'http://127.0.0.1:8000'
$port = 8000
$vitePort = 5173
$viteReadinessUrl = "http://127.0.0.1:$vitePort/@vite/client"
$viteHotFile = Join-Path $projectPath 'public\hot'

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

function Get-NpmExecutable {
    param ([string[]] $laragonRoots)

    $paths = @(Get-Command npm.cmd -All -ErrorAction SilentlyContinue | ForEach-Object { $_.Source })

    foreach ($root in $laragonRoots) {
        $nodeDirectory = Join-Path $root 'bin\nodejs'

        if (Test-Path -LiteralPath $nodeDirectory -PathType Container) {
            $paths += @(Get-ChildItem -LiteralPath $nodeDirectory -Directory | ForEach-Object { Join-Path $_.FullName 'npm.cmd' })
            $paths += (Join-Path $nodeDirectory 'npm.cmd')
        }
    }

    if ($env:ProgramFiles) {
        $paths += (Join-Path $env:ProgramFiles 'nodejs\npm.cmd')
    }

    return $paths | Where-Object { $_ -and (Test-Path -LiteralPath $_ -PathType Leaf) } | Select-Object -Unique -First 1
}

function Show-LaunchError {
    param ([string] $message)

    Add-Type -AssemblyName System.Windows.Forms
    [System.Windows.Forms.MessageBox]::Show(
        $message,
        'HEMOCOLAB',
        [System.Windows.Forms.MessageBoxButtons]::OK,
        [System.Windows.Forms.MessageBoxIcon]::Error
    ) | Out-Null
}

function Test-AppReady {
    try {
        $response = Invoke-WebRequest -Uri $readinessUrl -UseBasicParsing -TimeoutSec 2
        return $response.StatusCode -eq 200 -and $response.Content.Contains('HEMOCOLAB')
    } catch {
        return $false
    }
}

function Test-ViteReady {
    if (-not (Test-Path -LiteralPath $viteHotFile -PathType Leaf)) {
        return $false
    }

    $viteUrl = (Get-Content -LiteralPath $viteHotFile -Raw).Trim().TrimEnd('/')

    if ($viteUrl -ne "http://127.0.0.1:$vitePort") {
        return $false
    }

    try {
        $response = Invoke-WebRequest -Uri $viteReadinessUrl -UseBasicParsing -TimeoutSec 2
        return $response.StatusCode -eq 200
    } catch {
        return $false
    }
}

function Test-PortListener {
    param ([int] $port)

    $client = [System.Net.Sockets.TcpClient]::new()

    try {
        return $client.ConnectAsync([System.Net.IPAddress]::Loopback, $port).Wait(1000) -and $client.Connected
    } catch {
        return $false
    } finally {
        $client.Dispose()
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

    # --- Folder catatan dan penentuan mode tampilan ----------------------
    $storageLogs = Join-Path $projectPath 'storage\logs'

    if (-not (Test-Path -LiteralPath $storageLogs -PathType Container)) {
        New-Item -ItemType Directory -Path $storageLogs -Force | Out-Null
    }

    $manifestFile = Join-Path $projectPath 'public\build\manifest.json'
    $asetTerbangun = Test-Path -LiteralPath $manifestFile -PathType Leaf

    if ($asetTerbangun -and (Test-Path -LiteralPath $viteHotFile -PathType Leaf)) {
        # berkas hot tertinggal dari sesi pengembangan; mode tampilan memakai hasil build
        Remove-Item -LiteralPath $viteHotFile -Force -ErrorAction SilentlyContinue
    }

    $perluVite = -not $asetTerbangun

    if ($perluVite) {
        $npmExecutable = Get-NpmExecutable -laragonRoots $laragonRoots

        $punyaVite = [bool]$npmExecutable -and (Test-Path -LiteralPath (Join-Path $projectPath 'node_modules\vite\bin\vite.js') -PathType Leaf)

        if ($npmExecutable -and $punyaVite) {
            # bangun berkas tampilan sekali agar kios berikutnya tidak memerlukan Node.js
            $env:Path = "$(Split-Path $npmExecutable -Parent);$env:Path"

            Start-Process -FilePath $npmExecutable -ArgumentList @('run', 'build') -WorkingDirectory $projectPath -WindowStyle Hidden -Wait -RedirectStandardOutput (Join-Path $storageLogs 'hemocolab-build.log') -RedirectStandardError (Join-Path $storageLogs 'hemocolab-build-error.log')

            if (Test-Path -LiteralPath $manifestFile -PathType Leaf) {
                $perluVite = $false
                Remove-Item -LiteralPath $viteHotFile -Force -ErrorAction SilentlyContinue
            }
        }

        if ($perluVite -and -not ($npmExecutable -and $punyaVite)) {
            throw 'Berkas tampilan (public\build) belum tersedia dan Node.js tidak ditemukan. Jalankan "npm install" lalu "npm run build" satu kali di folder proyek.'
        }
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

    if (-not (Test-PortListener -port 3306) -and $laragonExecutable -and -not (Get-Process -Name laragon -ErrorAction SilentlyContinue)) {
        Start-Process -FilePath $laragonExecutable -WindowStyle Hidden
    }

    if (-not (Test-PortListener -port $port)) {
        $serverProcess = Start-Process -FilePath $phpExecutable -ArgumentList "artisan serve --host=127.0.0.1 --port=$port --tries=1" -WorkingDirectory $projectPath -WindowStyle Hidden -PassThru -RedirectStandardOutput (Join-Path $projectPath 'storage\logs\hemocolab-server.log') -RedirectStandardError (Join-Path $projectPath 'storage\logs\hemocolab-server-error.log')
    }

    if ($perluVite) {
        if (-not (Test-ViteReady)) {
            if (Test-PortListener -port $vitePort) {
                throw "Port $vitePort sudah dipakai aplikasi lain. Tutup aplikasi tersebut lalu klik shortcut lagi."
            }

            $viteProcess = Start-Process -FilePath $npmExecutable -ArgumentList @('run', 'dev', '--', '--host', '127.0.0.1', '--port', "$vitePort", '--strictPort') -WorkingDirectory $projectPath -WindowStyle Hidden -PassThru -RedirectStandardOutput (Join-Path $projectPath 'storage\logs\hemocolab-vite.log') -RedirectStandardError (Join-Path $projectPath 'storage\logs\hemocolab-vite-error.log')
        }
    }

    $deadline = (Get-Date).AddSeconds(45)

    while ((Get-Date) -lt $deadline) {
        if ((Test-AppReady) -and ((-not $perluVite) -or (Test-ViteReady))) {
            break
        }

        if ($serverProcess -and $serverProcess.HasExited) {
            throw 'Server gagal dijalankan. Periksa storage\logs\hemocolab-server-error.log.'
        }

        if ($viteProcess -and $viteProcess.HasExited) {
            throw 'Vite gagal dijalankan. Periksa storage\logs\hemocolab-vite-error.log.'
        }

        Start-Sleep -Milliseconds 500
    }

    if (-not (Test-AppReady)) {
        throw 'Aplikasi belum siap. Klik Start All di Laragon jika MySQL belum aktif, lalu klik shortcut lagi. Pastikan port 8000 tidak dipakai aplikasi lain. Detail server ada di storage\logs\hemocolab-server-error.log.'
    }

    if ($perluVite -and -not (Test-ViteReady)) {
        throw 'Vite belum siap. Periksa storage\logs\hemocolab-vite.log dan hemocolab-vite-error.log.'
    }

    if (-not $NoBrowser) {
        Start-Process -FilePath $serverUrl
    }
} catch {
    if ($CheckPhp -or $NoBrowser) {
        [Console]::Error.WriteLine("Baris $($_.InvocationInfo.ScriptLineNumber): $($_.Exception.Message)")
        exit 1
    }

    Show-LaunchError $_.Exception.Message
    exit 1
}
