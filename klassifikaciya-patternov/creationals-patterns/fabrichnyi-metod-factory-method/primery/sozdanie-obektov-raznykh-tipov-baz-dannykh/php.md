# PHP

Предположим, что ваша команда разрабатывает приложение, которое может работать с разными типами баз данных (MySQL, PostgreSQL, SQLite и т.д.). Вы хотите реализовать создание объектов соответствующих баз данных в зависимости от конфигурации приложения.

Для решения этой задачи вы решаете использовать паттерн "Фабричный метод". Для начала создаете интерфейс Database, который будет содержать метод connect(). Этот интерфейс будет определять общий функционал для всех типов баз данных.

{% code overflow="wrap" lineNumbers="true" %}
```php
interface Database
{
    public function connect();
}
```
{% endcode %}

Затем реализуете этот интерфейс для каждого типа базы данных (MySQL, PostgreSQL, SQLite и т.д.). Например, для MySQL:

{% code overflow="wrap" lineNumbers="true" %}
```php
class MySQLDatabase implements Database
{
    public function connect()
    {
        echo "Подключение к MySQL";
    }
}
```
{% endcode %}

Далее создаете фабрику DatabaseFactory, которая будет создавать объекты баз данных в зависимости от типа, переданного в метод createDatabase(). Этот метод будет возвращать объект типа Database.

{% code overflow="wrap" lineNumbers="true" %}
```php
class DatabaseFactory
{
    public static function createDatabase(string $type): Database
    {
        switch ($type) {
            case 'mysql':
                return new MySQLDatabase();
            case 'pgsql':
                return new PostgreSQLDatabase();
            case 'sqlite':
                return new SQLiteDatabase();
            default:
                throw new InvalidArgumentException('Неверный тип базы данных');
        }
    }
}
```
{% endcode %}

В итоге, когда приложение запускается, оно использует фабрику для создания объекта базы данных и вызывает метод connect() для подключения к базе данных.

Диаграмма классов для этого кейса:

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (2) (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для паттерна "Фабричный метод"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```less
@startuml
interface Database {
    +connect(): void
}

class MySQLDatabase implements Database {
    +connect(): void
}

class PostgreSQLDatabase implements Database {
    +connect(): void
}

class SQLiteDatabase implements Database {
    +connect(): void
}

class DatabaseFactory {
    +createDatabase(type: string): Database
}

DatabaseFactory --> Database: createDatabase
Database <|-- MySQLDatabase
Database <|-- PostgreSQLDatabase
Database <|-- SQLiteDatabase
@enduml
```
{% endcode %}
