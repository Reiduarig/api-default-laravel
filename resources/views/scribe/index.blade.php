<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Laravel API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
                    body .content .php-example code { display: none; }
                    body .content .python-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://api-default-laravel.test";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.5.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.5.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;,&quot;php&quot;,&quot;python&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                                            <button type="button" class="lang-button" data-language-name="php">php</button>
                                            <button type="button" class="lang-button" data-language-name="python">python</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-autenticacion" class="tocify-header">
                <li class="tocify-item level-1" data-unique="autenticacion">
                    <a href="#autenticacion">Autenticación</a>
                </li>
                                    <ul id="tocify-subheader-autenticacion" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="autenticacion-POSTapi-v1-auth-login">
                                <a href="#autenticacion-POSTapi-v1-auth-login">Iniciar sesión</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="autenticacion-POSTapi-v1-auth-register">
                                <a href="#autenticacion-POSTapi-v1-auth-register">Registrar usuario</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="autenticacion-POSTapi-v1-logout">
                                <a href="#autenticacion-POSTapi-v1-logout">Cerrar sesión</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="autenticacion-POSTapi-v1-logoutAllDevices">
                                <a href="#autenticacion-POSTapi-v1-logoutAllDevices">Cerrar sesión en todos los dispositivos</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="autenticacion-POSTapi-v2-login">
                                <a href="#autenticacion-POSTapi-v2-login">Iniciar sesión</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="autenticacion-POSTapi-v2-register">
                                <a href="#autenticacion-POSTapi-v2-register">Registrar usuario</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="autenticacion-POSTapi-v2-logout">
                                <a href="#autenticacion-POSTapi-v2-logout">Cerrar sesión</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="autenticacion-POSTapi-v2-logout-all-devices">
                                <a href="#autenticacion-POSTapi-v2-logout-all-devices">Cerrar sesión en todos los dispositivos</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-informacion-del-sistema" class="tocify-header">
                <li class="tocify-item level-1" data-unique="informacion-del-sistema">
                    <a href="#informacion-del-sistema">Información del Sistema</a>
                </li>
                                    <ul id="tocify-subheader-informacion-del-sistema" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="informacion-del-sistema-GETapi-v2-version">
                                <a href="#informacion-del-sistema-GETapi-v2-version">Información de versión API V2</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="informacion-del-sistema-GETapi-v2-health">
                                <a href="#informacion-del-sistema-GETapi-v2-health">Estado de salud de la API</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-tickets-v1" class="tocify-header">
                <li class="tocify-item level-1" data-unique="tickets-v1">
                    <a href="#tickets-v1">Tickets (V1)</a>
                </li>
                                    <ul id="tocify-subheader-tickets-v1" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="tickets-v1-GETapi-v1-tickets">
                                <a href="#tickets-v1-GETapi-v1-tickets">Listar tickets</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="tickets-v1-POSTapi-v1-tickets">
                                <a href="#tickets-v1-POSTapi-v1-tickets">Crear ticket</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="tickets-v1-GETapi-v1-tickets--id-">
                                <a href="#tickets-v1-GETapi-v1-tickets--id-">Mostrar ticket</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="tickets-v1-PUTapi-v1-tickets--id-">
                                <a href="#tickets-v1-PUTapi-v1-tickets--id-">Actualizar ticket</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="tickets-v1-DELETEapi-v1-tickets--id-">
                                <a href="#tickets-v1-DELETEapi-v1-tickets--id-">Eliminar ticket</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-tickets-v2" class="tocify-header">
                <li class="tocify-item level-1" data-unique="tickets-v2">
                    <a href="#tickets-v2">Tickets (V2)</a>
                </li>
                                    <ul id="tocify-subheader-tickets-v2" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="tickets-v2-GETapi-v2-tickets">
                                <a href="#tickets-v2-GETapi-v2-tickets">Listar tickets</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="tickets-v2-POSTapi-v2-tickets">
                                <a href="#tickets-v2-POSTapi-v2-tickets">Crear ticket</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="tickets-v2-GETapi-v2-tickets--id-">
                                <a href="#tickets-v2-GETapi-v2-tickets--id-">Mostrar ticket</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="tickets-v2-PUTapi-v2-tickets--id-">
                                <a href="#tickets-v2-PUTapi-v2-tickets--id-">Actualizar ticket</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="tickets-v2-DELETEapi-v2-tickets--id-">
                                <a href="#tickets-v2-DELETEapi-v2-tickets--id-">Eliminar ticket</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="tickets-v2-GETapi-v2-tickets-statistics">
                                <a href="#tickets-v2-GETapi-v2-tickets-statistics">Estadísticas de tickets</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-usuarios-v1" class="tocify-header">
                <li class="tocify-item level-1" data-unique="usuarios-v1">
                    <a href="#usuarios-v1">Usuarios (V1)</a>
                </li>
                                    <ul id="tocify-subheader-usuarios-v1" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="usuarios-v1-GETapi-v1-users">
                                <a href="#usuarios-v1-GETapi-v1-users">Listar usuarios</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="usuarios-v1-POSTapi-v1-users">
                                <a href="#usuarios-v1-POSTapi-v1-users">Crear usuario</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="usuarios-v1-GETapi-v1-users--id-">
                                <a href="#usuarios-v1-GETapi-v1-users--id-">Mostrar usuario</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="usuarios-v1-DELETEapi-v1-users--id-">
                                <a href="#usuarios-v1-DELETEapi-v1-users--id-">Eliminar usuario</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-usuarios-v2" class="tocify-header">
                <li class="tocify-item level-1" data-unique="usuarios-v2">
                    <a href="#usuarios-v2">Usuarios (V2)</a>
                </li>
                                    <ul id="tocify-subheader-usuarios-v2" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="usuarios-v2-GETapi-v2-users">
                                <a href="#usuarios-v2-GETapi-v2-users">Listar usuarios</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="usuarios-v2-POSTapi-v2-users">
                                <a href="#usuarios-v2-POSTapi-v2-users">Crear usuario</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="usuarios-v2-GETapi-v2-users--id-">
                                <a href="#usuarios-v2-GETapi-v2-users--id-">Mostrar usuario</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="usuarios-v2-DELETEapi-v2-users--id-">
                                <a href="#usuarios-v2-DELETEapi-v2-users--id-">Eliminar usuario</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="usuarios-v2-GETapi-v2-users--user--tickets">
                                <a href="#usuarios-v2-GETapi-v2-users--user--tickets">Tickets de usuario</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="usuarios-v2-GETapi-v2-users-statistics">
                                <a href="#usuarios-v2-GETapi-v2-users-statistics">Estadísticas de usuarios</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: October 30, 2025</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<p>API REST para gestión de tickets con autenticación Sanctum y versionado V1/V2</p>
<aside>
    <strong>Base URL</strong>: <code>http://api-default-laravel.test</code>
</aside>
<pre><code>Esta API REST está construida con Laravel 12 y utiliza autenticación Sanctum para proteger los endpoints.

## Características principales:
- **Versionado:** Soporta versiones V1 y V2 de la API
- **Autenticación:** Sistema Bearer Token con Laravel Sanctum
- **Gestión de Tickets:** CRUD completo para tickets de soporte
- **Usuarios:** Sistema de autenticación y gestión de usuarios
- **Error Handling:** Manejo comprensivo de errores con códigos HTTP apropiados

## Autenticación
Para acceder a los endpoints protegidos, necesitas incluir un token Bearer en el header:
```
Authorization: Bearer YOUR_TOKEN_HERE
```

&lt;aside&gt;Los ejemplos de código muestran cómo trabajar con la API en diferentes lenguajes de programación. 
Puedes cambiar el lenguaje usando las pestañas en la parte superior derecha.&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>To authenticate requests, include an <strong><code>Authorization</code></strong> header with the value <strong><code>"Bearer YOUR_BEARER_TOKEN"</code></strong>.</p>
<p>All authenticated endpoints are marked with a <code>requires authentication</code> badge in the documentation below.</p>
<p>Para obtener tu token, realiza una petición POST a <code>/api/v2/login</code> con tus credenciales. El token se encuentra en la respuesta dentro de <code>data.token</code>.</p>

        <h1 id="autenticacion">Autenticación</h1>

    <p>Endpoints para gestión de autenticación usando Laravel Sanctum.
Los endpoints de login y register no requieren autenticación.
Los endpoints de logout requieren autenticación Bearer token.</p>

                                <h2 id="autenticacion-POSTapi-v1-auth-login">Iniciar sesión</h2>

<p>
</p>

<p>Autentica un usuario con email y contraseña, devuelve un token Bearer para acceder a endpoints protegidos.</p>

<span id="example-requests-POSTapi-v1-auth-login">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://api-default-laravel.test/api/v1/auth/login" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"admin@admin.com\",
    \"password\": \"password\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v1/auth/login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "admin@admin.com",
    "password": "password"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v1/auth/login';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'email' =&gt; 'admin@admin.com',
            'password' =&gt; 'password',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v1/auth/login'
