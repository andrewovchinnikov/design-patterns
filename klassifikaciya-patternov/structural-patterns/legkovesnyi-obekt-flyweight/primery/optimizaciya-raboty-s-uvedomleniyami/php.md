# PHP

Привет! Мы — команда разработчиков, работающая над веб-приложением для управления уведомлениями. Наше приложение позволяет пользователям создавать, редактировать и удалять уведомления, а также просматривать их в реальном времени. Мы хотим оптимизировать работу с уведомлениями, чтобы наше приложение работало быстрее и эффективнее. Для этого мы решили использовать паттерн Легковесный объект (Flyweight).

#### Описание кейса

Паттерн Легковесный объект помогает нам экономить память и ресурсы, когда у нас много объектов с одинаковыми или похожими состояниями. В нашем случае, уведомления могут иметь одинаковые параметры, такие как тип уведомления (информация, предупреждение, ошибка) и приоритет (высокий, средний, низкий). Мы можем использовать легковесные объекты для представления этих параметров, чтобы не создавать новые объекты каждый раз, когда нам нужно создать новое уведомление.

#### Пример кода на PHP

**1. Определение интерфейса Flyweight**

{% code overflow="wrap" lineNumbers="true" %}
```php
interface NotificationFlyweight {
    public function render(array $extrinsicState);
}
```
{% endcode %}

**2. Реализация конкретного легковесного объекта**

{% code overflow="wrap" lineNumbers="true" %}
```php
class ConcreteNotificationFlyweight implements NotificationFlyweight {
    private $type;
    private $priority;

    public function __construct($type, $priority) {
        $this->type = $type;
        $this->priority = $priority;
    }

    public function render(array $extrinsicState) {
        // Внешнее состояние включает уникальные данные уведомления, такие как сообщение и дата
        $message = $extrinsicState['message'];
        $date = $extrinsicState['date'];

        // Рендеринг уведомления
        echo "Сообщение: $message<br>";
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
class NotificationFlyweightFactory {
    private $flyweights = [];

    public function getFlyweight($type, $priority) {
        $key = $type . '_' . $priority;
        if (!isset($this->flyweights[$key])) {
            $this->flyweights[$key] = new ConcreteNotificationFlyweight($type, $priority);
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
$factory = new NotificationFlyweightFactory();

// Создаем уведомления с использованием легковесных объектов
$notifications = [
    ['message' => 'Встреча с командой', 'type' => 'Информация', 'priority' => 'Высокий', 'date' => '2023-10-01'],
    ['message' => 'Дедлайн проекта', 'type' => 'Предупреждение', 'priority' => 'Средний', 'date' => '2023-10-05'],
    ['message' => 'Ошибка сервера', 'type' => 'Ошибка', 'priority' => 'Высокий', 'date' => '2023-10-03']
];

foreach ($notifications as $notification) {
    $flyweight = $factory->getFlyweight($notification['type'], $notification['priority']);
    $flyweight->render([
        'message' => $notification['message'],
        'date' => $notification['date']
    ]);
}
```
{% endcode %}

#### UML Диаграмма

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для паттерна "Легковесный объект"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
interface NotificationFlyweight {
    +render(extrinsicState: array)
}

class ConcreteNotificationFlyweight implements NotificationFlyweight {
    -type: string
    -priority: string
    +__construct(type: string, priority: string)
    +render(extrinsicState: array)
}

class NotificationFlyweightFactory {
    -flyweights: array
    +getFlyweight(type: string, priority: string): NotificationFlyweight
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
