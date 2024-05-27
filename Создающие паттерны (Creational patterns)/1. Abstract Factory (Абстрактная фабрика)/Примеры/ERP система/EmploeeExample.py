# Определяем абстрактный класс Employee для сотрудника, который содержит метод work() для выполнения работы сотрудником.
# Затем мы создаем конкретные классы для менеджера (Manager), разработчика (Developer) и дизайнера (Designer), которые реализуют абстрактный класс Employee и метод work()
# для выполнения конкретного вида работы.
class Employee(ABC):
    def __init__(self, name: str, salary: int, skills: str, experience: str):
        self.name = name
        self.salary = salary
        self.skills = skills
        self.experience = experience

    @abstractedness
    def work(self):
        pass

# Конкретный класс для менеджера
class Manager(Employee):
    def work(self):
        # Код для выполнения работы менеджером
        print(f"Менеджер {self.name} выполняет работу по управлению персоналом.")

# Конкретный класс для разработчика
class Developer(Employee):
    def work(self):
        # Код для выполнения работы разработчиком
        print(f"Разработчик {self.name} выполняет работу по написанию кода.")

# определяем абстрактный класс EmployeeFactory для фабрики сотрудников, который содержит метод create_employee() для создания объекта сотрудника.
# Затем мы создаем конкретные классы для фабрики менеджеров (ManagerFactory), фабрики разработчиков (DeveloperFactory) и фабрики дизайнеров (DesignerFactory),
# которые реализуют абстрактный класс EmployeeFactory и метод create_employee() для создания конкретного объекта сотрудника.
class Designer(Employee):
    def work(self):
        # Код для выполнения работы дизайнером
        print(f"Дизайнер {self.name} выполняет работу по созданию дизайна.")

# Абстрактный класс для фабрики сотрудников
class EmployeeFactory(ABC):
    @abstractmethod
    def create_employee(self, name: str, salary: int, skills: str, experience: str) -> Employee:
        pass

# Конкретный класс для фабрики менеджеров
class ManagerFactory(EmployeeFactory):
    def create_employee(self, name: str, salary: int, skills: str, experience: str) -> Employee:
        # Создание объекта менеджера
        return Manager(name, salary, skills, experience)

# Конкретный класс для фабрики разработчиков
class DeveloperFactory(EmployeeFactory):
    def create_employee(self, name: str, salary: int, skills: str, experience: str) -> Employee:
        # Создание объекта разработчика
        return Developer(name, salary, skills, experience)

# Конкретный класс для фабрики дизайнеров
class DesignerFactory(EmployeeFactory):
    def create_employee(self, name: str, salary: int, skills: str, experience: str) -> Employee:
        # Создание объекта дизайнера
        return Designer(name, salary, skills, experience)

# В примере использования мы создаем фабрики для каждого типа сотрудников и выполняем работу с помощью созданных объектов.
if __name__ == "__main__":
    manager_factory = ManagerFactory()
    manager = manager_factory.create_employee("Иван Иванов", 50000, "управление персоналом", "5 лет")
    manager.work()

    developer_factory = DeveloperFactory()
    developer = developer_factory.create_employee("Петр Петров", 40000, "PHP, JavaScript", "3 года")
    developer.work()

    designer_factory = DesignerFactory()
    designer = designer_factory.create_employee("Мария Иванова", 45000, "Photoshop, Figma", "2 года")
    designer.work()
