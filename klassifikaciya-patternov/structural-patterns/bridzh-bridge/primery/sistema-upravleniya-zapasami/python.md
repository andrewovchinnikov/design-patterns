# Python

Предположим, у нас есть компания, которая управляет запасами товаров в нескольких локациях: на складе и в магазине. Нам нужно разработать систему, которая позволяет управлять запасами независимо от типа локации. Это означает, что мы должны иметь возможность добавлять и удалять товары как на складе, так и в магазине, используя единый интерфейс.

#### Решение с использованием паттерна "Мост"

Паттерн "Мост" позволяет разделить абстракцию и реализацию, что делает их независимыми друг от друга. В нашем случае:

* **Абстракция** (`InventoryManagement`) определяет интерфейс для управления запасами.
* **Реализация** (`Inventory`) определяет интерфейс для конкретных реализаций управления запасами в разных локациях.

#### Объяснение кода

1. **Абстракция (`InventoryManagement`)**:
   * Определяет общий интерфейс для управления запасами.
   * Содержит ссылку на объект реализации (`Inventory`).
   * Методы `set_inventory`, `add_item`, `remove_item` делегируют вызовы соответствующим методам реализации.

{% code overflow="wrap" lineNumbers="true" %}
```python
# Абстракция
class InventoryManagement:
    def __init__(self, inventory):
        self._inventory = inventory

    def set_inventory(self, inventory):
        self._inventory = inventory

    def add_item(self, item, quantity):
        self._inventory.add(item, quantity)

    def remove_item(self, item, quantity):
        self._inventory.remove(item, quantity)
```
{% endcode %}

1. **Реализация (`Inventory`)**:
   * Определяет интерфейс для конкретных реализаций.
   * Методы `add` и `remove` реализуются в конкретных классах.

{% code overflow="wrap" lineNumbers="true" %}
```python
# Реализация
class Inventory:
    def add(self, item, quantity):
        raise NotImplementedError

    def remove(self, item, quantity):
        raise NotImplementedError
```
{% endcode %}

1. **Конкретные реализации (`WarehouseInventory`, `StoreInventory`)**:
   * Реализуют интерфейс `Inventory`.
   * Определяют специфическую логику для склада и магазина.

{% code overflow="wrap" lineNumbers="true" %}
```python
# Конкретная реализация 1
class WarehouseInventory(Inventory):
    def add(self, item, quantity):
        print(f"Добавлен {quantity} {item} на склад.")

    def remove(self, item, quantity):
        print(f"Removing {quantity} {item} со склада.")

# Конкретная реализация 2
class StoreInventory(Inventory):
    def add(self, item, quantity):
        print(f"Добавлен {quantity} {item} в магазин.")

    def remove(self, item, quantity):
        print(f"Removing {quantity} {item} из магазина.")
```
{% endcode %}

1. **Пример использования**:
   * Создаются объекты конкретных реализаций (`WarehouseInventory`, `StoreInventory`).
   * Создается объект `InventoryManagement`, который изначально связан с `WarehouseInventory`.
   * Вызываются методы для добавления и удаления товаров.
   * Изменяется реализация на `StoreInventory` и повторно вызываются методы.

{% code overflow="wrap" lineNumbers="true" %}
```python
# Пример использования
warehouse_inventory = WarehouseInventory()
store_inventory = StoreInventory()

inventory_manager = InventoryManagement(warehouse_inventory)
inventory_manager.add_item("Laptop", 10)
inventory_manager.remove_item("Laptop", 2)

inventory_manager.set_inventory(store_inventory)
inventory_manager.add_item("Laptop", 5)
inventory_manager.remove_item("Laptop", 1)
```
{% endcode %}

UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (52).png" alt=""><figcaption><p>UML диаграмма для паттерна "Мост"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml

abstract class InventoryManagement {
  - inventory: Inventory
  + set_inventory(Inventory): void
  + add_item(item, quantity): void
  + remove_item(item, quantity): void
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

@enduml
```
{% endcode %}

#### Описание элементов диаграммы

1. **InventoryManagement**:
   * Абстрактный класс, определяющий интерфейс для управления запасами.
   * Содержит ссылку на объект типа `Inventory`.
   * Методы `set_inventory`, `add_item`, `remove_item`.
2. **Inventory**:
   * Интерфейс, определяющий методы для добавления и удаления товаров.
3. **WarehouseInventory**:
   * Конкретная реализация интерфейса `Inventory` для склада.
   * Реализует методы `add` и `remove`.
4. **StoreInventory**:
   * Конкретная реализация интерфейса `Inventory` для магазина.
   * Реализует методы `add` и `remove`.

#### Связи

* `InventoryManagement` содержит ссылку на `Inventory`.
* `WarehouseInventory` и `StoreInventory` реализуют интерфейс `Inventory`.

Эта диаграмма наглядно демонстрирует, как паттерн "Мост" разделяет абстракцию и реализацию, позволяя управлять запасами независимо от типа локации.
