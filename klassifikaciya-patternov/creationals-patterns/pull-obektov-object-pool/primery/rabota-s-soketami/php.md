# PHP

Разработка приложения для отправки и получения данных через сеть с использованием сокетов. Для оптимизации работы приложения и снижения нагрузки на память, используется паттерн "Пулл объектов" для повторного использования сокетов.

Паттерн "Пулл объектов" позволяет уменьшить нагрузку на систему, переиспользуя объекты, вместо создания новых каждый раз. В этом случае, пулл используется для объектов класса `Socket`, которые используются для отправки и получения данных через сеть. Приложение может брать объект `Socket` из пула, выполнять операции с сокетом, и возвращать объект обратно в пулл, вместо создания нового объекта каждый раз.

Код:

{% code overflow="wrap" lineNumbers="true" %}
```php
<?php

class Socket
{
    private $socket;

    public function __construct(string $host, int $port)
    {
        $this->socket = stream_socket_client("tcp://{$host}:{$port}");
    }

    public function send(string $data): void
    {
        fwrite($this->socket, $data);
    }

    public function receive(): string
    {
        return fread($this->socket, 8192);
    }

    public function close(): void
    {
        fclose($this->socket);
    }
}
```
{% endcode %}

Socket - это класс, который представляет собой сокет. Он принимает адрес хоста и номер порта в конструкторе и предоставляет методы send(), receive() и close(), которые позволяют отправлять, получать и закрывать сокет соответственно.

{% code overflow="wrap" lineNumbers="true" %}
```php
<?php

class SocketPool
{
    private $sockets = [];

    public function __construct(int $maxSize)
    {
        for ($i = 0; $i < $maxSize; $i++) {
            $this->sockets[] = new Socket('localhost', 80);
        }
    }

    public function getSocket(): Socket
    {
        if (count($this->sockets) > 0) {
            return array_pop($this->sockets);
        }

        return new Socket('localhost', 80);
    }

    public function releaseSocket(Socket $socket): void
    {
        $this->sockets[] = $socket;
    }
}
```
{% endcode %}

SocketPool - это класс, который представляет собой пулл объектов Socket. Он принимает максимальный размер пула в конструкторе и создает заданное количество объектов Socket, которые хранятся в массиве sockets. Класс предоставляет два метода:&#x20;

* getSocket() - этот метод извлекает объект Socket из пула и возвращает его. Если пулл пуст, метод создает новый объект Socket.&#x20;
* releaseSocket() - этот метод принимает объект Socket в качестве аргумента и возвращает его обратно в пулл.

```php
$pool = new SocketPool(10);

// Получаем сокет из пула
$socket = $pool->getSocket();

// Отправляем данные
$socket->send('GET / HTTP/1.1');

// Получаем ответ
$response = $socket->receive();

// Закрываем сокет
$socket->close();

// Возвращаем сокет в пул
$pool->releaseSocket($socket);
```

Код использования показывает, как использовать классы SocketPool и Socket для отправки и получения данных через сеть. Сначала создается объект SocketPool, который используется для создания объекта Socket. Затем из пула извлекается объект Socket, выполняются операции с сокетом, и результат сохраняется в переменной $response. После этого, сокет закрывается и возвращается обратно в пулл.

Диаграмма классов:

<figure><img src="../../../../../.gitbook/assets/image (40).png" alt=""><figcaption><p>UML диаграмма для паттерна "Пулл объектов"</p></figcaption></figure>

```plant-uml
@startuml
class Socket {
-socket: resource
+__construct(string $host, int $port): void
+send(string $data): void
+receive(): string
+close(): void
}

class SocketPool {
-sockets: array
+getSocket(): Socket
+releaseSocket(Socket $socket): void
}
@enduml
```
