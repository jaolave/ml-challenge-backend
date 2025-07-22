# Challenge Frontend - Product Detail Page

Aplicación web desarrollada en Laravel que proporciona una API REST para acceder a datos JSON estáticos. Esta API simula un marketplace y permite consultar información sobre productos, vendedores, métodos de pago, ofertas, preguntas y reseñas.

<p align="center">
<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="200" alt="Laravel Logo">
</p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Laravel Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Descripción del Proyecto

API REST desarrollada en Laravel que proporciona acceso a datos JSON estáticos a través de endpoints RESTful. Esta aplicación está diseñada para servir información sobre productos, vendedores, métodos de pago, ofertas, preguntas y reseñas, simulando una arquitectura de microservicios para un marketplace.

## Características Principales

- 🚀 **API REST** con endpoints organizados y versionados
- 📊 **Gestión de datos JSON** estáticos sin base de datos tradicional
- 🔍 **Validación de recursos** configurable y extensible
- ⚡ **Sistema de caché** integrado para optimización de rendimiento
- 🧪 **Suite completa de pruebas** unitarias y funcionales
- 📝 **Documentación completa** de endpoints y configuración

## Tecnologías Utilizadas

- **Laravel 11.x** - Framework PHP
- **PHP 8.2+** - Lenguaje de programación
- **Composer** - Gestión de dependencias
- **PHPUnit** - Framework de testing
- **JSON** - Almacenamiento de datos

## Instalación Rápida

### Requisitos Previos

- PHP 8.2 o superior
- Composer
- Extensiones PHP: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone <repository-url>
cd ml-challenge-backend
```

2. **Instalar dependencias**
```bash
composer install
```

3. **Configurar el entorno**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Iniciar el servidor de desarrollo**
```bash
php artisan serve
```

La aplicación estará disponible en `http://localhost:8000`

## Endpoints de la API

### Base URL
```
http://localhost:8000/api/v1/
```

### Recursos Disponibles

| Recurso | Descripción |
|---------|-------------|
| `products` | Información de productos del marketplace |
| `sellers` | Datos de vendedores y tiendas |
| `payment_methods` | Métodos de pago disponibles |
| `product_offers` | Ofertas especiales de productos |
| `questions` | Preguntas de usuarios sobre productos |
| `reviews` | Reseñas y calificaciones |

### Ejemplos de Uso

**Obtener todos los productos:**
```bash
GET /api/v1/products
```

**Obtener un producto específico:**
```bash
GET /api/v1/products/1
```

**Obtener todos los vendedores:**
```bash
GET /api/v1/sellers
```

**Obtener un vendedor específico:**
```bash
GET /api/v1/sellers/1
```

## Estructura del Proyecto

```
app/
├── Http/Controllers/Api/V1/
│   └── DataController.php          # Controlador principal de la API
├── Services/
│   ├── JsonDataService.php         # Servicio para manejo de datos JSON
│   └── ResourceValidationService.php # Servicio de validación de recursos
config/
└── resources.php                   # Configuración de recursos permitidos
storage/app/data/
├── products.json                   # Datos de productos
├── sellers.json                    # Datos de vendedores
├── payment_methods.json            # Métodos de pago
├── product_offers.json             # Ofertas
├── questions.json                  # Preguntas
└── reviews.json                    # Reseñas
tests/
├── Unit/                          # Pruebas unitarias
└── Feature/                       # Pruebas funcionales
```

## Testing

El proyecto incluye una suite completa de pruebas que cubre toda la funcionalidad:

### Ejecutar todas las pruebas
```bash
php artisan test
```

### Ejecutar pruebas específicas
```bash
# Solo pruebas unitarias
php artisan test --testsuite=Unit

# Solo pruebas funcionales  
php artisan test --testsuite=Feature

# Con información detallada
php artisan test --verbose
```

### Cobertura de Pruebas

- ✅ **JsonDataService** - Manejo de datos JSON y caché
- ✅ **ResourceValidationService** - Validación de recursos
- ✅ **DataController** - Endpoints de la API
- ✅ **Casos edge** - Manejo de errores y validaciones

## Configuración

### Recursos Permitidos

Los recursos de la API se configuran en `config/resources.php`:

```php
'allowed' => [
    'products',
    'sellers', 
    'payment_methods',
    'product_offers',
    'questions',
    'reviews',
],
```

### Cache

El sistema utiliza cache de archivos por defecto con TTL de 1 hora. Para limpiar el cache:

```bash
php artisan cache:clear
```

## Documentación Adicional

Para información detallada sobre instalación, configuración y resolución de problemas, consulta el archivo [run.md](./run.md).

## Arquitectura y Diseño

### Patrones Implementados

- **Service Layer Pattern** - Separación de lógica de negocio
- **Dependency Injection** - Inversión de control y testabilidad
- **Repository Pattern** - Abstracción del acceso a datos
- **RESTful API Design** - Convenciones REST estándar

### Principios SOLID

- **Single Responsibility** - Cada clase tiene una responsabilidad específica
- **Open/Closed** - Extensible sin modificar código existente
- **Dependency Inversion** - Dependencias abstraídas mediante interfaces

## Contribución

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

### Estándares de Código

- Seguir PSR-12 para estilo de código
- Escribir pruebas para nueva funcionalidad
- Documentar métodos públicos
- Mantener cobertura de pruebas alta

## Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo [LICENSE](https://opensource.org/licenses/MIT) para más detalles.

