![Cover Array](logo.jpg)

**Outros idiomas:**
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
- [हिंदी दस्तावेज़](README_hi.md)
- [التوثيق بالعربية](README_ar.md)
- [Türkçe Dokümantasyon](README_tr.md)
- [Tài liệu tiếng Việt](README_vi.md)

---

## Estado
### Status dos Testes
| Versão do PHP | Status                                                                                                                                                                               |
|---------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 8.0           | [![PHP 8.0](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml) |
| 8.1           | [![PHP 8.1](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml) |
| 8.2           | [![PHP 8.2](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml) |
| 8.3           | [![PHP 8.3](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml) |
| 8.4           | [![PHP 8.4](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml) |
| 8.5           | [![PHP 8.5](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml) |

### Cobertura de Código
[![codecov](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection/branch/master/graph/badge.svg)](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection)

## Requisitos
PHP >= 8.0

## Instalação
```
composer require krugozor/cover
```

# CoverArray: Wrapper Orientado a Objetos para Arrays PHP (Coleção PHP)
Criado por humano, verificado e testado por inteligência artificial. Lançamento 2026

## Por que o CoverArray Foi Criado

No desenvolvimento PHP moderno, frequentemente trabalhamos com arrays como a estrutura de dados primária. No entanto, as funções nativas de array do PHP têm várias limitações que o CoverArray resolve.

### O Problema com Arrays Nativos do PHP

- **Nomenclatura inconsistente de funções**: Algumas funções usam sublinhados (`array_map`), outras não (`usort`)
- **Ordem mista de parâmetros**: Funções como `array_map($callback, $array)` vs `array_filter($array, $callback)`
- **Sem encadeamento de métodos**: Funções nativas retornam novos arrays, exigindo variáveis intermediárias
- **Segurança de tipo limitada**: Sem autocompletar de IDE ou suporte a análise estática
- **Sintaxe verbosa**: Operações complexas exigem chamadas de função aninhadas

### O que o CoverArray Resolve

O CoverArray fornece uma interface limpa e orientada a objetos que envolve arrays PHP mantendo total compatibilidade com funções nativas:

```php
// Dados: usuários com idade e status
// Tarefa: obter nomes de usuários ativos maiores de 18 anos, ordenados por pontuação decrescente
$users = [
    ['name' => 'Alice', 'age' => 25, 'active' => true, 'score' => 85],
    ['name' => 'Bob', 'age' => 17, 'active' => false, 'score' => 45],
    ['name' => 'Charlie', 'age' => 32, 'active' => true, 'score' => 92],
    ['name' => 'Diana', 'age' => 19, 'active' => true, 'score' => 78],
    ['name' => 'Eve', 'age' => 22, 'active' => false, 'score' => 61],
];
```

#### Antes (PHP Nativo):
```php
$filtered = array_filter($users, fn($u) => $u['active'] && $u['age'] >= 18);
$sorted = usort($filtered, fn($a, $b) => $b['score'] <=> $a['score']) ? $filtered : [];
$names = array_column($sorted, 'name');
$result = implode(', ', $names); // Charlie, Alice, Diana
```
#### Depois (CoverArray):
```php
// TUDO EM UMA LINHA!
$result = CoverArray::fromArray($users)
    ->filter(fn($u) => $u->active && $u->age >= 18)
    ->usort(fn($a, $b) => $b->score <=> $a->score)
    ->values()
    ->column('name')
    ->implode(', '); // Charlie, Alice, Diana
```
### Principais Benefícios
* **Sem Dependências Externas:** Implementação PHP pura, sem pacotes adicionais necessários
* **API Consistente:** Todos os métodos seguem o padrão `$array->method($arguments)`
* **Encadeamento de Métodos:** Encadeie múltiplas operações de forma legível
* **Suporte de IDE:** Autocompletar completo e dicas de tipo
* **Sintaxe Moderna:** Projetado para PHP 8.0+ com tipagem estrita
* **Notação de Ponto:** Acesso fácil a dados aninhados com `$array->get('user.profile.name')`
* **Suporte JSON:** Serialização/desserialização integrada
* **Operações Imutáveis:** A maioria dos métodos retorna novas instâncias, preservando dados originais
* **Compatibilidade Total:** Funciona perfeitamente com código baseado em array existente

### Casos de Uso do Mundo Real

#### Exemplo 1: Gerenciamento de Configuração com Notação de Ponto
```php
// Carregar e acessar configuração aninhada com segurança
$config = CoverArray::fromJson(file_get_contents('config.json'));

// Acesso aninhado direto com valores padrão de fallback
$dbHost = $config->get('database.connections.mysql.host', fn($value) => $value ?? 'localhost');
$dbPort = $config->get('database.connections.mysql.port', fn($value) => $value ?? 3306);

// Acesso com callback para padrões complexos
$apiKeys = $config->get('services.payment.keys', function($keys) {
    return $keys ?? CoverArray::fromArray([
        'public' => 'default_public_key',
        'secret' => 'default_secret_key'
    ]);
});
```

#### Exemplo 2: Pipeline de Processamento de Resposta de API
```php
// Processamento de API do mundo real: filtrar, transformar e extrair dados
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

// Extrair colunas específicas para dropdown
$userOptions = $apiResponse->column('name', 'id')->getDataAsArray();
```

#### Exemplo 3: Análise de Logs e Relatório de Erros
```php
// Analisar logs de aplicação e extrair padrões de erro
$logLines = CoverArray::fromExplode("\n", file_get_contents('app.log'))
    ->filter(fn($line) => !empty(trim($line)));

// Extrair e categorizar erros
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

// Agrupar por tipo de erro e contar ocorrências
$errorStats = $errors
    ->column('type')
    ->countValues()
    ->arsort(); // Ordenar por frequência

// Gerar relatório de erros
$report = "Error Report:\n";
foreach ($errorStats as $type => $count) {
    $report .= "- {$type}: {$count} occurrences\n";
}

// Encontrar o erro crítico mais recente
$lastCritical = $errors
    ->filter(fn($e) => $e['type'] === 'Critical')
    ->last();
```

O CoverArray preenche a lacuna entre as poderosas funções de array do PHP e práticas modernas orientadas a objetos, tornando a manipulação de arrays mais expressiva, manutenível e agradável.

## Tabela de Comparação: Métodos CoverArray vs Funções de Array do PHP

<table><thead><tr><th><span>#</span></th><th><span>Função PHP</span></th><th><span>Método CoverArray</span></th><th><span>Status</span></th><th><span>Notas</span></th></tr></thead><tbody><tr><td><span>1</span></td><td><code>array_all</code></td><td><code>all()</code></td><td><span>✅</span></td><td><span>Implementado com polyfill para versões antigas do PHP</span></td></tr><tr><td><span>2</span></td><td><code>array_any</code></td><td><code>any()</code></td><td><span>✅</span></td><td><span>Implementado com polyfill para versões antigas do PHP</span></td></tr><tr><td><span>3</span></td><td><code>array_change_key_case</code></td><td><code>changeKeyCase()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>4</span></td><td><code>array_chunk</code></td><td><code>chunk()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>5</span></td><td><code>array_column</code></td><td><code>column()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>6</span></td><td><code>array_combine</code></td><td><code>combine()</code></td><td><span>✅</span></td><td><span>Implementação completa (método estático)</span></td></tr><tr><td><span>7</span></td><td><code>array_count_values</code></td><td><code>countValues()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>8</span></td><td><code>array_diff</code></td><td><code>diff()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>9</span></td><td><code>array_diff_assoc</code></td><td><code>diffAssoc()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>10</span></td><td><code>array_diff_key</code></td><td><code>diffKey()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>11</span></td><td><code>array_diff_uassoc</code></td><td><code>diffUassoc()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>12</span></td><td><code>array_diff_ukey</code></td><td><code>diffUkey()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>13</span></td><td><code>array_fill</code></td><td><code>fill()</code></td><td><span>✅</span></td><td><span>Implementação completa (método estático)</span></td></tr><tr><td><span>14</span></td><td><code>array_fill_keys</code></td><td><code>fillKeys()</code></td><td><span>✅</span></td><td><span>Implementação completa (método estático)</span></td></tr><tr><td><span>15</span></td><td><code>array_filter</code></td><td><code>filter()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>16</span></td><td><code>array_find</code></td><td><code>find()</code></td><td><span>✅</span></td><td><span>Implementado com polyfill para versões antigas do PHP</span></td></tr><tr><td><span>17</span></td><td><code>array_find_key</code></td><td><code>findKey()</code></td><td><span>✅</span></td><td><span>Implementado com polyfill para versões antigas do PHP</span></td></tr><tr><td><span>18</span></td><td><code>array_first</code></td><td><code>first()</code></td><td><span>✅</span></td><td><span>Implementado com polyfill para versões antigas do PHP</span></td></tr><tr><td><span>19</span></td><td><code>array_flip</code></td><td><code>flip()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>20</span></td><td><code>array_intersect</code></td><td><code>intersect()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>21</span></td><td><code>array_intersect_assoc</code></td><td><code>intersectAssoc()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>22</span></td><td><code>array_intersect_key</code></td><td><code>intersectKey()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>23</span></td><td><code>array_intersect_uassoc</code></td><td><code>intersectUassoc()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>24</span></td><td><code>array_intersect_ukey</code></td><td><code>intersectUkey()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>25</span></td><td><code>array_is_list</code></td><td><code>isList()</code></td><td><span>✅</span></td><td><span>Implementado com polyfill para versões antigas do PHP</span></td></tr><tr><td><span>26</span></td><td><code>array_key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>27</span></td><td><code>array_key_first</code></td><td><code>keyFirst()</code></td><td><span>✅</span></td><td><span>Usa função nativa</span></td></tr><tr><td><span>28</span></td><td><code>array_key_last</code></td><td><code>keyLast()</code></td><td><span>✅</span></td><td><span>Usa função nativa</span></td></tr><tr><td><span>29</span></td><td><code>array_keys</code></td><td><code>keys()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>30</span></td><td><code>array_last</code></td><td><code>last()</code></td><td><span>✅</span></td><td><span>Implementado com polyfill para versões antigas do PHP</span></td></tr><tr><td><span>31</span></td><td><code>array_map</code></td><td><code>map()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>32</span></td><td><code>array_merge</code></td><td><code>merge()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>33</span></td><td><code>array_merge_recursive</code></td><td><code>mergeRecursive()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>34</span></td><td><code>array_multisort</code></td><td><code>multisort()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr><tr><td><span>35</span></td><td><code>array_pad</code></td><td><code>pad()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>36</span></td><td><code>array_pop</code></td><td><code>pop()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr><tr><td><span>37</span></td><td><code>array_product</code></td><td><code>product()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>38</span></td><td><code>array_push</code></td><td><code>push()</code><span> / </span><code>append()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr><tr><td><span>39</span></td><td><code>array_rand</code></td><td><code>rand()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>40</span></td><td><code>array_reduce</code></td><td><code>reduce()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>41</span></td><td><code>array_replace</code></td><td><code>replace()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>42</span></td><td><code>array_replace_recursive</code></td><td><code>replaceRecursive()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>43</span></td><td><code>array_reverse</code></td><td><code>reverse()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>44</span></td><td><code>array_search</code></td><td><code>search()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>45</span></td><td><code>array_shift</code></td><td><code>shift()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr><tr><td><span>46</span></td><td><code>array_slice</code></td><td><code>slice()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>47</span></td><td><code>array_splice</code></td><td><code>splice()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr><tr><td><span>48</span></td><td><code>array_sum</code></td><td><code>sum()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>49</span></td><td><code>array_udiff</code></td><td><code>udiff()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>50</span></td><td><code>array_udiff_assoc</code></td><td><code>udiffAssoc()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>51</span></td><td><code>array_udiff_uassoc</code></td><td><code>udiffUassoc()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>52</span></td><td><code>array_uintersect</code></td><td><code>uintersect()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>53</span></td><td><code>array_uintersect_assoc</code></td><td><code>uintersectAssoc()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>54</span></td><td><code>array_uintersect_uassoc</code></td><td><code>uintersectUassoc()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>55</span></td><td><code>array_unique</code></td><td><code>unique()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>56</span></td><td><code>array_unshift</code></td><td><code>unshift()</code><span> / </span><code>prepend()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr><tr><td><span>57</span></td><td><code>array_values</code></td><td><code>values()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>58</span></td><td><code>array_walk</code></td><td><code>walk()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr><tr><td><span>59</span></td><td><code>array_walk_recursive</code></td><td><code>walkRecursive()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr><tr><td><span>60</span></td><td><code>arsort</code></td><td><code>arsort()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr><tr><td><span>61</span></td><td><code>asort</code></td><td><code>asort()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr><tr><td><span>62</span></td><td><code>compact</code></td><td><code>compact()</code></td><td><span>⚠️</span></td><td><span>Não implementável (limitações de escopo do PHP). Use: <code>CoverArray::fromArray(compact(...))</code></span></td></tr><tr><td><span>63</span></td><td><code>count</code></td><td><code>count()</code></td><td><span>✅</span></td><td><span>Implementação da interface Countable</span></td></tr><tr><td><span>64</span></td><td><code>current</code></td><td><code>current()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>65</span></td><td><code>end</code></td><td><code>end()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr><tr><td><span>66</span></td><td><code>extract</code></td><td><code>extract()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>67</span></td><td><code>in_array</code></td><td><code>in()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>68</span></td><td><code>key</code></td><td><code>key()</code></td><td><span>✅</span></td><td><span>Implementação completa</span></td></tr><tr><td><span>69</span></td><td><code>key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>Implementação completa (mesmo que array_key_exists)</span></td></tr><tr><td><span>70</span></td><td><code>krsort</code></td><td><code>krsort()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr><tr><td><span>71</span></td><td><code>ksort</code></td><td><code>ksort()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr><tr><td><span>72</span></td><td><code>list</code></td><td><code>list()</code></td><td><span>⚠️</span></td><td><span>Não implementável (construtor de linguagem). Use: <code>list($a, $b) = $cover->getDataAsArray()</code></span></td></tr><tr><td><span>73</span></td><td><code>natcasesort</code></td><td><code>natcasesort()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr><tr><td><span>74</span></td><td><code>natsort</code></td><td><code>natsort()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr><tr><td><span>75</span></td><td><code>next</code></td><td><code>next()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr><tr><td><span>76</span></td><td><code>pos</code></td><td><code>pos()</code></td><td><span>✅</span></td><td><span>Alias de <code>current()</code></span></td></tr><tr><td><span>77</span></td><td><code>prev</code></td><td><code>prev()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr><tr><td><span>78</span></td><td><code>range</code></td><td><code>range()</code></td><td><span>✅</span></td><td><span>Implementação completa (método estático)</span></td></tr><tr><td><span>79</span></td><td><code>reset</code></td><td><code>reset()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr><tr><td><span>80</span></td><td><code>rsort</code></td><td><code>rsort()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr><tr><td><span>81</span></td><td><code>shuffle</code></td><td><code>shuffle()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr><tr><td><span>82</span></td><td><code>sort</code></td><td><code>sort()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr><tr><td><span>83</span></td><td><code>uasort</code></td><td><code>uasort()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr><tr><td><span>84</span></td><td><code>uksort</code></td><td><code>uksort()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr><tr><td><span>85</span></td><td><code>usort</code></td><td><code>usort()</code></td><td><span>✅</span></td><td><span>Implementação completa (mutável)</span></td></tr></tbody></table>

### Métodos Adicionais do CoverArray

<table><thead><tr><th><span>Método</span></th><th><span>Propósito</span></th><th><span>Acesso</span></th></tr></thead><tbody><tr><td><code>__clone()</code></td><td><span>Cria uma cópia superficial com clonagem profunda de propriedades de objeto imediatas</span></td><td><span>Magic</span></td></tr><tr><td><code>__get()</code></td><td><span>Obtém um valor de propriedade usando sintaxe de propriedade de objeto</span></td><td><span>Magic</span></td></tr><tr><td><code>__isset()</code></td><td><span>Verifica se uma propriedade está definida</span></td><td><span>Magic</span></td></tr><tr><td><code>__serialize()</code></td><td><span>Serializa o objeto para serialização</span></td><td><span>Magic</span></td></tr><tr><td><code>__set()</code></td><td><span>Define um valor de propriedade usando sintaxe de propriedade de objeto</span></td><td><span>Magic</span></td></tr><tr><td><code>__toString()</code></td><td><span>Retorna uma representação em string do objeto</span></td><td><span>Magic</span></td></tr><tr><td><code>__unserialize()</code></td><td><span>Desserializa o objeto a partir de dados serializados</span></td><td><span>Magic</span></td></tr><tr><td><code>__unset()</code></td><td><span>Remove uma propriedade</span></td><td><span>Magic</span></td></tr><tr><td><code>clear()</code></td><td><span>Limpa todos os dados</span></td><td><span>Public</span></td></tr><tr><td><code>copy()</code></td><td><span>Cria e retorna uma cópia da instância do objeto atual</span></td><td><span>Public</span></td></tr><tr><td><code>each()</code></td><td><span>Aplica um callback a cada elemento e retorna uma nova instância com chaves preservadas (imutável, não-recursivo)</span></td><td><span>Public</span></td></tr><tr><td><code>eachRecursive()</code></td><td><span>Aplica recursivamente um callback a cada elemento e retorna uma nova instância (imutável, recursivo)</span></td><td><span>Public</span></td></tr><tr><td><code>fromArray()</code></td><td><span>Cria um CoverArray a partir de um array PHP nativo</span></td><td><span>Public Static</span></td></tr><tr><td><code>fromExplode()</code></td><td><span>Cria um CoverArray a partir de uma string usando explode()</span></td><td><span>Public Static</span></td></tr><tr><td><code>fromJson()</code></td><td><span>Cria uma instância de CoverArray a partir de uma string JSON</span></td><td><span>Public Static</span></td></tr><tr><td><code>get()</code></td><td><span>Retorna dados por chaves do objeto atual usando notação de ponto</span></td><td><span>Public</span></td></tr><tr><td><code>getDataAsArray()</code></td><td><span>Retorna os dados do objeto atual como um array PHP nativo</span></td><td><span>Public</span></td></tr><tr><td><code>getIterator()</code></td><td><span>Retorna um iterador para o array (interface IteratorAggregate)</span></td><td><span>Public</span></td></tr><tr><td><code>implode()</code></td><td><span>Junta elementos do array com uma string</span></td><td><span>Public</span></td></tr><tr><td><code>isEmpty()</code></td><td><span>Verifica se o array está vazio</span></td><td><span>Public</span></td></tr><tr><td><code>item()</code></td><td><span>Retorna o elemento da coleção com o índice fornecido como resultado</span></td><td><span>Public</span></td></tr><tr><td><code>jsonSerialize()</code></td><td><span>Especifica dados que devem ser serializados para JSON (interface JsonSerializable)</span></td><td><span>Public</span></td></tr><tr><td><code>offsetExists()</code></td><td><span>Verifica se o offset especificado existe no array (interface ArrayAccess)</span></td><td><span>Public</span></td></tr><tr><td><code>offsetGet()</code></td><td><span>Retorna o valor no offset especificado (interface ArrayAccess)</span></td><td><span>Public</span></td></tr><tr><td><code>offsetSet()</code></td><td><span>Define o valor no offset especificado (interface ArrayAccess)</span></td><td><span>Public</span></td></tr><tr><td><code>offsetUnset()</code></td><td><span>Remove o valor no offset especificado (interface ArrayAccess)</span></td><td><span>Public</span></td></tr><tr><td><code>setData()</code></td><td><span>Define os dados internos do CoverArray</span></td><td><span>Public</span></td></tr><tr><td><code>toJson()</code></td><td><span>Converte o CoverArray para uma string JSON</span></td><td><span>Public</span></td></tr></tbody></table>
