<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class InTest extends TestCase
{
    /**
     * Tests the in() method (in_array equivalent).
     *
     * This test verifies that the in() method correctly checks
     * whether a value exists in the CoverArray, with optional
     * strict type comparison, mirroring PHP's in_array() function.
     * The method should not modify the original CoverArray instance.
     *
     *
     * Тестирование метода in() (эквивалент in_array).
     *
     * Этот тест проверяет, что метод in() корректно проверяет,
     * существует ли значение в CoverArray, с опциональным
     * строгим сравнением типов, отражая функцию in_array() PHP.
     * Метод не должен изменять исходный экземпляр CoverArray.
     *
     * @see CoverArray::in()
     * @see in_array()
     */
    public function testInMethod(): void
    {
        // Test 1: Basic integer search with strict comparison (true)
        // Тест 1: Базовый поиск целого числа со строгим сравнением (true)
        $data1 = [1982, 1990, 2000];
        $cover1 = new CoverArray($data1);

        $this->assertSame(
            in_array(1982, $data1, true),
            $cover1->in(1982, true),
            'Should find integer 1982 with strict comparison'
        );

        // Test 2: Basic integer search with non-strict comparison (false)
        // Тест 2: Базовый поиск целого числа с нестрогим сравнением (false)
        $this->assertSame(
            in_array(1982, $data1, false),
            $cover1->in(1982, false),
            'Should find integer 1982 with non-strict comparison'
        );

        // Test 3: String vs integer with non-strict comparison
        // Тест 3: Строка против целого числа с нестрогим сравнением
        $this->assertSame(
            in_array('1982', $data1, false),
            $cover1->in('1982', false),
            'Should find string "1982" with non-strict comparison'
        );

        // Test 4: String vs integer with strict comparison
        // Тест 4: Строка против целого числа со строгим сравнением
        $this->assertSame(
            in_array('1982', $data1, true),
            $cover1->in('1982', true),
            'Should NOT find string "1982" with strict comparison'
        );

        // Test 5: Verify original object is not modified
        // Тест 5: Проверяем, что исходный объект не изменен
        $this->assertSame(
            $data1,
            $cover1->getDataAsArray(),
            'Original CoverArray should not be modified by in()'
        );

        // Test 6: Search for non-existent value
        // Тест 6: Поиск несуществующего значения
        $this->assertSame(
            in_array(9999, $data1, true),
            $cover1->in(9999, true),
            'Should NOT find non-existent value 9999'
        );

        // Test 7: Array with mixed types
        // Тест 7: Массив со смешанными типами
        $data2 = [42, '42', 42.0, true, false, null, 'string'];
        $cover2 = new CoverArray($data2);

        // Test strict comparison for various types
        // Тест строгого сравнения для различных типов
        $this->assertSame(
            in_array(42, $data2, true),
            $cover2->in(42, true),
            'Strict comparison: should find int 42'
        );

        $this->assertSame(
            in_array('42', $data2, true),
            $cover2->in('42', true),
            'Strict comparison: should find string "42"'
        );

        $this->assertSame(
            in_array(true, $data2, true),
            $cover2->in(true, true),
            'Strict comparison: should find boolean true'
        );

        $this->assertSame(
            in_array(null, $data2, true),
            $cover2->in(null, true),
            'Strict comparison: should find null'
        );

        // Test non-strict comparison for various types
        // Тест нестрогого сравнения для различных типов
        $this->assertSame(
            in_array(42, $data2, false),
            $cover2->in(42, false),
            'Non-strict comparison: should find int 42'
        );

        $this->assertSame(
            in_array('42', $data2, false),
            $cover2->in('42', false),
            'Non-strict comparison: should find string "42"'
        );

        $this->assertSame(
            in_array(true, $data2, false),
            $cover2->in(true, false),
            'Non-strict comparison: should find boolean true'
        );

        $this->assertSame(
            in_array(1, $data2, false),
            $cover2->in(1, false),
            'Non-strict comparison: should find int 1 (equals true)'
        );

        // Test 8: Empty array
        // Тест 8: Пустой массив
        $emptyCover = new CoverArray([]);
        $this->assertSame(
            in_array('anything', [], true),
            $emptyCover->in('anything', true),
            'Empty array should not contain any value'
        );

        // Test 9: Associative array search
        // Тест 9: Поиск в ассоциативном массиве
        $data3 = ['name' => 'John', 'age' => 30, 'city' => 'New York'];
        $cover3 = new CoverArray($data3);

        $this->assertSame(
            in_array('John', $data3, true),
            $cover3->in('John', true),
            'Should find value in associative array'
        );

        $this->assertSame(
            in_array(30, $data3, true),
            $cover3->in(30, true),
            'Should find numeric value in associative array'
        );

        // Test 10: Nested array search (in_array does not search recursively)
        // Тест 10: Поиск во вложенном массиве (in_array не ищет рекурсивно)
        $data4 = ['top' => ['nested' => 'value'], 'other' => 'test'];
        $cover4 = new CoverArray($data4);

        $this->assertSame(
            in_array(['nested' => 'value'], $data4, true),
            $cover4->in(['nested' => 'value'], true),
            'Should find nested array as a whole'
        );

        $this->assertSame(
            in_array('value', $data4, true),
            $cover4->in('value', true),
            'Should NOT find value inside nested array (in_array is not recursive)'
        );

        // Test 11: Case-sensitive string comparison
        // Тест 11: Регистрозависимое сравнение строк
        $data5 = ['PHP', 'MySQL', 'JavaScript'];
        $cover5 = new CoverArray($data5);

        $this->assertSame(
            in_array('php', $data5, true),
            $cover5->in('php', true),
            'Strict comparison: should NOT find lowercase "php"'
        );

        $this->assertSame(
            in_array('PHP', $data5, true),
            $cover5->in('PHP', true),
            'Strict comparison: should find uppercase "PHP"'
        );

        // Test 12: Float comparison
        // Тест 12: Сравнение чисел с плавающей точкой
        $data6 = [1.5, 2.0, 3.14159];
        $cover6 = new CoverArray($data6);

        $this->assertSame(
            in_array(1.5, $data6, true),
            $cover6->in(1.5, true),
            'Should find exact float 1.5'
        );

        $this->assertSame(
            in_array(2, $data6, false),
            $cover6->in(2, false),
            'Non-strict: should find int 2 equals float 2.0'
        );

        $this->assertSame(
            in_array(2, $data6, true),
            $cover6->in(2, true),
            'Strict: should NOT find int 2 in float array'
        );

        // Test 13: Default strict parameter (should be false)
        // Тест 13: Параметр strict по умолчанию (должен быть false)
        $data7 = ['10', 10, 20];
        $cover7 = new CoverArray($data7);

        $this->assertSame(
            in_array(10, $data7, false), // Default behavior of in_array() is false
            $cover7->in(10), // Should use default strict = false
            'Default strict parameter should be false'
        );

        $this->assertSame(
            in_array('10', $data7, false),
            $cover7->in('10'),
            'Default strict parameter should be false for string "10"'
        );
    }
}