# Yii2 RESTful API for Company Management

## Installation Requirements

- Git
- Docker
- Docker Compose
- Make

## Quick Installation

Clone the repository and run setup:

```bash
git clone <your-repository-url>
cd <your-repository-name>
make setup
```

The `make setup` command will automatically:
1. Create .env file from .env.example
2. Start Docker containers
3. Install Composer dependencies
4. Migrate database with test data

## Available Make Commands

- `make setup` - Complete project setup
- `make docker-up` - Start Docker containers
- `make docker-down` - Stop Docker containers
- `make docker-restart` - Restart Docker containers
- `make migrate` - Apply migrations
- `make migrate-fresh` - Reset and reapply all migrations
- `make clear-cache` - Clear application cache
- `make help` - Show all available commands

## Testing the API

After installation, the project will be available at: http://localhost:8080

### Main Endpoints:

#### User Registration
```
POST http://localhost:8080/api/user/register

{
  "first_name": "John",
  "last_name": "Doe",
  "email": "john@example.com",
  "password": "password123",
  "phone": "+1234567890"
}
```

#### Authentication
```
POST http://localhost:8080/api/user/sign-in

{
  "email": "john@example.com",
  "password": "password123"
}
```

The response contains a JWT token for authorization:
```
Authorization: Bearer {received_token}
```

#### Get Companies List
```
GET http://localhost:8080/api/company
```
*Requires authorization*

#### Get Single Company
```
GET http://localhost:8080/api/company/{id}
```
*Requires authorization*

## Test Data

After installation, the database will contain:
- 5 test users with different data
- 8 test companies
- Random associations between users and companies

## API Documentation

Swagger UI is available at:
```
http://localhost:8080/swagger
```

## Troubleshooting

### Docker Issues
```bash
make docker-down
make docker-build
```

### Database Errors
```bash
make migrate-fresh
```

### Application Logs
```bash
make docker-logs
