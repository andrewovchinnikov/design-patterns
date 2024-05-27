<?php

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

/**
 * Затем мы определим абстрактный класс PaymentFactory, который будет содержать метод createPayment() для создания объекта оплаты.
 * Этот метод будет принимать в качестве параметров сумму оплаты и дополнительные параметры, необходимые для выполнения конкретного вида оплаты.
 */
abstract class PaymentFactory
{
    // Метод для создания объекта оплаты
    abstract public function createPayment(...$params);
}

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

// Конкретный класс для фабрики оплаты Яндекс.Деньгами
class YandexMoneyPaymentFactory extends PaymentFactory
{
    public function createPayment(...$params)
    {
        // Создание объекта оплаты Яндекс.Деньгами
        return new YandexMoneyPayment(...$params);
    }
}

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


/**
 * В этом примере мы имеем абстрактный класс Payment, который содержит общий метод pay() для выполнения оплаты.
 * Затем мы создаем два конкретных класса для оплаты картой и Яндекс.Деньгами, которые реализуют этот метод.
 *
 * Далее мы создаем абстрактный класс PaymentFactory, который содержит метод createPayment() для создания объекта оплаты.
 * Затем мы создаем два конкретных класса для фабрики оплаты картой и Яндекс.Деньгами, которые реализуют этот метод.
 *
 * В примере использования мы создаем фабрику оплаты картой и выполняем оплату с помощью созданного объекта.
 * Затем мы создаем фабрику оплаты Яндекс.Деньгами и выполняем оплату аналогичным образом.
 *
 * Этот пример показывает, как паттерн Abstract Factory (Абстрактная фабрика) может быть использован для создания семейств взаимосвязанных или взаимозависимых
 * объектов (в данном случае, объектов оплаты) без спецификации их конкретных классов.
 */