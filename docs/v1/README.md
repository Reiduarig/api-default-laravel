# API V1 Documentation

## 📋 Índice

- [Introducción](#introducción)
- [Autenticación](#autenticación)
- [Endpoints](#endpoints)
  - [Autenticación](#endpoints-autenticación)
  - [Usuarios](#endpoints-usuarios)
  - [Tickets](#endpoints-tickets)
- [Ejemplos de Uso](#ejemplos-de-uso)
- [Códigos de Error](#códigos-de-error)

## 🚀 Introducción

La API V1 proporciona funcionalidad básica para la gestión de tickets y usuarios. Es una API RESTful que sigue convenciones estándar.

**URL Base:** `https://api-default-laravel.test/api/v1`

## 🔐 Autenticación

### Login
Obtiene un token de autenticación.

```http
POST /api/v1/auth/login
Content-Type: application/json

{
  "email": "usuario@ejemplo.com",
  "password": "contraseña123"
}
```

**Respuesta Exitosa:**
```json
{
  "status": "success",
  "message": "Usuario autenticado exitosamente.",
  "data": {
    "user": {
      "id": 1,
      "name": "Usuario Ejemplo",
      "email": "usuario@ejemplo.com"
    },
    "token": "1|eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
  }
}
```

### Registro
Crea una nueva cuenta de usuario.

```http
POST /api/v1/auth/register
Content-Type: application/json

{
  "name": "Usuario Nuevo",
  "email": "nuevo@ejemplo.com", 
  "password": "contraseña123",
  "password_confirmation": "contraseña123"
}
```

### Logout
Revoca el token actual.

```http
POST /api/v1/logout
Authorization: Bearer tu-token-aqui
```

### Logout de Todos los Dispositivos
Revoca todos los tokens del usuario.

```http
POST /api/v1/logoutAllDevices
Authorization: Bearer tu-token-aqui
```

## 📝 Endpoints - Usuarios

### Listar Usuarios
```http
GET /api/v1/users
Authorization: Bearer tu-token-aqui
```

**Parámetros de Query:**
- `page`: Número de página (default: 1)
- `per_page`: Elementos por página (default: 15)

### Obtener Usuario
```http
GET /api/v1/users/{id}
Authorization: Bearer tu-token-aqui
```

### Crear Usuario
```http
POST /api/v1/users
Authorization: Bearer tu-token-aqui
Content-Type: application/json

{
  "name": "Usuario Nuevo",
  "email": "nuevo@ejemplo.com",
  "password": "contraseña123"
}
```

### Actualizar Usuario
```http
PUT /api/v1/users/{id}
Authorization: Bearer tu-token-aqui
Content-Type: application/json

{
  "name": "Usuario Actualizado",
  "email": "actualizado@ejemplo.com"
}
```

### Eliminar Usuario
```http
DELETE /api/v1/users/{id}
Authorization: Bearer tu-token-aqui
```

## 🎫 Endpoints - Tickets

### Listar Tickets
```http
GET /api/v1/tickets
Authorization: Bearer tu-token-aqui
```

**Parámetros de Query:**
- `title`: Filtrar por título (búsqueda parcial)
- `status`: Filtrar por estado (A, C, H, X)
- `author`: Filtrar por ID del autor
- `created_at`: Filtrar por fecha de creación
- `updated_at`: Filtrar por fecha de actualización
- `sort`: Ordenar por campo (title, status, created_at, updated_at)
- `page`: Número de página
- `per_page`: Elementos por página

### Obtener Ticket
```http
GET /api/v1/tickets/{id}
Authorization: Bearer tu-token-aqui
```

### Crear Ticket
```http
POST /api/v1/tickets
Authorization: Bearer tu-token-aqui
Content-Type: application/json

{
  "title": "Título del ticket",
  "description": "Descripción detallada del problema",
  "status": "A",
  "user_id": 1
}
```

**Estados Válidos:**
- `A`: Activo
- `C`: Completado
- `H`: En espera
- `X`: Cancelado

### Actualizar Ticket
```http
PUT /api/v1/tickets/{id}
Authorization: Bearer tu-token-aqui
Content-Type: application/json

{
  "title": "Título actualizado",
  "description": "Descripción actualizada",
  "status": "C"
}
```

### Eliminar Ticket
```http
DELETE /api/v1/tickets/{id}
Authorization: Bearer tu-token-aqui
```

## 💡 Ejemplos de Uso

### Ejemplo Completo: Crear y Gestionar un Ticket

1. **Login:**
```bash
curl -X POST https://api-default-laravel.test/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "usuario@ejemplo.com",
    "password": "contraseña123"
  }'
```

2. **Crear Ticket:**
```bash
curl -X POST https://api-default-laravel.test/api/v1/tickets \
  -H "Authorization: Bearer 1|eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..." \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Error en el sistema de login",
    "description": "Los usuarios no pueden iniciar sesión desde móvil",
    "status": "A",
    "user_id": 1
  }'
```

3. **Actualizar Estado:**
```bash
curl -X PUT https://api-default-laravel.test/api/v1/tickets/1 \
  -H "Authorization: Bearer 1|eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..." \
  -H "Content-Type: application/json" \
  -d '{
    "status": "C"
  }'
```

### Filtrado y Búsqueda

```bash
# Buscar tickets por título
curl "https://api-default-laravel.test/api/v1/tickets?title=login" \
  -H "Authorization: Bearer tu-token"

# Filtrar por estado
curl "https://api-default-laravel.test/api/v1/tickets?status=A" \
  -H "Authorization: Bearer tu-token"

# Combinar filtros
curl "https://api-default-laravel.test/api/v1/tickets?status=A&title=error" \
  -H "Authorization: Bearer tu-token"

# Ordenar resultados
curl "https://api-default-laravel.test/api/v1/tickets?sort=created_at" \
  -H "Authorization: Bearer tu-token"
```

## ❌ Códigos de Error

### 400 - Bad Request
```json
{
  "status": "error",
  "message": "La solicitud no es válida"
}
```

### 401 - Unauthorized
```json
{
  "status": "error", 
  "message": "No autenticado"
}
```

### 403 - Forbidden
```json
{
  "status": "error",
  "message": "No autorizado para realizar esta acción"
}
```

### 404 - Not Found
```json
{
  "status": "error",
  "message": "No existe el recurso solicitado"
}
```

### 422 - Validation Error
```json
{
  "status": "error",
  "message": "Los datos proporcionados no son válidos",
  "errors": {
    "title": ["El campo título es obligatorio"],
    "email": ["El campo email debe ser una dirección válida"]
  }
}
```

### 500 - Server Error
```json
{
  "status": "error",
  "message": "Error interno del servidor"
}
```

## 📚 Recursos Adicionales

- [📖 Documentación Principal](../README.md)
- [🔄 Migrar a V2](../MIGRATION.md)
- [⚡ Guía de Inicio Rápido](../QUICKSTART.md)

---

> **Nota:** Para funcionalidades avanzadas como estadísticas, filtros complejos y optimizaciones de rendimiento, considera migrar a [API V2](../v2/README.md).