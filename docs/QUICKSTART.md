# Guía de Inicio Rápido

## 🚀 Configuración Inicial

### 1. Clonar y Configurar Proyecto
```bash
# Clonar repositorio
git clone https://github.com/tu-usuario/api-default-laravel.git
cd api-default-laravel

# Instalar dependencias
composer install
npm install

# Configurar entorno
cp .env.example .env
php artisan key:generate

# Configurar base de datos
php artisan migrate
php artisan db:seed
```

### 2. Iniciar Servidor
```bash
# Opción 1: Laravel Sail
./vendor/bin/sail up -d

# Opción 2: Artisan
php artisan serve

# Opción 3: Herd (macOS/Windows)
herd link api-default-laravel
```

### 3. Verificar Instalación
```bash
# Health check V2
curl https://api-default-laravel.test/api/v2/health

# Respuesta esperada:
{
  "status": "healthy",
  "version": "2.0",
  "database": "connected"
}
```

## 🔐 Primeros Pasos con Autenticación

### 1. Crear Usuario
```bash
curl -X POST https://api-default-laravel.test/api/v2/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Admin User",
    "email": "admin@example.com",
    "password": "password",
    "password_confirmation": "password"
  }'
```

### 2. Obtener Token
```bash
curl -X POST https://api-default-laravel.test/api/v2/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@example.com",
    "password": "password"
  }'
```

**Guardar el token de la respuesta:**
```json
{
  "status": "success",
  "data": {
    "token": "1|eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "user": {
      "id": 1,
      "name": "Admin User",
      "email": "admin@example.com"
    }
  }
}
```

### 3. Variable de Entorno (Recomendado)
```bash
# Guardar token para uso rápido
export API_TOKEN="1|eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
```

## 🎫 CRUD Básico de Tickets (5 minutos)

### 1. Crear Primer Ticket
```bash
curl -X POST https://api-default-laravel.test/api/v2/tickets \
  -H "Authorization: Bearer $API_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "data": {
      "type": "tickets",
      "attributes": {
        "title": "Mi primer ticket V2",
        "description": "Probando la API V2 con funcionalidades avanzadas",
        "status": "A",
        "priority": "medium"
      },
      "relationships": {
        "author": {
          "data": {"type": "users", "id": "1"}
        }
      }
    }
  }'
```

### 2. Listar Tickets
```bash
# Lista básica
curl "https://api-default-laravel.test/api/v2/tickets" \
  -H "Authorization: Bearer $API_TOKEN"

# Con relaciones
curl "https://api-default-laravel.test/api/v2/tickets?include=author" \
  -H "Authorization: Bearer $API_TOKEN"

# Solo campos específicos (optimizado)
curl "https://api-default-laravel.test/api/v2/tickets?fields[tickets]=title,status,priority" \
  -H "Authorization: Bearer $API_TOKEN"
```

### 3. Ver Ticket Individual
```bash
curl "https://api-default-laravel.test/api/v2/tickets/1?include=author" \
  -H "Authorization: Bearer $API_TOKEN"
```

### 4. Actualizar Ticket
```bash
curl -X PUT https://api-default-laravel.test/api/v2/tickets/1 \
  -H "Authorization: Bearer $API_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "data": {
      "type": "tickets",
      "id": "1",
      "attributes": {
        "status": "C",
        "priority": "high",
        "internal_notes": "Resuelto rápidamente"
      }
    }
  }'
```

## 🔍 Funcionalidades Avanzadas (10 minutos)

### 1. Filtrado Avanzado
```bash
# Filtros múltiples
curl "https://api-default-laravel.test/api/v2/tickets?priority=high,medium&status=A" \
  -H "Authorization: Bearer $API_TOKEN"

# Búsqueda por texto
curl "https://api-default-laravel.test/api/v2/tickets?search=problema&priority=high" \
  -H "Authorization: Bearer $API_TOKEN"

# Rangos de fechas
curl "https://api-default-laravel.test/api/v2/tickets?created_at=2025-10-01,2025-10-31" \
  -H "Authorization: Bearer $API_TOKEN"
```

### 2. Estadísticas
```bash
# Estadísticas completas
curl "https://api-default-laravel.test/api/v2/tickets-statistics" \
  -H "Authorization: Bearer $API_TOKEN"

# Estadísticas de usuarios  
curl "https://api-default-laravel.test/api/v2/users-statistics" \
  -H "Authorization: Bearer $API_TOKEN"
```

### 3. Optimización de Performance
```bash
# Field selection para reducir payload
curl "https://api-default-laravel.test/api/v2/tickets?fields[tickets]=title,status&per_page=50" \
  -H "Authorization: Bearer $API_TOKEN"

# Paginación personalizada
curl "https://api-default-laravel.test/api/v2/tickets?per_page=10&page=2" \
  -H "Authorization: Bearer $API_TOKEN"
```

