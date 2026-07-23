# Plan de implementación — Fase 1

## Objetivo

Establecer una base segura, mantenible y reversible para el sistema, sin alterar su funcionamiento público ni realizar una reescritura.

## Alcance


- Cada bloque debe poder revisarse, probarse y desplegarse de forma independiente.
- No se harán cambios de esquema de base de datos, ni se migrará el carrito a AJAX en esta fase.

---

## 1. Preparar línea base


1. Registrar la versión de PHP local y las extensiones requeridas, sin cambiar producción.
2. Definir las páginas críticas que se validarán después de cada cambio:
   - Inicio.
   - Catálogo.
   - Detalle de producto.
   - Registro.
   - Direcciones.
   - Carrito y pago.
   - Firelink.
   - Panel administrativo.

**Criterio de salida:** existe una lista de comprobación funcional y el entorno local está identificado.

---

## 2. Asegurar configuración y archivos sensibles

1. Revisar qué archivos sensibles se encuentran rastreados por Git, además de los cubiertos por `.gitignore`.
2. Mantener `Connections/conexion.php` con configuración local o lectura de variables de entorno; las credenciales de producción no deben permanecer en el repositorio.
3. Revisar el archivo `pass .txt`:
   - Confirmar si fue rastreado históricamente.
   - Si contiene credenciales reales, rotarlas antes de eliminarlo o limpiar el historial.
4. Ajustar `.gitignore` solo si se detectan archivos sensibles, respaldos o datos de trabajo que aún no estén cubiertos.

**Criterio de salida:** no hay secretos activos en archivos rastreados ni configuración de producción lista para subirse por error.

---

## 3. Estabilizar los estilos sin cambiar el diseño

1. Añadir las variables CSS corporativas en la parte superior de `css/style.css`.
2. Inventariar colores, tipografías y reglas repetidas en las hojas de estilo activas.
3. Reemplazar valores de color por variables CSS de manera gradual, por bloque visual y con comprobación de páginas afectadas.
4. Crear `css/components/` solo para componentes que ya sean reutilizables, empezando por uno de estos:
   - Tarjetas de catálogo.
   - Botones de streaming.
   - Panel administrativo.
5. Revisar las hojas de Firelink antes de unificarlas:
   - Corregir primero la carga duplicada de `estiloFirelink1.css` en `firelinkPlantilla.php`.
   - Comparar visualmente Firelink antes de fusionar `estiloFirelink1.css` y `estiloFirelink3.css`.
6. No actualizar Bootstrap ni eliminar compatibilidad heredada en esta fase.

**Criterio de salida:** el diseño se mantiene estable y los nuevos valores corporativos se centralizan progresivamente en variables CSS.

---

## 4. Modernizar JavaScript por flujo funcional

1. Documentar para cada formulario su página, script cliente, endpoint PHP y comportamiento esperado.
2. Migrar los flujos en este orden:
   1. Aplicación de cupón.
   2. Registro de usuario.
   3. Alta de dirección.
3. Sustituir la validación visual dependiente de jQuery por validación nativa HTML5 y Constraint Validation API.
4. Mantener siempre la validación del lado de PHP como validación definitiva.
5. Sustituir redirecciones `window.location` por `header('Location: ...')` solo cuando el archivo no haya enviado salida y validando cada flujo por separado.
6. No migrar el carrito a peticiones asíncronas aún; corresponde a la Fase 6 del plan general.

**Criterio de salida:** los tres formularios priorizados funcionan sin depender de jQuery para su validación de interfaz y conservan la validación del servidor.

---

## 5. Retirar código obsoleto de forma controlada

1. Buscar todos los consumidores activos antes de eliminar una dependencia o archivo.
2. No eliminar `js/jqBootstrapValidation.js` hasta migrar y comprobar sus consumidores activos, incluyendo `digitales.php` y las plantillas que lo usen.
3. Verificar si `funciones.js` tiene consumidores; eliminarlo solo si no los tiene.
4. Eliminar `js/prueba.js` únicamente después de confirmar que no se carga en páginas activas.
5. Mantener las copias de recursos dentro de plantillas fuera del alcance inicial, salvo que formen parte del sitio publicado.

**Criterio de salida:** no quedan referencias rotas a archivos eliminados y no se ha afectado el sitio público ni las plantillas usadas.

---

## 6. Validar y cerrar la fase

1. Probar la lista de páginas críticas en escritorio y móvil.
2. Revisar consola del navegador, errores PHP y carga correcta de recursos estáticos.
3. Mantener cambios pequeños y separados por tema:
   - Configuración y seguridad.
   - Variables CSS.
   - Cada flujo de formulario.
   - Limpieza de código obsoleto.
4. Registrar las pruebas realizadas antes de integrar los cambios a `develop`.

**Criterio de salida:** cada cambio de la Fase 1 está validado, es reversible y puede desplegarse independientemente en DreamHost.
