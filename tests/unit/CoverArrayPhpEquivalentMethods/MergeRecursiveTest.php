<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class MergeRecursiveTest extends TestCase
{
    /**
     * Tests the mergeRecursive() method with nested associative keys.
     *
     * This test verifies that the mergeRecursive() method correctly merges
     * arrays with nested associative keys, combining values for identical
     * string keys into arrays, mirroring PHP's array_merge_recursive() function.
     *
     *
     * Тестирование метода mergeRecursive() с вложенными ассоциативными ключами.
     *
     * Этот тест проверяет, что метод mergeRecursive() корректно объединяет
     * массивы с вложенными ассоциативными ключами, объединяя значения для одинаковых
     * строковых ключей в массивы, отражая функцию array_merge_recursive() PHP.
     *
     * @see CoverArray::mergeRecursive()
     * @see array_merge_recursive()
     */
    public function testMergeRecursiveWithNestedAssociativeKeys(): void
    {
        $data1 = ['color' => ['favorite' => 'red'], 5];
        $data2 = [10, 'color' => ['favorite' => 'green', 'blue']];

        $expected = array_merge_recursive($data1, $data2);

        $cover1 = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover1->mergeRecursive($data2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover1->mergeRecursive(new CoverArray($data2))->getDataAsArray()
        );
    }

    /**
     * Tests the mergeRecursive() method with identical string keys at different levels.
     *
     * This test verifies that the mergeRecursive() method correctly handles
     * identical string keys at different nesting levels, merging them appropriately,
     * mirroring PHP's array_merge_recursive() function.
     *
     *
     * Тестирование метода mergeRecursive() с одинаковыми строковыми ключами на разных уровнях.
     *
     * Этот тест проверяет, что метод mergeRecursive() корректно обрабатывает
     * одинаковые строковые ключи на разных уровнях вложенности, объединяя их соответствующим образом,
     * отражая функцию array_merge_recursive() PHP.
     *
     * @see CoverArray::mergeRecursive()
     * @see array_merge_recursive()
     */
    public function testMergeRecursiveWithIdenticalStringKeysAtDifferentLevels(): void
    {
        $data3 = [
            'user' => [
                'name' => 'John',
                'contacts' => ['email' => 'john@example.com']
            ],
            'settings' => ['theme' => 'dark']
        ];

        $data4 = [
            'user' => [
                'age' => 30,
                'contacts' => ['phone' => '123-456-7890']
            ],
            'settings' => ['language' => 'en']
        ];

        $expected = array_merge_recursive($data3, $data4);

        $cover3 = new CoverArray($data3);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover3->mergeRecursive($data4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover3->mergeRecursive(new CoverArray($data4))->getDataAsArray()
        );
    }

    /**
     * Tests the mergeRecursive() method with numeric keys.
     *
     * This test verifies that the mergeRecursive() method correctly handles
     * numeric keys by reindexing them rather than merging, mirroring
     * PHP's array_merge_recursive() function behavior.
     *
     *
     * Тестирование метода mergeRecursive() с числовыми ключами.
     *
     * Этот тест проверяет, что метод mergeRecursive() корректно обрабатывает
     * числовые ключи, переиндексируя их вместо объединения, отражая
     * поведение функции array_merge_recursive() PHP.
     *
     * @see CoverArray::mergeRecursive()
     * @see array_merge_recursive()
     */
    public function testMergeRecursiveWithNumericKeys(): void
    {
        $data5 = [0 => ['a', 'b'], 1 => ['c', 'd']];
        $data6 = [0 => ['e', 'f'], 1 => ['g', 'h']];

        $expected = array_merge_recursive($data5, $data6);

        $cover5 = new CoverArray($data5);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover5->mergeRecursive($data6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover5->mergeRecursive(new CoverArray($data6))->getDataAsArray()
        );
    }

    /**
     * Tests the mergeRecursive() method with three arrays.
     *
     * This test verifies that the mergeRecursive() method correctly merges
     * three arrays recursively, handling multiple levels of nesting,
     * mirroring PHP's array_merge_recursive() function.
     *
     *
     * Тестирование метода mergeRecursive() с тремя массивами.
     *
     * Этот тест проверяет, что метод mergeRecursive() корректно объединяет
     * три массива рекурсивно, обрабатывая несколько уровней вложенности,
     * отражая функцию array_merge_recursive() PHP.
     *
     * @see CoverArray::mergeRecursive()
     * @see array_merge_recursive()
     */
    public function testMergeRecursiveWithThreeArrays(): void
    {
        $data7 = ['a' => ['x' => 1]];
        $data8 = ['a' => ['y' => 2]];
        $data9 = ['a' => ['z' => 3]];

        $expected = array_merge_recursive($data7, $data8, $data9);

        $cover7 = new CoverArray($data7);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover7->mergeRecursive($data8, $data9)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover7->mergeRecursive(new CoverArray($data8), new CoverArray($data9))->getDataAsArray()
        );
    }

    /**
     * Tests the mergeRecursive() method with empty arrays.
     *
     * This test verifies that the mergeRecursive() method correctly handles
     * empty arrays, returning the original array unchanged, mirroring
     * PHP's array_merge_recursive() function behavior.
     *
     *
     * Тестирование метода mergeRecursive() с пустыми массивами.
     *
     * Этот тест проверяет, что метод mergeRecursive() корректно обрабатывает
     * пустые массивы, возвращая исходный массив без изменений, отражая
     * поведение функции array_merge_recursive() PHP.
     *
     * @see CoverArray::mergeRecursive()
     * @see array_merge_recursive()
     */
    public function testMergeRecursiveWithEmptyArrays(): void
    {
        $data10 = ['key' => 'value', 'nested' => ['a' => 1]];
        $data11 = [];

        $expected = array_merge_recursive($data10, $data11);

        $cover10 = new CoverArray($data10);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover10->mergeRecursive($data11)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover10->mergeRecursive(new CoverArray($data11))->getDataAsArray()
        );
    }

    /**
     * Tests the mergeRecursive() method with scalar values for same string key.
     *
     * This test verifies that the mergeRecursive() method correctly creates
     * an array from scalar values when the same string key exists in both arrays,
     * mirroring PHP's array_merge_recursive() function behavior.
     *
     *
     * Тестирование метода mergeRecursive() со скалярными значениями для одного строкового ключа.
     *
     * Этот тест проверяет, что метод mergeRecursive() корректно создает
     * массив из скалярных значений, когда один и тот же строковый ключ существует в обоих массивах,
     * отражая поведение функции array_merge_recursive() PHP.
     *
     * @see CoverArray::mergeRecursive()
     * @see array_merge_recursive()
     */
    public function testMergeRecursiveWithScalarValuesForSameStringKey(): void
    {
        $data12 = ['fruit' => 'apple'];
        $data13 = ['fruit' => 'banana'];

        $expected = array_merge_recursive($data12, $data13);

        $cover12 = new CoverArray($data12);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover12->mergeRecursive($data13)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover12->mergeRecursive(new CoverArray($data13))->getDataAsArray()
        );
    }

    /**
     * Tests the mergeRecursive() method with mixed numeric and string keys.
     *
     * This test verifies that the mergeRecursive() method correctly handles
     * arrays with both numeric and string keys, reindexing numeric keys
     * while merging string keys recursively, mirroring PHP's array_merge_recursive() function.
     *
     *
     * Тестирование метода mergeRecursive() со смешанными числовыми и строковыми ключами.
     *
     * Этот тест проверяет, что метод mergeRecursive() корректно обрабатывает
     * массивы с числовыми и строковыми ключами, переиндексируя числовые ключи
     * и объединяя строковые ключи рекурсивно, отражая функцию array_merge_recursive() PHP.
     *
     * @see CoverArray::mergeRecursive()
     * @see array_merge_recursive()
     */
    public function testMergeRecursiveWithMixedNumericAndStringKeys(): void
    {
        $data14 = [0 => 'zero', 'a' => ['x' => 1]];
        $data15 = [0 => 'ZERO', 'a' => ['y' => 2], 'b' => 'new'];

        $expected = array_merge_recursive($data14, $data15);

        $cover14 = new CoverArray($data14);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover14->mergeRecursive($data15)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover14->mergeRecursive(new CoverArray($data15))->getDataAsArray()
        );
    }

    /**
     * Tests the mergeRecursive() method with arrays containing CoverArray values.
     *
     * This test verifies that the mergeRecursive() method correctly handles
     * arrays containing CoverArray objects as values, converting them appropriately
     * during the merge process.
     *
     *
     * Тестирование метода mergeRecursive() с массивами, содержащими значения типа CoverArray.
     *
     * Этот тест проверяет, что метод mergeRecursive() корректно обрабатывает
     * массивы, содержащие объекты CoverArray как значения, преобразуя их соответствующим образом
     * в процессе объединения.
     *
     * @see CoverArray::mergeRecursive()
     * @see array_merge_recursive()
     */
    public function testMergeRecursiveWithCoverArrayValues(): void
    {
        $innerCover = new CoverArray(['inner' => 'value']);
        $data16 = ['key' => $innerCover, 'scalar' => 'test'];
        $data17 = ['key' => ['additional' => 'data'], 'scalar' => 'extra'];

        // Ожидаемый результат после преобразования CoverArray в массив
        $expected = array_merge_recursive(
            ['key' => ['inner' => 'value'], 'scalar' => 'test'],
            $data17
        );

        $cover16 = new CoverArray($data16);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover16->mergeRecursive($data17)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover16->mergeRecursive(new CoverArray($data17))->getDataAsArray()
        );
    }

    /**
     * Tests the mergeRecursive() method with multiple CoverArray arguments.
     *
     * This test verifies that the mergeRecursive() method correctly handles
     * multiple CoverArray objects as arguments, converting them appropriately
     * during the merge process.
     *
     *
     * Тестирование метода mergeRecursive() с несколькими аргументами типа CoverArray.
     *
     * Этот тест проверяет, что метод mergeRecursive() корректно обрабатывает
     * несколько объектов CoverArray в качестве аргументов, преобразуя их соответствующим образом
     * в процессе объединения.
     *
     * @see CoverArray::mergeRecursive()
     * @see array_merge_recursive()
     */
    public function testMergeRecursiveWithMultipleCoverArrayArguments(): void
    {
        $data18 = ['a' => 1, 'b' => ['x' => 10]];
        $data19 = ['b' => ['y' => 20], 'c' => 30];
        $data20 = ['a' => 100, 'c' => ['z' => 300]];

        $expected = array_merge_recursive($data18, $data19, $data20);

        $cover18 = new CoverArray($data18);
        $cover19 = new CoverArray($data19);
        $cover20 = new CoverArray($data20);

        // Все аргументы как CoverArray
        // All arguments as CoverArray
        $result = $cover18->mergeRecursive($cover19, $cover20);
        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the mergeRecursive() method with deeply nested arrays.
     *
     * This test verifies that the mergeRecursive() method correctly handles
     * deeply nested arrays, merging them appropriately at all levels,
     * mirroring PHP's array_merge_recursive() function.
     *
     *
     * Тестирование метода mergeRecursive() с глубоко вложенными массивами.
     *
     * Этот тест проверяет, что метод mergeRecursive() корректно обрабатывает
     * глубоко вложенные массивы, объединяя их соответствующим образом на всех уровнях,
     * отражая функцию array_merge_recursive() PHP.
     *
     * @see CoverArray::mergeRecursive()
     * @see array_merge_recursive()
     */
    public function testMergeRecursiveWithDeeplyNestedArrays(): void
    {
        $data21 = [
            'level1' => [
                'level2' => [
                    'level3' => ['a' => 1, 'b' => 2],
                    'scalar' => 'test'
                ]
            ]
        ];

        $data22 = [
            'level1' => [
                'level2' => [
                    'level3' => ['b' => 20, 'c' => 30],
                    'scalar' => 'new',
                    'extra' => 'value'
                ],
                'new' => 'data'
            ]
        ];

        $expected = array_merge_recursive($data21, $data22);

        $cover21 = new CoverArray($data21);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover21->mergeRecursive($data22)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover21->mergeRecursive(new CoverArray($data22))->getDataAsArray()
        );
    }
}