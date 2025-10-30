# Authenticating requests

To authenticate requests, include an **`Authorization`** header with the value **`"Bearer YOUR_BEARER_TOKEN"`**.

All authenticated endpoints are marked with a `requires authentication` badge in the documentation below.

Para obtener tu token, realiza una petición POST a <code>/api/v2/login</code> con tus credenciales. El token se encuentra en la respuesta dentro de <code>data.token</code>.
