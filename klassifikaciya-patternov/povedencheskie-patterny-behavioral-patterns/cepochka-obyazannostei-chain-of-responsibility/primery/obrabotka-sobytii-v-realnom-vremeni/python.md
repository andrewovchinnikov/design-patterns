# Python

#### Вводная часть

Представьте, что мы работаем в компании, которая разрабатывает системы мониторинга и управления умным домом. Наша задача — обрабатывать события, которые происходят в реальном времени, такие как открытие двери, включение света или изменение температуры. Мы хотим, чтобы каждое событие проходило через цепочку обработчиков, которые могут реагировать на него по-разному. Например, если дверь открывается, мы можем захотеть включить свет, отправить уведомление на телефон и записать это событие в журнал.

### Описание паттерна

Паттерн Цепочка обязанностей (Chain of Responsibility) позволяет передавать запросы последовательно по цепочке обработчиков. Каждый обработчик решает, может ли он обработать запрос сам или передать его дальше по цепочке. Этот паттерн особенно полезен, когда у нас есть несколько обработчиков, которые могут реагировать на одно и то же событие.

### Пример кода на Python

**1. Создание интерфейса обработчика**

{% code overflow="wrap" lineNumbers="true" %}
```python
from abc import ABC, abstractmethod

class EventHandler(ABC):
    @abstractmethod
    def handle(self, event):
        pass

    @abstractmethod
    def set_next(self, handler):
        pass
```
{% endcode %}

**2. Создание базового класса обработчика**

{% code overflow="wrap" lineNumbers="true" %}
```python
class BaseEventHandler(EventHandler):
    def __init__(self):
        self._next_handler = None

    def set_next(self, handler):
        self._next_handler = handler
        return handler

    def handle(self, event):
        if self._next_handler:
            self._next_handler.handle(event)
```
{% endcode %}

**3. Создание класса события**

{% code overflow="wrap" lineNumbers="true" %}
```python
class Event:
    def __init__(self, event_type, data=None):
        self.event_type = event_type
        self.data = data if data is not None else {}

    def get_type(self):
        return self.event_type

    def get_data(self):
        return self.data
```
{% endcode %}

**4. Создание конкретных обработчиков**

{% code overflow="wrap" lineNumbers="true" %}
```python
class LightHandler(BaseEventHandler):
    def handle(self, event):
        if event.get_type() == 'door_open':
            print("Turning on the light.")
        super().handle(event)

class NotificationHandler(BaseEventHandler):
    def handle(self, event):
        if event.get_type() == 'door_open':
            print("Sending notification to the phone.")
        super().handle(event)

class LogHandler(BaseEventHandler):
    def handle(self, event):
        print(f"Logging event: {event.get_type()}")
        super().handle(event)
```
{% endcode %}

**5. Создание цепочки обработчиков и обработка события**

{% code overflow="wrap" lineNumbers="true" %}
```python
if __name__ == "__main__":
    light_handler = LightHandler()
    notification_handler = NotificationHandler()
    log_handler = LogHandler()

    light_handler.set_next(notification_handler).set_next(log_handler)

    event = Event('door_open')
    light_handler.handle(event)
```
{% endcode %}

#### UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (85).png" alt=""><figcaption><p>UML диаграмма для паттерна "Цепочка обязанностей"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plantuml
@startuml
interface EventHandler {
    +handle(event Event)
    +set_next(handler EventHandler): EventHandler
}

class BaseEventHandler {
    -_next_handler: EventHandler
    +set_next(handler EventHandler): EventHandler
    +handle(event Event)
}

class LightHandler {
    +handle(event Event)
}

class NotificationHandler {
    +handle(event Event)
}

class LogHandler {
    +handle(event Event)
}

class Event {
    -event_type: string
    -data: dict
    +__init__(event_type string, data dict): Event
    +get_type(): string
    +get_data(): dict
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
