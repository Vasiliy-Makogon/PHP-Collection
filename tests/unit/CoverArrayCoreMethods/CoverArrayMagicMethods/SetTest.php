<?php

declare(strict_types=1);

namespace CoverArrayCoreMethods\CoverArrayMagicMethods;

use DateTime;
use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(CoverArray::class)]
class SetTest extends TestCase
{
    /**
     * Tests the __set() magic method for scalar values.
     *
     * This test verifies that the __set() method correctly stores scalar values
     * (strings, integers, floats, booleans, null) without modification.
     * Scalar values should be preserved exactly as they are passed.
     *
     *
     * Тестирует магический метод __set() для скалярных значений.
     *
     * Этот тест проверяет, что метод __set() корректно сохраняет скалярные значения
     * (строки, целые числа, числа с плавающей точкой, булевы значения, null) без изменений.
     * Скалярные значения должны сохраняться точно такими, как они переданы.
     *
     * @see CoverArray::__set()
     * @testdox Stores scalar values without modification
     */
    public function testSetScalarValues(): void
    {
        $data = new NewTypeArray();

        // String values
        $data->string = 'Hello World';
        $this->assertSame('Hello World', $data->string);
        $this->assertIsString($data->string);

        // Integer values
        $data->integer = 42;
        $this->assertSame(42, $data->integer);
        $this->assertIsInt($data->integer);

        // Float values
        $data->float = 3.14159;
        $this->assertSame(3.14159, $data->float);
        $this->assertIsFloat($data->float);

        // Boolean values
        $data->boolean_true = true;
        $data->boolean_false = false;
        $this->assertTrue($data->boolean_true);
        $this->assertFalse($data->boolean_false);
        $this->assertIsBool($data->boolean_true);
        $this->assertIsBool($data->boolean_false);

        // Null value
        $data->null_value = null;
        $this->assertNull($data->null_value);

        // Zero and empty values
        $data->zero_int = 0;
        $data->zero_float = 0.0;
        $data->empty_string = '';
        $this->assertSame(0, $data->zero_int);
        $this->assertSame(0.0, $data->zero_float);
        $this->assertSame('', $data->empty_string);

        // Large numbers
        $data->large_int = PHP_INT_MAX;
        $data->large_float = 1.8e308;
        $this->assertSame(PHP_INT_MAX, $data->large_int);
        $this->assertSame(1.8e308, $data->large_float);
    }

    /**
     * Tests the __set() magic method for automatic array conversion.
     *
     * This test verifies that when an array is assigned to a property via __set(),
     * it is automatically converted to a CoverArray instance. This conversion
     * should happen recursively for nested arrays, while preserving existing
     * CoverArray instances without re-conversion.
     *
     *
     * Тестирует магический метод __set() для автоматического преобразования массивов.
     *
     * Этот тест проверяет, что когда массив присваивается свойству через __set(),
     * он автоматически преобразуется в экземпляр CoverArray. Это преобразование
     * должно происходить рекурсивно для вложенных массивов, сохраняя при этом
     * существующие экземпляры CoverArray без повторного преобразования.
     *
     * @see CoverArray::__set()
     * @testdox Automatically converts arrays to CoverArray instances
     */
    public function testSetArrayConversion(): void
    {
        $data = new NewTypeArray();

        // Simple array conversion
        $data->simple_array = ['a', 'b', 'c'];
        $this->assertInstanceOf(NewTypeArray::class, $data->simple_array);
        $this->assertSame(['a', 'b', 'c'], $data->simple_array->getDataAsArray());
        $this->assertSame('a', $data->simple_array[0]);
        $this->assertSame('b', $data->simple_array[1]);
        $this->assertSame('c', $data->simple_array[2]);

        // Associative array conversion
        $data->assoc_array = ['name' => 'John', 'age' => 30];
        $this->assertInstanceOf(NewTypeArray::class, $data->assoc_array);
        $this->assertSame('John', $data->assoc_array->name);
        $this->assertSame(30, $data->assoc_array->age);

        // Empty array becomes empty CoverArray
        $data->empty_array = [];
        $this->assertInstanceOf(NewTypeArray::class, $data->empty_array);
        $this->assertCount(0, $data->empty_array);

        // Mixed array (numeric and string keys)
        $data->mixed_array = [0 => 'a', 'key' => 'value', 1 => 'b'];
        $this->assertInstanceOf(NewTypeArray::class, $data->mixed_array);
        $this->assertSame('a', $data->mixed_array[0]);
        $this->assertSame('value', $data->mixed_array->key);
        $this->assertSame('b', $data->mixed_array[1]);

        // Array with explicit numeric keys
        $data->explicit_keys = [5 => 'five', 10 => 'ten'];
        $this->assertInstanceOf(NewTypeArray::class, $data->explicit_keys);
        $this->assertSame('five', $data->explicit_keys[5]);
        $this->assertSame('ten', $data->explicit_keys[10]);
        $this->assertArrayNotHasKey(0, $data->explicit_keys->getDataAsArray());
    }

