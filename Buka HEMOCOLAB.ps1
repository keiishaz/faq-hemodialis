param (
    [switch] $Visible,
    [switch] $Check
)

$ErrorActionPreference = 'Stop'

$projectPath   = $PSScriptRoot
$serverUrl     = 'http://localhost:8000'
$serverPort    = 8000
$vitePort      = 5173
$viteHotFile   = Join-Path $projectPath 'public\hot'
$logFolder     = Join-Path $projectPath 'storage\logs'
$logFile       = Join-Path $logFolder 'peluncur.log'
$serverLog     = Join-Path $logFolder 'server.log'
$serverErrLog  = Join-Path $logFolder 'server-error.log'
$viteLog       = Join-Path $logFolder 'vite.log'
$viteErrLog    = Join-Path $logFolder 'vite-error.log'

if (-not (Test-Path -LiteralPath $logFolder -PathType Container)) {
    New-Item -ItemType Directory -Path $logFolder -Force | Out-Null
}

function Tulis-Log {
    param ([string] $pesan)

    $baris = '{0}  {1}' -f (Get-Date -Format 'yyyy-MM-dd HH:mm:ss'), $pesan

    try {
        Add-Content -LiteralPath $logFile -Value $baris -Encoding UTF8
    } catch {
    }

    if ($Visible) {
        Write-Host $baris
    }
}

function Uji-Port {
    param ([int] $port)

    $client = [System.Net.Sockets.TcpClient]::new()

    try {
        return $client.ConnectAsync([System.Net.IPAddress]::Loopback, $port).Wait(1200) -and $client.Connected
    } catch {
        return $false
    } finally {
        $client.Dispose()
    }
}

function Uji-ServerAplikasi {
    try {
        $jawaban = Invoke-WebRequest -Uri "http://127.0.0.1:$serverPort" -UseBasicParsing -TimeoutSec 3
        return $jawaban.StatusCode -eq 200
    } catch {
        return $false
    }
}

function Uji-Vite {
    if (-not (Test-Path -LiteralPath $viteHotFile -PathType Leaf)) {
        return $false
    }

    try {
        $jawaban = Invoke-WebRequest -Uri "http://127.0.0.1:$vitePort/@vite/client" -UseBasicParsing -TimeoutSec 3
        return $jawaban.StatusCode -eq 200
    } catch {
        return $false
    }
}

function Ambil-AkarLaragon {
    $hasil = @()
    $folder = Get-Item -LiteralPath $projectPath

    while ($folder) {
        if (Test-Path -LiteralPath (Join-Path $folder.FullName 'laragon.exe') -PathType Leaf) {
            $hasil += $folder.FullName
        }

        $folder = $folder.Parent
    }

    if ($env:LARAGON_ROOT) {
        $hasil += $env:LARAGON_ROOT
    }

    if ($env:SystemDrive) {
        $hasil += (Join-Path $env:SystemDrive 'laragon')
    }

    return $hasil | Where-Object { $_ -and (Test-Path -LiteralPath (Join-Path $_ 'laragon.exe') -PathType Leaf) } | Select-Object -Unique
}

function Ambil-Php {
    param ([string[]] $akarLaragon)

    $kandidat = @()

    foreach ($akar in $akarLaragon) {
        $folderPhp = Join-Path $akar 'bin\php'

        if (Test-Path -LiteralPath $folderPhp -PathType Container) {
            $kandidat += @(Get-ChildItem -LiteralPath $folderPhp -Directory -ErrorAction SilentlyContinue |
                ForEach-Object { Join-Path $_.FullName 'php.exe' })
            $kandidat += (Join-Path $folderPhp 'php.exe')
        }
    }

    $kandidat += @(Get-Command php.exe -All -ErrorAction SilentlyContinue | ForEach-Object { $_.Source })

    $tersedia = foreach ($jalur in ($kandidat | Where-Object { $_ } | Select-Object -Unique)) {
        if (-not (Test-Path -LiteralPath $jalur -PathType Leaf)) {
            continue
        }

        try {
            $keluaran = & $jalur -r 'echo PHP_VERSION;' 2>$null
        } catch {
            continue
        }

        if ($LASTEXITCODE -ne 0) {
            continue
        }

        $teks = ($keluaran -join '').Trim()

        try {
            $versi = [Version]::Parse($teks)
        } catch {
            continue
        }

        if ($versi -ge [Version]'8.3.0' -and $versi -lt [Version]'9.0.0') {
            [pscustomobject]@{ Jalur = $jalur; Versi = $versi }
        }
    }

    return $tersedia | Sort-Object Versi -Descending | Select-Object -First 1
}

