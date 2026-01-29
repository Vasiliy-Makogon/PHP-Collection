<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class NatcasesortTest extends TestCase
{
    /**
     * Tests the natcasesort() method with basic string array.
     *
     * This test verifies that the natcasesort() method correctly sorts an array
     * using a case-insensitive "natural order" algorithm,
     * mirroring PHP's natcasesort() function behavior.
     *
     *
     * Тестирование метода natcasesort() с базовым строковым массивом.
     *
     * Этот тест проверяет, что метод natcasesort() корректно сортирует массив
     * с использованием регистронезависимого алгоритма "естественной сортировки",
     * отражая поведение функции natcasesort() PHP.
     *
     * @see CoverArray::natcasesort()
     * @see natcasesort()
     */
    public function testNatcasesortWithBasicStrings(): void
    {
        $data = ['a' => 'img12.png', 'b' => 'img10.png', 'c' => 'img2.png', 'd' => 'img1.png'];
        $dataCopy = $data;

        natcasesort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->natcasesort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the natcasesort() method with case-insensitive sorting.
     *
     * This test verifies that the natcasesort() method correctly performs
     * case-insensitive sorting, treating 'IMG' and 'img' as equivalent,
     * mirroring PHP's natcasesort() function behavior.
     *
     *
     * Тестирование метода natcasesort() с регистронезависимой сортировкой.
     *
     * Этот тест проверяет, что метод natcasesort() корректно выполняет
     * регистронезависимую сортировку, рассматривая 'IMG' и 'img' как эквивалентные,
     * отражая поведение функции natcasesort() PHP.
     *
     * @see CoverArray::natcasesort()
     * @see natcasesort()
     */
    public function testNatcasesortCaseInsensitive(): void
    {
        $data = ['a' => 'IMG12.png', 'b' => 'img10.png', 'c' => 'Img2.png', 'd' => 'IMG1.png'];
        $dataCopy = $data;

        natcasesort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->natcasesort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the natcasesort() method with mixed case filenames.
     *
     * This test verifies that the natcasesort() method correctly sorts
     * filenames with mixed case using natural order,
     * mirroring PHP's natcasesort() function behavior.
     *
     *
     * Тестирование метода natcasesort() с именами файлов в смешанном регистре.
     *
     * Этот тест проверяет, что метод natcasesort() корректно сортирует
     * имена файлов в смешанном регистре, используя естественный порядок,
     * отражая поведение функции natcasesort() PHP.
     *
     * @see CoverArray::natcasesort()
     * @see natcasesort()
     */
    public function testNatcasesortWithMixedCaseFilenames(): void
    {
        $data = ['a' => 'File10.txt', 'b' => 'file2.txt', 'c' => 'FILE1.txt', 'd' => 'file20.txt'];
        $dataCopy = $data;

        natcasesort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->natcasesort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the natcasesort() method with numbers in strings.
     *
     * This test verifies that the natcasesort() method correctly handles
     * natural sorting where numeric parts are sorted numerically,
     * mirroring PHP's natcasesort() function behavior.
     *
     *
     * Тестирование метода natcasesort() с числами в строках.
     *
     * Этот тест проверяет, что метод natcasesort() корректно обрабатывает
     * естественную сортировку, где числовые части сортируются численно,
     * отражая поведение функции natcasesort() PHP.
     *
     * @see CoverArray::natcasesort()
     * @see natcasesort()
     */
    public function testNatcasesortWithNumbersInStrings(): void
    {
        $data = ['a' => 'test100', 'b' => 'test2', 'c' => 'test20', 'd' => 'test3'];
        $dataCopy = $data;

        natcasesort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->natcasesort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the natcasesort() method with empty array.
     *
     * This test verifies that the natcasesort() method correctly handles
     * empty arrays without errors,
     * mirroring PHP's natcasesort() function behavior.
     *
     *
     * Тестирование метода natcasesort() с пустым массивом.
     *
     * Этот тест проверяет, что метод natcasesort() корректно обрабатывает
     * пустые массивы без ошибок,
     * отражая поведение функции natcasesort() PHP.
     *
     * @see CoverArray::natcasesort()
     * @see natcasesort()
     */
    public function testNatcasesortWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        natcasesort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->natcasesort();

        // Check array is still empty
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the natcasesort() method with single element.
     *
     * This test verifies that the natcasesort() method correctly handles
     * arrays with a single element,
     * mirroring PHP's natcasesort() function behavior.
     *
     *
     * Тестирование метода natcasesort() с одним элементом.
     *
     * Этот тест проверяет, что метод natcasesort() корректно обрабатывает
     * массивы с одним элементом,
     * отражая поведение функции natcasesort() PHP.
     *
     * @see CoverArray::natcasesort()
     * @see natcasesort()
     */
    public function testNatcasesortWithSingleElement(): void
    {
        $data = ['a' => 'file1.txt'];
        $dataCopy = $data;

        natcasesort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->natcasesort();

        // Check array is unchanged
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the natcasesort() method preserving keys.
     *
     * This test verifies that the natcasesort() method maintains
     * the association between keys and values after sorting,
     * mirroring PHP's natcasesort() function behavior.
     *
     *
     * Тестирование метода natcasesort() с сохранением ключей.
     *
     * Этот тест проверяет, что метод natcasesort() сохраняет
     * ассоциацию между ключами и значениями после сортировки,
     * отражая поведение функции natcasesort() PHP.
     *
     * @see CoverArray::natcasesort()
     * @see natcasesort()
     */
    public function testNatcasesortPreservingKeys(): void
    {
        $data = ['first' => 'img100', 'second' => 'img2', 'third' => 'img10'];
        $dataCopy = $data;

        natcasesort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->natcasesort();

        // Check sorted array and key preservation
        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertArrayHasKey('first', $cover->getDataAsArray());
        $this->assertArrayHasKey('second', $cover->getDataAsArray());
        $this->assertArrayHasKey('third', $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the natcasesort() method with version strings.
     *
     * This test verifies that the natcasesort() method correctly sorts
     * version strings using natural order,
     * mirroring PHP's natcasesort() function behavior.
     *
     *
     * Тестирование метода natcasesort() со строками версий.
     *
     * Этот тест проверяет, что метод natcasesort() корректно сортирует
     * строки версий, используя естественный порядок,
     * отражая поведение функции natcasesort() PHP.
     *
     * @see CoverArray::natcasesort()
     * @see natcasesort()
     */
    public function testNatcasesortWithVersionStrings(): void
    {
        $data = ['a' => 'VERSION 1.10', 'b' => 'version 1.2', 'c' => 'Version 1.1', 'd' => 'VERSION 1.20'];
        $dataCopy = $data;

        natcasesort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->natcasesort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the natcasesort() method with leading zeros.
     *
     * This test verifies that the natcasesort() method correctly handles
     * strings with leading zeros in natural sorting,
     * mirroring PHP's natcasesort() function behavior.
     *
     *
     * Тестирование метода natcasesort() с ведущими нулями.
     *
     * Этот тест проверяет, что метод natcasesort() корректно обрабатывает
     * строки с ведущими нулями при естественной сортировке,
     * отражая поведение функции natcasesort() PHP.
     *
     * @see CoverArray::natcasesort()
     * @see natcasesort()
     */
    public function testNatcasesortWithLeadingZeros(): void
    {
        $data = ['a' => 'IMG012', 'b' => 'img002', 'c' => 'IMG100', 'd' => 'img001'];
        $dataCopy = $data;

        natcasesort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->natcasesort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the natcasesort() method with special characters.
     *
     * This test verifies that the natcasesort() method correctly sorts
     * strings containing special characters,
     * mirroring PHP's natcasesort() function behavior.
     *
     *
     * Тестирование метода natcasesort() со специальными символами.
     *
     * Этот тест проверяет, что метод natcasesort() корректно сортирует
     * строки, содержащие специальные символы,
     * отражая поведение функции natcasesort() PHP.
     *
     * @see CoverArray::natcasesort()
     * @see natcasesort()
     */
    public function testNatcasesortWithSpecialCharacters(): void
    {
        $data = ['a' => 'file-10.txt', 'b' => 'FILE-2.txt', 'c' => 'file_100.txt', 'd' => 'FILE_20.txt'];
        $dataCopy = $data;

        natcasesort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->natcasesort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }
}
