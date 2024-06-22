# Python

Веб-приложение должно предоставлять пользователям возможность загружать и редактировать изображения. Для оптимизации работы приложения и снижения нагрузки на память, используется паттерн "Пулл объектов" для повторного использования экземпляров класса для работы с изображениями. Паттерн "Пулл объектов" позволяет уменьшить нагрузку на систему, переиспользуя объекты, вместо создания новых каждый раз. В данном случае, пулл используется для объектов класса `Image`, которые используются для работы с изображениями. Приложение может брать объект из пула, выполнять операции с изображением, и возвращать объект обратно в пулл, вместо создания нового объекта каждый раз.

**Классы и функции на Python:**

1. **Класс `Image`**:
   * Представляет собой изображение.
   * Принимает имя файла изображения в конструкторе.
   * Предоставляет методы `resize`, `crop` и `save` для масштабирования, обрезки и сохранения изображения соответственно.

{% code overflow="wrap" lineNumbers="true" %}
```python
from PIL import Image as PILImage

class Image:
    def __init__(self, filename):
        self.image = PILImage.open(filename)

    def resize(self, width, height):
        self.image = self.image.resize((width, height))

    def crop(self, x, y, width, height):
        self.image = self.image.crop((x, y, x + width, y + height))

    def save(self, filename):
        self.image.save(filename)
```
{% endcode %}

1. **Класс `ImagePool`**:
   * Представляет собой пулл объектов `Image`.
   * Принимает максимальный размер пула в конструкторе и создает заданное количество объектов `Image`, которые хранятся в списке.
   * Предоставляет методы `get_image` и `release_image`.

{% code overflow="wrap" lineNumbers="true" %}
```python
class ImagePool:
    def __init__(self, max_size):
        self.images = []
        self.max_size = max_size

    def get_image(self):
        if self.images:
            return self.images.pop()
        return Image('')

    def release_image(self, image):
        if len(self.images) < self.max_size:
            self.images.append(image)
```
{% endcode %}

1. **Использование**:

{% code overflow="wrap" lineNumbers="true" %}
```python
if __name__ == "__main__":
    pool = ImagePool(10)

    # Получаем изображение из пула
    image = pool.get_image()

    # Загружаем изображение
    image.__init__('path/to/image.jpg')

    # Масштабируем изображение
    image.resize(100, 100)

    # Обрезаем изображение
    image.crop(0, 0, 50, 50)

    # Сохраняем изображение
    image.save('path/to/new/image.jpg')

    # Возвращаем изображение в пул
    pool.release_image(image)
```
{% endcode %}

**Диаграмма классов:**

<figure><img src="../../../../../.gitbook/assets/image (41).png" alt=""><figcaption><p>UML диаграмма для паттерна "Пулл объектов"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
class Image {
    -image: PILImage
    +__init__(filename: str)
    +resize(width: int, height: int): void
    +crop(x: int, y: int, width: int, height: int): void
    +save(filename: str): void
}

class ImagePool {
    -images: list
    -max_size: int
    +__init__(max_size: int)
    +get_image(): Image
    +release_image(image: Image): void
}

ImagePool --> Image
@enduml
```
{% endcode %}

Эта диаграмма отображает взаимосвязь между классами `Image` и `ImagePool`. `ImagePool` содержит пул объектов `Image` и управляет их жизненным циклом.
