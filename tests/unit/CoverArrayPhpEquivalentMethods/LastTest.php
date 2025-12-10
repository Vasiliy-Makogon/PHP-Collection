<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class LastTest extends TestCase
{
    /**
     * Helper method to assert last() behavior with both approaches.
     *
     * Вспомогательный метод для проверки поведения last() двумя подходами.
     */
    private function assertLastCase(array $data, mixed $expected): void
    {
        $cover = new CoverArray($data);
        $result = $cover->last();

        if (function_exists('array_last')) {
            $nativeResult = array_last($data);
            $this->assertSame(
                $nativeResult,
                $result,
                "CoverArray::last() should match array_last() for data: " . var_export($data, true)
            );
        } else {
            $this->assertSame(
                $expected,
                $result,
                "CoverArray::last() returned unexpected result for data: " . var_export($data, true)
            );
        }
    }

    /**
     * Tests the last() method with sequential numeric array.
     *
     * This test verifies that the last() method correctly returns
     * the last element of a sequential numeric array.
     *
     *
     * Тестирование метода last() с последовательным числовым массивом.
     *
     * Этот тест проверяет, что метод last() корректно возвращает
     * последний элемент последовательного числового массива.
     *
     * @see CoverArray::last()
     */
    public function testLastWithSequentialNumericArray(): void
    {
        $data = ['PHP', 'MySql'];
        $this->assertLastCase($data, 'MySql');
    }

    /**
     * Tests the last() method with associative array.
     *
     * This test verifies that the last() method correctly returns
     * the last element of an associative array.
     *
     *
     * Тестирование метода last() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод last() корректно возвращает
     * последний элемент ассоциативного массива.
     *
     * @see CoverArray::last()
     */
    public function testLastWithAssociativeArray(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $this->assertLastCase($data, 'cherry');
    }

    /**
     * Tests the last() method with empty array.
     *
     * This test verifies that the last() method correctly returns
     * null for empty arrays.
     *
     *
     * Тестирование метода last() с пустым массивом.
     *
     * Этот тест проверяет, что метод last() корректно возвращает
     * null для пустых массивов.
     *
     * @see CoverArray::last()
     */
    public function testLastWithEmptyArray(): void
    {
        $data = [];
        $this->assertLastCase($data, null);
    }

    /**
     * Tests the last() method with single element array.
     *
     * This test verifies that the last() method correctly returns
     * the single element when the array contains only one element.
     *
     *
     * Тестирование метода last() с массивом из одного элемента.
     *
     * Этот тест проверяет, что метод last() корректно возвращает
     * единственный элемент, когда массив содержит только один элемент.
     *
     * @see CoverArray::last()
     */
    public function testLastWithSingleElementArray(): void
    {
        $data = ['single' => 'element'];
        $this->assertLastCase($data, 'element');
    }

    /**
     * Tests the last() method with mixed key types.
     *
     * This test verifies that the last() method correctly handles
     * arrays with mixed key types and returns the last element.
     *
     *
     * Тестирование метода last() со смешанными типами ключей.
     *
     * Этот тест проверяет, что метод last() корректно обрабатывает
     * массивы со смешанными типами ключей и возвращает последний элемент.
     *
     * @see CoverArray::last()
     */
    public function testLastWithMixedKeyTypes(): void
    {
        $data = [0 => 'zero', 'a' => 'apple', 1 => 'one'];
        $this->assertLastCase($data, 'one');
    }

    /**
     * Tests the last() method with numeric keys not starting from 0.
     *
     * This test verifies that the last() method correctly returns
     * the last element when numeric keys don't start from 0.
     *
     *
     * Тестирование метода last() с числовыми ключами, не начинающимися с 0.
     *
     * Этот тест проверяет, что метод last() корректно возвращает
     * последний элемент, когда числовые ключи не начинаются с 0.
     *
     * @see CoverArray::last()
     */
    public function testLastWithNumericKeysNotStartingFromZero(): void
    {
        $data = [5 => 'five', 10 => 'ten', 15 => 'fifteen'];
        $this->assertLastCase($data, 'fifteen');
    }

    /**
     * Tests the last() method with null value as last element.
     *
     * This test verifies that the last() method correctly returns
     * null when the last element is null.
     *
     *
     * Тестирование метода last() с null значением в качестве последнего элемента.
     *
     * Этот тест проверяет, что метод last() корректно возвращает
     * null, когда последний элемент равен null.
     *
     * @see CoverArray::last()
     */
    public function testLastWithNullValueAsLastElement(): void
    {
        $data = ['a' => 1, 'b' => null];
        $this->assertLastCase($data, null);
    }

    /**
     * Tests the last() method with false value as last element.
     *
     * This test verifies that the last() method correctly returns
     * false when the last element is false.
     *
     *
     * Тестирование метода last() со значением false в качестве последнего элемента.
     *
     * Этот тест проверяет, что метод last() корректно возвращает
     * false, когда последний элемент равен false.
     *
     * @see CoverArray::last()
     */
    public function testLastWithFalseValueAsLastElement(): void
    {
        $data = ['a' => true, 'b' => false];
        $this->assertLastCase($data, false);
    }

    /**
     * Tests the last() method with zero value as last element.
     *
     * This test verifies that the last() method correctly returns
     * zero when the last element is 0.
     *
     *
     * Тестирование метода last() с нулевым значением в качестве последнего элемента.
     *
     * Этот тест проверяет, что метод last() корректно возвращает
     * 0, когда последний элемент равен 0.
     *
     * @see CoverArray::last()
     */
    public function testLastWithZeroValueAsLastElement(): void
    {
        $data = ['a' => 1, 'b' => 0];
        $this->assertLastCase($data, 0);
    }

    /**
     * Tests the last() method with empty string as last element.
     *
     * This test verifies that the last() method correctly returns
     * empty string when the last element is an empty string.
     *
     *
     * Тестирование метода last() с пустой строкой в качестве последнего элемента.
     *
     * Этот тест проверяет, что метод last() корректно возвращает
     * пустую строку, когда последний элемент является пустой строкой.
     *
     * @see CoverArray::last()
     */
    public function testLastWithEmptyStringAsLastElement(): void
    {
        $data = ['a' => 'not empty', 'b' => ''];
        $this->assertLastCase($data, '');
    }

    /**
     * Tests that last() method returns same result on multiple calls.
     *
     * This test verifies that the last() method doesn't affect
     * the internal array pointer and returns the same result
     * on multiple calls.
     *
     *
     * Тестирование, что метод last() возвращает одинаковый результат при нескольких вызовах.
     *
     * Этот тест проверяет, что метод last() не затрагивает
     * внутренний указатель массива и возвращает одинаковый результат
     * при нескольких вызовах.
     *
     * @see CoverArray::last()
     */
    public function testLastReturnsSameResultOnMultipleCalls(): void
    {
        $data = ['first', 'second', 'third'];
        $cover = new CoverArray($data);

        $this->assertSame('third', $cover->last());
        $this->assertSame('third', $cover->last()); // Второй вызов должен вернуть тот же результат
        $this->assertSame('third', $cover->last()); // Третий вызов должен вернуть тот же результат
    }
}