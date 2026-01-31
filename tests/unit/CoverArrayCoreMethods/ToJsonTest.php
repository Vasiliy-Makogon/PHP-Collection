<?php

declare(strict_types=1);

namespace CoverArrayCoreMethods;

use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class ToJsonTest extends TestCase
{
    /**
     * Tests toJson() method returns JSON string representation.
     *
     * This test verifies that the toJson() method correctly converts
     * CoverArray data to a JSON string. Comparison with native json_encode()
     * is performed to ensure equivalence.
     *
     *
     * Тестирование метода toJson() на возврат строкового представления JSON.
     *
     * Этот тест проверяет, что метод toJson() корректно преобразует
     * данные CoverArray в строку JSON. Выполняется сравнение с нативным json_encode()
     * для обеспечения эквивалентности.
     *
     * @see CoverArray::toJson()
     * @see json_encode()
     */
    public function testToJsonReturnsJsonString(): void
    {
        $data = ['name' => 'John', 'age' => 30, 'active' => true];
        $expected = json_encode($data);
        $cover = new NewTypeArray($data);

        $result = $cover->toJson();

        $this->assertSame($expected, $result);
    }

    /**
     * Tests toJson() with empty CoverArray.
     *
     * This test verifies that toJson() returns an empty JSON object
     * when called on an empty CoverArray instance.
     *
     *
     * Тестирование toJson() с пустым CoverArray.
     *
     * Этот тест проверяет, что toJson() возвращает пустой объект JSON
     * при вызове на пустом экземпляре CoverArray.
     *
     * @see CoverArray::toJson()
     * @see json_encode()
     */
    public function testToJsonWithEmptyArray(): void
    {
        $cover = new NewTypeArray();
        $expected = json_encode([]);

        $result = $cover->toJson();

        $this->assertSame($expected, $result);
    }

    /**
     * Tests toJson() with nested data structure.
     *
     * This test verifies that toJson() correctly serializes nested
     * array structures to JSON.
     *
     *
     * Тестирование toJson() с вложенной структурой данных.
     *
     * Этот тест проверяет, что toJson() корректно сериализует
     * вложенные структуры массивов в JSON.
     *
     * @see CoverArray::toJson()
     * @see json_encode()
     */
    public function testToJsonWithNestedStructure(): void
    {
        $data = [
            'user' => [
                'profile' => [
                    'name' => 'Alice',
                    'settings' => ['theme' => 'dark', 'lang' => 'en']
                ]
            ]
        ];
        $expected = json_encode($data);
        $cover = new NewTypeArray($data);

        $result = $cover->toJson();

        $this->assertSame($expected, $result);
    }

    /**
     * Tests toJson() with sequential numeric array.
     *
     * This test verifies that toJson() correctly serializes
     * sequential numeric arrays as JSON arrays.
     *
     *
     * Тестирование toJson() с последовательным числовым массивом.
     *
     * Этот тест проверяет, что toJson() корректно сериализует
     * последовательные числовые массивы как JSON-массивы.
     *
     * @see CoverArray::toJson()
     * @see json_encode()
     */
    public function testToJsonWithNumericArray(): void
    {
        $data = ['apple', 'banana', 'cherry'];
        $expected = json_encode($data);
        $cover = new NewTypeArray($data);

        $result = $cover->toJson();

        $this->assertSame($expected, $result);
        $this->assertSame('["apple","banana","cherry"]', $result);
    }

    /**
     * Tests toJson() with custom flags parameter.
     *
     * This test verifies that toJson() respects the flags parameter,
     * such as JSON_PRETTY_PRINT for formatted output.
     *
     *
     * Тестирование toJson() с пользовательским параметром флагов.
     *
     * Этот тест проверяет, что toJson() учитывает параметр флагов,
     * такой как JSON_PRETTY_PRINT для форматированного вывода.
     *
     * @see CoverArray::toJson()
     * @see json_encode()
     */
    public function testToJsonWithPrettyPrint(): void
    {
        $data = ['key' => 'value'];
        $expected = json_encode($data, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
        $cover = new NewTypeArray($data);

        $result = $cover->toJson(JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);

        $this->assertSame($expected, $result);
        $this->assertStringContainsString("\n", $result);
    }

    /**
     * Tests toJson() with JSON_UNESCAPED_UNICODE flag.
     *
     * This test verifies that toJson() correctly handles Unicode characters
     * when the JSON_UNESCAPED_UNICODE flag is used.
     *
     *
     * Тестирование toJson() с флагом JSON_UNESCAPED_UNICODE.
     *
     * Этот тест проверяет, что toJson() корректно обрабатывает символы Unicode
     * при использовании флага JSON_UNESCAPED_UNICODE.
     *
     * @see CoverArray::toJson()
     * @see json_encode()
     */
    public function testToJsonWithUnescapedUnicode(): void
    {
        $data = ['greeting' => 'Привет мир', 'emoji' => '🎉'];
        $expected = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        $cover = new NewTypeArray($data);

        $result = $cover->toJson(JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);

        $this->assertSame($expected, $result);
        $this->assertStringContainsString('Привет мир', $result);
    }

    /**
     * Tests toJson() with various data types.
     *
     * This test verifies that toJson() correctly handles various JSON-compatible
     * data types including strings, numbers, booleans, and null values.
     *
     *
     * Тестирование toJson() с различными типами данных.
     *
     * Этот тест проверяет, что toJson() корректно обрабатывает различные
     * JSON-совместимые типы данных, включая строки, числа, булевы значения и null.
     *
     * @see CoverArray::toJson()
     * @see json_encode()
     */
    public function testToJsonWithVariousDataTypes(): void
    {
        $data = [
            'string' => 'text',
            'integer' => 123,
            'float' => 3.14,
            'boolean_true' => true,
            'boolean_false' => false,
            'null_value' => null,
            'array' => [1, 2, 3]
        ];
        $expected = json_encode($data);
        $cover = new NewTypeArray($data);

        $result = $cover->toJson();

        $this->assertSame($expected, $result);
    }

    /**
     * Tests toJson() and fromJson() roundtrip conversion.
     *
     * This test verifies that data can be converted to JSON and back
     * to CoverArray without data loss.
     *
     *
     * Тестирование двустороннего преобразования toJson() и fromJson().
     *
     * Этот тест проверяет, что данные могут быть преобразованы в JSON и обратно
     * в CoverArray без потери данных.
     *
     * @see CoverArray::toJson()
     * @see CoverArray::fromJson()
     */
    public function testToJsonFromJsonRoundtrip(): void
    {
        $data = [
            'user' => ['name' => 'John', 'age' => 30],
            'items' => ['apple', 'banana'],
            'active' => true
        ];
        $cover = new CoverArray($data);

        $json = $cover->toJson();
        $restored = CoverArray::fromJson($json);

        $this->assertSame($data, $restored->getDataAsArray());
    }

    /**
     * Tests toJson() throws JsonException for non-encodable values.
     *
     * This test verifies that toJson() throws a JsonException when
     * the data contains values that cannot be encoded to JSON (e.g., resources).
     *
     *
     * Тестирование выброса JsonException методом toJson() для некодируемых значений.
     *
     * Этот тест проверяет, что toJson() выбрасывает JsonException,
     * когда данные содержат значения, которые не могут быть закодированы в JSON (например, ресурсы).
     *
     * @see CoverArray::toJson()
     */
    public function testToJsonThrowsExceptionForNonEncodableValues(): void
    {
        $this->expectException(\JsonException::class);

        $resource = tmpfile();
        $cover = new NewTypeArray(['resource' => $resource]);

        try {
            $cover->toJson();
        } finally {
            if (is_resource($resource)) {
                fclose($resource);
            }
        }
    }

    /**
     * Tests toJson() with custom depth parameter.
     *
     * This test verifies that toJson() respects the depth parameter
     * for encoding nested structures.
     *
     *
     * Тестирование toJson() с пользовательским параметром глубины.
     *
     * Этот тест проверяет, что toJson() учитывает параметр глубины
     * при кодировании вложенных структур.
     *
     * @see CoverArray::toJson()
     * @see json_encode()
     */
    public function testToJsonWithCustomDepth(): void
    {
        $data = ['level1' => ['level2' => ['level3' => 'value']]];
        $expected = json_encode($data, JSON_THROW_ON_ERROR, 512);
        $cover = new NewTypeArray($data);

        $result = $cover->toJson(JSON_THROW_ON_ERROR, 512);

        $this->assertSame($expected, $result);
    }

    /**
     * Tests toJson() throws exception when depth is exceeded.
     *
     * This test verifies that toJson() throws a JsonException when
     * the data nesting depth exceeds the specified limit.
     *
     *
     * Тестирование выброса исключения toJson() при превышении глубины.
     *
     * Этот тест проверяет, что toJson() выбрасывает JsonException,
     * когда глубина вложенности данных превышает указанный лимит.
     *
     * @see CoverArray::toJson()
     */
    public function testToJsonThrowsExceptionWhenDepthExceeded(): void
    {
        $this->expectException(\JsonException::class);

        $data = ['a' => ['b' => ['c' => ['d' => ['e' => 'value']]]]];
        $cover = new NewTypeArray($data);

        $cover->toJson(JSON_THROW_ON_ERROR, 2);
    }
}
