<?php

declare(strict_types=1);

namespace CoverArrayCoreMethods;

use InvalidArgumentException;
use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class GetDotNotationTest extends TestCase
{
    /**
     * Tests that get() throws InvalidArgumentException when path is empty.
     *
     * This test verifies that the get() method correctly throws an
     * InvalidArgumentException when an empty string is passed as the path.
     * An empty path is invalid and should be rejected immediately.
     *
     *
     * Тестирует, что get() выбрасывает InvalidArgumentException при пустом пути.
     *
     * Этот тест проверяет, что метод get() корректно выбрасывает
     * InvalidArgumentException, когда передается пустая строка в качестве пути.
     * Пустой путь недопустим и должен быть отклонен немедленно.
     *
     * @see CoverArray::get()
     */
    public function testGetThrowsExceptionOnEmptyPath(): void
    {
        $cover = new CoverArray(['key' => 'value']);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Path cannot be empty');

        $cover->get('');
    }

    /**
     * Tests get() returns null when intermediate value is not a CoverArray.
     *
     * This test verifies that when accessing a nested path like 'a.b.c',
     * if an intermediate value (e.g., at 'a') is not a CoverArray instance,
     * the method returns null without throwing an exception.
     *
     *
     * Тестирует, что get() возвращает null, когда промежуточное значение не является CoverArray.
     *
     * Этот тест проверяет, что при доступе к вложенному пути вроде 'a.b.c',
     * если промежуточное значение (например, по ключу 'a') не является экземпляром CoverArray,
     * метод возвращает null без выбрасывания исключения.
     *
     * @see CoverArray::get()
     */
    public function testGetReturnsNullForNonCoverArrayIntermediate(): void
    {
        // String value at intermediate path
        $cover = new CoverArray(['user' => 'John']);
        $this->assertNull($cover->get('user.name'));

        // Integer value at intermediate path
        $cover2 = new CoverArray(['count' => 42]);
        $this->assertNull($cover2->get('count.value'));

        // Object (non-CoverArray) at intermediate path
        $stdClass = new \stdClass();
        $stdClass->property = 'value';
        $cover3 = new CoverArray(['obj' => $stdClass]);
        $this->assertNull($cover3->get('obj.property'));

        // Null value at intermediate path
        $cover4 = new CoverArray(['empty' => null]);
        $this->assertNull($cover4->get('empty.something'));

        // Boolean value at intermediate path
        $cover5 = new CoverArray(['flag' => true]);
        $this->assertNull($cover5->get('flag.value'));
    }

    /**
     * Tests get() invokes callback when intermediate value is not a CoverArray.
     *
     * This test verifies that when a callback is provided and the intermediate
     * value is not a CoverArray, the callback is invoked with the actual data
     * (which is the intermediate value, not the nested value).
     *
     *
     * Тестирует, что get() вызывает callback, когда промежуточное значение не является CoverArray.
     *
     * Этот тест проверяет, что когда предоставлен callback и промежуточное значение
     * не является CoverArray, callback вызывается с фактическими данными
     * (которые являются промежуточным значением, а не вложенным значением).
     *
     * @see CoverArray::get()
     */
    public function testGetInvokesCallbackForNonCoverArrayIntermediate(): void
    {
        // String value at intermediate path - callback should receive the string
        $cover = new CoverArray(['user' => 'John']);
        $result = $cover->get('user.name', function ($value) {
            return $value === 'John' ? 'found user' : 'not found';
        });
        $this->assertSame('found user', $result);

        // Integer value at intermediate path
        $cover2 = new CoverArray(['count' => 42]);
        $result2 = $cover2->get('count.nested', function ($value) {
            return $value * 2;
        });
        $this->assertSame(84, $result2);

        // Null value at intermediate path - callback receives null
        $cover3 = new CoverArray(['empty' => null]);
        $result3 = $cover3->get('empty.something', function ($value) {
            return $value ?? 'default';
        });
        $this->assertSame('default', $result3);

        // Object at intermediate path
        $stdClass = new \stdClass();
        $stdClass->name = 'test';
        $cover4 = new CoverArray(['obj' => $stdClass]);
        $result4 = $cover4->get('obj.nested', function ($value) {
            return $value instanceof \stdClass ? $value->name : null;
        });
        $this->assertSame('test', $result4);
    }

    /**
     * Tests get() with simple single-key path.
     *
     * This test verifies that get() correctly retrieves values
     * using a simple path without dots.
     *
     *
     * Тестирует get() с простым однокомпонентным путем.
     *
     * Этот тест проверяет, что get() корректно получает значения,
     * используя простой путь без точек.
     *
     * @see CoverArray::get()
     */
    public function testGetWithSimplePath(): void
    {
        $cover = new CoverArray([
            'name' => 'John',
            'age' => 30,
            'active' => true,
            'data' => null,
        ]);

        $this->assertSame('John', $cover->get('name'));
        $this->assertSame(30, $cover->get('age'));
        $this->assertTrue($cover->get('active'));
        $this->assertNull($cover->get('data'));
        $this->assertNull($cover->get('nonexistent'));
    }

    /**
     * Tests get() with nested dot notation path.
     *
     * This test verifies that get() correctly traverses nested
     * CoverArray instances using dot notation.
     *
     *
     * Тестирует get() с вложенным путем через точечную нотацию.
     *
     * Этот тест проверяет, что get() корректно проходит вложенные
     * экземпляры CoverArray, используя точечную нотацию.
     *
     * @see CoverArray::get()
     */
    public function testGetWithNestedPath(): void
    {
        $cover = new CoverArray([
            'user' => [
                'profile' => [
                    'name' => 'John',
                    'email' => 'john@example.com',
                ],
                'settings' => [
                    'theme' => 'dark',
                ],
            ],
        ]);

        $this->assertSame('John', $cover->get('user.profile.name'));
        $this->assertSame('john@example.com', $cover->get('user.profile.email'));
        $this->assertSame('dark', $cover->get('user.settings.theme'));
        $this->assertNull($cover->get('user.profile.nonexistent'));
        $this->assertNull($cover->get('user.nonexistent.key'));
    }

    /**
     * Tests get() with callback for existing value.
     *
     * This test verifies that get() correctly invokes the callback
     * when the value exists at the specified path.
     *
     *
     * Тестирует get() с callback для существующего значения.
     *
     * Этот тест проверяет, что get() корректно вызывает callback,
     * когда значение существует по указанному пути.
     *
     * @see CoverArray::get()
     */
    public function testGetWithCallbackForExistingValue(): void
    {
        $cover = new CoverArray([
            'user' => [
                'name' => 'John',
                'age' => 25,
            ],
        ]);

        $result = $cover->get('user.name', fn($value) => strtoupper($value));
        $this->assertSame('JOHN', $result);

        $result2 = $cover->get('user.age', fn($value) => $value + 10);
        $this->assertSame(35, $result2);
    }

    /**
     * Tests get() with callback for non-existent value.
     *
     * This test verifies that get() correctly invokes the callback
     * with null when the value doesn't exist at the specified path.
     *
     *
     * Тестирует get() с callback для несуществующего значения.
     *
     * Этот тест проверяет, что get() корректно вызывает callback
     * с null, когда значение не существует по указанному пути.
     *
     * @see CoverArray::get()
     */
    public function testGetWithCallbackForNonExistentValue(): void
    {
        $cover = new CoverArray([
            'user' => [
                'name' => 'John',
            ],
        ]);

        $result = $cover->get('user.email', fn($value) => $value ?? 'default@example.com');
        $this->assertSame('default@example.com', $result);

        $result2 = $cover->get('nonexistent', fn($value) => $value ?? 'fallback');
        $this->assertSame('fallback', $result2);
    }
}
