# Python

Привет! Мы — команда разработчиков, работающая над веб-приложением для управления уведомлениями. Наше приложение позволяет пользователям создавать, редактировать и удалять уведомления, а также просматривать их в реальном времени. Мы хотим оптимизировать работу с уведомлениями, чтобы наше приложение работало быстрее и эффективнее. Для этого мы решили использовать паттерн Легковесный объект (Flyweight).

#### Описание кейса

Паттерн Легковесный объект помогает нам экономить память и ресурсы, когда у нас много объектов с одинаковыми или похожими состояниями. В нашем случае, уведомления могут иметь одинаковые параметры, такие как тип уведомления (информация, предупреждение, ошибка) и приоритет (высокий, средний, низкий). Мы можем использовать легковесные объекты для представления этих параметров, чтобы не создавать новые объекты каждый раз, когда нам нужно создать новое уведомление.

#### Пример кода на Python

**1. Определение интерфейса Flyweight**

{% code overflow="wrap" lineNumbers="true" %}
```python
from abc import ABC, abstractmethod

class NotificationFlyweight(ABC):
    @abstractmethod
    def render(self, extrinsic_state):
        pass
```
{% endcode %}

**2. Реализация конкретного легковесного объекта**

{% code overflow="wrap" lineNumbers="true" %}
```python
class ConcreteNotificationFlyweight(NotificationFlyweight):
    def __init__(self, type, priority):
        self.type = type
        self.priority = priority

    def render(self, extrinsic_state):
        # Внешнее состояние включает уникальные данные уведомления, такие как сообщение и дата
        message = extrinsic_state['message']
        date = extrinsic_state['date']

        # Рендеринг уведомления
        print(f"Сообщение: {message}")
        print(f"Тип: {self.type}")
        print(f"Приоритет: {self.priority}")
        print(f"Дата: {date}\n")
```
{% endcode %}

**3. Фабрика легковесных объектов**

{% code overflow="wrap" lineNumbers="true" %}
```python
class NotificationFlyweightFactory:
    def __init__(self):
        self.flyweights = {}

    def get_flyweight(self, type, priority):
        key = f"{type}_{priority}"
        if key not in self.flyweights:
            self.flyweights[key] = ConcreteNotificationFlyweight(type, priority)
        return self.flyweights[key]
```
{% endcode %}

**4. Использование легковесных объектов**

{% code overflow="wrap" lineNumbers="true" %}
```python
def main():
    # Создаем фабрику легковесных объектов
    factory = NotificationFlyweightFactory()

    # Создаем уведомления с использованием легковесных объектов
    notifications = [
        {"message": "Встреча с командой", "type": "Информация", "priority": "Высокий", "date": "2023-10-01"},
        {"message": "Дедлайн проекта", "type": "Предупреждение", "priority": "Средний", "date": "2023-10-05"},
        {"message": "Ошибка сервера", "type": "Ошибка", "priority": "Высокий", "date": "2023-10-03"}
    ]

    for notification in notifications:
        flyweight = factory.get_flyweight(notification["type"], notification["priority"])
        flyweight.render({
            "message": notification["message"],
            "date": notification["date"]
        })

if __name__ == "__main__":
    main()
```
{% endcode %}

#### UML Диаграмма

<figure><img src="../../../../../.gitbook/assets/image (74).png" alt=""><figcaption><p>UML диаграмма для паттерна "Легковесный объект"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
interface NotificationFlyweight {
    +render(extrinsic_state: dict)
}

class ConcreteNotificationFlyweight implements NotificationFlyweight {
    -type: string
    -priority: string
    +__init__(type: string, priority: string)
    +render(extrinsic_state: dict)
}

class NotificationFlyweightFactory {
    -flyweights: dict
    +__init__()
    +get_flyweight(type: string, priority: string): NotificationFlyweight
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
