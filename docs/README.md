# API Documentation - Laravel Tickets System

## 📋 Índice

- [Introducción](#introducción)
- [Versiones de la API](#versiones-de-la-api)
- [Autenticación](#autenticación)
- [Manejo de Errores](#manejo-de-errores)
- [Formatos de Respuesta](#formatos-de-respuesta)
- [Códigos de Estado](#códigos-de-estado)
- [Enlaces Rápidos](#enlaces-rápidos)

## 🚀 Introducción

Esta documentación describe las APIs V1 y V2 del sistema de tickets Laravel. El sistema permite gestionar tickets de soporte con diferentes niveles de funcionalidad según la versión utilizada.

## 📚 Versiones de la API

### API V1 - Funcionalidad Básica
- **URL Base:** `https://api-default-laravel.test/api/v1`
- **Estado:** Estable y mantenida
- **Características:** CRUD básico de tickets y usuarios
- **Recomendada para:** Aplicaciones simples, compatibilidad legacy

### API V2 - Funcionalidad Avanzada
- **URL Base:** `https://api-default-laravel.test/api/v2`
- **Estado:** Desarrollo activo
- **Características:** Repository Pattern, Action Classes, Estadísticas avanzadas
- **Recomendada para:** Aplicaciones nuevas que requieren funcionalidades avanzadas

## 🔐 Autenticación

Ambas versiones utilizan **Laravel Sanctum** para autenticación mediante tokens Bearer.

### Obtener Token
```http
POST /api/v1/login
POST /api/v2/login
Content-Type: application/json

{
  "email": "usuario@ejemplo.com",
  "password": "contraseña"
}
```

### Usar Token
```http
Authorization: Bearer tu-token-aqui
```

## 🛡️ Manejo de Errores

El sistema incluye un manejo robusto de errores con:

- ✅ **Manejo centralizado** de excepciones
- ✅ **Logging detallado** con contexto completo
- ✅ **Monitoreo en tiempo real** de errores y rendimiento
- ✅ **Alertas automáticas** para problemas críticos
- ✅ **Health checks** automatizados
- ✅ **Respuestas consistentes** en formato JSON

### Health Check
```bash
# Verificar estado de salud de la API
php artisan api:health-check

# Generar reporte detallado
php artisan api:health-check --report
```

**📖 Documentación completa:** [Sistema de Manejo de Errores](ERROR_HANDLING.md)

## 📄 Formatos de Respuesta

### Estructura Estándar V1
```json
{
  "data": [...],
  "message": "Operación exitosa",
  "status": "success"
}
```

### Estructura Estándar V2
```json
{
  "status": "success",
  "message": "Operación exitosa",
  "data": {
    "id": "1",
    "type": "ticket",
    "attributes": {...},
    "relationships": {...},
    "meta": {...}
  },
  "meta": {
    "api_version": "2.0",
    "timestamp": "2025-10-29T18:00:00.000Z"
  }
}
```

## 🎯 Códigos de Estado

| Código | Descripción |
|--------|-------------|
| 200 | OK - Operación exitosa |
| 201 | Created - Recurso creado exitosamente |
| 400 | Bad Request - Error en la solicitud |
| 401 | Unauthorized - Token inválido o faltante |
| 403 | Forbidden - Sin permisos para la operación |
| 404 | Not Found - Recurso no encontrado |
| 422 | Unprocessable Entity - Error de validación |
| 500 | Internal Server Error - Error del servidor |

## 🔗 Enlaces Rápidos

- [📖 Documentación API V1](./v1/README.md)
- [📖 Documentación API V2](./v2/README.md)
- [�️ Sistema de Manejo de Errores](./ERROR_HANDLING.md)
- [📋 Colecciones Postman & VS Code](./COLLECTIONS.md)
- [�🔄 Guía de Migración V1 → V2](./MIGRATION.md)
- [📋 Comparación de Funcionalidades](./COMPARISON.md)
- [🚀 Guía de Inicio Rápido](./QUICKSTART.md)

## 🆕 Novedades

### Sistema de Manejo de Errores (Octubre 2025)
- 🛡️ Manejo centralizado de excepciones con logging detallado
- 📊 Middlewares de monitoreo y validación en tiempo real
- 🚨 Alertas automáticas para errores críticos y patrones problemáticos
- 🏥 Comando `api:health-check` para diagnóstico completo del sistema
- 📈 Métricas de rendimiento y análisis de logs inteligente

### API V2 (Octubre 2025)
- ✨ Repository Pattern para mejor arquitectura
- ✨ Action Classes para lógica de negocio encapsulada
- ✨ Estadísticas avanzadas y análisis
- ✨ Filtros mejorados y búsqueda semántica
- ✨ Optimizaciones de rendimiento
- ✨ Field selection para reducir payload
- ✨ Paginación avanzada
- ✨ Auditoría y logging mejorados

### API V1 (Estable)
- ✅ CRUD completo de tickets
- ✅ Gestión de usuarios
- ✅ Autenticación con Sanctum
- ✅ Filtros básicos
- ✅ Validaciones estándar


> **Nota:** Se recomienda usar API V2 para nuevos proyectos. API V1 se mantiene para compatibilidad backward.