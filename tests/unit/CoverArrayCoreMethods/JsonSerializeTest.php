<?php

declare(strict_types=1);

namespace CoverArrayCoreMethods;

use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class JsonSerializeTest extends TestCase
{
    /**
     * Tests jsonSerialize() method returns internal array data.
     *
     * This test verifies that the jsonSerialize() method correctly returns
     * the internal data array, enabling proper JSON serialization via json_encode().
     * The method implements JsonSerializable interface requirement.
     *
     *
     * Тестирование метода jsonSerialize() на возврат внутренних данных массива.
     *
     * Этот тест проверяет, что метод jsonSerialize() корректно возвращает
     * внутренний массив данных, обеспечивая правильную сериализацию JSON через json_encode().
     * Метод реализует требование интерфейса JsonSerializable.
     *
     * @see CoverArray::jsonSerialize()
     * @see \JsonSerializable
     */
    public function testJsonSerializeReturnsInternalData(): void
    {
        $data = ['name' => 'John', 'age' => 30, 'active' => true];
        $cover = new NewTypeArray($data);

        $result = $cover->jsonSerialize();

        $this->assertSame($data, $result);
    }

    /**
     * Tests jsonSerialize() method with empty CoverArray.
     *
     * This test verifies that jsonSerialize() returns an empty array
     * when called on an empty CoverArray instance.
     *
     *
     * Тестирование метода jsonSerialize() с пустым CoverArray.
     *
     * Этот тест проверяет, что jsonSerialize() возвращает пустой массив
     * при вызове на пустом экземпляре CoverArray.
     *
     * @see CoverArray::jsonSerialize()
     */
    public function testJsonSerializeWithEmptyArray(): void
    {
        $cover = new NewTypeArray();

        $result = $cover->jsonSerialize();

        $this->assertSame([], $result);
    }

    /**
     * Tests jsonSerialize() integration with json_encode() for nested data.
     *
     * This test verifies that CoverArray with nested data can be serialized
     * to JSON correctly via json_encode(), which internally calls jsonSerialize().
     * Nested arrays are converted to CoverArray objects, but json_encode handles
     * them recursively through JsonSerializable interface.
     *
     *
     * Тестирование интеграции jsonSerialize() с json_encode() для вложенных данных.
     *
     * Этот тест проверяет, что CoverArray с вложенными данными может быть
     * корректно сериализован в JSON через json_encode(), который внутренне вызывает jsonSerialize().
     * Вложенные массивы конвертируются в объекты CoverArray, но json_encode обрабатывает
     * их рекурсивно через интерфейс JsonSerializable.
     *
     * @see CoverArray::jsonSerialize()
     * @see json_encode()
     */
    public function testJsonSerializeWithNestedDataViaJsonEncode(): void
    {
        $data = [
            'user' => [
                'profile' => [
                    'name' => 'Alice',
                    'settings' => ['theme' => 'dark', 'lang' => 'en']
                ]
            ],
            'items' => [1, 2, 3]
        ];
        $cover = new NewTypeArray($data);

        $jsonResult = json_encode($cover);
        $expectedJson = json_encode($data);

        $this->assertSame($expectedJson, $jsonResult);
    }

    /**
     * Tests jsonSerialize() integration with json_encode().
     *
     * This test verifies that CoverArray can be serialized directly
     * with json_encode() thanks to the JsonSerializable interface implementation.
     *
     *
     * Тестирование интеграции jsonSerialize() с json_encode().
     *
     * Этот тест проверяет, что CoverArray может быть сериализован напрямую
     * с помощью json_encode() благодаря реализации интерфейса JsonSerializable.
     *
     * @see CoverArray::jsonSerialize()
     * @see json_encode()
     */
    public function testJsonSerializeIntegrationWithJsonEncode(): void
    {
        $data = ['key' => 'value', 'number' => 42];
        $cover = new NewTypeArray($data);

        $jsonResult = json_encode($cover);
        $expectedJson = json_encode($data);

        $this->assertSame($expectedJson, $jsonResult);
    }

    /**
     * Tests jsonSerialize() with sequential numeric array.
     *
     * This test verifies that jsonSerialize() correctly handles
     * sequential numeric arrays (lists), preserving their structure.
     *
     *
     * Тестирование jsonSerialize() с последовательным числовым массивом.
     *
     * Этот тест проверяет, что jsonSerialize() корректно обрабатывает
     * последовательные числовые массивы (списки), сохраняя их структуру.
     *
     * @see CoverArray::jsonSerialize()
     */
    public function testJsonSerializeWithNumericArray(): void
    {
        $data = ['apple', 'banana', 'cherry'];
        $cover = new NewTypeArray($data);

        $result = $cover->jsonSerialize();

        $this->assertSame($data, $result);
        $this->assertSame('["apple","banana","cherry"]', json_encode($cover));
    }

    /**
     * Tests jsonSerialize() with various scalar data types.
     *
     * This test verifies that jsonSerialize() correctly handles
     * various JSON-compatible scalar data types including strings, numbers,
     * booleans, and null values.
     *
     *
     * Тестирование jsonSerialize() с различными скалярными типами данных.
     *
     * Этот тест проверяет, что jsonSerialize() корректно обрабатывает
     * различные JSON-совместимые скалярные типы данных, включая строки, числа,
     * булевы значения и null.
     *
     * @see CoverArray::jsonSerialize()
     */
    public function testJsonSerializeWithVariousDataTypes(): void
    {
        $data = [
            'string' => 'text',
            'integer' => 123,
            'float' => 3.14,
            'boolean_true' => true,
            'boolean_false' => false,
            'null_value' => null
        ];
        $cover = new NewTypeArray($data);

        $result = $cover->jsonSerialize();

        $this->assertSame($data, $result);
    }
}
