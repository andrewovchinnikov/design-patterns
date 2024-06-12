# Абстрактная фабрика (Abstract Factory)

**Abstract Factory (Абстрактная фабрика)** - это порождающий паттерн проектирования, который предоставляет интерфейс для создания семейств взаимосвязанных или взаимозависимых объектов без спецификации их конкретных классов.

Это означает, что мы можем создавать объекты, не зная их точных классов, а только используя общий интерфейс. При этом объекты, которые мы создаем, могут быть связаны между собой или зависеть друг от друга, но при этом они будут соответствовать одному и тому же семейству или концепции.

### Компоненты

* **AbstractFactory** - это абстрактный класс или интерфейс, который определяет общий интерфейс для создания объектов. Он содержит методы для создания объектов, которые соответствуют одному и тому же семейству или концепции.



* **ConcreteFactory** - это конкретный класс, который реализует интерфейс AbstractFactory. Он создает объекты, которые соответствуют конкретной реализации или варианту семейства или концепции.



* **AbstractProduct** - это абстрактный класс или интерфейс, который определяет общий интерфейс для объектов, которые создаются фабрикой. Он содержит методы, которые должны быть реализованы конкретными продуктами.



* **ConcreteProduct** - это конкретный класс, который реализует интерфейс AbstractProduct. Он содержит конкретную реализацию или вариант продукта, который соответствует конкретной реализации или варианту семейства или концепции

### **Функционирование**

1. Клиентский код создает экземпляр конкретной фабрики (`ConcreteFactory`), выбирая тем самым определенную конфигурацию или вариацию продуктов.
2. Клиентский код вызывает методы на экземпляре конкретной фабрики для создания конкретных продуктов (`ConcreteProduct`).
3. Конкретная фабрика создает экземпляры конкретных продуктов, соответствующих выбранной конфигурации или вариации, и возвращает их клиентскому коду.
4. Клиентский код работает с возвращенными продуктами через их абстрактные интерфейсы (`AbstractProduct`), не зная и не завися от конкретных классов продуктов.

### Подробнее

1. `AbstractFactory`: Интерфейс абстрактной фабрики, который предоставляет методы для создания абстрактных продуктов `ProductA` и `ProductB`. Конкретные фабрики реализуют этот интерфейс и создают конкретные продукты из соответствующего семейства.
2. `ConcreteFactory1`: Конкретная фабрика 1, которая реализует интерфейс `AbstractFactory`. Эта фабрика создает конкретные продукты `ConcreteProductA1` и `ConcreteProductB1` из первого семейства продуктов.
3. `ConcreteFactory2`: Конкретная фабрика 2, которая также реализует интерфейс `AbstractFactory`. Эта фабрика создает конкретные продукты `ConcreteProductA2` и `ConcreteProductB2` из второго семейства продуктов.
4. `AbstractProductA`: Интерфейс абстрактного продукта A, который определяет метод `usefulFunctionA()`, общий для всех конкретных продуктов A.
5. `ConcreteProductA1`: Конкретный продукт A1, который реализует интерфейс `AbstractProductA` и предоставляет свою реализацию метода `usefulFunctionA()`.
6. `ConcreteProductA2`: Конкретный продукт A2, который также реализует интерфейс `AbstractProductA` и предоставляет свою реализацию метода `usefulFunctionA()`.
7. `AbstractProductB`: Интерфейс абстрактного продукта B, который определяет методы `usefulFunctionB()` и `anotherUsefulFunctionB(AbstractProductA $collaborator)`. Метод `anotherUsefulFunctionB()` показывает, что продукт B может сотрудничать с продуктом A.
8. `ConcreteProductB1`: Конкретный продукт B1, который реализует интерфейс `AbstractProductB` и предоставляет свою реализацию методов `usefulFunctionB()` и `anotherUsefulFunctionB()`.
9. `ConcreteProductB2`: Конкретный продукт B2, который также реализует интерфейс `AbstractProductB` и предоставляет свою реализацию методов `usefulFunctionB()` и `anotherUsefulFunctionB()`.
10. Клиентский код: В этом примере клиентский код создает объекты конкретных фабрик, а затем использует методы этих фабрик для создания конкретных продуктов. Затем клиентский код вызывает методы конкретных продуктов для демонстрации их работы.

### UML диаграмма

<figure><img src="../../../.gitbook/assets/image (1) (1) (1) (1) (1) (1) (1) (1).png" alt=""><figcaption></figcaption></figure>

### Реализация

{% tabs %}
{% tab title="interface AbstractFactory" %}
{% code title="interface AbstractFactory" overflow="wrap" lineNumbers="true" fullWidth="true" %}
```php
// Интерфейс абстрактной фабрики
interface AbstractFactory
{
    public function createProductA();

    public function createProductB();
}
```
{% endcode %}
{% endtab %}

