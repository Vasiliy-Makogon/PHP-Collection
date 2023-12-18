# Объектный массив на PHP

`CoverArray` - базовый класс для удобной и гибкой работы с массивами в объектно-ориентированном
представлении. Фактически, это "объектный массив", которого так не хватает в PHP.

## Как это работает?

Вы можете создать класс, наследуемый от `CoverArray` или использовать `CoverArray` без наследования. 
Создадим класс нового типа, наследуемый от базового класса `CoverArray`:

```php
class NewTypeArray extends CoverArray
{}
```

Примечание: в данном примере, как и в тестах, используется тип данных `NewTypeArray`, 
наследуемый от `CoverArray`. Это сделано для того, что бы продемонстрировать гибкость данного решения. 
Объектов, производных от `CoverArray`, в программе может быть много, они могут отличаться на концептуальном уровне. 
Например, объекты класса `CoverArray` можно использовать просто как "объектный массив" 
для замещения стандартного `array` в повседневной работе, 
в свою очередь любой другой тип, производный от `CoverArray`, может служить, например, неким подобием DTO 
или попросту быть независимым типом данных для предотвращения "выстрела в ногу":

```php
function foo(NewTypeArray $data) {}
```

Инстанцируем новый объект данного класса. Передадим в конструктор многомерный массив и посмотрим на структуру, которая
получится:

```php
$data = new NewTypeArray([
    'firstName' => 'Vasiliy',
    'lastName' => 'Ivanov',
    'langs' => [
        'backend' => ['PHP', 'MySql'],
        'frontend' => ['HTML', 'CSS1', 'JavaScript', 'CSS2', 'CSS3']
    ],
]);

var_dump($data);
```

Результат:

```
object(Krugozor\Cover\Tests\NewTypeArray)#4 (1) {
  ["data":protected]=>
  array(3) {
    ["firstName"]=>
    string(7) "Vasiliy"
    ["lastName"]=>
    string(6) "Ivanov"
    ["langs"]=>
    object(Krugozor\Cover\Tests\NewTypeArray)#5 (1) {
      ["data":protected]=>
      array(2) {
        ["backend"]=>
        object(Krugozor\Cover\Tests\NewTypeArray)#6 (1) {
          ["data":protected]=>
          array(2) {
            [0]=>
            string(3) "PHP"
            [1]=>
            string(5) "MySql"
          }
        }
        ["frontend"]=>
        object(Krugozor\Cover\Tests\NewTypeArray)#7 (1) {
          ["data":protected]=>
          array(5) {
            [0]=>
            string(4) "HTML"
            [1]=>
            string(5) "CSS1"
            [2]=>
            string(10) "JavaScript"
            [3]=>
            string(5) "CSS2"
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
Это поведение гарантирует, что любой массив, попадающий в хранилище, получит "обложку" (cover) в виде типа текущего класса.
Данные всех созданных объектов аккуратно сложились в protected-свойства `$data`, что обеспечивает инкапсуляцию данных
и возможность реализации любых методов над ними.

## Давайте попробуем поработать с данными созданного выше объекта:

Пример:
```php
$value = $data
    ->get('langs.frontend')
    ->filter(function ($value) {
        return preg_match('~CSS~', $value);
    })
    ->implode(', ');

var_dump($value);
```
Результат:
```
string(18) "CSS1, CSS2, CSS3"
```

Пример:
```php
$value = $data
    ->get('langs.frontend')
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
  string(5) "CSS1"
  [2]=>
  string(10) "JavaScript"
  [3]=>
  string(5) "CSS2"
  [4]=>
  string(4) "CSS3"
  [5]=>
  string(6) "HTML 5"
  [6]=>
  string(5) "jQuey"
}
```


Пример:
```php
var_dump($data['langs']['backend'][0]);
var_dump($data->langs->backend->item(0));
var_dump($data->get('langs.backend.0'));
var_dump($data->get('langs')->item('backend')[0]);
var_dump($data->get('langs')['backend']->item(0));
```
Результат:
```
string(3) "PHP"
string(3) "PHP"
string(3) "PHP"
string(3) "PHP"
string(3) "PHP"
```


Пример:
```php
var_dump($data->get('langs.backend')->getFirst());
var_dump($data->get('langs.backend')->getLast());
```
Результат:
```
string(3) "PHP"
string(5) "MySql"
```


Пример:
```php
var_dump(serialize($data->get('langs.backend')));
```
Результат:
```
string(75) "O:33:"Krugozor\Cover\Tests\NewTypeArray":2:{i:0;s:3:"PHP";i:1;s:5:"MySql";}"
```


Пример:
```php
$value = $data->get('langs')->mapAssociative(function (string $key, CoverArray $langs) {
    return sprintf(
        "\n<ul>\n  %s (%s):\n%s\n</ul>",
        $key,
        $langs->count(),
        $langs->map(fn(string $lang): string => "    <li>$lang</li>")->implode(PHP_EOL)
    );
})->implode('');

var_dump($value);
```
Результат:
```
string(190) "
<ul>
  backend (2):
    <li>PHP</li>
    <li>MySql</li>
</ul>
<ul>
  frontend (5):
    <li>HTML</li>
    <li>CSS1</li>
    <li>JavaScript</li>
    <li>CSS2</li>
    <li>CSS3</li>
</ul>"
```


Пример:
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


Пример:
```php
var_dump($data->get('langs.backend')->getDataAsArray());
var_dump($data->get('langs.backend')->reverse()->getDataAsArray());
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
