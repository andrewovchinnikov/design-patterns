# PHP

Мы — команда разработчиков, работающая над системой управления проектами. Наша задача — сделать так, чтобы пользователи могли легко отслеживать статус своих задач и получать уведомления о любых изменениях. В этом кейсе мы рассмотрим, как можно использовать паттерн "Наблюдатель" для реализации системы уведомлений о статусе задач.

### Описание кейса

Наша система управления проектами позволяет пользователям создавать задачи и отслеживать их статус. Когда статус задачи изменяется (например, с "В процессе" на "Завершено"), все заинтересованные пользователи должны получать уведомления. Для этого мы будем использовать паттерн "Наблюдатель", который позволяет объектам (наблюдателям) подписываться на события, происходящие в другом объекте (субъекте), и получать уведомления об этих событиях.

### Применение паттерна

Паттерн "Наблюдатель" идеально подходит для нашей задачи, так как он позволяет легко добавлять и удалять наблюдателей (пользователей), которые будут получать уведомления о изменении статуса задач. Это упрощает управление уведомлениями и делает систему более гибкой.

### UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (106).png" alt=""><figcaption><p>UML диаграмма для паттерна "Наблюдатель"</p></figcaption></figure>

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

### Пример кода на PHP

**Интерфейс Observer**

```php
<?php

interface Observer {
    public function update(Subject $subject);
}
```

**Класс Subject**

{% code overflow="wrap" lineNumbers="true" %}
```php
<?php

class Subject {
    private $observers = [];

    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer) {
        $this->observers = array_filter($this->observers, function ($obs) use ($observer) {
            return $obs !== $observer;
        });
    }

    public function notify() {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}
```
{% endcode %}

**Класс Task (наследует Subject)**

{% code overflow="wrap" lineNumbers="true" %}
```php
<?php

class Task extends Subject {
    private $status;

    public function setStatus($status) {
        $this->status = $status;
        $this->notify();
    }

    public function getStatus() {
        return $this->status;
    }
}
```
{% endcode %}

**Класс User (реализует Observer)**

{% code overflow="wrap" lineNumbers="true" %}
```php
<?php

class User implements Observer {
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function update(Subject $subject) {
        if ($subject instanceof Task) {
            echo "Уведомление для {$this->name}: Статус задачи изменен на {$subject->getStatus()}\n";
        }
    }
}
```
{% endcode %}

#### Пример использования

{% code overflow="wrap" lineNumbers="true" %}
```php
<?php

// Создаем задачу
$task = new Task();

// Создаем пользователей
$user1 = new User("Иван");
$user2 = new User("Мария");

// Подписываем пользователей на уведомления о статусе задачи
$task->attach($user1);
$task->attach($user2);

// Изменяем статус задачи
$task->setStatus("В процессе");
$task->setStatus("Завершено");
```
{% endcode %}

### Вывод для кейса

В этом кейсе мы рассмотрели, как можно использовать паттерн "Наблюдатель" для реализации системы уведомлений о статусе задач. Мы создали интерфейс `Observer`, класс `Subject`, который управляет списком наблюдателей, и классы `Task` и `User`, которые реализуют логику задачи и пользователя соответственно.

Паттерн "Наблюдатель" позволяет легко добавлять и удалять наблюдателей, что делает систему гибкой и удобной для расширения. В результате, пользователи получают уведомления о любых изменениях статуса задач, что улучшает их взаимодействие с системой управления проектами.
