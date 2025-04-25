@echo off

REM QubeStat Project Setup for Windows
echo.
echo ================================
echo  QubeStat Project Setup: WINDOWS
echo ================================
echo.
echo [!] Please RESTART VS Code or your terminal AFTER installing Composer.
echo     Then re-run this script if dependencies are not installed.
echo.

REM Force copy env-example to .env
echo [+] Updating .env file from env-example...
copy /Y env-example .env >nul 2>&1
if %ERRORLEVEL% EQU 0 (
    echo [+] .env file created or updated successfully.
) else (
    echo [-] Failed to update .env file.
    exit /b 1
)

REM Check if composer exists
where composer >nul 2>&1
if %ERRORLEVEL% EQU 0 (
    echo [+] Composer found. Installing dependencies...
    composer install
    if %ERRORLEVEL% EQU 0 (
        echo [+] Composer dependencies installed successfully.
        exit /b 0
    ) else (
        echo [-] Composer failed to install dependencies.
        exit /b 1
    )
) else (
    REM Composer not found, install it
    if not exist "composer-setup.exe" (
        echo [+] Downloading composer-setup.exe...
        curl -s -O https://getcomposer.org/Composer-Setup.exe
        if %ERRORLEVEL% NEQ 0 (
            echo [-] Failed to download Composer setup.
            exit /b 1
        )
    )

    echo [+] Running composer setup...
    start /wait composer-setup.exe

    del composer-setup.exe

    REM Try again after install
    where composer >nul 2>&1
    if %ERRORLEVEL% EQU 0 (
        echo [+] Composer installed. Installing dependencies...
        composer install
        if %ERRORLEVEL% EQU 0 (
            echo [+] Dependencies installed successfully.
            exit /b 0
        ) else (
            echo [-] Composer found but failed to install dependencies.
            exit /b 1
        )
    ) else (
        echo [-] Composer install failed or not in PATH. Restart VS Code and try again.
        exit /b 1
    )
)
