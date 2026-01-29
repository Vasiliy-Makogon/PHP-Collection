<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class ImplodeTest extends TestCase
{
    /**
     * Tests the implode() method with basic array.
     *
     * This test verifies that the implode() method correctly joins
     * array elements with a separator,
     * mirroring PHP's implode() function behavior.
     *
     *
     * Тестирование метода implode() с базовым массивом.
     *
     * Этот тест проверяет, что метод implode() корректно объединяет
     * элементы массива с разделителем,
     * отражая поведение функции implode() PHP.
     *
     * @see CoverArray::implode()
     * @see implode()
     */
    public function testImplodeWithBasicArray(): void
    {
        $data = ['apple', 'banana', 'cherry'];
        $dataCopy = $data;
        $separator = ', ';

        $expected = implode($separator, $data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->implode($separator);

        // Check imploded string
        $this->assertSame($expected, $result);
        $this->assertSame('apple, banana, cherry', $result);
    }

    /**
     * Tests the implode() method with empty array.
     *
     * This test verifies that the implode() method returns
     * an empty string for empty arrays,
     * mirroring PHP's implode() function behavior.
     *
     *
     * Тестирование метода implode() с пустым массивом.
     *
     * Этот тест проверяет, что метод implode() возвращает
     * пустую строку для пустых массивов,
     * отражая поведение функции implode() PHP.
     *
     * @see CoverArray::implode()
     * @see implode()
     */
    public function testImplodeWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;
        $separator = ', ';

        $expected = implode($separator, $data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->implode($separator);

        // Check empty string
        $this->assertSame($expected, $result);
        $this->assertSame('', $result);
    }

    /**
     * Tests the implode() method with single element.
     *
     * This test verifies that the implode() method returns
     * the single element as string without separator,
     * mirroring PHP's implode() function behavior.
     *
     *
     * Тестирование метода implode() с одним элементом.
     *
     * Этот тест проверяет, что метод implode() возвращает
     * единственный элемент как строку без разделителя,
     * отражая поведение функции implode() PHP.
     *
     * @see CoverArray::implode()
     * @see implode()
     */
    public function testImplodeWithSingleElement(): void
    {
        $data = ['only'];
        $dataCopy = $data;
        $separator = ', ';

        $expected = implode($separator, $data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->implode($separator);

        // Check single element
        $this->assertSame($expected, $result);
        $this->assertSame('only', $result);
    }

    /**
     * Tests the implode() method with empty separator.
     *
     * This test verifies that the implode() method joins
     * elements without any separator when separator is empty,
     * mirroring PHP's implode() function behavior.
     *
     *
     * Тестирование метода implode() с пустым разделителем.
     *
     * Этот тест проверяет, что метод implode() объединяет
     * элементы без разделителя, когда разделитель пустой,
     * отражая поведение функции implode() PHP.
     *
     * @see CoverArray::implode()
     * @see implode()
     */
    public function testImplodeWithEmptySeparator(): void
    {
        $data = ['a', 'b', 'c'];
        $dataCopy = $data;
        $separator = '';

        $expected = implode($separator, $data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->implode($separator);

        // Check concatenated string
        $this->assertSame($expected, $result);
        $this->assertSame('abc', $result);
    }

    /**
     * Tests the implode() method with comma separator.
     *
     * This test verifies that the implode() method correctly joins
     * elements with comma separator,
     * mirroring PHP's implode() function behavior.
     *
     *
     * Тестирование метода implode() с разделителем-запятой.
     *
     * Этот тест проверяет, что метод implode() корректно объединяет
     * элементы с разделителем-запятой,
     * отражая поведение функции implode() PHP.
     *
     * @see CoverArray::implode()
     * @see implode()
     */
    public function testImplodeWithCommaSeparator(): void
    {
        $data = ['one', 'two', 'three'];
        $dataCopy = $data;
        $separator = ',';

        $expected = implode($separator, $data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->implode($separator);

        // Check result
        $this->assertSame($expected, $result);
        $this->assertSame('one,two,three', $result);
    }

    /**
     * Tests the implode() method with space separator.
     *
     * This test verifies that the implode() method correctly joins
     * elements with space separator,
     * mirroring PHP's implode() function behavior.
     *
     *
     * Тестирование метода implode() с разделителем-пробелом.
     *
     * Этот тест проверяет, что метод implode() корректно объединяет
     * элементы с разделителем-пробелом,
     * отражая поведение функции implode() PHP.
     *
     * @see CoverArray::implode()
     * @see implode()
     */
    public function testImplodeWithSpaceSeparator(): void
    {
        $data = ['Hello', 'World', '!'];
        $dataCopy = $data;
        $separator = ' ';

        $expected = implode($separator, $data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->implode($separator);

        // Check result
        $this->assertSame($expected, $result);
        $this->assertSame('Hello World !', $result);
    }

    /**
     * Tests the implode() method with numeric values.
     *
     * This test verifies that the implode() method converts
     * numeric values to strings and joins them,
     * mirroring PHP's implode() function behavior.
     *
     *
     * Тестирование метода implode() с числовыми значениями.
     *
     * Этот тест проверяет, что метод implode() преобразует
     * числовые значения в строки и объединяет их,
     * отражая поведение функции implode() PHP.
     *
     * @see CoverArray::implode()
     * @see implode()
     */
    public function testImplodeWithNumericValues(): void
    {
        $data = [1, 2, 3, 4, 5];
        $dataCopy = $data;
        $separator = '-';

        $expected = implode($separator, $data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->implode($separator);

        // Check result
        $this->assertSame($expected, $result);
        $this->assertSame('1-2-3-4-5', $result);
    }

    /**
     * Tests the implode() method with mixed types.
     *
     * This test verifies that the implode() method converts
     * mixed types to strings and joins them,
     * mirroring PHP's implode() function behavior.
     *
     *
     * Тестирование метода implode() со смешанными типами.
     *
     * Этот тест проверяет, что метод implode() преобразует
     * смешанные типы в строки и объединяет их,
     * отражая поведение функции implode() PHP.
     *
     * @see CoverArray::implode()
     * @see implode()
     */
    public function testImplodeWithMixedTypes(): void
    {
        $data = [123, 'text', 45.67, true];
        $dataCopy = $data;
        $separator = ' | ';

        $expected = implode($separator, $data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->implode($separator);

        // Check result
        $this->assertSame($expected, $result);
        $this->assertSame('123 | text | 45.67 | 1', $result);
    }

    /**
     * Tests the implode() method with string keys.
     *
     * This test verifies that the implode() method joins
     * values from associative arrays ignoring keys,
     * mirroring PHP's implode() function behavior.
     *
     *
     * Тестирование метода implode() со строковыми ключами.
     *
     * Этот тест проверяет, что метод implode() объединяет
     * значения из ассоциативных массивов, игнорируя ключи,
     * отражая поведение функции implode() PHP.
     *
     * @see CoverArray::implode()
     * @see implode()
     */
    public function testImplodeWithStringKeys(): void
    {
        $data = ['first' => 'a', 'second' => 'b', 'third' => 'c'];
        $dataCopy = $data;
        $separator = ', ';

        $expected = implode($separator, $data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->implode($separator);

        // Check values are joined (keys ignored)
        $this->assertSame($expected, $result);
        $this->assertSame('a, b, c', $result);
    }

    /**
     * Tests the implode() method with special characters.
     *
     * This test verifies that the implode() method correctly handles
     * special characters in separator and values,
     * mirroring PHP's implode() function behavior.
     *
     *
     * Тестирование метода implode() со специальными символами.
     *
     * Этот тест проверяет, что метод implode() корректно обрабатывает
     * специальные символы в разделителе и значениях,
     * отражая поведение функции implode() PHP.
     *
     * @see CoverArray::implode()
     * @see implode()
     */
    public function testImplodeWithSpecialCharacters(): void
    {
        $data = ['line1', 'line2', 'line3'];
        $dataCopy = $data;
        $separator = "\n";

        $expected = implode($separator, $data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->implode($separator);

        // Check result with newline separator
        $this->assertSame($expected, $result);
        $this->assertSame("line1\nline2\nline3", $result);
    }

    /**
     * Tests the implode() method with HTML separator.
     *
     * This test verifies that the implode() method correctly uses
     * HTML tags as separator,
     * mirroring PHP's implode() function behavior.
     *
     *
     * Тестирование метода implode() с HTML-разделителем.
     *
     * Этот тест проверяет, что метод implode() корректно использует
     * HTML-теги как разделитель,
     * отражая поведение функции implode() PHP.
     *
     * @see CoverArray::implode()
     * @see implode()
     */
    public function testImplodeWithHtmlSeparator(): void
    {
        $data = ['Item 1', 'Item 2', 'Item 3'];
        $dataCopy = $data;
        $separator = '<br>';

        $expected = implode($separator, $data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->implode($separator);

        // Check result
        $this->assertSame($expected, $result);
        $this->assertSame('Item 1<br>Item 2<br>Item 3', $result);
    }
}
