# QubeStat Backend API

A production-ready PHP backend application following LAMP architecture with JWT authentication, designed to work on both Windows and Linux.

## Cross-Platform Compatibility

This API has been designed to work seamlessly on:
- Windows with XAMPP
- Linux with standard LAMP stack

We've removed dependencies on platform-specific extensions (like `ext-sodium`) to ensure smooth installation across both environments.

## Features

- OOP-based architecture with PSR-4 autoloading
- JWT authentication for securing API endpoints
- RESTful API design with JSON and XML response formats
- Image upload functionality with validation
- Admin and User authentication flows
- Swagger UI for API documentation
- Cross-platform compatibility (Windows/Linux)

## Directory Structure

The application follows a structured approach:

```
backend/
├── public/             # Public accessible files
├── app/                # Application code
│   ├── api/            # API endpoints
│   ├── config/         # Configuration files
│   ├── controllers/    # Controllers
│   ├── models/         # Database models
│   ├── middleware/     # Request middleware
│   ├── helpers/        # Helper utilities
│   ├── services/       # Business logic
│   ├── routes/         # Route definitions
│   └── logs/           # Application logs
└── vendor/             # Composer dependencies
```

## Setup Instructions

### Windows
```
cd C:\xampp\htdocs\qubestat\backend
.\setup.bat
```

### Linux
```
cd /var/www/html/qubestat/backend
chmod +x setup.sh
./setup.sh
```

For detailed setup instructions, see `README-SETUP.md`.

## API Documentation

API documentation is available at `/api/docs/` endpoint using Swagger UI.

## Response Formats

The API supports both JSON and XML response formats:

- Default: JSON
- XML: Append `?xml=true` to any endpoint

For detailed information about the XML/JSON feature, see `README-XML.md`.

## Authentication

- JWT tokens are used for API authentication
- Tokens must be passed in the Authorization header
- Example: `Authorization: Bearer [token]`

## Development

- PHP 7.4 or higher required
- LAMP stack environment 
- Follow PSR-12 coding standards 