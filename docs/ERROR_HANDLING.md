# Sistema de Manejo de Errores y Monitoreo - API V2

## 📋 Índice

- [Introducción](#introducción)
- [Arquitectura del Sistema](#arquitectura-del-sistema)
- [Middlewares Implementados](#middlewares-implementados)
- [Manejo Central de Excepciones](#manejo-central-de-excepciones)
- [Sistema de Monitoreo](#sistema-de-monitoreo)
- [Comando de Health Check](#comando-de-health-check)
- [Tipos de Errores Manejados](#tipos-de-errores-manejados)
- [Logging y Alertas](#logging-y-alertas)
- [Configuración y Uso](#configuración-y-uso)

## 🚀 Introducción

El sistema de manejo de errores implementado para la API V2 proporciona una gestión robusta, comprensiva y profesional de errores, con capacidades avanzadas de monitoreo, logging y alertas automáticas.

### Objetivos principales:
- ✅ **Prevenir errores 500 no controlados**
- ✅ **Logging detallado y contextual**
- ✅ **Monitoreo proactivo de la salud de la API**
- ✅ **Respuestas de error consistentes y útiles**
- ✅ **Alertas automáticas para problemas críticos**

## 🏗️ Arquitectura del Sistema

### Flujo de Manejo de Errores

```
Request → Middlewares → Controller → Response
    ↓           ↓           ↓           ↓
Validator → Monitor → Exception → Error Handler
    ↓           ↓           ↓           ↓
   Log    →   Alert  →   Format →    JSON Response
```

### Componentes principales:

1. **Middlewares de Protección** - Validación y monitoreo en tiempo real
2. **Exception Handler Central** - Manejo unificado en `bootstrap/app.php`
3. **Sistema de Logging** - Registro detallado con contexto
4. **Health Check Command** - Diagnóstico completo del sistema
5. **Alertas Automáticas** - Notificaciones proactivas

## 🛡️ Middlewares Implementados

### 1. ApiResourceValidator

**Ubicación:** `app/Http/Middleware/ApiResourceValidator.php`

**Función:** Valida la estructura y formato de las requests antes de llegar al controller.

**Validaciones:**
- ✅ Content-Type para POST/PUT/PATCH
- ✅ Accept headers requeridos
- ✅ Parámetros de paginación (per_page: 1-100)
- ✅ Formato de parámetros de ordenamiento

**Ejemplo de respuesta de error:**
```json
{
  "status": "error",
  "message": "Content-Type debe ser application/json para este tipo de request.",
  "data": {
    "error_code": "INVALID_REQUEST_FORMAT",
    "api_version": "2.0",
    "help": {
      "content_type": "Usa Content-Type: application/json para POST/PUT/PATCH",
      "accept": "Incluye Accept: application/json en los headers"
    }
  }
}
```

### 2. ApiErrorMonitoring

**Ubicación:** `app/Http/Middleware/ApiErrorMonitoring.php`

**Función:** Monitoreo en tiempo real de errores y rendimiento.

**Características:**
- ✅ **Monitoreo de tiempo de respuesta** (alerta si >2 segundos)
- ✅ **Detección de patrones de error** (alerta si >10 errores/5min desde misma IP)
- ✅ **Alertas de errores críticos** (una vez por hora por tipo de error)
- ✅ **Sanitización de datos sensibles** en logs

**Métricas monitoreadas:**
- Tiempo de respuesta por endpoint
- Frecuencia de errores por IP y código de estado
- Errores críticos únicos con deduplicación
- Datos de request (sanitizados)

## 🎛️ Manejo Central de Excepciones

**Ubicación:** `bootstrap/app.php` - Sección `withExceptions`

### Tipos de excepciones manejadas:

#### 1. ThrottleRequestsException (429)
```php
// Rate limiting excedido
{
  "status": "error", 
  "message": "Demasiadas requests. Intenta de nuevo en X segundos.",
  "data": {
    "retry_after": 60,
    "max_attempts": 15
  }
}
```

#### 2. ModelNotFoundException (404)
```php
// Modelo no encontrado
{
  "status": "error",
  "message": "El recurso Ticket solicitado no fue encontrado.",
  "data": {
    "error_code": "RESOURCE_NOT_FOUND",
    "resource_type": "ticket",
    "api_version": "2.0"
  }
}
```

#### 3. ValidationException (422)
```php
// Errores de validación
{
  "status": "error",
  "message": "Los datos proporcionados no son válidos.",
  "errors": {
    "title": ["El campo título es obligatorio."]
  },
  "data": {
    "error_code": "VALIDATION_FAILED",
    "api_version": "2.0"
  }
}
```

#### 4. AuthorizationException (403)
```php
// Sin permisos
{
  "status": "error",
  "message": "No tienes permisos para realizar esta acción.",
  "data": {
    "error_code": "FORBIDDEN",
    "api_version": "2.0"
  }
}
```

#### 5. Errores Genéricos 500
```php
// Modo desarrollo
{
  "status": "error",
  "message": "Error interno del servidor.",
  "data": {
    "error_code": "INTERNAL_SERVER_ERROR",
    "api_version": "2.0",
    "debug_info": {
      "exception": "TypeError",
      "message": "Undefined method...",
      "file": "/path/to/file.php",
      "line": 123
    }
  }
}

// Modo producción
{
  "status": "error",
  "message": "Ha ocurrido un error interno. Por favor, inténtalo de nuevo más tarde.",
  "data": {
    "error_code": "INTERNAL_SERVER_ERROR",
    "api_version": "2.0",
    "error_id": "err_67289abc123",
    "timestamp": "2025-10-30T15:30:00.000000Z",
    "support_contact": "soporte@tudominio.com"
  }
}
```

## 📊 Sistema de Monitoreo

### Logging Contextual

Cada error registra:
- **URL y método** de la request
- **Usuario autenticado** (ID o 'anonymous')
- **IP y User-Agent** del cliente
- **Datos de request** (sanitizados)
- **Stack trace completo**
- **Timestamp preciso**

### Categorías de log:
- **INFO** - Eventos normales (rutas no encontradas, etc.)
- **WARNING** - Problemas menores (acceso denegado, rate limiting)
- **ERROR** - Errores del servidor
- **CRITICAL** - Errores que requieren atención inmediata

### Deduplicación inteligente:
- Errores críticos: 1 alerta por hora por tipo
- Patrones de error: Reset automático cada 5 minutos
- Rate limiting por IP para evitar spam

## 🏥 Comando de Health Check

**Comando:** `php artisan api:health-check`

### Verificaciones realizadas:

#### 1. Base de Datos
- ✅ Conectividad
- ✅ Tiempo de respuesta
- ✅ Conteo de registros principales

#### 2. Sistema de Cache
- ✅ Operaciones de lectura/escritura
- ✅ Funcionamiento correcto

#### 3. Autenticación
- ✅ Tokens activos en el sistema
- ✅ Estado de Sanctum

#### 4. Endpoints Críticos
- ✅ Disponibilidad de rutas principales
- ✅ Tiempo de respuesta de cada endpoint

#### 5. Análisis de Logs
- ✅ Errores en la última hora
- ✅ Warnings y críticos
- ✅ Patrones de problemas

#### 6. Rendimiento
- ✅ Consultas complejas
- ✅ Uso de memoria
- ✅ Tiempo de respuesta

### Ejemplo de salida:

```bash
🏥 Iniciando verificación de salud de la API...
📊 Resultados de la verificación:

✅ Database: healthy (Score: 100%)
   Users: 12
   Tickets: 100
   Response time ms: 25.39

✅ Cache: healthy (Score: 100%)
   Cache test: 1

✅ Authentication: healthy (Score: 100%)
   Total tokens: 5
   Active tokens: 5

⚠️ Api endpoints: degraded (Score: 75%)
   /api/v1: healthy (150ms)
   /api/v2: healthy (80ms)
   
✅ Performance: healthy (Score: 96%)
   Complex query time ms: 1.27
   Memory usage mb: 28

✅ Estado de salud excelente: 94%
```

### Reporte detallado:

```bash
php artisan api:health-check --report
```

Genera un archivo JSON completo en `storage/logs/api_health_report_FECHA.json` con:
- Métricas detalladas
- Recomendaciones automáticas
- Histórico de problemas
- Sugerencias de optimización

## 🚨 Tipos de Errores Manejados

### Errores de Cliente (4xx)

| Código | Tipo | Descripción | Ejemplo |
|--------|------|-------------|---------|
| 400 | Bad Request | Request malformado | Content-Type incorrecto |
| 401 | Unauthorized | Token faltante/inválido | Bearer token requerido |
| 403 | Forbidden | Sin permisos | Acceso denegado por policy |
| 404 | Not Found | Recurso inexistente | Ticket no encontrado |
| 405 | Method Not Allowed | Método incorrecto | POST en ruta GET |
| 422 | Validation Error | Datos inválidos | Campo requerido faltante |
| 429 | Too Many Requests | Rate limit | Límite de requests excedido |

### Errores de Servidor (5xx)

| Código | Tipo | Descripción | Manejo |
|--------|------|-------------|--------|
| 500 | Internal Server Error | Error no manejado | Log + alerta crítica |
| 502 | Bad Gateway | Error de proxy | Monitoreo de infraestructura |
| 503 | Service Unavailable | Servicio no disponible | Health check automático |
| 504 | Gateway Timeout | Timeout de request | Análisis de rendimiento |

## 📝 Logging y Alertas

### Estructura de logs:

```json
{
  "level": "ERROR",
  "message": "API Internal Server Error",
  "context": {
    "exception": "TypeError",
    "message": "Call to undefined method...",
    "file": "/app/Http/Controllers/V2/TicketController.php",
    "line": 45,
    "url": "https://api.example.com/api/v2/tickets",
    "method": "GET",
    "user_id": 123,
    "ip": "192.168.1.1",
    "user_agent": "PostmanRuntime/7.28.4",
    "trace": "...",
    "api_version": "2.0",
    "timestamp": "2025-10-30T15:30:00.000000Z"
  }
}
```

### Sistema de alertas:

#### Alertas críticas (CRITICAL):
- Errores de base de datos
- Fallos de autenticación masivos
- Excepciones no manejadas
- Problemas de memoria

#### Alertas de advertencia (WARNING):
- Respuestas lentas (>2 segundos)
- Patrones de error frecuentes
- Rate limiting activado
- Problemas de autorización

#### Alertas informativas (INFO):
- Nuevos registros de usuario
- Patrones de uso inusuales
- Cambios en configuración

## ⚙️ Configuración y Uso

### 1. Activación automática

El sistema se activa automáticamente al hacer requests a rutas `/api/*`:

```php
// En bootstrap/app.php
$middleware->group('api', [
    \App\Http\Middleware\ApiErrorMonitoring::class,
    \App\Http\Middleware\ApiResourceValidator::class,
]);
```

### 2. Variables de entorno

```env
# Control de debug
APP_DEBUG=false  # true para modo desarrollo

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=info

# Rate limiting
SANCTUM_RATE_LIMIT=15  # requests por minuto para V2
```

### 3. Configuración de alertas

En `app/Http/Middleware/ApiErrorMonitoring.php`:

```php
// Configurar límites
private const SLOW_RESPONSE_THRESHOLD = 2000; // ms
private const ERROR_PATTERN_THRESHOLD = 10;   // errores
private const ALERT_COOLDOWN = 3600;          // segundos
```

### 4. Personalización de respuestas

Modificar en `bootstrap/app.php` la sección `withExceptions`:

```php
$exceptions->render(function (CustomException $exception, $request) {
    return ApiResponseService::error(
        'Mensaje personalizado',
        500,
        ['custom_data' => 'valor']
    );
});
```

## 🔧 Troubleshooting

### Problemas comunes:

#### 1. Health check falla en endpoints
```bash
# Verificar que las rutas existen
php artisan route:list --name=api.v2

# Verificar conectividad
curl http://your-domain.test/api/v2/health
```

#### 2. Logs no se generan
```bash
# Verificar permisos
chmod -R 755 storage/logs

# Verificar configuración
php artisan config:clear
```

#### 3. Alertas duplicadas
```bash
# Limpiar cache de alertas
php artisan cache:clear
```

### Comandos útiles:

```bash
# Health check completo
php artisan api:health-check --report

# Verificar logs recientes
tail -f storage/logs/laravel.log

# Limpiar logs antiguos
php artisan log:clear

# Verificar estado del cache
php artisan cache:table
```

## 📈 Métricas y KPIs

### Métricas de salud:
- **Uptime de endpoints**: >99.5%
- **Tiempo de respuesta promedio**: <500ms
- **Tasa de errores 5xx**: <1%
- **Cobertura de manejo de errores**: 100%

### Alertas objetivo:
- **Errores críticos**: 0 por día
- **Respuestas lentas**: <5% del total
- **Rate limiting**: <2% de requests

---

## 🎯 Resumen

El sistema implementado proporciona:

✅ **Manejo robusto** de todos los tipos de errores  
✅ **Logging contextual** y detallado  
✅ **Monitoreo proactivo** en tiempo real  
✅ **Alertas inteligentes** con deduplicación  
✅ **Health checks** automatizados  
✅ **Respuestas consistentes** en formato JSON  
✅ **Separación clara** entre modo desarrollo y producción  
✅ **Documentación completa** y ejemplos prácticos  

El sistema está preparado para **producción** y proporciona las herramientas necesarias para mantener una API robusta, monitoreada y confiable.