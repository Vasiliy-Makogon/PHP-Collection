<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class ReplaceTest extends TestCase
{
    /**
     * Tests the replace() method with simple associative arrays.
     *
     * This test verifies that the replace() method correctly replaces
     * elements from one array with elements from another,
     * mirroring PHP's array_replace() function.
     *
     *
     * Тестирование метода replace() с простыми ассоциативными массивами.
     *
     * Этот тест проверяет, что метод replace() корректно заменяет
     * элементы одного массива элементами другого,
     * отражая функцию array_replace() PHP.
     *
     * @see CoverArray::replace()
     * @see array_replace()
     */
    public function testReplaceWithSimpleAssociativeArrays(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $replacement = ['b' => 'blueberry', 'd' => 'date'];

        $expected = array_replace($data, $replacement);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame($expected, $cover->replace($replacement)->getDataAsArray());

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame($expected, $cover->replace(new CoverArray($replacement))->getDataAsArray());
    }

    /**
     * Tests the replace() method with multiple replacement arrays.
     *
     * This test verifies that the replace() method correctly replaces
     * elements when multiple replacement arrays are provided,
     * mirroring PHP's array_replace() function.
     *
     *
     * Тестирование метода replace() с несколькими массивами замены.
     *
     * Этот тест проверяет, что метод replace() корректно заменяет
     * элементы при передаче нескольких массивов замены,
     * отражая функцию array_replace() PHP.
     *
     * @see CoverArray::replace()
     * @see array_replace()
     */
    public function testReplaceWithMultipleReplacementArrays(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $replacement1 = ['b' => 20, 'd' => 4];
        $replacement2 = ['a' => 100, 'e' => 5];

        $expected = array_replace($data, $replacement1, $replacement2);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame($expected, $cover->replace($replacement1, $replacement2)->getDataAsArray());

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->replace(
                new CoverArray($replacement1),
                new CoverArray($replacement2)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the replace() method with numeric keys.
     *
     * This test verifies that the replace() method correctly replaces
     * elements with numeric keys (by index),
     * mirroring PHP's array_replace() function.
     *
     *
     * Тестирование метода replace() с числовыми ключами.
     *
     * Этот тест проверяет, что метод replace() корректно заменяет
     * элементы с числовыми ключами (по индексу),
     * отражая функцию array_replace() PHP.
     *
     * @see CoverArray::replace()
     * @see array_replace()
     */
    public function testReplaceWithNumericKeys(): void
    {
        $data = [0 => 'zero', 1 => 'one', 2 => 'two'];
        $replacement = [1 => 'ONE', 3 => 'three'];

        $expected = array_replace($data, $replacement);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame($expected, $cover->replace($replacement)->getDataAsArray());

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame($expected, $cover->replace(new CoverArray($replacement))->getDataAsArray());
    }

    /**
     * Tests the replace() method with mixed key types.
     *
     * This test verifies that the replace() method correctly replaces
     * elements with mixed key types (strings, integers),
     * mirroring PHP's array_replace() function.
     *
     *
     * Тестирование метода replace() со смешанными типами ключей.
     *
     * Этот тест проверяет, что метод replace() корректно заменяет
     * элементы со смешанными типами ключей (строки, целые числа),
     * отражая функцию array_replace() PHP.
     *
     * @see CoverArray::replace()
     * @see array_replace()
     */
    public function testReplaceWithMixedKeyTypes(): void
    {
        $data = ['a' => 'apple', 0 => 'zero', 1 => 'one'];
        $replacement = ['a' => 'apricot', 0 => 'ZERO', 'b' => 'banana'];

        $expected = array_replace($data, $replacement);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame($expected, $cover->replace($replacement)->getDataAsArray());

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame($expected, $cover->replace(new CoverArray($replacement))->getDataAsArray());
    }

    /**
     * Tests the replace() method with empty replacement array.
     *
     * This test verifies that the replace() method correctly returns
     * the original array when the replacement array is empty,
     * mirroring PHP's array_replace() function.
     *
     *
     * Тестирование метода replace() с пустым массивом замены.
     *
     * Этот тест проверяет, что метод replace() корректно возвращает
     * исходный массив, когда массив замены пуст,
     * отражая функцию array_replace() PHP.
     *
     * @see CoverArray::replace()
     * @see array_replace()
     */
    public function testReplaceWithEmptyReplacementArray(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $replacement = [];

        $expected = array_replace($data, $replacement);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame($expected, $cover->replace($replacement)->getDataAsArray());

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame($expected, $cover->replace(new CoverArray($replacement))->getDataAsArray());
    }

    /**
     * Tests the replace() method with empty original array.
     *
     * This test verifies that the replace() method correctly returns
     * the replacement array when the original array is empty,
     * mirroring PHP's array_replace() function.
     *
     *
     * Тестирование метода replace() с пустым исходным массивом.
     *
     * Этот тест проверяет, что метод replace() корректно возвращает
     * массив замены, когда исходный массив пуст,
     * отражая функцию array_replace() PHP.
     *
     * @see CoverArray::replace()
     * @see array_replace()
     */
    public function testReplaceWithEmptyOriginalArray(): void
    {
        $data = [];
        $replacement = ['a' => 1, 'b' => 2];

        $expected = array_replace($data, $replacement);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame($expected, $cover->replace($replacement)->getDataAsArray());

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame($expected, $cover->replace(new CoverArray($replacement))->getDataAsArray());
    }

    /**
     * Tests the replace() method where all elements are replaced.
     *
     * This test verifies that the replace() method correctly replaces
     * all elements when the replacement array contains all keys,
     * mirroring PHP's array_replace() function.
     *
     *
     * Тестирование метода replace(), когда все элементы заменяются.
     *
     * Этот тест проверяет, что метод replace() корректно заменяет
     * все элементы, когда массив замены содержит все ключи,
     * отражая функцию array_replace() PHP.
     *
     * @see CoverArray::replace()
     * @see array_replace()
     */
    public function testReplaceWithAllElementsReplaced(): void
    {
        $data = ['a' => 1, 'b' => 2];
        $replacement = ['a' => 10, 'b' => 20];

        $expected = array_replace($data, $replacement);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame($expected, $cover->replace($replacement)->getDataAsArray());

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame($expected, $cover->replace(new CoverArray($replacement))->getDataAsArray());
    }

    /**
     * Tests the replace() method with three replacement arrays.
     *
     * This test verifies that the replace() method correctly replaces
     * elements when three replacement arrays are provided,
     * mirroring PHP's array_replace() function.
     *
     *
     * Тестирование метода replace() с тремя массивами замены.
     *
     * Этот тест проверяет, что метод replace() корректно заменяет
     * элементы при передаче трёх массивов замены,
     * отражая функцию array_replace() PHP.
     *
     * @see CoverArray::replace()
     * @see array_replace()
     */
    public function testReplaceWithThreeReplacementArrays(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $replacement1 = ['a' => 10];
        $replacement2 = ['b' => 20];
        $replacement3 = ['c' => 30, 'd' => 40];

        $expected = array_replace($data, $replacement1, $replacement2, $replacement3);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->replace($replacement1, $replacement2, $replacement3)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->replace(
                new CoverArray($replacement1),
                new CoverArray($replacement2),
                new CoverArray($replacement3)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the replace() method with mixed array and CoverArray arguments.
     *
     * This test verifies that the replace() method correctly handles
     * a mix of array and CoverArray arguments,
     * mirroring PHP's array_replace() function.
     *
     *
     * Тестирование метода replace() со смешанными аргументами array и CoverArray.
     *
     * Этот тест проверяет, что метод replace() корректно обрабатывает
     * смесь аргументов array и CoverArray,
     * отражая функцию array_replace() PHP.
     *
     * @see CoverArray::replace()
     * @see array_replace()
     */
    public function testReplaceWithMixedArrayAndCoverArrayArguments(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $replacement1 = ['a' => 10];
        $replacement2 = ['b' => 20];

        $expected = array_replace($data, $replacement1, $replacement2);

        $cover = new CoverArray($data);

        // mixed arguments: array and CoverArray
        // смешанные аргументы: array и CoverArray
        $this->assertSame(
            $expected,
            $cover->replace($replacement1, new CoverArray($replacement2))->getDataAsArray()
        );
    }
}
