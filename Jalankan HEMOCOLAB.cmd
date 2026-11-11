@echo off
rem Menjalankan peluncur HEMOCOLAB di latar belakang tanpa jendela yang menetap.
cd /d "%~dp0"
start "" /b powershell.exe -NoProfile -ExecutionPolicy Bypass -WindowStyle Hidden -File "%~dp0Buka HEMOCOLAB.ps1"
exit
