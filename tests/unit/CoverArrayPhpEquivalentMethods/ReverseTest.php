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
     * Tests the reverse() method without key preservation.
     *
     * This test verifies that the reverse() method correctly returns
     * a new CoverArray with elements in reverse order without preserving
     * keys for numeric arrays, mirroring PHP's array_reverse() function
     * with $preserve_keys set to false.
     *
     *
     * Тестирование метода reverse() без сохранения ключей.
     *
     * Этот тест проверяет, что метод reverse() корректно возвращает
     * новый CoverArray с элементами в обратном порядке без сохранения
     * ключей для числовых массивов, отражая функцию array_reverse() PHP
     * с $preserve_keys установленным в false.
     *
     * @see CoverArray::reverse()
     * @see array_reverse()
     */
    public function testReverseWithoutKeyPreservation(): void
    {
        $data = ['PHP', 'MySql', 'JavaScript'];

        $expected = array_reverse($data, false);

        $cover = new CoverArray($data);
        $result = $cover->reverse();

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the reverse() method with key preservation.
     *
     * This test verifies that the reverse() method correctly returns
     * a new CoverArray with elements in reverse order while preserving
     * keys for numeric arrays, mirroring PHP's array_reverse() function
     * with $preserve_keys set to true.
     *
     *
     * Тестирование метода reverse() с сохранением ключей.
     *
     * Этот тест проверяет, что метод reverse() корректно возвращает
     * новый CoverArray с элементами в обратном порядке с сохранением
     * ключей для числовых массивов, отражая функцию array_reverse() PHP
     * с $preserve_keys установленным в true.
     *
     * @see CoverArray::reverse()
     * @see array_reverse()
     */
    public function testReverseWithKeyPreservation(): void
    {
        $data = ['PHP', 'MySql', 'JavaScript'];

        $expected = array_reverse($data, true);

        $cover = new CoverArray($data);
        $result = $cover->reverse(true);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the reverse() method with associative array.
     *
     * This test verifies that the reverse() method correctly handles
     * associative arrays, preserving keys regardless of the $preserve_keys
     * parameter, mirroring PHP's array_reverse() function behavior.
     *
     *
     * Тестирование метода reverse() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод reverse() корректно обрабатывает
     * ассоциативные массивы, сохраняя ключи независимо от параметра
     * $preserve_keys, отражая поведение функции array_reverse() PHP.
     *
     * @see CoverArray::reverse()
     * @see array_reverse()
     */
    public function testReverseWithAssociativeArray(): void
    {
        $data = ['first' => 'PHP', 'second' => 'MySql', 'third' => 'JavaScript'];

        $expected = array_reverse($data, false);

        $cover = new CoverArray($data);
        $result = $cover->reverse();

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the reverse() method with mixed keys.
     *
     * This test verifies that the reverse() method correctly handles
     * arrays with both numeric and string keys, reversing the order
     * while appropriately handling key preservation, mirroring PHP's
     * array_reverse() function.
     *
     *
     * Тестирование метода reverse() со смешанными ключами.
     *
     * Этот тест проверяет, что метод reverse() корректно обрабатывает
     * массивы с числовыми и строковыми ключами, меняя порядок элементов
     * и правильно обрабатывая сохранение ключей, отражая функцию
     * array_reverse() PHP.
     *
     * @see CoverArray::reverse()
     * @see array_reverse()
     */
    public function testReverseWithMixedKeys(): void
    {
        $data = [0 => 'PHP', 'lang' => 'MySql', 1 => 'JavaScript', 'db' => 'PostgreSQL'];

        $expected = array_reverse($data, false);

        $cover = new CoverArray($data);
        $result = $cover->reverse();

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the reverse() method with empty array.
     *
     * This test verifies that the reverse() method correctly handles
     * empty arrays, returning an empty array without errors,
     * mirroring PHP's array_reverse() function.
     *
     *
     * Тестирование метода reverse() с пустым массивом.
     *
     * Этот тест проверяет, что метод reverse() корректно обрабатывает
     * пустые массивы, возвращая пустой массив без ошибок,
     * отражая функцию array_reverse() PHP.
     *
     * @see CoverArray::reverse()
     * @see array_reverse()
     */
    public function testReverseWithEmptyArray(): void
    {
        $data = [];

        $expected = array_reverse($data, false);

        $cover = new CoverArray($data);
        $result = $cover->reverse();

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the reverse() method with single element array.
     *
     * This test verifies that the reverse() method correctly handles
     * arrays with a single element, returning the same array,
     * mirroring PHP's array_reverse() function.
     *
     *
     * Тестирование метода reverse() с массивом из одного элемента.
     *
     * Этот тест проверяет, что метод reverse() корректно обрабатывает
     * массивы с одним элементом, возвращая тот же массив,
     * отражая функцию array_reverse() PHP.
     *
     * @see CoverArray::reverse()
     * @see array_reverse()
     */
    public function testReverseWithSingleElementArray(): void
    {
        $data = ['only' => 'element'];

        $expected = array_reverse($data, false);

        $cover = new CoverArray($data);
        $result = $cover->reverse();

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the reverse() method with array containing gaps in numeric indices.
     *
     * This test verifies that the reverse() method correctly handles
     * arrays with gaps in numeric indices, reversing the order while
     * appropriately reindexing numeric keys when not preserving keys,
     * mirroring PHP's array_reverse() function.
     *
     *
     * Тестирование метода reverse() с массивом с пропусками в числовых индексах.
     *
     * Этот тест проверяет, что метод reverse() корректно обрабатывает
     * массивы с пропусками в числовых индексах, меняя порядок элементов
     * и правильно переиндексируя числовые ключи при отсутствии сохранения ключей,
     * отражая функцию array_reverse() PHP.
     *
     * @see CoverArray::reverse()
     * @see array_reverse()
     */
    public function testReverseWithArrayHavingGapsInIndices(): void
    {
        $data = [0 => 'PHP', 2 => 'MySql', 5 => 'JavaScript'];

        $expected = array_reverse($data, false);

        $cover = new CoverArray($data);
        $result = $cover->reverse();

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the reverse() method returns CoverArray instance.
     *
     * This test verifies that the reverse() method returns a new
     * CoverArray instance rather than a plain array.
     *
     *
     * Тестирование, что метод reverse() возвращает экземпляр CoverArray.
     *
     * Этот тест проверяет, что метод reverse() возвращает новый
     * экземпляр CoverArray, а не обычный массив.
     *
     * @see CoverArray::reverse()
     */
    public function testReverseReturnsCoverArrayInstance(): void
    {
        $data = ['PHP', 'MySql', 'JavaScript'];

        $cover = new CoverArray($data);
        $result = $cover->reverse();

        $this->assertInstanceOf(CoverArray::class, $result);
    }

    /**
     * Tests the reverse() method with multidimensional array.
     *
     * This test verifies that the reverse() method correctly handles
     * multidimensional arrays, reversing only the top level while
     * preserving the internal structure of nested arrays,
     * mirroring PHP's array_reverse() function.
     *
     *
     * Тестирование метода reverse() с многомерным массивом.
     *
     * Этот тест проверяет, что метод reverse() корректно обрабатывает
     * многомерные массивы, меняя порядок только на верхнем уровне
     * и сохраняя внутреннюю структуру вложенных массивов,
     * отражая функцию array_reverse() PHP.
     *
     * @see CoverArray::reverse()
     * @see array_reverse()
     */
    public function testReverseWithMultidimensionalArray(): void
    {
        $data = [
            'first' => ['PHP', 'MySql'],
            'second' => ['HTML', 'CSS'],
            'third' => ['JavaScript', 'TypeScript']
        ];

        $expected = array_reverse($data, true);

        $cover = new CoverArray($data);
        $result = $cover->reverse(true);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the reverse() method with CoverArray as value.
     *
     * This test verifies that the reverse() method correctly handles
     * CoverArray objects as values in the array, preserving them
     * without modification during the reversal process.
     *
     *
     * Тестирование метода reverse() со значением типа CoverArray.
     *
     * Этот тест проверяет, что метод reverse() корректно обрабатывает
     * объекты CoverArray как значения в массиве, сохраняя их
     * без изменений в процессе обращения порядка.
     *
     * @see CoverArray::reverse()
     * @see array_reverse()
     */
    public function testReverseWithCoverArrayValue(): void
    {
        $innerCover = new CoverArray(['x' => 1, 'y' => 2]);
        $anotherCover = new CoverArray(['a' => 'b']);

        $data = [
            'first' => $innerCover,
            'second' => 'regular',
            'third' => $anotherCover
        ];

        $cover = new CoverArray($data);
        $result = $cover->reverse(true);

        // Проверяем, что порядок ключей изменился
        $this->assertSame(['third', 'second', 'first'], array_keys($result->getDataAsArray()));

        // Проверяем, что первый элемент (теперь 'third') содержит правильный CoverArray
        $this->assertInstanceOf(CoverArray::class, $result['third']);
        $this->assertSame(['a' => 'b'], $result['third']->getDataAsArray());

        // Проверяем, что второй элемент (теперь 'second') содержит строку
        $this->assertSame('regular', $result['second']);

        // Проверяем, что третий элемент (теперь 'first') содержит правильный CoverArray
        $this->assertInstanceOf(CoverArray::class, $result['first']);
        $this->assertSame(['x' => 1, 'y' => 2], $result['first']->getDataAsArray());
    }
}