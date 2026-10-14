# Prueba Técnica Junior PHP - MisterPlan

Hola, esta es mi entrega para la prueba técnica de gestión de reservas. La aplicación permite ver un listado de las reservas, filtrarlas por varios campos, crear nuevas y cambiar su estado (a confirmada o cancelada). También incluye una vista de detalles con un historial de lo que ha pasado con cada reserva.

## Tecnologías que he utilizado

* Backend: PHP organizado en MVC.
* Base de datos: MySQL.
* Plantillas: Twig (usando herencia para reutilizar el diseño).
* Frontend: HTML, CSS normal (sin frameworks) y Vanilla JavaScript usando fetch para peticiones asíncronas.

## Pasos para probar el proyecto

1. Copiar la carpeta del proyecto en el directorio del servidor local (por ejemplo, dentro de htdocs si usas XAMPP).
2. Crear una base de datos en MySQL que se llame `misterplan_reservas`.
3. Importar el archivo `schema.sql` que he dejado en la raíz del proyecto. Esto creará las dos tablas (`reserva` y `reserva_evento`) automáticamente.
4. Hacer una copia del archivo .env.example que está en la raíz, renombrarlo a .env y poner ahí tu usuario y contraseña de MySQL.
5. Abrir la terminal en la carpeta del proyecto e instalar las dependencias (como Twig) ejecutando el comando: `composer install`
6. Entrar a la ruta del proyecto desde el navegador.

## Notas sobre el código

Quería comentar un par de decisiones que he tomado al hacer la prueba:

* Cancelar en lugar de borrar: He evitado usar un DELETE en SQL cuando se cancela una reserva. En su lugar, hago un UPDATE para cambiar el estado a "cancelada". Así no perdemos los datos y queda el registro, como se haría en un entorno real.
* El historial: Sabía que el timeline de eventos se podía hacer directamente en la base de datos usando Triggers, pero he preferido hacer los INSERT desde el código PHP en el modelo. Me resulta más fácil de controlar la lógica de negocio y manejar posibles errores desde la aplicación.
* Validaciones: He puesto validaciones en el controlador de PHP para que no deje guardar reservas con fechas sin sentido (como salir antes de entrar) o precios en negativo.
* Peticiones asíncronas: Toda la interacción de filtrado, creación de reservas y cambio de estados se realiza mediante JavaScript (`fetch`) manipulando el DOM, garantizando que el usuario no sufra recargas completas de la página.

Alba Canelo Durán