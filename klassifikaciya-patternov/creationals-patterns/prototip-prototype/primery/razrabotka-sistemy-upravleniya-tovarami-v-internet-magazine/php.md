# PHP

<figure><img src="../../../../../.gitbook/assets/image (25).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Прототип"</p></figcaption></figure>

В интернет-магазине имеется большое количество товаров, которые можно разделить на несколько категорий (одежда, обувь, техника и т.д.). Для каждой категории товаров имеется свои наборы свойств (для одежды это размер, цвет, материал; для техники это производитель, модель, год выпуска и т.д.). При добавлении нового товара в систему, необходимо создавать объект товара с определенными свойствами. В этом случае, можно использовать паттерн Прототип, который позволяет создавать новые объекты путем копирования существующих объектов-прототипов.

Паттерн Прототип полезен в ситуациях, когда создание объекта требует больших затрат ресурсов или сложных вычислений, либо когда объекты должны быть подобны друг другу. В нашем кейсе, паттерн Прототип позволяет нам создавать новые объекты товаров, копируя существующие объекты-прототипы для каждой категории товаров, и изменяя только те свойства, которые необходимо изменить для нового товара.

1. Интерфейс Прототип (Prototype)

```php
interface Prototype
    public function clone();
}

```

Интерфейс Прототип определяет метод clone(), который используется для создания копии объекта-прототипа. Этот интерфейс обеспечивает единообразный способ создания копий объектов для всех классов, реализующих его.

2. Базовый класс Товара (Product)

Базовый класс Товара реализует интерфейс Прототип и содержит общие свойства (name, price) для всех товаров. Метод clone() реализуется с помощью ключевого слова clone.

{% code overflow="wrap" lineNumbers="true" %}
```php
abstract class Product implements Prototype
{
    protected $name;
    protected $price;

    public function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function clone()
    {
        return clone $this;
    }
}

```
{% endcode %}

3. Конкретный класс Товара для категории Одежда (ClothesProduct)

{% code overflow="wrap" lineNumbers="true" %}
```php
class ClothesProduct extends Product
{
    protected $size;
    protected $color;
    protected $material;

    public function __construct($name, $price, $size, $color, $material)
    {
        parent::__construct($name, $price);
        $this->size = $size;
        $this->color = $color;
        $this->material = $material;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function getMaterial()
    {
        return $this->material;
    }

    public function clone()
    {
        $clone = parent::clone();
        $clone->size = $this->size;
        $clone->color = $this->color;
        $clone->material = $this->material;
        return $clone;
    }
}

```
{% endcode %}

Конкретный класс Товара для категории Одежда наследуется от класса Product и содержит свои наборы свойств (size, color, material). Метод clone() должен быть переопределен в каждом конкретном классе Товара, чтобы обеспечить глубокое копирование объекта.

4. Конкретный класс Товара для категории Техника (TechProduct)

Конкретный класс Товара для категории Техника наследуется от класса Product и содержит свои наборы свойств (manufacturer, model, year). Метод clone() должен быть переопределен в каждом конкретном классе Товара, чтобы обеспечить глубокое копирование объекта.

{% code overflow="wrap" lineNumbers="true" %}
```php
class TechProduct extends Product
{
    protected $manufacturer;
    protected $model;
    protected $year;

    public function __construct($name, $price, $manufacturer, $model, $year)
    {
        parent::__construct($name, $price);
        $this->manufacturer = $manufacturer;
        $this->model = $model;
        $this->year = $year;
    }

    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function clone()
    {
        $clone = parent::clone();
        $clone->manufacturer = $this->manufacturer;
        $clone->model = $this->model;
        $clone->year = $this->year;
        return $clone;
    }
}

```
{% endcode %}

5. Класс-фабрика для создания объектов Товаров (ProductFactory)

Класс-фабрика для создания объектов Товаров содержит массив прототипов (prototypes) и предоставляет методы для добавления новых прототипов (setPrototype) и создания новых объектов Товаров (createProduct). Метод createProduct создает копию объекта-прототипа из массива prototypes и заполняет ее данными из массива data.

{% code overflow="wrap" lineNumbers="true" %}
```php
class ProductFactory
{
    private $prototypes = [];

    public function setPrototype(string $type, Prototype $prototype)
    {
        $this->prototypes[$type] = $prototype;
    }

    public function createProduct(string $type, array $data)
    {
        if (!isset($this->prototypes[$type])) {
            throw new Exception('Unknown product type');
        }

        $prototype = $this->prototypes[$type];
        $product = $prototype->clone();

        foreach ($data as $key => $value) {
            $product->{$key} = $value;
        }

        return $product;
    }
}

```
{% endcode %}

В этом кейсе, класс ProductFactory используется для создания новых объектов Товаров путем копирования существующих объектов-прототипов для каждой категории товаров и изменения только тех свойств, которые необходимо изменить для нового товара. Это позволяет нам избежать сложных вычислений и больших затрат ресурсов при создании новых объектов, а также обеспечивает подобие объектов внутри каждой категории товаров.
