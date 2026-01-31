![Cover Array](logo.jpg)

**![](https://upload.wikimedia.org/wikipedia/en/thumb/a/a4/Flag_of_the_United_States.svg/23px-Flag_of_the_United_States.svg.png) [English documentation](README.md) ![](https://upload.wikimedia.org/wikipedia/en/thumb/a/a4/Flag_of_the_United_States.svg/23px-Flag_of_the_United_States.svg.png)**

---

## Состояние
### Статус тестов
| Версия PHP | Статус                                                                                                                                                                               |
|------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 8.0        | [![PHP 8.0](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml) |
| 8.1        | [![PHP 8.1](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml) |
| 8.2        | [![PHP 8.2](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml) |
| 8.3        | [![PHP 8.3](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml) |
| 8.4        | [![PHP 8.4](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml) |
| 8.5        | [![PHP 8.5](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml) |

### Покрытие кода
[![codecov](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection/branch/master/graph/badge.svg)](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection)

## Требования
PHP >= 8.0

## Установка
```
composer require krugozor/cover
```

# CoverArray: Объектно-ориентированная обёртка для PHP-массивов (PHP Collection)
Создано человеком, проверено и протестировано искусственным интеллектом. Релиз 2026

## Зачем был создан CoverArray

В современной PHP-разработке мы часто работаем с массивами как основной структурой данных. Однако нативные функции PHP для работы с массивами имеют ряд ограничений, которые решает CoverArray.

### Проблемы нативных PHP-массивов

- **Непоследовательные названия функций**: Некоторые функции используют подчёркивания (`array_map`), другие — нет (`usort`)
- **Различный порядок параметров**: Функции вроде `array_map($callback, $array)` против `array_filter($array, $callback)`
- **Отсутствие цепочек вызовов**: Нативные функции возвращают новые массивы, требуя промежуточных переменных
- **Ограниченная типобезопасность**: Нет автодополнения в IDE или поддержки статического анализа
- **Громоздкий синтаксис**: Сложные операции требуют вложенных вызовов функций

### Что решает CoverArray

CoverArray предоставляет чистый объектно-ориентированный интерфейс, оборачивающий PHP-массивы с сохранением полной совместимости с нативными функциями:

```php
// Данные: пользователи с возрастом и статусом
// Задача: получить имена активных пользователей старше 18 лет, отсортированных по убыванию рейтинга
$users = [
    ['name' => 'Alice', 'age' => 25, 'active' => true, 'score' => 85],
    ['name' => 'Bob', 'age' => 17, 'active' => false, 'score' => 45],
    ['name' => 'Charlie', 'age' => 32, 'active' => true, 'score' => 92],
    ['name' => 'Diana', 'age' => 19, 'active' => true, 'score' => 78],
    ['name' => 'Eve', 'age' => 22, 'active' => false, 'score' => 61],
];
```

#### До (нативный PHP):
```php
$filtered = array_filter($users, fn($u) => $u['active'] && $u['age'] >= 18);
$sorted = usort($filtered, fn($a, $b) => $b['score'] <=> $a['score']) ? $filtered : [];
$names = array_column($sorted, 'name');
$result = implode(', ', $names); // Charlie, Alice, Diana
```
#### После (CoverArray):
```php
// ВСЁ В ОДНУ СТРОКУ!
$result = CoverArray::fromArray($users)
    ->filter(fn($u) => $u->active && $u->age >= 18)
    ->usort(fn($a, $b) => $b->score <=> $a->score)
    ->values()
    ->column('name')
    ->implode(', '); // Charlie, Alice, Diana
```
### Ключевые преимущества
* **Без внешних зависимостей:** Чистая PHP-реализация, не требуются дополнительные пакеты
* **Единообразный API:** Все методы следуют паттерну `$array->method($arguments)`
* **Цепочки вызовов:** Объединяйте несколько операций в читаемом виде
* **Поддержка IDE:** Полное автодополнение и подсказки типов
* **Современный синтаксис:** Разработан для PHP 8.0+ со строгой типизацией
* **Точечная нотация:** Удобный доступ к вложенным данным через `$array->get('user.profile.name')`
* **Поддержка JSON:** Встроенная сериализация/десериализация
* **Иммутабельные операции:** Большинство методов возвращают новые экземпляры, сохраняя исходные данные
* **Полная совместимость:** Безупречно работает с существующим кодом на базе массивов

### Практические примеры использования

#### Пример 1: Управление конфигурацией с точечной нотацией
```php
// Загрузка и безопасный доступ к вложенной конфигурации
$config = CoverArray::fromJson(file_get_contents('config.json'));

// Прямой доступ к вложенным данным со значениями по умолчанию
$dbHost = $config->get('database.connections.mysql.host', fn($value) => $value ?? 'localhost');
$dbPort = $config->get('database.connections.mysql.port', fn($value) => $value ?? 3306);

// Доступ с callback для сложных значений по умолчанию
$apiKeys = $config->get('services.payment.keys', function($keys) {
    return $keys ?? CoverArray::fromArray([
        'public' => 'default_public_key',
        'secret' => 'default_secret_key'
    ]);
});
```

#### Пример 2: Конвейер обработки API-ответов
```php
// Реальная обработка API: фильтрация, трансформация и извлечение данных
$apiResponse = CoverArray::fromJson($httpResponse)
    ->get('data.users', function (mixed $users): CoverArray {
        if ($users === null) {
            return new CoverArray();
        }

        /** @var CoverArray $users */
        return $users
            ->filter(fn($u) => $u['active'] == '1' && $u['email_verified'])
            ->map(fn($u) => [
                'id' => $u['id'],
                'name' => $u['first_name'] . ' ' . $u['last_name'],
                'email' => strtolower($u['email']),
                'role' => $u['role'] ?? 'user'
            ])
            ->usort(fn($a, $b) => $a['name'] <=> $b['name']);
    });

// Извлечение определённых столбцов для выпадающего списка
$userOptions = $apiResponse->column('name', 'id')->getDataAsArray();
```

#### Пример 3: Обработка заказов интернет-магазина
```php
// Обработка заказов: расчёт статистики и генерация отчётов
$orders = CoverArray::fromArray($database->getOrders());

// Фильтрация завершённых крупных заказов за последний месяц
$recentOrders = $orders
    ->filter(fn($order) => $order['status'] === 'completed')
    ->filter(fn($order) => $order['amount'] > 100)
    ->filter(fn($order) => strtotime($order['date']) > strtotime('-30 days'));

// Расчёт бизнес-метрик
$totalRevenue = $recentOrders->column('amount')->sum();
$averageOrder = $totalRevenue / $recentOrders->count();
$topCustomers = $recentOrders
    ->map(fn($o) => ['customer' => $o['customer_name'], 'amount' => $o['amount']])
    ->usort(fn($a, $b) => $b['amount'] <=> $a['amount'])
    ->slice(0, 10);

echo "Выручка: $" . number_format($totalRevenue, 2) . "\n";
echo "Средний заказ: $" . number_format($averageOrder, 2) . "\n";
echo "Топ-покупатель: " . $topCustomers->first()['customer'];
```

#### Пример 4: Анализ логов и отчёты об ошибках
```php
// Парсинг логов приложения и выявление паттернов ошибок
$logLines = CoverArray::fromExplode("\n", file_get_contents('app.log'))
    ->filter(fn($line) => !empty(trim($line)));

// Извлечение и категоризация ошибок
$errors = $logLines
    ->filter(fn($line) => str_contains($line, 'ERROR'))
    ->map(function($line) {
        preg_match('/\[(.*?)\].*ERROR:\s*(\w+)\s*-\s*(.*)/', $line, $matches);
        return [
            'timestamp' => $matches[1] ?? 'Unknown',
            'type' => $matches[2] ?? 'General',
            'message' => $matches[3] ?? $line
        ];
    });

// Группировка по типу ошибки и подсчёт вхождений
$errorStats = $errors
    ->column('type')
    ->countValues()
    ->arsort(); // Сортировка по частоте

// Генерация отчёта об ошибках
$report = "Отчёт об ошибках:\n";
foreach ($errorStats as $type => $count) {
    $report .= "- {$type}: {$count} вхождений\n";
}

// Поиск последней критической ошибки
$lastCritical = $errors
    ->filter(fn($e) => $e['type'] === 'Critical')
    ->last();
```

CoverArray объединяет мощные функции PHP для работы с массивами и современные объектно-ориентированные практики, делая манипуляции с массивами более выразительными, поддерживаемыми и приятными.

## Таблица сравнения: методы CoverArray и функции PHP для массивов

<table><thead><tr><th><span>#</span></th><th><span>Функция PHP</span></th><th><span>Метод CoverArray</span></th><th><span>Статус</span></th><th><span>Примечания</span></th></tr></thead><tbody><tr><td><span>1</span></td><td><code>array_all</code></td><td><code>all()</code></td><td><span>✅</span></td><td><span>Реализован с полифилом для старых версий PHP</span></td></tr><tr><td><span>2</span></td><td><code>array_any</code></td><td><code>any()</code></td><td><span>✅</span></td><td><span>Реализован с полифилом для старых версий PHP</span></td></tr><tr><td><span>3</span></td><td><code>array_change_key_case</code></td><td><code>changeKeyCase()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>4</span></td><td><code>array_chunk</code></td><td><code>chunk()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>5</span></td><td><code>array_column</code></td><td><code>column()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>6</span></td><td><code>array_combine</code></td><td><code>combine()</code></td><td><span>✅</span></td><td><span>Полная реализация (статический метод)</span></td></tr><tr><td><span>7</span></td><td><code>array_count_values</code></td><td><code>countValues()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>8</span></td><td><code>array_diff</code></td><td><code>diff()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>9</span></td><td><code>array_diff_assoc</code></td><td><code>diffAssoc()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>10</span></td><td><code>array_diff_key</code></td><td><code>diffKey()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>11</span></td><td><code>array_diff_uassoc</code></td><td><code>diffUassoc()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>12</span></td><td><code>array_diff_ukey</code></td><td><code>diffUkey()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>13</span></td><td><code>array_fill</code></td><td><code>fill()</code></td><td><span>✅</span></td><td><span>Полная реализация (статический метод)</span></td></tr><tr><td><span>14</span></td><td><code>array_fill_keys</code></td><td><code>fillKeys()</code></td><td><span>✅</span></td><td><span>Полная реализация (статический метод)</span></td></tr><tr><td><span>15</span></td><td><code>array_filter</code></td><td><code>filter()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>16</span></td><td><code>array_find</code></td><td><code>find()</code></td><td><span>✅</span></td><td><span>Реализован с полифилом для старых версий PHP</span></td></tr><tr><td><span>17</span></td><td><code>array_find_key</code></td><td><code>findKey()</code></td><td><span>✅</span></td><td><span>Реализован с полифилом для старых версий PHP</span></td></tr><tr><td><span>18</span></td><td><code>array_first</code></td><td><code>first()</code></td><td><span>✅</span></td><td><span>Реализован с полифилом для старых версий PHP</span></td></tr><tr><td><span>19</span></td><td><code>array_flip</code></td><td><code>flip()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>20</span></td><td><code>array_intersect</code></td><td><code>intersect()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>21</span></td><td><code>array_intersect_assoc</code></td><td><code>intersectAssoc()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>22</span></td><td><code>array_intersect_key</code></td><td><code>intersectKey()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>23</span></td><td><code>array_intersect_uassoc</code></td><td><code>intersectUassoc()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>24</span></td><td><code>array_intersect_ukey</code></td><td><code>intersectUkey()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>25</span></td><td><code>array_is_list</code></td><td><code>isList()</code></td><td><span>✅</span></td><td><span>Реализован с полифилом для старых версий PHP</span></td></tr><tr><td><span>26</span></td><td><code>array_key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>27</span></td><td><code>array_key_first</code></td><td><code>keyFirst()</code></td><td><span>✅</span></td><td><span>Использует встроенную функцию</span></td></tr><tr><td><span>28</span></td><td><code>array_key_last</code></td><td><code>keyLast()</code></td><td><span>✅</span></td><td><span>Использует встроенную функцию</span></td></tr><tr><td><span>29</span></td><td><code>array_keys</code></td><td><code>keys()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>30</span></td><td><code>array_last</code></td><td><code>last()</code></td><td><span>✅</span></td><td><span>Реализован с полифилом для старых версий PHP</span></td></tr><tr><td><span>31</span></td><td><code>array_map</code></td><td><code>map()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>32</span></td><td><code>array_merge</code></td><td><code>merge()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>33</span></td><td><code>array_merge_recursive</code></td><td><code>mergeRecursive()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>34</span></td><td><code>array_multisort</code></td><td><code>multisort()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>35</span></td><td><code>array_pad</code></td><td><code>pad()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>36</span></td><td><code>array_pop</code></td><td><code>pop()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>37</span></td><td><code>array_product</code></td><td><code>product()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>38</span></td><td><code>array_push</code></td><td><code>push()</code><span> / </span><code>append()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>39</span></td><td><code>array_rand</code></td><td><code>rand()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>40</span></td><td><code>array_reduce</code></td><td><code>reduce()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>41</span></td><td><code>array_replace</code></td><td><code>replace()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>42</span></td><td><code>array_replace_recursive</code></td><td><code>replaceRecursive()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>43</span></td><td><code>array_reverse</code></td><td><code>reverse()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>44</span></td><td><code>array_search</code></td><td><code>search()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>45</span></td><td><code>array_shift</code></td><td><code>shift()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>46</span></td><td><code>array_slice</code></td><td><code>slice()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>47</span></td><td><code>array_splice</code></td><td><code>splice()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>48</span></td><td><code>array_sum</code></td><td><code>sum()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>49</span></td><td><code>array_udiff</code></td><td><code>udiff()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>50</span></td><td><code>array_udiff_assoc</code></td><td><code>udiffAssoc()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>51</span></td><td><code>array_udiff_uassoc</code></td><td><code>udiffUassoc()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>52</span></td><td><code>array_uintersect</code></td><td><code>uintersect()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>53</span></td><td><code>array_uintersect_assoc</code></td><td><code>uintersectAssoc()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>54</span></td><td><code>array_uintersect_uassoc</code></td><td><code>uintersectUassoc()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>55</span></td><td><code>array_unique</code></td><td><code>unique()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>56</span></td><td><code>array_unshift</code></td><td><code>unshift()</code><span> / </span><code>prepend()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>57</span></td><td><code>array_values</code></td><td><code>values()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>58</span></td><td><code>array_walk</code></td><td><code>walk()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>59</span></td><td><code>array_walk_recursive</code></td><td><code>walkRecursive()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>60</span></td><td><code>arsort</code></td><td><code>arsort()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>61</span></td><td><code>asort</code></td><td><code>asort()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>62</span></td><td><code>compact</code></td><td><code>compact()</code></td><td><span>⚠️</span></td><td><span>Нереализуем (ограничения области видимости PHP). Используйте: <code>CoverArray::fromArray(compact(...))</code></span></td></tr><tr><td><span>63</span></td><td><code>count</code></td><td><code>count()</code></td><td><span>✅</span></td><td><span>Реализация интерфейса Countable</span></td></tr><tr><td><span>64</span></td><td><code>current</code></td><td><code>current()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>65</span></td><td><code>end</code></td><td><code>end()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>66</span></td><td><code>extract</code></td><td><code>extract()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>67</span></td><td><code>in_array</code></td><td><code>in()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>68</span></td><td><code>key</code></td><td><code>key()</code></td><td><span>✅</span></td><td><span>Полная реализация</span></td></tr><tr><td><span>69</span></td><td><code>key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>Полная реализация (аналог array_key_exists)</span></td></tr><tr><td><span>70</span></td><td><code>krsort</code></td><td><code>krsort()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>71</span></td><td><code>ksort</code></td><td><code>ksort()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>72</span></td><td><code>list</code></td><td><code>list()</code></td><td><span>⚠️</span></td><td><span>Частичная реализация (ограничения языковой конструкции)</span></td></tr><tr><td><span>73</span></td><td><code>natcasesort</code></td><td><code>natcasesort()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>74</span></td><td><code>natsort</code></td><td><code>natsort()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>75</span></td><td><code>next</code></td><td><code>next()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>76</span></td><td><code>pos</code></td><td><code>pos()</code></td><td><span>✅</span></td><td><span>Псевдоним <code>current()</code></span></td></tr><tr><td><span>77</span></td><td><code>prev</code></td><td><code>prev()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>78</span></td><td><code>range</code></td><td><code>range()</code></td><td><span>✅</span></td><td><span>Полная реализация (статический метод)</span></td></tr><tr><td><span>79</span></td><td><code>reset</code></td><td><code>reset()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>80</span></td><td><code>rsort</code></td><td><code>rsort()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>81</span></td><td><code>shuffle</code></td><td><code>shuffle()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>82</span></td><td><code>sort</code></td><td><code>sort()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>83</span></td><td><code>uasort</code></td><td><code>uasort()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>84</span></td><td><code>uksort</code></td><td><code>uksort()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>85</span></td><td><code>usort</code></td><td><code>usort()</code></td><td><span>✅</span></td><td><span>Полная реализация (мутирующий)</span></td></tr><tr><td><span>-</span></td><td><span>Дополнительный метод</span></td><td><code>each()</code></td><td><span>⭐</span></td><td><span><strong>Не эквивалентен оригинальной PHP-функции <code>each()</code></strong>. Собственный метод CoverArray для иммутабельной трансформации с сохранением ключей</span></td></tr><tr><td><span>-</span></td><td><span>Дополнительный метод</span></td><td><code>eachRecursive()</code></td><td><span>⭐</span></td><td><span>Собственный метод CoverArray для рекурсивной иммутабельной трансформации</span></td></tr></tbody></table>

### Дополнительные методы CoverArray

<table><thead><tr><th><span>Метод</span></th><th><span>Назначение</span></th><th><span>Доступ</span></th></tr></thead><tbody><tr><td><code>__clone()</code></td><td><span>Создаёт поверхностную копию с глубоким клонированием непосредственных свойств-объектов</span></td><td><span>Магический</span></td></tr><tr><td><code>__get()</code></td><td><span>Получает значение свойства через синтаксис свойств объекта</span></td><td><span>Магический</span></td></tr><tr><td><code>__isset()</code></td><td><span>Проверяет, установлено ли свойство</span></td><td><span>Магический</span></td></tr><tr><td><code>__serialize()</code></td><td><span>Сериализует объект для сериализации</span></td><td><span>Магический</span></td></tr><tr><td><code>__set()</code></td><td><span>Устанавливает значение свойства через синтаксис свойств объекта</span></td><td><span>Магический</span></td></tr><tr><td><code>__toString()</code></td><td><span>Возвращает строковое представление объекта</span></td><td><span>Магический</span></td></tr><tr><td><code>__unserialize()</code></td><td><span>Десериализует объект из сериализованных данных</span></td><td><span>Магический</span></td></tr><tr><td><code>__unset()</code></td><td><span>Удаляет свойство</span></td><td><span>Магический</span></td></tr><tr><td><code>clear()</code></td><td><span>Очищает все данные</span></td><td><span>Публичный</span></td></tr><tr><td><code>copy()</code></td><td><span>Создаёт и возвращает копию текущего экземпляра объекта</span></td><td><span>Публичный</span></td></tr><tr><td><code>fromArray()</code></td><td><span>Создаёт CoverArray из нативного PHP-массива</span></td><td><span>Публичный статический</span></td></tr><tr><td><code>fromExplode()</code></td><td><span>Создаёт CoverArray из строки с помощью explode()</span></td><td><span>Публичный статический</span></td></tr><tr><td><code>fromJson()</code></td><td><span>Создаёт экземпляр CoverArray из JSON-строки</span></td><td><span>Публичный статический</span></td></tr><tr><td><code>get()</code></td><td><span>Возвращает данные по ключам текущего объекта с использованием точечной нотации</span></td><td><span>Публичный</span></td></tr><tr><td><code>getDataAsArray()</code></td><td><span>Возвращает данные текущего объекта в виде нативного PHP-массива</span></td><td><span>Публичный</span></td></tr><tr><td><code>getIterator()</code></td><td><span>Возвращает итератор для массива (интерфейс IteratorAggregate)</span></td><td><span>Публичный</span></td></tr><tr><td><code>implode()</code></td><td><span>Объединяет элементы массива строкой</span></td><td><span>Публичный</span></td></tr><tr><td><code>isEmpty()</code></td><td><span>Проверяет, пуст ли массив</span></td><td><span>Публичный</span></td></tr><tr><td><code>item()</code></td><td><span>Возвращает элемент коллекции с указанным индексом как результат</span></td><td><span>Публичный</span></td></tr><tr><td><code>jsonSerialize()</code></td><td><span>Определяет данные для сериализации в JSON (интерфейс JsonSerializable)</span></td><td><span>Публичный</span></td></tr><tr><td><code>offsetExists()</code></td><td><span>Проверяет, существует ли указанное смещение в массиве (интерфейс ArrayAccess)</span></td><td><span>Публичный</span></td></tr><tr><td><code>offsetGet()</code></td><td><span>Возвращает значение по указанному смещению (интерфейс ArrayAccess)</span></td><td><span>Публичный</span></td></tr><tr><td><code>offsetSet()</code></td><td><span>Устанавливает значение по указанному смещению (интерфейс ArrayAccess)</span></td><td><span>Публичный</span></td></tr><tr><td><code>offsetUnset()</code></td><td><span>Удаляет значение по указанному смещению (интерфейс ArrayAccess)</span></td><td><span>Публичный</span></td></tr><tr><td><code>setData()</code></td><td><span>Устанавливает внутренние данные для CoverArray</span></td><td><span>Публичный</span></td></tr><tr><td><code>toJson()</code></td><td><span>Преобразует CoverArray в JSON-строку</span></td><td><span>Публичный</span></td></tr></tbody></table>
