# PHP

<figure><img src="../../../../../.gitbook/assets/image (17).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Одиночка"</p></figcaption></figure>

Наша команда разрабатывает ERP систему для управления бизнес-процессами в средних и крупных компаниях. В рамках разработки нам необходимо решить задачу с управлением настройками пользователей. Наша система должна обеспечивать гибкость и масштабируемость, поэтому мы решили использовать паттерн "Одиночка" (Singleton) для создания единственного экземпляра класса, отвечающего за работу с настройками.

Задача:

Нужно разработать класс `SettingsManager`, который будет отвечать за работу с настройками пользователей. Для этого необходимо реализовать паттерн "Одиночка" для создания единственного экземпляра класса `SettingsManager`. Этот экземпляр будет предоставлять доступ к данным о настройках и выполнять операции над ними.

Почему мы выбрали этот паттерн:

Мы выбрали паттерн "Одиночка" для решения этой задачи, потому что он позволяет нам централизовать управление настройками и избежать конфликтов при работе с ними. Кроме того, мы смогли упростить код и уменьшить количество ошибок, связанных с инициализацией и использованием экземпляров класса.

```php
// Класс SettingsManager, отвечающий за работу с настройками
class SettingsManager {
    // Свойство, хранящее массив настроек
    private $settings = [];

    // Приватное свойство, хранящее единственный экземплярр класса
    private static $instance = null;

    // Приватный конструктор, предотвращающий создание экземпляров класса с помощью оператора new
    private function __construct() {}

    // Статический и публичный метод, возвращающий единственный экземплярр класса SettingsManager
    public static function getInstance(): SettingsManager {
        // Проверяем, существует ли уже экземплярр класса
        if (self::$instance === null) {
            // Если нет, то создаем новый экземплярр класса и сохраняем его в свойстве instance
            self::$instance = new SettingsManager();
        }
        // Возвращаем существующий экземплярр класса
        return self::$instance;
    }

    // Публичный метод, добавляющий новую настройку в массив настроек
    public function addSetting(string $key, $value): void {
        // Добавляем новую настройку в массив настроек
        $this->settings[$key] = $value;
    }

    // Публичный метод, возвращающий значение настройки по ее ключу
    public function getSetting(string $key) {
        // Возвращаем значение настройки по ее ключу
        return $this->settings[$key] ?? null;
    }

    // Публичный метод, удаляющий настройку из массива настроек по ее ключу
    public function deleteSetting(string $key): void {
        // Если настройка существует, то удаляем ее из массива настроек
        if (array_key_exists($key, $this->settings)) {
            unset($this->settings[$key]);
        }
    }
}

//usage
// Получаем единственный экземплярр класса SettingsManager
$settingsManager = SettingsManager::getInstance();
// Добавляем новые настройки в массив настроек
$settingsManager->addSetting("language", "en");
$settingsManager->addSetting("theme", "dark");
// Получаем значение настройки по ее ключу
$language = $settingsManager->getSetting("language");
echo $language; // en
// Удаляем настройку из массива настроек по ее ключу
$settingsManager->deleteSetting("theme");
// Получаем обновленный массив всех настроек
$settings = $settingsManager->getSettings();
print_r($settings); // ["language" => "en"]
```

В этом примере мы создаем класс `SettingsManager`, который отвечает за работу с настройками. Мы используем паттерн "Одиночка" для создания единственного экземпляра класса `SettingsManager`.

Мы объявляем приватное свойство `$settings`, которое будет хранить массив настроек. Мы также объявляем приватное свойство `$instance`, которое будет хранить единственный экземплярр класса. Мы объявляем приватный конструктор, чтобы предотвратить создание экземпляров класса с помощью оператора `new`.

Метод `getInstance()` является статическим и публичным, и он используется для получения единственного экземпляра класса `SettingsManager`. В этом методе мы проверяем, существует ли уже экземплярр класса. Если нет, то создаем новый экземплярр класса и сохраняем его в свойстве `$instance`. В противном случае, мы просто возвращаем существующий экземплярр класса `SettingsManager`.

Методы `addSetting()`, `getSetting()` и `deleteSetting()` используются для выполнения операций над настройками.

Надеюсь, этот пример поможет вам лучше понять, как можно использовать паттерн "Одиночка" для решения задач, связанных с управлением настройками пользователей в веб-приложении на PHP.
