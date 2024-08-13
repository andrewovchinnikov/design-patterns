# Python

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (2) (1).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Прототип"</p></figcaption></figure>

В интернет-магазине имеется большое количество товаров, которые можно разделить на несколько категорий (одежда, обувь, техника и т.д.). Для каждой категории товаров имеется свои наборы свойств (для одежды это размер, цвет, материал; для техники это производитель, модель, год выпуска и т.д.). При добавлении нового товара в систему, необходимо создавать объект товара с определенными свойствами. В этом случае, можно использовать паттерн Прототип, который позволяет создавать новые объекты путем копирования существующих объектов-прототипов.

Паттерн Прототип полезен в ситуациях, когда создание объекта требует больших затрат ресурсов или сложных вычислений, либо когда объекты должны быть подобны друг другу. В нашем кейсе, паттерн Прототип позволяет нам создавать новые объекты товаров, копируя существующие объекты-прототипы для каждой категории товаров, и изменяя только те свойства, которые необходимо изменить для нового товара.

**Класс `Product`**

{% code overflow="wrap" lineNumbers="true" %}
```python
import copy

class Product:
    def __init__(self, name, price):
        self.name = name
        self.price = price

    def clone(self):
        return copy.deepcopy(self)
```
{% endcode %}

Базовый класс для всех товаров. Содержит общие свойства `name` и `price`.

Реализует метод `clone` для создания глубокой копии объекта.

**Классы `ClothesProduct` и `TechProduct`**

{% code overflow="wrap" lineNumbers="true" %}
```python
class ClothesProduct(Product):
    def __init__(self, name, price, size, color, material):
        super().__init__(name, price)
        self.size = size
        self.color = color
        self.material = material

class TechProduct(Product):
    def __init__(self, name, price, manufacturer, model, year):
        super().__init__(name, price)
        self.manufacturer = manufacturer
        self.model = model
        self.year = year
```
{% endcode %}

Конкретные классы для товаров категории "Одежда" и "Техника", наследующие от базового класса `Product`.

Дополнительно содержат свои уникальные свойства, такие как размер, цвет, материал для одежды и производитель, модель, год выпуска для техники.

**Класс `ProductFactory`**

{% code overflow="wrap" lineNumbers="true" %}
```python
class ProductFactory:
    def __init__(self):
        self.prototypes = {}

    def set_prototype(self, type_name, prototype):
        self.prototypes[type_name] = prototype

    def create_product(self, type_name, **kwargs):
        if type_name not in self.prototypes:
            raise ValueError(f"Unknown product type: {type_name}")

        prototype = self.prototypes[type_name]
        product = prototype.clone()

        for key, value in kwargs.items():
            setattr(product, key, value)

        return product
```
{% endcode %}

Класс-фабрика, используемый для создания новых объектов товаров.

Содержит словарь `prototypes`, где ключами являются имена типов товаров, а значениями - экземпляры прототипов.

Реализует методы `set_prototype` для добавления новых прототипов и `create_product` для создания новых объектов товаров на основе прототипов.

Теперь, когда у нас есть все классы, мы можем использовать `ProductFactory` для создания новых объектов товаров:

{% code overflow="wrap" lineNumbers="true" %}
```python
factory = ProductFactory()

# Добавление прототипов
factory.set_prototype("clothes", ClothesProduct("T-shirt", 29.99, "M", "Blue", "Cotton"))
factory.set_prototype("tech", TechProduct("Laptop", 999.99, "Apple", "MacBook Pro", 2020))

# Создание нового объекта товара
product = factory.create_product("clothes", name="Jeans", price=59.99, size="L", color="Blue", material="Denim")
print(product.__dict__)  # Выведет: {'name': 'Jeans', 'price': 59.99, 'size': 'L', 'color': 'Blue', 'material': 'Denim'}
```
{% endcode %}

В этом примере мы создаем фабрику, добавляем прототипы для одежды и техники, а затем используем фабрику для создания нового экземпляра товара одежды с заданными данными. Метод `create_product` принимает тип товара и произвольное количество именованных аргументов для изменения свойств товара.
