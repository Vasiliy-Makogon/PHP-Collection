![Cover Array](docs/logo.jpg)

**Other languages:**
- [Русская документация](docs/README_ru.md)
- [Documentation française](docs/README_fr.md)
- [Deutsche Dokumentation](docs/README_de.md)
- [Documentazione italiana](docs/README_it.md)
- [日本語ドキュメント](docs/README_jp.md)
- [Documentación en español](docs/README_es.md)
- [한국어 문서](docs/README_kr.md)
- [简体中文文档](docs/README_cn.md)
- [繁體中文文件](docs/README_tw.md)
- [Dokumentasi Bahasa Indonesia](docs/README_id.md)
- [Documentação em Português (BR)](docs/README_br.md)
- [हिंदी दस्तावेज़](docs/README_hi.md)
- [التوثيق بالعربية](docs/README_ar.md)
- [Türkçe Dokümantasyon](docs/README_tr.md)
- [Tài liệu tiếng Việt](docs/README_vi.md)

---

## State
### Test Status
| PHP Version | Status                                                                                                                                                                               |
|-------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 8.0         | [![PHP 8.0](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml) |
| 8.1         | [![PHP 8.1](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml) |
| 8.2         | [![PHP 8.2](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml) |
| 8.3         | [![PHP 8.3](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml) |
| 8.4         | [![PHP 8.4](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml) |
| 8.5         | [![PHP 8.5](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml) |

### Code Coverage
[![codecov](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection/branch/master/graph/badge.svg)](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection)

## Requirements
PHP >= 8.0

## Installation
```
composer require krugozor/cover
```

# CoverArray: Object-Oriented Array Wrapper for PHP (PHP Collection)
Created by human, verified and tested by artificial intelligence. Release 2026

## Why CoverArray Was Created

In modern PHP development, we often work with arrays as the primary data structure. However, PHP's native array functions have several limitations that CoverArray solves.

### The Problem with Native PHP Arrays

- **Inconsistent function naming**: Some functions use underscores (`array_map`), others don't (`usort`)
- **Mixed parameter orders**: Functions like `array_map($callback, $array)` vs `array_filter($array, $callback)`
- **No method chaining**: Native functions return new arrays, requiring intermediate variables
- **Limited type safety**: No IDE autocompletion or static analysis support
- **Verbose syntax**: Complex operations require nested function calls

### What CoverArray Solves

CoverArray provides a clean, object-oriented interface that wraps PHP arrays while maintaining full compatibility with native functions:

```php
// Data: users with age and status
// Task: get names of active users over 18, sorted by descending score
$users = [
    ['name' => 'Alice', 'age' => 25, 'active' => true, 'score' => 85],
    ['name' => 'Bob', 'age' => 17, 'active' => false, 'score' => 45],
    ['name' => 'Charlie', 'age' => 32, 'active' => true, 'score' => 92],
    ['name' => 'Diana', 'age' => 19, 'active' => true, 'score' => 78],
    ['name' => 'Eve', 'age' => 22, 'active' => false, 'score' => 61],
];
```

#### Before (Native PHP):
```php
$filtered = array_filter($users, fn($u) => $u['active'] && $u['age'] >= 18);
$sorted = usort($filtered, fn($a, $b) => $b['score'] <=> $a['score']) ? $filtered : [];
$names = array_column($sorted, 'name');
$result = implode(', ', $names); // Charlie, Alice, Diana
```
#### After (CoverArray):
```php
// EVERYTHING IN ONE LINE!
$result = CoverArray::fromArray($users)
    ->filter(fn($u) => $u->active && $u->age >= 18)
    ->usort(fn($a, $b) => $b->score <=> $a->score)
    ->values()
    ->column('name')
    ->implode(', '); // Charlie, Alice, Diana
```
### Key Benefits
* **No External Dependencies:** Pure PHP implementation, no additional packages required
* **Consistent API:** All methods follow `$array->method($arguments)` pattern
* **Method Chaining:** Chain multiple operations in a readable way
* **IDE Support:** Full autocompletion and type hints
* **Modern Syntax:** Designed for PHP 8.0+ with strict typing
* **Dot Notation:** Easy nested data access with `$array->get('user.profile.name')`
* **JSON Support:** Built-in serialization/deserialization
* **Immutable Operations:** Most methods return new instances, preserving original data
* **Full Compatibility:** Works seamlessly with existing array-based code

### Real-World Use Cases

#### Example 1: Configuration Management with Dot Notation
```php
// Load and access nested configuration safely
$config = CoverArray::fromJson(file_get_contents('config.json'));

// Direct nested access with default fallbacks
$dbHost = $config->get('database.connections.mysql.host', fn($value) => $value ?? 'localhost');
$dbPort = $config->get('database.connections.mysql.port', fn($value) => $value ?? 3306);

// Access with callback for complex defaults
$apiKeys = $config->get('services.payment.keys', function($keys) {
    return $keys ?? CoverArray::fromArray([
        'public' => 'default_public_key',
        'secret' => 'default_secret_key'
    ]);
});
```

#### Example 2: API Response Processing Pipeline
```php
// Real-world API processing: filter, transform, and extract data
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

// Extract specific columns for dropdown
$userOptions = $apiResponse->column('name', 'id')->getDataAsArray();
```

#### Example 3: Log Analysis and Error Reporting
```php
// Parse application logs and extract error patterns
$logLines = CoverArray::fromExplode("\n", file_get_contents('app.log'))
    ->filter(fn($line) => !empty(trim($line)));

// Extract and categorize errors
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

// Group by error type and count occurrences
$errorStats = $errors
    ->column('type')
    ->countValues()
    ->arsort(); // Sort by frequency

// Generate error report
$report = "Error Report:\n";
foreach ($errorStats as $type => $count) {
    $report .= "- {$type}: {$count} occurrences\n";
}

// Find most recent critical error
$lastCritical = $errors
    ->filter(fn($e) => $e['type'] === 'Critical')
    ->last();
```

CoverArray bridges the gap between PHP's powerful array functions and modern object-oriented practices, making array manipulation more expressive, maintainable, and enjoyable.

## Comparison Table: CoverArray Methods vs PHP Array Functions

<table><thead><tr><th><span>#</span></th><th><span>PHP Function</span></th><th><span>CoverArray Method</span></th><th><span>Status</span></th><th><span>Notes</span></th></tr></thead><tbody><tr><td><span>1</span></td><td><code>array_all</code></td><td><code>all()</code></td><td><span>✅</span></td><td><span>Implemented with polyfill for older PHP versions</span></td></tr><tr><td><span>2</span></td><td><code>array_any</code></td><td><code>any()</code></td><td><span>✅</span></td><td><span>Implemented with polyfill for older PHP versions</span></td></tr><tr><td><span>3</span></td><td><code>array_change_key_case</code></td><td><code>changeKeyCase()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>4</span></td><td><code>array_chunk</code></td><td><code>chunk()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>5</span></td><td><code>array_column</code></td><td><code>column()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>6</span></td><td><code>array_combine</code></td><td><code>combine()</code></td><td><span>✅</span></td><td><span>Full implementation (static method)</span></td></tr><tr><td><span>7</span></td><td><code>array_count_values</code></td><td><code>countValues()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>8</span></td><td><code>array_diff</code></td><td><code>diff()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>9</span></td><td><code>array_diff_assoc</code></td><td><code>diffAssoc()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>10</span></td><td><code>array_diff_key</code></td><td><code>diffKey()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>11</span></td><td><code>array_diff_uassoc</code></td><td><code>diffUassoc()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>12</span></td><td><code>array_diff_ukey</code></td><td><code>diffUkey()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>13</span></td><td><code>array_fill</code></td><td><code>fill()</code></td><td><span>✅</span></td><td><span>Full implementation (static method)</span></td></tr><tr><td><span>14</span></td><td><code>array_fill_keys</code></td><td><code>fillKeys()</code></td><td><span>✅</span></td><td><span>Full implementation (static method)</span></td></tr><tr><td><span>15</span></td><td><code>array_filter</code></td><td><code>filter()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>16</span></td><td><code>array_find</code></td><td><code>find()</code></td><td><span>✅</span></td><td><span>Implemented with polyfill for older PHP versions</span></td></tr><tr><td><span>17</span></td><td><code>array_find_key</code></td><td><code>findKey()</code></td><td><span>✅</span></td><td><span>Implemented with polyfill for older PHP versions</span></td></tr><tr><td><span>18</span></td><td><code>array_first</code></td><td><code>first()</code></td><td><span>✅</span></td><td><span>Implemented with polyfill for older PHP versions</span></td></tr><tr><td><span>19</span></td><td><code>array_flip</code></td><td><code>flip()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>20</span></td><td><code>array_intersect</code></td><td><code>intersect()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>21</span></td><td><code>array_intersect_assoc</code></td><td><code>intersectAssoc()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>22</span></td><td><code>array_intersect_key</code></td><td><code>intersectKey()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>23</span></td><td><code>array_intersect_uassoc</code></td><td><code>intersectUassoc()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>24</span></td><td><code>array_intersect_ukey</code></td><td><code>intersectUkey()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>25</span></td><td><code>array_is_list</code></td><td><code>isList()</code></td><td><span>✅</span></td><td><span>Implemented with polyfill for older PHP versions</span></td></tr><tr><td><span>26</span></td><td><code>array_key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>27</span></td><td><code>array_key_first</code></td><td><code>keyFirst()</code></td><td><span>✅</span></td><td><span>Uses built-in function</span></td></tr><tr><td><span>28</span></td><td><code>array_key_last</code></td><td><code>keyLast()</code></td><td><span>✅</span></td><td><span>Uses built-in function</span></td></tr><tr><td><span>29</span></td><td><code>array_keys</code></td><td><code>keys()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>30</span></td><td><code>array_last</code></td><td><code>last()</code></td><td><span>✅</span></td><td><span>Implemented with polyfill for older PHP versions</span></td></tr><tr><td><span>31</span></td><td><code>array_map</code></td><td><code>map()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>32</span></td><td><code>array_merge</code></td><td><code>merge()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>33</span></td><td><code>array_merge_recursive</code></td><td><code>mergeRecursive()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>34</span></td><td><code>array_multisort</code></td><td><code>multisort()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>35</span></td><td><code>array_pad</code></td><td><code>pad()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>36</span></td><td><code>array_pop</code></td><td><code>pop()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>37</span></td><td><code>array_product</code></td><td><code>product()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>38</span></td><td><code>array_push</code></td><td><code>push()</code><span> / </span><code>append()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>39</span></td><td><code>array_rand</code></td><td><code>rand()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>40</span></td><td><code>array_reduce</code></td><td><code>reduce()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>41</span></td><td><code>array_replace</code></td><td><code>replace()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>42</span></td><td><code>array_replace_recursive</code></td><td><code>replaceRecursive()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>43</span></td><td><code>array_reverse</code></td><td><code>reverse()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>44</span></td><td><code>array_search</code></td><td><code>search()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>45</span></td><td><code>array_shift</code></td><td><code>shift()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>46</span></td><td><code>array_slice</code></td><td><code>slice()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>47</span></td><td><code>array_splice</code></td><td><code>splice()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>48</span></td><td><code>array_sum</code></td><td><code>sum()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>49</span></td><td><code>array_udiff</code></td><td><code>udiff()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>50</span></td><td><code>array_udiff_assoc</code></td><td><code>udiffAssoc()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>51</span></td><td><code>array_udiff_uassoc</code></td><td><code>udiffUassoc()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>52</span></td><td><code>array_uintersect</code></td><td><code>uintersect()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>53</span></td><td><code>array_uintersect_assoc</code></td><td><code>uintersectAssoc()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>54</span></td><td><code>array_uintersect_uassoc</code></td><td><code>uintersectUassoc()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>55</span></td><td><code>array_unique</code></td><td><code>unique()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>56</span></td><td><code>array_unshift</code></td><td><code>unshift()</code><span> / </span><code>prepend()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>57</span></td><td><code>array_values</code></td><td><code>values()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>58</span></td><td><code>array_walk</code></td><td><code>walk()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>59</span></td><td><code>array_walk_recursive</code></td><td><code>walkRecursive()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>60</span></td><td><code>arsort</code></td><td><code>arsort()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>61</span></td><td><code>asort</code></td><td><code>asort()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>62</span></td><td><code>compact</code></td><td><code>compact()</code></td><td><span>⚠️</span></td><td><span>Not implementable (PHP scope limitations). Use: <code>CoverArray::fromArray(compact(...))</code></span></td></tr><tr><td><span>63</span></td><td><code>count</code></td><td><code>count()</code></td><td><span>✅</span></td><td><span>Implementation of Countable interface</span></td></tr><tr><td><span>64</span></td><td><code>current</code></td><td><code>current()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>65</span></td><td><code>end</code></td><td><code>end()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>66</span></td><td><code>extract</code></td><td><code>extract()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>67</span></td><td><code>in_array</code></td><td><code>in()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>68</span></td><td><code>key</code></td><td><code>key()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>69</span></td><td><code>key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>Full implementation (same as array_key_exists)</span></td></tr><tr><td><span>70</span></td><td><code>krsort</code></td><td><code>krsort()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>71</span></td><td><code>ksort</code></td><td><code>ksort()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>72</span></td><td><code>list</code></td><td><code>list()</code></td><td><span>⚠️</span></td><td><span>Not implementable (language construct). Use: <code>list($a, $b) = $cover->getDataAsArray()</code></span></td></tr><tr><td><span>73</span></td><td><code>natcasesort</code></td><td><code>natcasesort()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>74</span></td><td><code>natsort</code></td><td><code>natsort()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>75</span></td><td><code>next</code></td><td><code>next()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>76</span></td><td><code>pos</code></td><td><code>pos()</code></td><td><span>✅</span></td><td><span>Alias of <code>current()</code></span></td></tr><tr><td><span>77</span></td><td><code>prev</code></td><td><code>prev()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>78</span></td><td><code>range</code></td><td><code>range()</code></td><td><span>✅</span></td><td><span>Full implementation (static method)</span></td></tr><tr><td><span>79</span></td><td><code>reset</code></td><td><code>reset()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>80</span></td><td><code>rsort</code></td><td><code>rsort()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>81</span></td><td><code>shuffle</code></td><td><code>shuffle()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>82</span></td><td><code>sort</code></td><td><code>sort()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>83</span></td><td><code>uasort</code></td><td><code>uasort()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>84</span></td><td><code>uksort</code></td><td><code>uksort()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>85</span></td><td><code>usort</code></td><td><code>usort()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr></tbody></table>

### Additional CoverArray Methods

<table><thead><tr><th><span>Method</span></th><th><span>Purpose</span></th><th><span>Access</span></th></tr></thead><tbody><tr><td><code>__clone()</code></td><td><span>Creates a shallow copy with deep cloning of immediate object properties</span></td><td><span>Magic</span></td></tr><tr><td><code>__get()</code></td><td><span>Gets a property value using object property syntax</span></td><td><span>Magic</span></td></tr><tr><td><code>__isset()</code></td><td><span>Checks if a property is set</span></td><td><span>Magic</span></td></tr><tr><td><code>__serialize()</code></td><td><span>Serializes the object for serialization</span></td><td><span>Magic</span></td></tr><tr><td><code>__set()</code></td><td><span>Sets a property value using object property syntax</span></td><td><span>Magic</span></td></tr><tr><td><code>__toString()</code></td><td><span>Returns a string representation of the object</span></td><td><span>Magic</span></td></tr><tr><td><code>__unserialize()</code></td><td><span>Unserializes the object from serialized data</span></td><td><span>Magic</span></td></tr><tr><td><code>__unset()</code></td><td><span>Unsets a property</span></td><td><span>Magic</span></td></tr><tr><td><code>clear()</code></td><td><span>Clears all data</span></td><td><span>Public</span></td></tr><tr><td><code>copy()</code></td><td><span>Creates and returns a copy of the current object instance</span></td><td><span>Public</span></td></tr><tr><td><code>each()</code></td><td><span>Applies a callback to each element and returns a new instance with preserved keys (immutable, non-recursive)</span></td><td><span>Public</span></td></tr><tr><td><code>eachRecursive()</code></td><td><span>Recursively applies a callback to each element and returns a new instance (immutable, recursive)</span></td><td><span>Public</span></td></tr><tr><td><code>fromArray()</code></td><td><span>Creates a CoverArray from a native PHP array</span></td><td><span>Public Static</span></td></tr><tr><td><code>fromExplode()</code></td><td><span>Creates a CoverArray from a string using explode()</span></td><td><span>Public Static</span></td></tr><tr><td><code>fromJson()</code></td><td><span>Creates a CoverArray instance from a JSON string</span></td><td><span>Public Static</span></td></tr><tr><td><code>get()</code></td><td><span>Returns data by keys of the current object using dot notation</span></td><td><span>Public</span></td></tr><tr><td><code>getDataAsArray()</code></td><td><span>Returns the current object's data as a native PHP array</span></td><td><span>Public</span></td></tr><tr><td><code>getIterator()</code></td><td><span>Returns an iterator for the array (IteratorAggregate interface)</span></td><td><span>Public</span></td></tr><tr><td><code>implode()</code></td><td><span>Joins array elements with a string</span></td><td><span>Public</span></td></tr><tr><td><code>isEmpty()</code></td><td><span>Checks if the array is empty</span></td><td><span>Public</span></td></tr><tr><td><code>item()</code></td><td><span>Returns the collection element with the given index as the result</span></td><td><span>Public</span></td></tr><tr><td><code>jsonSerialize()</code></td><td><span>Specifies data which should be serialized to JSON (JsonSerializable interface)</span></td><td><span>Public</span></td></tr><tr><td><code>offsetExists()</code></td><td><span>Checks whether the specified offset exists in the array (ArrayAccess interface)</span></td><td><span>Public</span></td></tr><tr><td><code>offsetGet()</code></td><td><span>Returns the value at the specified offset (ArrayAccess interface)</span></td><td><span>Public</span></td></tr><tr><td><code>offsetSet()</code></td><td><span>Sets the value at the specified offset (ArrayAccess interface)</span></td><td><span>Public</span></td></tr><tr><td><code>offsetUnset()</code></td><td><span>Unsets the value at the specified offset (ArrayAccess interface)</span></td><td><span>Public</span></td></tr><tr><td><code>setData()</code></td><td><span>Sets the internal data for the CoverArray</span></td><td><span>Public</span></td></tr><tr><td><code>toJson()</code></td><td><span>Converts the CoverArray to a JSON string</span></td><td><span>Public</span></td></tr></tbody></table>