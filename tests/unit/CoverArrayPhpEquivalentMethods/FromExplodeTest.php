<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class FromExplodeTest extends TestCase
{
    /**
     * Tests the fromExplode() method with comma separator.
     *
     * This test verifies that the fromExplode() static method correctly creates
     * a new CoverArray by splitting a string with a comma separator,
     * mirroring the behavior of PHP's explode() function.
     *
     *
     * Тестирование метода fromExplode() с разделителем-запятой.
     *
     * Этот тест проверяет, что статический метод fromExplode() корректно создает
     * новый CoverArray, разбивая строку с разделителем-запятой,
     * отражая поведение функции explode() PHP.
     *
     * @see CoverArray::fromExplode()
     * @see explode()
     */
    public function testFromExplodeWithCommaSeparator(): void
    {
        $string = 'apple,banana,cherry';
        $separator = ',';

        $expected = explode($separator, $string);
        $result = CoverArray::fromExplode($separator, $string);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fromExplode() method with space separator.
     *
     * This test verifies that the fromExplode() static method correctly creates
     * a new CoverArray by splitting a string with a space separator,
     * mirroring the behavior of PHP's explode() function.
     *
     *
     * Тестирование метода fromExplode() с разделителем-пробелом.
     *
     * Этот тест проверяет, что статический метод fromExplode() корректно создает
     * новый CoverArray, разбивая строку с разделителем-пробелом,
     * отражая поведение функции explode() PHP.
     *
     * @see CoverArray::fromExplode()
     * @see explode()
     */
    public function testFromExplodeWithSpaceSeparator(): void
    {
        $string = 'hello world from PHP';
        $separator = ' ';

        $expected = explode($separator, $string);
        $result = CoverArray::fromExplode($separator, $string);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fromExplode() method with positive limit.
     *
     * This test verifies that the fromExplode() static method correctly creates
     * a new CoverArray with a positive limit parameter,
     * mirroring the behavior of PHP's explode() function.
     *
     *
     * Тестирование метода fromExplode() с положительным лимитом.
     *
     * Этот тест проверяет, что статический метод fromExplode() корректно создает
     * новый CoverArray с положительным параметром лимита,
     * отражая поведение функции explode() PHP.
     *
     * @see CoverArray::fromExplode()
     * @see explode()
     */
    public function testFromExplodeWithPositiveLimit(): void
    {
        $string = 'a,b,c,d,e';
        $separator = ',';
        $limit = 3;

        $expected = explode($separator, $string, $limit);
        $result = CoverArray::fromExplode($separator, $string, $limit);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fromExplode() method with negative limit.
     *
     * This test verifies that the fromExplode() static method correctly creates
     * a new CoverArray with a negative limit parameter,
     * mirroring the behavior of PHP's explode() function.
     *
     *
     * Тестирование метода fromExplode() с отрицательным лимитом.
     *
     * Этот тест проверяет, что статический метод fromExplode() корректно создает
     * новый CoverArray с отрицательным параметром лимита,
     * отражая поведение функции explode() PHP.
     *
     * @see CoverArray::fromExplode()
     * @see explode()
     */
    public function testFromExplodeWithNegativeLimit(): void
    {
        $string = 'a,b,c,d,e';
        $separator = ',';
        $limit = -2;

        $expected = explode($separator, $string, $limit);
        $result = CoverArray::fromExplode($separator, $string, $limit);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fromExplode() method with limit of 1.
     *
     * This test verifies that the fromExplode() static method correctly creates
     * a new CoverArray with a limit of 1, returning the original string,
     * mirroring the behavior of PHP's explode() function.
     *
     *
     * Тестирование метода fromExplode() с лимитом 1.
     *
     * Этот тест проверяет, что статический метод fromExplode() корректно создает
     * новый CoverArray с лимитом 1, возвращая исходную строку,
     * отражая поведение функции explode() PHP.
     *
     * @see CoverArray::fromExplode()
     * @see explode()
     */
    public function testFromExplodeWithLimitOne(): void
    {
        $string = 'a,b,c,d,e';
        $separator = ',';
        $limit = 1;

        $expected = explode($separator, $string, $limit);
        $result = CoverArray::fromExplode($separator, $string, $limit);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fromExplode() method with multi-character separator.
     *
     * This test verifies that the fromExplode() static method correctly creates
     * a new CoverArray by splitting a string with a multi-character separator,
     * mirroring the behavior of PHP's explode() function.
     *
     *
     * Тестирование метода fromExplode() с многосимвольным разделителем.
     *
     * Этот тест проверяет, что статический метод fromExplode() корректно создает
     * новый CoverArray, разбивая строку многосимвольным разделителем,
     * отражая поведение функции explode() PHP.
     *
     * @see CoverArray::fromExplode()
     * @see explode()
     */
    public function testFromExplodeWithMultiCharacterSeparator(): void
    {
        $string = 'apple::banana::cherry';
        $separator = '::';

        $expected = explode($separator, $string);
        $result = CoverArray::fromExplode($separator, $string);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fromExplode() method with separator not present in string.
     *
     * This test verifies that the fromExplode() static method correctly creates
     * a new CoverArray with a single element when separator is not found,
     * mirroring the behavior of PHP's explode() function.
     *
     *
     * Тестирование метода fromExplode() с разделителем, отсутствующим в строке.
     *
     * Этот тест проверяет, что статический метод fromExplode() корректно создает
     * новый CoverArray с одним элементом, когда разделитель не найден,
     * отражая поведение функции explode() PHP.
     *
     * @see CoverArray::fromExplode()
     * @see explode()
     */
    public function testFromExplodeWithSeparatorNotPresent(): void
    {
        $string = 'apple banana cherry';
        $separator = ',';

        $expected = explode($separator, $string);
        $result = CoverArray::fromExplode($separator, $string);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fromExplode() method with empty string.
     *
     * This test verifies that the fromExplode() static method correctly creates
     * a new CoverArray with a single empty element when input string is empty,
     * mirroring the behavior of PHP's explode() function.
     *
     *
     * Тестирование метода fromExplode() с пустой строкой.
     *
     * Этот тест проверяет, что статический метод fromExplode() корректно создает
     * новый CoverArray с одним пустым элементом, когда входная строка пуста,
     * отражая поведение функции explode() PHP.
     *
     * @see CoverArray::fromExplode()
     * @see explode()
     */
    public function testFromExplodeWithEmptyString(): void
    {
        $string = '';
        $separator = ',';

        $expected = explode($separator, $string);
        $result = CoverArray::fromExplode($separator, $string);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fromExplode() method with empty separator throws ValueError.
     *
     * This test verifies that the fromExplode() static method throws a ValueError
     * when the separator is empty, mirroring the behavior of PHP's explode() function.
     *
     *
     * Тестирование метода fromExplode() с пустым разделителем выбрасывает ValueError.
     *
     * Этот тест проверяет, что статический метод fromExplode() выбрасывает ValueError,
     * когда разделитель пуст, отражая поведение функции explode() PHP.
     *
     * @see CoverArray::fromExplode()
     * @see explode()
     */
    public function testFromExplodeWithEmptySeparatorThrowsValueError(): void
    {
        $string = 'abc';
        $separator = '';

        $this->expectException(\ValueError::class);
        CoverArray::fromExplode($separator, $string);
    }

    /**
     * Tests the fromExplode() method with consecutive separators.
     *
     * This test verifies that the fromExplode() static method correctly creates
     * a new CoverArray with empty elements when consecutive separators are present,
     * mirroring the behavior of PHP's explode() function.
     *
     *
     * Тестирование метода fromExplode() с последовательными разделителями.
     *
     * Этот тест проверяет, что статический метод fromExplode() корректно создает
     * новый CoverArray с пустыми элементами при наличии последовательных разделителей,
     * отражая поведение функции explode() PHP.
     *
     * @see CoverArray::fromExplode()
     * @see explode()
     */
    public function testFromExplodeWithConsecutiveSeparators(): void
    {
        $string = 'a,,b,,,c';
        $separator = ',';

        $expected = explode($separator, $string);
        $result = CoverArray::fromExplode($separator, $string);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fromExplode() method with separator at the beginning.
     *
     * This test verifies that the fromExplode() static method correctly creates
     * a new CoverArray with an empty first element when separator is at the beginning,
     * mirroring the behavior of PHP's explode() function.
     *
     *
     * Тестирование метода fromExplode() с разделителем в начале.
     *
     * Этот тест проверяет, что статический метод fromExplode() корректно создает
     * новый CoverArray с пустым первым элементом, когда разделитель в начале,
     * отражая поведение функции explode() PHP.
     *
     * @see CoverArray::fromExplode()
     * @see explode()
     */
    public function testFromExplodeWithSeparatorAtBeginning(): void
    {
        $string = ',apple,banana';
        $separator = ',';

        $expected = explode($separator, $string);
        $result = CoverArray::fromExplode($separator, $string);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fromExplode() method with separator at the end.
     *
     * This test verifies that the fromExplode() static method correctly creates
     * a new CoverArray with an empty last element when separator is at the end,
     * mirroring the behavior of PHP's explode() function.
     *
     *
     * Тестирование метода fromExplode() с разделителем в конце.
     *
     * Этот тест проверяет, что статический метод fromExplode() корректно создает
     * новый CoverArray с пустым последним элементом, когда разделитель в конце,
     * отражая поведение функции explode() PHP.
     *
     * @see CoverArray::fromExplode()
     * @see explode()
     */
    public function testFromExplodeWithSeparatorAtEnd(): void
    {
        $string = 'apple,banana,';
        $separator = ',';

        $expected = explode($separator, $string);
        $result = CoverArray::fromExplode($separator, $string);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fromExplode() method with special characters in separator.
     *
     * This test verifies that the fromExplode() static method correctly creates
     * a new CoverArray using special characters as separator,
     * mirroring the behavior of PHP's explode() function.
     *
     *
     * Тестирование метода fromExplode() со специальными символами в разделителе.
     *
     * Этот тест проверяет, что статический метод fromExplode() корректно создает
     * новый CoverArray, используя специальные символы в качестве разделителя,
     * отражая поведение функции explode() PHP.
     *
     * @see CoverArray::fromExplode()
     * @see explode()
     */
    public function testFromExplodeWithSpecialCharactersInSeparator(): void
    {
        $string = 'apple|banana|cherry';
        $separator = '|';

        $expected = explode($separator, $string);
        $result = CoverArray::fromExplode($separator, $string);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fromExplode() method with numeric strings.
     *
     * This test verifies that the fromExplode() static method correctly creates
     * a new CoverArray from numeric strings,
     * mirroring the behavior of PHP's explode() function.
     *
     *
     * Тестирование метода fromExplode() с числовыми строками.
     *
     * Этот тест проверяет, что статический метод fromExplode() корректно создает
     * новый CoverArray из числовых строк,
     * отражая поведение функции explode() PHP.
     *
     * @see CoverArray::fromExplode()
     * @see explode()
     */
    public function testFromExplodeWithNumericStrings(): void
    {
        $string = '1,2,3,4,5';
        $separator = ',';

        $expected = explode($separator, $string);
        $result = CoverArray::fromExplode($separator, $string);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fromExplode() method with whitespace in string.
     *
     * This test verifies that the fromExplode() static method correctly creates
     * a new CoverArray preserving whitespace in split parts,
     * mirroring the behavior of PHP's explode() function.
     *
     *
     * Тестирование метода fromExplode() с пробелами в строке.
     *
     * Этот тест проверяет, что статический метод fromExplode() корректно создает
     * новый CoverArray, сохраняя пробелы в разбитых частях,
     * отражая поведение функции explode() PHP.
     *
     * @see CoverArray::fromExplode()
     * @see explode()
     */
    public function testFromExplodeWithWhitespaceInString(): void
    {
        $string = ' apple , banana , cherry ';
        $separator = ',';

        $expected = explode($separator, $string);
        $result = CoverArray::fromExplode($separator, $string);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fromExplode() method with newline separator.
     *
     * This test verifies that the fromExplode() static method correctly creates
     * a new CoverArray by splitting a string with a newline separator,
     * mirroring the behavior of PHP's explode() function.
     *
     *
     * Тестирование метода fromExplode() с разделителем-переводом строки.
     *
     * Этот тест проверяет, что статический метод fromExplode() корректно создает
     * новый CoverArray, разбивая строку с разделителем-переводом строки,
     * отражая поведение функции explode() PHP.
     *
     * @see CoverArray::fromExplode()
     * @see explode()
     */
    public function testFromExplodeWithNewlineSeparator(): void
    {
        $string = "line1\nline2\nline3";
        $separator = "\n";

        $expected = explode($separator, $string);
        $result = CoverArray::fromExplode($separator, $string);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fromExplode() method with tab separator.
     *
     * This test verifies that the fromExplode() static method correctly creates
     * a new CoverArray by splitting a string with a tab separator,
     * mirroring the behavior of PHP's explode() function.
     *
     *
     * Тестирование метода fromExplode() с разделителем-табуляцией.
     *
     * Этот тест проверяет, что статический метод fromExplode() корректно создает
     * новый CoverArray, разбивая строку с разделителем-табуляцией,
     * отражая поведение функции explode() PHP.
     *
     * @see CoverArray::fromExplode()
     * @see explode()
     */
    public function testFromExplodeWithTabSeparator(): void
    {
        $string = "col1\tcol2\tcol3";
        $separator = "\t";

        $expected = explode($separator, $string);
        $result = CoverArray::fromExplode($separator, $string);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fromExplode() method with UTF-8 strings.
     *
     * This test verifies that the fromExplode() static method correctly creates
     * a new CoverArray from UTF-8 encoded strings,
     * mirroring the behavior of PHP's explode() function.
     *
     *
     * Тестирование метода fromExplode() со строками UTF-8.
     *
     * Этот тест проверяет, что статический метод fromExplode() корректно создает
     * новый CoverArray из строк в кодировке UTF-8,
     * отражая поведение функции explode() PHP.
     *
     * @see CoverArray::fromExplode()
     * @see explode()
     */
    public function testFromExplodeWithUtf8Strings(): void
    {
        $string = 'яблоко,банан,вишня';
        $separator = ',';

        $expected = explode($separator, $string);
        $result = CoverArray::fromExplode($separator, $string);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the fromExplode() method with single character string.
     *
     * This test verifies that the fromExplode() static method correctly creates
     * a new CoverArray from a single character string,
     * mirroring the behavior of PHP's explode() function.
     *
     *
     * Тестирование метода fromExplode() со строкой из одного символа.
     *
     * Этот тест проверяет, что статический метод fromExplode() корректно создает
     * новый CoverArray из строки с одним символом,
     * отражая поведение функции explode() PHP.
     *
     * @see CoverArray::fromExplode()
     * @see explode()
     */
    public function testFromExplodeWithSingleCharacterString(): void
    {
        $string = 'a';
        $separator = ',';

        $expected = explode($separator, $string);
        $result = CoverArray::fromExplode($separator, $string);

        $this->assertSame($expected, $result->getDataAsArray());
    }
}
