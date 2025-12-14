# Laravel 11 Base Project - Clean Architecture

### Version Info
```
Laravel: 11.44.1
PHP: 8.4.4
MySQL: 8.0
```

### Setup with Docker
```bash
docker-compose up -d --build
docker compose exec php bash
composer install
cp .env.example .env
php artisan key:generate 
php artisan jwt:secret
php artisan migrate
php artisan db:seed
```

---

## 📁 Directory Structure

```
app/
├── Domain/                              # DOMAIN LAYER (Pure PHP - No Framework)
│   ├── Entities/                        # Pure PHP Entities
│   │   ├── User.php
│   │   └── PasswordResetToken.php
│   │
│   ├── Repositories/                    # Repository Interfaces
│   │   ├── UserRepositoryInterface.php
│   │   └── PasswordResetTokenRepositoryInterface.php
│   │
│   └── Services/                        # Service Interfaces
│       ├── AuthServiceInterface.php
│       ├── UserServiceInterface.php
│       └── MailServiceInterface.php
│
├── Application/                         # APPLICATION LAYER (Use Cases, DTO)
│   ├── UseCases/
│   │   ├── Auth/
│   │   │   ├── LoginUseCase.php
│   │   │   ├── LogoutUseCase.php
│   │   │   ├── RefreshTokenUseCase.php
│   │   │   ├── ForgotPasswordUseCase.php
│   │   │   └── ResetPasswordUseCase.php
│   │   │
│   │   └── User/
│   │       ├── GetUserListUseCase.php
│   │       ├── GetUserByIdUseCase.php
│   │       ├── CreateUserUseCase.php
│   │       ├── UpdateUserUseCase.php
│   │       └── DeleteUserUseCase.php
│   │
│   └── DTOs/
│       ├── Auth/
│       │   ├── LoginDTO.php
│       │   └── ResetPasswordDTO.php
│       └── User/
│           ├── CreateUserDTO.php
│           ├── UpdateUserDTO.php
│           └── ListUserDTO.php
│
├── Infrastructure/                      # INFRASTRUCTURE LAYER
│   ├── Persistence/
│   │   └── Eloquent/
│   │       ├── Models/                  # Eloquent Models (Framework-dependent)
│   │       │   ├── UserModel.php
│   │       │   └── PasswordResetTokenModel.php
│   │       │
│   │       └── Mappers/                 # Entity <-> Model Mappers
│   │           ├── UserMapper.php
│   │           └── PasswordResetTokenMapper.php
│   │
│   ├── Repositories/                    # Repository Implementations
│   │   ├── EloquentUserRepository.php
│   │   └── EloquentPasswordResetTokenRepository.php
│   │
│   ├── Services/
│   │   ├── Auth/
│   │   │   └── AuthService.php
│   │   ├── User/
│   │   │   └── UserService.php
│   │   └── Mail/
│   │       └── LaravelMailService.php
│   │
│   └── Providers/
│       └── CleanArchitectureServiceProvider.php
│
├── Http/                                # PRESENTATION LAYER
│   ├── Controllers/
│   │   ├── Api/
│   │   │   └── V1/
│   │   │       ├── AuthController.php
│   │   │       └── UserController.php
│   │   ├── BaseController.php
│   │   └── Controller.php
│   │
│   ├── Requests/
│   │   ├── Auth/
│   │   │   ├── LoginRequest.php
│   │   │   ├── ForgotPasswordRequest.php
│   │   │   ├── ResetPasswordRequest.php
│   │   │   └── VerifyTokenRequest.php
│   │   ├── User/
│   │   │   └── ListRequest.php
│   │   └── BaseRequest.php
│   │
│   ├── Resources/
│   │   ├── BaseResource.php
│   │   ├── JwtAuthResource.php
│   │   └── UserResource.php
│   │
│   └── Middleware/
│       └── XRequestIdMiddleware.php
│
└── Shared/                              # SHARED LAYER
    ├── Helpers/
    │   └── Helper.php
    └── Enums/
        ├── UserStatus.php
        └── UserRole.php
```

---

## 📋 Layers Explanation

### 1. Domain Layer (Pure PHP)
**Purpose**: Contains core business logic, **NO framework dependency**.

| Folder | Description |
|--------|-------------|
| `Entities/` | Pure PHP classes - business objects |
| `Repositories/` | Repository Interfaces |
| `Services/` | Service Interfaces |

**Entity Example:**
```php
namespace App\Domain\Entities;

readonly class User
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $email,
        public string $password,
        // ...
    ) {}

    public function isEmailVerified(): bool
    {
        return $this->emailVerifiedAt !== null;
    }
}
```

### 2. Application Layer
**Purpose**: Orchestration - coordinates business logic.

| Folder      | Description           |
|-------------|-----------------------|
| `UseCases/` | Specific use cases    |
| `DTOs/`     | Data Transfer Objects |

### 3. Infrastructure Layer
**Purpose**: Implementation, interacts with framework and external services.

| Folder                          | Description                |
|---------------------------------|----------------------------|
| `Persistence/Eloquent/Models/`  | Eloquent Models            |
| `Persistence/Eloquent/Mappers/` | Convert Entity ↔ Model     |
| `Repositories/`                 | Repository implementations |
| `Services/`                     | Service implementations    |
| `Providers/`                    | Service Providers          |

