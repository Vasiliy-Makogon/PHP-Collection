<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class ReplaceRecursiveTest extends TestCase
{
    /**
     * Tests the replaceRecursive() method with nested arrays.
     *
     * This test verifies that the replaceRecursive() method correctly replaces
     * elements recursively in nested arrays,
     * mirroring PHP's array_replace_recursive() function.
     *
     *
     * Тестирование метода replaceRecursive() с вложенными массивами.
     *
     * Этот тест проверяет, что метод replaceRecursive() корректно заменяет
     * элементы рекурсивно во вложенных массивах,
     * отражая функцию array_replace_recursive() PHP.
     *
     * @see CoverArray::replaceRecursive()
     * @see array_replace_recursive()
     */
    public function testReplaceRecursiveWithNestedArrays(): void
    {
        $data = [
            'a' => ['x' => 1, 'y' => 2],
            'b' => ['z' => 3]
        ];
        $replacement = [
            'a' => ['y' => 20, 'w' => 4],
            'c' => ['v' => 5]
        ];

        $expected = array_replace_recursive($data, $replacement);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame($expected, $cover->replaceRecursive($replacement)->getDataAsArray());

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame($expected, $cover->replaceRecursive(new CoverArray($replacement))->getDataAsArray());
    }

    /**
     * Tests the replaceRecursive() method with deeply nested arrays.
     *
     * This test verifies that the replaceRecursive() method correctly replaces
     * elements in deeply nested array structures,
     * mirroring PHP's array_replace_recursive() function.
     *
     *
     * Тестирование метода replaceRecursive() с глубоко вложенными массивами.
     *
     * Этот тест проверяет, что метод replaceRecursive() корректно заменяет
     * элементы в глубоко вложенных структурах массивов,
     * отражая функцию array_replace_recursive() PHP.
     *
     * @see CoverArray::replaceRecursive()
     * @see array_replace_recursive()
     */
    public function testReplaceRecursiveWithDeeplyNestedArrays(): void
    {
        $data = [
            'level1' => [
                'level2' => [
                    'level3' => ['a' => 1, 'b' => 2]
                ]
            ]
        ];
        $replacement = [
            'level1' => [
                'level2' => [
                    'level3' => ['b' => 20, 'c' => 3]
                ]
            ]
        ];

        $expected = array_replace_recursive($data, $replacement);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame($expected, $cover->replaceRecursive($replacement)->getDataAsArray());

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame($expected, $cover->replaceRecursive(new CoverArray($replacement))->getDataAsArray());
    }

    /**
     * Tests the replaceRecursive() method with multiple replacement arrays.
     *
     * This test verifies that the replaceRecursive() method correctly replaces
     * elements when multiple replacement arrays are provided,
     * mirroring PHP's array_replace_recursive() function.
     *
     *
     * Тестирование метода replaceRecursive() с несколькими массивами замены.
     *
     * Этот тест проверяет, что метод replaceRecursive() корректно заменяет
     * элементы при передаче нескольких массивов замены,
     * отражая функцию array_replace_recursive() PHP.
     *
     * @see CoverArray::replaceRecursive()
     * @see array_replace_recursive()
     */
    public function testReplaceRecursiveWithMultipleReplacementArrays(): void
    {
        $data = ['a' => ['x' => 1], 'b' => 2];
        $replacement1 = ['a' => ['y' => 2], 'c' => 3];
        $replacement2 = ['a' => ['x' => 10, 'z' => 3]];

        $expected = array_replace_recursive($data, $replacement1, $replacement2);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame($expected, $cover->replaceRecursive($replacement1, $replacement2)->getDataAsArray());

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->replaceRecursive(
                new CoverArray($replacement1),
                new CoverArray($replacement2)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the replaceRecursive() method with flat arrays.
     *
     * This test verifies that the replaceRecursive() method correctly replaces
     * elements in flat (non-nested) arrays,
     * mirroring PHP's array_replace_recursive() function.
     *
     *
     * Тестирование метода replaceRecursive() с плоскими массивами.
     *
     * Этот тест проверяет, что метод replaceRecursive() корректно заменяет
     * элементы в плоских (не вложенных) массивах,
     * отражая функцию array_replace_recursive() PHP.
     *
     * @see CoverArray::replaceRecursive()
     * @see array_replace_recursive()
     */
    public function testReplaceRecursiveWithFlatArrays(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $replacement = ['b' => 20, 'd' => 4];

        $expected = array_replace_recursive($data, $replacement);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame($expected, $cover->replaceRecursive($replacement)->getDataAsArray());

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame($expected, $cover->replaceRecursive(new CoverArray($replacement))->getDataAsArray());
    }

    /**
     * Tests the replaceRecursive() method with numeric keys.
     *
     * This test verifies that the replaceRecursive() method correctly replaces
     * elements with numeric keys in nested arrays,
     * mirroring PHP's array_replace_recursive() function.
     *
     *
     * Тестирование метода replaceRecursive() с числовыми ключами.
     *
     * Этот тест проверяет, что метод replaceRecursive() корректно заменяет
     * элементы с числовыми ключами во вложенных массивах,
     * отражая функцию array_replace_recursive() PHP.
     *
     * @see CoverArray::replaceRecursive()
     * @see array_replace_recursive()
     */
    public function testReplaceRecursiveWithNumericKeys(): void
    {
        $data = [
            0 => ['a' => 1, 'b' => 2],
            1 => ['c' => 3]
        ];
        $replacement = [
            0 => ['b' => 20],
            2 => ['d' => 4]
        ];

        $expected = array_replace_recursive($data, $replacement);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame($expected, $cover->replaceRecursive($replacement)->getDataAsArray());

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame($expected, $cover->replaceRecursive(new CoverArray($replacement))->getDataAsArray());
    }

    /**
     * Tests the replaceRecursive() method with empty replacement array.
     *
     * This test verifies that the replaceRecursive() method correctly returns
     * the original array when the replacement array is empty,
     * mirroring PHP's array_replace_recursive() function.
     *
     *
     * Тестирование метода replaceRecursive() с пустым массивом замены.
     *
     * Этот тест проверяет, что метод replaceRecursive() корректно возвращает
     * исходный массив, когда массив замены пуст,
     * отражая функцию array_replace_recursive() PHP.
     *
     * @see CoverArray::replaceRecursive()
     * @see array_replace_recursive()
     */
    public function testReplaceRecursiveWithEmptyReplacementArray(): void
    {
        $data = ['a' => ['x' => 1], 'b' => 2];
        $replacement = [];

        $expected = array_replace_recursive($data, $replacement);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame($expected, $cover->replaceRecursive($replacement)->getDataAsArray());

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame($expected, $cover->replaceRecursive(new CoverArray($replacement))->getDataAsArray());
    }

    /**
     * Tests the replaceRecursive() method with empty original array.
     *
     * This test verifies that the replaceRecursive() method correctly returns
     * the replacement array when the original array is empty,
     * mirroring PHP's array_replace_recursive() function.
     *
     *
     * Тестирование метода replaceRecursive() с пустым исходным массивом.
     *
     * Этот тест проверяет, что метод replaceRecursive() корректно возвращает
     * массив замены, когда исходный массив пуст,
     * отражая функцию array_replace_recursive() PHP.
     *
     * @see CoverArray::replaceRecursive()
     * @see array_replace_recursive()
     */
    public function testReplaceRecursiveWithEmptyOriginalArray(): void
    {
        $data = [];
        $replacement = ['a' => ['x' => 1], 'b' => 2];

        $expected = array_replace_recursive($data, $replacement);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame($expected, $cover->replaceRecursive($replacement)->getDataAsArray());

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame($expected, $cover->replaceRecursive(new CoverArray($replacement))->getDataAsArray());
    }

    /**
     * Tests the replaceRecursive() method replacing array with scalar.
     *
     * This test verifies that the replaceRecursive() method correctly replaces
     * a nested array with a scalar value,
     * mirroring PHP's array_replace_recursive() function.
     *
     *
     * Тестирование метода replaceRecursive() с заменой массива на скаляр.
     *
     * Этот тест проверяет, что метод replaceRecursive() корректно заменяет
     * вложенный массив на скалярное значение,
     * отражая функцию array_replace_recursive() PHP.
     *
     * @see CoverArray::replaceRecursive()
     * @see array_replace_recursive()
     */
    public function testReplaceRecursiveReplacingArrayWithScalar(): void
    {
        $data = ['a' => ['x' => 1, 'y' => 2], 'b' => 3];
        $replacement = ['a' => 'replaced'];

        $expected = array_replace_recursive($data, $replacement);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame($expected, $cover->replaceRecursive($replacement)->getDataAsArray());

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame($expected, $cover->replaceRecursive(new CoverArray($replacement))->getDataAsArray());
    }

    /**
     * Tests the replaceRecursive() method replacing scalar with array.
     *
     * This test verifies that the replaceRecursive() method correctly replaces
     * a scalar value with a nested array,
     * mirroring PHP's array_replace_recursive() function.
     *
     *
     * Тестирование метода replaceRecursive() с заменой скаляра на массив.
     *
     * Этот тест проверяет, что метод replaceRecursive() корректно заменяет
     * скалярное значение на вложенный массив,
     * отражая функцию array_replace_recursive() PHP.
     *
     * @see CoverArray::replaceRecursive()
     * @see array_replace_recursive()
     */
    public function testReplaceRecursiveReplacingScalarWithArray(): void
    {
        $data = ['a' => 'scalar', 'b' => 3];
        $replacement = ['a' => ['x' => 1, 'y' => 2]];

        $expected = array_replace_recursive($data, $replacement);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame($expected, $cover->replaceRecursive($replacement)->getDataAsArray());

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame($expected, $cover->replaceRecursive(new CoverArray($replacement))->getDataAsArray());
    }
}
