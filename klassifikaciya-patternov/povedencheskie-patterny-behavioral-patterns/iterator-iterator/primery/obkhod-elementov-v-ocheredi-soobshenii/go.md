# Go

Мы — команда разработчиков, работающая над веб-приложением для управления очередями сообщений. Наша задача — обработать все сообщения в очереди и выполнить определенные действия для каждого сообщения. Для этого мы будем использовать паттерн "Итератор", который позволит нам последовательно обрабатывать элементы очереди, не заботясь о её внутренней структуре.

### Описание кейса

Мы хотим создать систему, которая будет обрабатывать сообщения из очереди. Каждое сообщение может содержать различные данные, и нам нужно выполнить определенные действия для каждого сообщения. Паттерн "Итератор" поможет нам абстрагироваться от внутренней структуры очереди и сосредоточиться на обработке сообщений.

### Пример кода на Go

**1. Определение интерфейса Iterator**

{% code overflow="wrap" lineNumbers="true" %}
```go
package main

import "fmt"

type Iterator interface {
    First()
    Next()
    IsDone() bool
    CurrentItem() interface{}
}
```
{% endcode %}

**2. Определение интерфейса Aggregate**

{% code overflow="wrap" lineNumbers="true" %}
```go
type Aggregate interface {
    CreateIterator() Iterator
}
```
{% endcode %}

**3. Реализация конкретного итератора**

{% code overflow="wrap" lineNumbers="true" %}
```go
type MessageQueueIterator struct {
    queue  []interface{}
    index  int
}

func (i *MessageQueueIterator) First() {
    i.index = 0
}

func (i *MessageQueueIterator) Next() {
    i.index++
}

func (i *MessageQueueIterator) IsDone() bool {
    return i.index >= len(i.queue)
}

func (i *MessageQueueIterator) CurrentItem() interface{} {
    if i.IsDone() {
        return nil
    }
    return i.queue[i.index]
}
```
{% endcode %}

**4. Реализация конкретного агрегата**

{% code overflow="wrap" lineNumbers="true" %}
```go
type MessageQueue struct {
    messages []interface{}
}

func (q *MessageQueue) AddMessage(message interface{}) {
    q.messages = append(q.messages, message)
}

func (q *MessageQueue) CreateIterator() Iterator {
    return &MessageQueueIterator{queue: q.messages}
}
```
{% endcode %}

**5. Использование итератора для обработки сообщений**

{% code overflow="wrap" lineNumbers="true" %}
```go
func main() {
    // Создаем очередь сообщений
    messageQueue := &MessageQueue{}
    messageQueue.AddMessage("Сообщение 1")
    messageQueue.AddMessage("Сообщение 2")
    messageQueue.AddMessage("Сообщение 3")

    // Создаем итератор для очереди
    iterator := messageQueue.CreateIterator()

    // Обрабатываем сообщения
    for iterator.First(); !iterator.IsDone(); iterator.Next() {
        message := iterator.CurrentItem()
        fmt.Printf("Обработка сообщения: %v\n", message)
    }
}
```
{% endcode %}

### UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для паттерна "Итератор"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plantuml
@startuml

interface Iterator {
    +First(): void
    +Next(): void
    +IsDone(): boolean
    +CurrentItem(): any
}

class MessageQueueIterator {
    -queue: List<any>
    -index: int
    +First(): void
    +Next(): void
    +IsDone(): boolean
    +CurrentItem(): any
}

interface Aggregate {
    +CreateIterator(): Iterator
}

class MessageQueue {
    -messages: List<any>
    +AddMessage(message: any): void
    +CreateIterator(): Iterator
}

Iterator <|-- MessageQueueIterator
Aggregate <|-- MessageQueue
MessageQueue --> MessageQueueIterator: <<create>>

@enduml
```
{% endcode %}

### Вывод

В этом кейсе мы рассмотрели применение паттерна "Итератор" для обработки сообщений в очереди. Мы создали интерфейсы `Iterator` и `Aggregate`, а также их конкретные реализации `MessageQueueIterator` и `MessageQueue`. Это позволило нам абстрагироваться от внутренней структуры очереди и сосредоточиться на обработке сообщений.

Паттерн "Итератор" оказался очень полезным для последовательной обработки элементов коллекции, не заботясь о её внутренней структуре. Это упрощает код и делает его более гибким и поддерживаемым.

Надеюсь, этот пример поможет вам лучше понять, как использовать паттерн "Итератор" в ваших проектах!
