<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class ExtractTest extends TestCase
{
    /**
     * Tests the extract() method with default flags.
     *
     * This test verifies that the extract() method correctly imports
     * variables from the array into the current symbol table,
     * mirroring PHP's extract() function behavior.
     *
     *
     * Тестирование метода extract() с флагами по умолчанию.
     *
     * Этот тест проверяет, что метод extract() корректно импортирует
     * переменные из массива в текущую таблицу символов,
     * отражая поведение функции extract() PHP.
     *
     * @see CoverArray::extract()
     * @see extract()
     */
    public function testExtractWithDefaultFlags(): void
    {
        $data = ['color' => 'red', 'size' => 'large', 'shape' => 'circle'];
        $dataCopy = $data;

        $expected = extract($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->extract();

        // Check return value (number of variables extracted)
        $this->assertSame($expected, $result);
        $this->assertSame(3, $result);

        // Check variables were created
        $this->assertSame('red', $color);
        $this->assertSame('large', $size);
        $this->assertSame('circle', $shape);
    }

    /**
     * Tests the extract() method with EXTR_OVERWRITE flag.
     *
     * This test verifies that the extract() method overwrites
     * existing variables with the same name,
     * mirroring PHP's extract() function behavior.
     *
     *
     * Тестирование метода extract() с флагом EXTR_OVERWRITE.
     *
     * Этот тест проверяет, что метод extract() перезаписывает
     * существующие переменные с тем же именем,
     * отражая поведение функции extract() PHP.
     *
     * @see CoverArray::extract()
     * @see extract()
     */
    public function testExtractWithExtrOverwrite(): void
    {
        $data = ['value' => 'new', 'another' => 'test'];
        $dataCopy = $data;

        $expected = extract($data, EXTR_OVERWRITE);

        $cover = new CoverArray($dataCopy);
        $result = $cover->extract(EXTR_OVERWRITE);

        // Check return value (number of variables extracted)
        $this->assertSame($expected, $result);
        $this->assertSame(2, $result);
    }

    /**
     * Tests the extract() method with EXTR_SKIP flag.
     *
     * This test verifies that the extract() method skips
     * existing variables without overwriting,
     * mirroring PHP's extract() function behavior.
     *
     *
     * Тестирование метода extract() с флагом EXTR_SKIP.
     *
     * Этот тест проверяет, что метод extract() пропускает
     * существующие переменные без перезаписи,
     * отражая поведение функции extract() PHP.
     *
     * @see CoverArray::extract()
     * @see extract()
     */
    public function testExtractWithExtrSkip(): void
    {
        $data = ['item1' => 'value1', 'item2' => 'value2'];
        $dataCopy = $data;

        $expected = extract($data, EXTR_SKIP);

        $cover = new CoverArray($dataCopy);
        $result = $cover->extract(EXTR_SKIP);

        // Check return value (number of variables extracted)
        $this->assertSame($expected, $result);
        $this->assertSame(2, $result);
    }

    /**
     * Tests the extract() method with EXTR_PREFIX_SAME flag.
     *
     * This test verifies that the extract() method adds prefix
     * to conflicting variable names,
     * mirroring PHP's extract() function behavior.
     *
     *
     * Тестирование метода extract() с флагом EXTR_PREFIX_SAME.
     *
     * Этот тест проверяет, что метод extract() добавляет префикс
     * к конфликтующим именам переменных,
     * отражая поведение функции extract() PHP.
     *
     * @see CoverArray::extract()
     * @see extract()
     */
    public function testExtractWithExtrPrefixSame(): void
    {
        $data = ['var1' => 'value1', 'var2' => 'value2'];
        $dataCopy = $data;

        $expected = extract($data, EXTR_PREFIX_SAME, 'pfx');

        $cover = new CoverArray($dataCopy);
        $result = $cover->extract(EXTR_PREFIX_SAME, 'pfx');

        // Check return value (number of variables extracted)
        $this->assertSame($expected, $result);
        $this->assertSame(2, $result);
    }

    /**
     * Tests the extract() method with EXTR_PREFIX_ALL flag.
     *
     * This test verifies that the extract() method adds prefix
     * to all variable names,
     * mirroring PHP's extract() function behavior.
     *
     *
     * Тестирование метода extract() с флагом EXTR_PREFIX_ALL.
     *
     * Этот тест проверяет, что метод extract() добавляет префикс
     * ко всем именам переменных,
     * отражая поведение функции extract() PHP.
     *
     * @see CoverArray::extract()
     * @see extract()
     */
    public function testExtractWithExtrPrefixAll(): void
    {
        $data = ['a' => 'first', 'b' => 'second'];
        $dataCopy = $data;

        $expected = extract($data, EXTR_PREFIX_ALL, 'var');

        $cover = new CoverArray($dataCopy);
        $result = $cover->extract(EXTR_PREFIX_ALL, 'var');

        // Check return value (number of variables extracted)
        $this->assertSame($expected, $result);
        $this->assertSame(2, $result);
    }

    /**
     * Tests the extract() method with empty array.
     *
     * This test verifies that the extract() method returns zero
     * when extracting from an empty array,
     * mirroring PHP's extract() function behavior.
     *
     *
     * Тестирование метода extract() с пустым массивом.
     *
     * Этот тест проверяет, что метод extract() возвращает ноль
     * при извлечении из пустого массива,
     * отражая поведение функции extract() PHP.
     *
     * @see CoverArray::extract()
     * @see extract()
     */
    public function testExtractWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        $expected = extract($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->extract();

        // Check return value
        $this->assertSame($expected, $result);
        $this->assertSame(0, $result);
    }

    /**
     * Tests the extract() method with single element.
     *
     * This test verifies that the extract() method correctly extracts
     * a single element from the array,
     * mirroring PHP's extract() function behavior.
     *
     *
     * Тестирование метода extract() с одним элементом.
     *
     * Этот тест проверяет, что метод extract() корректно извлекает
     * один элемент из массива,
     * отражая поведение функции extract() PHP.
     *
     * @see CoverArray::extract()
     * @see extract()
     */
    public function testExtractWithSingleElement(): void
    {
        $data = ['single' => 'value'];
        $dataCopy = $data;

        $expected = extract($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->extract();

        // Check return value
        $this->assertSame($expected, $result);
        $this->assertSame(1, $result);

        // Check variable was created
        $this->assertSame('value', $single);
    }

    /**
     * Tests the extract() method with numeric keys.
     *
     * This test verifies that the extract() method skips
     * numeric keys (invalid variable names),
     * mirroring PHP's extract() function behavior.
     *
     *
     * Тестирование метода extract() с числовыми ключами.
     *
     * Этот тест проверяет, что метод extract() пропускает
     * числовые ключи (недопустимые имена переменных),
     * отражая поведение функции extract() PHP.
     *
     * @see CoverArray::extract()
     * @see extract()
     */
    public function testExtractWithNumericKeys(): void
    {
        $data = [0 => 'zero', 1 => 'one', 'valid' => 'var'];
        $dataCopy = $data;

        $expected = extract($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->extract();

        // Check return value (only valid variable name)
        $this->assertSame($expected, $result);
        $this->assertSame(1, $result);

        // Check only valid variable was created
        $this->assertSame('var', $valid);
    }

    /**
     * Tests the extract() method with mixed types.
     *
     * This test verifies that the extract() method correctly extracts
     * values of different types,
     * mirroring PHP's extract() function behavior.
     *
     *
     * Тестирование метода extract() со смешанными типами.
     *
     * Этот тест проверяет, что метод extract() корректно извлекает
     * значения разных типов,
     * отражая поведение функции extract() PHP.
     *
     * @see CoverArray::extract()
     * @see extract()
     */
    public function testExtractWithMixedTypes(): void
    {
        $data = [
            'int_var' => 42,
            'str_var' => 'hello',
            'bool_var' => true,
            'null_var' => null,
            'array_var' => [1, 2, 3]
        ];
        $dataCopy = $data;

        $expected = extract($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->extract();

        // Check return value
        $this->assertSame($expected, $result);
        $this->assertSame(5, $result);

        // Check variables were created with correct types
        $this->assertSame(42, $int_var);
        $this->assertSame('hello', $str_var);
        $this->assertTrue($bool_var);
        $this->assertNull($null_var);
        $this->assertSame([1, 2, 3], $array_var);
    }

    /**
     * Tests the extract() method with EXTR_PREFIX_INVALID flag.
     *
     * This test verifies that the extract() method adds prefix
     * to invalid variable names,
     * mirroring PHP's extract() function behavior.
     *
     *
     * Тестирование метода extract() с флагом EXTR_PREFIX_INVALID.
     *
     * Этот тест проверяет, что метод extract() добавляет префикс
     * к недопустимым именам переменных,
     * отражая поведение функции extract() PHP.
     *
     * @see CoverArray::extract()
     * @see extract()
     */
    public function testExtractWithExtrPrefixInvalid(): void
    {
        $data = [0 => 'numeric', 'valid' => 'name'];
        $dataCopy = $data;

        $expected = extract($data, EXTR_PREFIX_INVALID, 'num');

        $cover = new CoverArray($dataCopy);
        $result = $cover->extract(EXTR_PREFIX_INVALID, 'num');

        // Check return value (number of variables extracted)
        $this->assertSame($expected, $result);
        $this->assertSame(2, $result);
    }
}
