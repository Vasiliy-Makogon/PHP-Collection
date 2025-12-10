<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class IsListTest extends TestCase
{
    /**
     * Helper method to assert isList behavior with both approaches.
     *
     * Вспомогательный метод для проверки поведения isList двумя подходами.
     */
    private function assertIsListCase(array $data, bool $expected): void
    {
        $cover = new CoverArray($data);
        $result = $cover->isList();

        if (function_exists('array_is_list')) {
            $nativeResult = array_is_list($data);
            $this->assertSame(
                $nativeResult,
                $result,
                "CoverArray::isList() should match array_is_list() for data: " . var_export($data, true)
            );
        } else {
            $this->assertSame(
                $expected,
                $result,
                "CoverArray::isList() returned unexpected result for data: " . var_export($data, true)
            );
        }
    }

    /**
     * Tests the isList() method with empty array.
     *
     * This test verifies that the isList() method correctly returns true
     * for empty arrays, as empty arrays are considered lists.
     *
     *
     * Тестирование метода isList() с пустым массивом.
     *
     * Этот тест проверяет, что метод isList() корректно возвращает true
     * для пустых массивов, так как пустые массивы считаются списками.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListWithEmptyArray(): void
    {
        $this->assertIsListCase([], true);
    }

    /**
     * Tests the isList() method with simple sequential array.
     *
     * This test verifies that the isList() method correctly returns true
     * for arrays with sequential integer keys starting from 0.
     *
     *
     * Тестирование метода isList() с простым последовательным массивом.
     *
     * Этот тест проверяет, что метод isList() корректно возвращает true
     * для массивов с последовательными целочисленными ключами, начиная с 0.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListWithSimpleSequentialArray(): void
    {
        $this->assertIsListCase([1, 2, 3], true);
    }

    /**
     * Tests the isList() method with explicitly indexed sequential array.
     *
     * This test verifies that the isList() method correctly returns true
     * for arrays with explicitly declared sequential integer keys.
     *
     *
     * Тестирование метода isList() с явно проиндексированным последовательным массивом.
     *
     * Этот тест проверяет, что метод isList() корректно возвращает true
     * для массивов с явно объявленными последовательными целочисленными ключами.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListWithExplicitlyIndexedSequentialArray(): void
    {
        $this->assertIsListCase([0 => 'a', 1 => 'b', 2 => 'c'], true);
    }

    /**
     * Tests the isList() method with missing keys (gap in sequence).
     *
     * This test verifies that the isList() method correctly returns false
     * for arrays with missing keys in the sequence.
     *
     *
     * Тестирование метода isList() с пропущенными ключами (пропуск в последовательности).
     *
     * Этот тест проверяет, что метод isList() корректно возвращает false
     * для массивов с пропущенными ключами в последовательности.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListWithMissingKeys(): void
    {
        $this->assertIsListCase([0 => 'a', 2 => 'b', 3 => 'c'], false);
    }

    /**
     * Tests the isList() method with wrong starting index.
     *
     * This test verifies that the isList() method correctly returns false
     * for arrays that don't start with index 0.
     *
     *
     * Тестирование метода isList() с неправильным начальным индексом.
     *
     * Этот тест проверяет, что метод isList() корректно возвращает false
     * для массивов, которые не начинаются с индекса 0.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListWithWrongStartingIndex(): void
    {
        $this->assertIsListCase([1 => 'a', 2 => 'b', 3 => 'c'], false);
    }

    /**
     * Tests the isList() method with string numeric keys.
     *
     * This test verifies that the isList() method correctly returns true
     * for arrays with string keys that represent sequential integers.
     *
     *
     * Тестирование метода isList() со строковыми числовыми ключами.
     *
     * Этот тест проверяет, что метод isList() корректно возвращает true
     * для массивов со строковыми ключами, представляющими последовательные целые числа.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListWithStringNumericKeys(): void
    {
        $this->assertIsListCase(['0' => 'a', '1' => 'b', '2' => 'c'], true);
    }

    /**
     * Tests the isList() method with wrong starting string numeric key.
     *
     * This test verifies that the isList() method correctly returns false
     * for arrays with string numeric keys that don't start at '0'.
     *
     *
     * Тестирование метода isList() с неправильным начальным строковым числовым ключом.
     *
     * Этот тест проверяет, что метод isList() корректно возвращает false
     * для массивов со строковыми числовыми ключами, которые не начинаются с '0'.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListWithWrongStartingStringNumericKey(): void
    {
        $this->assertIsListCase(['1' => 'a', '2' => 'b', '3' => 'c'], false);
    }

    /**
     * Tests the isList() method with string keys containing leading zeros.
     *
     * This test verifies that the isList() method correctly returns false
     * for arrays with string keys containing leading zeros.
     *
     *
     * Тестирование метода isList() со строковыми ключами, содержащими ведущие нули.
     *
     * Этот тест проверяет, что метод isList() корректно возвращает false
     * для массивов со строковыми ключами, содержащими ведущие нули.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListWithStringKeysWithLeadingZeros(): void
    {
        $this->assertIsListCase(['00' => 'a', '01' => 'b', '02' => 'c'], false);
    }

    /**
     * Tests the isList() method with mixed integer and string numeric keys.
     *
     * This test verifies that the isList() method correctly returns true
     * for arrays with mixed integer and string numeric keys in sequence.
     *
     *
     * Тестирование метода isList() со смешанными целочисленными и строковыми числовыми ключами.
     *
     * Этот тест проверяет, что метод isList() корректно возвращает true
     * для массивов со смешанными целочисленными и строковыми числовыми ключами в последовательности.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListWithMixedIntegerAndStringNumericKeys(): void
    {
        $this->assertIsListCase(['0' => 'a', 1 => 'b', '2' => 'c'], true);
    }

    /**
     * Tests the isList() method with associative array.
     *
     * This test verifies that the isList() method correctly returns false
     * for associative arrays with string keys.
     *
     *
     * Тестирование метода isList() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод isList() корректно возвращает false
     * для ассоциативных массивов со строковыми ключами.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListWithAssociativeArray(): void
    {
        $this->assertIsListCase(['a' => 1, 'b' => 2, 'c' => 3], false);
    }

    /**
     * Tests the isList() method with single element list.
     *
     * This test verifies that the isList() method correctly returns true
     * for arrays with a single element at index 0.
     *
     *
     * Тестирование метода isList() со списком из одного элемента.
     *
     * Этот тест проверяет, что метод isList() корректно возвращает true
     * для массивов с одним элементом по индексу 0.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListWithSingleElementList(): void
    {
        $this->assertIsListCase([0 => 'a'], true);
    }

    /**
     * Tests the isList() method with single element at wrong index.
     *
     * This test verifies that the isList() method correctly returns false
     * for arrays with a single element not at index 0.
     *
     *
     * Тестирование метода isList() с одним элементом по неправильному индексу.
     *
     * Этот тест проверяет, что метод isList() корректно возвращает false
     * для массивов с одним элементом не по индексу 0.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListWithSingleElementAtWrongIndex(): void
    {
        $this->assertIsListCase([1 => 'a'], false);
    }

    /**
     * Tests the isList() method with large range.
     *
     * This test verifies that the isList() method correctly returns true
     * for large arrays with sequential keys.
     *
     *
     * Тестирование метода isList() с большим диапазоном.
     *
     * Этот тест проверяет, что метод isList() корректно возвращает true
     * для больших массивов с последовательными ключами.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListWithLargeRange(): void
    {
        $this->assertIsListCase(range(0, 100), true);
    }

    /**
     * Tests the isList() method with array_fill starting from 0.
     *
     * This test verifies that the isList() method correctly returns true
     * for arrays created with array_fill starting from index 0.
     *
     *
     * Тестирование метода isList() с array_fill, начиная с 0.
     *
     * Этот тест проверяет, что метод isList() корректно возвращает true
     * для массивов, созданных с помощью array_fill, начиная с индекса 0.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListWithArrayFillStartingFromZero(): void
    {
        $this->assertIsListCase(array_fill(0, 100, 'value'), true);
    }

    /**
     * Tests the isList() method with array_fill starting from non-zero.
     *
     * This test verifies that the isList() method correctly returns false
     * for arrays created with array_fill starting from a non-zero index.
     *
     *
     * Тестирование метода isList() с array_fill, начиная не с нуля.
     *
     * Этот тест проверяет, что метод isList() корректно возвращает false
     * для массивов, созданных с помощью array_fill, начиная не с нулевого индекса.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListWithArrayFillStartingFromNonZero(): void
    {
        $this->assertIsListCase(array_fill(5, 10, 'value'), false);
    }

    /**
     * Tests the isList() method with negative keys.
     *
     * This test verifies that the isList() method correctly returns false
     * for arrays containing negative keys.
     *
     *
     * Тестирование метода isList() с отрицательными ключами.
     *
     * Этот тест проверяет, что метод isList() корректно возвращает false
     * для массивов, содержащих отрицательные ключи.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListWithNegativeKeys(): void
    {
        $this->assertIsListCase([-1 => 'a', 0 => 'b', 1 => 'c'], false);
    }

    /**
     * Tests the isList() method with float numeric keys.
     *
     * This test verifies that the isList() method correctly returns true
     * for arrays with float keys that represent sequential integers.
     *
     *
     * Тестирование метода isList() с числовыми ключами с плавающей точкой.
     *
     * Этот тест проверяет, что метод isList() корректно возвращает true
     * для массивов с ключами с плавающей точкой, представляющими последовательные целые числа.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListWithFloatNumericKeys(): void
    {
        $this->assertIsListCase([0.0 => 'a', 1.0 => 'b', 2.0 => 'c'], true);
    }

    /**
     * Tests the isList() method with boolean keys.
     *
     * This test verifies that the isList() method correctly returns false
     * for arrays with boolean keys.
     *
     *
     * Тестирование метода isList() с булевыми ключами.
     *
     * Этот тест проверяет, что метод isList() корректно возвращает false
     * для массивов с булевыми ключами.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListWithBooleanKeys(): void
    {
        $this->assertIsListCase([true => 'a', false => 'b'], false);
    }

    /**
     * Tests the isList() method with null key.
     *
     * This test verifies that the isList() method correctly returns false
     * for arrays containing a null key.
     *
     *
     * Тестирование метода isList() с ключом null.
     *
     * Этот тест проверяет, что метод isList() корректно возвращает false
     * для массивов, содержащих ключ null.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListWithNullKey(): void
    {
        $this->assertIsListCase([null => 'a', 1 => 'b'], false);
    }

    /**
     * Tests the isList() method with mixed associative and numeric keys.
     *
     * This test verifies that the isList() method correctly returns false
     * for arrays containing both associative and numeric keys.
     *
     *
     * Тестирование метода isList() со смешанными ассоциативными и числовыми ключами.
     *
     * Этот тест проверяет, что метод isList() корректно возвращает false
     * для массивов, содержащих как ассоциативные, так и числовые ключи.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListWithMixedAssociativeAndNumericKeys(): void
    {
        $this->assertIsListCase([0 => 'a', 'foo' => 'b', 2 => 'c'], false);
    }

    /**
     * Tests the isList() method with nested arrays.
     *
     * This test verifies that the isList() method correctly returns true
     * for arrays containing nested arrays but with proper sequential keys.
     *
     *
     * Тестирование метода isList() с вложенными массивами.
     *
     * Этот тест проверяет, что метод isList() корректно возвращает true
     * для массивов, содержащих вложенные массивы, но с правильными последовательными ключами.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListWithNestedArrays(): void
    {
        $this->assertIsListCase([0 => [1, 2], 1 => ['a' => 'b']], true);
    }

    /**
     * Tests the isList() method with string keys with spaces.
     *
     * This test verifies that the isList() method correctly returns false
     * for arrays with string keys containing spaces.
     *
     *
     * Тестирование метода isList() со строковыми ключами с пробелами.
     *
     * Этот тест проверяет, что метод isList() корректно возвращает false
     * для массивов со строковыми ключами, содержащими пробелы.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListWithStringKeysWithSpaces(): void
    {
        $this->assertIsListCase([' 0' => 'a', '1 ' => 'b', ' 2 ' => 'c'], false);
    }
}