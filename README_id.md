![Cover Array](logo.jpg)

**Bahasa lain:**
- [English documentation](README.md)
- [Русская документация](README_ru.md)
- [Documentation française](README_fr.md)
- [Deutsche Dokumentation](README_de.md)
- [Documentazione italiana](README_it.md)
- [日本語ドキュメント](README_jp.md)
- [Documentación en español](README_es.md)
- [한국어 문서](README_kr.md)
- [简体中文文档](README_cn.md)
- [繁體中文文件](README_tw.md)
- [Documentação em Português (BR)](README_br.md)

---

## Status
### Status Pengujian
| Versi PHP   | Status                                                                                                                                                                               |
|-------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 8.0         | [![PHP 8.0](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml) |
| 8.1         | [![PHP 8.1](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml) |
| 8.2         | [![PHP 8.2](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml) |
| 8.3         | [![PHP 8.3](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml) |
| 8.4         | [![PHP 8.4](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml) |
| 8.5         | [![PHP 8.5](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml) |

### Cakupan Kode
[![codecov](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection/branch/master/graph/badge.svg)](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection)

## Persyaratan
PHP >= 8.0

## Instalasi
```
composer require krugozor/cover
```

# CoverArray: Pembungkus Array Berorientasi Objek untuk PHP (PHP Collection)
Dibuat oleh manusia, diverifikasi dan diuji oleh kecerdasan buatan. Rilis 2026

## Mengapa CoverArray Dibuat

Dalam pengembangan PHP modern, kita sering bekerja dengan array sebagai struktur data utama. Namun, fungsi array bawaan PHP memiliki beberapa keterbatasan yang dipecahkan oleh CoverArray.

### Masalah dengan Array Bawaan PHP

- **Penamaan fungsi yang tidak konsisten**: Beberapa fungsi menggunakan garis bawah (`array_map`), yang lain tidak (`usort`)
- **Urutan parameter yang beragam**: Fungsi seperti `array_map($callback, $array)` vs `array_filter($array, $callback)`
- **Tidak ada metode berantai**: Fungsi bawaan mengembalikan array baru, memerlukan variabel perantara
- **Keamanan tipe terbatas**: Tidak ada dukungan pelengkapan otomatis IDE atau analisis statis
- **Sintaks yang bertele-tele**: Operasi kompleks memerlukan pemanggilan fungsi bersarang

### Apa yang Dipecahkan oleh CoverArray

CoverArray menyediakan antarmuka yang bersih dan berorientasi objek yang membungkus array PHP sambil mempertahankan kompatibilitas penuh dengan fungsi bawaan:

```php
// Data: pengguna dengan usia dan status
// Tugas: dapatkan nama pengguna aktif di atas 18 tahun, diurutkan berdasarkan skor menurun
$users = [
    ['name' => 'Alice', 'age' => 25, 'active' => true, 'score' => 85],
    ['name' => 'Bob', 'age' => 17, 'active' => false, 'score' => 45],
    ['name' => 'Charlie', 'age' => 32, 'active' => true, 'score' => 92],
    ['name' => 'Diana', 'age' => 19, 'active' => true, 'score' => 78],
    ['name' => 'Eve', 'age' => 22, 'active' => false, 'score' => 61],
];
```

#### Sebelum (PHP Bawaan):
```php
$filtered = array_filter($users, fn($u) => $u['active'] && $u['age'] >= 18);
$sorted = usort($filtered, fn($a, $b) => $b['score'] <=> $a['score']) ? $filtered : [];
$names = array_column($sorted, 'name');
$result = implode(', ', $names); // Charlie, Alice, Diana
```
#### Sesudah (CoverArray):
```php
// SEMUANYA DALAM SATU BARIS!
$result = CoverArray::fromArray($users)
    ->filter(fn($u) => $u->active && $u->age >= 18)
    ->usort(fn($a, $b) => $b->score <=> $a->score)
    ->values()
    ->column('name')
    ->implode(', '); // Charlie, Alice, Diana
```
### Manfaat Utama
* **Tanpa Ketergantungan Eksternal:** Implementasi PHP murni, tidak memerlukan paket tambahan
* **API Konsisten:** Semua metode mengikuti pola `$array->method($arguments)`
* **Metode Berantai:** Rangkai beberapa operasi dengan cara yang mudah dibaca
* **Dukungan IDE:** Pelengkapan otomatis dan petunjuk tipe lengkap
* **Sintaks Modern:** Dirancang untuk PHP 8.0+ dengan tipe yang ketat
* **Notasi Titik:** Akses data bersarang yang mudah dengan `$array->get('user.profile.name')`
* **Dukungan JSON:** Serialisasi/deserialisasi bawaan
* **Operasi Immutable:** Sebagian besar metode mengembalikan instans baru, menjaga data asli
* **Kompatibilitas Penuh:** Bekerja dengan mulus dengan kode berbasis array yang ada

### Kasus Penggunaan Dunia Nyata

#### Contoh 1: Manajemen Konfigurasi dengan Notasi Titik
```php
// Muat dan akses konfigurasi bersarang dengan aman
$config = CoverArray::fromJson(file_get_contents('config.json'));

// Akses bersarang langsung dengan fallback default
$dbHost = $config->get('database.connections.mysql.host', fn($value) => $value ?? 'localhost');
$dbPort = $config->get('database.connections.mysql.port', fn($value) => $value ?? 3306);

// Akses dengan callback untuk default kompleks
$apiKeys = $config->get('services.payment.keys', function($keys) {
    return $keys ?? CoverArray::fromArray([
        'public' => 'default_public_key',
        'secret' => 'default_secret_key'
    ]);
});
```

#### Contoh 2: Pipeline Pemrosesan Respons API
```php
// Pemrosesan API dunia nyata: filter, transformasi, dan ekstrak data
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

// Ekstrak kolom tertentu untuk dropdown
$userOptions = $apiResponse->column('name', 'id')->getDataAsArray();
```

#### Contoh 3: Pemrosesan Pesanan E-commerce
```php
// Proses pesanan: hitung statistik dan buat laporan
$orders = CoverArray::fromArray($database->getOrders());

// Filter pesanan bernilai tinggi yang selesai dari bulan lalu
$recentOrders = $orders
    ->filter(fn($order) => $order['status'] === 'completed')
    ->filter(fn($order) => $order['amount'] > 100)
    ->filter(fn($order) => strtotime($order['date']) > strtotime('-30 days'));

// Hitung metrik bisnis
$totalRevenue = $recentOrders->column('amount')->sum();
$averageOrder = $totalRevenue / $recentOrders->count();
$topCustomers = $recentOrders
    ->map(fn($o) => ['customer' => $o['customer_name'], 'amount' => $o['amount']])
    ->usort(fn($a, $b) => $b['amount'] <=> $a['amount'])
    ->slice(0, 10);

echo "Revenue: $" . number_format($totalRevenue, 2) . "\n";
echo "Average Order: $" . number_format($averageOrder, 2) . "\n";
echo "Top Customer: " . $topCustomers->first()['customer'];
```

#### Contoh 4: Analisis Log dan Pelaporan Kesalahan
```php
// Parse log aplikasi dan ekstrak pola kesalahan
$logLines = CoverArray::fromExplode("\n", file_get_contents('app.log'))
    ->filter(fn($line) => !empty(trim($line)));

// Ekstrak dan kategorikan kesalahan
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

// Kelompokkan berdasarkan tipe kesalahan dan hitung kejadian
$errorStats = $errors
    ->column('type')
    ->countValues()
    ->arsort(); // Urutkan berdasarkan frekuensi

// Buat laporan kesalahan
$report = "Error Report:\n";
foreach ($errorStats as $type => $count) {
    $report .= "- {$type}: {$count} occurrences\n";
}

// Temukan kesalahan kritis terbaru
$lastCritical = $errors
    ->filter(fn($e) => $e['type'] === 'Critical')
    ->last();
```

CoverArray menjembatani kesenjangan antara fungsi array PHP yang kuat dan praktik berorientasi objek modern, membuat manipulasi array lebih ekspresif, mudah dipelihara, dan menyenangkan.

## Tabel Perbandingan: Metode CoverArray vs Fungsi Array PHP

<table><thead><tr><th><span>#</span></th><th><span>Fungsi PHP</span></th><th><span>Metode CoverArray</span></th><th><span>Status</span></th><th><span>Catatan</span></th></tr></thead><tbody><tr><td><span>1</span></td><td><code>array_all</code></td><td><code>all()</code></td><td><span>✅</span></td><td><span>Diimplementasikan dengan polyfill untuk versi PHP lama</span></td></tr><tr><td><span>2</span></td><td><code>array_any</code></td><td><code>any()</code></td><td><span>✅</span></td><td><span>Diimplementasikan dengan polyfill untuk versi PHP lama</span></td></tr><tr><td><span>3</span></td><td><code>array_change_key_case</code></td><td><code>changeKeyCase()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>4</span></td><td><code>array_chunk</code></td><td><code>chunk()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>5</span></td><td><code>array_column</code></td><td><code>column()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>6</span></td><td><code>array_combine</code></td><td><code>combine()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (metode statis)</span></td></tr><tr><td><span>7</span></td><td><code>array_count_values</code></td><td><code>countValues()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>8</span></td><td><code>array_diff</code></td><td><code>diff()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>9</span></td><td><code>array_diff_assoc</code></td><td><code>diffAssoc()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>10</span></td><td><code>array_diff_key</code></td><td><code>diffKey()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>11</span></td><td><code>array_diff_uassoc</code></td><td><code>diffUassoc()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>12</span></td><td><code>array_diff_ukey</code></td><td><code>diffUkey()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>13</span></td><td><code>array_fill</code></td><td><code>fill()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (metode statis)</span></td></tr><tr><td><span>14</span></td><td><code>array_fill_keys</code></td><td><code>fillKeys()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (metode statis)</span></td></tr><tr><td><span>15</span></td><td><code>array_filter</code></td><td><code>filter()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>16</span></td><td><code>array_find</code></td><td><code>find()</code></td><td><span>✅</span></td><td><span>Diimplementasikan dengan polyfill untuk versi PHP lama</span></td></tr><tr><td><span>17</span></td><td><code>array_find_key</code></td><td><code>findKey()</code></td><td><span>✅</span></td><td><span>Diimplementasikan dengan polyfill untuk versi PHP lama</span></td></tr><tr><td><span>18</span></td><td><code>array_first</code></td><td><code>first()</code></td><td><span>✅</span></td><td><span>Diimplementasikan dengan polyfill untuk versi PHP lama</span></td></tr><tr><td><span>19</span></td><td><code>array_flip</code></td><td><code>flip()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>20</span></td><td><code>array_intersect</code></td><td><code>intersect()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>21</span></td><td><code>array_intersect_assoc</code></td><td><code>intersectAssoc()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>22</span></td><td><code>array_intersect_key</code></td><td><code>intersectKey()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>23</span></td><td><code>array_intersect_uassoc</code></td><td><code>intersectUassoc()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>24</span></td><td><code>array_intersect_ukey</code></td><td><code>intersectUkey()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>25</span></td><td><code>array_is_list</code></td><td><code>isList()</code></td><td><span>✅</span></td><td><span>Diimplementasikan dengan polyfill untuk versi PHP lama</span></td></tr><tr><td><span>26</span></td><td><code>array_key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>27</span></td><td><code>array_key_first</code></td><td><code>keyFirst()</code></td><td><span>✅</span></td><td><span>Menggunakan fungsi bawaan</span></td></tr><tr><td><span>28</span></td><td><code>array_key_last</code></td><td><code>keyLast()</code></td><td><span>✅</span></td><td><span>Menggunakan fungsi bawaan</span></td></tr><tr><td><span>29</span></td><td><code>array_keys</code></td><td><code>keys()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>30</span></td><td><code>array_last</code></td><td><code>last()</code></td><td><span>✅</span></td><td><span>Diimplementasikan dengan polyfill untuk versi PHP lama</span></td></tr><tr><td><span>31</span></td><td><code>array_map</code></td><td><code>map()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>32</span></td><td><code>array_merge</code></td><td><code>merge()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>33</span></td><td><code>array_merge_recursive</code></td><td><code>mergeRecursive()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>34</span></td><td><code>array_multisort</code></td><td><code>multisort()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr><tr><td><span>35</span></td><td><code>array_pad</code></td><td><code>pad()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>36</span></td><td><code>array_pop</code></td><td><code>pop()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr><tr><td><span>37</span></td><td><code>array_product</code></td><td><code>product()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>38</span></td><td><code>array_push</code></td><td><code>push()</code><span> / </span><code>append()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr><tr><td><span>39</span></td><td><code>array_rand</code></td><td><code>rand()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>40</span></td><td><code>array_reduce</code></td><td><code>reduce()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>41</span></td><td><code>array_replace</code></td><td><code>replace()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>42</span></td><td><code>array_replace_recursive</code></td><td><code>replaceRecursive()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>43</span></td><td><code>array_reverse</code></td><td><code>reverse()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>44</span></td><td><code>array_search</code></td><td><code>search()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>45</span></td><td><code>array_shift</code></td><td><code>shift()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr><tr><td><span>46</span></td><td><code>array_slice</code></td><td><code>slice()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>47</span></td><td><code>array_splice</code></td><td><code>splice()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr><tr><td><span>48</span></td><td><code>array_sum</code></td><td><code>sum()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>49</span></td><td><code>array_udiff</code></td><td><code>udiff()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>50</span></td><td><code>array_udiff_assoc</code></td><td><code>udiffAssoc()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>51</span></td><td><code>array_udiff_uassoc</code></td><td><code>udiffUassoc()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>52</span></td><td><code>array_uintersect</code></td><td><code>uintersect()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>53</span></td><td><code>array_uintersect_assoc</code></td><td><code>uintersectAssoc()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>54</span></td><td><code>array_uintersect_uassoc</code></td><td><code>uintersectUassoc()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>55</span></td><td><code>array_unique</code></td><td><code>unique()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>56</span></td><td><code>array_unshift</code></td><td><code>unshift()</code><span> / </span><code>prepend()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr><tr><td><span>57</span></td><td><code>array_values</code></td><td><code>values()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>58</span></td><td><code>array_walk</code></td><td><code>walk()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr><tr><td><span>59</span></td><td><code>array_walk_recursive</code></td><td><code>walkRecursive()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr><tr><td><span>60</span></td><td><code>arsort</code></td><td><code>arsort()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr><tr><td><span>61</span></td><td><code>asort</code></td><td><code>asort()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr><tr><td><span>62</span></td><td><code>compact</code></td><td><code>compact()</code></td><td><span>⚠️</span></td><td><span>Tidak dapat diimplementasikan (keterbatasan scope PHP). Gunakan: <code>CoverArray::fromArray(compact(...))</code></span></td></tr><tr><td><span>63</span></td><td><code>count</code></td><td><code>count()</code></td><td><span>✅</span></td><td><span>Implementasi antarmuka Countable</span></td></tr><tr><td><span>64</span></td><td><code>current</code></td><td><code>current()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>65</span></td><td><code>end</code></td><td><code>end()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr><tr><td><span>66</span></td><td><code>extract</code></td><td><code>extract()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>67</span></td><td><code>in_array</code></td><td><code>in()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>68</span></td><td><code>key</code></td><td><code>key()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap</span></td></tr><tr><td><span>69</span></td><td><code>key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (sama dengan array_key_exists)</span></td></tr><tr><td><span>70</span></td><td><code>krsort</code></td><td><code>krsort()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr><tr><td><span>71</span></td><td><code>ksort</code></td><td><code>ksort()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr><tr><td><span>72</span></td><td><code>list</code></td><td><code>list()</code></td><td><span>⚠️</span></td><td><span>Tidak dapat diimplementasikan (konstruksi bahasa). Gunakan: <code>list($a, $b) = $cover->getDataAsArray()</code></span></td></tr><tr><td><span>73</span></td><td><code>natcasesort</code></td><td><code>natcasesort()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr><tr><td><span>74</span></td><td><code>natsort</code></td><td><code>natsort()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr><tr><td><span>75</span></td><td><code>next</code></td><td><code>next()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr><tr><td><span>76</span></td><td><code>pos</code></td><td><code>pos()</code></td><td><span>✅</span></td><td><span>Alias dari <code>current()</code></span></td></tr><tr><td><span>77</span></td><td><code>prev</code></td><td><code>prev()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr><tr><td><span>78</span></td><td><code>range</code></td><td><code>range()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (metode statis)</span></td></tr><tr><td><span>79</span></td><td><code>reset</code></td><td><code>reset()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr><tr><td><span>80</span></td><td><code>rsort</code></td><td><code>rsort()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr><tr><td><span>81</span></td><td><code>shuffle</code></td><td><code>shuffle()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr><tr><td><span>82</span></td><td><code>sort</code></td><td><code>sort()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr><tr><td><span>83</span></td><td><code>uasort</code></td><td><code>uasort()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr><tr><td><span>84</span></td><td><code>uksort</code></td><td><code>uksort()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr><tr><td><span>85</span></td><td><code>usort</code></td><td><code>usort()</code></td><td><span>✅</span></td><td><span>Implementasi lengkap (mutating)</span></td></tr></tbody></table>

### Metode CoverArray Tambahan

<table><thead><tr><th><span>Metode</span></th><th><span>Tujuan</span></th><th><span>Akses</span></th></tr></thead><tbody><tr><td><code>__clone()</code></td><td><span>Membuat salinan dangkal dengan kloning mendalam pada properti objek langsung</span></td><td><span>Magic</span></td></tr><tr><td><code>__get()</code></td><td><span>Mendapatkan nilai properti menggunakan sintaks properti objek</span></td><td><span>Magic</span></td></tr><tr><td><code>__isset()</code></td><td><span>Memeriksa apakah properti telah disetel</span></td><td><span>Magic</span></td></tr><tr><td><code>__serialize()</code></td><td><span>Serialisasi objek untuk serialisasi</span></td><td><span>Magic</span></td></tr><tr><td><code>__set()</code></td><td><span>Mengatur nilai properti menggunakan sintaks properti objek</span></td><td><span>Magic</span></td></tr><tr><td><code>__toString()</code></td><td><span>Mengembalikan representasi string dari objek</span></td><td><span>Magic</span></td></tr><tr><td><code>__unserialize()</code></td><td><span>Deserialisasi objek dari data serial</span></td><td><span>Magic</span></td></tr><tr><td><code>__unset()</code></td><td><span>Menghapus properti</span></td><td><span>Magic</span></td></tr><tr><td><code>clear()</code></td><td><span>Menghapus semua data</span></td><td><span>Public</span></td></tr><tr><td><code>copy()</code></td><td><span>Membuat dan mengembalikan salinan dari instans objek saat ini</span></td><td><span>Public</span></td></tr><tr><td><code>each()</code></td><td><span>Menerapkan callback ke setiap elemen dan mengembalikan instans baru dengan kunci yang dipertahankan (immutable, non-rekursif)</span></td><td><span>Public</span></td></tr><tr><td><code>eachRecursive()</code></td><td><span>Menerapkan callback secara rekursif ke setiap elemen dan mengembalikan instans baru (immutable, rekursif)</span></td><td><span>Public</span></td></tr><tr><td><code>fromArray()</code></td><td><span>Membuat CoverArray dari array PHP asli</span></td><td><span>Public Static</span></td></tr><tr><td><code>fromExplode()</code></td><td><span>Membuat CoverArray dari string menggunakan explode()</span></td><td><span>Public Static</span></td></tr><tr><td><code>fromJson()</code></td><td><span>Membuat instans CoverArray dari string JSON</span></td><td><span>Public Static</span></td></tr><tr><td><code>get()</code></td><td><span>Mengembalikan data berdasarkan kunci objek saat ini menggunakan notasi titik</span></td><td><span>Public</span></td></tr><tr><td><code>getDataAsArray()</code></td><td><span>Mengembalikan data objek saat ini sebagai array PHP asli</span></td><td><span>Public</span></td></tr><tr><td><code>getIterator()</code></td><td><span>Mengembalikan iterator untuk array (antarmuka IteratorAggregate)</span></td><td><span>Public</span></td></tr><tr><td><code>implode()</code></td><td><span>Menggabungkan elemen array dengan string</span></td><td><span>Public</span></td></tr><tr><td><code>isEmpty()</code></td><td><span>Memeriksa apakah array kosong</span></td><td><span>Public</span></td></tr><tr><td><code>item()</code></td><td><span>Mengembalikan elemen koleksi dengan indeks yang diberikan sebagai hasilnya</span></td><td><span>Public</span></td></tr><tr><td><code>jsonSerialize()</code></td><td><span>Menentukan data yang harus diserialisasikan ke JSON (antarmuka JsonSerializable)</span></td><td><span>Public</span></td></tr><tr><td><code>offsetExists()</code></td><td><span>Memeriksa apakah offset yang ditentukan ada di array (antarmuka ArrayAccess)</span></td><td><span>Public</span></td></tr><tr><td><code>offsetGet()</code></td><td><span>Mengembalikan nilai pada offset yang ditentukan (antarmuka ArrayAccess)</span></td><td><span>Public</span></td></tr><tr><td><code>offsetSet()</code></td><td><span>Mengatur nilai pada offset yang ditentukan (antarmuka ArrayAccess)</span></td><td><span>Public</span></td></tr><tr><td><code>offsetUnset()</code></td><td><span>Menghapus nilai pada offset yang ditentukan (antarmuka ArrayAccess)</span></td><td><span>Public</span></td></tr><tr><td><code>setData()</code></td><td><span>Mengatur data internal untuk CoverArray</span></td><td><span>Public</span></td></tr><tr><td><code>toJson()</code></td><td><span>Mengonversi CoverArray ke string JSON</span></td><td><span>Public</span></td></tr></tbody></table>
