# Python

Привет! Мы — команда разработчиков, работающая над веб-приложением для управления пользовательскими настройками. Наше приложение позволяет пользователям настраивать различные параметры, такие как темы оформления, язык интерфейса и уведомления. Мы хотим оптимизировать работу с пользовательскими настройками, чтобы наше приложение работало быстрее и эффективнее. Для этого мы решили использовать паттерн Легковесный объект (Flyweight).

#### Описание кейса

Паттерн Легковесный объект помогает нам экономить память и ресурсы, когда у нас много объектов с одинаковыми или похожими состояниями. В нашем случае, пользовательские настройки могут иметь одинаковые параметры, такие как тема оформления (светлая, темная) и язык интерфейса (русский, английский). Мы можем использовать легковесные объекты для представления этих параметров, чтобы не создавать новые объекты каждый раз, когда нам нужно создать новые настройки для пользователя.

#### Пример кода на Python

**1. Определение интерфейса Flyweight**

{% code overflow="wrap" lineNumbers="true" %}
```python
from abc import ABC, abstractmethod

class UserSettingsFlyweight(ABC):
    @abstractmethod
    def render(self, extrinsic_state):
        pass
```
{% endcode %}

**2. Реализация конкретного легковесного объекта**

{% code overflow="wrap" lineNumbers="true" %}
```python
class ConcreteUserSettingsFlyweight(UserSettingsFlyweight):
    def __init__(self, theme, language):
        self.theme = theme
        self.language = language

    def render(self, extrinsic_state):
        # Внешнее состояние включает уникальные данные пользователя, такие как имя пользователя и дата настройки
        username = extrinsic_state['username']
        date = extrinsic_state['date']

        # Рендеринг настроек пользователя
        print(f"Пользователь: {username}")
        print(f"Тема: {self.theme}")
        print(f"Язык: {self.language}")
        print(f"Дата настройки: {date}\n")
```
{% endcode %}

**3. Фабрика легковесных объектов**

{% code overflow="wrap" lineNumbers="true" %}
```python
class UserSettingsFlyweightFactory:
    def __init__(self):
        self.flyweights = {}

    def get_flyweight(self, theme, language):
        key = f"{theme}_{language}"
        if key not in self.flyweights:
            self.flyweights[key] = ConcreteUserSettingsFlyweight(theme, language)
        return self.flyweights[key]
```
{% endcode %}

**4. Использование легковесных объектов**

{% code overflow="wrap" lineNumbers="true" %}
```python
def main():
    # Создаем фабрику легковесных объектов
    factory = UserSettingsFlyweightFactory()

    # Создаем пользовательские настройки с использованием легковесных объектов
    settings = [
        {"username": "Иван", "theme": "Светлая", "language": "Русский", "date": "2023-10-01"},
        {"username": "Мария", "theme": "Темная", "language": "Английский", "date": "2023-10-05"},
        {"username": "Алексей", "theme": "Светлая", "language": "Русский", "date": "2023-10-03"}
    ]

    for setting in settings:
        flyweight = factory.get_flyweight(setting["theme"], setting["language"])
        flyweight.render({
            "username": setting["username"],
            "date": setting["date"]
        })

if __name__ == "__main__":
    main()
```
{% endcode %}

#### UML Диаграмма

<figure><img src="../../../../../.gitbook/assets/image (73).png" alt=""><figcaption><p>UML диаграмма для паттерна "Легковесный объект"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
interface UserSettingsFlyweight {
    +render(extrinsic_state: dict)
}

class ConcreteUserSettingsFlyweight implements UserSettingsFlyweight {
    -theme: string
    -language: string
    +__init__(theme: string, language: string)
    +render(extrinsic_state: dict)
}

class UserSettingsFlyweightFactory {
    -flyweights: dict
    +__init__()
    +get_flyweight(theme: string, language: string): UserSettingsFlyweight
}

UserSettingsFlyweight <|-- ConcreteUserSettingsFlyweight
UserSettingsFlyweightFactory --> UserSettingsFlyweight
@enduml
```
{% endcode %}

#### Вывод для кейса

Использование паттерна Легковесный объект позволило нам значительно оптимизировать работу с пользовательскими настройками в нашем веб-приложении. Мы смогли сократить использование памяти и улучшить производительность, создавая легковесные объекты для общих параметров настроек. Это особенно полезно, когда у нас много пользователей с одинаковыми или похожими настройками.

Теперь наше приложение работает быстрее и эффективнее, что делает его более удобным для пользователей. Мы планируем продолжать использовать этот паттерн и в других частях нашего приложения, чтобы достичь еще большей оптимизации.

Надеюсь, этот пример поможет вам лучше понять, как использовать паттерн Легковесный объект в ваших проектах!
