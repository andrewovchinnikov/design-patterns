# Go

<figure><img src="../../../../../.gitbook/assets/image (24).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Прототип"</p></figcaption></figure>

Предположим, что наша команда разрабатывает систему управления контентом (CMS) для средних и крупных бизнесов. В рамках разработки нам необходимо реализовать функционал по созданию и редактированию страниц сайта.

Каждой странице сайта соответствует объект класса Page, который содержит информацию о заголовке страницы, её содержимом, мета-тегах и других атрибутах. При создании новой страницы пользователь выбирает шаблон, на основе которого будет создана новая страница. Шаблон представляет собой объект класса Template, который содержит информацию о структуре и дизайне страницы.

Создание новых страниц на основе шаблонов может быть реализовано с помощью паттерна Прототип. Для этого мы можем создать класс-фабрику PageFactory, который будет содержать прототипы страниц для каждого шаблона. При создании новой страницы пользователь выбирает шаблон, а PageFactory создаёт новый объект класса Page, клонируя прототип соответствующего шаблона.

Вот пример кода для реализации паттерна Прототип в Go:

Определяем интерфейс Template, который будет являться базовым для всех шаблонов:

{% code overflow="wrap" lineNumbers="true" %}
```go
package main

import (
    "fmt"
)

type Template interface {
    clone() Template
}
```
{% endcode %}

Далее определяем конкретный шаблон PageTemplate, который реализует интерфейс Template:

{% code overflow="wrap" lineNumbers="true" %}
```go
type PageTemplate struct {
    title       string
    content     string
    args        []string
    kwargs      map[string]string
}

func (p *PageTemplate) clone() Template {
    return &PageTemplate{
        title:       p.title,
        content:     p.content,
        args:        append([]string{}, p.args...),
        kwargs:      map[string]string{},
    }
}
```
{% endcode %}

PageTemplate содержит поля title, content, args и kwargs. Метод clone() реализует интерфейс Template и создает копию текущего шаблона.

Затем определяем структуру Page, которая будет представлять собой конкретную страницу:

{% code overflow="wrap" lineNumbers="true" %}
```go
type Page struct {
    title       string
    content     string
    args        []string
    kwargs      map[string]string
}
```
{% endcode %}

Page содержит те же поля, что и PageTemplate.

Далее определяем структуру PageFactory, которая будет создавать новые страницы на основе существующих шаблонов:

{% code overflow="wrap" lineNumbers="true" %}
```go
type PageFactory struct {
    prototypes map[string]Template
}

func (f *PageFactory) createPage(templateName string, title string, content string, args []string, kwargs map[string]string) Page {
    prototype := f.prototypes[templateName]
    page := prototype.clone()
    pageTemplate := page.(*PageTemplate)
    pageTemplate.title = title
    pageTemplate.content = content
    pageTemplate.args = args
    pageTemplate.kwargs = kwargs
    return Page{
        title:       pageTemplate.title,
        content:     pageTemplate.content,
        args:        pageTemplate.args,
        kwargs:      pageTemplate.kwargs,
    }
}
```
{% endcode %}

PageFactory содержит поле prototypes, которое является картой, где ключ - это имя шаблона, а значение - это сам шаблон. Метод createPage() создает новую страницу на основе существующего шаблона. Он принимает в качестве аргументов имя шаблона, заголовок, контент, args и kwargs. Затем он получает шаблон из карты prototypes, создает его копию с помощью метода clone() и заполняет поля title, content, args и kwargs. В конце он возвращает новую страницу.

Наконец, в функции main() мы создаем экземпляр PageFactory, заполняем карту prototypes существующими шаблонами и создаем новые страницы с помощью метода createPage():

{% code overflow="wrap" lineNumbers="true" %}
```go
func main() {
    factory := &PageFactory{
        prototypes: map[string]Template{
            "default": &PageTemplate{
                title:   "Default Title",
                content: "Default Content",
            },
            "blog": &PageTemplate{
                title:   "Blog Title",
                content: "Blog Content",
                args:    []string{"post_format"},
                kwargs: map[string]string{
                    "post_format": "standard",
                },
            },
            "portfolio": &PageTemplate{
                title:   "Portfolio Title",
                content: "Portfolio Content",
                args:    []string{"num_columns"},
                kwargs: map[string]string{
                    "num_columns": "3",
                },
            },
        },
    }

    // Создаем новую страницу на основе шаблона "default"
    page := factory.createPage("default", "New Page Title", "New Page Content", nil, nil)
    fmt.Println(page.title)
    fmt.Println(page.content)

    // Создаем новую страницу на основе шаблона "blog"
    page = factory.createPage("blog", "New Blog Title", "New Blog Content", []string{"post_format"}, map[string]string{"post_format": "gallery"})
    fmt.Println(page.title)
    fmt.Println(page.content)
    fmt.Println(page.kwargs["post_format"])
}

```
{% endcode %}
