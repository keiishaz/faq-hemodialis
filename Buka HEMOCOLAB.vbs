' HEMOCOLAB - peluncur aplikasi
' Menjalankan Buka HEMOCOLAB.ps1 di latar belakang. Keluaran proses dicatat ke
' storage\logs\hemocolab-launcher.log, pesan kesalahan ditampilkan oleh
' peluncur PowerShell.

Set shell = CreateObject("WScript.Shell")
Set fileSystem = CreateObject("Scripting.FileSystemObject")

projectPath = fileSystem.GetParentFolderName(WScript.ScriptFullName)
launcherPath = fileSystem.BuildPath(projectPath, "Buka HEMOCOLAB.ps1")
logFolder = fileSystem.BuildPath(projectPath, "storage\logs")

If Not fileSystem.FolderExists(logFolder) Then
    fileSystem.CreateFolder logFolder
End If

logPath = fileSystem.BuildPath(logFolder, "hemocolab-launcher.log")

If Not fileSystem.FileExists(launcherPath) Then
    MsgBox "Berkas peluncur tidak ditemukan di:" & vbCrLf & projectPath, 16, "HEMOCOLAB"
    WScript.Quit 1
End If

command = "cmd.exe /c powershell.exe -NoProfile -ExecutionPolicy Bypass -File """ & launcherPath & """ > """ & logPath & """ 2>&1"
shell.Run command, 0, False
