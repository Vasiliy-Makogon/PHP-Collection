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