**Mapper Example:**
```php
namespace App\Infrastructure\Persistence\Eloquent\Mappers;

class UserMapper
{
    public static function toEntity(UserModel $model): User
    {
        return new User(
            id: $model->id,
            name: $model->name,
            email: $model->email,
            // ...
        );
    }

    public static function toModelData(User $entity): array
    {
        return [
            'name' => $entity->name,
            'email' => $entity->email,
            // ...
        ];
    }
}
```

### 4. Presentation Layer
**Purpose**: Handles HTTP requests/responses.

| Folder         | Description               |
|----------------|---------------------------|
| `Controllers/` | API Controllers           |
| `Requests/`    | Form Request validation   |
| `Resources/`   | API Resource transformers |
| `Middleware/`  | HTTP Middleware           |

### 5. Shared Layer
**Purpose**: Common code.

| Folder     | Description      |
|------------|------------------|
| `Helpers/` | Helper functions |
| `Enums/`   | Enums            |

---

## 🔄 Data Flow

```
┌─────────────────────────────────────────────────────────────────────┐
│                        PRESENTATION LAYER                           │
│  Request → Controller → FormRequest (validation)                    │
└────────────────────────────────┬────────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────────┐
│                       APPLICATION LAYER                             │
│  Service → UseCase → DTO                                            │
└────────────────────────────────┬────────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────────┐
│                         DOMAIN LAYER                                │
│  Repository Interface → Entity                                      │
└────────────────────────────────┬────────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────────┐
│                      INFRASTRUCTURE LAYER                           │
│  Repository Impl → Mapper → Eloquent Model → Database               │
└─────────────────────────────────────────────────────────────────────┘
```

---

## 🎯 Dependency Rule

```
                    ┌─────────────┐
                    │   Domain    │  ← No dependencies
                    └──────▲──────┘
                           │
                    ┌──────┴──────┐
                    │ Application │  ← Depends only on Domain
                    └──────▲──────┘
                           │
        ┌──────────────────┼─────────────────┐
        │                  │                 │
┌───────┴───────┐   ┌──────┴──────┐   ┌──────┴──────┐
│Infrastructure │   │ Presentation│   │   Shared    │
└───────────────┘   └─────────────┘   └─────────────┘
```

---

## 💡 How to Use

### Create a New Entity

```php
// app/Domain/Entities/Product.php
namespace App\Domain\Entities;

readonly class Product
{
    public function __construct(
        public ?int $id,
        public string $name,
        public float $price,
        public int $stock,
    ) {}

    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    public function decreaseStock(int $quantity): self
    {
        return new self(
            id: $this->id,
            name: $this->name,
            price: $this->price,
            stock: max(0, $this->stock - $quantity),
        );
    }
}
```

### Create Repository Interface

```php
// app/Domain/Repositories/ProductRepositoryInterface.php
namespace App\Domain\Repositories;

use App\Domain\Entities\Product;

interface ProductRepositoryInterface
{
    public function findById(int $id): ?Product;
    public function create(array $data): Product;
    public function update(array $data, int $id): Product;
    public function delete(int $id): bool;
}
```

### Create Eloquent Model

```php
// app/Infrastructure/Persistence/Eloquent/Models/ProductModel.php
namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $fillable = ['name', 'price', 'stock'];
}
```

### Create Mapper

```php
// app/Infrastructure/Persistence/Eloquent/Mappers/ProductMapper.php
namespace App\Infrastructure\Persistence\Eloquent\Mappers;

use App\Domain\Entities\Product;
use App\Infrastructure\Persistence\Eloquent\Models\ProductModel;

class ProductMapper
{
    public static function toEntity(ProductModel $model): Product
    {
        return new Product(
            id: $model->id,
            name: $model->name,
            price: (float) $model->price,
            stock: $model->stock,
        );
    }
}
```

### Register Service Binding

```php
// app/Infrastructure/Providers/CleanArchitectureServiceProvider.php
public array $bindings = [
    ProductRepositoryInterface::class => EloquentProductRepository::class,
];
```

---

## ✅ Features

- ✅ Strict Clean Architecture
- ✅ Pure Domain Entities (No framework dependency)
- ✅ Entity ↔ Model Mappers
- ✅ Repository Pattern
- ✅ Use Case Pattern
- ✅ DTO Pattern
- ✅ API Versioning (v1, v2...)
- ✅ JWT Authentication
- ✅ Custom Logging with X-Request-ID
- ✅ Exception Handling

---

## 📚 API Endpoints

### Auth
| Method | Endpoint                  | Description            |
|--------|---------------------------|------------------------|
| POST   | `/api/v1/login`           | User login             |
| POST   | `/api/v1/logout`          | User logout            |
| POST   | `/api/v1/refresh-token`   | Refresh JWT token      |
| GET    | `/api/v1/get-me`          | Get current user       |
| POST   | `/api/v1/forgot-password` | Request password reset |
| POST   | `/api/v1/verify-token`    | Verify reset token     |
| POST   | `/api/v1/reset-password`  | Reset password         |

### Users
| Method | Endpoint             | Description    |
|--------|----------------------|----------------|
| GET    | `/api/v1/users`      | List users     |
| POST   | `/api/v1/users`      | Create user    |
| GET    | `/api/v1/users/{id}` | Get user by ID |
| PUT    | `/api/v1/users/{id}` | Update user    |
| DELETE | `/api/v1/users/{id}` | Delete user    |

---

## 🛠️ Development

### Generate API Documentation
```bash
php artisan l5-swagger:generate
```

### Run Tests
```bash
php artisan test
```

### Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```
