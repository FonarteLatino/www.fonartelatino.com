# Fonarte Latino — CMS de Catálogo Musical

> **Sello independiente líder en distribución física y digital de música independiente de México.**

---

## 📋 Índice

1. [Descripción del Proyecto](#descripción-del-proyecto)
2. [Arquitectura del Sistema](#arquitectura-del-sistema)
3. [Estructura de Directorios](#estructura-de-directorios)
4. [Requisitos y Dependencias](#requisitos-y-dependencias)
5. [Entornos de Despliegue](#entornos-de-despliegue)
6. [Configuración Local (XAMPP)](#configuración-local-xampp)
7. [Despliegue en DreamHost](#despliegue-en-dreamhost)
8. [Diccionario de Datos — MySQL](#diccionario-de-datos--mysql)
9. [Módulos Funcionales](#módulos-funcionales)
10. [Convenciones de Código](#convenciones-de-código)
11. [Seguridad](#seguridad)
12. [Hoja de Ruta (Modernización)](#hoja-de-ruta-modernización)

---

## Descripción del Proyecto

El sitio **www.fonartelatino.com** es un catálogo musical con tienda en línea (ecommerce) que permite:

- **Públicos:** Navegar el catálogo de discos (físico y digital), escuchar previews en Spotify, comprar discos físicos, ver información de artistas por género y categoría.
- **Administrativos:** Gestionar el catálogo de productos, pedidos, cupones de descuento, géneros, precios, banners y usuarios.

---

## Arquitectura del Sistema

| Capa | Tecnología | Versión | Notas |
|---|---|---|---|
| Servidor Web | Apache | 2.4+ | DreamHost Shared / XAMPP local |
| Backend | PHP | 7.4 – 8.1 | MySQLi procesal (sin ORM) |
| Base de Datos | MySQL | 5.7 – 8.0 | Base de datos: `fonartecommerce` |
| Frontend CSS | Bootstrap + Custom CSS | Bootstrap 3.x | Archivo principal: `css/style.css` |
| Frontend JS | jQuery + Vanilla JS | jQuery 1.11.x | Se migra gradualmente a ES6+ |
| Email | PHPMailer | 5.x | Directorio `/PHPMailer/` |
| Hosting destino | DreamHost Shared | — | Apache / PHP FPM |

**Patrón de arquitectura:** Monolito PHP procesal. No hay separación MVC.  
Cada página PHP es responsable de: conexión a DB → query → renderizado HTML.

---

## Estructura de Directorios

```
www.fonartelatino.com/
│
├── Connections/            # Configuración de base de datos
│   └── conexion.php        # ⚠️  Editar según entorno (local/producción)
│
├── css/                    # Hojas de estilo
│   ├── style.css           # CSS principal del sitio público
│   ├── bootstrap.min.css   # Bootstrap 3
│   ├── estiloFirelink1.css # Módulo Firelink
│   └── tarjeta.css         # Estilos de tarjeta de producto
│
├── js/                     # Scripts JavaScript
│   ├── jquery.js           # jQuery 1.11.x
│   ├── bootstrap.min.js    # Bootstrap JS
│   ├── cart.js             # [NUEVO] Carrito asíncrono Vanilla JS
│   ├── valida_registro.js  # Validación formulario de registro
│   └── valida_direccion_nueva.js
│
├── includes/               # [NUEVO] Utilidades compartidas PHP
│   ├── head_meta.php       # Meta tags SEO + Open Graph
│   ├── analytics.php       # Google Analytics 4 (solo producción)
│   ├── config_sitio.php    # Helper getSiteConfig()
│   ├── csrf.php            # Generación y validación de tokens CSRF
│   ├── db.php              # Wrapper MySQLi con prepared statements
│   └── image_processor.php # Conversión a WebP (PHP GD)
│
├── api/                    # [NUEVO] Endpoints JSON internos
│   ├── carrito_add.php     # POST: agregar al carrito
│   ├── carrito_remove.php  # POST: eliminar del carrito
│   └── pedido_update_status.php  # POST: cambiar estatus de pedido
│
├── img/                    # Imágenes
│   ├── caratulas/          # 📁 Portadas de discos (no versionar en Git)
│   ├── slider/             # Banners del home
│   ├── logos/              # Logo del sitio
│   └── favicon.png         # Favicon principal
│
├── font-awesome/           # Iconos Font Awesome 4.x
├── PHPMailer/              # Librería de email
├── zebra_pagination/       # Paginación
├── bin/                    # Scripts CLI / Cron Jobs
│   └── check_streaming_links.php  # Validador de links de streaming
│
├── script_BD/              # Scripts SQL de la base de datos
│   └── fonartecommerce.sql # Dump completo de la BD
│
├── admin_*.php             # Páginas del panel administrativo
├── ajax_*.php              # Endpoints AJAX legacy
├── js_*.php                # Generadores de JS dinámico (a deprecar)
│
├── index.php               # Página principal (Home)
├── catalogo.php            # Catálogo general
├── producto_detalle.php    # Detalle de un producto
├── carrito.php             # Carrito de compras
├── pago.php                # Proceso de pago
├── login.php               # Login del panel admin
├── menu.php                # Menú de navegación pública
├── menu_admin.php          # Menú del panel administrativo
├── pie.php                 # Footer público
├── rutas_absolutas.php     # ⚠️  Editar según entorno
├── alertas.php             # Sistema de alertas/flash messages
│
├── sitemap_generator.php   # [NUEVO] Genera sitemap.xml dinámico
├── streaming_redirect.php  # [NUEVO] Redireccionador de links de streaming
├── .htaccess               # Reglas Apache (rewrite, seguridad, caché)
├── robots.txt              # [NUEVO] Directivas para bots de búsqueda
└── README.md               # Este archivo
```

---

## Requisitos y Dependencias

### Servidor
- PHP **7.4+** (recomendado 8.1)
  - Extensiones: `mysqli`, `gd` (para imágenes WebP), `mbstring`, `curl` (para validador de links), `openssl`
- MySQL **5.7+** o MariaDB **10.3+**
- Apache con `mod_rewrite` habilitado
- HTTPS habilitado (certificado SSL — en DreamHost: Let's Encrypt gratuito)

### PHP
- No se usa Composer actualmente (PHPMailer incluido manualmente)

### Frontend
- Bootstrap 3.3.x (incluido localmente en `/css/` y `/js/`)
- Font Awesome 4.7 (incluido localmente en `/font-awesome/`)
- Google Fonts: Roboto Condensed (CDN)

---

## Entornos de Despliegue

| Variable | Local | Producción |
|---|---|---|
| Host DB | `localhost` | `mysql.fonartelatino.com` |
| DB Name | `fonartecommerce` | `fonartecommerce` |
| DB User | `root` | `usrfonartebjf` |
| DB Pass | *(vacía)* | *(ver credenciales seguras)* |
| `$ruta_absoluta` | `http://localhost/www.fonartelatino.com/` | `https://www.fonartelatino.com/` |

### Archivos a editar por entorno

#### `Connections/conexion.php`
Activar el bloque del entorno correcto comentando los demás.

#### `rutas_absolutas.php`
```php
// Para local:
$ruta_absoluta = 'http://localhost/www.fonartelatino.com/';
// Para producción:
$ruta_absoluta = 'https://www.fonartelatino.com/';
```

---

## Configuración Local (XAMPP)

```bash
# 1. Clonar o copiar el proyecto
# Ruta: C:\xampp\htdocs\www.fonartelatino.com\

# 2. Iniciar Apache y MySQL en XAMPP

# 3. Importar la base de datos
# Abrir: http://localhost/phpmyadmin
# Crear base de datos: fonartecommerce (utf8_general_ci)
# Importar: script_BD/fonartecommerce.sql

# 4. Configurar Connections/conexion.php
# Activar el bloque "SERVIDOR LOCAL"

# 5. Configurar rutas_absolutas.php
# Activar: $ruta_absoluta = 'http://localhost/www.fonartelatino.com/';

# 6. Acceder al sitio
# http://localhost/www.fonartelatino.com/
# Panel admin: http://localhost/www.fonartelatino.com/panel-admin
```

---

## Despliegue en DreamHost

### Pasos estándar

```
1. Conectarse vía FTP/SFTP a:
   Host: fonartelatino.com (o ftp.fonartelatino.com)
   Puerto: 22 (SFTP)
   Usuario: ver credenciales DreamHost

2. Directorio destino: /home/[usuario]/fonartelatino.com/

3. Subir todos los archivos EXCEPTO los del .gitignore:
   - NO subir Connections/conexion.php local
   - NO subir rutas_absolutas.php local (editar antes de subir)
   - NO subir img/caratulas/ (ya están en el servidor)

4. En el servidor, editar Connections/conexion.php:
   Activar el bloque "SERVIDOR DE PRODUCCION"

5. En el servidor, editar rutas_absolutas.php:
   $ruta_absoluta = 'https://www.fonartelatino.com/';

6. Importar cambios de BD (si los hay):
   Acceder a phpMyAdmin desde panel DreamHost
   Ejecutar scripts de migración incrementales

7. Verificar en https://www.fonartelatino.com/
```

### Configuración de Cron Jobs en DreamHost
```
# Validador de links de streaming (cada lunes a las 3am)
0 3 * * 1  php /home/[usuario]/fonartelatino.com/bin/check_streaming_links.php

# Limpieza de carritos abandonados (cada día a las 2am)  
0 2 * * *  php /home/[usuario]/fonartelatino.com/bin/cleanup_carrito.php
```

---

## Diccionario de Datos — MySQL

### Base de datos: `fonartecommerce`

#### Tabla: `productos` (tabla principal del catálogo)

| Campo | Tipo | Descripción | Valores posibles |
|---|---|---|---|
| `id` | INT PK AUTO | ID único | — |
| `sku` | VARCHAR(50) | SKU del producto | Ej: `FL-001` |
| `id_fonarte` | VARCHAR(50) | ID interno Fonarte | Ej: `FON-123` |
| `artista` | VARCHAR(200) | Nombre del artista | Texto UTF-8 |
| `album` | VARCHAR(200) | Nombre del álbum | Texto UTF-8 |
| `genero` | INT FK | Género principal → `genero.id` | — |
| `genero2` | INT FK | Género secundario → `genero.id` | Opcional |
| `genero3` | INT FK | Género terciario → `genero.id` | Opcional |
| `categoria` | INT FK | Formato físico → `categoria.id` | CD/Vinil/DVD/etc |
| `clave_precio` | VARCHAR FK | Nivel de precio → `precios.clave` | — |
| `spotify` | TEXT | URL embed o link de Spotify | URL o vacío |
| `itunes` | TEXT | URL Apple Music | URL o vacío |
| `amazon` | TEXT | URL Amazon | URL o vacío |
| `google` | TEXT | URL Google Play Music | URL o vacío |
| `amazon_mu` | TEXT | URL Amazon Music | URL o vacío |
| `youtube` | TEXT | URL YouTube | URL o vacío |
| `deezer` | TEXT | URL Deezer | URL o vacío |
| `tidal` | TEXT | URL Tidal | URL o vacío |
| `ruta_img` | VARCHAR(300) | Ruta relativa portada principal | `img/caratulas/xxx.jpg` |
| `ruta_img_2` | VARCHAR(300) | Ruta relativa imagen secundaria | `img/caratulas/xxx.jpg` |
| `descripcion` | TEXT | Descripción del álbum | Texto libre |
| `estatus` | ENUM | Disponibilidad general | `ACTIVO`, `INACTIVO`, `DIGITAL` |
| `disponible_fisico` | TINYINT(1) | ¿Disponible para compra física? | `0`, `1` |
| `disponible_digital` | TINYINT(1) | ¿Disponible en streaming? | `0`, `1` |
| `prendido` | TINYINT(1) | ¿Visible en el catálogo público? | `0`, `1` |
| `firelink` | ENUM | ¿Activar página Firelink? | `Si`, `No` |
| `play` | ENUM | ¿Activar player Spotify en Firelink? | `Si`, `No` |
| `video` | VARCHAR(500) | URL de video promo | URL o vacío |
| `promo` | TEXT | Texto promocional | — |
| `p` | ENUM | ¿Activar promocional? | `Si`, `No` |
| `fecha_alta` | DATE | Fecha de registro | `YYYY-MM-DD` |
| `hora_alta` | TIME | Hora de registro | `HH:MM:SS` |

#### Tabla: `pedido`

| Campo | Tipo | Descripción |
|---|---|---|
| `id` | INT PK | ID del pedido |
| `id_usr` | INT FK | Usuario que realizó el pedido |
| `id_direccion` | INT FK | Dirección de envío seleccionada |
| `id_envio` | INT FK | Tarifa de envío aplicada |
| `subtotal_productos` | DECIMAL | Subtotal de productos |
| `precio_envio` | DECIMAL | Costo de envío |
| `total` | DECIMAL | Total con descuentos aplicados |
| `cupon_aplicado` | VARCHAR | Código de cupón usado (o vacío) |
| `estatus` | ENUM | Estado del pedido |
| `fecha` | DATE | Fecha del pedido |

**Valores de `estatus` en pedido:** `PENDIENTE`, `REVISANDO_PAGO`, `APROBADO`, `ENVIADO`, `CANCELADO`

#### Tablas de selección en Home

| Tabla | Función | Campos clave |
|---|---|---|
| `lanzamientos` | Sección "Lanzamientos" del home | `id_producto` |
| `novedades` | Sección "Novedades" del home | `id_producto` |
| `d_semana` | Sección "Disco de la Semana" | `id_producto` |
| `en_detalle` | Sección "En Detalle" | `id_producto`, `id_artista` |

> Para agregar/quitar un disco de cada sección, se administra desde el panel administrativo correspondiente.

---

## Módulos Funcionales

### Público
| Módulo | Archivo principal | Descripción |
|---|---|---|
| Home | `index.php` | Lanzamientos, Novedades, Disco Semana, En Detalle |
| Catálogo | `catalogo.php` | Grid de discos por categoría |
| Detalle | `producto_detalle.php` | Página del álbum con player Spotify y botones de compra |
| Géneros | `generos.php` | Filtro por género musical |
| Busca | `busqueda.php` | Búsqueda por texto |
| Carrito | `carrito.php` | Carrito de compras |
| Checkout | `cuenta.php`, `direcciones_envio.php`, `pago.php` | Flujo de compra |
| Pago Bancario | `pago_bancario.php` | Instrucciones de transferencia |
| Pago PayPal | `pago_paypal.php` | Botón de PayPal |
| Firelink | `firelinkPlantilla.php` | Landing page de artista con player |
| Contacto | `contacto.php` | Formulario de contacto |

### Administración (requiere login)
| Módulo | Archivo principal | Descripción |
|---|---|---|
| Dashboard | `admin_home.php` | Panel principal |
| Productos | `admin_productos.php` | Lista de productos |
| Ver/Editar Producto | `admin_ver_producto.php` | Formulario completo de edición |
| Nuevo Producto | `admin_nuevo_producto.php` | Alta de nuevo disco |
| Pedidos | `admin_pedidos_dashboard.php` | [NUEVO] Vista de pedidos con estatus |
| Cupones | `admin_cupon.php` | Gestión de cupones |
| Géneros | `admin_generos.php` | Catálogo de géneros |
| Categorías | `admin_categorias.php` | Categorías de formatos |
| Precios | `admin_precios.php` | Niveles de precio |
| Envíos | `admin_precio_envios.php` | Tarifas de envío |
| Analíticas | `analytic.php` | Iframe con dashboard de analytics |
| Branding | `admin_branding.php` | [NUEVO] Logo y banners |

---

## Convenciones de Código

### PHP
- Siempre iniciar sesión con `session_start()` antes de cualquier output
- Usar `htmlspecialchars()` para todo echo de datos de BD hacia HTML
- Usar `filter_input()` para sanitizar entradas de `$_GET` y `$_POST`
- Usar Prepared Statements para todas las queries (no concatenación directa)
- Verificar token CSRF en todos los formularios POST
- No usar `die(mysqli_error())` en producción — loggear y mostrar error genérico

### Naming
- Archivos PHP: `snake_case.php`
- Clases CSS: usar Variables CSS (`var(--color-primary)`) en lugar de valores hardcoded
- IDs de HTML: descriptivos y únicos por página

---

## Seguridad

### Puntos críticos documentados

1. **SQL Injection**: Usar siempre Prepared Statements. Ver `includes/db.php`
2. **XSS**: Todo dato de BD que se imprime en HTML debe pasar por `htmlspecialchars()`
3. **CSRF**: Token en cada formulario POST. Generado en `includes/csrf.php`
4. **Autenticación Admin**: Verificar sesión `MM_Username_Panel` al inicio de cada página admin
5. **Archivos sensibles**: `Connections/conexion.php` con credenciales reales NO se sube a Git

### Variables de entorno recomendadas
En producción, mover las credenciales de DB a un archivo fuera del webroot:
```php
// Connections/conexion.php (versión producción):
$hostname_conexion = getenv('DB_HOST') ?: 'mysql.fonartelatino.com';
$database_conexion = getenv('DB_NAME') ?: 'fonartecommerce';
$username_conexion = getenv('DB_USER') ?: 'usrfonartebjf';
$password_conexion = getenv('DB_PASS') ?: '';
```

---

## Hoja de Ruta (Modernización)

| Etapa | Descripción | Estado |
|---|---|---|
| 1 | Git, README, Variables CSS, includes/ | ✅ En progreso |
| 2 | .htaccess completo, SEO, sitemap, robots.txt | ✅ En progreso |
| 3 | Lazy loading de imágenes, conversión WebP | 🔲 Pendiente |
| 4 | Hibridación catálogo Físico/Digital | 🔲 Pendiente |
| 5 | Resiliencia streaming (redirección + validador) | 🔲 Pendiente |
| 6 | Carrito asíncrono, dashboard de pedidos | 🔲 Pendiente |
| 7 | Panel de branding dinámico | 🔲 Pendiente |
| — | Seguridad: Prepared Statements en todo el sitio | 🟡 Crítico |

---

*Última actualización: Julio 2026*  
*Propietario: Fonarte Latino*
