$ErrorActionPreference = 'Stop'

$projectPath = $PSScriptRoot
$phpExecutable = 'C:\laragon\bin\php\php-8.3.33-Win32-vs16-x64\php.exe'
$laragonExecutable = 'C:\laragon\laragon.exe'
$serverUrl = 'http://localhost:8000'
$readinessUrl = 'http://127.0.0.1:8000'
$port = 8000

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
    if (-not (Test-Path -LiteralPath $phpExecutable -PathType Leaf)) {
        throw "PHP Laragon tidak ditemukan: $phpExecutable"
    }

    if (-not (Test-Path -LiteralPath (Join-Path $projectPath 'artisan') -PathType Leaf)) {
        throw "Folder proyek tidak ditemukan: $projectPath"
    }

    $databaseListener = Get-NetTCPConnection -LocalPort 3306 -State Listen -ErrorAction SilentlyContinue | Select-Object -First 1

    if (-not $databaseListener -and (Test-Path -LiteralPath $laragonExecutable -PathType Leaf) -and -not (Get-Process -Name laragon -ErrorAction SilentlyContinue)) {
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
    Show-LaunchError $_.Exception.Message
    exit 1
}
