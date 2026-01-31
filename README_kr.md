![Cover Array](logo.jpg)

**다른 언어:**
- [English documentation](README.md)
- [Русская документация](README_ru.md)
- [Documentation française](README_fr.md)
- [Deutsche Dokumentation](README_de.md)
- [Documentazione italiana](README_it.md)
- [日本語ドキュメント](README_jp.md)
- [Documentación en español](README_es.md)
- [简体中文文档](README_cn.md)
- [繁體中文文件](README_tw.md)
- [Dokumentasi Bahasa Indonesia](README_id.md)
- [Documentação em Português (BR)](README_br.md)

---

## 상태
### 테스트 상태
| PHP 버전 | 상태                                                                                                                                                                               |
|-------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 8.0         | [![PHP 8.0](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml) |
| 8.1         | [![PHP 8.1](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml) |
| 8.2         | [![PHP 8.2](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml) |
| 8.3         | [![PHP 8.3](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml) |
| 8.4         | [![PHP 8.4](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml) |
| 8.5         | [![PHP 8.5](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml) |

### 코드 커버리지
[![codecov](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection/branch/master/graph/badge.svg)](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection)

## 요구사항
PHP >= 8.0

## 설치
```
composer require krugozor/cover
```

# CoverArray: PHP용 객체지향 배열 래퍼 (PHP Collection)
사람이 만들고, 인공지능이 검증 및 테스트했습니다. 2026년 릴리스

## CoverArray가 만들어진 이유

현대 PHP 개발에서 우리는 종종 배열을 주요 데이터 구조로 사용합니다. 하지만 PHP의 네이티브 배열 함수들은 CoverArray가 해결하는 여러 제한사항이 있습니다.

### 네이티브 PHP 배열의 문제점

- **일관성 없는 함수 명명**: 일부 함수는 언더스코어를 사용하고 (`array_map`), 다른 함수는 사용하지 않습니다 (`usort`)
- **혼재된 매개변수 순서**: `array_map($callback, $array)` vs `array_filter($array, $callback)` 같은 함수들
- **메서드 체이닝 불가**: 네이티브 함수는 새 배열을 반환하므로 중간 변수가 필요합니다
- **제한된 타입 안전성**: IDE 자동완성 또는 정적 분석 지원이 없습니다
- **장황한 문법**: 복잡한 작업은 중첩된 함수 호출이 필요합니다

### CoverArray가 해결하는 것

CoverArray는 네이티브 함수와의 완전한 호환성을 유지하면서 PHP 배열을 래핑하는 깔끔한 객체지향 인터페이스를 제공합니다:

```php
// 데이터: 나이와 상태를 가진 사용자들
// 작업: 18세 이상의 활성 사용자 이름을 점수 내림차순으로 정렬하여 가져오기
$users = [
    ['name' => 'Alice', 'age' => 25, 'active' => true, 'score' => 85],
    ['name' => 'Bob', 'age' => 17, 'active' => false, 'score' => 45],
    ['name' => 'Charlie', 'age' => 32, 'active' => true, 'score' => 92],
    ['name' => 'Diana', 'age' => 19, 'active' => true, 'score' => 78],
    ['name' => 'Eve', 'age' => 22, 'active' => false, 'score' => 61],
];
```

#### 이전 (네이티브 PHP):
```php
$filtered = array_filter($users, fn($u) => $u['active'] && $u['age'] >= 18);
$sorted = usort($filtered, fn($a, $b) => $b['score'] <=> $a['score']) ? $filtered : [];
$names = array_column($sorted, 'name');
$result = implode(', ', $names); // Charlie, Alice, Diana
```
#### 이후 (CoverArray):
```php
// 모든 것을 한 줄로!
$result = CoverArray::fromArray($users)
    ->filter(fn($u) => $u->active && $u->age >= 18)
    ->usort(fn($a, $b) => $b->score <=> $a->score)
    ->values()
    ->column('name')
    ->implode(', '); // Charlie, Alice, Diana
```
### 주요 이점
* **외부 의존성 없음:** 순수 PHP 구현으로 추가 패키지가 필요하지 않습니다
* **일관된 API:** 모든 메서드가 `$array->method($arguments)` 패턴을 따릅니다
* **메서드 체이닝:** 여러 작업을 읽기 쉬운 방식으로 연결합니다
* **IDE 지원:** 완전한 자동완성 및 타입 힌트 제공
* **현대적 문법:** 엄격한 타입 지정을 사용하는 PHP 8.0+ 용으로 설계됨
* **점 표기법:** `$array->get('user.profile.name')`으로 중첩 데이터에 쉽게 접근
* **JSON 지원:** 내장된 직렬화/역직렬화
* **불변 연산:** 대부분의 메서드는 원본 데이터를 보존하면서 새 인스턴스를 반환합니다
* **완전한 호환성:** 기존 배열 기반 코드와 원활하게 작동합니다

### 실제 사용 사례

#### 예제 1: 점 표기법을 사용한 설정 관리
```php
// 중첩된 설정을 안전하게 로드하고 접근
$config = CoverArray::fromJson(file_get_contents('config.json'));

// 기본값 폴백과 함께 직접 중첩 접근
$dbHost = $config->get('database.connections.mysql.host', fn($value) => $value ?? 'localhost');
$dbPort = $config->get('database.connections.mysql.port', fn($value) => $value ?? 3306);

// 복잡한 기본값을 위한 콜백과 함께 접근
$apiKeys = $config->get('services.payment.keys', function($keys) {
    return $keys ?? CoverArray::fromArray([
        'public' => 'default_public_key',
        'secret' => 'default_secret_key'
    ]);
});
```

#### 예제 2: API 응답 처리 파이프라인
```php
// 실제 API 처리: 필터링, 변환 및 데이터 추출
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

// 드롭다운용 특정 열 추출
$userOptions = $apiResponse->column('name', 'id')->getDataAsArray();
```

#### 예제 3: 로그 분석 및 오류 보고
```php
// 애플리케이션 로그 파싱 및 오류 패턴 추출
$logLines = CoverArray::fromExplode("\n", file_get_contents('app.log'))
    ->filter(fn($line) => !empty(trim($line)));

// 오류 추출 및 분류
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

// 오류 유형별로 그룹화하고 발생 횟수 계산
$errorStats = $errors
    ->column('type')
    ->countValues()
    ->arsort(); // 빈도별 정렬

// 오류 보고서 생성
$report = "Error Report:\n";
foreach ($errorStats as $type => $count) {
    $report .= "- {$type}: {$count} occurrences\n";
}

// 가장 최근의 중요 오류 찾기
$lastCritical = $errors
    ->filter(fn($e) => $e['type'] === 'Critical')
    ->last();
```

CoverArray는 PHP의 강력한 배열 함수와 현대적인 객체지향 방식 사이의 간극을 메워, 배열 조작을 더욱 표현력 있고, 유지보수하기 쉽고, 즐겁게 만듭니다.

## 비교 표: CoverArray 메서드 vs PHP 배열 함수

<table><thead><tr><th><span>#</span></th><th><span>PHP 함수</span></th><th><span>CoverArray 메서드</span></th><th><span>상태</span></th><th><span>비고</span></th></tr></thead><tbody><tr><td><span>1</span></td><td><code>array_all</code></td><td><code>all()</code></td><td><span>✅</span></td><td><span>구 버전 PHP용 폴리필과 함께 구현됨</span></td></tr><tr><td><span>2</span></td><td><code>array_any</code></td><td><code>any()</code></td><td><span>✅</span></td><td><span>구 버전 PHP용 폴리필과 함께 구현됨</span></td></tr><tr><td><span>3</span></td><td><code>array_change_key_case</code></td><td><code>changeKeyCase()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>4</span></td><td><code>array_chunk</code></td><td><code>chunk()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>5</span></td><td><code>array_column</code></td><td><code>column()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>6</span></td><td><code>array_combine</code></td><td><code>combine()</code></td><td><span>✅</span></td><td><span>완전 구현 (정적 메서드)</span></td></tr><tr><td><span>7</span></td><td><code>array_count_values</code></td><td><code>countValues()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>8</span></td><td><code>array_diff</code></td><td><code>diff()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>9</span></td><td><code>array_diff_assoc</code></td><td><code>diffAssoc()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>10</span></td><td><code>array_diff_key</code></td><td><code>diffKey()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>11</span></td><td><code>array_diff_uassoc</code></td><td><code>diffUassoc()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>12</span></td><td><code>array_diff_ukey</code></td><td><code>diffUkey()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>13</span></td><td><code>array_fill</code></td><td><code>fill()</code></td><td><span>✅</span></td><td><span>완전 구현 (정적 메서드)</span></td></tr><tr><td><span>14</span></td><td><code>array_fill_keys</code></td><td><code>fillKeys()</code></td><td><span>✅</span></td><td><span>완전 구현 (정적 메서드)</span></td></tr><tr><td><span>15</span></td><td><code>array_filter</code></td><td><code>filter()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>16</span></td><td><code>array_find</code></td><td><code>find()</code></td><td><span>✅</span></td><td><span>구 버전 PHP용 폴리필과 함께 구현됨</span></td></tr><tr><td><span>17</span></td><td><code>array_find_key</code></td><td><code>findKey()</code></td><td><span>✅</span></td><td><span>구 버전 PHP용 폴리필과 함께 구현됨</span></td></tr><tr><td><span>18</span></td><td><code>array_first</code></td><td><code>first()</code></td><td><span>✅</span></td><td><span>구 버전 PHP용 폴리필과 함께 구현됨</span></td></tr><tr><td><span>19</span></td><td><code>array_flip</code></td><td><code>flip()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>20</span></td><td><code>array_intersect</code></td><td><code>intersect()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>21</span></td><td><code>array_intersect_assoc</code></td><td><code>intersectAssoc()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>22</span></td><td><code>array_intersect_key</code></td><td><code>intersectKey()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>23</span></td><td><code>array_intersect_uassoc</code></td><td><code>intersectUassoc()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>24</span></td><td><code>array_intersect_ukey</code></td><td><code>intersectUkey()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>25</span></td><td><code>array_is_list</code></td><td><code>isList()</code></td><td><span>✅</span></td><td><span>구 버전 PHP용 폴리필과 함께 구현됨</span></td></tr><tr><td><span>26</span></td><td><code>array_key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>27</span></td><td><code>array_key_first</code></td><td><code>keyFirst()</code></td><td><span>✅</span></td><td><span>내장 함수 사용</span></td></tr><tr><td><span>28</span></td><td><code>array_key_last</code></td><td><code>keyLast()</code></td><td><span>✅</span></td><td><span>내장 함수 사용</span></td></tr><tr><td><span>29</span></td><td><code>array_keys</code></td><td><code>keys()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>30</span></td><td><code>array_last</code></td><td><code>last()</code></td><td><span>✅</span></td><td><span>구 버전 PHP용 폴리필과 함께 구현됨</span></td></tr><tr><td><span>31</span></td><td><code>array_map</code></td><td><code>map()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>32</span></td><td><code>array_merge</code></td><td><code>merge()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>33</span></td><td><code>array_merge_recursive</code></td><td><code>mergeRecursive()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>34</span></td><td><code>array_multisort</code></td><td><code>multisort()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr><tr><td><span>35</span></td><td><code>array_pad</code></td><td><code>pad()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>36</span></td><td><code>array_pop</code></td><td><code>pop()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr><tr><td><span>37</span></td><td><code>array_product</code></td><td><code>product()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>38</span></td><td><code>array_push</code></td><td><code>push()</code><span> / </span><code>append()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr><tr><td><span>39</span></td><td><code>array_rand</code></td><td><code>rand()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>40</span></td><td><code>array_reduce</code></td><td><code>reduce()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>41</span></td><td><code>array_replace</code></td><td><code>replace()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>42</span></td><td><code>array_replace_recursive</code></td><td><code>replaceRecursive()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>43</span></td><td><code>array_reverse</code></td><td><code>reverse()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>44</span></td><td><code>array_search</code></td><td><code>search()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>45</span></td><td><code>array_shift</code></td><td><code>shift()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr><tr><td><span>46</span></td><td><code>array_slice</code></td><td><code>slice()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>47</span></td><td><code>array_splice</code></td><td><code>splice()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr><tr><td><span>48</span></td><td><code>array_sum</code></td><td><code>sum()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>49</span></td><td><code>array_udiff</code></td><td><code>udiff()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>50</span></td><td><code>array_udiff_assoc</code></td><td><code>udiffAssoc()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>51</span></td><td><code>array_udiff_uassoc</code></td><td><code>udiffUassoc()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>52</span></td><td><code>array_uintersect</code></td><td><code>uintersect()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>53</span></td><td><code>array_uintersect_assoc</code></td><td><code>uintersectAssoc()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>54</span></td><td><code>array_uintersect_uassoc</code></td><td><code>uintersectUassoc()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>55</span></td><td><code>array_unique</code></td><td><code>unique()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>56</span></td><td><code>array_unshift</code></td><td><code>unshift()</code><span> / </span><code>prepend()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr><tr><td><span>57</span></td><td><code>array_values</code></td><td><code>values()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>58</span></td><td><code>array_walk</code></td><td><code>walk()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr><tr><td><span>59</span></td><td><code>array_walk_recursive</code></td><td><code>walkRecursive()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr><tr><td><span>60</span></td><td><code>arsort</code></td><td><code>arsort()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr><tr><td><span>61</span></td><td><code>asort</code></td><td><code>asort()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr><tr><td><span>62</span></td><td><code>compact</code></td><td><code>compact()</code></td><td><span>⚠️</span></td><td><span>구현 불가 (PHP 스코프 제한). 다음을 사용하세요: <code>CoverArray::fromArray(compact(...))</code></span></td></tr><tr><td><span>63</span></td><td><code>count</code></td><td><code>count()</code></td><td><span>✅</span></td><td><span>Countable 인터페이스 구현</span></td></tr><tr><td><span>64</span></td><td><code>current</code></td><td><code>current()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>65</span></td><td><code>end</code></td><td><code>end()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr><tr><td><span>66</span></td><td><code>extract</code></td><td><code>extract()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>67</span></td><td><code>in_array</code></td><td><code>in()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>68</span></td><td><code>key</code></td><td><code>key()</code></td><td><span>✅</span></td><td><span>완전 구현</span></td></tr><tr><td><span>69</span></td><td><code>key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>완전 구현 (array_key_exists와 동일)</span></td></tr><tr><td><span>70</span></td><td><code>krsort</code></td><td><code>krsort()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr><tr><td><span>71</span></td><td><code>ksort</code></td><td><code>ksort()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr><tr><td><span>72</span></td><td><code>list</code></td><td><code>list()</code></td><td><span>⚠️</span></td><td><span>구현 불가 (언어 구조). 다음을 사용하세요: <code>list($a, $b) = $cover->getDataAsArray()</code></span></td></tr><tr><td><span>73</span></td><td><code>natcasesort</code></td><td><code>natcasesort()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr><tr><td><span>74</span></td><td><code>natsort</code></td><td><code>natsort()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr><tr><td><span>75</span></td><td><code>next</code></td><td><code>next()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr><tr><td><span>76</span></td><td><code>pos</code></td><td><code>pos()</code></td><td><span>✅</span></td><td><span><code>current()</code>의 별칭</span></td></tr><tr><td><span>77</span></td><td><code>prev</code></td><td><code>prev()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr><tr><td><span>78</span></td><td><code>range</code></td><td><code>range()</code></td><td><span>✅</span></td><td><span>완전 구현 (정적 메서드)</span></td></tr><tr><td><span>79</span></td><td><code>reset</code></td><td><code>reset()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr><tr><td><span>80</span></td><td><code>rsort</code></td><td><code>rsort()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr><tr><td><span>81</span></td><td><code>shuffle</code></td><td><code>shuffle()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr><tr><td><span>82</span></td><td><code>sort</code></td><td><code>sort()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr><tr><td><span>83</span></td><td><code>uasort</code></td><td><code>uasort()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr><tr><td><span>84</span></td><td><code>uksort</code></td><td><code>uksort()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr><tr><td><span>85</span></td><td><code>usort</code></td><td><code>usort()</code></td><td><span>✅</span></td><td><span>완전 구현 (가변)</span></td></tr></tbody></table>

### 추가 CoverArray 메서드

<table><thead><tr><th><span>메서드</span></th><th><span>목적</span></th><th><span>접근</span></th></tr></thead><tbody><tr><td><code>__clone()</code></td><td><span>직접적인 객체 속성의 깊은 복제와 함께 얕은 복사본을 생성합니다</span></td><td><span>매직</span></td></tr><tr><td><code>__get()</code></td><td><span>객체 속성 문법을 사용하여 속성 값을 가져옵니다</span></td><td><span>매직</span></td></tr><tr><td><code>__isset()</code></td><td><span>속성이 설정되어 있는지 확인합니다</span></td><td><span>매직</span></td></tr><tr><td><code>__serialize()</code></td><td><span>직렬화를 위해 객체를 직렬화합니다</span></td><td><span>매직</span></td></tr><tr><td><code>__set()</code></td><td><span>객체 속성 문법을 사용하여 속성 값을 설정합니다</span></td><td><span>매직</span></td></tr><tr><td><code>__toString()</code></td><td><span>객체의 문자열 표현을 반환합니다</span></td><td><span>매직</span></td></tr><tr><td><code>__unserialize()</code></td><td><span>직렬화된 데이터에서 객체를 역직렬화합니다</span></td><td><span>매직</span></td></tr><tr><td><code>__unset()</code></td><td><span>속성을 제거합니다</span></td><td><span>매직</span></td></tr><tr><td><code>clear()</code></td><td><span>모든 데이터를 지웁니다</span></td><td><span>공개</span></td></tr><tr><td><code>copy()</code></td><td><span>현재 객체 인스턴스의 복사본을 생성하고 반환합니다</span></td><td><span>공개</span></td></tr><tr><td><code>each()</code></td><td><span>각 요소에 콜백을 적용하고 키가 보존된 새 인스턴스를 반환합니다 (불변, 비재귀)</span></td><td><span>공개</span></td></tr><tr><td><code>eachRecursive()</code></td><td><span>각 요소에 콜백을 재귀적으로 적용하고 새 인스턴스를 반환합니다 (불변, 재귀)</span></td><td><span>공개</span></td></tr><tr><td><code>fromArray()</code></td><td><span>네이티브 PHP 배열로부터 CoverArray를 생성합니다</span></td><td><span>공개 정적</span></td></tr><tr><td><code>fromExplode()</code></td><td><span>explode()를 사용하여 문자열로부터 CoverArray를 생성합니다</span></td><td><span>공개 정적</span></td></tr><tr><td><code>fromJson()</code></td><td><span>JSON 문자열로부터 CoverArray 인스턴스를 생성합니다</span></td><td><span>공개 정적</span></td></tr><tr><td><code>get()</code></td><td><span>점 표기법을 사용하여 현재 객체의 키로 데이터를 반환합니다</span></td><td><span>공개</span></td></tr><tr><td><code>getDataAsArray()</code></td><td><span>현재 객체의 데이터를 네이티브 PHP 배열로 반환합니다</span></td><td><span>공개</span></td></tr><tr><td><code>getIterator()</code></td><td><span>배열에 대한 반복자를 반환합니다 (IteratorAggregate 인터페이스)</span></td><td><span>공개</span></td></tr><tr><td><code>implode()</code></td><td><span>배열 요소를 문자열과 결합합니다</span></td><td><span>공개</span></td></tr><tr><td><code>isEmpty()</code></td><td><span>배열이 비어있는지 확인합니다</span></td><td><span>공개</span></td></tr><tr><td><code>item()</code></td><td><span>주어진 인덱스를 가진 컬렉션 요소를 결과로 반환합니다</span></td><td><span>공개</span></td></tr><tr><td><code>jsonSerialize()</code></td><td><span>JSON으로 직렬화될 데이터를 지정합니다 (JsonSerializable 인터페이스)</span></td><td><span>공개</span></td></tr><tr><td><code>offsetExists()</code></td><td><span>지정된 오프셋이 배열에 존재하는지 확인합니다 (ArrayAccess 인터페이스)</span></td><td><span>공개</span></td></tr><tr><td><code>offsetGet()</code></td><td><span>지정된 오프셋의 값을 반환합니다 (ArrayAccess 인터페이스)</span></td><td><span>공개</span></td></tr><tr><td><code>offsetSet()</code></td><td><span>지정된 오프셋의 값을 설정합니다 (ArrayAccess 인터페이스)</span></td><td><span>공개</span></td></tr><tr><td><code>offsetUnset()</code></td><td><span>지정된 오프셋의 값을 제거합니다 (ArrayAccess 인터페이스)</span></td><td><span>공개</span></td></tr><tr><td><code>setData()</code></td><td><span>CoverArray의 내부 데이터를 설정합니다</span></td><td><span>공개</span></td></tr><tr><td><code>toJson()</code></td><td><span>CoverArray를 JSON 문자열로 변환합니다</span></td><td><span>공개</span></td></tr></tbody></table>
