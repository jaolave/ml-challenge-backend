# Guía de Ejecución - ML Challenge Backend

## Descripción

Esta es una API REST desarrollada en Laravel que proporciona acceso a datos JSON estáticos a través de endpoints RESTful. La API está diseñada para servir información sobre productos, vendedores, métodos de pago, ofertas, preguntas y reseñas.

## Requisitos del Sistema

- **PHP**: 8.2 o superior
- **Composer**: Para gestión de dependencias
- **Extensiones PHP requeridas**:
  - OpenSSL
  - PDO
  - Mbstring
  - Tokenizer
  - XML
  - Ctype
  - JSON
  - BCMath

## Instalación y Configuración

### 1. Instalar Dependencias

Ejecuta el siguiente comando en la raíz del proyecto para instalar todas las dependencias de Composer:

```bash
composer install
```

### 2. Configuración del Entorno

El archivo `.env` ya está configurado para usar cache de archivos. No requiere configuración adicional de base de datos para el funcionamiento básico.

### 3. Generar Clave de Aplicación (si es necesario)

Si el archivo `.env` no tiene la clave `APP_KEY` configurada, ejecuta:

```bash
php artisan key:generate
```

### 4. Crear Enlaces Simbólicos (Opcional)

Si planeas usar almacenamiento público:

```bash
php artisan storage:link
```

### 5. Optimizar la Aplicación (Opcional para Producción)

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

## Ejecución del Proyecto

### Servidor de Desarrollo

Para ejecutar el servidor de desarrollo de Laravel:

```bash
php artisan serve
```

Por defecto, la aplicación estará disponible en: `http://localhost:8000`

### Especificar Puerto Personalizado

Si necesitas usar un puerto diferente:

```bash
php artisan serve --port=8080
```

### Especificar Host Personalizado

Para hacer la aplicación accesible desde otras máquinas en la red:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

## Endpoints de la API

La API está disponible bajo el prefijo `/api/v1/` y soporta los siguientes recursos:

### Recursos Disponibles

- `products` - Productos
- `sellers` - Vendedores
- `payment_methods` - Métodos de pago
- `product_offers` - Ofertas de productos
- `questions` - Preguntas
- `reviews` - Reseñas

### Endpoints

#### Listar todos los elementos de un recurso
```
GET /api/v1/{resource}
```

**Ejemplos:**
- `GET http://localhost:8000/api/v1/products`
- `GET http://localhost:8000/api/v1/sellers`
- `GET http://localhost:8000/api/v1/payment_methods`

#### Obtener un elemento específico por ID
```
GET /api/v1/{resource}/{id}
```

**Ejemplos:**
- `GET http://localhost:8000/api/v1/products/1`
- `GET http://localhost:8000/api/v1/sellers/2`
- `GET http://localhost:8000/api/v1/payment_methods/3`

## Estructura de Datos

Los datos se almacenan en archivos JSON ubicados en `storage/app/data/`. Cada recurso tiene su propio archivo:

- `storage/app/data/products.json`
- `storage/app/data/sellers.json`
- `storage/app/data/payment_methods.json`
- `storage/app/data/product_offers.json`
- `storage/app/data/questions.json`
- `storage/app/data/reviews.json`

## Cache

La aplicación utiliza cache de archivos para mejorar el rendimiento. Los datos JSON se cachean por 1 hora (3600 segundos).

### Limpiar Cache

Si necesitas limpiar el cache:

```bash
php artisan cache:clear
```

## Resolución de Problemas

### Error: "Class not found"

Ejecuta:
```bash
composer dump-autoload
```

### Error de Permisos

Asegúrate de que los directorios `storage` y `bootstrap/cache` tengan permisos de escritura:

```bash
chmod -R 775 storage bootstrap/cache
```

### Error: "No application encryption key has been specified"

Ejecuta:
```bash
php artisan key:generate
```

### Puerto en Uso

Si el puerto 8000 está ocupado, especifica otro puerto:
```bash
php artisan serve --port=8080
```

## Logs

Los logs de la aplicación se encuentran en:
- `storage/logs/laravel.log`

Para monitorear los logs en tiempo real:
```bash
tail -f storage/logs/laravel.log
```

