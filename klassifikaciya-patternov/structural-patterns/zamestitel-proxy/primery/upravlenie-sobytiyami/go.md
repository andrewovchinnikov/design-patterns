# Go

Привет! Мы — команда разработчиков, работающая над веб-приложением для управления событиями. Наше приложение позволяет пользователям создавать, редактировать и удалять события, а также просматривать их в календаре. Мы хотим оптимизировать работу с событиями, чтобы наше приложение работало быстрее и эффективнее. Для этого мы решили использовать паттерн Легковесный объект (Flyweight).

#### Описание кейса

Паттерн Легковесный объект помогает нам экономить память и ресурсы, когда у нас много объектов с одинаковыми или похожими состояниями. В нашем случае, события могут иметь одинаковые параметры, такие как тип события (встреча, дедлайн и т.д.) и приоритет (высокий, средний, низкий). Мы можем использовать легковесные объекты для представления этих параметров, чтобы не создавать новые объекты каждый раз, когда нам нужно создать новое событие.

#### Пример кода на Go

**1. Определение интерфейса Flyweight**

{% code overflow="wrap" lineNumbers="true" %}
```go
package main

import "fmt"

type EventFlyweight interface {
    Render(extrinsicState map[string]string)
}
```
{% endcode %}

**2. Реализация конкретного легковесного объекта**

{% code overflow="wrap" lineNumbers="true" %}
```go
type ConcreteEventFlyweight struct {
    Type     string
    Priority string
}

func (c *ConcreteEventFlyweight) Render(extrinsicState map[string]string) {
    // Внешнее состояние включает уникальные данные события, такие как название и дата
    name := extrinsicState["name"]
    date := extrinsicState["date"]

    // Рендеринг события
    fmt.Printf("Событие: %s\n", name)
    fmt.Printf("Тип: %s\n", c.Type)
    fmt.Printf("Приоритет: %s\n", c.Priority)
    fmt.Printf("Дата: %s\n\n", date)
}
```
{% endcode %}

**3. Фабрика легковесных объектов**

{% code overflow="wrap" lineNumbers="true" %}
```go
type EventFlyweightFactory struct {
    flyweights map[string]EventFlyweight
}

func NewEventFlyweightFactory() *EventFlyweightFactory {
    return &EventFlyweightFactory{
        flyweights: make(map[string]EventFlyweight),
    }
}

func (f *EventFlyweightFactory) GetFlyweight(typeName, priority string) EventFlyweight {
    key := typeName + "_" + priority
    if flyweight, exists := f.flyweights[key]; exists {
        return flyweight
    }
    flyweight := &ConcreteEventFlyweight{Type: typeName, Priority: priority}
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
    factory := NewEventFlyweightFactory()

    // Создаем события с использованием легковесных объектов
    events := []map[string]string{
        {"name": "Встреча с командой", "type": "Встреча", "priority": "Высокий", "date": "2023-10-01"},
        {"name": "Дедлайн проекта", "type": "Дедлайн", "priority": "Средний", "date": "2023-10-05"},
        {"name": "Обед с друзьями", "type": "Встреча", "priority": "Низкий", "date": "2023-10-03"},
    }

    for _, event := range events {
        flyweight := factory.GetFlyweight(event["type"], event["priority"])
        flyweight.Render(map[string]string{
            "name": event["name"],
            "date": event["date"],
        })
    }
}
```
{% endcode %}

#### UML Диаграмма

<figure><img src="../../../../../.gitbook/assets/image (69).png" alt=""><figcaption><p>UML диаграмма для паттерна "Легковесный объект"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
interface EventFlyweight {
    +Render(extrinsicState: map[string]string)
}

class ConcreteEventFlyweight implements EventFlyweight {
    -Type: string
    -Priority: string
    +Render(extrinsicState: map[string]string)
}

class EventFlyweightFactory {
    -flyweights: map[string]EventFlyweight
    +NewEventFlyweightFactory(): EventFlyweightFactory
    +GetFlyweight(typeName: string, priority: string): EventFlyweight
}

EventFlyweight <|-- ConcreteEventFlyweight
EventFlyweightFactory --> EventFlyweight
@enduml
```
{% endcode %}

#### Вывод для кейса

Использование паттерна Легковесный объект позволило нам значительно оптимизировать работу с событиями в нашем веб-приложении. Мы смогли сократить использование памяти и улучшить производительность, создавая легковесные объекты для общих параметров событий. Это особенно полезно, когда у нас много событий с одинаковыми или похожими состояниями.

Теперь наше приложение работает быстрее и эффективнее, что делает его более удобным для пользователей. Мы планируем продолжать использовать этот паттерн и в других частях нашего приложения, чтобы достичь еще большей оптимизации.

Надеюсь, этот пример поможет вам лучше понять, как использовать паттерн Легковесный объект в ваших проектах!
