# Объектный массив на PHP (PHP-коллекция)

Набор классов для удобной и гибкой работы с массивами в объектно-ориентированном
представлении. Фактически, это "объектный массив", которого так не хватает в PHP.

## Требования

PHP >= 8.0

## Установка

```
composer require krugozor/cover
```

## Документация

Базовый класс называется `CoverArray`.
Вы можете создать класс, наследуемый от `CoverArray` или использовать `CoverArray` без наследования.

В данной документации, как и в unit-тестах, используется тип данных `NewTypeArray`,
наследуемый от `CoverArray`:

```php
class NewTypeArray extends CoverArray {}
```

Это сделано для того, что бы продемонстрировать гибкость данного решения.
Объектов, производных от `CoverArray`, в вашей программе может быть много, они могут отличаться
на концептуальном уровне и содержать в себе разную логику работы с данными.

Например, объекты класса `CoverArray` можно использовать просто как "объектный массив"
для замещения стандартного `array` в повседневной работе,
в свою очередь любой другой тип, производный от `CoverArray`, может служить, например, неким подобием DTO
или попросту быть независимым типом данных для предотвращения "выстрела в ногу":

```php
function foo(NewTypeArray $data) {}
```

### Инициализация

Инстанцируем новый объект класса `NewTypeArray`.
Передадим в конструктор многомерный массив и посмотрим на структуру, которая получится:

```php
class NewTypeArray extends CoverArray {}

$data = new NewTypeArray([
    'firstName' => 'Vasiliy',
    'lastName' => 'Ivanov',
    'languages' => [
        'backend' => ['PHP', 'MySql'],
        'frontend' => ['HTML', 'CSS1', 'JavaScript', 'CSS2', 'CSS3']
    ],
]);

var_dump($data);
```

Результат:

```
object(NewTypeArray)#2 (1) {
  ["data":protected]=>
  array(3) {
    ["firstName"]=>
    string(7) "Vasiliy"
    ["lastName"]=>
    string(6) "Ivanov"
    ["languages"]=>
    object(NewTypeArray)#4 (1) {
      ["data":protected]=>
      array(2) {
        ["backend"]=>
        object(NewTypeArray)#5 (1) {
          ["data":protected]=>
          array(2) {
            [0]=>
            string(3) "PHP"
            [1]=>
            string(5) "MySql"
          }
        }
        ["frontend"]=>
        object(NewTypeArray)#6 (1) {
          ["data":protected]=>
          array(5) {
            [0]=>
            string(4) "HTML"
            [1]=>
            string(4) "CSS1"
            [2]=>
            string(10) "JavaScript"
            [3]=>
            string(4) "CSS2"
            [4]=>
            string(4) "CSS3"
          }
        }
      }
    }
  }
}
```

Как видно, все переданные в конструктор массивы рекурсивно преобразовались в объекты типа `NewTypeArray`.
Это поведение гарантирует, что **любой массив, попадающий в хранилище, получит "обложку" в виде
объекта того класса, который его аккумулирует**.

Данные всех созданных объектов аккуратно сложились в protected-свойства `$data`, что обеспечивает инкапсуляцию
данных, а функционал базового класса `CoverArray` предоставляет безграничную возможность манипуляций над этими данными!

### Примеры работы

Тут представлена лишь малая доля возможных примеров работы с объектным массивом `CoverArray`.
Изучите API класса для более углублённого понимания.

#### Пример:
```php
$value = $data
    ->get('languages.frontend')
    ->filter(function ($value) {
        return preg_match('~CSS~', $value);
    })
    ->implode(', ');

var_dump($value);
```
Результат:
```
string(16) "CSS1, CSS2, CSS3"
```


#### Пример:
```php
$value = $data
    ->get('languages.frontend')
    ->append('HTML 5', 'jQuey')
    ->getDataAsArray();

var_dump($value);
```
Результат:
```
array(7) {
  [0]=>
  string(4) "HTML"
  [1]=>
  string(4) "CSS1"
  [2]=>
  string(10) "JavaScript"
  [3]=>
  string(4) "CSS2"
  [4]=>
  string(4) "CSS3"
  [5]=>
  string(6) "HTML 5"
  [6]=>
  string(5) "jQuey"
}
```


