<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class ShuffleTest extends TestCase
{
    /**
     * Tests the shuffle() method with basic array.
     *
     * This test verifies that the shuffle() method correctly randomizes
     * the order of elements in the array while preserving all values,
     * mirroring PHP's shuffle() function behavior.
     *
     *
     * Тестирование метода shuffle() с базовым массивом.
     *
     * Этот тест проверяет, что метод shuffle() корректно рандомизирует
     * порядок элементов в массиве, сохраняя все значения,
     * отражая поведение функции shuffle() PHP.
     *
     * @see CoverArray::shuffle()
     * @see shuffle()
     */
    public function testShuffleWithBasicArray(): void
    {
        $data = [1, 2, 3, 4, 5];
        $dataCopy = $data;

        shuffle($data);
        $expectedSorted = [1, 2, 3, 4, 5];

        $cover = new CoverArray($dataCopy);
        $result = $cover->shuffle();

        // Check that all values are preserved
        $shuffledData = $cover->getDataAsArray();
        sort($shuffledData);
        $this->assertSame($expectedSorted, $shuffledData);

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the shuffle() method preserves array size.
     *
     * This test verifies that the shuffle() method maintains
     * the same number of elements after shuffling,
     * mirroring PHP's shuffle() function behavior.
     *
     *
     * Тестирование метода shuffle() с сохранением размера массива.
     *
     * Этот тест проверяет, что метод shuffle() сохраняет
     * то же количество элементов после перемешивания,
     * отражая поведение функции shuffle() PHP.
     *
     * @see CoverArray::shuffle()
     * @see shuffle()
     */
    public function testShufflePreservesArraySize(): void
    {
        $data = ['a', 'b', 'c', 'd', 'e'];
        $dataCopy = $data;

        shuffle($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->shuffle();

        // Check that size is preserved
        $this->assertCount(5, $cover->getDataAsArray());
        $this->assertCount(count($data), $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the shuffle() method resets keys.
     *
     * This test verifies that the shuffle() method resets array keys
     * to sequential numeric indices starting from 0,
     * mirroring PHP's shuffle() function behavior.
     *
     *
     * Тестирование метода shuffle() со сбросом ключей.
     *
     * Этот тест проверяет, что метод shuffle() сбрасывает ключи массива
     * на последовательные числовые индексы, начиная с 0,
     * отражая поведение функции shuffle() PHP.
     *
     * @see CoverArray::shuffle()
     * @see shuffle()
     */
    public function testShuffleResetsKeys(): void
    {
        $data = ['first' => 1, 'second' => 2, 'third' => 3];
        $dataCopy = $data;

        shuffle($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->shuffle();

        // Check that keys are reset to numeric indices
        $shuffledData = $cover->getDataAsArray();
        $this->assertArrayHasKey(0, $shuffledData);
        $this->assertArrayHasKey(1, $shuffledData);
        $this->assertArrayHasKey(2, $shuffledData);
        $this->assertArrayNotHasKey('first', $shuffledData);
        $this->assertArrayNotHasKey('second', $shuffledData);
        $this->assertArrayNotHasKey('third', $shuffledData);

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the shuffle() method with empty array.
     *
     * This test verifies that the shuffle() method correctly handles
     * empty arrays without errors,
     * mirroring PHP's shuffle() function behavior.
     *
     *
     * Тестирование метода shuffle() с пустым массивом.
     *
     * Этот тест проверяет, что метод shuffle() корректно обрабатывает
     * пустые массивы без ошибок,
     * отражая поведение функции shuffle() PHP.
     *
     * @see CoverArray::shuffle()
     * @see shuffle()
     */
    public function testShuffleWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        shuffle($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->shuffle();

        // Check array is still empty
        $this->assertSame([], $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the shuffle() method with single element.
     *
     * This test verifies that the shuffle() method correctly handles
     * arrays with a single element,
     * mirroring PHP's shuffle() function behavior.
     *
     *
     * Тестирование метода shuffle() с одним элементом.
     *
     * Этот тест проверяет, что метод shuffle() корректно обрабатывает
     * массивы с одним элементом,
     * отражая поведение функции shuffle() PHP.
     *
     * @see CoverArray::shuffle()
     * @see shuffle()
     */
    public function testShuffleWithSingleElement(): void
    {
        $data = [42];
        $dataCopy = $data;

        shuffle($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->shuffle();

        // Check array contains the same element
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the shuffle() method with duplicate values.
     *
     * This test verifies that the shuffle() method correctly handles
     * arrays with duplicate values, preserving all duplicates,
     * mirroring PHP's shuffle() function behavior.
     *
     *
     * Тестирование метода shuffle() с дублирующимися значениями.
     *
     * Этот тест проверяет, что метод shuffle() корректно обрабатывает
     * массивы с дублирующимися значениями, сохраняя все дубликаты,
     * отражая поведение функции shuffle() PHP.
     *
     * @see CoverArray::shuffle()
     * @see shuffle()
     */
    public function testShuffleWithDuplicateValues(): void
    {
        $data = [1, 2, 2, 3, 3, 3];
        $dataCopy = $data;

        shuffle($data);
        $expectedSorted = [1, 2, 2, 3, 3, 3];

        $cover = new CoverArray($dataCopy);
        $result = $cover->shuffle();

        // Check that all values including duplicates are preserved
        $shuffledData = $cover->getDataAsArray();
        sort($shuffledData);
        $this->assertSame($expectedSorted, $shuffledData);

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the shuffle() method with string values.
     *
     * This test verifies that the shuffle() method correctly shuffles
     * arrays containing string values,
     * mirroring PHP's shuffle() function behavior.
     *
     *
     * Тестирование метода shuffle() со строковыми значениями.
     *
     * Этот тест проверяет, что метод shuffle() корректно перемешивает
     * массивы, содержащие строковые значения,
     * отражая поведение функции shuffle() PHP.
     *
     * @see CoverArray::shuffle()
     * @see shuffle()
     */
    public function testShuffleWithStringValues(): void
    {
        $data = ['apple', 'banana', 'cherry', 'date'];
        $dataCopy = $data;

        shuffle($data);
        $expectedSorted = ['apple', 'banana', 'cherry', 'date'];

        $cover = new CoverArray($dataCopy);
        $result = $cover->shuffle();

        // Check that all values are preserved
        $shuffledData = $cover->getDataAsArray();
        sort($shuffledData);
        $this->assertSame($expectedSorted, $shuffledData);

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the shuffle() method with mixed types.
     *
     * This test verifies that the shuffle() method correctly shuffles
     * arrays containing mixed value types,
     * mirroring PHP's shuffle() function behavior.
     *
     *
     * Тестирование метода shuffle() со смешанными типами.
     *
     * Этот тест проверяет, что метод shuffle() корректно перемешивает
     * массивы, содержащие значения смешанных типов,
     * отражая поведение функции shuffle() PHP.
     *
     * @see CoverArray::shuffle()
     * @see shuffle()
     */
    public function testShuffleWithMixedTypes(): void
    {
        $data = [1, 'two', 3.0, true, null];
        $originalCount = count($data);

        $cover = new CoverArray($data);
        $result = $cover->shuffle();

        // Check that size is preserved
        $this->assertCount($originalCount, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the shuffle() method preserves all values.
     *
     * This test verifies that the shuffle() method preserves
     * every value from the original array after shuffling,
     * mirroring PHP's shuffle() function behavior.
     *
     *
     * Тестирование метода shuffle() с сохранением всех значений.
     *
     * Этот тест проверяет, что метод shuffle() сохраняет
     * каждое значение из исходного массива после перемешивания,
     * отражая поведение функции shuffle() PHP.
     *
     * @see CoverArray::shuffle()
     * @see shuffle()
     */
    public function testShufflePreservesAllValues(): void
    {
        $data = [10, 20, 30, 40, 50];
        $dataCopy = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->shuffle();

        $shuffledData = $cover->getDataAsArray();

        // Check that each original value is present in shuffled array
        foreach ([10, 20, 30, 40, 50] as $value) {
            $this->assertContains($value, $shuffledData);
        }

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }
}
