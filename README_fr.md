![Cover Array](logo.jpg)

**Autres langues :**
- [English documentation](README.md)
- [Русская документация](README_ru.md)
- [Deutsche Dokumentation](README_de.md)
- [Documentazione italiana](README_it.md)
- [日本語ドキュメント](README_jp.md)
- [Documentación en español](README_es.md)
- [한국어 문서](README_kr.md)
- [简体中文文档](README_cn.md)
- [繁體中文文件](README_tw.md)
- [Dokumentasi Bahasa Indonesia](README_id.md)
- [Documentação em Português (BR)](README_br.md)

---

## Statut
### Statut des tests
| Version PHP | Statut                                                                                                                                                                               |
|-------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 8.0         | [![PHP 8.0](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml) |
| 8.1         | [![PHP 8.1](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml) |
| 8.2         | [![PHP 8.2](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml) |
| 8.3         | [![PHP 8.3](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml) |
| 8.4         | [![PHP 8.4](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml) |
| 8.5         | [![PHP 8.5](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml) |

### Couverture du code
[![codecov](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection/branch/master/graph/badge.svg)](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection)

## Exigences
PHP >= 8.0

## Installation
```
composer require krugozor/cover
```

# CoverArray : Encapsulation orientée objet des tableaux PHP (PHP Collection)
Créé par l'homme, vérifié et testé par l'intelligence artificielle. Version 2026

## Pourquoi CoverArray a été créé

Dans le développement PHP moderne, nous travaillons souvent avec des tableaux comme structure de données principale. Cependant, les fonctions natives de PHP pour les tableaux présentent plusieurs limitations que CoverArray résout.

### Le problème avec les tableaux natifs PHP

- **Nommage incohérent des fonctions** : Certaines fonctions utilisent des underscores (`array_map`), d'autres non (`usort`)
- **Ordre mixte des paramètres** : Fonctions comme `array_map($callback, $array)` vs `array_filter($array, $callback)`
- **Pas de chaînage de méthodes** : Les fonctions natives retournent de nouveaux tableaux, nécessitant des variables intermédiaires
- **Sécurité de type limitée** : Pas d'autocomplétion IDE ni de support d'analyse statique
- **Syntaxe verbeuse** : Les opérations complexes nécessitent des appels de fonction imbriqués

### Ce que CoverArray résout

CoverArray fournit une interface propre et orientée objet qui encapsule les tableaux PHP tout en maintenant une compatibilité totale avec les fonctions natives :

```php
// Données : utilisateurs avec âge et statut
// Tâche : obtenir les noms des utilisateurs actifs de plus de 18 ans, triés par score décroissant
$users = [
    ['name' => 'Alice', 'age' => 25, 'active' => true, 'score' => 85],
    ['name' => 'Bob', 'age' => 17, 'active' => false, 'score' => 45],
    ['name' => 'Charlie', 'age' => 32, 'active' => true, 'score' => 92],
    ['name' => 'Diana', 'age' => 19, 'active' => true, 'score' => 78],
    ['name' => 'Eve', 'age' => 22, 'active' => false, 'score' => 61],
];
```

#### Avant (PHP natif) :
```php
$filtered = array_filter($users, fn($u) => $u['active'] && $u['age'] >= 18);
$sorted = usort($filtered, fn($a, $b) => $b['score'] <=> $a['score']) ? $filtered : [];
$names = array_column($sorted, 'name');
$result = implode(', ', $names); // Charlie, Alice, Diana
```
#### Après (CoverArray) :
```php
// TOUT EN UNE LIGNE !
$result = CoverArray::fromArray($users)
    ->filter(fn($u) => $u->active && $u->age >= 18)
    ->usort(fn($a, $b) => $b->score <=> $a->score)
    ->values()
    ->column('name')
    ->implode(', '); // Charlie, Alice, Diana
```
### Avantages clés
* **Aucune dépendance externe :** Implémentation PHP pure, aucun package supplémentaire requis
* **API cohérente :** Toutes les méthodes suivent le modèle `$array->method($arguments)`
* **Chaînage de méthodes :** Enchaînez plusieurs opérations de manière lisible
* **Support IDE :** Autocomplétion complète et indications de type
* **Syntaxe moderne :** Conçu pour PHP 8.0+ avec typage strict
* **Notation par points :** Accès facile aux données imbriquées avec `$array->get('user.profile.name')`
* **Support JSON :** Sérialisation/désérialisation intégrée
* **Opérations immuables :** La plupart des méthodes retournent de nouvelles instances, préservant les données originales
* **Compatibilité totale :** Fonctionne parfaitement avec le code existant basé sur les tableaux

### Cas d'utilisation réels

#### Exemple 1 : Gestion de configuration avec notation par points
```php
// Charger et accéder à la configuration imbriquée en toute sécurité
$config = CoverArray::fromJson(file_get_contents('config.json'));

// Accès direct imbriqué avec valeurs par défaut
$dbHost = $config->get('database.connections.mysql.host', fn($value) => $value ?? 'localhost');
$dbPort = $config->get('database.connections.mysql.port', fn($value) => $value ?? 3306);

// Accès avec callback pour valeurs par défaut complexes
$apiKeys = $config->get('services.payment.keys', function($keys) {
    return $keys ?? CoverArray::fromArray([
        'public' => 'default_public_key',
        'secret' => 'default_secret_key'
    ]);
});
```

#### Exemple 2 : Pipeline de traitement des réponses API
```php
// Traitement réel d'API : filtrer, transformer et extraire les données
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

// Extraire des colonnes spécifiques pour un menu déroulant
$userOptions = $apiResponse->column('name', 'id')->getDataAsArray();
```

#### Exemple 3 : Analyse des logs et rapports d'erreurs
```php
// Analyser les logs d'application et extraire les modèles d'erreurs
$logLines = CoverArray::fromExplode("\n", file_get_contents('app.log'))
    ->filter(fn($line) => !empty(trim($line)));

// Extraire et catégoriser les erreurs
$errors = $logLines
    ->filter(fn($line) => str_contains($line, 'ERROR'))
    ->map(function($line) {
        preg_match('/\[(.*?)\].*ERROR:\s*(\w+)\s*-\s*(.*)/', $line, $matches);
        return [
            'timestamp' => $matches[1] ?? 'Inconnu',
            'type' => $matches[2] ?? 'Général',
            'message' => $matches[3] ?? $line
        ];
    });

// Grouper par type d'erreur et compter les occurrences
$errorStats = $errors
    ->column('type')
    ->countValues()
    ->arsort(); // Trier par fréquence

// Générer le rapport d'erreurs
$report = "Rapport d'erreurs :\n";
foreach ($errorStats as $type => $count) {
    $report .= "- {$type} : {$count} occurrences\n";
}

// Trouver la dernière erreur critique
$lastCritical = $errors
    ->filter(fn($e) => $e['type'] === 'Critical')
    ->last();
```

CoverArray comble le fossé entre les puissantes fonctions de tableaux PHP et les pratiques modernes orientées objet, rendant la manipulation des tableaux plus expressive, maintenable et agréable.

## Tableau de comparaison : Méthodes CoverArray vs Fonctions PHP pour les tableaux

<table><thead><tr><th><span>#</span></th><th><span>Fonction PHP</span></th><th><span>Méthode CoverArray</span></th><th><span>Statut</span></th><th><span>Notes</span></th></tr></thead><tbody><tr><td><span>1</span></td><td><code>array_all</code></td><td><code>all()</code></td><td><span>✅</span></td><td><span>Implémenté avec polyfill pour les anciennes versions PHP</span></td></tr><tr><td><span>2</span></td><td><code>array_any</code></td><td><code>any()</code></td><td><span>✅</span></td><td><span>Implémenté avec polyfill pour les anciennes versions PHP</span></td></tr><tr><td><span>3</span></td><td><code>array_change_key_case</code></td><td><code>changeKeyCase()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>4</span></td><td><code>array_chunk</code></td><td><code>chunk()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>5</span></td><td><code>array_column</code></td><td><code>column()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>6</span></td><td><code>array_combine</code></td><td><code>combine()</code></td><td><span>✅</span></td><td><span>Implémentation complète (méthode statique)</span></td></tr><tr><td><span>7</span></td><td><code>array_count_values</code></td><td><code>countValues()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>8</span></td><td><code>array_diff</code></td><td><code>diff()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>9</span></td><td><code>array_diff_assoc</code></td><td><code>diffAssoc()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>10</span></td><td><code>array_diff_key</code></td><td><code>diffKey()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>11</span></td><td><code>array_diff_uassoc</code></td><td><code>diffUassoc()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>12</span></td><td><code>array_diff_ukey</code></td><td><code>diffUkey()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>13</span></td><td><code>array_fill</code></td><td><code>fill()</code></td><td><span>✅</span></td><td><span>Implémentation complète (méthode statique)</span></td></tr><tr><td><span>14</span></td><td><code>array_fill_keys</code></td><td><code>fillKeys()</code></td><td><span>✅</span></td><td><span>Implémentation complète (méthode statique)</span></td></tr><tr><td><span>15</span></td><td><code>array_filter</code></td><td><code>filter()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>16</span></td><td><code>array_find</code></td><td><code>find()</code></td><td><span>✅</span></td><td><span>Implémenté avec polyfill pour les anciennes versions PHP</span></td></tr><tr><td><span>17</span></td><td><code>array_find_key</code></td><td><code>findKey()</code></td><td><span>✅</span></td><td><span>Implémenté avec polyfill pour les anciennes versions PHP</span></td></tr><tr><td><span>18</span></td><td><code>array_first</code></td><td><code>first()</code></td><td><span>✅</span></td><td><span>Implémenté avec polyfill pour les anciennes versions PHP</span></td></tr><tr><td><span>19</span></td><td><code>array_flip</code></td><td><code>flip()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>20</span></td><td><code>array_intersect</code></td><td><code>intersect()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>21</span></td><td><code>array_intersect_assoc</code></td><td><code>intersectAssoc()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>22</span></td><td><code>array_intersect_key</code></td><td><code>intersectKey()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>23</span></td><td><code>array_intersect_uassoc</code></td><td><code>intersectUassoc()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>24</span></td><td><code>array_intersect_ukey</code></td><td><code>intersectUkey()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>25</span></td><td><code>array_is_list</code></td><td><code>isList()</code></td><td><span>✅</span></td><td><span>Implémenté avec polyfill pour les anciennes versions PHP</span></td></tr><tr><td><span>26</span></td><td><code>array_key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>27</span></td><td><code>array_key_first</code></td><td><code>keyFirst()</code></td><td><span>✅</span></td><td><span>Utilise la fonction intégrée</span></td></tr><tr><td><span>28</span></td><td><code>array_key_last</code></td><td><code>keyLast()</code></td><td><span>✅</span></td><td><span>Utilise la fonction intégrée</span></td></tr><tr><td><span>29</span></td><td><code>array_keys</code></td><td><code>keys()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>30</span></td><td><code>array_last</code></td><td><code>last()</code></td><td><span>✅</span></td><td><span>Implémenté avec polyfill pour les anciennes versions PHP</span></td></tr><tr><td><span>31</span></td><td><code>array_map</code></td><td><code>map()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>32</span></td><td><code>array_merge</code></td><td><code>merge()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>33</span></td><td><code>array_merge_recursive</code></td><td><code>mergeRecursive()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>34</span></td><td><code>array_multisort</code></td><td><code>multisort()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr><tr><td><span>35</span></td><td><code>array_pad</code></td><td><code>pad()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>36</span></td><td><code>array_pop</code></td><td><code>pop()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr><tr><td><span>37</span></td><td><code>array_product</code></td><td><code>product()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>38</span></td><td><code>array_push</code></td><td><code>push()</code><span> / </span><code>append()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr><tr><td><span>39</span></td><td><code>array_rand</code></td><td><code>rand()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>40</span></td><td><code>array_reduce</code></td><td><code>reduce()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>41</span></td><td><code>array_replace</code></td><td><code>replace()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>42</span></td><td><code>array_replace_recursive</code></td><td><code>replaceRecursive()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>43</span></td><td><code>array_reverse</code></td><td><code>reverse()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>44</span></td><td><code>array_search</code></td><td><code>search()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>45</span></td><td><code>array_shift</code></td><td><code>shift()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr><tr><td><span>46</span></td><td><code>array_slice</code></td><td><code>slice()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>47</span></td><td><code>array_splice</code></td><td><code>splice()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr><tr><td><span>48</span></td><td><code>array_sum</code></td><td><code>sum()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>49</span></td><td><code>array_udiff</code></td><td><code>udiff()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>50</span></td><td><code>array_udiff_assoc</code></td><td><code>udiffAssoc()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>51</span></td><td><code>array_udiff_uassoc</code></td><td><code>udiffUassoc()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>52</span></td><td><code>array_uintersect</code></td><td><code>uintersect()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>53</span></td><td><code>array_uintersect_assoc</code></td><td><code>uintersectAssoc()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>54</span></td><td><code>array_uintersect_uassoc</code></td><td><code>uintersectUassoc()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>55</span></td><td><code>array_unique</code></td><td><code>unique()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>56</span></td><td><code>array_unshift</code></td><td><code>unshift()</code><span> / </span><code>prepend()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr><tr><td><span>57</span></td><td><code>array_values</code></td><td><code>values()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>58</span></td><td><code>array_walk</code></td><td><code>walk()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr><tr><td><span>59</span></td><td><code>array_walk_recursive</code></td><td><code>walkRecursive()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr><tr><td><span>60</span></td><td><code>arsort</code></td><td><code>arsort()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr><tr><td><span>61</span></td><td><code>asort</code></td><td><code>asort()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr><tr><td><span>62</span></td><td><code>compact</code></td><td><code>compact()</code></td><td><span>⚠️</span></td><td><span>Non implémentable (limitations de portée PHP). Utilisez : <code>CoverArray::fromArray(compact(...))</code></span></td></tr><tr><td><span>63</span></td><td><code>count</code></td><td><code>count()</code></td><td><span>✅</span></td><td><span>Implémentation de l'interface Countable</span></td></tr><tr><td><span>64</span></td><td><code>current</code></td><td><code>current()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>65</span></td><td><code>end</code></td><td><code>end()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr><tr><td><span>66</span></td><td><code>extract</code></td><td><code>extract()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>67</span></td><td><code>in_array</code></td><td><code>in()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>68</span></td><td><code>key</code></td><td><code>key()</code></td><td><span>✅</span></td><td><span>Implémentation complète</span></td></tr><tr><td><span>69</span></td><td><code>key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>Implémentation complète (identique à array_key_exists)</span></td></tr><tr><td><span>70</span></td><td><code>krsort</code></td><td><code>krsort()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr><tr><td><span>71</span></td><td><code>ksort</code></td><td><code>ksort()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr><tr><td><span>72</span></td><td><code>list</code></td><td><code>list()</code></td><td><span>⚠️</span></td><td><span>Non implémentable (construction du langage). Utilisez : <code>list($a, $b) = $cover->getDataAsArray()</code></span></td></tr><tr><td><span>73</span></td><td><code>natcasesort</code></td><td><code>natcasesort()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr><tr><td><span>74</span></td><td><code>natsort</code></td><td><code>natsort()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr><tr><td><span>75</span></td><td><code>next</code></td><td><code>next()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr><tr><td><span>76</span></td><td><code>pos</code></td><td><code>pos()</code></td><td><span>✅</span></td><td><span>Alias de <code>current()</code></span></td></tr><tr><td><span>77</span></td><td><code>prev</code></td><td><code>prev()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr><tr><td><span>78</span></td><td><code>range</code></td><td><code>range()</code></td><td><span>✅</span></td><td><span>Implémentation complète (méthode statique)</span></td></tr><tr><td><span>79</span></td><td><code>reset</code></td><td><code>reset()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr><tr><td><span>80</span></td><td><code>rsort</code></td><td><code>rsort()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr><tr><td><span>81</span></td><td><code>shuffle</code></td><td><code>shuffle()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr><tr><td><span>82</span></td><td><code>sort</code></td><td><code>sort()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr><tr><td><span>83</span></td><td><code>uasort</code></td><td><code>uasort()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr><tr><td><span>84</span></td><td><code>uksort</code></td><td><code>uksort()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr><tr><td><span>85</span></td><td><code>usort</code></td><td><code>usort()</code></td><td><span>✅</span></td><td><span>Implémentation complète (mutante)</span></td></tr></tbody></table>

### Méthodes additionnelles CoverArray

<table><thead><tr><th><span>Méthode</span></th><th><span>Objectif</span></th><th><span>Accès</span></th></tr></thead><tbody><tr><td><code>__clone()</code></td><td><span>Crée une copie superficielle avec clonage profond des propriétés d'objet immédiates</span></td><td><span>Magique</span></td></tr><tr><td><code>__get()</code></td><td><span>Obtient une valeur de propriété en utilisant la syntaxe de propriété d'objet</span></td><td><span>Magique</span></td></tr><tr><td><code>__isset()</code></td><td><span>Vérifie si une propriété est définie</span></td><td><span>Magique</span></td></tr><tr><td><code>__serialize()</code></td><td><span>Sérialise l'objet pour la sérialisation</span></td><td><span>Magique</span></td></tr><tr><td><code>__set()</code></td><td><span>Définit une valeur de propriété en utilisant la syntaxe de propriété d'objet</span></td><td><span>Magique</span></td></tr><tr><td><code>__toString()</code></td><td><span>Retourne une représentation en chaîne de l'objet</span></td><td><span>Magique</span></td></tr><tr><td><code>__unserialize()</code></td><td><span>Désérialise l'objet à partir de données sérialisées</span></td><td><span>Magique</span></td></tr><tr><td><code>__unset()</code></td><td><span>Supprime une propriété</span></td><td><span>Magique</span></td></tr><tr><td><code>clear()</code></td><td><span>Efface toutes les données</span></td><td><span>Public</span></td></tr><tr><td><code>copy()</code></td><td><span>Crée et retourne une copie de l'instance actuelle de l'objet</span></td><td><span>Public</span></td></tr><tr><td><code>each()</code></td><td><span>Applique un callback à chaque élément et retourne une nouvelle instance avec préservation des clés (immuable, non-récursif)</span></td><td><span>Public</span></td></tr><tr><td><code>eachRecursive()</code></td><td><span>Applique récursivement un callback à chaque élément et retourne une nouvelle instance (immuable, récursif)</span></td><td><span>Public</span></td></tr><tr><td><code>fromArray()</code></td><td><span>Crée un CoverArray à partir d'un tableau PHP natif</span></td><td><span>Public Statique</span></td></tr><tr><td><code>fromExplode()</code></td><td><span>Crée un CoverArray à partir d'une chaîne en utilisant explode()</span></td><td><span>Public Statique</span></td></tr><tr><td><code>fromJson()</code></td><td><span>Crée une instance CoverArray à partir d'une chaîne JSON</span></td><td><span>Public Statique</span></td></tr><tr><td><code>get()</code></td><td><span>Retourne les données par clés de l'objet actuel en utilisant la notation par points</span></td><td><span>Public</span></td></tr><tr><td><code>getDataAsArray()</code></td><td><span>Retourne les données de l'objet actuel sous forme de tableau PHP natif</span></td><td><span>Public</span></td></tr><tr><td><code>getIterator()</code></td><td><span>Retourne un itérateur pour le tableau (interface IteratorAggregate)</span></td><td><span>Public</span></td></tr><tr><td><code>implode()</code></td><td><span>Joint les éléments du tableau avec une chaîne</span></td><td><span>Public</span></td></tr><tr><td><code>isEmpty()</code></td><td><span>Vérifie si le tableau est vide</span></td><td><span>Public</span></td></tr><tr><td><code>item()</code></td><td><span>Retourne l'élément de la collection avec l'index donné comme résultat</span></td><td><span>Public</span></td></tr><tr><td><code>jsonSerialize()</code></td><td><span>Spécifie les données qui doivent être sérialisées en JSON (interface JsonSerializable)</span></td><td><span>Public</span></td></tr><tr><td><code>offsetExists()</code></td><td><span>Vérifie si l'offset spécifié existe dans le tableau (interface ArrayAccess)</span></td><td><span>Public</span></td></tr><tr><td><code>offsetGet()</code></td><td><span>Retourne la valeur à l'offset spécifié (interface ArrayAccess)</span></td><td><span>Public</span></td></tr><tr><td><code>offsetSet()</code></td><td><span>Définit la valeur à l'offset spécifié (interface ArrayAccess)</span></td><td><span>Public</span></td></tr><tr><td><code>offsetUnset()</code></td><td><span>Supprime la valeur à l'offset spécifié (interface ArrayAccess)</span></td><td><span>Public</span></td></tr><tr><td><code>setData()</code></td><td><span>Définit les données internes pour le CoverArray</span></td><td><span>Public</span></td></tr><tr><td><code>toJson()</code></td><td><span>Convertit le CoverArray en chaîne JSON</span></td><td><span>Public</span></td></tr></tbody></table>
