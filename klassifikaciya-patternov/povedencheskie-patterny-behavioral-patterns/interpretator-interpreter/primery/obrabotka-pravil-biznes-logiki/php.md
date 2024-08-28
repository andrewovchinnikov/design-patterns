# PHP

Представьте, что мы разрабатываем систему управления заказами для интернет-магазина. Наша система должна позволять администраторам задавать правила бизнес-логики для обработки заказов. Например, если сумма заказа превышает определенную величину, то применяется скидка, или если заказ содержит определенные товары, то применяется бесплатная доставка.

Для реализации этой функциональности мы будем использовать паттерн "Интерпретатор". Этот паттерн позволяет нам создать язык для описания правил бизнес-логики и интерпретатор для их выполнения.

### Пример кода на PHP

**Шаг 1: Создание контекста**

Контекст будет содержать информацию о текущем заказе и методы для получения этой информации.

{% code overflow="wrap" lineNumbers="true" %}
```php
class Context {
    private $order;

    public function __construct($order) {
        $this->order = $order;
    }

    public function getOrder() {
        return $this->order;
    }
}
```
{% endcode %}

**Шаг 2: Создание абстрактного выражения**

Абстрактное выражение будет содержать метод `interpret`, который будет реализован в конкретных выражениях.

{% code overflow="wrap" lineNumbers="true" %}
```php
abstract class AbstractExpression {
    abstract public function interpret(Context $context);
}
```
{% endcode %}

**Шаг 3: Создание конечных выражений**

Конечные выражения будут реализовывать метод `interpret` для конкретных условий.

{% code overflow="wrap" lineNumbers="true" %}
```php
class OrderAmountExpression extends AbstractExpression {
    private $amount;

    public function __construct($amount) {
        $this->amount = $amount;
    }

    public function interpret(Context $context) {
        $order = $context->getOrder();
        return $order['totalAmount'] > $this->amount;
    }
}

class OrderContainsProductExpression extends AbstractExpression {
    private $product;

    public function __construct($product) {
        $this->product = $product;
    }

    public function interpret(Context $context) {
        $order = $context->getOrder();
        return in_array($this->product, $order['products']);
    }
}
```
{% endcode %}

**Шаг 4: Создание неконечных выражений**

Неконечные выражения будут комбинировать другие выражения.

{% code overflow="wrap" lineNumbers="true" %}
```php
class AndExpression extends AbstractExpression {
    private $expr1;
    private $expr2;

    public function __construct(AbstractExpression $expr1, AbstractExpression $expr2) {
        $this->expr1 = $expr1;
        $this->expr2 = $expr2;
    }

    public function interpret(Context $context) {
        return $this->expr1->interpret($context) && $this->expr2->interpret($context);
    }
}

class OrExpression extends AbstractExpression {
    private $expr1;
    private $expr2;

    public function __construct(AbstractExpression $expr1, AbstractExpression $expr2) {
        $this->expr1 = $expr1;
        $this->expr2 = $expr2;
    }

    public function interpret(Context $context) {
        return $this->expr1->interpret($context) || $this->expr2->interpret($context);
    }
}
```
{% endcode %}

**Шаг 5: Использование интерпретатора**

Теперь мы можем использовать наш интерпретатор для выполнения правил бизнес-логики.

{% code lineNumbers="true" %}
```php
// Пример данных
$order = [
    'totalAmount' => 200,
    'products' => ['product1', 'product2']
];

$context = new Context($order);

// Создание правил
$amountExpr = new OrderAmountExpression(100);
$productExpr = new OrderContainsProductExpression('product1');
$andExpr = new AndExpression($amountExpr, $productExpr);

// Интерпретация правил
$result = $andExpr->interpret($context);

if ($result) {
    echo "Правила выполнены: применяется скидка или бесплатная доставка.";
} else {
    echo "Правила не выполнены.";
}
```
{% endcode %}

### UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для паттерна "Интерпретатор"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plantuml
@startuml

class Context {
    -order: array
    +__construct(order: array): void
    +getOrder(): array
}

abstract class AbstractExpression {
    +interpret(context: Context): bool
}

class OrderAmountExpression {
    -amount: float
    +__construct(amount: float): void
    +interpret(context: Context): bool
}

class OrderContainsProductExpression {
    -product: string
    +__construct(product: string): void
    +interpret(context: Context): bool
}

class AndExpression {
    -expr1: AbstractExpression
    -expr2: AbstractExpression
    +__construct(expr1: AbstractExpression, expr2: AbstractExpression): void
    +interpret(context: Context): bool
}

class OrExpression {
    -expr1: AbstractExpression
    -expr2: AbstractExpression
    +__construct(expr1: AbstractExpression, expr2: AbstractExpression): void
    +interpret(context: Context): bool
}

AbstractExpression <|-- OrderAmountExpression
AbstractExpression <|-- OrderContainsProductExpression
AbstractExpression <|-- AndExpression
AbstractExpression <|-- OrExpression

@enduml
```
{% endcode %}

### Вывод

В этом кейсе мы рассмотрели, как можно использовать паттерн "Интерпретатор" для создания системы, которая позволяет администраторам задавать правила бизнес-логики для обработки заказов. Мы создали контекст, абстрактное выражение, конечные выражения и неконечные выражения. Затем мы использовали эти компоненты для интерпретации и выполнения правил бизнес-логики.

Паттерн "Интерпретатор" позволяет гибко и удобно обрабатывать сложные правила, разделяя грамматику языка от его интерпретации. Это делает код более чистым и управляемым, особенно когда речь идет о сложных условиях и правилах.
