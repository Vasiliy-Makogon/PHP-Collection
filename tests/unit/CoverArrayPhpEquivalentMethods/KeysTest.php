<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class KeysTest extends TestCase
{
    /**
     * Tests the keys() method getting all keys from associative array.
     *
     * This test verifies that the keys() method correctly returns
     * all keys from an associative array without filtering,
     * mirroring PHP's array_keys() function without parameters.
     *
     *
     * Тестирование метода keys() с получением всех ключей из ассоциативного массива.
     *
     * Этот тест проверяет, что метод keys() корректно возвращает
     * все ключи из ассоциативного массива без фильтрации,
     * отражая поведение функции array_keys() PHP без параметров.
     *
     * @see CoverArray::keys()
     * @see array_keys()
     */
    public function testKeysAllKeysFromAssociativeArray(): void
    {
        $data = ['country' => 'Russia', 'region' => 'Moscow region', 'city' => 'Podolsk', 'street' => 'Kirov st.'];

        $expected = array_keys($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keys()->getDataAsArray());
    }

    /**
     * Tests the keys() method getting all keys from nested array structure.
     *
     * This test verifies that the keys() method correctly returns
     * all keys from an array containing nested arrays, without
     * recursing into the nested structures, mirroring PHP's array_keys() function.
     *
     *
     * Тестирование метода keys() с получением всех ключей из вложенной структуры массива.
     *
     * Этот тест проверяет, что метод keys() корректно возвращает
     * все ключи из массива, содержащего вложенные массивы, без
     * рекурсии во вложенные структуры, отражая поведение функции array_keys() PHP.
     *
     * @see CoverArray::keys()
     * @see array_keys()
     */
    public function testKeysAllKeysFromNestedArrayStructure(): void
    {
        $data = [
            'backend' => ['PHP', 'MySql'],
            'frontend' => ['HTML', 'CSS', 'JavaScript']
        ];

        $expected = array_keys($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keys()->getDataAsArray());
    }

    /**
     * Tests the keys() method filtered by value with strict comparison.
     *
     * This test verifies that the keys() method correctly returns
     * keys filtered by value using strict comparison (===),
     * mirroring PHP's array_keys() function with $strict = true.
     *
     *
     * Тестирование метода keys() с фильтрацией по значению и строгим сравнением.
     *
     * Этот тест проверяет, что метод keys() корректно возвращает
     * ключи, отфильтрованные по значению с использованием строгого сравнения (===),
     * отражая поведение функции array_keys() PHP с $strict = true.
     *
     * @see CoverArray::keys()
     * @see array_keys()
     */
    public function testKeysFilteredByValueWithStrictComparison(): void
    {
        $data = ['PHP', 'MySql'];

        $expected = array_keys($data, 'PHP', true);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keys('PHP', true)->getDataAsArray());
    }

    /**
     * Tests the keys() method filtered by value with loose comparison.
     *
     * This test verifies that the keys() method correctly returns
     * keys filtered by value using loose comparison (==),
     * mirroring PHP's array_keys() function with $strict = false.
     *
     *
     * Тестирование метода keys() с фильтрацией по значению и нестрогим сравнением.
     *
     * Этот тест проверяет, что метод keys() корректно возвращает
     * ключи, отфильтрованные по значению с использованием нестрогого сравнения (==),
     * отражая поведение функции array_keys() PHP с $strict = false.
     *
     * @see CoverArray::keys()
     * @see array_keys()
     */
    public function testKeysFilteredByValueWithLooseComparison(): void
    {
        $data = [0 => '0', 1 => 0, 2 => false, 3 => null, 4 => ''];

        $expected = array_keys($data, '0', false);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keys('0', false)->getDataAsArray());
    }

    /**
     * Tests the keys() method filtered by value with strict comparison on mixed types.
     *
     * This test verifies that the keys() method correctly handles
     * strict comparison with string '0' when array contains various falsy values,
     * mirroring PHP's array_keys() function with $strict = true.
     *
     *
     * Тестирование метода keys() с фильтрацией по значению и строгим сравнением на смешанных типах.
     *
     * Этот тест проверяет, что метод keys() корректно обрабатывает
     * строгое сравнение со строкой '0', когда массив содержит различные ложные значения,
     * отражая поведение функции array_keys() PHP с $strict = true.
     *
     * @see CoverArray::keys()
     * @see array_keys()
     */
    public function testKeysFilteredByValueStrictComparisonOnMixedTypes(): void
    {
        $data = [0 => '0', 1 => 0, 2 => false, 3 => null, 4 => ''];

        $expected = array_keys($data, '0', true);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keys('0', true)->getDataAsArray());
    }

    /**
     * Tests the keys() method with empty array without filter.
     *
     * This test verifies that the keys() method correctly returns
     * an empty array when called on an empty array without filtering,
     * mirroring PHP's array_keys() function behavior.
     *
     *
     * Тестирование метода keys() с пустым массивом без фильтра.
     *
     * Этот тест проверяет, что метод keys() корректно возвращает
     * пустой массив при вызове на пустом массиве без фильтрации,
     * отражая поведение функции array_keys() PHP.
     *
     * @see CoverArray::keys()
     * @see array_keys()
     */
    public function testKeysWithEmptyArrayWithoutFilter(): void
    {
        $data = [];

        $expected = array_keys($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keys()->getDataAsArray());
    }

    /**
     * Tests the keys() method with empty array with filter.
     *
     * This test verifies that the keys() method correctly returns
     * an empty array when called on an empty array with filtering,
     * mirroring PHP's array_keys() function behavior.
     *
     *
     * Тестирование метода keys() с пустым массивом с фильтром.
     *
     * Этот тест проверяет, что метод keys() корректно возвращает
     * пустой массив при вызове на пустом массиве с фильтрацией,
     * отражая поведение функции array_keys() PHP.
     *
     * @see CoverArray::keys()
     * @see array_keys()
     */
    public function testKeysWithEmptyArrayWithFilter(): void
    {
        $data = [];

        $expected = array_keys($data, 'value', true);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keys('value', true)->getDataAsArray());
    }

    /**
     * Tests the keys() method with duplicate values.
     *
     * This test verifies that the keys() method correctly returns
     * all keys for duplicate values when filtered by that value,
     * mirroring PHP's array_keys() function behavior.
     *
     *
     * Тестирование метода keys() с дублирующимися значениями.
     *
     * Этот тест проверяет, что метод keys() корректно возвращает
     * все ключи для дублирующихся значений при фильтрации по этому значению,
     * отражая поведение функции array_keys() PHP.
     *
     * @see CoverArray::keys()
     * @see array_keys()
     */
    public function testKeysWithDuplicateValues(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'apple', 'd' => 'cherry', 'e' => 'apple'];

        $expected = array_keys($data, 'apple', true);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keys('apple', true)->getDataAsArray());
    }

    /**
     * Tests the keys() method with numeric keys.
     *
     * This test verifies that the keys() method correctly returns
     * numeric keys from an array, mirroring PHP's array_keys() function behavior.
     *
     *
     * Тестирование метода keys() с числовыми ключами.
     *
     * Этот тест проверяет, что метод keys() корректно возвращает
     * числовые ключи из массива, отражая поведение функции array_keys() PHP.
     *
     * @see CoverArray::keys()
     * @see array_keys()
     */
    public function testKeysWithNumericKeys(): void
    {
        $data = [10 => 'ten', 20 => 'twenty', 30 => 'thirty', 40 => 'forty'];

        $expected = array_keys($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keys()->getDataAsArray());
    }

    /**
     * Tests the keys() method with numeric keys and value filter.
     *
     * This test verifies that the keys() method correctly returns
     * numeric keys filtered by value, mirroring PHP's array_keys() function behavior.
     *
     *
     * Тестирование метода keys() с числовыми ключами и фильтром по значению.
     *
     * Этот тест проверяет, что метод keys() корректно возвращает
     * числовые ключи, отфильтрованные по значению, отражая поведение функции array_keys() PHP.
     *
     * @see CoverArray::keys()
     * @see array_keys()
     */
    public function testKeysWithNumericKeysAndValueFilter(): void
    {
        $data = [10 => 'ten', 20 => 'twenty', 30 => 'thirty', 40 => 'forty'];

        $expected = array_keys($data, 'thirty', true);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keys('thirty', true)->getDataAsArray());
    }

    /**
     * Tests the keys() method with mixed key types and value filter.
     *
     * This test verifies that the keys() method correctly returns
     * keys (both string and numeric) filtered by integer value,
     * mirroring PHP's array_keys() function behavior.
     *
     *
     * Тестирование метода keys() со смешанными типами ключей и фильтром по значению.
     *
     * Этот тест проверяет, что метод keys() корректно возвращает
     * ключи (и строковые, и числовые), отфильтрованные по целочисленному значению,
     * отражая поведение функции array_keys() PHP.
     *
     * @see CoverArray::keys()
     * @see array_keys()
     */
    public function testKeysWithMixedKeyTypesAndIntegerValueFilter(): void
    {
        $data = ['a' => 1, 0 => 2, 'c' => 1, 1 => 2];

        $expected = array_keys($data, 1, true);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keys(1, true)->getDataAsArray());
    }

    /**
     * Tests the keys() method with mixed key types and another value filter.
     *
     * This test verifies that the keys() method correctly returns
     * keys filtered by a different integer value in an array with mixed key types,
     * mirroring PHP's array_keys() function behavior.
     *
     *
     * Тестирование метода keys() со смешанными типами ключей и другим фильтром по значению.
     *
     * Этот тест проверяет, что метод keys() корректно возвращает
     * ключи, отфильтрованные по другому целочисленному значению в массиве со смешанными типами ключей,
     * отражая поведение функции array_keys() PHP.
     *
     * @see CoverArray::keys()
     * @see array_keys()
     */
    public function testKeysWithMixedKeyTypesAndAnotherIntegerValueFilter(): void
    {
        $data = ['a' => 1, 0 => 2, 'c' => 1, 1 => 2];

        $expected = array_keys($data, 2, true);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keys(2, true)->getDataAsArray());
    }

    /**
     * Tests the keys() method with CoverArray as filter value.
     *
     * This test verifies that the keys() method correctly handles
     * CoverArray objects as filter values, comparing them appropriately
     * according to the strictness setting.
     *
     * Note: When comparing objects with array_keys(), PHP compares
     * object identity (same instance) for strict comparison and
     * object equality (same class and property values) for loose comparison.
     *
     *
     * Тестирование метода keys() с CoverArray в качестве значения фильтра.
     *
     * Этот тест проверяет, что метод keys() корректно обрабатывает
     * объекты CoverArray в качестве значений фильтра, сравнивая их соответствующим образом
     * в соответствии с настройкой строгости.
     *
     * Примечание: При сравнении объектов с array_keys(), PHP сравнивает
     * идентичность объектов (тот же экземпляр) для строгого сравнения и
     * равенство объектов (тот же класс и значения свойств) для нестрогого сравнения.
     *
     * @see CoverArray::keys()
     * @see array_keys()
     */
    public function testKeysWithCoverArrayAsFilterValue(): void
    {
        // Create a CoverArray instance for the array element
        // Создаем экземпляр CoverArray для элемента массива
        $coverArrayForElement = new CoverArray(['x' => 1]);

        $data = [
            'a' => $coverArrayForElement, // Same instance / Тот же экземпляр
            'b' => new CoverArray(['x' => 1]), // Different instance, same data / Другой экземпляр, те же данные
            'c' => new CoverArray(['y' => 2])  // Different data / Другие данные
        ];

        // For strict comparison, only the same instance will match
        // Для строгого сравнения совпадет только тот же экземпляр
        $expected = array_keys($data, $coverArrayForElement, true);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keys($coverArrayForElement, true)->getDataAsArray());
    }

    /**
     * Tests the keys() method with CoverArray as filter value using strict comparison.
     *
     * This test verifies that the keys() method correctly handles
     * CoverArray objects as filter values with strict comparison,
     * requiring object identity.
     *
     *
     * Тестирование метода keys() с CoverArray в качестве значения фильтра и строгим сравнением.
     *
     * Этот тест проверяет, что метод keys() корректно обрабатывает
     * объекты CoverArray в качестве значений фильтра с строгим сравнением,
     * требуя идентичности объектов.
     *
     * @see CoverArray::keys()
     * @see array_keys()
     */
    public function testKeysWithCoverArrayAsFilterValueStrictComparison(): void
    {
        // Create a CoverArray instance for the array element
        // Создаем экземпляр CoverArray для элемента массива
        $coverArrayForElement = new CoverArray(['x' => 1]);

        $data = [
            'a' => $coverArrayForElement, // Same instance / Тот же экземпляр
            'b' => new CoverArray(['x' => 1]), // Different instance, same data / Другой экземпляр, те же данные
            'c' => new CoverArray(['y' => 2])  // Different data / Другие данные
        ];

        // For strict comparison, only the same instance will match
        // Для строгого сравнения совпадет только тот же экземпляр
        $expected = array_keys($data, $coverArrayForElement, true);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keys($coverArrayForElement, true)->getDataAsArray());
    }

    /**
     * Tests the keys() method with nested CoverArray as filter value using strict comparison.
     *
     * This test verifies that the keys() method correctly handles
     * nested CoverArray objects as filter values with strict comparison.
     *
     *
     * Тестирование метода keys() с вложенным CoverArray в качестве значения фильтра и строгим сравнением.
     *
     * Этот тест проверяет, что метод keys() корректно обрабатывает
     * вложенные объекты CoverArray в качестве значений фильтра с строгим сравнением.
     *
     * @see CoverArray::keys()
     * @see array_keys()
     */
    public function testKeysWithNestedCoverArrayAsFilterValueStrictComparison(): void
    {
        $nestedCoverArray = new CoverArray([
            'inner' => new CoverArray(['deep' => 'value'])
        ]);

        $data = [
            'a' => $nestedCoverArray,
            'b' => new CoverArray([
                'inner' => new CoverArray(['deep' => 'value'])
            ]),
            'c' => new CoverArray([
                'inner' => new CoverArray(['deep' => 'different'])
            ])
        ];

        // Strict comparison - only same instance
        // Строгое сравнение - только тот же экземпляр
        $expected = array_keys($data, $nestedCoverArray, true);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keys($nestedCoverArray, true)->getDataAsArray());
    }

    /**
     * Tests the keys() method with CoverArray containing other objects.
     *
     * This test verifies that the keys() method correctly handles
     * CoverArray objects containing other objects as values.
     *
     *
     * Тестирование метода keys() с CoverArray, содержащим другие объекты.
     *
     * Этот тест проверяет, что метод keys() корректно обрабатывает
     * объекты CoverArray, содержащие другие объекты в качестве значений.
     *
     * @see CoverArray::keys()
     * @see array_keys()
     */
    public function testKeysWithCoverArrayContainingObjects(): void
    {
        $object = new \stdClass();
        $object->id = 1;

        $data = [
            'a' => new CoverArray(['obj' => $object]),
            'b' => new CoverArray(['obj' => $object]),
            'c' => new CoverArray(['obj' => new \stdClass()])
        ];

        $filterCoverArray = new CoverArray(['obj' => $object]);

        // Strict comparison - will only match exact same instance
        // Строгое сравнение - совпадет только точный тот же экземпляр
        $expected = array_keys($data, $filterCoverArray, true);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keys($filterCoverArray, true)->getDataAsArray());
    }

    /**
     * Tests the keys() method with nested CoverArray as filter value.
     *
     * This test verifies that the keys() method correctly handles
     * nested CoverArray objects as filter values.
     *
     *
     * Тестирование метода keys() с вложенным CoverArray в качестве значения фильтра.
     *
     * Этот тест проверяет, что метод keys() корректно обрабатывает
     * вложенные объекты CoverArray в качестве значений фильтра.
     *
     * @see CoverArray::keys()
     * @see array_keys()
     */
    public function testKeysWithNestedCoverArrayAsFilterValue(): void
    {
        $nestedCoverArray = new CoverArray([
            'inner' => new CoverArray(['deep' => 'value'])
        ]);

        $data = [
            'a' => $nestedCoverArray,
            'b' => new CoverArray([
                'inner' => new CoverArray(['deep' => 'value'])
            ]),
            'c' => new CoverArray([
                'inner' => new CoverArray(['deep' => 'different'])
            ])
        ];

        // Strict comparison - only same instance
        // Строгое сравнение - только тот же экземпляр
        $expected = array_keys($data, $nestedCoverArray, true);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keys($nestedCoverArray, true)->getDataAsArray());
    }
}