# PHP

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (2) (1) (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Строитель"</p></figcaption></figure>

Тимлид сформировал задачу на разработку нового модуля для существующей ERP системы, который будет отвечать за формирование и обработку договоров с поставщиками. Разработчик, взявшийся за эту задачу, столкнулся с тем, что объект "Договор" имеет сложную структуру и содержит множество различных данных, таких как информация о стоимости, сроках выполнения, обязанностях сторон и т.д. Кроме того, договор может быть связан с другими объектами бизнес-логики, такими как заказы, счета и т.д.

Разработчик решил использовать паттерн "Строитель" для создания объектов "Договор". Этот паттерн позволяет создавать сложные объекты с помощью последовательного вызова методов, добавляющих необходимые данные и устанавливающих связи с другими объектами. При этом сам процесс создания объекта вынесен в отдельный класс "Builder", что позволяет избежать избыточной сложности кода и улучшить его гибкость и расширяемость.

Ниже приведен пример кода, реализующего паттерн "Строитель" для создания объектов "Договор":

Класс "Договор"

{% code overflow="wrap" lineNumbers="true" %}
```php
class Contract {
    private $cost;
    private $deadline;
    private $obligations;
    private $order;
    private $invoice;

    public function __construct() {
        $this->obligations = array();
    }

    public function getCost() {
        return $this->cost;
    }

    public function getDeadline() {
        return $this->deadline;
    }

    public function getObligations() {
        return $this->obligations;
    }

    public function getOrder() {
        return $this->order;
    }

    public function getInvoice() {
        return $this->invoice;
    }
}
```
{% endcode %}

Класс "Договор" (Contract): Этот класс представляет объект "Договор" в бизнес-логике. Он содержит приватные свойства $cost, $deadline, $obligations, $order и $invoice, которые соответствуют стоимости контракта, сроку его выполнения, обязанностям сторон, связанному заказу и связанному счету соответственно. В конструкторе класса инициализируется свойство $obligations как пустой массив. Кроме того, класс содержит публичные методы-геттеры для доступа к значениям своих свойств.&#x20;

Класс "Builder" для создания объектов "Договор"

{% code overflow="wrap" lineNumbers="true" %}
```php
class ContractBuilder {
    private $contract;

    public function __construct() {
        $this->contract = new Contract();
    }

    public function setCost($cost) {
        $this->contract->cost = $cost;
        return $this;
    }

    public function setDeadline($deadline) {
        $this->contract->deadline = $deadline;
        return $this;
    }

    public function addObligation($obligation) {
        $this->contract->obligations[] = $obligation;
        return $this;
    }

    public function setOrder($order) {
        $this->contract->order = $order;
        return $this;
    }

    public function setInvoice($invoice) {
        $this->contract->invoice = $invoice;
        return $this;
    }

    public function build() {
        $result = $this->contract;
        $this->contract = new Contract();  
        return $result;
    }
}
```
{% endcode %}

Этот класс реализует паттерн "Строитель" для создания объектов "Договор". Он содержит приватное свойство $contract, которое хранит текущий экземпляр класса Contract, который строится. В конструкторе класса инициализируется свойство $contract как новый экземпляр класса Contract. Кроме того, класс содержит цепочку публичных методов-сеттеров для настройки свойств экземпляра класса Contract, которые возвращают текущий экземпляр класса ContractBuilder для дальнейшей цепочки вызовов. Метод build() создает и возвращает готовый экземпляр класса Contract, а также сбрасывает значение свойства $contract для создания нового экземпляра класса Contract при следующем вызове.

Пример использования

{% code overflow="wrap" lineNumbers="true" %}
```php
$order = new Order();  // Создаем объект "Заказ"
$invoice = new Invoice();  // Создаем объект "Счет"

$contract = (new ContractBuilder())
    ->setCost(1000.0)
    ->setDeadline(new DateTime('+30 days'))->format('Y-m-d'))
    ->addObligation("Поставка товара в срок")
    ->addObligation("Соответствие товара требованиям заказа")
    ->setOrder($order)
    ->setInvoice($invoice)
    ->build();

echo "Стоимость контракта: " . $contract->getCost() . PHP_EOL;
echo "Дедлайн контракта: " . $contract->getDeadline() . PHP_EOL;
echo "Обязанности сторон: " . implode(", ", $contract->getObligations()) . PHP_EOL;
echo "Связанный заказ: " . $contract->getOrder() . PHP_EOL;
echo "Связанный счет: " . $contract->getInvoice() . PHP_EOL;
```
{% endcode %}

В примере использования создаются новые объекты "Заказ" (Order) и "Счет" (Invoice), которые будут связаны с создаваемым объектом "Договор". Затем создается новый экземпляр класса ContractBuilder и вызывается цепочка методов-сеттеров для настройки свойств создаваемого объекта "Договор", таких как стоимость, срок выполнения, обязанности сторон, связанный заказ и связанный счет. Метод build() вызывается в конце цепочки для создания и возврата готового объекта "Договор". Затем выводятся значения свойств созданного объекта "Договор" с помощью методов-геттеров.