    /**
     * Tests recursive conversion of multidimensional arrays in __set().
     *
     * This test verifies that when a multidimensional array is assigned via __set(),
     * all nested arrays are recursively converted to CoverArray instances,
     * creating a fully wrapped object structure while preserving scalar values.
     *
     *
     * Тестирует рекурсивное преобразование многомерных массивов в __set().
     *
     * Этот тест проверяет, что когда многомерный массив присваивается через __set(),
     * все вложенные массивы рекурсивно преобразуются в экземпляры CoverArray,
     * создавая полностью обёрнутую объектную структуру с сохранением скалярных значений.
     *
     * @see CoverArray::__set()
     * @testdox Recursively converts multidimensional arrays
     */
    public function testSetMultidimensionalArrayConversion(): void
    {
        $data = new NewTypeArray();

        // Two-level nested array
        $data->two_level = [
            'level1' => [
                'level2' => 'deep value',
                'scalar' => 123,
                'list' => ['a', 'b', 'c']
            ]
        ];

        $this->assertInstanceOf(NewTypeArray::class, $data->two_level);
        $this->assertInstanceOf(NewTypeArray::class, $data->two_level->level1);
        $this->assertSame('deep value', $data->two_level->level1->level2);
        $this->assertSame(123, $data->two_level->level1->scalar);
        $this->assertInstanceOf(NewTypeArray::class, $data->two_level->level1->list);
        $this->assertSame('a', $data->two_level->level1->list[0]);

        // Three-level nested array
        $data->three_level = [
            'a' => [
                'b' => [
                    'c' => [
                        'd' => 'very deep',
                        'e' => [1, 2, 3]
                    ]
                ]
            ]
        ];

        $this->assertInstanceOf(NewTypeArray::class, $data->three_level->a->b->c);
        $this->assertSame('very deep', $data->three_level->a->b->c->d);
        $this->assertInstanceOf(NewTypeArray::class, $data->three_level->a->b->c->e);
        $this->assertSame(2, $data->three_level->a->b->c->e[1]);

        // Complex mixed structure
        $complex = [
            'users' => [
                ['id' => 1, 'name' => 'Alice', 'active' => true],
                ['id' => 2, 'name' => 'Bob', 'active' => false],
            ],
            'settings' => [
                'theme' => 'dark',
                'notifications' => ['email' => true, 'push' => false]
            ]
        ];

        $data->complex = $complex;

        $this->assertInstanceOf(NewTypeArray::class, $data->complex->users);
        $this->assertInstanceOf(NewTypeArray::class, $data->complex->users[0]);
        $this->assertSame('Alice', $data->complex->users[0]->name);
        $this->assertTrue($data->complex->users[0]->active);

        $this->assertInstanceOf(NewTypeArray::class, $data->complex->settings);
        $this->assertInstanceOf(NewTypeArray::class, $data->complex->settings->notifications);
        $this->assertFalse($data->complex->settings->notifications->push);
    }

