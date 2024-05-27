<?php

/**
 * Определяем абстрактный класс Employee для сотрудника, который содержит метод work() для выполнения работы сотрудником.
 * Затем мы создаем конкретные реализации этого класса для менеджера (Manager), разработчика (Developer) и дизайнера (Designer),
 * которые реализуют метод work() для выполнения конкретного вида работы.
 */
abstract class Employee
{
    protected $name;
    protected $salary;
    protected $skills;
    protected $experience;

    public function __construct($name, $salary, $skills, $experience)
    {
        $this->name = $name;
        $this->salary = $salary;
        $this->skills = $skills;
        $this->experience = $experience;
    }

    // Метод для выполнения работы сотрудником
    abstract public function work();
}

/*
 * Конкретный класс для менеджера
 */
class Manager extends Employee
{
    public function __construct($name, $salary, $skills, $experience)
    {
        parent::__construct($name, $salary, $skills, $experience);
    }

    public function work()
    {
        // Код для выполнения работы менеджером
        echo "Менеджер {$this->name} выполняет работу по управлению персоналом.\n";
    }
}

/**
 * Конкретный класс для разработчика
 */
class Developer extends Employee
{
    public function __construct($name, $salary, $skills, $experience)
    {
        parent::__construct($name, $salary, $skills, $experience);
    }

    public function work()
    {
        // Код для выполнения работы разработчиком
        echo "Разработчик {$this->name} выполняет работу по написанию кода.\n";
    }
}

/*
 * Конкретный класс для дизайнера
 */
class Designer extends Employee
{
    public function __construct($name, $salary, $skills, $experience)
    {
        parent::__construct($name, $salary, $skills, $experience);
    }

    public function work()
    {
        // Код для выполнения работы дизайнером
        echo "Дизайнер {$this->name} выполняет работу по созданию дизайна.\n";
    }
}

/**
 * Определяем абстрактный класс EmployeeFactory для фабрики сотрудников, который содержит метод createEmployee(...$params) для создания объекта сотрудника.
 * Затем мы создаем конкретные реализации этого класса для фабрики менеджеров (ManagerFactory), фабрики разработчиков (DeveloperFactory) и
 * фабрики дизайнеров (DesignerFactory), которые реализуют метод createEmployee(...$params) для создания конкретного объекта сотрудника.
 */
abstract class EmployeeFactory
{
    // Метод для создания объекта сотрудника
    abstract public function createEmployee(...$params);
}

/*
 * Конкретный класс для фабрики менеджеров
 */
class ManagerFactory extends EmployeeFactory
{
    public function createEmployee(...$params)
    {
        // Создание объекта менеджера
        return new Manager(...$params);
    }
}

/**
 * Конкретный класс для фабрики разработчиков
 */
class DeveloperFactory extends EmployeeFactory
{
    public function createEmployee(...$params)
    {
        // Создание объекта разработчика
        return new Developer(...$params);
    }
}

/*
 * Конкретный класс для фабрики дизайнеров
 */
class DesignerFactory extends EmployeeFactory
{
    public function createEmployee(...$params)
    {
        // Создание объекта дизайнера
        return new Designer(...$params);
    }
}

/**
 * В примере использования мы создаем фабрики для каждого типа сотрудников и выполняем работу с помощью созданных объектов.
 */
$managerFactory = new ManagerFactory();
$manager = $managerFactory->createEmployee('Иван Иванов', 50000, 'управление персоналом', '5 лет');
$manager->work();

$developerFactory = new DeveloperFactory();
$developer = $developerFactory->createEmployee('Петр Петров', 40000, 'PHP, JavaScript', '3 года');
$developer->work();

$designerFactory = new DesignerFactory();
$designer = $designerFactory->createEmployee('Мария Иванова', 45000, 'Photoshop, Figma', '2 года');
$designer->work();

