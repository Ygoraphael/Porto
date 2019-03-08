@ECHO OFF

REM executar como administrador

set FILE=%1
set FILE=%FILE:"=%
set NAME=%2
set NAME=%NAME:"=%
set DESC=%3
set DESC=%DESC:"=%

echo Installing Windows Service...
echo ---------------------------------------------------
sc create "%NAME%" binPath= "%~dp0%FILE%" DisplayName= "%NAME%"
sc description "%NAME%" "%DESC%"
sc config "%NAME%" start= auto
echo ---------------------------------------------------
echo Done.
PAUSE