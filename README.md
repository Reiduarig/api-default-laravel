# API REST Laravel - Sistema de Gestión de Usuarios y Tickets

Una API REST completa construida con Laravel 12 que proporciona gestión de usuarios y tickets con autenticación Bearer Token y dos versiones de API.

## 🚀 Características Principales

- **Autenticación Segura** - Laravel Sanctum con tokens Bearer
- **Dual API Versioning** - V1 (básica) y V2 (avanzada) 
- **Gestión Completa** - CRUD para usuarios y tickets
- **Documentación Interactiva** - Generada automáticamente con Scribe
- **Manejo de Errores** - Sistema robusto de manejo de errores
- **JSON:API Compliant** - Formato estandarizado en V2

## 📋 Versiones de la API

### API V1 - Versión Básica
- Operaciones CRUD estándar
- Autenticación Bearer Token
- Respuestas simples en JSON
- Ideal para integraciones básicas

### API V2 - Versión Avanzada  
- Operaciones CRUD mejoradas
- Patrón Repository implementado
- Formato JSON:API compliant
- Endpoints de estadísticas
- Filtrado avanzado y relaciones
- Ideal para aplicaciones complejas

## 🛠️ Tecnologías

- **Laravel 12.0** - Framework PHP
- **Laravel Sanctum** - Autenticación API
- **Scribe** - Documentación automática
- **Pest** - Testing framework
- **MySQL/SQLite** - Base de datos

## ⚡ Inicio Rápido

### Prerrequisitos
- PHP 8.2+
- Composer
- Node.js & NPM

### Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/tu-usuario/api-default-laravel.git
cd api-default-laravel
```

2. **Instalación automática**
```bash
composer run setup
```

3. **Iniciar la aplicación**
```bash
composer run dev
```

La API estará disponible en `http://localhost:8000`

### Configuración Manual

Si prefieres la instalación paso a paso:

```bash
# Instalar dependencias
composer install
npm install

# Configurar entorno
cp .env.example .env
php artisan key:generate

# Base de datos
php artisan migrate
php artisan db:seed

# Assets
npm run build

# Documentación
php artisan scribe:generate

# Iniciar servidor
php artisan serve
```

## 📚 Documentación

### Documentación Interactiva
- **URL**: `/docs`
- **Descripción**: Interfaz interactiva con todos los endpoints
- **Incluye**: Ejemplos de peticiones, respuestas y pruebas en vivo


### Endpoints Principales

#### Autenticación
- `POST /api/auth/register` - Registro de usuario
- `POST /api/auth/login` - Inicio de sesión
- `POST /api/auth/logout` - Cerrar sesión

#### API V1 - Básica
- `GET /api/v1/users` - Listar usuarios
- `GET /api/v1/tickets` - Listar tickets
- CRUD completo para ambos recursos

#### API V2 - Avanzada
- `GET /api/v2/users` - Listar con filtros avanzados
- `GET /api/v2/users/{user}/tickets` - Tickets de usuario
- `GET /api/v2/users/statistics` - Estadísticas de usuarios
- `GET /api/v2/tickets/statistics` - Estadísticas de tickets

## 🧪 Testing

```bash
# Ejecutar tests
composer test

# Tests con cobertura
php artisan test --coverage
```

## 📖 Estructura del Proyecto

```
app/
├── Http/Controllers/API/
│   ├── V1/               # API V1 - Básica
│   └── V2/               # API V2 - Avanzada
├── Models/               # Modelos Eloquent


routes/
├── api.php              # Rutas principales
└── api/v1.php           # Rutas específicas V1

docs/                    # Documentación del proyecto
config/scribe.php        # Configuración documentación
```

## 🔧 Comandos Útiles

```bash
# Regenerar documentación
php artisan scribe:generate

# Limpiar cache
php artisan optimize:clear

# Verificar rutas
php artisan route:list --path=api

# Ejecutar migraciones
php artisan migrate

# Generar datos de prueba
php artisan db:seed
```


## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver `LICENSE` para más detalles.
