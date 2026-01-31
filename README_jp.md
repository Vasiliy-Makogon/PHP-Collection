![Cover Array](logo.jpg)

**他の言語:**
- [English Documentation](README.md)
- [Русская документация](README_rus.md)
- [Documentation française](README_fr.md)

---

## ステータス
### テスト状況
| PHPバージョン | ステータス                                                                                                                                                                               |
|-------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 8.0         | [![PHP 8.0](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml) |
| 8.1         | [![PHP 8.1](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml) |
| 8.2         | [![PHP 8.2](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml) |
| 8.3         | [![PHP 8.3](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml) |
| 8.4         | [![PHP 8.4](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml) |
| 8.5         | [![PHP 8.5](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml) |

### コードカバレッジ
[![codecov](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection/branch/master/graph/badge.svg)](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection)

## 要件
PHP >= 8.0

## インストール
```
composer require krugozor/cover
```

# CoverArray: PHP用オブジェクト指向配列ラッパー（PHPコレクション）
人間によって作成され、人工知能によって検証およびテストされました。2026年リリース

## CoverArrayが作成された理由

モダンなPHP開発では、配列を主要なデータ構造として頻繁に使用します。しかし、PHPのネイティブ配列関数にはCoverArrayが解決するいくつかの制限があります。

### ネイティブPHP配列の問題点

- **一貫性のない関数命名**: アンダースコアを使用する関数（`array_map`）と使用しない関数（`usort`）が混在
- **混合したパラメータ順序**: `array_map($callback, $array)` 対 `array_filter($array, $callback)`のような関数
- **メソッドチェーンの不在**: ネイティブ関数は新しい配列を返すため、中間変数が必要
- **限られた型安全性**: IDEの自動補完や静的解析のサポートがない
- **冗長な構文**: 複雑な操作にはネストした関数呼び出しが必要

### CoverArrayが解決すること

CoverArrayは、ネイティブ関数との完全な互換性を維持しながら、PHP配列をラップするクリーンなオブジェクト指向インターフェースを提供します:

```php
// データ: 年齢とステータスを持つユーザー
// タスク: 18歳以上のアクティブユーザーの名前を取得し、スコアの降順でソート
$users = [
    ['name' => 'Alice', 'age' => 25, 'active' => true, 'score' => 85],
    ['name' => 'Bob', 'age' => 17, 'active' => false, 'score' => 45],
    ['name' => 'Charlie', 'age' => 32, 'active' => true, 'score' => 92],
    ['name' => 'Diana', 'age' => 19, 'active' => true, 'score' => 78],
    ['name' => 'Eve', 'age' => 22, 'active' => false, 'score' => 61],
];
```

#### 従来の方法（ネイティブPHP）:
```php
$filtered = array_filter($users, fn($u) => $u['active'] && $u['age'] >= 18);
$sorted = usort($filtered, fn($a, $b) => $b['score'] <=> $a['score']) ? $filtered : [];
$names = array_column($sorted, 'name');
$result = implode(', ', $names); // Charlie, Alice, Diana
```
#### 新しい方法（CoverArray）:
```php
// すべてを1行で！
$result = CoverArray::fromArray($users)
    ->filter(fn($u) => $u->active && $u->age >= 18)
    ->usort(fn($a, $b) => $b->score <=> $a->score)
    ->values()
    ->column('name')
    ->implode(', '); // Charlie, Alice, Diana
```
### 主な利点
* **外部依存なし:** ピュアなPHP実装、追加パッケージ不要
* **一貫性のあるAPI:** すべてのメソッドが`$array->method($arguments)`パターンに従う
* **メソッドチェーン:** 複数の操作を読みやすい方法でチェーン化
* **IDE サポート:** 完全な自動補完と型ヒント
* **モダンな構文:** 厳密な型付けを備えたPHP 8.0+向けに設計
* **ドット記法:** `$array->get('user.profile.name')`で簡単にネストしたデータにアクセス
* **JSONサポート:** 組み込みのシリアライゼーション/デシリアライゼーション
* **イミュータブル操作:** ほとんどのメソッドは新しいインスタンスを返し、元のデータを保持
* **完全な互換性:** 既存の配列ベースのコードとシームレスに連携

### 実世界のユースケース

#### 例1: ドット記法を使った設定管理
```php
// JSONから設定を読み込み、ネストした設定に安全にアクセス
$config = CoverArray::fromJson(file_get_contents('config.json'));

// デフォルトフォールバックを使用した直接的なネストアクセス
$dbHost = $config->get('database.connections.mysql.host', fn($value) => $value ?? 'localhost');
$dbPort = $config->get('database.connections.mysql.port', fn($value) => $value ?? 3306);

// 複雑なデフォルト値用のコールバックを使用したアクセス
$apiKeys = $config->get('services.payment.keys', function($keys) {
    return $keys ?? CoverArray::fromArray([
        'public' => 'default_public_key',
        'secret' => 'default_secret_key'
    ]);
});
```

#### 例2: APIレスポンス処理パイプライン
```php
// 実世界のAPI処理: フィルタ、変換、データ抽出
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

// ドロップダウン用に特定の列を抽出
$userOptions = $apiResponse->column('name', 'id')->getDataAsArray();
```

#### 例3: Eコマース注文処理
```php
// 注文処理: 統計を計算しレポートを生成
$orders = CoverArray::fromArray($database->getOrders());

// 先月の完了した高額注文をフィルタ
$recentOrders = $orders
    ->filter(fn($order) => $order['status'] === 'completed')
    ->filter(fn($order) => $order['amount'] > 100)
    ->filter(fn($order) => strtotime($order['date']) > strtotime('-30 days'));

// ビジネス指標を計算
$totalRevenue = $recentOrders->column('amount')->sum();
$averageOrder = $totalRevenue / $recentOrders->count();
$topCustomers = $recentOrders
    ->map(fn($o) => ['customer' => $o['customer_name'], 'amount' => $o['amount']])
    ->usort(fn($a, $b) => $b['amount'] <=> $a['amount'])
    ->slice(0, 10);

echo "売上: $" . number_format($totalRevenue, 2) . "\n";
echo "平均注文額: $" . number_format($averageOrder, 2) . "\n";
echo "トップ顧客: " . $topCustomers->first()['customer'];
```

#### 例4: ログ分析とエラーレポート
```php
// アプリケーションログを解析し、エラーパターンを抽出
$logLines = CoverArray::fromExplode("\n", file_get_contents('app.log'))
    ->filter(fn($line) => !empty(trim($line)));

// エラーを抽出し分類
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

// エラータイプでグループ化し、発生回数をカウント
$errorStats = $errors
    ->column('type')
    ->countValues()
    ->arsort(); // 頻度でソート

// エラーレポートを生成
$report = "エラーレポート:\n";
foreach ($errorStats as $type => $count) {
    $report .= "- {$type}: {$count} 回発生\n";
}

// 最新の重大エラーを検索
$lastCritical = $errors
    ->filter(fn($e) => $e['type'] === 'Critical')
    ->last();
```

CoverArrayは、PHPの強力な配列関数とモダンなオブジェクト指向プラクティスの間のギャップを埋め、配列操作をより表現力豊かで保守しやすく、楽しいものにします。

## 比較表: CoverArrayメソッド vs PHP配列関数

<table><thead><tr><th><span>#</span></th><th><span>PHP関数</span></th><th><span>CoverArrayメソッド</span></th><th><span>ステータス</span></th><th><span>備考</span></th></tr></thead><tbody><tr><td><span>1</span></td><td><code>array_all</code></td><td><code>all()</code></td><td><span>✅</span></td><td><span>古いPHPバージョン用のポリフィルで実装</span></td></tr><tr><td><span>2</span></td><td><code>array_any</code></td><td><code>any()</code></td><td><span>✅</span></td><td><span>古いPHPバージョン用のポリフィルで実装</span></td></tr><tr><td><span>3</span></td><td><code>array_change_key_case</code></td><td><code>changeKeyCase()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>4</span></td><td><code>array_chunk</code></td><td><code>chunk()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>5</span></td><td><code>array_column</code></td><td><code>column()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>6</span></td><td><code>array_combine</code></td><td><code>combine()</code></td><td><span>✅</span></td><td><span>完全実装（静的メソッド）</span></td></tr><tr><td><span>7</span></td><td><code>array_count_values</code></td><td><code>countValues()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>8</span></td><td><code>array_diff</code></td><td><code>diff()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>9</span></td><td><code>array_diff_assoc</code></td><td><code>diffAssoc()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>10</span></td><td><code>array_diff_key</code></td><td><code>diffKey()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>11</span></td><td><code>array_diff_uassoc</code></td><td><code>diffUassoc()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>12</span></td><td><code>array_diff_ukey</code></td><td><code>diffUkey()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>13</span></td><td><code>array_fill</code></td><td><code>fill()</code></td><td><span>✅</span></td><td><span>完全実装（静的メソッド）</span></td></tr><tr><td><span>14</span></td><td><code>array_fill_keys</code></td><td><code>fillKeys()</code></td><td><span>✅</span></td><td><span>完全実装（静的メソッド）</span></td></tr><tr><td><span>15</span></td><td><code>array_filter</code></td><td><code>filter()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>16</span></td><td><code>array_find</code></td><td><code>find()</code></td><td><span>✅</span></td><td><span>古いPHPバージョン用のポリフィルで実装</span></td></tr><tr><td><span>17</span></td><td><code>array_find_key</code></td><td><code>findKey()</code></td><td><span>✅</span></td><td><span>古いPHPバージョン用のポリフィルで実装</span></td></tr><tr><td><span>18</span></td><td><code>array_first</code></td><td><code>first()</code></td><td><span>✅</span></td><td><span>古いPHPバージョン用のポリフィルで実装</span></td></tr><tr><td><span>19</span></td><td><code>array_flip</code></td><td><code>flip()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>20</span></td><td><code>array_intersect</code></td><td><code>intersect()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>21</span></td><td><code>array_intersect_assoc</code></td><td><code>intersectAssoc()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>22</span></td><td><code>array_intersect_key</code></td><td><code>intersectKey()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>23</span></td><td><code>array_intersect_uassoc</code></td><td><code>intersectUassoc()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>24</span></td><td><code>array_intersect_ukey</code></td><td><code>intersectUkey()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>25</span></td><td><code>array_is_list</code></td><td><code>isList()</code></td><td><span>✅</span></td><td><span>古いPHPバージョン用のポリフィルで実装</span></td></tr><tr><td><span>26</span></td><td><code>array_key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>27</span></td><td><code>array_key_first</code></td><td><code>keyFirst()</code></td><td><span>✅</span></td><td><span>組み込み関数を使用</span></td></tr><tr><td><span>28</span></td><td><code>array_key_last</code></td><td><code>keyLast()</code></td><td><span>✅</span></td><td><span>組み込み関数を使用</span></td></tr><tr><td><span>29</span></td><td><code>array_keys</code></td><td><code>keys()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>30</span></td><td><code>array_last</code></td><td><code>last()</code></td><td><span>✅</span></td><td><span>古いPHPバージョン用のポリフィルで実装</span></td></tr><tr><td><span>31</span></td><td><code>array_map</code></td><td><code>map()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>32</span></td><td><code>array_merge</code></td><td><code>merge()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>33</span></td><td><code>array_merge_recursive</code></td><td><code>mergeRecursive()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>34</span></td><td><code>array_multisort</code></td><td><code>multisort()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr><tr><td><span>35</span></td><td><code>array_pad</code></td><td><code>pad()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>36</span></td><td><code>array_pop</code></td><td><code>pop()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr><tr><td><span>37</span></td><td><code>array_product</code></td><td><code>product()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>38</span></td><td><code>array_push</code></td><td><code>push()</code><span> / </span><code>append()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr><tr><td><span>39</span></td><td><code>array_rand</code></td><td><code>rand()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>40</span></td><td><code>array_reduce</code></td><td><code>reduce()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>41</span></td><td><code>array_replace</code></td><td><code>replace()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>42</span></td><td><code>array_replace_recursive</code></td><td><code>replaceRecursive()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>43</span></td><td><code>array_reverse</code></td><td><code>reverse()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>44</span></td><td><code>array_search</code></td><td><code>search()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>45</span></td><td><code>array_shift</code></td><td><code>shift()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr><tr><td><span>46</span></td><td><code>array_slice</code></td><td><code>slice()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>47</span></td><td><code>array_splice</code></td><td><code>splice()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr><tr><td><span>48</span></td><td><code>array_sum</code></td><td><code>sum()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>49</span></td><td><code>array_udiff</code></td><td><code>udiff()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>50</span></td><td><code>array_udiff_assoc</code></td><td><code>udiffAssoc()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>51</span></td><td><code>array_udiff_uassoc</code></td><td><code>udiffUassoc()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>52</span></td><td><code>array_uintersect</code></td><td><code>uintersect()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>53</span></td><td><code>array_uintersect_assoc</code></td><td><code>uintersectAssoc()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>54</span></td><td><code>array_uintersect_uassoc</code></td><td><code>uintersectUassoc()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>55</span></td><td><code>array_unique</code></td><td><code>unique()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>56</span></td><td><code>array_unshift</code></td><td><code>unshift()</code><span> / </span><code>prepend()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr><tr><td><span>57</span></td><td><code>array_values</code></td><td><code>values()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>58</span></td><td><code>array_walk</code></td><td><code>walk()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr><tr><td><span>59</span></td><td><code>array_walk_recursive</code></td><td><code>walkRecursive()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr><tr><td><span>60</span></td><td><code>arsort</code></td><td><code>arsort()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr><tr><td><span>61</span></td><td><code>asort</code></td><td><code>asort()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr><tr><td><span>62</span></td><td><code>compact</code></td><td><code>compact()</code></td><td><span>⚠️</span></td><td><span>実装不可（PHPスコープの制限）。使用方法: <code>CoverArray::fromArray(compact(...))</code></span></td></tr><tr><td><span>63</span></td><td><code>count</code></td><td><code>count()</code></td><td><span>✅</span></td><td><span>Countableインターフェースの実装</span></td></tr><tr><td><span>64</span></td><td><code>current</code></td><td><code>current()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>65</span></td><td><code>end</code></td><td><code>end()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr><tr><td><span>66</span></td><td><code>extract</code></td><td><code>extract()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>67</span></td><td><code>in_array</code></td><td><code>in()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>68</span></td><td><code>key</code></td><td><code>key()</code></td><td><span>✅</span></td><td><span>完全実装</span></td></tr><tr><td><span>69</span></td><td><code>key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>完全実装（array_key_existsと同じ）</span></td></tr><tr><td><span>70</span></td><td><code>krsort</code></td><td><code>krsort()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr><tr><td><span>71</span></td><td><code>ksort</code></td><td><code>ksort()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr><tr><td><span>72</span></td><td><code>list</code></td><td><code>list()</code></td><td><span>⚠️</span></td><td><span>実装不可（言語構造）。使用方法: <code>list($a, $b) = $cover->getDataAsArray()</code></span></td></tr><tr><td><span>73</span></td><td><code>natcasesort</code></td><td><code>natcasesort()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr><tr><td><span>74</span></td><td><code>natsort</code></td><td><code>natsort()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr><tr><td><span>75</span></td><td><code>next</code></td><td><code>next()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr><tr><td><span>76</span></td><td><code>pos</code></td><td><code>pos()</code></td><td><span>✅</span></td><td><span><code>current()</code>のエイリアス</span></td></tr><tr><td><span>77</span></td><td><code>prev</code></td><td><code>prev()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr><tr><td><span>78</span></td><td><code>range</code></td><td><code>range()</code></td><td><span>✅</span></td><td><span>完全実装（静的メソッド）</span></td></tr><tr><td><span>79</span></td><td><code>reset</code></td><td><code>reset()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr><tr><td><span>80</span></td><td><code>rsort</code></td><td><code>rsort()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr><tr><td><span>81</span></td><td><code>shuffle</code></td><td><code>shuffle()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr><tr><td><span>82</span></td><td><code>sort</code></td><td><code>sort()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr><tr><td><span>83</span></td><td><code>uasort</code></td><td><code>uasort()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr><tr><td><span>84</span></td><td><code>uksort</code></td><td><code>uksort()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr><tr><td><span>85</span></td><td><code>usort</code></td><td><code>usort()</code></td><td><span>✅</span></td><td><span>完全実装（ミューテーティング）</span></td></tr></tbody></table>

### 追加のCoverArrayメソッド

<table><thead><tr><th><span>メソッド</span></th><th><span>目的</span></th><th><span>アクセス</span></th></tr></thead><tbody><tr><td><code>__clone()</code></td><td><span>即座のオブジェクトプロパティを深くクローンしてシャローコピーを作成</span></td><td><span>マジック</span></td></tr><tr><td><code>__get()</code></td><td><span>オブジェクトプロパティ構文を使用してプロパティ値を取得</span></td><td><span>マジック</span></td></tr><tr><td><code>__isset()</code></td><td><span>プロパティが設定されているかチェック</span></td><td><span>マジック</span></td></tr><tr><td><code>__serialize()</code></td><td><span>シリアライゼーション用にオブジェクトをシリアライズ</span></td><td><span>マジック</span></td></tr><tr><td><code>__set()</code></td><td><span>オブジェクトプロパティ構文を使用してプロパティ値を設定</span></td><td><span>マジック</span></td></tr><tr><td><code>__toString()</code></td><td><span>オブジェクトの文字列表現を返す</span></td><td><span>マジック</span></td></tr><tr><td><code>__unserialize()</code></td><td><span>シリアライズされたデータからオブジェクトをアンシリアライズ</span></td><td><span>マジック</span></td></tr><tr><td><code>__unset()</code></td><td><span>プロパティを削除</span></td><td><span>マジック</span></td></tr><tr><td><code>clear()</code></td><td><span>すべてのデータをクリア</span></td><td><span>パブリック</span></td></tr><tr><td><code>copy()</code></td><td><span>現在のオブジェクトインスタンスのコピーを作成して返す</span></td><td><span>パブリック</span></td></tr><tr><td><code>each()</code></td><td><span>各要素にコールバックを適用し、キーを保持した新しいインスタンスを返す（イミュータブル、非再帰的）</span></td><td><span>パブリック</span></td></tr><tr><td><code>eachRecursive()</code></td><td><span>各要素に再帰的にコールバックを適用し、新しいインスタンスを返す（イミュータブル、再帰的）</span></td><td><span>パブリック</span></td></tr><tr><td><code>fromArray()</code></td><td><span>ネイティブPHP配列からCoverArrayを作成</span></td><td><span>パブリック静的</span></td></tr><tr><td><code>fromExplode()</code></td><td><span>explode()を使用して文字列からCoverArrayを作成</span></td><td><span>パブリック静的</span></td></tr><tr><td><code>fromJson()</code></td><td><span>JSON文字列からCoverArrayインスタンスを作成</span></td><td><span>パブリック静的</span></td></tr><tr><td><code>get()</code></td><td><span>ドット記法を使用して現在のオブジェクトのキーでデータを返す</span></td><td><span>パブリック</span></td></tr><tr><td><code>getDataAsArray()</code></td><td><span>現在のオブジェクトのデータをネイティブPHP配列として返す</span></td><td><span>パブリック</span></td></tr><tr><td><code>getIterator()</code></td><td><span>配列のイテレータを返す（IteratorAggregateインターフェース）</span></td><td><span>パブリック</span></td></tr><tr><td><code>implode()</code></td><td><span>配列要素を文字列で結合</span></td><td><span>パブリック</span></td></tr><tr><td><code>isEmpty()</code></td><td><span>配列が空かどうかをチェック</span></td><td><span>パブリック</span></td></tr><tr><td><code>item()</code></td><td><span>指定されたインデックスのコレクション要素を結果として返す</span></td><td><span>パブリック</span></td></tr><tr><td><code>jsonSerialize()</code></td><td><span>JSONにシリアライズすべきデータを指定（JsonSerializableインターフェース）</span></td><td><span>パブリック</span></td></tr><tr><td><code>offsetExists()</code></td><td><span>指定されたオフセットが配列に存在するかチェック（ArrayAccessインターフェース）</span></td><td><span>パブリック</span></td></tr><tr><td><code>offsetGet()</code></td><td><span>指定されたオフセットの値を返す（ArrayAccessインターフェース）</span></td><td><span>パブリック</span></td></tr><tr><td><code>offsetSet()</code></td><td><span>指定されたオフセットに値を設定（ArrayAccessインターフェース）</span></td><td><span>パブリック</span></td></tr><tr><td><code>offsetUnset()</code></td><td><span>指定されたオフセットの値を削除（ArrayAccessインターフェース）</span></td><td><span>パブリック</span></td></tr><tr><td><code>setData()</code></td><td><span>CoverArrayの内部データを設定</span></td><td><span>パブリック</span></td></tr><tr><td><code>toJson()</code></td><td><span>CoverArrayをJSON文字列に変換</span></td><td><span>パブリック</span></td></tr></tbody></table>
