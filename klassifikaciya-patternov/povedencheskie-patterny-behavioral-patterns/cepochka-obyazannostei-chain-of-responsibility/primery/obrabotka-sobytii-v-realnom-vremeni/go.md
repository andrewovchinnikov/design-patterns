# Go

Представьте, что мы работаем в компании, которая разрабатывает системы мониторинга и управления умным домом. Наша задача — обрабатывать события, которые происходят в реальном времени, такие как открытие двери, включение света или изменение температуры. Мы хотим, чтобы каждое событие проходило через цепочку обработчиков, которые могут реагировать на него по-разному. Например, если дверь открывается, мы можем захотеть включить свет, отправить уведомление на телефон и записать это событие в журнал.

### Описание

Паттерн Цепочка обязанностей (Chain of Responsibility) позволяет передавать запросы последовательно по цепочке обработчиков. Каждый обработчик решает, может ли он обработать запрос сам или передать его дальше по цепочке. Этот паттерн особенно полезен, когда у нас есть несколько обработчиков, которые могут реагировать на одно и то же событие.

### Пример кода на Go

**1. Создание интерфейса обработчика**

{% code title="" overflow="wrap" %}
```go
package main

import "fmt"

type EventHandler interface {
    Handle(event Event)
    SetNext(handler EventHandler) EventHandler
}
```
{% endcode %}

**2. Создание базового класса обработчика**

{% code overflow="wrap" lineNumbers="true" %}
```go
type BaseEventHandler struct {
    nextHandler EventHandler
}

func (b *BaseEventHandler) SetNext(handler EventHandler) EventHandler {
    b.nextHandler = handler
    return handler
}

func (b *BaseEventHandler) Handle(event Event) {
    if b.nextHandler != nil {
        b.nextHandler.Handle(event)
    }
}
```
{% endcode %}

**3. Создание класса события**

{% code overflow="wrap" lineNumbers="true" %}
```go
type Event struct {
    Type string
    Data map[string]interface{}
}

func NewEvent(eventType string, data map[string]interface{}) Event {
    return Event{Type: eventType, Data: data}
}
```
{% endcode %}

**4. Создание конкретных обработчиков**

{% code overflow="wrap" lineNumbers="true" %}
```go
type LightHandler struct {
    BaseEventHandler
}

func (l *LightHandler) Handle(event Event) {
    if event.Type == "door_open" {
        fmt.Println("Turning on the light.")
    }
    l.BaseEventHandler.Handle(event)
}

type NotificationHandler struct {
    BaseEventHandler
}

func (n *NotificationHandler) Handle(event Event) {
    if event.Type == "door_open" {
        fmt.Println("Sending notification to the phone.")
    }
    n.BaseEventHandler.Handle(event)
}

type LogHandler struct {
    BaseEventHandler
}

func (l *LogHandler) Handle(event Event) {
    fmt.Printf("Logging event: %s\n", event.Type)
    l.BaseEventHandler.Handle(event)
}
```
{% endcode %}

**5. Создание цепочки обработчиков и обработка события**

{% code overflow="wrap" lineNumbers="true" %}
```go
func main() {
    lightHandler := &LightHandler{}
    notificationHandler := &NotificationHandler{}
    logHandler := &LogHandler{}

    lightHandler.SetNext(notificationHandler).SetNext(logHandler)

    event := NewEvent("door_open", nil)
    lightHandler.Handle(event)
}
```
{% endcode %}

### UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для паттерна "Цепочка обязанностей"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plantuml
@startuml
interface EventHandler {
    +Handle(event Event)
    +SetNext(handler EventHandler): EventHandler
}

class BaseEventHandler {
    -nextHandler: EventHandler
    +SetNext(handler EventHandler): EventHandler
    +Handle(event Event)
}

class LightHandler {
    +Handle(event Event)
}

class NotificationHandler {
    +Handle(event Event)
}

class LogHandler {
    +Handle(event Event)
}

class Event {
    -Type: string
    -Data: map[string]interface{}
    +NewEvent(eventType string, data map[string]interface{}): Event
}

EventHandler <|-- BaseEventHandler
BaseEventHandler <|-- LightHandler
BaseEventHandler <|-- NotificationHandler
BaseEventHandler <|-- LogHandler
@enduml
```
{% endcode %}

### Вывод

Мы создали систему обработки событий в реальном времени, используя паттерн Цепочка обязанностей. Каждый обработчик может реагировать на событие по-своему или передавать его дальше по цепочке. Это позволяет нам гибко добавлять новые обработчики и изменять порядок их выполнения без изменения существующего кода. Такой подход делает систему более модульной и легко расширяемой.
