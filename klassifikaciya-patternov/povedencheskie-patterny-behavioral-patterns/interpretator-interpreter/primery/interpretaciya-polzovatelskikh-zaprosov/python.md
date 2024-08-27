# Python

Представьте, что мы разрабатываем веб-приложение для управления библиотекой. Наше приложение позволяет пользователям искать книги по различным критериям, таким как автор, название, год издания и т.д. Мы хотим сделать так, чтобы пользователи могли создавать сложные запросы, комбинируя различные условия. Для этого мы будем использовать паттерн "Интерпретатор".

### **Описание кейса**

Наше приложение должно позволять пользователям создавать запросы в виде текстовых выражений, например:

* "Автор: Толстой И Название: Война и мир"
* "Год: 2020 И Жанр: Фантастика"

Мы будем использовать паттерн "Интерпретатор" для интерпретации и выполнения этих запросов.

### Пример кода на Python

**Шаг 1: Создание контекста**

Контекст будет содержать информацию о доступных книгах и методы для получения этой информации.

{% code overflow="wrap" lineNumbers="true" %}
```python
class Book:
    def __init__(self, title, author, year, genre):
        self.title = title
        self.author = author
        self.year = year
        self.genre = genre

class Context:
    def __init__(self, books):
        self.books = books

    def get_books(self):
        return self.books
```
{% endcode %}

**Шаг 2: Создание абстрактного выражения**

Абстрактное выражение будет содержать метод `interpret`, который будет реализован в конкретных выражениях.

{% code overflow="wrap" lineNumbers="true" %}
```python
from abc import ABC, abstractmethod

class AbstractExpression(ABC):
    @abstractmethod
    def interpret(self, context):
        pass
```
{% endcode %}

**Шаг 3: Создание конечных выражений**

Конечные выражения будут реализовывать метод `interpret` для конкретных условий.

{% code overflow="wrap" lineNumbers="true" %}
```python
class AuthorExpression(AbstractExpression):
    def __init__(self, author):
        self.author = author

    def interpret(self, context):
        books = context.get_books()
        return [book for book in books if book.author == self.author]

class TitleExpression(AbstractExpression):
    def __init__(self, title):
        self.title = title

    def interpret(self, context):
        books = context.get_books()
        return [book for book in books if book.title == self.title]
```
{% endcode %}

**Шаг 4: Создание неконечных выражений**

Неконечные выражения будут комбинировать другие выражения.

{% code overflow="wrap" lineNumbers="true" %}
```python
class AndExpression(AbstractExpression):
    def __init__(self, expr1, expr2):
        self.expr1 = expr1
        self.expr2 = expr2

    def interpret(self, context):
        result1 = self.expr1.interpret(context)
        result2 = self.expr2.interpret(context)
        return [book for book in result1 if book in result2]
```
{% endcode %}

**Шаг 5: Использование интерпретатора**

Теперь мы можем использовать наш интерпретатор для выполнения запросов.

{% code overflow="wrap" lineNumbers="true" %}
```python
def main():
    # Пример данных
    books = [
        Book(title="Война и мир", author="Толстой", year=1869, genre="Роман"),
        Book(title="1984", author="Оруэлл", year=1949, genre="Фантастика"),
        Book(title="Дюна", author="Герберт", year=1965, genre="Фантастика"),
    ]

    context = Context(books)

    # Создание запроса
    author_expr = AuthorExpression(author="Толстой")
    title_expr = TitleExpression(title="Война и мир")
    and_expr = AndExpression(expr1=author_expr, expr2=title_expr)

    # Интерпретация запроса
    result = and_expr.interpret(context)

    for book in result:
        print(f"Title: {book.title}, Author: {book.author}, Year: {book.year}, Genre: {book.genre}")

if __name__ == "__main__":
    main()
```
{% endcode %}

### UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (5) (1).png" alt=""><figcaption><p>UML диаграмма для паттерна "Интерпретатор"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plantuml
@startuml

class Context {
    -books: Book[]
    +get_books(): Book[]
}

interface AbstractExpression {
    +interpret(context: Context): Book[]
}

class AuthorExpression {
    -author: string
    +interpret(context: Context): Book[]
}

class TitleExpression {
    -title: string
    +interpret(context: Context): Book[]
}

class AndExpression {
    -expr1: AbstractExpression
    -expr2: AbstractExpression
    +interpret(context: Context): Book[]
}

AbstractExpression <|-- AuthorExpression
AbstractExpression <|-- TitleExpression
AbstractExpression <|-- AndExpression

@enduml
```
{% endcode %}

### Вывод

В этом кейсе мы рассмотрели, как можно использовать паттерн "Интерпретатор" для создания системы, которая позволяет пользователям создавать и выполнять сложные запросы к базе данных книг. Мы создали контекст, абстрактное выражение, конечные выражения и неконечные выражения. Затем мы использовали эти компоненты для интерпретации и выполнения запросов.

Паттерн "Интерпретатор" позволяет гибко и удобно обрабатывать сложные запросы, разделяя грамматику языка от его интерпретации. Это делает код более чистым и управляемым, особенно когда речь идет о сложных условиях и правилах.
