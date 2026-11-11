Option Explicit

' Membuat shortcut HEMOCOLAB di Desktop.
' Shortcut diarahkan ke cmd.exe yang menjalankan Jalankan HEMOCOLAB.cmd,
' sehingga tidak bergantung pada asosiasi berkas .vbs maupun .exe.

Dim fso, shell, folder, berkasCmd, berkasPs1, berkasIco, desktop, jalurLnk, lnk, perintah

Set fso = CreateObject("Scripting.FileSystemObject")
Set shell = CreateObject("WScript.Shell")

folder = fso.GetParentFolderName(WScript.ScriptFullName)
berkasCmd = fso.BuildPath(folder, "Jalankan HEMOCOLAB.cmd")
berkasPs1 = fso.BuildPath(folder, "Buka HEMOCOLAB.ps1")
berkasIco = fso.BuildPath(folder, "HEMOCOLAB.ico")

If Not fso.FileExists(berkasCmd) Then
    MsgBox "Berkas Jalankan HEMOCOLAB.cmd tidak ditemukan di:" & vbCrLf & folder, 16, "HEMOCOLAB"
    WScript.Quit 1
End If

If Not fso.FileExists(berkasPs1) Then
    MsgBox "Berkas Buka HEMOCOLAB.ps1 tidak ditemukan di:" & vbCrLf & folder, 16, "HEMOCOLAB"
    WScript.Quit 1
End If

If Not fso.FileExists(berkasIco) Then
    MsgBox "Berkas HEMOCOLAB.ico tidak ditemukan di:" & vbCrLf & folder, 16, "HEMOCOLAB"
    WScript.Quit 1
End If

desktop = shell.SpecialFolders("Desktop")

If desktop = "" Then
    MsgBox "Folder Desktop tidak terdeteksi pada sistem ini.", 16, "HEMOCOLAB"
    WScript.Quit 1
End If

jalurLnk = fso.BuildPath(desktop, "HEMOCOLAB.lnk")
perintah = "/c """ & berkasCmd & """"

Set lnk = shell.CreateShortcut(jalurLnk)
lnk.TargetPath = shell.ExpandEnvironmentStrings("%SystemRoot%\System32\cmd.exe")
lnk.Arguments = perintah
lnk.WorkingDirectory = folder
lnk.IconLocation = berkasIco & ",0"
lnk.Description = "HEMOCOLAB - Hemodialisis"
lnk.WindowStyle = 7
lnk.Save

' segarkan cache ikon agar logo langsung tampil
On Error Resume Next
shell.Run "ie4uinit.exe -show", 0, True
On Error GoTo 0

MsgBox "Shortcut HEMOCOLAB sudah dibuat di Desktop." & vbCrLf & vbCrLf & _
    "Klik dua kali ikon HEMOCOLAB di Desktop untuk membuka aplikasi." & vbCrLf & vbCrLf & _
    "Peluncur: " & berkasCmd, 64, "HEMOCOLAB"
