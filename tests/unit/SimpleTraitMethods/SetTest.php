<?php

declare(strict_types=1);

namespace SimpleTraitMethods;

use Krugozor\Cover\Simple;
use Krugozor\Cover\Tests\SimpleTraitTestClass;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(Simple::class)]
class SetTest extends TestCase
{
    /**
     * Tests that __set() stores scalar values without modification.
     *
     * This test verifies that the Simple trait's __set() method correctly
     * stores scalar values (strings, integers, floats, booleans, null)
     * directly in the internal data array without any conversion.
     *
     *
     * Тестирует, что __set() сохраняет скалярные значения без изменений.
     *
     * Этот тест проверяет, что метод __set() трейта Simple корректно
     * сохраняет скалярные значения (строки, целые числа, числа с плавающей
     * точкой, логические значения, null) непосредственно во внутреннем
     * массиве данных без какого-либо преобразования.
     *
     * @see Simple::__set()
     */
    public function testSetScalarValues(): void
    {
        $obj = new SimpleTraitTestClass();

        $obj->string = 'Hello World';
        $obj->integer = 42;
        $obj->float = 3.14159;
        $obj->boolean_true = true;
        $obj->boolean_false = false;
        $obj->null_value = null;
        $obj->zero = 0;
        $obj->empty_string = '';

        $this->assertSame('Hello World', $obj->string);
        $this->assertSame(42, $obj->integer);
        $this->assertSame(3.14159, $obj->float);
        $this->assertTrue($obj->boolean_true);
        $this->assertFalse($obj->boolean_false);
        $this->assertNull($obj->null_value);
        $this->assertSame(0, $obj->zero);
        $this->assertSame('', $obj->empty_string);
    }

    /**
     * Tests that __set() stores arrays WITHOUT converting them to CoverArray.
     *
     * This test verifies the key difference between Simple::__set() and
     * CoverArray::__set(). The Simple trait stores arrays as-is, while
     * CoverArray converts them to CoverArray instances via array2cover().
     *
     *
     * Тестирует, что __set() сохраняет массивы БЕЗ преобразования в CoverArray.
     *
     * Этот тест проверяет ключевое различие между Simple::__set() и
     * CoverArray::__set(). Трейт Simple сохраняет массивы как есть, тогда как
     * CoverArray преобразует их в экземпляры CoverArray через array2cover().
     *
     * @see Simple::__set()
     */
    public function testSetArraysWithoutConversion(): void
    {
        $obj = new SimpleTraitTestClass();

        $simpleArray = ['a', 'b', 'c'];
        $assocArray = ['name' => 'John', 'age' => 30];
        $nestedArray = ['level1' => ['level2' => 'value']];
        $emptyArray = [];

        $obj->simple = $simpleArray;
        $obj->assoc = $assocArray;
        $obj->nested = $nestedArray;
        $obj->empty = $emptyArray;

        // Arrays remain as plain PHP arrays (NOT CoverArray instances)
        $this->assertIsArray($obj->simple);
        $this->assertIsArray($obj->assoc);
        $this->assertIsArray($obj->nested);
        $this->assertIsArray($obj->empty);

        // Values are preserved exactly
        $this->assertSame($simpleArray, $obj->simple);
        $this->assertSame($assocArray, $obj->assoc);
        $this->assertSame($nestedArray, $obj->nested);
        $this->assertSame($emptyArray, $obj->empty);

        // Nested arrays are also plain arrays
        $this->assertIsArray($obj->nested['level1']);
        $this->assertSame('value', $obj->nested['level1']['level2']);
    }

    /**
     * Tests that __set() stores objects as-is without modification.
     *
     * This test verifies that objects are stored directly without cloning
     * or modification, maintaining referential integrity.
     *
     *
     * Тестирует, что __set() сохраняет объекты как есть без изменений.
     *
     * Этот тест проверяет, что объекты сохраняются напрямую без клонирования
     * или модификации, сохраняя ссылочную целостность.
     *
     * @see Simple::__set()
     */
    public function testSetObjectValues(): void
    {
        $obj = new SimpleTraitTestClass();

        $stdObject = new stdClass();
        $stdObject->property = 'value';

        $obj->object = $stdObject;

        // Same object reference
        $this->assertSame($stdObject, $obj->object);

        // Modifications through one reference affect the other
        $stdObject->newProperty = 'new value';
        $this->assertSame('new value', $obj->object->newProperty);
    }

