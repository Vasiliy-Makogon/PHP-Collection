![Cover Array](logo.jpg)

**Andere Sprachen:**
- [English Documentation](../README.md)
- [Русская документация](README_ru.md)
- [Documentation française](README_fr.md)
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

---

## Status
### Teststatus
| PHP-Version | Status                                                                                                                                                                               |
|-------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 8.0         | [![PHP 8.0](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml) |
| 8.1         | [![PHP 8.1](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml) |
| 8.2         | [![PHP 8.2](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml) |
| 8.3         | [![PHP 8.3](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml) |
| 8.4         | [![PHP 8.4](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml) |
| 8.5         | [![PHP 8.5](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml) |

### Code-Abdeckung
[![codecov](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection/branch/master/graph/badge.svg)](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection)

## Anforderungen
PHP >= 8.0

## Installation
```
composer require krugozor/cover
```

# CoverArray: Objektorientierter Array-Wrapper für PHP (PHP Collection)
Von Menschen erstellt, durch künstliche Intelligenz verifiziert und getestet. Release 2026

## Warum CoverArray erstellt wurde

In der modernen PHP-Entwicklung arbeiten wir häufig mit Arrays als primäre Datenstruktur. Die nativen Array-Funktionen von PHP haben jedoch mehrere Einschränkungen, die CoverArray löst.

### Das Problem mit nativen PHP-Arrays

- **Inkonsistente Funktionsbenennung**: Einige Funktionen verwenden Unterstriche (`array_map`), andere nicht (`usort`)
- **Gemischte Parameterreihenfolgen**: Funktionen wie `array_map($callback, $array)` vs `array_filter($array, $callback)`
- **Keine Methodenverkettung**: Native Funktionen geben neue Arrays zurück und erfordern Zwischenvariablen
- **Eingeschränkte Typsicherheit**: Keine IDE-Autovervollständigung oder Unterstützung für statische Analyse
- **Ausführliche Syntax**: Komplexe Operationen erfordern verschachtelte Funktionsaufrufe

### Was CoverArray löst

CoverArray bietet eine saubere, objektorientierte Schnittstelle, die PHP-Arrays umschließt und dabei volle Kompatibilität mit nativen Funktionen beibehält:

```php
// Daten: Benutzer mit Alter und Status
// Aufgabe: Namen aktiver Benutzer über 18 abrufen, nach absteigender Punktzahl sortiert
$users = [
    ['name' => 'Alice', 'age' => 25, 'active' => true, 'score' => 85],
    ['name' => 'Bob', 'age' => 17, 'active' => false, 'score' => 45],
    ['name' => 'Charlie', 'age' => 32, 'active' => true, 'score' => 92],
    ['name' => 'Diana', 'age' => 19, 'active' => true, 'score' => 78],
    ['name' => 'Eve', 'age' => 22, 'active' => false, 'score' => 61],
];
```

#### Vorher (Native PHP):
```php
$filtered = array_filter($users, fn($u) => $u['active'] && $u['age'] >= 18);
$sorted = usort($filtered, fn($a, $b) => $b['score'] <=> $a['score']) ? $filtered : [];
$names = array_column($sorted, 'name');
$result = implode(', ', $names); // Charlie, Alice, Diana
```
#### Nachher (CoverArray):
```php
// ALLES IN EINER ZEILE!
$result = CoverArray::fromArray($users)
    ->filter(fn($u) => $u->active && $u->age >= 18)
    ->usort(fn($a, $b) => $b->score <=> $a->score)
    ->values()
    ->column('name')
    ->implode(', '); // Charlie, Alice, Diana
```
### Hauptvorteile
* **Keine externen Abhängigkeiten:** Reine PHP-Implementierung, keine zusätzlichen Pakete erforderlich
* **Konsistente API:** Alle Methoden folgen dem Muster `$array->method($arguments)`
* **Methodenverkettung:** Mehrere Operationen auf lesbare Weise verketten
* **IDE-Unterstützung:** Vollständige Autovervollständigung und Typhinweise
* **Moderne Syntax:** Entwickelt für PHP 8.0+ mit strikter Typisierung
* **Punkt-Notation:** Einfacher verschachtelter Datenzugriff mit `$array->get('user.profile.name')`
* **JSON-Unterstützung:** Eingebaute Serialisierung/Deserialisierung
* **Unveränderliche Operationen:** Die meisten Methoden geben neue Instanzen zurück und bewahren die Originaldaten
* **Volle Kompatibilität:** Funktioniert nahtlos mit bestehendem Array-basierten Code

### Praxisnahe Anwendungsfälle

#### Beispiel 1: Konfigurationsverwaltung mit Punkt-Notation
```php
// Verschachtelte Konfiguration sicher laden und darauf zugreifen
$config = CoverArray::fromJson(file_get_contents('config.json'));

// Direkter verschachtelter Zugriff mit Standard-Fallbacks
$dbHost = $config->get('database.connections.mysql.host', fn($value) => $value ?? 'localhost');
$dbPort = $config->get('database.connections.mysql.port', fn($value) => $value ?? 3306);

// Zugriff mit Callback für komplexe Standardwerte
$apiKeys = $config->get('services.payment.keys', function($keys) {
    return $keys ?? CoverArray::fromArray([
        'public' => 'default_public_key',
        'secret' => 'default_secret_key'
    ]);
});
```

#### Beispiel 2: API-Antwortverarbeitungs-Pipeline
```php
// Praxisnahe API-Verarbeitung: Filtern, Transformieren und Extrahieren von Daten
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

// Spezifische Spalten für Dropdown extrahieren
$userOptions = $apiResponse->column('name', 'id')->getDataAsArray();
```

#### Beispiel 3: Protokollanalyse und Fehlerberichterstattung
```php
// Anwendungsprotokolle parsen und Fehlermuster extrahieren
$logLines = CoverArray::fromExplode("\n", file_get_contents('app.log'))
    ->filter(fn($line) => !empty(trim($line)));

// Fehler extrahieren und kategorisieren
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

// Nach Fehlertyp gruppieren und Vorkommen zählen
$errorStats = $errors
    ->column('type')
    ->countValues()
    ->arsort(); // Nach Häufigkeit sortieren

// Fehlerbericht generieren
$report = "Fehlerbericht:\n";
foreach ($errorStats as $type => $count) {
    $report .= "- {$type}: {$count} Vorkommen\n";
}

// Letzten kritischen Fehler finden
$lastCritical = $errors
    ->filter(fn($e) => $e['type'] === 'Critical')
    ->last();
```

CoverArray schließt die Lücke zwischen PHPs leistungsstarken Array-Funktionen und modernen objektorientierten Praktiken und macht die Array-Manipulation ausdrucksstärker, wartbarer und angenehmer.

## Vergleichstabelle: CoverArray-Methoden vs PHP-Array-Funktionen

<table><thead><tr><th><span>#</span></th><th><span>PHP-Funktion</span></th><th><span>CoverArray-Methode</span></th><th><span>Status</span></th><th><span>Hinweise</span></th></tr></thead><tbody><tr><td><span>1</span></td><td><code>array_all</code></td><td><code>all()</code></td><td><span>✅</span></td><td><span>Implementiert mit Polyfill für ältere PHP-Versionen</span></td></tr><tr><td><span>2</span></td><td><code>array_any</code></td><td><code>any()</code></td><td><span>✅</span></td><td><span>Implementiert mit Polyfill für ältere PHP-Versionen</span></td></tr><tr><td><span>3</span></td><td><code>array_change_key_case</code></td><td><code>changeKeyCase()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>4</span></td><td><code>array_chunk</code></td><td><code>chunk()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>5</span></td><td><code>array_column</code></td><td><code>column()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>6</span></td><td><code>array_combine</code></td><td><code>combine()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (statische Methode)</span></td></tr><tr><td><span>7</span></td><td><code>array_count_values</code></td><td><code>countValues()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>8</span></td><td><code>array_diff</code></td><td><code>diff()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>9</span></td><td><code>array_diff_assoc</code></td><td><code>diffAssoc()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>10</span></td><td><code>array_diff_key</code></td><td><code>diffKey()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>11</span></td><td><code>array_diff_uassoc</code></td><td><code>diffUassoc()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>12</span></td><td><code>array_diff_ukey</code></td><td><code>diffUkey()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>13</span></td><td><code>array_fill</code></td><td><code>fill()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (statische Methode)</span></td></tr><tr><td><span>14</span></td><td><code>array_fill_keys</code></td><td><code>fillKeys()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (statische Methode)</span></td></tr><tr><td><span>15</span></td><td><code>array_filter</code></td><td><code>filter()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>16</span></td><td><code>array_find</code></td><td><code>find()</code></td><td><span>✅</span></td><td><span>Implementiert mit Polyfill für ältere PHP-Versionen</span></td></tr><tr><td><span>17</span></td><td><code>array_find_key</code></td><td><code>findKey()</code></td><td><span>✅</span></td><td><span>Implementiert mit Polyfill für ältere PHP-Versionen</span></td></tr><tr><td><span>18</span></td><td><code>array_first</code></td><td><code>first()</code></td><td><span>✅</span></td><td><span>Implementiert mit Polyfill für ältere PHP-Versionen</span></td></tr><tr><td><span>19</span></td><td><code>array_flip</code></td><td><code>flip()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>20</span></td><td><code>array_intersect</code></td><td><code>intersect()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>21</span></td><td><code>array_intersect_assoc</code></td><td><code>intersectAssoc()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>22</span></td><td><code>array_intersect_key</code></td><td><code>intersectKey()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>23</span></td><td><code>array_intersect_uassoc</code></td><td><code>intersectUassoc()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>24</span></td><td><code>array_intersect_ukey</code></td><td><code>intersectUkey()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>25</span></td><td><code>array_is_list</code></td><td><code>isList()</code></td><td><span>✅</span></td><td><span>Implementiert mit Polyfill für ältere PHP-Versionen</span></td></tr><tr><td><span>26</span></td><td><code>array_key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>27</span></td><td><code>array_key_first</code></td><td><code>keyFirst()</code></td><td><span>✅</span></td><td><span>Verwendet eingebaute Funktion</span></td></tr><tr><td><span>28</span></td><td><code>array_key_last</code></td><td><code>keyLast()</code></td><td><span>✅</span></td><td><span>Verwendet eingebaute Funktion</span></td></tr><tr><td><span>29</span></td><td><code>array_keys</code></td><td><code>keys()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>30</span></td><td><code>array_last</code></td><td><code>last()</code></td><td><span>✅</span></td><td><span>Implementiert mit Polyfill für ältere PHP-Versionen</span></td></tr><tr><td><span>31</span></td><td><code>array_map</code></td><td><code>map()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>32</span></td><td><code>array_merge</code></td><td><code>merge()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>33</span></td><td><code>array_merge_recursive</code></td><td><code>mergeRecursive()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>34</span></td><td><code>array_multisort</code></td><td><code>multisort()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr><tr><td><span>35</span></td><td><code>array_pad</code></td><td><code>pad()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>36</span></td><td><code>array_pop</code></td><td><code>pop()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr><tr><td><span>37</span></td><td><code>array_product</code></td><td><code>product()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>38</span></td><td><code>array_push</code></td><td><code>push()</code><span> / </span><code>append()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr><tr><td><span>39</span></td><td><code>array_rand</code></td><td><code>rand()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>40</span></td><td><code>array_reduce</code></td><td><code>reduce()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>41</span></td><td><code>array_replace</code></td><td><code>replace()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>42</span></td><td><code>array_replace_recursive</code></td><td><code>replaceRecursive()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>43</span></td><td><code>array_reverse</code></td><td><code>reverse()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>44</span></td><td><code>array_search</code></td><td><code>search()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>45</span></td><td><code>array_shift</code></td><td><code>shift()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr><tr><td><span>46</span></td><td><code>array_slice</code></td><td><code>slice()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>47</span></td><td><code>array_splice</code></td><td><code>splice()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr><tr><td><span>48</span></td><td><code>array_sum</code></td><td><code>sum()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>49</span></td><td><code>array_udiff</code></td><td><code>udiff()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>50</span></td><td><code>array_udiff_assoc</code></td><td><code>udiffAssoc()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>51</span></td><td><code>array_udiff_uassoc</code></td><td><code>udiffUassoc()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>52</span></td><td><code>array_uintersect</code></td><td><code>uintersect()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>53</span></td><td><code>array_uintersect_assoc</code></td><td><code>uintersectAssoc()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>54</span></td><td><code>array_uintersect_uassoc</code></td><td><code>uintersectUassoc()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>55</span></td><td><code>array_unique</code></td><td><code>unique()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>56</span></td><td><code>array_unshift</code></td><td><code>unshift()</code><span> / </span><code>prepend()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr><tr><td><span>57</span></td><td><code>array_values</code></td><td><code>values()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>58</span></td><td><code>array_walk</code></td><td><code>walk()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr><tr><td><span>59</span></td><td><code>array_walk_recursive</code></td><td><code>walkRecursive()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr><tr><td><span>60</span></td><td><code>arsort</code></td><td><code>arsort()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr><tr><td><span>61</span></td><td><code>asort</code></td><td><code>asort()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr><tr><td><span>62</span></td><td><code>compact</code></td><td><code>compact()</code></td><td><span>⚠️</span></td><td><span>Nicht implementierbar (PHP-Gültigkeitsbereichs-Einschränkungen). Verwenden: <code>CoverArray::fromArray(compact(...))</code></span></td></tr><tr><td><span>63</span></td><td><code>count</code></td><td><code>count()</code></td><td><span>✅</span></td><td><span>Implementierung des Countable-Interfaces</span></td></tr><tr><td><span>64</span></td><td><code>current</code></td><td><code>current()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>65</span></td><td><code>end</code></td><td><code>end()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr><tr><td><span>66</span></td><td><code>extract</code></td><td><code>extract()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>67</span></td><td><code>in_array</code></td><td><code>in()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>68</span></td><td><code>key</code></td><td><code>key()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung</span></td></tr><tr><td><span>69</span></td><td><code>key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (identisch mit array_key_exists)</span></td></tr><tr><td><span>70</span></td><td><code>krsort</code></td><td><code>krsort()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr><tr><td><span>71</span></td><td><code>ksort</code></td><td><code>ksort()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr><tr><td><span>72</span></td><td><code>list</code></td><td><code>list()</code></td><td><span>⚠️</span></td><td><span>Nicht implementierbar (Sprachkonstrukt). Verwenden: <code>list($a, $b) = $cover->getDataAsArray()</code></span></td></tr><tr><td><span>73</span></td><td><code>natcasesort</code></td><td><code>natcasesort()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr><tr><td><span>74</span></td><td><code>natsort</code></td><td><code>natsort()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr><tr><td><span>75</span></td><td><code>next</code></td><td><code>next()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr><tr><td><span>76</span></td><td><code>pos</code></td><td><code>pos()</code></td><td><span>✅</span></td><td><span>Alias von <code>current()</code></span></td></tr><tr><td><span>77</span></td><td><code>prev</code></td><td><code>prev()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr><tr><td><span>78</span></td><td><code>range</code></td><td><code>range()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (statische Methode)</span></td></tr><tr><td><span>79</span></td><td><code>reset</code></td><td><code>reset()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr><tr><td><span>80</span></td><td><code>rsort</code></td><td><code>rsort()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr><tr><td><span>81</span></td><td><code>shuffle</code></td><td><code>shuffle()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr><tr><td><span>82</span></td><td><code>sort</code></td><td><code>sort()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr><tr><td><span>83</span></td><td><code>uasort</code></td><td><code>uasort()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr><tr><td><span>84</span></td><td><code>uksort</code></td><td><code>uksort()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr><tr><td><span>85</span></td><td><code>usort</code></td><td><code>usort()</code></td><td><span>✅</span></td><td><span>Vollständige Implementierung (mutierend)</span></td></tr></tbody></table>

### Zusätzliche CoverArray-Methoden

<table><thead><tr><th><span>Methode</span></th><th><span>Zweck</span></th><th><span>Zugriff</span></th></tr></thead><tbody><tr><td><code>__clone()</code></td><td><span>Erstellt eine flache Kopie mit tiefem Klonen unmittelbarer Objekt-Eigenschaften</span></td><td><span>Magisch</span></td></tr><tr><td><code>__get()</code></td><td><span>Ruft einen Eigenschaftswert mithilfe der Objekteigenschaftssyntax ab</span></td><td><span>Magisch</span></td></tr><tr><td><code>__isset()</code></td><td><span>Prüft, ob eine Eigenschaft gesetzt ist</span></td><td><span>Magisch</span></td></tr><tr><td><code>__serialize()</code></td><td><span>Serialisiert das Objekt für die Serialisierung</span></td><td><span>Magisch</span></td></tr><tr><td><code>__set()</code></td><td><span>Setzt einen Eigenschaftswert mithilfe der Objekteigenschaftssyntax</span></td><td><span>Magisch</span></td></tr><tr><td><code>__toString()</code></td><td><span>Gibt eine String-Darstellung des Objekts zurück</span></td><td><span>Magisch</span></td></tr><tr><td><code>__unserialize()</code></td><td><span>Deserialisiert das Objekt aus serialisierten Daten</span></td><td><span>Magisch</span></td></tr><tr><td><code>__unset()</code></td><td><span>Hebt die Setzung einer Eigenschaft auf</span></td><td><span>Magisch</span></td></tr><tr><td><code>clear()</code></td><td><span>Löscht alle Daten</span></td><td><span>Öffentlich</span></td></tr><tr><td><code>copy()</code></td><td><span>Erstellt und gibt eine Kopie der aktuellen Objektinstanz zurück</span></td><td><span>Öffentlich</span></td></tr><tr><td><code>each()</code></td><td><span>Wendet einen Callback auf jedes Element an und gibt eine neue Instanz mit beibehaltenen Schlüsseln zurück (unveränderlich, nicht-rekursiv)</span></td><td><span>Öffentlich</span></td></tr><tr><td><code>eachRecursive()</code></td><td><span>Wendet rekursiv einen Callback auf jedes Element an und gibt eine neue Instanz zurück (unveränderlich, rekursiv)</span></td><td><span>Öffentlich</span></td></tr><tr><td><code>fromArray()</code></td><td><span>Erstellt ein CoverArray aus einem nativen PHP-Array</span></td><td><span>Öffentlich Statisch</span></td></tr><tr><td><code>fromExplode()</code></td><td><span>Erstellt ein CoverArray aus einem String mit explode()</span></td><td><span>Öffentlich Statisch</span></td></tr><tr><td><code>fromJson()</code></td><td><span>Erstellt eine CoverArray-Instanz aus einem JSON-String</span></td><td><span>Öffentlich Statisch</span></td></tr><tr><td><code>get()</code></td><td><span>Gibt Daten anhand von Schlüsseln des aktuellen Objekts mithilfe der Punkt-Notation zurück</span></td><td><span>Öffentlich</span></td></tr><tr><td><code>getDataAsArray()</code></td><td><span>Gibt die Daten des aktuellen Objekts als natives PHP-Array zurück</span></td><td><span>Öffentlich</span></td></tr><tr><td><code>getIterator()</code></td><td><span>Gibt einen Iterator für das Array zurück (IteratorAggregate-Interface)</span></td><td><span>Öffentlich</span></td></tr><tr><td><code>implode()</code></td><td><span>Verbindet Array-Elemente mit einem String</span></td><td><span>Öffentlich</span></td></tr><tr><td><code>isEmpty()</code></td><td><span>Prüft, ob das Array leer ist</span></td><td><span>Öffentlich</span></td></tr><tr><td><code>item()</code></td><td><span>Gibt das Sammlungselement mit dem angegebenen Index als Ergebnis zurück</span></td><td><span>Öffentlich</span></td></tr><tr><td><code>jsonSerialize()</code></td><td><span>Gibt an, welche Daten zu JSON serialisiert werden sollen (JsonSerializable-Interface)</span></td><td><span>Öffentlich</span></td></tr><tr><td><code>offsetExists()</code></td><td><span>Prüft, ob der angegebene Offset im Array existiert (ArrayAccess-Interface)</span></td><td><span>Öffentlich</span></td></tr><tr><td><code>offsetGet()</code></td><td><span>Gibt den Wert am angegebenen Offset zurück (ArrayAccess-Interface)</span></td><td><span>Öffentlich</span></td></tr><tr><td><code>offsetSet()</code></td><td><span>Setzt den Wert am angegebenen Offset (ArrayAccess-Interface)</span></td><td><span>Öffentlich</span></td></tr><tr><td><code>offsetUnset()</code></td><td><span>Hebt den Wert am angegebenen Offset auf (ArrayAccess-Interface)</span></td><td><span>Öffentlich</span></td></tr><tr><td><code>setData()</code></td><td><span>Setzt die internen Daten für das CoverArray</span></td><td><span>Öffentlich</span></td></tr><tr><td><code>toJson()</code></td><td><span>Konvertiert das CoverArray in einen JSON-String</span></td><td><span>Öffentlich</span></td></tr></tbody></table>
