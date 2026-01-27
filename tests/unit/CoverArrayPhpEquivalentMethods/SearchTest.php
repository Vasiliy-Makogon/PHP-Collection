<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class SearchTest extends TestCase
{
    /**
     * Tests the search() method with existing value.
     *
     * This test verifies that the search() method correctly finds
     * and returns the key of an existing value,
     * mirroring PHP's array_search() function.
     *
     *
     * Тестирование метода search() с существующим значением.
     *
     * Этот тест проверяет, что метод search() корректно находит
     * и возвращает ключ существующего значения,
     * отражая функцию array_search() PHP.
     *
     * @see CoverArray::search()
     * @see array_search()
     */
    public function testSearchWithExistingValue(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $needle = 'banana';

        $expected = array_search($needle, $data);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->search($needle));
    }

    /**
     * Tests the search() method with non-existing value.
     *
     * This test verifies that the search() method correctly returns
     * false when the value is not found,
     * mirroring PHP's array_search() function.
     *
     *
     * Тестирование метода search() с несуществующим значением.
     *
     * Этот тест проверяет, что метод search() корректно возвращает
     * false, когда значение не найдено,
     * отражая функцию array_search() PHP.
     *
     * @see CoverArray::search()
     * @see array_search()
     */
    public function testSearchWithNonExistingValue(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $needle = 'orange';

        $expected = array_search($needle, $data);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->search($needle));
    }

    /**
     * Tests the search() method with numeric keys.
     *
     * This test verifies that the search() method correctly finds
     * and returns numeric keys,
     * mirroring PHP's array_search() function.
     *
     *
     * Тестирование метода search() с числовыми ключами.
     *
     * Этот тест проверяет, что метод search() корректно находит
     * и возвращает числовые ключи,
     * отражая функцию array_search() PHP.
     *
     * @see CoverArray::search()
     * @see array_search()
     */
    public function testSearchWithNumericKeys(): void
    {
        $data = [10, 20, 30, 40, 50];
        $needle = 30;

        $expected = array_search($needle, $data);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->search($needle));
    }

    /**
     * Tests the search() method with strict comparison.
     *
     * This test verifies that the search() method correctly uses
     * strict comparison when $strict is true,
     * mirroring PHP's array_search() function.
     *
     *
     * Тестирование метода search() со строгим сравнением.
     *
     * Этот тест проверяет, что метод search() корректно использует
     * строгое сравнение, когда $strict равен true,
     * отражая функцию array_search() PHP.
     *
     * @see CoverArray::search()
     * @see array_search()
     */
    public function testSearchWithStrictComparison(): void
    {
        $data = [0 => '10', 1 => 10, 2 => '20'];
        $needle = 10;

        // Without strict - finds string '10' at index 0
        $expectedLoose = array_search($needle, $data, false);

        // With strict - finds integer 10 at index 1
        $expectedStrict = array_search($needle, $data, true);

        $cover = new CoverArray($data);

        $this->assertSame($expectedLoose, $cover->search($needle, false));
        $this->assertSame($expectedStrict, $cover->search($needle, true));
    }

    /**
     * Tests the search() method with duplicate values.
     *
     * This test verifies that the search() method returns
     * the first key when there are duplicate values,
     * mirroring PHP's array_search() function.
     *
     *
     * Тестирование метода search() с дублирующимися значениями.
     *
     * Этот тест проверяет, что метод search() возвращает
     * первый ключ при наличии дублирующихся значений,
     * отражая функцию array_search() PHP.
     *
     * @see CoverArray::search()
     * @see array_search()
     */
    public function testSearchWithDuplicateValues(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'apple', 'd' => 'date'];
        $needle = 'apple';

        $expected = array_search($needle, $data);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->search($needle));
    }

    /**
     * Tests the search() method with empty array.
     *
     * This test verifies that the search() method correctly returns
     * false when searching in an empty array,
     * mirroring PHP's array_search() function.
     *
     *
     * Тестирование метода search() с пустым массивом.
     *
     * Этот тест проверяет, что метод search() корректно возвращает
     * false при поиске в пустом массиве,
     * отражая функцию array_search() PHP.
     *
     * @see CoverArray::search()
     * @see array_search()
     */
    public function testSearchWithEmptyArray(): void
    {
        $data = [];
        $needle = 'anything';

        $expected = array_search($needle, $data);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->search($needle));
    }

    /**
     * Tests the search() method with null value.
     *
     * This test verifies that the search() method correctly finds
     * null values in the array,
     * mirroring PHP's array_search() function.
     *
     *
     * Тестирование метода search() со значением null.
     *
     * Этот тест проверяет, что метод search() корректно находит
     * значения null в массиве,
     * отражая функцию array_search() PHP.
     *
     * @see CoverArray::search()
     * @see array_search()
     */
    public function testSearchWithNullValue(): void
    {
        $data = ['a' => 1, 'b' => null, 'c' => 3];
        $needle = null;

        $expected = array_search($needle, $data, true);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->search($needle, true));
    }

    /**
     * Tests the search() method with boolean values.
     *
     * This test verifies that the search() method correctly finds
     * boolean values in the array,
     * mirroring PHP's array_search() function.
     *
     *
     * Тестирование метода search() с булевыми значениями.
     *
     * Этот тест проверяет, что метод search() корректно находит
     * булевы значения в массиве,
     * отражая функцию array_search() PHP.
     *
     * @see CoverArray::search()
     * @see array_search()
     */
    public function testSearchWithBooleanValues(): void
    {
        $data = ['a' => true, 'b' => false, 'c' => 1, 'd' => 0];
        $needle = false;

        // Without strict - may find 0 or false
        $expectedLoose = array_search($needle, $data, false);

        // With strict - finds only false
        $expectedStrict = array_search($needle, $data, true);

        $cover = new CoverArray($data);

        $this->assertSame($expectedLoose, $cover->search($needle, false));
        $this->assertSame($expectedStrict, $cover->search($needle, true));
    }

    /**
     * Tests the search() method with zero value.
     *
     * This test verifies that the search() method correctly finds
     * zero value with strict comparison,
     * mirroring PHP's array_search() function.
     *
     *
     * Тестирование метода search() со значением ноль.
     *
     * Этот тест проверяет, что метод search() корректно находит
     * значение ноль со строгим сравнением,
     * отражая функцию array_search() PHP.
     *
     * @see CoverArray::search()
     * @see array_search()
     */
    public function testSearchWithZeroValue(): void
    {
        $data = ['a' => '', 'b' => 0, 'c' => '0', 'd' => null];
        $needle = 0;

        // With strict - finds only integer 0
        $expectedStrict = array_search($needle, $data, true);

        $cover = new CoverArray($data);

        $this->assertSame($expectedStrict, $cover->search($needle, true));
    }
}
