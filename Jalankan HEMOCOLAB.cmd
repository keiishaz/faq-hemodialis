@echo off
chcp 65001 >nul
cd /d "%~dp0"
echo ============================================
echo  HEMOCOLAB - menjalankan aplikasi
echo ============================================
echo.
echo Folder proyek: %CD%
echo.
powershell.exe -NoProfile -ExecutionPolicy Bypass -File "%~dp0Buka HEMOCOLAB.ps1"
set KODE=%ERRORLEVEL%
echo.
echo Selesai dengan kode: %KODE%
echo.
echo Jika ada pesan kesalahan di atas, kirimkan teksnya untuk diperiksa.
pause
