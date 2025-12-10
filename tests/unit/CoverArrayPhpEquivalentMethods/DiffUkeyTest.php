<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class DiffUkeyTest extends TestCase
{
    /**
     * Standard comparison callback function.
     * Стандартная callback-функция сравнения.
     */
    private function getStandardCallback(): callable
    {
        return function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            return $a <=> $b;
        };
    }

    /**
     * Tests the diffUkey() method with string keys using standard callback.
     *
     * This test verifies that the diffUkey() method correctly computes
     * the difference of arrays with string keys using a user-defined
     * callback function for key comparison, mirroring PHP's array_diff_ukey().
     *
     *
     * Тестирование метода diffUkey() со строковыми ключами с использованием стандартного callback.
     *
     * Этот тест проверяет, что метод diffUkey() корректно вычисляет
     * расхождение массивов со строковыми ключами с использованием
     * пользовательской callback-функции для сравнения ключей, отражая array_diff_ukey() PHP.
     *
     * @see CoverArray::diffUkey()
     * @see array_diff_ukey()
     */
    public function testDiffUkeyWithStringKeys(): void
    {
        $callback = $this->getStandardCallback();

        // Test with string keys using callback
        // Тест со строковыми ключами с использованием callback
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $diff = ['a' => 100, 'b' => 200];

        $expected = array_diff_ukey($data, $diff, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffUkey($callback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffUkey($callback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the diffUkey() method with numeric keys using standard callback.
     *
     * This test verifies that the diffUkey() method correctly computes
     * the difference of arrays with numeric keys using a user-defined
     * callback function for key comparison, mirroring PHP's array_diff_ukey().
     *
     *
     * Тестирование метода diffUkey() с числовыми ключами с использованием стандартного callback.
     *
     * Этот тест проверяет, что метод diffUkey() корректно вычисляет
     * расхождение массивов с числовыми ключами с использованием
     * пользовательской callback-функции для сравнения ключей, отражая array_diff_ukey() PHP.
     *
     * @see CoverArray::diffUkey()
     * @see array_diff_ukey()
     */
    public function testDiffUkeyWithNumericKeys(): void
    {
        $callback = $this->getStandardCallback();

        // Test with numeric keys using callback
        // Тест с числовыми ключами с использованием callback
        $data = [0 => 'zero', 1 => 'one', 2 => 'two'];
        $diff = [0 => 'ZERO', 1 => 'ONE'];

        $expected = array_diff_ukey($data, $diff, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffUkey($callback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffUkey($callback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the diffUkey() method with multiple diff arrays.
     *
     * This test verifies that the diffUkey() method correctly computes
     * the difference of arrays with multiple diff arrays using a user-defined
     * callback function for key comparison, mirroring PHP's array_diff_ukey().
     *
     *
     * Тестирование метода diffUkey() с несколькими массивами для сравнения.
     *
     * Этот тест проверяет, что метод diffUkey() корректно вычисляет
     * расхождение массивов с несколькими массивами для сравнения с использованием
     * пользовательской callback-функции для сравнения ключей, отражая array_diff_ukey() PHP.
     *
     * @see CoverArray::diffUkey()
     * @see array_diff_ukey()
     */
    public function testDiffUkeyWithMultipleDiffArrays(): void
    {
        $callback = $this->getStandardCallback();

        // Test with multiple diff arrays
        // Тест с несколькими массивами для сравнения
        $data = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $diff1 = ['a' => 10, 'b' => 20];
        $diff2 = ['c' => 30, 'd' => 40];

        $expected = array_diff_ukey($data, $diff1, $diff2, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffUkey($callback, $diff1, $diff2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffUkey(
                $callback,
                new CoverArray($diff1),
                new CoverArray($diff2)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the diffUkey() method with case-insensitive comparison callback.
     *
     * This test verifies that the diffUkey() method correctly computes
     * the difference of arrays using a case-insensitive callback function
     * for key comparison, mirroring PHP's array_diff_ukey().
     *
     *
     * Тестирование метода diffUkey() с callback для сравнения без учета регистра.
     *
     * Этот тест проверяет, что метод diffUkey() корректно вычисляет
     * расхождение массивов с использованием callback-функции без учета регистра
     * для сравнения ключей, отражая array_diff_ukey() PHP.
     *
     * @see CoverArray::diffUkey()
     * @see array_diff_ukey()
     */
    public function testDiffUkeyWithCaseInsensitiveCallback(): void
    {
        // Test with case-insensitive comparison callback
        // Тест с callback для сравнения без учета регистра
        $caseInsensitiveCallback = function ($a, $b) {
            return strcasecmp((string) $a, (string) $b);
        };

        $data = ['A' => 'apple', 'B' => 'banana', 'c' => 'cherry'];
        $diff = ['a' => 'apricot', 'b' => 'blueberry'];

        $expected = array_diff_ukey($data, $diff, $caseInsensitiveCallback);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffUkey($caseInsensitiveCallback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffUkey($caseInsensitiveCallback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the diffUkey() method with custom key comparison logic.
     *
     * This test verifies that the diffUkey() method correctly computes
     * the difference of arrays using custom key comparison logic
     * (comparing by key length), mirroring PHP's array_diff_ukey().
     *
     *
     * Тестирование метода diffUkey() с пользовательской логикой сравнения ключей.
     *
     * Этот тест проверяет, что метод diffUkey() корректно вычисляет
     * расхождение массивов с использованием пользовательской логики сравнения ключей
     * (сравнение по длине ключа), отражая array_diff_ukey() PHP.
     *
     * @see CoverArray::diffUkey()
     * @see array_diff_ukey()
     */
    public function testDiffUkeyWithCustomKeyComparisonLogic(): void
    {
        // Test with custom key comparison logic (comparing string lengths of keys)
        // Тест с пользовательской логикой сравнения ключей (сравнение длины строк ключей)
        $customCallback = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            // Приводим к строке и сравниваем длину
            $lenA = strlen((string) $a);
            $lenB = strlen((string) $b);

            if ($lenA === $lenB) {
                return strcmp((string) $a, (string) $b);
            }
            return $lenA <=> $lenB;
        };

        $data = ['aa' => 1, 'b' => 2, 'ccc' => 3];
        $diff = ['aa' => 10, 'ccc' => 30];

        $expected = array_diff_ukey($data, $diff, $customCallback);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffUkey($customCallback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffUkey($customCallback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the diffUkey() method with empty diff array.
     *
     * This test verifies that the diffUkey() method correctly handles
     * empty diff arrays, returning the entire original array,
     * mirroring PHP's array_diff_ukey() function.
     *
     *
     * Тестирование метода diffUkey() с пустым массивом для сравнения.
     *
     * Этот тест проверяет, что метод diffUkey() корректно обрабатывает
     * пустые массивы для сравнения, возвращая весь исходный массив,
     * отражая функцию array_diff_ukey() PHP.
     *
     * @see CoverArray::diffUkey()
     * @see array_diff_ukey()
     */
    public function testDiffUkeyWithEmptyDiffArray(): void
    {
        $callback = $this->getStandardCallback();

        // Test with empty diff array
        // Тест с пустым массивом для сравнения
        $data = ['x' => 10, 'y' => 20];
        $diff = [];

        $expected = array_diff_ukey($data, $diff, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffUkey($callback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffUkey($callback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the diffUkey() method where all keys are removed.
     *
     * This test verifies that the diffUkey() method correctly returns
     * an empty array when all keys are present in the diff array,
     * mirroring PHP's array_diff_ukey() function.
     *
     *
     * Тестирование метода diffUkey(), когда все ключи удаляются.
     *
     * Этот тест проверяет, что метод diffUkey() корректно возвращает
     * пустой массив, когда все ключи присутствуют в массиве сравнения,
     * отражая функцию array_diff_ukey() PHP.
     *
     * @see CoverArray::diffUkey()
     * @see array_diff_ukey()
     */
    public function testDiffUkeyWithAllKeysRemoved(): void
    {
        $callback = $this->getStandardCallback();

        // Test where all keys are removed
        // Тест, где все ключи удаляются
        $data = ['a' => 1, 'b' => 2];
        $diff = ['a' => 100, 'b' => 200];

        $expected = array_diff_ukey($data, $diff, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffUkey($callback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffUkey($callback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the diffUkey() method with mixed key types.
     *
     * This test verifies that the diffUkey() method correctly computes
     * the difference of arrays with mixed key types (strings, integers, numeric strings)
     * using a user-defined callback function for key comparison,
     * mirroring PHP's array_diff_ukey().
     *
     *
     * Тестирование метода diffUkey() со смешанными типами ключей.
     *
     * Этот тест проверяет, что метод diffUkey() корректно вычисляет
     * расхождение массивов со смешанными типами ключей (строки, целые числа, числовые строки)
     * с использованием пользовательской callback-функции для сравнения ключей,
     * отражая array_diff_ukey() PHP.
     *
     * @see CoverArray::diffUkey()
     * @see array_diff_ukey()
     */
    public function testDiffUkeyWithMixedKeyTypes(): void
    {
        $callback = $this->getStandardCallback();

        // Test with mixed key types
        // Тест со смешанными типами ключей
        $data = ['a' => 1, 0 => 'zero', '1' => 'one', 2 => 'two'];
        $diff = ['a' => 10, 0 => 'ZERO', '1' => 'ONE'];

        $expected = array_diff_ukey($data, $diff, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diffUkey($callback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diffUkey($callback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the diffUkey() method with three diff arrays of mixed argument types.
     *
     * This test verifies that the diffUkey() method correctly computes
     * the difference of arrays with three diff arrays of mixed argument types
     * (array and CoverArray) using a user-defined callback function for key comparison,
     * mirroring PHP's array_diff_ukey().
     *
     *
     * Тестирование метода diffUkey() с тремя массивами для сравнения смешанных типов аргументов.
     *
     * Этот тест проверяет, что метод diffUkey() корректно вычисляет
     * расхождение массивов с тремя массивами для сравнения смешанных типов аргументов
     * (массив и CoverArray) с использованием пользовательской callback-функции для сравнения ключей,
     * отражая array_diff_ukey() PHP.
     *
     * @see CoverArray::diffUkey()
     * @see array_diff_ukey()
     */
    public function testDiffUkeyWithThreeDiffArraysMixedTypes(): void
    {
        $callback = $this->getStandardCallback();

        // Test with three diff arrays of mixed types
        // Тест с тремя массивами для сравнения смешанных типов
        $data = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5];
        $diff1 = ['a' => 10];
        $diff2 = new CoverArray(['b' => 20, 'c' => 30]);
        $diff3 = ['d' => 40];

        $expected = array_diff_ukey($data, ['a' => 10], ['b' => 20, 'c' => 30], ['d' => 40], $callback);

        $cover = new CoverArray($data);

        $result = $cover->diffUkey($callback, $diff1, $diff2, $diff3);
        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the diffUkey() method with three diff arrays all as CoverArray objects.
     *
     * This test verifies that the diffUkey() method correctly computes
     * the difference of arrays with three diff arrays all as CoverArray objects,
     * using a user-defined callback function for key comparison,
     * mirroring PHP's array_diff_ukey().
     *
     *
     * Тестирование метода diffUkey() с тремя массивами для сравнения, все как объекты CoverArray.
     *
     * Этот тест проверяет, что метод diffUkey() корректно вычисляет
     * расхождение массивов с тремя массивами для сравнения, все как объекты CoverArray,
     * с использованием пользовательской callback-функции для сравнения ключей,
     * отражая array_diff_ukey() PHP.
     *
     * @see CoverArray::diffUkey()
     * @see array_diff_ukey()
     */
    public function testDiffUkeyWithThreeDiffArraysAllCoverArray(): void
    {
        $callback = $this->getStandardCallback();

        // Test with three diff arrays, all as CoverArray
        // Тест с тремя массивами для сравнения, все как CoverArray
        $data = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5, 'f' => 6];
        $diff1 = ['a' => 10, 'b' => 20];
        $diff2 = ['c' => 30, 'd' => 40];
        $diff3 = ['e' => 50];

        $expected = array_diff_ukey($data, $diff1, $diff2, $diff3, $callback);

        $cover = new CoverArray($data);

        $result = $cover->diffUkey(
            $callback,
            new CoverArray($diff1),
            new CoverArray($diff2),
            new CoverArray($diff3)
        );
        $this->assertSame($expected, $result->getDataAsArray());
    }
}