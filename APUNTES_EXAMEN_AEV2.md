# 📋 CHULETA EXAMEN AEV2 - PHP MVC + Doctrine ORM

**Fecha del examen:** 17 de Noviembre  
**Contenidos:** MVC, Doctrine ORM, Relaciones, Enums, Docker

---

## 📦 1. LA CARPETA `/vendor`

### ¿Qué es?
Es donde se guardan todas las **librerías externas** que instalaste con Composer. Contiene:
- **Doctrine ORM** (para trabajar con la BD)
- **Composer** (autoloading PSR-4)
- Todas las dependencias del proyecto

### Importante
- ✅ **NO modificar nunca**
- ✅ **NO subir a Git** (va en `.gitignore`)
- ✅ Se regenera automáticamente con `composer install`

---

## 🐳 2. LEVANTAR PROYECTO EN DOCKER

### Estructura básica (docker-compose.yml)
```yaml
version: '3.8'
services:
  php:
    image: php:8.3-apache
    ports:
      - "80:80"
    volumes:
      - ./:/var/www/html
    networks:
      - aev2-network
      
  mariadb-server:
    image: mariadb:latest
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: aev2
    networks:
      - aev2-network
    ports:
      - "3306:3306"
      
networks:
  aev2-network:
    driver: bridge
```

### Comandos principales

```bash
# Levantar contenedores
docker-compose up -d

# Ver contenedores activos
docker-compose ps

# Ver logs
docker-compose logs -f

# Parar contenedores
docker-compose down

# Entrar en el contenedor PHP
docker-compose exec php bash

# Ejecutar SQL en MariaDB
docker-compose exec mariadb-server mysql -u root -proot aev2 < schema.sql

# Instalar dependencias de Composer
docker-compose exec php composer install
```

### Importante para Doctrine
- Usar **nombre del servicio** como host, NO localhost
- Ejemplo: `host: mariadb-server-aev2` (ve tu docker-compose.yml)

---

## ⚙️ 3. COMANDOS TERMINAL MÁS IMPORTANTES

```bash
# Instalar dependencias (siempre primero)
composer install

# Actualizar dependencias
composer update

# Generar autoloader PSR-4
composer dump-autoload

# Verificar sintaxis PHP
php -l src/Entity/Product.php

# Ejecutar servidor local
php -S localhost:8000 -t public/

# Git - commits importantes
git add .
git commit -m "Mensaje descriptivo"
git log --oneline
git status
```

---

## 🔑 4. GENERATEDVALUE - STRATEGY (CUÁNDO USAR)

### GeneratedValue Strategy: IDENTITY
```php
#[Id]
#[GeneratedValue(strategy: "IDENTITY")]  // ← AUTO_INCREMENT automático
#[Column(name: 'id', type: 'integer')]
private int $id;
```
**Cuándo usarlo:** Cuando quieres que la BD genere el ID automáticamente (99% de casos)

### GeneratedValue Strategy: NONE
```php
#[Id]
#[GeneratedValue(strategy: "NONE")]  // ← Tú asignas el ID manualmente
#[Column(name: 'id', type: 'integer')]
private int $id;
```
**Cuándo usarlo:** Cuando los IDs no son autoincrement (raro, como con PROD_NUM)

### Sin GeneratedValue
```php
#[Id]
#[Column(name: 'id', type: 'integer')]
private int $id;
```
**Cuándo usarlo:** Casi nunca, solo si tu BD está muy mal configurada

---

## 📋 5. TIPOS DE DATOS EN ENTIDADES

```php
// Strings
#[Column(type: 'string', length: 100)]
private string $name;

// Números
#[Column(type: 'integer')]
private int $quantity;

#[Column(type: 'decimal', precision: 10, scale: 2)]
private float $price;  // Dinero, usar decimal

// Booleano
#[Column(type: 'boolean')]
private bool $active;

// Fechas
#[Column(type: 'date')]
private \DateTime $birthDate;

#[Column(type: 'datetime')]
private \DateTime $createdAt;

#[Column(type: 'time')]
private \DateTime $startTime;

// Nullable (puede ser null)
#[Column(type: 'string', nullable: true)]
private ?string $middleName = null;

// Unsigned (sin negativo)
#[Column(type: 'integer', options: ['unsigned' => true])]
private int $count;

// Unique
#[Column(type: 'string', unique: true)]
private string $email;
```

