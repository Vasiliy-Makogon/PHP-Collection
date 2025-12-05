<?php

declare(strict_types=1);

namespace CoverArrayCoreMethods\CoverArrayMagicMethods;

use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(CoverArray::class)]
class CoverArrayMagicCloneTest extends TestCase
{
    /**
     * Tests that cloning creates a separate instance with copied data.
     *
     * This test verifies that the __clone method creates a new object instance
     * that is separate from the original, but contains the same data values.
     * The cloned object should be independent from the original.
     *
     *
     * Тестирование создания отдельного экземпляра с копированными данными при клонировании.
     *
     * Этот тест проверяет, что метод __clone создает новый объект, отдельный
     * от оригинального, но содержащий те же значения данных. Клонированный
     * объект должен быть независимым от оригинала.
     *
     * @see CoverArray::__clone()
     */
    public function testCloneCreatesSeparateInstance(): void
    {
        $original = new NewTypeArray(['key1' => 'value1', 'key2' => 'value2']);
        $cloned = clone $original;

        $this->assertNotSame($original, $cloned);
        $this->assertEquals($original->getDataAsArray(), $cloned->getDataAsArray());
    }

    /**
     * Tests that cloned objects are independent.
     *
     * This test ensures that modifications to the cloned object do not affect
     * the original object, and vice versa. The clone should be a deep copy
     * that maintains data independence.
     *
     *
     * Тестирование независимости клонированных объектов.
     *
     * Этот тест гарантирует, что изменения в клонированном объекте не влияют
     * на оригинальный объект, и наоборот. Клон должен быть глубокой копией,
     * сохраняющей независимость данных.
     *
     * @see CoverArray::__clone()
     */
    public function testClonedObjectsAreIndependent(): void
    {
        $original = new NewTypeArray(['a' => 1, 'b' => 2]);
        $cloned = clone $original;

        // Изменяем клон
        $cloned['a'] = 999;
        $cloned['c'] = 3;

        $this->assertEquals(1, $original['a']);
        $this->assertFalse(isset($original['c']));
        $this->assertEquals(999, $cloned['a']);
        $this->assertEquals(3, $cloned['c']);
    }

    /**
     * Tests cloning of nested objects.
     *
     * This test verifies that when cloning an object containing nested objects,
     * those nested objects are also cloned (deep cloning). This prevents
     * unintended shared references between the original and cloned objects.
     *
     *
     * Тестирование клонирования вложенных объектов.
     *
     * Этот тест проверяет, что при клонировании объекта, содержащего вложенные
     * объекты, эти вложенные объекты также клонируются (глубокое клонирование).
     * Это предотвращает нежелательное совместное использование ссылок между
     * оригинальным и клонированным объектами.
     *
     * @see CoverArray::__clone()
     */
    public function testCloneDeeplyNestedObjects(): void
    {
        $nested = new NewTypeArray(['nested_key' => 'nested_value']);
        $original = new NewTypeArray(['obj' => $nested]);

        $cloned = clone $original;

        // Проверяем, что вложенный объект был клонирован
        $this->assertNotSame($original['obj'], $cloned['obj']);
        $this->assertEquals($original['obj']->getDataAsArray(), $cloned['obj']->getDataAsArray());

        // Изменяем клонированный вложенный объект
        $cloned['obj']['nested_key'] = 'modified_value';

        $this->assertEquals('nested_value', $original['obj']['nested_key']);
        $this->assertEquals('modified_value', $cloned['obj']['nested_key']);
    }

    /**
     * Tests cloning of arrays containing objects.
     *
     * This test ensures that objects within arrays are properly cloned
     * when the parent object is cloned. This maintains the deep cloning
     * behavior for all object references.
     *
     *
     * Тестирование клонирования массивов, содержащих объекты.
     *
     * Этот тест гарантирует, что объекты внутри массивов правильно клонируются
     * при клонировании родительского объекта. Это поддерживает поведение
     * глубокого клонирования для всех ссылок на объекты.
     *
     * @see CoverArray::__clone()
     */
    public function testCloneWithObjectsInArray(): void
    {
        $object1 = new stdClass();
        $object1->property = 'value1';

        $object2 = new stdClass();
        $object2->property = 'value2';

        $original = new NewTypeArray([
            'objects' => [$object1, $object2],
            'mixed' => [1, $object1, 'string']
        ]);

        $cloned = clone $original;

        // Проверяем, что объекты в массиве были клонированы
        $this->assertNotSame($original['objects'][0], $cloned['objects'][0]);
        $this->assertNotSame($original['objects'][1], $cloned['objects'][1]);
        $this->assertNotSame($original['mixed'][1], $cloned['mixed'][1]);

        // Изменяем клонированные объекты
        $cloned['objects'][0]->property = 'modified_value';
        $cloned['mixed'][1]->property = 'also_modified';

        $this->assertEquals('value1', $original['objects'][0]->property);
        $this->assertEquals('value1', $original['mixed'][1]->property);
        $this->assertEquals('modified_value', $cloned['objects'][0]->property);
        $this->assertEquals('also_modified', $cloned['mixed'][1]->property);
    }

