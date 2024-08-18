# Go

Представьте, что мы разрабатываем систему мониторинга для веб-приложения. Наша задача — собирать различные метрики, такие как время отклика, количество запросов и т.д. Мы хотим, чтобы наша система была гибкой и легко расширяемой, чтобы в будущем можно было добавлять новые метрики без изменения существующего кода.

Для этого мы будем использовать паттерн "Декоратор". Этот паттерн позволяет динамически добавлять новое поведение объектам, оборачивая их в объекты классов декораторов.

#### Пример кода на Go

**1. Базовый интерфейс**

{% code overflow="wrap" lineNumbers="true" %}
```go
package main

import "fmt"

type Metric interface {
    Collect() string
}
```
{% endcode %}

**2. Базовый класс метрики**

{% code overflow="wrap" lineNumbers="true" %}
```go
type BaseMetric struct{}

func (bm BaseMetric) Collect() string {
    // Базовая реализация сбора метрик
    return "Сбор базовых метрик"
}
```
{% endcode %}

**3. Базовый класс декоратора**

{% code overflow="wrap" lineNumbers="true" %}
```go
type MetricDecorator struct {
    metric Metric
}

func (md MetricDecorator) Collect() string {
    return md.metric.Collect()
}
```
{% endcode %}

**4. Декоратор для сбора времени отклика**

{% code overflow="wrap" lineNumbers="true" %}
```go
type ResponseTimeDecorator struct {
    MetricDecorator
}

func (rt ResponseTimeDecorator) Collect() string {
    // Логика сбора времени отклика
    result := rt.MetricDecorator.Collect()
    return result + " + Время отклика"
}
```
{% endcode %}

**5. Декоратор для сбора количества запросов**

{% code overflow="wrap" lineNumbers="true" %}
```go
type RequestCountDecorator struct {
    MetricDecorator
}

func (rc RequestCountDecorator) Collect() string {
    // Логика сбора количества запросов
    result := rc.MetricDecorator.Collect()
    return result + " + Количество запросов"
}
```
{% endcode %}

**6. Использование декораторов**

{% code overflow="wrap" lineNumbers="true" %}
```go
func main() {
    baseMetric := BaseMetric{}
    responseTimeMetric := ResponseTimeDecorator{MetricDecorator{metric: baseMetric}}
    requestCountMetric := RequestCountDecorator{MetricDecorator{metric: responseTimeMetric}}

    fmt.Println(requestCountMetric.Collect())
    // Вывод: Сбор базовых метрик + Время отклика + Количество запросов
}
```
{% endcode %}

#### UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для паттерна "Декоратор"</p></figcaption></figure>

```plantuml
@startuml
interface Metric {
    +Collect(): String
}

class BaseMetric {
    +Collect(): String
}

abstract class MetricDecorator {
    -metric: Metric
    +MetricDecorator(metric: Metric)
    +Collect(): String
}

class ResponseTimeDecorator {
    +Collect(): String
}

class RequestCountDecorator {
    +Collect(): String
}

Metric <|-- BaseMetric
Metric <|-- MetricDecorator
MetricDecorator <|-- ResponseTimeDecorator
MetricDecorator <|-- RequestCountDecorator
@enduml
```

#### Вывод

Использование паттерна "Декоратор" позволяет нам гибко и легко добавлять новые метрики в нашу систему мониторинга. Мы можем оборачивать базовые метрики в декораторы, которые добавляют дополнительное поведение, не изменяя существующий код. Это делает нашу систему более модульной и удобной для расширения в будущем.