## Información de Contacto y Debug

Para verificar que la aplicación está funcionando correctamente, visita:
- `http://localhost:8000/` - Página de inicio con información de la API
- `http://localhost:8000/api/v1/products` - Ejemplo de endpoint

## Notas Adicionales

- El modo debug está habilitado en desarrollo (`APP_DEBUG=true`)
- Los archivos de datos JSON deben existir en `storage/app/data/` para que los endpoints funcionen correctamente
- La validación de recursos se basa en la configuración en `config/resources.php`

## Testing y Cobertura de Código

### Ejecutar Pruebas

El proyecto incluye un conjunto completo de pruebas unitarias y funcionales que cubren toda la funcionalidad existente.

#### Ejecutar todas las pruebas
```bash
php artisan test
```

#### Ejecutar solo pruebas unitarias
```bash
php artisan test --testsuite=Unit
```

#### Ejecutar solo pruebas funcionales
```bash
php artisan test --testsuite=Feature
```

#### Ejecutar pruebas con información detallada
```bash
php artisan test --verbose
```

### Cobertura de Pruebas

Las pruebas implementadas cubren:

#### 1. JsonDataService (Pruebas unitarias)
- ✅ Obtención de todos los registros de recursos existentes
- ✅ Manejo de recursos no existentes (retorna `null`)
- ✅ Búsqueda por ID en formato objeto
- ✅ Búsqueda por clave en payment_methods
- ✅ Manejo de IDs no encontrados
- ✅ Funcionalidad de caché (verificación de implementación)
- ✅ Comparación flexible de IDs (string vs entero)
- ✅ Pruebas con todos los tipos de recursos disponibles

#### 2. ResourceValidationService (Pruebas unitarias)
- ✅ Validación de recursos permitidos
- ✅ Rechazo de recursos no permitidos
- ✅ Validación case-insensitive
- ✅ Obtención de lista de recursos permitidos
- ✅ Adición de nuevos recursos
- ✅ Prevención de duplicados
- ✅ Eliminación de recursos existentes
- ✅ Manejo de eliminación de recursos inexistentes
- ✅ Operaciones múltiples de adición/eliminación
- ✅ Preservación de recursos originales después de modificaciones

#### 3. DataController (Pruebas funcionales)
- ✅ Acceso a todos los recursos permitidos (products, sellers, payment_methods, etc.)
- ✅ Respuestas HTTP 404 para recursos no permitidos
- ✅ Obtención de elementos específicos por ID
- ✅ Manejo case-insensitive de nombres de recursos
- ✅ Validación de formatos de parámetros de rutas
- ✅ Manejo de diferentes formatos de datos JSON
- ✅ Estructura consistente de respuestas JSON
- ✅ Manejo correcto de IDs string y numéricos
- ✅ Validación de endpoints con caracteres especiales
- ✅ Verificación de headers de respuesta

### Archivos de Pruebas

```
tests/
├── Unit/
│   ├── JsonDataServiceTest.php          # Pruebas del servicio de datos JSON
│   └── ResourceValidationServiceTest.php # Pruebas del servicio de validación
└── Feature/
    └── DataControllerTest.php            # Pruebas de los endpoints de la API
```

### Consideraciones Importantes

- Las pruebas **NO modifican** los archivos de datos originales en `storage/app/data/`
- Se implementa limpieza de caché antes y después de cada prueba
- Las pruebas cubren **solo funcionalidad existente**, sin agregar lógica adicional
- Compatible con la estructura real de datos JSON del proyecto

### Configuración para Cobertura de Código

Para generar reportes de cobertura detallados, instala Xdebug o PCOV:

**Con Xdebug:**
```bash
# Windows (con Chocolatey)
choco install php-xdebug

# O instalar manualmente según tu configuración de PHP
```

**Luego ejecutar:**
```bash
php artisan test --coverage
```

### Pruebas Fallando

Si alguna prueba falla, verifica:

1. **Cache limpio**: `php artisan cache:clear`
2. **Archivos de datos**: Verificar que existan todos los archivos JSON en `storage/app/data/`
3. **Permisos**: Asegúrate de que el directorio storage tenga permisos de escritura
4. **Dependencias**: Ejecutar `composer install` si es necesario
