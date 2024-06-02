# PHP

<figure><img src="../../../../../.gitbook/assets/image (9).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Одиночка" для работы с БД</p></figcaption></figure>

Разработка веб-приложения, которое использует базу данных для хранения и обработки данных. База данных должна быть доступна из разных частей приложения, и нужно избежать конфликтов при работе с ней.

Решение:

Для решения этой задачи мы можем использовать паттерн "Одиночка" (Singleton) для создания единственного экземпляра класса, отвечающего за работу с базой данных. Этот экземпляр будет предоставлять доступ к базе данных и выполнять запросы к ней.

Например, для класса `Database`, отвечающего за работу с базой данных, паттерн "Одиночка" может быть реализован следующим образом:

{% code overflow="wrap" lineNumbers="true" %}
```php
class Database {
    private static $instance = null;
    private $pdo = null;

    private function __construct() {
        $dsn = 'mysql:dbname=my_database;host=localhost';
        $user = 'my_user';
        $password = 'my_password';

        try {
            $this->pdo = new PDO($dsn, $user, $password);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function query(string $sql, array $params = []): array {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

//использование
$db = Database::getInstance();
$users = $db->query('SELECT * FROM users');
```
{% endcode %}

В этом примере мы объявляем приватное статическое свойство `$instance`, которое будет хранить единственный экземплярр класса `Database`. Конструктор класса также объявлен приватным, чтобы предотвратить создание экземпляров класса с помощью оператора `new`.

Метод `getInstance()` является статическим и публичным, и он используется для получения единственного экземпляра класса `Database`. В этом методе мы проверяем, является ли свойство `$instance` равным `null`. Если да, то мы создаем новый экземплярр класса `Database` и сохраняем его в свойстве `$instance`. В противном случае, мы просто возвращаем существующий экземплярр класса `Database`.

Метод `query()` используется для выполнения запросов к базе данных. Он принимает в качестве аргументов SQL-запрос и массив параметров, и возвращает массив с результатами запроса.