{% tab title="class ConcreteFactory1" %}


{% code title="class ConcreteFactory1" overflow="wrap" lineNumbers="true" fullWidth="true" %}
```php
// Конкретная фабрика 1
class ConcreteFactory1 implements AbstractFactory
{
    public function createProductA()
    {
        return new ConcreteProductA1();
    }

    public function createProductB()
    {
        return new ConcreteProductB1();
    }
}
```
{% endcode %}
{% endtab %}

{% tab title="class ConcreteFactory2" %}


{% code title="class YandexMoneyPayment extends Payment" overflow="wrap" lineNumbers="true" fullWidth="true" %}
```php
// Конкретная фабрика 2
class ConcreteFactory2 implements AbstractFactory
{
    public function createProductA()
    {
        return new ConcreteProductA2();
    }

    public function createProductB()
    {
        return new ConcreteProductB2();
    }
}
```
{% endcode %}
{% endtab %}

{% tab title="interface AbstractProductA" %}
{% code title="interface AbstractProductA" overflow="wrap" lineNumbers="true" fullWidth="true" %}
```php
/ Интерфейс абстрактного продукта A
interface AbstractProductA
{
    public function usefulFunctionA();
}
```
{% endcode %}
{% endtab %}

{% tab title="class ConcreteProductA1" %}
{% code title="class ConcreteProductA1" overflow="wrap" lineNumbers="true" fullWidth="true" %}
```php
// Конкретный продукт A1
class ConcreteProductA1 implements AbstractProductA
{
    public function usefulFunctionA()
    {
        echo "Продукт A1: Полезная функция A" . PHP_EOL;
    }
}
```
{% endcode %}
{% endtab %}

{% tab title="class ConcreteProductA2" %}
{% code title="class ConcreteProductA2" overflow="wrap" lineNumbers="true" fullWidth="true" %}
```php
// Конкретный продукт A2
class ConcreteProductA2 implements AbstractProductA
{
    public function usefulFunctionA()
    {
        echo "Продукт A2: Полезная функция A" . PHP_EOL;
    }
}
```
{% endcode %}
{% endtab %}

{% tab title="interface AbstractProductB" %}
{% code overflow="wrap" lineNumbers="true" fullWidth="true" %}
```php
// Интерфейс абстрактного продукта B
interface AbstractProductB
{
    public function usefulFunctionB();

    public function anotherUsefulFunctionB(AbstractProductA $collaborator);
}
```
{% endcode %}
{% endtab %}

{% tab title="class ConcreteProductB1" %}
{% code title="class ConcreteProductB1" overflow="wrap" lineNumbers="true" %}
```php
// Конкретный продукт B1
class ConcreteProductB1 implements AbstractProductB
{
    public function usefulFunctionB()
    {
        echo "Продукт B1: Полезная функция B" . PHP_EOL;
    }

    public function anotherUsefulFunctionB(AbstractProductA $collaborator)
    {
        echo "Продукт B1: Другая полезная функция B, с помощью продукта A: " . PHP_EOL;
        $collaborator->usefulFunctionA();
    }
}
```
{% endcode %}
{% endtab %}

{% tab title="class ConcreteProductB2" %}
{% code title="class ConcreteProductB2" overflow="wrap" lineNumbers="true" %}
```php
// Конкретный продукт B2
class ConcreteProductB2 implements AbstractProductB
{
    public function usefulFunctionB()
    {
        echo "Продукт B2: Полезная функция B" . PHP_EOL;
    }

    public function anotherUsefulFunctionB(AbstractProductA $collaborator)
    {
        echo "Продукт B2: Другая полезная функция B, с помощью продукта A: " . PHP_EOL;
        $collaborator->usefulFunctionA();
    }
}
```
{% endcode %}
{% endtab %}

{% tab title="Клиентский код" %}
{% code title="Клиентский код" overflow="wrap" lineNumbers="true" %}
```php
// Клиентский код
$factory1 = new ConcreteFactory1();
$productA1 = $factory1->createProductA();
$productB1 = $factory1->createProductB();

$productA1->usefulFunctionA();
$productB1->usefulFunctionB();
$productB1->anotherUsefulFunctionB($productA1);

echo PHP_EOL;

$factory2 = new ConcreteFactory2();
$productA2 = $factory2->createProductA();
$productB2 = $factory2->createProductB();

$productA2->usefulFunctionA();
$productB2->usefulFunctionB();
$productB2->anotherUsefulFunctionB($productA2);
```
{% endcode %}
{% endtab %}
{% endtabs %}
