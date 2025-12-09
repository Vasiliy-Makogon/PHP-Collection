<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class IsListTest extends TestCase
{
    /**
     * Tests the isList() method (array_is_list equivalent).
     *
     * This test verifies that the isList() method correctly determines
     * whether the CoverArray represents a list (sequential integer keys
     * starting from 0), mirroring PHP's array_is_list() function.
     *
     *
     * Тестирование метода isList() (эквивалент array_is_list).
     *
     * Этот тест проверяет, что метод isList() корректно определяет,
     * представляет ли CoverArray список (последовательные целочисленные ключи,
     * начинающиеся с 0), отражая функцию array_is_list() PHP.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListMethod(): void
    {
        // Define test cases with expected results
        // Определяем тестовые случаи с ожидаемыми результатами
        $testCases = [
            // Пустые массивы
            ['data' => [], 'expected' => true],

            // Простые списки
            ['data' => [1, 2, 3], 'expected' => true],
            ['data' => ['a', 'b', 'c'], 'expected' => true],
            ['data' => [0 => 'a', 1 => 'b', 2 => 'c'], 'expected' => true],

            // Не списки (пропущенные ключи)
            ['data' => [0 => 'a', 2 => 'b', 3 => 'c'], 'expected' => false],
            ['data' => [1 => 'a', 2 => 'b', 3 => 'c'], 'expected' => false],
            ['data' => [0 => 'a', 1 => 'b', 3 => 'c'], 'expected' => false],

            // Не списки (неправильный порядок)
            ['data' => [2 => 'a', 1 => 'b', 0 => 'c'], 'expected' => false],
            ['data' => [0 => 'a', 2 => 'b', 1 => 'c'], 'expected' => false],

            // Строковые ключи-числа
            ['data' => ['0' => 'a', '1' => 'b', '2' => 'c'], 'expected' => true],  // Должен быть списком
            ['data' => ['1' => 'a', '2' => 'b', '3' => 'c'], 'expected' => false],  // Не список (начинается с 1)
            ['data' => ['0' => 'a', '2' => 'b', '3' => 'c'], 'expected' => false],  // Не список (пропущен 1)

            // Строковые ключи с ведущими нулями
            ['data' => ['00' => 'a', '01' => 'b', '02' => 'c'], 'expected' => false],  // Не список (ведущие нули)
            ['data' => ['000' => 'a', '001' => 'b'], 'expected' => false],  // Не список

            // Смешанные ключи
            ['data' => ['0' => 'a', 1 => 'b', '2' => 'c'], 'expected' => true],  // Должен быть списком
            ['data' => [0 => 'a', '1' => 'b', 2 => 'c'], 'expected' => true],    // Должен быть списком

            // Ассоциативные массивы
            ['data' => ['a' => 1, 'b' => 2, 'c' => 3], 'expected' => false],
            ['data' => [0 => 'a', 'foo' => 'b', 2 => 'c'], 'expected' => false],
            ['data' => ['0' => 'a', 'foo' => 'b', '2' => 'c'], 'expected' => false],

            // Массивы с одним элементом
            ['data' => [0 => 'a'], 'expected' => true],
            ['data' => [1 => 'a'], 'expected' => false],
            ['data' => ['0' => 'a'], 'expected' => true],
            ['data' => ['1' => 'a'], 'expected' => false],
            ['data' => ['foo' => 'a'], 'expected' => false],

            // Большие массивы
            ['data' => range(0, 100), 'expected' => true],
            ['data' => array_fill(0, 100, 'value'), 'expected' => true],
            ['data' => array_fill(5, 10, 'value'), 'expected' => false],  // Начинается с 5

            // Массивы с отрицательными ключами
            ['data' => [-1 => 'a', 0 => 'b', 1 => 'c'], 'expected' => false],
            ['data' => [-5 => 'a', -4 => 'b'], 'expected' => false],

            // Специальные случаи
            ['data' => [0 => 'a', '01' => 'b'], 'expected' => false],  // '01' !== 1
            ['data' => [0 => 'a', '1' => 'b', '02' => 'c'], 'expected' => false],  // '02' !== 2

            // Пустые строки как значения (не влияют на проверку)
            ['data' => [0 => '', 1 => null, 2 => false], 'expected' => true],

            // Вложенные массивы (не влияют на проверку ключей)
            ['data' => [0 => [1, 2], 1 => ['a' => 'b']], 'expected' => true],

            // Проблемные случаи с преобразованием типов
            ['data' => ['0' => 'a', 1 => 'b', '2' => 'c', '3' => 'd'], 'expected' => true],  // Должен быть списком
            ['data' => [0 => 'a', '1' => 'b', 2 => 'c', '3' => 'd'], 'expected' => true],    // Должен быть списком

            // Дополнительные тесты из оригинального теста
            ['data' => [0.0 => 'a', 1.0 => 'b', 2.0 => 'c'], 'expected' => true],
            ['data' => [' 0' => 'a', '1 ' => 'b', ' 2 ' => 'c'], 'expected' => false],
            ['data' => ['+0' => 'a', '+1' => 'b'], 'expected' => false],
            ['data' => ['0.0' => 'a', '1.0' => 'b'], 'expected' => false],
            ['data' => ['0x0' => 'a', '0x1' => 'b'], 'expected' => false],
            ['data' => ['1e0' => 'a', '1e1' => 'b'], 'expected' => false],
            ['data' => [true => 'a', false => 'b'], 'expected' => false],
            ['data' => [null => 'a', 1 => 'b'], 'expected' => false],
        ];

        foreach ($testCases as $index => $testCase) {
            $data = $testCase['data'];
            $expected = $testCase['expected'];

            $cover = new CoverArray($data);
            $result = $cover->isList();

            // If array_is_list function exists, compare with native implementation
            // Если функция array_is_list существует, сравниваем с нативной реализацией
            if (function_exists('array_is_list')) {
                $nativeResult = array_is_list($data);

                // Check that our implementation matches native implementation
                // Проверяем, что наша реализация совпадает с нативной
                $this->assertSame(
                    $nativeResult,
                    $result,
                    sprintf(
                        "Test case #%d failed: CoverArray::isList() result differs from array_is_list(). " .
                        "Data: %s, CoverArray::isList: %s, array_is_list: %s",
                        $index,
                        var_export($data, true),
                        var_export($result, true),
                        var_export($nativeResult, true)
                    )
                );

                // Also verify that our expected value matches native implementation
                // Также проверяем, что наше ожидаемое значение совпадает с нативной реализацией
                $this->assertSame(
                    $nativeResult,
                    $expected,
                    sprintf(
                        "Test case #%d: Expected value mismatch with array_is_list(). " .
                        "Data: %s, Expected: %s, array_is_list: %s",
                        $index,
                        var_export($data, true),
                        var_export($expected, true),
                        var_export($nativeResult, true)
                    )
                );
            } else {
                // If array_is_list doesn't exist, just check against our expected value
                // Если array_is_list не существует, просто проверяем по ожидаемому значению
                $this->assertSame(
                    $expected,
                    $result,
                    sprintf(
                        "Test case #%d failed: Data: %s, Expected: %s, Got: %s",
                        $index,
                        var_export($data, true),
                        var_export($expected, true),
                        var_export($result, true)
                    )
                );
            }
        }
    }
}