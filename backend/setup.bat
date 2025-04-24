@echo off

REM seting up the environment for the project
if not exist ".env" (
    echo [+] Copying .env.example to .env...
    copy env-example .env >nul 2>&1
    if %ERRORLEVEL% EQU 0 (
        echo [+] .env file created successfully.
    ) else (
        echo [-] Failed to create .env file.
        exit /b 1
    )
)


REM Check if composer exists
where composer >nul 2>&1
if %ERRORLEVEL% EQU 0 (
    echo [+] Installing composer dependencies...
    composer install
    if %ERRORLEVEL% EQU 0 (
        echo [+] Composer dependencies installed successfully.
        exit /b 0
    ) else (
        echo [-] Failed to install composer dependencies.
        exit /b 1
    )
) else (
    REM Download composer-setup.exe if it doesn't exist
    REM Check if composer-setup exists
    if not exist "composer-setup.exe" (
        echo [+] Downloading composer-setup.exe...
        curl https://getcomposer.org/Composer-Setup.exe -o composer-setup.exe
        if %ERRORLEVEL% EQU 0 (
            echo [+] composer-setup.exe downloaded!!
        ) else (
            echo [-] Failed to download composer-setup.exe
            exit /b 1
        )
    )
    
    echo [+] Installing composer...
    start /wait composer-setup.exe
    
    echo [+] Composer installed successfully.
    del composer-setup.exe
    
    echo [-] Restart the shell or VS code to access composer.
    exit /b 1
)