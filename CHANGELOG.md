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

## [0.0.0] - 2019-07-16

### Propósito del Sitio
El sitio www.fonartelatino.com funciona como el catálogo en línea y plataforma de comercio electrónico de Fonarte Latino, un sello discográfico y distribuidora de música independiente mexicana. Su propósito principal es permitir a los usuarios explorar artistas, álbumes y géneros musicales, adquirir formatos físicos (CDs, Vinilos, DVDs) mediante un carrito de compras tradicional, y proporcionar accesos directos a plataformas de streaming digital para el consumo en línea.

### Estado Presente del Sistema (Evaluación Base)

#### Arquitectura y Código Base
- **Monolito sin capas:** El código carece de patrones arquitectónicos (como MVC). La lógica de negocio, el acceso a datos y el maquetado HTML están directamente mezclados en los mismos archivos PHP (Spaghetti Code).
- **Versión de PHP Legacy:** El código presenta funciones y condicionales heredados, como validaciones exclusivas de PHP < 6, el uso de la API procedimental mysqli_* y un extenso uso de funciones como utf8_decode() / utf8_encode() que romperán la aplicación al migrar a PHP 9.

#### Base de Datos (fonartecommerce)
- **Seguridad Crítica:** Existen múltiples vulnerabilidades a Inyección SQL debido a la concatenación de variables ($_GET, $_POST, $_SESSION) directamente en las sentencias SQL. No se emplean consultas preparadas (Prepared Statements).
- **Integridad y Desnormalización:** Las tablas carecen de llaves foráneas estrictas (CONSTRAINT FOREIGN KEY), y se utilizan columnas de texto para almacenar IDs (ej. genero, genero2 en la tabla productos), lo que limita la integridad referencial y merma el rendimiento.
- **Lógica de Formatos Limitada:** El campo de estatus en los productos combina de forma inflexible la lógica de venta física vs disponibilidad digital.

#### Frontend y UI
- **Dependencias Obsoletas:** El sitio depende de Bootstrap 3 (2013), jQuery 1.11.x, y plugins de validación descontinuados (jqBootstrapValidation.js).
- **Navegación Tradicional:** Hay ausencia de interacciones asíncronas modernas (fetch o AJAX). Acciones como agregar al carrito o aplicar cupones se manejan mediante recargas completas de la página con inyecciones de window.location.
- **Estilos CSS Ineficientes:** Abunda el uso de CSS en línea (style="...") y hojas de estilo con bloques duplicados, lo que vuelve casi imposible tematizar el sitio de forma escalable usando variables nativas.

#### Infraestructura, SEO y Seguridad General
- **SEO Ausente:** Faltan componentes básicos como robots.txt, sitemap.xml, URLs semánticas completas (solo están parcialmente cubiertas en el catálogo) y etiquetas semánticas sociales (Open Graph y Twitter Cards).
- **Falta de Prevención CSRF:** No se utilizan tokens anti-falsificación en los formularios (carrito, checkout o panel administrativo).
- **Fugas de Información:** Credenciales de la base de datos se encuentran hardcodeadas en texto claro dentro del historial del archivo de conexión, y existe un archivo pass .txt expuesto en la raíz.
- **Gestión Frágil de Streaming:** Los enlaces a plataformas como Spotify o Apple Music están incrustados directamente, lo que puede causar fallas ("Link rot") a largo plazo si las URLs externas llegan a modificarse.
