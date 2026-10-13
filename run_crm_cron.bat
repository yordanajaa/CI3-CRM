@echo off
title CRM Automation Engine Runner - IDMETAFORA
echo ========================================================
echo   EXECUTING CRM AUTOMATION ENGINE (CLI CRON JOB)
echo ========================================================
echo.

cd /d "C:\laragon\www\ci3_metafora"

if exist "C:\laragon\bin\php\php-7.2.34-nts-Win32-VC15-x64\php.exe" (
    "C:\laragon\bin\php\php-7.2.34-nts-Win32-VC15-x64\php.exe" index.php administrator crm cli_automations
) else (
    php index.php administrator crm cli_automations
)

echo.
echo ========================================================
echo   AUTOMATION EXECUTION COMPLETED AT %DATE% %TIME%
echo ========================================================
echo.
pause
