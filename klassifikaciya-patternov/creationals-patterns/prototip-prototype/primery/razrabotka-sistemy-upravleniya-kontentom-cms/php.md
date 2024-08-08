# PHP

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Прототип"</p></figcaption></figure>

Задача: Разработать систему управления контентом (CMS) для сайта, которая позволит администраторам создавать, редактировать и удалять страницы сайта. Для упрощения процесса создания страниц, необходимо предоставить возможность создавать новые страницы на основе существующих шаблонов.

Решение: Для реализации этой задачи, мы будем использовать паттерн проектирования "Прототип". Этот паттерн позволяет создавать новые объекты путем копирования существующих объектов. В нашем случае, мы будем создавать новые страницы на основе существующих шаблонов, которые будут являться прототипами.

Код:

Сначала, определим абстрактный класс Template, который будет содержать абстрактный метод clone():

```php
abstract class Template {
    abstract public function clone();
}

```

Затем, определим конкретный класс-шаблон PageTemplate, который будет наследоваться от класса Template и реализовывать метод clone():

{% code overflow="wrap" lineNumbers="true" %}
```php
class PageTemplate extends Template {
    private $title;
    private $content;
    private $args;
    private $kwargs;

    public function __construct($title, $content, ...$args) {
        $this->title = $title;
        $this->content = $content;
        $this->args = $args;
        $this->kwargs = array();
        if (isset($args[sizeof($args) - 1]) && is_array($args[sizeof($args) - 1])) {
            $this->kwargs = $args[sizeof($args) - 1];
            unset($this->args[sizeof($this->args) - 1]);
        }
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }

    public function getArgs() {
        return $this->args;
    }

    public function getKwargs() {
        return $this->kwargs;
    }

    public function clone() {
        return new PageTemplate($this->title, $this->content, ...$this->args);
    }
}

```
{% endcode %}

Класс PageTemplate содержит конструктор, который принимает аргументы $title, $content, ...$args. Аргумент $title будет использоваться в качестве заголовка страницы, а $content - в качестве ее содержимого. Аргументы, переданные в ...$args, будут использоваться для дальнейшей настройки шаблона. Метод clone() создает копию текущего объекта PageTemplate.

Теперь, определим класс Page, который будет представлять собой конкретную страницу, созданную на основе шаблона:

{% code overflow="wrap" lineNumbers="true" %}
```php
class Page {
    private $title;
    private $content;
    private $args;
    private $kwargs;

    public function __construct($title, $content, ...$args) {
        $this->title = $title;
        $this->content = $content;
        $this->args = $args;
        $this->kwargs = array();
        if (isset($args[sizeof($args) - 1]) && is_array($args[sizeof($args) - 1])) {
            $this->kwargs = $args[sizeof($args) - 1];
            unset($this->args[sizeof($this->args) - 1]);
        }
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }

    public function getArgs() {
        return $this->args;
    }

    public function getKwargs() {
        return $this->kwargs;
    }
}

```
{% endcode %}

Класс Page аналогичен классу PageTemplate, за исключением того, что он не наследуется от класса Template и не содержит метода clone().

Наконец, определим класс-фабрику PageFactory, который будет создавать новые страницы на основе шаблонов:

{% code overflow="wrap" lineNumbers="true" %}
```php
class PageFactory {
    private $prototypes;

    public function __construct() {
        $this->prototypes = array(
            "default" => new PageTemplate("Default Title", "Default Content"),
            "blog" => new PageTemplate("Blog Title", "Blog Content", "post_format" => "standard"),
            "portfolio" => new PageTemplate("Portfolio Title", "Portfolio Content", "num_columns" => 3),
        );
    }

    public function createPage($templateName, $title, $content, ...$args) {
        $prototype = $this->prototypes[$templateName];
        $page = $prototype->clone();
        $page->title = $title;
        $page->content = $content;
        $page->args = $args;
        $page->kwargs = array();
        if (isset($args[sizeof($args) - 1]) && is_array($args[sizeof($args) - 1])) {
            $page->kwargs = $args[sizeof($args) - 1];
            unset($page->args[sizeof($page->args) - 1]);
        }
        return $page;
    }
}

```
{% endcode %}

Класс PageFactory содержит конструктор, который инициализирует массив $prototypes, содержащий шаблоны страниц. Метод createPage() принимает аргументы $templateName, $title, $content, ...$args, где $templateName - это имя шаблона, который будет использоваться для создания новой страницы. Метод создает копию шаблона, заменяет заголовок и содержимое страницы на те, что были переданы в аргументах, и возвращает объект класса Page.

Пример использования:

{% code overflow="wrap" lineNumbers="true" %}
```php
$factory = new PageFactory();

// Создаем новую страницу на основе шаблона "default"
$page = $factory->createPage("default", "New Page Title", "New Page Content");
echo $page->getTitle();
echo $page->getContent();

// Создаем новую страницу на основе шаблона "blog"
$page = $factory->createPage("blog", "New Blog Title", "New Blog Content", "post_format" => "gallery");
echo $page->getTitle();
echo $page->getContent();
echo $page->getKwargs()["post_format"];

```
{% endcode %}
