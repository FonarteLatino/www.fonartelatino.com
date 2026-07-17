# Changelog — Fonarte Latino
Todos los cambios notables en este proyecto serán documentados en este archivo.

El formato está basado en [Keep a Changelog](https://keepachangelog.com/es-ES/1.0.0/).

## [1.0.0] - 2026-07-16

### Estado Actual del Proyecto (Auditoría Inicial)
- **Arquitectura:** Monolito PHP ("Spaghetti Code"). Mezcla de lógica de negocio, manipulación de base de datos e interfaz gráfica en los mismos archivos PHP (sin MVC ni separación de capas).
- **Base de Datos:** Implementación en MySQL usando la extensión procesal `mysqli_*`. Se identificó el uso intensivo de consultas SQL concatenadas directamente con strings provenientes del usuario (`$_GET`, `$_POST`), careciendo de *Prepared Statements*.
- **Frontend:** Maquetación HTML estática sin sistema de plantillas. Uso de Bootstrap 3 y múltiples estilos CSS en línea (`style="..."`) que dificultan la tematización.
- **JavaScript:** Dependencia principal de jQuery 1.11.x. La interactividad asíncrona es limitada; se usan principalmente redirecciones completas vía `window.location` en lugar de peticiones `fetch()` o AJAX modernas.
- **Seguridad (Riesgos Identificados):**
  - Vulnerabilidades críticas a Inyección SQL (ej. `producto_detalle.php`, `pago.php`).
  - Ausencia generalizada de tokens CSRF en formularios de estado (carrito, checkout, admin).
  - Contraseñas y credenciales alojadas en texto claro dentro del código fuente comentado y en archivos `.txt`.
- **Infraestructura y SEO:**
  - Desplegado en DreamHost (Shared Hosting) bajo Apache.
  - El `.htaccess` carece de optimizaciones importantes (cabeceras de caché, GZIP/Brotli, directivas de seguridad como X-Frame-Options).
  - Ausencia de herramientas de indexación (`robots.txt`, `sitemap.xml`).
  - Metadatos estáticos sin implementación completa de Open Graph o Twitter Cards.
- **Catálogo Musical:**
  - El campo de estatus actual maneja limitadamente la lógica de formatos (físico/digital), pero no soporta bien formatos híbridos explícitos.
  - Los enlaces de plataformas de streaming apuntan directamente a URL externas desde el frontend, lo que causa links rotos generalizados al compartirlos si la URL destino cambia.


## [0.0.0] - 2026-07-16