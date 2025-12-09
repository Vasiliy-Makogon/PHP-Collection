<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class ReverseTest extends TestCase
{
    /**
     * Tests the reverse() method (array_reverse equivalent).
     *
     * This test verifies that the reverse() method correctly returns
     * a new CoverArray with elements in reverse order, with optional
     * key preservation, mirroring PHP's array_reverse() function.
     * The method should not modify the original CoverArray instance.
     *
     *
     * Тестирование метода reverse() (эквивалент array_reverse).
     *
     * Этот тест проверяет, что метод reverse() корректно возвращает
     * новый CoverArray с элементами в обратном порядке, с опциональным
     * сохранением ключей, отражая функцию array_reverse() PHP.
     * Метод не должен изменять исходный экземпляр CoverArray.
     *
     * @see CoverArray::reverse()
     * @see array_reverse()
     */
    public function testReverseMethod(): void
    {
        // Test 1: Simple numeric array without key preservation (default)
        // Тест 1: Простой числовой массив без сохранения ключей (по умолчанию)
        $data1 = ['PHP', 'MySql', 'JavaScript'];
        $cover1 = new CoverArray($data1);

        $expected1 = array_reverse($data1, false);
        $result1 = $cover1->reverse();

        $this->assertSame(
            $expected1,
            $result1->getDataAsArray(),
            'Simple array should be reversed without key preservation'
        );

        // Test 2: Simple numeric array with key preservation
        // Тест 2: Простой числовой массив с сохранением ключей
        $result2 = $cover1->reverse(true);
        $expected2 = array_reverse($data1, true);

        $this->assertSame(
            $expected2,
            $result2->getDataAsArray(),
            'Simple array should be reversed with key preservation'
        );

        // Test 3: Verify original object is not modified
        // Тест 3: Проверяем, что исходный объект не изменен
        $this->assertSame(
            $data1,
            $cover1->getDataAsArray(),
            'Original CoverArray should not be modified by reverse()'
        );

        // Test 4: Associative array (keys should always be preserved)
        // Тест 4: Ассоциативный массив (ключи всегда должны сохраняться)
        $data2 = ['first' => 'PHP', 'second' => 'MySql', 'third' => 'JavaScript'];
        $cover2 = new CoverArray($data2);

        $expected3 = array_reverse($data2, false); // Для ассоциативного массива ключи сохраняются всегда
        $result3 = $cover2->reverse();

        $this->assertSame(
            $expected3,
            $result3->getDataAsArray(),
            'Associative array keys should be preserved in reverse'
        );

        // Test 5: Mixed keys (numeric and string)
        // Тест 5: Смешанные ключи (числовые и строковые)
        $data3 = [0 => 'PHP', 'lang' => 'MySql', 1 => 'JavaScript', 'db' => 'PostgreSQL'];
        $cover3 = new CoverArray($data3);

        $expected4 = array_reverse($data3, false);
        $result4 = $cover3->reverse();

        $this->assertSame(
            $expected4,
            $result4->getDataAsArray(),
            'Mixed key array should be reversed correctly'
        );

        // Test 6: Empty array
        // Тест 6: Пустой массив
        $emptyCover = new CoverArray([]);
        $emptyResult = $emptyCover->reverse();

        $this->assertSame(
            [],
            $emptyResult->getDataAsArray(),
            'Empty array should remain empty when reversed'
        );

        // Test 7: Single element array
        // Тест 7: Массив с одним элементом
        $singleData = ['only' => 'element'];
        $singleCover = new CoverArray($singleData);
        $singleResult = $singleCover->reverse();

        $this->assertSame(
            $singleData, // Обратный массив из одного элемента равен самому себе
            $singleResult->getDataAsArray(),
            'Single element array should be unchanged when reversed'
        );

        // Test 8: Array with gaps in numeric indices
        // Тест 8: Массив с пропусками в числовых индексах
        $data4 = [0 => 'PHP', 2 => 'MySql', 5 => 'JavaScript'];
        $cover4 = new CoverArray($data4);

        $expected5 = array_reverse($data4, false);
        $result5 = $cover4->reverse();

        $this->assertSame(
            $expected5,
            $result5->getDataAsArray(),
            'Array with gaps in indices should be reversed correctly'
        );

        // Test 9: Verify method returns CoverArray instance
        // Тест 9: Проверяем, что метод возвращает экземпляр CoverArray
        $this->assertInstanceOf(
            CoverArray::class,
            $cover1->reverse(),
            'reverse() should return a CoverArray instance'
        );

        // Test 10: Multidimensional array (reverse only top level)
        // Тест 10: Многомерный массив (обратный порядок только на верхнем уровне)
        $multiData = [
            'first' => ['PHP', 'MySql'],
            'second' => ['HTML', 'CSS'],
            'third' => ['JavaScript', 'TypeScript']
        ];
        $multiCover = new CoverArray($multiData);

        $expected6 = array_reverse($multiData, true);
        $result6 = $multiCover->reverse(true);

        $this->assertSame(
            $expected6,
            $result6->getDataAsArray(),
            'Multidimensional array should reverse only top level'
        );
    }
}