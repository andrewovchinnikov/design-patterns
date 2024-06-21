# PHP

Разработка веб-приложения, которое предоставляет пользователям возможность загружать и редактировать изображения. Для оптимизации работы приложения и снижения нагрузки на память, используется паттерн "Пулл объектов" для повторного использования экземпляров класса для работы с изображениями.

Паттерн "Пулл объектов" позволяет уменьшить нагрузку на систему, переиспользуя объекты, вместо создания новых каждый раз. В этом случае, пулл используется для объектов класса `Image`, которые используются для работы с изображениями. Приложение может брать объект из пула, выполнять операции с изображением, и возвращать объект обратно в пулл, вместо создания нового объекта каждый раз

Код:

```php
<?php

class Image
{
    private $resource;

    public function __construct(string $filename)
    {
        $this->resource = imagecreatefromjpeg($filename);
    }

    public function resize(int $width, int $height): void
    {
        $newResource = imagescale($this->resource, $width, $height);
        imagedestroy($this->resource);
        $this->resource = $newResource;
    }

    public function crop(int $x, int $y, int $width, int $height): void
    {
        $newResource = imagecrop($this->resource, ['x' => $x, 'y' => $y, 'width' => $width, 'height' => $height]);
        imagedestroy($this->resource);
        $this->resource = $newResource;
    }

    public function save(string $filename): void
    {
        imagejpeg($this->resource, $filename);
        imagedestroy($this->resource);
    }
}
```

Image - это класс, который представляет собой изображение. Он принимает имя файла изображения в конструкторе и предоставляет методы resize(), crop() и save(), которые позволяют масштабировать, обрезать и сохранять изображение соответственно.

<pre class="language-php" data-overflow="wrap" data-line-numbers><code class="lang-php"><strong>&#x3C;?php
</strong>
class ImagePool
{
    private $images = [];

    public function __construct(int $maxSize)
    {
        for ($i = 0; $i &#x3C; $maxSize; $i++) {
            $this->images[] = new Image('');
        }
    }

    public function getImage(): Image
    {
        if (count($this->images) > 0) {
            return array_pop($this->images);
        }

        return new Image('');
    }

    public function releaseImage(Image $image): void
    {
        $this->images[] = $image;
    }
}

// Использование
$pool = new ImagePool(10);

// Получаем изображение из пула
$image = $pool->getImage();

// Загружаем изображение
$image->__construct('path/to/image.jpg');

// Масштабируем изображение
$image->resize(100, 100);

// Обрезаем изображение
$image->crop(0, 0, 50, 50);

// Сохраняем изображение
$image->save('path/to/new/image.jpg');

// Возвращаем изображение в пул
$pool->releaseImage($image);
</code></pre>

1. `ImagePool` - это класс, который представляет собой пулл объектов `Image`. Он принимает максимальный размер пула в конструкторе и создает заданное количество объектов `Image`, которые хранятся в массиве `images`. Класс предоставляет два метода:

* `getImage()` - этот метод извлекает объект `Image` из пула и возвращает его. Если пулл пуст, метод создает новый объект `Image`.
* `releaseImage()` - этот метод принимает объект `Image` в качестве аргумента и возвращает его обратно в пулл.

Диаграмма классов:

<figure><img src="../../../../../.gitbook/assets/image (39).png" alt=""><figcaption><p>UML диаграмма для паттерна "Пулл объектов"</p></figcaption></figure>

```sql
@startuml
class Image {
-resource: resource
+__construct(string $filename): void
+resize(int $width, int $height): void
+crop(int $x, int $y, int $width, int $height): void
+save(string $filename): void
}

class ImagePool {
-images: array
+getImage(): Image
+releaseImage(Image $image): void
}
@enduml
```
