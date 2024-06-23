# Go

Веб-приложение должно предоставлять пользователям возможность загружать и редактировать изображения. Для оптимизации работы приложения и снижения нагрузки на память, используется паттерн "Пулл объектов" для повторного использования экземпляров класса для работы с изображениями. Паттерн "Пулл объектов" позволяет уменьшить нагрузку на систему, переиспользуя объекты, вместо создания новых каждый раз. В данном случае, пулл используется для объектов класса `Image`, которые используются для работы с изображениями. Приложение может брать объект из пула, выполнять операции с изображением, и возвращать объект обратно в пулл, вместо создания нового объекта каждый раз.

**Структуры и функции на Go:**

1. **Структура `Image`**:
   * Представляет собой изображение.
   * Принимает имя файла изображения в методе `Load`.
   * Предоставляет методы `Resize`, `Crop` и `Save` для масштабирования, обрезки и сохранения изображения соответственно.

{% code overflow="wrap" lineNumbers="true" %}
```go
package main

import (
    "image"
    "image/jpeg"
    "os"
)

type Image struct {
    img image.Image
}

func (i *Image) Load(filename string) error {
    file, err := os.Open(filename)
    if err != nil {
        return err
    }
    defer file.Close()
    i.img, err = jpeg.Decode(file)
    return err
}

func (i *Image) Resize(width, height int) {
    // Реализация масштабирования
}

func (i *Image) Crop(x, y, width, height int) {
    // Реализация обрезки
}

func (i *Image) Save(filename string) error {
    file, err := os.Create(filename)
    if err != nil {
        return err
    }
    defer file.Close()
    return jpeg.Encode(file, i.img, nil)
}
```
{% endcode %}

1. **Структура `ImagePool`**:
   * Представляет собой пулл объектов `Image`.
   * Принимает максимальный размер пула в конструкторе и создает заданное количество объектов `Image`, которые хранятся в канале.
   * Предоставляет методы `GetImage` и `ReleaseImage`.

{% code overflow="wrap" lineNumbers="true" %}
```go
package main

type ImagePool struct {
    pool chan *Image
}

func NewImagePool(maxSize int) *ImagePool {
    pool := make(chan *Image, maxSize)
    for i := 0; i < maxSize; i++ {
        pool <- &Image{}
    }
    return &ImagePool{pool: pool}
}

func (p *ImagePool) GetImage() *Image {
    select {
    case img := <-p.pool:
        return img
    default:
        return &Image{}
    }
}

func (p *ImagePool) ReleaseImage(img *Image) {
    select {
    case p.pool <- img:
    default:
        // Пулл полон, можно добавить логирование или другие действия
    }
}
```
{% endcode %}

1. **Использование**:

{% code overflow="wrap" lineNumbers="true" %}
```go
package main

import (
    "fmt"
)

func main() {
    pool := NewImagePool(10)

    // Получаем изображение из пула
    img := pool.GetImage()

    // Загружаем изображение
    err := img.Load("path/to/image.jpg")
    if err != nil {
        fmt.Println("Error loading image:", err)
        return
    }

    // Масштабируем изображение
    img.Resize(100, 100)

    // Обрезаем изображение
    img.Crop(0, 0, 50, 50)

    // Сохраняем изображение
    err = img.Save("path/to/new/image.jpg")
    if err != nil {
        fmt.Println("Error saving image:", err)
        return
    }

    // Возвращаем изображение в пул
    pool.ReleaseImage(img)
}
```
{% endcode %}

**Диаграмма классов:**

<figure><img src="../../../../../.gitbook/assets/image (1) (1).png" alt=""><figcaption><p>UML диаграмма для паттерна "Пулл объектов"</p></figcaption></figure>

```plant-uml
@startuml
class Image {
    -img: image.Image
    +Load(filename: string): error
    +Resize(width: int, height: int): void
    +Crop(x: int, y: int, width: int, height: int): void
    +Save(filename: string): error
}

class ImagePool {
    -pool: chan *Image
    +NewImagePool(maxSize: int): *ImagePool
    +GetImage(): *Image
    +ReleaseImage(img: *Image): void
}

ImagePool --> Image
@enduml
```

Эта диаграмма отображает взаимосвязь между классами `Image` и `ImagePool`. `ImagePool` содержит пул объектов `Image` и управляет их жизненным циклом.
