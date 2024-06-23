# Python

В веб-приложениях, которые интенсивно взаимодействуют с базой данных, управление соединениями может стать проблемой. Создание и закрытие соединений с базой данных для каждого запроса может быть неэффективным. Пул соединений позволяет управлять соединениями, предоставляя их по мере необходимости и возвращая обратно в пул после использования.

**Задача:**

1. Создать класс `DatabaseConnection`, который будет представлять соединение с базой данных и кэшировать результаты запросов.
2. Создать класс `DatabasePool`, который будет управлять пулом соединений, предоставляя их по мере необходимости и возвращая обратно в пул после использования.
3. Реализовать функциональность для получения и возвращения соединений из пула.
4. Реализовать функциональность для выполнения запросов к базе данных с кэшированием результатов.

**Классы и функции:**

**Класс `DatabaseConnection`**

{% code overflow="wrap" lineNumbers="true" %}
```python
import sqlite3

class DatabaseConnection:
    def __init__(self, db_name):
        self.connection = sqlite3.connect(db_name)
        self.cache = {}

    def query(self, query):
        if query in self.cache:
            return self.cache[query]
        cursor = self.connection.cursor()
        cursor.execute(query)
        result = cursor.fetchall()
        self.cache[query] = result
        return result

    def close(self):
        self.connection.close()
```
{% endcode %}

* **Методы:**
  * `__init__(self, db_name)`:
    * **Описание:** Конструктор для создания нового объекта `DatabaseConnection`.
    * **Параметры:** `db_name` - имя базы данных.
  * `query(self, query)`:
    * **Описание:** Метод для выполнения запроса к базе данных. Если результат запроса уже есть в кэше, возвращается кэшированный результат. В противном случае выполняется запрос к базе данных, результат кэшируется и возвращается.
    * **Параметры:** `query` - SQL запрос.
    * **Возвращает:** Результат запроса.
  * `close(self)`:
    * **Описание:** Метод для закрытия соединения с базой данных.

**Класс `DatabasePool`**

{% code overflow="wrap" lineNumbers="true" %}
```python
from queue import Queue

class DatabasePool:
    def __init__(self, db_name, size):
        self.pool = Queue(maxsize=size)
        for _ in range(size):
            self.pool.put(DatabaseConnection(db_name))

    def get_connection(self):
        return self.pool.get()

    def release_connection(self, connection):
        self.pool.put(connection)
```
{% endcode %}

* **Методы:**
  * `__init__(self, db_name, size)`:
    * **Описание:** Конструктор для создания нового объекта `DatabasePool` с заданным количеством соединений.
    * **Параметры:**
      * `db_name` - имя базы данных.
      * `size` - количество соединений в пуле.
  * `get_connection(self)`:
    * **Описание:** Метод для получения соединения из пула.
    * **Возвращает:** Объект `DatabaseConnection`.
  * `release_connection(self, connection)`:
    * **Описание:** Метод для возвращения соединения обратно в пул.
    * **Параметры:** `connection` - соединение, которое нужно вернуть в пул.

**Использование:**

{% code overflow="wrap" lineNumbers="true" %}
```python
if __name__ == "__main__":
    pool = DatabasePool('test.db', 10)

    # Получаем объект соединения из пулла
    connection = pool.get_connection()

    # Выполняем запрос
    result = connection.query("SELECT * FROM users")
    print(result)

    # Возвращаем объект соединения в пул
    pool.release_connection(connection)
```
{% endcode %}

**Диаграмма классов**

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для паттерна "Пулл объектов"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml

class DatabaseConnection {
  -connection: sqlite3.Connection
  -cache: dict
  +__init__(db_name: str)
  +query(query: str): list
  +close()
}

class DatabasePool {
  -pool: Queue
  +__init__(db_name: str, size: int)
  +get_connection(): DatabaseConnection
  +release_connection(connection: DatabaseConnection)
}

class sqlite3.Connection {
  +cursor()
  +close()
}

DatabasePool --> DatabaseConnection : contains
DatabaseConnection --> sqlite3.Connection : uses

@enduml
```
{% endcode %}

Эта диаграмма отображает следующие классы и их взаимосвязи:

* `DatabaseConnection`: Представляет соединение с базой данных. Содержит поля `connection` и `cache`, а также методы `__init__`, `query` и `close`.
* `DatabasePool`: Представляет пул соединений с базой данных. Содержит поле `pool` и методы `__init__`, `get_connection` и `release_connection`.
* `sqlite3.Connection`: Представляет собой стандартный объект для работы с базой данных в Python. Содержит методы `cursor` и `close`.

Связи между классами:

* `DatabasePool` содержит (`contains`) объекты `DatabaseConnection`.
* `DatabaseConnection` использует (`uses`) объект `sqlite3.Connection`.

Этот пример демонстрирует, как можно управлять пулом соединений с базой данных в Python, обеспечивая эффективное использование ресурсов и улучшая производительность приложения.
