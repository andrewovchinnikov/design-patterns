# Go

Предположим, у нас есть компания, которая управляет запасами товаров в нескольких локациях: на складе и в магазине. Нам нужно разработать систему, которая позволяет управлять запасами независимо от типа локации. Это означает, что мы должны иметь возможность добавлять и удалять товары как на складе, так и в магазине, используя единый интерфейс.

#### Решение с использованием паттерна "Мост"

Паттерн "Мост" позволяет разделить абстракцию и реализацию, что делает их независимыми друг от друга. В нашем случае:

* **Абстракция** (`InventoryManagement`) определяет интерфейс для управления запасами.
* **Реализация** (`Inventory`) определяет интерфейс для конкретных реализаций управления запасами в разных локациях.

#### Объяснение кода

1. **Интерфейс `Inventory`**:
   * Определяет методы `Add` и `Remove` для управления запасами.

{% code overflow="wrap" lineNumbers="true" %}
```go
// Inventory представляет интерфейс для управления запасами
type Inventory interface {
    Add(item string, quantity int)
    Remove(item string, quantity int)
}
```
{% endcode %}

2. **Реализация `WarehouseInventory`**:

* Реализует интерфейс `Inventory`.
* Метод `Add` добавляет товары на склад.
* Метод `Remove` удаляет товары со склада.

{% code overflow="wrap" lineNumbers="true" %}
```go
// WarehouseInventory представляет реализацию для склада
type WarehouseInventory struct{}

func (w *WarehouseInventory) Add(item string, quantity int) {
    fmt.Printf("Добавлен %d %s на склад.\n", quantity, item)
}

func (w *WarehouseInventory) Remove(item string, quantity int) {
    fmt.Printf("Удален %d %s со склада.\n", quantity, item)
}
```
{% endcode %}

2. **Реализация `StoreInventory`**:

* Реализует интерфейс `Inventory`.
* Метод `Add` добавляет товары в магазин.
* Метод `Remove` удаляет товары из магазина.

{% code overflow="wrap" lineNumbers="true" %}
```go
// StoreInventory представляет реализацию для магазина
type StoreInventory struct{}

func (s *StoreInventory) Add(item string, quantity int) {
    fmt.Printf("Добавлен %d %s на склад.\n", quantity, item)
}

func (s *StoreInventory) Remove(item string, quantity int) {
    fmt.Printf("Удален %d %s со склада.\n", quantity, item)
}
```
{% endcode %}

3. **Абстракция `InventoryManagement`**:

* Содержит ссылку на объект типа `Inventory`.
* Метод `SetInventory` позволяет изменить текущую реализацию `Inventory`.
* Методы `AddItem` и `RemoveItem` делегируют вызовы соответствующим методам реализации.

{% code overflow="wrap" lineNumbers="true" %}
```go
// InventoryManagement представляет абстракцию для управления запасами
type InventoryManagement struct {
    inventory Inventory
}

func (im *InventoryManagement) SetInventory(inventory Inventory) {
    im.inventory = inventory
}

func (im *InventoryManagement) AddItem(item string, quantity int) {
    im.inventory.Add(item, quantity)
}

func (im *InventoryManagement) RemoveItem(item string, quantity int) {
    im.inventory.Remove(item, quantity)
}
```
{% endcode %}

1. **Функция `main`**:
   * Создает объекты `WarehouseInventory` и `StoreInventory`.
   * Создает объект `InventoryManagement` и устанавливает начальную реализацию `WarehouseInventory`.
   * Вызывает методы `AddItem` и `RemoveItem` для управления запасами на складе.
   * Изменяет реализацию на `StoreInventory` и повторно вызывает методы для управления запасами в магазине.

{% code overflow="wrap" lineNumbers="true" %}
```go
func main() {
    warehouseInventory := &WarehouseInventory{}
    storeInventory := &StoreInventory{}

    inventoryManager := &InventoryManagement{}
    inventoryManager.SetInventory(warehouseInventory)
    inventoryManager.AddItem("Laptop", 10)
    inventoryManager.RemoveItem("Laptop", 2)

    inventoryManager.SetInventory(storeInventory)
    inventoryManager.AddItem("Laptop", 5)
    inventoryManager.RemoveItem("Laptop", 1)
}
```
{% endcode %}



<details>

<summary>Весь код</summary>

```go
package main

import "fmt"

// Inventory представляет интерфейс для управления запасами
type Inventory interface {
    Add(item string, quantity int)
    Remove(item string, quantity int)
}

// WarehouseInventory представляет реализацию для склада
type WarehouseInventory struct{}

func (w *WarehouseInventory) Add(item string, quantity int) {
    fmt.Printf("Добавлен %d %s на склад.\n", quantity, item)
}

func (w *WarehouseInventory) Remove(item string, quantity int) {
    fmt.Printf("Удален %d %s со склада.\n", quantity, item)
}

// StoreInventory представляет реализацию для магазина
type StoreInventory struct{}

func (s *StoreInventory) Add(item string, quantity int) {
    fmt.Printf("Добавлен %d %s на склад.\n", quantity, item)
}

func (s *StoreInventory) Remove(item string, quantity int) {
    fmt.Printf("Удален %d %s со склада.\n", quantity, item)
}

// InventoryManagement представляет абстракцию для управления запасами
type InventoryManagement struct {
    inventory Inventory
}

func (im *InventoryManagement) SetInventory(inventory Inventory) {
    im.inventory = inventory
}

func (im *InventoryManagement) AddItem(item string, quantity int) {
    im.inventory.Add(item, quantity)
}

func (im *InventoryManagement) RemoveItem(item string, quantity int) {
    im.inventory.Remove(item, quantity)
}

func main() {
    warehouseInventory := &WarehouseInventory{}
    storeInventory := &StoreInventory{}

    inventoryManager := &InventoryManagement{}
    inventoryManager.SetInventory(warehouseInventory)
    inventoryManager.AddItem("Laptop", 10)
    inventoryManager.RemoveItem("Laptop", 2)

    inventoryManager.SetInventory(storeInventory)
    inventoryManager.AddItem("Laptop", 5)
    inventoryManager.RemoveItem("Laptop", 1)
}
```

</details>

UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (51).png" alt=""><figcaption><p>UML диаграмма для паттерна "Мост"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml

interface Inventory {
  + Add(item, quantity): void
  + Remove(item, quantity): void
}

class WarehouseInventory implements Inventory {
  + Add(item, quantity): void
  + Remove(item, quantity): void
}

class StoreInventory implements Inventory {
  + Add(item, quantity): void
  + Remove(item, quantity): void
}

class InventoryManagement {
  - inventory: Inventory
  + SetInventory(inventory): void
  + AddItem(item, quantity): void
  + RemoveItem(item, quantity): void
}

InventoryManagement --> Inventory : uses

@enduml
```
{% endcode %}

#### Вывод

Паттерн "Мост" позволяет нам управлять запасами независимо от типа локации, обеспечивая гибкость и расширяемость системы. Мы можем легко добавлять новые типы локаций или изменять существующие, не затрагивая основную логику управления запасами.
