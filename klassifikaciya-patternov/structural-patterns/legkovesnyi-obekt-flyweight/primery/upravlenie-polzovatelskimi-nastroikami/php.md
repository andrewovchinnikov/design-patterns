# PHP

Привет! Мы — команда разработчиков, работающая над веб-приложением для управления пользовательскими настройками. Наше приложение позволяет пользователям настраивать различные параметры, такие как темы оформления, язык интерфейса и уведомления. Мы хотим оптимизировать работу с пользовательскими настройками, чтобы наше приложение работало быстрее и эффективнее. Для этого мы решили использовать паттерн Легковесный объект (Flyweight).

#### Описание кейса

Паттерн Легковесный объект помогает нам экономить память и ресурсы, когда у нас много объектов с одинаковыми или похожими состояниями. В нашем случае, пользовательские настройки могут иметь одинаковые параметры, такие как тема оформления (светлая, темная) и язык интерфейса (русский, английский). Мы можем использовать легковесные объекты для представления этих параметров, чтобы не создавать новые объекты каждый раз, когда нам нужно создать новые настройки для пользователя.

#### Пример кода на PHP

**1. Определение интерфейса Flyweight**

{% code overflow="wrap" lineNumbers="true" %}
```php
interface UserSettingsFlyweight {
    public function render(array $extrinsicState);
}
```
{% endcode %}

**2. Реализация конкретного легковесного объекта**

{% code overflow="wrap" lineNumbers="true" %}
```php
class ConcreteUserSettingsFlyweight implements UserSettingsFlyweight {
    private $theme;
    private $language;

    public function __construct($theme, $language) {
        $this->theme = $theme;
        $this->language = $language;
    }

    public function render(array $extrinsicState) {
        // Внешнее состояние включает уникальные данные пользователя, такие как имя пользователя и дата настройки
        $username = $extrinsicState['username'];
        $date = $extrinsicState['date'];

        // Рендеринг настроек пользователя
        echo "Пользователь: $username<br>";
        echo "Тема: $this->theme<br>";
        echo "Язык: $this->language<br>";
        echo "Дата настройки: $date<br><br>";
    }
}
```
{% endcode %}

**3. Фабрика легковесных объектов**

{% code overflow="wrap" lineNumbers="true" %}
```php
class UserSettingsFlyweightFactory {
    private $flyweights = [];

    public function getFlyweight($theme, $language) {
        $key = $theme . '_' . $language;
        if (!isset($this->flyweights[$key])) {
            $this->flyweights[$key] = new ConcreteUserSettingsFlyweight($theme, $language);
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
$factory = new UserSettingsFlyweightFactory();

// Создаем пользовательские настройки с использованием легковесных объектов
$settings = [
    ['username' => 'Иван', 'theme' => 'Светлая', 'language' => 'Русский', 'date' => '2023-10-01'],
    ['username' => 'Мария', 'theme' => 'Темная', 'language' => 'Английский', 'date' => '2023-10-05'],
    ['username' => 'Алексей', 'theme' => 'Светлая', 'language' => 'Русский', 'date' => '2023-10-03']
];

foreach ($settings as $setting) {
    $flyweight = $factory->getFlyweight($setting['theme'], $setting['language']);
    $flyweight->render([
        'username' => $setting['username'],
        'date' => $setting['date']
    ]);
}
```
{% endcode %}

#### UML Диаграмма

<figure><img src="../../../../../.gitbook/assets/image (71).png" alt=""><figcaption><p>UML диаграмма для паттерна "Легковесный объект"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
interface UserSettingsFlyweight {
    +render(extrinsicState: array)
}

class ConcreteUserSettingsFlyweight implements UserSettingsFlyweight {
    -theme: string
    -language: string
    +__construct(theme: string, language: string)
    +render(extrinsicState: array)
}

class UserSettingsFlyweightFactory {
    -flyweights: array
    +getFlyweight(theme: string, language: string): UserSettingsFlyweight
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
