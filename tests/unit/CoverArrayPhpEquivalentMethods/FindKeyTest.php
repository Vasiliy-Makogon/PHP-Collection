<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class FindKeyTest extends TestCase
{
    /**
     * Tests the findKey() method finding key of an element in array of numbers.
     *
     * This test verifies that the findKey() method correctly returns the key
     * of the first element satisfying a callback function in an array of numbers.
     *
     *
     * Тестирование метода findKey() для поиска ключа элемента в массиве чисел.
     *
     * Этот тест проверяет, что метод findKey() корректно возвращает ключ
     * первого элемента, удовлетворяющего callback-функции, в массиве чисел.
     *
     * @see CoverArray::findKey()
     */
    public function testFindKeyInArrayOfNumbers(): void
    {
        // Test finding key of an element in array of numbers
        // Тест поиска ключа элемента в массиве чисел
        $data = [10, 20, 30, 40, 50];
        $cover = new CoverArray($data);

        $result = $cover->findKey(function ($value, $key) {
            return $value === 30;
        });

        $this->assertSame(2, $result);
    }

    /**
     * Tests the findKey() method returns null when element not found in array of numbers.
     *
     * This test verifies that the findKey() method returns null when
     * no element in the array of numbers satisfies the callback function.
     *
     *
     * Тестирование метода findKey() возвращает null, когда элемент не найден в массиве чисел.
     *
     * Этот тест проверяет, что метод findKey() возвращает null, когда
     * ни один элемент в массиве чисел не удовлетворяет callback-функции.
     *
     * @see CoverArray::findKey()
     */
    public function testFindKeyReturnsNullWhenNotFoundInNumbers(): void
    {
        $data = [10, 20, 30, 40, 50];
        $cover = new CoverArray($data);

        $result = $cover->findKey(function ($value, $key) {
            return $value === 100;
        });

        $this->assertNull($result);
    }

    /**
     * Tests the findKey() method finding key of an element in associative array.
     *
     * This test verifies that the findKey() method correctly returns the key
     * of the first element satisfying a callback function in an associative array.
     *
     *
     * Тестирование метода findKey() для поиска ключа элемента в ассоциативном массиве.
     *
     * Этот тест проверяет, что метод findKey() корректно возвращает ключ
     * первого элемента, удовлетворяющего callback-функции, в ассоциативном массиве.
     *
     * @see CoverArray::findKey()
     */
    public function testFindKeyInAssociativeArray(): void
    {
        // Test finding key of an element in associative array
        // Тест поиска ключа элемента в ассоциативном массиве
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $cover = new CoverArray($data);

        $result = $cover->findKey(function ($value, $key) {
            return $value === 'banana';
        });

        $this->assertSame('b', $result);
    }

    /**
     * Tests the findKey() method returns null when element not found in associative array.
     *
     * This test verifies that the findKey() method returns null when
     * no element in the associative array satisfies the callback function.
     *
     *
     * Тестирование метода findKey() возвращает null, когда элемент не найден в ассоциативном массиве.
     *
     * Этот тест проверяет, что метод findKey() возвращает null, когда
     * ни один элемент в ассоциативном массиве не удовлетворяет callback-функции.
     *
     * @see CoverArray::findKey()
     */
    public function testFindKeyReturnsNullWhenNotFoundInAssociativeArray(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $cover = new CoverArray($data);

        $result = $cover->findKey(function ($value, $key) {
            return $value === 'date';
        });

        $this->assertNull($result);
    }

    /**
     * Tests the findKey() method using key in callback.
     *
     * This test verifies that the findKey() method correctly uses
     * the key parameter in the callback function to find elements.
     *
     *
     * Тестирование метода findKey() с использованием ключа в callback.
     *
     * Этот тест проверяет, что метод findKey() корректно использует
     * параметр ключа в callback-функции для поиска элементов.
     *
     * @see CoverArray::findKey()
     */
    public function testFindKeyUsingKeyInCallback(): void
    {
        // Test finding key using key in callback
        // Тест поиска ключа с использованием ключа в callback
        $data = [5 => 'five', 10 => 'ten', 15 => 'fifteen'];
        $cover = new CoverArray($data);

        $result = $cover->findKey(function ($value, $key) {
            return $key === 10;
        });

        $this->assertSame(10, $result);
    }

    /**
     * Tests the findKey() method with empty array.
     *
     * This test verifies that the findKey() method returns null
     * for empty arrays, as there are no elements to satisfy the callback.
     *
     *
     * Тестирование метода findKey() с пустым массивом.
     *
     * Этот тест проверяет, что метод findKey() возвращает null
     * для пустых массивов, так как нет элементов, удовлетворяющих callback.
     *
     * @see CoverArray::findKey()
     */
    public function testFindKeyWithEmptyArray(): void
    {
        // Test with empty array
        // Тест с пустым массивом
        $data = [];
        $cover = new CoverArray($data);

        $result = $cover->findKey(function ($value, $key) {
            return $value === 'anything';
        });

        $this->assertNull($result);
    }

    /**
     * Tests the findKey() method returns first key when multiple elements satisfy condition.
     *
     * This test verifies that the findKey() method returns the key
     * of the first element that satisfies the callback when multiple
     * elements in the array satisfy the condition.
     *
     *
     * Тестирование метода findKey() возвращает первый ключ, когда несколько элементов удовлетворяют условию.
     *
     * Этот тест проверяет, что метод findKey() возвращает ключ
     * первого элемента, удовлетворяющего callback, когда несколько
     * элементов в массиве удовлетворяют условию.
     *
     * @see CoverArray::findKey()
     */
    public function testFindKeyReturnsFirstWhenMultipleSatisfy(): void
    {
        // Test finding first key when multiple elements satisfy condition
        // Тест поиска первого ключа, когда несколько элементов удовлетворяют условию
        $data = ['x' => 1, 'y' => 2, 'z' => 3, 'w' => 4];
        $cover = new CoverArray($data);

        $result = $cover->findKey(function ($value, $key) {
            return $value >= 2;
        });

        $this->assertSame('y', $result);
    }

    /**
     * Tests the findKey() method with callback that uses both value and key.
     *
     * This test verifies that the findKey() method correctly handles
     * callbacks that use both value and key parameters in the condition.
     *
     *
     * Тестирование метода findKey() с callback, который использует и значение, и ключ.
     *
     * Этот тест проверяет, что метод findKey() корректно обрабатывает
     * callback, использующие оба параметра (значение и ключ) в условии.
     *
     * @see CoverArray::findKey()
     */
    public function testFindKeyWithCallbackUsingBothValueAndKey(): void
    {
        // Test with callback that uses both value and key
        // Тест с callback, который использует и значение, и ключ
        $data = ['first' => 10, 'second' => 20, 'third' => 30];
        $cover = new CoverArray($data);

        $result = $cover->findKey(function ($value, $key) {
            return $value > 15 && $key === 'second';
        });

        $this->assertSame('second', $result);
    }

    /**
     * Tests the findKey() method with callback that always returns false.
     *
     * This test verifies that the findKey() method returns null when
     * the callback function always returns false for all elements.
     *
     *
     * Тестирование метода findKey() с callback, который всегда возвращает false.
     *
     * Этот тест проверяет, что метод findKey() возвращает null, когда
     * callback-функция всегда возвращает false для всех элементов.
     *
     * @see CoverArray::findKey()
     */
    public function testFindKeyWithCallbackAlwaysFalse(): void
    {
        // Test with callback that always returns false
        // Тест с callback, который всегда возвращает false
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $cover = new CoverArray($data);

        $result = $cover->findKey(function ($value, $key) {
            return false;
        });

        $this->assertNull($result);
    }

    /**
     * Tests the findKey() method with callback that always returns true.
     *
     * This test verifies that the findKey() method returns the first key
     * when the callback function always returns true for all elements.
     *
     *
     * Тестирование метода findKey() с callback, который всегда возвращает true.
     *
     * Этот тест проверяет, что метод findKey() возвращает первый ключ,
     * когда callback-функция всегда возвращает true для всех элементов.
     *
     * @see CoverArray::findKey()
     */
    public function testFindKeyWithCallbackAlwaysTrue(): void
    {
        // Test with callback that always returns true (should return first key)
        // Тест с callback, который всегда возвращает true (должен вернуть первый ключ)
        $data = ['one' => 1, 'two' => 2, 'three' => 3];
        $cover = new CoverArray($data);

        $result = $cover->findKey(function ($value, $key) {
            return true;
        });

        $this->assertSame('one', $result);
    }

    /**
     * Tests the findKey() method with complex condition.
     *
     * This test verifies that the findKey() method correctly handles
     * complex callback conditions to find matching elements.
     *
     *
     * Тестирование метода findKey() со сложным условием.
     *
     * Этот тест проверяет, что метод findKey() корректно обрабатывает
     * сложные условия в callback для поиска соответствующих элементов.
     *
     * @see CoverArray::findKey()
     */
    public function testFindKeyWithComplexCondition(): void
    {
        // Test finding key with complex condition
        // Тест поиска ключа со сложным условием
        $data = ['item1' => 5, 'item2' => 12, 'item3' => 8, 'item4' => 15];
        $cover = new CoverArray($data);

        $result = $cover->findKey(function ($value, $key) {
            return $value % 2 === 0 && $value > 10;
        });

        $this->assertSame('item2', $result);
    }

    /**
     * Tests the findKey() method returns null for complex condition not satisfied.
     *
     * This test verifies that the findKey() method returns null when
     * no element satisfies a complex callback condition.
     *
     *
     * Тестирование метода findKey() возвращает null для сложного условия, которое не выполняется.
     *
     * Этот тест проверяет, что метод findKey() возвращает null, когда
     * ни один элемент не удовлетворяет сложному условию в callback.
     *
     * @see CoverArray::findKey()
     */
    public function testFindKeyReturnsNullForComplexConditionNotSatisfied(): void
    {
        $data = ['item1' => 5, 'item2' => 12, 'item3' => 8, 'item4' => 15];
        $cover = new CoverArray($data);

        $result = $cover->findKey(function ($value, $key) {
            return $value > 100;
        });

        $this->assertNull($result);
    }

    /**
     * Tests the findKey() method with CoverArray elements in the array.
     *
     * This test verifies that the findKey() method correctly handles
     * arrays containing CoverArray objects as values, applying the callback
     * to the CoverArray objects themselves.
     *
     *
     * Тестирование метода findKey() с элементами типа CoverArray в массиве.
     *
     * Этот тест проверяет, что метод findKey() корректно обрабатывает
     * массивы, содержащие объекты CoverArray как значения, применяя callback
     * к самим объектам CoverArray.
     *
     * @see CoverArray::findKey()
     */
    public function testFindKeyWithCoverArrayElements(): void
    {
        // Test with CoverArray elements
        // Тест с элементами типа CoverArray
        $innerCover1 = new CoverArray(['value' => 10]);
        $innerCover2 = new CoverArray(['value' => 20]);
        $innerCover3 = new CoverArray(['value' => 30]);

        $data = [
            'first' => $innerCover1,
            'second' => $innerCover2,
            'third' => $innerCover3
        ];

        $cover = new CoverArray($data);

        $result = $cover->findKey(function ($value, $key) {
            return $value instanceof CoverArray && $value->item('value') === 20;
        });

        $this->assertSame('second', $result);
    }

    /**
     * Tests the findKey() method with callback checking CoverArray properties.
     *
     * This test verifies that the findKey() method can use callbacks
     * that examine properties of CoverArray objects in the array.
     *
     *
     * Тестирование метода findKey() с callback, проверяющим свойства CoverArray.
     *
     * Этот тест проверяет, что метод findKey() может использовать callback,
     * которые проверяют свойства объектов CoverArray в массиве.
     *
     * @see CoverArray::findKey()
     */
    public function testFindKeyWithCallbackCheckingCoverArrayProperties(): void
    {
        $cover1 = new CoverArray(['id' => 1, 'name' => 'Alice']);
        $cover2 = new CoverArray(['id' => 2, 'name' => 'Bob']);
        $cover3 = new CoverArray(['id' => 3, 'name' => 'Charlie']);

        $data = [
            'user1' => $cover1,
            'user2' => $cover2,
            'user3' => $cover3
        ];

        $cover = new CoverArray($data);

        $result = $cover->findKey(function ($value, $key) {
            return $value instanceof CoverArray && $value->get('name') === 'Bob';
        });

        $this->assertSame('user2', $result);
    }
}