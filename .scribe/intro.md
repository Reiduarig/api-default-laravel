# Introduction

API REST para gestión de tickets con autenticación Sanctum y versionado V1/V2

<aside>
    <strong>Base URL</strong>: <code>http://api-default-laravel.test</code>
</aside>

    Esta API REST está construida con Laravel 12 y utiliza autenticación Sanctum para proteger los endpoints.

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

    <aside>Los ejemplos de código muestran cómo trabajar con la API en diferentes lenguajes de programación. 
    Puedes cambiar el lenguaje usando las pestañas en la parte superior derecha.</aside>

