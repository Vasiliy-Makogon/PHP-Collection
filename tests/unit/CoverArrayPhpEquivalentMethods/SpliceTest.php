<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class SpliceTest extends TestCase
{
    /**
     * Tests the splice() method with only offset parameter.
     *
     * This test verifies that the splice() method correctly removes elements
     * from the specified offset to the end of the array, modifying the original
     * array and returning the removed elements, mirroring PHP's array_splice()
     * function behavior.
     *
     *
     * Тестирование метода splice() с параметром только offset.
     *
     * Этот тест проверяет, что метод splice() корректно удаляет элементы
     * начиная с указанного offset до конца массива, изменяя исходный
     * массив и возвращая удаленные элементы, отражая поведение функции
     * array_splice() PHP.
     *
     * @see CoverArray::splice()
     * @see array_splice()
     */
    public function testSpliceWithOffsetOnly(): void
    {
        $data = ['a', 'b', 'c', 'd', 'e'];
        $dataCopy = $data;

        $expectedRemoved = array_splice($data, 2);
        $expectedModified = $data;

        $cover = new CoverArray($dataCopy);
        $removed = $cover->splice(2);

        // Check returned removed elements
        $this->assertSame($expectedRemoved, $removed->getDataAsArray());

        // Check modified original array
        $this->assertSame($expectedModified, $cover->getDataAsArray());
    }

    /**
     * Tests the splice() method with offset and length parameters.
     *
     * This test verifies that the splice() method correctly removes a specified
     * number of elements starting from the offset, modifying the original array
     * and returning the removed elements, mirroring PHP's array_splice() function behavior.
     *
     *
     * Тестирование метода splice() с параметрами offset и length.
     *
     * Этот тест проверяет, что метод splice() корректно удаляет указанное
     * количество элементов начиная с offset, изменяя исходный массив
     * и возвращая удаленные элементы, отражая поведение функции array_splice() PHP.
     *
     * @see CoverArray::splice()
     * @see array_splice()
     */
    public function testSpliceWithOffsetAndLength(): void
    {
        $data = ['a', 'b', 'c', 'd', 'e'];
        $dataCopy = $data;

        $expectedRemoved = array_splice($data, 1, 3);
        $expectedModified = $data;

        $cover = new CoverArray($dataCopy);
        $removed = $cover->splice(1, 3);

        // Check returned removed elements
        $this->assertSame($expectedRemoved, $removed->getDataAsArray());

        // Check modified original array
        $this->assertSame($expectedModified, $cover->getDataAsArray());
    }

    /**
     * Tests the splice() method with negative offset.
     *
     * This test verifies that the splice() method correctly handles negative
     * offset values, counting from the end of the array, mirroring PHP's
     * array_splice() function behavior.
     *
     *
     * Тестирование метода splice() с отрицательным offset.
     *
     * Этот тест проверяет, что метод splice() корректно обрабатывает
     * отрицательные значения offset, отсчитывая от конца массива,
     * отражая поведение функции array_splice() PHP.
     *
     * @see CoverArray::splice()
     * @see array_splice()
     */
    public function testSpliceWithNegativeOffset(): void
    {
        $data = ['a', 'b', 'c', 'd', 'e'];
        $dataCopy = $data;

        $expectedRemoved = array_splice($data, -2);
        $expectedModified = $data;

        $cover = new CoverArray($dataCopy);
        $removed = $cover->splice(-2);

        // Check returned removed elements
        $this->assertSame($expectedRemoved, $removed->getDataAsArray());

        // Check modified original array
        $this->assertSame($expectedModified, $cover->getDataAsArray());
    }

    /**
     * Tests the splice() method with negative length.
     *
     * This test verifies that the splice() method correctly handles negative
     * length values, leaving that many elements at the end of the array,
     * mirroring PHP's array_splice() function behavior.
     *
     *
     * Тестирование метода splice() с отрицательным length.
     *
     * Этот тест проверяет, что метод splice() корректно обрабатывает
     * отрицательные значения length, оставляя указанное количество
     * элементов в конце массива, отражая поведение функции array_splice() PHP.
     *
     * @see CoverArray::splice()
     * @see array_splice()
     */
    public function testSpliceWithNegativeLength(): void
    {
        $data = ['a', 'b', 'c', 'd', 'e'];
        $dataCopy = $data;

        $expectedRemoved = array_splice($data, 1, -1);
        $expectedModified = $data;

        $cover = new CoverArray($dataCopy);
        $removed = $cover->splice(1, -1);

        // Check returned removed elements
        $this->assertSame($expectedRemoved, $removed->getDataAsArray());

        // Check modified original array
        $this->assertSame($expectedModified, $cover->getDataAsArray());
    }

    /**
     * Tests the splice() method with replacement parameter.
     *
     * This test verifies that the splice() method correctly removes elements
     * and inserts replacement elements in their place, mirroring PHP's
     * array_splice() function behavior.
     *
     *
     * Тестирование метода splice() с параметром replacement.
     *
     * Этот тест проверяет, что метод splice() корректно удаляет элементы
     * и вставляет замещающие элементы на их место, отражая поведение
     * функции array_splice() PHP.
     *
     * @see CoverArray::splice()
     * @see array_splice()
     */
    public function testSpliceWithReplacement(): void
    {
        $data = ['a', 'b', 'c', 'd', 'e'];
        $dataCopy = $data;
        $replacement = ['x', 'y'];

        $expectedRemoved = array_splice($data, 2, 2, $replacement);
        $expectedModified = $data;

        $cover = new CoverArray($dataCopy);
        $removed = $cover->splice(2, 2, $replacement);

        // Check returned removed elements
        $this->assertSame($expectedRemoved, $removed->getDataAsArray());

        // Check modified original array
        $this->assertSame($expectedModified, $cover->getDataAsArray());
    }

    /**
     * Tests the splice() method with replacement that is longer than removed section.
     *
     * This test verifies that the splice() method correctly handles replacement
     * arrays that are longer than the section being removed, mirroring PHP's
     * array_splice() function behavior.
     *
     *
     * Тестирование метода splice() с replacement длиннее удаляемой секции.
     *
     * Этот тест проверяет, что метод splice() корректно обрабатывает
     * массивы замены, которые длиннее удаляемой секции, отражая
     * поведение функции array_splice() PHP.
     *
     * @see CoverArray::splice()
     * @see array_splice()
     */
    public function testSpliceWithLongerReplacement(): void
    {
        $data = ['a', 'b', 'c', 'd'];
        $dataCopy = $data;
        $replacement = ['x', 'y', 'z', 'w'];

        $expectedRemoved = array_splice($data, 1, 2, $replacement);
        $expectedModified = $data;

        $cover = new CoverArray($dataCopy);
        $removed = $cover->splice(1, 2, $replacement);

        // Check returned removed elements
        $this->assertSame($expectedRemoved, $removed->getDataAsArray());

        // Check modified original array
        $this->assertSame($expectedModified, $cover->getDataAsArray());
    }

    /**
     * Tests the splice() method with empty array.
     *
     * This test verifies that the splice() method correctly handles empty
     * arrays, returning an empty result and leaving the array empty,
     * mirroring PHP's array_splice() function behavior.
     *
     *
     * Тестирование метода splice() с пустым массивом.
     *
     * Этот тест проверяет, что метод splice() корректно обрабатывает
     * пустые массивы, возвращая пустой результат и оставляя массив пустым,
     * отражая поведение функции array_splice() PHP.
     *
     * @see CoverArray::splice()
     * @see array_splice()
     */
    public function testSpliceWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        $expectedRemoved = array_splice($data, 0);
        $expectedModified = $data;

        $cover = new CoverArray($dataCopy);
        $removed = $cover->splice(0);

        // Check returned removed elements
        $this->assertSame($expectedRemoved, $removed->getDataAsArray());

        // Check modified original array
        $this->assertSame($expectedModified, $cover->getDataAsArray());
    }

    /**
     * Tests the splice() method with associative array.
     *
     * This test verifies that the splice() method correctly handles associative
     * arrays, reindexing numeric keys while preserving string keys, mirroring
     * PHP's array_splice() function behavior.
     *
     *
     * Тестирование метода splice() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод splice() корректно обрабатывает
     * ассоциативные массивы, переиндексируя числовые ключи и сохраняя
     * строковые ключи, отражая поведение функции array_splice() PHP.
     *
     * @see CoverArray::splice()
     * @see array_splice()
     */
    public function testSpliceWithAssociativeArray(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry', 'd' => 'date'];
        $dataCopy = $data;

        $expectedRemoved = array_splice($data, 1, 2);
        $expectedModified = $data;

        $cover = new CoverArray($dataCopy);
        $removed = $cover->splice(1, 2);

        // Check returned removed elements
        $this->assertSame($expectedRemoved, $removed->getDataAsArray());

        // Check modified original array
        $this->assertSame($expectedModified, $cover->getDataAsArray());
    }

    /**
     * Tests the splice() method with zero length.
     *
     * This test verifies that the splice() method with zero length only
     * inserts replacement elements without removing any, mirroring PHP's
     * array_splice() function behavior.
     *
     *
     * Тестирование метода splice() с нулевым length.
     *
     * Этот тест проверяет, что метод splice() с нулевым length только
     * вставляет замещающие элементы без удаления, отражая поведение
     * функции array_splice() PHP.
     *
     * @see CoverArray::splice()
     * @see array_splice()
     */
    public function testSpliceWithZeroLength(): void
    {
        $data = ['a', 'b', 'c', 'd'];
        $dataCopy = $data;
        $replacement = ['x', 'y'];

        $expectedRemoved = array_splice($data, 2, 0, $replacement);
        $expectedModified = $data;

        $cover = new CoverArray($dataCopy);
        $removed = $cover->splice(2, 0, $replacement);

        // Check returned removed elements
        $this->assertSame($expectedRemoved, $removed->getDataAsArray());

        // Check modified original array
        $this->assertSame($expectedModified, $cover->getDataAsArray());
    }

    /**
     * Tests the splice() method removing all elements.
     *
     * This test verifies that the splice() method can remove all elements
     * from the array, leaving it empty, mirroring PHP's array_splice()
     * function behavior.
     *
     *
     * Тестирование метода splice() с удалением всех элементов.
     *
     * Этот тест проверяет, что метод splice() может удалить все элементы
     * из массива, оставляя его пустым, отражая поведение функции
     * array_splice() PHP.
     *
     * @see CoverArray::splice()
     * @see array_splice()
     */
    public function testSpliceRemoveAllElements(): void
    {
        $data = ['a', 'b', 'c'];
        $dataCopy = $data;

        $expectedRemoved = array_splice($data, 0);
        $expectedModified = $data;

        $cover = new CoverArray($dataCopy);
        $removed = $cover->splice(0);

        // Check returned removed elements
        $this->assertSame($expectedRemoved, $removed->getDataAsArray());

        // Check modified original array
        $this->assertSame($expectedModified, $cover->getDataAsArray());
        $this->assertCount(0, $cover);
    }

    /**
     * Tests the splice() method with offset beyond array length.
     *
     * This test verifies that the splice() method correctly handles offset
     * values that exceed the array length, mirroring PHP's array_splice()
     * function behavior.
     *
     *
     * Тестирование метода splice() с offset больше длины массива.
     *
     * Этот тест проверяет, что метод splice() корректно обрабатывает
     * значения offset, превышающие длину массива, отражая поведение
     * функции array_splice() PHP.
     *
     * @see CoverArray::splice()
     * @see array_splice()
     */
    public function testSpliceWithOffsetBeyondLength(): void
    {
        $data = ['a', 'b', 'c'];
        $dataCopy = $data;
        $replacement = ['x', 'y'];

        $expectedRemoved = array_splice($data, 10, 0, $replacement);
        $expectedModified = $data;

        $cover = new CoverArray($dataCopy);
        $removed = $cover->splice(10, 0, $replacement);

        // Check returned removed elements
        $this->assertSame($expectedRemoved, $removed->getDataAsArray());

        // Check modified original array
        $this->assertSame($expectedModified, $cover->getDataAsArray());
    }
}
