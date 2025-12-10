<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class FindTest extends TestCase
{
    /**
     * Helper method to assert find() behavior with both approaches.
     *
     * Вспомогательный метод для проверки поведения find() двумя подходами.
     */
    private function assertFindCase(array $data, callable $callback, mixed $expected): void
    {
        $cover = new CoverArray($data);
        $result = $cover->find($callback);

        if (function_exists('array_find')) {
            $nativeResult = array_find($data, $callback);
            $this->assertSame(
                $nativeResult,
                $result,
                "CoverArray::find() should match array_find() for data: " . var_export($data, true)
            );
        } else {
            $this->assertSame(
                $expected,
                $result,
                "CoverArray::find() returned unexpected result for data: " . var_export($data, true)
            );
        }
    }

    /**
     * Tests the find() method with array of numbers (element found).
     *
     * This test verifies that the find() method correctly returns the first
     * element satisfying a callback function in an array of numbers.
     *
     *
     * Тестирование метода find() с массивом чисел (элемент найден).
     *
     * Этот тест проверяет, что метод find() корректно возвращает первый
     * элемент, удовлетворяющий callback-функции, в массиве чисел.
     *
     * @see CoverArray::find()
     */
    public function testFindWithArrayOfNumbersFound(): void
    {
        $data = [1, 3, 5, 7, 9];
        $callback = function ($value, $key) {
            return $value > 4 && $key === 2;
        };

        $this->assertFindCase($data, $callback, 5);
    }

    /**
     * Tests the find() method with array of numbers (element not found).
     *
     * This test verifies that the find() method correctly returns null
     * when no element satisfies the callback function in an array of numbers.
     *
     *
     * Тестирование метода find() с массивом чисел (элемент не найден).
     *
     * Этот тест проверяет, что метод find() корректно возвращает null,
     * когда ни один элемент не удовлетворяет callback-функции в массиве чисел.
     *
     * @see CoverArray::find()
     */
    public function testFindWithArrayOfNumbersNotFound(): void
    {
        $data = [1, 3, 5, 7, 9];
        $callback = function ($value, $key) {
            return $value > 10;
        };

        $this->assertFindCase($data, $callback, null);
    }

    /**
     * Tests the find() method with array of strings (element found).
     *
     * This test verifies that the find() method correctly returns the first
     * element satisfying a callback function in an array of strings.
     *
     *
     * Тестирование метода find() с массивом строк (элемент найден).
     *
     * Этот тест проверяет, что метод find() корректно возвращает первый
     * элемент, удовлетворяющий callback-функции, в массиве строк.
     *
     * @see CoverArray::find()
     */
    public function testFindWithArrayOfStringsFound(): void
    {
        $data = ['apple', 'banana', 'cherry', 'date'];
        $callback = function ($value, $key) {
            return str_starts_with($value, 'c');
        };

        $this->assertFindCase($data, $callback, 'cherry');
    }

    /**
     * Tests the find() method with array of strings (element not found).
     *
     * This test verifies that the find() method correctly returns null
     * when no element satisfies the callback function in an array of strings.
     *
     *
     * Тестирование метода find() с массивом строк (элемент не найден).
     *
     * Этот тест проверяет, что метод find() корректно возвращает null,
     * когда ни один элемент не удовлетворяет callback-функции в массиве строк.
     *
     * @see CoverArray::find()
     */
    public function testFindWithArrayOfStringsNotFound(): void
    {
        $data = ['apple', 'banana', 'cherry', 'date'];
        $callback = function ($value, $key) {
            return str_starts_with($value, 'z');
        };

        $this->assertFindCase($data, $callback, null);
    }

    /**
     * Tests the find() method with associative array (element found).
     *
     * This test verifies that the find() method correctly returns the first
     * element satisfying a callback function in an associative array.
     *
     *
     * Тестирование метода find() с ассоциативным массивом (элемент найден).
     *
     * Этот тест проверяет, что метод find() корректно возвращает первый
     * элемент, удовлетворяющий callback-функции, в ассоциативном массиве.
     *
     * @see CoverArray::find()
     */
    public function testFindWithAssociativeArrayFound(): void
    {
        $data = ['name' => 'John', 'age' => 30, 'city' => 'New York'];
        $callback = function ($value, $key) {
            return $key === 'age' && $value > 20;
        };

        $this->assertFindCase($data, $callback, 30);
    }

    /**
     * Tests the find() method with associative array (element not found).
     *
     * This test verifies that the find() method correctly returns null
     * when no element satisfies the callback function in an associative array.
     *
     *
     * Тестирование метода find() с ассоциативным массивом (элемент не найден).
     *
     * Этот тест проверяет, что метод find() корректно возвращает null,
     * когда ни один элемент не удовлетворяет callback-функции в ассоциативном массиве.
     *
     * @see CoverArray::find()
     */
    public function testFindWithAssociativeArrayNotFound(): void
    {
        $data = ['name' => 'John', 'age' => 30, 'city' => 'New York'];
        $callback = function ($value, $key) {
            return $key === 'country';
        };

        $this->assertFindCase($data, $callback, null);
    }

    /**
     * Tests the find() method with empty array.
     *
     * This test verifies that the find() method correctly returns null
     * when called on an empty array.
     *
     *
     * Тестирование метода find() с пустым массивом.
     *
     * Этот тест проверяет, что метод find() корректно возвращает null
     * при вызове на пустом массиве.
     *
     * @see CoverArray::find()
     */
    public function testFindWithEmptyArray(): void
    {
        $data = [];
        $callback = function ($value, $key) {
            return $value === 'anything';
        };

        $this->assertFindCase($data, $callback, null);
    }

    /**
     * Tests the find() method when multiple elements satisfy condition.
     *
     * This test verifies that the find() method returns the first element
     * that satisfies the callback function when multiple elements match.
     *
     *
     * Тестирование метода find(), когда несколько элементов удовлетворяют условию.
     *
     * Этот тест проверяет, что метод find() возвращает первый элемент,
     * который удовлетворяет callback-функции, когда несколько элементов соответствуют условию.
     *
     * @see CoverArray::find()
     */
    public function testFindFirstWhenMultipleElementsSatisfyCondition(): void
    {
        $data = [10, 20, 30, 40, 50];
        $callback = function ($value, $key) {
            return $value >= 30;
        };

        $this->assertFindCase($data, $callback, 30);
    }

    /**
     * Tests the find() method with callback using both value and key.
     *
     * This test verifies that the find() method correctly passes both
     * value and key to the callback function and returns the matching element.
     *
     *
     * Тестирование метода find() с callback, использующим и значение, и ключ.
     *
     * Этот тест проверяет, что метод find() корректно передает и значение,
     * и ключ в callback-функцию и возвращает соответствующий элемент.
     *
     * @see CoverArray::find()
     */
    public function testFindWithCallbackUsingValueAndKey(): void
    {
        $data = [0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three'];
        $callback = function ($value, $key) {
            return $key === 2 && strlen($value) === 3;
        };

        $this->assertFindCase($data, $callback, 'two');
    }

    /**
     * Tests the find() method with multiple conditions (element found).
     *
     * This test verifies that the find() method correctly returns an element
     * that satisfies multiple conditions in the callback function.
     *
     *
     * Тестирование метода find() с несколькими условиями (элемент найден).
     *
     * Этот тест проверяет, что метод find() корректно возвращает элемент,
     * который удовлетворяет нескольким условиям в callback-функции.
     *
     * @see CoverArray::find()
     */
    public function testFindWithMultipleConditionsFound(): void
    {
        $data = ['a' => 5, 'b' => 10, 'c' => 15, 'd' => 20];
        $callback = function ($value, $key) {
            return $value % 5 === 0 && $value % 3 === 0;
        };

        $this->assertFindCase($data, $callback, 15);
    }

    /**
     * Tests the find() method with multiple conditions (element not found).
     *
     * This test verifies that the find() method correctly returns null
     * when no element satisfies multiple conditions in the callback function.
     *
     *
     * Тестирование метода find() с несколькими условиями (элемент не найден).
     *
     * Этот тест проверяет, что метод find() корректно возвращает null,
     * когда ни один элемент не удовлетворяет нескольким условиям в callback-функции.
     *
     * @see CoverArray::find()
     */
    public function testFindWithMultipleConditionsNotFound(): void
    {
        $data = ['a' => 5, 'b' => 10, 'c' => 15, 'd' => 20];
        $callback = function ($value, $key) {
            return $value > 100;
        };

        $this->assertFindCase($data, $callback, null);
    }

    /**
     * Tests the find() method with CoverArray as element values.
     *
     * This test verifies that the find() method correctly handles
     * CoverArray objects as element values, finding elements based
     * on properties of the contained CoverArray objects.
     *
     *
     * Тестирование метода find() со значениями элементов типа CoverArray.
     *
     * Этот тест проверяет, что метод find() корректно обрабатывает
     * объекты CoverArray как значения элементов, находя элементы на основе
     * свойств содержащихся объектов CoverArray.
     *
     * @see CoverArray::find()
     */
    public function testFindWithCoverArrayValues(): void
    {
        $innerCover1 = new CoverArray(['id' => 1, 'active' => true]);
        $innerCover2 = new CoverArray(['id' => 2, 'active' => false]);
        $innerCover3 = new CoverArray(['id' => 3, 'active' => true]);

        $data = [
            'user1' => $innerCover1,
            'user2' => $innerCover2,
            'user3' => $innerCover3
        ];

        $callback = function ($value, $key) {
            return $value instanceof CoverArray && $value['id'] === 3;
        };

        $this->assertFindCase($data, $callback, $innerCover3);
    }
}