function Ambil-Node {
    param ([string[]] $akarLaragon)

    $kandidat = @()

    foreach ($akar in $akarLaragon) {
        $folderNode = Join-Path $akar 'bin\nodejs'

        if (Test-Path -LiteralPath $folderNode -PathType Container) {
            $kandidat += @(Get-ChildItem -LiteralPath $folderNode -Directory -ErrorAction SilentlyContinue |
                ForEach-Object { Join-Path $_.FullName 'npm.cmd' })
            $kandidat += (Join-Path $folderNode 'npm.cmd')
        }
    }

    $kandidat += @(Get-Command npm.cmd -All -ErrorAction SilentlyContinue | ForEach-Object { $_.Source })

    if ($env:ProgramFiles) {
        $kandidat += (Join-Path $env:ProgramFiles 'nodejs\npm.cmd')
    }

    return $kandidat | Where-Object { $_ -and (Test-Path -LiteralPath $_ -PathType Leaf) } | Select-Object -First 1
}

function Buka-Peramban {
    param ([string] $alamat)

    try {
        Start-Process -FilePath $alamat
        Tulis-Log "Peramban dibuka: $alamat"
    } catch {
        Tulis-Log "Peramban tidak dapat dibuka otomatis: $($_.Exception.Message)"
    }
}