    /**
     * Tests that __set() preserves existing CoverArray instances.
     *
     * This test verifies that when an existing CoverArray (or subclass) instance
     * is assigned via __set(), it is not recursively converted again.
     * The same object reference should be stored, maintaining object identity
     * and preventing unnecessary duplication.
     *
     *
     * Тестирует, что __set() сохраняет существующие экземпляры CoverArray.
     *
     * Этот тест проверяет, что когда существующий экземпляр CoverArray (или его подкласса)
     * присваивается через __set(), он не преобразуется повторно.
     * Должна сохраняться та же ссылка на объект, поддерживая идентичность объекта
     * и предотвращая ненужное дублирование.
     *
     * @see CoverArray::__set()
     * @testdox Preserves existing CoverArray instances without re-conversion
     */
    public function testSetPreservesExistingCoverArrays(): void
    {
        $data = new NewTypeArray();

        // Existing CoverArray instance
        $existingCover = new NewTypeArray(['inner' => 'value']);
        $originalHash = spl_object_hash($existingCover);

        $data->existing_cover = $existingCover;

        $retrieved = $data->existing_cover;
        $retrievedHash = spl_object_hash($retrieved);

        $this->assertSame($existingCover, $retrieved);
        $this->assertSame($originalHash, $retrievedHash);
        $this->assertSame('value', $retrieved->inner);

        // Existing CoverArray within an array
        $nestedCover = new NewTypeArray(['nested' => 'data']);
        $arrayWithCover = [
            'regular_array' => ['a', 'b'],
            'cover_instance' => $nestedCover,
            'mixed' => [
                'another_cover' => new NewTypeArray(['x' => 'y'])
            ]
        ];

        $data->array_with_covers = $arrayWithCover;

        // Regular array should be converted
        $this->assertInstanceOf(NewTypeArray::class, $data->array_with_covers->regular_array);

        // Existing CoverArray should be preserved
        $this->assertSame($nestedCover, $data->array_with_covers->cover_instance);

        // Nested CoverArray in mixed array should also be preserved
        $this->assertInstanceOf(NewTypeArray::class, $data->array_with_covers->mixed->another_cover);
        $this->assertSame('y', $data->array_with_covers->mixed->another_cover->x);

        // Test with CoverArray class directly (not NewTypeArray)
        $directCover = new CoverArray(['direct' => 'test']);
        $data->direct_cover = $directCover;
        $this->assertSame($directCover, $data->direct_cover);
    }

    /**
     * Tests the __set() method with object values.
     *
     * This test verifies that non-CoverArray objects are stored as-is without
     * modification. Objects should maintain their identity and not be cloned
     * or converted unless they are arrays (which get converted to CoverArray).
     *
     *
     * Тестирует метод __set() с объектными значениями.
     *
     * Этот тест проверяет, что объекты, не являющиеся CoverArray, сохраняются
     * как есть без изменений. Объекты должны сохранять свою идентичность и не
     * клонироваться или преобразовываться, если они не являются массивами
     * (которые преобразуются в CoverArray).
     *
     * @see CoverArray::__set()
     * @testdox Stores object values as-is (without conversion)
     */
    public function testSetObjectValues(): void
    {
        $data = new NewTypeArray();

        // Standard PHP objects
        $stdObject = new stdClass();
        $stdObject->property = 'value';
        $data->std_object = $stdObject;

        $this->assertSame($stdObject, $data->std_object);
        $this->assertInstanceOf(stdClass::class, $data->std_object);
        $this->assertSame('value', $data->std_object->property);

        // DateTime objects
        $dateTime = new DateTime('2023-01-01');
        $data->datetime = $dateTime;

        $this->assertSame($dateTime, $data->datetime);
        $this->assertInstanceOf(DateTime::class, $data->datetime);
        $this->assertSame('2023-01-01', $data->datetime->format('Y-m-d'));

        // Custom objects
        $customObject = new class {
            public string $name = 'Custom';
            public function greet(): string {
                return 'Hello from custom object';
            }
        };

        $data->custom_object = $customObject;
        $this->assertSame($customObject, $data->custom_object);
        $this->assertSame('Hello from custom object', $data->custom_object->greet());

        // Object with array property (array should remain as array)
        $objectWithArray = new stdClass();
        $objectWithArray->data = ['nested' => 'value'];

        $data->object_with_array = $objectWithArray;
        $this->assertSame($objectWithArray, $data->object_with_array);

        // The array property remains a plain array (not converted to NewTypeArray)
        $this->assertIsArray($data->object_with_array->data);
        $this->assertSame('value', $data->object_with_array->data['nested']);
    }

