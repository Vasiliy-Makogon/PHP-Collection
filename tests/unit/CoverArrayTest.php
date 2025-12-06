<?php

declare(strict_types=1);

use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class CoverArrayTest extends TestCase
{
    /** @var NewTypeArray */
    protected NewTypeArray $data;

    public function setUp(): void
    {
        $this->data = new NewTypeArray([
            'name' => 'Vasiliy',
            'birthday' => [18, 8, 1982],
            'languages' => [
                'backend' => ['PHP', 'MySql'],
                'frontend' => ['HTML', 'CSS', 'JavaScript']
            ],
            'address' => [
                'country' => 'Russia',
                'region' => 'Moscow region',
                'city' => 'Podolsk',
                'street' => 'Kirov st.'
            ]
        ]);
    }

    /**
     * Tests the CoverArray constructor with empty values.
     *
     * This test verifies that the CoverArray constructor correctly handles
     * empty and null input values, ensuring that no data is populated
     * when no initial data is provided or when null is explicitly passed.
     *
     *
     * Тестирование конструктора CoverArray с пустыми значениями.
     *
     * Этот тест проверяет, что конструктор CoverArray корректно обрабатывает
     * пустые и null входные значения, гарантируя, что данные не заполняются
     * когда не предоставлены начальные данные или когда явно передается null.
     *
     * @see CoverArray::__construct()
     */
    public function testConstructorOnEmptyValue(): void
    {
        $this->assertEmpty(new NewTypeArray(null));
        $this->assertEmpty(new NewTypeArray());
    }

    /**
     * Tests the Countable interface implementation.
     *
     * This test verifies that CoverArray correctly implements
     * the Countable interface, allowing the use of count()
     * function and Countable type checks.
     *
     *
     * Тестирование реализации интерфейса Countable.
     *
     * Этот тест проверяет, что CoverArray корректно реализует
     * интерфейс Countable, позволяя использование функции count()
     * и проверки типа Countable.
     *
     * @see Countable
     * @see CoverArray::count()
     */
    public function testImplementsCountable(): void
    {
        $this->assertInstanceOf(Countable::class, $this->data);

        // Проверка совместимости с функцией count()
        $this->assertEquals(count($this->data), $this->data->count(),
            'count() function should work with CoverArray');

        // Проверка с пустым массивом
        $empty = new NewTypeArray();
        $this->assertEquals(0, count($empty),
            'Empty CoverArray should have count 0');

        // Проверка с непустым массивом
        $nonEmpty = new NewTypeArray(['a' => 1, 'b' => 2, 'c' => 3]);
        $this->assertEquals(3, count($nonEmpty),
            'CoverArray with 3 elements should have count 3');
    }

    /**
     * Tests the IteratorAggregate interface implementation.
     *
     * This test verifies that CoverArray correctly implements
     * the IteratorAggregate interface, allowing iteration over
     * its elements using foreach loops and Traversable type checks.
     *
     *
     * Тестирование реализации интерфейса IteratorAggregate.
     *
     * Этот тест проверяет, что CoverArray корректно реализует
     * интерфейс IteratorAggregate, позволяя итерацию по его
     * элементам с использованием циклов foreach и проверок типа Traversable.
     *
     * @see CoverArray::getIterator()
     * @see IteratorAggregate
     * @see Traversable
     */
    public function testIsIterable(): void
    {
        $this->assertIsIterable($this->data);

        // Дополнительная проверка, что это действительно Traversable
        $this->assertInstanceOf(Traversable::class, $this->data->getIterator());

        // Проверка фактической итерации
        $count = 0;
        foreach ($this->data as $key => $value) {
            $count++;
            $this->assertNotNull($key, 'Key should not be null during iteration');
            $this->assertNotNull($value, 'Value should not be null during iteration');
        }

        $this->assertEquals($this->data->count(), $count,
            'Iteration should cover all elements');
    }

    /**
     * Tests the each() method.
     *
     * This test verifies that the each() method correctly applies
     * a callback function to all elements of the CoverArray while
     * preserving keys, returning a new CoverArray instance with
     * transformed values. Unlike map(), each() always preserves
     * the original array structure and key associations.
     *
     *
     * Тестирование метода each().
     *
     * Этот тест проверяет, что метод each() корректно применяет
     * callback-функцию ко всем элементам CoverArray, сохраняя
     * ключи, и возвращает новый экземпляр CoverArray с
     * преобразованными значениями. В отличие от map(), each()
     * всегда сохраняет оригинальную структуру массива и ассоциации ключей.
     *
     * @see CoverArray::each()
     * @see CoverArray::map()
     */
    public function testEachMethod(): void
    {
        // Test basic transformation preserving keys
        $data = $this->data->get('address');
        $result = $data->each(fn($value) => strtoupper($value));

        $this->assertInstanceOf(NewTypeArray::class, $result);
        $this->assertNotSame($data, $result, 'each() should return new instance');

        $expected = [
            'country' => 'RUSSIA',
            'region' => 'MOSCOW REGION',
            'city' => 'PODOLSK',
            'street' => 'KIROV ST.'
        ];

        $this->assertEquals($expected, $result->getDataAsArray());

        // Test with key as second parameter
        $withKeys = $data->each(fn($value, $key) => "$key: $value");

        $expectedWithKeys = [
            'country' => 'country: Russia',
            'region' => 'region: Moscow region',
            'city' => 'city: Podolsk',
            'street' => 'street: Kirov st.'
        ];

        $this->assertEquals($expectedWithKeys, $withKeys->getDataAsArray());

        // Test with numeric keys (list)
        $listData = $this->data->get('birthday');
        $listResult = $listData->each(fn($value) => $value * 2);

        $this->assertTrue($listResult->isList());
        $this->assertEquals([36, 16, 3964], $listResult->getDataAsArray());
        $this->assertEquals(0, $listResult->keyFirst());
        $this->assertEquals(2, $listResult->keyLast());

        // Test that original array is not modified
        $originalValues = $data->getDataAsArray();
        $data->each(fn($value) => "modified-$value");
        $this->assertEquals($originalValues, $data->getDataAsArray(),
            'Original array should not be modified by each()');

        // Test with empty array
        $empty = new NewTypeArray();
        $emptyResult = $empty->each(fn($value) => $value * 2);
        $this->assertTrue($emptyResult->isEmpty());
        $this->assertEquals(0, $emptyResult->count());

        // Test complex transformation with nested arrays
        $nested = $this->data->get('languages');
        $nestedResult = $nested->each(function($value) {
            return $value->each(fn($lang) => strtolower($lang));
        });

        $this->assertInstanceOf(NewTypeArray::class, $nestedResult);
        $this->assertInstanceOf(NewTypeArray::class, $nestedResult['backend']);
        $this->assertInstanceOf(NewTypeArray::class, $nestedResult['frontend']);

        $this->assertEquals(['php', 'mysql'], $nestedResult['backend']->getDataAsArray());
        $this->assertEquals(['html', 'css', 'javascript'], $nestedResult['frontend']->getDataAsArray());

        // Test returning different types
        $mixedData = new NewTypeArray(['a' => 1, 'b' => 2, 'c' => 3]);
        $mixedResult = $mixedData->each(function($value, $key) {
            return ['key' => $key, 'value' => $value, 'doubled' => $value * 2];
        });

        $expectedMixed = [
            'a' => ['key' => 'a', 'value' => 1, 'doubled' => 2],
            'b' => ['key' => 'b', 'value' => 2, 'doubled' => 4],
            'c' => ['key' => 'c', 'value' => 3, 'doubled' => 6]
        ];

        $this->assertEquals($expectedMixed, $mixedResult->getDataAsArray());

        // Test that arrays in result are converted to CoverArray
        $this->assertInstanceOf(NewTypeArray::class, $mixedResult['a']);
        $this->assertEquals(1, $mixedResult['a']['value']);
        $this->assertEquals(2, $mixedResult['a']['doubled']);

        // Test comparison with map() - each preserves keys, map may not
        $testArray = new NewTypeArray(['a' => 1, 'b' => 2]);

        $eachResult = $testArray->each(fn($v) => $v * 2);
        $mapResult = $testArray->map(fn($v) => $v * 2);

        // each() preserves keys
        $this->assertEquals(['a' => 2, 'b' => 4], $eachResult->getDataAsArray());
        // map() with single array also preserves keys
        $this->assertEquals(['a' => 2, 'b' => 4], $mapResult->getDataAsArray());

        // But map() with multiple arrays loses keys
        $mapMultiResult = $testArray->map(fn($v1, $v2) => $v1 + $v2, [10, 20]);
        $this->assertTrue(array_keys($mapMultiResult->getDataAsArray()) === [0, 1],
            'map() with multiple arrays returns sequential keys');
    }

    /**
     * Tests the offsetSet() method implementation.
     *
     * This test verifies that the ArrayAccess interface implementation
     * correctly sets values at specified offsets, handling both
     * associative and numeric keys, and automatically converting
     * arrays to CoverArray instances. It also tests appending
     * elements when offset is null.
     *
     *
     * Тестирование реализации метода offsetSet().
     *
     * Этот тест проверяет, что реализация интерфейса ArrayAccess
     * корректно устанавливает значения по указанным смещениям,
     * обрабатывая как ассоциативные, так и числовые ключи,
     * и автоматически преобразуя массивы в экземпляры CoverArray.
     * Также проверяется добавление элементов при offset равном null.
     *
     * @see CoverArray::offsetSet()
     * @see ArrayAccess::offsetSet()
     */
    public function testOffsetSetMethod(): void
    {
        // Test setting with explicit key
        $this->data['workplaces'] = ['Mvideo', 'Svyaznoy'];
        $this->data['pets'] = new NewTypeArray(['cat']);

        $this->assertSame(
            ['Mvideo', 'Svyaznoy'],
            $this->data->get('workplaces')->getDataAsArray()
        );
        $this->assertSame(
            ['cat'],
            $this->data->get('pets')->getDataAsArray()
        );

        $this->assertInstanceOf(NewTypeArray::class, $this->data->get('workplaces'));
        $this->assertInstanceOf(NewTypeArray::class, $this->data->get('pets'));

        // Test appending without key (null offset)
        $array = new NewTypeArray(['first']);

        // Append a value without specifying key - should add to the end
        $array[] = 'second';
        $array[] = 'third';

        $this->assertSame(['first', 'second', 'third'], $array->getDataAsArray());
        $this->assertEquals(0, $array->keyFirst());
        $this->assertEquals(2, $array->keyLast());
        $this->assertEquals('first', $array[0]);
        $this->assertEquals('second', $array[1]);
        $this->assertEquals('third', $array[2]);

        // Test appending with mixed types
        $mixedArray = new NewTypeArray();
        $mixedArray[] = 'string';
        $mixedArray[] = 123;
        $mixedArray[] = ['nested' => 'value'];
        $mixedArray[] = new NewTypeArray(['inner' => 'data']);

        $this->assertEquals(4, $mixedArray->count());
        $this->assertEquals('string', $mixedArray[0]);
        $this->assertEquals(123, $mixedArray[1]);
        $this->assertInstanceOf(NewTypeArray::class, $mixedArray[2]);
        $this->assertEquals('value', $mixedArray[2]['nested']);
        $this->assertInstanceOf(NewTypeArray::class, $mixedArray[3]);
        $this->assertEquals('data', $mixedArray[3]['inner']);

        // Test appending to empty array
        $empty = new NewTypeArray();
        $empty[] = 'first element';
        $this->assertEquals(1, $empty->count());
        $this->assertEquals('first element', $empty[0]);

        // Test overwriting existing numeric key vs appending
        $numericArray = new NewTypeArray(['a', 'b', 'c']);
        $numericArray[1] = 'replaced'; // Replace existing
        $numericArray[] = 'appended';   // Append new

        $this->assertEquals(['a', 'replaced', 'c', 'appended'], $numericArray->getDataAsArray());
        $this->assertEquals(4, $numericArray->count());

        // Test that array values are converted to CoverArray instances
        $conversionTest = new NewTypeArray();
        $conversionTest[] = ['key1' => 'value1', 'key2' => ['nested' => 'value']];

        $this->assertInstanceOf(NewTypeArray::class, $conversionTest[0]);
        $this->assertEquals('value1', $conversionTest[0]['key1']);
        $this->assertInstanceOf(NewTypeArray::class, $conversionTest[0]['key2']);
        $this->assertEquals('value', $conversionTest[0]['key2']['nested']);
    }

    /**
     * Tests the offsetGet() method implementation.
     *
     * This test verifies that the ArrayAccess interface implementation
     * correctly retrieves values from specified offsets, returning null
     * for non-existent keys and maintaining the nested CoverArray structure.
     *
     *
     * Тестирование реализации метода offsetGet().
     *
     * Этот тест проверяет, что реализация интерфейса ArrayAccess
     * корректно извлекает значения по указанным смещениям,
     * возвращая null для несуществующих ключей и сохраняя
     * вложенную структуру CoverArray.
     *
     * @see CoverArray::offsetGet()
     * @see ArrayAccess::offsetGet()
     */
    public function testOffsetGetMethod(): void
    {
        $this->assertSame('Vasiliy', $this->data['name']);
        $this->assertSame('PHP', $this->data['languages']['backend'][0]);
        $this->assertInstanceOf(NewTypeArray::class, $this->data['languages']['backend']);
        $this->assertInstanceOf(CoverArray::class, $this->data['languages']['backend']);
        $this->assertNull($this->data['nonexistent']);
    }

    /**
     * Tests the offsetExists() method implementation.
     *
     * This test verifies that the ArrayAccess interface implementation
     * correctly checks for the existence of keys at specified offsets,
     * returning true for existing keys and false for non-existent ones.
     *
     *
     * Тестирование реализации метода offsetExists().
     *
     * Этот тест проверяет, что реализация интерфейса ArrayAccess
     * корректно проверяет существование ключей по указанным смещениям,
     * возвращая true для существующих ключей и false для несуществующих.
     *
     * @see CoverArray::offsetExists()
     * @see ArrayAccess::offsetExists()
     */
    public function testOffsetExistsMethod(): void
    {
        $this->assertTrue(isset($this->data['name']));
        $this->assertFalse(isset($this->data['nonexistent']));
    }

    /**
     * Tests the offsetUnset() method implementation.
     *
     * This test verifies that the ArrayAccess interface implementation
     * correctly removes elements at specified offsets, ensuring that
     * unset operations work consistently with PHP array behavior.
     *
     *
     * Тестирование реализации метода offsetUnset().
     *
     * Этот тест проверяет, что реализация интерфейса ArrayAccess
     * корректно удаляет элементы по указанным смещениям,
     * гарантируя согласованность операций unset с поведением PHP массивов.
     *
     * @see CoverArray::offsetUnset()
     * @see ArrayAccess::offsetUnset()
     */
    public function testOffsetUnsetMethod(): void
    {
        unset($this->data['name']);
        $this->assertFalse(isset($this->data['name']));
    }

    /**
     * Tests the __serialize() method implementation.
     *
     * This test verifies that the serialization mechanism correctly
     * converts CoverArray instances to a serialized representation,
     * preserving the internal data structure for storage or transmission.
     *
     *
     * Тестирование реализации метода __serialize().
     *
     * Этот тест проверяет, что механизм сериализации корректно
     * преобразует экземпляры CoverArray в сериализованное представление,
     * сохраняя внутреннюю структуру данных для хранения или передачи.
     *
     * @see CoverArray::__serialize()
     */
    public function testSerializeMethod(): void
    {
        $this->assertSame(
            'O:33:"Krugozor\Cover\Tests\NewTypeArray":2:{i:0;s:3:"PHP";i:1;s:5:"MySql";}',
            serialize($this->data->get('languages.backend'))
        );
    }

    /**
     * Tests the __unserialize() method implementation.
     *
     * This test verifies that the deserialization mechanism correctly
     * reconstructs CoverArray instances from serialized data,
     * restoring the original data structure and type information.
     *
     *
     * Тестирование реализации метода __unserialize().
     *
     * Этот тест проверяет, что механизм десериализации корректно
     * восстанавливает экземпляры CoverArray из сериализованных данных,
     * восстанавливая оригинальную структуру данных и информацию о типах.
     *
     * @see CoverArray::__unserialize()
     */
    public function testUnserializeMethod(): void
    {
        $this->assertEquals(
            unserialize('O:33:"Krugozor\Cover\Tests\NewTypeArray":2:{i:0;s:3:"PHP";i:1;s:5:"MySql";}'),
            $this->data->get('languages.backend')
        );
    }

    /**
     * Tests the getDataAsArray() method.
     *
     * This test verifies that getDataAsArray() correctly converts
     * the entire CoverArray structure, including nested instances,
     * to a plain PHP array representation while preserving values.
     *
     *
     * Тестирование метода getDataAsArray().
     *
     * Этот тест проверяет, что getDataAsArray() корректно преобразует
     * всю структуру CoverArray, включая вложенные экземпляры,
     * в представление в виде обычного PHP массива, сохраняя значения.
     *
     * @see CoverArray::getDataAsArray()
     */
    public function testGetDataAsArrayMethod(): void
    {
        $this->assertIsArray($this->data->getDataAsArray());
    }

    /**
     * Tests the jsonSerialize() method implementation.
     *
     * This test verifies that the JsonSerializable interface implementation
     * correctly returns data suitable for JSON serialization, converting
     * the entire CoverArray structure including nested instances to a
     * plain PHP array representation compatible with json_encode().
     *
     *
     * Тестирование реализации метода jsonSerialize().
     *
     * Этот тест проверяет, что реализация интерфейса JsonSerializable
     * корректно возвращает данные, пригодные для JSON сериализации,
     * преобразуя всю структуру CoverArray, включая вложенные экземпляры,
     * в представление в виде обычного PHP массива, совместимое с json_encode().
     *
     * @see CoverArray::jsonSerialize()
     * @see JsonSerializable
     */
    public function testJsonSerializeMethod(): void
    {
        // Test basic JSON serialization
        $data = $this->data->get('address');
        $jsonData = $data->jsonSerialize();

        $this->assertIsArray($jsonData);
        $this->assertEquals([
            'country' => 'Russia',
            'region' => 'Moscow region',
            'city' => 'Podolsk',
            'street' => 'Kirov st.'
        ], $jsonData);

        // Test that json_encode() works with CoverArray
        $jsonString = json_encode($data);
        $expectedJson = '{"country":"Russia","region":"Moscow region","city":"Podolsk","street":"Kirov st."}';
        $this->assertEquals($expectedJson, $jsonString);

        // Test with nested CoverArray structures
        $nestedData = $this->data->get('languages');
        $nestedJson = $nestedData->jsonSerialize();

        $this->assertIsArray($nestedJson);
        $this->assertIsArray($nestedJson['backend']);
        $this->assertIsArray($nestedJson['frontend']);
        $this->assertEquals(['PHP', 'MySql'], $nestedJson['backend']);
        $this->assertEquals(['HTML', 'CSS', 'JavaScript'], $nestedJson['frontend']);

        // Test json_encode with nested structure
        $nestedJsonString = json_encode($nestedData);
        $expectedNestedJson = '{"backend":["PHP","MySql"],"frontend":["HTML","CSS","JavaScript"]}';
        $this->assertEquals($expectedNestedJson, $nestedJsonString);

        // Test with empty CoverArray
        $empty = new NewTypeArray();
        $emptyJson = $empty->jsonSerialize();
        $this->assertIsArray($emptyJson);
        $this->assertEquals([], $emptyJson);
        $this->assertEquals('[]', json_encode($empty));

        // Test with mixed data types
        $mixed = new NewTypeArray([
            'string' => 'text',
            'integer' => 42,
            'float' => 3.14,
            'boolean' => true,
            'null' => null,
            'array' => [1, 2, 3],
            'nested' => new NewTypeArray(['key' => 'value'])
        ]);

        $mixedJson = $mixed->jsonSerialize();
        $this->assertIsArray($mixedJson);
        $this->assertEquals('text', $mixedJson['string']);
        $this->assertEquals(42, $mixedJson['integer']);
        $this->assertEquals(3.14, $mixedJson['float']);
        $this->assertTrue($mixedJson['boolean']);
        $this->assertNull($mixedJson['null']);
        $this->assertEquals([1, 2, 3], $mixedJson['array']);
        $this->assertIsArray($mixedJson['nested']);
        $this->assertEquals(['key' => 'value'], $mixedJson['nested']);

        // Test JSON encoding with all data types
        $jsonEncoded = json_encode($mixed);
        $decoded = json_decode($jsonEncoded, true);

        $this->assertEquals('text', $decoded['string']);
        $this->assertEquals(42, $decoded['integer']);
        $this->assertEquals(3.14, $decoded['float']);
        $this->assertTrue($decoded['boolean']);
        $this->assertNull($decoded['null']);
        $this->assertEquals([1, 2, 3], $decoded['array']);
        $this->assertEquals(['key' => 'value'], $decoded['nested']);

        // Test that jsonSerialize returns the same as getDataAsArray
        $this->assertEquals($data->getDataAsArray(), $data->jsonSerialize());
        $this->assertEquals($nestedData->getDataAsArray(), $nestedData->jsonSerialize());
        $this->assertEquals($mixed->getDataAsArray(), $mixed->jsonSerialize());

        // Test with JSON options
        $dataWithSpecialChars = new NewTypeArray([
            'name' => 'Vasiliy "The Developer"',
            'html' => '<div>Test</div>',
            'unicode' => '© 🚀 émojî'
        ]);

        $defaultJson = json_encode($dataWithSpecialChars);

        // Decode and verify the values
        $decodedSpecial = json_decode($defaultJson, true);
        $this->assertEquals('Vasiliy "The Developer"', $decodedSpecial['name']);
        $this->assertEquals('<div>Test</div>', $decodedSpecial['html']);
        $this->assertEquals('© 🚀 émojî', $decodedSpecial['unicode']);

        // Test with JSON_UNESCAPED_UNICODE flag
        $unicodeData = new NewTypeArray(['unicode' => '© 🚀 émojî']);
        $jsonUnicode = json_encode($unicodeData, JSON_UNESCAPED_UNICODE);
        $decodedUnicode = json_decode($jsonUnicode, true);
        $this->assertEquals('© 🚀 émojî', $decodedUnicode['unicode']);

        // Test with JSON_UNESCAPED_SLASHES flag
        $slashesData = new NewTypeArray(['path' => '/usr/local/bin']);
        $jsonSlashes = json_encode($slashesData, JSON_UNESCAPED_SLASHES);
        $this->assertStringContainsString('/usr/local/bin', $jsonSlashes);

        // Test with JSON_HEX_QUOT flag - кавычки будут закодированы как \u0022
        $quotesData = new NewTypeArray(['quoted' => 'Text with "quotes"']);
        $jsonHexQuot = json_encode($quotesData, JSON_HEX_QUOT);
        $this->assertStringContainsString('\u0022', $jsonHexQuot);

        // Test compatibility with JsonSerializable interface
        $this->assertInstanceOf(JsonSerializable::class, $this->data);
        $this->assertIsArray($this->data->jsonSerialize());

        // Test that json_encode with CoverArray produces valid JSON
        $complexData = new NewTypeArray([
            'user' => [
                'name' => 'John "Doe"',
                'age' => 30,
                'tags' => ['php', 'json', 'testing']
            ]
        ]);

        $complexJson = json_encode($complexData);
        $this->assertNotFalse($complexJson, 'json_encode should not return false');
        $this->assertJson($complexJson);

        $decodedComplex = json_decode($complexJson, true);
        $this->assertEquals('John "Doe"', $decodedComplex['user']['name']);
        $this->assertEquals(30, $decodedComplex['user']['age']);
        $this->assertEquals(['php', 'json', 'testing'], $decodedComplex['user']['tags']);
    }

    /**
     * Tests the get() method with dot notation.
     *
     * This test verifies that the get() method correctly retrieves
     * nested values using dot notation, handles non-existent paths
     * gracefully, and validates input parameters appropriately.
     *
     *
     * Тестирование метода get() с точечной нотацией.
     *
     * Этот тест проверяет, что метод get() корректно извлекает
     * вложенные значения с использованием точечной нотации,
     * корректно обрабатывает несуществующие пути и проверяет
     * входные параметры соответствующим образом.
     *
     * @see CoverArray::get()
     */
    public function testGetMethod(): void
    {
        $this->assertSame('PHP', $this->data->get('languages.backend.0'));
        $this->assertSame('PHP', $this->data->get('languages.backend')->get('0'));

        $this->assertNull($this->data->get('languages.backend.0.0'));
        $this->assertNull($this->data->get('nonexistent.nonexistent.nonexistent'));
        $this->assertNull($this->data->get('1000.nonexistent.nonexistent.nonexistent'));

        $this->expectException(InvalidArgumentException::class);
        $this->assertNull($this->data->get(''));
    }

    /**
     * Tests the fromExplode() static method.
     *
     * This test verifies that fromExplode() correctly creates a CoverArray
     * instance by splitting a string using a delimiter, mirroring the
     * behavior of PHP's explode() function with proper error handling.
     *
     *
     * Тестирование статического метода fromExplode().
     *
     * Этот тест проверяет, что fromExplode() корректно создает экземпляр CoverArray
     * путем разделения строки с использованием разделителя, отражая поведение
     * функции explode() PHP с правильной обработкой ошибок.
     *
     * @see CoverArray::fromExplode()
     * @see explode()
     */
    public function testFromExplodeMethod(): void
    {
        $o = NewTypeArray::fromExplode(',', '1,2,3');
        $this->assertInstanceOf(NewTypeArray::class, $o);
        $this->assertSame(['1', '2', '3'], $o->getDataAsArray());

        $o = NewTypeArray::fromExplode(',', '1,2,3', 2);
        $this->assertSame(['1', '2,3'], $o->getDataAsArray());

        $this->expectException(ValueError::class);
        NewTypeArray::fromExplode('', '1,2,3');
    }

    /**
     * Tests the fromArray() static factory method.
     *
     * This test verifies that the fromArray() method correctly creates
     * a new CoverArray instance from a plain PHP array, automatically
     * converting nested arrays to CoverArray instances through the
     * array2cover mechanism.
     *
     *
     * Тестирование статического фабричного метода fromArray().
     *
     * Этот тест проверяет, что метод fromArray() корректно создает
     * новый экземпляр CoverArray из обычного PHP массива, автоматически
     * преобразуя вложенные массивы в экземпляры CoverArray через
     * механизм array2cover.
     *
     * @see CoverArray::fromArray()
     * @see CoverArray::array2cover()
     */
    public function testFromArrayMethod(): void
    {
        // Test with simple flat array
        $simpleArray = ['a' => 1, 'b' => 2, 'c' => 3];
        $cover = NewTypeArray::fromArray($simpleArray);

        $this->assertInstanceOf(NewTypeArray::class, $cover);
        $this->assertEquals($simpleArray, $cover->getDataAsArray());
        $this->assertEquals(1, $cover['a']);
        $this->assertEquals(2, $cover['b']);
        $this->assertEquals(3, $cover['c']);

        // Test with nested arrays (should be converted to CoverArray)
        $nestedArray = [
            'level1' => [
                'level2' => [
                    'value' => 'deep'
                ],
                'list' => [1, 2, 3]
            ],
            'simple' => 'value'
        ];

        $coverNested = NewTypeArray::fromArray($nestedArray);

        $this->assertInstanceOf(NewTypeArray::class, $coverNested);
        $this->assertInstanceOf(NewTypeArray::class, $coverNested['level1']);
        $this->assertInstanceOf(NewTypeArray::class, $coverNested['level1']['level2']);
        $this->assertInstanceOf(NewTypeArray::class, $coverNested['level1']['list']);
        $this->assertEquals('deep', $coverNested['level1']['level2']['value']);
        $this->assertEquals([1, 2, 3], $coverNested['level1']['list']->getDataAsArray());
        $this->assertEquals('value', $coverNested['simple']);

        // Test with empty array
        $emptyCover = NewTypeArray::fromArray([]);
        $this->assertInstanceOf(NewTypeArray::class, $emptyCover);
        $this->assertTrue($emptyCover->isEmpty());
        $this->assertEquals(0, $emptyCover->count());

        // Test with list (sequential numeric keys)
        $listArray = ['first', 'second', 'third'];
        $coverList = NewTypeArray::fromArray($listArray);

        $this->assertInstanceOf(NewTypeArray::class, $coverList);
        $this->assertTrue($coverList->isList());
        $this->assertEquals('first', $coverList[0]);
        $this->assertEquals('second', $coverList[1]);
        $this->assertEquals('third', $coverList[2]);

        // Test that fromArray() creates independent instance
        $originalArray = ['key' => 'original'];
        $cover1 = NewTypeArray::fromArray($originalArray);
        $cover2 = NewTypeArray::fromArray($originalArray);

        $this->assertNotSame($cover1, $cover2, 'fromArray() should create new instances');
        $this->assertEquals($cover1->getDataAsArray(), $cover2->getDataAsArray());

        // Modify cover1 and ensure cover2 is not affected
        $cover1['key'] = 'modified';
        $this->assertEquals('modified', $cover1['key']);
        $this->assertEquals('original', $cover2['key'], 'Instances should be independent');

        // Test mixed data types
        $mixedArray = [
            'string' => 'text',
            'integer' => 42,
            'float' => 3.14,
            'boolean' => true,
            'null' => null,
            'array' => ['nested'],
            'object' => new stdClass()
        ];

        $coverMixed = NewTypeArray::fromArray($mixedArray);
        $this->assertEquals('text', $coverMixed['string']);
        $this->assertEquals(42, $coverMixed['integer']);
        $this->assertEquals(3.14, $coverMixed['float']);
        $this->assertTrue($coverMixed['boolean']);
        $this->assertNull($coverMixed['null']);
        $this->assertInstanceOf(NewTypeArray::class, $coverMixed['array']);
        $this->assertEquals(['nested'], $coverMixed['array']->getDataAsArray());
        $this->assertInstanceOf(stdClass::class, $coverMixed['object']);

        // Test equivalence with constructor
        $testArray = ['test' => 'value'];
        $fromConstructor = new NewTypeArray($testArray);
        $fromMethod = NewTypeArray::fromArray($testArray);

        $this->assertEquals($fromConstructor->getDataAsArray(), $fromMethod->getDataAsArray());
        $this->assertEquals($fromConstructor['test'], $fromMethod['test']);
    }



    /**
     * Tests the implode() method.
     *
     * This test verifies that implode() correctly joins array elements
     * into a string using the specified separator, mirroring the behavior
     * of PHP's implode() function for CoverArray instances.
     *
     *
     * Тестирование метода implode().
     *
     * Этот тест проверяет, что implode() корректно объединяет элементы массива
     * в строку с использованием указанного разделителя, отражая поведение
     * функции implode() PHP для экземпляров CoverArray.
     *
     * @see CoverArray::implode()
     * @see implode()
     */
    public function testImplodeMethod(): void
    {
        $this->assertSame(
            'PHP, MySql',
            $this->data->get('languages.backend')->implode(', ')
        );
    }

    /**
     * Tests that nested structures maintain proper class types.
     *
     * This test verifies that when creating CoverArray instances with
     * nested arrays, all levels correctly maintain their class type,
     * ensuring consistent behavior throughout the object hierarchy.
     *
     *
     * Тестирование поддержания правильных типов классов во вложенных структурах.
     *
     * Этот тест проверяет, что при создании экземпляров CoverArray с
     * вложенными массивами, все уровни корректно сохраняют свой тип класса,
     * гарантируя согласованное поведение во всей иерархии объектов.
     *
     * @see CoverArray::array2cover()
     */
    public function testInstanceOfSelf(): void
    {
        $this->assertInstanceOf(NewTypeArray::class, $this->data);
        $this->assertInstanceOf(NewTypeArray::class, $this->data->get('languages'));
        $this->assertInstanceOf(NewTypeArray::class, $this->data->get('languages.backend'));
        $this->assertInstanceOf(NewTypeArray::class, $this->data->get('languages.frontend'));

        $this->assertInstanceOf(CoverArray::class, $this->data);
        $this->assertInstanceOf(CoverArray::class, $this->data->get('languages'));
        $this->assertInstanceOf(CoverArray::class, $this->data->get('languages.backend'));
        $this->assertInstanceOf(CoverArray::class, $this->data->get('languages.frontend'));
    }
}