# PHP

Предположим, у нас есть компания, которая управляет запасами товаров в нескольких локациях: на складе и в магазине. Нам нужно разработать систему, которая позволяет управлять запасами независимо от типа локации. Это означает, что мы должны иметь возможность добавлять и удалять товары как на складе, так и в магазине, используя единый интерфейс.

#### Решение с использованием паттерна "Мост"

Паттерн "Мост" позволяет разделить абстракцию и реализацию, что делает их независимыми друг от друга. В нашем случае:

* **Абстракция** (`InventoryManagement`) определяет интерфейс для управления запасами.
* **Реализация** (`Inventory`) определяет интерфейс для конкретных реализаций управления запасами в разных локациях.

**Шаги реализации**

1. **Определение абстракции**:
   * Создаем абстрактный класс `InventoryManagement`, который содержит ссылку на объект типа `Inventory`.
   * Методы `addItem` и `removeItem` делегируют вызовы соответствующим методам реализации.

{% code overflow="wrap" lineNumbers="true" %}
```php
// Абстракция
abstract class InventoryManagement {
    protected $inventory;

    public function __construct(Inventory $inventory) {
        $this->inventory = $inventory;
    }

    public function setInventory(Inventory $inventory) {
        $this->inventory = $inventory;
    }

    abstract public function addItem($item, $quantity);
    abstract public function removeItem($item, $quantity);
}
```
{% endcode %}

1. **Определение реализации**:
   * Создаем интерфейс `Inventory` с методами `add` и `remove`.
   * Реализуем этот интерфейс в двух классах: `WarehouseInventory` и `StoreInventory`.

{% code overflow="wrap" lineNumbers="true" %}
```php
// Реализация
interface Inventory {
    public function add($item, $quantity);
    public function remove($item, $quantity);
}

// Конкретная реализация 1
class WarehouseInventory implements Inventory {
    public function add($item, $quantity) {
        echo "Adding $quantity of $item to the warehouse.\n";
    }

    public function remove($item, $quantity) {
        echo "Removing $quantity of $item from the warehouse.\n";
    }
}

// Конкретная реализация 2
class StoreInventory implements Inventory {
    public function add($item, $quantity) {
        echo "Adding $quantity of $item to the store.\n";
    }

    public function remove($item, $quantity) {
        echo "Removing $quantity of $item from the store.\n";
    }
}
```
{% endcode %}

1. **Конкретная абстракция**:
   * Создаем класс `InventoryManager`, который расширяет `InventoryManagement` и реализует методы `addItem` и `removeItem`.

{% code overflow="wrap" lineNumbers="true" %}
```php
// Конкретная абстракция
class InventoryManager extends InventoryManagement {
    public function addItem($item, $quantity) {
        $this->inventory->add($item, $quantity);
    }

    public function removeItem($item, $quantity) {
        $this->inventory->remove($item, $quantity);
    }
}
```
{% endcode %}

1. **Использование**:
   * Создаем объекты конкретных реализаций (`WarehouseInventory` и `StoreInventory`).
   * Создаем объект `InventoryManager` и связываем его с конкретной реализацией.
   * Используем методы `addItem` и `removeItem` для управления запасами.

```php
<?php
// Пример использования
$warehouseInventory = new WarehouseInventory();
$storeInventory = new StoreInventory();

$inventoryManager = new InventoryManager($warehouseInventory);
$inventoryManager->addItem("Laptop", 10);
$inventoryManager->removeItem("Laptop", 2);

$inventoryManager->setInventory($storeInventory);
$inventoryManager->addItem("Laptop", 5);
$inventoryManager->removeItem("Laptop", 1);
?>
```

<details>

<summary>Весь код</summary>

```php
<?php

// Абстракция
abstract class InventoryManagement {
    protected $inventory;

    public function __construct(Inventory $inventory) {
        $this->inventory = $inventory;
    }

    public function setInventory(Inventory $inventory) {
        $this->inventory = $inventory;
    }

    abstract public function addItem($item, $quantity);
    abstract public function removeItem($item, $quantity);
}

// Реализация
interface Inventory {
    public function add($item, $quantity);
    public function remove($item, $quantity);
}

// Конкретная реализация 1
class WarehouseInventory implements Inventory {
    public function add($item, $quantity) {
        echo "Adding $quantity of $item to the warehouse.\n";
    }

    public function remove($item, $quantity) {
        echo "Removing $quantity of $item from the warehouse.\n";
    }
}

// Конкретная реализация 2
class StoreInventory implements Inventory {
    public function add($item, $quantity) {
        echo "Adding $quantity of $item to the store.\n";
    }

    public function remove($item, $quantity) {
        echo "Removing $quantity of $item from the store.\n";
    }
}

// Конкретная абстракция
class InventoryManager extends InventoryManagement {
    public function addItem($item, $quantity) {
        $this->inventory->add($item, $quantity);
    }

    public function removeItem($item, $quantity) {
        $this->inventory->remove($item, $quantity);
    }
}

// Пример использования
$warehouseInventory = new WarehouseInventory();
$storeInventory = new StoreInventory();

$inventoryManager = new InventoryManager($warehouseInventory);
$inventoryManager->addItem("Laptop", 10);
$inventoryManager->removeItem("Laptop", 2);

$inventoryManager->setInventory($storeInventory);
$inventoryManager->addItem("Laptop", 5);
$inventoryManager->removeItem("Laptop", 1);
?>
```

</details>

#### UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для паттерна "Мост"</p></figcaption></figure>

```plant-uml
@startuml

abstract class InventoryManagement {
  - inventory: Inventory
  + setInventory(Inventory): void
  + addItem(item, quantity): void
  + removeItem(item, quantity): void
}

class InventoryManager extends InventoryManagement {
  + addItem(item, quantity): void
  + removeItem(item, quantity): void
}

interface Inventory {
  + add(item, quantity): void
  + remove(item, quantity): void
}

class WarehouseInventory implements Inventory {
  + add(item, quantity): void
  + remove(item, quantity): void
}

class StoreInventory implements Inventory {
  + add(item, quantity): void
  + remove(item, quantity): void
}

InventoryManagement --> Inventory : uses
InventoryManager --> Inventory : uses

@enduml
```

#### Вывод

Паттерн "Мост" позволяет нам управлять запасами независимо от типа локации, обеспечивая гибкость и расширяемость системы. Мы можем легко добавлять новые типы локаций или изменять существующие, не затрагивая основную логику управления запасами.
