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
     * Tests the unique() method with simple array of duplicate strings.
     *
     * This test verifies that the unique() method correctly removes
     * duplicate string values from the CoverArray, returning a new instance
     * with only unique elements, mirroring PHP's array_unique() function.
     *
     *
     * Тестирование метода unique() с простым массивом повторяющихся строк.
     *
     * Этот тест проверяет, что метод unique() корректно удаляет
     * повторяющиеся строковые значения из CoverArray, возвращая новый экземпляр
     * только с уникальными элементами, отражая функцию array_unique() PHP.
     *
     * @see CoverArray::unique()
     * @see array_unique()
     */
    public function testUniqueWithDuplicateStrings(): void
    {
        // Test with simple array with duplicate values
        // Тест с простым массивом с повторяющимися значениями
        $data = ['PHP', 'MySql', 'PHP', 'PHP', 'MySql', 'JavaScript'];

        $expected = array_unique($data, SORT_STRING);

        $cover = new CoverArray($data);
        $result = $cover->unique();

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the unique() method with duplicate integers.
     *
     * This test verifies that the unique() method correctly removes
     * duplicate integer values from the CoverArray, returning a new instance
     * with only unique elements, mirroring PHP's array_unique() function.
     *
     *
     * Тестирование метода unique() с повторяющимися целыми числами.
     *
     * Этот тест проверяет, что метод unique() корректно удаляет
     * повторяющиеся целочисленные значения из CoverArray, возвращая новый экземпляр
     * только с уникальными элементами, отражая функцию array_unique() PHP.
     *
     * @see CoverArray::unique()
     * @see array_unique()
     */
    public function testUniqueWithDuplicateIntegers(): void
    {
        // Test with array with duplicate integers
        // Тест с массивом с повторяющимися целыми числами
        $data = [1, 2, 2, 3, 3, 3, 1, 4];

        $expected = array_unique($data, SORT_NUMERIC);

        $cover = new CoverArray($data);
        $result = $cover->unique();

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the unique() method with mixed types (string and numeric strings).
     *
     * This test verifies that the unique() method correctly handles
     * arrays with mixed types, comparing values according to the SORT_REGULAR flag,
     * mirroring PHP's array_unique() function.
     *
     *
     * Тестирование метода unique() со смешанными типами (строки и числовые строки).
     *
     * Этот тест проверяет, что метод unique() корректно обрабатывает
     * массивы со смешанными типами, сравнивая значения согласно флагу SORT_REGULAR,
     * отражая функцию array_unique() PHP.
     *
     * @see CoverArray::unique()
     * @see array_unique()
     */
    public function testUniqueWithMixedTypes(): void
    {
        // Test with mixed types (string and numeric strings)
        // Тест со смешанными типами (строки и числовые строки)
        $data = ['10', 10, '10', 10.0];

        $expected = array_unique($data, SORT_REGULAR);

        $cover = new CoverArray($data);
        $result = $cover->unique();

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the unique() method with associative array and duplicate values.
     *
     * This test verifies that the unique() method correctly removes
     * duplicate values from an associative array while preserving keys,
     * mirroring PHP's array_unique() function.
     *
     *
     * Тестирование метода unique() с ассоциативным массивом и повторяющимися значениями.
     *
     * Этот тест проверяет, что метод unique() корректно удаляет
     * повторяющиеся значения из ассоциативного массива, сохраняя ключи,
     * отражая функцию array_unique() PHP.
     *
     * @see CoverArray::unique()
     * @see array_unique()
     */
    public function testUniqueWithAssociativeArray(): void
    {
        // Test with associative array with duplicate values
        // Тест с ассоциативным массивом с повторяющимися значениями
        $data = ['a' => 'PHP', 'b' => 'MySql', 'c' => 'PHP', 'd' => 'JavaScript', 'e' => 'MySql'];

        $expected = array_unique($data, SORT_STRING);

        $cover = new CoverArray($data);
        $result = $cover->unique();

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the unique() method with empty array.
     *
     * This test verifies that the unique() method correctly handles
     * empty arrays, returning an empty array without errors,
     * mirroring PHP's array_unique() function.
     *
     *
     * Тестирование метода unique() с пустым массивом.
     *
     * Этот тест проверяет, что метод unique() корректно обрабатывает
     * пустые массивы, возвращая пустой массив без ошибок,
     * отражая функцию array_unique() PHP.
     *
     * @see CoverArray::unique()
     * @see array_unique()
     */
    public function testUniqueWithEmptyArray(): void
    {
        // Test with empty array
        // Тест с пустым массивом
        $data = [];

        $expected = array_unique($data, SORT_STRING);

        $cover = new CoverArray($data);
        $result = $cover->unique();

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the unique() method with single element array.
     *
     * This test verifies that the unique() method correctly handles
     * single element arrays, returning the same array unchanged,
     * mirroring PHP's array_unique() function.
     *
     *
     * Тестирование метода unique() с массивом из одного элемента.
     *
     * Этот тест проверяет, что метод unique() корректно обрабатывает
     * массивы из одного элемента, возвращая тот же массив без изменений,
     * отражая функцию array_unique() PHP.
     *
     * @see CoverArray::unique()
     * @see array_unique()
     */
    public function testUniqueWithSingleElementArray(): void
    {
        // Test with single element array
        // Тест с массивом из одного элемента
        $data = ['only' => 'element'];

        $expected = array_unique($data, SORT_STRING);

        $cover = new CoverArray($data);
        $result = $cover->unique();

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the unique() method with array containing all unique values.
     *
     * This test verifies that the unique() method correctly handles
     * arrays where all values are already unique, returning the array unchanged,
     * mirroring PHP's array_unique() function.
     *
     *
     * Тестирование метода unique() с массивом, содержащим все уникальные значения.
     *
     * Этот тест проверяет, что метод unique() корректно обрабатывает
     * массивы, где все значения уже уникальны, возвращая массив без изменений,
     * отражая функцию array_unique() PHP.
     *
     * @see CoverArray::unique()
     * @see array_unique()
     */
    public function testUniqueWithAllUniqueValues(): void
    {
        // Test with array with all unique values
        // Тест с массивом со всеми уникальными значениями
        $data = ['PHP', 'MySql', 'JavaScript', 'Python'];

        $expected = array_unique($data, SORT_STRING);

        $cover = new CoverArray($data);
        $result = $cover->unique();

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the unique() method with SORT_STRING flag.
     *
     * This test verifies that the unique() method correctly uses
     * the SORT_STRING flag for comparison, mirroring PHP's array_unique() function.
     *
     *
     * Тестирование метода unique() с флагом SORT_STRING.
     *
     * Этот тест проверяет, что метод unique() корректно использует
     * флаг SORT_STRING для сравнения, отражая функцию array_unique() PHP.
     *
     * @see CoverArray::unique()
     * @see array_unique()
     */
    public function testUniqueWithSortStringFlag(): void
    {
        // Test with SORT_STRING flag
        // Тест с флагом SORT_STRING
        $data = ['10', 10, '20', 20, '10'];

        $expected = array_unique($data, SORT_STRING);

        $cover = new CoverArray($data);
        $result = $cover->unique(SORT_STRING);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the unique() method with SORT_NUMERIC flag.
     *
     * This test verifies that the unique() method correctly uses
     * the SORT_NUMERIC flag for comparison, mirroring PHP's array_unique() function.
     *
     *
     * Тестирование метода unique() с флагом SORT_NUMERIC.
     *
     * Этот тест проверяет, что метод unique() корректно использует
     * флаг SORT_NUMERIC для сравнения, отражая функцию array_unique() PHP.
     *
     * @see CoverArray::unique()
     * @see array_unique()
     */
    public function testUniqueWithSortNumericFlag(): void
    {
        // Test with SORT_NUMERIC flag
        // Тест с флагом SORT_NUMERIC
        $data = ['10', 10, '20', 20, '10'];

        $expected = array_unique($data, SORT_NUMERIC);

        $cover = new CoverArray($data);
        $result = $cover->unique(SORT_NUMERIC);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the unique() method with SORT_REGULAR flag.
     *
     * This test verifies that the unique() method correctly uses
     * the SORT_REGULAR flag for comparison, mirroring PHP's array_unique() function.
     *
     *
     * Тестирование метода unique() с флагом SORT_REGULAR.
     *
     * Этот тест проверяет, что метод unique() корректно использует
     * флаг SORT_REGULAR для сравнения, отражая функцию array_unique() PHP.
     *
     * @see CoverArray::unique()
     * @see array_unique()
     */
    public function testUniqueWithSortRegularFlag(): void
    {
        // Test with SORT_REGULAR flag
        // Тест с флагом SORT_REGULAR
        $data = ['10', 10, '20', 20, '10'];

        $expected = array_unique($data, SORT_REGULAR);

        $cover = new CoverArray($data);
        $result = $cover->unique(SORT_REGULAR);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the unique() method with boolean and null values using SORT_STRING flag.
     *
     * This test verifies that the unique() method correctly handles
     * arrays with boolean and null values using the SORT_STRING flag,
     * mirroring PHP's array_unique() function.
     *
     *
     * Тестирование метода unique() с булевыми и null значениями с использованием флага SORT_STRING.
     *
     * Этот тест проверяет, что метод unique() корректно обрабатывает
     * массивы с булевыми и null значениями с использованием флага SORT_STRING,
     * отражая функцию array_unique() PHP.
     *
     * @see CoverArray::unique()
     * @see array_unique()
     */
    public function testUniqueWithBooleanNullValuesSortString(): void
    {
        // Test with boolean and null values (using default SORT_STRING flag)
        // Тест с булевыми и null значениями (с флагом SORT_STRING по умолчанию)
        $data = [true, false, null, true, false, null, 1, 0];

        $expected = array_unique($data, SORT_STRING);

        $cover = new CoverArray($data);
        $result = $cover->unique(); // Использует SORT_STRING по умолчанию

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the unique() method with boolean and null values using SORT_REGULAR flag.
     *
     * This test verifies that the unique() method correctly handles
     * arrays with boolean and null values using the SORT_REGULAR flag,
     * mirroring PHP's array_unique() function.
     *
     *
     * Тестирование метода unique() с булевыми и null значениями с использованием флага SORT_REGULAR.
     *
     * Этот тест проверяет, что метод unique() корректно обрабатывает
     * массивы с булевыми и null значениями с использованием флага SORT_REGULAR,
     * отражая функцию array_unique() PHP.
     *
     * @see CoverArray::unique()
     * @see array_unique()
     */
    public function testUniqueWithBooleanNullValuesSortRegular(): void
    {
        // Test with boolean and null values (using SORT_REGULAR flag)
        // Тест с булевыми и null значениями (с флагом SORT_REGULAR)
        $data = [true, false, null, true, false, null, 1, 0];

        $expected = array_unique($data, SORT_REGULAR);

        $cover = new CoverArray($data);
        $result = $cover->unique(SORT_REGULAR);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the unique() method with case-sensitive string comparison.
     *
     * This test verifies that the unique() method performs
     * case-sensitive string comparison by default,
     * mirroring PHP's array_unique() function behavior.
     *
     *
     * Тестирование метода unique() с регистрозависимым сравнением строк.
     *
     * Этот тест проверяет, что метод unique() выполняет
     * регистрозависимое сравнение строк по умолчанию,
     * отражая поведение функции array_unique() PHP.
     *
     * @see CoverArray::unique()
     * @see array_unique()
     */
    public function testUniqueWithCaseSensitiveStrings(): void
    {
        // Test with case-sensitive string comparison (default behavior)
        // Тест с регистрозависимым сравнением строк (поведение по умолчанию)
        $data = ['php', 'PHP', 'Php', 'mySql', 'Mysql'];

        $expected = array_unique($data, SORT_STRING);

        $cover = new CoverArray($data);
        $result = $cover->unique();

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests that unique() method returns a CoverArray instance.
     *
     * This test verifies that the unique() method returns a new
     * CoverArray instance rather than a plain array.
     *
     *
     * Тестирование, что метод unique() возвращает экземпляр CoverArray.
     *
     * Этот тест проверяет, что метод unique() возвращает новый
     * экземпляр CoverArray, а не обычный массив.
     *
     * @see CoverArray::unique()
     */
    public function testUniqueReturnsCoverArrayInstance(): void
    {
        $data = ['PHP', 'MySql', 'PHP'];
        $cover = new CoverArray($data);

        $result = $cover->unique();

        $this->assertInstanceOf(CoverArray::class, $result);
    }

    /**
     * Tests the unique() method with array values containing CoverArray objects.
     *
     * This test verifies that the unique() method correctly handles
     * arrays containing CoverArray objects, comparing their values
     * rather than object references.
     *
     *
     * Тестирование метода unique() со значениями массивов, содержащих объекты CoverArray.
     *
     * Этот тест проверяет, что метод unique() корректно обрабатывает
     * массивы, содержащие объекты CoverArray, сравнивая их значения,
     * а не ссылки на объекты.
     *
     * @see CoverArray::unique()
     * @see array_unique()
     */
    public function testUniqueWithArrayValuesContainingCoverArray(): void
    {
        // Test with array values containing CoverArray objects
        // Тест со значениями массивов, содержащих объекты CoverArray
        $data = [
            ['inner' => ['x' => 1, 'y' => 2], 'value' => 1],
            ['inner' => ['x' => 1, 'y' => 2], 'value' => 1],
            ['inner' => ['x' => 3, 'y' => 4], 'value' => 1]
        ];

        // Create CoverArray which will convert nested arrays to CoverArray objects
        // Создаем CoverArray, который преобразует вложенные массивы в объекты CoverArray
        $cover = new CoverArray($data);

        // Get unique values
        // Получаем уникальные значения
        $result = $cover->unique(SORT_REGULAR);

        // We need to manually check the result since array_unique and CoverArray handle nested arrays differently
        // Нам нужно вручную проверить результат, так как array_unique и CoverArray обрабатывают вложенные массивы по-разному
        $this->assertCount(2, $result);

        // Check that first two identical arrays are considered the same
        // Проверяем, что первые два одинаковых массива считаются одинаковыми
        $firstItem = $result[0]->getDataAsArray();
        $secondItem = $result[2]->getDataAsArray(); // Второй элемент был удален, поэтому индекс 2 это третий исходный элемент

        $this->assertSame(['inner' => ['x' => 1, 'y' => 2], 'value' => 1], $firstItem);
        $this->assertSame(['inner' => ['x' => 3, 'y' => 4], 'value' => 1], $secondItem);
    }

    /**
     * Tests the unique() method with duplicate array values.
     *
     * This test verifies that the unique() method correctly identifies
     * and removes duplicate array values, mirroring PHP's array_unique() function.
     *
     *
     * Тестирование метода unique() с повторяющимися значениями массивов.
     *
     * Этот тест проверяет, что метод unique() корректно идентифицирует
     * и удаляет повторяющиеся значения массивов, отражая функцию array_unique() PHP.
     *
     * @see CoverArray::unique()
     * @see array_unique()
     */
    public function testUniqueWithDuplicateArrayValues(): void
    {
        // Test with duplicate array values
        // Тест с повторяющимися значениями массивов
        $data = [
            ['a', 'b', 'c'],
            ['a', 'b', 'c'],
            ['d', 'e', 'f'],
            ['a', 'b', 'c']
        ];

        $expected = array_unique($data, SORT_REGULAR);

        $cover = new CoverArray($data);
        $result = $cover->unique(SORT_REGULAR);

        // Since CoverArray converts nested arrays to CoverArray objects, we need to compare differently
        // Поскольку CoverArray преобразует вложенные массивы в объекты CoverArray, нужно сравнивать по-другому
        $this->assertCount(count($expected), $result);

        // Convert result to array for comparison
        // Преобразуем результат в массив для сравнения
        $resultArray = $result->getDataAsArray();
        $this->assertSame($expected, $resultArray);
    }

    /**
     * Tests the unique() method with SORT_LOCALE_STRING flag.
     *
     * This test verifies that the unique() method correctly uses
     * the SORT_LOCALE_STRING flag for comparison when available,
     * mirroring PHP's array_unique() function.
     *
     *
     * Тестирование метода unique() с флагом SORT_LOCALE_STRING.
     *
     * Этот тест проверяет, что метод unique() корректно использует
     * флаг SORT_LOCALE_STRING для сравнения, когда он доступен,
     * отражая функцию array_unique() PHP.
     *
     * @see CoverArray::unique()
     * @see array_unique()
     */
    public function testUniqueWithSortLocaleStringFlag(): void
    {
        // Test with SORT_LOCALE_STRING flag
        // Тест с флагом SORT_LOCALE_STRING
        $data = ['apple', 'banana', 'apple', 'Banana', 'cherry'];

        $expected = array_unique($data, SORT_LOCALE_STRING);

        $cover = new CoverArray($data);
        $result = $cover->unique(SORT_LOCALE_STRING);

        $this->assertSame($expected, $result->getDataAsArray());
    }
}