# Наблюдатель (Observer)

### **Описание**

Паттерн "Наблюдатель" (Observer) — это поведенческий паттерн проектирования, который позволяет объектам (наблюдателям) подписываться на события, происходящие в другом объекте (субъекте), и получать уведомления об этих событиях. Этот паттерн часто используется для реализации механизмов уведомлений и рассылки событий.

### **UML диаграмма**

<figure><img src="../../../.gitbook/assets/image (105).png" alt=""><figcaption><p>UML диаграмма для паттерна "Наблюдатель"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plaintext
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

class ConcreteSubject extends Subject {
    -state: String
    +setState(state: String): void
    +getState(): String
}

class ConcreteObserver implements Observer {
    -subject: Subject
    -state: String
    +ConcreteObserver(subject: Subject)
    +update(subject: Subject): void
}

Subject "1" -- "*" Observer: <<notify>>
ConcreteSubject --> Subject: <<extend>>
ConcreteObserver --> Observer: <<implement>>
ConcreteObserver --> Subject: <<observe>>

@enduml
```
{% endcode %}

### **Преимущества**

1. **Разделение ответственности**: Наблюдатели и субъекты имеют четко разделенные обязанности, что упрощает поддержку и расширение кода.
2. **Гибкость**: Легко добавлять и удалять наблюдателей без изменения субъекта.
3. **Динамическое поведение**: Позволяет динамически изменять поведение объектов в зависимости от их состояния.

### **Недостатки**

1. **Сложность**: Введение паттерна "Наблюдатель" может усложнить код, особенно если наблюдателей много.
2. **Производительность**: Уведомление большого количества наблюдателей может потребовать значительных ресурсов.

### **Применение**

1. **Системы уведомлений**: Когда нужно реализовать механизм уведомлений о событиях.
2. **Системы рассылки событий**: Когда нужно рассылать события между различными компонентами системы.
3. **Системы мониторинга**: Когда нужно отслеживать изменения состояния объектов.

**Примеры использования**

1. **Пользовательские интерфейсы**: В графических интерфейсах для обновления элементов интерфейса при изменении данных.
2. **Системы управления задачами**: В системах управления задачами для уведомления пользователей о изменениях статуса задач.
3. **Системы мониторинга**: В системах мониторинга для отслеживания изменений состояния серверов и устройств.

### **Объяснение паттерна**

Паттерн "Наблюдатель" позволяет объектам (наблюдателям) подписываться на события, происходящие в другом объекте (субъекте), и получать уведомления об этих событиях. Основные компоненты паттерна включают:

1. **Subject (Субъект)**: Объект, который содержит список наблюдателей и предоставляет методы для добавления, удаления и уведомления наблюдателей.
2. **Observer (Наблюдатель)**: Интерфейс, который определяет метод `update`, который будет вызываться субъектом для уведомления наблюдателей.
3. **ConcreteSubject (Конкретный субъект)**: Реализация субъекта, которая содержит состояние и методы для его изменения.
4. **ConcreteObserver (Конкретный наблюдатель)**: Реализация наблюдателя, которая подписывается на события субъекта и обновляет свое состояние при получении уведомлений.

Паттерн "Наблюдатель" является мощным инструментом для управления событиями и уведомлениями в системах. Он широко используется в различных областях, таких как системы уведомлений, системы рассылки событий и системы мониторинга.
