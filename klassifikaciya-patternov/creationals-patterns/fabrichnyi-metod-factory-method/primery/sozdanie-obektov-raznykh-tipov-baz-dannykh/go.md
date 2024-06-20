# Go

Предположим, что ваша команда разрабатывает приложение, которое может работать с разными типами баз данных (MySQL, PostgreSQL, SQLite и т.д.). Вы хотите реализовать создание объектов соответствующих баз данных в зависимости от конфигурации приложения.

Для решения этой задачи вы решаете использовать паттерн "Фабричный метод". Для начала создаете интерфейс Database, который будет содержать метод Connect(). Этот интерфейс будет определять общий функционал для всех типов баз данных.

```go
type Database interface {
    Connect()
}
```

Затем реализуете этот интерфейс для каждого типа базы данных (MySQL, PostgreSQL, SQLite и т.д.):

```go
type MySQLDatabase struct{}

func (d *MySQLDatabase) Connect() {
    fmt.Println("Подключение к MySQL")
}
```

```go
type PostgreSQLDatabase struct{}

func (d *PostgreSQLDatabase) Connect() {
    fmt.Println("Подключение к PostgreSQL")
}
```

```go
type SQLiteDatabase struct{}

func (d *SQLiteDatabase) Connect() {
    fmt.Println("Подключение к SQLite")
}
```

Далее создаете фабрику DatabaseFactory, которая будет создавать объекты баз данных в зависимости от типа, переданного в метод CreateDatabase(). Этот метод будет возвращать объект типа Database.

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

В итоге, когда приложение запускается, оно использует фабрику для создания объекта базы данных и вызывает метод Connect() для подключения к базе данных.

Диаграмма классов для этого кейса:

<figure><img src="../../../../../.gitbook/assets/image (32).png" alt=""><figcaption><p>UML диаграмма для паттерна "Фабричный метод"</p></figcaption></figure>

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