    /**
     * Tests that __set() correctly overwrites existing values.
     *
     * This test verifies that setting a property that already exists
     * overwrites the old value with the new one.
     *
     *
     * Тестирует, что __set() корректно перезаписывает существующие значения.
     *
     * Этот тест проверяет, что установка свойства, которое уже существует,
     * перезаписывает старое значение новым.
     *
     * @see Simple::__set()
     */
    public function testSetOverwritesExistingValues(): void
    {
        $obj = new SimpleTraitTestClass();

        $obj->key = 'original';
        $this->assertSame('original', $obj->key);

        $obj->key = 'modified';
        $this->assertSame('modified', $obj->key);

        // Overwrite scalar with array
        $obj->key = ['now', 'an', 'array'];
        $this->assertIsArray($obj->key);
        $this->assertSame(['now', 'an', 'array'], $obj->key);

        // Overwrite array with scalar
        $obj->key = 123;
        $this->assertSame(123, $obj->key);
    }

    /**
     * Tests __set() with special string keys.
     *
     * This test verifies that __set() correctly handles property names
     * with special characters, UTF-8, and numeric strings.
     *
     *
     * Тестирует __set() со специальными строковыми ключами.
     *
     * Этот тест проверяет, что __set() корректно обрабатывает имена свойств
     * со специальными символами, UTF-8 и числовыми строками.
     *
     * @see Simple::__set()
     */
    public function testSetWithSpecialKeys(): void
    {
        $obj = new SimpleTraitTestClass();

        $obj->{'key-with-dash'} = 'dash';
        $obj->{'key.with.dot'} = 'dot';
        $obj->{'key with spaces'} = 'spaces';
        $obj->café = 'French coffee';
        $obj->{'123'} = 'numeric string';

        $this->assertSame('dash', $obj->{'key-with-dash'});
        $this->assertSame('dot', $obj->{'key.with.dot'});
        $this->assertSame('spaces', $obj->{'key with spaces'});
        $this->assertSame('French coffee', $obj->café);
        $this->assertSame('numeric string', $obj->{'123'});
    }

    /**
     * Tests that __set() returns void.
     *
     * This test verifies that the __set() magic method returns void,
     * which is the expected behavior per PHP specification.
     *
     *
     * Тестирует, что __set() возвращает void.
     *
     * Этот тест проверяет, что магический метод __set() возвращает void,
     * что является ожидаемым поведением согласно спецификации PHP.
     *
     * @see Simple::__set()
     */
    public function testSetReturnsVoid(): void
    {
        $obj = new SimpleTraitTestClass();

        $result = $obj->__set('key', 'value');

        $this->assertNull($result);
        $this->assertSame('value', $obj->key);
    }

    /**
     * Tests __set() with resource and callable values.
     *
     * This test verifies that resources and callable functions are stored
     * as-is without modification.
     *
     *
     * Тестирует __set() со значениями-ресурсами и callable.
     *
     * Этот тест проверяет, что ресурсы и callable-функции сохраняются
     * как есть без изменений.
     *
     * @see Simple::__set()
     */
    public function testSetResourceAndCallableValues(): void
    {
        $obj = new SimpleTraitTestClass();

        // Resource
        $resource = fopen('php://memory', 'r+');
        $obj->resource = $resource;
        $this->assertSame($resource, $obj->resource);
        $this->assertIsResource($obj->resource);
        fclose($resource);

        // Callable (closure)
        $closure = fn(int $a, int $b): int => $a + $b;
        $obj->closure = $closure;
        $this->assertSame($closure, $obj->closure);
        $this->assertSame(5, ($obj->closure)(2, 3));

        // Callable (function name as string)
        $obj->func = 'strlen';
        $this->assertSame('strlen', $obj->func);
        $this->assertIsCallable($obj->func);
    }
}
