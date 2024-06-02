# Go

<figure><img src="../../../../../.gitbook/assets/image (9).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Одиночка" для работы с БД</p></figcaption></figure>

Разработка веб-приложения с использованием базы данных. Для обеспечения эффективного доступа к данным и избежания конфликтов при работе с базой данных необходимо создать единственный экземпляр класса, отвечающего за работу с базой данных.

Решение:

Для решения этой задачи мы можем использовать паттерн "Одиночка" (Singleton) для создания единственного экземпляра класса, отвечающего за работу с базой данных. Этот экземпляр будет предоставлять доступ к базе данных и выполнять запросы к ней.

Например, для класса `Database`, отвечающего за работу с базой данных, паттерн "Одиночка" может быть реализован следующим образом на Go:

{% code overflow="wrap" lineNumbers="true" %}
```go
package main

import (
    "database/sql"
    "fmt"
    _ "github.com/go-sql-driver/mysql"
)

type Database struct {
    conn *sql.DB
}

var instance *Database

func GetInstance() *Database {
    if instance == nil {
        conn, err := sql.Open("mysql", "user:password@/dbname")
        if err != nil {
            fmt.Println("Ошибка при открытии соединения с базой данных:", err)
            return nil
        }
        instance = &Database{conn: conn}
    }
    return instance
}

func (db *Database) Query(query string, args ...interface{}) (*sql.Rows, error) {
    return db.conn.Query(query, args...)
}

func main() {
    // Получение экземпляра класса Database
    db := GetInstance()
    if db == nil {
        fmt.Println("Ошибка при получении экземпляра класса Database")
        return
    }

    // Выполнение запроса к базе данных
    rows, err := db.Query("SELECT * FROM users WHERE id = ?", 1)
    if err != nil {
        fmt.Println("Ошибка при выполнении запроса:", err)
        return
    }
    defer rows.Close()

    // Вывод результатов запроса
    for rows.Next() {
        var id int
        var name string
        err := rows.Scan(&id, &name)
        if err != nil {
            fmt.Println("Ошибка при сканировании строки:", err)
            return
        }
        fmt.Println("ID:", id, "Имя:", name)
    }
}
```
{% endcode %}

В этом примере мы создаем класс `Database`, который отвечает за работу с базой данных. Мы используем паттерн "Одиночка" для создания единственного экземпляра класса `Database`.

Мы объявляем глобальную переменную `instance` типа `*Database`, которая будет хранить единственный экземплярр класса. Мы также объявляем статический метод `GetInstance()`, который будет возвращать единственный экземплярр класса `Database`.

В методе `GetInstance()` мы проверяем, является ли переменная `instance` равной `nil`. Если да, то мы создаем новый экземплярр класса `Database` и сохраняем его в переменной `instance`. В противном случае, мы просто возвращаем существующий экземплярр класса `Database`.

Метод `Query()` используется для выполнения запросов к базе данных. Он принимает в качестве аргументов SQL-запрос и список параметров, и возвращает объект `sql.Rows`, который содержит результаты запроса.