## 📊 Dashboard de Ejemplo (15 minutos)

### Crear Dashboard HTML Simple
```html
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard API V2</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .card { border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 5px; }
        .stats { display: flex; gap: 20px; }
        .stat { background: #f5f5f5; padding: 10px; border-radius: 3px; text-align: center; }
        .high { color: #d73027; }
        .medium { color: #fee08b; }
        .low { color: #4575b4; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
    </style>
</head>
<body>
    <h1>🎫 Dashboard API V2</h1>
    
    <div class="card">
        <h2>📊 Estadísticas</h2>
        <div id="stats" class="stats">Cargando...</div>
    </div>

    <div class="card">
        <h2>🎫 Tickets Recientes</h2>
        <table id="tickets">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Estado</th>
                    <th>Prioridad</th>
                    <th>Vistas</th>
                </tr>
            </thead>
            <tbody>Cargando...</tbody>
        </table>
    </div>

    <script>
        const API_BASE = 'https://api-default-laravel.test/api/v2';
        const TOKEN = 'TU_TOKEN_AQUI';

        async function fetchAPI(endpoint) {
            const response = await fetch(`${API_BASE}${endpoint}`, {
                headers: {
                    'Authorization': `Bearer ${TOKEN}`,
                    'Accept': 'application/json'
                }
            });
            return response.json();
        }

        async function loadStats() {
            try {
                const stats = await fetchAPI('/tickets-statistics');
                const data = stats.data;
                
                document.getElementById('stats').innerHTML = `
                    <div class="stat">
                        <h3>${data.total_tickets}</h3>
                        <p>Total Tickets</p>
                    </div>
                    <div class="stat">
                        <h3>${data.status_distribution.active}</h3>
                        <p>Activos</p>
                    </div>
                    <div class="stat">
                        <h3>${data.priority_distribution.high}</h3>
                        <p class="high">Alta Prioridad</p>
                    </div>
                    <div class="stat">
                        <h3>${data.average_view_count}</h3>
                        <p>Promedio Vistas</p>
                    </div>
                `;
            } catch (error) {
                console.error('Error loading stats:', error);
            }
        }

        async function loadTickets() {
            try {
                const response = await fetchAPI('/tickets?fields[tickets]=title,status,priority,view_count&per_page=10');
                const tickets = response.data;
                
                const tbody = document.querySelector('#tickets tbody');
                tbody.innerHTML = tickets.map(ticket => `
                    <tr>
                        <td>${ticket.id}</td>
                        <td>${ticket.attributes.title}</td>
                        <td>${ticket.attributes.status}</td>
                        <td class="${ticket.attributes.priority}">${ticket.attributes.priority}</td>
                        <td>${ticket.attributes.view_count}</td>
                    </tr>
                `).join('');
            } catch (error) {
                console.error('Error loading tickets:', error);
            }
        }

        // Cargar datos al inicio
        loadStats();
        loadTickets();

        // Actualizar cada 30 segundos
        setInterval(() => {
            loadStats();
            loadTickets();
        }, 30000);
    </script>
</body>
</html>
```

## 🔧 Cliente JavaScript Avanzado (10 minutos)

### Clase ApiClient
```javascript
class ApiV2Client {
    constructor(baseUrl, token) {
        this.baseUrl = baseUrl;
        this.token = token;
    }

    async request(endpoint, options = {}) {
        const url = `${this.baseUrl}${endpoint}`;
        const config = {
            headers: {
                'Authorization': `Bearer ${this.token}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                ...options.headers
            },
            ...options
        };

        const response = await fetch(url, config);
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }

        return response.json();
    }

    // Tickets
    async getTickets(filters = {}) {
        const params = new URLSearchParams();
        
        if (filters.priority) params.append('priority', filters.priority);
        if (filters.status) params.append('status', filters.status);
        if (filters.search) params.append('search', filters.search);
        if (filters.include) params.append('include', filters.include.join(','));
        if (filters.fields) params.append('fields[tickets]', filters.fields.join(','));
        if (filters.perPage) params.append('per_page', filters.perPage);
        if (filters.page) params.append('page', filters.page);

        const query = params.toString();
        return this.request(`/tickets${query ? '?' + query : ''}`);
    }

    async getTicket(id, include = []) {
        const params = include.length ? `?include=${include.join(',')}` : '';
        return this.request(`/tickets/${id}${params}`);
    }

    async createTicket(ticketData) {
        return this.request('/tickets', {
            method: 'POST',
            body: JSON.stringify({
                data: {
                    type: 'tickets',
                    attributes: ticketData.attributes,
                    relationships: ticketData.relationships
                }
            })
        });
    }

    async updateTicket(id, changes) {
        return this.request(`/tickets/${id}`, {
            method: 'PUT',
            body: JSON.stringify({
                data: {
                    type: 'tickets',
                    id: id.toString(),
                    attributes: changes
                }
            })
        });
    }

    // Estadísticas
    async getTicketsStats() {
        return this.request('/tickets-statistics');
    }

    async getUsersStats() {
        return this.request('/users-statistics');
    }

    // Utilidades
    async health() {
        return this.request('/health');
    }

    async version() {
        return this.request('/version');
    }
}

