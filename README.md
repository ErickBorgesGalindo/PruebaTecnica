# TAP Terminal - Sistema de Gestion

Examen de Admision - Area de Desarrollo

**Fecha:** 13 de Julio del 2025
**Candidato:** Erick Borges
**Ubicacion:** Manzanillo, Colima

---

## Descripcion del Proyecto

Sistema de gestion integral para TAP Terminal que permite administrar productos, usuarios y perfiles de acceso. El sistema incluye autenticacion segura, control de acceso por roles, exportacion de reportes, y un registro completo de auditoria de cambios.

---

## Stack Tecnologico

| Capa | Tecnologia | Version |
|------|-----------|---------|
| Backend | Laravel | 11 |
| Lenguaje Backend | PHP | 8.2+ |
| Frontend | Angular | 19 |
| Lenguaje Frontend | TypeScript | 5.0+ |
| Base de datos | MongoDB | 7.0 |
| Autenticacion | JWT (tymon/jwt-auth) | 2.3 |
| Exportacion PDF | DomPDF | - |
| Exportacion Excel | Maatwebsite Excel | - |
| Control de versiones | Git | 2.51 |

---

## Arquitectura del Sistema

```
PruebaTecnica/
├── backend/                    # Laravel 11 - API REST
│   ├── app/
│   │   ├── Exports/           # Clases de exportacion Excel
│   │   │   ├── ProductsExport.php
│   │   │   ├── UsersExport.php
│   │   │   └── ProfilesExport.php
│   │   ├── Http/Controllers/
│   │   │   ├── AuthController.php          # Login, Logout, Forgot Password
│   │   │   ├── ProductController.php       # CRUD Productos
│   │   │   ├── UserController.php          # CRUD Usuarios
│   │   │   ├── ProfileController.php       # CRUD Perfiles
│   │   │   ├── UserProfileController.php   # Relacion Usuario-Perfil
│   │   │   ├── AuditLogController.php      # Bitacora de cambios
│   │   │   └── ExportController.php        # Exportaciones PDF/Excel
│   │   ├── Models/
│   │   │   ├── Product.php
│   │   │   ├── User.php
│   │   │   ├── Profile.php
│   │   │   ├── UserProfile.php
│   │   │   └── AuditLog.php
│   │   └── Traits/
│   │       └── Auditable.php               # Trait reutilizable de auditoria
│   ├── config/
│   │   ├── database.php                    # Configuracion MongoDB
│   │   └── jwt.php                         # Configuracion JWT
│   ├── database/seeders/                   # Datos de prueba
│   ├── routes/api.php                      # Rutas de la API
│   └── postman_collection.json             # Documentacion API
│
├── frontend/                   # Angular 19 - Aplicacion SPA
│   └── src/app/
│       ├── components/
│       │   ├── login/                     # Inicio de sesion
│       │   ├── forgot-password/           # Recuperacion de contrasena
│       │   ├── unauthorized/              # Pagina de acceso denegado
│       │   ├── product-list/              # Tabla de productos
│       │   ├── product-form/              # Formulario crear/editar producto
│       │   ├── user-list/                 # Tabla de usuarios
│       │   ├── user-form/                 # Formulario crear/editar usuario
│       │   ├── user-detail/               # Detalle de usuario (modal)
│       │   ├── profile-list/              # Tabla de perfiles
│       │   ├── profile-form/              # Formulario crear/editar perfil
│       │   └── audit-log-list/            # Bitacora de cambios
│       ├── guards/
│       │   ├── auth.guard.ts              # Guard de autenticacion
│       │   └── section.guard.ts           # Guard de acceso por seccion
│       ├── interceptors/
│       │   └── auth.interceptor.ts        # Interceptor JWT
│       ├── services/
│       │   ├── auth.service.ts            # Servicio de autenticacion
│       │   ├── product.service.ts         # Servicio de productos
│       │   ├── user.service.ts            # Servicio de usuarios
│       │   ├── profile.service.ts         # Servicio de perfiles
│       │   └── audit-log.service.ts       # Servicio de bitacora
│       └── app.routes.ts                  # Rutas de Angular
│
└── postman_collection.json     # Coleccion de Postman
```

---

## Modelo de Base de Datos (MongoDB)

### Coleccion `products`
```json
{
  "_id": "ObjectId",
  "code": "PROD-XXXXXX",
  "name": "string",
  "brand": "string",
  "price": "number (max 999)",
  "created_at": "datetime",
  "updated_at": "datetime"
}
```

