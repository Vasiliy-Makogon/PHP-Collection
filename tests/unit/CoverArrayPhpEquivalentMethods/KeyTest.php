<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class KeyTest extends TestCase
{
    /**
     * Tests the key() method with basic array.
     *
     * This test verifies that the key() method correctly returns
     * the key of the element at the current internal pointer position,
     * mirroring PHP's key() function behavior.
     *
     *
     * Тестирование метода key() с базовым массивом.
     *
     * Этот тест проверяет, что метод key() корректно возвращает
     * ключ элемента в текущей позиции внутреннего указателя,
     * отражая поведение функции key() PHP.
     *
     * @see CoverArray::key()
     * @see key()
     */
    public function testKeyWithBasicArray(): void
    {
        $data = ['apple', 'banana', 'cherry'];
        $dataCopy = $data;

        $expected = key($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->key();

        // Check current key
        $this->assertSame($expected, $result);
        $this->assertSame(0, $result);
    }

    /**
     * Tests the key() method after reset.
     *
     * This test verifies that the key() method returns
     * the first key after resetting the internal pointer,
     * mirroring PHP's key() function behavior.
     *
     *
     * Тестирование метода key() после reset.
     *
     * Этот тест проверяет, что метод key() возвращает
     * первый ключ после сброса внутреннего указателя,
     * отражая поведение функции key() PHP.
     *
     * @see CoverArray::key()
     * @see key()
     */
    public function testKeyAfterReset(): void
    {
        $data = ['first', 'second', 'third'];
        $dataCopy = $data;

        reset($data);
        $expected = key($data);

        $cover = new CoverArray($dataCopy);
        $cover->reset();
        $result = $cover->key();

        // Check key is first
        $this->assertSame($expected, $result);
        $this->assertSame(0, $result);
    }

    /**
     * Tests the key() method after next.
     *
     * This test verifies that the key() method returns
     * the correct key after advancing the internal pointer,
     * mirroring PHP's key() function behavior.
     *
     *
     * Тестирование метода key() после next.
     *
     * Этот тест проверяет, что метод key() возвращает
     * корректный ключ после продвижения внутреннего указателя,
     * отражая поведение функции key() PHP.
     *
     * @see CoverArray::key()
     * @see key()
     */
    public function testKeyAfterNext(): void
    {
        $data = [10, 20, 30];
        $dataCopy = $data;

        next($data);
        $expected = key($data);

        $cover = new CoverArray($dataCopy);
        $cover->next();
        $result = $cover->key();

        // Check key is second
        $this->assertSame($expected, $result);
        $this->assertSame(1, $result);
    }

    /**
     * Tests the key() method after end.
     *
     * This test verifies that the key() method returns
     * the last key after setting pointer to the end,
     * mirroring PHP's key() function behavior.
     *
     *
     * Тестирование метода key() после end.
     *
     * Этот тест проверяет, что метод key() возвращает
     * последний ключ после установки указателя в конец,
     * отражая поведение функции key() PHP.
     *
     * @see CoverArray::key()
     * @see key()
     */
    public function testKeyAfterEnd(): void
    {
        $data = ['a', 'b', 'c'];
        $dataCopy = $data;

        end($data);
        $expected = key($data);

        $cover = new CoverArray($dataCopy);
        $cover->end();
        $result = $cover->key();

        // Check key is last
        $this->assertSame($expected, $result);
        $this->assertSame(2, $result);
    }

    /**
     * Tests the key() method with empty array.
     *
     * This test verifies that the key() method returns null
     * for empty arrays,
     * mirroring PHP's key() function behavior.
     *
     *
     * Тестирование метода key() с пустым массивом.
     *
     * Этот тест проверяет, что метод key() возвращает null
     * для пустых массивов,
     * отражая поведение функции key() PHP.
     *
     * @see CoverArray::key()
     * @see key()
     */
    public function testKeyWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        $expected = key($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->key();

        // Check returns null for empty array
        $this->assertSame($expected, $result);
        $this->assertNull($result);
    }

    /**
     * Tests the key() method with single element.
     *
     * This test verifies that the key() method correctly returns
     * the only key in a single-element array,
     * mirroring PHP's key() function behavior.
     *
     *
     * Тестирование метода key() с одним элементом.
     *
     * Этот тест проверяет, что метод key() корректно возвращает
     * единственный ключ в массиве из одного элемента,
     * отражая поведение функции key() PHP.
     *
     * @see CoverArray::key()
     * @see key()
     */
    public function testKeyWithSingleElement(): void
    {
        $data = [42];
        $dataCopy = $data;

        $expected = key($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->key();

        // Check current key
        $this->assertSame($expected, $result);
        $this->assertSame(0, $result);
    }

    /**
     * Tests the key() method with string keys.
     *
     * This test verifies that the key() method correctly returns
     * the current string key from an associative array,
     * mirroring PHP's key() function behavior.
     *
     *
     * Тестирование метода key() со строковыми ключами.
     *
     * Этот тест проверяет, что метод key() корректно возвращает
     * текущий строковый ключ из ассоциативного массива,
     * отражая поведение функции key() PHP.
     *
     * @see CoverArray::key()
     * @see key()
     */
    public function testKeyWithStringKeys(): void
    {
        $data = ['first' => 'one', 'second' => 'two', 'third' => 'three'];
        $dataCopy = $data;

        $expected = key($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->key();

        // Check current key
        $this->assertSame($expected, $result);
        $this->assertSame('first', $result);
    }

    /**
     * Tests the key() method with numeric keys.
     *
     * This test verifies that the key() method correctly returns
     * the current numeric key from an array,
     * mirroring PHP's key() function behavior.
     *
     *
     * Тестирование метода key() с числовыми ключами.
     *
     * Этот тест проверяет, что метод key() корректно возвращает
     * текущий числовой ключ из массива,
     * отражая поведение функции key() PHP.
     *
     * @see CoverArray::key()
     * @see key()
     */
    public function testKeyWithNumericKeys(): void
    {
        $data = [10 => 'ten', 20 => 'twenty', 30 => 'thirty'];
        $dataCopy = $data;

        $expected = key($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->key();

        // Check current key
        $this->assertSame($expected, $result);
        $this->assertSame(10, $result);
    }

    /**
     * Tests the key() method after iterating all elements.
     *
     * This test verifies that the key() method returns null
     * when the internal pointer is past the end of the array,
     * mirroring PHP's key() function behavior.
     *
     *
     * Тестирование метода key() после итерации всех элементов.
     *
     * Этот тест проверяет, что метод key() возвращает null,
     * когда внутренний указатель находится за концом массива,
     * отражая поведение функции key() PHP.
     *
     * @see CoverArray::key()
     * @see key()
     */
    public function testKeyAfterIteratingAllElements(): void
    {
        $data = ['a', 'b', 'c'];
        $dataCopy = $data;

        // Move pointer past the end
        while (next($data) !== false);
        $expected = key($data);

        $cover = new CoverArray($dataCopy);
        // Move pointer past the end
        while ($cover->next() !== false);
        $result = $cover->key();

        // Check returns null when pointer is past the end
        $this->assertSame($expected, $result);
        $this->assertNull($result);
    }

    /**
     * Tests the key() method with mixed key types.
     *
     * This test verifies that the key() method correctly returns
     * keys of different types,
     * mirroring PHP's key() function behavior.
     *
     *
     * Тестирование метода key() со смешанными типами ключей.
     *
     * Этот тест проверяет, что метод key() корректно возвращает
     * ключи разных типов,
     * отражая поведение функции key() PHP.
     *
     * @see CoverArray::key()
     * @see key()
     */
    public function testKeyWithMixedKeyTypes(): void
    {
        $data = [0 => 'zero', 'one' => 1, 2 => 'two'];
        $dataCopy = $data;

        $expected = key($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->key();

        // Check current key
        $this->assertSame($expected, $result);
        $this->assertSame(0, $result);
    }

    /**
     * Tests the key() method navigation through array.
     *
     * This test verifies that the key() method correctly tracks
     * the key as we navigate through the array,
     * mirroring PHP's key() function behavior.
     *
     *
     * Тестирование метода key() при навигации по массиву.
     *
     * Этот тест проверяет, что метод key() корректно отслеживает
     * ключ при навигации по массиву,
     * отражая поведение функции key() PHP.
     *
     * @see CoverArray::key()
     * @see key()
     */
    public function testKeyNavigationThroughArray(): void
    {
        $data = ['first' => 'a', 'second' => 'b', 'third' => 'c'];
        $dataCopy = $data;

        reset($data);
        $key1 = key($data);
        next($data);
        $key2 = key($data);
        next($data);
        $key3 = key($data);

        $cover = new CoverArray($dataCopy);
        $cover->reset();
        $result1 = $cover->key();
        $cover->next();
        $result2 = $cover->key();
        $cover->next();
        $result3 = $cover->key();

        // Check keys during navigation
        $this->assertSame($key1, $result1);
        $this->assertSame($key2, $result2);
        $this->assertSame($key3, $result3);
        $this->assertSame('first', $result1);
        $this->assertSame('second', $result2);
        $this->assertSame('third', $result3);
    }

    /**
     * Tests the key() method with prev navigation.
     *
     * This test verifies that the key() method correctly returns
     * the key when moving backwards through the array,
     * mirroring PHP's key() function behavior.
     *
     *
     * Тестирование метода key() с навигацией prev.
     *
     * Этот тест проверяет, что метод key() корректно возвращает
     * ключ при движении назад по массиву,
     * отражая поведение функции key() PHP.
     *
     * @see CoverArray::key()
     * @see key()
     */
    public function testKeyWithPrevNavigation(): void
    {
        $data = [1, 2, 3, 4];
        $dataCopy = $data;

        end($data);
        $keyEnd = key($data);
        prev($data);
        $keyPrev = key($data);

        $cover = new CoverArray($dataCopy);
        $cover->end();
        $resultEnd = $cover->key();
        $cover->prev();
        $resultPrev = $cover->key();

        // Check keys during backward navigation
        $this->assertSame($keyEnd, $resultEnd);
        $this->assertSame($keyPrev, $resultPrev);
        $this->assertSame(3, $resultEnd);
        $this->assertSame(2, $resultPrev);
    }
}
