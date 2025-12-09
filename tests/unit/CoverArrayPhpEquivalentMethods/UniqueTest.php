<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class UniqueTest extends TestCase
{
    /**
     * Tests the unique() method (array_unique equivalent).
     *
     * This test verifies that the unique() method correctly removes
     * duplicate values from the CoverArray, returning a new instance
     * with only unique elements, mirroring PHP's array_unique() function.
     * The method should not modify the original CoverArray instance.
     *
     *
     * Тестирование метода unique() (эквивалент array_unique).
     *
     * Этот тест проверяет, что метод unique() корректно удаляет
     * повторяющиеся значения из CoverArray, возвращая новый экземпляр
     * только с уникальными элементами, отражая функцию array_unique() PHP.
     * Метод не должен изменять исходный экземпляр CoverArray.
     *
     * @see CoverArray::unique()
     * @see array_unique()
     */
    public function testUniqueMethod(): void
    {
        // Test 1: Simple array with duplicate values
        // Тест 1: Простой массив с повторяющимися значениями
        $data1 = ['PHP', 'MySql', 'PHP', 'PHP', 'MySql', 'JavaScript'];
        $cover1 = new CoverArray($data1);

        $expected1 = array_unique($data1, SORT_STRING);
        $result1 = $cover1->unique();

        $this->assertSame(
            $expected1,
            $result1->getDataAsArray(),
            'Duplicate string values should be removed'
        );

        // Test 2: Verify original object is not modified
        // Тест 2: Проверяем, что исходный объект не изменен
        $this->assertSame(
            $data1,
            $cover1->getDataAsArray(),
            'Original CoverArray should not be modified by unique()'
        );

        // Test 3: Array with duplicate integers
        // Тест 3: Массив с повторяющимися целыми числами
        $data2 = [1, 2, 2, 3, 3, 3, 1, 4];
        $cover2 = new CoverArray($data2);

        $expected2 = array_unique($data2, SORT_NUMERIC);
        $result2 = $cover2->unique();

        $this->assertSame(
            $expected2,
            $result2->getDataAsArray(),
            'Duplicate integer values should be removed'
        );

        // Test 4: Array with mixed types (string and numeric strings)
        // Тест 4: Массив со смешанными типами (строки и числовые строки)
        $data3 = ['10', 10, '10', 10.0];
        $cover3 = new CoverArray($data3);

        $expected3 = array_unique($data3, SORT_REGULAR);
        $result3 = $cover3->unique();

        $this->assertSame(
            $expected3,
            $result3->getDataAsArray(),
            'Mixed types should be compared according to SORT_REGULAR flag'
        );

        // Test 5: Associative array with duplicate values
        // Тест 5: Ассоциативный массив с повторяющимися значениями
        $data4 = ['a' => 'PHP', 'b' => 'MySql', 'c' => 'PHP', 'd' => 'JavaScript', 'e' => 'MySql'];
        $cover4 = new CoverArray($data4);

        $expected4 = array_unique($data4, SORT_STRING);
        $result4 = $cover4->unique();

        $this->assertSame(
            $expected4,
            $result4->getDataAsArray(),
            'Associative array duplicate values should be removed, keys preserved'
        );

        // Test 6: Empty array
        // Тест 6: Пустой массив
        $emptyCover = new CoverArray([]);
        $emptyResult = $emptyCover->unique();

        $this->assertSame(
            [],
            $emptyResult->getDataAsArray(),
            'Empty array should remain empty when getting unique values'
        );

        // Test 7: Single element array
        // Тест 7: Массив с одним элементом
        $singleData = ['only' => 'element'];
        $singleCover = new CoverArray($singleData);
        $singleResult = $singleCover->unique();

        $this->assertSame(
            $singleData,
            $singleResult->getDataAsArray(),
            'Single element array should be unchanged when getting unique values'
        );

        // Test 8: Array with all unique values
        // Тест 8: Массив со всеми уникальными значениями
        $allUniqueData = ['PHP', 'MySql', 'JavaScript', 'Python'];
        $allUniqueCover = new CoverArray($allUniqueData);
        $allUniqueResult = $allUniqueCover->unique();

        $this->assertSame(
            $allUniqueData,
            $allUniqueResult->getDataAsArray(),
            'Array with all unique values should remain unchanged'
        );

        // Test 9: Different sort flags (SORT_STRING, SORT_NUMERIC, SORT_REGULAR, SORT_LOCALE_STRING)
        // Тест 9: Различные флаги сортировки
        $data5 = ['10', 10, '20', 20, '10'];
        $cover5 = new CoverArray($data5);

        // Test with SORT_STRING flag (default)
        // Тест с флагом SORT_STRING (по умолчанию)
        $expectedString = array_unique($data5, SORT_STRING);
        $resultString = $cover5->unique(SORT_STRING);
        $this->assertSame($expectedString, $resultString->getDataAsArray());

        // Test with SORT_NUMERIC flag
        // Тест с флагом SORT_NUMERIC
        $expectedNumeric = array_unique($data5, SORT_NUMERIC);
        $resultNumeric = $cover5->unique(SORT_NUMERIC);
        $this->assertSame($expectedNumeric, $resultNumeric->getDataAsArray());

        // Test with SORT_REGULAR flag
        // Тест с флагом SORT_REGULAR
        $expectedRegular = array_unique($data5, SORT_REGULAR);
        $resultRegular = $cover5->unique(SORT_REGULAR);
        $this->assertSame($expectedRegular, $resultRegular->getDataAsArray());

        // Test 10: Verify method returns CoverArray instance
        // Тест 10: Проверяем, что метод возвращает экземпляр CoverArray
        $this->assertInstanceOf(
            CoverArray::class,
            $cover1->unique(),
            'unique() should return a CoverArray instance'
        );

        // Test 11: Array with boolean and null values (using default SORT_STRING flag)
        // Тест 11: Массив с булевыми и null значениями (с флагом SORT_STRING по умолчанию)
        $data6 = [true, false, null, true, false, null, 1, 0];
        $cover6 = new CoverArray($data6);
        $expected6 = array_unique($data6, SORT_STRING); // Используем тот же флаг, что и в методе по умолчанию
        $result6 = $cover6->unique(); // Использует SORT_STRING по умолчанию

        $this->assertSame(
            $expected6,
            $result6->getDataAsArray(),
            'Array with boolean and null values should have duplicates removed with SORT_STRING flag'
        );

        // Test 12: Array with boolean and null values (using SORT_REGULAR flag)
        // Тест 12: Массив с булевыми и null значениями (с флагом SORT_REGULAR)
        $expectedRegularBool = array_unique($data6, SORT_REGULAR);
        $resultRegularBool = $cover6->unique(SORT_REGULAR);
        $this->assertSame(
            $expectedRegularBool,
            $resultRegularBool->getDataAsArray(),
            'Array with boolean and null values should have duplicates removed with SORT_REGULAR flag'
        );

        // Test 13: Case-sensitive string comparison (default behavior)
        // Тест 13: Регистрозависимое сравнение строк (поведение по умолчанию)
        $data7 = ['php', 'PHP', 'Php', 'mySql', 'Mysql'];
        $cover7 = new CoverArray($data7);

        $expected7 = array_unique($data7, SORT_STRING);
        $result7 = $cover7->unique();

        $this->assertSame(
            $expected7,
            $result7->getDataAsArray(),
            'String comparison should be case-sensitive by default'
        );
    }
}