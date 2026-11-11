' HEMOCOLAB - peluncur aplikasi
' Menjalankan Buka HEMOCOLAB.ps1 tanpa jendela, mencatat keluaran ke
' storage\logs\hemocolab-launcher.log, dan menampilkan pesan bila gagal.

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
    MsgBox "Berkas Buka HEMOCOLAB.ps1 tidak ditemukan di:" & vbCrLf & projectPath, 16, "HEMOCOLAB"
    WScript.Quit 1
End If

command = "cmd.exe /c powershell.exe -NoProfile -ExecutionPolicy Bypass -File """ & launcherPath & """ > """ & logPath & """ 2>&1"
exitCode = shell.Run(command, 0, True)

If exitCode <> 0 Then
    message = "HEMOCOLAB gagal dijalankan." & vbCrLf & vbCrLf & _
        "Catatan kesalahan disimpan di:" & vbCrLf & logPath & vbCrLf & vbCrLf & _
        "Buka berkas tersebut atau jalankan ""Jalankan HEMOCOLAB.cmd"" untuk melihat pesan lengkap."
    MsgBox message, 16, "HEMOCOLAB"
End If
