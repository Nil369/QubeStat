#!/bin/bash

echo
echo "====================================================="
echo "  QubeStat Project Setup - Linux/macOS Environment"
echo "====================================================="
echo
echo "[!] Please RESTART your terminal or VS Code AFTER installing Composer."
echo "    Then re-run this script if dependencies are not installed."
echo

read -p "Press ENTER to continue..."

# Step 1: Check for XAMPP
if [ ! -d "/opt/lampp" ]; then
    echo "[+] XAMPP not found in /opt/lampp."
    echo "    Please install XAMPP from https://www.apachefriends.org/index.html"
    echo "[-] Setup cannot proceed without XAMPP."
    exit 1
else
    echo "[+] XAMPP installation found."
fi

# Step 2: Always update .env from env-example
echo "[+] Updating .env from env-example..."
cp env-example .env
if [ $? -eq 0 ]; then
    echo "[+] .env file created or updated successfully."
else
    echo "[-] Failed to copy env-example to .env"
    exit 1
fi

# Step 3: Check if composer is installed
if command -v composer >/dev/null 2>&1; then
    echo "[+] Composer detected. Installing dependencies..."
    composer install
    if [ $? -eq 0 ]; then
        echo "[+] Dependencies installed successfully."
        exit 0
    else
        echo "[-] Composer failed to install dependencies."
        exit 1
    fi
else
    echo "[+] Composer not found. Downloading installer..."
    curl -sS https://getcomposer.org/installer -o composer-setup.php
    if [ $? -ne 0 ]; then
        echo "[-] Failed to download Composer setup."
        exit 1
    fi

    echo "[+] Installing Composer..."
    sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
    rm composer-setup.php

    if command -v composer >/dev/null 2>&1; then
        echo "[+] Composer installed. Installing dependencies..."
        composer install
        if [ $? -eq 0 ]; then
            echo "[+] Dependencies installed successfully."
            exit 0
        else
            echo "[-] Composer found but failed to install dependencies."
            exit 1
        fi
    else
        echo "[-] Composer install failed or not in PATH."
        echo "[!] Please restart your terminal and re-run this script."
        exit 1
    fi
fi
