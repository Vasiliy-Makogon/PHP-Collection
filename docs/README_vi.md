![Cover Array](logo.jpg)

**Ngôn ngữ khác:**
- [English documentation](../README.md)
- [Русская документация](README_ru.md)
- [Documentation française](README_fr.md)
- [Deutsche Dokumentation](README_de.md)
- [Documentazione italiana](README_it.md)
- [日本語ドキュメント](README_jp.md)
- [Documentación en español](README_es.md)
- [한국어 문서](README_kr.md)
- [简体中文文档](README_cn.md)
- [繁體中文文件](README_tw.md)
- [Dokumentasi Bahasa Indonesia](README_id.md)
- [Documentação em Português (BR)](README_br.md)
- [हिंदी दस्तावेज़](README_hi.md)
- [التوثيق بالعربية](README_ar.md)
- [Türkçe Dokümantasyon](README_tr.md)

---

## Trạng thái
### Trạng thái kiểm thử
| Phiên bản PHP | Trạng thái                                                                                                                                                                               |
|---------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 8.0           | [![PHP 8.0](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml) |
| 8.1           | [![PHP 8.1](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml) |
| 8.2           | [![PHP 8.2](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml) |
| 8.3           | [![PHP 8.3](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml) |
| 8.4           | [![PHP 8.4](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml) |
| 8.5           | [![PHP 8.5](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml) |

### Độ phủ mã nguồn
[![codecov](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection/branch/master/graph/badge.svg)](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection)

## Yêu cầu
PHP >= 8.0

## Cài đặt
```
composer require krugozor/cover
```

# CoverArray: Lớp bọc hướng đối tượng cho mảng PHP (PHP Collection)
Được tạo bởi con người, kiểm tra và thử nghiệm bởi trí tuệ nhân tạo. Phát hành 2026

## Tại sao CoverArray được tạo ra

Trong quá trình phát triển PHP hiện đại, chúng ta thường xuyên làm việc với mảng như cấu trúc dữ liệu chính. Tuy nhiên, các hàm xử lý mảng gốc của PHP có một số hạn chế mà CoverArray giải quyết.

### Vấn đề của mảng PHP gốc

- **Tên hàm không nhất quán**: Một số hàm sử dụng dấu gạch dưới (`array_map`), một số khác thì không (`usort`)
- **Thứ tự tham số khác nhau**: Các hàm như `array_map($callback, $array)` so với `array_filter($array, $callback)`
- **Không hỗ trợ chuỗi gọi hàm**: Các hàm gốc trả về mảng mới, đòi hỏi phải dùng biến trung gian
- **An toàn kiểu hạn chế**: Không có tự động hoàn thành trong IDE hay hỗ trợ phân tích tĩnh
- **Cú pháp cồng kềnh**: Các thao tác phức tạp đòi hỏi gọi hàm lồng nhau

### CoverArray giải quyết những gì

CoverArray cung cấp giao diện hướng đối tượng gọn gàng, bọc các mảng PHP trong khi vẫn giữ đầy đủ tương thích với các hàm gốc:

```php
// Dữ liệu: người dùng với tuổi và trạng thái
// Nhiệm vụ: lấy tên các người dùng đang hoạt động trên 18 tuổi, sắp xếp theo điểm giảm dần
$users = [
    ['name' => 'Alice', 'age' => 25, 'active' => true, 'score' => 85],
    ['name' => 'Bob', 'age' => 17, 'active' => false, 'score' => 45],
    ['name' => 'Charlie', 'age' => 32, 'active' => true, 'score' => 92],
    ['name' => 'Diana', 'age' => 19, 'active' => true, 'score' => 78],
    ['name' => 'Eve', 'age' => 22, 'active' => false, 'score' => 61],
];
```

#### Trước (PHP gốc):
```php
$filtered = array_filter($users, fn($u) => $u['active'] && $u['age'] >= 18);
$sorted = usort($filtered, fn($a, $b) => $b['score'] <=> $a['score']) ? $filtered : [];
$names = array_column($sorted, 'name');
$result = implode(', ', $names); // Charlie, Alice, Diana
```
#### Sau (CoverArray):
```php
// TẤT CẢ TRONG MỘT DÒNG!
$result = CoverArray::fromArray($users)
    ->filter(fn($u) => $u->active && $u->age >= 18)
    ->usort(fn($a, $b) => $b->score <=> $a->score)
    ->values()
    ->column('name')
    ->implode(', '); // Charlie, Alice, Diana
```
### Ưu điểm chính
* **Không phụ thuộc bên ngoài:** Hiện thực PHP thuần túy, không cần gói bổ sung
* **API đồng nhất:** Tất cả các phương thức theo khuôn mẫu `$array->method($arguments)`
* **Chuỗi gọi hàm:** Kết hợp nhiều thao tác thành dạng dễ đọc
* **Hỗ trợ IDE:** Tự động hoàn thành và gợi ý kiểu đầy đủ
* **Cú pháp hiện đại:** Thiết kế cho PHP 8.0+ với kiểu nghiêm ngặt
* **Ký pháp dấu chấm:** Truy cập tiện lợi dữ liệu lồng nhau qua `$array->get('user.profile.name')`
* **Hỗ trợ JSON:** Tích hợp sẵn serialize/deserialize
* **Thao tác bất biến:** Hầu hết các phương thức trả về bản sao mới, giữ nguyên dữ liệu gốc
* **Tương thích hoàn toàn:** Hoạt động hoàn hảo với mã hiện có dựa trên mảng

### Ví dụ thực tế

#### Ví dụ 1: Quản lý cấu hình với ký pháp dấu chấm
```php
// Tải và truy cập an toàn cấu hình lồng nhau
$config = CoverArray::fromJson(file_get_contents('config.json'));

// Truy cập trực tiếp dữ liệu lồng nhau với giá trị mặc định
$dbHost = $config->get('database.connections.mysql.host', fn($value) => $value ?? 'localhost');
$dbPort = $config->get('database.connections.mysql.port', fn($value) => $value ?? 3306);

// Truy cập với callback cho giá trị mặc định phức tạp
$apiKeys = $config->get('services.payment.keys', function($keys) {
    return $keys ?? CoverArray::fromArray([
        'public' => 'default_public_key',
        'secret' => 'default_secret_key'
    ]);
});
```

#### Ví dụ 2: Quy trình xử lý phản hồi API
```php
// Xử lý API thực tế: lọc, biến đổi và trích xuất dữ liệu
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

// Trích xuất cột cụ thể cho danh sách thả xuống
$userOptions = $apiResponse->column('name', 'id')->getDataAsArray();
```

#### Ví dụ 3: Phân tích nhật ký và báo cáo lỗi
```php
// Phân tích nhật ký ứng dụng và xác định các mẫu lỗi
$logLines = CoverArray::fromExplode("\n", file_get_contents('app.log'))
    ->filter(fn($line) => !empty(trim($line)));

// Trích xuất và phân loại lỗi
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

// Nhóm theo loại lỗi và đếm số lần xuất hiện
$errorStats = $errors
    ->column('type')
    ->countValues()
    ->arsort(); // Sắp xếp theo tần suất

// Tạo báo cáo lỗi
$report = "Báo cáo lỗi:\n";
foreach ($errorStats as $type => $count) {
    $report .= "- {$type}: {$count} lần xuất hiện\n";
}

// Tìm lỗi nghiêm trọng gần nhất
$lastCritical = $errors
    ->filter(fn($e) => $e['type'] === 'Critical')
    ->last();
```

CoverArray kết hợp sức mạnh của các hàm xử lý mảng PHP với các phương pháp hướng đối tượng hiện đại, giúp thao tác mảng trở nên biểu cảm hơn, dễ bảo trì hơn và thú vị hơn.

## Bảng so sánh: Phương thức CoverArray và hàm PHP cho mảng

<table><thead><tr><th><span>#</span></th><th><span>Hàm PHP</span></th><th><span>Phương thức CoverArray</span></th><th><span>Trạng thái</span></th><th><span>Ghi chú</span></th></tr></thead><tbody><tr><td><span>1</span></td><td><code>array_all</code></td><td><code>all()</code></td><td><span>✅</span></td><td><span>Hiện thực với polyfill cho các phiên bản PHP cũ</span></td></tr><tr><td><span>2</span></td><td><code>array_any</code></td><td><code>any()</code></td><td><span>✅</span></td><td><span>Hiện thực với polyfill cho các phiên bản PHP cũ</span></td></tr><tr><td><span>3</span></td><td><code>array_change_key_case</code></td><td><code>changeKeyCase()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>4</span></td><td><code>array_chunk</code></td><td><code>chunk()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>5</span></td><td><code>array_column</code></td><td><code>column()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>6</span></td><td><code>array_combine</code></td><td><code>combine()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (phương thức tĩnh)</span></td></tr><tr><td><span>7</span></td><td><code>array_count_values</code></td><td><code>countValues()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>8</span></td><td><code>array_diff</code></td><td><code>diff()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>9</span></td><td><code>array_diff_assoc</code></td><td><code>diffAssoc()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>10</span></td><td><code>array_diff_key</code></td><td><code>diffKey()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>11</span></td><td><code>array_diff_uassoc</code></td><td><code>diffUassoc()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>12</span></td><td><code>array_diff_ukey</code></td><td><code>diffUkey()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>13</span></td><td><code>array_fill</code></td><td><code>fill()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (phương thức tĩnh)</span></td></tr><tr><td><span>14</span></td><td><code>array_fill_keys</code></td><td><code>fillKeys()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (phương thức tĩnh)</span></td></tr><tr><td><span>15</span></td><td><code>array_filter</code></td><td><code>filter()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>16</span></td><td><code>array_find</code></td><td><code>find()</code></td><td><span>✅</span></td><td><span>Hiện thực với polyfill cho các phiên bản PHP cũ</span></td></tr><tr><td><span>17</span></td><td><code>array_find_key</code></td><td><code>findKey()</code></td><td><span>✅</span></td><td><span>Hiện thực với polyfill cho các phiên bản PHP cũ</span></td></tr><tr><td><span>18</span></td><td><code>array_first</code></td><td><code>first()</code></td><td><span>✅</span></td><td><span>Hiện thực với polyfill cho các phiên bản PHP cũ</span></td></tr><tr><td><span>19</span></td><td><code>array_flip</code></td><td><code>flip()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>20</span></td><td><code>array_intersect</code></td><td><code>intersect()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>21</span></td><td><code>array_intersect_assoc</code></td><td><code>intersectAssoc()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>22</span></td><td><code>array_intersect_key</code></td><td><code>intersectKey()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>23</span></td><td><code>array_intersect_uassoc</code></td><td><code>intersectUassoc()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>24</span></td><td><code>array_intersect_ukey</code></td><td><code>intersectUkey()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>25</span></td><td><code>array_is_list</code></td><td><code>isList()</code></td><td><span>✅</span></td><td><span>Hiện thực với polyfill cho các phiên bản PHP cũ</span></td></tr><tr><td><span>26</span></td><td><code>array_key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>27</span></td><td><code>array_key_first</code></td><td><code>keyFirst()</code></td><td><span>✅</span></td><td><span>Sử dụng hàm tích hợp sẵn</span></td></tr><tr><td><span>28</span></td><td><code>array_key_last</code></td><td><code>keyLast()</code></td><td><span>✅</span></td><td><span>Sử dụng hàm tích hợp sẵn</span></td></tr><tr><td><span>29</span></td><td><code>array_keys</code></td><td><code>keys()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>30</span></td><td><code>array_last</code></td><td><code>last()</code></td><td><span>✅</span></td><td><span>Hiện thực với polyfill cho các phiên bản PHP cũ</span></td></tr><tr><td><span>31</span></td><td><code>array_map</code></td><td><code>map()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>32</span></td><td><code>array_merge</code></td><td><code>merge()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>33</span></td><td><code>array_merge_recursive</code></td><td><code>mergeRecursive()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>34</span></td><td><code>array_multisort</code></td><td><code>multisort()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr><tr><td><span>35</span></td><td><code>array_pad</code></td><td><code>pad()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>36</span></td><td><code>array_pop</code></td><td><code>pop()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr><tr><td><span>37</span></td><td><code>array_product</code></td><td><code>product()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>38</span></td><td><code>array_push</code></td><td><code>push()</code><span> / </span><code>append()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr><tr><td><span>39</span></td><td><code>array_rand</code></td><td><code>rand()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>40</span></td><td><code>array_reduce</code></td><td><code>reduce()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>41</span></td><td><code>array_replace</code></td><td><code>replace()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>42</span></td><td><code>array_replace_recursive</code></td><td><code>replaceRecursive()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>43</span></td><td><code>array_reverse</code></td><td><code>reverse()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>44</span></td><td><code>array_search</code></td><td><code>search()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>45</span></td><td><code>array_shift</code></td><td><code>shift()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr><tr><td><span>46</span></td><td><code>array_slice</code></td><td><code>slice()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>47</span></td><td><code>array_splice</code></td><td><code>splice()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr><tr><td><span>48</span></td><td><code>array_sum</code></td><td><code>sum()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>49</span></td><td><code>array_udiff</code></td><td><code>udiff()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>50</span></td><td><code>array_udiff_assoc</code></td><td><code>udiffAssoc()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>51</span></td><td><code>array_udiff_uassoc</code></td><td><code>udiffUassoc()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>52</span></td><td><code>array_uintersect</code></td><td><code>uintersect()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>53</span></td><td><code>array_uintersect_assoc</code></td><td><code>uintersectAssoc()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>54</span></td><td><code>array_uintersect_uassoc</code></td><td><code>uintersectUassoc()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>55</span></td><td><code>array_unique</code></td><td><code>unique()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>56</span></td><td><code>array_unshift</code></td><td><code>unshift()</code><span> / </span><code>prepend()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr><tr><td><span>57</span></td><td><code>array_values</code></td><td><code>values()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>58</span></td><td><code>array_walk</code></td><td><code>walk()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr><tr><td><span>59</span></td><td><code>array_walk_recursive</code></td><td><code>walkRecursive()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr><tr><td><span>60</span></td><td><code>arsort</code></td><td><code>arsort()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr><tr><td><span>61</span></td><td><code>asort</code></td><td><code>asort()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr><tr><td><span>62</span></td><td><code>compact</code></td><td><code>compact()</code></td><td><span>⚠️</span></td><td><span>Không thể hiện thực (hạn chế phạm vi của PHP). Sử dụng: <code>CoverArray::fromArray(compact(...))</code></span></td></tr><tr><td><span>63</span></td><td><code>count</code></td><td><code>count()</code></td><td><span>✅</span></td><td><span>Hiện thực giao diện Countable</span></td></tr><tr><td><span>64</span></td><td><code>current</code></td><td><code>current()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>65</span></td><td><code>end</code></td><td><code>end()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr><tr><td><span>66</span></td><td><code>extract</code></td><td><code>extract()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>67</span></td><td><code>in_array</code></td><td><code>in()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>68</span></td><td><code>key</code></td><td><code>key()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ</span></td></tr><tr><td><span>69</span></td><td><code>key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (tương đương array_key_exists)</span></td></tr><tr><td><span>70</span></td><td><code>krsort</code></td><td><code>krsort()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr><tr><td><span>71</span></td><td><code>ksort</code></td><td><code>ksort()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr><tr><td><span>72</span></td><td><code>list</code></td><td><code>list()</code></td><td><span>⚠️</span></td><td><span>Không thể hiện thực (cấu trúc ngôn ngữ). Sử dụng: <code>list($a, $b) = $cover->getDataAsArray()</code></span></td></tr><tr><td><span>73</span></td><td><code>natcasesort</code></td><td><code>natcasesort()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr><tr><td><span>74</span></td><td><code>natsort</code></td><td><code>natsort()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr><tr><td><span>75</span></td><td><code>next</code></td><td><code>next()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr><tr><td><span>76</span></td><td><code>pos</code></td><td><code>pos()</code></td><td><span>✅</span></td><td><span>Bí danh của <code>current()</code></span></td></tr><tr><td><span>77</span></td><td><code>prev</code></td><td><code>prev()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr><tr><td><span>78</span></td><td><code>range</code></td><td><code>range()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (phương thức tĩnh)</span></td></tr><tr><td><span>79</span></td><td><code>reset</code></td><td><code>reset()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr><tr><td><span>80</span></td><td><code>rsort</code></td><td><code>rsort()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr><tr><td><span>81</span></td><td><code>shuffle</code></td><td><code>shuffle()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr><tr><td><span>82</span></td><td><code>sort</code></td><td><code>sort()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr><tr><td><span>83</span></td><td><code>uasort</code></td><td><code>uasort()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr><tr><td><span>84</span></td><td><code>uksort</code></td><td><code>uksort()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr><tr><td><span>85</span></td><td><code>usort</code></td><td><code>usort()</code></td><td><span>✅</span></td><td><span>Hiện thực đầy đủ (thay đổi trực tiếp)</span></td></tr></tbody></table>

### Các phương thức bổ sung của CoverArray

<table><thead><tr><th><span>Phương thức</span></th><th><span>Mục đích</span></th><th><span>Quyền truy cập</span></th></tr></thead><tbody><tr><td><code>__clone()</code></td><td><span>Tạo bản sao nông với nhân bản sâu các thuộc tính đối tượng trực tiếp</span></td><td><span>Ma thuật</span></td></tr><tr><td><code>__get()</code></td><td><span>Lấy giá trị thuộc tính thông qua cú pháp thuộc tính đối tượng</span></td><td><span>Ma thuật</span></td></tr><tr><td><code>__isset()</code></td><td><span>Kiểm tra thuộc tính đã được thiết lập chưa</span></td><td><span>Ma thuật</span></td></tr><tr><td><code>__serialize()</code></td><td><span>Tuần tự hóa đối tượng để lưu trữ</span></td><td><span>Ma thuật</span></td></tr><tr><td><code>__set()</code></td><td><span>Thiết lập giá trị thuộc tính thông qua cú pháp thuộc tính đối tượng</span></td><td><span>Ma thuật</span></td></tr><tr><td><code>__toString()</code></td><td><span>Trả về biểu diễn chuỗi của đối tượng</span></td><td><span>Ma thuật</span></td></tr><tr><td><code>__unserialize()</code></td><td><span>Giải tuần tự hóa đối tượng từ dữ liệu đã tuần tự hóa</span></td><td><span>Ma thuật</span></td></tr><tr><td><code>__unset()</code></td><td><span>Xóa thuộc tính</span></td><td><span>Ma thuật</span></td></tr><tr><td><code>clear()</code></td><td><span>Xóa toàn bộ dữ liệu</span></td><td><span>Công khai</span></td></tr><tr><td><code>copy()</code></td><td><span>Tạo và trả về bản sao của đối tượng hiện tại</span></td><td><span>Công khai</span></td></tr><tr><td><code>each()</code></td><td><span>Áp dụng callback cho từng phần tử và trả về bản sao mới giữ nguyên khóa (bất biến, không đệ quy)</span></td><td><span>Công khai</span></td></tr><tr><td><code>eachRecursive()</code></td><td><span>Áp dụng đệ quy callback cho từng phần tử và trả về bản sao mới (bất biến, đệ quy)</span></td><td><span>Công khai</span></td></tr><tr><td><code>fromArray()</code></td><td><span>Tạo CoverArray từ mảng PHP gốc</span></td><td><span>Công khai tĩnh</span></td></tr><tr><td><code>fromExplode()</code></td><td><span>Tạo CoverArray từ chuỗi bằng explode()</span></td><td><span>Công khai tĩnh</span></td></tr><tr><td><code>fromJson()</code></td><td><span>Tạo đối tượng CoverArray từ chuỗi JSON</span></td><td><span>Công khai tĩnh</span></td></tr><tr><td><code>get()</code></td><td><span>Trả về dữ liệu theo khóa của đối tượng hiện tại sử dụng ký pháp dấu chấm</span></td><td><span>Công khai</span></td></tr><tr><td><code>getDataAsArray()</code></td><td><span>Trả về dữ liệu của đối tượng hiện tại dưới dạng mảng PHP gốc</span></td><td><span>Công khai</span></td></tr><tr><td><code>getIterator()</code></td><td><span>Trả về iterator cho mảng (giao diện IteratorAggregate)</span></td><td><span>Công khai</span></td></tr><tr><td><code>implode()</code></td><td><span>Nối các phần tử mảng thành chuỗi</span></td><td><span>Công khai</span></td></tr><tr><td><code>isEmpty()</code></td><td><span>Kiểm tra mảng có rỗng hay không</span></td><td><span>Công khai</span></td></tr><tr><td><code>item()</code></td><td><span>Trả về phần tử trong bộ sưu tập tại chỉ mục chỉ định</span></td><td><span>Công khai</span></td></tr><tr><td><code>jsonSerialize()</code></td><td><span>Xác định dữ liệu để tuần tự hóa thành JSON (giao diện JsonSerializable)</span></td><td><span>Công khai</span></td></tr><tr><td><code>offsetExists()</code></td><td><span>Kiểm tra vị trí chỉ định có tồn tại trong mảng không (giao diện ArrayAccess)</span></td><td><span>Công khai</span></td></tr><tr><td><code>offsetGet()</code></td><td><span>Trả về giá trị tại vị trí chỉ định (giao diện ArrayAccess)</span></td><td><span>Công khai</span></td></tr><tr><td><code>offsetSet()</code></td><td><span>Thiết lập giá trị tại vị trí chỉ định (giao diện ArrayAccess)</span></td><td><span>Công khai</span></td></tr><tr><td><code>offsetUnset()</code></td><td><span>Xóa giá trị tại vị trí chỉ định (giao diện ArrayAccess)</span></td><td><span>Công khai</span></td></tr><tr><td><code>setData()</code></td><td><span>Thiết lập dữ liệu nội bộ cho CoverArray</span></td><td><span>Công khai</span></td></tr><tr><td><code>toJson()</code></td><td><span>Chuyển đổi CoverArray thành chuỗi JSON</span></td><td><span>Công khai</span></td></tr></tbody></table>
