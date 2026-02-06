![Cover Array](logo.jpg)

**其他語言：**
- [English documentation](../README.md)
- [Русская документация](README_ru.md)
- [Documentation française](README_fr.md)
- [Deutsche Dokumentation](README_de.md)
- [Documentazione italiana](README_it.md)
- [日本語ドキュメント](README_jp.md)
- [Documentación en español](README_es.md)
- [한국어 문서](README_kr.md)
- [简体中文文档](README_cn.md)
- [Dokumentasi Bahasa Indonesia](README_id.md)
- [Documentação em Português (BR)](README_br.md)
- [हिंदी दस्तावेज़](README_hi.md)
- [التوثيق بالعربية](README_ar.md)
- [Türkçe Dokümantasyon](README_tr.md)
- [Tài liệu tiếng Việt](README_vi.md)

---

## 狀態
### 測試狀態
| PHP 版本 | 狀態                                                                                                                                                                               |
|-------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 8.0         | [![PHP 8.0](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml) |
| 8.1         | [![PHP 8.1](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml) |
| 8.2         | [![PHP 8.2](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml) |
| 8.3         | [![PHP 8.3](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml) |
| 8.4         | [![PHP 8.4](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml) |
| 8.5         | [![PHP 8.5](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml) |

### 程式碼覆蓋率
[![codecov](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection/branch/master/graph/badge.svg)](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection)

## 系統要求
PHP >= 8.0

## 安裝
```
composer require krugozor/cover
```

# CoverArray：PHP 的物件導向陣列包裝器（PHP Collection）
由人類創建，由人工智慧驗證和測試。2026 版本

## 為什麼創建 CoverArray

在現代 PHP 開發中，我們經常將陣列作為主要的資料結構來使用。然而，PHP 的原生陣列函數存在幾個限制，而 CoverArray 解決了這些問題。

### 原生 PHP 陣列的問題

- **函數命名不一致**：有些函數使用底線（`array_map`），有些則不使用（`usort`）
- **參數順序混亂**：例如 `array_map($callback, $array)` 與 `array_filter($array, $callback)` 的順序不同
- **無法鏈式調用**：原生函數返回新陣列，需要使用中間變數
- **型別安全性有限**：沒有 IDE 自動完成或靜態分析支援
- **語法冗長**：複雜操作需要巢狀函數調用

### CoverArray 解決的問題

CoverArray 提供了一個清晰的物件導向介面，它封裝了 PHP 陣列，同時保持與原生函數的完全相容性：

```php
// 資料：具有年齡和狀態的使用者
// 任務：取得年齡超過 18 歲的活躍使用者的姓名，按分數降序排列
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
#### 之後（CoverArray）：
```php
// 全部在一行完成！
$result = CoverArray::fromArray($users)
    ->filter(fn($u) => $u->active && $u->age >= 18)
    ->usort(fn($a, $b) => $b->score <=> $a->score)
    ->values()
    ->column('name')
    ->implode(', '); // Charlie, Alice, Diana
```
### 主要優勢
* **無外部相依性：** 純 PHP 實現，無需額外套件
* **一致的 API：** 所有方法遵循 `$array->method($arguments)` 模式
* **方法鏈式調用：** 以可讀的方式串連多個操作
* **IDE 支援：** 完整的自動完成和型別提示
* **現代語法：** 為 PHP 8.0+ 設計，具有嚴格型別檢查
* **點記法：** 使用 `$array->get('user.profile.name')` 輕鬆存取巢狀資料
* **JSON 支援：** 內建序列化/反序列化
* **不可變操作：** 大多數方法返回新實例，保留原始資料
* **完全相容：** 與現有的基於陣列的程式碼無縫配合

### 實際應用案例

#### 範例 1：使用點記法進行設定管理
```php
// 安全地載入和存取巢狀設定
$config = CoverArray::fromJson(file_get_contents('config.json'));

// 直接存取巢狀資料，並提供預設值
$dbHost = $config->get('database.connections.mysql.host', fn($value) => $value ?? 'localhost');
$dbPort = $config->get('database.connections.mysql.port', fn($value) => $value ?? 3306);

// 使用回呼存取複雜的預設值
$apiKeys = $config->get('services.payment.keys', function($keys) {
    return $keys ?? CoverArray::fromArray([
        'public' => 'default_public_key',
        'secret' => 'default_secret_key'
    ]);
});
```

#### 範例 2：API 回應處理管道
```php
// 實際 API 處理：篩選、轉換和提取資料
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

// 提取特定欄位用於下拉選單
$userOptions = $apiResponse->column('name', 'id')->getDataAsArray();
```

#### 範例 3：日誌分析和錯誤報告
```php
// 解析應用程式日誌並提取錯誤模式
$logLines = CoverArray::fromExplode("\n", file_get_contents('app.log'))
    ->filter(fn($line) => !empty(trim($line)));

// 提取和分類錯誤
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

// 按錯誤類型分組並計算發生次數
$errorStats = $errors
    ->column('type')
    ->countValues()
    ->arsort(); // 按頻率排序

// 生成錯誤報告
$report = "錯誤報告：\n";
foreach ($errorStats as $type => $count) {
    $report .= "- {$type}：{$count} 次\n";
}

// 查找最近的關鍵錯誤
$lastCritical = $errors
    ->filter(fn($e) => $e['type'] === 'Critical')
    ->last();
```

CoverArray 彌合了 PHP 強大的陣列函數與現代物件導向實踐之間的差距，使陣列操作更具表現力、更易於維護且更令人愉悅。

## 對照表：CoverArray 方法 vs PHP 陣列函數

<table><thead><tr><th><span>#</span></th><th><span>PHP 函數</span></th><th><span>CoverArray 方法</span></th><th><span>狀態</span></th><th><span>備註</span></th></tr></thead><tbody><tr><td><span>1</span></td><td><code>array_all</code></td><td><code>all()</code></td><td><span>✅</span></td><td><span>使用 polyfill 實現，支援舊版 PHP</span></td></tr><tr><td><span>2</span></td><td><code>array_any</code></td><td><code>any()</code></td><td><span>✅</span></td><td><span>使用 polyfill 實現，支援舊版 PHP</span></td></tr><tr><td><span>3</span></td><td><code>array_change_key_case</code></td><td><code>changeKeyCase()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>4</span></td><td><code>array_chunk</code></td><td><code>chunk()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>5</span></td><td><code>array_column</code></td><td><code>column()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>6</span></td><td><code>array_combine</code></td><td><code>combine()</code></td><td><span>✅</span></td><td><span>完整實現（靜態方法）</span></td></tr><tr><td><span>7</span></td><td><code>array_count_values</code></td><td><code>countValues()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>8</span></td><td><code>array_diff</code></td><td><code>diff()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>9</span></td><td><code>array_diff_assoc</code></td><td><code>diffAssoc()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>10</span></td><td><code>array_diff_key</code></td><td><code>diffKey()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>11</span></td><td><code>array_diff_uassoc</code></td><td><code>diffUassoc()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>12</span></td><td><code>array_diff_ukey</code></td><td><code>diffUkey()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>13</span></td><td><code>array_fill</code></td><td><code>fill()</code></td><td><span>✅</span></td><td><span>完整實現（靜態方法）</span></td></tr><tr><td><span>14</span></td><td><code>array_fill_keys</code></td><td><code>fillKeys()</code></td><td><span>✅</span></td><td><span>完整實現（靜態方法）</span></td></tr><tr><td><span>15</span></td><td><code>array_filter</code></td><td><code>filter()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>16</span></td><td><code>array_find</code></td><td><code>find()</code></td><td><span>✅</span></td><td><span>使用 polyfill 實現，支援舊版 PHP</span></td></tr><tr><td><span>17</span></td><td><code>array_find_key</code></td><td><code>findKey()</code></td><td><span>✅</span></td><td><span>使用 polyfill 實現，支援舊版 PHP</span></td></tr><tr><td><span>18</span></td><td><code>array_first</code></td><td><code>first()</code></td><td><span>✅</span></td><td><span>使用 polyfill 實現，支援舊版 PHP</span></td></tr><tr><td><span>19</span></td><td><code>array_flip</code></td><td><code>flip()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>20</span></td><td><code>array_intersect</code></td><td><code>intersect()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>21</span></td><td><code>array_intersect_assoc</code></td><td><code>intersectAssoc()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>22</span></td><td><code>array_intersect_key</code></td><td><code>intersectKey()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>23</span></td><td><code>array_intersect_uassoc</code></td><td><code>intersectUassoc()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>24</span></td><td><code>array_intersect_ukey</code></td><td><code>intersectUkey()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>25</span></td><td><code>array_is_list</code></td><td><code>isList()</code></td><td><span>✅</span></td><td><span>使用 polyfill 實現，支援舊版 PHP</span></td></tr><tr><td><span>26</span></td><td><code>array_key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>27</span></td><td><code>array_key_first</code></td><td><code>keyFirst()</code></td><td><span>✅</span></td><td><span>使用內建函數</span></td></tr><tr><td><span>28</span></td><td><code>array_key_last</code></td><td><code>keyLast()</code></td><td><span>✅</span></td><td><span>使用內建函數</span></td></tr><tr><td><span>29</span></td><td><code>array_keys</code></td><td><code>keys()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>30</span></td><td><code>array_last</code></td><td><code>last()</code></td><td><span>✅</span></td><td><span>使用 polyfill 實現，支援舊版 PHP</span></td></tr><tr><td><span>31</span></td><td><code>array_map</code></td><td><code>map()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>32</span></td><td><code>array_merge</code></td><td><code>merge()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>33</span></td><td><code>array_merge_recursive</code></td><td><code>mergeRecursive()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>34</span></td><td><code>array_multisort</code></td><td><code>multisort()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr><tr><td><span>35</span></td><td><code>array_pad</code></td><td><code>pad()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>36</span></td><td><code>array_pop</code></td><td><code>pop()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr><tr><td><span>37</span></td><td><code>array_product</code></td><td><code>product()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>38</span></td><td><code>array_push</code></td><td><code>push()</code><span> / </span><code>append()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr><tr><td><span>39</span></td><td><code>array_rand</code></td><td><code>rand()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>40</span></td><td><code>array_reduce</code></td><td><code>reduce()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>41</span></td><td><code>array_replace</code></td><td><code>replace()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>42</span></td><td><code>array_replace_recursive</code></td><td><code>replaceRecursive()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>43</span></td><td><code>array_reverse</code></td><td><code>reverse()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>44</span></td><td><code>array_search</code></td><td><code>search()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>45</span></td><td><code>array_shift</code></td><td><code>shift()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr><tr><td><span>46</span></td><td><code>array_slice</code></td><td><code>slice()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>47</span></td><td><code>array_splice</code></td><td><code>splice()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr><tr><td><span>48</span></td><td><code>array_sum</code></td><td><code>sum()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>49</span></td><td><code>array_udiff</code></td><td><code>udiff()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>50</span></td><td><code>array_udiff_assoc</code></td><td><code>udiffAssoc()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>51</span></td><td><code>array_udiff_uassoc</code></td><td><code>udiffUassoc()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>52</span></td><td><code>array_uintersect</code></td><td><code>uintersect()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>53</span></td><td><code>array_uintersect_assoc</code></td><td><code>uintersectAssoc()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>54</span></td><td><code>array_uintersect_uassoc</code></td><td><code>uintersectUassoc()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>55</span></td><td><code>array_unique</code></td><td><code>unique()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>56</span></td><td><code>array_unshift</code></td><td><code>unshift()</code><span> / </span><code>prepend()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr><tr><td><span>57</span></td><td><code>array_values</code></td><td><code>values()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>58</span></td><td><code>array_walk</code></td><td><code>walk()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr><tr><td><span>59</span></td><td><code>array_walk_recursive</code></td><td><code>walkRecursive()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr><tr><td><span>60</span></td><td><code>arsort</code></td><td><code>arsort()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr><tr><td><span>61</span></td><td><code>asort</code></td><td><code>asort()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr><tr><td><span>62</span></td><td><code>compact</code></td><td><code>compact()</code></td><td><span>⚠️</span></td><td><span>無法實現（PHP 作用域限制）。使用：<code>CoverArray::fromArray(compact(...))</code></span></td></tr><tr><td><span>63</span></td><td><code>count</code></td><td><code>count()</code></td><td><span>✅</span></td><td><span>實現 Countable 介面</span></td></tr><tr><td><span>64</span></td><td><code>current</code></td><td><code>current()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>65</span></td><td><code>end</code></td><td><code>end()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr><tr><td><span>66</span></td><td><code>extract</code></td><td><code>extract()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>67</span></td><td><code>in_array</code></td><td><code>in()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>68</span></td><td><code>key</code></td><td><code>key()</code></td><td><span>✅</span></td><td><span>完整實現</span></td></tr><tr><td><span>69</span></td><td><code>key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>完整實現（與 array_key_exists 相同）</span></td></tr><tr><td><span>70</span></td><td><code>krsort</code></td><td><code>krsort()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr><tr><td><span>71</span></td><td><code>ksort</code></td><td><code>ksort()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr><tr><td><span>72</span></td><td><code>list</code></td><td><code>list()</code></td><td><span>⚠️</span></td><td><span>無法實現（語言構造）。使用：<code>list($a, $b) = $cover->getDataAsArray()</code></span></td></tr><tr><td><span>73</span></td><td><code>natcasesort</code></td><td><code>natcasesort()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr><tr><td><span>74</span></td><td><code>natsort</code></td><td><code>natsort()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr><tr><td><span>75</span></td><td><code>next</code></td><td><code>next()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr><tr><td><span>76</span></td><td><code>pos</code></td><td><code>pos()</code></td><td><span>✅</span></td><td><span><code>current()</code> 的別名</span></td></tr><tr><td><span>77</span></td><td><code>prev</code></td><td><code>prev()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr><tr><td><span>78</span></td><td><code>range</code></td><td><code>range()</code></td><td><span>✅</span></td><td><span>完整實現（靜態方法）</span></td></tr><tr><td><span>79</span></td><td><code>reset</code></td><td><code>reset()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr><tr><td><span>80</span></td><td><code>rsort</code></td><td><code>rsort()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr><tr><td><span>81</span></td><td><code>shuffle</code></td><td><code>shuffle()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr><tr><td><span>82</span></td><td><code>sort</code></td><td><code>sort()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr><tr><td><span>83</span></td><td><code>uasort</code></td><td><code>uasort()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr><tr><td><span>84</span></td><td><code>uksort</code></td><td><code>uksort()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr><tr><td><span>85</span></td><td><code>usort</code></td><td><code>usort()</code></td><td><span>✅</span></td><td><span>完整實現（可變）</span></td></tr></tbody></table>

### 額外的 CoverArray 方法

<table><thead><tr><th><span>方法</span></th><th><span>用途</span></th><th><span>存取</span></th></tr></thead><tbody><tr><td><code>__clone()</code></td><td><span>建立淺複製，對直接物件屬性進行深度複製</span></td><td><span>魔術方法</span></td></tr><tr><td><code>__get()</code></td><td><span>使用物件屬性語法取得屬性值</span></td><td><span>魔術方法</span></td></tr><tr><td><code>__isset()</code></td><td><span>檢查屬性是否已設定</span></td><td><span>魔術方法</span></td></tr><tr><td><code>__serialize()</code></td><td><span>序列化物件用於序列化</span></td><td><span>魔術方法</span></td></tr><tr><td><code>__set()</code></td><td><span>使用物件屬性語法設定屬性值</span></td><td><span>魔術方法</span></td></tr><tr><td><code>__toString()</code></td><td><span>返回物件的字串表示</span></td><td><span>魔術方法</span></td></tr><tr><td><code>__unserialize()</code></td><td><span>從序列化資料反序列化物件</span></td><td><span>魔術方法</span></td></tr><tr><td><code>__unset()</code></td><td><span>取消設定屬性</span></td><td><span>魔術方法</span></td></tr><tr><td><code>clear()</code></td><td><span>清除所有資料</span></td><td><span>Public</span></td></tr><tr><td><code>copy()</code></td><td><span>建立並返回當前物件實例的副本</span></td><td><span>Public</span></td></tr><tr><td><code>each()</code></td><td><span>對每個元素應用回呼並返回保留鍵的新實例（不可變，非遞迴）</span></td><td><span>Public</span></td></tr><tr><td><code>eachRecursive()</code></td><td><span>遞迴地對每個元素應用回呼並返回新實例（不可變，遞迴）</span></td><td><span>Public</span></td></tr><tr><td><code>fromArray()</code></td><td><span>從原生 PHP 陣列建立 CoverArray</span></td><td><span>Public Static</span></td></tr><tr><td><code>fromExplode()</code></td><td><span>使用 explode() 從字串建立 CoverArray</span></td><td><span>Public Static</span></td></tr><tr><td><code>fromJson()</code></td><td><span>從 JSON 字串建立 CoverArray 實例</span></td><td><span>Public Static</span></td></tr><tr><td><code>get()</code></td><td><span>使用點記法返回當前物件的鍵資料</span></td><td><span>Public</span></td></tr><tr><td><code>getData()</code></td><td><span>按原樣返回內部資料陣列，不進行任何轉換</span></td><td><span>Public</span></td></tr><tr><td><code>getDataAsArray()</code></td><td><span>將當前物件的資料作為原生 PHP 陣列返回</span></td><td><span>Public</span></td></tr><tr><td><code>getIterator()</code></td><td><span>返回陣列的迭代器（IteratorAggregate 介面）</span></td><td><span>Public</span></td></tr><tr><td><code>implode()</code></td><td><span>使用字串連接陣列元素</span></td><td><span>Public</span></td></tr><tr><td><code>isEmpty()</code></td><td><span>檢查陣列是否為空</span></td><td><span>Public</span></td></tr><tr><td><code>item()</code></td><td><span>返回具有給定索引的集合元素作為結果</span></td><td><span>Public</span></td></tr><tr><td><code>jsonSerialize()</code></td><td><span>指定應序列化為 JSON 的資料（JsonSerializable 介面）</span></td><td><span>Public</span></td></tr><tr><td><code>offsetExists()</code></td><td><span>檢查陣列中是否存在指定的偏移量（ArrayAccess 介面）</span></td><td><span>Public</span></td></tr><tr><td><code>offsetGet()</code></td><td><span>返回指定偏移量處的值（ArrayAccess 介面）</span></td><td><span>Public</span></td></tr><tr><td><code>offsetSet()</code></td><td><span>設定指定偏移量處的值（ArrayAccess 介面）</span></td><td><span>Public</span></td></tr><tr><td><code>offsetUnset()</code></td><td><span>取消設定指定偏移量處的值（ArrayAccess 介面）</span></td><td><span>Public</span></td></tr><tr><td><code>setData()</code></td><td><span>設定 CoverArray 的內部資料</span></td><td><span>Public</span></td></tr><tr><td><code>toJson()</code></td><td><span>將 CoverArray 轉換為 JSON 字串</span></td><td><span>Public</span></td></tr></tbody></table>
