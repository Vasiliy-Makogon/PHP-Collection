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
     * Tests the fillKeys() method (array_fill_keys equivalent).
     *
     * This test verifies that the fillKeys() static method correctly creates
     * a CoverArray and fills it with a specified value using provided keys,
     * mirroring PHP's array_fill_keys() function behavior.
     *
     *
     * Тестирование метода fillKeys() (эквивалент array_fill_keys).
     *
     * Этот тест проверяет, что статический метод fillKeys() корректно создает
     * CoverArray и заполняет его указанным значением с использованием предоставленных ключей,
     * отражая поведение функции array_fill_keys() PHP.
     *
     * @see CoverArray::fillKeys()
     * @see array_fill_keys()
     */
    public function testFillKeysMethod(): void
    {
        // Test with string and integer keys
        // Тест со строковыми и целочисленными ключами
        $keys1 = ['foo', 5, 10, 'bar'];
        $value1 = 'banana';

        $expected1 = array_fill_keys($keys1, $value1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            CoverArray::fillKeys($keys1, $value1)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            CoverArray::fillKeys(new CoverArray($keys1), $value1)->getDataAsArray()
        );

        // Test with only string keys
        // Тест только со строковыми ключами
        $keys2 = ['name', 'age', 'city'];
        $value2 = 'unknown';

        $expected2 = array_fill_keys($keys2, $value2);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            CoverArray::fillKeys($keys2, $value2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            CoverArray::fillKeys(new CoverArray($keys2), $value2)->getDataAsArray()
        );

        // Test with only numeric keys
        // Тест только с числовыми ключами
        $keys3 = [0, 1, 2, 3];
        $value3 = 42;

        $expected3 = array_fill_keys($keys3, $value3);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            CoverArray::fillKeys($keys3, $value3)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            CoverArray::fillKeys(new CoverArray($keys3), $value3)->getDataAsArray()
        );

        // Test with mixed types in value (array)
        // Тест со смешанными типами в значении (массив)
        $keys4 = ['a', 'b', 'c'];
        $value4 = ['nested' => 'value'];

        $expected4 = array_fill_keys($keys4, $value4);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            CoverArray::fillKeys($keys4, $value4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            CoverArray::fillKeys(new CoverArray($keys4), $value4)->getDataAsArray()
        );

        // Test with null value
        // Тест со значением null
        $keys5 = ['x', 'y', 'z'];
        $value5 = null;

        $expected5 = array_fill_keys($keys5, $value5);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            CoverArray::fillKeys($keys5, $value5)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            CoverArray::fillKeys(new CoverArray($keys5), $value5)->getDataAsArray()
        );

        // Test with empty keys array
        // Тест с пустым массивом ключей
        $keys6 = [];
        $value6 = 'any';

        $expected6 = array_fill_keys($keys6, $value6);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected6,
            CoverArray::fillKeys($keys6, $value6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected6,
            CoverArray::fillKeys(new CoverArray($keys6), $value6)->getDataAsArray()
        );

        // Test with duplicate keys (should create array with duplicate keys, which is allowed)
        // Тест с дублирующимися ключами (должен создать массив с дублирующимися ключами, что разрешено)
        $keys7 = ['a', 'b', 'a', 'c'];
        $value7 = 'duplicate';

        $expected7 = array_fill_keys($keys7, $value7);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected7,
            CoverArray::fillKeys($keys7, $value7)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected7,
            CoverArray::fillKeys(new CoverArray($keys7), $value7)->getDataAsArray()
        );
    }
}