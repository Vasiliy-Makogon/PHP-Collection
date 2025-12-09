<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class AnyTest extends TestCase
{
    /**
     * Tests the any() method with array of numbers where condition is satisfied.
     *
     * This test verifies that the any() method returns true when at least
     * one element in the array of numbers satisfies the callback condition.
     *
     *
     * Тестирование метода any() с массивом чисел, где условие выполняется.
     *
     * Этот тест проверяет, что метод any() возвращает true, когда хотя бы
     * один элемент в массиве чисел удовлетворяет условию callback-функции.
     *
     * @see CoverArray::any()
     */
    public function testAnyWithArrayOfNumbersConditionSatisfied(): void
    {
        // Test with array of numbers where condition is satisfied
        // Тест с массивом чисел, где условие выполняется
        $data = [1, 2, 3, 4, 5];
        $cover = new CoverArray($data);

        $result = $cover->any(function ($value, $key) {
            return $value > 3;
        });

        $this->assertTrue($result);
    }

    /**
     * Tests the any() method with array of numbers where condition is not satisfied.
     *
     * This test verifies that the any() method returns false when no
     * element in the array of numbers satisfies the callback condition.
     *
     *
     * Тестирование метода any() с массивом чисел, где условие не выполняется.
     *
     * Этот тест проверяет, что метод any() возвращает false, когда ни один
     * элемент в массиве чисел не удовлетворяет условию callback-функции.
     *
     * @see CoverArray::any()
     */
    public function testAnyWithArrayOfNumbersConditionNotSatisfied(): void
    {
        // Test with array of numbers where condition is not satisfied
        // Тест с массивом чисел, где условие не выполняется
        $data = [1, 2, 3, 4, 5];
        $cover = new CoverArray($data);

        $result = $cover->any(function ($value, $key) {
            return $value > 10;
        });

        $this->assertFalse($result);
    }

    /**
     * Tests the any() method with array of strings where condition is satisfied.
     *
     * This test verifies that the any() method returns true when at least
     * one element in the array of strings satisfies the callback condition.
     *
     *
     * Тестирование метода any() с массивом строк, где условие выполняется.
     *
     * Этот тест проверяет, что метод any() возвращает true, когда хотя бы
     * один элемент в массиве строк удовлетворяет условию callback-функции.
     *
     * @see CoverArray::any()
     */
    public function testAnyWithArrayOfStringsConditionSatisfied(): void
    {
        // Test with array of strings where condition is satisfied
        // Тест с массивом строк, где условие выполняется
        $data = ['apple', 'banana', 'cherry'];
        $cover = new CoverArray($data);

        $result = $cover->any(function ($value, $key) {
            return $value === 'banana';
        });

        $this->assertTrue($result);
    }

    /**
     * Tests the any() method with array of strings where condition is not satisfied.
     *
     * This test verifies that the any() method returns false when no
     * element in the array of strings satisfies the callback condition.
     *
     *
     * Тестирование метода any() с массивом строк, где условие не выполняется.
     *
     * Этот тест проверяет, что метод any() возвращает false, когда ни один
     * элемент в массиве строк не удовлетворяет условию callback-функции.
     *
     * @see CoverArray::any()
     */
    public function testAnyWithArrayOfStringsConditionNotSatisfied(): void
    {
        // Test with array of strings where condition is not satisfied
        // Тест с массивом строк, где условие не выполняется
        $data = ['apple', 'banana', 'cherry'];
        $cover = new CoverArray($data);

        $result = $cover->any(function ($value, $key) {
            return $value === 'orange';
        });

        $this->assertFalse($result);
    }

    /**
     * Tests the any() method with associative array where condition is satisfied.
     *
     * This test verifies that the any() method returns true when at least
     * one key-value pair in the associative array satisfies the callback condition.
     *
     *
     * Тестирование метода any() с ассоциативным массивом, где условие выполняется.
     *
     * Этот тест проверяет, что метод any() возвращает true, когда хотя бы
     * одна пара ключ-значение в ассоциативном массиве удовлетворяет условию callback-функции.
     *
     * @see CoverArray::any()
     */
    public function testAnyWithAssociativeArrayConditionSatisfied(): void
    {
        // Test with associative array where condition is satisfied
        // Тест с ассоциативным массивом, где условие выполняется
        $data = ['name' => 'John', 'age' => 30, 'city' => 'New York'];
        $cover = new CoverArray($data);

        $result = $cover->any(function ($value, $key) {
            return $key === 'age' && $value === 30;
        });

        $this->assertTrue($result);
    }

    /**
     * Tests the any() method with associative array where condition is not satisfied.
     *
     * This test verifies that the any() method returns false when no
     * key-value pair in the associative array satisfies the callback condition.
     *
     *
     * Тестирование метода any() с ассоциативным массивом, где условие не выполняется.
     *
     * Этот тест проверяет, что метод any() возвращает false, когда ни одна
     * пара ключ-значение в ассоциативном массиве не удовлетворяет условию callback-функции.
     *
     * @see CoverArray::any()
     */
    public function testAnyWithAssociativeArrayConditionNotSatisfied(): void
    {
        // Test with associative array where condition is not satisfied
        // Тест с ассоциативным массивом, где условие не выполняется
        $data = ['name' => 'John', 'age' => 30, 'city' => 'New York'];
        $cover = new CoverArray($data);

        $result = $cover->any(function ($value, $key) {
            return $key === 'country' && $value === 'USA';
        });

        $this->assertFalse($result);
    }

    /**
     * Tests the any() method with empty array.
     *
     * This test verifies that the any() method returns false for
     * empty arrays, as there are no elements that could satisfy
     * the callback condition.
     *
     *
     * Тестирование метода any() с пустым массивом.
     *
     * Этот тест проверяет, что метод any() возвращает false для
     * пустых массивов, так как нет элементов, которые могли бы
     * удовлетворить условию callback-функции.
     *
     * @see CoverArray::any()
     */
    public function testAnyWithEmptyArray(): void
    {
        // Test with empty array
        // Тест с пустым массивом
        $data = [];
        $cover = new CoverArray($data);

        $result = $cover->any(function ($value, $key) {
            return $value === 'anything';
        });

        $this->assertFalse($result);
    }

    /**
     * Tests the any() method with callback using both value and key.
     *
     * This test verifies that the any() method correctly passes
     * both value and key to the callback function and returns true
     * when at least one key-value pair satisfies the condition.
     *
     *
     * Тестирование метода any() с callback, использующим и значение, и ключ.
     *
     * Этот тест проверяет, что метод any() корректно передает
     * и значение, и ключ в callback-функцию и возвращает true,
     * когда хотя бы одна пара ключ-значение удовлетворяет условию.
     *
     * @see CoverArray::any()
     */
    public function testAnyWithCallbackUsingValueAndKey(): void
    {
        // Test with callback that uses both value and key
        // Тест с callback, который использует и значение, и ключ
        $data = [10 => 'ten', 20 => 'twenty', 30 => 'thirty'];
        $cover = new CoverArray($data);

        $result = $cover->any(function ($value, $key) {
            return $key > 15 && strpos($value, 'tw') === 0;
        });

        $this->assertTrue($result);
    }

    /**
     * Tests the any() method with callback using both value and key where condition is not satisfied.
     *
     * This test verifies that the any() method returns false when no
     * key-value pair satisfies a complex condition using both value and key.
     *
     *
     * Тестирование метода any() с callback, использующим и значение, и ключ, где условие не выполняется.
     *
     * Этот тест проверяет, что метод any() возвращает false, когда ни одна
     * пара ключ-значение не удовлетворяет сложному условию, использующему и значение, и ключ.
     *
     * @see CoverArray::any()
     */
    public function testAnyWithCallbackUsingValueAndKeyConditionNotSatisfied(): void
    {
        // Test with callback that uses both value and key where condition is not satisfied
        // Тест с callback, который использует и значение, и ключ, где условие не выполняется
        $data = [10 => 'ten', 20 => 'twenty', 30 => 'thirty'];
        $cover = new CoverArray($data);

        $result = $cover->any(function ($value, $key) {
            return $key > 40 || $value === 'forty';
        });

        $this->assertFalse($result);
    }
}