payload = {
    "email": "admin@admin.com",
    "password": "password"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-auth-login">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Inicio de sesi&oacute;n exitoso.&quot;,
    &quot;data&quot;: {
        &quot;user&quot;: {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;Admin User&quot;,
            &quot;email&quot;: &quot;admin@admin.com&quot;,
            &quot;email_verified_at&quot;: null,
            &quot;created_at&quot;: &quot;2025-10-30T10:00:00.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-30T10:00:00.000000Z&quot;
        },
        &quot;token&quot;: &quot;1|abcdef123456789...&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;Credenciales incorrectas&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-auth-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-auth-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-auth-login"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-auth-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-auth-login">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-auth-login" data-method="POST"
      data-path="api/v1/auth/login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-auth-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-auth-login"
                    onclick="tryItOut('POSTapi-v1-auth-login');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-auth-login"
                    onclick="cancelTryOut('POSTapi-v1-auth-login');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-auth-login"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/auth/login</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-auth-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-auth-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-auth-login"
               value="admin@admin.com"
               data-component="body">
    <br>
<p>Email del usuario. Example: <code>admin@admin.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-v1-auth-login"
               value="password"
               data-component="body">
    <br>
<p>Contraseña del usuario. Example: <code>password</code></p>
        </div>
        </form>

                    <h2 id="autenticacion-POSTapi-v1-auth-register">Registrar usuario</h2>

<p>
</p>

<p>Crea una nueva cuenta de usuario en el sistema.</p>

<span id="example-requests-POSTapi-v1-auth-register">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://api-default-laravel.test/api/v1/auth/register" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Juan Pérez\",
    \"email\": \"juan@example.com\",
    \"password\": \"password123\",
    \"password_confirmation\": \"password123\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v1/auth/register"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Juan Pérez",
    "email": "juan@example.com",
    "password": "password123",
    "password_confirmation": "password123"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v1/auth/register';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'Juan Pérez',
            'email' =&gt; 'juan@example.com',
            'password' =&gt; 'password123',
            'password_confirmation' =&gt; 'password123',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v1/auth/register'
payload = {
    "name": "Juan Pérez",
    "email": "juan@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-auth-register">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Registro exitoso.&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: 2,
        &quot;name&quot;: &quot;Juan P&eacute;rez&quot;,
        &quot;email&quot;: &quot;juan@example.com&quot;,
        &quot;email_verified_at&quot;: null,
        &quot;created_at&quot;: &quot;2025-10-30T11:00:00.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2025-10-30T11:00:00.000000Z&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;Los datos proporcionados no son v&aacute;lidos.&quot;,
    &quot;data&quot;: {
        &quot;email&quot;: [
            &quot;The email has already been taken.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-auth-register" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-auth-register"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-auth-register"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-auth-register" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-auth-register">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-auth-register" data-method="POST"
      data-path="api/v1/auth/register"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-auth-register', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-auth-register"
                    onclick="tryItOut('POSTapi-v1-auth-register');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-auth-register"
                    onclick="cancelTryOut('POSTapi-v1-auth-register');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-auth-register"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/auth/register</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-auth-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-auth-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v1-auth-register"
               value="Juan Pérez"
               data-component="body">
    <br>
<p>Nombre completo del usuario. Example: <code>Juan Pérez</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-auth-register"
               value="juan@example.com"
               data-component="body">
    <br>
<p>Email único del usuario. Example: <code>juan@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-v1-auth-register"
               value="password123"
               data-component="body">
    <br>
<p>Contraseña (mínimo 8 caracteres). Example: <code>password123</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password_confirmation</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password_confirmation"                data-endpoint="POSTapi-v1-auth-register"
               value="password123"
               data-component="body">
    <br>
<p>Confirmación de contraseña. Example: <code>password123</code></p>
        </div>
        </form>

                    <h2 id="autenticacion-POSTapi-v1-logout">Cerrar sesión</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Revoca el token actual y cierra la sesión en este dispositivo específico.</p>

<span id="example-requests-POSTapi-v1-logout">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://api-default-laravel.test/api/v1/logout" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v1/logout"
);

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v1/logout';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v1/logout'
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-logout">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Sesi&oacute;n cerrada correctamente&quot;,
    &quot;data&quot;: []
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-logout" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-logout"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-logout"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-logout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-logout">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-logout" data-method="POST"
      data-path="api/v1/logout"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-logout', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-logout"
                    onclick="tryItOut('POSTapi-v1-logout');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-logout"
                    onclick="cancelTryOut('POSTapi-v1-logout');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-logout"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/logout</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-logout"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="autenticacion-POSTapi-v1-logoutAllDevices">Cerrar sesión en todos los dispositivos</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Revoca TODOS los tokens del usuario, cerrando sesión en todos los dispositivos donde esté autenticado.
Útil para desconectar por seguridad o cambio de contraseña.</p>

<span id="example-requests-POSTapi-v1-logoutAllDevices">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://api-default-laravel.test/api/v1/logoutAllDevices" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v1/logoutAllDevices"
);

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v1/logoutAllDevices';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v1/logoutAllDevices'
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-logoutAllDevices">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Sesi&oacute;n cerrada correctamente&quot;,
    &quot;data&quot;: []
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-logoutAllDevices" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-logoutAllDevices"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-logoutAllDevices"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-logoutAllDevices" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-logoutAllDevices">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-logoutAllDevices" data-method="POST"
      data-path="api/v1/logoutAllDevices"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-logoutAllDevices', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-logoutAllDevices"
                    onclick="tryItOut('POSTapi-v1-logoutAllDevices');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-logoutAllDevices"
                    onclick="cancelTryOut('POSTapi-v1-logoutAllDevices');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-logoutAllDevices"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/logoutAllDevices</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-logoutAllDevices"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-logoutAllDevices"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-logoutAllDevices"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="autenticacion-POSTapi-v2-login">Iniciar sesión</h2>

<p>
</p>

<p>Autentica un usuario con email y contraseña, devuelve un token Bearer para acceder a endpoints protegidos.</p>

<span id="example-requests-POSTapi-v2-login">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://api-default-laravel.test/api/v2/login" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"admin@admin.com\",
    \"password\": \"password\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v2/login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "admin@admin.com",
    "password": "password"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v2/login';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'email' =&gt; 'admin@admin.com',
            'password' =&gt; 'password',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v2/login'
payload = {
    "email": "admin@admin.com",
    "password": "password"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>

</span>

<span id="example-responses-POSTapi-v2-login">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Inicio de sesi&oacute;n exitoso.&quot;,
    &quot;data&quot;: {
        &quot;user&quot;: {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;Admin User&quot;,
            &quot;email&quot;: &quot;admin@admin.com&quot;,
            &quot;email_verified_at&quot;: null,
            &quot;created_at&quot;: &quot;2025-10-30T10:00:00.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-30T10:00:00.000000Z&quot;
        },
        &quot;token&quot;: &quot;1|abcdef123456789...&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;Credenciales incorrectas&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v2-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v2-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v2-login"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v2-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v2-login">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v2-login" data-method="POST"
      data-path="api/v2/login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v2-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v2-login"
                    onclick="tryItOut('POSTapi-v2-login');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v2-login"
                    onclick="cancelTryOut('POSTapi-v2-login');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v2-login"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v2/login</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v2-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v2-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v2-login"
               value="admin@admin.com"
               data-component="body">
    <br>
<p>Email del usuario. Example: <code>admin@admin.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-v2-login"
               value="password"
               data-component="body">
    <br>
<p>Contraseña del usuario. Example: <code>password</code></p>
        </div>
        </form>

                    <h2 id="autenticacion-POSTapi-v2-register">Registrar usuario</h2>

<p>
</p>

<p>Crea una nueva cuenta de usuario en el sistema.</p>

<span id="example-requests-POSTapi-v2-register">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://api-default-laravel.test/api/v2/register" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Juan Pérez\",
    \"email\": \"juan@example.com\",
    \"password\": \"password123\",
    \"password_confirmation\": \"password123\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v2/register"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Juan Pérez",
    "email": "juan@example.com",
    "password": "password123",
    "password_confirmation": "password123"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v2/register';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'Juan Pérez',
            'email' =&gt; 'juan@example.com',
            'password' =&gt; 'password123',
            'password_confirmation' =&gt; 'password123',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v2/register'
payload = {
    "name": "Juan Pérez",
    "email": "juan@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>

</span>

<span id="example-responses-POSTapi-v2-register">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Registro exitoso.&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: 2,
        &quot;name&quot;: &quot;Juan P&eacute;rez&quot;,
        &quot;email&quot;: &quot;juan@example.com&quot;,
        &quot;email_verified_at&quot;: null,
        &quot;created_at&quot;: &quot;2025-10-30T11:00:00.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2025-10-30T11:00:00.000000Z&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;Los datos proporcionados no son v&aacute;lidos.&quot;,
    &quot;data&quot;: {
        &quot;email&quot;: [
            &quot;The email has already been taken.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v2-register" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v2-register"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v2-register"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v2-register" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v2-register">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v2-register" data-method="POST"
      data-path="api/v2/register"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v2-register', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v2-register"
                    onclick="tryItOut('POSTapi-v2-register');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v2-register"
                    onclick="cancelTryOut('POSTapi-v2-register');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v2-register"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v2/register</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v2-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v2-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v2-register"
               value="Juan Pérez"
               data-component="body">
    <br>
<p>Nombre completo del usuario. Example: <code>Juan Pérez</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v2-register"
               value="juan@example.com"
               data-component="body">
    <br>
<p>Email único del usuario. Example: <code>juan@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-v2-register"
               value="password123"
               data-component="body">
    <br>
<p>Contraseña (mínimo 8 caracteres). Example: <code>password123</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password_confirmation</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password_confirmation"                data-endpoint="POSTapi-v2-register"
               value="password123"
               data-component="body">
    <br>
<p>Confirmación de contraseña. Example: <code>password123</code></p>
        </div>
        </form>

                    <h2 id="autenticacion-POSTapi-v2-logout">Cerrar sesión</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Revoca el token actual y cierra la sesión en este dispositivo específico.</p>

<span id="example-requests-POSTapi-v2-logout">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://api-default-laravel.test/api/v2/logout" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v2/logout"
);

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v2/logout';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v2/logout'
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-POSTapi-v2-logout">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Sesi&oacute;n cerrada correctamente&quot;,
    &quot;data&quot;: []
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v2-logout" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v2-logout"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v2-logout"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v2-logout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v2-logout">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v2-logout" data-method="POST"
      data-path="api/v2/logout"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v2-logout', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v2-logout"
                    onclick="tryItOut('POSTapi-v2-logout');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v2-logout"
                    onclick="cancelTryOut('POSTapi-v2-logout');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v2-logout"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v2/logout</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v2-logout"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v2-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v2-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="autenticacion-POSTapi-v2-logout-all-devices">Cerrar sesión en todos los dispositivos</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Revoca TODOS los tokens del usuario, cerrando sesión en todos los dispositivos donde esté autenticado.
Útil para desconectar por seguridad o cambio de contraseña.</p>

<span id="example-requests-POSTapi-v2-logout-all-devices">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://api-default-laravel.test/api/v2/logout-all-devices" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v2/logout-all-devices"
);

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v2/logout-all-devices';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v2/logout-all-devices'
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-POSTapi-v2-logout-all-devices">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Sesi&oacute;n cerrada correctamente&quot;,
    &quot;data&quot;: []
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v2-logout-all-devices" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v2-logout-all-devices"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v2-logout-all-devices"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v2-logout-all-devices" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v2-logout-all-devices">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v2-logout-all-devices" data-method="POST"
      data-path="api/v2/logout-all-devices"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v2-logout-all-devices', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v2-logout-all-devices"
                    onclick="tryItOut('POSTapi-v2-logout-all-devices');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v2-logout-all-devices"
                    onclick="cancelTryOut('POSTapi-v2-logout-all-devices');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v2-logout-all-devices"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v2/logout-all-devices</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v2-logout-all-devices"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v2-logout-all-devices"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v2-logout-all-devices"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                <h1 id="informacion-del-sistema">Información del Sistema</h1>

    <p>Obtiene información detallada sobre la versión 2.0 de la API, incluyendo características,
mejoras respecto a V1 y guías de migración.</p>

                                <h2 id="informacion-del-sistema-GETapi-v2-version">Información de versión API V2</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-v2-version">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://api-default-laravel.test/api/v2/version" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v2/version"
);

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v2/version';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v2/version'
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v2-version">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;api_version&quot;: &quot;2.0&quot;,
    &quot;features&quot;: [
        &quot;repository_pattern&quot;,
        &quot;action_classes&quot;,
        &quot;advanced_resources&quot;
    ],
    &quot;improvements_over_v1&quot;: [
        &quot;Better performance&quot;,
        &quot;Enhanced error handling&quot;
    ],
    &quot;deprecations&quot;: [
        &quot;None - V1 remains fully supported&quot;
    ],
    &quot;migration_guide&quot;: &quot;/docs/v2-migration&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v2-version" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v2-version"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v2-version"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v2-version" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v2-version">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v2-version" data-method="GET"
      data-path="api/v2/version"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v2-version', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v2-version"
                    onclick="tryItOut('GETapi-v2-version');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v2-version"
                    onclick="cancelTryOut('GETapi-v2-version');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v2-version"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v2/version</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v2-version"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v2-version"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v2-version"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="informacion-del-sistema-GETapi-v2-health">Estado de salud de la API</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-v2-health">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://api-default-laravel.test/api/v2/health" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v2/health"
);

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v2/health';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v2/health'
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v2-health">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;healthy&quot;,
    &quot;version&quot;: &quot;2.0&quot;,
    &quot;timestamp&quot;: &quot;2025-10-30T11:00:00.000000Z&quot;,
    &quot;database&quot;: &quot;connected&quot;,
    &quot;cache&quot;: &quot;operational&quot;,
    &quot;features&quot;: &quot;all_systems_operational&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v2-health" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v2-health"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v2-health"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v2-health" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v2-health">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v2-health" data-method="GET"
      data-path="api/v2/health"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v2-health', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v2-health"
                    onclick="tryItOut('GETapi-v2-health');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v2-health"
                    onclick="cancelTryOut('GETapi-v2-health');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v2-health"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v2/health</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v2-health"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v2-health"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v2-health"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                <h1 id="tickets-v1">Tickets (V1)</h1>

    <p>Gestión básica de tickets de soporte con funcionalidades CRUD estándar.
Incluye filtros básicos y paginación. Para funcionalidades avanzadas usar V2.
Todos los endpoints requieren autenticación Bearer token.</p>

                                <h2 id="tickets-v1-GETapi-v1-tickets">Listar tickets</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Obtiene una lista paginada de tickets con filtros básicos.</p>

<span id="example-requests-GETapi-v1-tickets">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://api-default-laravel.test/api/v1/tickets?page=1&amp;filter%5Bstatus%5D=A&amp;filter%5Bpriority%5D=high&amp;filter%5Bauthor_id%5D=1" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v1/tickets"
);

const params = {
    "page": "1",
    "filter[status]": "A",
    "filter[priority]": "high",
    "filter[author_id]": "1",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v1/tickets';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'page' =&gt; '1',
            'filter[status]' =&gt; 'A',
            'filter[priority]' =&gt; 'high',
            'filter[author_id]' =&gt; '1',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v1/tickets'
params = {
  'page': '1',
  'filter[status]': 'A',
  'filter[priority]': 'high',
  'filter[author_id]': '1',
}
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, params=params)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-tickets">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Tickets obtenidos correctamente.&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;title&quot;: &quot;Error en sistema de login&quot;,
            &quot;description&quot;: &quot;Los usuarios no pueden iniciar sesi&oacute;n&quot;,
            &quot;status&quot;: &quot;A&quot;,
            &quot;priority&quot;: &quot;high&quot;,
            &quot;author_id&quot;: 1,
            &quot;created_at&quot;: &quot;2025-10-30T10:00:00.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-30T10:30:00.000000Z&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-tickets" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-tickets"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-tickets"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-tickets" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-tickets">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-tickets" data-method="GET"
      data-path="api/v1/tickets"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-tickets', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-tickets"
                    onclick="tryItOut('GETapi-v1-tickets');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-tickets"
                    onclick="cancelTryOut('GETapi-v1-tickets');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-tickets"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/tickets</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-tickets"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-tickets"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-tickets"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-v1-tickets"
               value="1"
               data-component="query">
    <br>
<p>Número de página para paginación. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>filter[status]</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="filter[status]"                data-endpoint="GETapi-v1-tickets"
               value="A"
               data-component="query">
    <br>
<p>Filtrar por estado. Valores: A(abierto), H(en_progreso), C(cerrado), X(cancelado). Example: <code>A</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>filter[priority]</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="filter[priority]"                data-endpoint="GETapi-v1-tickets"
               value="high"
               data-component="query">
    <br>
<p>Filtrar por prioridad. Valores: low, medium, high, critical. Example: <code>high</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>filter[author_id]</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="filter[author_id]"                data-endpoint="GETapi-v1-tickets"
               value="1"
               data-component="query">
    <br>
<p>Filtrar por ID del autor. Example: <code>1</code></p>
            </div>
                </form>

                    <h2 id="tickets-v1-POSTapi-v1-tickets">Crear ticket</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Crea un nuevo ticket de soporte en el sistema.</p>

<span id="example-requests-POSTapi-v1-tickets">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://api-default-laravel.test/api/v1/tickets" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"data\": {
        \"attributes\": {
            \"title\": \"Error en sistema de login\",
            \"description\": \"Los usuarios no pueden iniciar sesión\",
            \"status\": \"A\",
            \"priority\": \"high\",
            \"internal_notes\": \"architecto\",
            \"view_count\": 39
        },
        \"relationships\": {
            \"author\": {
                \"data\": {
                    \"id\": 16
                }
            }
        },
        \"type\": \"ticket\"
    }
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v1/tickets"
);

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "data": {
        "attributes": {
            "title": "Error en sistema de login",
            "description": "Los usuarios no pueden iniciar sesión",
            "status": "A",
            "priority": "high",
            "internal_notes": "architecto",
            "view_count": 39
        },
        "relationships": {
            "author": {
                "data": {
                    "id": 16
                }
            }
        },
        "type": "ticket"
    }
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v1/tickets';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'data' =&gt; [
                'attributes' =&gt; [
                    'title' =&gt; 'Error en sistema de login',
                    'description' =&gt; 'Los usuarios no pueden iniciar sesión',
                    'status' =&gt; 'A',
                    'priority' =&gt; 'high',
                    'internal_notes' =&gt; 'architecto',
                    'view_count' =&gt; 39,
                ],
                'relationships' =&gt; [
                    'author' =&gt; [
                        'data' =&gt; [
                            'id' =&gt; 16,
                        ],
                    ],
                ],
                'type' =&gt; 'ticket',
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v1/tickets'
payload = {
    "data": {
        "attributes": {
            "title": "Error en sistema de login",
            "description": "Los usuarios no pueden iniciar sesión",
            "status": "A",
            "priority": "high",
            "internal_notes": "architecto",
            "view_count": 39
        },
        "relationships": {
            "author": {
                "data": {
                    "id": 16
                }
            }
        },
        "type": "ticket"
    }
}
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-tickets">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Ticket creado correctamente.&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: 101,
        &quot;title&quot;: &quot;Error en sistema de login&quot;,
        &quot;description&quot;: &quot;Los usuarios no pueden iniciar sesi&oacute;n&quot;,
        &quot;status&quot;: &quot;A&quot;,
        &quot;priority&quot;: &quot;high&quot;,
        &quot;author_id&quot;: 1,
        &quot;created_at&quot;: &quot;2025-10-30T11:00:00.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2025-10-30T11:00:00.000000Z&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;Los datos proporcionados no son v&aacute;lidos.&quot;,
    &quot;data&quot;: {
        &quot;title&quot;: [
            &quot;The title field is required.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-tickets" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-tickets"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-tickets"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-tickets" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-tickets">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-tickets" data-method="POST"
      data-path="api/v1/tickets"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-tickets', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-tickets"
                    onclick="tryItOut('POSTapi-v1-tickets');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-tickets"
                    onclick="cancelTryOut('POSTapi-v1-tickets');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-tickets"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/tickets</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-tickets"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-tickets"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-tickets"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>data</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style=" margin-left: 14px; clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>attributes</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>title</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.title"                data-endpoint="POSTapi-v1-tickets"
               value="Error en sistema de login"
               data-component="body">
    <br>
<p>Título del ticket (máximo 255 caracteres). Example: <code>Error en sistema de login</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.description"                data-endpoint="POSTapi-v1-tickets"
               value="Los usuarios no pueden iniciar sesión"
               data-component="body">
    <br>
<p>Descripción detallada del problema. Example: <code>Los usuarios no pueden iniciar sesión</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.status"                data-endpoint="POSTapi-v1-tickets"
               value="A"
               data-component="body">
    <br>
<p>Estado inicial (opcional, por defecto 'A'). Valores: A, H, C, X. Example: <code>A</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>priority</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.priority"                data-endpoint="POSTapi-v1-tickets"
               value="high"
               data-component="body">
    <br>
<p>Prioridad del ticket. Valores: low, medium, high, critical. Example: <code>high</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>internal_notes</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.internal_notes"                data-endpoint="POSTapi-v1-tickets"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>view_count</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="data.attributes.view_count"                data-endpoint="POSTapi-v1-tickets"
               value="39"
               data-component="body">
    <br>
<p>validation.min. Example: <code>39</code></p>
                    </div>
                                    </details>
        </div>
                                                                    <div style=" margin-left: 14px; clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>relationships</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style=" margin-left: 28px; clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>author</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style=" margin-left: 42px; clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>data</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 56px; clear: unset;">
                        <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="data.relationships.author.data.id"                data-endpoint="POSTapi-v1-tickets"
               value="16"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the users table. Example: <code>16</code></p>
                    </div>
                                    </details>
        </div>
                                        </details>
        </div>
                                        </details>
        </div>
                                                                    <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.type"                data-endpoint="POSTapi-v1-tickets"
               value="ticket"
               data-component="body">
    <br>
<p>Tipo del recurso. Debe ser &quot;ticket&quot;. Example: <code>ticket</code></p>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="tickets-v1-GETapi-v1-tickets--id-">Mostrar ticket</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Obtiene un ticket específico por su ID.</p>

<span id="example-requests-GETapi-v1-tickets--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://api-default-laravel.test/api/v1/tickets/architecto" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v1/tickets/architecto"
);

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v1/tickets/architecto';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v1/tickets/architecto'
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-tickets--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Ticket obtenido correctamente.&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;title&quot;: &quot;Error en sistema de login&quot;,
        &quot;description&quot;: &quot;Los usuarios no pueden iniciar sesi&oacute;n&quot;,
        &quot;status&quot;: &quot;A&quot;,
        &quot;priority&quot;: &quot;high&quot;,
        &quot;author_id&quot;: 1,
        &quot;created_at&quot;: &quot;2025-10-30T10:00:00.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2025-10-30T10:30:00.000000Z&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;El recurso Ticket solicitado no fue encontrado.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-tickets--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-tickets--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-tickets--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-tickets--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-tickets--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-tickets--id-" data-method="GET"
      data-path="api/v1/tickets/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-tickets--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-tickets--id-"
                    onclick="tryItOut('GETapi-v1-tickets--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-tickets--id-"
                    onclick="cancelTryOut('GETapi-v1-tickets--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-tickets--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/tickets/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-tickets--id-"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-tickets--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-tickets--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="GETapi-v1-tickets--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the ticket. Example: <code>architecto</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>ticket</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="ticket"                data-endpoint="GETapi-v1-tickets--id-"
               value="1"
               data-component="url">
    <br>
<p>ID del ticket. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="tickets-v1-PUTapi-v1-tickets--id-">Actualizar ticket</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Actualiza un ticket existente en el sistema.</p>

<span id="example-requests-PUTapi-v1-tickets--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://api-default-laravel.test/api/v1/tickets/architecto" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"data\": {
        \"attributes\": {
            \"title\": \"Error en sistema de login (solucionado)\",
            \"description\": \"Error solucionado mediante actualización\",
            \"status\": \"C\",
            \"priority\": \"medium\",
            \"internal_notes\": \"architecto\",
            \"view_count\": 39
        },
        \"relationships\": {
            \"author\": {
                \"data\": {
                    \"id\": 16
                }
            }
        },
        \"type\": \"ticket\"
    }
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v1/tickets/architecto"
);

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "data": {
        "attributes": {
            "title": "Error en sistema de login (solucionado)",
            "description": "Error solucionado mediante actualización",
            "status": "C",
            "priority": "medium",
            "internal_notes": "architecto",
            "view_count": 39
        },
        "relationships": {
            "author": {
                "data": {
                    "id": 16
                }
            }
        },
        "type": "ticket"
    }
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v1/tickets/architecto';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'data' =&gt; [
                'attributes' =&gt; [
                    'title' =&gt; 'Error en sistema de login (solucionado)',
                    'description' =&gt; 'Error solucionado mediante actualización',
                    'status' =&gt; 'C',
                    'priority' =&gt; 'medium',
                    'internal_notes' =&gt; 'architecto',
                    'view_count' =&gt; 39,
                ],
                'relationships' =&gt; [
                    'author' =&gt; [
                        'data' =&gt; [
                            'id' =&gt; 16,
                        ],
                    ],
                ],
                'type' =&gt; 'ticket',
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v1/tickets/architecto'
payload = {
    "data": {
        "attributes": {
            "title": "Error en sistema de login (solucionado)",
            "description": "Error solucionado mediante actualización",
            "status": "C",
            "priority": "medium",
            "internal_notes": "architecto",
            "view_count": 39
        },
        "relationships": {
            "author": {
                "data": {
                    "id": 16
                }
            }
        },
        "type": "ticket"
    }
}
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('PUT', url, headers=headers, json=payload)
response.json()</code></pre></div>

