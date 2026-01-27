# CLAUDE.md

Этот файл содержит руководство для Claude Code (claude.ai/code) при работе с кодом в этом репозитории.

## Обзор проекта

CoverArray — это PHP-библиотека, предоставляющая объектно-ориентированную обёртку для PHP-массивов. Реализует нативные функции PHP для работы с массивами в виде цепочечных методов, добавляя такие возможности как доступ через точечную нотацию и сериализация в JSON.

**Пакет:** `krugozor/cover`
**Пространство имён:** `Krugozor\Cover`
**Требования:** PHP >= 8.0

## Команды

### Запуск всех тестов
```bash
vendor/bin/phpunit
```

### Запуск одного тестового файла
```bash
vendor/bin/phpunit tests/unit/CoverArrayPhpEquivalentMethods/FilterTest.php
```

### Запуск конкретного тестового метода
```bash
vendor/bin/phpunit --filter testMethodName
```

### Запуск тестов с покрытием кода
```bash
vendor/bin/phpunit --coverage-html html-coverage
```

### Установка зависимостей
```bash
composer install
```

## Архитектура

### Исходные файлы (`src/`)

- **CoverArray.php** — Основной класс, реализующий интерфейсы `IteratorAggregate`, `Countable`, `ArrayAccess`, `JsonSerializable` и `Stringable`. Оборачивает функции PHP для массивов в цепочечные ООП-методы.
- **Simple.php** — Трейт, предоставляющий базовую функциональность работы с массивами (магические методы `__get`, `__set`, `__isset`, `__unset` и хранение данных). Используется классом `CoverArray`.

### Организация тестов (`tests/unit/`)

Тесты организованы по категориям методов:
- `CoverArrayCoreMethods/` — Тесты основной функциональности (item, setData, clear, магические методы)
- `CoverArrayPhpEquivalentMethods/` — Тесты методов, соответствующих функциям PHP для массивов
- `CoverArrayPrivateMethods/` — Тесты внутренних методов

### Ключевые паттерны проектирования

- **Иммутабельные операции**: Большинство методов возвращают новые экземпляры `CoverArray`, сохраняя исходные данные
- **Мутирующие методы**: Методы сортировки (`sort`, `usort`, `arsort` и др.), `pop`, `shift`, `push`, `walk` изменяют объект на месте
- **Статические фабричные методы**: `fromArray()`, `fromJson()`, `fromExplode()`, `combine()`, `fill()`, `fillKeys()`, `range()`
- **Точечная нотация**: Метод `get()` поддерживает вложенный доступ, например `$array->get('user.profile.name')`
- **Полифиллы**: Методы `all()`, `any()`, `find()`, `findKey()`, `first()`, `last()`, `isList()` включают полифиллы для старых версий PHP

## Правила написания тестов

1. **Сравнение с оригинальной функцией PHP**: В тестах необходимо проверять, что вызов оригинальной функции PHP и вызов метода-аналога из CoverArray возвращают одинаковые результаты.

```php
$data = ['apple', 'banana', 'apple', 'orange', 'banana', 'apple'];
$expected = array_count_values($data);
$cover = new CoverArray($data);
$result = $cover->countValues();
$this->assertSame($expected, $result->getDataAsArray());
```

2. **Тестирование аргументов `CoverArray|array`**: Если метод принимает `CoverArray|array`, необходимо тестировать оба варианта отдельно:

```php
$data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
$diff = ['a' => 'apricot', 'c' => 'coconut'];
$expected = array_diff_key($data, $diff);
$cover = new CoverArray($data);

// arguments as array
$this->assertSame($expected, $cover->diffKey($diff)->getDataAsArray());

// arguments as CoverArray
$this->assertSame($expected, $cover->diffKey(new CoverArray($diff))->getDataAsArray());
```

3. **Не проверять неизменяемость исходного массива**: Тесты на то, что `$this->data` не изменяется — писать не нужно.

4. **Не проверять результат оригинальной функции сам с собой**: Избегать конструкций вида:
```php
$expected = array_count_values($data);
$this->assertSame($expected, $expected); // НЕ нужно
```

5. **Полифиллы не сравниваются с оригиналом**: Для методов `all()`, `any()`, `find()`, `findKey()`, `first()`, `last()`, `isList()` (полифиллы для `array_all`, `array_any`, `array_find`, `array_find_key`, `array_first`, `array_is_list`, `array_last`) оригинальную функцию PHP не тестируем, только метод CoverArray.

6. **PHPDoc комментарии**: Для каждого теста пишется комментарий на английском и русском языке:
```php
/**
 * Tests the diffKey() method (array_diff_key equivalent).
 *
 * This test verifies that the diffKey() method correctly computes
 * the difference of arrays using keys for comparison.
 *
 * Тестирование метода diffKey() (эквивалент array_diff_key).
 *
 * Этот тест проверяет, что метод diffKey() корректно вычисляет
 * расхождение массивов, используя ключи для сравнения.
 *
 * @see CoverArray::diffKey()
 * @see array_diff_key()
 */
```

7. **Один кейс — один метод**: Каждый отдельный кейс тестирования — отдельный метод класса теста.

8. **CoverArray как тип данных**: При тестировании методов с mixed-аргументами также нужно тестировать передачу CoverArray как аргумента.
