# Python

Привет! Мы — команда разработчиков, работающая над веб-приложением для управления событиями. Наше приложение позволяет пользователям создавать, редактировать и удалять события, а также просматривать их в календаре. Мы хотим оптимизировать работу с событиями, чтобы наше приложение работало быстрее и эффективнее. Для этого мы решили использовать паттерн Легковесный объект (Flyweight).

#### Описание кейса

Паттерн Легковесный объект помогает нам экономить память и ресурсы, когда у нас много объектов с одинаковыми или похожими состояниями. В нашем случае, события могут иметь одинаковые параметры, такие как тип события (встреча, дедлайн и т.д.) и приоритет (высокий, средний, низкий). Мы можем использовать легковесные объекты для представления этих параметров, чтобы не создавать новые объекты каждый раз, когда нам нужно создать новое событие.

#### Пример кода на Python

**1. Определение интерфейса Flyweight**

{% code overflow="wrap" lineNumbers="true" %}
```python
from abc import ABC, abstractmethod

class EventFlyweight(ABC):
    @abstractmethod
    def render(self, extrinsic_state):
        pass
```
{% endcode %}

**2. Реализация конкретного легковесного объекта**

{% code overflow="wrap" lineNumbers="true" %}
```python
class ConcreteEventFlyweight(EventFlyweight):
    def __init__(self, type, priority):
        self.type = type
        self.priority = priority

    def render(self, extrinsic_state):
        # Внешнее состояние включает уникальные данные события, такие как название и дата
        name = extrinsic_state['name']
        date = extrinsic_state['date']

        # Рендеринг события
        print(f"Событие: {name}")
        print(f"Тип: {self.type}")
        print(f"Приоритет: {self.priority}")
        print(f"Дата: {date}\n")
```
{% endcode %}

**3. Фабрика легковесных объектов**

{% code overflow="wrap" lineNumbers="true" %}
```python
class EventFlyweightFactory:
    def __init__(self):
        self.flyweights = {}

    def get_flyweight(self, type, priority):
        key = f"{type}_{priority}"
        if key not in self.flyweights:
            self.flyweights[key] = ConcreteEventFlyweight(type, priority)
        return self.flyweights[key]
```
{% endcode %}

**4. Использование легковесных объектов**

{% code overflow="wrap" lineNumbers="true" %}
```python
def main():
    # Создаем фабрику легковесных объектов
    factory = EventFlyweightFactory()

    # Создаем события с использованием легковесных объектов
    events = [
        {"name": "Встреча с командой", "type": "Встреча", "priority": "Высокий", "date": "2023-10-01"},
        {"name": "Дедлайн проекта", "type": "Дедлайн", "priority": "Средний", "date": "2023-10-05"},
        {"name": "Обед с друзьями", "type": "Встреча", "priority": "Низкий", "date": "2023-10-03"}
    ]

    for event in events:
        flyweight = factory.get_flyweight(event["type"], event["priority"])
        flyweight.render({
            "name": event["name"],
            "date": event["date"]
        })

if __name__ == "__main__":
    main()
```
{% endcode %}

#### UML Диаграмма

<figure><img src="../../../../../.gitbook/assets/image (70).png" alt=""><figcaption><p>UML диаграмма для паттерна "Легковесный объект"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
interface EventFlyweight {
    +render(extrinsic_state: dict)
}

class ConcreteEventFlyweight implements EventFlyweight {
    -type: string
    -priority: string
    +__init__(type: string, priority: string)
    +render(extrinsic_state: dict)
}

class EventFlyweightFactory {
    -flyweights: dict
    +__init__()
    +get_flyweight(type: string, priority: string): EventFlyweight
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