---

## 🔗 6. RELACIONES EN DOCTRINE - DESGLOSE COMPLETO

### 📌 ManyToOne (Muchos → Uno)
```php
// Lado del MUCHOS (es el propietario de la foreign key)
#[ManyToOne(targetEntity: Department::class, inversedBy: 'employees')]
#[JoinColumn(
    name: 'dept_no',                    // ← Nombre de la FK en ESTA tabla
    referencedColumnName: 'dept_no',    // ← Nombre de la PK en la tabla referenciada
    nullable: false
)]
private Department $department;
```

| Parámetro | Qué es | Ejemplo |
|-----------|--------|---------|
| `targetEntity` | La clase a la que me relaciono | `Department::class` |
| `inversedBy` | La propiedad en el otro lado | `'employees'` |
| `name` (JoinColumn) | Nombre FK en MI tabla | `'dept_no'` |
| `referencedColumnName` | Nombre PK en TABLA REFERENCIADA | `'dept_no'` |
| `nullable` | ¿Puede ser nulo? | `false` si es obligatorio |

### 📌 OneToMany (Uno → Muchos)
```php
// Lado del UNO (es el inverso, no tiene FK)
#[OneToMany(targetEntity: Employee::class, mappedBy: 'department')]
private Collection $employees;

public function __construct()
{
    $this->employees = new ArrayCollection();
}
```

| Parámetro | Qué es | Ejemplo |
|-----------|--------|---------|
| `targetEntity` | La clase al otro lado | `Employee::class` |
| `mappedBy` | Propiedad en el LADO PROPIETARIO | `'department'` |

**Nota:** Nunca uses `inversedBy` aquí, siempre `mappedBy`

### 📌 OneToOne (Uno ↔ Uno)
```php
// PROPIETARIO (tiene la FK)
#[OneToOne(targetEntity: Passport::class, inversedBy: 'employee')]
#[JoinColumn(name: 'passport_id', referencedColumnName: 'id')]
private Passport $passport;

// INVERSO (sin FK)
#[OneToOne(targetEntity: Employee::class, mappedBy: 'passport')]
private Employee $employee;
```

### 📌 ManyToMany (Muchos ↔ Muchos)
// PROPIETARIO (con JoinTable)
#[ManyToMany(targetEntity: Student::class, mappedBy: 'courses')]
private Collection $students;

 public function __construct()
 {
 $this->students = new ArrayCollection();
 }

 #[ManyToMany(targetEntity: Course::class, inversedBy: 'students')]
 #[JoinTable(name: 'cursos_estudiantes')]
 private Collection $courses;
 
 public function __construct()
 {
 $this->courses = new ArrayCollection();
 }
```

### 🎯 Autorreferencia (Employee → Employee Manager)
```php
// Empleado tiene un jefe (ManyToOne)
#[ManyToOne(targetEntity: Employee::class, inversedBy: 'subordinates')]
#[JoinColumn(name: 'jefe', referencedColumnName: 'emp_no', nullable: true)]
private ?Employee $manager = null;

// Un empleado es jefe de muchos (OneToMany)
#[OneToMany(targetEntity: Employee::class, mappedBy: 'manager')]
private ?Collection $subordinates = null;
```

---

## 📊 7. ENUMS EN ENTIDADES

### Opción 1: Enum separado en archivo (recomendado para examen)
```php
// src/Enum/EmployeeStatus.php
namespace AEV2\Enum;

