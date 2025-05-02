# Proyecto de Formación - Backend

Este proyecto consiste en desarrollar el backend de una aplicación web que gestiona un listado de naves de Star Wars, con sus respectivos pilotos, utilizando Laravel y MySQL. La API REST proporciona los datos de las naves y pilotos a través de SWAPI (https://swapi.dev/).

## Requisitos

1. **Base de Datos**:
   - Utilizamos una base de datos MySQL para almacenar los datos de las naves y sus pilotos.
   
2. **API REST**:
   - El backend servirá los datos de naves y pilotos al frontend mediante una API REST.
   - La API permitirá:
     - **Mostrar naves** con todos sus pilotos asociados.
     - **Vincular pilotos** a naves.
     - **Eliminar pilotos** (eliminación real en base de datos).
   
3. **Comando Artisan**:
   - Se implementará un comando Artisan que importa todas las naves y pilotos de la API SWAPI a la base de datos local.
   - Cada vez que se ejecute el comando, se reseteará el contenido de la base de datos con los datos más recientes de la API.

4. **Transformación de Precios**:
   - El precio de las naves debe ser transformado a base 15 en el frontend, utilizando símbolos especiales.

## Funcionalidades del Backend

- **EndPoints Principales**:
  - **GET /api/starships**: Devuelve una lista de todas las naves con sus pilotos.
  - **POST /api/starships/{id}/pilots**: Permite vincular un piloto a una nave.
  - **DELETE /api/pilots/{id}**: Elimina un piloto y su relación con la nave.

- **Base de Datos**:
  - Dos tablas principales: `starships` y `pilots`.
  - Relación de muchos a muchos entre naves y pilotos.

## Requisitos

- **Laravel**
- **MySQL**
- **Comando Artisan para importar datos desde SWAPI**
- **Manejo de relaciones en base de datos** para naves y pilotos.
- **Test Funcional** para verificar las funcionalidades básicas del backend.
