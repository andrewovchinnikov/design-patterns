# Go

Мы — команда разработчиков, работающая над созданием системы управления комментариями для веб-сайта. Наша цель — предоставить пользователям возможность оставлять комментарии и ответы на комментарии. Для этого мы используем паттерн Компоновщик, который позволяет нам обрабатывать комментарии и ответы единообразно.



UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (51).png" alt=""><figcaption><p>UML диаграмма для паттерна "Мост"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
interface Comment {
    +display(): void
}

class SimpleComment implements Comment {
    -text: String
    +display(): void
}

class CompositeComment implements Comment {
    -comments: List<Comment>
    +addComment(comment: Comment): void
    +removeComment(comment: Comment): void
    +display(): void
}
@enduml

```
{% endcode %}

**1. Интерфейс Comment**

{% code overflow="wrap" lineNumbers="true" %}
```go
package main

import "fmt"

type Comment interface {
    Display()
}
```
{% endcode %}

**2. Структура SimpleComment**

{% code overflow="wrap" lineNumbers="true" %}
```go
type SimpleComment struct {
    Text string
}

func (sc SimpleComment) Display() {
    fmt.Printf("Комментарий: %s\n", sc.Text)
}
```
{% endcode %}

**3. Структура CompositeComment**

{% code overflow="wrap" lineNumbers="true" %}
```go
type CompositeComment struct {
    Comments []Comment
}

func (cc *CompositeComment) AddComment(comment Comment) {
    cc.Comments = append(cc.Comments, comment)
}

func (cc *CompositeComment) RemoveComment(comment Comment) {
    for i, c := range cc.Comments {
        if c == comment {
            cc.Comments = append(cc.Comments[:i], cc.Comments[i+1:]...)
            break
        }
    }
}

func (cc CompositeComment) Display() {
    for _, comment := range cc.Comments {
        comment.Display()
    }
}
```
{% endcode %}

**4. Пример использования**

{% code overflow="wrap" lineNumbers="true" %}
```go
func main() {
    // Создаем простые комментарии
    comment1 := SimpleComment{Text: "Это первый комментарий."}
    comment2 := SimpleComment{Text: "Это второй комментарий."}

    // Создаем композитный комментарий
    compositeComment := CompositeComment{}
    compositeComment.AddComment(comment1)
    compositeComment.AddComment(comment2)

    // Создаем вложенные комментарии
    subComment1 := SimpleComment{Text: "Это ответ на первый комментарий."}
    subComment2 := SimpleComment{Text: "Это ответ на второй комментарий."}

    // Добавляем вложенные комментарии в композитный комментарий
    compositeComment.AddComment(subComment1)
    compositeComment.AddComment(subComment2)

    // Отображаем все комментарии
    compositeComment.Display()
}
```
{% endcode %}

#### Объяснение кода

1.  **Интерфейс Comment**: Это базовый интерфейс для всех комментариев. Он содержит метод `Display`, который должен быть реализован в структурах.

    {% code overflow="wrap" lineNumbers="true" %}
    ```go
    type Comment interface {
        Display()
    }
    ```
    {% endcode %}
2.  **Структура SimpleComment**: Эта структура представляет простой комментарий. Она содержит текст комментария и реализует метод `Display`, который отображает текст комментария.

    {% code overflow="wrap" lineNumbers="true" %}
    ```go
    type SimpleComment struct {
        Text string
    }

    func (sc SimpleComment) Display() {
        fmt.Printf("Комментарий: %s\n", sc.Text)
    }
    ```
    {% endcode %}
3.  **Структура CompositeComment**: Эта структура представляет композитный комментарий, который может содержать другие комментарии и ответы. Она содержит срез `Comments`, в который можно добавлять и удалять комментарии. Метод `Display` вызывает метод `Display` для каждого из добавленных комментариев.

    {% code overflow="wrap" lineNumbers="true" %}
    ```go
    type CompositeComment struct {
        Comments []Comment
    }

    func (cc *CompositeComment) AddComment(comment Comment) {
        cc.Comments = append(cc.Comments, comment)
    }

    func (cc *CompositeComment) RemoveComment(comment Comment) {
        for i, c := range cc.Comments {
            if c == comment {
                cc.Comments = append(cc.Comments[:i], cc.Comments[i+1:]...)
                break
            }
        }
    }

    func (cc CompositeComment) Display() {
        for _, comment := range cc.Comments {
            comment.Display()
        }
    }
    ```
    {% endcode %}
4.  **Пример использования**: Мы создаем простые комментарии и композитный комментарий. Затем добавляем простые комментарии и вложенные комментарии в композитный комментарий и вызываем метод `Display` для отображения всех комментариев.

    {% code overflow="wrap" lineNumbers="true" %}
    ```go
    func main() {
        // Создаем простые комментарии
        comment1 := SimpleComment{Text: "Это первый комментарий."}
        comment2 := SimpleComment{Text: "Это второй комментарий."}

        // Создаем композитный комментарий
        compositeComment := CompositeComment{}
        compositeComment.AddComment(comment1)
        compositeComment.AddComment(comment2)

        // Создаем вложенные комментарии
        subComment1 := SimpleComment{Text: "Это ответ на первый комментарий."}
        subComment2 := SimpleComment{Text: "Это ответ на второй комментарий."}

        // Добавляем вложенные комментарии в композитный комментарий
        compositeComment.AddComment(subComment1)
        compositeComment.AddComment(subComment2)

        // Отображаем все комментарии
        compositeComment.Display()
    }
    ```
    {% endcode %}

Таким образом, паттерн Компоновщик позволяет нам обрабатывать комментарии и ответы единообразно, что упрощает управление и расширение системы управления комментариями.