enum EmployeeStatus: string
{
    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
    case SUSPENDED = 'SUSPENDED';
    
    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Activo',
            self::INACTIVE => 'Inactivo',
            self::SUSPENDED => 'Suspendido',
        };
    }
}
```

### Opción 2: Enum inline en la Entity (más compacto)
```php
// Dentro de src/Entity/Employee.php
namespace AEV2\Entity;

#[Entity(repositoryClass: EmployeeRepository::class)]
#[Table(name: 'emp')]
class Employee
{
    // Enum como propiedad con valores inline
    #[Column(type: 'string', enumType: 'ACTIVE|INACTIVE|SUSPENDED')]
    private string $status = 'ACTIVE';
    
    // O mejor aún, con valores específicos:
    #[Column(
        type: 'string',
        length: 20,
        nullable: false,
        options: ['default' => 'ACTIVE']
    )]
    private string $status = 'ACTIVE';
    
    public function getStatus(): string
    {
        return $this->status;
    }
    
    public function setStatus(string $status): void
    {
        if (!in_array($status, ['ACTIVE', 'INACTIVE', 'SUSPENDED'])) {
            throw new \InvalidArgumentException('Estado no válido');
        }
        $this->status = $status;
    }
}
```

### Opción 3: TRUE Enum Backed inline (PHP 8.1+)
```php
// Dentro de la Entity (al inicio del archivo)
namespace AEV2\Entity;

enum EmployeeStatus: string
{
    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
    case SUSPENDED = 'SUSPENDED';
}

#[Entity]
#[Table(name: 'emp')]
class Employee
{
    #[Column(type: 'string', enumType: EmployeeStatus::class)]
    private EmployeeStatus $status = EmployeeStatus::ACTIVE;
    
    public function getStatus(): EmployeeStatus
    {
        return $this->status;
    }
    
    public function setStatus(EmployeeStatus $status): void
    {
        $this->status = $status;
    }
}
```

### Usar según opción

**Si usas Opción 1 o 3 (Enum verdadero):**
```php
// En controlador
$employee->setStatus(EmployeeStatus::ACTIVE);

// En vista
<?= $employee->getStatus()->value ?>  // Muestra el valor: ACTIVE
```

**Si usas Opción 2 (solo string):**
```php
// En controlador
$employee->setStatus('ACTIVE');

// En vista
<?= $employee->getStatus() ?>  // Muestra: ACTIVE
```

### Recomendación para el examen
**Usa Opción 3** (Enum Backed inline al inicio de la Entity) porque:
- Es limpio (dentro del mismo archivo)
- No necesitas otro archivo
- Sigue siendo un true Enum de PHP 8.1+
- Muy fácil de escribir en un examen

---

## 🛠️ 8. PATRONES CRUD BÁSICOS

### CREATE
```php
$product = new Product();
$product->setId(1);
$product->setDescription('Producto A');

$em = $this->entityManager->getEntityManager();
$em->persist($product);
$em->flush();
```

### READ
```php
// Por ID
$product = $this->productRepository->find(1);

// Todos
$products = $this->productRepository->findAll();

// Condicional
$products = $this->productRepository->findBy(['status' => 'ACTIVE']);
```

### UPDATE
```php
$product = $this->productRepository->find(1);
$product->setDescription('Nuevo nombre');

$em = $this->entityManager->getEntityManager();
$em->persist($product);
$em->flush();
```

### DELETE
```php
$product = $this->productRepository->find(1);

$em = $this->entityManager->getEntityManager();
$em->remove($product);
$em->flush();
```

---

## 💡 9. ERRORES COMUNES Y SOLUCIONES

### ❌ Error: "Cannot assign X to property Y of type int"
**Causa:** Relación declarada como `int` cuando debe ser la entidad  
**Solución:** Cambiar el tipo
```php
// ❌ MAL
private int $department;

