# Jellyfin / Emby Random Movie Picker

![Vista previa de la interfaz](https://i.ibb.co/FkvHR2z8/image.png)

Una aplicación web ligera que se conecta a la API de tu servidor local (Jellyfin o Emby) para recomendarte una película aleatoria de tu biblioteca. Está diseñada centrándose en la experiencia de usuario (UX) y construida con tecnologías nativas, sin depender de frameworks de terceros.

## Características Destacadas

* **Interfaz Cinematográfica:** Animaciones fluidas de entrada y salida, desenfoques (blur) y escalado para dar la sensación de estar viendo un cartel de cine real.
* **Carga Asíncrona:** Implementación de "Skeleton Loaders" y precarga de imágenes en segundo plano con JavaScript puro para evitar parpadeos molestos o espacios en blanco.
* **API Wrapper Seguro:** Backend en PHP que hace de puente con el servidor. Oculta tu Token de acceso real y gestiona las peticiones de forma eficiente mediante cURL.
* **Manejo de Errores:** Si el servidor se cae, no hay películas o falta configurar algo, la interfaz te avisa de forma amigable en lugar de romperse.
* **Diseño Responsivo:** Adaptado 100% a móviles, usando la tipografía moderna Plus Jakarta Sans.

## Stack Tecnológico

* **Frontend:** HTML5, CSS3 (Animaciones, Backdrop-filter, Flexbox) y Vanilla JavaScript (Fetch API, manipulación del DOM).
* **Backend:** PHP 8+ (cURL, manejo de JSON).
* **Servidores compatibles:** Emby y Jellyfin.

## Instalación y Configuración

Como la aplicación interactúa con un servidor local, necesitas alojarla en un entorno que soporte PHP (por ejemplo, XAMPP, Laragon, un contenedor Docker o directamente en tu NAS).

**1. Clonar el proyecto**
```bash
git clone https://github.com/ysflamine/jellyfin-random-movie.git
```

**2. Configurar credenciales**
Ve a la carpeta backend/ y renombra el archivo config.example.php a config.php. Luego, abre el archivo y pon tu IP y tu Token de acceso:

```php
//backend/config.php
define("SERVER_URL", "http://TU_IP:PUERTO"); 
define("API_TOKEN", "TU_TOKEN_GENERADO");
```

**3. Listo para usar**

Coloca la carpeta del proyecto en el directorio público de tu servidor web (como htdocs o www) y abre la ruta frontend/ desde tu navegador.