    /**
     * Tests cloning with scalar values.
     *
     * This test verifies that scalar values (integers, strings, booleans, etc.)
     * are copied by value during cloning, which is the expected behavior
     * for PHP's assignment of scalars.
     *
     *
     * Тестирование клонирования со скалярными значениями.
     *
     * Этот тест проверяет, что скалярные значения (целые числа, строки,
     * логические значения и т.д.) копируются по значению при клонировании,
     * что является ожидаемым поведением для присваивания скаляров в PHP.
     *
     * @see CoverArray::__clone()
     */
    public function testCloneWithScalarValues(): void
    {
        $original = new NewTypeArray([
            'int' => 42,
            'float' => 3.14,
            'string' => 'hello',
            'bool' => true,
            'null' => null
        ]);

        $cloned = clone $original;

        // Изменяем значения в клоне
        $cloned['int'] = 100;
        $cloned['string'] = 'world';

        $this->assertEquals(42, $original['int']);
        $this->assertEquals('hello', $original['string']);
        $this->assertEquals(100, $cloned['int']);
        $this->assertEquals('world', $cloned['string']);
    }

    /**
     * Tests that the copy() method uses cloning.
     *
     * This test verifies that the copy() method internally uses the __clone
     * method to create a copy of the object, ensuring consistent behavior
     * between the two approaches.
     *
     *
     * Тестирование использования клонирования в методе copy().
     *
     * Этот тест проверяет, что метод copy() внутренне использует метод __clone
     * для создания копии объекта, обеспечивая согласованное поведение между
     * двумя подходами.
     *
     * @see CoverArray::__clone()
     * @see CoverArray::copy()
     */
    public function testCopyMethodUsesClone(): void
    {
        $original = new NewTypeArray(['data' => 'value']);
        $copied = $original->copy();

        $this->assertNotSame($original, $copied);
        $this->assertEquals($original->getDataAsArray(), $copied->getDataAsArray());
    }

    /**
     * Tests cloning with empty data.
     *
     * This test ensures that cloning an empty CoverArray object works
     * correctly and produces a new empty object without errors.
     *
     *
     * Тестирование клонирования с пустыми данными.
     *
     * Этот тест гарантирует, что клонирование пустого объекта CoverArray
     * работает корректно и создает новый пустой объект без ошибок.
     *
     * @see CoverArray::__clone()
     */
    public function testCloneEmptyArray(): void
    {
        $original = new NewTypeArray();
        $cloned = clone $original;

        $this->assertNotSame($original, $cloned);
        $this->assertEmpty($cloned->getDataAsArray());
        $this->assertTrue($cloned->isEmpty());
    }

    /**
     * Tests cloning with complex nested structure.
     *
     * This test verifies that cloning works correctly with complex,
     * deeply nested data structures containing a mix of objects,
     * arrays, and scalar values.
     *
     *
     * Тестирование клонирования со сложной вложенной структурой.
     *
     * Этот тест проверяет, что клонирование работает корректно со сложными,
     * глубоко вложенными структурами данных, содержащими смесь объектов,
     * массивов и скалярных значений.
     *
     * @see CoverArray::__clone()
     */
    public function testCloneComplexStructure(): void
    {
        $innerObject = new stdClass();
        $innerObject->id = 1;

        $original = new NewTypeArray([
            'level1' => [
                'level2' => new NewTypeArray([
                    'level3' => [
                        'object' => $innerObject,
                        'array' => [1, 2, 3],
                        'scalar' => 'test'
                    ]
                ])
            ],
            'simple' => 'value'
        ]);

        $cloned = clone $original;

        // Изменяем глубоко вложенные данные
        $cloned['level1']['level2']['level3']['object']->id = 999;
        $cloned['level1']['level2']['level3']['array'][0] = 999;
        $cloned['level1']['level2']['level3']['scalar'] = 'modified';

        $this->assertEquals(1, $original['level1']['level2']['level3']['object']->id);
        $this->assertEquals(1, $original['level1']['level2']['level3']['array'][0]);
        $this->assertEquals('test', $original['level1']['level2']['level3']['scalar']);

        $this->assertEquals(999, $cloned['level1']['level2']['level3']['object']->id);
        $this->assertEquals(999, $cloned['level1']['level2']['level3']['array'][0]);
        $this->assertEquals('modified', $cloned['level1']['level2']['level3']['scalar']);
    }
}