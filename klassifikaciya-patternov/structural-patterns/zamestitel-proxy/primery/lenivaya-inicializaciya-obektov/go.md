# Go

Привет! Мы — команда разработчиков, работающая над веб-приложением для управления уведомлениями. Наше приложение позволяет пользователям создавать, редактировать и удалять уведомления, а также просматривать их в реальном времени. Мы хотим оптимизировать работу с уведомлениями, чтобы наше приложение работало быстрее и эффективнее. Для этого мы решили использовать паттерн Легковесный объект (Flyweight).

#### Описание кейса

Паттерн Легковесный объект помогает нам экономить память и ресурсы, когда у нас много объектов с одинаковыми или похожими состояниями. В нашем случае, уведомления могут иметь одинаковые параметры, такие как тип уведомления (информация, предупреждение, ошибка) и приоритет (высокий, средний, низкий). Мы можем использовать легковесные объекты для представления этих параметров, чтобы не создавать новые объекты каждый раз, когда нам нужно создать новое уведомление.

#### Пример кода на Go

**1. Определение интерфейса Flyweight**

{% code overflow="wrap" lineNumbers="true" %}
```go
package main

import "fmt"

type NotificationFlyweight interface {
    Render(extrinsicState map[string]string)
}
```
{% endcode %}

**2. Реализация конкретного легковесного объекта**

{% code overflow="wrap" lineNumbers="true" %}
```go
type ConcreteNotificationFlyweight struct {
    Type     string
    Priority string
}

func (c *ConcreteNotificationFlyweight) Render(extrinsicState map[string]string) {
    // Внешнее состояние включает уникальные данные уведомления, такие как сообщение и дата
    message := extrinsicState["message"]
    date := extrinsicState["date"]

    // Рендеринг уведомления
    fmt.Printf("Сообщение: %s\n", message)
    fmt.Printf("Тип: %s\n", c.Type)
    fmt.Printf("Приоритет: %s\n", c.Priority)
    fmt.Printf("Дата: %s\n\n", date)
}
```
{% endcode %}

**3. Фабрика легковесных объектов**

{% code overflow="wrap" lineNumbers="true" %}
```go
type NotificationFlyweightFactory struct {
    flyweights map[string]NotificationFlyweight
}

func NewNotificationFlyweightFactory() *NotificationFlyweightFactory {
    return &NotificationFlyweightFactory{
        flyweights: make(map[string]NotificationFlyweight),
    }
}

func (f *NotificationFlyweightFactory) GetFlyweight(typeName, priority string) NotificationFlyweight {
    key := typeName + "_" + priority
    if flyweight, exists := f.flyweights[key]; exists {
        return flyweight
    }
    flyweight := &ConcreteNotificationFlyweight{Type: typeName, Priority: priority}
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
    factory := NewNotificationFlyweightFactory()

    // Создаем уведомления с использованием легковесных объектов
    notifications := []map[string]string{
        {"message": "Встреча с командой", "type": "Информация", "priority": "Высокий", "date": "2023-10-01"},
        {"message": "Дедлайн проекта", "type": "Предупреждение", "priority": "Средний", "date": "2023-10-05"},
        {"message": "Ошибка сервера", "type": "Ошибка", "priority": "Высокий", "date": "2023-10-03"},
    }

    for _, notification := range notifications {
        flyweight := factory.GetFlyweight(notification["type"], notification["priority"])
        flyweight.Render(map[string]string{
            "message": notification["message"],
            "date":    notification["date"],
        })
    }
}
```
{% endcode %}

#### UML Диаграмма

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для паттерна "Легковесный объект"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
interface NotificationFlyweight {
    +Render(extrinsicState: map[string]string)
}

class ConcreteNotificationFlyweight implements NotificationFlyweight {
    -Type: string
    -Priority: string
    +Render(extrinsicState: map[string]string)
}

class NotificationFlyweightFactory {
    -flyweights: map[string]NotificationFlyweight
    +NewNotificationFlyweightFactory(): NotificationFlyweightFactory
    +GetFlyweight(typeName: string, priority: string): NotificationFlyweight
}

NotificationFlyweight <|-- ConcreteNotificationFlyweight
NotificationFlyweightFactory --> NotificationFlyweight
@enduml
```
{% endcode %}

#### Вывод для кейса

Использование паттерна Легковесный объект позволило нам значительно оптимизировать работу с уведомлениями в нашем веб-приложении. Мы смогли сократить использование памяти и улучшить производительность, создавая легковесные объекты для общих параметров уведомлений. Это особенно полезно, когда у нас много уведомлений с одинаковыми или похожими состояниями.

Теперь наше приложение работает быстрее и эффективнее, что делает его более удобным для пользователей. Мы планируем продолжать использовать этот паттерн и в других частях нашего приложения, чтобы достичь еще большей оптимизации.

Надеюсь, этот пример поможет вам лучше понять, как использовать паттерн Легковесный объект в ваших проектах!
