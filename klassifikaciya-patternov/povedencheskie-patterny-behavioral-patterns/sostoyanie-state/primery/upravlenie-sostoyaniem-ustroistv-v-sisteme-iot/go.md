# Go

Мы — команда разработчиков, работающая над системой управления проектами. Наша задача — сделать так, чтобы пользователи могли легко отслеживать статус своих задач и получать уведомления о любых изменениях. В этом кейсе мы рассмотрим, как можно использовать паттерн "Наблюдатель" для реализации системы уведомлений о статусе задач на языке Go.

### Описание кейса

Наша система управления проектами позволяет пользователям создавать задачи и отслеживать их статус. Когда статус задачи изменяется (например, с "В процессе" на "Завершено"), все заинтересованные пользователи должны получать уведомления. Для этого мы будем использовать паттерн "Наблюдатель", который позволяет объектам (наблюдателям) подписываться на события, происходящие в другом объекте (субъекте), и получать уведомления об этих событиях.

### Применение паттерна

Паттерн "Наблюдатель" идеально подходит для нашей задачи, так как он позволяет легко добавлять и удалять наблюдателей (пользователей), которые будут получать уведомления о изменении статуса задач. Это упрощает управление уведомлениями и делает систему более гибкой.

### UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (107).png" alt=""><figcaption><p>UML диаграмма для паттерна "Наблюдатель"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml

interface Observer {
    +update(subject: Subject): void
}

class Subject {
    -observers: List<Observer>
    +attach(observer: Observer): void
    +detach(observer: Observer): void
    +notify(): void
}

class Task extends Subject {
    -status: String
    +setStatus(status: String): void
    +getStatus(): String
}

class User implements Observer {
    -name: String
    +User(name: String)
    +update(subject: Subject): void
}

Subject "1" -- "*" Observer: <<notify>>
Task --> Subject: <<extend>>
User --> Observer: <<implement>>
User --> Subject: <<observe>>

@enduml
```
{% endcode %}

### Пример кода на Go

**Интерфейс Observer**

{% code overflow="wrap" lineNumbers="true" %}
```go
package main

type Observer interface {
    update(subject Subject)
}
```
{% endcode %}

**Класс Subject**

{% code overflow="wrap" lineNumbers="true" %}
```go
package main

type Subject struct {
    observers []Observer
}

func (s *Subject) attach(observer Observer) {
    s.observers = append(s.observers, observer)
}

func (s *Subject) detach(observer Observer) {
    for i, obs := range s.observers {
        if obs == observer {
            s.observers = append(s.observers[:i], s.observers[i+1:]...)
            break
        }
    }
}

func (s *Subject) notify() {
    for _, observer := range s.observers {
        observer.update(s)
    }
}
```
{% endcode %}

**Класс Task (наследует Subject)**

{% code overflow="wrap" lineNumbers="true" %}
```go
package main

type Task struct {
    Subject
    status string
}

func (t *Task) setStatus(status string) {
    t.status = status
    t.notify()
}

func (t *Task) getStatus() string {
    return t.status
}
```
{% endcode %}

**Класс User (реализует Observer)**

{% code overflow="wrap" lineNumbers="true" %}
```go
package main

import "fmt"

type User struct {
    name string
}

func NewUser(name string) *User {
    return &User{name: name}
}

func (u *User) update(subject Subject) {
    if task, ok := subject.(*Task); ok {
        fmt.Printf("Уведомление для %s: Статус задачи изменен на %s\n", u.name, task.getStatus())
    }
}
```
{% endcode %}

#### Пример использования

{% code overflow="wrap" lineNumbers="true" %}
```go
package main

func main() {
    // Создаем задачу
    task := &Task{}

    // Создаем пользователей
    user1 := NewUser("Иван")
    user2 := NewUser("Мария")

    // Подписываем пользователей на уведомления о статусе задачи
    task.attach(user1)
    task.attach(user2)

    // Изменяем статус задачи
    task.setStatus("В процессе")
    task.setStatus("Завершено")
}
```
{% endcode %}

### Вывод для кейса

В этом кейсе мы рассмотрели, как можно использовать паттерн "Наблюдатель" для реализации системы уведомлений о статусе задач на языке Go. Мы создали интерфейс `Observer`, класс `Subject`, который управляет списком наблюдателей, и классы `Task` и `User`, которые реализуют логику задачи и пользователя соответственно.

Паттерн "Наблюдатель" позволяет легко добавлять и удалять наблюдателей, что делает систему гибкой и удобной для расширения. В результате, пользователи получают уведомления о любых изменениях статуса задач, что улучшает их взаимодействие с системой управления проектами.
