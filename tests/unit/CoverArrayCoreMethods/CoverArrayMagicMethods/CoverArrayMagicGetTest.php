<?php

declare(strict_types=1);

use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class CoverArrayMagicGetTest extends TestCase
{
    /**
     * Tests the __get() magic method for accessing existing properties.
     *
     * This test verifies that the __get() method correctly returns values
     * for existing keys in the CoverArray object. It covers various data types
     * including strings, integers, floats, booleans, null, objects, and arrays
     * (which are converted to CoverArray instances).
     *
     *
     * Тестирует магический метод __get() для доступа к существующим свойствам.
     *
     * Этот тест проверяет, что метод __get() корректно возвращает значения
     * для существующих ключей в объекте CoverArray. Он охватывает различные
     * типы данных, включая строки, целые числа, числа с плавающей точкой,
     * булевы значения, null, объекты и массивы (которые преобразуются в
     * экземпляры CoverArray).
     *
     * @see CoverArray::__get()
     * @testdox Returns correct values for existing properties
     */
    public function testGetExistingProperties(): void
    {
        $data = new NewTypeArray([
            'string' => 'Hello World',
            'integer' => 42,
            'float' => 3.14159,
            'boolean_true' => true,
            'boolean_false' => false,
            'null' => null,
            'object' => new stdClass(),
            'array' => ['a', 'b', 'c'],
            'nested_array' => [
                'level1' => ['level2' => 'deep value']
            ],
            'empty_array' => [],
            'cover_array' => new NewTypeArray(['inner' => 'value']),
        ]);

        // String values
        $this->assertSame('Hello World', $data->string);
        $this->assertIsString($data->string);

        // Integer values
        $this->assertSame(42, $data->integer);
        $this->assertIsInt($data->integer);

        // Float values
        $this->assertSame(3.14159, $data->float);
        $this->assertIsFloat($data->float);

        // Boolean values
        $this->assertTrue($data->boolean_true);
        $this->assertFalse($data->boolean_false);
        $this->assertIsBool($data->boolean_true);
        $this->assertIsBool($data->boolean_false);

        // Null value
        $this->assertNull($data->null);

        // Object value
        $this->assertInstanceOf(stdClass::class, $data->object);

        // Array values (converted to CoverArray)
        $this->assertInstanceOf(NewTypeArray::class, $data->array);
        $this->assertSame(['a', 'b', 'c'], $data->array->getDataAsArray());

        // Nested arrays (recursively converted)
        $this->assertInstanceOf(NewTypeArray::class, $data->nested_array);
        $this->assertInstanceOf(NewTypeArray::class, $data->nested_array->level1);
        $this->assertSame('deep value', $data->nested_array->level1->level2);

        // Empty array (converted to empty CoverArray)
        $this->assertInstanceOf(NewTypeArray::class, $data->empty_array);
        $this->assertCount(0, $data->empty_array);

        // Existing CoverArray instance (preserved)
        $this->assertInstanceOf(NewTypeArray::class, $data->cover_array);
        $this->assertSame('value', $data->cover_array->inner);
    }

    /**
     * Tests the __get() magic method for non-existent properties.
     *
     * This test verifies that the __get() method returns null when accessing
     * non-existent keys, ensuring predictable behavior without throwing exceptions.
     * This is important for handling missing data gracefully in applications.
     *
     *
     * Тестирует магический метод __get() для несуществующих свойств.
     *
     * Этот тест проверяет, что метод __get() возвращает null при доступе
     * к несуществующим ключам, обеспечивая предсказуемое поведение без
     * выбрасывания исключений. Это важно для корректной обработки отсутствующих
     * данных в приложениях.
     *
     * @see CoverArray::__get()
     * @testdox Returns null for non-existent properties
     */
    public function testGetNonExistentProperties(): void
    {
        $data = new NewTypeArray(['existing' => 'value']);

        // Non-existent string keys
        $this->assertNull($data->nonExistent);
        $this->assertNull($data->undefined);
        $this->assertNull($data->missing_key);

        // Numeric keys (when accessed as properties)
        $this->assertNull($data->{'0'});
        $this->assertNull($data->{'123'});

        // Special characters in keys
        $this->assertNull($data->{'key-with-dash'});
        $this->assertNull($data->{'key.with.dot'});
        $this->assertNull($data->{'key with space'});

        // After unsetting an existing property
        $this->assertSame('value', $data->existing);
        unset($data->existing);
        $this->assertNull($data->existing);
    }

    /**
     * Tests the __get() magic method with edge cases and special values.
     *
     * This test covers edge cases including zero values, empty strings,
     * resource types, callable functions, and numeric string keys.
     * It ensures that __get() handles all PHP data types consistently.
     *
     *
     * Тестирует магический метод __get() с граничными случаями и специальными значениями.
     *
     * Этот тест охватывает граничные случаи, включая нулевые значения, пустые строки,
     * типы ресурсов, callable-функции и строковые числовые ключи. Он гарантирует,
     * что __get() обрабатывает все типы данных PHP последовательно.
     *
     * @see CoverArray::__get()
     * @testdox Handles edge cases and special values correctly
     */
    public function testGetEdgeCases(): void
    {
        // Test with zero values
        $data1 = new NewTypeArray([
            'zero_int' => 0,
            'zero_float' => 0.0,
            'empty_string' => '',
            'false_value' => false,
        ]);

        $this->assertSame(0, $data1->zero_int);
        $this->assertSame(0.0, $data1->zero_float);
        $this->assertSame('', $data1->empty_string);
        $this->assertFalse($data1->false_value);

        // Test with resource
        $resource = fopen('php://memory', 'r');
        $data2 = new NewTypeArray(['resource' => $resource]);
        $this->assertSame($resource, $data2->resource);
        $this->assertIsResource($data2->resource);
        fclose($resource);

        // Test with callable
        $callable = fn() => 'test';
        $data3 = new NewTypeArray(['callable' => $callable]);
        $this->assertSame($callable, $data3->callable);
        $this->assertIsCallable($data3->callable);

        // Test with numeric string keys in array
        $data4 = new NewTypeArray([
            'numeric_keys' => ['0' => 'a', '1' => 'b', '2' => 'c']
        ]);
        $this->assertInstanceOf(NewTypeArray::class, $data4->numeric_keys);
        $this->assertSame('a', $data4->numeric_keys->{'0'});
        $this->assertSame('b', $data4->numeric_keys->{'1'});
    }

    /**
     * Tests the __get() magic method with inherited classes.
     *
     * This test verifies that __get() works correctly with classes that
     * extend CoverArray, ensuring that inheritance doesn't break the
     * property access functionality.
     *
     *
     * Тестирует магический метод __get() с унаследованными классами.
     *
     * Этот тест проверяет, что __get() корректно работает с классами,
     * которые расширяют CoverArray, гарантируя, что наследование не
     * нарушает функциональность доступа к свойствам.
     *
     * @see CoverArray::__get()
     * @testdox Works correctly with inherited classes
     */
    public function testGetWithInheritance(): void
    {
        // Custom class extending NewTypeArray
        $customData = new class(['custom' => 'value']) extends NewTypeArray {
            public function getCustom(): string
            {
                return $this->custom . ' processed';
            }
        };

        $this->assertSame('value', $customData->custom);
        $this->assertSame('value processed', $customData->getCustom());

        // Test with CoverArray directly (not NewTypeArray)
        $coverArray = new CoverArray(['direct' => 'test']);
        $this->assertSame('test', $coverArray->direct);
    }

    /**
     * Tests that __get() maintains referential integrity for objects.
     *
     * This test verifies that when an object is stored in a CoverArray
     * and retrieved via __get(), the same object reference is returned,
     * not a copy. This is important for maintaining object state consistency.
     *
     *
     * Тестирует, что __get() сохраняет ссылочную целостность для объектов.
     *
     * Этот тест проверяет, что когда объект хранится в CoverArray и
     * извлекается через __get(), возвращается та же ссылка на объект,
     * а не копия. Это важно для поддержания согласованности состояния объектов.
     *
     * @see CoverArray::__get()
     * @testdox Maintains object references (not copies)
     */
    public function testGetObjectReferences(): void
    {
        $originalObject = new stdClass();
        $originalObject->id = 'test-123';
        $originalObject->data = ['a', 'b', 'c'];

        $data = new NewTypeArray(['object' => $originalObject]);

        // Get the object back
        $retrievedObject = $data->object;

        // Should be the same object (same reference)
        $this->assertSame($originalObject, $retrievedObject);

        // Modifying through retrieved reference should affect original
        $retrievedObject->modified = true;
        $this->assertTrue($originalObject->modified);

        // Test with nested objects in arrays
        $innerObject = new stdClass();
        $innerObject->value = 'inner';

        $data2 = new NewTypeArray([
            'nested' => [
                'object' => $innerObject
            ]
        ]);

        $retrievedInner = $data2->nested->object;
        $this->assertSame($innerObject, $retrievedInner);
        $this->assertSame('inner', $retrievedInner->value);
    }

    /**
     * Tests the __get() method's performance with large datasets.
     *
     * This test verifies that __get() works efficiently even with
     * large numbers of properties, ensuring scalability for real-world
     * applications with complex data structures.
     *
     *
     * Тестирует производительность метода __get() с большими наборами данных.
     *
     * Этот тест проверяет, что __get() работает эффективно даже с
     * большим количеством свойств, обеспечивая масштабируемость для
     * реальных приложений со сложными структурами данных.
     *
     * @see CoverArray::__get()
     * @testdox Handles large datasets efficiently
     */
    public function testGetWithLargeDataset(): void
    {
        // Create a large dataset
        $largeArray = [];
        for ($i = 0; $i < 1000; $i++) {
            $largeArray["key_$i"] = "value_$i";
        }

        $data = new NewTypeArray($largeArray);

        // Test random access
        $this->assertSame('value_42', $data->key_42);
        $this->assertSame('value_999', $data->key_999);
        $this->assertSame('value_0', $data->key_0);

        // Test non-existent in large dataset
        $this->assertNull($data->non_existent_key);

        // Test with nested large structures
        $nestedLarge = new NewTypeArray([
            'level1' => [
                'level2' => $largeArray,
                'scalar' => 'test'
            ]
        ]);

        $this->assertSame('value_123', $nestedLarge->level1->level2->key_123);
        $this->assertSame('test', $nestedLarge->level1->scalar);
    }

    /**
     * Tests the __get() method's compatibility with array syntax.
     *
     * This test verifies that properties accessed via __get() return
     * the same values as when accessed via array syntax (offsetGet),
     * ensuring consistency between different access methods.
     *
     *
     * Тестирует совместимость метода __get() с синтаксисом массивов.
     *
     * Этот тест проверяет, что свойства, доступные через __get(),
     * возвращают те же значения, что и при доступе через синтаксис
     * массивов (offsetGet), обеспечивая согласованность между различными
     * методами доступа.
     *
     * @see CoverArray::__get()
     * @see CoverArray::offsetGet()
     * @testdox Consistent with array access syntax
     */
    public function testGetConsistencyWithArrayAccess(): void
    {
        $data = new NewTypeArray([
            'name' => 'John',
            'age' => 30,
            'skills' => ['PHP', 'JavaScript'],
            'address' => [
                'city' => 'Moscow',
                'street' => 'Tverskaya'
            ]
        ]);

        // Property access vs array access should be consistent
        $this->assertSame($data->name, $data['name']);
        $this->assertSame($data->age, $data['age']);
        $this->assertSame($data->skills, $data['skills']);
        $this->assertSame($data->address, $data['address']);

        // Nested access consistency
        $this->assertSame($data->address->city, $data['address']['city']);
        $this->assertSame($data->skills[0], $data->skills->{0});

        // Non-existent properties
        $this->assertNull($data->nonExistent);
        $this->assertNull($data['nonExistent']);
        $this->assertSame($data->nonExistent, $data['nonExistent']);
    }

    /**
     * Tests the __get() method with UTF-8 and special character keys.
     *
     * This test verifies that __get() correctly handles property names
     * with UTF-8 characters, emojis, and other special characters that
     * are valid in PHP property names but may be edge cases.
     *
     *
     * Тестирует метод __get() с UTF-8 и специальными символьными ключами.
     *
     * Этот тест проверяет, что __get() корректно обрабатывает имена свойств
     * с символами UTF-8, эмодзи и другими специальными символами, которые
     * допустимы в именах свойств PHP, но могут быть граничными случаями.
     *
     * @see CoverArray::__get()
     * @testdox Handles UTF-8 and special character property names
     */
    public function testGetWithUtf8AndSpecialCharacters(): void
    {
        $data = new NewTypeArray([
            'café' => 'French coffee',
            'straße' => 'German street',
            'привет' => 'Russian hello',
            '🎉' => 'Party emoji',
            'key_with_underscore' => 'underscore',
            'key-with-dash' => 'dash',
            'key.with.dot' => 'dot',
            'key with spaces' => 'spaces',
        ]);

        // UTF-8 characters
        $this->assertSame('French coffee', $data->café);
        $this->assertSame('German street', $data->straße);
        $this->assertSame('Russian hello', $data->привет);

        // Emoji (valid in PHP 8+)
        $this->assertSame('Party emoji', $data->{'🎉'});

        // Special characters need curly brace syntax
        $this->assertSame('underscore', $data->key_with_underscore);
        $this->assertSame('dash', $data->{'key-with-dash'});
        $this->assertSame('dot', $data->{'key.with.dot'});
        $this->assertSame('spaces', $data->{'key with spaces'});
    }

    /**
     * Tests that __get() doesn't interfere with normal method calls.
     *
     * This test verifies that __get() is only invoked for property access
     * and doesn't interfere with calling actual methods on the object.
     * This separation is important for maintaining clear API boundaries.
     *
     *
     * Тестирует, что __get() не мешает обычным вызовам методов.
     *
     * Этот тест проверяет, что __get() вызывается только для доступа к свойствам
     * и не мешает вызовам фактических методов объекта. Это разделение важно для
     * поддержания четких границ API.
     *
     * @see CoverArray::__get()
     * @testdox Doesn't interfere with method calls
     */
    public function testGetDoesNotInterfereWithMethods(): void
    {
        $data = new NewTypeArray(['test' => 'value']);

        // Method calls should work normally
        $this->assertIsArray($data->getData());
        $this->assertInstanceOf(NewTypeArray::class, $data->copy());
        $this->assertFalse($data->isEmpty());

        // Properties should still work via __get()
        $this->assertSame('value', $data->test);

        // Mix of method calls and property access
        $clone = $data->copy();
        $this->assertSame('value', $clone->test);

        // __get() shouldn't be called for methods that don't exist
        // In PHP 8+, accessing undefined method causes Error
        $this->expectException(\Error::class);
        $data->nonExistentMethod();
    }

    /**
     * Tests that a property with the same name as a method doesn't break method calls.
     *
     * This test verifies that having a property with the same name as a method
     * doesn't prevent the method from being called. The property access should
     * use __get() and method calls should be handled separately.
     *
     *
     * Тестирует, что свойство с тем же именем, что и у метода, не ломает вызов метода.
     *
     * Этот тест проверяет, что наличие свойства с тем же именем, что и у метода,
     * не мешает вызову метода. Доступ к свойству должен использовать __get(),
     * а вызовы методов должны обрабатываться отдельно.
     *
     * @see CoverArray::__get()
     * @testdox Property with same name as method doesn't break method calls
     */
    public function testPropertyWithMethodNameDoesNotBreakMethodCalls(): void
    {
        $data = new NewTypeArray([
            'getData' => 'I am a property, not a method',
        ]);

        // The property should be accessible via __get()
        $this->assertSame('I am a property, not a method', $data->getData);

        // The method getData() should still work and return an array
        $methodResult = $data->getData();
        $this->assertIsArray($methodResult);
        $this->assertArrayHasKey('getData', $methodResult);
        $this->assertSame('I am a property, not a method', $methodResult['getData']);
    }
}