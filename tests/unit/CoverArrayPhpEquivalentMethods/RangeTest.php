<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class RangeTest extends TestCase
{
    /**
     * Tests the range() method with integer values and default step.
     *
     * This test verifies that the range() static method correctly creates
     * a new CoverArray containing a range of integers with default step of 1,
     * mirroring the behavior of PHP's range() function.
     *
     *
     * Тестирование метода range() с целочисленными значениями и шагом по умолчанию.
     *
     * Этот тест проверяет, что статический метод range() корректно создает
     * новый CoverArray, содержащий диапазон целых чисел с шагом по умолчанию 1,
     * отражая поведение функции range() PHP.
     *
     * @see CoverArray::range()
     * @see range()
     */
    public function testRangeWithIntegersAndDefaultStep(): void
    {
        $expected = range(1, 5);
        $result = CoverArray::range(1, 5);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the range() method with integer values and custom step.
     *
     * This test verifies that the range() static method correctly creates
     * a new CoverArray containing a range of integers with a custom step,
     * mirroring the behavior of PHP's range() function.
     *
     *
     * Тестирование метода range() с целочисленными значениями и пользовательским шагом.
     *
     * Этот тест проверяет, что статический метод range() корректно создает
     * новый CoverArray, содержащий диапазон целых чисел с пользовательским шагом,
     * отражая поведение функции range() PHP.
     *
     * @see CoverArray::range()
     * @see range()
     */
    public function testRangeWithIntegersAndCustomStep(): void
    {
        $expected = range(0, 10, 2);
        $result = CoverArray::range(0, 10, 2);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the range() method with descending integers.
     *
     * This test verifies that the range() static method correctly creates
     * a new CoverArray containing a descending range of integers,
     * mirroring the behavior of PHP's range() function.
     *
     *
     * Тестирование метода range() с убывающими целыми числами.
     *
     * Этот тест проверяет, что статический метод range() корректно создает
     * новый CoverArray, содержащий убывающий диапазон целых чисел,
     * отражая поведение функции range() PHP.
     *
     * @see CoverArray::range()
     * @see range()
     */
    public function testRangeWithDescendingIntegers(): void
    {
        $expected = range(5, 1);
        $result = CoverArray::range(5, 1);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the range() method with descending integers and custom step.
     *
     * This test verifies that the range() static method correctly creates
     * a new CoverArray containing a descending range with a custom negative step,
     * mirroring the behavior of PHP's range() function.
     *
     *
     * Тестирование метода range() с убывающими целыми числами и пользовательским шагом.
     *
     * Этот тест проверяет, что статический метод range() корректно создает
     * новый CoverArray, содержащий убывающий диапазон с пользовательским отрицательным шагом,
     * отражая поведение функции range() PHP.
     *
     * @see CoverArray::range()
     * @see range()
     */
    public function testRangeWithDescendingIntegersAndCustomStep(): void
    {
        $expected = range(10, 0, -2);
        $result = CoverArray::range(10, 0, -2);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the range() method with character values.
     *
     * This test verifies that the range() static method correctly creates
     * a new CoverArray containing a range of characters,
     * mirroring the behavior of PHP's range() function.
     *
     *
     * Тестирование метода range() с символьными значениями.
     *
     * Этот тест проверяет, что статический метод range() корректно создает
     * новый CoverArray, содержащий диапазон символов,
     * отражая поведение функции range() PHP.
     *
     * @see CoverArray::range()
     * @see range()
     */
    public function testRangeWithCharacters(): void
    {
        $expected = range('a', 'e');
        $result = CoverArray::range('a', 'e');

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the range() method with descending characters.
     *
     * This test verifies that the range() static method correctly creates
     * a new CoverArray containing a descending range of characters,
     * mirroring the behavior of PHP's range() function.
     *
     *
     * Тестирование метода range() с убывающими символами.
     *
     * Этот тест проверяет, что статический метод range() корректно создает
     * новый CoverArray, содержащий убывающий диапазон символов,
     * отражая поведение функции range() PHP.
     *
     * @see CoverArray::range()
     * @see range()
     */
    public function testRangeWithDescendingCharacters(): void
    {
        $expected = range('z', 'a');
        $result = CoverArray::range('z', 'a');

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the range() method with uppercase characters.
     *
     * This test verifies that the range() static method correctly creates
     * a new CoverArray containing a range of uppercase characters,
     * mirroring the behavior of PHP's range() function.
     *
     *
     * Тестирование метода range() с заглавными символами.
     *
     * Этот тест проверяет, что статический метод range() корректно создает
     * новый CoverArray, содержащий диапазон заглавных символов,
     * отражая поведение функции range() PHP.
     *
     * @see CoverArray::range()
     * @see range()
     */
    public function testRangeWithUppercaseCharacters(): void
    {
        $expected = range('A', 'E');
        $result = CoverArray::range('A', 'E');

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the range() method with float step.
     *
     * This test verifies that the range() static method correctly creates
     * a new CoverArray containing a range with a float step,
     * mirroring the behavior of PHP's range() function.
     *
     *
     * Тестирование метода range() с дробным шагом.
     *
     * Этот тест проверяет, что статический метод range() корректно создает
     * новый CoverArray, содержащий диапазон с дробным шагом,
     * отражая поведение функции range() PHP.
     *
     * @see CoverArray::range()
     * @see range()
     */
    public function testRangeWithFloatStep(): void
    {
        $expected = range(0, 1, 0.2);
        $result = CoverArray::range(0, 1, 0.2);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the range() method with negative integers.
     *
     * This test verifies that the range() static method correctly creates
     * a new CoverArray containing a range of negative integers,
     * mirroring the behavior of PHP's range() function.
     *
     *
     * Тестирование метода range() с отрицательными целыми числами.
     *
     * Этот тест проверяет, что статический метод range() корректно создает
     * новый CoverArray, содержащий диапазон отрицательных целых чисел,
     * отражая поведение функции range() PHP.
     *
     * @see CoverArray::range()
     * @see range()
     */
    public function testRangeWithNegativeIntegers(): void
    {
        $expected = range(-5, -1);
        $result = CoverArray::range(-5, -1);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the range() method with zero range.
     *
     * This test verifies that the range() static method correctly creates
     * a new CoverArray with a single element when start equals end,
     * mirroring the behavior of PHP's range() function.
     *
     *
     * Тестирование метода range() с нулевым диапазоном.
     *
     * Этот тест проверяет, что статический метод range() корректно создает
     * новый CoverArray с одним элементом, когда начало равно концу,
     * отражая поведение функции range() PHP.
     *
     * @see CoverArray::range()
     * @see range()
     */
    public function testRangeWithZeroRange(): void
    {
        $expected = range(5, 5);
        $result = CoverArray::range(5, 5);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the range() method with mixed case characters.
     *
     * This test verifies that the range() static method correctly creates
     * a new CoverArray containing a range from lowercase to uppercase character,
     * mirroring the behavior of PHP's range() function.
     *
     *
     * Тестирование метода range() с символами разного регистра.
     *
     * Этот тест проверяет, что статический метод range() корректно создает
     * новый CoverArray, содержащий диапазон от строчного к заглавному символу,
     * отражая поведение функции range() PHP.
     *
     * @see CoverArray::range()
     * @see range()
     */
    public function testRangeWithMixedCaseCharacters(): void
    {
        $expected = range('a', 'E');
        $result = CoverArray::range('a', 'E');

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the range() method with characters and step.
     *
     * This test verifies that the range() static method correctly creates
     * a new CoverArray containing a range of characters with a custom step,
     * mirroring the behavior of PHP's range() function.
     *
     *
     * Тестирование метода range() с символами и шагом.
     *
     * Этот тест проверяет, что статический метод range() корректно создает
     * новый CoverArray, содержащий диапазон символов с пользовательским шагом,
     * отражая поведение функции range() PHP.
     *
     * @see CoverArray::range()
     * @see range()
     */
    public function testRangeWithCharactersAndStep(): void
    {
        $expected = range('a', 'z', 2);
        $result = CoverArray::range('a', 'z', 2);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the range() method with zero as start value.
     *
     * This test verifies that the range() static method correctly creates
     * a new CoverArray starting from zero,
     * mirroring the behavior of PHP's range() function.
     *
     *
     * Тестирование метода range() с нулем как начальным значением.
     *
     * Этот тест проверяет, что статический метод range() корректно создает
     * новый CoverArray, начинающийся с нуля,
     * отражая поведение функции range() PHP.
     *
     * @see CoverArray::range()
     * @see range()
     */
    public function testRangeWithZeroAsStart(): void
    {
        $expected = range(0, 5);
        $result = CoverArray::range(0, 5);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the range() method with float values.
     *
     * This test verifies that the range() static method correctly creates
     * a new CoverArray containing a range of float values,
     * mirroring the behavior of PHP's range() function.
     *
     *
     * Тестирование метода range() с дробными значениями.
     *
     * Этот тест проверяет, что статический метод range() корректно создает
     * новый CoverArray, содержащий диапазон дробных значений,
     * отражая поведение функции range() PHP.
     *
     * @see CoverArray::range()
     * @see range()
     */
    public function testRangeWithFloatValues(): void
    {
        $expected = range(1.5, 3.5);
        $result = CoverArray::range(1.5, 3.5);

        $this->assertSame($expected, $result->getDataAsArray());
    }
}
