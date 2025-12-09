<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class FillKeysTest extends TestCase
{
    /**
     * Tests the fillKeys() method with string and integer keys.
     *
     * This test verifies that the fillKeys() static method correctly creates
     * a CoverArray with mixed string and integer keys filled with a specified value,
     * mirroring PHP's array_fill_keys() function.
     *
     *
     * Тестирование метода fillKeys() со строковыми и целочисленными ключами.
     *
     * Этот тест проверяет, что статический метод fillKeys() корректно создает
     * CoverArray со смешанными строковыми и целочисленными ключами, заполненными указанным значением,
     * отражая функцию array_fill_keys() PHP.
     *
     * @see CoverArray::fillKeys()
     * @see array_fill_keys()
     */
    public function testFillKeysWithStringAndIntegerKeys(): void
    {
        // Test with string and integer keys
        // Тест со строковыми и целочисленными ключами
        $keys = ['foo', 5, 10, 'bar'];
        $value = 'banana';

        $expected = array_fill_keys($keys, $value);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            CoverArray::fillKeys($keys, $value)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            CoverArray::fillKeys(new CoverArray($keys), $value)->getDataAsArray()
        );
    }

    /**
     * Tests the fillKeys() method with only string keys.
     *
     * This test verifies that the fillKeys() static method correctly creates
     * a CoverArray with string keys filled with a specified value,
     * mirroring PHP's array_fill_keys() function.
     *
     *
     * Тестирование метода fillKeys() только со строковыми ключами.
     *
     * Этот тест проверяет, что статический метод fillKeys() корректно создает
     * CoverArray со строковыми ключами, заполненными указанным значением,
     * отражая функцию array_fill_keys() PHP.
     *
     * @see CoverArray::fillKeys()
     * @see array_fill_keys()
     */
    public function testFillKeysWithOnlyStringKeys(): void
    {
        // Test with only string keys
        // Тест только со строковыми ключами
        $keys = ['name', 'age', 'city'];
        $value = 'unknown';

        $expected = array_fill_keys($keys, $value);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            CoverArray::fillKeys($keys, $value)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            CoverArray::fillKeys(new CoverArray($keys), $value)->getDataAsArray()
        );
    }

    /**
     * Tests the fillKeys() method with only numeric keys.
     *
     * This test verifies that the fillKeys() static method correctly creates
     * a CoverArray with numeric keys filled with a specified value,
     * mirroring PHP's array_fill_keys() function.
     *
     *
     * Тестирование метода fillKeys() только с числовыми ключами.
     *
     * Этот тест проверяет, что статический метод fillKeys() корректно создает
     * CoverArray с числовыми ключами, заполненными указанным значением,
     * отражая функцию array_fill_keys() PHP.
     *
     * @see CoverArray::fillKeys()
     * @see array_fill_keys()
     */
    public function testFillKeysWithOnlyNumericKeys(): void
    {
        // Test with only numeric keys
        // Тест только с числовыми ключами
        $keys = [0, 1, 2, 3];
        $value = 42;

        $expected = array_fill_keys($keys, $value);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            CoverArray::fillKeys($keys, $value)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            CoverArray::fillKeys(new CoverArray($keys), $value)->getDataAsArray()
        );
    }

    /**
     * Tests the fillKeys() method with array value.
     *
     * This test verifies that the fillKeys() static method correctly creates
     * a CoverArray with array values for each key, mirroring PHP's array_fill_keys() function.
     *
     *
     * Тестирование метода fillKeys() со значением-массивом.
     *
     * Этот тест проверяет, что статический метод fillKeys() корректно создает
     * CoverArray со значениями-массивами для каждого ключа, отражая функцию array_fill_keys() PHP.
     *
     * @see CoverArray::fillKeys()
     * @see array_fill_keys()
     */
    public function testFillKeysWithArrayValue(): void
    {
        // Test with mixed types in value (array)
        // Тест со смешанными типами в значении (массив)
        $keys = ['a', 'b', 'c'];
        $value = ['nested' => 'value'];

        $expected = array_fill_keys($keys, $value);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            CoverArray::fillKeys($keys, $value)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            CoverArray::fillKeys(new CoverArray($keys), $value)->getDataAsArray()
        );
    }

    /**
     * Tests the fillKeys() method with null value.
     *
     * This test verifies that the fillKeys() static method correctly creates
     * a CoverArray with null values for each key, mirroring PHP's array_fill_keys() function.
     *
     *
     * Тестирование метода fillKeys() со значением null.
     *
     * Этот тест проверяет, что статический метод fillKeys() корректно создает
     * CoverArray со значениями null для каждого ключа, отражая функцию array_fill_keys() PHP.
     *
     * @see CoverArray::fillKeys()
     * @see array_fill_keys()
     */
    public function testFillKeysWithNullValue(): void
    {
        // Test with null value
        // Тест со значением null
        $keys = ['x', 'y', 'z'];
        $value = null;

        $expected = array_fill_keys($keys, $value);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            CoverArray::fillKeys($keys, $value)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            CoverArray::fillKeys(new CoverArray($keys), $value)->getDataAsArray()
        );
    }

    /**
     * Tests the fillKeys() method with empty keys array.
     *
     * This test verifies that the fillKeys() static method correctly handles
     * an empty keys array, returning an empty CoverArray,
     * mirroring PHP's array_fill_keys() function.
     *
     *
     * Тестирование метода fillKeys() с пустым массивом ключей.
     *
     * Этот тест проверяет, что статический метод fillKeys() корректно обрабатывает
     * пустой массив ключей, возвращая пустой CoverArray,
     * отражая функцию array_fill_keys() PHP.
     *
     * @see CoverArray::fillKeys()
     * @see array_fill_keys()
     */
    public function testFillKeysWithEmptyKeysArray(): void
    {
        // Test with empty keys array
        // Тест с пустым массивом ключей
        $keys = [];
        $value = 'any';

        $expected = array_fill_keys($keys, $value);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            CoverArray::fillKeys($keys, $value)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            CoverArray::fillKeys(new CoverArray($keys), $value)->getDataAsArray()
        );
    }

    /**
     * Tests the fillKeys() method with duplicate keys.
     *
     * This test verifies that the fillKeys() static method correctly handles
     * duplicate keys, creating an array where later keys overwrite earlier ones,
     * mirroring PHP's array_fill_keys() function behavior.
     *
     *
     * Тестирование метода fillKeys() с дублирующимися ключами.
     *
     * Этот тест проверяет, что статический метод fillKeys() корректно обрабатывает
     * дублирующиеся ключи, создавая массив, где более поздние ключи перезаписывают более ранние,
     * отражая поведение функции array_fill_keys() PHP.
     *
     * @see CoverArray::fillKeys()
     * @see array_fill_keys()
     */
    public function testFillKeysWithDuplicateKeys(): void
    {
        // Test with duplicate keys (should create array with duplicate keys, which is allowed)
        // Тест с дублирующимися ключами (должен создать массив с дублирующимися ключами, что разрешено)
        $keys = ['a', 'b', 'a', 'c'];
        $value = 'duplicate';

        $expected = array_fill_keys($keys, $value);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            CoverArray::fillKeys($keys, $value)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            CoverArray::fillKeys(new CoverArray($keys), $value)->getDataAsArray()
        );
    }

    /**
     * Tests the fillKeys() method with boolean and other scalar values.
     *
     * This test verifies that the fillKeys() static method correctly handles
     * various scalar value types, mirroring PHP's array_fill_keys() function.
     *
     *
     * Тестирование метода fillKeys() с boolean и другими скалярными значениями.
     *
     * Этот тест проверяет, что статический метод fillKeys() корректно обрабатывает
     * различные типы скалярных значений, отражая функцию array_fill_keys() PHP.
     *
     * @see CoverArray::fillKeys()
     * @see array_fill_keys()
     */
    public function testFillKeysWithBooleanAndScalarValues(): void
    {
        // Test with boolean and scalar values
        // Тест с boolean и скалярными значениями
        $keys = ['true', 'false', 'int', 'float'];
        $value = true;

        $expected = array_fill_keys($keys, $value);

        $result = CoverArray::fillKeys($keys, $value);
        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fillKeys() method with mixed key types including numeric strings.
     *
     * This test verifies that the fillKeys() static method correctly handles
     * mixed key types including numeric strings, mirroring PHP's array_fill_keys() function.
     *
     *
     * Тестирование метода fillKeys() со смешанными типами ключей, включая числовые строки.
     *
     * Этот тест проверяет, что статический метод fillKeys() корректно обрабатывает
     * смешанные типы ключей, включая числовые строки, отражая функцию array_fill_keys() PHP.
     *
     * @see CoverArray::fillKeys()
     * @see array_fill_keys()
     */
    public function testFillKeysWithMixedKeyTypesIncludingNumericStrings(): void
    {
        // Test with mixed key types including numeric strings
        // Тест со смешанными типами ключей, включая числовые строки
        $keys = ['a', 1, '2', 3, 'b'];
        $value = 'mixed';

        $expected = array_fill_keys($keys, $value);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            CoverArray::fillKeys($keys, $value)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            CoverArray::fillKeys(new CoverArray($keys), $value)->getDataAsArray()
        );
    }
}