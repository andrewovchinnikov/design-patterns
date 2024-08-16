# Go

Привет! Мы — команда разработчиков, работающая над веб-приложением для управления пользовательскими настройками. Наше приложение позволяет пользователям настраивать различные параметры, такие как темы оформления, язык интерфейса и уведомления. Мы хотим оптимизировать работу с пользовательскими настройками, чтобы наше приложение работало быстрее и эффективнее. Для этого мы решили использовать паттерн Легковесный объект (Flyweight).

#### Описание кейса

Паттерн Легковесный объект помогает нам экономить память и ресурсы, когда у нас много объектов с одинаковыми или похожими состояниями. В нашем случае, пользовательские настройки могут иметь одинаковые параметры, такие как тема оформления (светлая, темная) и язык интерфейса (русский, английский). Мы можем использовать легковесные объекты для представления этих параметров, чтобы не создавать новые объекты каждый раз, когда нам нужно создать новые настройки для пользователя.

#### Пример кода на Go

**1. Определение интерфейса Flyweight**

{% code overflow="wrap" lineNumbers="true" %}
```go
package main

import "fmt"

type UserSettingsFlyweight interface {
    Render(extrinsicState map[string]string)
}
```
{% endcode %}

**2. Реализация конкретного легковесного объекта**

{% code overflow="wrap" lineNumbers="true" %}
```go
type ConcreteUserSettingsFlyweight struct {
    Theme    string
    Language string
}

func (c *ConcreteUserSettingsFlyweight) Render(extrinsicState map[string]string) {
    // Внешнее состояние включает уникальные данные пользователя, такие как имя пользователя и дата настройки
    username := extrinsicState["username"]
    date := extrinsicState["date"]

    // Рендеринг настроек пользователя
    fmt.Printf("Пользователь: %s\n", username)
    fmt.Printf("Тема: %s\n", c.Theme)
    fmt.Printf("Язык: %s\n", c.Language)
    fmt.Printf("Дата настройки: %s\n\n", date)
}
```
{% endcode %}

**3. Фабрика легковесных объектов**

{% code overflow="wrap" lineNumbers="true" %}
```go
type UserSettingsFlyweightFactory struct {
    flyweights map[string]UserSettingsFlyweight
}

func NewUserSettingsFlyweightFactory() *UserSettingsFlyweightFactory {
    return &UserSettingsFlyweightFactory{
        flyweights: make(map[string]UserSettingsFlyweight),
    }
}

func (f *UserSettingsFlyweightFactory) GetFlyweight(theme, language string) UserSettingsFlyweight {
    key := theme + "_" + language
    if flyweight, exists := f.flyweights[key]; exists {
        return flyweight
    }
    flyweight := &ConcreteUserSettingsFlyweight{Theme: theme, Language: language}
    f.flyweights[key] = flyweight
    return flyweight
}
```
{% endcode %}

**4. Использование легковесных объектов**

{% code overflow="wrap" lineNumbers="true" %}
```go
func main() {
    // Создаем фабрику легковесных объектов
    factory := NewUserSettingsFlyweightFactory()

    // Создаем пользовательские настройки с использованием легковесных объектов
    settings := []map[string]string{
        {"username": "Иван", "theme": "Светлая", "language": "Русский", "date": "2023-10-01"},
        {"username": "Мария", "theme": "Темная", "language": "Английский", "date": "2023-10-05"},
        {"username": "Алексей", "theme": "Светлая", "language": "Русский", "date": "2023-10-03"},
    }

    for _, setting := range settings {
        flyweight := factory.GetFlyweight(setting["theme"], setting["language"])
        flyweight.Render(map[string]string{
            "username": setting["username"],
            "date":     setting["date"],
        })
    }
}
```
{% endcode %}

#### UML Диаграмма

<figure><img src="../../../../../.gitbook/assets/image (72).png" alt=""><figcaption><p>UML диаграмма для паттерна "Легковесный объект"</p></figcaption></figure>

{% code title="" overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
interface UserSettingsFlyweight {
    +Render(extrinsicState: map[string]string)
}

class ConcreteUserSettingsFlyweight implements UserSettingsFlyweight {
    -Theme: string
    -Language: string
    +Render(extrinsicState: map[string]string)
}

class UserSettingsFlyweightFactory {
    -flyweights: map[string]UserSettingsFlyweight
    +NewUserSettingsFlyweightFactory(): UserSettingsFlyweightFactory
    +GetFlyweight(theme: string, language: string): UserSettingsFlyweight
}

UserSettingsFlyweight <|-- ConcreteUserSettingsFlyweight
UserSettingsFlyweightFactory --> UserSettingsFlyweight
@enduml
```
{% endcode %}

#### Вывод для кейса

Использование паттерна Легковесный объект позволило нам значительно оптимизировать работу с пользовательскими настройками в нашем веб-приложении. Мы смогли сократить использование памяти и улучшить производительность, создавая легковесные объекты для общих параметров настроек. Это особенно полезно, когда у нас много пользователей с одинаковыми или похожими настройками.

Теперь наше приложение работает быстрее и эффективнее, что делает его более удобным для пользователей. Мы планируем продолжать использовать этот паттерн и в других частях нашего приложения, чтобы достичь еще большей оптимизации.

Надеюсь, этот пример поможет вам лучше понять, как использовать паттерн Легковесный объект в ваших проектах!
