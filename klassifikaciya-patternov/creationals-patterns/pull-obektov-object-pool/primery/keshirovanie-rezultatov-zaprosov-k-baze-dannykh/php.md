# PHP

Описание: Разработка веб-приложения с высокой нагрузкой, которое обращается к базе данных для получения информации о пользователях. Для оптимизации работы приложения и снижения нагрузки на базу данных, используется паттерн "Пулл объектов" для кеширования результатов запросов к базе данных.

{% code overflow="wrap" lineNumbers="true" %}
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
```
{% endcode %}

DatabaseConnection - это класс, который представляет собой соединение с базой данных. Он принимает объект PDO в конструкторе и предоставляет метод query(), который выполняет запрос к базе данных и возвращает результат в виде массива.

{% code overflow="wrap" lineNumbers="true" %}
```php
<?php

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
{% endcode %}

DatabasePool - это класс, который представляет собой пулл соединений с базой данных. Он принимает объект PDO в конструкторе и создает заданное количество соединений с базой данных (в этом случае 10), которые хранятся в массиве connections. Класс предоставляет два метода:

* `getConnection()` - этот метод извлекает соединение из пула и возвращает его. Если пулл пуст, метод создает новое соединение.
* `releaseConnection()` - этот метод принимает соединение в качестве аргумента и возвращает его обратно в пулл.

Использование

{% code overflow="wrap" lineNumbers="true" %}
```php
$pdo = new PDO('mysql:host=localhost;dbname=test', 'user', 'password');
$pool = new DatabasePool($pdo);

// Получаем соединение с базой данных из пула
$connection = $pool->getConnection();

// Выполняем запрос к базе данных
$result = $connection->query('SELECT * FROM users');

// Возвращаем соединение в пул
$pool->releaseConnection($connection);
```
{% endcode %}

Диаграмма классов:

<figure><img src="../../../../../.gitbook/assets/image (38).png" alt=""><figcaption><p>UML диаграмма для паттерна "Пулл  объектов"</p></figcaption></figure>

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