    /**
     * Tests the __set() method with resource and callable values.
     *
     * This test verifies that resources and callable functions are stored
     * as-is without modification. These special PHP types should be preserved
     * exactly as they are passed to __set().
     *
     *
     * Тестирует метод __set() со значениями-ресурсами и callable-функциями.
     *
     * Этот тест проверяет, что ресурсы и callable-функции сохраняются как есть
     * без изменений. Эти специальные типы PHP должны сохраняться точно такими,
     * как они переданы в __set().
     *
     * @see CoverArray::__set()
     * @testdox Stores resources and callables as-is
     */
    public function testSetResourceAndCallableValues(): void
    {
        $data = new NewTypeArray();

        // Resource values
        $resource = fopen('php://memory', 'r+');
        fwrite($resource, 'test data');
        rewind($resource);

        $data->resource = $resource;
        $this->assertSame($resource, $data->resource);
        $this->assertIsResource($data->resource);
        $this->assertSame('test data', fread($data->resource, 9));

        fclose($resource);

        // Callable functions (closures)
        $closure = fn(int $a, int $b): int => $a + $b;
        $data->closure = $closure;

        $this->assertSame($closure, $data->closure);
        $this->assertIsCallable($data->closure);
        $this->assertSame(5, ($data->closure)(2, 3));

        // Named function as string
        $data->function_name = 'strlen';
        $this->assertSame('strlen', $data->function_name);
        $this->assertIsCallable($data->function_name);

        // Array callable
        $data->array_callable = [new DateTime(), 'format'];
        $this->assertIsCallable($data->array_callable);

        $date = new DateTime('2023-01-01');
        $data->date_object = $date;
        $data->date_method = [$data->date_object, 'format'];
        $this->assertSame('2023-01-01', call_user_func($data->date_method, 'Y-m-d'));
    }

    /**
     * Tests the __set() method for overwriting existing values.
     *
     * This test verifies that __set() correctly overwrites existing properties
     * with new values. The new value should completely replace the old value,
     * and if the new value is an array, it should be converted to CoverArray.
     *
     *
     * Тестирует метод __set() для перезаписи существующих значений.
     *
     * Этот тест проверяет, что __set() корректно перезаписывает существующие свойства
     * новыми значениями. Новое значение должно полностью заменять старое значение,
     * и если новое значение является массивом, оно должно быть преобразовано в CoverArray.
     *
     * @see CoverArray::__set()
     * @testdox Correctly overwrites existing properties
     */
    public function testSetOverwritesExistingValues(): void
    {
        $data = new NewTypeArray(['initial' => 'value']);

        // Overwrite scalar with scalar
        $this->assertSame('value', $data->initial);
        $data->initial = 'new value';
        $this->assertSame('new value', $data->initial);

        // Overwrite scalar with array
        $data->scalar_to_array = 'string';
        $this->assertSame('string', $data->scalar_to_array);

        $data->scalar_to_array = ['a', 'b', 'c'];
        $this->assertInstanceOf(NewTypeArray::class, $data->scalar_to_array);
        $this->assertSame(['a', 'b', 'c'], $data->scalar_to_array->getDataAsArray());

        // Overwrite array with scalar
        $data->array_to_scalar = ['x', 'y'];
        $this->assertInstanceOf(NewTypeArray::class, $data->array_to_scalar);

        $data->array_to_scalar = 123;
        $this->assertSame(123, $data->array_to_scalar);
        $this->assertIsInt($data->array_to_scalar);

        // Overwrite array with different array
        $data->array_replacement = ['old' => 'data'];
        $this->assertSame('data', $data->array_replacement->old);

        $data->array_replacement = ['new' => 'data', 'extra' => 'info'];
        $this->assertInstanceOf(NewTypeArray::class, $data->array_replacement);
        $this->assertSame('data', $data->array_replacement->new);
        $this->assertSame('info', $data->array_replacement->extra);
        $this->assertNull($data->array_replacement->old);

        // Overwrite with null
        $data->to_null = 'some value';
        $this->assertSame('some value', $data->to_null);

        $data->to_null = null;
        $this->assertNull($data->to_null);

        // Multiple overwrites
        $data->multi = 1;
        $this->assertSame(1, $data->multi);

        $data->multi = 'two';
        $this->assertSame('two', $data->multi);

        $data->multi = [3];
        $this->assertInstanceOf(NewTypeArray::class, $data->multi);
        $this->assertSame([3], $data->multi->getDataAsArray());

        $data->multi = false;
        $this->assertFalse($data->multi);
    }