try {
    Tulis-Log '---'
    Tulis-Log "Mulai peluncuran dari: $projectPath"

    if (-not (Test-Path -LiteralPath (Join-Path $projectPath 'artisan') -PathType Leaf)) {
        throw "Folder proyek tidak dikenali (artisan tidak ditemukan): $projectPath"
    }

    $akarLaragon = @(Ambil-AkarLaragon)
    Tulis-Log ("Akar Laragon: " + ($(if ($akarLaragon.Count -gt 0) { $akarLaragon -join '; ' } else { '(tidak ditemukan)' })))

    $php = Ambil-Php -akarLaragon $akarLaragon

    if (-not $php) {
        throw 'PHP 8.3 atau lebih baru tidak ditemukan. Pasang PHP 8.3+ di Laragon (Menu > PHP > Version) atau tambahkan php.exe ke PATH.'
    }

    Tulis-Log "PHP $($php.Versi): $($php.Jalur)"

    if ($Check) {
        exit 0
    }

    $node = Ambil-Node -akarLaragon $akarLaragon
    $viteAda = Test-Path -LiteralPath (Join-Path $projectPath 'node_modules\vite\bin\vite.js') -PathType Leaf

    if (-not $node) {
        throw 'Node.js (npm) tidak ditemukan. Pasang Node.js di Laragon (Menu > Node.js) atau pasang Node.js LTS dari nodejs.org.'
    }

    if (-not $viteAda) {
        throw 'Folder node_modules belum lengkap. Jalankan "npm install" satu kali di folder proyek.'
    }

    Tulis-Log "npm: $node"

    $folderNode = Split-Path $node -Parent
    if (($env:Path -split ';') -notcontains $folderNode) {
        $env:Path = "$folderNode;$env:Path"
    }

    # --- MySQL melalui Laragon -------------------------------------------
    if (-not (Uji-Port -port 3306)) {
        Tulis-Log 'MySQL belum aktif, menyalakan Laragon.'

        $laragonExe = $null
        foreach ($akar in $akarLaragon) {
            if ($php.Jalur.StartsWith((Join-Path $akar 'bin\php'), [StringComparison]::OrdinalIgnoreCase)) {
                $laragonExe = Join-Path $akar 'laragon.exe'
                break
            }
        }

        if (-not $laragonExe -and $akarLaragon.Count -gt 0) {
            $laragonExe = Join-Path $akarLaragon[0] 'laragon.exe'
        }

        if ($laragonExe -and -not (Get-Process -Name laragon -ErrorAction SilentlyContinue)) {
            Start-Process -FilePath $laragonExe -WindowStyle Hidden
        }

        $batasMysql = (Get-Date).AddSeconds(60)
        while ((Get-Date) -lt $batasMysql -and -not (Uji-Port -port 3306)) {
            Start-Sleep -Milliseconds 700
        }

        if (Uji-Port -port 3306) {
            Tulis-Log 'MySQL siap pada port 3306.'
        } else {
            Tulis-Log 'Peringatan: MySQL belum merespons pada port 3306.'
        }
    } else {
        Tulis-Log 'MySQL sudah aktif pada port 3306.'
    }

    # --- php artisan serve ------------------------------------------------
    if (Uji-Port -port $serverPort) {
        if (Uji-ServerAplikasi) {
            Tulis-Log "Port $serverPort sudah melayani aplikasi, server tidak dijalankan ulang."
        } else {
            throw "Port $serverPort sudah dipakai aplikasi lain. Tutup aplikasi tersebut, lalu jalankan HEMOCOLAB kembali."
        }
    } else {
        Tulis-Log "Menjalankan: php artisan serve --port=$serverPort"

        $prosesServer = Start-Process -FilePath $php.Jalur `
            -ArgumentList "artisan serve --host=127.0.0.1 --port=$serverPort" `
            -WorkingDirectory $projectPath -WindowStyle Hidden -PassThru `
            -RedirectStandardOutput $serverLog -RedirectStandardError $serverErrLog

        Start-Sleep -Seconds 1

        if ($prosesServer.HasExited) {
            throw "Server aplikasi berhenti segera setelah dijalankan. Periksa $serverErrLog"
        }

        Tulis-Log "Server aplikasi berjalan (PID $($prosesServer.Id))."
    }

    # --- npm run dev ------------------------------------------------------
    if (Uji-Vite) {
        Tulis-Log 'Vite sudah aktif pada port 5173.'
    } else {
        if (Uji-Port -port $vitePort) {
            throw "Port $vitePort dipakai aplikasi lain. Tutup aplikasi tersebut lalu jalankan HEMOCOLAB kembali."
        }

        Tulis-Log 'Menjalankan: npm run dev'

        $prosesVite = Start-Process -FilePath "$env:SystemRoot\System32\cmd.exe" `
            -ArgumentList '/c', "npm run dev -- --host 127.0.0.1 --port $vitePort --strictPort" `
            -WorkingDirectory $projectPath -WindowStyle Hidden -PassThru `
            -RedirectStandardOutput $viteLog -RedirectStandardError $viteErrLog

        Start-Sleep -Seconds 2

        if ($prosesVite.HasExited) {
            throw "Vite berhenti segera setelah dijalankan. Periksa $viteErrLog"
        }

        Tulis-Log "Vite berjalan (PID $($prosesVite.Id))."
    }

    # --- tunggu siap ------------------------------------------------------
    $batas = (Get-Date).AddSeconds(120)
    $serverSiap = $false
    $viteSiap = $false

    while ((Get-Date) -lt $batas) {
        if (-not $serverSiap) { $serverSiap = Uji-ServerAplikasi }
        if (-not $viteSiap) { $viteSiap = Uji-Vite }

        if ($serverSiap -and $viteSiap) {
            break
        }

        Start-Sleep -Milliseconds 800
    }

    Tulis-Log "Status kesiapan: server=$serverSiap vite=$viteSiap"

    if (-not $serverSiap) {
        throw "Aplikasi belum merespons di http://127.0.0.1:$serverPort. Periksa $serverErrLog dan pastikan MySQL aktif."
    }

    if (-not $viteSiap) {
        throw "Vite belum merespons di port $vitePort. Periksa $viteErrLog."
    }

    Buka-Peramban -alamat $serverUrl
    Tulis-Log 'Peluncuran selesai.'
    exit 0
} catch {
    Tulis-Log "GAGAL: $($_.Exception.Message)"
    exit 1
}
