# DWES → AP5-1 - CRUD con Doctrine ORM (Base de Datos Empresa)

## Descripción:

Esta actividad práctica implementa un sistema completo de gestión empresarial utilizando la base de datos **empresa**.
El proyecto integra Doctrine ORM con operaciones CRUD sobre productos, mientras que clientes y pedidos tienen
funcionalidad de consulta. Se utiliza el patrón arquitectónico MVC con un sistema de enrutamiento personalizado.

**Base del proyecto:** AP5-0 (eliminando la gestión de tareas)

## Estructura del Proyecto:

```
AP5-1/
├── config/
│   └── rutas.json          # Configuración de rutas de la aplicación
├── public/
│   ├── index.php           # Punto de entrada de la aplicación
│   └── assets/             # Plantillas HTML
│       ├── main.html           # Página principal con menú
│       ├── list_clients.html   # Listado de clientes
│       ├── list_orders.html    # Listado de pedidos
│       ├── detail_order.html   # Detalle de pedido
│       ├── list_products.html  # Listado de productos
│       ├── form_product.html   # Formulario crear/editar producto
│       ├── delete_product.html # Confirmación eliminación producto
│       └── 404.html            # Página de error
├── src/
│   ├── Controllers/
│   │   ├── MainController.php      # Controlador principal
│   │   ├── ClientController.php    # Controlador de clientes
│   │   ├── OrderController.php     # Controlador de pedidos
│   │   └── ProductController.php   # Controlador de productos (CRUD)
│   ├── Core/
│   │   ├── Dispatcher.php          # Dispatcher de rutas
│   │   ├── EntityManager.php       # Gestor de Doctrine
│   │   ├── Request.php             # Gestión de peticiones HTTP
│   │   └── RouteCollection.php     # Colección de rutas
│   ├── Entity/
│   │   ├── Client.php              # Entidad Client → tabla CLIENTE
│   │   ├── Order.php               # Entidad Order → tabla PEDIDO
│   │   ├── OrderDetail.php         # Entidad OrderDetail → tabla DETALLE
│   │   └── Product.php             # Entidad Product → tabla PRODUCTO
│   ├── Repository/
│   │   ├── ClientRepository.php
│   │   ├── OrderRepository.php
│   │   ├── OrderDetailRepository.php
│   │   └── ProductRepository.php
│   └── Views/
│       ├── MainView.php            # Vista principal
│       ├── ListClientsView.php     # Vista lista de clientes
│       ├── ListOrdersView.php      # Vista lista de pedidos
│       ├── DetailOrderView.php     # Vista detalle de pedido
│       ├── ListProductsView.php    # Vista lista de productos
│       ├── FormProductView.php     # Vista formulario producto
│       └── DeleteProductView.php   # Vista confirmación eliminación
├── .env                    # Variables de entorno (configuración BD)
└── composer.json           # Dependencias del proyecto
```

## Base de Datos:

### Nombre: **empresa**

**Importar:** `empresa.sql` de `.BBDD_archive`

### Tablas:

- **CLIENTE**: Información de clientes
- **PEDIDO**: Pedidos realizados por clientes
- **DETALLE**: Detalles de los pedidos (relación entre pedido y producto)
- **PRODUCTO**: Catálogo de productos

### Entidades (inglés, singular):

- `Client` → CLIENTE
- `Order` → PEDIDO
- `OrderDetail` → DETALLE
- `Product` → PRODUCTO

**IMPORTANTE:** Todas las relaciones son bidireccionales usando Doctrine ORM.

## Funcionalidades Implementadas:

### Consulta (Solo lectura):

1. **Clientes**: Listado completo de todos los clientes con toda su información
2. **Pedidos**:
    - Listado de todos los pedidos
    - Link para acceder a los detalles de cada pedido
3. **Detalle de Pedido**: Muestra información completa del pedido y todos sus detalles (productos)

### Operaciones CRUD (Solo para PRODUCTO):

1. **Create (Crear)**:
    - Formulario para crear nuevos productos
    - **Importante**: El ID del producto NO es autogenerado, debe proporcionarse manualmente
    - Campos: ID (integer, manual), Descripción (string, max 30 caracteres, único)

2. **Read (Leer)**:
    - Listado completo de todos los productos
    - Muestra ID y descripción de cada producto
    - Muestra el listado de pedidos que estan realcionados con los productos

3. **Update (Actualizar)**:
    - Formulario pre-rellenado para editar productos existentes
    - El ID no se puede modificar (campo de solo lectura)
    - Solo se puede actualizar la descripción

4. **Delete (Eliminar)**:
    - Pantalla de confirmación antes de eliminar
    - Muestra advertencia visual
    - Requiere confirmación explícita del usuario
    - Mostrar aviso si existe un error al eliminar

## Rutas Disponibles:

### Ruta Principal:

- `GET /` → Página principal con todas las opciones de navegación

### Rutas de Consulta:

- `GET /clientes` → Listado de todos los clientes
- `GET /pedidos` → Listado de todos los pedidos con link a detalles
- `GET /pedido/read/{id}` → Detalle completo de un pedido específico (muestra tabla DETALLE)

### Rutas CRUD de Productos:

- `GET /productos` → Listado de todos los productos con opciones CRUD
- `GET /producto/create` → Formulario para crear nuevo producto
- `POST /producto/create` → Procesar creación de producto
- `GET /producto/update/{id}` → Formulario para editar producto
- `POST /producto/update/{id}` → Procesar actualización de producto
- `GET /producto/delete/{id}` → Pantalla de confirmación de eliminación
- `POST /producto/delete/{id}` → Procesar eliminación de producto

## Relaciones entre Entidades:

```
Client (1) ←→ (N) Order
Order (1) ←→ (N) OrderDetail
Product (1) ←→ (N) OrderDetail
```

Todas las relaciones están implementadas de forma bidireccional:

- **Client** tiene colección de Orders
- **Order** tiene referencia a Client y colección de OrderDetails
- **Product** tiene colección de OrderDetails
- **OrderDetail** tiene referencias a Order y Product

## Recursos Generales:

Presentaciones y videos del Tema 5:

- Introducción a CRUD con Doctrine
- Operaciones Create, Read, Update, Delete
- Relaciones bidireccionales en Doctrine

Material de apoyo:

- Web oficial de Doctrine ORM (https://www.doctrine-project.org/)
- Documentación de Doctrine DBAL
- Patrón MVC en PHP
- Asociaciones en Doctrine (OneToMany, ManyToOne)

## License

This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.

<a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-nd/4.0/80x15.png" /></a>

## Credits

Authors: Fernando A. Díaz-Alonso ([@fdiaz-alonso](https://github.com/fdiaz-alonso)) & Lluís
Alandete ([@lalandete](mailto:lalandete@florida-uni.es))