</span>

<span id="example-responses-PUTapi-v1-tickets--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Ticket actualizado correctamente.&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;title&quot;: &quot;Error en sistema de login (solucionado)&quot;,
        &quot;description&quot;: &quot;Error solucionado mediante actualizaci&oacute;n&quot;,
        &quot;status&quot;: &quot;C&quot;,
        &quot;priority&quot;: &quot;medium&quot;,
        &quot;author_id&quot;: 1,
        &quot;created_at&quot;: &quot;2025-10-30T10:00:00.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2025-10-30T11:30:00.000000Z&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;El recurso Ticket solicitado no fue encontrado.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;Los datos proporcionados no son v&aacute;lidos.&quot;,
    &quot;data&quot;: {
        &quot;status&quot;: [
            &quot;The selected status is invalid.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-PUTapi-v1-tickets--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-v1-tickets--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-v1-tickets--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-v1-tickets--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-v1-tickets--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-v1-tickets--id-" data-method="PUT"
      data-path="api/v1/tickets/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-v1-tickets--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-v1-tickets--id-"
                    onclick="tryItOut('PUTapi-v1-tickets--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-v1-tickets--id-"
                    onclick="cancelTryOut('PUTapi-v1-tickets--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-v1-tickets--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/v1/tickets/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/v1/tickets/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PUTapi-v1-tickets--id-"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-v1-tickets--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-v1-tickets--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="PUTapi-v1-tickets--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the ticket. Example: <code>architecto</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>ticket</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="ticket"                data-endpoint="PUTapi-v1-tickets--id-"
               value="1"
               data-component="url">
    <br>
<p>ID del ticket. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>data</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style=" margin-left: 14px; clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>attributes</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>title</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.title"                data-endpoint="PUTapi-v1-tickets--id-"
               value="Error en sistema de login (solucionado)"
               data-component="body">
    <br>
<p>Título del ticket. Example: <code>Error en sistema de login (solucionado)</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.description"                data-endpoint="PUTapi-v1-tickets--id-"
               value="Error solucionado mediante actualización"
               data-component="body">
    <br>
<p>Descripción del problema. Example: <code>Error solucionado mediante actualización</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.status"                data-endpoint="PUTapi-v1-tickets--id-"
               value="C"
               data-component="body">
    <br>
<p>Estado del ticket. Valores: A, H, C, X. Example: <code>C</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>priority</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.priority"                data-endpoint="PUTapi-v1-tickets--id-"
               value="medium"
               data-component="body">
    <br>
<p>Prioridad. Valores: low, medium, high, critical. Example: <code>medium</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>internal_notes</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.internal_notes"                data-endpoint="PUTapi-v1-tickets--id-"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>view_count</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="data.attributes.view_count"                data-endpoint="PUTapi-v1-tickets--id-"
               value="39"
               data-component="body">
    <br>
<p>validation.min. Example: <code>39</code></p>
                    </div>
                                    </details>
        </div>
                                                                    <div style=" margin-left: 14px; clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>relationships</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style=" margin-left: 28px; clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>author</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style=" margin-left: 42px; clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>data</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 56px; clear: unset;">
                        <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="data.relationships.author.data.id"                data-endpoint="PUTapi-v1-tickets--id-"
               value="16"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the users table. Example: <code>16</code></p>
                    </div>
                                    </details>
        </div>
                                        </details>
        </div>
                                        </details>
        </div>
                                                                    <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.type"                data-endpoint="PUTapi-v1-tickets--id-"
               value="ticket"
               data-component="body">
    <br>
<p>Tipo del recurso. Debe ser &quot;ticket&quot;. Example: <code>ticket</code></p>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="tickets-v1-DELETEapi-v1-tickets--id-">Eliminar ticket</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Elimina un ticket del sistema de forma permanente.</p>

<span id="example-requests-DELETEapi-v1-tickets--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://api-default-laravel.test/api/v1/tickets/architecto" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v1/tickets/architecto"
);

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v1/tickets/architecto';
$response = $client-&gt;delete(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v1/tickets/architecto'
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('DELETE', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v1-tickets--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;El ticket ha sido eliminado correctamente.&quot;,
    &quot;data&quot;: null
}</code>
 </pre>
            <blockquote>
            <p>Example response (403):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;No tienes permisos para realizar esta acci&oacute;n.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;El recurso Ticket solicitado no fue encontrado.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-v1-tickets--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v1-tickets--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v1-tickets--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-v1-tickets--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v1-tickets--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-v1-tickets--id-" data-method="DELETE"
      data-path="api/v1/tickets/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v1-tickets--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v1-tickets--id-"
                    onclick="tryItOut('DELETEapi-v1-tickets--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v1-tickets--id-"
                    onclick="cancelTryOut('DELETEapi-v1-tickets--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v1-tickets--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v1/tickets/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-v1-tickets--id-"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-v1-tickets--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-v1-tickets--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="DELETEapi-v1-tickets--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the ticket. Example: <code>architecto</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>ticket</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="ticket"                data-endpoint="DELETEapi-v1-tickets--id-"
               value="1"
               data-component="url">
    <br>
<p>ID del ticket. Example: <code>1</code></p>
            </div>
                    </form>

                <h1 id="tickets-v2">Tickets (V2)</h1>

    <p>Gestión completa de tickets de soporte con funcionalidades avanzadas como filtros, búsqueda,
estadísticas y gestión de relaciones. Incluye arquitectura mejorada con Actions y Repository Pattern.
Todos los endpoints requieren autenticación Bearer token.</p>

                                <h2 id="tickets-v2-GETapi-v2-tickets">Listar tickets</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Obtiene una lista paginada de tickets con filtros avanzados, búsqueda por texto y ordenamiento.
Soporta inclusión de relaciones como autor y comentarios.</p>

<span id="example-requests-GETapi-v2-tickets">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://api-default-laravel.test/api/v2/tickets?page=1&amp;per_page=15&amp;search=bug&amp;sort=created_at&amp;direction=desc&amp;include=author%2Ccomments&amp;filter%5Bstatus%5D=A&amp;filter%5Bpriority%5D=high&amp;filter%5Bauthor_id%5D=1" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v2/tickets"
);

const params = {
    "page": "1",
    "per_page": "15",
    "search": "bug",
    "sort": "created_at",
    "direction": "desc",
    "include": "author,comments",
    "filter[status]": "A",
    "filter[priority]": "high",
    "filter[author_id]": "1",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v2/tickets';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'page' =&gt; '1',
            'per_page' =&gt; '15',
            'search' =&gt; 'bug',
            'sort' =&gt; 'created_at',
            'direction' =&gt; 'desc',
            'include' =&gt; 'author,comments',
            'filter[status]' =&gt; 'A',
            'filter[priority]' =&gt; 'high',
            'filter[author_id]' =&gt; '1',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v2/tickets'
params = {
  'page': '1',
  'per_page': '15',
  'search': 'bug',
  'sort': 'created_at',
  'direction': 'desc',
  'include': 'author,comments',
  'filter[status]': 'A',
  'filter[priority]': 'high',
  'filter[author_id]': '1',
}
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, params=params)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v2-tickets">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Tickets obtenidos correctamente.&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: &quot;1&quot;,
            &quot;type&quot;: &quot;ticket&quot;,
            &quot;attributes&quot;: {
                &quot;title&quot;: &quot;Error en sistema de login&quot;,
                &quot;description&quot;: &quot;Los usuarios no pueden iniciar sesi&oacute;n despu&eacute;s de la actualizaci&oacute;n&quot;,
                &quot;status&quot;: &quot;A&quot;,
                &quot;priority&quot;: &quot;high&quot;,
                &quot;view_count&quot;: 15,
                &quot;created_at&quot;: &quot;2025-10-30T10:00:00.000000Z&quot;,
                &quot;updated_at&quot;: &quot;2025-10-30T10:30:00.000000Z&quot;,
                &quot;days_open&quot;: 0.5,
                &quot;is_overdue&quot;: false,
                &quot;internal_notes&quot;: &quot;Revisado por equipo t&eacute;cnico&quot;
            },
            &quot;relationships&quot;: {
                &quot;author&quot;: {
                    &quot;links&quot;: {
                        &quot;self&quot;: &quot;http://api-default-laravel.test/api/v2/tickets/1/relationships/author&quot;,
                        &quot;related&quot;: &quot;http://api-default-laravel.test/api/v2/tickets/1/author&quot;
                    }
                }
            },
            &quot;meta&quot;: {
                &quot;version&quot;: &quot;2.0&quot;,
                &quot;cached_at&quot;: &quot;2025-10-30T11:00:00.000000Z&quot;
            }
        }
    ],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http://api-default-laravel.test/api/v2/tickets?page=1&quot;,
        &quot;last&quot;: &quot;http://api-default-laravel.test/api/v2/tickets?page=10&quot;,
        &quot;next&quot;: &quot;http://api-default-laravel.test/api/v2/tickets?page=2&quot;
    },
    &quot;meta&quot;: {
        &quot;total_tickets&quot;: 150,
        &quot;filters_applied&quot;: {
            &quot;status&quot;: &quot;A&quot;,
            &quot;priority&quot;: &quot;high&quot;
        },
        &quot;includes&quot;: [
            &quot;author&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v2-tickets" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v2-tickets"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v2-tickets"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v2-tickets" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v2-tickets">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v2-tickets" data-method="GET"
      data-path="api/v2/tickets"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v2-tickets', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v2-tickets"
                    onclick="tryItOut('GETapi-v2-tickets');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v2-tickets"
                    onclick="cancelTryOut('GETapi-v2-tickets');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v2-tickets"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v2/tickets</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v2-tickets"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v2-tickets"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v2-tickets"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-v2-tickets"
               value="1"
               data-component="query">
    <br>
<p>Número de página para paginación. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-v2-tickets"
               value="15"
               data-component="query">
    <br>
<p>Elementos por página (máximo 100). Example: <code>15</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-v2-tickets"
               value="bug"
               data-component="query">
    <br>
<p>Búsqueda en título y descripción. Example: <code>bug</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort"                data-endpoint="GETapi-v2-tickets"
               value="created_at"
               data-component="query">
    <br>
<p>Campo de ordenamiento. Valores: title, status, priority, created_at, updated_at. Example: <code>created_at</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>direction</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="direction"                data-endpoint="GETapi-v2-tickets"
               value="desc"
               data-component="query">
    <br>
<p>Dirección del ordenamiento. Valores: asc, desc. Example: <code>desc</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>include</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="include"                data-endpoint="GETapi-v2-tickets"
               value="author,comments"
               data-component="query">
    <br>
<p>Relaciones a incluir. Valores: author, user, comments. Example: <code>author,comments</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>filter[status]</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="filter[status]"                data-endpoint="GETapi-v2-tickets"
               value="A"
               data-component="query">
    <br>
<p>Filtrar por estado. Valores: A(abierto), H(en_progreso), C(cerrado), X(cancelado). Example: <code>A</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>filter[priority]</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="filter[priority]"                data-endpoint="GETapi-v2-tickets"
               value="high"
               data-component="query">
    <br>
<p>Filtrar por prioridad. Valores: low, medium, high, critical. Example: <code>high</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>filter[author_id]</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="filter[author_id]"                data-endpoint="GETapi-v2-tickets"
               value="1"
               data-component="query">
    <br>
<p>Filtrar por ID del autor. Example: <code>1</code></p>
            </div>
                </form>

                    <h2 id="tickets-v2-POSTapi-v2-tickets">Crear ticket</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Crea un nuevo ticket de soporte en el sistema usando Action Pattern para lógica de negocio.
El ticket se asigna automáticamente al usuario autenticado como autor.</p>

<span id="example-requests-POSTapi-v2-tickets">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://api-default-laravel.test/api/v2/tickets" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"data\": {
        \"attributes\": {
            \"title\": \"Error en sistema de login\",
            \"description\": \"Los usuarios no pueden iniciar sesión después de la actualización del sistema\",
            \"status\": \"A\",
            \"priority\": \"high\",
            \"internal_notes\": \"Revisado por equipo técnico\",
            \"view_count\": 39
        },
        \"relationships\": {
            \"author\": {
                \"data\": {
                    \"id\": 16
                }
            }
        },
        \"type\": \"ticket\"
    }
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v2/tickets"
);

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "data": {
        "attributes": {
            "title": "Error en sistema de login",
            "description": "Los usuarios no pueden iniciar sesión después de la actualización del sistema",
            "status": "A",
            "priority": "high",
            "internal_notes": "Revisado por equipo técnico",
            "view_count": 39
        },
        "relationships": {
            "author": {
                "data": {
                    "id": 16
                }
            }
        },
        "type": "ticket"
    }
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v2/tickets';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'data' =&gt; [
                'attributes' =&gt; [
                    'title' =&gt; 'Error en sistema de login',
                    'description' =&gt; 'Los usuarios no pueden iniciar sesión después de la actualización del sistema',
                    'status' =&gt; 'A',
                    'priority' =&gt; 'high',
                    'internal_notes' =&gt; 'Revisado por equipo técnico',
                    'view_count' =&gt; 39,
                ],
                'relationships' =&gt; [
                    'author' =&gt; [
                        'data' =&gt; [
                            'id' =&gt; 16,
                        ],
                    ],
                ],
                'type' =&gt; 'ticket',
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v2/tickets'
payload = {
    "data": {
        "attributes": {
            "title": "Error en sistema de login",
            "description": "Los usuarios no pueden iniciar sesión después de la actualización del sistema",
            "status": "A",
            "priority": "high",
            "internal_notes": "Revisado por equipo técnico",
            "view_count": 39
        },
        "relationships": {
            "author": {
                "data": {
                    "id": 16
                }
            }
        },
        "type": "ticket"
    }
}
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>

