<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class CombineTest extends TestCase
{
    /**
     * Tests the combine() method (array_combine equivalent).
     *
     * This test verifies that the combine() static method correctly creates
     * a new CoverArray by using one array for keys and another for values,
     * mirroring the behavior of PHP's array_combine() function.
     *
     *
     * Тестирование метода combine() (эквивалент array_combine).
     *
     * Этот тест проверяет, что статический метод combine() корректно создает
     * новый CoverArray, используя один массив для ключей, а другой для значений,
     * отражая поведение функции array_combine() PHP.
     *
     * @see CoverArray::combine()
     * @see array_combine()
     */
    public function testCombineMethod(): void
    {
        $keys = ['name', 'age', 'city'];
        $values = ['John', 30, 'New York'];

        $expected = array_combine($keys, $values);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            CoverArray::combine(
                $keys,
                $values
            )->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            CoverArray::combine(
                new CoverArray($keys),
                new CoverArray($values)
            )->getDataAsArray()
        );
    }
}