# Python

Мы — команда разработчиков, работающая над системой управления проектами. Наша задача — сделать так, чтобы пользователи могли легко отслеживать статус своих задач и получать уведомления о любых изменениях. В этом кейсе мы рассмотрим, как можно использовать паттерн "Наблюдатель" для реализации системы уведомлений о статусе задач на языке Python.

### Описание кейса

Наша система управления проектами позволяет пользователям создавать задачи и отслеживать их статус. Когда статус задачи изменяется (например, с "В процессе" на "Завершено"), все заинтересованные пользователи должны получать уведомления. Для этого мы будем использовать паттерн "Наблюдатель", который позволяет объектам (наблюдателям) подписываться на события, происходящие в другом объекте (субъекте), и получать уведомления об этих событиях.

### Применение паттерна

Паттерн "Наблюдатель" идеально подходит для нашей задачи, так как он позволяет легко добавлять и удалять наблюдателей (пользователей), которые будут получать уведомления о изменении статуса задач. Это упрощает управление уведомлениями и делает систему более гибкой.

### UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (108).png" alt=""><figcaption><p>UML диаграмма для паттерна "Наблюдатель"</p></figcaption></figure>

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

### Пример кода на Python

**Интерфейс Observer**

{% code overflow="wrap" lineNumbers="true" %}
```python
from abc import ABC, abstractmethod

class Observer(ABC):
    @abstractmethod
    def update(self, subject):
        pass
```
{% endcode %}

**Класс Subject**

{% code overflow="wrap" lineNumbers="true" %}
```python
class Subject:
    def __init__(self):
        self._observers = []

    def attach(self, observer):
        self._observers.append(observer)

    def detach(self, observer):
        self._observers.remove(observer)

    def notify(self):
        for observer in self._observers:
            observer.update(self)
```
{% endcode %}

**Класс Task (наследует Subject)**

{% code overflow="wrap" lineNumbers="true" %}
```python
class Task(Subject):
    def __init__(self):
        super().__init__()
        self._status = None

    def set_status(self, status):
        self._status = status
        self.notify()

    def get_status(self):
        return self._status
```
{% endcode %}

**Класс User (реализует Observer)**

{% code overflow="wrap" lineNumbers="true" %}
```python
class User(Observer):
    def __init__(self, name):
        self.name = name

    def update(self, subject):
        if isinstance(subject, Task):
            print(f"Уведомление для {self.name}: Статус задачи изменен на {subject.get_status()}")
```
{% endcode %}

#### Пример использования

{% code overflow="wrap" lineNumbers="true" %}
```python
if __name__ == "__main__":
    # Создаем задачу
    task = Task()

    # Создаем пользователей
    user1 = User("Иван")
    user2 = User("Мария")

    # Подписываем пользователей на уведомления о статусе задачи
    task.attach(user1)
    task.attach(user2)

    # Изменяем статус задачи
    task.set_status("В процессе")
    task.set_status("Завершено")
```
{% endcode %}

### Вывод для кейса

В этом кейсе мы рассмотрели, как можно использовать паттерн "Наблюдатель" для реализации системы уведомлений о статусе задач на языке Python. Мы создали интерфейс `Observer`, класс `Subject`, который управляет списком наблюдателей, и классы `Task` и `User`, которые реализуют логику задачи и пользователя соответственно.

Паттерн "Наблюдатель" позволяет легко добавлять и удалять наблюдателей, что делает систему гибкой и удобной для расширения. В результате, пользователи получают уведомления о любых изменениях статуса задач, что улучшает их взаимодействие с системой управления проектами.