</span>

<span id="example-responses-POSTapi-v2-tickets">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Ticket creado correctamente.&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: &quot;151&quot;,
        &quot;type&quot;: &quot;ticket&quot;,
        &quot;attributes&quot;: {
            &quot;title&quot;: &quot;Error en sistema de login&quot;,
            &quot;description&quot;: &quot;Los usuarios no pueden iniciar sesi&oacute;n despu&eacute;s de la actualizaci&oacute;n del sistema&quot;,
            &quot;status&quot;: &quot;A&quot;,
            &quot;priority&quot;: &quot;high&quot;,
            &quot;view_count&quot;: 0,
            &quot;created_at&quot;: &quot;2025-10-30T11:00:00.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-30T11:00:00.000000Z&quot;,
            &quot;days_open&quot;: 0,
            &quot;is_overdue&quot;: false,
            &quot;internal_notes&quot;: &quot;Revisado por equipo t&eacute;cnico&quot;
        },
        &quot;relationships&quot;: {
            &quot;author&quot;: {
                &quot;links&quot;: {
                    &quot;self&quot;: &quot;http://api-default-laravel.test/api/v2/tickets/151/relationships/author&quot;,
                    &quot;related&quot;: &quot;http://api-default-laravel.test/api/v2/tickets/151/author&quot;
                }
            }
        },
        &quot;meta&quot;: {
            &quot;version&quot;: &quot;2.0&quot;,
            &quot;cached_at&quot;: &quot;2025-10-30T11:00:00.000000Z&quot;
        }
    },
    &quot;meta&quot;: {
        &quot;created_via&quot;: &quot;api_v2&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;Los datos proporcionados no son v&aacute;lidos.&quot;,
    &quot;data&quot;: {
        &quot;title&quot;: [
            &quot;The title field is required.&quot;
        ],
        &quot;priority&quot;: [
            &quot;The selected priority is invalid.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v2-tickets" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v2-tickets"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v2-tickets"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v2-tickets" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v2-tickets">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v2-tickets" data-method="POST"
      data-path="api/v2/tickets"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v2-tickets', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v2-tickets"
                    onclick="tryItOut('POSTapi-v2-tickets');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v2-tickets"
                    onclick="cancelTryOut('POSTapi-v2-tickets');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v2-tickets"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v2/tickets</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v2-tickets"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v2-tickets"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v2-tickets"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>data</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style=" margin-left: 14px; clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>attributes</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>title</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.title"                data-endpoint="POSTapi-v2-tickets"
               value="Error en sistema de login"
               data-component="body">
    <br>
<p>Título del ticket (máximo 255 caracteres). Example: <code>Error en sistema de login</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.description"                data-endpoint="POSTapi-v2-tickets"
               value="Los usuarios no pueden iniciar sesión después de la actualización del sistema"
               data-component="body">
    <br>
<p>Descripción detallada del problema. Example: <code>Los usuarios no pueden iniciar sesión después de la actualización del sistema</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.status"                data-endpoint="POSTapi-v2-tickets"
               value="A"
               data-component="body">
    <br>
<p>Estado inicial del ticket (opcional, por defecto 'A'). Valores: A, H, C, X. Example: <code>A</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>priority</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.priority"                data-endpoint="POSTapi-v2-tickets"
               value="high"
               data-component="body">
    <br>
<p>Prioridad del ticket. Valores: low, medium, high, critical. Example: <code>high</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>internal_notes</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.internal_notes"                data-endpoint="POSTapi-v2-tickets"
               value="Revisado por equipo técnico"
               data-component="body">
    <br>
<p>Notas internas del ticket (opcional). Example: <code>Revisado por equipo técnico</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>view_count</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="data.attributes.view_count"                data-endpoint="POSTapi-v2-tickets"
               value="39"
               data-component="body">
    <br>
<p>validation.min. Example: <code>39</code></p>
                    </div>
                                    </details>
        </div>
                                                                    <div style=" margin-left: 14px; clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>relationships</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style=" margin-left: 28px; clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>author</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style=" margin-left: 42px; clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>data</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 56px; clear: unset;">
                        <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="data.relationships.author.data.id"                data-endpoint="POSTapi-v2-tickets"
               value="16"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the users table. Example: <code>16</code></p>
                    </div>
                                    </details>
        </div>
                                        </details>
        </div>
                                        </details>
        </div>
                                                                    <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.type"                data-endpoint="POSTapi-v2-tickets"
               value="ticket"
               data-component="body">
    <br>
<p>Tipo del recurso. Debe ser &quot;ticket&quot;. Example: <code>ticket</code></p>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="tickets-v2-GETapi-v2-tickets--id-">Mostrar ticket</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Obtiene un ticket específico con relaciones optimizadas e incremento automático de vistas.</p>

<span id="example-requests-GETapi-v2-tickets--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://api-default-laravel.test/api/v2/tickets/architecto?include=user%2Ccomments" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v2/tickets/architecto"
);

const params = {
    "include": "user,comments",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v2/tickets/architecto';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'include' =&gt; 'user,comments',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v2/tickets/architecto'
params = {
  'include': 'user,comments',
}
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, params=params)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v2-tickets--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Ticket obtenido correctamente.&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: &quot;1&quot;,
        &quot;type&quot;: &quot;ticket&quot;,
        &quot;attributes&quot;: {
            &quot;title&quot;: &quot;Error en sistema de login&quot;,
            &quot;description&quot;: &quot;Los usuarios no pueden iniciar sesi&oacute;n despu&eacute;s de la actualizaci&oacute;n&quot;,
            &quot;status&quot;: &quot;A&quot;,
            &quot;priority&quot;: &quot;high&quot;,
            &quot;view_count&quot;: 16,
            &quot;created_at&quot;: &quot;2025-10-30T10:00:00.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-30T10:30:00.000000Z&quot;,
            &quot;days_open&quot;: 0.5,
            &quot;is_overdue&quot;: false,
            &quot;internal_notes&quot;: &quot;Revisado por equipo t&eacute;cnico&quot;
        },
        &quot;relationships&quot;: {
            &quot;author&quot;: {
                &quot;links&quot;: {
                    &quot;self&quot;: &quot;http://api-default-laravel.test/api/v2/tickets/1/relationships/author&quot;,
                    &quot;related&quot;: &quot;http://api-default-laravel.test/api/v2/tickets/1/author&quot;
                }
            }
        },
        &quot;meta&quot;: {
            &quot;version&quot;: &quot;2.0&quot;,
            &quot;cached_at&quot;: &quot;2025-10-30T11:00:00.000000Z&quot;,
            &quot;view_incremented&quot;: true
        }
    },
    &quot;meta&quot;: {
        &quot;includes&quot;: [
            &quot;user&quot;
        ]
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;El recurso Ticket solicitado no fue encontrado.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v2-tickets--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v2-tickets--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v2-tickets--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v2-tickets--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v2-tickets--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v2-tickets--id-" data-method="GET"
      data-path="api/v2/tickets/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v2-tickets--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v2-tickets--id-"
                    onclick="tryItOut('GETapi-v2-tickets--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v2-tickets--id-"
                    onclick="cancelTryOut('GETapi-v2-tickets--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v2-tickets--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v2/tickets/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v2-tickets--id-"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v2-tickets--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v2-tickets--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="GETapi-v2-tickets--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the ticket. Example: <code>architecto</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>ticket</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="ticket"                data-endpoint="GETapi-v2-tickets--id-"
               value="1"
               data-component="url">
    <br>
<p>ID del ticket. Example: <code>1</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>include</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="include"                data-endpoint="GETapi-v2-tickets--id-"
               value="user,comments"
               data-component="query">
    <br>
<p>Relaciones a incluir. Valores: user, comments. Example: <code>user,comments</code></p>
            </div>
                </form>

                    <h2 id="tickets-v2-PUTapi-v2-tickets--id-">Actualizar ticket</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Actualiza un ticket existente usando Action Pattern con validaciones y logging.</p>

<span id="example-requests-PUTapi-v2-tickets--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://api-default-laravel.test/api/v2/tickets/architecto" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"data\": {
        \"attributes\": {
            \"title\": \"Error en sistema de login (solucionado)\",
            \"description\": \"Error solucionado mediante actualización\",
            \"status\": \"C\",
            \"priority\": \"medium\",
            \"internal_notes\": \"Solucionado por el equipo técnico\",
            \"view_count\": 39
        },
        \"relationships\": {
            \"author\": {
                \"data\": {
                    \"id\": 16
                }
            }
        },
        \"type\": \"ticket\"
    }
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v2/tickets/architecto"
);

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "data": {
        "attributes": {
            "title": "Error en sistema de login (solucionado)",
            "description": "Error solucionado mediante actualización",
            "status": "C",
            "priority": "medium",
            "internal_notes": "Solucionado por el equipo técnico",
            "view_count": 39
        },
        "relationships": {
            "author": {
                "data": {
                    "id": 16
                }
            }
        },
        "type": "ticket"
    }
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v2/tickets/architecto';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'data' =&gt; [
                'attributes' =&gt; [
                    'title' =&gt; 'Error en sistema de login (solucionado)',
                    'description' =&gt; 'Error solucionado mediante actualización',
                    'status' =&gt; 'C',
                    'priority' =&gt; 'medium',
                    'internal_notes' =&gt; 'Solucionado por el equipo técnico',
                    'view_count' =&gt; 39,
                ],
                'relationships' =&gt; [
                    'author' =&gt; [
                        'data' =&gt; [
                            'id' =&gt; 16,
                        ],
                    ],
                ],
                'type' =&gt; 'ticket',
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v2/tickets/architecto'
payload = {
    "data": {
        "attributes": {
            "title": "Error en sistema de login (solucionado)",
            "description": "Error solucionado mediante actualización",
            "status": "C",
            "priority": "medium",
            "internal_notes": "Solucionado por el equipo técnico",
            "view_count": 39
        },
        "relationships": {
            "author": {
                "data": {
                    "id": 16
                }
            }
        },
        "type": "ticket"
    }
}
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('PUT', url, headers=headers, json=payload)
response.json()</code></pre></div>

