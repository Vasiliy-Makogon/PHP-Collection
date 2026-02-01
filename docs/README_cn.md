![Cover Array](logo.jpg)

**其他语言：**
- [English documentation](../README.md)
- [Русская документация](README_ru.md)
- [Documentation française](README_fr.md)
- [Deutsche Dokumentation](README_de.md)
- [Documentazione italiana](README_it.md)
- [日本語ドキュメント](README_jp.md)
- [Documentación en español](README_es.md)
- [한국어 문서](README_kr.md)
- [繁體中文文件](README_tw.md)
- [Dokumentasi Bahasa Indonesia](README_id.md)
- [Documentação em Português (BR)](README_br.md)
- [हिंदी दस्तावेज़](README_hi.md)
- [التوثيق بالعربية](README_ar.md)

---

## 状态
### 测试状态
| PHP 版本 | 状态                                                                                                                                                                               |
|-------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 8.0         | [![PHP 8.0](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml) |
| 8.1         | [![PHP 8.1](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml) |
| 8.2         | [![PHP 8.2](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml) |
| 8.3         | [![PHP 8.3](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml) |
| 8.4         | [![PHP 8.4](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml) |
| 8.5         | [![PHP 8.5](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml) |

### 代码覆盖率
[![codecov](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection/branch/master/graph/badge.svg)](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection)

## 系统要求
PHP >= 8.0

## 安装
```
composer require krugozor/cover
```

# CoverArray：PHP 面向对象数组封装器（PHP 集合）
由人类创建，经人工智能验证和测试。2026 年发布

## 为什么创建 CoverArray

在现代 PHP 开发中，我们经常使用数组作为主要数据结构。然而，PHP 原生数组函数存在一些限制，CoverArray 解决了这些问题。

### 原生 PHP 数组的问题

- **函数命名不一致**：一些函数使用下划线（`array_map`），另一些则不使用（`usort`）
- **参数顺序混乱**：函数如 `array_map($callback, $array)` 与 `array_filter($array, $callback)` 不同
- **无法链式调用**：原生函数返回新数组，需要使用中间变量
- **类型安全有限**：没有 IDE 自动补全或静态分析支持
- **语法冗长**：复杂操作需要嵌套函数调用

### CoverArray 解决的问题

CoverArray 提供了一个清晰的面向对象接口来封装 PHP 数组，同时保持与原生函数的完全兼容性：

```php
// 数据：带有年龄和状态的用户
// 任务：获取活跃用户中年龄大于 18 岁的名字，按分数降序排序
$users = [
    ['name' => 'Alice', 'age' => 25, 'active' => true, 'score' => 85],
    ['name' => 'Bob', 'age' => 17, 'active' => false, 'score' => 45],
    ['name' => 'Charlie', 'age' => 32, 'active' => true, 'score' => 92],
    ['name' => 'Diana', 'age' => 19, 'active' => true, 'score' => 78],
    ['name' => 'Eve', 'age' => 22, 'active' => false, 'score' => 61],
];
```

#### 之前（原生 PHP）：
```php
$filtered = array_filter($users, fn($u) => $u['active'] && $u['age'] >= 18);
$sorted = usort($filtered, fn($a, $b) => $b['score'] <=> $a['score']) ? $filtered : [];
$names = array_column($sorted, 'name');
$result = implode(', ', $names); // Charlie, Alice, Diana
```
#### 之后（CoverArray）：
```php
// 所有操作在一行完成！
$result = CoverArray::fromArray($users)
    ->filter(fn($u) => $u->active && $u->age >= 18)
    ->usort(fn($a, $b) => $b->score <=> $a->score)
    ->values()
    ->column('name')
    ->implode(', '); // Charlie, Alice, Diana
```
### 主要优势
* **无外部依赖**：纯 PHP 实现，无需额外的包
* **一致的 API**：所有方法遵循 `$array->method($arguments)` 模式
* **方法链式调用**：以可读的方式链式调用多个操作
* **IDE 支持**：完整的自动补全和类型提示
* **现代语法**：为 PHP 8.0+ 设计，具有严格类型
* **点符号**：通过 `$array->get('user.profile.name')` 轻松访问嵌套数据
* **JSON 支持**：内置序列化/反序列化
* **不可变操作**：大多数方法返回新实例，保留原始数据
* **完全兼容**：与现有基于数组的代码无缝协作

### 实际应用场景

#### 示例 1：使用点符号进行配置管理
```php
// 安全地加载和访问嵌套配置
$config = CoverArray::fromJson(file_get_contents('config.json'));

// 直接访问嵌套数据，带有默认值回退
$dbHost = $config->get('database.connections.mysql.host', fn($value) => $value ?? 'localhost');
$dbPort = $config->get('database.connections.mysql.port', fn($value) => $value ?? 3306);

// 使用回调访问复杂的默认值
$apiKeys = $config->get('services.payment.keys', function($keys) {
    return $keys ?? CoverArray::fromArray([
        'public' => 'default_public_key',
        'secret' => 'default_secret_key'
    ]);
});
```

#### 示例 2：API 响应处理管道
```php
// 真实世界的 API 处理：过滤、转换和提取数据
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

// 提取特定列用于下拉菜单
$userOptions = $apiResponse->column('name', 'id')->getDataAsArray();
```

#### 示例 3：日志分析和错误报告
```php
// 解析应用程序日志并提取错误模式
$logLines = CoverArray::fromExplode("\n", file_get_contents('app.log'))
    ->filter(fn($line) => !empty(trim($line)));

// 提取和分类错误
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

// 按错误类型分组并计数
$errorStats = $errors
    ->column('type')
    ->countValues()
    ->arsort(); // 按频率排序

// 生成错误报告
$report = "错误报告:\n";
foreach ($errorStats as $type => $count) {
    $report .= "- {$type}: {$count} 次\n";
}

// 查找最近的严重错误
$lastCritical = $errors
    ->filter(fn($e) => $e['type'] === 'Critical')
    ->last();
```

CoverArray 在 PHP 强大的数组函数和现代面向对象实践之间架起桥梁，使数组操作更具表现力、可维护性和愉悦性。

## 对照表：CoverArray 方法与 PHP 数组函数

<table><thead><tr><th><span>#</span></th><th><span>PHP 函数</span></th><th><span>CoverArray 方法</span></th><th><span>状态</span></th><th><span>备注</span></th></tr></thead><tbody><tr><td><span>1</span></td><td><code>array_all</code></td><td><code>all()</code></td><td><span>✅</span></td><td><span>为旧版 PHP 实现了 polyfill</span></td></tr><tr><td><span>2</span></td><td><code>array_any</code></td><td><code>any()</code></td><td><span>✅</span></td><td><span>为旧版 PHP 实现了 polyfill</span></td></tr><tr><td><span>3</span></td><td><code>array_change_key_case</code></td><td><code>changeKeyCase()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>4</span></td><td><code>array_chunk</code></td><td><code>chunk()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>5</span></td><td><code>array_column</code></td><td><code>column()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>6</span></td><td><code>array_combine</code></td><td><code>combine()</code></td><td><span>✅</span></td><td><span>完全实现（静态方法）</span></td></tr><tr><td><span>7</span></td><td><code>array_count_values</code></td><td><code>countValues()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>8</span></td><td><code>array_diff</code></td><td><code>diff()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>9</span></td><td><code>array_diff_assoc</code></td><td><code>diffAssoc()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>10</span></td><td><code>array_diff_key</code></td><td><code>diffKey()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>11</span></td><td><code>array_diff_uassoc</code></td><td><code>diffUassoc()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>12</span></td><td><code>array_diff_ukey</code></td><td><code>diffUkey()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>13</span></td><td><code>array_fill</code></td><td><code>fill()</code></td><td><span>✅</span></td><td><span>完全实现（静态方法）</span></td></tr><tr><td><span>14</span></td><td><code>array_fill_keys</code></td><td><code>fillKeys()</code></td><td><span>✅</span></td><td><span>完全实现（静态方法）</span></td></tr><tr><td><span>15</span></td><td><code>array_filter</code></td><td><code>filter()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>16</span></td><td><code>array_find</code></td><td><code>find()</code></td><td><span>✅</span></td><td><span>为旧版 PHP 实现了 polyfill</span></td></tr><tr><td><span>17</span></td><td><code>array_find_key</code></td><td><code>findKey()</code></td><td><span>✅</span></td><td><span>为旧版 PHP 实现了 polyfill</span></td></tr><tr><td><span>18</span></td><td><code>array_first</code></td><td><code>first()</code></td><td><span>✅</span></td><td><span>为旧版 PHP 实现了 polyfill</span></td></tr><tr><td><span>19</span></td><td><code>array_flip</code></td><td><code>flip()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>20</span></td><td><code>array_intersect</code></td><td><code>intersect()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>21</span></td><td><code>array_intersect_assoc</code></td><td><code>intersectAssoc()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>22</span></td><td><code>array_intersect_key</code></td><td><code>intersectKey()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>23</span></td><td><code>array_intersect_uassoc</code></td><td><code>intersectUassoc()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>24</span></td><td><code>array_intersect_ukey</code></td><td><code>intersectUkey()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>25</span></td><td><code>array_is_list</code></td><td><code>isList()</code></td><td><span>✅</span></td><td><span>为旧版 PHP 实现了 polyfill</span></td></tr><tr><td><span>26</span></td><td><code>array_key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>27</span></td><td><code>array_key_first</code></td><td><code>keyFirst()</code></td><td><span>✅</span></td><td><span>使用内置函数</span></td></tr><tr><td><span>28</span></td><td><code>array_key_last</code></td><td><code>keyLast()</code></td><td><span>✅</span></td><td><span>使用内置函数</span></td></tr><tr><td><span>29</span></td><td><code>array_keys</code></td><td><code>keys()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>30</span></td><td><code>array_last</code></td><td><code>last()</code></td><td><span>✅</span></td><td><span>为旧版 PHP 实现了 polyfill</span></td></tr><tr><td><span>31</span></td><td><code>array_map</code></td><td><code>map()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>32</span></td><td><code>array_merge</code></td><td><code>merge()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>33</span></td><td><code>array_merge_recursive</code></td><td><code>mergeRecursive()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>34</span></td><td><code>array_multisort</code></td><td><code>multisort()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr><tr><td><span>35</span></td><td><code>array_pad</code></td><td><code>pad()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>36</span></td><td><code>array_pop</code></td><td><code>pop()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr><tr><td><span>37</span></td><td><code>array_product</code></td><td><code>product()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>38</span></td><td><code>array_push</code></td><td><code>push()</code><span> / </span><code>append()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr><tr><td><span>39</span></td><td><code>array_rand</code></td><td><code>rand()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>40</span></td><td><code>array_reduce</code></td><td><code>reduce()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>41</span></td><td><code>array_replace</code></td><td><code>replace()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>42</span></td><td><code>array_replace_recursive</code></td><td><code>replaceRecursive()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>43</span></td><td><code>array_reverse</code></td><td><code>reverse()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>44</span></td><td><code>array_search</code></td><td><code>search()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>45</span></td><td><code>array_shift</code></td><td><code>shift()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr><tr><td><span>46</span></td><td><code>array_slice</code></td><td><code>slice()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>47</span></td><td><code>array_splice</code></td><td><code>splice()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr><tr><td><span>48</span></td><td><code>array_sum</code></td><td><code>sum()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>49</span></td><td><code>array_udiff</code></td><td><code>udiff()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>50</span></td><td><code>array_udiff_assoc</code></td><td><code>udiffAssoc()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>51</span></td><td><code>array_udiff_uassoc</code></td><td><code>udiffUassoc()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>52</span></td><td><code>array_uintersect</code></td><td><code>uintersect()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>53</span></td><td><code>array_uintersect_assoc</code></td><td><code>uintersectAssoc()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>54</span></td><td><code>array_uintersect_uassoc</code></td><td><code>uintersectUassoc()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>55</span></td><td><code>array_unique</code></td><td><code>unique()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>56</span></td><td><code>array_unshift</code></td><td><code>unshift()</code><span> / </span><code>prepend()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr><tr><td><span>57</span></td><td><code>array_values</code></td><td><code>values()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>58</span></td><td><code>array_walk</code></td><td><code>walk()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr><tr><td><span>59</span></td><td><code>array_walk_recursive</code></td><td><code>walkRecursive()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr><tr><td><span>60</span></td><td><code>arsort</code></td><td><code>arsort()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr><tr><td><span>61</span></td><td><code>asort</code></td><td><code>asort()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr><tr><td><span>62</span></td><td><code>compact</code></td><td><code>compact()</code></td><td><span>⚠️</span></td><td><span>无法实现（PHP 作用域限制）。使用：<code>CoverArray::fromArray(compact(...))</code></span></td></tr><tr><td><span>63</span></td><td><code>count</code></td><td><code>count()</code></td><td><span>✅</span></td><td><span>实现 Countable 接口</span></td></tr><tr><td><span>64</span></td><td><code>current</code></td><td><code>current()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>65</span></td><td><code>end</code></td><td><code>end()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr><tr><td><span>66</span></td><td><code>extract</code></td><td><code>extract()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>67</span></td><td><code>in_array</code></td><td><code>in()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>68</span></td><td><code>key</code></td><td><code>key()</code></td><td><span>✅</span></td><td><span>完全实现</span></td></tr><tr><td><span>69</span></td><td><code>key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>完全实现（与 array_key_exists 相同）</span></td></tr><tr><td><span>70</span></td><td><code>krsort</code></td><td><code>krsort()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr><tr><td><span>71</span></td><td><code>ksort</code></td><td><code>ksort()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr><tr><td><span>72</span></td><td><code>list</code></td><td><code>list()</code></td><td><span>⚠️</span></td><td><span>无法实现（语言结构）。使用：<code>list($a, $b) = $cover->getDataAsArray()</code></span></td></tr><tr><td><span>73</span></td><td><code>natcasesort</code></td><td><code>natcasesort()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr><tr><td><span>74</span></td><td><code>natsort</code></td><td><code>natsort()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr><tr><td><span>75</span></td><td><code>next</code></td><td><code>next()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr><tr><td><span>76</span></td><td><code>pos</code></td><td><code>pos()</code></td><td><span>✅</span></td><td><span><code>current()</code> 的别名</span></td></tr><tr><td><span>77</span></td><td><code>prev</code></td><td><code>prev()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr><tr><td><span>78</span></td><td><code>range</code></td><td><code>range()</code></td><td><span>✅</span></td><td><span>完全实现（静态方法）</span></td></tr><tr><td><span>79</span></td><td><code>reset</code></td><td><code>reset()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr><tr><td><span>80</span></td><td><code>rsort</code></td><td><code>rsort()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr><tr><td><span>81</span></td><td><code>shuffle</code></td><td><code>shuffle()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr><tr><td><span>82</span></td><td><code>sort</code></td><td><code>sort()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr><tr><td><span>83</span></td><td><code>uasort</code></td><td><code>uasort()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr><tr><td><span>84</span></td><td><code>uksort</code></td><td><code>uksort()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr><tr><td><span>85</span></td><td><code>usort</code></td><td><code>usort()</code></td><td><span>✅</span></td><td><span>完全实现（可变）</span></td></tr></tbody></table>

### CoverArray 附加方法

<table><thead><tr><th><span>方法</span></th><th><span>目的</span></th><th><span>访问</span></th></tr></thead><tbody><tr><td><code>__clone()</code></td><td><span>创建浅拷贝，对直接对象属性进行深度克隆</span></td><td><span>魔术方法</span></td></tr><tr><td><code>__get()</code></td><td><span>使用对象属性语法获取属性值</span></td><td><span>魔术方法</span></td></tr><tr><td><code>__isset()</code></td><td><span>检查属性是否已设置</span></td><td><span>魔术方法</span></td></tr><tr><td><code>__serialize()</code></td><td><span>序列化对象</span></td><td><span>魔术方法</span></td></tr><tr><td><code>__set()</code></td><td><span>使用对象属性语法设置属性值</span></td><td><span>魔术方法</span></td></tr><tr><td><code>__toString()</code></td><td><span>返回对象的字符串表示</span></td><td><span>魔术方法</span></td></tr><tr><td><code>__unserialize()</code></td><td><span>从序列化数据反序列化对象</span></td><td><span>魔术方法</span></td></tr><tr><td><code>__unset()</code></td><td><span>取消设置属性</span></td><td><span>魔术方法</span></td></tr><tr><td><code>clear()</code></td><td><span>清除所有数据</span></td><td><span>公共</span></td></tr><tr><td><code>copy()</code></td><td><span>创建并返回当前对象实例的副本</span></td><td><span>公共</span></td></tr><tr><td><code>each()</code></td><td><span>对每个元素应用回调并返回保留键的新实例（不可变，非递归）</span></td><td><span>公共</span></td></tr><tr><td><code>eachRecursive()</code></td><td><span>递归地对每个元素应用回调并返回新实例（不可变，递归）</span></td><td><span>公共</span></td></tr><tr><td><code>fromArray()</code></td><td><span>从原生 PHP 数组创建 CoverArray</span></td><td><span>公共静态</span></td></tr><tr><td><code>fromExplode()</code></td><td><span>使用 explode() 从字符串创建 CoverArray</span></td><td><span>公共静态</span></td></tr><tr><td><code>fromJson()</code></td><td><span>从 JSON 字符串创建 CoverArray 实例</span></td><td><span>公共静态</span></td></tr><tr><td><code>get()</code></td><td><span>使用点符号返回当前对象的键数据</span></td><td><span>公共</span></td></tr><tr><td><code>getDataAsArray()</code></td><td><span>以原生 PHP 数组形式返回当前对象的数据</span></td><td><span>公共</span></td></tr><tr><td><code>getIterator()</code></td><td><span>返回数组的迭代器（IteratorAggregate 接口）</span></td><td><span>公共</span></td></tr><tr><td><code>implode()</code></td><td><span>使用字符串连接数组元素</span></td><td><span>公共</span></td></tr><tr><td><code>isEmpty()</code></td><td><span>检查数组是否为空</span></td><td><span>公共</span></td></tr><tr><td><code>item()</code></td><td><span>将给定索引的集合元素作为结果返回</span></td><td><span>公共</span></td></tr><tr><td><code>jsonSerialize()</code></td><td><span>指定应序列化为 JSON 的数据（JsonSerializable 接口）</span></td><td><span>公共</span></td></tr><tr><td><code>offsetExists()</code></td><td><span>检查数组中是否存在指定的偏移量（ArrayAccess 接口）</span></td><td><span>公共</span></td></tr><tr><td><code>offsetGet()</code></td><td><span>返回指定偏移量的值（ArrayAccess 接口）</span></td><td><span>公共</span></td></tr><tr><td><code>offsetSet()</code></td><td><span>设置指定偏移量的值（ArrayAccess 接口）</span></td><td><span>公共</span></td></tr><tr><td><code>offsetUnset()</code></td><td><span>取消设置指定偏移量的值（ArrayAccess 接口）</span></td><td><span>公共</span></td></tr><tr><td><code>setData()</code></td><td><span>为 CoverArray 设置内部数据</span></td><td><span>公共</span></td></tr><tr><td><code>toJson()</code></td><td><span>将 CoverArray 转换为 JSON 字符串</span></td><td><span>公共</span></td></tr></tbody></table>