### Coleccion `users`
```json
{
  "_id": "ObjectId",
  "code": "USR-XXXXXX",
  "name": "string",
  "email": "string (unico)",
  "phone": "string (opcional, con codigo de pais)",
  "photo_url": "string",
  "password": "string (cifrado con bcrypt)",
  "created_at": "datetime",
  "updated_at": "datetime"
}
```

### Coleccion `profiles`
```json
{
  "_id": "ObjectId",
  "code": "PRF-XXXXXX",
  "name": "string",
  "sections": ["string"],
  "created_at": "datetime",
  "updated_at": "datetime"
}
```

### Coleccion `user_profiles`
```json
{
  "_id": "ObjectId",
  "user_id": "string",
  "profile_id": "string",
  "created_at": "datetime"
}
```

### Coleccion `audit_logs`
```json
{
  "_id": "ObjectId",
  "entity_type": "string",
  "entity_id": "string",
  "action": "string",
  "old_data": "object|null",
  "new_data": "object|null",
  "user_id": "string",
  "user_name": "string",
  "created_at": "datetime"
}
```

---

## Endpoints de la API

### Autenticacion (no requiere token)

| Metodo | URL | Descripcion |
|--------|-----|-------------|
| POST | `/api/auth/login` | Iniciar sesion |
| POST | `/api/auth/forgot-password` | Recuperar contrasena |

### Autenticacion (requiere token)

| Metodo | URL | Descripcion |
|--------|-----|-------------|
| POST | `/api/auth/logout` | Cerrar sesion |
| GET | `/api/auth/me` | Usuario actual con perfiles y secciones |

### Productos

| Metodo | URL | Descripcion |
|--------|-----|-------------|
| GET | `/api/products` | Listar todos |
| POST | `/api/products` | Crear nuevo |
| GET | `/api/products/{id}` | Obtener uno |
| PUT | `/api/products/{id}` | Actualizar |
| DELETE | `/api/products/{id}` | Eliminar |

### Usuarios

| Metodo | URL | Descripcion |
|--------|-----|-------------|
| GET | `/api/users` | Listar todos |
| POST | `/api/users` | Crear nuevo |
| GET | `/api/users/{id}` | Obtener uno |
| PUT | `/api/users/{id}` | Actualizar |
| DELETE | `/api/users/{id}` | Eliminar |
| GET | `/api/users/{id}/profiles` | Perfiles asignados |

### Perfiles

| Metodo | URL | Descripcion |
|--------|-----|-------------|
| GET | `/api/profiles` | Listar todos |
| POST | `/api/profiles` | Crear nuevo |
| GET | `/api/profiles/{id}` | Obtener uno |
| PUT | `/api/profiles/{id}` | Actualizar |
| DELETE | `/api/profiles/{id}` | Eliminar |

### Relacion Usuario-Perfil

| Metodo | URL | Descripcion |
|--------|-----|-------------|
| GET | `/api/user-profiles` | Listar relaciones |
| POST | `/api/user-profiles` | Asignar perfil a usuario |
| DELETE | `/api/user-profiles/{id}` | Desasignar perfil |

### Exportaciones (descarga archivos)

| Metodo | URL | Descripcion |
|--------|-----|-------------|
| GET | `/api/export/products/pdf` | Productos en PDF |
| GET | `/api/export/products/excel` | Productos en Excel |
| GET | `/api/export/users/pdf` | Usuarios en PDF |
| GET | `/api/export/users/excel` | Usuarios en Excel |
| GET | `/api/export/profiles/pdf` | Perfiles en PDF |
| GET | `/api/export/profiles/excel` | Perfiles en Excel |

### Bitacora

| Metodo | URL | Descripcion |
|--------|-----|-------------|
| GET | `/api/audit-logs` | Listar registros |
| GET | `/api/audit-logs?entity_type=product` | Filtrar por entidad |
| GET | `/api/audit-logs?action=updated` | Filtrar por accion |

---

## Funcionalidades Implementadas

### 1. Gestion de Productos
- Alta automatica con codigo generado (`PROD-XXXXXX`)
- Formulario con validacion de precio maximo (3 digitos)
- Tabla con codigo, nombre, marca, precio y fecha de creacion
- Edicion y eliminacion con confirmacion
- Exportacion a PDF y Excel

### 2. Gestion de Usuarios
- Alta automatica con codigo generado (`USR-XXXXXX`)
- Validacion de email unico
- Campo de telefono con codigo de pais
- Foto de perfil (URL)
- Contrasena temporal cifrada con bcrypt
- Detalle de usuario con foto, datos y perfiles asignados
- Exportacion a PDF y Excel

### 3. Gestion de Perfiles
- Alta automatica con codigo generado (`PRF-XXXXXX`)
- Seleccion de secciones con checkboxes
- Detalle en modal con secciones relacionadas
- Exportacion a PDF y Excel

