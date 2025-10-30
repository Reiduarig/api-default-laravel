# API Collections - Postman & VS Code REST Client

## 📋 Índice

- [Colección Postman](#colección-postman)
- [VS Code REST Client](#vs-code-rest-client)
- [Variables de Entorno](#variables-de-entorno)
- [Ejemplos de Testing](#ejemplos-de-testing)

## 📮 Colección Postman

### Importar Colección
```json
{
  "info": {
    "name": "Laravel Tickets API - V2",
    "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
  },
  "variable": [
    {
      "key": "base_url",
      "value": "https://api-default-laravel.test",
      "type": "string"
    },
    {
      "key": "api_token",
      "value": "",
      "type": "string"
    }
  ],
  "auth": {
    "type": "bearer",
    "bearer": [
      {
        "key": "token",
        "value": "{{api_token}}",
        "type": "string"
      }
    ]
  },
  "item": [
    {
      "name": "🔐 Authentication",
      "item": [
        {
          "name": "Login V2",
          "event": [
            {
              "listen": "test",
              "script": {
                "exec": [
                  "if (pm.response.code === 200) {",
                  "    const response = pm.response.json();",
                  "    pm.collectionVariables.set('api_token', response.data.token);",
                  "    pm.test('Token saved', function () {",
                  "        pm.expect(response.data.token).to.be.a('string');",
                  "    });",
                  "}"
                ]
              }
            }
          ],
          "request": {
            "method": "POST",
            "header": [
              {
                "key": "Content-Type",
                "value": "application/json"
              }
            ],
            "body": {
              "mode": "raw",
              "raw": "{\n  \"email\": \"admin@example.com\",\n  \"password\": \"password\"\n}"
            },
            "url": {
              "raw": "{{base_url}}/api/v2/login",
              "host": ["{{base_url}}"],
              "path": ["api", "v2", "login"]
            }
          }
        },
        {
          "name": "Register V2",
          "request": {
            "method": "POST",
            "header": [
              {
                "key": "Content-Type",
                "value": "application/json"
              }
            ],
            "body": {
              "mode": "raw",
              "raw": "{\n  \"name\": \"Test User\",\n  \"email\": \"test@example.com\",\n  \"password\": \"password\",\n  \"password_confirmation\": \"password\"\n}"
            },
            "url": {
              "raw": "{{base_url}}/api/v2/register",
              "host": ["{{base_url}}"],
              "path": ["api", "v2", "register"]
            }
          }
        }
      ]
    },
    {
      "name": "🎫 Tickets V2",
      "item": [
        {
          "name": "List Tickets",
          "request": {
            "method": "GET",
            "url": {
              "raw": "{{base_url}}/api/v2/tickets",
              "host": ["{{base_url}}"],
              "path": ["api", "v2", "tickets"]
            }
          }
        },
        {
          "name": "List Tickets with Filters",
          "request": {
            "method": "GET",
            "url": {
              "raw": "{{base_url}}/api/v2/tickets?priority=high,medium&status=A&include=author&fields[tickets]=title,status,priority",
              "host": ["{{base_url}}"],
              "path": ["api", "v2", "tickets"],
              "query": [
                {
                  "key": "priority",
                  "value": "high,medium"
                },
                {
                  "key": "status",
                  "value": "A"
                },
                {
                  "key": "include",
                  "value": "author"
                },
                {
                  "key": "fields[tickets]",
                  "value": "title,status,priority"
                }
              ]
            }
          }
        },
        {
          "name": "Get Ticket",
          "request": {
            "method": "GET",
            "url": {
              "raw": "{{base_url}}/api/v2/tickets/1?include=author",
              "host": ["{{base_url}}"],
              "path": ["api", "v2", "tickets", "1"],
              "query": [
                {
                  "key": "include",
                  "value": "author"
                }
              ]
            }
          }
        },
        {
          "name": "Create Ticket",
          "request": {
            "method": "POST",
            "header": [
              {
                "key": "Content-Type",
                "value": "application/json"
              }
            ],
            "body": {
              "mode": "raw",
              "raw": "{\n  \"data\": {\n    \"type\": \"tickets\",\n    \"attributes\": {\n      \"title\": \"Nuevo ticket desde Postman\",\n      \"description\": \"Descripción detallada del problema\",\n      \"status\": \"A\",\n      \"priority\": \"high\",\n      \"internal_notes\": \"Notas internas para el staff\"\n    },\n    \"relationships\": {\n      \"author\": {\n        \"data\": {\n          \"type\": \"users\",\n          \"id\": \"1\"\n        }\n      }\n    }\n  }\n}"
            },
            "url": {
              "raw": "{{base_url}}/api/v2/tickets",
              "host": ["{{base_url}}"],
              "path": ["api", "v2", "tickets"]
            }
          }
        },
        {
          "name": "Update Ticket",
          "request": {
            "method": "PUT",
            "header": [
              {
                "key": "Content-Type",
                "value": "application/json"
              }
            ],
            "body": {
              "mode": "raw",
              "raw": "{\n  \"data\": {\n    \"type\": \"tickets\",\n    \"id\": \"1\",\n    \"attributes\": {\n      \"status\": \"C\",\n      \"priority\": \"low\",\n      \"internal_notes\": \"Resuelto exitosamente\"\n    }\n  }\n}"
            },
            "url": {
              "raw": "{{base_url}}/api/v2/tickets/1",
              "host": ["{{base_url}}"],
              "path": ["api", "v2", "tickets", "1"]
            }
          }
        }
      ]
    },
    {
      "name": "📊 Statistics",
      "item": [
        {
          "name": "Tickets Statistics",
          "request": {
            "method": "GET",
            "url": {
              "raw": "{{base_url}}/api/v2/tickets-statistics",
              "host": ["{{base_url}}"],
              "path": ["api", "v2", "tickets-statistics"]
            }
          }
        },
        {
          "name": "Users Statistics",
          "request": {
            "method": "GET",
            "url": {
              "raw": "{{base_url}}/api/v2/users-statistics",
              "host": ["{{base_url}}"],
              "path": ["api", "v2", "users-statistics"]
            }
          }
        }
      ]
    },
    {
      "name": "🔍 Advanced Features",
      "item": [
        {
          "name": "Search Tickets",
          "request": {
            "method": "GET",
            "url": {
              "raw": "{{base_url}}/api/v2/tickets?search=error%20login&priority=high",
              "host": ["{{base_url}}"],
              "path": ["api", "v2", "tickets"],
              "query": [
                {
                  "key": "search",
                  "value": "error login"
                },
                {
                  "key": "priority",
                  "value": "high"
                }
              ]
            }
          }
        },
        {
          "name": "Field Selection",
          "request": {
            "method": "GET",
            "url": {
              "raw": "{{base_url}}/api/v2/tickets?fields[tickets]=title,status,priority&per_page=5",
              "host": ["{{base_url}}"],
              "path": ["api", "v2", "tickets"],
              "query": [
                {
                  "key": "fields[tickets]",
                  "value": "title,status,priority"
                },
                {
                  "key": "per_page",
                  "value": "5"
                }
              ]
            }
          }
        },
        {
          "name": "Date Range Filter",
          "request": {
            "method": "GET",
            "url": {
              "raw": "{{base_url}}/api/v2/tickets?created_at=2025-10-01,2025-10-31",
              "host": ["{{base_url}}"],
              "path": ["api", "v2", "tickets"],
              "query": [
                {
                  "key": "created_at",
                  "value": "2025-10-01,2025-10-31"
                }
              ]
            }
          }
        }
      ]
    }
  ]
}
```

## 🔗 VS Code REST Client

### Archivo de Variables
Crear `requests/variables.http`:
```http
### Variables
@baseUrl = https://api-default-laravel.test
@token = TU_TOKEN_AQUI
@contentType = application/json
```

### Autenticación
Crear `requests/auth.http`:
```http
### Login V2
POST {{baseUrl}}/api/v2/login
Content-Type: {{contentType}}

{
  "email": "admin@example.com",
  "password": "password"
}

### Register V2
POST {{baseUrl}}/api/v2/register
Content-Type: {{contentType}}

{
  "name": "Test User",
  "email": "test@example.com",
  "password": "password",
  "password_confirmation": "password"
}

### Logout
POST {{baseUrl}}/api/v2/logout
Authorization: Bearer {{token}}
```

### Tickets CRUD
Crear `requests/tickets.http`:
```http
### Get All Tickets
GET {{baseUrl}}/api/v2/tickets
Authorization: Bearer {{token}}

### Get Tickets with Filters
GET {{baseUrl}}/api/v2/tickets?priority=high,medium&status=A&include=author
Authorization: Bearer {{token}}

### Get Tickets with Field Selection
GET {{baseUrl}}/api/v2/tickets?fields[tickets]=title,status,priority&per_page=10
Authorization: Bearer {{token}}

### Get Single Ticket
GET {{baseUrl}}/api/v2/tickets/1?include=author
Authorization: Bearer {{token}}

### Create Ticket
POST {{baseUrl}}/api/v2/tickets
Authorization: Bearer {{token}}
Content-Type: {{contentType}}

{
  "data": {
    "type": "tickets",
    "attributes": {
      "title": "Error crítico en producción",
      "description": "El sistema de pagos no responde correctamente",
      "status": "A",
      "priority": "high",
      "internal_notes": "Requiere atención inmediata del equipo DevOps"
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

### Update Ticket
PUT {{baseUrl}}/api/v2/tickets/1
Authorization: Bearer {{token}}
Content-Type: {{contentType}}

{
  "data": {
    "type": "tickets",
    "id": "1",
    "attributes": {
      "status": "C",
      "priority": "medium",
      "internal_notes": "Problema resuelto - servidor reiniciado"
    }
  }
}

### Delete Ticket
DELETE {{baseUrl}}/api/v2/tickets/1
Authorization: Bearer {{token}}
```

### Filtros Avanzados
Crear `requests/filters.http`:
```http
### Search by Text
GET {{baseUrl}}/api/v2/tickets?search=login%20error
Authorization: Bearer {{token}}

### Multiple Priorities
GET {{baseUrl}}/api/v2/tickets?priority=high,medium
Authorization: Bearer {{token}}

### Multiple Statuses
GET {{baseUrl}}/api/v2/tickets?status=A,H
Authorization: Bearer {{token}}

### Date Range
GET {{baseUrl}}/api/v2/tickets?created_at=2025-10-01,2025-10-31
Authorization: Bearer {{token}}

### Complex Filter Combination
GET {{baseUrl}}/api/v2/tickets?priority=high&status=A&search=critical&include=author&fields[tickets]=title,status,priority,view_count
Authorization: Bearer {{token}}

### Pagination
GET {{baseUrl}}/api/v2/tickets?per_page=5&page=2
Authorization: Bearer {{token}}
```

### Estadísticas
Crear `requests/statistics.http`:
```http
### Tickets Statistics
GET {{baseUrl}}/api/v2/tickets-statistics
Authorization: Bearer {{token}}

### Users Statistics
GET {{baseUrl}}/api/v2/users-statistics
Authorization: Bearer {{token}}

### API Version Info
GET {{baseUrl}}/api/v2/version
Authorization: Bearer {{token}}

### Health Check
GET {{baseUrl}}/api/v2/health
Authorization: Bearer {{token}}
```

### Usuarios V2
Crear `requests/users.http`:
```http
### Get All Users
GET {{baseUrl}}/api/v2/users
Authorization: Bearer {{token}}

### Get User
GET {{baseUrl}}/api/v2/users/1
Authorization: Bearer {{token}}

### Get User Tickets
GET {{baseUrl}}/api/v2/users/1/tickets
Authorization: Bearer {{token}}

### Create User
POST {{baseUrl}}/api/v2/users
Authorization: Bearer {{token}}
Content-Type: {{contentType}}

{
  "name": "Nuevo Usuario",
  "email": "nuevo@example.com",
  "password": "password123"
}

### Update User
PUT {{baseUrl}}/api/v2/users/1
Authorization: Bearer {{token}}
Content-Type: {{contentType}}

{
  "name": "Usuario Actualizado",
  "email": "actualizado@example.com"
}
```

## 🧪 Testing Automatizado

### Script de Tests Postman
```javascript
// Test Suite para Collection
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

pm.test("Response has data property", function () {
    const jsonData = pm.response.json();
    pm.expect(jsonData).to.have.property('data');
});

pm.test("API version is 2.0", function () {
    const jsonData = pm.response.json();
    pm.expect(jsonData.meta.api_version).to.eql('2.0');
});

// Test específico para tickets
if (pm.info.requestName.includes("Create Ticket")) {
    pm.test("Ticket created with correct priority", function () {
        const jsonData = pm.response.json();
        pm.expect(jsonData.data.attributes.priority).to.be.oneOf(['low', 'medium', 'high']);
    });
    
    pm.test("Author relationship exists", function () {
        const jsonData = pm.response.json();
        pm.expect(jsonData.data.relationships).to.have.property('author');
    });
}

// Test para estadísticas
if (pm.info.requestName.includes("Statistics")) {
    pm.test("Statistics contain required fields", function () {
        const jsonData = pm.response.json();
        pm.expect(jsonData.data).to.have.property('total_tickets');
        pm.expect(jsonData.data).to.have.property('status_distribution');
        pm.expect(jsonData.data).to.have.property('priority_distribution');
    });
}
```

### VS Code Testing con REST Client
Crear `requests/tests.http`:
```http
### Test Full Workflow
# @name login
POST {{baseUrl}}/api/v2/login
Content-Type: {{contentType}}

{
  "email": "admin@example.com",
  "password": "password"
}

###
# @name createTicket
POST {{baseUrl}}/api/v2/tickets
Authorization: Bearer {{login.response.body.data.token}}
Content-Type: {{contentType}}

{
  "data": {
    "type": "tickets",
    "attributes": {
      "title": "Test Ticket - {{$datetime}}",
      "description": "Ticket creado para testing automatizado",
      "status": "A",
      "priority": "medium"
    },
    "relationships": {
      "author": {
        "data": {"type": "users", "id": "1"}
      }
    }
  }
}

###
# @name getTicket
GET {{baseUrl}}/api/v2/tickets/{{createTicket.response.body.data.id}}?include=author
Authorization: Bearer {{login.response.body.data.token}}

###
# @name updateTicket
PUT {{baseUrl}}/api/v2/tickets/{{createTicket.response.body.data.id}}
Authorization: Bearer {{login.response.body.data.token}}
Content-Type: {{contentType}}

{
  "data": {
    "type": "tickets",
    "id": "{{createTicket.response.body.data.id}}",
    "attributes": {
      "status": "C",
      "internal_notes": "Test completado exitosamente"
    }
  }
}

###
# @name verifyStats
GET {{baseUrl}}/api/v2/tickets-statistics
Authorization: Bearer {{login.response.body.data.token}}
```

## 🛠️ Variables de Entorno

### Archivo .env para VS Code
Crear `requests/.env`:
```env
BASE_URL=https://api-default-laravel.test
API_TOKEN=
ADMIN_EMAIL=admin@example.com
ADMIN_PASSWORD=password
TEST_USER_EMAIL=test@example.com
TEST_USER_PASSWORD=password123
```

### Variables Dinámicas
```http
### Variables dinámicas
@timestamp = {{$timestamp}}
@randomEmail = test-{{$randomInt}}@example.com
@uuid = {{$guid}}
@datetime = {{$datetime iso8601}}
```

## 🔄 Automatización con Scripts

### Script Bash para Testing
```bash
#!/bin/bash
# test-api-v2.sh

BASE_URL="https://api-default-laravel.test/api/v2"
EMAIL="admin@example.com"
PASSWORD="password"

echo "🔐 Authenticating..."
TOKEN=$(curl -s -X POST $BASE_URL/login \
  -H "Content-Type: application/json" \
  -d "{\"email\":\"$EMAIL\",\"password\":\"$PASSWORD\"}" \
  | jq -r '.data.token')

if [ "$TOKEN" = "null" ]; then
  echo "❌ Authentication failed"
  exit 1
fi

echo "✅ Token obtained: ${TOKEN:0:20}..."

echo "🎫 Creating test ticket..."
TICKET_ID=$(curl -s -X POST $BASE_URL/tickets \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "data": {
      "type": "tickets",
      "attributes": {
        "title": "Test Ticket via Script",
        "description": "Automated test ticket",
        "status": "A",
        "priority": "high"
      },
      "relationships": {
        "author": {"data": {"type": "users", "id": "1"}}
      }
    }
  }' | jq -r '.data.id')

echo "✅ Ticket created with ID: $TICKET_ID"

echo "📊 Getting statistics..."
curl -s -X GET $BASE_URL/tickets-statistics \
  -H "Authorization: Bearer $TOKEN" \
  | jq '.data | {total_tickets, status_distribution, priority_distribution}'

echo "🔄 Updating ticket..."
curl -s -X PUT $BASE_URL/tickets/$TICKET_ID \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d "{
    \"data\": {
      \"type\": \"tickets\",
      \"id\": \"$TICKET_ID\",
      \"attributes\": {
        \"status\": \"C\",
        \"internal_notes\": \"Resolved by automated script\"
      }
    }
  }" | jq '.data.attributes | {status, internal_notes}'

echo "✅ Test completed successfully!"
```

### Node.js Testing Script
```javascript
// test-api-v2.js
const fetch = require('node-fetch');

const BASE_URL = 'https://api-default-laravel.test/api/v2';
const EMAIL = 'admin@example.com';
const PASSWORD = 'password';

async function testApiV2() {
    try {
        // 1. Login
        console.log('🔐 Authenticating...');
        const loginResponse = await fetch(`${BASE_URL}/login`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email: EMAIL, password: PASSWORD })
        });
        const { data: { token } } = await loginResponse.json();
        console.log(`✅ Token obtained: ${token.substring(0, 20)}...`);

        const headers = {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json'
        };

        // 2. Create ticket
        console.log('🎫 Creating test ticket...');
        const ticketResponse = await fetch(`${BASE_URL}/tickets`, {
            method: 'POST',
            headers,
            body: JSON.stringify({
                data: {
                    type: 'tickets',
                    attributes: {
                        title: `Test Ticket ${new Date().toISOString()}`,
                        description: 'Automated test ticket',
                        status: 'A',
                        priority: 'high'
                    },
                    relationships: {
                        author: { data: { type: 'users', id: '1' } }
                    }
                }
            })
        });
        const ticket = await ticketResponse.json();
        console.log(`✅ Ticket created with ID: ${ticket.data.id}`);

        // 3. Get statistics
        console.log('📊 Getting statistics...');
        const statsResponse = await fetch(`${BASE_URL}/tickets-statistics`, { headers });
        const stats = await statsResponse.json();
        console.log('Statistics:', {
            total: stats.data.total_tickets,
            active: stats.data.status_distribution.active,
            high_priority: stats.data.priority_distribution.high
        });

        // 4. Update ticket
        console.log('🔄 Updating ticket...');
        const updateResponse = await fetch(`${BASE_URL}/tickets/${ticket.data.id}`, {
            method: 'PUT',
            headers,
            body: JSON.stringify({
                data: {
                    type: 'tickets',
                    id: ticket.data.id,
                    attributes: {
                        status: 'C',
                        internal_notes: 'Resolved by Node.js script'
                    }
                }
            })
        });
        const updatedTicket = await updateResponse.json();
        console.log('✅ Ticket updated:', {
            status: updatedTicket.data.attributes.status,
            notes: updatedTicket.data.attributes.internal_notes
        });

        console.log('🎉 All tests completed successfully!');

    } catch (error) {
        console.error('❌ Test failed:', error.message);
    }
}

testApiV2();
```

---

> **Nota:** Estas colecciones te permiten probar rápidamente todas las funcionalidades de la API V2. Personaliza las variables según tu entorno.