// ✅ BIEN
private Department $department;
```

### ❌ Error: "Call to undefined method getXXX()"
**Causa:** Getter no existe en la entidad  
**Solución:** Crear el getter
```php
public function getXXX(): string
{
    return $this->xxx;
}
```

### ❌ Error: "Table 'xxx' doesn't exist"
**Causa:** Tabla no existe en BD  
**Solución:** Crear tabla en BD o usar migrations

### ❌ Error: "Field 'XXX' doesn't have a default value"
**Causa:** No usaste AUTO_INCREMENT pero intentas insertar sin ID  
**Solución:** Usar `GeneratedValue(strategy: "IDENTITY")` o proporcionar el ID

### ❌ Error: "Object of class DateTime could not be converted to string"
**Causa:** Intentas imprimir DateTime directamente  
**Solución:** Usar `->format()`
```php
<?= $date->format('d/m/Y') ?>
```

---

## 🎯 10. CHECKLIST ANTES DEL EXAMEN

### Entidades
- [ ] Todas las propiedades tienen getter y setter
- [ ] Las FK están como objetos, NO como int
- [ ] Los tipos de dato son correctos (decimal para dinero, DateTime para fechas)
- [ ] Las relaciones tienen targetEntity definido
- [ ] Relaciones bidireccionales tienen inversedBy/mappedBy

### Controladores
- [ ] Validar datos antes de persistir
- [ ] Usar `persist()` antes de `flush()`
- [ ] Manejar el EntityManager correctamente
- [ ] Verificar que exista antes de actualizar/eliminar

### Vistas
- [ ] No imprimir objetos DateTime directamente (usar format())
- [ ] Usar `?.` para evitar errores si relación es null
- [ ] Cerrar todos los bucles foreach con endforeach
- [ ] Usar `<?= ?>` para imprimir (más limpio que echo)

### Docker
- [ ] Contenedores arriba: `docker-compose up -d`
- [ ] Usar nombre de servicio, no localhost
- [ ] Datos persisten en volúmenes

### Base de Datos
- [ ] Usar PRIMARY KEY para IDs
- [ ] Usar FOREIGN KEY para relaciones
- [ ] Tipos correctos (VARCHAR, INT, DECIMAL, DATE)
- [ ] Si es ID, con AUTO_INCREMENT

---

## 📚 11. ESTRUCTURA DEL PROYECTO

```
src/
├── Entity/              ← Entidades (clases + anotaciones Doctrine)
├── Repository/          ← Repositorios (consultas custom)
├── Controllers/         ← Controladores (lógica)
├── Views/              ← Vistas (renderizado)
├── Core/               ← Configuración (Router, Dispatcher, EntityManager)
└── Enum/               ← Enumeraciones

public/
├── index.php           ← Punto de entrada
└── assets/             ← HTML templates

vendor/                 ← Librerías (NO modificar)

docker-compose.yml      ← Configuración Docker
composer.json           ← Dependencias Composer
```

---

## 🚀 BONUS: SQL para crear tablas rápido

```sql
-- Tabla con ID AUTO_INCREMENT
CREATE TABLE PRODUCTO (
  PROD_NUM INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  DESCRIPCION VARCHAR(100) NOT NULL,
  UNIQUE KEY (DESCRIPCION)
);

-- Tabla con FK
CREATE TABLE PEDIDO (
  PEDIDO_NUM INT AUTO_INCREMENT PRIMARY KEY,
  CLIENTE_ID INT,
  FECHA_PEDIDO DATE,
  FOREIGN KEY (CLIENTE_ID) REFERENCES CLIENTE(CLIENTE_NUM)
);

-- Ver estructura tabla
DESCRIBE PRODUCTO;

-- Ver todas las tablas
SHOW TABLES;
```

---

## 📝 ÚLTIMA RECOMENDACIÓN

Antes del examen:
1. Lee las preguntas **con cuidado**
2. Identifica si es sobre **entidades, relaciones, controladores o vistas**
3. Si hay un error, busca primero en los **tipos de dato**
4. Recuerda: **FK siempre son objetos, nunca int**
5. **Persist + Flush** para cualquier cambio en BD

¡Mucho éxito en el examen! 🍀
