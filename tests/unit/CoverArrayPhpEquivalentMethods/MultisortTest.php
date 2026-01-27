<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class MultisortTest extends TestCase
{
    /**
     * Tests the multisort() method with default parameters (ascending order).
     *
     * This test verifies that the multisort() method correctly sorts
     * the array in ascending order with default parameters,
     * mirroring PHP's array_multisort() function.
     *
     *
     * Тестирование метода multisort() с параметрами по умолчанию (по возрастанию).
     *
     * Этот тест проверяет, что метод multisort() корректно сортирует
     * массив по возрастанию с параметрами по умолчанию,
     * отражая функцию array_multisort() PHP.
     *
     * @see CoverArray::multisort()
     * @see array_multisort()
     */
    public function testMultisortWithDefaultParameters(): void
    {
        $data = [3, 1, 4, 1, 5, 9, 2, 6];
        $expected = $data;
        array_multisort($expected);

        $cover = new CoverArray($data);
        $result = $cover->multisort();

        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertSame($cover, $result); // Returns same instance (mutating)
    }

    /**
     * Tests the multisort() method with descending order.
     *
     * This test verifies that the multisort() method correctly sorts
     * the array in descending order when SORT_DESC is specified,
     * mirroring PHP's array_multisort() function.
     *
     *
     * Тестирование метода multisort() с сортировкой по убыванию.
     *
     * Этот тест проверяет, что метод multisort() корректно сортирует
     * массив по убыванию при указании SORT_DESC,
     * отражая функцию array_multisort() PHP.
     *
     * @see CoverArray::multisort()
     * @see array_multisort()
     */
    public function testMultisortWithDescendingOrder(): void
    {
        $data = [3, 1, 4, 1, 5, 9, 2, 6];
        $expected = $data;
        array_multisort($expected, SORT_DESC);

        $cover = new CoverArray($data);
        $cover->multisort(SORT_DESC);

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the multisort() method with SORT_NUMERIC flag.
     *
     * This test verifies that the multisort() method correctly sorts
     * the array numerically when SORT_NUMERIC flag is specified,
     * mirroring PHP's array_multisort() function.
     *
     *
     * Тестирование метода multisort() с флагом SORT_NUMERIC.
     *
     * Этот тест проверяет, что метод multisort() корректно сортирует
     * массив численно при указании флага SORT_NUMERIC,
     * отражая функцию array_multisort() PHP.
     *
     * @see CoverArray::multisort()
     * @see array_multisort()
     */
    public function testMultisortWithNumericFlag(): void
    {
        $data = ['10', '2', '1', '20', '3'];
        $expected = $data;
        array_multisort($expected, SORT_ASC, SORT_NUMERIC);

        $cover = new CoverArray($data);
        $cover->multisort(SORT_ASC, SORT_NUMERIC);

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the multisort() method with SORT_STRING flag.
     *
     * This test verifies that the multisort() method correctly sorts
     * the array as strings when SORT_STRING flag is specified,
     * mirroring PHP's array_multisort() function.
     *
     *
     * Тестирование метода multisort() с флагом SORT_STRING.
     *
     * Этот тест проверяет, что метод multisort() корректно сортирует
     * массив как строки при указании флага SORT_STRING,
     * отражая функцию array_multisort() PHP.
     *
     * @see CoverArray::multisort()
     * @see array_multisort()
     */
    public function testMultisortWithStringFlag(): void
    {
        $data = ['10', '2', '1', '20', '3'];
        $expected = $data;
        array_multisort($expected, SORT_ASC, SORT_STRING);

        $cover = new CoverArray($data);
        $cover->multisort(SORT_ASC, SORT_STRING);

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the multisort() method with one additional array.
     *
     * This test verifies that the multisort() method correctly sorts
     * the primary array and reorders the additional array correspondingly,
     * mirroring PHP's array_multisort() function.
     *
     *
     * Тестирование метода multisort() с одним дополнительным массивом.
     *
     * Этот тест проверяет, что метод multisort() корректно сортирует
     * основной массив и переупорядочивает дополнительный массив соответственно,
     * отражая функцию array_multisort() PHP.
     *
     * @see CoverArray::multisort()
     * @see array_multisort()
     */
    public function testMultisortWithOneAdditionalArray(): void
    {
        $data1 = [3, 1, 2];
        $data2 = ['c', 'a', 'b'];

        $expected1 = $data1;
        $expected2 = $data2;
        array_multisort($expected1, SORT_ASC, SORT_NUMERIC, $expected2);

        $cover1 = new CoverArray($data1);
        $cover2 = new CoverArray($data2);
        $cover1->multisort(SORT_ASC, SORT_NUMERIC, $cover2);

        $this->assertSame($expected1, $cover1->getDataAsArray());
        $this->assertSame($expected2, $cover2->getDataAsArray());
    }

    /**
     * Tests the multisort() method with multiple additional arrays.
     *
     * This test verifies that the multisort() method correctly sorts
     * the primary array and reorders multiple additional arrays correspondingly,
     * mirroring PHP's array_multisort() function.
     *
     *
     * Тестирование метода multisort() с несколькими дополнительными массивами.
     *
     * Этот тест проверяет, что метод multisort() корректно сортирует
     * основной массив и переупорядочивает несколько дополнительных массивов соответственно,
     * отражая функцию array_multisort() PHP.
     *
     * @see CoverArray::multisort()
     * @see array_multisort()
     */
    public function testMultisortWithMultipleAdditionalArrays(): void
    {
        $data1 = [3, 1, 2, 4];
        $data2 = ['c', 'a', 'b', 'd'];
        $data3 = [30, 10, 20, 40];

        $expected1 = $data1;
        $expected2 = $data2;
        $expected3 = $data3;
        array_multisort($expected1, SORT_ASC, SORT_NUMERIC, $expected2, $expected3);

        $cover1 = new CoverArray($data1);
        $cover2 = new CoverArray($data2);
        $cover3 = new CoverArray($data3);
        $cover1->multisort(SORT_ASC, SORT_NUMERIC, $cover2, $cover3);

        $this->assertSame($expected1, $cover1->getDataAsArray());
        $this->assertSame($expected2, $cover2->getDataAsArray());
        $this->assertSame($expected3, $cover3->getDataAsArray());
    }

    /**
     * Tests the multisort() method with associative arrays.
     *
     * This test verifies that the multisort() method correctly sorts
     * associative arrays while preserving key associations,
     * mirroring PHP's array_multisort() function.
     *
     *
     * Тестирование метода multisort() с ассоциативными массивами.
     *
     * Этот тест проверяет, что метод multisort() корректно сортирует
     * ассоциативные массивы, сохраняя связь ключей,
     * отражая функцию array_multisort() PHP.
     *
     * @see CoverArray::multisort()
     * @see array_multisort()
     */
    public function testMultisortWithAssociativeArrays(): void
    {
        $data = ['b' => 2, 'a' => 1, 'c' => 3];
        $expected = $data;
        array_multisort($expected);

        $cover = new CoverArray($data);
        $cover->multisort();

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the multisort() method with SORT_NATURAL flag.
     *
     * This test verifies that the multisort() method correctly sorts
     * the array using natural ordering when SORT_NATURAL flag is specified,
     * mirroring PHP's array_multisort() function.
     *
     *
     * Тестирование метода multisort() с флагом SORT_NATURAL.
     *
     * Этот тест проверяет, что метод multisort() корректно сортирует
     * массив с использованием естественного порядка при указании флага SORT_NATURAL,
     * отражая функцию array_multisort() PHP.
     *
     * @see CoverArray::multisort()
     * @see array_multisort()
     */
    public function testMultisortWithNaturalFlag(): void
    {
        $data = ['img12', 'img10', 'img2', 'img1'];
        $expected = $data;
        array_multisort($expected, SORT_ASC, SORT_NATURAL);

        $cover = new CoverArray($data);
        $cover->multisort(SORT_ASC, SORT_NATURAL);

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the multisort() method with empty array.
     *
     * This test verifies that the multisort() method correctly handles
     * an empty array without errors,
     * mirroring PHP's array_multisort() function.
     *
     *
     * Тестирование метода multisort() с пустым массивом.
     *
     * Этот тест проверяет, что метод multisort() корректно обрабатывает
     * пустой массив без ошибок,
     * отражая функцию array_multisort() PHP.
     *
     * @see CoverArray::multisort()
     * @see array_multisort()
     */
    public function testMultisortWithEmptyArray(): void
    {
        $data = [];
        $expected = $data;
        array_multisort($expected);

        $cover = new CoverArray($data);
        $cover->multisort();

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the multisort() method with descending order and additional array.
     *
     * This test verifies that the multisort() method correctly sorts
     * the primary array in descending order and reorders the additional array correspondingly,
     * mirroring PHP's array_multisort() function.
     *
     *
     * Тестирование метода multisort() с сортировкой по убыванию и дополнительным массивом.
     *
     * Этот тест проверяет, что метод multisort() корректно сортирует
     * основной массив по убыванию и переупорядочивает дополнительный массив соответственно,
     * отражая функцию array_multisort() PHP.
     *
     * @see CoverArray::multisort()
     * @see array_multisort()
     */
    public function testMultisortWithDescendingOrderAndAdditionalArray(): void
    {
        $data1 = [1, 3, 2, 4];
        $data2 = ['one', 'three', 'two', 'four'];

        $expected1 = $data1;
        $expected2 = $data2;
        array_multisort($expected1, SORT_DESC, SORT_NUMERIC, $expected2);

        $cover1 = new CoverArray($data1);
        $cover2 = new CoverArray($data2);
        $cover1->multisort(SORT_DESC, SORT_NUMERIC, $cover2);

        $this->assertSame($expected1, $cover1->getDataAsArray());
        $this->assertSame($expected2, $cover2->getDataAsArray());
    }
}