    /**
     * Tests the __set() method with UTF-8 and special character property names.
     *
     * This test verifies that __set() correctly handles property names containing
     * UTF-8 characters, emojis, and other special characters that are valid
     * in PHP property names. These properties should be settable and retrievable.
     *
     *
     * Тестирует метод __set() с UTF-8 и специальными символами в именах свойств.
     *
     * Этот тест проверяет, что __set() корректно обрабатывает имена свойств,
     * содержащие символы UTF-8, эмодзи и другие специальные символы, которые
     * допустимы в именах свойств PHP. Эти свойства должны быть устанавливаемыми
     * и извлекаемыми.
     *
     * @see CoverArray::__set()
     * @testdox Handles UTF-8 and special character property names
     */
    public function testSetWithUtf8AndSpecialCharacters(): void
    {
        $data = new NewTypeArray();

        // UTF-8 property names
        $data->café = 'French coffee';
        $data->straße = 'German street';
        $data->привет = 'Russian hello';

        $this->assertSame('French coffee', $data->café);
        $this->assertSame('German street', $data->straße);
        $this->assertSame('Russian hello', $data->привет);

        // Emoji property names (PHP 8+)
        $data->{'🎉'} = 'Party time';
        $data->{'👍'} = 'Thumbs up';

        $this->assertSame('Party time', $data->{'🎉'});
        $this->assertSame('Thumbs up', $data->{'👍'});

        // Special characters in property names
        $data->{'key-with-dash'} = 'dash value';
        $data->{'key.with.dot'} = 'dot value';
        $data->{'key with spaces'} = 'space value';
        $data->{'key_underscore'} = 'underscore value';
        $data->{'key$special'} = 'dollar value';

        $this->assertSame('dash value', $data->{'key-with-dash'});
        $this->assertSame('dot value', $data->{'key.with.dot'});
        $this->assertSame('space value', $data->{'key with spaces'});
        $this->assertSame('underscore value', $data->key_underscore);
        $this->assertSame('dollar value', $data->{'key$special'});

        // Numeric-looking string properties
        $data->{'123'} = 'numeric string key';
        $data->{'0'} = 'zero key';

        $this->assertSame('numeric string key', $data->{'123'});
        $this->assertSame('zero key', $data->{'0'});

        // Property name with array value
        $data->{'🎂'} = ['layers' => 3, 'flavor' => 'chocolate'];
        $this->assertInstanceOf(NewTypeArray::class, $data->{'🎂'});
        $this->assertSame('chocolate', $data->{'🎂'}->flavor);
    }

