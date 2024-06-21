# PHP

Описание: Разработка веб-приложения с высокой нагрузкой, которое обращается к базе данных для получения информации о пользователях. Для оптимизации работы приложения и снижения нагрузки на базу данных, используется паттерн "Пулл объектов" для кеширования результатов запросов к базе данных.

```php
<?php

class DatabaseConnection
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function query(string $query): array
    {
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

class DatabasePool
{
    private $connections = [];

    public function __construct(PDO $pdo)
    {
        for ($i = 0; $i < 10; $i++) {
            $this->connections[] = new DatabaseConnection($pdo);
        }
    }

    public function getConnection(): DatabaseConnection
    {
        if (count($this->connections) > 0) {
            return array_pop($this->connections);
        }

        return new DatabaseConnection($this->pdo);
    }

    public function releaseConnection(DatabaseConnection $connection): void
    {
        $this->connections[] = $connection;
    }
}
```

```php
// Использование
$pdo = new PDO('mysql:host=localhost;dbname=test', 'user', 'password');
$pool = new DatabasePool($pdo);

// Получаем соединение с базой данных из пула
$connection = $pool->getConnection();

// Выполняем запрос к базе данных
$result = $connection->query('SELECT * FROM users');

// Возвращаем соединение в пул
$pool->releaseConnection($connection);
```

Диаграмма классов:

```plant-uml
@startuml
class DatabaseConnection {
-pdo: PDO
+query(string $query): array
}

class DatabasePool {
-connections: array
-pdo: PDO
+getConnection(): DatabaseConnection
+releaseConnection(DatabaseConnection $connection): void
}

PDO <|-- DatabaseConnection
@enduml
```
