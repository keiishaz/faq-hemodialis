$ErrorActionPreference = 'Stop'

$root = $PSScriptRoot

# --- 1. Siapkan logo HEMOCOLAB pada folder tetap --------------------------
$iconSource = Join-Path $root 'public\images\hemocolab-shortcut.ico'
if (-not (Test-Path -LiteralPath $iconSource -PathType Leaf)) {
    $iconSource = Join-Path $root 'public\favicon.ico'
}
if (-not (Test-Path -LiteralPath $iconSource -PathType Leaf)) {
    throw 'Logo HEMOCOLAB tidak ditemukan di public\images\hemocolab-shortcut.ico.'
}

$iconDir = Join-Path $env:LOCALAPPDATA 'HEMOCOLAB'
New-Item -ItemType Directory -Force -Path $iconDir | Out-Null
$icon = Join-Path $iconDir 'hemocolab.ico'
Copy-Item -LiteralPath $iconSource -Destination $icon -Force

# --- 2. Cari shortcut HEMOCOLAB yang sudah ada ----------------------------
$folderDesktop = [Environment]::GetFolderPath('Desktop')
$folderPrograms = [Environment]::GetFolderPath('Programs')
$folderStart = [Environment]::GetFolderPath('StartMenu')

$calon = @()
$calon += (Join-Path $root 'HEMOCOLAB.lnk')
$calon += (Join-Path $root 'HEMO-KIOSK.lnk')
if ($folderDesktop) {
    $calon += (Join-Path $folderDesktop 'HEMOCOLAB.lnk')
    $calon += (Join-Path $folderDesktop 'HEMO-KIOSK.lnk')
    $calon += (Get-ChildItem -LiteralPath $folderDesktop -Filter '*.lnk' -ErrorAction SilentlyContinue |
        Where-Object { $_.Name -like '*HEMOCOLAB*' -or $_.Name -like '*HEMO-KIOSK*' } |
        Select-Object -ExpandProperty FullName)
}
if ($folderPrograms) {
    $calon += (Join-Path $folderPrograms 'HEMOCOLAB.lnk')
}
if ($folderStart) {
    $calon += (Join-Path $folderStart 'HEMOCOLAB.lnk')
}

$calon = $calon | Where-Object { $_ } | Select-Object -Unique

$shell = New-Object -ComObject WScript.Shell
$diperbarui = 0

foreach ($lnk in $calon) {
    if (-not (Test-Path -LiteralPath $lnk -PathType Leaf)) {
        continue
    }

    try {
        $shortcut = $shell.CreateShortcut($lnk)
    } catch {
        continue
    }

    # Hanya sentuh shortcut yang memang menjalankan HEMOCOLAB.
    $menjalankanAplikasi = ($shortcut.Arguments -like '*Buka HEMOCOLAB.vbs*') -or
        ($shortcut.TargetPath -like '*HEMOCOLAB*') -or
        ($lnk -like '*HEMOCOLAB*')

    if (-not $menjalankanAplikasi) {
        continue
    }

    $shortcut.IconLocation = $icon + ',0'
    $shortcut.Save()
    $diperbarui++
    Write-Host ('Ikon logo HEMOCOLAB dipasang pada: ' + $lnk)
}

# --- 3. Bila belum ada shortcut, buatkan satu di desktop ------------------
if ($diperbarui -eq 0) {
    $vbs = Join-Path $root 'Buka HEMOCOLAB.vbs'
    if (-not (Test-Path -LiteralPath $vbs -PathType Leaf)) {
        throw "Shortcut belum ada dan berkas 'Buka HEMOCOLAB.vbs' tidak ditemukan."
    }
    if (-not $folderDesktop) {
        throw 'Folder desktop tidak terdeteksi pada sistem ini.'
    }

    $lnkBaru = Join-Path $folderDesktop 'HEMOCOLAB.lnk'
    $shortcut = $shell.CreateShortcut($lnkBaru)
    $shortcut.TargetPath = Join-Path $env:SystemRoot 'System32\wscript.exe'
    $shortcut.Arguments = '"' + $vbs + '"'
    $shortcut.WorkingDirectory = $root
    $shortcut.IconLocation = $icon + ',0'
    $shortcut.Description = 'HEMOCOLAB - Hemodialysis Collaborative Learning and Education'
    $shortcut.Save()
    Write-Host ('Shortcut baru dibuat dengan logo HEMOCOLAB: ' + $lnkBaru)
}

# --- 4. Segarkan cache ikon Windows --------------------------------------
Start-Process -FilePath 'ie4uinit.exe' -ArgumentList '-show' -NoNewWindow -Wait -ErrorAction SilentlyContinue

Write-Host ''
Write-Host 'Selesai. Logo HEMOCOLAB sekarang menjadi ikon shortcut di desktop.'
Write-Host 'Bila ikon lama masih terlihat, klik kanan desktop lalu pilih Refresh.'