#### Пример:
```php
var_dump($data['languages']['backend'][0]);
var_dump($data->languages->backend->item(0));
var_dump($data->get('languages.backend.0'));
var_dump($data->get('languages')->item('backend')[0]);
var_dump($data->get('languages')['backend']->item(0));
```
Результат:
```
string(3) "PHP"
string(3) "PHP"
string(3) "PHP"
string(3) "PHP"
string(3) "PHP"
```


#### Пример:
```php
var_dump($data->get('languages.backend')->getFirst());
var_dump($data->get('languages.backend')->getLast());
```
Результат:
```
string(3) "PHP"
string(5) "MySql"
```


#### Пример:
```php
var_dump(serialize($data->get('languages.backend')));
```
Результат:
```
string(54) "O:12:"NewTypeArray":2:{i:0;s:3:"PHP";i:1;s:5:"MySql";}"
```


#### Пример:
```php
$value = $data->get('languages')->map(function (CoverArray $lang, string $key) {
    return sprintf(
        "\n\t<li>%s (%s):\n\t%s\n\t</li>",
        $key,
        $lang->count(),
        $lang->map(fn($value): string => "\t<li>$value</li>")->implode("\n\t")
    );
})
    ->prepend("\n<ul>")
    ->append("\n</ul>")
    ->implode('');

var_dump($value);
```
Результат:
```
string(180) "
<ul>
        <li>backend (2):
                <li>PHP</li>
                <li>MySql</li>
        </li>
        <li>frontend (5):
                <li>HTML</li>
                <li>CSS1</li>
                <li>JavaScript</li>
                <li>CSS2</li>
                <li>CSS3</li>
        </li>
</ul>"
```


#### Пример:
```php
$value = NewTypeArray::fromExplode(',', '1,1,2,1,2,2,1,,1,,,2')
    ->unique()
    ->filter()
    ->implode(',');

var_dump($value);
```
Результат:
```
string(3) "1,2"
```


#### Пример:
```php
var_dump($data->get('languages.backend')->getDataAsArray());
var_dump($data->get('languages.backend')->reverse()->getDataAsArray());
```
Результат:
```
array(2) {
  [0]=>
  string(3) "PHP"
  [1]=>
  string(5) "MySql"
}
array(2) {
  [0]=>
  string(5) "MySql"
  [1]=>
  string(3) "PHP"
}
```


#### Пример:
```php
var_dump($data->get('languages.backend')->in('PHP'));
```
Результат:
```
bool(true)
```


#### Пример:
```php
$value = $data->get('languages.frontend')->diff(
    ['HTML'],
    ['CSS1', 'CSS2', 'CSS3']
)->getDataAsArray();

var_dump($value);
```
или даже так:
```php
$value = $data->get('languages.frontend')->diff(
    new NewTypeArray(['HTML']),
    new NewTypeArray(['CSS1', 'CSS2', 'CSS3'])
)->getDataAsArray();
```

Результат:
```
array(1) {
  [2]=>
  string(10) "JavaScript"
}
```


#### Пример:
```php
$value = $data->get('languages')->mapRecursive(
    fn(mixed $value, mixed $key): string => "$key: $value"
)->getDataAsArray();

var_dump($value);
```
Результат:
```
array(2) {
  ["backend"]=>
  array(2) {
    [0]=>
    string(6) "0: PHP"
    [1]=>
    string(8) "1: MySql"
  }
  ["frontend"]=>
  array(5) {
    [0]=>
    string(7) "0: HTML"
    [1]=>
    string(7) "1: CSS1"
    [2]=>
    string(13) "2: JavaScript"
    [3]=>
    string(7) "3: CSS2"
    [4]=>
    string(7) "4: CSS3"
  }
}
```