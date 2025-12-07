![Cover Array](logo.jpg)

<h1>Object-Oriented Array for PHP (PHP Collection)</h1>

### Test Status
| PHP Version | Status                                                                                                                                                                               |
|-------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 8.0         | [![PHP 8.0](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php80.yml) |
| 8.1         | [![PHP 8.1](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php81.yml) |
| 8.2         | [![PHP 8.2](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php82.yml) |
| 8.3         | [![PHP 8.3](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php83.yml) |
| 8.4         | [![PHP 8.4](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php84.yml) |
| 8.5         | [![PHP 8.5](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml/badge.svg)](https://github.com/Vasiliy-Makogon/PHP-Collection/actions/workflows/php85.yml) |

### Code Coverage
[![codecov](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection/branch/master/graph/badge.svg)](https://codecov.io/gh/Vasiliy-Makogon/PHP-Collection)


<h2>Introduction</h2>

<p>A PHP class for convenient and flexible array manipulation in object-oriented programming. Essentially, it's the "object array" that PHP has been missing.</p>

<h2>Requirements</h2>
<p>PHP >= 8.0</p>

<h2>Installation</h2>
<pre><code>composer require krugozor/cover</code></pre>

<h2>Comparison Table: CoverArray Methods vs PHP Array Functions</h2>

<table><thead><tr><th><span>#</span></th><th><span>PHP Function</span></th><th><span>CoverArray Method</span></th><th><span>Status</span></th><th><span>Notes</span></th></tr></thead><tbody><tr><td><span>1</span></td><td><code>array</code></td><td><code>__construct()</code><span> / </span><code>fromArray()</code></td><td><span>✅</span></td><td><span>Implemented as constructor and static method</span></td></tr><tr><td><span>2</span></td><td><code>array_all</code></td><td><code>all()</code></td><td><span>✅</span></td><td><span>Implemented with polyfill for older PHP versions</span></td></tr><tr><td><span>3</span></td><td><code>array_any</code></td><td><code>any()</code></td><td><span>✅</span></td><td><span>Implemented with polyfill for older PHP versions</span></td></tr><tr><td><span>4</span></td><td><code>array_change_key_case</code></td><td><code>changeKeyCase()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>5</span></td><td><code>array_chunk</code></td><td><code>chunk()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>6</span></td><td><code>array_column</code></td><td><code>column()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>7</span></td><td><code>array_combine</code></td><td><code>combine()</code></td><td><span>✅</span></td><td><span>Full implementation (static method)</span></td></tr><tr><td><span>8</span></td><td><code>array_count_values</code></td><td><code>countValues()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>9</span></td><td><code>array_diff</code></td><td><code>diff()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>10</span></td><td><code>array_diff_assoc</code></td><td><code>diffAssoc()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>11</span></td><td><code>array_diff_key</code></td><td><code>diffKey()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>12</span></td><td><code>array_diff_uassoc</code></td><td><code>diffUassoc()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>13</span></td><td><code>array_diff_ukey</code></td><td><code>diffUkey()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>14</span></td><td><code>array_fill</code></td><td><code>fill()</code></td><td><span>✅</span></td><td><span>Full implementation (static method)</span></td></tr><tr><td><span>15</span></td><td><code>array_fill_keys</code></td><td><code>fillKeys()</code></td><td><span>✅</span></td><td><span>Full implementation (static method)</span></td></tr><tr><td><span>16</span></td><td><code>array_filter</code></td><td><code>filter()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>17</span></td><td><code>array_find</code></td><td><code>find()</code></td><td><span>✅</span></td><td><span>Implemented with polyfill for older PHP versions</span></td></tr><tr><td><span>18</span></td><td><code>array_find_key</code></td><td><code>findKey()</code></td><td><span>✅</span></td><td><span>Implemented with polyfill for older PHP versions</span></td></tr><tr><td><span>19</span></td><td><code>array_first</code></td><td><code>first()</code></td><td><span>✅</span></td><td><span>Implemented with polyfill for older PHP versions</span></td></tr><tr><td><span>20</span></td><td><code>array_flip</code></td><td><code>flip()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>21</span></td><td><code>array_intersect</code></td><td><code>intersect()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>22</span></td><td><code>array_intersect_assoc</code></td><td><code>intersectAssoc()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>23</span></td><td><code>array_intersect_key</code></td><td><code>intersectKey()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>24</span></td><td><code>array_intersect_uassoc</code></td><td><code>intersectUassoc()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>25</span></td><td><code>array_intersect_ukey</code></td><td><code>intersectUkey()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>26</span></td><td><code>array_is_list</code></td><td><code>isList()</code></td><td><span>✅</span></td><td><span>Implemented with polyfill for older PHP versions</span></td></tr><tr><td><span>27</span></td><td><code>array_key_exists</code></td><td><code>keyExists()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>28</span></td><td><code>array_key_first</code></td><td><code>keyFirst()</code></td><td><span>✅</span></td><td><span>Uses built-in function</span></td></tr><tr><td><span>29</span></td><td><code>array_key_last</code></td><td><code>keyLast()</code></td><td><span>✅</span></td><td><span>Uses built-in function</span></td></tr><tr><td><span>30</span></td><td><code>array_keys</code></td><td><code>keys()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>31</span></td><td><code>array_last</code></td><td><code>last()</code></td><td><span>✅</span></td><td><span>Implemented with polyfill for older PHP versions</span></td></tr><tr><td><span>32</span></td><td><code>array_map</code></td><td><code>map()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>33</span></td><td><code>array_merge</code></td><td><code>merge()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>34</span></td><td><code>array_merge_recursive</code></td><td><code>mergeRecursive()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>35</span></td><td><code>array_multisort</code></td><td><span>❌</span></td><td><span>⚠️</span></td><td><span>Not implemented (commented out)</span></td></tr><tr><td><span>36</span></td><td><code>array_pad</code></td><td><code>pad()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>37</span></td><td><code>array_pop</code></td><td><code>pop()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>38</span></td><td><code>array_product</code></td><td><code>product()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>39</span></td><td><code>array_push</code></td><td><code>push()</code><span> / </span><code>append()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>40</span></td><td><code>array_rand</code></td><td><code>rand()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>41</span></td><td><code>array_reduce</code></td><td><code>reduce()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>42</span></td><td><code>array_replace</code></td><td><code>replace()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>43</span></td><td><code>array_replace_recursive</code></td><td><code>replaceRecursive()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>44</span></td><td><code>array_reverse</code></td><td><code>reverse()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>45</span></td><td><code>array_search</code></td><td><code>search()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>46</span></td><td><code>array_shift</code></td><td><code>shift()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>47</span></td><td><code>array_slice</code></td><td><code>slice()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>48</span></td><td><code>array_splice</code></td><td><code>splice()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>49</span></td><td><code>array_sum</code></td><td><code>sum()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>50</span></td><td><code>array_udiff</code></td><td><code>udiff()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>51</span></td><td><code>array_udiff_assoc</code></td><td><code>udiffAssoc()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>52</span></td><td><code>array_udiff_uassoc</code></td><td><code>udiffUassoc()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>53</span></td><td><code>array_uintersect</code></td><td><code>uintersect()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>54</span></td><td><code>array_uintersect_assoc</code></td><td><code>uintersectAssoc()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>55</span></td><td><code>array_uintersect_uassoc</code></td><td><code>uintersectUassoc()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>56</span></td><td><code>array_unique</code></td><td><code>unique()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>57</span></td><td><code>array_unshift</code></td><td><code>unshift()</code><span> / </span><code>prepend()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>58</span></td><td><code>array_values</code></td><td><code>values()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>59</span></td><td><code>array_walk</code></td><td><code>each()</code></td><td><span>✅</span></td><td><span>Full implementation for associative arrays</span></td></tr><tr><td><span>60</span></td><td><code>array_walk_recursive</code></td><td><code>eachRecursive()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>61</span></td><td><code>arsort</code></td><td><code>arsort()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>62</span></td><td><code>asort</code></td><td><code>asort()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>63</span></td><td><code>compact</code></td><td><code>compact()</code></td><td><span>✅</span></td><td><span>Full implementation (static method)</span></td></tr><tr><td><span>64</span></td><td><code>count</code></td><td><code>count()</code></td><td><span>✅</span></td><td><span>Implementation of Countable interface</span></td></tr><tr><td><span>65</span></td><td><code>current</code></td><td><code>current()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>66</span></td><td><code>each</code></td><td><code>each()</code></td><td><span>✅</span></td><td><span>Full implementation (Note: not equivalent to deprecated PHP </span><code>each()</code><span> function)</span></td></tr><tr><td><span>67</span></td><td><code>end</code></td><td><code>end()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>68</span></td><td><code>extract</code></td><td><code>extract()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>69</span></td><td><code>in_array</code></td><td><code>in()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>70</span></td><td><code>key</code></td><td><code>key()</code></td><td><span>✅</span></td><td><span>Full implementation</span></td></tr><tr><td><span>71</span></td><td><code>krsort</code></td><td><code>krsort()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>72</span></td><td><code>ksort</code></td><td><code>ksort()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>73</span></td><td><code>list</code></td><td><code>list()</code></td><td><span>✅</span></td><td><span>Partial implementation (language limitations)</span></td></tr><tr><td><span>74</span></td><td><code>natcasesort</code></td><td><code>natcasesort()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>75</span></td><td><code>natsort</code></td><td><code>natsort()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>76</span></td><td><code>next</code></td><td><code>next()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>77</span></td><td><code>pos</code></td><td><code>pos()</code></td><td><span>✅</span></td><td><span>Alias of </span><code>current()</code></td></tr><tr><td><span>78</span></td><td><code>prev</code></td><td><code>prev()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>79</span></td><td><code>range</code></td><td><code>range()</code></td><td><span>✅</span></td><td><span>Full implementation (static method)</span></td></tr><tr><td><span>80</span></td><td><code>reset</code></td><td><code>reset()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>81</span></td><td><code>rsort</code></td><td><code>rsort()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>82</span></td><td><code>shuffle</code></td><td><code>shuffle()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>83</span></td><td><code>sizeof</code></td><td><code>sizeof()</code></td><td><span>✅</span></td><td><span>Alias of </span><code>count()</code></td></tr><tr><td><span>84</span></td><td><code>sort</code></td><td><code>sort()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>85</span></td><td><code>uasort</code></td><td><code>uasort()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>86</span></td><td><code>uksort</code></td><td><code>uksort()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr><tr><td><span>87</span></td><td><code>usort</code></td><td><code>usort()</code></td><td><span>✅</span></td><td><span>Full implementation (mutating)</span></td></tr></tbody></table>

<h2>Additional CoverArray Methods:</h2>

<table><thead><tr><th><span>Method</span></th><th><span>Purpose</span></th><th><span>Access</span></th></tr></thead><tbody><tr><td><code>__clone()</code></td><td><span>Creates a shallow copy with deep cloning of immediate object properties</span></td><td><span>Magic</span></td></tr><tr><td><code>__get()</code></td><td><span>Gets a property value using object property syntax</span></td><td><span>Magic</span></td></tr><tr><td><code>__isset()</code></td><td><span>Checks if a property is set</span></td><td><span>Magic</span></td></tr><tr><td><code>__serialize()</code></td><td><span>Serializes the object for serialization</span></td><td><span>Magic</span></td></tr><tr><td><code>__set()</code></td><td><span>Sets a property value using object property syntax</span></td><td><span>Magic</span></td></tr><tr><td><code>__toString()</code></td><td><span>Returns a string representation of the object</span></td><td><span>Magic</span></td></tr><tr><td><code>__unserialize()</code></td><td><span>Unserializes the object from serialized data</span></td><td><span>Magic</span></td></tr><tr><td><code>__unset()</code></td><td><span>Unsets a property</span></td><td><span>Magic</span></td></tr><tr><td><code>clear()</code></td><td><span>Clears all data</span></td><td><span>Public</span></td></tr><tr><td><code>copy()</code></td><td><span>Creates and returns a copy of the current object instance</span></td><td><span>Public</span></td></tr><tr><td><code>fromArray()</code></td><td><span>Creates a CoverArray from a native PHP array</span></td><td><span>Public Static</span></td></tr><tr><td><code>fromExplode()</code></td><td><span>Creates a CoverArray from a string using explode()</span></td><td><span>Public Static</span></td></tr><tr><td><code>fromJson()</code></td><td><span>Creates a CoverArray instance from a JSON string</span></td><td><span>Public Static</span></td></tr><tr><td><code>get()</code></td><td><span>Returns data by keys of the current object using dot notation</span></td><td><span>Public</span></td></tr><tr><td><code>getData()</code></td><td><span>Returns the current object's data (internal array)</span></td><td><span>Public</span></td></tr><tr><td><code>getDataAsArray()</code></td><td><span>Returns the current object's data as a native PHP array</span></td><td><span>Public</span></td></tr><tr><td><code>getIterator()</code></td><td><span>Returns an iterator for the array (IteratorAggregate interface)</span></td><td><span>Public</span></td></tr><tr><td><code>implode()</code></td><td><span>Joins array elements with a string</span></td><td><span>Public</span></td></tr><tr><td><code>isEmpty()</code></td><td><span>Checks if the array is empty</span></td><td><span>Public</span></td></tr><tr><td><code>item()</code></td><td><span>Returns the collection element with the given index as the result</span></td><td><span>Public</span></td></tr><tr><td><code>jsonSerialize()</code></td><td><span>Specifies data which should be serialized to JSON (JsonSerializable interface)</span></td><td><span>Public</span></td></tr><tr><td><code>offsetExists()</code></td><td><span>Checks whether the specified offset exists in the array (ArrayAccess interface)</span></td><td><span>Public</span></td></tr><tr><td><code>offsetGet()</code></td><td><span>Returns the value at the specified offset (ArrayAccess interface)</span></td><td><span>Public</span></td></tr><tr><td><code>offsetSet()</code></td><td><span>Sets the value at the specified offset (ArrayAccess interface)</span></td><td><span>Public</span></td></tr><tr><td><code>offsetUnset()</code></td><td><span>Unsets the value at the specified offset (ArrayAccess interface)</span></td><td><span>Public</span></td></tr><tr><td><code>setData()</code></td><td><span>Sets the internal data for the CoverArray</span></td><td><span>Public</span></td></tr><tr><td><code>toJson()</code></td><td><span>Converts the CoverArray to a JSON string</span></td><td><span>Public</span></td></tr></tbody></table>

<h2>Documentation</h2>

<h3>Introduction</h3>
<p>The base class is called <code>CoverArray</code>. You can create a class that extends <code>CoverArray</code> or use <code>CoverArray</code> directly without inheritance.</p>

<p>In this documentation (and in unit tests), we use the <code>NewTypeArray</code> type which extends <code>CoverArray</code>:</p>

<pre><code>class NewTypeArray extends CoverArray {}</code></pre>

<p>This demonstrates the flexibility of this solution. Your program can have many objects derived from <code>CoverArray</code>, they can differ conceptually and contain different data manipulation logic.</p>

<p>For example, <code>CoverArray</code> objects can be used simply as an "object array" to replace the standard <code>array</code> in daily work, while any other type derived from <code>CoverArray</code> can serve as a DTO-like structure or simply be an independent data type to prevent "shooting yourself in the foot":</p>

<pre><code>function foo(NewTypeArray $cover) {}</code></pre>

<h3>Initialization</h3>

<pre><code>class NewTypeArray extends CoverArray {}

$cover = new NewTypeArray([
    'firstName' => 'Vasiliy',
    'lastName' => 'Ivanov',
    'languages' => [
        'backend' => ['PHP', 'MySql'],
        'frontend' => ['HTML', 'CSS1', 'JavaScript', 'CSS2', 'CSS3']
    ],
]);

var_dump($cover);</code></pre>

<p>Output:</p>
<pre><code>object(NewTypeArray)#2 (1) {
  ["data":protected]=>
  array(3) {
    ["firstName"]=>
    string(7) "Vasiliy"
    ["lastName"]=>
    string(6) "Ivanov"
    ["languages"]=>
    object(NewTypeArray)#4 (1) {
      ["data":protected]=>
      array(2) {
        ["backend"]=>
        object(NewTypeArray)#5 (1) {
          ["data":protected]=>
          array(2) {
            [0]=>
            string(3) "PHP"
            [1]=>
            string(5) "MySql"
          }
        }
        ["frontend"]=>
        object(NewTypeArray)#6 (1) {
          ["data":protected]=>
          array(5) {
            [0]=>
            string(4) "HTML"
            [1]=>
            string(4) "CSS1"
            [2]=>
            string(10) "JavaScript"
            [3]=>
            string(4) "CSS2"
            [4]=>
            string(4) "CSS3"
          }
        }
      }
    }
  }
}</code></pre>

<p>As you can see, all arrays passed to the constructor are recursively converted to <code>NewTypeArray</code> objects. This behavior guarantees that <strong>any array entering the storage will receive a "cover" as an object of the class that accumulates it</strong>.</p>

<p>All created object data is neatly stored in the protected property <code>CoverArray::$data</code>, ensuring data encapsulation, while the base class functionality provides unlimited possibilities for manipulating this data!</p>

<h2>Commonly Used Methods with Examples</h2>

<h3>Basic Access Methods</h3>

<h4>get() - Access elements using dot notation</h4>
<pre><code>$languages = $cover->get('languages');
$frontend = $cover->get('languages.frontend');
$firstLanguage = $cover->get('languages.backend.0');

var_dump($frontend->getDataAsArray());</code></pre>

<p>Output:</p>
<pre><code>array(5) {
  [0]=> string(4) "HTML"
  [1]=> string(4) "CSS1"
  [2]=> string(10) "JavaScript"
  [3]=> string(4) "CSS2"
  [4]=> string(4) "CSS3"
}</code></pre>

<h4>ArrayAccess Interface (Array Syntax)</h4>
<pre><code>// Access using array syntax
$backend = $cover['languages']['backend'];
$firstName = $cover['firstName'];

// Set using array syntax
$cover['age'] = 30;
$cover['languages']['mobile'] = ['Swift', 'Kotlin'];</code></pre>

<h4>Magic Properties Access</h4>
<pre><code>// Access using object property syntax
$lastName = $cover->lastName;
$backend = $cover->languages->backend;

// Set using magic setter
$cover->country = 'Russia';
$cover->languages->database = ['PostgreSQL', 'Redis'];</code></pre>

<h3>Array Manipulation Methods</h3>

<h4>filter() - Filter array elements</h4>
<pre><code>// Filter CSS languages
$cssLanguages = $cover->get('languages.frontend')
    ->filter(function ($value) {
        return str_contains($value, 'CSS');
    })
    ->getDataAsArray();

var_dump($cssLanguages);</code></pre>

<p>Output:</p>
<pre><code>array(3) {
  [1]=> string(4) "CSS1"
  [3]=> string(4) "CSS2"
  [4]=> string(4) "CSS3"
}</code></pre>

<h4>map() / each() - Transform array elements</h4>
<pre><code>// Transform each language to uppercase
$uppercase = $cover->get('languages.backend')
    ->map(fn($lang) => strtoupper($lang))
    ->getDataAsArray();

var_dump($uppercase);</code></pre>

<p>Output:</p>
<pre><code>array(2) {
  [0]=> string(3) "PHP"
  [1]=> string(5) "MYSQL"
}</code></pre>

<pre><code>// Using each() for associative arrays
$formatted = $cover->each(function ($value, $key) {
    return "$key: $value";
})->getDataAsArray();

print_r($formatted);</code></pre>

<p>Output:</p>
<pre><code>Array
(
    [firstName] => firstName: Vasiliy
    [lastName] => lastName: Ivanov
    [languages] => languages: NewTypeArray Object
        (
            [data:protected] => Array
                (
                    [backend] => NewTypeArray Object
                        (
                            [data:protected] => Array
                                (
                                    [0] => PHP
                                    [1] => MySql
                                )
                        )
                    [frontend] => NewTypeArray Object
                        (
                            [data:protected] => Array
                                (
                                    [0] => HTML
                                    [1] => CSS1
                                    [2] => JavaScript
                                    [3] => CSS2
                                    [4] => CSS3
                                )
                        )
                )
        )
)</code></pre>

<h4>append() / push() - Add elements to the end</h4>
<pre><code>$numbers = new NewTypeArray([1, 2, 3]);
$numbers->append(4, 5, 6);
// Or using push() alias
$numbers->push(7, 8);

var_dump($numbers->getDataAsArray());</code></pre>

<p>Output:</p>
<pre><code>array(8) {
  [0]=> int(1)
  [1]=> int(2)
  [2]=> int(3)
  [3]=> int(4)
  [4]=> int(5)
  [5]=> int(6)
  [6]=> int(7)
  [7]=> int(8)
}</code></pre>

<h4>prepend() / unshift() - Add elements to the beginning</h4>
<pre><code>$numbers = new NewTypeArray([4, 5, 6]);
$numbers->prepend(1, 2, 3);
// Or using unshift() alias
$numbers->unshift(0);

var_dump($numbers->getDataAsArray());</code></pre>

<p>Output:</p>
<pre><code>array(7) {
  [0]=> int(0)
  [1]=> int(1)
  [2]=> int(2)
  [3]=> int(3)
  [4]=> int(4)
  [5]=> int(5)
  [6]=> int(6)
}</code></pre>

<h4>implode() - Join array elements with a string</h4>
<pre><code>$backend = $cover->get('languages.backend');
$string = $backend->implode(', ');

echo $string;</code></pre>

<p>Output:</p>
<pre>PHP, MySql</pre>

<h3>Search and Check Methods</h3>

<h4>in() - Check if value exists in array</h4>
<pre><code>$hasPHP = $cover->get('languages.backend')->in('PHP');
$hasJava = $cover->get('languages.backend')->in('Java');

var_dump($hasPHP);
var_dump($hasJava);</code></pre>

<p>Output:</p>
<pre><code>bool(true)
bool(false)</code></pre>

<h4>keyExists() - Check if key exists</h4>
<pre><code>$hasFirstName = $cover->keyExists('firstName');
$hasMiddleName = $cover->keyExists('middleName');

var_dump($hasFirstName);
var_dump($hasMiddleName);</code></pre>

<p>Output:</p>
<pre><code>bool(true)
bool(false)</code></pre>

<h4>find() - Find first element matching callback</h4>
<pre><code>$firstCSS = $cover->get('languages.frontend')
    ->find(fn($lang) => str_starts_with($lang, 'CSS'));

echo $firstCSS;</code></pre>

<p>Output:</p>
<pre>CSS1</pre>

<h3>Utility Methods</h3>

<h4>getFirst() / getLast() - Get first/last element</h4>
<pre><code>$first = $cover->get('languages.backend')->getFirst();
$last = $cover->get('languages.backend')->getLast();

echo $first;
echo $last;</code></pre>

<p>Output:</p>
<pre>PHP
MySql</pre>

<h4>keys() / values() - Get array keys or values</h4>
<pre><code>$keys = $cover->keys()->getDataAsArray();
$values = $cover->values()->getDataAsArray();

print_r($keys);</code></pre>

<p>Output:</p>
<pre><code>Array
(
    [0] => firstName
    [1] => lastName
    [2] => languages
)</code></pre>

<h4>unique() - Remove duplicate values</h4>
<pre><code>$duplicates = new NewTypeArray([1, 2, 2, 3, 1, 4]);
$unique = $duplicates->unique()->getDataAsArray();

print_r($unique);</code></pre>

<p>Output:</p>
<pre><code>Array
(
    [0] => 1
    [1] => 2
    [3] => 3
    [5] => 4
)</code></pre>

<h4>reverse() - Reverse array order</h4>
<pre><code>$original = new NewTypeArray([1, 2, 3, 4, 5]);
$reversed = $original->reverse()->getDataAsArray();

print_r($reversed);</code></pre>

<p>Output:</p>
<pre><code>Array
(
    [0] => 5
    [1] => 4
    [2] => 3
    [3] => 2
    [4] => 1
)</code></pre>

<h3>Data Conversion Methods</h3>

<h4>getDataAsArray() - Convert to plain PHP array</h4>
<pre><code>$array = $cover->getDataAsArray();
print_r($array);</code></pre>

<p>Output:</p>
<pre><code>Array
(
    [firstName] => Vasiliy
    [lastName] => Ivanov
    [languages] => Array
        (
            [backend] => Array
                (
                    [0] => PHP
                    [1] => MySql
                )
            [frontend] => Array
                (
                    [0] => HTML
                    [1] => CSS1
                    [2] => JavaScript
                    [3] => CSS2
                    [4] => CSS3
                )
        )
)</code></pre>

<h4>toJson() / fromJson() - JSON serialization</h4>
<pre><code>// Convert to JSON
$json = $cover->toJson();
echo $json;</code></pre>

<p>Output:</p>
<pre><code>{"firstName":"Vasiliy","lastName":"Ivanov","languages":{"backend":["PHP","MySql"],"frontend":["HTML","CSS1","JavaScript","CSS2","CSS3"]}}</code></pre>

<pre><code>// Create from JSON
$newCover = NewTypeArray::fromJson('{"name":"John","age":25}');
echo $newCover->name;</code></pre>

<p>Output:</p>
<pre>John</pre>

<h4>fromExplode() - Create from delimited string</h4>
<pre><code>$csv = NewTypeArray::fromExplode(',', 'apple,banana,cherry,date');
echo $csv->implode(' | ');</code></pre>

<p>Output:</p>
<pre>apple | banana | cherry | date</pre>

<h3>Chaining Examples</h3>

<h4>Method Chaining</h4>
<pre><code>$result = $cover->get('languages.frontend')
    ->filter(fn($lang) => $lang !== 'JavaScript')
    ->map(fn($lang) => strtoupper($lang))
    ->implode(' - ');

echo $result;</code></pre>

<p>Output:</p>
<pre>HTML - CSS1 - CSS2 - CSS3</pre>

<h4>Complex Transformation</h4>
<pre><code>$htmlList = $cover->get('languages')
    ->each(function ($langs, $category) {
        return sprintf(
            "&lt;li&gt;%s: %s&lt;/li&gt;",
            ucfirst($category),
            $langs->implode(', ')
        );
    })
    ->prepend('&lt;ul&gt;')
    ->append('&lt;/ul&gt;')
    ->implode("\n");

echo $htmlList;</code></pre>

<p>Output:</p>
<pre><code>&lt;ul&gt;
&lt;li&gt;Backend: PHP, MySql&lt;/li&gt;
&lt;li&gt;Frontend: HTML, CSS1, JavaScript, CSS2, CSS3&lt;/li&gt;
&lt;/ul&gt;</code></pre>

<h3>Serialization and Cloning</h3>

<h4>Serialization</h4>
<pre><code>// Serialize
$serialized = serialize($cover->get('languages.backend'));
echo $serialized;</code></pre>

<p>Output:</p>
<pre><code>O:12:"NewTypeArray":2:{i:0;s:3:"PHP";i:1;s:5:"MySql";}</code></pre>

<pre><code>// Deserialize
$unserialized = unserialize($serialized);
echo $unserialized->implode(', ');</code></pre>

<p>Output:</p>
<pre>PHP, MySql</pre>

<h4>Cloning</h4>
<pre><code>$original = new NewTypeArray(['name' => 'John', 'skills' => ['PHP', 'MySQL']]);
$clone = $original->copy();

$clone['name'] = 'Jane';
$clone['skills'][] = 'JavaScript';

echo $original['name'];
echo " | ";
echo $original->get('skills')->implode(', ');</code></pre>

<p>Output:</p>
<pre>John | PHP, MySQL</pre>

<h2>Available Methods</h2>
<p>The class implements ALL analogues of PHP functions for working with arrays, including analogues of functions added in PHP 8.4 and even more!</p>

<h3>Complete Method List</h3>
<ul>
  <li><code>all()</code> - Checks if all array elements satisfy a callback function</li>
  <li><code>any()</code> - Checks if at least one array element satisfies a callback function</li>
  <li><code>append()</code> - Push elements onto the end of array (alias: <code>push()</code>)</li>
  <li><code>changeKeyCase()</code> - Changes the case of all keys in an array</li>
  <li><code>chunk()</code> - Split an array into chunks</li>
  <li><code>clear()</code> - Clears all data from the array</li>
  <li><code>column()</code> - Return values from a single column</li>
  <li><code>combine()</code> - Creates array using one array for keys and another for values</li>
  <li><code>copy()</code> - Creates a copy of the object</li>
  <li><code>count()</code> - Counts elements</li>
  <li><code>countValues()</code> - Counts occurrences of each distinct value</li>
  <li><code>each()</code> - Applies callback to elements (for associative arrays)</li>
  <li><code>eachRecursive()</code> - Applies callback recursively to all elements</li>
  <li><code>fill()</code> - Fill an array with values</li>
  <li><code>fillKeys()</code> - Fill an array with values, specifying keys</li>
  <li><code>filter()</code> - Filters elements using a callback function</li>
  <li><code>find()</code> - Returns first element satisfying a callback</li>
  <li><code>findKey()</code> - Returns key of first element satisfying a callback</li>
  <li><code>flip()</code> - Exchanges keys with their associated values</li>
  <li><code>fromArray()</code> - Creates instance from array</li>
  <li><code>fromExplode()</code> - Creates instance from exploded string</li>
  <li><code>fromJson()</code> - Creates instance from JSON string</li>
  <li><code>get()</code> - Returns data by keys using dot notation</li>
  <li><code>getData()</code> - Returns raw data</li>
  <li><code>getDataAsArray()</code> - Returns data as native PHP array</li>
  <li><code>getFirst()</code> - Returns first element</li>
  <li><code>getLast()</code> - Returns last element</li>
  <li><code>implode()</code> - Join array elements with a string</li>
  <li><code>in()</code> - Checks if value exists in array</li>
  <li><code>isEmpty()</code> - Checks if array is empty</li>
  <li><code>isList()</code> - Checks if array is a list</li>
  <li><code>item()</code> - Returns element by key</li>
  <li><code>jsonSerialize()</code> - Serializes for JSON</li>
  <li><code>keyExists()</code> - Checks if key exists</li>
  <li><code>keyFirst()</code> - Gets first key</li>
  <li><code>keyLast()</code> - Gets last key</li>
  <li><code>keys()</code> - Return all keys or subset of keys</li>
  <li><code>map()</code> - Applies callback to elements</li>
  <li><code>prepend()</code> - Prepend elements to beginning (alias: <code>unshift()</code>)</li>
  <li><code>reverse()</code> - Return array with elements in reverse order</li>
  <li><code>setData()</code> - Sets data from iterable</li>
  <li><code>toJson()</code> - Converts to JSON string</li>
  <li><code>unique()</code> - Removes duplicate values</li>
  <li><code>values()</code> - Return all values of array</li>
</ul>