### 4. Autenticacion y Seguridad
- Login con JWT (JSON Web Token)
- Logout que invalida el token
- Recuperacion de contrasena con contrasena temporal
- Cifrado de contrasenas con bcrypt
- HTTP Interceptor que agrega el token automaticamente

### 5. Control de Acceso
- Cada usuario tiene perfiles asignados
- Cada perfil define las secciones a las que tiene acceso
- Guard de Angular que verifica permisos antes de cada ruta
- Navbar dinamico que solo muestra las secciones permitidas
- Pagina de acceso denegado para rutas no autorizadas

### 6. Bitacora de Cambios
- Registro automatico de creaciones, ediciones y eliminaciones
- Almacena datos anteriores y nuevos para comparacion
- Registra quien hizo el cambio y cuando
- Filtros por tipo de entidad y tipo de accion
- Visualizacion formateada de los cambios

### 7. Documentacion API
- Coleccion de Postman con todas las peticiones
- Variables de entorno configuradas
- Descripcion de cada endpoint
- Ejemplos de body para POST/PUT

---

## Credenciales de Prueba

| Usuario | Email | Contrasena | Perfil | Acceso |
|---------|-------|------------|--------|--------|
| Admin | admin@test.com | password123 | Administrador | Productos, Usuarios, Perfiles, Bitacora |
| Maria Lopez | maria@test.com | password123 | Solo Lectura | Productos |

---

## Instalacion y Ejecucion

### Prerrequisitos
- PHP 8.2+
- Composer
- Node.js 18+
- MongoDB 7.0+
- Angular CLI 19+

### Backend (Laravel)

```bash
# Entrar a la carpeta del backend
cd backend

# Instalar dependencias
composer install

# Configurar archivo .env
cp .env.example .env

# Configurar MongoDB en .env
DB_CONNECTION=mongodb
MONGODB_HOST=127.0.0.1
MONGODB_PORT=27017
MONGODB_DATABASE=tap_terminal

# Generar clave JWT
php artisan jwt:secret

# Ejecutar seeders (datos de prueba)
php artisan db:seed

# Iniciar servidor
php artisan serve
```

El servidor estara disponible en `http://127.0.0.1:8000`

### Frontend (Angular)

```bash
# Entrar a la carpeta del frontend
cd frontend

# Instalar dependencias
npm install

# Iniciar servidor de desarrollo
ng serve
```

La aplicacion estara disponible en `http://localhost:4200`

### Postman

1. Abrir Postman
2. Importar `postman_collection.json`
3. Crear entorno con variable `baseUrl = http://127.0.0.1:8000/api`
4. Ejecutar peticion de Login para obtener el token
5. Guardar el token en la variable de entorno `token`

---

## Decisiones Tecnicas

### Por que MongoDB?
Se utilizo MongoDB como base de datos NoSQL porque el examen lo requeria y permite un modelado flexible de datos. Las coleccionaes se disenaron con esquemas claros pero sin la rigidez de una base de datos relacional, lo que facilita la evolucion del modelo.

### Por que JWT?
JWT (JSON Web Token) es un estandar para autenticacion stateless. Permite al servidor validar al usuario sin mantener estado, lo que facilita la escalabilidad. El token se genera en el login y se envia en cada peticion posterior.

### Por que un Trait de auditoria?
En lugar de duplicar la logica de registro de cambios en cada controlador, se creo un trait `Auditable` que se puede mezclar en cualquier controlador. Esto sigue el principio DRY (Don't Repeat Yourself) y facilita agregar auditoria a nuevos modulos.

### Por que Guards en Angular?
Los guards son el mecanismo nativo de Angular para proteger rutas. Se implementaron dos capas: `AuthGuard` verifica que el usuario este logueado, y `SectionGuard` verifica que tenga permiso para la seccion especifica. Esto cumple con el requisito de que "los usuarios solo podran ingresar a las secciones asignadas en sus perfiles".

---

## Criterios de Evaluacion Cumplidos

| Criterio | Puntos | Implementacion |
|----------|--------|----------------|
| Funcionamiento General | 30% | CRUD completo de 3 modulos, autenticacion, exportaciones, bitacora |
| Codigo Limpio | 20% | Estructura organizada, servicios reutilizables, traits, PSR-12 en PHP |
| Uso correcto de BD | 15% | MongoDB con colecciones bien disenadas, relaciones por referencias |
| Seguridad | 15% | JWT, bcrypt, control de acceso por secciones, validaciones |
| Documentacion | 10% | Coleccion Postman completa, README detallado |
| Extras | 10% | Bitacora de auditoria, exportaciones PDF/Excel, estilos UI |
