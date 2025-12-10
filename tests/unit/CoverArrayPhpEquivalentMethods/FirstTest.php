<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class FirstTest extends TestCase
{
    /**
     * Tests the first() method with sequential numeric array.
     *
     * This test verifies that the first() method correctly returns the first
     * element of a sequential numeric array.
     *
     *
     * Тестирование метода first() с последовательным числовым массивом.
     *
     * Этот тест проверяет, что метод first() корректно возвращает первый
     * элемент последовательного числового массива.
     *
     * @see CoverArray::first()
     */
    public function testFirstWithSequentialNumericArray(): void
    {
        // Test with sequential numeric array
        // Тест с последовательным числовым массивом
        $data = [10, 20, 30, 40];
        $cover = new CoverArray($data);

        $this->assertSame(10, $cover->first());
    }

    /**
     * Tests the first() method with associative array.
     *
     * This test verifies that the first() method correctly returns the first
     * element of an associative array (preserving insertion order in PHP 7+).
     *
     *
     * Тестирование метода first() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод first() корректно возвращает первый
     * элемент ассоциативного массива (сохраняя порядок вставки в PHP 7+).
     *
     * @see CoverArray::first()
     */
    public function testFirstWithAssociativeArray(): void
    {
        // Test with associative array (preserving insertion order in PHP 7+)
        // Тест с ассоциативным массивом (сохраняется порядок вставки в PHP 7+)
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $cover = new CoverArray($data);

        $this->assertSame('apple', $cover->first());
    }

    /**
     * Tests the first() method with empty array.
     *
     * This test verifies that the first() method correctly returns null
     * when called on an empty array.
     *
     *
     * Тестирование метода first() с пустым массивом.
     *
     * Этот тест проверяет, что метод first() корректно возвращает null
     * при вызове на пустом массиве.
     *
     * @see CoverArray::first()
     */
    public function testFirstWithEmptyArray(): void
    {
        // Test with empty array
        // Тест с пустым массивом
        $data = [];
        $cover = new CoverArray($data);

        $this->assertNull($cover->first());
    }

    /**
     * Tests the first() method with null as first element.
     *
     * This test verifies that the first() method correctly returns null
     * when the first element of the array is actually null.
     *
     *
     * Тестирование метода first() с null в качестве первого элемента.
     *
     * Этот тест проверяет, что метод first() корректно возвращает null
     * когда первый элемент массива действительно равен null.
     *
     * @see CoverArray::first()
     */
    public function testFirstWithNullAsFirstElement(): void
    {
        // Test with array containing null as first element
        // Тест с массивом, содержащим null в качестве первого элемента
        $data = [null, 'second', 'third'];
        $cover = new CoverArray($data);

        $this->assertNull($cover->first());
    }

    /**
     * Tests the first() method with false as first element.
     *
     * This test verifies that the first() method correctly returns false
     * when the first element of the array is false.
     *
     *
     * Тестирование метода first() с false в качестве первого элемента.
     *
     * Этот тест проверяет, что метод first() корректно возвращает false
     * когда первый элемент массива равен false.
     *
     * @see CoverArray::first()
     */
    public function testFirstWithFalseAsFirstElement(): void
    {
        // Test with array containing false as first element
        // Тест с массивом, содержащим false в качестве первого элемента
        $data = [false, true, true];
        $cover = new CoverArray($data);

        $this->assertFalse($cover->first());
    }

    /**
     * Tests the first() method with zero as first element.
     *
     * This test verifies that the first() method correctly returns 0
     * when the first element of the array is zero.
     *
     *
     * Тестирование метода first() с 0 в качестве первого элемента.
     *
     * Этот тест проверяет, что метод first() корректно возвращает 0
     * когда первый элемент массива равен 0.
     *
     * @see CoverArray::first()
     */
    public function testFirstWithZeroAsFirstElement(): void
    {
        // Test with array containing zero as first element
        // Тест с массивом, содержащим 0 в качестве первого элемента
        $data = [0, 1, 2];
        $cover = new CoverArray($data);

        $this->assertSame(0, $cover->first());
    }

    /**
     * Tests the first() method with empty string as first element.
     *
     * This test verifies that the first() method correctly returns an empty string
     * when the first element of the array is an empty string.
     *
     *
     * Тестирование метода first() с пустой строкой в качестве первого элемента.
     *
     * Этот тест проверяет, что метод first() корректно возвращает пустую строку
     * когда первый элемент массива является пустой строкой.
     *
     * @see CoverArray::first()
     */
    public function testFirstWithEmptyStringAsFirstElement(): void
    {
        // Test with array containing empty string as first element
        // Тест с массивом, содержащим пустую строку в качестве первого элемента
        $data = ['', 'not empty', 'another'];
        $cover = new CoverArray($data);

        $this->assertSame('', $cover->first());
    }

    /**
     * Tests the first() method with mixed key types array.
     *
     * This test verifies that the first() method correctly returns the first
     * element of an array with mixed key types.
     *
     *
     * Тестирование метода first() с массивом со смешанными типами ключей.
     *
     * Этот тест проверяет, что метод first() корректно возвращает первый
     * элемент массива со смешанными типами ключей.
     *
     * @see CoverArray::first()
     */
    public function testFirstWithMixedKeyTypesArray(): void
    {
        // Test with mixed key types array
        // Тест с массивом со смешанными типами ключей
        $data = [0 => 'zero', 'one' => 1, 2 => 'two'];
        $cover = new CoverArray($data);

        $this->assertSame('zero', $cover->first());
    }

    /**
     * Tests that first() method doesn't affect array pointer.
     *
     * This test verifies that the first() method returns the same result
     * on multiple calls without affecting the internal array pointer.
     *
     *
     * Тестирование, что метод first() не затрагивает указатель массива.
     *
     * Этот тест проверяет, что метод first() возвращает одинаковый результат
     * при нескольких вызовах без воздействия на внутренний указатель массива.
     *
     * @see CoverArray::first()
     */
    public function testFirstDoesNotAffectArrayPointer(): void
    {
        // Test that method doesn't affect array pointer (same result on multiple calls)
        // Тест, что метод не затрагивает указатель массива (одинаковый результат при нескольких вызовах)
        $data = ['first', 'second', 'third'];
        $cover = new CoverArray($data);

        $this->assertSame('first', $cover->first());
        $this->assertSame('first', $cover->first()); // Second call should return same result
        $this->assertSame('first', $cover->first()); // Third call should return same result
    }

    /**
     * Tests the first() method with CoverArray as first element.
     *
     * This test verifies that the first() method correctly returns a CoverArray
     * instance when the first element is an array, as CoverArray converts
     * nested arrays to CoverArray instances.
     *
     *
     * Тестирование метода first() с CoverArray в качестве первого элемента.
     *
     * Этот тест проверяет, что метод first() корректно возвращает экземпляр CoverArray
     * когда первый элемент является массивом, так как CoverArray преобразует
     * вложенные массивы в экземпляры CoverArray.
     *
     * @see CoverArray::first()
     */
    public function testFirstWithCoverArrayAsFirstElement(): void
    {
        // Test with array containing array as first element
        // Тест с массивом, содержащим массив в качестве первого элемента
        $nestedArray = ['nested' => 'value'];
        $data = [$nestedArray, 'simple', 123];
        $cover = new CoverArray($data);

        // Since CoverArray converts nested arrays to CoverArray instances
        // Так как CoverArray преобразует вложенные массивы в экземпляры CoverArray
        $firstElement = $cover->first();
        $this->assertInstanceOf(CoverArray::class, $firstElement);
        $this->assertSame($nestedArray, $firstElement->getDataAsArray());
    }

    /**
     * Tests the first() method with CoverArray object as first element.
     *
     * This test verifies that the first() method correctly returns a CoverArray
     * object when it's already a CoverArray instance, preserving the original object.
     *
     *
     * Тестирование метода first() с объектом CoverArray в качестве первого элемента.
     *
     * Этот тест проверяет, что метод first() корректно возвращает объект CoverArray
     * когда он уже является экземпляром CoverArray, сохраняя исходный объект.
     *
     * @see CoverArray::first()
     */
    public function testFirstWithCoverArrayObjectAsFirstElement(): void
    {
        // Test with CoverArray object as first element
        // Тест с объектом CoverArray в качестве первого элемента
        $innerCover = new CoverArray(['x' => 1, 'y' => 2]);
        $data = [$innerCover, 'simple', 123];
        $cover = new CoverArray($data);

        $firstElement = $cover->first();

        // Should return the same CoverArray instance, not a clone
        // Должен вернуть тот же экземпляр CoverArray, не клон
        $this->assertSame($innerCover, $firstElement);
        $this->assertInstanceOf(CoverArray::class, $firstElement);
    }
}