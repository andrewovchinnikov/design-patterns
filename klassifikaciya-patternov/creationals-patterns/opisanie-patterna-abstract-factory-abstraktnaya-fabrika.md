# Абстрактная фабрика (Abstract Factory)

**Abstract Factory (Абстрактная фабрика)** - это порождающий паттерн проектирования, который предоставляет интерфейс для создания семейств взаимосвязанных или взаимозависимых объектов без спецификации их конкретных классов.

Это означает, что мы можем создавать объекты, не зная их точных классов, а только используя общий интерфейс. При этом объекты, которые мы создаем, могут быть связаны между собой или зависеть друг от друга, но при этом они будут соответствовать одному и тому же семейству или концепции.

## Паттерн Abstract Factory состоит из следующих компонентов:

* AbstractFactory - это абстрактный класс или интерфейс, который определяет общий интерфейс для создания объектов. Он содержит методы для создания объектов, которые соответствуют одному и тому же семейству или концепции.
* ConcreteFactory - это конкретный класс, который реализует интерфейс AbstractFactory. Он создает объекты, которые соответствуют конкретной реализации или варианту семейства или концепции.
* AbstractProduct - это абстрактный класс или интерфейс, который определяет общий интерфейс для объектов, которые создаются фабрикой. Он содержит методы, которые должны быть реализованы конкретными продуктами.
* ConcreteProduct - это конкретный класс, который реализует интерфейс AbstractProduct. Он содержит конкретную реализацию или вариант продукта, который соответствует конкретной реализации или варианту семейства или концепции

<figure><img src="../../.gitbook/assets/image.png" alt=""><figcaption></figcaption></figure>

{% tabs %}
{% tab title="Abstract class" %}
{% code title="abstract class Payment" overflow="wrap" lineNumbers="true" fullWidth="true" %}
```php
/**
 * Начнем с того, что определим абстрактный класс Payment, который будет содержать общие методы и свойства для всех видов оплаты.
 * В данном случае, у нас будет только один метод pay(), который будет выполнять оплату, и свойство $amount, которое будет хранить сумму оплаты.
 */
abstract class Payment
{
    protected $amount; // Сумма оплаты

    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    // Метод для выполнения оплаты
    abstract public function pay();
}
```
{% endcode %}
{% endtab %}

{% tab title="Class CardPayment" %}


{% code title="class CardPayment extends Payment" overflow="wrap" lineNumbers="true" fullWidth="true" %}
```php
/**
 * Затем мы определим конкретные классы для каждого вида оплаты, например, CardPayment для оплаты картой и YandexMoneyPayment для оплаты Яндекс.Деньгами.
 * Эти классы будут расширять абстрактный класс Payment и реализовывать метод pay() для выполнения конкретного вида оплаты.
 *
 * В конструкторе каждого из этих классов мы будем передавать сумму оплаты, а также дополнительные параметры, необходимые для выполнения конкретного вида оплаты.
 * Например, для оплаты картой нам понадобятся номер карты, имя владельца, срок действия и CVV-код, а для оплаты Яндекс.Деньгами нам понадобится только номер кошелька.
 */
class CardPayment extends Payment
{
    private $cardNumber; // Номер карты
    private $cardHolder; // Владелец карты
    private $expirationDate; // Срок действия карты
    private $cvv; // CVV-код карты

    public function __construct($amount, $cardNumber, $cardHolder, $expirationDate, $cvv)
    {
        parent::__construct($amount);
        $this->cardNumber = $cardNumber;
        $this->cardHolder = $cardHolder;
        $this->expirationDate = $expirationDate;
        $this->cvv = $cvv;
    }

    public function pay()
    {
        // Код для выполнения оплаты картой
        echo "Платеж картой на сумму {$this->amount} выполнен успешно.\n";
    }
}
```
{% endcode %}
{% endtab %}

{% tab title="Class YandexMoneyPayment" %}


{% code title="class YandexMoneyPayment extends Payment" overflow="wrap" lineNumbers="true" fullWidth="true" %}
```php
/**
 * Конкретный класс для оплаты Яндекс.Деньгами
 */
class YandexMoneyPayment extends Payment
{
    private $walletNumber; // Номер кошелька

    public function __construct($amount, $walletNumber)
    {
        parent::__construct($amount);
        $this->walletNumber = $walletNumber;
    }

    public function pay()
    {
        // Код для выполнения оплаты Яндекс.Деньгами
        echo "Платеж Яндекс.Деньгами на сумму {$this->amount} выполнен успешно.\n";
    }
}
```
{% endcode %}
{% endtab %}

{% tab title="Abstract class PaymentFactory" %}
{% code title="abstract class PaymentFactory" overflow="wrap" lineNumbers="true" fullWidth="true" %}
```php
/**
 * Затем мы определим абстрактный класс PaymentFactory, который будет содержать метод createPayment() для создания объекта оплаты.
 * Этот метод будет принимать в качестве параметров сумму оплаты и дополнительные параметры, необходимые для выполнения конкретного вида оплаты.
 */
abstract class PaymentFactory
{
    // Метод для создания объекта оплаты
    abstract public function createPayment(...$params);
}
```
{% endcode %}
{% endtab %}

{% tab title="Class YandexMoneyPaymentFactory" %}
{% code title="class YandexMoneyPaymentFactory extends PaymentFactory" overflow="wrap" lineNumbers="true" fullWidth="true" %}
```php
// Конкретный класс для фабрики оплаты Яндекс.Деньгами
class YandexMoneyPaymentFactory extends PaymentFactory
{
    public function createPayment(...$params)
    {
        // Создание объекта оплаты Яндекс.Деньгами
        return new YandexMoneyPayment(...$params);
    }
}
```
{% endcode %}
{% endtab %}

{% tab title="Class CardPaymentFactory" %}
{% code title="class CardPaymentFactory extends PaymentFactory" overflow="wrap" lineNumbers="true" fullWidth="true" %}
```php
/**
 * Затем мы определим конкретные классы для каждого вида оплаты, например, CardPaymentFactory для создания объекта оплаты картой и YandexMoneyPaymentFactory
 * для создания объекта оплаты Яндекс.Деньгами. Эти классы будут расширять абстрактный класс PaymentFactory и реализовывать метод createPayment()
 * для создания конкретного объекта оплаты.
 */
class CardPaymentFactory extends PaymentFactory
{
    public function createPayment(...$params)
    {
        // Создание объекта оплаты картой
        return new CardPayment(...$params);
    }
}
```
{% endcode %}
{% endtab %}

{% tab title="Использование" %}
{% code overflow="wrap" lineNumbers="true" fullWidth="true" %}
```php
/**
 * В примере использования мы создаем объект фабрики оплаты картой и выполняем оплату с помощью созданного объекта.
 * Затем мы создаем объект фабрики оплаты Яндекс.Деньгами и выполняем оплату аналогичным образом.
 */
$amount = 1000; // Сумма оплаты

// Создание фабрики оплаты картой
$factory = new CardPaymentFactory();
$payment = $factory->createPayment($amount, '1234 5678 9012 3456', 'Иван Иванов', '12/24', '123');
$payment->pay();

// Создание фабрики оплаты Яндекс.Деньгами
$factory = new YandexMoneyPaymentFactory();
$payment = $factory->createPayment($amount, '4100112333445566');
$payment->pay();
```
{% endcode %}
{% endtab %}
{% endtabs %}
