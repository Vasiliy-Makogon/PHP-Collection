<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class DiffKeyTest extends TestCase
{
    /**
     * Tests the diffKey() method with string keys.
     *
     * This test verifies that the diffKey() method correctly computes
     * the difference of arrays using string keys for comparison,
     * ignoring values, mirroring PHP's array_diff_key() function.
     *
     *
     * Тестирование метода diffKey() со строковыми ключами.
     *
     * Этот тест проверяет, что метод diffKey() корректно вычисляет
     * расхождение массивов, используя строковые ключи для сравнения,
     * игнорируя значения, отражая функцию array_diff_key() PHP.
     *
     * @see CoverArray::diffKey()
     * @see array_diff_key()
     */
    public function testDiffKeyWithStringKeys(): void
    {
        // Test with string keys
        // Тест со строковыми ключами
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $diff = ['a' => 'apricot', 'c' => 'coconut'];

        $expected = array_diff_key($data, $diff);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffKey($diff)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffKey(new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the diffKey() method with numeric keys.
     *
     * This test verifies that the diffKey() method correctly computes
     * the difference of arrays using numeric keys for comparison,
     * ignoring values, mirroring PHP's array_diff_key() function.
     *
     *
     * Тестирование метода diffKey() с числовыми ключами.
     *
     * Этот тест проверяет, что метод diffKey() корректно вычисляет
     * расхождение массивов, используя числовые ключи для сравнения,
     * игнорируя значения, отражая функцию array_diff_key() PHP.
     *
     * @see CoverArray::diffKey()
     * @see array_diff_key()
     */
    public function testDiffKeyWithNumericKeys(): void
    {
        // Test with numeric keys
        // Тест с числовыми ключами
        $data = [0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three'];
        $diff = [1 => 'ONE', 3 => 'THREE'];

        $expected = array_diff_key($data, $diff);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffKey($diff)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffKey(new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the diffKey() method with multiple diff arrays.
     *
     * This test verifies that the diffKey() method correctly computes
     * the difference of arrays using multiple diff arrays for key comparison,
     * ignoring values, mirroring PHP's array_diff_key() function.
     *
     *
     * Тестирование метода diffKey() с несколькими массивами для сравнения.
     *
     * Этот тест проверяет, что метод diffKey() корректно вычисляет
     * расхождение массивов, используя несколько массивов для сравнения ключей,
     * игнорируя значения, отражая функцию array_diff_key() PHP.
     *
     * @see CoverArray::diffKey()
     * @see array_diff_key()
     */
    public function testDiffKeyWithMultipleDiffArrays(): void
    {
        // Test with multiple diff arrays
        // Тест с несколькими массивами для сравнения
        $data = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5];
        $diff1 = ['a' => 10, 'c' => 30];
        $diff2 = ['b' => 20, 'd' => 40];

        $expected = array_diff_key($data, $diff1, $diff2);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffKey($diff1, $diff2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffKey(
                new CoverArray($diff1),
                new CoverArray($diff2)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the diffKey() method with mixed key types.
     *
     * This test verifies that the diffKey() method correctly computes
     * the difference of arrays with mixed key types (strings, integers),
     * comparing keys and ignoring values, mirroring PHP's array_diff_key() function.
     *
     *
     * Тестирование метода diffKey() со смешанными типами ключей.
     *
     * Этот тест проверяет, что метод diffKey() корректно вычисляет
     * расхождение массивов со смешанными типами ключей (строки, целые числа),
     * сравнивая ключи и игнорируя значения, отражая функцию array_diff_key() PHP.
     *
     * @see CoverArray::diffKey()
     * @see array_diff_key()
     */
    public function testDiffKeyWithMixedKeyTypes(): void
    {
        // Test with mixed key types
        // Тест со смешанными типами ключей
        $data = ['a' => 'apple', 0 => 'zero', '1' => 'one'];
        $diff = ['a' => 'apricot', 0 => 'ZERO'];

        $expected = array_diff_key($data, $diff);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffKey($diff)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffKey(new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the diffKey() method with empty diff array.
     *
     * This test verifies that the diffKey() method correctly handles
     * an empty diff array, returning the entire original array,
     * mirroring PHP's array_diff_key() function.
     *
     *
     * Тестирование метода diffKey() с пустым массивом для сравнения.
     *
     * Этот тест проверяет, что метод diffKey() корректно обрабатывает
     * пустой массив для сравнения, возвращая весь исходный массив,
     * отражая функцию array_diff_key() PHP.
     *
     * @see CoverArray::diffKey()
     * @see array_diff_key()
     */
    public function testDiffKeyWithEmptyDiffArray(): void
    {
        // Test with empty diff array (should return entire array)
        // Тест с пустым массивом для сравнения (должен вернуть весь массив)
        $data = ['x' => 10, 'y' => 20, 'z' => 30];
        $diff = [];

        $expected = array_diff_key($data, $diff);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffKey($diff)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffKey(new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the diffKey() method where all keys are removed.
     *
     * This test verifies that the diffKey() method correctly returns
     * an empty array when all keys are present in the diff array,
     * mirroring PHP's array_diff_key() function.
     *
     *
     * Тестирование метода diffKey(), когда все ключи удаляются.
     *
     * Этот тест проверяет, что метод diffKey() корректно возвращает
     * пустой массив, когда все ключи присутствуют в массиве сравнения,
     * отражая функцию array_diff_key() PHP.
     *
     * @see CoverArray::diffKey()
     * @see array_diff_key()
     */
    public function testDiffKeyWithAllKeysRemoved(): void
    {
        // Test where all keys are removed
        // Тест, где все ключи удаляются
        $data = ['a' => 1, 'b' => 2];
        $diff = ['a' => 100, 'b' => 200];

        $expected = array_diff_key($data, $diff);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffKey($diff)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffKey(new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the diffKey() method with three diff arrays.
     *
     * This test verifies that the diffKey() method correctly computes
     * the difference of arrays with three diff arrays for key comparison,
     * ignoring values, mirroring PHP's array_diff_key() function.
     *
     *
     * Тестирование метода diffKey() с тремя массивами для сравнения.
     *
     * Этот тест проверяет, что метод diffKey() корректно вычисляет
     * расхождение массивов с тремя массивами для сравнения ключей,
     * игнорируя значения, отражая функцию array_diff_key() PHP.
     *
     * @see CoverArray::diffKey()
     * @see array_diff_key()
     */
    public function testDiffKeyWithThreeDiffArrays(): void
    {
        // Test with three diff arrays
        // Тест с тремя массивами для сравнения
        $data = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5, 'f' => 6];
        $diff1 = ['a' => 10, 'c' => 30];
        $diff2 = ['b' => 20, 'd' => 40];
        $diff3 = ['e' => 50];

        $expected = array_diff_key($data, $diff1, $diff2, $diff3);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffKey($diff1, $diff2, $diff3)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffKey(
                new CoverArray($diff1),
                new CoverArray($diff2),
                new CoverArray($diff3)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the diffKey() method with numeric string keys vs integer keys.
     *
     * This test verifies that the diffKey() method correctly distinguishes
     * between numeric string keys and integer keys, as they are different
     * in PHP, mirroring PHP's array_diff_key() function.
     *
     *
     * Тестирование метода diffKey() с числовыми строковыми ключами против целочисленных ключей.
     *
     * Этот тест проверяет, что метод diffKey() корректно различает
     * числовые строковые ключи и целочисленные ключи, так как они разные
     * в PHP, отражая функцию array_diff_key() PHP.
     *
     * @see CoverArray::diffKey()
     * @see array_diff_key()
     */
    public function testDiffKeyWithNumericStringVsIntegerKeys(): void
    {
        // Test with numeric string keys vs integer keys
        // Тест с числовыми строковыми ключами против целочисленных ключей
        $data = [1 => 'integer one', '1' => 'string one', 2 => 'integer two', '2' => 'string two'];
        $diff = [1 => 'diff integer one', '2' => 'diff string two'];

        $expected = array_diff_key($data, $diff);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffKey($diff)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffKey(new CoverArray($diff))->getDataAsArray()
        );
    }
}