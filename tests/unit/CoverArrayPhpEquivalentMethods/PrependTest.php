<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class PrependTest extends TestCase
{
    /**
     * Tests the prepend() and unshift() methods (array_unshift equivalent).
     *
     * This test verifies that the prepend() method (and its unshift() alias)
     * correctly adds one or more elements to the beginning of the CoverArray,
     * shifting existing elements to higher indices, mirroring PHP's array_unshift().
     * Both methods modify the current instance and return it for method chaining.
     *
     * Note: When prepending to an array with string keys, the new elements
     * receive numeric indices starting from 0, and existing string keys are preserved.
     * This matches the behavior of PHP's array_unshift() function.
     *
     *
     * Тестирование методов prepend() и unshift() (эквивалент array_unshift).
     *
     * Этот тест проверяет, что метод prepend() (и его псевдоним unshift())
     * корректно добавляет один или несколько элементов в начало CoverArray,
     * сдвигая существующие элементы на более высокие индексы, отражая array_unshift() PHP.
     * Оба метода изменяют текущий экземпляр и возвращают его для цепочек вызовов.
     *
     * Примечание: При добавлении элементов в массив со строковыми ключами,
     * новые элементы получают числовые индексы, начиная с 0, а существующие строковые
     * ключи сохраняются. Это соответствует поведению функции array_unshift() PHP.
     *
     * @covers \Krugozor\Cover\CoverArray::prepend
     * @covers \Krugozor\Cover\CoverArray::unshift
     * @see    CoverArray::prepend()
     * @see    CoverArray::unshift()
     * @see    array_unshift()
     */
    public function testPrependMethod(): void
    {
        // Test 1: Basic prepend operation with single element
        // Тест 1: Базовая операция prepend с одним элементом
        $data1 = ['PHP', 'MySql'];
        $cover1 = new CoverArray($data1);

        $result1 = $cover1->prepend('C++');

        $this->assertSame(
            'C++',
            $cover1->first(),
            'First element should be "C++" after prepend'
        );

        $this->assertSame(
            $cover1,
            $result1,
            'prepend() should return $this for method chaining'
        );

        $this->assertSame(
            ['C++', 'PHP', 'MySql'],
            $cover1->getDataAsArray()
        );

        // Test 2: Prepending multiple elements
        // Тест 2: Добавление нескольких элементов в начало
        $cover2 = new CoverArray(['PHP', 'MySql']);
        $cover2->prepend('Python', 'Ruby');

        $this->assertSame(
            'Python',
            $cover2->first(),
            'First element should be "Python" after prepending multiple elements'
        );

        $this->assertSame(
            ['Python', 'Ruby', 'PHP', 'MySql'],
            $cover2->getDataAsArray()
        );

        // Test 3: Prepending an array (array becomes nested)
        // Тест 3: Добавление массива (массив становится вложенным)
        $cover3 = new CoverArray(['PHP', 'MySql']);
        $cover3->prepend(['Python', 'Ruby']);

        $firstElement = $cover3->first();
        $this->assertInstanceOf(
            CoverArray::class,
            $firstElement,
            'Prepended array should be converted to CoverArray'
        );

        $this->assertSame(
            ['Python', 'Ruby'],
            $firstElement->getDataAsArray(),
            'Prepended array should be nested as CoverArray'
        );

        $this->assertSame(
            [['Python', 'Ruby'], 'PHP', 'MySql'],
            $cover3->getDataAsArray()
        );

        // Test 4: unshift() alias - should behave identically to prepend()
        // Тест 4: Алиас unshift() - должен вести себя идентично prepend()
        $cover4 = new CoverArray(['PHP', 'MySql']);
        $cover4->unshift('Java', 'C#');

        $this->assertSame(
            'Java',
            $cover4->first(),
            'First element should be "Java" after unshift()'
        );

        $this->assertSame(
            ['Java', 'C#', 'PHP', 'MySql'],
            $cover4->getDataAsArray(),
            'unshift() should prepend elements in order'
        );

        // Test 5: Verify unshift() returns $this for chaining
        // Тест 5: Проверяем, что unshift() возвращает $this для цепочек вызовов
        $cover5 = new CoverArray(['PHP']);
        $returnValue = $cover5->unshift('Java');

        $this->assertSame(
            $cover5,
            $returnValue,
            'unshift() should return $this for method chaining'
        );

        // Test 6: Empty array prepend
        // Тест 6: Добавление элементов в пустой массив
        $cover6 = new CoverArray([]);
        $cover6->prepend('first');

        $this->assertSame(
            ['first'],
            $cover6->getDataAsArray(),
            'Prepending to empty array should work correctly'
        );

        // Test 7: Prepending to associative array - numeric index for new element
        // Тест 7: Добавление элемента в ассоциативный массив - числовой индекс для нового элемента
        $cover7 = new CoverArray(['b' => 'PHP', 'c' => 'MySql']);
        $cover7->prepend('Java'); // Передаем просто строку, не ассоциативный массив

        $this->assertSame(
            [0 => 'Java', 'b' => 'PHP', 'c' => 'MySql'],
            $cover7->getDataAsArray(),
            'When prepending to associative array, new element gets numeric index'
        );

        // Test 8: Prepending associative array (becomes nested at index 0)
        // Тест 8: Добавление ассоциативного массива (становится вложенным по индексу 0)
        $cover8 = new CoverArray(['b' => 'PHP', 'c' => 'MySql']);
        $cover8->prepend(['a' => 'Java']); // Передаем ассоциативный массив

        $firstElement8 = $cover8->first();
        $this->assertInstanceOf(
            CoverArray::class,
            $firstElement8,
            'Prepended associative array should be converted to CoverArray'
        );

        $this->assertSame(
            ['a' => 'Java'],
            $firstElement8->getDataAsArray(),
            'Prepended associative array should be nested'
        );

        $this->assertSame(
            [0 => ['a' => 'Java'], 'b' => 'PHP', 'c' => 'MySql'],
            $cover8->getDataAsArray()
        );

        // Test 9: Mixed prepend - string keys and numeric indices
        // Тест 9: Смешанное добавление - строковые ключи и числовые индексы
        $cover9 = new CoverArray([0 => 'PHP', 1 => 'MySql']);
        $cover9->prepend('new');

        $this->assertSame(
            [0 => 'new', 1 => 'PHP', 2 => 'MySql'],
            $cover9->getDataAsArray(),
            'Numeric indices should be reindexed when prepending new elements'
        );

        // Test 10: Verify both methods produce identical results
        // Тест 10: Проверяем, что оба метода дают идентичные результаты
        $initialData = ['c', 'd', 'e'];
        $cover10a = new CoverArray($initialData);
        $cover10b = new CoverArray($initialData);

        $result10a = $cover10a->prepend('a', 'b');
        $result10b = $cover10b->unshift('a', 'b');

        $this->assertEquals(
            $result10a->getDataAsArray(),
            $result10b->getDataAsArray(),
            'prepend() and unshift() should produce identical results'
        );

        // Test 11: Complex nested structure prepend
        // Тест 11: Добавление сложной вложенной структуры
        $cover11 = new CoverArray([
            'backend' => ['PHP', 'MySql'],
            'frontend' => ['HTML', 'CSS']
        ]);

        $cover11->prepend('new_top_level');

        $this->assertSame(
            [0 => 'new_top_level', 'backend' => ['PHP', 'MySql'], 'frontend' => ['HTML', 'CSS']],
            $cover11->getDataAsArray(),
            'Prepending to complex nested structure should work correctly'
        );

        // Test 12: Verify method modifies the instance (not returning new instance)
        // Тест 12: Проверяем, что метод изменяет экземпляр (не возвращает новый)
        $original = ['PHP', 'MySql'];
        $cover12 = new CoverArray($original);
        $result12 = $cover12->prepend('new');

        $this->assertSame(
            $cover12,
            $result12,
            'prepend() should modify and return the same instance'
        );

        $this->assertNotSame(
            $original,
            $cover12->getDataAsArray(),
            'Original data should be modified'
        );

        // Test 13: Prepending empty (edge case)
        // Тест 13: Добавление пустого значения (граничный случай)
        $cover13 = new CoverArray(['PHP']);
        $result13 = $cover13->prepend();

        $this->assertSame(
            $cover13,
            $result13,
            'prepend() without arguments should return $this unchanged'
        );

        $this->assertSame(
            ['PHP'],
            $cover13->getDataAsArray(),
            'Array should remain unchanged when prepending nothing'
        );
    }
}