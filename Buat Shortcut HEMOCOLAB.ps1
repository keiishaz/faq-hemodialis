param (
    [switch] $Desktop,
    [switch] $TanpaDesktop,
    [switch] $StartMenu
)

$ErrorActionPreference = 'Stop'

$root = $PSScriptRoot
$vbs = Join-Path $root 'Buka HEMOCOLAB.vbs'

if (-not (Test-Path -LiteralPath $vbs -PathType Leaf)) {
    throw "Berkas 'Buka HEMOCOLAB.vbs' tidak ditemukan di folder proyek."
}

# --- Logo HEMOCOLAB -------------------------------------------------------
# Ikon asli berada di public\images. Berkas tersebut disalin ke folder tetap
# milik pengguna agar ikon tetap tampil walaupun folder proyek dipindahkan
# atau namanya diubah.
$iconSource = Join-Path $root 'public\images\hemocolab-shortcut.ico'
if (-not (Test-Path -LiteralPath $iconSource -PathType Leaf)) {
    $iconSource = Join-Path $root 'public\favicon.ico'
}
if (-not (Test-Path -LiteralPath $iconSource -PathType Leaf)) {
    throw "Logo HEMOCOLAB tidak ditemukan di public\images\hemocolab-shortcut.ico."
}

$iconDir = Join-Path $env:LOCALAPPDATA 'HEMOCOLAB'
New-Item -ItemType Directory -Force -Path $iconDir | Out-Null
$icon = Join-Path $iconDir 'hemocolab.ico'
Copy-Item -LiteralPath $iconSource -Destination $icon -Force
Write-Host "Logo HEMOCOLAB disalin ke: $icon"

# --- Sasaran shortcut -----------------------------------------------------
$targets = @()
$targets += (Join-Path $root 'HEMOCOLAB.lnk')

if (-not $TanpaDesktop) {
    $desktopPath = [Environment]::GetFolderPath('Desktop')
    if ($desktopPath) {
        $targets += (Join-Path $desktopPath 'HEMOCOLAB.lnk')
    }
}

if ($StartMenu) {
    $programs = [Environment]::GetFolderPath('Programs')
    if ($programs) {
        $targets += (Join-Path $programs 'HEMOCOLAB.lnk')
    }
}

$shell = New-Object -ComObject WScript.Shell

foreach ($lnkPath in $targets) {
    $shortcut = $shell.CreateShortcut($lnkPath)
    $shortcut.TargetPath = Join-Path $env:SystemRoot 'System32\wscript.exe'
    $shortcut.Arguments = '"' + $vbs + '"'
    $shortcut.WorkingDirectory = $root
    $shortcut.IconLocation = $icon + ',0'
    $shortcut.Description = 'HEMOCOLAB - Hemodialysis Collaborative Learning and Education'
    $shortcut.Save()
    Write-Host "Shortcut dibuat: $lnkPath"
}

# Segarkan cache ikon Windows agar logo langsung tampil tanpa perlu log out.
Start-Process -FilePath 'ie4uinit.exe' -ArgumentList '-show' -NoNewWindow -Wait -ErrorAction SilentlyContinue

Write-Host ''
Write-Host 'Selesai. Logo HEMOCOLAB kini dipakai pada ikon shortcut.'
Write-Host 'Jika ikon lama masih terlihat, klik kanan desktop > Refresh.'
