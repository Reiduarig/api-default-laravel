# API V2 Documentation

## 📋 Índice

- [Introducción](#introducción)
- [Nuevas Características](#nuevas-características)
- [Arquitectura](#arquitectura)
- [Endpoints](#endpoints)
  - [Autenticación](#endpoints-autenticación)
  - [Usuarios V2](#endpoints-usuarios-v2)
  - [Tickets V2](#endpoints-tickets-v2)
  - [Estadísticas](#endpoints-estadísticas)
- [Funcionalidades Avanzadas](#funcionalidades-avanzadas)
- [Ejemplos de Uso](#ejemplos-de-uso)
- [Migración desde V1](#migración-desde-v1)

## 🚀 Introducción

La API V2 representa una evolución significativa con arquitectura mejorada, funcionalidades avanzadas y optimizaciones de rendimiento. Diseñada con patrones modernos para aplicaciones empresariales.

**URL Base:** `https://api-default-laravel.test/api/v2`

## ✨ Nuevas Características

### 🏗️ Arquitectura Mejorada
- **Repository Pattern** para separación de datos
- **Action Classes** para lógica de negocio encapsulada
- **Advanced Resources** con carga condicional
- **Enhanced Error Handling** con logging de auditoría

### 📊 Funcionalidades Avanzadas
- **Estadísticas y Analytics** detalladas
- **Field Selection** para optimización de payload
- **Enhanced Filtering** con múltiples criterios
- **Advanced Search** en múltiples campos
- **Conditional Loading** de relaciones
- **Performance Optimizations** con eager loading

### 🔧 Campos Nuevos en Tickets
- `priority`: Prioridad del ticket (low, medium, high)
- `internal_notes`: Notas internas para staff
- `view_count`: Contador de visualizaciones
- `author_id`: ID del autor (separado de user_id para V2)

## 🏛️ Arquitectura

### Repository Pattern
```php
// Separación de lógica de acceso a datos
TicketRepository::getFilteredPaginated($filters, $includes, $perPage)
```

### Action Classes
```php
// Encapsulación de lógica de negocio
CreateTicketAction::execute($request)
UpdateTicketAction::execute($request, $ticket)
```

### Advanced Resources
```php
// Recursos con capacidades avanzadas
TicketResource::conditionalLoading($request)
TicketResource::fieldSelection($request)
```

## 🔐 Endpoints - Autenticación

### Login (Reutiliza V1)
```http
POST /api/v2/login
Content-Type: application/json

{
  "email": "usuario@ejemplo.com",
  "password": "contraseña123"
}
```

### Logout
```http
POST /api/v2/logout
Authorization: Bearer tu-token-aqui
```

### Logout de Todos los Dispositivos
```http
POST /api/v2/logout-all-devices
Authorization: Bearer tu-token-aqui
```

## 👥 Endpoints - Usuarios V2

### Listar Usuarios
```http
GET /api/v2/users
Authorization: Bearer tu-token-aqui
```

**Parámetros Nuevos:**
- `include`: Relaciones a incluir (tickets, profile)
- `fields[users]`: Campos específicos a retornar
- `sort`: Ordenamiento avanzado
- `search`: Búsqueda en múltiples campos

### Obtener Tickets de Usuario
```http
GET /api/v2/users/{id}/tickets
Authorization: Bearer tu-token-aqui
```

### Estadísticas de Usuarios
```http
GET /api/v2/users-statistics
Authorization: Bearer tu-token-aqui
```

## 🎫 Endpoints - Tickets V2

### Listar Tickets con Funcionalidades Avanzadas
```http
GET /api/v2/tickets
Authorization: Bearer tu-token-aqui
```

**Parámetros Avanzados:**
- `include`: author, comments, user
- `fields[tickets]`: title,status,priority (field selection)
- `priority`: low,medium,high
- `status`: A,C,H,X
- `search`: Búsqueda en title y description
- `sort`: Ordenamiento múltiple
- `per_page`: Elementos por página

**Ejemplo con Field Selection:**
```http
GET /api/v2/tickets?fields[tickets]=title,status,priority&include=author
```

### Obtener Ticket con Contador de Vistas
```http
GET /api/v2/tickets/{id}
Authorization: Bearer tu-token-aqui
```

**Respuesta V2:**
```json
{
  "status": "success",
  "message": "Ticket obtenido correctamente.",
  "data": {
    "id": "1",
    "type": "ticket",
    "attributes": {
      "title": "Título del ticket",
      "description": "Descripción detallada",
      "status": "A",
      "priority": "medium",
      "view_count": 5,
      "created_at": "2025-10-29T18:00:00.000000Z",
      "updated_at": "2025-10-29T18:00:00.000000Z",
      "days_open": 2.5,
      "is_overdue": false,
      "internal_notes": "Notas para el staff"
    },
    "relationships": {
      "author": {
        "data": {
          "id": "1",
          "type": "users"
        },
        "links": {
          "self": "/api/v2/tickets/1/relationships/author",
          "related": "/api/v2/tickets/1/author"
        }
      }
    },
    "meta": {
      "version": "2.0",
      "cached_at": "2025-10-29T18:00:00.000000Z",
      "links": {
        "self": "/api/v2/tickets/1",
        "edit": "/api/v2/tickets/1",
        "delete": "/api/v2/tickets/1"
      }
    }
  },
  "meta": {
    "api_version": "2.0",
    "timestamp": "2025-10-29T18:00:00.000000Z",
    "view_count": 5,
    "includes": []
  }
}
```

### Crear Ticket con Action Classes
```http
POST /api/v2/tickets
Authorization: Bearer tu-token-aqui
Content-Type: application/json

{
  "data": {
    "type": "tickets",
    "attributes": {
      "title": "Nuevo ticket V2",
      "description": "Descripción del problema",
      "status": "A",
      "priority": "medium",
      "internal_notes": "Notas internas del staff"
    },
    "relationships": {
      "author": {
        "data": {
          "type": "users",
          "id": "1"
        }
      }
    }
  }
}
```

**Características del Action Class:**
- ✅ Cálculo automático de prioridad si no se especifica
- ✅ Asignación automática de author_id
- ✅ Logging de auditoría
- ✅ Transacciones de base de datos
- ✅ Validaciones mejoradas

### Actualizar Ticket con Auditoría
```http
PUT /api/v2/tickets/{id}
Authorization: Bearer tu-token-aqui
Content-Type: application/json

{
  "data": {
    "type": "tickets",
    "id": "1",
    "attributes": {
      "title": "Título actualizado",
      "status": "C",
      "priority": "low",
      "internal_notes": "Actualizado por el equipo"
    }
  }
}
```

**Características del Action Class:**
- ✅ Logging automático de cambios
- ✅ Lógica de negocio (fechas de completado)
- ✅ Auditoría de campos modificados
- ✅ Recálculo condicional de prioridad

## 📊 Endpoints - Estadísticas

### Estadísticas Completas de Tickets
```http
GET /api/v2/tickets-statistics
Authorization: Bearer tu-token-aqui
```

**Respuesta:**
```json
{
  "status": "success",
  "message": "Estadísticas de tickets obtenidas correctamente.",
  "data": {
    "total_tickets": 150,
    "status_distribution": {
      "active": 45,
      "closed": 85,
      "pending": 15,
      "cancelled": 5
    },
    "priority_distribution": {
      "high": 25,
      "medium": 80,
      "low": 45
    },
    "average_view_count": 12.5,
    "most_viewed_ticket": {
      "id": 42,
      "title": "Ticket más visto",
      "view_count": 150
    },
    "recent_activity": {
      "tickets_created_last_week": 12,
      "tickets_updated_last_day": 5,
      "most_active_author": {
        "id": 1,
        "name": "Usuario Activo",
        "count": 25
      }
    }
  },
  "meta": {
    "api_version": "2.0",
    "timestamp": "2025-10-29T18:00:00.000000Z",
    "generated_at": "2025-10-29T18:00:00.000000Z"
  }
}
```

### Información de Versión
```http
GET /api/v2/version
Authorization: Bearer tu-token-aqui
```

### Health Check
```http
GET /api/v2/health
Authorization: Bearer tu-token-aqui
```

## 🔥 Funcionalidades Avanzadas

### Field Selection (Optimización de Payload)
```bash
# Solo campos específicos
curl "https://api-default-laravel.test/api/v2/tickets?fields[tickets]=title,status,priority" \
  -H "Authorization: Bearer tu-token"

# Combinado con includes
curl "https://api-default-laravel.test/api/v2/tickets?fields[tickets]=title,status&include=author" \
  -H "Authorization: Bearer tu-token"
```

### Enhanced Filtering
```bash
# Filtros múltiples
curl "https://api-default-laravel.test/api/v2/tickets?priority=high,medium&status=A,H" \
  -H "Authorization: Bearer tu-token"

# Búsqueda avanzada
curl "https://api-default-laravel.test/api/v2/tickets?search=login%20error&priority=high" \
  -H "Authorization: Bearer tu-token"

# Rangos de fechas
curl "https://api-default-laravel.test/api/v2/tickets?created_at=2025-10-01,2025-10-31" \
  -H "Authorization: Bearer tu-token"
```

### Conditional Loading
```bash
# Incluir relaciones específicas
curl "https://api-default-laravel.test/api/v2/tickets?include=author,comments" \
  -H "Authorization: Bearer tu-token"

# Solo author
curl "https://api-default-laravel.test/api/v2/tickets/1?include=author" \
  -H "Authorization: Bearer tu-token"
```

### Paginación Avanzada
```bash
# Paginación personalizada
curl "https://api-default-laravel.test/api/v2/tickets?per_page=10&page=3" \
  -H "Authorization: Bearer tu-token"
```

**Respuesta con Metadata de Paginación:**
```json
{
  "data": [...],
  "meta": {
    "total_tickets": 150,
    "pagination": {
      "current_page": 3,
      "per_page": 10,
      "total": 150,
      "total_pages": 15
    }
  }
}
```

## 💡 Ejemplos de Uso

### Workflow Completo V2

1. **Login y Crear Ticket con Prioridad:**
```bash
# Login
TOKEN=$(curl -X POST https://api-default-laravel.test/api/v2/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password"}' \
  | jq -r '.data.token')

# Crear ticket crítico
curl -X POST https://api-default-laravel.test/api/v2/tickets \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "data": {
      "type": "tickets",
      "attributes": {
        "title": "Sistema de pagos caído - URGENTE",
        "description": "Los usuarios no pueden procesar pagos",
        "status": "A",
        "priority": "high",
        "internal_notes": "Prioridad máxima - afecta ingresos"
      },
      "relationships": {
        "author": {
          "data": {"type": "users", "id": "1"}
        }
      }
    }
  }'
```

2. **Monitorear con Estadísticas:**
```bash
# Ver estadísticas generales
curl "https://api-default-laravel.test/api/v2/tickets-statistics" \
  -H "Authorization: Bearer $TOKEN"

# Filtrar tickets críticos
curl "https://api-default-laravel.test/api/v2/tickets?priority=high&status=A" \
  -H "Authorization: Bearer $TOKEN"
```

3. **Actualizar con Auditoría:**
```bash
# Marcar como resuelto
curl -X PUT https://api-default-laravel.test/api/v2/tickets/1 \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "data": {
      "type": "tickets",
      "id": "1", 
      "attributes": {
        "status": "C",
        "internal_notes": "Resuelto - servidor de pagos reiniciado"
      }
    }
  }'
```

### Optimización de Performance
```bash
# Solo campos necesarios para dashboard
curl "https://api-default-laravel.test/api/v2/tickets?fields[tickets]=title,status,priority,created_at&per_page=50" \
  -H "Authorization: Bearer $TOKEN"

# Con relaciones optimizadas
curl "https://api-default-laravel.test/api/v2/tickets?include=author&fields[tickets]=title,status&fields[users]=name" \
  -H "Authorization: Bearer $TOKEN"
```

## 🔄 Migración desde V1

### Cambios en Estructura de Respuesta

**V1:**
```json
{
  "data": {
    "id": 1,
    "title": "Ticket",
    "status": "A"
  }
}
```

**V2:**
```json
{
  "status": "success",
  "data": {
    "id": "1",
    "type": "ticket",
    "attributes": {
      "title": "Ticket",
      "status": "A",
      "priority": "medium",
      "view_count": 0
    },
    "relationships": {...},
    "meta": {...}
  },
  "meta": {
    "api_version": "2.0"
  }
}
```

### Nuevos Campos Requeridos
- `priority`: Ahora se incluye automáticamente
- `author_id`: Se establece automáticamente
- `view_count`: Inicializado en 0

### URLs Actualizadas
- `GET /api/v2/tickets-statistics` (nueva)
- `GET /api/v2/users/{id}/tickets` (nueva)
- `GET /api/v2/users-statistics` (nueva)

## 📚 Recursos Adicionales

- [📖 Documentación Principal](../README.md)
- [🔄 Guía de Migración Completa](../MIGRATION.md)
- [⚡ Comparación V1 vs V2](../COMPARISON.md)
- [🚀 Guía de Inicio Rápido](../QUICKSTART.md)

---

> **Recomendación:** API V2 está optimizada para aplicaciones modernas con requisitos de performance y funcionalidades avanzadas. Se recomienda para todos los nuevos desarrollos.