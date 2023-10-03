# Объектный массив на PHP

`\Krugozor\Cover\CoverArray` - это базовый класс для удобной и гибкой работы с массивами в объектно-ориентированном
представлении. Фактически, это "объектный массив", которого так не хватает в PHP.

## Как это работает?

Вы можете создать класс, наследуемый от `CoverArray` или использовать `CoverArray` без наследования. 
Создадим класс нового типа, наследуемый от базового класса `CoverArray`:

```php
class NewTypeArray extends CoverArray
{}
```

Инстанцируем новый объект данного класса. Передадим в конструктор многомерный массив и посмотрим на структуру, которая
получится:

```php
$data = new NewTypeArray([
    'firstName' => 'Vasiliy',
    'lastName' => 'Ivanov',
    'langs' => [
        'backend' => ['PHP', 'MySql'],
        'frontend' => ['HTML', 'CSS 1', 'JavaScript', 'CSS 2', 'CSS3']
    ],
]);

var_dump($data);
```

Результат отладки:

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
            string(5) "CSS 1"
            [2]=>
            string(10) "JavaScript"
            [3]=>
            string(5) "CSS 2"
            [4]=>
            string(4) "CSS3"
          }
        }
      }
    }
  }
}
```

Как видно, произошло два крайне важных события:

1. Все переданные в конструктор массивы многомерного массива преобразовались в объекты текущего 
   класса (в данном случае `NewTypeArray`). 
   Это поведение гарантирует, что любой массив, попадающий в объект наследуемый от `CoverArray`,
   становится объектным массивом. 
   
2. Данные всех созданных объектов аккуратно сложились в protected-свойства `$data`, что обеспечивает инкапсуляцию данных
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
string(18) "CSS 1, CSS 2, CSS3"
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
  string(5) "CSS 1"
  [2]=>
  string(10) "JavaScript"
  [3]=>
  string(5) "CSS 2"
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
```
Результат:
```

```


Пример:
```php
```
Результат:
```

```


Пример:
```php
```
Результат:
```

```


Пример:
```php
```
Результат:
```

```


Пример:
```php
```
Результат:
```

```

