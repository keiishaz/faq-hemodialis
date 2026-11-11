param (
    [switch] $Desktop
)

$ErrorActionPreference = 'Stop'

$root = $PSScriptRoot
$vbs = Join-Path $root 'Buka HEMOCOLAB.vbs'
$icon = Join-Path $root 'public\images\hemocolab-shortcut.ico'

if (-not (Test-Path -LiteralPath $vbs -PathType Leaf)) {
    throw "Berkas 'Buka HEMOCOLAB.vbs' tidak ditemukan di folder proyek."
}

if (-not (Test-Path -LiteralPath $icon -PathType Leaf)) {
    $icon = Join-Path $env:SystemRoot 'System32\shell32.dll'
}

$targets = @((Join-Path $root 'HEMOCOLAB.lnk'))
if ($Desktop) {
    $targets += (Join-Path ([Environment]::GetFolderPath('Desktop')) 'HEMOCOLAB.lnk')
}

$shell = New-Object -ComObject WScript.Shell

foreach ($lnkPath in $targets) {
    $shortcut = $shell.CreateShortcut($lnkPath)
    $shortcut.TargetPath = Join-Path $env:SystemRoot 'System32\wscript.exe'
    $shortcut.Arguments = '"' + $vbs + '"'
    $shortcut.WorkingDirectory = $root
    $shortcut.IconLocation = $icon
    $shortcut.Description = 'HEMOCOLAB - Hemodialysis Collaborative Learning and Education'
    $shortcut.Save()
    Write-Host "Shortcut dibuat: $lnkPath"
}

Write-Host 'Selesai. Klik dua kali shortcut HEMOCOLAB untuk membuka aplikasi.'
