# Python

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (2) (1) (1).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Прототип"</p></figcaption></figure>

Задача: Необходимо разработать систему управления содержимым сайта (CMS), которая позволит пользователям создавать и управлять страницами сайта. Система должна предоставлять набор шаблонов страниц, которые пользователи могут использовать для создания новых страниц.

Решение: Для решения этой задачи мы будем использовать паттерн проектирования "Прототип". Этот паттерн позволяет создавать новые объекты путем клонирования существующих объектов. В нашем случае, мы будем создавать новые страницы путем клонирования существующих шаблонов страниц.

Во-первых, определим абстрактный базовый класс `Template`, который будет содержать абстрактный метод `clone()`:

{% code overflow="wrap" lineNumbers="true" %}
```python
from abc import ABC, abstractmethod

class Template(ABC):
    @abstractmethod
    def clone(self):
        pass

```
{% endcode %}

Затем, определим конкретный класс-шаблон `PageTemplate`, который будет наследоваться от базового класса `Template` и реализовывать метод `clone()`:

{% code overflow="wrap" lineNumbers="true" %}
```python
class PageTemplate(Template):
    def __init__(self, title, content, *args, **kwargs):
        self.title = title
        self.content = content
        self.args = args
        self.kwargs = kwargs

    def clone(self):
        return PageTemplate(self.title, self.content, *self.args, **self.kwargs)

```
{% endcode %}

Класс `PageTemplate` содержит конструктор, который принимает аргументы `title`, `content`, а также произвольное количество позиционных и именованных аргументов. Метод `clone()` создает копию объекта `PageTemplate` с теми же значениями атрибутов.

Теперь, определим класс `Page`, который будет представлять собой конкретную страницу, созданную на основе шаблона:

{% code overflow="wrap" lineNumbers="true" %}
```python
class Page:
    def __init__(self, title, content, *args, **kwargs):
        self.title = title
        self.content = content
        self.args = args
        self.kwargs = kwargs

```
{% endcode %}

Класс `Page` аналогичен классу `PageTemplate`, за исключением того, что он не наследуется от базового класса `Template` и не содержит метода `clone()`.

Наконец, определим класс-фабрику `PageFactory`, который будет создавать новые страницы на основе шаблонов:

{% code overflow="wrap" lineNumbers="true" %}
```python
class PageFactory:
    def __init__(self):
        self.prototypes = {
            'default': PageTemplate('Default Title', 'Default Content'),
            'blog': PageTemplate('Blog Title', 'Blog Content', post_format='standard'),
            'portfolio': PageTemplate('Portfolio Title', 'Portfolio Content', num_columns=3),
        }

    def create_page(self, template_name, title, content, *args, **kwargs):
        prototype = self.prototypes[template_name]
        page = prototype.clone()
        page.title = title
        page.content = content
        page.args = args
        page.kwargs = kwargs
        return page

```
{% endcode %}

Класс `PageFactory` содержит конструктор, который инициализирует атрибут `prototypes` - словарь, содержащий шаблоны страниц. Метод `create_page()` принимает аргументы `template_name`, `title`, `content`, а также произвольное количество позиционных и именованных аргументов. Он создает новую страницу путем клонирования шаблона, задает значения атрибутов и возвращает ее.

Пример использования:

{% code overflow="wrap" lineNumbers="true" %}
```python
factory = PageFactory()

# Создаем новую страницу на основе шаблона "default"
page = factory.create_page('default', 'New Page Title', 'New Page Content')
print(page.title)
print(page.content)

# Создаем новую страницу на основе шаблона "blog"
page = factory.create_page('blog', 'New Blog Title', 'New Blog Content', post_format='gallery')
print(page.title)
print(page.content)
print(page.kwargs['post_format'])

```
{% endcode %}