    /**
     * Tests the interaction between __set() and ArrayAccess interface.
     *
     * This test verifies that properties set via __set() are accessible via
     * array syntax (offsetGet), and vice versa. Both access methods should
     * be consistent and work interchangeably.
     *
     *
     * Тестирует взаимодействие между __set() и интерфейсом ArrayAccess.
     *
     * Этот тест проверяет, что свойства, установленные через __set(), доступны
     * через синтаксис массивов (offsetGet), и наоборот. Оба метода доступа должны
     * быть согласованными и работать взаимозаменяемо.
     *
     * @see CoverArray::__set()
     * @see CoverArray::offsetSet()
     * @testdox Consistent with ArrayAccess interface
     */
    public function testSetConsistencyWithArrayAccess(): void
    {
        $data = new NewTypeArray();

        // Set via property, get via array
        $data->property = 'value';
        $this->assertSame('value', $data['property']);

        $data->nested = ['level' => 'deep'];
        $this->assertInstanceOf(NewTypeArray::class, $data['nested']);
        $this->assertSame('deep', $data['nested']['level']);

        // Set via array, get via property
        $data['array_key'] = 'array value';
        $this->assertSame('array value', $data->array_key);

        $data['array_nested'] = ['inner' => 'data'];
        $this->assertInstanceOf(NewTypeArray::class, $data->array_nested);
        $this->assertSame('data', $data->array_nested->inner);

        // Overwriting consistency
        $data->consistent = 'property set';
        $data['consistent'] = 'array set';
        $this->assertSame('array set', $data->consistent);
        $this->assertSame('array set', $data['consistent']);

        // Complex nested structure
        $data->complex = [
            'users' => [
                ['name' => 'Alice'],
                ['name' => 'Bob']
            ]
        ];

        // Access via property syntax
        $this->assertSame('Alice', $data->complex->users[0]->name);

        // Access via array syntax
        $this->assertSame('Alice', $data['complex']['users'][0]['name']);

        // Mixed access
        $this->assertSame('Bob', $data->complex['users'][1]->name);
        $this->assertSame('Bob', $data['complex']->users[1]['name']);
    }

    /**
     * Tests that __set() works correctly with inherited classes.
     *
     * This test verifies that __set() functions properly in classes that
     * extend CoverArray. The automatic array conversion should still work,
     * and the behavior should be consistent with the parent class.
     *
     *
     * Тестирует, что __set() корректно работает с унаследованными классами.
     *
     * Этот тест проверяет, что __set() правильно функционирует в классах,
     * которые расширяют CoverArray. Автоматическое преобразование массивов
     * должно продолжать работать, и поведение должно быть согласованным
     * с родительским классом.
     *
     * @see CoverArray::__set()
     * @testdox Works correctly with inherited classes
     */
    public function testSetWithInheritance(): void
    {
        // Custom class extending NewTypeArray
        $customData = new class extends NewTypeArray {
            public string $customProperty = 'default';

            public function setCustomValue($value): void
            {
                $this->customProperty = $value;
            }
        };

        // Should work like normal NewTypeArray
        $customData->dynamic = 'value';
        $this->assertSame('value', $customData->dynamic);

        $customData->array = ['nested' => 'data'];
        $this->assertInstanceOf(NewTypeArray::class, $customData->array);
        $this->assertSame('data', $customData->array->nested);

        // Custom property should not interfere
        $customData->customProperty = 'modified';
        $this->assertSame('modified', $customData->customProperty);

        // Method should still work
        $customData->setCustomValue('method set');
        $this->assertSame('method set', $customData->customProperty);

        // Test with multiple inheritance levels
        $deepInheritance = new class extends NewTypeArray {
            // Empty class for testing
        };

        $deepInheritance->test = ['array' => 'conversion'];
        $this->assertInstanceOf(NewTypeArray::class, $deepInheritance->test);
        $this->assertSame('conversion', $deepInheritance->test->array);
    }

    /**
     * Tests the __set() method for chaining support.
     *
     * This test verifies that __set() returns void (no chaining support),
     * which is the standard behavior for PHP magic setter methods.
     * Attempting to chain __set() should result in an error.
     *
     *
     * Тестирует метод __set() на поддержку цепочек вызовов.
     *
     * Этот тест проверяет, что __set() возвращает void (без поддержки цепочек),
     * что является стандартным поведением для магических методов-сеттеров в PHP.
     * Попытка создать цепочку из __set() должна приводить к ошибке.
     *
     * @see CoverArray::__set()
     * @testdox Does not support method chaining (returns void)
     */
    public function testSetNoChainingSupport(): void
    {
        $data = new NewTypeArray();

        // __set() should return void, not $this
        // This is a negative test - we verify that chaining doesn't work

        // Direct call to __set() returns void
        $result = $data->__set('test', 'value');
        $this->assertNull($result);

        // Property access doesn't return anything chainable
        // The following would cause an error if we tried to chain it:
        // $data->chain = 'value'->something(); // This would fail

        // But we can verify the value was set
        $this->assertSame('value', $data->test);
    }

