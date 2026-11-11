Option Explicit

' Membuat shortcut HEMOCOLAB di Desktop dengan logo HEMOCOLAB.
' Shortcut dibentuk memakai layanan Windows sendiri (WScript.Shell) agar
' dijamin dapat diklik dua kali, lalu sasaran peluncur diarahkan ke berkas
' .vbs yang sudah terbukti berjalan pada komputer ini.

Dim fso, shell, root, vbsPath, icoPath, desktopPath, lnkPath, shortcut

Set fso = CreateObject("Scripting.FileSystemObject")
Set shell = CreateObject("WScript.Shell")

root = fso.GetParentFolderName(WScript.ScriptFullName)

' --- 1. Berkas peluncur (.vbs) -------------------------------------------
vbsPath = ""
If fso.FileExists(fso.BuildPath(root, "HEMOCOLAB.vbs")) Then
    vbsPath = fso.BuildPath(root, "HEMOCOLAB.vbs")
ElseIf fso.FileExists(fso.BuildPath(root, "Buka HEMOCOLAB.vbs")) Then
    vbsPath = fso.BuildPath(root, "Buka HEMOCOLAB.vbs")
Else
    MsgBox "Berkas peluncur (.vbs) tidak ditemukan di folder:" & vbCrLf & root, 16, "HEMOCOLAB"
    WScript.Quit 1
End If

' --- 2. Berkas logo -------------------------------------------------------
icoPath = ""
If fso.FileExists(fso.BuildPath(root, "HEMOCOLAB.ico")) Then
    icoPath = fso.BuildPath(root, "HEMOCOLAB.ico")
ElseIf fso.FileExists(fso.BuildPath(root, "public\images\hemocolab-shortcut.ico")) Then
    icoPath = fso.BuildPath(root, "public\images\hemocolab-shortcut.ico")
Else
    MsgBox "Berkas logo HEMOCOLAB.ico tidak ditemukan di folder:" & vbCrLf & root, 16, "HEMOCOLAB"
    WScript.Quit 1
End If

' --- 3. Bentuk shortcut di Desktop ---------------------------------------
desktopPath = shell.SpecialFolders("Desktop")

If desktopPath = "" Then
    MsgBox "Folder Desktop tidak terdeteksi pada sistem ini.", 16, "HEMOCOLAB"
    WScript.Quit 1
End If

lnkPath = fso.BuildPath(desktopPath, "HEMOCOLAB.lnk")

Set shortcut = shell.CreateShortcut(lnkPath)
shortcut.TargetPath = shell.ExpandEnvironmentStrings("%SystemRoot%\System32\wscript.exe")
shortcut.Arguments = """" & vbsPath & """"
shortcut.WorkingDirectory = root
shortcut.IconLocation = icoPath & ",0"
shortcut.Description = "HEMOCOLAB - Hemodialisis"
shortcut.WindowStyle = 1
shortcut.Save

MsgBox "Shortcut HEMOCOLAB sudah dibuat di Desktop." & vbCrLf & vbCrLf & _
    "Peluncur : " & vbsPath & vbCrLf & _
    "Logo     : " & icoPath & vbCrLf & vbCrLf & _
    "Klik dua kali ikon HEMOCOLAB di Desktop untuk membuka aplikasi.", 64, "HEMOCOLAB"