</span>

<span id="example-responses-PUTapi-v2-tickets--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Ticket actualizado correctamente.&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: &quot;1&quot;,
        &quot;type&quot;: &quot;ticket&quot;,
        &quot;attributes&quot;: {
            &quot;title&quot;: &quot;Error en sistema de login (solucionado)&quot;,
            &quot;description&quot;: &quot;Error solucionado mediante actualizaci&oacute;n&quot;,
            &quot;status&quot;: &quot;C&quot;,
            &quot;priority&quot;: &quot;medium&quot;,
            &quot;view_count&quot;: 16,
            &quot;created_at&quot;: &quot;2025-10-30T10:00:00.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-30T11:30:00.000000Z&quot;,
            &quot;days_open&quot;: 1.5,
            &quot;is_overdue&quot;: false,
            &quot;internal_notes&quot;: &quot;Solucionado por el equipo t&eacute;cnico&quot;
        },
        &quot;meta&quot;: {
            &quot;version&quot;: &quot;2.0&quot;,
            &quot;cached_at&quot;: &quot;2025-10-30T11:30:00.000000Z&quot;
        }
    },
    &quot;meta&quot;: {
        &quot;updated_via&quot;: &quot;api_v2&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;El recurso Ticket solicitado no fue encontrado.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;Los datos proporcionados no son v&aacute;lidos.&quot;,
    &quot;data&quot;: {
        &quot;status&quot;: [
            &quot;The selected status is invalid.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-PUTapi-v2-tickets--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-v2-tickets--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-v2-tickets--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-v2-tickets--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-v2-tickets--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-v2-tickets--id-" data-method="PUT"
      data-path="api/v2/tickets/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-v2-tickets--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-v2-tickets--id-"
                    onclick="tryItOut('PUTapi-v2-tickets--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-v2-tickets--id-"
                    onclick="cancelTryOut('PUTapi-v2-tickets--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-v2-tickets--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/v2/tickets/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/v2/tickets/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PUTapi-v2-tickets--id-"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-v2-tickets--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-v2-tickets--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="PUTapi-v2-tickets--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the ticket. Example: <code>architecto</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>ticket</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="ticket"                data-endpoint="PUTapi-v2-tickets--id-"
               value="1"
               data-component="url">
    <br>
<p>ID del ticket. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>data</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style=" margin-left: 14px; clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>attributes</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>title</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.title"                data-endpoint="PUTapi-v2-tickets--id-"
               value="Error en sistema de login (solucionado)"
               data-component="body">
    <br>
<p>Título del ticket. Example: <code>Error en sistema de login (solucionado)</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.description"                data-endpoint="PUTapi-v2-tickets--id-"
               value="Error solucionado mediante actualización"
               data-component="body">
    <br>
<p>Descripción del problema. Example: <code>Error solucionado mediante actualización</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.status"                data-endpoint="PUTapi-v2-tickets--id-"
               value="C"
               data-component="body">
    <br>
<p>Estado del ticket. Valores: A, H, C, X. Example: <code>C</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>priority</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.priority"                data-endpoint="PUTapi-v2-tickets--id-"
               value="medium"
               data-component="body">
    <br>
<p>Prioridad. Valores: low, medium, high, critical. Example: <code>medium</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>internal_notes</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.internal_notes"                data-endpoint="PUTapi-v2-tickets--id-"
               value="Solucionado por el equipo técnico"
               data-component="body">
    <br>
<p>Notas internas del ticket. Example: <code>Solucionado por el equipo técnico</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>view_count</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="data.attributes.view_count"                data-endpoint="PUTapi-v2-tickets--id-"
               value="39"
               data-component="body">
    <br>
<p>validation.min. Example: <code>39</code></p>
                    </div>
                                    </details>
        </div>
                                                                    <div style=" margin-left: 14px; clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>relationships</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style=" margin-left: 28px; clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>author</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style=" margin-left: 42px; clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>data</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 56px; clear: unset;">
                        <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="data.relationships.author.data.id"                data-endpoint="PUTapi-v2-tickets--id-"
               value="16"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the users table. Example: <code>16</code></p>
                    </div>
                                    </details>
        </div>
                                        </details>
        </div>
                                        </details>
        </div>
                                                                    <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.type"                data-endpoint="PUTapi-v2-tickets--id-"
               value="ticket"
               data-component="body">
    <br>
<p>Tipo del recurso. Debe ser &quot;ticket&quot;. Example: <code>ticket</code></p>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="tickets-v2-DELETEapi-v2-tickets--id-">Eliminar ticket</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Elimina un ticket del sistema con logging de auditoría mejorado.</p>

<span id="example-requests-DELETEapi-v2-tickets--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://api-default-laravel.test/api/v2/tickets/architecto" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v2/tickets/architecto"
);

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v2/tickets/architecto';
$response = $client-&gt;delete(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v2/tickets/architecto'
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('DELETE', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v2-tickets--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Ticket eliminado correctamente.&quot;,
    &quot;data&quot;: null,
    &quot;meta&quot;: {
        &quot;deleted_via&quot;: &quot;api_v2&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (403):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;No tienes permisos para realizar esta acci&oacute;n.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;El recurso Ticket solicitado no fue encontrado.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-v2-tickets--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v2-tickets--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v2-tickets--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-v2-tickets--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v2-tickets--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-v2-tickets--id-" data-method="DELETE"
      data-path="api/v2/tickets/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v2-tickets--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v2-tickets--id-"
                    onclick="tryItOut('DELETEapi-v2-tickets--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v2-tickets--id-"
                    onclick="cancelTryOut('DELETEapi-v2-tickets--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v2-tickets--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v2/tickets/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-v2-tickets--id-"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-v2-tickets--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-v2-tickets--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="DELETEapi-v2-tickets--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the ticket. Example: <code>architecto</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>ticket</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="ticket"                data-endpoint="DELETEapi-v2-tickets--id-"
               value="1"
               data-component="url">
    <br>
<p>ID del ticket. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="tickets-v2-GETapi-v2-tickets-statistics">Estadísticas de tickets</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Obtiene estadísticas completas del sistema de tickets incluyendo distribución por estado,
prioridad, tendencias temporales y métricas de rendimiento.</p>

<span id="example-requests-GETapi-v2-tickets-statistics">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://api-default-laravel.test/api/v2/tickets-statistics?period=month&amp;include_trends=1" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v2/tickets-statistics"
);

const params = {
    "period": "month",
    "include_trends": "1",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v2/tickets-statistics';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'period' =&gt; 'month',
            'include_trends' =&gt; '1',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v2/tickets-statistics'
params = {
  'period': 'month',
  'include_trends': '1',
}
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, params=params)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v2-tickets-statistics">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Estad&iacute;sticas de tickets obtenidas correctamente.&quot;,
    &quot;data&quot;: {
        &quot;totals&quot;: {
            &quot;total_tickets&quot;: 500,
            &quot;open_tickets&quot;: 125,
            &quot;closed_tickets&quot;: 350,
            &quot;overdue_tickets&quot;: 15
        },
        &quot;status_distribution&quot;: {
            &quot;active&quot;: 125,
            &quot;closed&quot;: 350,
            &quot;pending&quot;: 20,
            &quot;cancelled&quot;: 5
        },
        &quot;priority_distribution&quot;: {
            &quot;low&quot;: 150,
            &quot;medium&quot;: 200,
            &quot;high&quot;: 120,
            &quot;critical&quot;: 30
        },
        &quot;performance_metrics&quot;: {
            &quot;average_resolution_time&quot;: &quot;2.5 days&quot;,
            &quot;most_active_authors&quot;: [
                {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: &quot;Admin User&quot;,
                    &quot;tickets_count&quot;: 45
                },
                {
                    &quot;id&quot;: 5,
                    &quot;name&quot;: &quot;Support Team&quot;,
                    &quot;tickets_count&quot;: 32
                }
            ],
            &quot;peak_hours&quot;: {
                &quot;busiest_hour&quot;: 14,
                &quot;tickets_created_peak&quot;: 25
            }
        },
        &quot;trends&quot;: {
            &quot;period&quot;: &quot;month&quot;,
            &quot;created_last_period&quot;: 80,
            &quot;resolved_last_period&quot;: 75,
            &quot;growth_rate&quot;: &quot;6.7%&quot;
        }
    },
    &quot;meta&quot;: {
        &quot;generated_at&quot;: &quot;2025-10-30T11:00:00.000000Z&quot;,
        &quot;cache_ttl&quot;: 300,
        &quot;api_version&quot;: &quot;2.0&quot;
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v2-tickets-statistics" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v2-tickets-statistics"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v2-tickets-statistics"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v2-tickets-statistics" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v2-tickets-statistics">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v2-tickets-statistics" data-method="GET"
      data-path="api/v2/tickets-statistics"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v2-tickets-statistics', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v2-tickets-statistics"
                    onclick="tryItOut('GETapi-v2-tickets-statistics');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v2-tickets-statistics"
                    onclick="cancelTryOut('GETapi-v2-tickets-statistics');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v2-tickets-statistics"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v2/tickets-statistics</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v2-tickets-statistics"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v2-tickets-statistics"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v2-tickets-statistics"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>period</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="period"                data-endpoint="GETapi-v2-tickets-statistics"
               value="month"
               data-component="query">
    <br>
<p>Período para métricas temporales. Valores: day, week, month, year. Example: <code>month</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>include_trends</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="GETapi-v2-tickets-statistics" style="display: none">
            <input type="radio" name="include_trends"
                   value="1"
                   data-endpoint="GETapi-v2-tickets-statistics"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-v2-tickets-statistics" style="display: none">
            <input type="radio" name="include_trends"
                   value="0"
                   data-endpoint="GETapi-v2-tickets-statistics"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Incluir datos de tendencias temporales. Example: <code>true</code></p>
            </div>
                </form>

                <h1 id="usuarios-v1">Usuarios (V1)</h1>

    <p>Gestión básica de usuarios con funcionalidades CRUD estándar.
Para funcionalidades avanzadas como estadísticas usar V2.
Todos los endpoints requieren autenticación Bearer token.</p>

                                <h2 id="usuarios-v1-GETapi-v1-users">Listar usuarios</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Obtiene una lista paginada de usuarios con filtros básicos.</p>

<span id="example-requests-GETapi-v1-users">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://api-default-laravel.test/api/v1/users?page=1&amp;filter%5Bname%5D=admin&amp;filter%5Bemail%5D=admin%40admin.com" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v1/users"
);

const params = {
    "page": "1",
    "filter[name]": "admin",
    "filter[email]": "admin@admin.com",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v1/users';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'page' =&gt; '1',
            'filter[name]' =&gt; 'admin',
            'filter[email]' =&gt; 'admin@admin.com',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v1/users'
params = {
  'page': '1',
  'filter[name]': 'admin',
  'filter[email]': 'admin@admin.com',
}
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, params=params)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-users">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Usuarios obtenidos correctamente.&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;Admin User&quot;,
            &quot;email&quot;: &quot;admin@admin.com&quot;,
            &quot;created_at&quot;: &quot;2025-10-30T10:00:00.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-30T10:00:00.000000Z&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-users" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-users"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-users"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-users">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-users" data-method="GET"
      data-path="api/v1/users"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-users', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-users"
                    onclick="tryItOut('GETapi-v1-users');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-users"
                    onclick="cancelTryOut('GETapi-v1-users');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-users"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/users</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-users"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-v1-users"
               value="1"
               data-component="query">
    <br>
<p>Número de página para paginación. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>filter[name]</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="filter[name]"                data-endpoint="GETapi-v1-users"
               value="admin"
               data-component="query">
    <br>
<p>Filtrar por nombre. Example: <code>admin</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>filter[email]</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="filter[email]"                data-endpoint="GETapi-v1-users"
               value="admin@admin.com"
               data-component="query">
    <br>
<p>Filtrar por email. Example: <code>admin@admin.com</code></p>
            </div>
                </form>

                    <h2 id="usuarios-v1-POSTapi-v1-users">Crear usuario</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Crea un nuevo usuario en el sistema.</p>

<span id="example-requests-POSTapi-v1-users">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://api-default-laravel.test/api/v1/users" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"b\",
    \"email\": \"zbailey@example.net\",
    \"password\": \"-0pBNvYgxw\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v1/users"
);

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "b",
    "email": "zbailey@example.net",
    "password": "-0pBNvYgxw"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v1/users';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'b',
            'email' =&gt; 'zbailey@example.net',
            'password' =&gt; '-0pBNvYgxw',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v1/users'
payload = {
    "name": "b",
    "email": "zbailey@example.net",
    "password": "-0pBNvYgxw"
}
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-users">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Usuario creado correctamente.&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: 51,
        &quot;name&quot;: &quot;Juan P&eacute;rez&quot;,
        &quot;email&quot;: &quot;juan@example.com&quot;,
        &quot;created_at&quot;: &quot;2025-10-30T11:00:00.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2025-10-30T11:00:00.000000Z&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;Los datos proporcionados no son v&aacute;lidos.&quot;,
    &quot;data&quot;: {
        &quot;email&quot;: [
            &quot;The email has already been taken.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-users" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-users"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-users"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-users">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-users" data-method="POST"
      data-path="api/v1/users"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-users', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-users"
                    onclick="tryItOut('POSTapi-v1-users');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-users"
                    onclick="cancelTryOut('POSTapi-v1-users');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-users"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/users</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-users"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v1-users"
               value="b"
               data-component="body">
    <br>
<p>validation.max. Example: <code>b</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-users"
               value="zbailey@example.net"
               data-component="body">
    <br>
<p>validation.email. Example: <code>zbailey@example.net</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-v1-users"
               value="-0pBNvYgxw"
               data-component="body">
    <br>
<p>validation.min. Example: <code>-0pBNvYgxw</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>data</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.type"                data-endpoint="POSTapi-v1-users"
               value="user"
               data-component="body">
    <br>
<p>Tipo del recurso. Debe ser &quot;user&quot;. Example: <code>user</code></p>
                    </div>
                                                                <div style=" margin-left: 14px; clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>attributes</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.name"                data-endpoint="POSTapi-v1-users"
               value="Juan Pérez"
               data-component="body">
    <br>
<p>Nombre completo del usuario. Example: <code>Juan Pérez</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.email"                data-endpoint="POSTapi-v1-users"
               value="juan@example.com"
               data-component="body">
    <br>
<p>Email único del usuario. Example: <code>juan@example.com</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.password"                data-endpoint="POSTapi-v1-users"
               value="password123"
               data-component="body">
    <br>
<p>Contraseña (mínimo 8 caracteres). Example: <code>password123</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>password_confirmation</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.password_confirmation"                data-endpoint="POSTapi-v1-users"
               value="password123"
               data-component="body">
    <br>
<p>Confirmación de contraseña. Example: <code>password123</code></p>
                    </div>
                                    </details>
        </div>
                                        </details>
        </div>
        </form>

                    <h2 id="usuarios-v1-GETapi-v1-users--id-">Mostrar usuario</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Obtiene un usuario específico por su ID.</p>

<span id="example-requests-GETapi-v1-users--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://api-default-laravel.test/api/v1/users/architecto" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v1/users/architecto"
);

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v1/users/architecto';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v1/users/architecto'
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-users--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Usuario obtenido correctamente.&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;name&quot;: &quot;Admin User&quot;,
        &quot;email&quot;: &quot;admin@admin.com&quot;,
        &quot;created_at&quot;: &quot;2025-10-30T10:00:00.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2025-10-30T10:00:00.000000Z&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;El recurso User solicitado no fue encontrado.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-users--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-users--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-users--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-users--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-users--id-" data-method="GET"
      data-path="api/v1/users/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-users--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-users--id-"
                    onclick="tryItOut('GETapi-v1-users--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-users--id-"
                    onclick="cancelTryOut('GETapi-v1-users--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-users--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/users/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-users--id-"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="GETapi-v1-users--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the user. Example: <code>architecto</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>user</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="user"                data-endpoint="GETapi-v1-users--id-"
               value="1"
               data-component="url">
    <br>
<p>ID del usuario. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="usuarios-v1-DELETEapi-v1-users--id-">Eliminar usuario</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Elimina un usuario del sistema de forma permanente.</p>

<span id="example-requests-DELETEapi-v1-users--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://api-default-laravel.test/api/v1/users/architecto" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v1/users/architecto"
);

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v1/users/architecto';
$response = $client-&gt;delete(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v1/users/architecto'
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('DELETE', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v1-users--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Usuario eliminado correctamente.&quot;,
    &quot;data&quot;: null
}</code>
 </pre>
            <blockquote>
            <p>Example response (403):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;No tienes permisos para realizar esta acci&oacute;n.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;El recurso User solicitado no fue encontrado.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-v1-users--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v1-users--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v1-users--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-v1-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v1-users--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-v1-users--id-" data-method="DELETE"
      data-path="api/v1/users/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v1-users--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v1-users--id-"
                    onclick="tryItOut('DELETEapi-v1-users--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v1-users--id-"
                    onclick="cancelTryOut('DELETEapi-v1-users--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v1-users--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v1/users/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-v1-users--id-"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-v1-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-v1-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="DELETEapi-v1-users--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the user. Example: <code>architecto</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>user</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="user"                data-endpoint="DELETEapi-v1-users--id-"
               value="1"
               data-component="url">
    <br>
<p>ID del usuario. Example: <code>1</code></p>
            </div>
                    </form>

                <h1 id="usuarios-v2">Usuarios (V2)</h1>

    <p>Gestión completa de usuarios con funcionalidades avanzadas, filtros, paginación y estadísticas.
Todos los endpoints requieren autenticación Bearer token excepto donde se indique lo contrario.</p>

                                <h2 id="usuarios-v2-GETapi-v2-users">Listar usuarios</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Obtiene una lista paginada de usuarios con filtros avanzados, búsqueda y ordenamiento.</p>

<span id="example-requests-GETapi-v2-users">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://api-default-laravel.test/api/v2/users?page=1&amp;per_page=15&amp;search=admin&amp;sort=name&amp;direction=asc&amp;include=tickets&amp;filter%5Bname%5D=admin&amp;filter%5Bemail%5D=admin%40admin.com" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v2/users"
);

const params = {
    "page": "1",
    "per_page": "15",
    "search": "admin",
    "sort": "name",
    "direction": "asc",
    "include": "tickets",
    "filter[name]": "admin",
    "filter[email]": "admin@admin.com",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v2/users';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'page' =&gt; '1',
            'per_page' =&gt; '15',
            'search' =&gt; 'admin',
            'sort' =&gt; 'name',
            'direction' =&gt; 'asc',
            'include' =&gt; 'tickets',
            'filter[name]' =&gt; 'admin',
            'filter[email]' =&gt; 'admin@admin.com',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v2/users'
params = {
  'page': '1',
  'per_page': '15',
  'search': 'admin',
  'sort': 'name',
  'direction': 'asc',
  'include': 'tickets',
  'filter[name]': 'admin',
  'filter[email]': 'admin@admin.com',
}
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, params=params)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v2-users">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Usuarios obtenidos correctamente.&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: &quot;1&quot;,
            &quot;type&quot;: &quot;user&quot;,
            &quot;attributes&quot;: {
                &quot;name&quot;: &quot;Admin User&quot;,
                &quot;email&quot;: &quot;admin@admin.com&quot;,
                &quot;created_at&quot;: &quot;2025-10-30T10:00:00.000000Z&quot;,
                &quot;updated_at&quot;: &quot;2025-10-30T10:00:00.000000Z&quot;,
                &quot;isAdmin&quot;: true
            },
            &quot;relationships&quot;: {
                &quot;tickets&quot;: {
                    &quot;links&quot;: {
                        &quot;self&quot;: &quot;http://api-default-laravel.test/api/v2/users/1/relationships/tickets&quot;,
                        &quot;related&quot;: &quot;http://api-default-laravel.test/api/v2/users/1/tickets&quot;
                    }
                }
            }
        }
    ],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http://api-default-laravel.test/api/v2/users?page=1&quot;,
        &quot;last&quot;: &quot;http://api-default-laravel.test/api/v2/users?page=10&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: &quot;http://api-default-laravel.test/api/v2/users?page=2&quot;
    },
    &quot;meta&quot;: {
        &quot;total_users&quot;: 150,
        &quot;filters_applied&quot;: {
            &quot;name&quot;: &quot;admin&quot;
        },
        &quot;includes&quot;: [
            &quot;tickets&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v2-users" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v2-users"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v2-users"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v2-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v2-users">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v2-users" data-method="GET"
      data-path="api/v2/users"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v2-users', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v2-users"
                    onclick="tryItOut('GETapi-v2-users');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v2-users"
                    onclick="cancelTryOut('GETapi-v2-users');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v2-users"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v2/users</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v2-users"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v2-users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v2-users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-v2-users"
               value="1"
               data-component="query">
    <br>
<p>Número de página para paginación. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-v2-users"
               value="15"
               data-component="query">
    <br>
<p>Elementos por página (máximo 100). Example: <code>15</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-v2-users"
               value="admin"
               data-component="query">
    <br>
<p>Búsqueda en nombre y email. Example: <code>admin</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort"                data-endpoint="GETapi-v2-users"
               value="name"
               data-component="query">
    <br>
<p>Campo de ordenamiento. Valores: name, email, created_at, updated_at. Example: <code>name</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>direction</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="direction"                data-endpoint="GETapi-v2-users"
               value="asc"
               data-component="query">
    <br>
<p>Dirección del ordenamiento. Valores: asc, desc. Example: <code>asc</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>include</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="include"                data-endpoint="GETapi-v2-users"
               value="tickets"
               data-component="query">
    <br>
<p>Relaciones a incluir. Valores: tickets. Example: <code>tickets</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>filter[name]</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="filter[name]"                data-endpoint="GETapi-v2-users"
               value="admin"
               data-component="query">
    <br>
<p>Filtrar por nombre. Example: <code>admin</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>filter[email]</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="filter[email]"                data-endpoint="GETapi-v2-users"
               value="admin@admin.com"
               data-component="query">
    <br>
<p>Filtrar por email. Example: <code>admin@admin.com</code></p>
            </div>
                </form>

                    <h2 id="usuarios-v2-POSTapi-v2-users">Crear usuario</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Crea un nuevo usuario en el sistema con validación completa y logging.</p>

<span id="example-requests-POSTapi-v2-users">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://api-default-laravel.test/api/v2/users" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"b\",
    \"email\": \"zbailey@example.net\",
    \"password\": \"-0pBNvYgxw\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v2/users"
);

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "b",
    "email": "zbailey@example.net",
    "password": "-0pBNvYgxw"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v2/users';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'b',
            'email' =&gt; 'zbailey@example.net',
            'password' =&gt; '-0pBNvYgxw',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v2/users'
payload = {
    "name": "b",
    "email": "zbailey@example.net",
    "password": "-0pBNvYgxw"
}
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>

</span>

<span id="example-responses-POSTapi-v2-users">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Usuario creado correctamente.&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: &quot;151&quot;,
        &quot;type&quot;: &quot;user&quot;,
        &quot;attributes&quot;: {
            &quot;name&quot;: &quot;Juan P&eacute;rez&quot;,
            &quot;email&quot;: &quot;juan@example.com&quot;,
            &quot;created_at&quot;: &quot;2025-10-30T11:00:00.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-30T11:00:00.000000Z&quot;,
            &quot;isAdmin&quot;: false
        }
    },
    &quot;meta&quot;: {
        &quot;created_via&quot;: &quot;api_v2&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;Los datos proporcionados no son v&aacute;lidos.&quot;,
    &quot;data&quot;: {
        &quot;email&quot;: [
            &quot;The email has already been taken.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v2-users" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v2-users"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v2-users"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v2-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v2-users">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v2-users" data-method="POST"
      data-path="api/v2/users"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v2-users', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v2-users"
                    onclick="tryItOut('POSTapi-v2-users');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v2-users"
                    onclick="cancelTryOut('POSTapi-v2-users');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v2-users"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v2/users</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v2-users"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v2-users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v2-users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v2-users"
               value="b"
               data-component="body">
    <br>
<p>validation.max. Example: <code>b</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v2-users"
               value="zbailey@example.net"
               data-component="body">
    <br>
<p>validation.email. Example: <code>zbailey@example.net</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-v2-users"
               value="-0pBNvYgxw"
               data-component="body">
    <br>
<p>validation.min. Example: <code>-0pBNvYgxw</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>data</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.type"                data-endpoint="POSTapi-v2-users"
               value="user"
               data-component="body">
    <br>
<p>Tipo del recurso. Debe ser &quot;user&quot;. Example: <code>user</code></p>
                    </div>
                                                                <div style=" margin-left: 14px; clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>attributes</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.name"                data-endpoint="POSTapi-v2-users"
               value="Juan Pérez"
               data-component="body">
    <br>
<p>Nombre completo del usuario. Example: <code>Juan Pérez</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.email"                data-endpoint="POSTapi-v2-users"
               value="juan@example.com"
               data-component="body">
    <br>
<p>Email único del usuario. Example: <code>juan@example.com</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.password"                data-endpoint="POSTapi-v2-users"
               value="password123"
               data-component="body">
    <br>
<p>Contraseña (mínimo 8 caracteres). Example: <code>password123</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>password_confirmation</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="data.attributes.password_confirmation"                data-endpoint="POSTapi-v2-users"
               value="password123"
               data-component="body">
    <br>
<p>Confirmación de contraseña. Example: <code>password123</code></p>
                    </div>
                                    </details>
        </div>
                                        </details>
        </div>
        </form>

                    <h2 id="usuarios-v2-GETapi-v2-users--id-">Mostrar usuario</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Obtiene un usuario específico con relaciones optimizadas y carga condicional.</p>

<span id="example-requests-GETapi-v2-users--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://api-default-laravel.test/api/v2/users/architecto?include=tickets" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v2/users/architecto"
);

const params = {
    "include": "tickets",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v2/users/architecto';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'include' =&gt; 'tickets',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v2/users/architecto'
params = {
  'include': 'tickets',
}
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, params=params)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v2-users--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Usuario obtenido correctamente.&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: &quot;1&quot;,
        &quot;type&quot;: &quot;user&quot;,
        &quot;attributes&quot;: {
            &quot;name&quot;: &quot;Admin User&quot;,
            &quot;email&quot;: &quot;admin@admin.com&quot;,
            &quot;created_at&quot;: &quot;2025-10-30T10:00:00.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-30T10:00:00.000000Z&quot;,
            &quot;isAdmin&quot;: true
        },
        &quot;relationships&quot;: {
            &quot;tickets&quot;: {
                &quot;links&quot;: {
                    &quot;self&quot;: &quot;http://api-default-laravel.test/api/v2/users/1/relationships/tickets&quot;,
                    &quot;related&quot;: &quot;http://api-default-laravel.test/api/v2/users/1/tickets&quot;
                }
            }
        },
        &quot;meta&quot;: {
            &quot;version&quot;: &quot;2.0&quot;,
            &quot;cached_at&quot;: &quot;2025-10-30T11:00:00.000000Z&quot;
        }
    },
    &quot;meta&quot;: {
        &quot;includes&quot;: [
            &quot;tickets&quot;
        ]
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;El recurso User solicitado no fue encontrado.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v2-users--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v2-users--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v2-users--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v2-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v2-users--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v2-users--id-" data-method="GET"
      data-path="api/v2/users/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v2-users--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v2-users--id-"
                    onclick="tryItOut('GETapi-v2-users--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v2-users--id-"
                    onclick="cancelTryOut('GETapi-v2-users--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v2-users--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v2/users/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v2-users--id-"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v2-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v2-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="GETapi-v2-users--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the user. Example: <code>architecto</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>user</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="user"                data-endpoint="GETapi-v2-users--id-"
               value="1"
               data-component="url">
    <br>
<p>ID del usuario. Example: <code>1</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>include</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="include"                data-endpoint="GETapi-v2-users--id-"
               value="tickets"
               data-component="query">
    <br>
<p>Relaciones a incluir. Valores: tickets. Example: <code>tickets</code></p>
            </div>
                </form>

                    <h2 id="usuarios-v2-DELETEapi-v2-users--id-">Eliminar usuario</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Elimina un usuario del sistema con validaciones de negocio y logging de auditoría.</p>

<span id="example-requests-DELETEapi-v2-users--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://api-default-laravel.test/api/v2/users/architecto" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v2/users/architecto"
);

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v2/users/architecto';
$response = $client-&gt;delete(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v2/users/architecto'
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('DELETE', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v2-users--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Usuario eliminado correctamente.&quot;,
    &quot;data&quot;: null,
    &quot;meta&quot;: {
        &quot;deleted_via&quot;: &quot;api_v2&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (403):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;No tienes permisos para realizar esta acci&oacute;n.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;El recurso User solicitado no fue encontrado.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;No se puede eliminar un usuario con tickets activos.&quot;,
    &quot;meta&quot;: {
        &quot;active_tickets_count&quot;: 5,
        &quot;suggested_action&quot;: &quot;Complete or reassign active tickets before deletion&quot;
    }
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-v2-users--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v2-users--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v2-users--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-v2-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v2-users--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-v2-users--id-" data-method="DELETE"
      data-path="api/v2/users/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v2-users--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v2-users--id-"
                    onclick="tryItOut('DELETEapi-v2-users--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v2-users--id-"
                    onclick="cancelTryOut('DELETEapi-v2-users--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v2-users--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v2/users/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-v2-users--id-"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-v2-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-v2-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="DELETEapi-v2-users--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the user. Example: <code>architecto</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>user</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="user"                data-endpoint="DELETEapi-v2-users--id-"
               value="1"
               data-component="url">
    <br>
<p>ID del usuario. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="usuarios-v2-GETapi-v2-users--user--tickets">Tickets de usuario</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Obtiene todos los tickets de un usuario específico con paginación.</p>

<span id="example-requests-GETapi-v2-users--user--tickets">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://api-default-laravel.test/api/v2/users/1/tickets?page=1&amp;per_page=15" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v2/users/1/tickets"
);

const params = {
    "page": "1",
    "per_page": "15",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v2/users/1/tickets';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'page' =&gt; '1',
            'per_page' =&gt; '15',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v2/users/1/tickets'
params = {
  'page': '1',
  'per_page': '15',
}
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, params=params)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v2-users--user--tickets">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Tickets del usuario obtenidos correctamente.&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;title&quot;: &quot;Error en sistema de login&quot;,
            &quot;description&quot;: &quot;Los usuarios no pueden iniciar sesi&oacute;n&quot;,
            &quot;status&quot;: &quot;A&quot;,
            &quot;priority&quot;: &quot;high&quot;,
            &quot;created_at&quot;: &quot;2025-10-30T10:00:00.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-30T10:30:00.000000Z&quot;
        }
    ],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http://api-default-laravel.test/api/v2/users/1/tickets?page=1&quot;,
        &quot;last&quot;: &quot;http://api-default-laravel.test/api/v2/users/1/tickets?page=3&quot;,
        &quot;next&quot;: &quot;http://api-default-laravel.test/api/v2/users/1/tickets?page=2&quot;
    },
    &quot;meta&quot;: {
        &quot;user_id&quot;: 1,
        &quot;total_tickets&quot;: 45
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;El recurso User solicitado no fue encontrado.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v2-users--user--tickets" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v2-users--user--tickets"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v2-users--user--tickets"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v2-users--user--tickets" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v2-users--user--tickets">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v2-users--user--tickets" data-method="GET"
      data-path="api/v2/users/{user}/tickets"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v2-users--user--tickets', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v2-users--user--tickets"
                    onclick="tryItOut('GETapi-v2-users--user--tickets');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v2-users--user--tickets"
                    onclick="cancelTryOut('GETapi-v2-users--user--tickets');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v2-users--user--tickets"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v2/users/{user}/tickets</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v2-users--user--tickets"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v2-users--user--tickets"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v2-users--user--tickets"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>user</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="user"                data-endpoint="GETapi-v2-users--user--tickets"
               value="1"
               data-component="url">
    <br>
<p>ID del usuario. Example: <code>1</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-v2-users--user--tickets"
               value="1"
               data-component="query">
    <br>
<p>Número de página para paginación. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-v2-users--user--tickets"
               value="15"
               data-component="query">
    <br>
<p>Elementos por página. Example: <code>15</code></p>
            </div>
                </form>

                    <h2 id="usuarios-v2-GETapi-v2-users-statistics">Estadísticas de usuarios</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Obtiene estadísticas completas del sistema de usuarios incluyendo métricas de actividad
y análisis de comportamiento.</p>

<span id="example-requests-GETapi-v2-users-statistics">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://api-default-laravel.test/api/v2/users-statistics" \
    --header "Authorization: Bearer YOUR_BEARER_TOKEN" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://api-default-laravel.test/api/v2/users-statistics"
);

