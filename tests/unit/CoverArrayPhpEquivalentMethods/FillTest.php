<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class FillTest extends TestCase
{
    /**
     * Tests the fill() method with positive start index.
     *
     * This test verifies that the fill() static method correctly creates
     * a CoverArray filled with specified values starting from a positive index,
     * mirroring PHP's array_fill() function behavior.
     *
     *
     * Тестирование метода fill() с положительным начальным индексом.
     *
     * Этот тест проверяет, что статический метод fill() корректно создает
     * CoverArray, заполненный указанными значениями, начиная с положительного индекса,
     * отражая поведение функции array_fill() PHP.
     *
     * @see CoverArray::fill()
     * @see array_fill()
     */
    public function testFillWithPositiveStartIndex(): void
    {
        // Test with positive start index
        // Тест с положительным начальным индексом
        $expected = array_fill(2, 2, 'foo');

        $result = CoverArray::fill(2, 2, 'foo');

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fill() method with zero start index.
     *
     * This test verifies that the fill() static method correctly creates
     * a CoverArray filled with specified values starting from index zero,
     * mirroring PHP's array_fill() function behavior.
     *
     *
     * Тестирование метода fill() с нулевым начальным индексом.
     *
     * Этот тест проверяет, что статический метод fill() корректно создает
     * CoverArray, заполненный указанными значениями, начиная с индекса ноль,
     * отражая поведение функции array_fill() PHP.
     *
     * @see CoverArray::fill()
     * @see array_fill()
     */
    public function testFillWithZeroStartIndex(): void
    {
        // Test with zero start index
        // Тест с нулевым начальным индексом
        $expected = array_fill(0, 3, 'bar');

        $result = CoverArray::fill(0, 3, 'bar');

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fill() method with negative start index.
     *
     * This test verifies that the fill() static method correctly creates
     * a CoverArray filled with specified values starting from a negative index,
     * mirroring PHP's array_fill() function behavior.
     *
     *
     * Тестирование метода fill() с отрицательным начальным индексом.
     *
     * Этот тест проверяет, что статический метод fill() корректно создает
     * CoverArray, заполненный указанными значениями, начиная с отрицательного индекса,
     * отражая поведение функции array_fill() PHP.
     *
     * @see CoverArray::fill()
     * @see array_fill()
     */
    public function testFillWithNegativeStartIndex(): void
    {
        // Test with negative start index
        // Тест с отрицательным начальным индексом
        $expected = array_fill(-2, 3, 'test');

        $result = CoverArray::fill(-2, 3, 'test');

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fill() method with count zero.
     *
     * This test verifies that the fill() static method correctly returns
     * an empty array when count is zero, mirroring PHP's array_fill() function behavior.
     *
     *
     * Тестирование метода fill() с количеством ноль.
     *
     * Этот тест проверяет, что статический метод fill() корректно возвращает
     * пустой массив, когда количество равно нулю, отражая поведение функции array_fill() PHP.
     *
     * @see CoverArray::fill()
     * @see array_fill()
     */
    public function testFillWithCountZero(): void
    {
        // Test with count 0 (should return empty array)
        // Тест с количеством 0 (должен вернуть пустой массив)
        $expected = array_fill(5, 0, 'value');

        $result = CoverArray::fill(5, 0, 'value');

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fill() method with integer value.
     *
     * This test verifies that the fill() static method correctly creates
     * a CoverArray filled with integer values, mirroring PHP's array_fill() function behavior.
     *
     *
     * Тестирование метода fill() с целочисленным значением.
     *
     * Этот тест проверяет, что статический метод fill() корректно создает
     * CoverArray, заполненный целочисленными значениями, отражая поведение функции array_fill() PHP.
     *
     * @see CoverArray::fill()
     * @see array_fill()
     */
    public function testFillWithIntegerValue(): void
    {
        // Test with integer value
        // Тест с целочисленным значением
        $expected = array_fill(0, 3, 42);

        $result = CoverArray::fill(0, 3, 42);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fill() method with array value.
     *
     * This test verifies that the fill() static method correctly creates
     * a CoverArray filled with array values, converting nested arrays to CoverArray instances,
     * mirroring PHP's array_fill() function behavior but with conversion of nested arrays.
     *
     *
     * Тестирование метода fill() со значением-массивом.
     *
     * Этот тест проверяет, что статический метод fill() корректно создает
     * CoverArray, заполненный значениями-массивами, преобразуя вложенные массивы в экземпляры CoverArray,
     * отражая поведение функции array_fill() PHP, но с преобразованием вложенных массивов.
     *
     * @see CoverArray::fill()
     * @see array_fill()
     */
    public function testFillWithArrayValue(): void
    {
        // Test with array value
        // Тест со значением-массивом
        $arrayValue = ['a', 'b', 'c'];
        $expected = array_fill(0, 2, $arrayValue);

        $result = CoverArray::fill(0, 2, $arrayValue);

        // Проверяем структуру
        $this->assertCount(2, $result);

        // Проверяем, что элементы являются CoverArray
        $this->assertInstanceOf(CoverArray::class, $result[0]);
        $this->assertInstanceOf(CoverArray::class, $result[1]);

        // Проверяем данные внутри CoverArray
        $this->assertSame($arrayValue, $result[0]->getDataAsArray());
        $this->assertSame($arrayValue, $result[1]->getDataAsArray());
    }

    /**
     * Tests the fill() method with CoverArray value.
     *
     * This test verifies that the fill() static method correctly handles
     * CoverArray objects as values, preserving them without conversion.
     *
     *
     * Тестирование метода fill() со значением типа CoverArray.
     *
     * Этот тест проверяет, что статический метод fill() корректно обрабатывает
     * объекты CoverArray как значения, сохраняя их без преобразования.
     *
     * @see CoverArray::fill()
     * @see array_fill()
     */
    public function testFillWithCoverArrayValue(): void
    {
        // Test with CoverArray value
        // Тест со значением типа CoverArray
        $coverArrayValue = new CoverArray(['x' => 1, 'y' => 2]);
        $expected = array_fill(0, 3, $coverArrayValue);

        $result = CoverArray::fill(0, 3, $coverArrayValue);

        $this->assertCount(3, $result);

        // Проверяем, что все элементы являются тем же объектом CoverArray
        $this->assertSame($coverArrayValue, $result[0]);
        $this->assertSame($coverArrayValue, $result[1]);
        $this->assertSame($coverArrayValue, $result[2]);

        // Проверяем, что это именно CoverArray
        $this->assertInstanceOf(CoverArray::class, $result[0]);
    }

    /**
     * Tests the fill() method with null value.
     *
     * This test verifies that the fill() static method correctly creates
     * a CoverArray filled with null values, mirroring PHP's array_fill() function behavior.
     *
     *
     * Тестирование метода fill() со значением null.
     *
     * Этот тест проверяет, что статический метод fill() корректно создает
     * CoverArray, заполненный значениями null, отражая поведение функции array_fill() PHP.
     *
     * @see CoverArray::fill()
     * @see array_fill()
     */
    public function testFillWithNullValue(): void
    {
        // Test with null value
        // Тест со значением null
        $expected = array_fill(1, 3, null);

        $result = CoverArray::fill(1, 3, null);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fill() method with boolean value.
     *
     * This test verifies that the fill() static method correctly creates
     * a CoverArray filled with boolean values, mirroring PHP's array_fill() function behavior.
     *
     *
     * Тестирование метода fill() с булевым значением.
     *
     * Этот тест проверяет, что статический метод fill() корректно создает
     * CoverArray, заполненный булевыми значениями, отражая поведение функции array_fill() PHP.
     *
     * @see CoverArray::fill()
     * @see array_fill()
     */
    public function testFillWithBooleanValue(): void
    {
        // Test with boolean value
        // Тест с булевым значением
        $expected = array_fill(0, 3, true);

        $result = CoverArray::fill(0, 3, true);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fill() method with count one.
     *
     * This test verifies that the fill() static method correctly creates
     * a CoverArray with a single element, mirroring PHP's array_fill() function behavior.
     *
     *
     * Тестирование метода fill() с количеством один.
     *
     * Этот тест проверяет, что статический метод fill() корректно создает
     * CoverArray с одним элементом, отражая поведение функции array_fill() PHP.
     *
     * @see CoverArray::fill()
     * @see array_fill()
     */
    public function testFillWithCountOne(): void
    {
        // Test with count 1
        // Тест с количеством 1
        $expected = array_fill(10, 1, 'single');

        $result = CoverArray::fill(10, 1, 'single');

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fill() method with float value.
     *
     * This test verifies that the fill() static method correctly creates
     * a CoverArray filled with float values, mirroring PHP's array_fill() function behavior.
     *
     *
     * Тестирование метода fill() со значением с плавающей точкой.
     *
     * Этот тест проверяет, что статический метод fill() корректно создает
     * CoverArray, заполненный значениями с плавающей точкой, отражая поведение функции array_fill() PHP.
     *
     * @see CoverArray::fill()
     * @see array_fill()
     */
    public function testFillWithFloatValue(): void
    {
        // Test with float value
        // Тест со значением с плавающей точкой
        $expected = array_fill(0, 2, 3.14);

        $result = CoverArray::fill(0, 2, 3.14);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fill() method with object value.
     *
     * This test verifies that the fill() static method correctly creates
     * a CoverArray filled with object values, mirroring PHP's array_fill() function behavior.
     *
     *
     * Тестирование метода fill() со значением-объектом.
     *
     * Этот тест проверяет, что статический метод fill() корректно создает
     * CoverArray, заполненный значениями-объектами, отражая поведение функции array_fill() PHP.
     *
     * @see CoverArray::fill()
     * @see array_fill()
     */
    public function testFillWithObjectValue(): void
    {
        // Test with object value
        // Тест со значением-объектом
        $object = new \stdClass();
        $object->property = 'value';

        $expected = array_fill(0, 2, $object);

        $result = CoverArray::fill(0, 2, $object);

        $this->assertSame($expected, $result->getDataAsArray());
        $this->assertSame($object, $result[0]);
        $this->assertSame($object, $result[1]); // Тот же объект, не клон
    }
}