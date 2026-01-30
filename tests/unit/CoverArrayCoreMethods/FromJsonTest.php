<?php

declare(strict_types=1);

namespace CoverArrayCoreMethods;

use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class FromJsonTest extends TestCase
{
    /**
     * Tests fromJson() static factory method creates CoverArray from JSON string.
     *
     * This test verifies that the fromJson() method correctly parses a JSON string
     * and creates a new CoverArray instance with the decoded data.
     * Comparison with native json_decode() is performed to ensure equivalence.
     *
     *
     * Тестирование статического фабричного метода fromJson() для создания CoverArray из строки JSON.
     *
     * Этот тест проверяет, что метод fromJson() корректно парсит строку JSON
     * и создает новый экземпляр CoverArray с декодированными данными.
     * Выполняется сравнение с нативным json_decode() для обеспечения эквивалентности.
     *
     * @see CoverArray::fromJson()
     * @see json_decode()
     */
    public function testFromJsonCreatesInstanceFromJsonString(): void
    {
        $json = '{"name":"John","age":30,"active":true}';
        $expected = json_decode($json, true);

        $cover = CoverArray::fromJson($json);

        $this->assertInstanceOf(CoverArray::class, $cover);
        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests fromJson() with empty JSON object.
     *
     * This test verifies that fromJson() correctly handles an empty JSON object,
     * creating an empty CoverArray instance.
     *
     *
     * Тестирование fromJson() с пустым объектом JSON.
     *
     * Этот тест проверяет, что fromJson() корректно обрабатывает пустой объект JSON,
     * создавая пустой экземпляр CoverArray.
     *
     * @see CoverArray::fromJson()
     * @see json_decode()
     */
    public function testFromJsonWithEmptyObject(): void
    {
        $json = '{}';
        $expected = json_decode($json, true);

        $cover = CoverArray::fromJson($json);

        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertTrue($cover->isEmpty());
    }

    /**
     * Tests fromJson() with empty JSON array.
     *
     * This test verifies that fromJson() correctly handles an empty JSON array,
     * creating an empty CoverArray instance.
     *
     *
     * Тестирование fromJson() с пустым массивом JSON.
     *
     * Этот тест проверяет, что fromJson() корректно обрабатывает пустой массив JSON,
     * создавая пустой экземпляр CoverArray.
     *
     * @see CoverArray::fromJson()
     * @see json_decode()
     */
    public function testFromJsonWithEmptyArray(): void
    {
        $json = '[]';
        $expected = json_decode($json, true);

        $cover = CoverArray::fromJson($json);

        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertTrue($cover->isEmpty());
    }

    /**
     * Tests fromJson() with nested JSON structure.
     *
     * This test verifies that fromJson() correctly parses nested JSON structures
     * and creates a CoverArray with properly nested data.
     *
     *
     * Тестирование fromJson() с вложенной структурой JSON.
     *
     * Этот тест проверяет, что fromJson() корректно парсит вложенные структуры JSON
     * и создает CoverArray с правильно вложенными данными.
     *
     * @see CoverArray::fromJson()
     * @see json_decode()
     */
    public function testFromJsonWithNestedStructure(): void
    {
        $json = '{"user":{"profile":{"name":"Alice","settings":{"theme":"dark"}}}}';
        $expected = json_decode($json, true);

        $cover = CoverArray::fromJson($json);

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests fromJson() with JSON array (sequential list).
     *
     * This test verifies that fromJson() correctly parses a JSON array
     * and creates a CoverArray with sequential numeric keys.
     *
     *
     * Тестирование fromJson() с массивом JSON (последовательный список).
     *
     * Этот тест проверяет, что fromJson() корректно парсит массив JSON
     * и создает CoverArray с последовательными числовыми ключами.
     *
     * @see CoverArray::fromJson()
     * @see json_decode()
     */
    public function testFromJsonWithArray(): void
    {
        $json = '["apple","banana","cherry"]';
        $expected = json_decode($json, true);

        $cover = CoverArray::fromJson($json);

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests fromJson() with various data types.
     *
     * This test verifies that fromJson() correctly handles various JSON data types
     * including strings, numbers, booleans, and null values.
     *
     *
     * Тестирование fromJson() с различными типами данных.
     *
     * Этот тест проверяет, что fromJson() корректно обрабатывает различные типы данных JSON,
     * включая строки, числа, булевы значения и null.
     *
     * @see CoverArray::fromJson()
     * @see json_decode()
     */
    public function testFromJsonWithVariousDataTypes(): void
    {
        $json = '{"string":"text","integer":123,"float":3.14,"bool_true":true,"bool_false":false,"null_val":null}';
        $expected = json_decode($json, true);

        $cover = CoverArray::fromJson($json);

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests fromJson() throws JsonException for invalid JSON.
     *
     * This test verifies that fromJson() throws a JsonException when
     * given an invalid JSON string, as JSON_THROW_ON_ERROR is the default flag.
     *
     *
     * Тестирование выброса JsonException методом fromJson() для невалидного JSON.
     *
     * Этот тест проверяет, что fromJson() выбрасывает JsonException при
     * получении невалидной строки JSON, так как JSON_THROW_ON_ERROR является флагом по умолчанию.
     *
     * @see CoverArray::fromJson()
     */
    public function testFromJsonThrowsExceptionForInvalidJson(): void
    {
        $this->expectException(\JsonException::class);

        CoverArray::fromJson('invalid json');
    }

    /**
     * Tests fromJson() with custom depth parameter.
     *
     * This test verifies that fromJson() respects the depth parameter
     * for deeply nested JSON structures.
     *
     *
     * Тестирование fromJson() с пользовательским параметром глубины.
     *
     * Этот тест проверяет, что fromJson() учитывает параметр глубины
     * для глубоко вложенных структур JSON.
     *
     * @see CoverArray::fromJson()
     * @see json_decode()
     */
    public function testFromJsonWithCustomDepth(): void
    {
        $json = '{"level1":{"level2":{"level3":"value"}}}';
        $expected = json_decode($json, true, 512);

        $cover = CoverArray::fromJson($json, 512);

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests fromJson() throws exception when depth is exceeded.
     *
     * This test verifies that fromJson() throws a JsonException when
     * the JSON nesting depth exceeds the specified limit.
     *
     *
     * Тестирование выброса исключения fromJson() при превышении глубины.
     *
     * Этот тест проверяет, что fromJson() выбрасывает JsonException,
     * когда глубина вложенности JSON превышает указанный лимит.
     *
     * @see CoverArray::fromJson()
     */
    public function testFromJsonThrowsExceptionWhenDepthExceeded(): void
    {
        $this->expectException(\JsonException::class);

        $json = '{"a":{"b":{"c":{"d":"value"}}}}';
        CoverArray::fromJson($json, 2);
    }

    /**
     * Tests fromJson() works correctly with NewTypeArray subclass.
     *
     * This test verifies that fromJson() returns an instance of the called class
     * when invoked on a subclass of CoverArray.
     *
     *
     * Тестирование корректной работы fromJson() с подклассом NewTypeArray.
     *
     * Этот тест проверяет, что fromJson() возвращает экземпляр вызванного класса
     * при вызове на подклассе CoverArray.
     *
     * @see CoverArray::fromJson()
     */
    public function testFromJsonWithSubclass(): void
    {
        $json = '{"key":"value"}';

        $cover = NewTypeArray::fromJson($json);

        $this->assertInstanceOf(NewTypeArray::class, $cover);
        $this->assertSame(['key' => 'value'], $cover->getDataAsArray());
    }

    /**
     * Tests fromJson() with Unicode characters.
     *
     * This test verifies that fromJson() correctly handles JSON strings
     * containing Unicode characters.
     *
     *
     * Тестирование fromJson() с символами Unicode.
     *
     * Этот тест проверяет, что fromJson() корректно обрабатывает строки JSON,
     * содержащие символы Unicode.
     *
     * @see CoverArray::fromJson()
     * @see json_decode()
     */
    public function testFromJsonWithUnicodeCharacters(): void
    {
        $json = '{"greeting":"Привет мир","emoji":"🎉"}';
        $expected = json_decode($json, true);

        $cover = CoverArray::fromJson($json);

        $this->assertSame($expected, $cover->getDataAsArray());
    }
}
