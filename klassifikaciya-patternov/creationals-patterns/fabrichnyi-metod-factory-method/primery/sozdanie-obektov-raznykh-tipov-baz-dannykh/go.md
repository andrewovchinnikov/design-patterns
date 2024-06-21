# Go

Предположим, что ваша команда разрабатывает приложение, которое может работать с разными типами баз данных (MySQL, PostgreSQL, SQLite и т.д.). Вы хотите реализовать создание объектов соответствующих баз данных в зависимости от конфигурации приложения.

Для решения этой задачи вы решаете использовать паттерн "Фабричный метод". Для начала создаете интерфейс Database, который будет содержать метод Connect(). Этот интерфейс будет определять общий функционал для всех типов баз данных.

{% code overflow="wrap" lineNumbers="true" %}
```go
type Database interface {
    Connect()
}
```
{% endcode %}

Затем реализуете этот интерфейс для каждого типа базы данных (MySQL, PostgreSQL, SQLite и т.д.):

{% code overflow="wrap" lineNumbers="true" %}
```go
type MySQLDatabase struct{}

func (d *MySQLDatabase) Connect() {
    fmt.Println("Подключение к MySQL")
}
```
{% endcode %}

{% code overflow="wrap" lineNumbers="true" %}
```go
type PostgreSQLDatabase struct{}

func (d *PostgreSQLDatabase) Connect() {
    fmt.Println("Подключение к PostgreSQL")
}
```
{% endcode %}

{% code overflow="wrap" lineNumbers="true" %}
```go
type SQLiteDatabase struct{}

func (d *SQLiteDatabase) Connect() {
    fmt.Println("Подключение к SQLite")
}
```
{% endcode %}

Далее создаете фабрику DatabaseFactory, которая будет создавать объекты баз данных в зависимости от типа, переданного в метод CreateDatabase(). Этот метод будет возвращать объект типа Database.

{% code overflow="wrap" lineNumbers="true" %}
```go
type DatabaseFactory struct{}

func (f *DatabaseFactory) CreateDatabase(typ string) Database {
    switch typ {
    case "mysql":
        return &MySQLDatabase{}
    case "pgsql":
        return &PostgreSQLDatabase{}
    case "sqlite":
        return &SQLiteDatabase{}
    default:
        panic("Неверный тип базы данных")
    }
}
```
{% endcode %}

В итоге, когда приложение запускается, оно использует фабрику для создания объекта базы данных и вызывает метод Connect() для подключения к базе данных.

Диаграмма классов для этого кейса:

<figure><img src="../../../../../.gitbook/assets/image (32).png" alt=""><figcaption><p>UML диаграмма для паттерна "Фабричный метод"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
interface Database {
    +Connect(): void
}

class MySQLDatabase implements Database {
    +Connect(): void
}

class PostgreSQLDatabase implements Database {
    +Connect(): void
}

class SQLiteDatabase implements Database {
    +Connect(): void
}

class DatabaseFactory {
    +CreateDatabase(type: string): Database
}

DatabaseFactory --> Database: CreateDatabase
Database <|-- MySQLDatabase
Database <|-- PostgreSQLDatabase
Database <|-- SQLiteDatabase
@enduml
```
{% endcode %}
