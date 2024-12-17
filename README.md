# WooCommerce FacturaE XML Generator

Genera archivos XML en formato **FacturaE** para los pedidos de **WooCommerce**.

## Descripción

El plugin **WooCommerce FacturaE XML Generator** permite a los propietarios de tiendas WooCommerce generar archivos en formato **FacturaE** a partir de sus pedidos. Este plugin es especialmente útil para aquellos usuarios que necesitan cumplir con las normativas fiscales en España, generando facturas electrónicas en formato XML según las especificaciones del modelo FacturaE.

## Características

- **Generación automática de FacturaE**: Convierte los pedidos de WooCommerce en archivos XML en formato FacturaE.
- **Integración con WooCommerce PDF Invoices & Packing Slips**: Utiliza el número de factura generado por el plugin **WooCommerce PDF Invoices & Packing Slips** si está instalado y activo.
- **Personalización de la información de la empresa**: Puedes configurar la información de tu empresa (nombre, NIF, dirección, ciudad, código postal y país) desde la página de configuración del plugin.
- **Generación de archivos XML**: Los administradores de la tienda pueden descargar los archivos XML directamente desde la página de pedidos de WooCommerce.
- **Compatibilidad**: El plugin comprueba que WooCommerce y el plugin **WooCommerce PDF Invoices & Packing Slips** estén activos antes de generar los archivos XML.

## Instalación

1. **Sube el plugin**:
   - Descarga el plugin y sube la carpeta `wc-facturae-generator` al directorio de plugins de tu instalación de WordPress (`wp-content/plugins`).
   
2. **Activa el plugin**:
   - Ve a `Plugins > Plugins instalados` en el panel de administración de WordPress y activa el plugin **WooCommerce FacturaE XML Generator**.

3. **Configuración de la empresa**:
   - Dirígete a `WooCommerce > FacturaE XML Generator` para configurar la información de tu empresa (nombre, NIF, dirección, ciudad, código postal y país).

4. **Instalar WooCommerce PDF Invoices & Packing Slips**:
   - Si aún no lo tienes instalado, el plugin **WooCommerce PDF Invoices & Packing Slips** es necesario para generar las facturas correctamente. Puedes instalarlo desde el repositorio de plugins de WordPress.

## Uso

1. **Generar FacturaE**:
   - Una vez activado el plugin, dirígete a la página de pedidos de WooCommerce (`WooCommerce > Pedidos`).
   - En cada pedido, encontrarás un botón **"Descargar XML FacturaE"** en la lista de acciones del pedido.
   - Haz clic en el botón para generar y descargar el archivo XML de la factura.

2. **Formato de los archivos XML**:
   - El archivo XML generado incluirá la información del pedido, datos de la empresa y del cliente, así como las líneas de los productos y los totales de la factura.

## Requisitos

- **WooCommerce**: El plugin requiere WooCommerce para funcionar correctamente.
- **WooCommerce PDF Invoices & Packing Slips**: Este plugin es opcional pero recomendado para generar los números de factura y otros datos relacionados con la facturación.

## Configuración

Puedes configurar los siguientes parámetros de tu empresa desde la página de configuración del plugin:

- **Nombre de la Empresa**: El nombre legal de tu empresa.
- **NIF de la Empresa**: El número de identificación fiscal de tu empresa.
- **Dirección de la Empresa**: La dirección fiscal de tu empresa.
- **Ciudad de la Empresa**: La ciudad en la que se encuentra tu empresa.
- **Código Postal de la Empresa**: El código postal de la dirección de tu empresa.
- **País de la Empresa**: El país en el que está registrada tu empresa.

## Notas

- El plugin comprobará si **WooCommerce** y **WooCommerce PDF Invoices & Packing Slips** están activos. Si alguno de estos no está activo, mostrará una notificación de error en el panel de administración.
- Si necesitas soporte, por favor contacta con el desarrollador en [xarop.com](https://xarop.com).

## Licencia

Este plugin está licenciado bajo la **GPL2**.

## Contribuciones

Si deseas contribuir al desarrollo de este plugin, siéntete libre de realizar un **fork** del repositorio y enviar **pull requests** con tus mejoras.

## Autor

Desarrollado por **xarop.com**.
