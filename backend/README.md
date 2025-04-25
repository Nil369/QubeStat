# QubeStat Backend API

A production-ready PHP backend application built using the LAMP stack, offering secure RESTful endpoints with JSON and XML support, and platform-agnostic setup flows.

---

## ✅ Cross-Platform Compatibility

This backend runs on:

- **Windows/Linux/MacOS** (using [XAMPP](https://www.apachefriends.org/))


All platform-specific dependencies (like `ext-sodium`) have been removed for smooth installation.

---

## ⚙️ Features

- Modular autoloaded structure
- PHP session based authentication
- XML and JSON response formats
- Email verification support
- File uploads with validation
- Role-based (admin/user) login
- Swagger UI for API docs
- Cross-platform compatibility

---

## 📁 Folder Structure

```
backend/
├── api/                    # All API endpoint wrappers
│   └── users/              # User endpoints 
│   └── admin/              # Admin endpoints
│   └── auth/               # Auth endpoints (register, login, logout, etc.)
│   └── docs/               # Interactive API docs
│   └── products/           # Products endpoints
│   └── payment-gateway/    # User endpoints (register, login, logout, etc.)
├── config/                 # Configuration files (.env, db_connect, etc.)
├── helpers/                # Utility functions (XML encoder, mailer, etc.)
├── middlewares/            # Authentication middleware
├── models/                 # Data models (User, etc.)
├── public/                 # Public accessible files (index.php, etc.)
├── vendor/                 # Composer packages
├── setup.bat               # Windows setup script
├── setup_unix.sh           # Linux/macOS setup script
└── env-example             # Sample environment configuration
```

---

## 🚀 Getting Started

### 🔒 Environment Setup

Create or update your `.env` file:

```bash
cp env-example .env
```

Or let the setup script do it for you.

---

### 🪟 Windows Setup

```bash
cd C:\xampp\htdocs\qubestat\backend
setup.bat
```

> ⚠️ **Restart your terminal or VS Code after Composer installation** (if done during setup).

---

### 🐧 Linux/macOS Setup

```bash
cd /opt/lampp/htdocs/QubeStat/backend
chmod +x setup_unix.sh
./setup_unix.sh
```

> ⚠️ If `composer` is newly installed, restart your terminal before re-running the script.

---

## 📘 API Documentation

Swagger-based API documentation is available at:

```
http://localhost/QubeStat/backend/api/docs/
```

---

## 🧾 Response Format Options

- **JSON (default)**: No action needed
- **XML**
    -   Add `?xml=true` to your endpoint
    -   Add `?search=adm&xml=true` to your endpoint to get search results in xml

Example:

```http
GET /api/users/users.php?id=1&xml=true
```


---

## 🧑‍💻 Development Notes

- PHP 7.4+ required
- Apache/MySQL installed
- Use Composer for dependency management

---