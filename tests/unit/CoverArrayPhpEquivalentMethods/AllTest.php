<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class AllTest extends TestCase
{
    /**
     * Tests the all() method with all elements satisfying condition.
     *
     * This test verifies that the all() method returns true when
     * all elements in the array satisfy the callback condition.
     *
     *
     * Тестирование метода all(), когда все элементы удовлетворяют условию.
     *
     * Этот тест проверяет, что метод all() возвращает true, когда
     * все элементы массива удовлетворяют условию callback-функции.
     *
     * @see CoverArray::all()
     */
    public function testAllWithAllElementsSatisfyingCondition(): void
    {
        // Test with array where all elements satisfy condition
        // Тест с массивом, где все элементы удовлетворяют условию
        $data = [2, 4, 6, 8, 10];
        $cover = new CoverArray($data);

        $result = $cover->all(function ($value, $key) {
            return $value % 2 === 0; // все числа четные
        });

        $this->assertTrue($result);
    }

    /**
     * Tests the all() method with not all elements satisfying condition.
     *
     * This test verifies that the all() method returns false when
     * at least one element in the array does not satisfy the callback condition.
     *
     *
     * Тестирование метода all(), когда не все элементы удовлетворяют условию.
     *
     * Этот тест проверяет, что метод all() возвращает false, когда
     * хотя бы один элемент массива не удовлетворяет условию callback-функции.
     *
     * @see CoverArray::all()
     */
    public function testAllWithNotAllElementsSatisfyingCondition(): void
    {
        // Test with array where not all elements satisfy condition
        // Тест с массивом, где не все элементы удовлетворяют условию
        $data = [2, 4, 5, 8, 10];
        $cover = new CoverArray($data);

        $result = $cover->all(function ($value, $key) {
            return $value % 2 === 0; // 5 не четное
        });

        $this->assertFalse($result);
    }

    /**
     * Tests the all() method with array of strings where all satisfy condition.
     *
     * This test verifies that the all() method correctly handles
     * arrays of strings and returns true when all strings satisfy
     * the callback condition.
     *
     *
     * Тестирование метода all() с массивом строк, где все удовлетворяют условию.
     *
     * Этот тест проверяет, что метод all() корректно обрабатывает
     * массивы строк и возвращает true, когда все строки удовлетворяют
     * условию callback-функции.
     *
     * @see CoverArray::all()
     */
    public function testAllWithArrayOfStringsAllSatisfying(): void
    {
        // Test with array of strings where all satisfy condition
        // Тест с массивом строк, где все удовлетворяют условию
        $data = ['apple', 'apricot', 'avocado'];
        $cover = new CoverArray($data);

        $result = $cover->all(function ($value, $key) {
            return str_starts_with($value, 'a');
        });

        $this->assertTrue($result);
    }

    /**
     * Tests the all() method with array of strings where not all satisfy condition.
     *
     * This test verifies that the all() method correctly handles
     * arrays of strings and returns false when not all strings
     * satisfy the callback condition.
     *
     *
     * Тестирование метода all() с массивом строк, где не все удовлетворяют условию.
     *
     * Этот тест проверяет, что метод all() корректно обрабатывает
     * массивы строк и возвращает false, когда не все строки удовлетворяют
     * условию callback-функции.
     *
     * @see CoverArray::all()
     */
    public function testAllWithArrayOfStringsNotAllSatisfying(): void
    {
        // Test with array of strings where not all satisfy condition
        // Тест с массивом строк, где не все удовлетворяют условию
        $data = ['apple', 'banana', 'apricot'];
        $cover = new CoverArray($data);

        $result = $cover->all(function ($value, $key) {
            return str_starts_with($value, 'a');
        });

        $this->assertFalse($result);
    }

    /**
     * Tests the all() method with associative array where all satisfy condition.
     *
     * This test verifies that the all() method correctly handles
     * associative arrays and returns true when all key-value pairs
     * satisfy the callback condition.
     *
     *
     * Тестирование метода all() с ассоциативным массивом, где все удовлетворяют условию.
     *
     * Этот тест проверяет, что метод all() корректно обрабатывает
     * ассоциативные массивы и возвращает true, когда все пары ключ-значение
     * удовлетворяют условию callback-функции.
     *
     * @see CoverArray::all()
     */
    public function testAllWithAssociativeArrayAllSatisfying(): void
    {
        // Test with associative array where all satisfy condition
        // Тест с ассоциативным массивом, где все удовлетворяют условию
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $cover = new CoverArray($data);

        $result = $cover->all(function ($value, $key) {
            return is_string($key) && is_int($value);
        });

        $this->assertTrue($result);
    }

    /**
     * Tests the all() method with empty array.
     *
     * This test verifies that the all() method returns true for
     * empty arrays, as there are no elements that could fail
     * the callback condition.
     *
     *
     * Тестирование метода all() с пустым массивом.
     *
     * Этот тест проверяет, что метод all() возвращает true для
     * пустых массивов, так как нет элементов, которые могли бы
     * не удовлетворить условию callback-функции.
     *
     * @see CoverArray::all()
     */
    public function testAllWithEmptyArray(): void
    {
        // Test with empty array (should return true)
        // Тест с пустым массивом (должен вернуть true)
        $data = [];
        $cover = new CoverArray($data);

        $result = $cover->all(function ($value, $key) {
            return $value > 10; // для пустого массива всегда true
        });

        $this->assertTrue($result);
    }

    /**
     * Tests the all() method with callback checking both value and key.
     *
     * This test verifies that the all() method correctly passes
     * both value and key to the callback function and returns true
     * when all key-value pairs satisfy the condition.
     *
     *
     * Тестирование метода all() с callback, проверяющим и значение, и ключ.
     *
     * Этот тест проверяет, что метод all() корректно передает
     * и значение, и ключ в callback-функцию и возвращает true,
     * когда все пары ключ-значение удовлетворяют условию.
     *
     * @see CoverArray::all()
     */
    public function testAllWithCallbackCheckingValueAndKey(): void
    {
        // Test with callback that checks both value and key
        // Тест с callback, который проверяет и значение, и ключ
        $data = [0 => 'zero', 1 => 'one', 2 => 'two'];
        $cover = new CoverArray($data);

        $result = $cover->all(function ($value, $key) {
            return is_int($key) && is_string($value);
        });

        $this->assertTrue($result);
    }

    /**
     * Tests the all() method with mixed types in array.
     *
     * This test verifies that the all() method correctly handles
     * arrays with mixed types and returns false when not all elements
     * satisfy the type condition.
     *
     *
     * Тестирование метода all() с массивами смешанных типов.
     *
     * Этот тест проверяет, что метод all() корректно обрабатывает
     * массивы со смешанными типами и возвращает false, когда не все
     * элементы удовлетворяют условию по типу.
     *
     * @see CoverArray::all()
     */
    public function testAllWithMixedTypesInArray(): void
    {
        // Test with array of mixed types
        // Тест с массивом смешанных типов
        $data = [0 => 'zero', 1 => 1, 2 => 'two'];
        $cover = new CoverArray($data);

        $result = $cover->all(function ($value, $key) {
            return is_string($value);
        });

        $this->assertFalse($result);
    }
}