![Cover Array](logo.jpg)

**अन्य भाषाएँ:**
- [English documentation](../README.md)
- [Документация на русском](README_ru.md)
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
- [التوثيق بالعربية](README_ar.md)
- [Türkçe Dokümantasyon](README_tr.md)
- [Tài liệu tiếng Việt](README_vi.md)

---

## स्थिति
### परीक्षण स्थिति
| PHP संस्करण | स्थिति                                                                                                                                                                               |
|-------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 8.0         | [![PHP 8.0](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml) |
| 8.1         | [![PHP 8.1](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml) |
| 8.2         | [![PHP 8.2](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml) |
| 8.3         | [![PHP 8.3](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml) |
| 8.4         | [![PHP 8.4](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml) |
| 8.5         | [![PHP 8.5](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml) |

### कोड कवरेज
[![codecov](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection/branch/master/graph/badge.svg)](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection)

## आवश्यकताएँ
PHP >= 8.0

## इंस्टॉलेशन
```
composer require krugozor/cover
```

# CoverArray: PHP ऐरे के लिए ऑब्जेक्ट-ओरिएंटेड रैपर (PHP Collection)
मनुष्य द्वारा निर्मित, AI द्वारा सत्यापित और परीक्षित। रिलीज़ 2026

## CoverArray क्यों बनाया गया

आधुनिक PHP विकास में, हम अक्सर ऐरे को मुख्य डेटा संरचना के रूप में उपयोग करते हैं। हालांकि, PHP की नेटिव ऐरे फ़ंक्शन में कुछ सीमाएं हैं जिन्हें CoverArray हल करता है।

### नेटिव PHP ऐरे की समस्याएं

- **असंगत फ़ंक्शन नाम**: कुछ फ़ंक्शन अंडरस्कोर का उपयोग करते हैं (`array_map`), अन्य नहीं करते (`usort`)
- **विभिन्न पैरामीटर क्रम**: `array_map($callback, $array)` बनाम `array_filter($array, $callback)` जैसे फ़ंक्शन
- **चेनिंग का अभाव**: नेटिव फ़ंक्शन नए ऐरे लौटाते हैं, जिसके लिए इंटरमीडिएट वेरिएबल की आवश्यकता होती है
- **सीमित टाइप सेफ्टी**: IDE में ऑटोकंप्लीशन या स्टैटिक एनालिसिस सपोर्ट नहीं
- **बोझिल सिंटैक्स**: जटिल ऑपरेशन के लिए नेस्टेड फ़ंक्शन कॉल की आवश्यकता

### CoverArray क्या हल करता है

CoverArray एक साफ ऑब्जेक्ट-ओरिएंटेड इंटरफेस प्रदान करता है जो PHP ऐरे को रैप करता है और नेटिव फ़ंक्शन के साथ पूर्ण संगतता बनाए रखता है:

```php
// डेटा: आयु और स्थिति वाले उपयोगकर्ता
// कार्य: 18 वर्ष से अधिक आयु के सक्रिय उपयोगकर्ताओं के नाम प्राप्त करें, स्कोर के अनुसार अवरोही क्रम में
$users = [
    ['name' => 'Alice', 'age' => 25, 'active' => true, 'score' => 85],
    ['name' => 'Bob', 'age' => 17, 'active' => false, 'score' => 45],
    ['name' => 'Charlie', 'age' => 32, 'active' => true, 'score' => 92],
    ['name' => 'Diana', 'age' => 19, 'active' => true, 'score' => 78],
    ['name' => 'Eve', 'age' => 22, 'active' => false, 'score' => 61],
];
```

#### पहले (नेटिव PHP):
```php
$filtered = array_filter($users, fn($u) => $u['active'] && $u['age'] >= 18);
$sorted = usort($filtered, fn($a, $b) => $b['score'] <=> $a['score']) ? $filtered : [];
$names = array_column($sorted, 'name');
$result = implode(', ', $names); // Charlie, Alice, Diana
```
#### बाद में (CoverArray):
```php
// सब कुछ एक लाइन में!
$result = CoverArray::fromArray($users)
    ->filter(fn($u) => $u->active && $u->age >= 18)
    ->usort(fn($a, $b) => $b->score <=> $a->score)
    ->values()
    ->column('name')
    ->implode(', '); // Charlie, Alice, Diana
```
### मुख्य लाभ
* **कोई बाहरी निर्भरता नहीं:** शुद्ध PHP कार्यान्वयन, अतिरिक्त पैकेज की आवश्यकता नहीं
* **एकीकृत API:** सभी मेथड `$array->method($arguments)` पैटर्न का पालन करते हैं
* **मेथड चेनिंग:** कई ऑपरेशन को पठनीय तरीके से जोड़ें
* **IDE सपोर्ट:** पूर्ण ऑटोकंप्लीशन और टाइप हिंटिंग
* **आधुनिक सिंटैक्स:** PHP 8.0+ के लिए सख्त टाइपिंग के साथ डिज़ाइन किया गया
* **डॉट नोटेशन:** `$array->get('user.profile.name')` के माध्यम से नेस्टेड डेटा तक सुविधाजनक पहुंच
* **JSON सपोर्ट:** बिल्ट-इन सीरियलाइजेशन/डीसीरियलाइजेशन
* **इम्यूटेबल ऑपरेशन:** अधिकांश मेथड नए इंस्टेंस लौटाते हैं, मूल डेटा को संरक्षित रखते हैं
* **पूर्ण संगतता:** मौजूदा ऐरे-आधारित कोड के साथ बेहतरीन तरीके से काम करता है

### व्यावहारिक उपयोग उदाहरण

#### उदाहरण 1: डॉट नोटेशन के साथ कॉन्फ़िगरेशन प्रबंधन
```php
// नेस्टेड कॉन्फ़िगरेशन लोड करें और सुरक्षित रूप से एक्सेस करें
$config = CoverArray::fromJson(file_get_contents('config.json'));

// डिफ़ॉल्ट मान के साथ नेस्टेड डेटा तक सीधी पहुंच
$dbHost = $config->get('database.connections.mysql.host', fn($value) => $value ?? 'localhost');
$dbPort = $config->get('database.connections.mysql.port', fn($value) => $value ?? 3306);

// जटिल डिफ़ॉल्ट मान के लिए कॉलबैक के साथ एक्सेस
$apiKeys = $config->get('services.payment.keys', function($keys) {
    return $keys ?? CoverArray::fromArray([
        'public' => 'default_public_key',
        'secret' => 'default_secret_key'
    ]);
});
```

#### उदाहरण 2: API रिस्पॉन्स प्रोसेसिंग पाइपलाइन
```php
// वास्तविक API प्रोसेसिंग: फ़िल्टरिंग, ट्रांसफॉर्मेशन और डेटा एक्सट्रैक्शन
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

// ड्रॉपडाउन के लिए विशिष्ट कॉलम निकालें
$userOptions = $apiResponse->column('name', 'id')->getDataAsArray();
```

#### उदाहरण 3: लॉग विश्लेषण और त्रुटि रिपोर्ट
```php
// एप्लिकेशन लॉग पार्स करें और त्रुटि पैटर्न की पहचान करें
$logLines = CoverArray::fromExplode("\n", file_get_contents('app.log'))
    ->filter(fn($line) => !empty(trim($line)));

// त्रुटियों को निकालें और वर्गीकृत करें
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

// त्रुटि प्रकार के अनुसार समूहित करें और घटनाओं की गणना करें
$errorStats = $errors
    ->column('type')
    ->countValues()
    ->arsort(); // आवृत्ति के अनुसार सॉर्ट करें

// त्रुटि रिपोर्ट जनरेट करें
$report = "त्रुटि रिपोर्ट:\n";
foreach ($errorStats as $type => $count) {
    $report .= "- {$type}: {$count} घटनाएं\n";
}

// अंतिम क्रिटिकल त्रुटि खोजें
$lastCritical = $errors
    ->filter(fn($e) => $e['type'] === 'Critical')
    ->last();
```

CoverArray शक्तिशाली PHP ऐरे फ़ंक्शन और आधुनिक ऑब्जेक्ट-ओरिएंटेड प्रथाओं को जोड़ता है, जिससे ऐरे मैनिपुलेशन अधिक अभिव्यक्त, रखरखाव योग्य और आनंददायक बन जाता है।

## तुलना तालिका: CoverArray मेथड और PHP ऐरे फ़ंक्शन

<table><thead><tr><th><span>#</span></th><th><span>PHP फ़ंक्शन</span></th><th><span>CoverArray मेथड</span></th><th><span>स्थिति</span></th><th><span>नोट्स</span></th></tr></thead><tbody><tr><td><span>1</span></td><td><code>array_all</code></td><td><code>all()</code></td><td><span>✅</span></td><td><span>पुराने PHP संस्करणों के लिए पॉलीफिल के साथ कार्यान्वित</span></td></tr><tr><td><span>2</span></td><td><code>array_any</code></td><td><code>any()</code></td><td><span>✅</span></td><td><span>पुराने PHP संस्करणों के लिए पॉलीफिल के साथ कार्यान्वित</span></td></tr><tr><td><span>3</span></td><td><code>array_change_key_case</code></td><td><code>changeKeyCase()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>4</span></td><td><code>array_chunk</code></td><td><code>chunk()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>5</span></td><td><code>array_column</code></td><td><code>column()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>6</span></td><td><code>array_combine</code></td><td><code>combine()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (स्टैटिक मेथड)</span></td></tr><tr><td><span>7</span></td><td><code>array_count_values</code></td><td><code>countValues()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>8</span></td><td><code>array_diff</code></td><td><code>diff()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>9</span></td><td><code>array_diff_assoc</code></td><td><code>diffAssoc()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>10</span></td><td><code>array_diff_key</code></td><td><code>diffKey()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>11</span></td><td><code>array_diff_uassoc</code></td><td><code>diffUassoc()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>12</span></td><td><code>array_diff_ukey</code></td><td><code>diffUkey()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>13</span></td><td><code>array_fill</code></td><td><code>fill()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (स्टैटिक मेथड)</span></td></tr><tr><td><span>14</span></td><td><code>array_fill_keys</code></td><td><code>fillKeys()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (स्टैटिक मेथड)</span></td></tr><tr><td><span>15</span></td><td><code>array_filter</code></td><td><code>filter()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>16</span></td><td><code>array_find</code></td><td><code>find()</code></td><td><span>✅</span></td><td><span>पुराने PHP संस्करणों के लिए पॉलीफिल के साथ कार्यान्वित</span></td></tr><tr><td><span>17</span></td><td><code>array_find_key</code></td><td><code>findKey()</code></td><td><span>✅</span></td><td><span>पुराने PHP संस्करणों के लिए पॉलीफिल के साथ कार्यान्वित</span></td></tr><tr><td><span>18</span></td><td><code>array_first</code></td><td><code>first()</code></td><td><span>✅</span></td><td><span>पुराने PHP संस्करणों के लिए पॉलीफिल के साथ कार्यान्वित</span></td></tr><tr><td><span>19</span></td><td><code>array_flip</code></td><td><code>flip()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>20</span></td><td><code>array_intersect</code></td><td><code>intersect()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>21</span></td><td><code>array_intersect_assoc</code></td><td><code>intersectAssoc()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>22</span></td><td><code>array_intersect_key</code></td><td><code>intersectKey()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>23</span></td><td><code>array_intersect_uassoc</code></td><td><code>intersectUassoc()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>24</span></td><td><code>array_intersect_ukey</code></td><td><code>intersectUkey()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>25</span></td><td><code>array_is_list</code></td><td><code>isList()</code></td><td><span>✅</span></td><td><span>पुराने PHP संस्करणों के लिए पॉलीफिल के साथ कार्यान्वित</span></td></tr><tr><td><span>26</span></td><td><code>array_key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>27</span></td><td><code>array_key_first</code></td><td><code>keyFirst()</code></td><td><span>✅</span></td><td><span>बिल्ट-इन फ़ंक्शन का उपयोग करता है</span></td></tr><tr><td><span>28</span></td><td><code>array_key_last</code></td><td><code>keyLast()</code></td><td><span>✅</span></td><td><span>बिल्ट-इन फ़ंक्शन का उपयोग करता है</span></td></tr><tr><td><span>29</span></td><td><code>array_keys</code></td><td><code>keys()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>30</span></td><td><code>array_last</code></td><td><code>last()</code></td><td><span>✅</span></td><td><span>पुराने PHP संस्करणों के लिए पॉलीफिल के साथ कार्यान्वित</span></td></tr><tr><td><span>31</span></td><td><code>array_map</code></td><td><code>map()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>32</span></td><td><code>array_merge</code></td><td><code>merge()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>33</span></td><td><code>array_merge_recursive</code></td><td><code>mergeRecursive()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>34</span></td><td><code>array_multisort</code></td><td><code>multisort()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr><tr><td><span>35</span></td><td><code>array_pad</code></td><td><code>pad()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>36</span></td><td><code>array_pop</code></td><td><code>pop()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr><tr><td><span>37</span></td><td><code>array_product</code></td><td><code>product()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>38</span></td><td><code>array_push</code></td><td><code>push()</code><span> / </span><code>append()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr><tr><td><span>39</span></td><td><code>array_rand</code></td><td><code>rand()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>40</span></td><td><code>array_reduce</code></td><td><code>reduce()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>41</span></td><td><code>array_replace</code></td><td><code>replace()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>42</span></td><td><code>array_replace_recursive</code></td><td><code>replaceRecursive()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>43</span></td><td><code>array_reverse</code></td><td><code>reverse()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>44</span></td><td><code>array_search</code></td><td><code>search()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>45</span></td><td><code>array_shift</code></td><td><code>shift()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr><tr><td><span>46</span></td><td><code>array_slice</code></td><td><code>slice()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>47</span></td><td><code>array_splice</code></td><td><code>splice()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr><tr><td><span>48</span></td><td><code>array_sum</code></td><td><code>sum()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>49</span></td><td><code>array_udiff</code></td><td><code>udiff()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>50</span></td><td><code>array_udiff_assoc</code></td><td><code>udiffAssoc()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>51</span></td><td><code>array_udiff_uassoc</code></td><td><code>udiffUassoc()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>52</span></td><td><code>array_uintersect</code></td><td><code>uintersect()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>53</span></td><td><code>array_uintersect_assoc</code></td><td><code>uintersectAssoc()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>54</span></td><td><code>array_uintersect_uassoc</code></td><td><code>uintersectUassoc()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>55</span></td><td><code>array_unique</code></td><td><code>unique()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>56</span></td><td><code>array_unshift</code></td><td><code>unshift()</code><span> / </span><code>prepend()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr><tr><td><span>57</span></td><td><code>array_values</code></td><td><code>values()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>58</span></td><td><code>array_walk</code></td><td><code>walk()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr><tr><td><span>59</span></td><td><code>array_walk_recursive</code></td><td><code>walkRecursive()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr><tr><td><span>60</span></td><td><code>arsort</code></td><td><code>arsort()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr><tr><td><span>61</span></td><td><code>asort</code></td><td><code>asort()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr><tr><td><span>62</span></td><td><code>compact</code></td><td><code>compact()</code></td><td><span>⚠️</span></td><td><span>कार्यान्वयन असंभव (PHP स्कोप सीमाएं)। उपयोग करें: <code>CoverArray::fromArray(compact(...))</code></span></td></tr><tr><td><span>63</span></td><td><code>count</code></td><td><code>count()</code></td><td><span>✅</span></td><td><span>Countable इंटरफेस कार्यान्वयन</span></td></tr><tr><td><span>64</span></td><td><code>current</code></td><td><code>current()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>65</span></td><td><code>end</code></td><td><code>end()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr><tr><td><span>66</span></td><td><code>extract</code></td><td><code>extract()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>67</span></td><td><code>in_array</code></td><td><code>in()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>68</span></td><td><code>key</code></td><td><code>key()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन</span></td></tr><tr><td><span>69</span></td><td><code>key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (array_key_exists का एलियास)</span></td></tr><tr><td><span>70</span></td><td><code>krsort</code></td><td><code>krsort()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr><tr><td><span>71</span></td><td><code>ksort</code></td><td><code>ksort()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr><tr><td><span>72</span></td><td><code>list</code></td><td><code>list()</code></td><td><span>⚠️</span></td><td><span>कार्यान्वयन असंभव (भाषा निर्माण)। उपयोग करें: <code>list($a, $b) = $cover->getDataAsArray()</code></span></td></tr><tr><td><span>73</span></td><td><code>natcasesort</code></td><td><code>natcasesort()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr><tr><td><span>74</span></td><td><code>natsort</code></td><td><code>natsort()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr><tr><td><span>75</span></td><td><code>next</code></td><td><code>next()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr><tr><td><span>76</span></td><td><code>pos</code></td><td><code>pos()</code></td><td><span>✅</span></td><td><span><code>current()</code> का एलियास</span></td></tr><tr><td><span>77</span></td><td><code>prev</code></td><td><code>prev()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr><tr><td><span>78</span></td><td><code>range</code></td><td><code>range()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (स्टैटिक मेथड)</span></td></tr><tr><td><span>79</span></td><td><code>reset</code></td><td><code>reset()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr><tr><td><span>80</span></td><td><code>rsort</code></td><td><code>rsort()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr><tr><td><span>81</span></td><td><code>shuffle</code></td><td><code>shuffle()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr><tr><td><span>82</span></td><td><code>sort</code></td><td><code>sort()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr><tr><td><span>83</span></td><td><code>uasort</code></td><td><code>uasort()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr><tr><td><span>84</span></td><td><code>uksort</code></td><td><code>uksort()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr><tr><td><span>85</span></td><td><code>usort</code></td><td><code>usort()</code></td><td><span>✅</span></td><td><span>पूर्ण कार्यान्वयन (म्यूटेटिंग)</span></td></tr></tbody></table>

### अतिरिक्त CoverArray मेथड

<table><thead><tr><th><span>मेथड</span></th><th><span>उद्देश्य</span></th><th><span>एक्सेस</span></th></tr></thead><tbody><tr><td><code>__clone()</code></td><td><span>तत्काल ऑब्जेक्ट प्रॉपर्टीज की डीप क्लोनिंग के साथ शैलो कॉपी बनाता है</span></td><td><span>मैजिक</span></td></tr><tr><td><code>__get()</code></td><td><span>ऑब्जेक्ट प्रॉपर्टी सिंटैक्स के माध्यम से प्रॉपर्टी वैल्यू प्राप्त करता है</span></td><td><span>मैजिक</span></td></tr><tr><td><code>__isset()</code></td><td><span>जांचता है कि प्रॉपर्टी सेट है या नहीं</span></td><td><span>मैजिक</span></td></tr><tr><td><code>__serialize()</code></td><td><span>सीरियलाइजेशन के लिए ऑब्जेक्ट को सीरियलाइज करता है</span></td><td><span>मैजिक</span></td></tr><tr><td><code>__set()</code></td><td><span>ऑब्जेक्ट प्रॉपर्टी सिंटैक्स के माध्यम से प्रॉपर्टी वैल्यू सेट करता है</span></td><td><span>मैजिक</span></td></tr><tr><td><code>__toString()</code></td><td><span>ऑब्जेक्ट का स्ट्रिंग प्रतिनिधित्व लौटाता है</span></td><td><span>मैजिक</span></td></tr><tr><td><code>__unserialize()</code></td><td><span>सीरियलाइज्ड डेटा से ऑब्जेक्ट को डीसीरियलाइज करता है</span></td><td><span>मैजिक</span></td></tr><tr><td><code>__unset()</code></td><td><span>प्रॉपर्टी हटाता है</span></td><td><span>मैजिक</span></td></tr><tr><td><code>clear()</code></td><td><span>सभी डेटा क्लियर करता है</span></td><td><span>पब्लिक</span></td></tr><tr><td><code>copy()</code></td><td><span>वर्तमान ऑब्जेक्ट इंस्टेंस की कॉपी बनाता और लौटाता है</span></td><td><span>पब्लिक</span></td></tr><tr><td><code>each()</code></td><td><span>प्रत्येक एलिमेंट पर कॉलबैक लागू करता है और की प्रेजर्वेशन के साथ नया इंस्टेंस लौटाता है (इम्यूटेबल, नॉन-रिकर्सिव)</span></td><td><span>पब्लिक</span></td></tr><tr><td><code>eachRecursive()</code></td><td><span>प्रत्येक एलिमेंट पर रिकर्सिवली कॉलबैक लागू करता है और नया इंस्टेंस लौटाता है (इम्यूटेबल, रिकर्सिव)</span></td><td><span>पब्लिक</span></td></tr><tr><td><code>fromArray()</code></td><td><span>नेटिव PHP ऐरे से CoverArray बनाता है</span></td><td><span>पब्लिक स्टैटिक</span></td></tr><tr><td><code>fromExplode()</code></td><td><span>explode() का उपयोग करके स्ट्रिंग से CoverArray बनाता है</span></td><td><span>पब्लिक स्टैटिक</span></td></tr><tr><td><code>fromJson()</code></td><td><span>JSON स्ट्रिंग से CoverArray इंस्टेंस बनाता है</span></td><td><span>पब्लिक स्टैटिक</span></td></tr><tr><td><code>get()</code></td><td><span>डॉट नोटेशन का उपयोग करके वर्तमान ऑब्जेक्ट की कीज़ द्वारा डेटा लौटाता है</span></td><td><span>पब्लिक</span></td></tr><tr><td><code>getData()</code></td><td><span>आंतरिक डेटा सरणी को बिना किसी रूपांतरण के वैसा ही लौटाता है</span></td><td><span>पब्लिक</span></td></tr><tr><td><code>getDataAsArray()</code></td><td><span>वर्तमान ऑब्जेक्ट का डेटा नेटिव PHP ऐरे के रूप में लौटाता है</span></td><td><span>पब्लिक</span></td></tr><tr><td><code>getIterator()</code></td><td><span>ऐरे के लिए इटरेटर लौटाता है (IteratorAggregate इंटरफेस)</span></td><td><span>पब्लिक</span></td></tr><tr><td><code>implode()</code></td><td><span>ऐरे एलिमेंट्स को स्ट्रिंग से जोड़ता है</span></td><td><span>पब्लिक</span></td></tr><tr><td><code>isEmpty()</code></td><td><span>जांचता है कि ऐरे खाली है या नहीं</span></td><td><span>पब्लिक</span></td></tr><tr><td><code>item()</code></td><td><span>निर्दिष्ट इंडेक्स पर कलेक्शन एलिमेंट को रिजल्ट के रूप में लौटाता है</span></td><td><span>पब्लिक</span></td></tr><tr><td><code>jsonSerialize()</code></td><td><span>JSON सीरियलाइजेशन के लिए डेटा परिभाषित करता है (JsonSerializable इंटरफेस)</span></td><td><span>पब्लिक</span></td></tr><tr><td><code>offsetExists()</code></td><td><span>जांचता है कि ऐरे में निर्दिष्ट ऑफसेट मौजूद है या नहीं (ArrayAccess इंटरफेस)</span></td><td><span>पब्लिक</span></td></tr><tr><td><code>offsetGet()</code></td><td><span>निर्दिष्ट ऑफसेट पर वैल्यू लौटाता है (ArrayAccess इंटरफेस)</span></td><td><span>पब्लिक</span></td></tr><tr><td><code>offsetSet()</code></td><td><span>निर्दिष्ट ऑफसेट पर वैल्यू सेट करता है (ArrayAccess इंटरफेस)</span></td><td><span>पब्लिक</span></td></tr><tr><td><code>offsetUnset()</code></td><td><span>निर्दिष्ट ऑफसेट पर वैल्यू हटाता है (ArrayAccess इंटरफेस)</span></td><td><span>पब्लिक</span></td></tr><tr><td><code>setData()</code></td><td><span>CoverArray के लिए इंटरनल डेटा सेट करता है</span></td><td><span>पब्लिक</span></td></tr><tr><td><code>toJson()</code></td><td><span>CoverArray को JSON स्ट्रिंग में कन्वर्ट करता है</span></td><td><span>पब्लिक</span></td></tr></tbody></table>
