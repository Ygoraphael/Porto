@ECHO OFF

REM executar como administrador

set FILE=%1
set FILE=%FILE:"=%
set NAME=%2
set NAME=%NAME:"=%

echo Uninstalling Windows Service...
echo ---------------------------------------------------
sc delete "%NAME%" binPath= "%~dp0%FILE%"
echo ---------------------------------------------------
echo Done.
PAUSE