    /**
     * Tests the __set() method with large datasets.
     *
     * This test verifies that __set() works correctly even when dealing with
     * large amounts of data, ensuring performance and memory efficiency
     * for real-world applications.
     *
     *
     * Тестирует метод __set() с большими наборами данных.
     *
     * Этот тест проверяет, что __set() работает корректно даже при работе с
     * большими объёмами данных, обеспечивая производительность и эффективность
     * использования памяти для реальных приложений.
     *
     * @see CoverArray::__set()
     * @testdox Handles large datasets efficiently
     */
    public function testSetWithLargeDataset(): void
    {
        $data = new NewTypeArray();

        // Set many properties
        for ($i = 0; $i < 1000; $i++) {
            $data->{"key_$i"} = "value_$i";
        }

        // Verify random properties
        $this->assertSame('value_42', $data->key_42);
        $this->assertSame('value_999', $data->key_999);
        $this->assertSame('value_0', $data->key_0);

        // Set large array
        $largeArray = [];
        for ($i = 0; $i < 1000; $i++) {
            $largeArray["item_$i"] = [
                'id' => $i,
                'data' => str_repeat('x', 100),
                'nested' => ['level' => $i % 100]
            ];
        }

        $data->large_structure = $largeArray;

        // Verify the structure was converted correctly
        $this->assertInstanceOf(NewTypeArray::class, $data->large_structure);
        $this->assertInstanceOf(NewTypeArray::class, $data->large_structure->item_500);
        $this->assertSame(500, $data->large_structure->item_500->id);
        $this->assertInstanceOf(NewTypeArray::class, $data->large_structure->item_500->nested);
        $this->assertSame(0, $data->large_structure->item_100->nested->level);

        // Memory test - ensure we can still create new objects
        $another = new NewTypeArray();
        $another->test = 'ok';
        $this->assertSame('ok', $another->test);
    }

    /**
     * Tests that __set() maintains referential integrity.
     *
     * This test verifies that when the same value (especially objects) is set
     * to multiple properties, references are maintained rather than creating
     * copies. This is important for memory efficiency and object state consistency.
     *
     *
     * Тестирует, что __set() сохраняет ссылочную целостность.
     *
     * Этот тест проверяет, что когда одно и то же значение (особенно объекты)
     * устанавливается в несколько свойств, сохраняются ссылки, а не создаются
     * копии. Это важно для эффективности использования памяти и согласованности
     * состояния объектов.
     *
     * @see CoverArray::__set()
     * @testdox Maintains referential integrity for objects
     */
    public function testSetMaintainsReferences(): void
    {
        $data = new NewTypeArray();

        // Same object reference to multiple properties
        $sharedObject = new stdClass();
        $sharedObject->id = 'shared';

        $data->prop1 = $sharedObject;
        $data->prop2 = $sharedObject;
        $data->nested = ['object' => $sharedObject];

        // All should reference the same object
        $this->assertSame($sharedObject, $data->prop1);
        $this->assertSame($sharedObject, $data->prop2);
        $this->assertSame($sharedObject, $data->nested->object);

        // Modification through one reference affects all
        $data->prop1->modified = true;
        $this->assertTrue($data->prop2->modified);
        $this->assertTrue($data->nested->object->modified);
        $this->assertTrue($sharedObject->modified);

        // Same array reference
        $sharedArray = ['shared' => 'data'];
        $data->arr1 = $sharedArray;
        $data->arr2 = $sharedArray;

        // Arrays are converted to CoverArray, so they become different objects
        // But the original array reference is used to create each CoverArray
        $this->assertNotSame($data->arr1, $data->arr2); // Different CoverArray instances
        $this->assertSame('data', $data->arr1->shared);
        $this->assertSame('data', $data->arr2->shared);

        // Modifying the original array doesn't affect already converted CoverArrays
        $sharedArray['new'] = 'value';
        $this->assertNull($data->arr1->new); // Not affected
        $this->assertNull($data->arr2->new); // Not affected
    }
}