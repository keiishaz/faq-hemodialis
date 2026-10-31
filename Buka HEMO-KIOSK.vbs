Set shell = CreateObject("WScript.Shell")
Set fileSystem = CreateObject("Scripting.FileSystemObject")

projectPath = fileSystem.GetParentFolderName(WScript.ScriptFullName)
launcherPath = fileSystem.BuildPath(projectPath, "Buka HEMO-KIOSK.ps1")
command = "powershell.exe -NoProfile -ExecutionPolicy Bypass -WindowStyle Hidden -File """ & launcherPath & """"

shell.Run command, 0, False
