# Go

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (2) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Прототип"</p></figcaption></figure>

В интернет-магазине имеется большое количество товаров, которые можно разделить на несколько категорий (одежда, обувь, техника и т.д.). Для каждой категории товаров имеется свои наборы свойств (для одежды это размер, цвет, материал; для техники это производитель, модель, год выпуска и т.д.). При добавлении нового товара в систему, необходимо создавать объект товара с определенными свойствами. В этом случае, можно использовать паттерн Прототип, который позволяет создавать новые объекты путем копирования существующих объектов-прототипов.

Паттерн Прототип полезен в ситуациях, когда создание объекта требует больших затрат ресурсов или сложных вычислений, либо когда объекты должны быть подобны друг другу. В нашем кейсе, паттерн Прототип позволяет нам создавать новые объекты товаров, копируя существующие объекты-прототипы для каждой категории товаров, и изменяя только те свойства, которые необходимо изменить для нового товара.

1. **Интерфейс `Prototype`**

{% code overflow="wrap" lineNumbers="true" %}
```go
type Prototype interface {
	Clone() Prototype
}
```
{% endcode %}

Это интерфейс, который должен быть реализован всеми классами, которые могут быть прототипами. Он содержит единственный метод `Clone()`, который должен возвращать новый экземпляр объекта.

2. **Базовый класс `Product`**

{% code overflow="wrap" lineNumbers="true" %}
```go
type Product struct {
	Name  string
	Price float64
}

func (p *Product) Clone() Prototype {
	return &Product{
		Name:  p.Name,
		Price: p.Price,
	}
}
```
{% endcode %}

Это базовый класс для всех товаров. Он реализует интерфейс `Prototype` и содержит общие свойства `Name` и `Price`. Метод `Clone()` создает новый экземпляр `Product` с теми же значениями полей.

3. **Конкретный класс `ClothesProduct`**

{% code overflow="wrap" lineNumbers="true" %}
```go
type ClothesProduct struct {
	Product
	Size    string
	Color   string
	Material string
}

func (cp *ClothesProduct) Clone() Prototype {
	return &ClothesProduct{
		Product: Product{
			Name:  cp.Name,
			Price: cp.Price,
		},
		Size:    cp.Size,
		Color:   cp.Color,
		Material: cp.Material,
	}
}
```
{% endcode %}

Это конкретный класс для товаров категории "Одежда". Он также реализует интерфейс `Prototype` и содержит дополнительные свойства `Size`, `Color` и `Material`. Метод `Clone()` создает новый экземпляр `ClothesProduct` с теми же значениями полей.

4. **Конкретный класс `TechProduct`**

{% code overflow="wrap" lineNumbers="true" %}
```go
type TechProduct struct {
	Product
	Manufacturer string
	Model        string
	Year         int
}

func (tp *TechProduct) Clone() Prototype {
	return &TechProduct{
		Product: Product{
			Name:  tp.Name,
			Price: tp.Price,
		},
		Manufacturer: tp.Manufacturer,
		Model:        tp.Model,
		Year:         tp.Year,
	}
}
```
{% endcode %}

Это конкретный класс для товаров категории "Техника". Он также реализует интерфейс `Prototype` и содержит дополнительные свойства `Manufacturer`, `Model` и `Year`. Метод `Clone()` создает новый экземпляр `TechProduct` с теми же значениями полей.

5. **Класс-фабрика `ProductFactory`**

{% code overflow="wrap" lineNumbers="true" %}
```go
type ProductFactory struct {
	prototypes map[string]Prototype
}

func (pf *ProductFactory) SetPrototype(typeName string, prototype Prototype) {
	if pf.prototypes == nil {
		pf.prototypes = make(map[string]Prototype)
	}
	pf.prototypes[typeName] = prototype
}

func (pf *ProductFactory) CreateProduct(typeName string, data map[string]interface{}) (Prototype, error) {
	prototype, ok := pf.prototypes[typeName]
	if !ok {
		return nil, fmt.Errorf("unknown product type")
	}

	product := prototype.Clone()

	// Заполнение свойств товара данными
	for key, value := range data {
		switch key {
		case "Name":
			product.(*Product).Name = value.(string)
		case "Price":
			product.(*Product).Price = value.(float64)
		case "Size":
			product.(*ClothesProduct).Size = value.(string)
		case "Color":
			product.(*ClothesProduct).Color = value.(string)
		case "Material":
			product.(*ClothesProduct).Material = value.(string)
		case "Manufacturer":
			product.(*TechProduct).Manufacturer = value.(string)
		case "Model":
			product.(*TechProduct).Model = value.(string)
		case "Year":
			product.(*TechProduct).Year = value.(int)
		}
	}

	return product, nil
}
```
{% endcode %}

Это класс-фабрика, который используется для создания новых объектов Товаров. Он содержит словарь `prototypes`, где ключами являются имена типов товаров, а значениями - экземпляры прототипов. Метод `SetPrototype()` позволяет добавлять новые прототипы, а метод `CreateProduct()` создает новый экземпляр товара на основе прототипа и заполняет его данными из переданного словаря `data`.