const headers = {
    "Authorization": "Bearer YOUR_BEARER_TOKEN",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://api-default-laravel.test/api/v2/users-statistics';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer YOUR_BEARER_TOKEN',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://api-default-laravel.test/api/v2/users-statistics'
headers = {
  'Authorization': 'Bearer YOUR_BEARER_TOKEN',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v2-users-statistics">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;message&quot;: &quot;Estad&iacute;sticas de usuarios obtenidas correctamente.&quot;,
    &quot;data&quot;: {
        &quot;totals&quot;: {
            &quot;total_users&quot;: 150,
            &quot;active_users&quot;: 125,
            &quot;users_with_tickets&quot;: 89,
            &quot;admin_users&quot;: 5
        },
        &quot;activity_metrics&quot;: {
            &quot;users_created_this_month&quot;: 15,
            &quot;most_active_users&quot;: [
                {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: &quot;Admin User&quot;,
                    &quot;tickets_count&quot;: 45
                },
                {
                    &quot;id&quot;: 5,
                    &quot;name&quot;: &quot;Support Team&quot;,
                    &quot;tickets_count&quot;: 32
                }
            ],
            &quot;users_with_pending_tickets&quot;: 25
        },
        &quot;user_engagement&quot;: {
            &quot;average_tickets_per_user&quot;: 3.2,
            &quot;users_active_last_week&quot;: 89,
            &quot;registration_trends&quot;: {
                &quot;this_week&quot;: 8,
                &quot;last_week&quot;: 12,
                &quot;growth_rate&quot;: &quot;-33.3%&quot;
            }
        }
    },
    &quot;meta&quot;: {
        &quot;generated_at&quot;: &quot;2025-10-30T11:00:00.000000Z&quot;,
        &quot;api_version&quot;: &quot;2.0&quot;
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v2-users-statistics" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v2-users-statistics"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v2-users-statistics"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v2-users-statistics" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v2-users-statistics">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v2-users-statistics" data-method="GET"
      data-path="api/v2/users-statistics"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v2-users-statistics', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v2-users-statistics"
                    onclick="tryItOut('GETapi-v2-users-statistics');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v2-users-statistics"
                    onclick="cancelTryOut('GETapi-v2-users-statistics');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v2-users-statistics"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v2/users-statistics</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v2-users-statistics"
               value="Bearer YOUR_BEARER_TOKEN"
               data-component="header">
    <br>
<p>Example: <code>Bearer YOUR_BEARER_TOKEN</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v2-users-statistics"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v2-users-statistics"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                                                        <button type="button" class="lang-button" data-language-name="php">php</button>
                                                        <button type="button" class="lang-button" data-language-name="python">python</button>
                            </div>
            </div>
</div>
</body>
</html>
