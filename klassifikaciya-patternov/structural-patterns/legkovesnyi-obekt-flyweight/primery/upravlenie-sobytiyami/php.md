# PHP

Привет! Мы — команда разработчиков, работающая над веб-приложением для управления событиями. Наше приложение позволяет пользователям создавать, редактировать и удалять события, а также просматривать их в календаре. Мы хотим оптимизировать работу с событиями, чтобы наше приложение работало быстрее и эффективнее. Для этого мы решили использовать паттерн Легковесный объект (Flyweight).

#### Описание кейса

Паттерн Легковесный объект помогает нам экономить память и ресурсы, когда у нас много объектов с одинаковыми или похожими состояниями. В нашем случае, события могут иметь одинаковые параметры, такие как тип события (встреча, дедлайн и т.д.) и приоритет (высокий, средний, низкий). Мы можем использовать легковесные объекты для представления этих параметров, чтобы не создавать новые объекты каждый раз, когда нам нужно создать новое событие.

#### Пример кода на PHP

**1. Определение интерфейса Flyweight**

{% code overflow="wrap" lineNumbers="true" %}
```php
interface EventFlyweight {
    public function render(array $extrinsicState);
}
```
{% endcode %}

**2. Реализация конкретного легковесного объекта**

{% code overflow="wrap" lineNumbers="true" %}
```php
class ConcreteEventFlyweight implements EventFlyweight {
    private $type;
    private $priority;

    public function __construct($type, $priority) {
        $this->type = $type;
        $this->priority = $priority;
    }

    public function render(array $extrinsicState) {
        // Внешнее состояние включает уникальные данные события, такие как название и дата
        $name = $extrinsicState['name'];
        $date = $extrinsicState['date'];

        // Рендеринг события
        echo "Событие: $name<br>";
        echo "Тип: $this->type<br>";
        echo "Приоритет: $this->priority<br>";
        echo "Дата: $date<br><br>";
    }
}
```
{% endcode %}

**3. Фабрика легковесных объектов**

{% code overflow="wrap" lineNumbers="true" %}
```php
class EventFlyweightFactory {
    private $flyweights = [];

    public function getFlyweight($type, $priority) {
        $key = $type . '_' . $priority;
        if (!isset($this->flyweights[$key])) {
            $this->flyweights[$key] = new ConcreteEventFlyweight($type, $priority);
        }
        return $this->flyweights[$key];
    }
}
```
{% endcode %}

**4. Использование легковесных объектов**

{% code overflow="wrap" lineNumbers="true" %}
```php
// Создаем фабрику легковесных объектов
$factory = new EventFlyweightFactory();

// Создаем события с использованием легковесных объектов
$events = [
    ['name' => 'Встреча с командой', 'type' => 'Встреча', 'priority' => 'Высокий', 'date' => '2023-10-01'],
    ['name' => 'Дедлайн проекта', 'type' => 'Дедлайн', 'priority' => 'Средний', 'date' => '2023-10-05'],
    ['name' => 'Обед с друзьями', 'type' => 'Встреча', 'priority' => 'Низкий', 'date' => '2023-10-03']
];

foreach ($events as $event) {
    $flyweight = $factory->getFlyweight($event['type'], $event['priority']);
    $flyweight->render([
        'name' => $event['name'],
        'date' => $event['date']
    ]);
}
```
{% endcode %}

#### UML Диаграмма

<figure><img src="../../../../../.gitbook/assets/image (68).png" alt=""><figcaption><p>UML диаграмма для паттерна "Легковесный объект"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
interface EventFlyweight {
    +render(extrinsicState: array)
}

class ConcreteEventFlyweight implements EventFlyweight {
    -type: string
    -priority: string
    +__construct(type: string, priority: string)
    +render(extrinsicState: array)
}

class EventFlyweightFactory {
    -flyweights: array
    +getFlyweight(type: string, priority: string): EventFlyweight
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
