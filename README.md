# Cover
`\Krugozor\Cover\CoverArray` - это базовый класс для удобной и гибкой работы с массивами в объектно-ориентированном представлении. Фактически, это "объектный массив". Объекты, производные от `CoverArray` имплементируют PHP-интерфейсы `\IteratorAggregate, \Countable, \ArrayAccess, \Serializable`, для них реализованы магические методы `__set`, `__get`, `__isset`, `__unset` и другие.   

## Как это работает? 

Вы можете создать класс, наследуемый от `CoverArray` или использовать `CoverArray` без наследования. Создадим класс нового типа, наследуемый от базового класса `CoverArray`: 

```php
class NewType extends CoverArray
{}
```
Инстанцируем новый объект данного класса. Передадим в конструктор многомерный массив и посмотрим на структуру, которая получится: 

```php
$data = [
    'name' => 'Vasiliy',
    'age' => 35,
    'langs' => [
        'backend' => ['php'],
        'frontend' => ['js', 'html']
    ]
];

$cover = new CoverArray($data);
var_dump($cover);
```
результат отладки: 
```
object(NewType)#1 (1) {
  ["data":protected]=>
  array(3) {
    ["name"]=>
    string(7) "Vasiliy"
    ["age"]=>
    int(35)
    ["langs"]=>
    object(NewType)#2 (1) {
      ["data":protected]=>
      array(2) {
        ["backend"]=>
        object(NewType)#3 (1) {
          ["data":protected]=>
          array(1) {
            [0]=>
            string(3) "php"
          }
        }
        ["frontend"]=>
        object(NewType)#4 (1) {
          ["data":protected]=>
          array(2) {
            [0]=>
            string(2) "js"
            [1]=>
            string(4) "html"
          }
        }
      }
    }
  }
}
```
Как видно, произошло два крайне важных события: 
1. Все переданные в конструктор массивы многомерного массива преобразовались в объекты текущего класса (в данном случае -- `NewType`).
2. Данные всех созданных объектов аккуратно сложились в protected-свойства `$data`, что обеспечивает инкапсуляцию данных и возможность реализации любых методов над ними.

Давайте попробуем поработать с данными.

### Методы трейта \Krugozor\Cover\Simple

Трейт `\Krugozor\Cover\Simple` является неотъемлемой частью данного решения, но *может использоваться отдельно, когда не нужен дополнительный функционал всей библиотеки*. Методы, описанные в этой части документации, реализованы исключительно в трейте `\Krugozor\Cover\Simple`. 

#### __set __get

Добавим в объект `$cover` новое свойство `address` и получим его значение:
```php
$cover->address = 'Moscow, Russian Federation';
var_dump($cover->address);
```
результат отладки: 
```
string(26) "Moscow, Russian Federation"
```

#### __isset __unset
Проверим наличие свойства `address`, а затем удалим его:
```php
if (isset($cover->address)) {
    unset($cover->address);
    var_dump($cover->address);
}
```
результат отладки:
```
NULL
```

#### setData
Наполним объект `$cover` некоторыми новыми свойствами:

```php
$cover->setData([
    'gender' => 'Male', 
    'height' => 180, 
    'weight' => 85
]);
var_dump($cover);
```
результат отладки:
```
object(NewType)#1 (1) {
  ["data":protected]=>
  array(6) {
    ["name"]=>
    string(7) "Vasiliy"
    ["age"]=>
    int(35)
    ["langs"]=>
    object(NewType)#2 (1) {
      ["data":protected]=>
      array(2) {
        ["backend"]=>
        object(NewType)#3 (1) {
          ["data":protected]=>
          array(1) {
            [0]=>
            string(3) "php"
          }
        }
        ["frontend"]=>
        object(NewType)#4 (1) {
          ["data":protected]=>
          array(2) {
            [0]=>
            string(2) "js"
            [1]=>
            string(4) "html"
          }
        }
      }
    }
    ["gender"]=>
    string(4) "Male"
    ["height"]=>
    int(180)
    ["weight"]=>
    int(85)
  }
}
```

#### item
Получим из объекта `$cover->langs->backend` значение первого элемента, обратившись по индексу:
```php
var_dump($cover->langs->backend->item(0));
```
результат отладки:
```
string(3) "php"
```
метод можно использовать и для получения свойств по строковому ключу:
```php
var_dump($cover->langs->frontend);
```
результат отладки:
```
object(NewType)#4 (1) {
  ["data":protected]=>
  array(2) {
    [0]=>
    string(2) "js"
    [1]=>
    string(4) "html"
  }
}
```

#### clear

Метод очищает protected-свойство `$data` у вызванного объекта. Полностью очистим данные объекта `$cover->langs->frontend`: 
```php
$cover->langs->frontend->clear();
var_dump($cover->langs->frontend);
```
результат отладки:
```
object(NewType)#4 (1) {
  ["data":protected]=>
  array(0) {
  }
}
```

### Методы класса \Krugozor\Cover\CoverArray