// Uso del cliente
const api = new ApiV2Client('https://api-default-laravel.test/api/v2', 'TU_TOKEN');

// Ejemplos de uso
async function ejemplosUso() {
    try {
        // Obtener tickets con filtros
        const tickets = await api.getTickets({
            priority: 'high,medium',
            status: 'A',
            include: ['author'],
            fields: ['title', 'status', 'priority', 'view_count'],
            perPage: 20
        });

        // Crear ticket
        const newTicket = await api.createTicket({
            attributes: {
                title: 'Error crítico en producción',
                description: 'El sistema de pagos no funciona',
                status: 'A',
                priority: 'high',
                internal_notes: 'Requiere atención inmediata'
            },
            relationships: {
                author: { data: { type: 'users', id: '1' } }
            }
        });

        // Actualizar ticket
        await api.updateTicket(newTicket.data.id, {
            status: 'C',
            internal_notes: 'Resuelto - reiniciar servidor'
        });

        // Estadísticas
        const stats = await api.getTicketsStats();
        console.log('Tickets activos:', stats.data.status_distribution.active);

    } catch (error) {
        console.error('Error:', error.message);
    }
}
```

## 📱 Próximos Pasos

### 1. Explorar Documentación Completa
- [📖 API V2 Completa](./v2/README.md)
- [🔄 Migrar desde V1](./MIGRATION.md)
- [📊 Comparar V1 vs V2](./COMPARISON.md)

### 2. Implementar en tu Aplicación
```javascript
// Instalar en proyecto existente
npm install axios  // o fetch nativo

// Integrar ApiV2Client
import ApiV2Client from './api-v2-client.js';
const api = new ApiV2Client(process.env.API_URL, userToken);
```

### 3. Casos de Uso Avanzados
- **Dashboard en tiempo real** con WebSockets
- **Búsqueda avanzada** con Elasticsearch
- **Notificaciones push** para tickets críticos
- **Reportes automáticos** con estadísticas
- **Cache inteligente** con Redis

### 4. Optimizaciones de Producción
```javascript
// Implementar retry logic
class ApiV2ClientWithRetry extends ApiV2Client {
    async request(endpoint, options = {}, retries = 3) {
        try {
            return await super.request(endpoint, options);
        } catch (error) {
            if (retries > 0 && error.status >= 500) {
                await new Promise(resolve => setTimeout(resolve, 1000));
                return this.request(endpoint, options, retries - 1);
            }
            throw error;
        }
    }
}

// Cache local
class CachedApiClient extends ApiV2Client {
    constructor(baseUrl, token, cacheTimeout = 60000) {
        super(baseUrl, token);
        this.cache = new Map();
        this.cacheTimeout = cacheTimeout;
    }

    async request(endpoint, options = {}) {
        const cacheKey = `${endpoint}:${JSON.stringify(options)}`;
        
        if (options.method === 'GET' && this.cache.has(cacheKey)) {
            const cached = this.cache.get(cacheKey);
            if (Date.now() - cached.timestamp < this.cacheTimeout) {
                return cached.data;
            }
        }

        const data = await super.request(endpoint, options);
        
        if (options.method === 'GET') {
            this.cache.set(cacheKey, {
                data,
                timestamp: Date.now()
            });
        }

        return data;
    }
}
```

## 🎯 Objetivos Completados ✅

- ✅ **Configuración inicial**
- ✅ **Autenticación** 
- ✅ **CRUD básico** de tickets
- ✅ **Funcionalidades avanzadas** (filtros, estadísticas)
- ✅ **Dashboard de ejemplo** funcional
- ✅ **Cliente JavaScript** reutilizable
- ✅ **Próximos pasos** definidos

¡Ya tienes todo listo para comenzar a aprovechar la potencia de la API V2! 🚀

---

> **Tip:** Guarda este archivo como referencia rápida y compártelo con tu equipo para acelerar la adopción de la API V2.