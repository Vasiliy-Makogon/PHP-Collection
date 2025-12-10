<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class DiffAssocTest extends TestCase
{
    /**
     * Tests the diffAssoc() method with simple associative arrays.
     *
     * This test verifies that the diffAssoc() method correctly computes
     * the difference of arrays with additional index check for simple
     * associative arrays, comparing both keys and values,
     * mirroring PHP's array_diff_assoc() function.
     *
     *
     * Тестирование метода diffAssoc() с простыми ассоциативными массивами.
     *
     * Этот тест проверяет, что метод diffAssoc() корректно вычисляет
     * расхождение массивов с дополнительной проверкой индекса для простых
     * ассоциативных массивов, сравнивая как ключи, так и значения,
     * отражая функцию array_diff_assoc() PHP.
     *
     * @see CoverArray::diffAssoc()
     * @see array_diff_assoc()
     */
    public function testDiffAssocWithSimpleAssociativeArrays(): void
    {
        // Test with simple associative arrays
        // Тест с простыми ассоциативными массивами
        $data = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $diff = ['b' => 2, 'c' => 30, 'e' => 5];

        $expected = array_diff_assoc($data, $diff);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffAssoc($diff)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffAssoc(new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the diffAssoc() method with multiple diff arrays.
     *
     * This test verifies that the diffAssoc() method correctly computes
     * the difference of arrays with multiple comparison arrays,
     * comparing both keys and values across all arrays,
     * mirroring PHP's array_diff_assoc() function.
     *
     *
     * Тестирование метода diffAssoc() с несколькими массивами для сравнения.
     *
     * Этот тест проверяет, что метод diffAssoc() корректно вычисляет
     * расхождение массивов с несколькими массивами для сравнения,
     * сравнивая как ключи, так и значения во всех массивах,
     * отражая функцию array_diff_assoc() PHP.
     *
     * @see CoverArray::diffAssoc()
     * @see array_diff_assoc()
     */
    public function testDiffAssocWithMultipleDiffArrays(): void
    {
        // Test with multiple diff arrays
        // Тест с несколькими массивами для сравнения
        $data = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $diff1 = ['b' => 2, 'c' => 30];
        $diff2 = ['a' => 10, 'd' => 4];

        $expected = array_diff_assoc($data, $diff1, $diff2);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffAssoc($diff1, $diff2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffAssoc(
                new CoverArray($diff1),
                new CoverArray($diff2)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the diffAssoc() method with numeric keys.
     *
     * This test verifies that the diffAssoc() method correctly computes
     * the difference of arrays with numeric keys, comparing both
     * key and value for numeric indices, mirroring PHP's array_diff_assoc() function.
     *
     *
     * Тестирование метода diffAssoc() с числовыми ключами.
     *
     * Этот тест проверяет, что метод diffAssoc() корректно вычисляет
     * расхождение массивов с числовыми ключами, сравнивая как ключ,
     * так и значение для числовых индексов, отражая функцию array_diff_assoc() PHP.
     *
     * @see CoverArray::diffAssoc()
     * @see array_diff_assoc()
     */
    public function testDiffAssocWithNumericKeys(): void
    {
        // Test with numeric keys (compares both key and value)
        // Тест с числовыми ключами (сравнивает и ключ, и значение)
        $data = [0 => 'zero', 1 => 'one', 2 => 'two'];
        $diff = [0 => 'zero', 1 => 'ONE', 3 => 'three'];

        $expected = array_diff_assoc($data, $diff);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffAssoc($diff)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffAssoc(new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the diffAssoc() method with mixed key types.
     *
     * This test verifies that the diffAssoc() method correctly computes
     * the difference of arrays with mixed key types (strings, integers, numeric strings),
     * comparing both keys and values, mirroring PHP's array_diff_assoc() function.
     *
     *
     * Тестирование метода diffAssoc() со смешанными типами ключей.
     *
     * Этот тест проверяет, что метод diffAssoc() корректно вычисляет
     * расхождение массивов со смешанными типами ключей (строки, целые числа, числовые строки),
     * сравнивая как ключи, так и значения, отражая функцию array_diff_assoc() PHP.
     *
     * @see CoverArray::diffAssoc()
     * @see array_diff_assoc()
     */
    public function testDiffAssocWithMixedKeyTypes(): void
    {
        // Test with mixed key types
        // Тест со смешанными типами ключей
        $data = ['a' => 'apple', 0 => 'zero', '1' => 'one'];
        $diff = ['a' => 'apple', 0 => 'ZERO', '1' => 'one'];

        $expected = array_diff_assoc($data, $diff);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffAssoc($diff)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffAssoc(new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the diffAssoc() method with empty diff array.
     *
     * This test verifies that the diffAssoc() method correctly handles
     * an empty diff array, returning the entire original array,
     * mirroring PHP's array_diff_assoc() function.
     *
     *
     * Тестирование метода diffAssoc() с пустым массивом для сравнения.
     *
     * Этот тест проверяет, что метод diffAssoc() корректно обрабатывает
     * пустой массив для сравнения, возвращая весь исходный массив,
     * отражая функцию array_diff_assoc() PHP.
     *
     * @see CoverArray::diffAssoc()
     * @see array_diff_assoc()
     */
    public function testDiffAssocWithEmptyDiffArray(): void
    {
        // Test with empty diff array (should return entire array)
        // Тест с пустым массивом для сравнения (должен вернуть весь массив)
        $data = ['x' => 10, 'y' => 20, 'z' => 30];
        $diff = [];

        $expected = array_diff_assoc($data, $diff);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffAssoc($diff)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffAssoc(new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the diffAssoc() method where all elements are removed.
     *
     * This test verifies that the diffAssoc() method correctly returns
     * an empty array when all key-value pairs match in the diff array,
     * mirroring PHP's array_diff_assoc() function.
     *
     *
     * Тестирование метода diffAssoc(), когда все элементы удаляются.
     *
     * Этот тест проверяет, что метод diffAssoc() корректно возвращает
     * пустой массив, когда все пары ключ-значение совпадают в массиве сравнения,
     * отражая функцию array_diff_assoc() PHP.
     *
     * @see CoverArray::diffAssoc()
     * @see array_diff_assoc()
     */
    public function testDiffAssocWithAllElementsRemoved(): void
    {
        // Test where all elements are removed
        // Тест, где все элементы удаляются
        $data = ['a' => 1, 'b' => 2];
        $diff = ['a' => 1, 'b' => 2];

        $expected = array_diff_assoc($data, $diff);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffAssoc($diff)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffAssoc(new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the diffAssoc() method with three diff arrays.
     *
     * This test verifies that the diffAssoc() method correctly computes
     * the difference of arrays with three comparison arrays,
     * comparing both keys and values across all arrays,
     * mirroring PHP's array_diff_assoc() function.
     *
     *
     * Тестирование метода diffAssoc() с тремя массивами для сравнения.
     *
     * Этот тест проверяет, что метод diffAssoc() корректно вычисляет
     * расхождение массивов с тремя массивами для сравнения,
     * сравнивая как ключи, так и значения во всех массивах,
     * отражая функцию array_diff_assoc() PHP.
     *
     * @see CoverArray::diffAssoc()
     * @see array_diff_assoc()
     */
    public function testDiffAssocWithThreeDiffArrays(): void
    {
        // Test with three diff arrays
        // Тест с тремя массивами для сравнения
        $data = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5];
        $diff1 = ['a' => 1, 'b' => 20];
        $diff2 = ['c' => 3];
        $diff3 = ['d' => 40, 'e' => 50];

        $expected = array_diff_assoc($data, $diff1, $diff2, $diff3);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffAssoc($diff1, $diff2, $diff3)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffAssoc(
                new CoverArray($diff1),
                new CoverArray($diff2),
                new CoverArray($diff3)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the diffAssoc() method with same keys but different values.
     *
     * This test verifies that the diffAssoc() method correctly retains
     * elements where keys are the same but values are different,
     * comparing both keys and values, mirroring PHP's array_diff_assoc() function.
     *
     *
     * Тестирование метода diffAssoc() с одинаковыми ключами, но разными значениями.
     *
     * Этот тест проверяет, что метод diffAssoc() корректно сохраняет
     * элементы, где ключи одинаковы, но значения различаются,
     * сравнивая как ключи, так и значения, отражая функцию array_diff_assoc() PHP.
     *
     * @see CoverArray::diffAssoc()
     * @see array_diff_assoc()
     */
    public function testDiffAssocWithSameKeysDifferentValues(): void
    {
        // Test with same keys but different values
        // Тест с одинаковыми ключами, но разными значениями
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $diff = ['a' => 10, 'b' => 2, 'c' => 30];

        $expected = array_diff_assoc($data, $diff);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffAssoc($diff)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffAssoc(new CoverArray($diff))->getDataAsArray()
        );
    }
}