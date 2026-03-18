NORTRANS-APPS
Sistema web desarrollado para la gestión administrativa y consumo de API, ejecutado en entorno local mediante XAMPP.

Descripción del Proyecto
NORTRANS-APPS es una aplicación web estructurada en dos módulos principales:
API: Encargada de la lógica del sistema y exposición de servicios.
ADM: Panel administrativo para la gestión del sistema.
El proyecto ya cuenta con su configuración interna, por lo que no requiere ajustes adicionales de conexión a base de datos.

Requisitos
Antes de ejecutar el proyecto, asegurate de tener instalado:
XAMPP
Apache (incluido en XAMPP)
Navegador web (Chrome, Edge, etc.)

Estructura del Proyecto
La estructura de carpetas debe ser exactamente la siguiente:

C:\
 └── xampp\
      └── htdocs\
           └── nortrans-apps\
                ├── api....
                └── adm....


Importante
El nombre de la carpeta debe ser exactamente:
nortrans-apps
Debe estar ubicada en:

C:\xampp\htdocs\

Instalación y Ejecución
1. Clonar o copiar el proyecto

Ubicar el proyecto en:

C:\xampp\htdocs\nortrans-apps

2. Iniciar XAMPP
Abrir el panel de control de XAMPP y levantar:
Apache

3. Acceder al sistema
Una vez iniciado Apache, abrir en el navegador:

🔹 Módulo Administrativo

http://localhost/nortrans-apps/adm...

Tecnologías Utilizadas
PHP
HTML / CSS / JavaScript
XAMPP (Apache)

Consideraciones
El sistema está preparado para funcionar directamente sin configuraciones adicionales.
Es importante respetar la estructura de carpetas indicada.
Si Apache utiliza otro puerto (por ejemplo 8080), la URL cambiaría:

http://localhost:8080/nortrans-apps/

Autor
Desarrollado por Ing. Alberto Ferreira. Ing. Jennifer Salinas 
