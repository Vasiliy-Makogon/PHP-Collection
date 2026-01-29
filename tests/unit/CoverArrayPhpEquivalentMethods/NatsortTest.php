<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class NatsortTest extends TestCase
{
    /**
     * Tests the natsort() method with basic string array.
     *
     * This test verifies that the natsort() method correctly sorts an array
     * using a "natural order" algorithm,
     * mirroring PHP's natsort() function behavior.
     *
     *
     * Тестирование метода natsort() с базовым строковым массивом.
     *
     * Этот тест проверяет, что метод natsort() корректно сортирует массив
     * с использованием алгоритма "естественного упорядочивания",
     * отражая поведение функции natsort() PHP.
     *
     * @see CoverArray::natsort()
     * @see natsort()
     */
    public function testNatsortWithBasicStrings(): void
    {
        $data = ['a' => 'img12.png', 'b' => 'img10.png', 'c' => 'img2.png', 'd' => 'img1.png'];
        $dataCopy = $data;

        natsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->natsort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the natsort() method with case-sensitive sorting.
     *
     * This test verifies that the natsort() method performs
     * case-sensitive sorting, treating 'IMG' and 'img' as different,
     * mirroring PHP's natsort() function behavior.
     *
     *
     * Тестирование метода natsort() с регистрозависимой сортировкой.
     *
     * Этот тест проверяет, что метод natsort() выполняет
     * регистрозависимую сортировку, рассматривая 'IMG' и 'img' как разные,
     * отражая поведение функции natsort() PHP.
     *
     * @see CoverArray::natsort()
     * @see natsort()
     */
    public function testNatsortCaseSensitive(): void
    {
        $data = ['a' => 'IMG12.png', 'b' => 'img10.png', 'c' => 'Img2.png', 'd' => 'IMG1.png'];
        $dataCopy = $data;

        natsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->natsort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the natsort() method with mixed case filenames.
     *
     * This test verifies that the natsort() method correctly sorts
     * filenames with mixed case using natural order,
     * mirroring PHP's natsort() function behavior.
     *
     *
     * Тестирование метода natsort() с именами файлов в смешанном регистре.
     *
     * Этот тест проверяет, что метод natsort() корректно сортирует
     * имена файлов в смешанном регистре, используя естественный порядок,
     * отражая поведение функции natsort() PHP.
     *
     * @see CoverArray::natsort()
     * @see natsort()
     */
    public function testNatsortWithMixedCaseFilenames(): void
    {
        $data = ['a' => 'file10.txt', 'b' => 'file2.txt', 'c' => 'File1.txt', 'd' => 'file20.txt'];
        $dataCopy = $data;

        natsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->natsort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the natsort() method with numbers in strings.
     *
     * This test verifies that the natsort() method correctly handles
     * natural sorting where numeric parts are sorted numerically,
     * mirroring PHP's natsort() function behavior.
     *
     *
     * Тестирование метода natsort() с числами в строках.
     *
     * Этот тест проверяет, что метод natsort() корректно обрабатывает
     * естественную сортировку, где числовые части сортируются численно,
     * отражая поведение функции natsort() PHP.
     *
     * @see CoverArray::natsort()
     * @see natsort()
     */
    public function testNatsortWithNumbersInStrings(): void
    {
        $data = ['a' => 'test100', 'b' => 'test2', 'c' => 'test20', 'd' => 'test3'];
        $dataCopy = $data;

        natsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->natsort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the natsort() method with empty array.
     *
     * This test verifies that the natsort() method correctly handles
     * empty arrays without errors,
     * mirroring PHP's natsort() function behavior.
     *
     *
     * Тестирование метода natsort() с пустым массивом.
     *
     * Этот тест проверяет, что метод natsort() корректно обрабатывает
     * пустые массивы без ошибок,
     * отражая поведение функции natsort() PHP.
     *
     * @see CoverArray::natsort()
     * @see natsort()
     */
    public function testNatsortWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        natsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->natsort();

        // Check array is still empty
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the natsort() method with single element.
     *
     * This test verifies that the natsort() method correctly handles
     * arrays with a single element,
     * mirroring PHP's natsort() function behavior.
     *
     *
     * Тестирование метода natsort() с одним элементом.
     *
     * Этот тест проверяет, что метод natsort() корректно обрабатывает
     * массивы с одним элементом,
     * отражая поведение функции natsort() PHP.
     *
     * @see CoverArray::natsort()
     * @see natsort()
     */
    public function testNatsortWithSingleElement(): void
    {
        $data = ['a' => 'file1.txt'];
        $dataCopy = $data;

        natsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->natsort();

        // Check array is unchanged
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the natsort() method preserving keys.
     *
     * This test verifies that the natsort() method maintains
     * the association between keys and values after sorting,
     * mirroring PHP's natsort() function behavior.
     *
     *
     * Тестирование метода natsort() с сохранением ключей.
     *
     * Этот тест проверяет, что метод natsort() сохраняет
     * ассоциацию между ключами и значениями после сортировки,
     * отражая поведение функции natsort() PHP.
     *
     * @see CoverArray::natsort()
     * @see natsort()
     */
    public function testNatsortPreservingKeys(): void
    {
        $data = ['first' => 'img100', 'second' => 'img2', 'third' => 'img10'];
        $dataCopy = $data;

        natsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->natsort();

        // Check sorted array and key preservation
        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertArrayHasKey('first', $cover->getDataAsArray());
        $this->assertArrayHasKey('second', $cover->getDataAsArray());
        $this->assertArrayHasKey('third', $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the natsort() method with version strings.
     *
     * This test verifies that the natsort() method correctly sorts
     * version strings using natural order,
     * mirroring PHP's natsort() function behavior.
     *
     *
     * Тестирование метода natsort() со строками версий.
     *
     * Этот тест проверяет, что метод natsort() корректно сортирует
     * строки версий, используя естественный порядок,
     * отражая поведение функции natsort() PHP.
     *
     * @see CoverArray::natsort()
     * @see natsort()
     */
    public function testNatsortWithVersionStrings(): void
    {
        $data = ['a' => 'version 1.10', 'b' => 'version 1.2', 'c' => 'version 1.1', 'd' => 'version 1.20'];
        $dataCopy = $data;

        natsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->natsort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the natsort() method with leading zeros.
     *
     * This test verifies that the natsort() method correctly handles
     * strings with leading zeros in natural sorting,
     * mirroring PHP's natsort() function behavior.
     *
     *
     * Тестирование метода natsort() с ведущими нулями.
     *
     * Этот тест проверяет, что метод natsort() корректно обрабатывает
     * строки с ведущими нулями при естественной сортировке,
     * отражая поведение функции natsort() PHP.
     *
     * @see CoverArray::natsort()
     * @see natsort()
     */
    public function testNatsortWithLeadingZeros(): void
    {
        $data = ['a' => 'img012', 'b' => 'img002', 'c' => 'img100', 'd' => 'img001'];
        $dataCopy = $data;

        natsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->natsort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the natsort() method with special characters.
     *
     * This test verifies that the natsort() method correctly sorts
     * strings containing special characters,
     * mirroring PHP's natsort() function behavior.
     *
     *
     * Тестирование метода natsort() со специальными символами.
     *
     * Этот тест проверяет, что метод natsort() корректно сортирует
     * строки, содержащие специальные символы,
     * отражая поведение функции natsort() PHP.
     *
     * @see CoverArray::natsort()
     * @see natsort()
     */
    public function testNatsortWithSpecialCharacters(): void
    {
        $data = ['a' => 'file-10.txt', 'b' => 'file-2.txt', 'c' => 'file_100.txt', 'd' => 'file_20.txt'];
        $dataCopy = $data;

        natsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->natsort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the natsort() method with alphanumeric strings.
     *
     * This test verifies that the natsort() method correctly sorts
     * complex alphanumeric strings,
     * mirroring PHP's natsort() function behavior.
     *
     *
     * Тестирование метода natsort() с алфавитно-цифровыми строками.
     *
     * Этот тест проверяет, что метод natsort() корректно сортирует
     * сложные алфавитно-цифровые строки,
     * отражая поведение функции natsort() PHP.
     *
     * @see CoverArray::natsort()
     * @see natsort()
     */
    public function testNatsortWithAlphanumericStrings(): void
    {
        $data = ['a' => 'item1b', 'b' => 'item1a', 'c' => 'item10b', 'd' => 'item2a'];
        $dataCopy = $data;

        natsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->natsort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }
}
