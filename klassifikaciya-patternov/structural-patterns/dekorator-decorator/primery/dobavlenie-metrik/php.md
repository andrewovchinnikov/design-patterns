# PHP

Представьте, что мы разрабатываем систему мониторинга для веб-приложения. Наша задача — собирать различные метрики, такие как время отклика, количество запросов и т.д. Мы хотим, чтобы наша система была гибкой и легко расширяемой, чтобы в будущем можно было добавлять новые метрики без изменения существующего кода.

Для этого мы будем использовать паттерн "Декоратор". Этот паттерн позволяет динамически добавлять новое поведение объектам, оборачивая их в объекты классов декораторов.

#### Пример кода на PHP

**1. Базовый интерфейс**

{% code overflow="wrap" lineNumbers="true" %}
```php
<?php
interface Metric {
    public function collect();
}
```
{% endcode %}

**2. Базовый класс метрики**

{% code overflow="wrap" lineNumbers="true" %}
```php
<?php
class BaseMetric implements Metric {
    public function collect() {
        // Базовая реализация сбора метрик
        return "Сбор базовых метрик";
    }
}
```
{% endcode %}

**3. Базовый класс декоратора**

{% code overflow="wrap" lineNumbers="true" %}
```php
<?php
abstract class MetricDecorator implements Metric {
    protected $metric;

    public function __construct(Metric $metric) {
        $this->metric = $metric;
    }

    public function collect() {
        return $this->metric->collect();
    }
}
```
{% endcode %}

**4. Декоратор для сбора времени отклика**

{% code overflow="wrap" lineNumbers="true" %}
```php
<?php
class ResponseTimeDecorator extends MetricDecorator {
    public function collect() {
        // Логика сбора времени отклика
        $result = $this->metric->collect();
        return $result . " + Время отклика";
    }
}
```
{% endcode %}

**5. Декоратор для сбора количества запросов**

{% code overflow="wrap" lineNumbers="true" %}
```php
<?php
class RequestCountDecorator extends MetricDecorator {
    public function collect() {
        // Логика сбора количества запросов
        $result = $this->metric->collect();
        return $result . " + Количество запросов";
    }
}
```
{% endcode %}

**6. Использование декораторов**

{% code overflow="wrap" lineNumbers="true" %}
```php
<?php
$baseMetric = new BaseMetric();
$responseTimeMetric = new ResponseTimeDecorator($baseMetric);
$requestCountMetric = new RequestCountDecorator($responseTimeMetric);

echo $requestCountMetric->collect();
// Вывод: Сбор базовых метрик + Время отклика + Количество запросов
```
{% endcode %}

#### UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (2) (1).png" alt=""><figcaption><p>UML диаграмма для паттерна "Декоратор"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plantuml
@startuml
interface Metric {
    +collect(): String
}

class BaseMetric {
    +collect(): String
}

abstract class MetricDecorator {
    -metric: Metric
    +MetricDecorator(metric: Metric)
    +collect(): String
}

class ResponseTimeDecorator {
    +collect(): String
}

class RequestCountDecorator {
    +collect(): String
}

Metric <|-- BaseMetric
Metric <|-- MetricDecorator
MetricDecorator <|-- ResponseTimeDecorator
MetricDecorator <|-- RequestCountDecorator
@enduml
```
{% endcode %}

#### Вывод

Использование паттерна "Декоратор" позволяет нам гибко и легко добавлять новые метрики в нашу систему мониторинга. Мы можем оборачивать базовые метрики в декораторы, которые добавляют дополнительное поведение, не изменяя существующий код. Это делает нашу систему более модульной и удобной для расширения в будущем.
