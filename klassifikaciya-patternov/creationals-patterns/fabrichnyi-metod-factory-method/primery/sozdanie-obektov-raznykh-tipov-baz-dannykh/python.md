# Python

Предположим, что ваша команда разрабатывает приложение, которое может работать с разными типами баз данных (MySQL, PostgreSQL, SQLite и т.д.). Вы хотите реализовать создание объектов соответствующих баз данных в зависимости от конфигурации приложения.

Для решения этой задачи вы решаете использовать паттерн "Фабричный метод". Для начала создаете интерфейс Database, который будет содержать метод connect(). Этот интерфейс будет определять общий функционал для всех типов баз данных.

{% code overflow="wrap" lineNumbers="true" %}
```python
from abc import ABC, abstractmethod

class Database(ABC):
    @abstractmethod
    def connect(self):
        pass
```
{% endcode %}

Затем реализуете этот интерфейс для каждого типа базы данных (MySQL, PostgreSQL, SQLite и т.д.):

{% code overflow="wrap" lineNumbers="true" %}
```python
class MySQLDatabase(Database):
    def connect(self):
        print("Подключение к MySQL")
```
{% endcode %}

{% code overflow="wrap" lineNumbers="true" %}
```python
class PostgreSQLDatabase(Database):
    def connect(self):
        print("Подключение к PostgreSQL")
```
{% endcode %}

{% code overflow="wrap" lineNumbers="true" %}
```python
class SQLiteDatabase(Database):
    def connect(self):
        print("Подключение к SQLite")
```
{% endcode %}

Далее создаете фабрику DatabaseFactory, которая будет создавать объекты баз данных в зависимости от типа, переданного в метод create\_database(). Этот метод будет возвращать объект типа Database.

{% code overflow="wrap" lineNumbers="true" %}
```python
class DatabaseFactory:
    @staticmethod
    def create_database(database_type: str) -> Database:
        if database_type == "mysql":
            return MySQLDatabase()
        elif database_type == "pgsql":
            return PostgreSQLDatabase()
        elif database_type == "sqlite":
            return SQLiteDatabase()
        else:
            raise ValueError("Неверный тип базы данных")
```
{% endcode %}

В итоге, когда приложение запускается, оно использует фабрику для создания объекта базы данных и вызывает метод connect() для подключения к базе данных.

Диаграмма классов для этого кейса:

<figure><img src="../../../../../.gitbook/assets/image (35).png" alt=""><figcaption><p>UML диаграмма для паттерна "Фабричный метод"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
abstract class Database {
    +connect(): void
}

class MySQLDatabase extends Database {
    +connect(): void
}

class PostgreSQLDatabase extends Database {
    +connect(): void
}

class SQLiteDatabase extends Database {
    +connect(): void
}

class DatabaseFactory {
    +create_database(type: string): Database
}

DatabaseFactory --> Database: create_database
Database <|-- MySQLDatabase
Database <|-- PostgreSQLDatabase
Database <|-- SQLiteDatabase
@enduml
```
{% endcode %}
