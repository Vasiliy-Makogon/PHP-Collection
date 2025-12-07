<?php

declare(strict_types=1);

use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class PhpEquivalentMethodsTest extends TestCase
{
    /** @var NewTypeArray */
    protected NewTypeArray $data;

    public function setUp(): void
    {
        $this->data = new NewTypeArray([
            'name' => 'Vasiliy',
            'birthday' => [18, 8, 1982],
            'languages' => [
                'backend' => ['PHP', 'MySql'],
                'frontend' => ['HTML', 'CSS', 'JavaScript']
            ],
            'address' => [
                'country' => 'Russia',
                'region' => 'Moscow region',
                'city' => 'Podolsk',
                'street' => 'Kirov st.'
            ]
        ]);
    }

    /**
     * Tests the all() method (array_all equivalent).
     *
     * This test verifies that the all() method correctly checks if all
     * elements in the CoverArray satisfy the given callback function,
     * returning true only when all elements pass the condition.
     *
     *
     * Тестирование метода all() (эквивалент array_all).
     *
     * Этот тест проверяет, что метод all() корректно проверяет, удовлетворяют ли
     * все элементы в CoverArray заданной callback-функции,
     * возвращая true только когда все элементы удовлетворяют условию.
     *
     * @see CoverArray::all()
     * @see array_all()
     */
    public function testAllMethod(): void
    {
        // Test with array where all elements satisfy condition
        // Тест с массивом, где все элементы удовлетворяют условию
        $data1 = [2, 4, 6, 8, 10];
        $cover1 = new CoverArray($data1);

        $this->assertTrue($cover1->all(function ($value, $key) {
            return $value % 2 === 0; // все числа четные
        }));

        // Test with array where not all elements satisfy condition
        // Тест с массивом, где не все элементы удовлетворяют условию
        $data2 = [2, 4, 5, 8, 10];
        $cover2 = new CoverArray($data2);

        $this->assertFalse($cover2->all(function ($value, $key) {
            return $value % 2 === 0; // 5 не четное
        }));

        // Test with array of strings
        // Тест с массивом строк
        $data3 = ['apple', 'apricot', 'avocado'];
        $cover3 = new CoverArray($data3);

        $this->assertTrue($cover3->all(function ($value, $key) {
            return str_starts_with($value, 'a');
        }));

        $data4 = ['apple', 'banana', 'apricot'];
        $cover4 = new CoverArray($data4);

        $this->assertFalse($cover4->all(function ($value, $key) {
            return str_starts_with($value, 'a');
        }));

        // Test with associative array
        // Тест с ассоциативным массивом
        $data5 = ['a' => 1, 'b' => 2, 'c' => 3];
        $cover5 = new CoverArray($data5);

        $this->assertTrue($cover5->all(function ($value, $key) {
            return is_string($key) && is_int($value);
        }));

        // Test with empty array (should return true)
        // Тест с пустым массивом (должен вернуть true)
        $data6 = [];
        $cover6 = new CoverArray($data6);

        $this->assertTrue($cover6->all(function ($value, $key) {
            return $value > 10; // для пустого массива всегда true
        }));

        // Test with callback that checks both value and key
        // Тест с callback, который проверяет и значение, и ключ
        $data7 = [0 => 'zero', 1 => 'one', 2 => 'two'];
        $cover7 = new CoverArray($data7);

        $this->assertTrue($cover7->all(function ($value, $key) {
            return is_int($key) && is_string($value);
        }));

        $data8 = [0 => 'zero', 1 => 1, 2 => 'two'];
        $cover8 = new CoverArray($data8);

        $this->assertFalse($cover8->all(function ($value, $key) {
            return is_string($value);
        }));
    }

    /**
     * Tests the any() method (array_any equivalent).
     *
     * This test verifies that the any() method correctly checks if at least
     * one element in the CoverArray satisfies the given callback function,
     * returning true when any element passes the condition.
     *
     *
     * Тестирование метода any() (эквивалент array_any).
     *
     * Этот тест проверяет, что метод any() корректно проверяет, удовлетворяет ли
     * хотя бы один элемент в CoverArray заданной callback-функции,
     * возвращая true когда любой элемент удовлетворяет условию.
     *
     * @see CoverArray::any()
     * @see array_any()
     */
    public function testAnyMethod(): void
    {
        // Test with array of numbers
        // Тест с массивом чисел
        $data1 = [1, 2, 3, 4, 5];
        $cover1 = new CoverArray($data1);

        $this->assertTrue($cover1->any(function ($value, $key) {
            return $value > 3;
        }));

        $this->assertFalse($cover1->any(function ($value, $key) {
            return $value > 10;
        }));

        // Test with array of strings
        // Тест с массивом строк
        $data2 = ['apple', 'banana', 'cherry'];
        $cover2 = new CoverArray($data2);

        $this->assertTrue($cover2->any(function ($value, $key) {
            return $value === 'banana';
        }));

        $this->assertFalse($cover2->any(function ($value, $key) {
            return $value === 'orange';
        }));

        // Test with associative array
        // Тест с ассоциативным массивом
        $data3 = ['name' => 'John', 'age' => 30, 'city' => 'New York'];
        $cover3 = new CoverArray($data3);

        $this->assertTrue($cover3->any(function ($value, $key) {
            return $key === 'age' && $value === 30;
        }));

        $this->assertFalse($cover3->any(function ($value, $key) {
            return $key === 'country' && $value === 'USA';
        }));

        // Test with empty array
        // Тест с пустым массивом
        $data4 = [];
        $cover4 = new CoverArray($data4);

        $this->assertFalse($cover4->any(function ($value, $key) {
            return $value === 'anything';
        }));

        // Test with callback that uses both value and key
        // Тест с callback, который использует и значение, и ключ
        $data5 = [10 => 'ten', 20 => 'twenty', 30 => 'thirty'];
        $cover5 = new CoverArray($data5);

        $this->assertTrue($cover5->any(function ($value, $key) {
            return $key > 15 && strpos($value, 'tw') === 0;
        }));

        $this->assertFalse($cover5->any(function ($value, $key) {
            return $key > 40 || $value === 'forty';
        }));
    }

    /**
     * Tests the changeKeyCase() method (array_change_key_case equivalent).
     *
     * This test verifies that the changeKeyCase() method correctly changes
     * the case of all keys in the CoverArray to either uppercase or lowercase,
     * mirroring the behavior of PHP's array_change_key_case() function.
     *
     *
     * Тестирование метода changeKeyCase() (эквивалент array_change_key_case).
     *
     * Этот тест проверяет, что метод changeKeyCase() корректно изменяет
     * регистр всех ключей в CoverArray в верхний или нижний регистр,
     * отражая поведение функции array_change_key_case() PHP.
     *
     * @see CoverArray::changeKeyCase()
     * @see array_change_key_case()
     */
    public function testChangeKeyCaseMethod(): void
    {
        // Test changing keys to lowercase (default)
        // Тест изменения ключей в нижний регистр (по умолчанию)
        $data1 = ['Apple' => 1, 'Banana' => 2, 'Cherry' => 3];

        $expected1 = array_change_key_case($data1, CASE_LOWER);

        $cover1 = new CoverArray($data1);
        $this->assertSame(
            $expected1,
            $cover1->changeKeyCase(CASE_LOWER)->getDataAsArray()
        );

        // Test changing keys to uppercase
        // Тест изменения ключей в верхний регистр
        $data2 = ['apple' => 1, 'banana' => 2, 'cherry' => 3];

        $expected2 = array_change_key_case($data2, CASE_UPPER);

        $cover2 = new CoverArray($data2);
        $this->assertSame(
            $expected2,
            $cover2->changeKeyCase(CASE_UPPER)->getDataAsArray()
        );

        // Test with mixed case keys to lowercase
        // Тест с ключами в смешанном регистре в нижний регистр
        $data3 = ['Apple' => 1, 'BANANA' => 2, 'cherry' => 3];

        $expected3 = array_change_key_case($data3, CASE_LOWER);

        $cover3 = new CoverArray($data3);
        $this->assertSame(
            $expected3,
            $cover3->changeKeyCase(CASE_LOWER)->getDataAsArray()
        );

        // Test with numeric keys (should remain unchanged)
        // Тест с числовыми ключами (должны остаться без изменений)
        $data4 = [0 => 'zero', 'Apple' => 1, 1 => 'one'];

        $expected4 = array_change_key_case($data4, CASE_UPPER);

        $cover4 = new CoverArray($data4);
        $this->assertSame(
            $expected4,
            $cover4->changeKeyCase(CASE_UPPER)->getDataAsArray()
        );

        // Test with special characters in keys
        // Тест со специальными символами в ключах
        $data5 = ['foo-bar' => 1, 'test_key' => 2, 'привет' => 3];

        $expected5 = array_change_key_case($data5, CASE_UPPER);

        $cover5 = new CoverArray($data5);
        $this->assertSame(
            $expected5,
            $cover5->changeKeyCase(CASE_UPPER)->getDataAsArray()
        );
    }

    /**
     * Tests the chunk() method (array_chunk equivalent).
     *
     * This test verifies that the chunk() method correctly splits the CoverArray
     * into chunks of specified size, with optional key preservation,
     * mirroring the behavior of PHP's array_chunk() function.
     *
     *
     * Тестирование метода chunk() (эквивалент array_chunk).
     *
     * Этот тест проверяет, что метод chunk() корректно разбивает CoverArray
     * на части указанного размера, с опциональным сохранением ключей,
     * отражая поведение функции array_chunk() PHP.
     *
     * @see CoverArray::chunk()
     * @see array_chunk()
     */
    public function testChunkMethod(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry', 'd' => 'date', 'e' => 'elderberry'];
        $cover = new CoverArray($data);

        // Test chunk without preserving keys
        // Тест разбиения без сохранения ключей
        $expected1 = array_chunk($data, 2, false);

        $this->assertSame(
            $expected1,
            $cover->chunk(2, false)->getDataAsArray()
        );

        // Test chunk preserving keys
        // Тест разбиения с сохранением ключей
        $expected2 = array_chunk($data, 2, true);

        $this->assertSame(
            $expected2,
            $cover->chunk(2, true)->getDataAsArray()
        );

        // Test chunk with size 3
        // Тест разбиения на размер 3
        $expected3 = array_chunk($data, 3, false);

        $this->assertSame(
            $expected3,
            $cover->chunk(3, false)->getDataAsArray()
        );

        // Test chunk with size larger than array
        // Тест разбиения на размер больше массива
        $expected4 = array_chunk($data, 10, false);

        $this->assertSame(
            $expected4,
            $cover->chunk(10, false)->getDataAsArray()
        );

        // Test chunk with size 1
        // Тест разбиения на размер 1
        $expected5 = array_chunk($data, 1, true);

        $this->assertSame(
            $expected5,
            $cover->chunk(1, true)->getDataAsArray()
        );

        // Test exception for invalid chunk size (0)
        // Тест исключения для недопустимого размера части (0)
        $this->expectException(ValueError::class);
        $cover->chunk(0, false);
    }

    /**
     * Tests the column() method (array_column equivalent).
     *
     * This test verifies that the column() method correctly returns
     * the values from a single column in the input array, with optional
     * index key specification, mirroring PHP's array_column() function.
     *
     *
     * Тестирование метода column() (эквивалент array_column).
     *
     * Этот тест проверяет, что метод column() корректно возвращает
     * значения из одного столбца входного массива, с опциональным
     * указанием ключа индекса, отражая функцию array_column() PHP.
     *
     * @see CoverArray::column()
     * @see array_column()
     */
    public function testColumnMethod(): void
    {
        $data = [
            ['id' => 2135, 'first_name' => 'John', 'last_name' => 'Doe'],
            ['id' => 3245, 'first_name' => 'Sally', 'last_name' => 'Smith'],
            ['id' => 5342, 'first_name' => 'Jane', 'last_name' => 'Jones'],
            ['id' => 5623, 'first_name' => 'Peter', 'last_name' => 'Doe']
        ];

        $cover = new CoverArray($data);

        // Test without index key
        // Тест без ключа индекса
        $expected1 = array_column($data, 'first_name');

        $this->assertSame(
            $expected1,
            $cover->column('first_name')->getDataAsArray()
        );

        // Test with index key
        // Тест с ключом индекса
        $expected2 = array_column($data, 'first_name', 'id');

        $this->assertSame(
            $expected2,
            $cover->column('first_name', 'id')->getDataAsArray()
        );

        // Test with null column key (returns array of nulls)
        // Тест с null в качестве ключа столбца (возвращает массив null)
        $expected3 = array_column($data, null, 'id');

        $this->assertSame(
            $expected3,
            $cover->column(null, 'id')->getDataAsArray()
        );

        // Test with both null column and index keys
        // Тест с null в качестве ключа столбца и индекса
        $expected4 = array_column($data, null);

        $this->assertSame(
            $expected4,
            $cover->column(null)->getDataAsArray()
        );
    }

    /**
     * Tests the combine() method (array_combine equivalent).
     *
     * This test verifies that the combine() static method correctly creates
     * a new CoverArray by using one array for keys and another for values,
     * mirroring the behavior of PHP's array_combine() function.
     *
     *
     * Тестирование метода combine() (эквивалент array_combine).
     *
     * Этот тест проверяет, что статический метод combine() корректно создает
     * новый CoverArray, используя один массив для ключей, а другой для значений,
     * отражая поведение функции array_combine() PHP.
     *
     * @see CoverArray::combine()
     * @see array_combine()
     */
    public function testCombineMethod(): void
    {
        $keys = ['name', 'age', 'city'];
        $values = ['John', 30, 'New York'];

        $expected = array_combine($keys, $values);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            CoverArray::combine(
                $keys,
                $values
            )->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            CoverArray::combine(
                new CoverArray($keys),
                new CoverArray($values)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the countValues() method (array_count_values equivalent).
     *
     * This test verifies that the countValues() method correctly counts
     * the occurrences of each value in the CoverArray, returning a new
     * CoverArray where keys are the original values and values are their counts.
     *
     *
     * Тестирование метода countValues() (эквивалент array_count_values).
     *
     * Этот тест проверяет, что метод countValues() корректно подсчитывает
     * количество вхождений каждого значения в CoverArray, возвращая новый
     * CoverArray, где ключи - это исходные значения, а значения - их количество.
     *
     * @see CoverArray::countValues()
     * @see array_count_values()
     */
    public function testCountValuesMethod(): void
    {
        // Test with simple array of strings
        // Тест с простым массивом строк
        $data = ['apple', 'banana', 'apple', 'orange', 'banana', 'apple'];

        $expected = array_count_values($data);

        // CoverArray method
        // метод CoverArray
        $cover = new CoverArray($data);
        $result = $cover->countValues();

        $this->assertSame($expected, $result->getDataAsArray());

        // Test with numbers
        // Тест с числами
        $data2 = [1, 2, 1, 3, 2, 1, 1];

        $expected2 = array_count_values($data2);

        // CoverArray method
        // метод CoverArray
        $cover2 = new CoverArray($data2);
        $result2 = $cover2->countValues();

        $this->assertSame($expected2, $result2->getDataAsArray());

        // Test with empty array
        // Тест с пустым массивом
        $data3 = [];

        $expected3 = array_count_values($data3);

        // CoverArray method
        // метод CoverArray
        $cover3 = new CoverArray($data3);
        $result3 = $cover3->countValues();

        $this->assertSame($expected3, $result3->getDataAsArray());

        // Test with mixed string and number values
        // Тест со смешанными строками и числами
        $data4 = ['apple', 1, 'banana', 1, 'apple', 2, 'apple'];

        $expected4 = array_count_values($data4);

        // CoverArray method
        // метод CoverArray
        $cover4 = new CoverArray($data4);
        $result4 = $cover4->countValues();

        $this->assertSame($expected4, $result4->getDataAsArray());
    }

    /**
     * Tests the diff() method (array_diff equivalent).
     *
     * This test verifies that the diff() method correctly computes
     * the difference of arrays, comparing values across multiple
     * CoverArray or array arguments, mirroring PHP's array_diff() function.
     *
     *
     * Тестирование метода diff() (эквивалент array_diff).
     *
     * Этот тест проверяет, что метод diff() корректно вычисляет
     * расхождение массивов, сравнивая значения через несколько
     * аргументов CoverArray или массивов, отражая функцию array_diff() PHP.
     *
     * @see CoverArray::diff()
     * @see array_diff()
     */
    public function testDiffMethod(): void
    {
        // Test with simple arrays
        // Тест с простыми массивами
        $data1 = [1, 2, 3, 4, 5];
        $diff1 = [2, 4];
        $diff2 = [3];

        $expected1 = array_diff($data1, $diff1, $diff2);

        $cover1 = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->diff($diff1, $diff2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->diff(
                new CoverArray($diff1),
                new CoverArray($diff2)
            )->getDataAsArray()
        );

        // Test with associative arrays (compares values, not keys)
        // Тест с ассоциативными массивами (сравнивает значения, не ключи)
        $data2 = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry', 'd' => 'date'];
        $diff3 = ['banana', 'date'];

        $expected2 = array_diff($data2, $diff3);

        $cover2 = new CoverArray($data2);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover2->diff($diff3)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover2->diff(new CoverArray($diff3))->getDataAsArray()
        );

        // Test with mixed types
        // Тест со смешанными типами
        $data3 = [1, '1', 2, '2', 3];
        $diff4 = [1, '2'];

        $expected3 = array_diff($data3, $diff4);

        $cover3 = new CoverArray($data3);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover3->diff($diff4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover3->diff(new CoverArray($diff4))->getDataAsArray()
        );

        // Test with empty diff array
        // Тест с пустым массивом для сравнения
        $data4 = ['a', 'b', 'c'];
        $diff5 = [];

        $expected4 = array_diff($data4, $diff5);

        $cover4 = new CoverArray($data4);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover4->diff($diff5)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover4->diff(new CoverArray($diff5))->getDataAsArray()
        );

        // Test with multiple diff arrays
        // Тест с несколькими массивами для сравнения
        $data5 = ['red', 'green', 'blue', 'yellow', 'purple'];
        $diff6 = ['green', 'yellow'];
        $diff7 = ['red'];
        $diff8 = ['blue'];

        $expected5 = array_diff($data5, $diff6, $diff7, $diff8);

        $cover5 = new CoverArray($data5);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover5->diff($diff6, $diff7, $diff8)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover5->diff(
                new CoverArray($diff6),
                new CoverArray($diff7),
                new CoverArray($diff8)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the diffAssoc() method (array_diff_assoc equivalent).
     *
     * This test verifies that the diffAssoc() method correctly computes
     * the difference of arrays with additional index check, comparing
     * both keys and values, mirroring PHP's array_diff_assoc() function.
     *
     *
     * Тестирование метода diffAssoc() (эквивалент array_diff_assoc).
     *
     * Этот тест проверяет, что метод diffAssoc() корректно вычисляет
     * расхождение массивов с дополнительной проверкой индекса, сравнивая
     * как ключи, так и значения, отражая функцию array_diff_assoc() PHP.
     *
     * @see CoverArray::diffAssoc()
     * @see array_diff_assoc()
     */
    public function testDiffAssocMethod(): void
    {
        // Test with simple associative arrays
        // Тест с простыми ассоциативными массивами
        $data1 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $diff1 = ['b' => 2, 'c' => 30, 'e' => 5];

        $expected1 = array_diff_assoc($data1, $diff1);

        $cover1 = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->diffAssoc($diff1)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->diffAssoc(new CoverArray($diff1))->getDataAsArray()
        );

        // Test with multiple diff arrays
        // Тест с несколькими массивами для сравнения
        $data2 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $diff2 = ['b' => 2, 'c' => 30];
        $diff3 = ['a' => 10, 'd' => 4];

        $expected2 = array_diff_assoc($data2, $diff2, $diff3);

        $cover2 = new CoverArray($data2);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover2->diffAssoc($diff2, $diff3)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover2->diffAssoc(
                new CoverArray($diff2),
                new CoverArray($diff3)
            )->getDataAsArray()
        );

        // Test with numeric keys (compares both key and value)
        // Тест с числовыми ключами (сравнивает и ключ, и значение)
        $data3 = [0 => 'zero', 1 => 'one', 2 => 'two'];
        $diff4 = [0 => 'zero', 1 => 'ONE', 3 => 'three'];

        $expected3 = array_diff_assoc($data3, $diff4);

        $cover3 = new CoverArray($data3);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover3->diffAssoc($diff4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover3->diffAssoc(new CoverArray($diff4))->getDataAsArray()
        );

        // Test with mixed key types
        // Тест со смешанными типами ключей
        $data4 = ['a' => 'apple', 0 => 'zero', '1' => 'one'];
        $diff5 = ['a' => 'apple', 0 => 'ZERO', '1' => 'one'];

        $expected4 = array_diff_assoc($data4, $diff5);

        $cover4 = new CoverArray($data4);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover4->diffAssoc($diff5)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover4->diffAssoc(new CoverArray($diff5))->getDataAsArray()
        );

        // Test with empty diff array (should return entire array)
        // Тест с пустым массивом для сравнения (должен вернуть весь массив)
        $data5 = ['x' => 10, 'y' => 20, 'z' => 30];
        $diff6 = [];

        $expected5 = array_diff_assoc($data5, $diff6);

        $cover5 = new CoverArray($data5);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover5->diffAssoc($diff6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover5->diffAssoc(new CoverArray($diff6))->getDataAsArray()
        );

        // Test where all elements are removed
        // Тест, где все элементы удаляются
        $data6 = ['a' => 1, 'b' => 2];
        $diff7 = ['a' => 1, 'b' => 2];

        $expected6 = array_diff_assoc($data6, $diff7);

        $cover6 = new CoverArray($data6);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected6,
            $cover6->diffAssoc($diff7)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected6,
            $cover6->diffAssoc(new CoverArray($diff7))->getDataAsArray()
        );
    }

    /**
     * Tests the diffKey() method (array_diff_key equivalent).
     *
     * This test verifies that the diffKey() method correctly computes
     * the difference of arrays using keys for comparison, ignoring
     * values, mirroring PHP's array_diff_key() function.
     *
     *
     * Тестирование метода diffKey() (эквивалент array_diff_key).
     *
     * Этот тест проверяет, что метод diffKey() корректно вычисляет
     * расхождение массивов, используя ключи для сравнения, игнорируя
     * значения, отражая функцию array_diff_key() PHP.
     *
     * @see CoverArray::diffKey()
     * @see array_diff_key()
     */
    public function testDiffKeyMethod(): void
    {
        // Test with string keys
        // Тест со строковыми ключами
        $data1 = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $diff1 = ['a' => 'apricot', 'c' => 'coconut'];

        $expected1 = array_diff_key($data1, $diff1);

        $cover1 = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->diffKey($diff1)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->diffKey(new CoverArray($diff1))->getDataAsArray()
        );

        // Test with numeric keys
        // Тест с числовыми ключами
        $data2 = [0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three'];
        $diff2 = [1 => 'ONE', 3 => 'THREE'];

        $expected2 = array_diff_key($data2, $diff2);

        $cover2 = new CoverArray($data2);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover2->diffKey($diff2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover2->diffKey(new CoverArray($diff2))->getDataAsArray()
        );

        // Test with multiple diff arrays
        // Тест с несколькими массивами для сравнения
        $data3 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5];
        $diff3 = ['a' => 10, 'c' => 30];
        $diff4 = ['b' => 20, 'd' => 40];

        $expected3 = array_diff_key($data3, $diff3, $diff4);

        $cover3 = new CoverArray($data3);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover3->diffKey($diff3, $diff4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover3->diffKey(
                new CoverArray($diff3),
                new CoverArray($diff4)
            )->getDataAsArray()
        );

        // Test with mixed key types
        // Тест со смешанными типами ключей
        $data4 = ['a' => 'apple', 0 => 'zero', '1' => 'one'];
        $diff5 = ['a' => 'apricot', 0 => 'ZERO'];

        $expected4 = array_diff_key($data4, $diff5);

        $cover4 = new CoverArray($data4);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover4->diffKey($diff5)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover4->diffKey(new CoverArray($diff5))->getDataAsArray()
        );

        // Test with empty diff array (should return entire array)
        // Тест с пустым массивом для сравнения (должен вернуть весь массив)
        $data5 = ['x' => 10, 'y' => 20, 'z' => 30];
        $diff6 = [];

        $expected5 = array_diff_key($data5, $diff6);

        $cover5 = new CoverArray($data5);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover5->diffKey($diff6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover5->diffKey(new CoverArray($diff6))->getDataAsArray()
        );

        // Test where all keys are removed
        // Тест, где все ключи удаляются
        $data6 = ['a' => 1, 'b' => 2];
        $diff7 = ['a' => 100, 'b' => 200];

        $expected6 = array_diff_key($data6, $diff7);

        $cover6 = new CoverArray($data6);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected6,
            $cover6->diffKey($diff7)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected6,
            $cover6->diffKey(new CoverArray($diff7))->getDataAsArray()
        );
    }

    /**
     * Tests the diffUassoc() method (array_diff_uassoc equivalent).
     *
     * This test verifies that the diffUassoc() method correctly computes
     * the difference of arrays with additional index check using a user-defined
     * callback function for key comparison, mirroring PHP's array_diff_uassoc().
     *
     *
     * Тестирование метода diffUassoc() (эквивалент array_diff_uassoc).
     *
     * Этот тест проверяет, что метод diffUassoc() корректно вычисляет
     * расхождение массивов с дополнительной проверкой индекса с использованием
     * пользовательской callback-функции для сравнения ключей, отражая array_diff_uassoc() PHP.
     *
     * @see CoverArray::diffUassoc()
     * @see array_diff_uassoc()
     */
    public function testDiffUassocMethod(): void
    {
        $callback = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            return $a <=> $b;
        };

        // Test with string keys using callback
        // Тест со строковыми ключами с использованием callback
        $data1 = ['a' => 1, 'b' => 2, 'c' => 3];
        $diff1 = ['a' => 1, 'b' => 20];

        $expected1 = array_diff_uassoc($data1, $diff1, $callback);

        $cover1 = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->diffUassoc($callback, $diff1)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->diffUassoc($callback, new CoverArray($diff1))->getDataAsArray()
        );

        // Test with numeric keys using callback
        // Тест с числовыми ключами с использованием callback
        $data2 = [0 => 'zero', 1 => 'one', 2 => 'two'];
        $diff2 = [0 => 'zero', 1 => 'ONE'];

        $expected2 = array_diff_uassoc($data2, $diff2, $callback);

        $cover2 = new CoverArray($data2);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover2->diffUassoc($callback, $diff2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover2->diffUassoc($callback, new CoverArray($diff2))->getDataAsArray()
        );

        // Test with multiple diff arrays
        // Тест с несколькими массивами для сравнения
        $data3 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $diff3 = ['a' => 1, 'b' => 20];
        $diff4 = ['c' => 30, 'd' => 4];

        $expected3 = array_diff_uassoc($data3, $diff3, $diff4, $callback);

        $cover3 = new CoverArray($data3);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover3->diffUassoc($callback, $diff3, $diff4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover3->diffUassoc(
                $callback,
                new CoverArray($diff3),
                new CoverArray($diff4)
            )->getDataAsArray()
        );

        // Test with case-insensitive comparison callback
        // Тест с callback для сравнения без учета регистра
        $caseInsensitiveCallback = function ($a, $b) {
            return strcasecmp((string) $a, (string) $b);
        };

        $data4 = ['A' => 'apple', 'B' => 'banana', 'c' => 'cherry'];
        $diff5 = ['a' => 'apple', 'b' => 'banana'];

        $expected4 = array_diff_uassoc($data4, $diff5, $caseInsensitiveCallback);

        $cover4 = new CoverArray($data4);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover4->diffUassoc($caseInsensitiveCallback, $diff5)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover4->diffUassoc($caseInsensitiveCallback, new CoverArray($diff5))->getDataAsArray()
        );

        // Test with custom key comparison logic
        // Тест с пользовательской логикой сравнения ключей
        $customCallback = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            // Приводим к строке и сравниваем длину
            $lenA = strlen((string) $a);
            $lenB = strlen((string) $b);

            if ($lenA === $lenB) {
                return strcmp((string) $a, (string) $b);
            }
            return $lenA <=> $lenB;
        };

        $data5 = ['aa' => 1, 'b' => 2, 'ccc' => 3];
        $diff6 = ['aa' => 10, 'ccc' => 3];

        $expected5 = array_diff_uassoc($data5, $diff6, $customCallback);

        $cover5 = new CoverArray($data5);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover5->diffUassoc($customCallback, $diff6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover5->diffUassoc($customCallback, new CoverArray($diff6))->getDataAsArray()
        );

        // Test with empty diff array
        // Тест с пустым массивом для сравнения
        $data6 = ['x' => 10, 'y' => 20];
        $diff7 = [];

        $expected6 = array_diff_uassoc($data6, $diff7, $callback);

        $cover6 = new CoverArray($data6);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected6,
            $cover6->diffUassoc($callback, $diff7)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected6,
            $cover6->diffUassoc($callback, new CoverArray($diff7))->getDataAsArray()
        );
    }

    /**
     * Tests the diffUkey() method (array_diff_ukey equivalent).
     *
     * This test verifies that the diffUkey() method correctly computes
     * the difference of arrays using a user-defined callback function
     * for key comparison, mirroring PHP's array_diff_ukey() function.
     *
     *
     * Тестирование метода diffUkey() (эквивалент array_diff_ukey).
     *
     * Этот тест проверяет, что метод diffUkey() корректно вычисляет
     * расхождение массивов с использованием пользовательской callback-функции
     * для сравнения ключей, отражая функцию array_diff_ukey() PHP.
     *
     * @see CoverArray::diffUkey()
     * @see array_diff_ukey()
     */
    public function testDiffUkeyMethod(): void
    {
        $callback = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            return $a <=> $b;
        };

        // Test with string keys using callback
        // Тест со строковыми ключами с использованием callback
        $data1 = ['a' => 1, 'b' => 2, 'c' => 3];
        $diff1 = ['a' => 100, 'b' => 200];

        $expected1 = array_diff_ukey($data1, $diff1, $callback);

        $cover1 = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->diffUkey($callback, $diff1)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->diffUkey($callback, new CoverArray($diff1))->getDataAsArray()
        );

        // Test with numeric keys using callback
        // Тест с числовыми ключами с использованием callback
        $data2 = [0 => 'zero', 1 => 'one', 2 => 'two'];
        $diff2 = [0 => 'ZERO', 1 => 'ONE'];

        $expected2 = array_diff_ukey($data2, $diff2, $callback);

        $cover2 = new CoverArray($data2);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover2->diffUkey($callback, $diff2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover2->diffUkey($callback, new CoverArray($diff2))->getDataAsArray()
        );

        // Test with multiple diff arrays
        // Тест с несколькими массивами для сравнения
        $data3 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $diff3 = ['a' => 10, 'b' => 20];
        $diff4 = ['c' => 30, 'd' => 40];

        $expected3 = array_diff_ukey($data3, $diff3, $diff4, $callback);

        $cover3 = new CoverArray($data3);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover3->diffUkey($callback, $diff3, $diff4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover3->diffUkey(
                $callback,
                new CoverArray($diff3),
                new CoverArray($diff4)
            )->getDataAsArray()
        );

        // Test with case-insensitive comparison callback
        // Тест с callback для сравнения без учета регистра
        $caseInsensitiveCallback = function ($a, $b) {
            return strcasecmp((string) $a, (string) $b);
        };

        $data4 = ['A' => 'apple', 'B' => 'banana', 'c' => 'cherry'];
        $diff5 = ['a' => 'apricot', 'b' => 'blueberry'];

        $expected4 = array_diff_ukey($data4, $diff5, $caseInsensitiveCallback);

        $cover4 = new CoverArray($data4);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover4->diffUkey($caseInsensitiveCallback, $diff5)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover4->diffUkey($caseInsensitiveCallback, new CoverArray($diff5))->getDataAsArray()
        );

        // Test with custom key comparison logic (comparing string lengths of keys)
        // Тест с пользовательской логикой сравнения ключей (сравнение длины строк ключей)
        $customCallback = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            // Приводим к строке и сравниваем длину
            $lenA = strlen((string) $a);
            $lenB = strlen((string) $b);

            if ($lenA === $lenB) {
                return strcmp((string) $a, (string) $b);
            }
            return $lenA <=> $lenB;
        };

        $data5 = ['aa' => 1, 'b' => 2, 'ccc' => 3];
        $diff6 = ['aa' => 10, 'ccc' => 30];

        $expected5 = array_diff_ukey($data5, $diff6, $customCallback);

        $cover5 = new CoverArray($data5);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover5->diffUkey($customCallback, $diff6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover5->diffUkey($customCallback, new CoverArray($diff6))->getDataAsArray()
        );

        // Test with empty diff array
        // Тест с пустым массивом для сравнения
        $data6 = ['x' => 10, 'y' => 20];
        $diff7 = [];

        $expected6 = array_diff_ukey($data6, $diff7, $callback);

        $cover6 = new CoverArray($data6);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected6,
            $cover6->diffUkey($callback, $diff7)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected6,
            $cover6->diffUkey($callback, new CoverArray($diff7))->getDataAsArray()
        );

        // Test where all keys are removed
        // Тест, где все ключи удаляются
        $data7 = ['a' => 1, 'b' => 2];
        $diff8 = ['a' => 100, 'b' => 200];

        $expected7 = array_diff_ukey($data7, $diff8, $callback);

        $cover7 = new CoverArray($data7);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected7,
            $cover7->diffUkey($callback, $diff8)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected7,
            $cover7->diffUkey($callback, new CoverArray($diff8))->getDataAsArray()
        );
    }

    /**
     * Tests the fill() method (array_fill equivalent).
     *
     * This test verifies that the fill() static method correctly creates
     * a CoverArray filled with specified values starting from a given index,
     * mirroring PHP's array_fill() function behavior.
     *
     *
     * Тестирование метода fill() (эквивалент array_fill).
     *
     * Этот тест проверяет, что статический метод fill() корректно создает
     * CoverArray, заполненный указанными значениями, начиная с заданного индекса,
     * отражая поведение функции array_fill() PHP.
     *
     * @see CoverArray::fill()
     * @see array_fill()
     */
    public function testFillMethod(): void
    {
        // Test with positive start index
        // Тест с положительным начальным индексом
        $expected1 = [2 => 'foo', 3 => 'foo'];

        $this->assertSame(
            $expected1,
            CoverArray::fill(2, 2, 'foo')->getDataAsArray()
        );

        // Test with zero start index
        // Тест с нулевым начальным индексом
        $expected2 = [0 => 'bar', 1 => 'bar', 2 => 'bar'];

        $this->assertSame(
            $expected2,
            CoverArray::fill(0, 3, 'bar')->getDataAsArray()
        );

        // Test with negative start index
        // Тест с отрицательным начальным индексом
        $expected3 = [-2 => 'test', -1 => 'test', 0 => 'test'];

        $this->assertSame(
            $expected3,
            CoverArray::fill(-2, 3, 'test')->getDataAsArray()
        );

        // Test with count 0 (should return empty array)
        // Тест с количеством 0 (должен вернуть пустой массив)
        $expected4 = [];

        $this->assertSame(
            $expected4,
            CoverArray::fill(5, 0, 'value')->getDataAsArray()
        );

        // Test with integer value
        // Тест с целочисленным значением
        $expected5 = [0 => 42, 1 => 42, 2 => 42];

        $this->assertSame(
            $expected5,
            CoverArray::fill(0, 3, 42)->getDataAsArray()
        );

        // Test with array value
        // Тест со значением-массивом
        $arrayValue = ['a', 'b', 'c'];
        $expected6 = [0 => $arrayValue, 1 => $arrayValue];

        $this->assertSame(
            $expected6,
            CoverArray::fill(0, 2, $arrayValue)->getDataAsArray()
        );

        // Test with null value
        // Тест со значением null
        $expected7 = [1 => null, 2 => null, 3 => null];

        $this->assertSame(
            $expected7,
            CoverArray::fill(1, 3, null)->getDataAsArray()
        );

        // Test with boolean value
        // Тест с булевым значением
        $expected8 = [0 => true, 1 => true, 2 => true];

        $this->assertSame(
            $expected8,
            CoverArray::fill(0, 3, true)->getDataAsArray()
        );

        // Test with count 1
        // Тест с количеством 1
        $expected9 = [10 => 'single'];

        $this->assertSame(
            $expected9,
            CoverArray::fill(10, 1, 'single')->getDataAsArray()
        );
    }

    /**
     * Tests the fillKeys() method (array_fill_keys equivalent).
     *
     * This test verifies that the fillKeys() static method correctly creates
     * a CoverArray and fills it with a specified value using provided keys,
     * mirroring PHP's array_fill_keys() function behavior.
     *
     *
     * Тестирование метода fillKeys() (эквивалент array_fill_keys).
     *
     * Этот тест проверяет, что статический метод fillKeys() корректно создает
     * CoverArray и заполняет его указанным значением с использованием предоставленных ключей,
     * отражая поведение функции array_fill_keys() PHP.
     *
     * @see CoverArray::fillKeys()
     * @see array_fill_keys()
     */
    public function testFillKeysMethod(): void
    {
        // Test with string and integer keys
        // Тест со строковыми и целочисленными ключами
        $keys1 = ['foo', 5, 10, 'bar'];
        $value1 = 'banana';

        $expected1 = array_fill_keys($keys1, $value1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            CoverArray::fillKeys($keys1, $value1)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            CoverArray::fillKeys(new CoverArray($keys1), $value1)->getDataAsArray()
        );

        // Test with only string keys
        // Тест только со строковыми ключами
        $keys2 = ['name', 'age', 'city'];
        $value2 = 'unknown';

        $expected2 = array_fill_keys($keys2, $value2);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            CoverArray::fillKeys($keys2, $value2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            CoverArray::fillKeys(new CoverArray($keys2), $value2)->getDataAsArray()
        );

        // Test with only numeric keys
        // Тест только с числовыми ключами
        $keys3 = [0, 1, 2, 3];
        $value3 = 42;

        $expected3 = array_fill_keys($keys3, $value3);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            CoverArray::fillKeys($keys3, $value3)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            CoverArray::fillKeys(new CoverArray($keys3), $value3)->getDataAsArray()
        );

        // Test with mixed types in value (array)
        // Тест со смешанными типами в значении (массив)
        $keys4 = ['a', 'b', 'c'];
        $value4 = ['nested' => 'value'];

        $expected4 = array_fill_keys($keys4, $value4);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            CoverArray::fillKeys($keys4, $value4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            CoverArray::fillKeys(new CoverArray($keys4), $value4)->getDataAsArray()
        );

        // Test with null value
        // Тест со значением null
        $keys5 = ['x', 'y', 'z'];
        $value5 = null;

        $expected5 = array_fill_keys($keys5, $value5);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            CoverArray::fillKeys($keys5, $value5)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            CoverArray::fillKeys(new CoverArray($keys5), $value5)->getDataAsArray()
        );

        // Test with empty keys array
        // Тест с пустым массивом ключей
        $keys6 = [];
        $value6 = 'any';

        $expected6 = array_fill_keys($keys6, $value6);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected6,
            CoverArray::fillKeys($keys6, $value6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected6,
            CoverArray::fillKeys(new CoverArray($keys6), $value6)->getDataAsArray()
        );

        // Test with duplicate keys (should create array with duplicate keys, which is allowed)
        // Тест с дублирующимися ключами (должен создать массив с дублирующимися ключами, что разрешено)
        $keys7 = ['a', 'b', 'a', 'c'];
        $value7 = 'duplicate';

        $expected7 = array_fill_keys($keys7, $value7);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected7,
            CoverArray::fillKeys($keys7, $value7)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected7,
            CoverArray::fillKeys(new CoverArray($keys7), $value7)->getDataAsArray()
        );
    }

    /**
     * Tests the filter() method (array_filter equivalent).
     *
     * This test verifies that the filter() method correctly filters elements
     * of the CoverArray using a callback function with different filtering modes,
     * mirroring PHP's array_filter() function behavior.
     *
     *
     * Тестирование метода filter() (эквивалент array_filter).
     *
     * Этот тест проверяет, что метод filter() корректно фильтрует элементы
     * CoverArray с использованием callback-функции с различными режимами фильтрации,
     * отражая поведение функции array_filter() PHP.
     *
     * @see CoverArray::filter()
     * @see array_filter()
     */
    public function testFilterMethod(): void
    {
        // Test with callback that filters by value
        // Тест с callback, который фильтрует по значению
        $data1 = [1, 2, 3, 4, 5];
        $callback1 = function ($value) {
            return $value % 2 === 0; // только четные числа
        };

        $expected1 = array_filter($data1, $callback1);

        $cover1 = new CoverArray($data1);
        $this->assertSame(
            $expected1,
            $cover1->filter($callback1)->getDataAsArray()
        );

        // Test with callback that filters by key (ARRAY_FILTER_USE_KEY)
        // Тест с callback, который фильтрует по ключу (ARRAY_FILTER_USE_KEY)
        $data2 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $callback2 = function ($key) {
            return in_array($key, ['a', 'c']); // только ключи 'a' и 'c'
        };

        $expected2 = array_filter($data2, $callback2, ARRAY_FILTER_USE_KEY);

        $cover2 = new CoverArray($data2);
        $this->assertSame(
            $expected2,
            $cover2->filter($callback2, ARRAY_FILTER_USE_KEY)->getDataAsArray()
        );

        // Test with callback that filters by both value and key (ARRAY_FILTER_USE_BOTH)
        // Тест с callback, который фильтрует и по значению, и по ключу (ARRAY_FILTER_USE_BOTH)
        $data3 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $callback3 = function ($value, $key) {
            return $value > 1 && $key !== 'c'; // значение > 1 и ключ не 'c'
        };

        $expected3 = array_filter($data3, $callback3, ARRAY_FILTER_USE_BOTH);

        $cover3 = new CoverArray($data3);
        $this->assertSame(
            $expected3,
            $cover3->filter($callback3, ARRAY_FILTER_USE_BOTH)->getDataAsArray()
        );

        // Test without callback (removes empty values) - excluding empty array to avoid PHP version differences
        // Тест без callback (удаляет пустые значения) - исключаем пустой массив, чтобы избежать различий между версиями PHP
        $data4 = [0 => 'a', 1 => false, 2 => null, 3 => '', 4 => 'b'];

        $expected4 = array_filter($data4);

        $cover4 = new CoverArray($data4);
        $this->assertSame(
            $expected4,
            $cover4->filter()->getDataAsArray()
        );

        // Test with callback that always returns false
        // Тест с callback, который всегда возвращает false
        $data5 = ['x' => 1, 'y' => 2, 'z' => 3];
        $callback5 = function ($value) {
            return false;
        };

        $expected5 = array_filter($data5, $callback5);

        $cover5 = new CoverArray($data5);
        $this->assertSame(
            $expected5,
            $cover5->filter($callback5)->getDataAsArray()
        );

        // Test with callback that always returns true
        // Тест с callback, который всегда возвращает true
        $data6 = ['x' => 1, 'y' => 2, 'z' => 3];
        $callback6 = function ($value) {
            return true;
        };

        $expected6 = array_filter($data6, $callback6);

        $cover6 = new CoverArray($data6);
        $this->assertSame(
            $expected6,
            $cover6->filter($callback6)->getDataAsArray()
        );

        // Test with empty array
        // Тест с пустым массивом
        $data7 = [];

        $expected7 = array_filter($data7);

        $cover7 = new CoverArray($data7);
        $this->assertSame(
            $expected7,
            $cover7->filter()->getDataAsArray()
        );

        // Test with array containing only falsey values (excluding empty array)
        // Тест с массивом, содержащим только ложные значения (исключая пустой массив)
        $data8 = [0, false, null, ''];

        $expected8 = array_filter($data8);

        $cover8 = new CoverArray($data8);
        $this->assertSame(
            $expected8,
            $cover8->filter()->getDataAsArray()
        );

        // Test with callback that uses only value (default mode)
        // Тест с callback, который использует только значение (режим по умолчанию)
        $data9 = [10, 20, 30, 40, 50];
        $callback9 = function ($value) {
            return $value > 25;
        };

        $expected9 = array_filter($data9, $callback9);

        $cover9 = new CoverArray($data9);
        $this->assertSame(
            $expected9,
            $cover9->filter($callback9)->getDataAsArray()
        );
    }

    /**
     * Tests the find() method (array_find equivalent).
     *
     * This test verifies that the find() method correctly returns the first
     * element satisfying a callback function, or null if no element matches,
     * mirroring the behavior of the array_find() function.
     *
     *
     * Тестирование метода find() (эквивалент array_find).
     *
     * Этот тест проверяет, что метод find() корректно возвращает первый
     * элемент, удовлетворяющий callback-функции, или null если ни один элемент не соответствует,
     * отражая поведение функции array_find().
     *
     * @see CoverArray::find()
     * @see array_find()
     */
    public function testFindMethod(): void
    {
        // Test finding an element in array of numbers
        // Тест поиска элемента в массиве чисел
        $data1 = [1, 3, 5, 7, 9];
        $cover1 = new CoverArray($data1);

        $this->assertSame(5, $cover1->find(function ($value, $key) {
            return $value > 4 && $key === 2;
        }));

        $this->assertNull($cover1->find(function ($value, $key) {
            return $value > 10;
        }));

        // Test finding an element in array of strings
        // Тест поиска элемента в массиве строк
        $data2 = ['apple', 'banana', 'cherry', 'date'];
        $cover2 = new CoverArray($data2);

        $this->assertSame('cherry', $cover2->find(function ($value, $key) {
            return str_starts_with($value, 'c');
        }));

        $this->assertNull($cover2->find(function ($value, $key) {
            return str_starts_with($value, 'z');
        }));

        // Test finding an element in associative array
        // Тест поиска элемента в ассоциативном массиве
        $data3 = ['name' => 'John', 'age' => 30, 'city' => 'New York'];
        $cover3 = new CoverArray($data3);

        $this->assertSame(30, $cover3->find(function ($value, $key) {
            return $key === 'age' && $value > 20;
        }));

        $this->assertNull($cover3->find(function ($value, $key) {
            return $key === 'country';
        }));

        // Test with empty array
        // Тест с пустым массивом
        $data4 = [];
        $cover4 = new CoverArray($data4);

        $this->assertNull($cover4->find(function ($value, $key) {
            return $value === 'anything';
        }));

        // Test finding first element when multiple elements satisfy condition
        // Тест поиска первого элемента, когда несколько элементов удовлетворяют условию
        $data5 = [10, 20, 30, 40, 50];
        $cover5 = new CoverArray($data5);

        $this->assertSame(30, $cover5->find(function ($value, $key) {
            return $value >= 30;
        }));

        // Test with callback that uses both value and key
        // Тест с callback, который использует и значение, и ключ
        $data6 = [0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three'];
        $cover6 = new CoverArray($data6);

        $this->assertSame('two', $cover6->find(function ($value, $key) {
            return $key === 2 && strlen($value) === 3;
        }));

        // Test finding element that matches multiple conditions
        // Тест поиска элемента, соответствующего нескольким условиям
        $data7 = ['a' => 5, 'b' => 10, 'c' => 15, 'd' => 20];
        $cover7 = new CoverArray($data7);

        $this->assertSame(15, $cover7->find(function ($value, $key) {
            return $value % 5 === 0 && $value % 3 === 0;
        }));

        $this->assertNull($cover7->find(function ($value, $key) {
            return $value > 100;
        }));
    }

    /**
     * Tests the findKey() method (array_find_key equivalent).
     *
     * This test verifies that the findKey() method correctly returns the key
     * of the first element satisfying a callback function, or null if no
     * element matches, mirroring the behavior of the array_find_key() function.
     *
     *
     * Тестирование метода findKey() (эквивалент array_find_key).
     *
     * Этот тест проверяет, что метод findKey() корректно возвращает ключ
     * первого элемента, удовлетворяющего callback-функции, или null если
     * ни один элемент не соответствует, отражая поведение функции array_find_key().
     *
     * @see CoverArray::findKey()
     * @see array_find_key()
     */
    public function testFindKeyMethod(): void
    {
        // Test finding key of an element in array of numbers
        // Тест поиска ключа элемента в массиве чисел
        $data1 = [10, 20, 30, 40, 50];
        $cover1 = new CoverArray($data1);

        $this->assertSame(2, $cover1->findKey(function ($value, $key) {
            return $value === 30;
        }));

        $this->assertNull($cover1->findKey(function ($value, $key) {
            return $value === 100;
        }));

        // Test finding key of an element in associative array
        // Тест поиска ключа элемента в ассоциативном массиве
        $data2 = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $cover2 = new CoverArray($data2);

        $this->assertSame('b', $cover2->findKey(function ($value, $key) {
            return $value === 'banana';
        }));

        $this->assertNull($cover2->findKey(function ($value, $key) {
            return $value === 'date';
        }));

        // Test finding key using key in callback
        // Тест поиска ключа с использованием ключа в callback
        $data3 = [5 => 'five', 10 => 'ten', 15 => 'fifteen'];
        $cover3 = new CoverArray($data3);

        $this->assertSame(10, $cover3->findKey(function ($value, $key) {
            return $key === 10;
        }));

        // Test with empty array
        // Тест с пустым массивом
        $data4 = [];
        $cover4 = new CoverArray($data4);

        $this->assertNull($cover4->findKey(function ($value, $key) {
            return $value === 'anything';
        }));

        // Test finding first key when multiple elements satisfy condition
        // Тест поиска первого ключа, когда несколько элементов удовлетворяют условию
        $data5 = ['x' => 1, 'y' => 2, 'z' => 3, 'w' => 4];
        $cover5 = new CoverArray($data5);

        $this->assertSame('y', $cover5->findKey(function ($value, $key) {
            return $value >= 2;
        }));

        // Test with callback that uses both value and key
        // Тест с callback, который использует и значение, и ключ
        $data6 = ['first' => 10, 'second' => 20, 'third' => 30];
        $cover6 = new CoverArray($data6);

        $this->assertSame('second', $cover6->findKey(function ($value, $key) {
            return $value > 15 && $key === 'second';
        }));

        // Test with callback that always returns false
        // Тест с callback, который всегда возвращает false
        $data7 = ['a' => 1, 'b' => 2, 'c' => 3];
        $cover7 = new CoverArray($data7);

        $this->assertNull($cover7->findKey(function ($value, $key) {
            return false;
        }));

        // Test with callback that always returns true (should return first key)
        // Тест с callback, который всегда возвращает true (должен вернуть первый ключ)
        $data8 = ['one' => 1, 'two' => 2, 'three' => 3];
        $cover8 = new CoverArray($data8);

        $this->assertSame('one', $cover8->findKey(function ($value, $key) {
            return true;
        }));

        // Test finding key with complex condition
        // Тест поиска ключа со сложным условием
        $data9 = ['item1' => 5, 'item2' => 12, 'item3' => 8, 'item4' => 15];
        $cover9 = new CoverArray($data9);

        $this->assertSame('item2', $cover9->findKey(function ($value, $key) {
            return $value % 2 === 0 && $value > 10;
        }));

        $this->assertNull($cover9->findKey(function ($value, $key) {
            return $value > 100;
        }));
    }

    /**
     * Tests the first() method (array_first equivalent).
     *
     * This test verifies that the first() method correctly returns the first
     * element of the array without affecting the internal array pointer,
     * returning null if the array is empty, mirroring the behavior of array_first().
     *
     *
     * Тестирование метода first() (эквивалент array_first).
     *
     * Этот тест проверяет, что метод first() корректно возвращает первый
     * элемент массива, не затрагивая внутренний указатель массива,
     * возвращая null, если массив пуст, отражая поведение функции array_first().
     *
     * @see CoverArray::first()
     */
    public function testFirstMethod(): void
    {
        // Test with sequential numeric array
        // Тест с последовательным числовым массивом
        $data1 = [10, 20, 30, 40];
        $cover1 = new CoverArray($data1);

        $this->assertSame(10, $cover1->first());

        // Test with associative array (preserving insertion order in PHP 7+)
        // Тест с ассоциативным массивом (сохраняется порядок вставки в PHP 7+)
        $data2 = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $cover2 = new CoverArray($data2);

        $this->assertSame('apple', $cover2->first());

        // Test with empty array
        // Тест с пустым массивом
        $data3 = [];
        $cover3 = new CoverArray($data3);

        $this->assertNull($cover3->first());

        // Test with array containing null as first element
        // Тест с массивом, содержащим null в качестве первого элемента
        $data4 = [null, 'second', 'third'];
        $cover4 = new CoverArray($data4);

        $this->assertNull($cover4->first());

        // Test with array containing false as first element
        // Тест с массивом, содержащим false в качестве первого элемента
        $data5 = [false, true, true];
        $cover5 = new CoverArray($data5);

        $this->assertFalse($cover5->first());

        // Test with array containing zero as first element
        // Тест с массивом, содержащим 0 в качестве первого элемента
        $data6 = [0, 1, 2];
        $cover6 = new CoverArray($data6);

        $this->assertSame(0, $cover6->first());

        // Test with array containing empty string as first element
        // Тест с массивом, содержащим пустую строку в качестве первого элемента
        $data7 = ['', 'not empty', 'another'];
        $cover7 = new CoverArray($data7);

        $this->assertSame('', $cover7->first());

        // Test with mixed key types array
        // Тест с массивом со смешанными типами ключей
        $data8 = [0 => 'zero', 'one' => 1, 2 => 'two'];
        $cover8 = new CoverArray($data8);

        $this->assertSame('zero', $cover8->first());

        // Test that method doesn't affect array pointer (same result on multiple calls)
        // Тест, что метод не затрагивает указатель массива (одинаковый результат при нескольких вызовах)
        $data9 = ['first', 'second', 'third'];
        $cover9 = new CoverArray($data9);

        $this->assertSame('first', $cover9->first());
        $this->assertSame('first', $cover9->first()); // Second call should return same result
        $this->assertSame('first', $cover9->first()); // Third call should return same result

        // Test with array containing array as first element
        // Тест с массивом, содержащим массив в качестве первого элемента
        $nestedArray = ['nested' => 'value'];
        $data10 = [$nestedArray, 'simple', 123];
        $cover10 = new CoverArray($data10);

        // Since CoverArray converts nested arrays to CoverArray instances
        // Так как CoverArray преобразует вложенные массивы в экземпляры CoverArray
        $firstElement = $cover10->first();
        $this->assertInstanceOf(CoverArray::class, $firstElement);
        $this->assertSame($nestedArray, $firstElement->getDataAsArray());
    }

    /**
     * Tests the flip() method (array_flip equivalent).
     *
     * This test verifies that the flip() method correctly exchanges
     * all keys with their associated values in the CoverArray,
     * mirroring PHP's array_flip() function behavior.
     *
     *
     * Тестирование метода flip() (эквивалент array_flip).
     *
     * Этот тест проверяет, что метод flip() корректно меняет местами
     * все ключи с их связанными значениями в CoverArray,
     * отражая поведение функции array_flip() PHP.
     *
     * @see CoverArray::flip()
     * @see array_flip()
     */
    public function testFlipMethod(): void
    {
        // Test with simple associative array
        // Тест с простым ассоциативным массивом
        $data1 = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];

        $expected1 = array_flip($data1);

        $cover1 = new CoverArray($data1);
        $this->assertSame(
            $expected1,
            $cover1->flip()->getDataAsArray()
        );

        // Test with numeric keys (will become values)
        // Тест с числовыми ключами (станут значениями)
        $data2 = [0 => 'zero', 1 => 'one', 2 => 'two'];

        $expected2 = array_flip($data2);

        $cover2 = new CoverArray($data2);
        $this->assertSame(
            $expected2,
            $cover2->flip()->getDataAsArray()
        );

        // Test with mixed key types
        // Тест со смешанными типами ключей
        $data3 = ['a' => 1, 'b' => 2, 'c' => 3];

        $expected3 = array_flip($data3);

        $cover3 = new CoverArray($data3);
        $this->assertSame(
            $expected3,
            $cover3->flip()->getDataAsArray()
        );

        // Test with duplicate values (only last duplicate will be kept)
        // Тест с дублирующимися значениями (сохранится только последний дубликат)
        $data4 = ['x' => 'fruit', 'y' => 'fruit', 'z' => 'vegetable'];

        $expected4 = array_flip($data4);

        $cover4 = new CoverArray($data4);
        $this->assertSame(
            $expected4,
            $cover4->flip()->getDataAsArray()
        );

        // Test with empty array
        // Тест с пустым массивом
        $data5 = [];

        $expected5 = array_flip($data5);

        $cover5 = new CoverArray($data5);
        $this->assertSame(
            $expected5,
            $cover5->flip()->getDataAsArray()
        );

        // Test with numeric string values that become integer keys
        // Тест с числовыми строковыми значениями, которые становятся целочисленными ключами
        $data6 = ['one' => '1', 'two' => '2', 'three' => '3'];

        $expected6 = array_flip($data6);

        $cover6 = new CoverArray($data6);
        $this->assertSame(
            $expected6,
            $cover6->flip()->getDataAsArray()
        );

        // Test with values that are valid string and integer types
        // Тест со значениями, которые являются допустимыми строковыми и целочисленными типами
        $data7 = ['a' => 'apple', 'b' => 2, 'c' => '3'];

        $expected7 = array_flip($data7);

        $cover7 = new CoverArray($data7);
        $this->assertSame(
            $expected7,
            $cover7->flip()->getDataAsArray()
        );
    }

    /**
     * Tests the intersect() method (array_intersect equivalent).
     *
     * This test verifies that the intersect() method correctly computes
     * the intersection of arrays based on values, returning elements
     * present in all provided arrays, mirroring PHP's array_intersect().
     *
     *
     * Тестирование метода intersect() (эквивалент array_intersect).
     *
     * Этот тест проверяет, что метод intersect() корректно вычисляет
     * пересечение массивов на основе значений, возвращая элементы,
     * присутствующие во всех предоставленных массивах, отражая array_intersect() PHP.
     *
     * @see CoverArray::intersect()
     * @see array_intersect()
     */
    public function testIntersectMethod(): void
    {
        // Test with simple arrays
        // Тест с простыми массивами
        $data1 = [1, 2, 3, 4, 5];
        $intersect1 = [2, 3, 6];
        $intersect2 = [3, 4, 7];

        $expected1 = array_intersect($data1, $intersect1, $intersect2);

        $cover1 = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->intersect($intersect1, $intersect2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->intersect(
                new CoverArray($intersect1),
                new CoverArray($intersect2)
            )->getDataAsArray()
        );

        // Test with associative arrays (compares values, not keys)
        // Тест с ассоциативными массивами (сравнивает значения, не ключи)
        $data2 = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry', 'd' => 'date'];
        $intersect3 = ['banana', 'date', 'elderberry'];

        $expected2 = array_intersect($data2, $intersect3);

        $cover2 = new CoverArray($data2);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover2->intersect($intersect3)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover2->intersect(new CoverArray($intersect3))->getDataAsArray()
        );

        // Test with multiple arrays for intersection
        // Тест с несколькими массивами для пересечения
        $data3 = ['red', 'green', 'blue', 'yellow', 'purple'];
        $intersect4 = ['green', 'yellow', 'orange'];
        $intersect5 = ['blue', 'green', 'violet'];
        $intersect6 = ['green', 'indigo'];

        $expected3 = array_intersect($data3, $intersect4, $intersect5, $intersect6);

        $cover3 = new CoverArray($data3);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover3->intersect($intersect4, $intersect5, $intersect6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover3->intersect(
                new CoverArray($intersect4),
                new CoverArray($intersect5),
                new CoverArray($intersect6)
            )->getDataAsArray()
        );

        // Test with empty intersection array
        // Тест с пустым массивом для пересечения
        $data4 = ['a', 'b', 'c'];
        $intersect7 = [];

        $expected4 = array_intersect($data4, $intersect7);

        $cover4 = new CoverArray($data4);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover4->intersect($intersect7)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover4->intersect(new CoverArray($intersect7))->getDataAsArray()
        );

        // Test with no intersection
        // Тест без пересечения
        $data5 = [1, 2, 3];
        $intersect8 = [4, 5, 6];

        $expected5 = array_intersect($data5, $intersect8);

        $cover5 = new CoverArray($data5);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover5->intersect($intersect8)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover5->intersect(new CoverArray($intersect8))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectAssoc() method (array_intersect_assoc equivalent).
     *
     * This test verifies that the intersectAssoc() method correctly computes
     * the intersection of arrays with additional index check, comparing
     * both keys and values, mirroring PHP's array_intersect_assoc() function.
     *
     *
     * Тестирование метода intersectAssoc() (эквивалент array_intersect_assoc).
     *
     * Этот тест проверяет, что метод intersectAssoc() корректно вычисляет
     * пересечение массивов с дополнительной проверкой индекса, сравнивая
     * как ключи, так и значения, отражая функцию array_intersect_assoc() PHP.
     *
     * @see CoverArray::intersectAssoc()
     * @see array_intersect_assoc()
     */
    public function testIntersectAssocMethod(): void
    {
        // Test with associative arrays (compares both keys and values)
        // Тест с ассоциативными массивами (сравнивает и ключи, и значения)
        $data1 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $intersect1 = ['b' => 2, 'c' => 30, 'e' => 5];

        $expected1 = array_intersect_assoc($data1, $intersect1);

        $cover1 = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->intersectAssoc($intersect1)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->intersectAssoc(new CoverArray($intersect1))->getDataAsArray()
        );

        // Test with multiple arrays for intersection
        // Тест с несколькими массивами для пересечения
        $data2 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $intersect2 = ['b' => 2, 'c' => 30];
        $intersect3 = ['a' => 1, 'd' => 40];

        $expected2 = array_intersect_assoc($data2, $intersect2, $intersect3);

        $cover2 = new CoverArray($data2);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover2->intersectAssoc($intersect2, $intersect3)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover2->intersectAssoc(
                new CoverArray($intersect2),
                new CoverArray($intersect3)
            )->getDataAsArray()
        );

        // Test with numeric keys (compares both key and value)
        // Тест с числовыми ключами (сравнивает и ключ, и значение)
        $data3 = [0 => 'zero', 1 => 'one', 2 => 'two'];
        $intersect4 = [0 => 'zero', 1 => 'ONE', 2 => 'two'];

        $expected3 = array_intersect_assoc($data3, $intersect4);

        $cover3 = new CoverArray($data3);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover3->intersectAssoc($intersect4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover3->intersectAssoc(new CoverArray($intersect4))->getDataAsArray()
        );

        // Test with mixed key types
        // Тест со смешанными типами ключей
        $data4 = ['a' => 'apple', 0 => 'zero', '1' => 'one'];
        $intersect5 = ['a' => 'apple', 0 => 'ZERO', '1' => 'one'];

        $expected4 = array_intersect_assoc($data4, $intersect5);

        $cover4 = new CoverArray($data4);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover4->intersectAssoc($intersect5)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover4->intersectAssoc(new CoverArray($intersect5))->getDataAsArray()
        );

        // Test with empty intersection array (should return empty array)
        // Тест с пустым массивом для пересечения (должен вернуть пустой массив)
        $data5 = ['x' => 10, 'y' => 20, 'z' => 30];
        $intersect6 = [];

        $expected5 = array_intersect_assoc($data5, $intersect6);

        $cover5 = new CoverArray($data5);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover5->intersectAssoc($intersect6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover5->intersectAssoc(new CoverArray($intersect6))->getDataAsArray()
        );

        // Test with complete match
        // Тест с полным совпадением
        $data6 = ['a' => 1, 'b' => 2];
        $intersect7 = ['a' => 1, 'b' => 2];

        $expected6 = array_intersect_assoc($data6, $intersect7);

        $cover6 = new CoverArray($data6);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected6,
            $cover6->intersectAssoc($intersect7)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected6,
            $cover6->intersectAssoc(new CoverArray($intersect7))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectKey() method (array_intersect_key equivalent).
     *
     * This test verifies that the intersectKey() method correctly computes
     * the intersection of arrays using keys for comparison, returning
     * elements with keys present in all provided arrays, mirroring array_intersect_key().
     *
     *
     * Тестирование метода intersectKey() (эквивалент array_intersect_key).
     *
     * Этот тест проверяет, что метод intersectKey() корректно вычисляет
     * пересечение массивов, используя ключи для сравнения, возвращая
     * элементы с ключами, присутствующими во всех предоставленных массивах,
     * отражая array_intersect_key().
     *
     * @see CoverArray::intersectKey()
     * @see array_intersect_key()
     */
    public function testIntersectKeyMethod(): void
    {
        // Test with associative arrays
        // Тест с ассоциативными массивами
        $data1 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $intersect1 = ['b' => 20, 'c' => 30, 'e' => 50];

        $expected1 = array_intersect_key($data1, $intersect1);

        $cover1 = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->intersectKey($intersect1)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->intersectKey(new CoverArray($intersect1))->getDataAsArray()
        );

        // Test with multiple arrays for intersection
        // Тест с несколькими массивами для пересечения
        $data2 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5];
        $intersect2 = ['a' => 10, 'c' => 30];
        $intersect3 = ['b' => 200, 'd' => 400, 'e' => 500];

        $expected2 = array_intersect_key($data2, $intersect2, $intersect3);

        $cover2 = new CoverArray($data2);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover2->intersectKey($intersect2, $intersect3)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover2->intersectKey(
                new CoverArray($intersect2),
                new CoverArray($intersect3)
            )->getDataAsArray()
        );

        // Test with numeric keys
        // Тест с числовыми ключами
        $data3 = [0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three'];
        $intersect4 = [1 => 'ONE', 3 => 'THREE', 4 => 'four'];

        $expected3 = array_intersect_key($data3, $intersect4);

        $cover3 = new CoverArray($data3);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover3->intersectKey($intersect4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover3->intersectKey(new CoverArray($intersect4))->getDataAsArray()
        );

        // Test with mixed key types
        // Тест со смешанными типами ключей
        $data4 = ['a' => 'apple', 0 => 'zero', '1' => 'one'];
        $intersect5 = ['a' => 'apricot', 0 => 'ZERO'];

        $expected4 = array_intersect_key($data4, $intersect5);

        $cover4 = new CoverArray($data4);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover4->intersectKey($intersect5)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover4->intersectKey(new CoverArray($intersect5))->getDataAsArray()
        );

        // Test with empty intersection array (should return empty array)
        // Тест с пустым массивом для пересечения (должен вернуть пустой массив)
        $data5 = ['x' => 10, 'y' => 20, 'z' => 30];
        $intersect6 = [];

        $expected5 = array_intersect_key($data5, $intersect6);

        $cover5 = new CoverArray($data5);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover5->intersectKey($intersect6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover5->intersectKey(new CoverArray($intersect6))->getDataAsArray()
        );

        // Test with no common keys
        // Тест без общих ключей
        $data6 = ['a' => 1, 'b' => 2];
        $intersect7 = ['c' => 3, 'd' => 4];

        $expected6 = array_intersect_key($data6, $intersect7);

        $cover6 = new CoverArray($data6);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected6,
            $cover6->intersectKey($intersect7)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected6,
            $cover6->intersectKey(new CoverArray($intersect7))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectUassoc() method (array_intersect_uassoc equivalent).
     *
     * This test verifies that the intersectUassoc() method correctly computes
     * the intersection of arrays with additional index check using a user-defined
     * callback function for key comparison, mirroring PHP's array_intersect_uassoc().
     *
     *
     * Тестирование метода intersectUassoc() (эквивалент array_intersect_uassoc).
     *
     * Этот тест проверяет, что метод intersectUassoc() корректно вычисляет
     * пересечение массивов с дополнительной проверкой индекса с использованием
     * пользовательской callback-функции для сравнения ключей, отражая array_intersect_uassoc() PHP.
     *
     * @see CoverArray::intersectUassoc()
     * @see array_intersect_uassoc()
     */
    public function testIntersectUassocMethod(): void
    {
        // Define a callback that works with mixed key types
        // Определяем callback, который работает со смешанными типами ключей
        $callback = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            return $a <=> $b;
        };

        // Test with string keys
        // Тест со строковыми ключами
        $data1 = ['a' => 1, 'b' => 2, 'c' => 3];
        $intersect1 = ['a' => 1, 'b' => 20];

        $expected1 = array_intersect_uassoc($data1, $intersect1, $callback);

        $cover1 = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->intersectUassoc($callback, $intersect1)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->intersectUassoc($callback, new CoverArray($intersect1))->getDataAsArray()
        );

        // Test with numeric keys
        // Тест с числовыми ключами
        $data2 = [0 => 'zero', 1 => 'one', 2 => 'two'];
        $intersect2 = [0 => 'zero', 1 => 'ONE'];

        $expected2 = array_intersect_uassoc($data2, $intersect2, $callback);

        $cover2 = new CoverArray($data2);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover2->intersectUassoc($callback, $intersect2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover2->intersectUassoc($callback, new CoverArray($intersect2))->getDataAsArray()
        );

        // Test with multiple arrays
        // Тест с несколькими массивами
        $data3 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $intersect3 = ['a' => 1, 'b' => 20];
        $intersect4 = ['c' => 30, 'd' => 4];

        $expected3 = array_intersect_uassoc($data3, $intersect3, $intersect4, $callback);

        $cover3 = new CoverArray($data3);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover3->intersectUassoc($callback, $intersect3, $intersect4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover3->intersectUassoc(
                $callback,
                new CoverArray($intersect3),
                new CoverArray($intersect4)
            )->getDataAsArray()
        );

        // Test with case-insensitive comparison callback
        // Тест с callback для сравнения без учета регистра
        $caseInsensitiveCallback = function ($a, $b) {
            return strcasecmp((string) $a, (string) $b);
        };

        $data4 = ['A' => 'apple', 'B' => 'banana', 'c' => 'cherry'];
        $intersect5 = ['a' => 'apple', 'b' => 'banana'];

        $expected4 = array_intersect_uassoc($data4, $intersect5, $caseInsensitiveCallback);

        $cover4 = new CoverArray($data4);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover4->intersectUassoc($caseInsensitiveCallback, $intersect5)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover4->intersectUassoc($caseInsensitiveCallback, new CoverArray($intersect5))->getDataAsArray()
        );

        // Test with custom key comparison logic
        // Тест с пользовательской логикой сравнения ключей
        $customCallback = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            // Compare by string length first
            // Сначала сравниваем по длине строки
            $lenA = strlen((string) $a);
            $lenB = strlen((string) $b);

            if ($lenA === $lenB) {
                return strcmp((string) $a, (string) $b);
            }
            return $lenA <=> $lenB;
        };

        $data5 = ['aa' => 1, 'b' => 2, 'ccc' => 3];
        $intersect6 = ['aa' => 10, 'ccc' => 3];

        $expected5 = array_intersect_uassoc($data5, $intersect6, $customCallback);

        $cover5 = new CoverArray($data5);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover5->intersectUassoc($customCallback, $intersect6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover5->intersectUassoc($customCallback, new CoverArray($intersect6))->getDataAsArray()
        );

        // Test with empty intersection array
        // Тест с пустым массивом для пересечения
        $data6 = ['x' => 10, 'y' => 20];
        $intersect7 = [];

        $expected6 = array_intersect_uassoc($data6, $intersect7, $callback);

        $cover6 = new CoverArray($data6);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected6,
            $cover6->intersectUassoc($callback, $intersect7)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected6,
            $cover6->intersectUassoc($callback, new CoverArray($intersect7))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectUkey() method (array_intersect_ukey equivalent).
     *
     * This test verifies that the intersectUkey() method correctly computes
     * the intersection of arrays using a user-defined callback function
     * for key comparison, mirroring PHP's array_intersect_ukey() function.
     *
     *
     * Тестирование метода intersectUkey() (эквивалент array_intersect_ukey).
     *
     * Этот тест проверяет, что метод intersectUkey() корректно вычисляет
     * пересечение массивов с использованием пользовательской callback-функции
     * для сравнения ключей, отражая функцию array_intersect_ukey() PHP.
     *
     * @see CoverArray::intersectUkey()
     * @see array_intersect_ukey()
     */
    public function testIntersectUkeyMethod(): void
    {
        // Define a callback that works with mixed key types
        // Определяем callback, который работает со смешанными типами ключей
        $callback = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            return $a <=> $b;
        };

        // Test with string keys
        // Тест со строковыми ключами
        $data1 = ['a' => 1, 'b' => 2, 'c' => 3];
        $intersect1 = ['a' => 10, 'b' => 20, 'd' => 40];

        $expected1 = array_intersect_ukey($data1, $intersect1, $callback);

        $cover1 = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->intersectUkey($callback, $intersect1)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->intersectUkey($callback, new CoverArray($intersect1))->getDataAsArray()
        );

        // Test with numeric keys
        // Тест с числовыми ключами
        $data2 = [0 => 'zero', 1 => 'one', 2 => 'two'];
        $intersect2 = [1 => 'ONE', 2 => 'TWO', 3 => 'three'];

        $expected2 = array_intersect_ukey($data2, $intersect2, $callback);

        $cover2 = new CoverArray($data2);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover2->intersectUkey($callback, $intersect2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover2->intersectUkey($callback, new CoverArray($intersect2))->getDataAsArray()
        );

        // Test with multiple arrays
        // Тест с несколькими массивами
        $data3 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $intersect3 = ['a' => 10, 'b' => 20];
        $intersect4 = ['c' => 30, 'd' => 40];

        $expected3 = array_intersect_ukey($data3, $intersect3, $intersect4, $callback);

        $cover3 = new CoverArray($data3);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover3->intersectUkey($callback, $intersect3, $intersect4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover3->intersectUkey(
                $callback,
                new CoverArray($intersect3),
                new CoverArray($intersect4)
            )->getDataAsArray()
        );

        // Test with case-insensitive comparison callback
        // Тест с callback для сравнения без учета регистра
        $caseInsensitiveCallback = function ($a, $b) {
            return strcasecmp((string) $a, (string) $b);
        };

        $data4 = ['A' => 'apple', 'B' => 'banana', 'c' => 'cherry'];
        $intersect5 = ['a' => 'apricot', 'b' => 'blueberry'];

        $expected4 = array_intersect_ukey($data4, $intersect5, $caseInsensitiveCallback);

        $cover4 = new CoverArray($data4);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover4->intersectUkey($caseInsensitiveCallback, $intersect5)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover4->intersectUkey($caseInsensitiveCallback, new CoverArray($intersect5))->getDataAsArray()
        );

        // Test with custom key comparison logic
        // Тест с пользовательской логикой сравнения ключей
        $customCallback = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            // Compare by string length first
            // Сначала сравниваем по длине строки
            $lenA = strlen((string) $a);
            $lenB = strlen((string) $b);

            if ($lenA === $lenB) {
                return strcmp((string) $a, (string) $b);
            }
            return $lenA <=> $lenB;
        };

        $data5 = ['aa' => 1, 'b' => 2, 'ccc' => 3];
        $intersect6 = ['aa' => 10, 'ccc' => 30];

        $expected5 = array_intersect_ukey($data5, $intersect6, $customCallback);

        $cover5 = new CoverArray($data5);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover5->intersectUkey($customCallback, $intersect6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover5->intersectUkey($customCallback, new CoverArray($intersect6))->getDataAsArray()
        );

        // Test with empty intersection array
        // Тест с пустым массивом для пересечения
        $data6 = ['x' => 10, 'y' => 20];
        $intersect7 = [];

        $expected6 = array_intersect_ukey($data6, $intersect7, $callback);

        $cover6 = new CoverArray($data6);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected6,
            $cover6->intersectUkey($callback, $intersect7)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected6,
            $cover6->intersectUkey($callback, new CoverArray($intersect7))->getDataAsArray()
        );

        // Test with no common keys
        // Тест без общих ключей
        $data7 = ['a' => 1, 'b' => 2];
        $intersect8 = ['c' => 3, 'd' => 4];

        $expected7 = array_intersect_ukey($data7, $intersect8, $callback);

        $cover7 = new CoverArray($data7);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected7,
            $cover7->intersectUkey($callback, $intersect8)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected7,
            $cover7->intersectUkey($callback, new CoverArray($intersect8))->getDataAsArray()
        );
    }

    /**
     * Tests the isList() method (array_is_list equivalent).
     *
     * This test verifies that the isList() method correctly determines
     * whether the CoverArray represents a list (sequential integer keys
     * starting from 0), mirroring PHP's array_is_list() function.
     *
     *
     * Тестирование метода isList() (эквивалент array_is_list).
     *
     * Этот тест проверяет, что метод isList() корректно определяет,
     * представляет ли CoverArray список (последовательные целочисленные ключи,
     * начинающиеся с 0), отражая функцию array_is_list() PHP.
     *
     * @see CoverArray::isList()
     * @see array_is_list()
     */
    public function testIsListMethod(): void
    {
        // Define test cases with expected results
        // Определяем тестовые случаи с ожидаемыми результатами
        $testCases = [
            // Пустые массивы
            ['data' => [], 'expected' => true],

            // Простые списки
            ['data' => [1, 2, 3], 'expected' => true],
            ['data' => ['a', 'b', 'c'], 'expected' => true],
            ['data' => [0 => 'a', 1 => 'b', 2 => 'c'], 'expected' => true],

            // Не списки (пропущенные ключи)
            ['data' => [0 => 'a', 2 => 'b', 3 => 'c'], 'expected' => false],
            ['data' => [1 => 'a', 2 => 'b', 3 => 'c'], 'expected' => false],
            ['data' => [0 => 'a', 1 => 'b', 3 => 'c'], 'expected' => false],

            // Не списки (неправильный порядок)
            ['data' => [2 => 'a', 1 => 'b', 0 => 'c'], 'expected' => false],
            ['data' => [0 => 'a', 2 => 'b', 1 => 'c'], 'expected' => false],

            // Строковые ключи-числа
            ['data' => ['0' => 'a', '1' => 'b', '2' => 'c'], 'expected' => true],  // Должен быть списком
            ['data' => ['1' => 'a', '2' => 'b', '3' => 'c'], 'expected' => false],  // Не список (начинается с 1)
            ['data' => ['0' => 'a', '2' => 'b', '3' => 'c'], 'expected' => false],  // Не список (пропущен 1)

            // Строковые ключи с ведущими нулями
            ['data' => ['00' => 'a', '01' => 'b', '02' => 'c'], 'expected' => false],  // Не список (ведущие нули)
            ['data' => ['000' => 'a', '001' => 'b'], 'expected' => false],  // Не список

            // Смешанные ключи
            ['data' => ['0' => 'a', 1 => 'b', '2' => 'c'], 'expected' => true],  // Должен быть списком
            ['data' => [0 => 'a', '1' => 'b', 2 => 'c'], 'expected' => true],    // Должен быть списком

            // Ассоциативные массивы
            ['data' => ['a' => 1, 'b' => 2, 'c' => 3], 'expected' => false],
            ['data' => [0 => 'a', 'foo' => 'b', 2 => 'c'], 'expected' => false],
            ['data' => ['0' => 'a', 'foo' => 'b', '2' => 'c'], 'expected' => false],

            // Массивы с одним элементом
            ['data' => [0 => 'a'], 'expected' => true],
            ['data' => [1 => 'a'], 'expected' => false],
            ['data' => ['0' => 'a'], 'expected' => true],
            ['data' => ['1' => 'a'], 'expected' => false],
            ['data' => ['foo' => 'a'], 'expected' => false],

            // Большие массивы
            ['data' => range(0, 100), 'expected' => true],
            ['data' => array_fill(0, 100, 'value'), 'expected' => true],
            ['data' => array_fill(5, 10, 'value'), 'expected' => false],  // Начинается с 5

            // Массивы с отрицательными ключами
            ['data' => [-1 => 'a', 0 => 'b', 1 => 'c'], 'expected' => false],
            ['data' => [-5 => 'a', -4 => 'b'], 'expected' => false],

            // Специальные случаи
            ['data' => [0 => 'a', '01' => 'b'], 'expected' => false],  // '01' !== 1
            ['data' => [0 => 'a', '1' => 'b', '02' => 'c'], 'expected' => false],  // '02' !== 2

            // Пустые строки как значения (не влияют на проверку)
            ['data' => [0 => '', 1 => null, 2 => false], 'expected' => true],

            // Вложенные массивы (не влияют на проверку ключей)
            ['data' => [0 => [1, 2], 1 => ['a' => 'b']], 'expected' => true],

            // Проблемные случаи с преобразованием типов
            ['data' => ['0' => 'a', 1 => 'b', '2' => 'c', '3' => 'd'], 'expected' => true],  // Должен быть списком
            ['data' => [0 => 'a', '1' => 'b', 2 => 'c', '3' => 'd'], 'expected' => true],    // Должен быть списком

            // Дополнительные тесты из оригинального теста
            ['data' => [0.0 => 'a', 1.0 => 'b', 2.0 => 'c'], 'expected' => true],
            ['data' => [' 0' => 'a', '1 ' => 'b', ' 2 ' => 'c'], 'expected' => false],
            ['data' => ['+0' => 'a', '+1' => 'b'], 'expected' => false],
            ['data' => ['0.0' => 'a', '1.0' => 'b'], 'expected' => false],
            ['data' => ['0x0' => 'a', '0x1' => 'b'], 'expected' => false],
            ['data' => ['1e0' => 'a', '1e1' => 'b'], 'expected' => false],
            ['data' => [true => 'a', false => 'b'], 'expected' => false],
            ['data' => [null => 'a', 1 => 'b'], 'expected' => false],
        ];

        foreach ($testCases as $index => $testCase) {
            $data = $testCase['data'];
            $expected = $testCase['expected'];

            $cover = new CoverArray($data);
            $result = $cover->isList();

            // If array_is_list function exists, compare with native implementation
            // Если функция array_is_list существует, сравниваем с нативной реализацией
            if (function_exists('array_is_list')) {
                $nativeResult = array_is_list($data);

                // Check that our implementation matches native implementation
                // Проверяем, что наша реализация совпадает с нативной
                $this->assertSame(
                    $nativeResult,
                    $result,
                    sprintf(
                        "Test case #%d failed: CoverArray::isList() result differs from array_is_list(). " .
                        "Data: %s, CoverArray::isList: %s, array_is_list: %s",
                        $index,
                        var_export($data, true),
                        var_export($result, true),
                        var_export($nativeResult, true)
                    )
                );

                // Also verify that our expected value matches native implementation
                // Также проверяем, что наше ожидаемое значение совпадает с нативной реализацией
                $this->assertSame(
                    $nativeResult,
                    $expected,
                    sprintf(
                        "Test case #%d: Expected value mismatch with array_is_list(). " .
                        "Data: %s, Expected: %s, array_is_list: %s",
                        $index,
                        var_export($data, true),
                        var_export($expected, true),
                        var_export($nativeResult, true)
                    )
                );
            } else {
                // If array_is_list doesn't exist, just check against our expected value
                // Если array_is_list не существует, просто проверяем по ожидаемому значению
                $this->assertSame(
                    $expected,
                    $result,
                    sprintf(
                        "Test case #%d failed: Data: %s, Expected: %s, Got: %s",
                        $index,
                        var_export($data, true),
                        var_export($expected, true),
                        var_export($result, true)
                    )
                );
            }
        }
    }

    /**
     * Tests the keyExists() method (array_key_exists equivalent).
     *
     * This test verifies that the keyExists() method correctly checks
     * whether a given key or index exists in the CoverArray,
     * mirroring PHP's array_key_exists() function behavior.
     *
     *
     * Тестирование метода keyExists() (эквивалент array_key_exists).
     *
     * Этот тест проверяет, что метод keyExists() корректно проверяет,
     * существует ли заданный ключ или индекс в CoverArray,
     * отражая поведение функции array_key_exists() PHP.
     *
     * @see CoverArray::keyExists()
     * @see array_key_exists()
     */
    public function testKeyExistsMethod(): void
    {
        // Test with associative array
        // Тест с ассоциативным массивом
        $data1 = ['name' => 'John', 'age' => 30, 'city' => 'New York'];

        $expected1 = array_key_exists('name', $data1);
        $expected2 = array_key_exists('country', $data1);

        $cover1 = new CoverArray($data1);

        $this->assertSame($expected1, $cover1->keyExists('name'));
        $this->assertSame($expected2, $cover1->keyExists('country'));

        // Test with numeric keys
        // Тест с числовыми ключами
        $data2 = [0 => 'zero', 1 => 'one', 2 => 'two'];

        $expected3 = array_key_exists(0, $data2);
        $expected4 = array_key_exists(3, $data2);

        $cover2 = new CoverArray($data2);

        $this->assertSame($expected3, $cover2->keyExists(0));
        $this->assertSame($expected4, $cover2->keyExists(3));

        // Test with mixed key types
        // Тест со смешанными типами ключей
        $data3 = ['a' => 'apple', 0 => 'zero', '1' => 'one'];

        $expected5 = array_key_exists('a', $data3);
        $expected6 = array_key_exists(0, $data3);
        $expected7 = array_key_exists('1', $data3);
        $expected8 = array_key_exists(1, $data3);

        $cover3 = new CoverArray($data3);

        $this->assertSame($expected5, $cover3->keyExists('a'));
        $this->assertSame($expected6, $cover3->keyExists(0));
        $this->assertSame($expected7, $cover3->keyExists('1'));
        $this->assertSame($expected8, $cover3->keyExists(1));

        // Test with empty array
        // Тест с пустым массивом
        $data4 = [];

        $expected9 = array_key_exists('any', $data4);

        $cover4 = new CoverArray($data4);

        $this->assertSame($expected9, $cover4->keyExists('any'));

        // Test with boolean and null keys
        // Тест с булевыми и null ключами
        $data5 = ['' => 'empty', 0 => 'zero', 1 => 'one'];

        $expected10 = array_key_exists(false, $data5);
        $expected11 = array_key_exists(true, $data5);
        $expected12 = array_key_exists(null, $data5);

        $cover5 = new CoverArray($data5);

        $this->assertSame($expected10, $cover5->keyExists(false));
        $this->assertSame($expected11, $cover5->keyExists(true));
        $this->assertSame($expected12, $cover5->keyExists(null));
    }

    /**
     * Tests the keyFirst() method (array_key_first equivalent).
     *
     * This test verifies that the keyFirst() method correctly returns
     * the first key of the CoverArray, or null for empty arrays,
     * mirroring PHP's array_key_first() function behavior.
     *
     *
     * Тестирование метода keyFirst() (эквивалент array_key_first).
     *
     * Этот тест проверяет, что метод keyFirst() корректно возвращает
     * первый ключ CoverArray, или null для пустых массивов,
     * отражая поведение функции array_key_first() PHP.
     *
     * @see CoverArray::keyFirst()
     * @see array_key_first()
     */
    public function testKeyFirstMethod(): void
    {
        // Test with associative array
        // Тест с ассоциативным массивом
        $data1 = ['country' => 'Russia', 'region' => 'Moscow region', 'city' => 'Podolsk', 'street' => 'Kirov st.'];

        $expected1 = array_key_first($data1);

        // CoverArray method
        // метод CoverArray
        $cover1 = new CoverArray($data1);
        $this->assertSame($expected1, $cover1->keyFirst());

        // Test with sequential numeric array
        // Тест с последовательным числовым массивом
        $data2 = [18, 8, 1982];

        $expected2 = array_key_first($data2);

        // CoverArray method
        // метод CoverArray
        $cover2 = new CoverArray($data2);
        $this->assertSame($expected2, $cover2->keyFirst());

        // Test with empty array
        // Тест с пустым массивом
        $data3 = [];

        $expected3 = array_key_first($data3);

        // CoverArray method
        // метод CoverArray
        $cover3 = new CoverArray($data3);
        $this->assertSame($expected3, $cover3->keyFirst());

        // Test with mixed keys array
        // Тест с массивом со смешанными ключами
        $data4 = [0 => 'zero', 'a' => 'apple', 1 => 'one', 'b' => 'banana'];

        $expected4 = array_key_first($data4);

        // CoverArray method
        // метод CoverArray
        $cover4 = new CoverArray($data4);
        $this->assertSame($expected4, $cover4->keyFirst());

        // Test with single element array
        // Тест с массивом из одного элемента
        $data5 = ['single' => 'element'];

        $expected5 = array_key_first($data5);

        // CoverArray method
        // метод CoverArray
        $cover5 = new CoverArray($data5);
        $this->assertSame($expected5, $cover5->keyFirst());
    }

    /**
     * Tests the keyLast() method (array_key_last equivalent).
     *
     * This test verifies that the keyLast() method correctly returns
     * the last key of the CoverArray, or null for empty arrays,
     * mirroring PHP's array_key_last() function behavior.
     *
     *
     * Тестирование метода keyLast() (эквивалент array_key_last).
     *
     * Этот тест проверяет, что метод keyLast() корректно возвращает
     * последний ключ CoverArray, или null для пустых массивов,
     * отражая поведение функции array_key_last() PHP.
     *
     * @see CoverArray::keyLast()
     * @see array_key_last()
     */
    public function testKeyLastMethod(): void
    {
        // Test with associative array
        // Тест с ассоциативным массивом
        $data1 = ['country' => 'Russia', 'region' => 'Moscow region', 'city' => 'Podolsk', 'street' => 'Kirov st.'];

        $expected1 = array_key_last($data1);

        // CoverArray method
        // метод CoverArray
        $cover1 = new CoverArray($data1);
        $this->assertSame($expected1, $cover1->keyLast());

        // Test with sequential numeric array
        // Тест с последовательным числовым массивом
        $data2 = [18, 8, 1982];

        $expected2 = array_key_last($data2);

        // CoverArray method
        // метод CoverArray
        $cover2 = new CoverArray($data2);
        $this->assertSame($expected2, $cover2->keyLast());

        // Test with empty array
        // Тест с пустым массивом
        $data3 = [];

        $expected3 = array_key_last($data3);

        // CoverArray method
        // метод CoverArray
        $cover3 = new CoverArray($data3);
        $this->assertSame($expected3, $cover3->keyLast());

        // Test with mixed keys array
        // Тест с массивом со смешанными ключами
        $data4 = [0 => 'zero', 'a' => 'apple', 1 => 'one', 'b' => 'banana'];

        $expected4 = array_key_last($data4);

        // CoverArray method
        // метод CoverArray
        $cover4 = new CoverArray($data4);
        $this->assertSame($expected4, $cover4->keyLast());

        // Test with single element array
        // Тест с массивом из одного элемента
        $data5 = ['single' => 'element'];

        $expected5 = array_key_last($data5);

        // CoverArray method
        // метод CoverArray
        $cover5 = new CoverArray($data5);
        $this->assertSame($expected5, $cover5->keyLast());

        // Test with numeric keys not starting from 0
        // Тест с числовыми ключами, не начинающимися с 0
        $data6 = [5 => 'five', 10 => 'ten', 15 => 'fifteen'];

        $expected6 = array_key_last($data6);

        // CoverArray method
        // метод CoverArray
        $cover6 = new CoverArray($data6);
        $this->assertSame($expected6, $cover6->keyLast());

        // Test with reordered array (should return last key in current order, not insertion order)
        // Тест с переупорядоченным массивом (должен вернуть последний ключ в текущем порядке, а не порядке вставки)
        $data7 = ['z' => 'last', 'a' => 'first', 'm' => 'middle'];

        $expected7 = array_key_last($data7);

        // CoverArray method
        // метод CoverArray
        $cover7 = new CoverArray($data7);
        $this->assertSame($expected7, $cover7->keyLast());
    }

    /**
     * Tests the keys() method (array_keys equivalent).
     *
     * This test verifies that the keys() method correctly returns
     * all or a subset of keys from the CoverArray, optionally filtered
     * by value, mirroring PHP's array_keys() function behavior.
     *
     *
     * Тестирование метода keys() (эквивалент array_keys).
     *
     * Этот тест проверяет, что метод keys() корректно возвращает
     * все или подмножество ключей из CoverArray, опционально фильтруя
     * по значению, отражая поведение функции array_keys() PHP.
     *
     * @see CoverArray::keys()
     * @see array_keys()
     */
    public function testKeysMethod(): void
    {
        // Test getting all keys from associative array
        // Тест получения всех ключей из ассоциативного массива
        $data1 = ['country' => 'Russia', 'region' => 'Moscow region', 'city' => 'Podolsk', 'street' => 'Kirov st.'];

        $expected1 = array_keys($data1);

        // CoverArray method
        // метод CoverArray
        $cover1 = new CoverArray($data1);
        $this->assertSame($expected1, $cover1->keys()->getDataAsArray());

        // Test getting all keys from nested array structure
        // Тест получения всех ключей из вложенной структуры массива
        $data2 = [
            'backend' => ['PHP', 'MySql'],
            'frontend' => ['HTML', 'CSS', 'JavaScript']
        ];

        $expected2 = array_keys($data2);

        // CoverArray method
        // метод CoverArray
        $cover2 = new CoverArray($data2);
        $this->assertSame($expected2, $cover2->keys()->getDataAsArray());

        // Test getting keys filtered by value with strict comparison
        // Тест получения ключей, отфильтрованных по значению с строгим сравнением
        $data3 = ['PHP', 'MySql'];

        $expected3 = array_keys($data3, 'PHP', true);

        // CoverArray method
        // метод CoverArray
        $cover3 = new CoverArray($data3);
        $this->assertSame($expected3, $cover3->keys('PHP', true)->getDataAsArray());

        // Test getting keys filtered by value with loose comparison
        // Тест получения ключей, отфильтрованных по значению с нестрогим сравнением
        $data4 = [0 => '0', 1 => 0, 2 => false, 3 => null, 4 => ''];

        $expected4 = array_keys($data4, '0', false);

        // CoverArray method
        // метод CoverArray
        $cover4 = new CoverArray($data4);
        $this->assertSame($expected4, $cover4->keys('0', false)->getDataAsArray());

        $expected5 = array_keys($data4, '0', true);
        $this->assertSame($expected5, $cover4->keys('0', true)->getDataAsArray());

        // Test with empty array
        // Тест с пустым массивом
        $data5 = [];

        $expected6 = array_keys($data5);
        $expected7 = array_keys($data5, 'value', true);

        // CoverArray method
        // метод CoverArray
        $cover5 = new CoverArray($data5);
        $this->assertSame($expected6, $cover5->keys()->getDataAsArray());
        $this->assertSame($expected7, $cover5->keys('value', true)->getDataAsArray());

        // Test with duplicate values
        // Тест с дублирующимися значениями
        $data6 = ['a' => 'apple', 'b' => 'banana', 'c' => 'apple', 'd' => 'cherry', 'e' => 'apple'];

        $expected8 = array_keys($data6, 'apple', true);

        // CoverArray method
        // метод CoverArray
        $cover6 = new CoverArray($data6);
        $this->assertSame($expected8, $cover6->keys('apple', true)->getDataAsArray());

        // Test with numeric keys
        // Тест с числовыми ключами
        $data7 = [10 => 'ten', 20 => 'twenty', 30 => 'thirty', 40 => 'forty'];

        $expected9 = array_keys($data7);
        $expected10 = array_keys($data7, 'thirty', true);

        // CoverArray method
        // метод CoverArray
        $cover7 = new CoverArray($data7);
        $this->assertSame($expected9, $cover7->keys()->getDataAsArray());
        $this->assertSame($expected10, $cover7->keys('thirty', true)->getDataAsArray());

        // Test with mixed key types
        // Тест со смешанными типами ключей
        $data8 = ['a' => 1, 0 => 2, 'c' => 1, 1 => 2];

        $expected11 = array_keys($data8, 1, true);
        $expected12 = array_keys($data8, 2, true);

        // CoverArray method
        // метод CoverArray
        $cover8 = new CoverArray($data8);
        $this->assertSame($expected11, $cover8->keys(1, true)->getDataAsArray());
        $this->assertSame($expected12, $cover8->keys(2, true)->getDataAsArray());
    }

    /**
     * Tests the last() method (array_last equivalent).
     *
     * This test verifies that the last() method correctly returns
     * the last element of the CoverArray, or null for empty arrays,
     * providing convenient access to the final element.
     *
     *
     * Тестирование метода last() (эквивалент array_last).
     *
     * Этот тест проверяет, что метод last() корректно возвращает
     * последний элемент CoverArray, или null для пустых массивов,
     * предоставляя удобный доступ к конечному элементу.
     *
     * @see CoverArray::last()
     */
    public function testLastMethod(): void
    {
        // Test with sequential numeric array
        // Тест с последовательным числовым массивом
        $data1 = ['PHP', 'MySql'];

        // CoverArray method
        // метод CoverArray
        $cover1 = new CoverArray($data1);
        $this->assertSame('MySql', $cover1->last());

        // Test with associative array
        // Тест с ассоциативным массивом
        $data2 = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];

        // CoverArray method
        // метод CoverArray
        $cover2 = new CoverArray($data2);
        $this->assertSame('cherry', $cover2->last());

        // Test with empty array
        // Тест с пустым массивом
        $data3 = [];

        // CoverArray method
        // метод CoverArray
        $cover3 = new CoverArray($data3);
        $this->assertNull($cover3->last());

        // Test with single element array
        // Тест с массивом из одного элемента
        $data4 = ['single' => 'element'];

        // CoverArray method
        // метод CoverArray
        $cover4 = new CoverArray($data4);
        $this->assertSame('element', $cover4->last());

        // Test with mixed key types
        // Тест со смешанными типами ключей
        $data5 = [0 => 'zero', 'a' => 'apple', 1 => 'one'];

        // CoverArray method
        // метод CoverArray
        $cover5 = new CoverArray($data5);
        $this->assertSame('one', $cover5->last());

        // Test with numeric keys not starting from 0
        // Тест с числовыми ключами, не начинающимися с 0
        $data6 = [5 => 'five', 10 => 'ten', 15 => 'fifteen'];

        // CoverArray method
        // метод CoverArray
        $cover6 = new CoverArray($data6);
        $this->assertSame('fifteen', $cover6->last());

        // Test with null value as last element
        // Тест с null значением в качестве последнего элемента
        $data7 = ['a' => 1, 'b' => null];

        // CoverArray method
        // метод CoverArray
        $cover7 = new CoverArray($data7);
        $this->assertNull($cover7->last());

        // Test with false value as last element
        // Тест со значением false в качестве последнего элемента
        $data8 = ['a' => true, 'b' => false];

        // CoverArray method
        // метод CoverArray
        $cover8 = new CoverArray($data8);
        $this->assertFalse($cover8->last());

        // Test with zero value as last element
        // Тест с нулевым значением в качестве последнего элемента
        $data9 = ['a' => 1, 'b' => 0];

        // CoverArray method
        // метод CoverArray
        $cover9 = new CoverArray($data9);
        $this->assertSame(0, $cover9->last());

        // Test with empty string as last element
        // Тест с пустой строкой в качестве последнего элемента
        $data10 = ['a' => 'not empty', 'b' => ''];

        // CoverArray method
        // метод CoverArray
        $cover10 = new CoverArray($data10);
        $this->assertSame('', $cover10->last());

        // Test that method doesn't affect array pointer (same result on multiple calls)
        // Тест, что метод не затрагивает указатель массива (одинаковый результат при нескольких вызовах)
        $data11 = ['first', 'second', 'third'];
        $cover11 = new CoverArray($data11);

        $this->assertSame('third', $cover11->last());
        $this->assertSame('third', $cover11->last()); // Second call should return same result
        $this->assertSame('third', $cover11->last()); // Third call should return same result
    }

    /**
     * Tests the map() method (array_map equivalent).
     *
     * This test verifies that the map() method correctly applies
     * a callback function to the elements of the CoverArray,
     * optionally with additional arrays, mirroring PHP's array_map() function.
     *
     *
     * Тестирование метода map() (эквивалент array_map).
     *
     * Этот тест проверяет, что метод map() корректно применяет
     * callback-функцию к элементам CoverArray,
     * опционально с дополнительными массивами, отражая функцию array_map() PHP.
     *
     * @see CoverArray::map()
     * @see array_map()
     */
    public function testMapMethod(): void
    {
        // Test with single array (preserves keys)
        // Тест с одним массивом (сохраняет ключи)
        $data1 = ['country' => 'Russia', 'region' => 'Moscow region', 'city' => 'Podolsk', 'street' => 'Kirov st.'];

        $expected1 = [
            'country' => '--Russia',
            'region' => '--Moscow region',
            'city' => '--Podolsk',
            'street' => '--Kirov st.'
        ];

        $cover1 = new CoverArray($data1);

        // original function
        // оригинальная функция
        $this->assertSame(
            $expected1,
            array_map(
                fn(mixed $value): string => "--$value",
                $data1
            )
        );

        // CoverArray method
        // метод CoverArray
        $this->assertSame(
            $expected1,
            $cover1->map(
                fn(mixed $value): string => "--$value"
            )->getDataAsArray()
        );

        // Test with multiple arrays (returns sequential integer keys)
        // Тест с несколькими массивами (возвращает последовательные целочисленные ключи)
        $data2 = ['Russia', 'Moscow region', 'Podolsk', 'Kirov st.'];
        $keys2 = ['country', 'region', 'city', 'street'];

        $expected2 = [
            0 => 'country: Russia',
            1 => 'region: Moscow region',
            2 => 'city: Podolsk',
            3 => 'street: Kirov st.'
        ];

        $cover2 = new CoverArray($data2);
        $coverKeys2 = new CoverArray($keys2);

        // original function
        // оригинальная функция
        $this->assertSame(
            $expected2,
            array_map(
                fn(mixed $value, mixed $key): string => "$key: $value",
                $data2,
                $keys2
            )
        );

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover2->map(
                fn(mixed $value, mixed $key): string => "$key: $value",
                $keys2
            )->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover2->map(
                fn(mixed $value, mixed $key): string => "$key: $value",
                $coverKeys2
            )->getDataAsArray()
        );

        // Test with null callback (identity function)
        // Тест с null callback (функция идентичности)
        $data3 = [1, 2, 3, 4];

        $expected3 = array_map(null, $data3);

        $cover3 = new CoverArray($data3);

        // original function
        // оригинальная функция
        $this->assertSame($expected3, array_map(null, $data3));

        // CoverArray method
        // метод CoverArray
        $this->assertSame($expected3, $cover3->map(null)->getDataAsArray());

        // Test with three arrays
        // Тест с тремя массивами
        $data4 = [1, 2, 3];
        $data5 = [4, 5, 6];
        $data6 = [7, 8, 9];

        $expected4 = array_map(
            fn($a, $b, $c) => $a + $b + $c,
            $data4,
            $data5,
            $data6
        );

        $cover4 = new CoverArray($data4);
        $cover5 = new CoverArray($data5);
        $cover6 = new CoverArray($data6);

        // original function
        // оригинальная функция
        $this->assertSame(
            $expected4,
            array_map(
                fn($a, $b, $c) => $a + $b + $c,
                $data4,
                $data5,
                $data6
            )
        );

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover4->map(
                fn($a, $b, $c) => $a + $b + $c,
                $data5,
                $data6
            )->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover4->map(
                fn($a, $b, $c) => $a + $b + $c,
                $cover5,
                $cover6
            )->getDataAsArray()
        );

        // Test with arrays of different lengths (should use the shortest)
        // Тест с массивами разной длины (должен использовать самый короткий)
        $data7 = [1, 2, 3, 4];
        $data8 = [10, 20];

        $expected5 = array_map(
            fn($a, $b) => $a * $b,
            $data7,
            $data8
        );

        $cover7 = new CoverArray($data7);
        $cover8 = new CoverArray($data8);

        // original function
        // оригинальная функция
        $this->assertSame(
            $expected5,
            array_map(
                fn($a, $b) => $a * $b,
                $data7,
                $data8
            )
        );

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover7->map(
                fn($a, $b) => $a * $b,
                $data8
            )->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover7->map(
                fn($a, $b) => $a * $b,
                $cover8
            )->getDataAsArray()
        );

        // Test with empty array
        // Тест с пустым массивом
        $data9 = [];

        $expected6 = array_map(fn($v) => $v * 2, $data9);

        $cover9 = new CoverArray($data9);

        // original function
        // оригинальная функция
        $this->assertSame($expected6, array_map(fn($v) => $v * 2, $data9));

        // CoverArray method
        // метод CoverArray
        $this->assertSame($expected6, $cover9->map(fn($v) => $v * 2)->getDataAsArray());
    }

    /**
     * Tests the merge() method (array_merge equivalent).
     *
     * This test verifies that the merge() method correctly merges
     * one or more arrays into the CoverArray, preserving numeric
     * keys and overwriting string keys, mirroring PHP's array_merge().
     *
     *
     * Тестирование метода merge() (эквивалент array_merge).
     *
     * Этот тест проверяет, что метод merge() корректно объединяет
     * один или несколько массивов в CoverArray, сохраняя числовые
     * ключи и перезаписывая строковые ключи, отражая array_merge() PHP.
     *
     * @see CoverArray::merge()
     * @see array_merge()
     */
    public function testMergeMethod(): void
    {
        // Test merging numeric arrays (keys are reindexed)
        // Тест объединения числовых массивов (ключи переиндексируются)
        $data1 = ['PHP', 'MySql'];
        $merge1 = ['HTML', 'CSS', 'JavaScript'];

        $expected1 = array_merge($data1, $merge1);

        $cover1 = new CoverArray($data1);
        $coverMerge1 = new CoverArray($merge1);

        // original function
        // оригинальная функция
        $this->assertSame($expected1, array_merge($data1, $merge1));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->merge($merge1)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->merge($coverMerge1)->getDataAsArray()
        );

        // Test merging associative arrays (string keys are overwritten)
        // Тест объединения ассоциативных массивов (строковые ключи перезаписываются)
        $data2 = ['a' => 'apple', 'b' => 'banana'];
        $merge2 = ['b' => 'blueberry', 'c' => 'cherry'];

        $expected2 = array_merge($data2, $merge2);

        $cover2 = new CoverArray($data2);
        $coverMerge2 = new CoverArray($merge2);

        // original function
        // оригинальная функция
        $this->assertSame($expected2, array_merge($data2, $merge2));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover2->merge($merge2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover2->merge($coverMerge2)->getDataAsArray()
        );

        // Test merging multiple arrays
        // Тест объединения нескольких массивов
        $data3 = ['x' => 1, 'y' => 2];
        $merge3a = ['y' => 20, 'z' => 3];
        $merge3b = ['z' => 30, 'w' => 4];

        $expected3 = array_merge($data3, $merge3a, $merge3b);

        $cover3 = new CoverArray($data3);
        $coverMerge3a = new CoverArray($merge3a);
        $coverMerge3b = new CoverArray($merge3b);

        // original function
        // оригинальная функция
        $this->assertSame($expected3, array_merge($data3, $merge3a, $merge3b));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover3->merge($merge3a, $merge3b)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover3->merge($coverMerge3a, $coverMerge3b)->getDataAsArray()
        );

        // Test merging with mixed numeric and string keys
        // Тест объединения со смешанными числовыми и строковыми ключами
        $data4 = [0 => 'zero', 'a' => 'apple', 1 => 'one'];
        $merge4 = [1 => 'ONE', 'b' => 'banana', 2 => 'two'];

        $expected4 = array_merge($data4, $merge4);

        $cover4 = new CoverArray($data4);
        $coverMerge4 = new CoverArray($merge4);

        // original function
        // оригинальная функция
        $this->assertSame($expected4, array_merge($data4, $merge4));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover4->merge($merge4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover4->merge($coverMerge4)->getDataAsArray()
        );

        // Test merging empty arrays
        // Тест объединения пустых массивов
        $data5 = ['a' => 1, 'b' => 2];
        $merge5 = [];

        $expected5 = array_merge($data5, $merge5);

        $cover5 = new CoverArray($data5);
        $coverMerge5 = new CoverArray($merge5);

        // original function
        // оригинальная функция
        $this->assertSame($expected5, array_merge($data5, $merge5));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover5->merge($merge5)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover5->merge($coverMerge5)->getDataAsArray()
        );

        // Test merging all empty arrays
        // Тест объединения всех пустых массивов
        $data6 = [];
        $merge6 = [];

        $expected6 = array_merge($data6, $merge6);

        $cover6 = new CoverArray($data6);
        $coverMerge6 = new CoverArray($merge6);

        // original function
        // оригинальная функция
        $this->assertSame($expected6, array_merge($data6, $merge6));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected6,
            $cover6->merge($merge6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected6,
            $cover6->merge($coverMerge6)->getDataAsArray()
        );

        // Test merging with integer keys that are reindexed
        // Тест объединения с целочисленными ключами, которые переиндексируются
        $data7 = [10 => 'ten', 20 => 'twenty'];
        $merge7 = [30 => 'thirty', 40 => 'forty'];

        $expected7 = array_merge($data7, $merge7);

        $cover7 = new CoverArray($data7);
        $coverMerge7 = new CoverArray($merge7);

        // original function
        // оригинальная функция
        $this->assertSame($expected7, array_merge($data7, $merge7));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected7,
            $cover7->merge($merge7)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected7,
            $cover7->merge($coverMerge7)->getDataAsArray()
        );
    }

    /**
     * Tests the mergeRecursive() method (array_merge_recursive equivalent).
     *
     * This test verifies that the mergeRecursive() method correctly merges
     * one or more arrays recursively, with values for identical string keys
     * merged into arrays, mirroring PHP's array_merge_recursive() function.
     *
     *
     * Тестирование метода mergeRecursive() (эквивалент array_merge_recursive).
     *
     * Этот тест проверяет, что метод mergeRecursive() корректно объединяет
     * один или несколько массивов рекурсивно, со значениями для одинаковых
     * строковых ключей, объединенными в массивы, отражая array_merge_recursive() PHP.
     *
     * @see CoverArray::mergeRecursive()
     * @see array_merge_recursive()
     */
    public function testMergeRecursiveMethod(): void
    {
        // Test merging arrays with nested associative keys
        // Тест объединения массивов с вложенными ассоциативными ключами
        $data1 = ['color' => ['favorite' => 'red'], 5];
        $data2 = [10, 'color' => ['favorite' => 'green', 'blue']];

        $expected1 = [
            'color' => [
                'favorite' => [
                    0 => 'red',
                    1 => 'green',
                ],
                0 => 'blue',
            ],
            0 => 5,
            1 => 10,
        ];

        $cover1 = new CoverArray($data1);
        $cover2 = new CoverArray($data2);

        // original function
        // оригинальная функция
        $this->assertSame($expected1, array_merge_recursive($data1, $data2));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->mergeRecursive($data2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->mergeRecursive($cover2)->getDataAsArray()
        );

        // Test merging with multiple identical string keys at different levels
        // Тест объединения с несколькими одинаковыми строковыми ключами на разных уровнях
        $data3 = [
            'user' => [
                'name' => 'John',
                'contacts' => ['email' => 'john@example.com']
            ],
            'settings' => ['theme' => 'dark']
        ];

        $data4 = [
            'user' => [
                'age' => 30,
                'contacts' => ['phone' => '123-456-7890']
            ],
            'settings' => ['language' => 'en']
        ];

        $expected2 = array_merge_recursive($data3, $data4);

        $cover3 = new CoverArray($data3);
        $cover4 = new CoverArray($data4);

        // original function
        // оригинальная функция
        $this->assertSame($expected2, array_merge_recursive($data3, $data4));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover3->mergeRecursive($data4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover3->mergeRecursive($cover4)->getDataAsArray()
        );

        // Test merging numeric keys (they get reindexed, not merged)
        // Тест объединения числовых ключей (они переиндексируются, а не объединяются)
        $data5 = [0 => ['a', 'b'], 1 => ['c', 'd']];
        $data6 = [0 => ['e', 'f'], 1 => ['g', 'h']];

        $expected3 = array_merge_recursive($data5, $data6);

        $cover5 = new CoverArray($data5);
        $cover6 = new CoverArray($data6);

        // original function
        // оригинальная функция
        $this->assertSame($expected3, array_merge_recursive($data5, $data6));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover5->mergeRecursive($data6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover5->mergeRecursive($cover6)->getDataAsArray()
        );

        // Test merging three arrays recursively
        // Тест объединения трех массивов рекурсивно
        $data7 = ['a' => ['x' => 1]];
        $data8 = ['a' => ['y' => 2]];
        $data9 = ['a' => ['z' => 3]];

        $expected4 = array_merge_recursive($data7, $data8, $data9);

        $cover7 = new CoverArray($data7);
        $cover8 = new CoverArray($data8);
        $cover9 = new CoverArray($data9);

        // original function
        // оригинальная функция
        $this->assertSame($expected4, array_merge_recursive($data7, $data8, $data9));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover7->mergeRecursive($data8, $data9)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover7->mergeRecursive($cover8, $cover9)->getDataAsArray()
        );

        // Test merging with empty arrays
        // Тест объединения с пустыми массивами
        $data10 = ['key' => 'value', 'nested' => ['a' => 1]];
        $data11 = [];

        $expected5 = array_merge_recursive($data10, $data11);

        $cover10 = new CoverArray($data10);
        $cover11 = new CoverArray($data11);

        // original function
        // оригинальная функция
        $this->assertSame($expected5, array_merge_recursive($data10, $data11));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover10->mergeRecursive($data11)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover10->mergeRecursive($cover11)->getDataAsArray()
        );

        // Test merging arrays with scalar values for same string key (creates array)
        // Тест объединения массивов со скалярными значениями для одного и того же строкового ключа (создает массив)
        $data12 = ['fruit' => 'apple'];
        $data13 = ['fruit' => 'banana'];

        $expected6 = array_merge_recursive($data12, $data13);

        $cover12 = new CoverArray($data12);
        $cover13 = new CoverArray($data13);

        // original function
        // оригинальная функция
        $this->assertSame($expected6, array_merge_recursive($data12, $data13));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected6,
            $cover12->mergeRecursive($data13)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected6,
            $cover12->mergeRecursive($cover13)->getDataAsArray()
        );

        // Test merging arrays with mixed numeric and string keys
        // Тест объединения массивов со смешанными числовыми и строковыми ключами
        $data14 = [0 => 'zero', 'a' => ['x' => 1]];
        $data15 = [0 => 'ZERO', 'a' => ['y' => 2], 'b' => 'new'];

        $expected7 = array_merge_recursive($data14, $data15);

        $cover14 = new CoverArray($data14);
        $cover15 = new CoverArray($data15);

        // original function
        // оригинальная функция
        $this->assertSame($expected7, array_merge_recursive($data14, $data15));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected7,
            $cover14->mergeRecursive($data15)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected7,
            $cover14->mergeRecursive($cover15)->getDataAsArray()
        );
    }

    /**
     * Tests the pad() method (array_pad equivalent).
     *
     * This test verifies that the pad() method correctly pads
     * the CoverArray to the specified length with a given value,
     * mirroring PHP's array_pad() function behavior.
     *
     *
     * Тестирование метода pad() (эквивалент array_pad).
     *
     * Этот тест проверяет, что метод pad() корректно дополняет
     * CoverArray до указанной длины заданным значением,
     * отражая поведение функции array_pad() PHP.
     *
     * @see CoverArray::pad()
     * @see array_pad()
     */
    public function testPadMethod(): void
    {
        // Test padding to the right (positive length)
        // Тест дополнения справа (положительная длина)
        $data1 = [1, 2, 3];
        $expected1 = array_pad($data1, 5, 0);

        $cover1 = new CoverArray($data1);

        $this->assertSame($expected1, $cover1->pad(5, 0)->getDataAsArray());

        // Test padding to the left (negative length)
        // Тест дополнения слева (отрицательная длина)
        $data2 = [1, 2, 3];
        $expected2 = array_pad($data2, -5, 0);

        $cover2 = new CoverArray($data2);

        $this->assertSame($expected2, $cover2->pad(-5, 0)->getDataAsArray());

        // Test with length smaller than array size (no padding)
        // Тест с длиной меньше размера массива (без дополнения)
        $data3 = [1, 2, 3, 4, 5];
        $expected3 = array_pad($data3, 3, 0);

        $cover3 = new CoverArray($data3);

        $this->assertSame($expected3, $cover3->pad(3, 0)->getDataAsArray());

        // Test with negative length smaller than array size (no padding)
        // Тест с отрицательной длиной меньше размера массива (без дополнения)
        $data4 = [1, 2, 3, 4, 5];
        $expected4 = array_pad($data4, -3, 0);

        $cover4 = new CoverArray($data4);

        $this->assertSame($expected4, $cover4->pad(-3, 0)->getDataAsArray());

        // Test with string values
        // Тест со строковыми значениями
        $data5 = ['a', 'b', 'c'];
        $expected5 = array_pad($data5, 5, 'default');

        $cover5 = new CoverArray($data5);

        $this->assertSame($expected5, $cover5->pad(5, 'default')->getDataAsArray());

        // Test with array as padding value
        // Тест с массивом в качестве значения для дополнения
        $data6 = [1, 2];
        $padValue = ['nested' => 'value'];
        $expected6 = array_pad($data6, 4, $padValue);

        $cover6 = new CoverArray($data6);

        $this->assertSame($expected6, $cover6->pad(4, $padValue)->getDataAsArray());

        // Test with null as padding value
        // Тест с null в качестве значения для дополнения
        $data7 = ['a', 'b'];
        $expected7 = array_pad($data7, 4, null);

        $cover7 = new CoverArray($data7);

        $this->assertSame($expected7, $cover7->pad(4, null)->getDataAsArray());

        // Test with empty array
        // Тест с пустым массивом
        $data8 = [];
        $expected8 = array_pad($data8, 3, 'fill');

        $cover8 = new CoverArray($data8);

        $this->assertSame($expected8, $cover8->pad(3, 'fill')->getDataAsArray());

        // Test with length 0
        // Тест с длиной 0
        $data9 = [1, 2, 3];
        $expected9 = array_pad($data9, 0, 0);

        $cover9 = new CoverArray($data9);

        $this->assertSame($expected9, $cover9->pad(0, 0)->getDataAsArray());

        // Test with associative array (keys are reindexed)
        // Тест с ассоциативным массивом (ключи переиндексируются)
        $data10 = ['a' => 1, 'b' => 2];
        $expected10 = array_pad($data10, 4, 0);

        $cover10 = new CoverArray($data10);

        $this->assertSame($expected10, $cover10->pad(4, 0)->getDataAsArray());

        // Test with mixed padding (left and right with same value)
        // Тест со смешанным дополнением (слева и справа одинаковым значением)
        $data11 = [1, 2, 3];
        $expected11 = array_pad($data11, 7, 'x');

        $cover11 = new CoverArray($data11);

        $this->assertSame($expected11, $cover11->pad(7, 'x')->getDataAsArray());
    }

    /**
     * Tests the pop() method (array_pop equivalent).
     *
     * This test verifies that the pop() method correctly removes
     * and returns the last element of the CoverArray, shortening
     * the array by one element, mirroring PHP's array_pop() function.
     *
     *
     * Тестирование метода pop() (эквивалент array_pop).
     *
     * Этот тест проверяет, что метод pop() корректно удаляет
     * и возвращает последний элемент CoverArray, уменьшая
     * массив на один элемент, отражая поведение функции array_pop() PHP.
     *
     * @see CoverArray::pop()
     * @see array_pop()
     */
    public function testPopMethod(): void
    {
        // Test popping from a sequential array
        // Тест извлечения из последовательного массива
        $data1 = [1, 2, 3];
        $expectedArray1 = $data1;
        $expectedValue1 = array_pop($expectedArray1);

        $cover1 = new CoverArray($data1);
        $actualValue1 = $cover1->pop();

        $this->assertSame($expectedValue1, $actualValue1);
        $this->assertSame($expectedArray1, $cover1->getDataAsArray());

        // Test popping from an associative array
        // Тест извлечения из ассоциативного массива
        $data2 = ['a' => 1, 'b' => 2, 'c' => 3];
        $expectedArray2 = $data2;
        $expectedValue2 = array_pop($expectedArray2);

        $cover2 = new CoverArray($data2);
        $actualValue2 = $cover2->pop();

        $this->assertSame($expectedValue2, $actualValue2);
        $this->assertSame($expectedArray2, $cover2->getDataAsArray());

        // Test popping from an empty array (should return null)
        // Тест извлечения из пустого массива (должен вернуть null)
        $data3 = [];
        $expectedArray3 = $data3;
        $expectedValue3 = array_pop($expectedArray3);

        $cover3 = new CoverArray($data3);
        $actualValue3 = $cover3->pop();

        $this->assertSame($expectedValue3, $actualValue3);
        $this->assertSame($expectedArray3, $cover3->getDataAsArray());

        // Test popping from an array with one element
        // Тест извлечения из массива с одним элементом
        $data4 = ['single'];
        $expectedArray4 = $data4;
        $expectedValue4 = array_pop($expectedArray4);

        $cover4 = new CoverArray($data4);
        $actualValue4 = $cover4->pop();

        // original function
        // оригинальная функция
        $this->assertSame($expectedValue4, $actualValue4);
        $this->assertSame($expectedArray4, $cover4->getDataAsArray());

        // Test popping with mixed value types
        // Тест извлечения со смешанными типами значений
        $data5 = ['string', 123, null, false];
        $expectedArray5 = $data5;
        $expectedValue5 = array_pop($expectedArray5);

        $cover5 = new CoverArray($data5);
        $actualValue5 = $cover5->pop();

        $this->assertSame($expectedValue5, $actualValue5);
        $this->assertSame($expectedArray5, $cover5->getDataAsArray());

        // Test popping array value (CoverArray should convert it to CoverArray)
        // Тест извлечения значения-массива (CoverArray должен преобразовать его в CoverArray)
        $data6 = [1, 2, ['nested' => 'value']];
        $expectedArray6 = $data6;
        $expectedValue6 = array_pop($expectedArray6);

        $cover6 = new CoverArray($data6);
        $actualValue6 = $cover6->pop();

        // Проверяем, что возвращенный объект является CoverArray и содержит правильные данные
        $this->assertInstanceOf(CoverArray::class, $actualValue6);
        $this->assertSame($expectedValue6, $actualValue6->getDataAsArray());
        $this->assertSame($expectedArray6, $cover6->getDataAsArray());

        // Test that pop() modifies the original array
        // Тест, что pop() изменяет исходный массив
        $data7 = [10, 20, 30, 40];
        $cover7 = new CoverArray($data7);

        // Первый pop
        $firstPop = $cover7->pop();
        $this->assertSame(40, $firstPop);
        $this->assertSame([10, 20, 30], $cover7->getDataAsArray());

        // Второй pop
        $secondPop = $cover7->pop();
        $this->assertSame(30, $secondPop);
        $this->assertSame([10, 20], $cover7->getDataAsArray());

        // Третий pop
        $thirdPop = $cover7->pop();
        $this->assertSame(20, $thirdPop);
        $this->assertSame([10], $cover7->getDataAsArray());

        // Четвертый pop
        $fourthPop = $cover7->pop();
        $this->assertSame(10, $fourthPop);
        $this->assertSame([], $cover7->getDataAsArray());

        // Пятый pop (из пустого массива)
        $fifthPop = $cover7->pop();
        $this->assertNull($fifthPop);
        $this->assertSame([], $cover7->getDataAsArray());

        // Test popping from array with numeric string keys
        // Тест извлечения из массива с числовыми строковыми ключами
        $data8 = ['0' => 'a', '1' => 'b', '2' => 'c'];
        $expectedArray8 = $data8;
        $expectedValue8 = array_pop($expectedArray8);

        $cover8 = new CoverArray($data8);
        $actualValue8 = $cover8->pop();

        $this->assertSame($expectedValue8, $actualValue8);
        $this->assertSame($expectedArray8, $cover8->getDataAsArray());
    }

    /**
     * Tests the product() method (array_product equivalent).
     *
     * This test verifies that the product() method correctly calculates
     * the product of array values, mirroring PHP's array_product() function.
     * It tests various scenarios including integers, floats, strings,
     * booleans, null values, and edge cases like empty arrays and zero values.
     *
     *
     * Тестирование метода product() (эквивалент array_product).
     *
     * Этот тест проверяет, что метод product() корректно вычисляет
     * произведение значений массива, отражая поведение функции array_product() PHP.
     * Он тестирует различные сценарии, включая целые числа, числа с плавающей точкой,
     * строки, булевы значения, null и граничные случаи, такие как пустые массивы и нулевые значения.
     *
     * @see CoverArray::product()
     * @see array_product()
     */
    public function testProductMethod(): void
    {
        // Test with integers - product of integers
        $data1 = [2, 3, 4];
        $expected1 = array_product($data1);
        $cover1 = new CoverArray($data1);
        $this->assertSame($expected1, $cover1->product());

        // Test with floats - product of floating point numbers
        $data2 = [1.5, 2.5, 2.0];
        $expected2 = array_product($data2);
        $cover2 = new CoverArray($data2);
        $this->assertSame($expected2, $cover2->product());

        // Test with empty array (should return 1, not 0!)
        $data3 = [];
        $expected3 = array_product($data3);
        $cover3 = new CoverArray($data3);
        $this->assertSame($expected3, $cover3->product());

        // Test with single element
        $data4 = [5];
        $expected4 = array_product($data4);
        $cover4 = new CoverArray($data4);
        $this->assertSame($expected4, $cover4->product());

        // Test with negative numbers
        $data5 = [-2, 3, -4];
        $expected5 = array_product($data5);
        $cover5 = new CoverArray($data5);
        $this->assertSame($expected5, $cover5->product());

        // Test with zero value
        $data6 = [2, 3, 0, 5];
        $expected6 = array_product($data6);
        $cover6 = new CoverArray($data6);
        $this->assertSame($expected6, $cover6->product());

        // Test with string numbers (should be converted automatically)
        $data7 = ['2', '3', '4'];
        $expected7 = array_product($data7);
        $cover7 = new CoverArray($data7);
        $this->assertSame($expected7, $cover7->product());

        // Test with mixed numeric strings and numbers
        $data8 = ['2.5', 3, 4];
        $expected8 = array_product($data8);
        $cover8 = new CoverArray($data8);
        $this->assertSame($expected8, $cover8->product());

        // Test with non-numeric strings - returns 0 in PHP >= 8.3, with E_WARNING suppressed
        // Тест с нечисловыми строками - возвращает 0 в PHP >= 8.3, с подавленным E_WARNING
        $data9 = [2, 3, 'abc', 4];
        $expected9 = @array_product($data9); // 0
        $cover9 = new CoverArray($data9);
        $this->assertSame($expected9, $cover9->product());

        // Test with boolean values
        $data10 = [2, true, 3, false, 4];
        $expected10 = array_product($data10);
        $cover10 = new CoverArray($data10);
        $this->assertSame($expected10, $cover10->product());

        // Test with null values
        $data11 = [2, 3, null, 4];
        $expected11 = array_product($data11);
        $cover11 = new CoverArray($data11);
        $this->assertSame($expected11, $cover11->product());

        // Test with large numbers
        $data12 = [1000, 1000, 1000];
        $expected12 = array_product($data12);
        $cover12 = new CoverArray($data12);
        $this->assertSame($expected12, $cover12->product());

        // Test with associative array
        $data13 = ['a' => 2, 'b' => 3, 'c' => 4];
        $expected13 = array_product($data13);
        $cover13 = new CoverArray($data13);
        $this->assertSame($expected13, $cover13->product());

        // Test with numeric string with leading zeros
        $data14 = ['02', '03'];
        $expected14 = array_product($data14);
        $cover14 = new CoverArray($data14);
        $this->assertSame($expected14, $cover14->product());

        // Test with very small float numbers
        $data15 = [0.1, 0.2, 0.3];
        $expected15 = array_product($data15);
        $cover15 = new CoverArray($data15);
        $this->assertSame($expected15, $cover15->product());

        // Test that original array is not modified
        $data16 = [2, 3, 4];
        $expected16 = array_product($data16);
        $cover16 = new CoverArray($data16);
        $result = $cover16->product();
        $this->assertSame($expected16, $result);
        $this->assertSame([2, 3, 4], $cover16->getDataAsArray(), 'Original array should not be modified');
    }

    /**
     * Tests edge cases for the product() method (array_product equivalent).
     *
     * This test verifies edge cases for the product() method, including
     * boolean conversions, null values, and scientific notation strings.
     *
     *
     * Тестирование граничных случаев метода product() (эквивалент array_product).
     *
     * Этот тест проверяет граничные случаи метода product(), включая
     * преобразования булевых значений, null значений и строк в научной нотации.
     *
     * @see CoverArray::product()
     * @see array_product()
     */
    public function testProductMethodEdgeCases(): void
    {
        // Test: Product with all null values - all nulls become 0
        // Тест: Произведение всех null значений - все null становятся 0
        $this->assertSame(0, (new CoverArray([null, null, null]))->product());

        // Test: Product with all false values - all false become 0
        // Тест: Произведение всех false значений - все false становятся 0
        $this->assertSame(0, (new CoverArray([false, false, false]))->product());

        // Test: Product with all true values - all true become 1
        // Тест: Произведение всех true значений - все true становятся 1
        $this->assertSame(1, (new CoverArray([true, true, true]))->product());

        // Test: Product with mixed null and false - both become 0
        // Тест: Произведение с mixed null и false - оба становятся 0
        $this->assertSame(0, (new CoverArray([null, false, 5]))->product()); // 0 * 0 * 5 = 0

        // Test: Product with scientific notation strings
        // Тест: Произведение со строками в научной нотации
        $this->assertSame(
            array_product(['1.2e3', '5e0']), // Используем array_product как эталон
            (new CoverArray(['1.2e3', '5e0']))->product()
        );
    }

    /**
     * Tests the product() method with invalid/non-scalar types (array_product equivalent).
     *
     * This test verifies that the product() method handles invalid and non-scalar
     * types (arrays, objects, resources, callables) correctly, matching the behavior
     * of PHP's array_product() function with error suppression.
     *
     * Note: In PHP 8.3+, array_product() generates E_WARNING for non-scalar values
     * and returns 0. In earlier versions, it returns 0 without warning.
     *
     *
     * Тестирование метода product() с недопустимыми/нескалярными типами (эквивалент array_product).
     *
     * Этот тест проверяет, что метод product() корректно обрабатывает недопустимые и
     * нескалярные типы (массивы, объекты, ресурсы, callable), соответствуя поведению
     * функции array_product() PHP с подавлением ошибок.
     *
     * Примечание: В PHP 8.3+ array_product() генерирует E_WARNING для нескалярных значений
     * и возвращает 0. В более ранних версиях возвращает 0 без предупреждения.
     *
     * @see CoverArray::product()
     * @see array_product()
     */
    public function testProductMethodWithInvalidTypes(): void
    {
        // Test with arrays inside array
        $data1 = [2, [1, 2], 3];
        $expected1 = @array_product($data1);
        $cover1 = new CoverArray($data1);
        $this->assertSame($expected1, $cover1->product());

        // Test with objects
        $data2 = [2, new \stdClass(), 3];
        $expected2 = @array_product($data2); // 0
        $cover2 = new CoverArray($data2);
        $this->assertSame($expected2, $cover2->product());

        // Test with resources
        $resource = fopen('php://memory', 'r');
        $data3 = [2, $resource, 3];
        $expected3 = @array_product($data3); // 0 (PHP 8.3+) или handle ресурса (PHP < 8.3)
        $cover3 = new CoverArray($data3);
        $this->assertSame($expected3, $cover3->product());
        fclose($resource);

        // Test with callable
        $data4 = [
            2,
            function () {
                return 5;
            },
            3
        ];
        $expected4 = @array_product($data4); // 0
        $cover4 = new CoverArray($data4);
        $this->assertSame($expected4, $cover4->product());
    }

    /**
     * Tests the append() method (array_push equivalent).
     *
     * This test verifies that the append() method correctly adds
     * one or more elements to the end of the CoverArray, mirroring
     * PHP's array_push() function behavior.
     *
     *
     * Тестирование метода append() (эквивалент array_push).
     *
     * Этот тест проверяет, что метод append() корректно добавляет
     * один или несколько элементов в конец CoverArray, отражая
     * поведение функции array_push() PHP.
     *
     * @see CoverArray::append()
     * @see array_push()
     */
    public function testAppendMethod(): void
    {
        // Test appending single element
        // Тест добавления одного элемента
        $data1 = [1, 2, 3];
        $expected1 = $data1;
        array_push($expected1, 4);

        $cover1 = new CoverArray($data1);
        $cover1->append(4);

        $this->assertSame($expected1, $cover1->getDataAsArray());

        // Test appending multiple elements
        // Тест добавления нескольких элементов
        $data2 = [1, 2, 3];
        $expected2 = $data2;
        array_push($expected2, 4, 5, 6);

        $cover2 = new CoverArray($data2);
        $cover2->append(4, 5, 6);

        $this->assertSame($expected2, $cover2->getDataAsArray());

        // Test appending with different types
        // Тест добавления с разными типами
        $data3 = ['a', 'b'];
        $expected3 = $data3;
        array_push($expected3, 'c', 1, true, null);

        $cover3 = new CoverArray($data3);
        $cover3->append('c', 1, true, null);

        $this->assertSame($expected3, $cover3->getDataAsArray());

        // Test appending array (should be converted to CoverArray)
        // Тест добавления массива (должен быть преобразован в CoverArray)
        $data4 = [1, 2];
        $arrayValue = ['nested' => 'value'];

        // Используем array_push для получения ожидаемого результата
        // но будем проверять поэлементно, так как array_push не преобразует вложенные массивы
        $expected4 = $data4;
        array_push($expected4, $arrayValue);

        $cover4 = new CoverArray($data4);
        $cover4->append($arrayValue);

        // Проверяем первые два элемента
        $this->assertSame($expected4[0], $cover4->item(0));
        $this->assertSame($expected4[1], $cover4->item(1));

        // Проверяем, что третий элемент является CoverArray и содержит правильные данные
        $thirdElement = $cover4->item(2);
        $this->assertInstanceOf(CoverArray::class, $thirdElement);
        $this->assertSame($arrayValue, $thirdElement->getDataAsArray());

        // Test appending to empty array
        // Тест добавления в пустой массив
        $data5 = [];
        $expected5 = $data5;
        array_push($expected5, 'first', 'second');

        $cover5 = new CoverArray($data5);
        $cover5->append('first', 'second');

        $this->assertSame($expected5, $cover5->getDataAsArray());

        // Test appending with numeric string keys
        // Тест добавления с числовыми строковыми ключами
        $data6 = [0 => 'zero', 1 => 'one'];
        $expected6 = $data6;
        array_push($expected6, 'two', 'three');

        $cover6 = new CoverArray($data6);
        $cover6->append('two', 'three');

        $this->assertSame($expected6, $cover6->getDataAsArray());

        // Test that method returns same instance (for chaining)
        // Тест, что метод возвращает тот же экземпляр (для цепочки вызовов)
        $data7 = [1, 2];
        $cover7 = new CoverArray($data7);

        $returned = $cover7->append(3);
        $this->assertSame($cover7, $returned);

        // Test chaining append calls
        // Тест цепочки вызовов append
        $data8 = [1];
        $expected8 = $data8;
        array_push($expected8, 2, 3, 4, 5);

        $cover8 = new CoverArray($data8);
        $cover8->append(2)->append(3, 4)->append(5);

        $this->assertSame($expected8, $cover8->getDataAsArray());

        // Test appending with associative array (push reindexes numeric keys)
        // Тест добавления с ассоциативным массивом (push переиндексирует числовые ключи)
        $data9 = ['a' => 1, 'b' => 2];
        $expected9 = $data9;
        array_push($expected9, 3, 4);

        $cover9 = new CoverArray($data9);
        $cover9->append(3, 4);

        $this->assertSame($expected9, $cover9->getDataAsArray());

        // Test appending with false, 0, empty string
        // Тест добавления с false, 0, пустой строкой
        $data10 = ['first'];
        $expected10 = $data10;
        array_push($expected10, false, 0, '');

        $cover10 = new CoverArray($data10);
        $cover10->append(false, 0, '');

        $this->assertSame($expected10, $cover10->getDataAsArray());
    }

    /**
     * Tests the push() method (array_push equivalent, alias for append()).
     *
     * This test verifies that the push() method correctly adds
     * one or more elements to the end of the CoverArray, mirroring
     * PHP's array_push() function behavior. This is an alias for append().
     *
     *
     * Тестирование метода push() (эквивалент array_push, псевдоним для append()).
     *
     * Этот тест проверяет, что метод push() корректно добавляет
     * один или несколько элементов в конец CoverArray, отражая
     * поведение функции array_push() PHP. Это псевдоним для append().
     *
     * @see CoverArray::push()
     * @see CoverArray::append()
     * @see array_push()
     */
    public function testPushMethod(): void
    {
        // Test pushing single element
        // Тест добавления одного элемента
        $data1 = [1, 2, 3];
        $expected1 = $data1;
        array_push($expected1, 4);

        $cover1 = new CoverArray($data1);
        $cover1->push(4);

        $this->assertSame($expected1, $cover1->getDataAsArray());

        // Test pushing multiple elements
        // Тест добавления нескольких элементов
        $data2 = [1, 2, 3];
        $expected2 = $data2;
        array_push($expected2, 4, 5, 6);

        $cover2 = new CoverArray($data2);
        $cover2->push(4, 5, 6);

        $this->assertSame($expected2, $cover2->getDataAsArray());

        // Test that push is an alias for append (same behavior)
        // Тест, что push является псевдонимом для append (одинаковое поведение)
        $data3 = ['a', 'b', 'c'];
        $expected3 = $data3;
        array_push($expected3, 'd', 'e');

        $cover3a = new CoverArray($data3);
        $cover3b = new CoverArray($data3);

        $cover3a->append('d', 'e');
        $cover3b->push('d', 'e');

        $this->assertSame($expected3, $cover3a->getDataAsArray());
        $this->assertSame($expected3, $cover3b->getDataAsArray());
        $this->assertSame($cover3a->getDataAsArray(), $cover3b->getDataAsArray());

        // Test pushing with different types
        // Тест добавления с разными типами
        $data4 = [1];
        $expected4 = $data4;
        array_push($expected4, 'string', 2.5, null, false);

        $cover4 = new CoverArray($data4);
        $cover4->push('string', 2.5, null, false);

        $this->assertSame($expected4, $cover4->getDataAsArray());

        // Test pushing array (should be converted to CoverArray)
        // Тест добавления массива (должен быть преобразован в CoverArray)
        $data5 = ['first'];
        $arrayValue = ['nested' => ['key' => 'value']];

        // Используем array_push для получения ожидаемого результата
        $expected5 = $data5;
        array_push($expected5, $arrayValue);

        $cover5 = new CoverArray($data5);
        $cover5->push($arrayValue);

        // Проверяем первый элемент
        $this->assertSame($expected5[0], $cover5->item(0));

        // Проверяем, что второй элемент является CoverArray и содержит правильные данные
        $secondElement = $cover5->item(1);
        $this->assertInstanceOf(CoverArray::class, $secondElement);
        $this->assertSame($arrayValue, $secondElement->getDataAsArray());

        // Test pushing to empty array
        // Тест добавления в пустой массив
        $data6 = [];
        $expected6 = $data6;
        array_push($expected6, 'apple', 'banana', 'cherry');

        $cover6 = new CoverArray($data6);
        $cover6->push('apple', 'banana', 'cherry');

        $this->assertSame($expected6, $cover6->getDataAsArray());

        // Test that method returns same instance (for chaining)
        // Тест, что метод возвращает тот же экземпляр (для цепочки вызовов)
        $data7 = [10, 20];
        $cover7 = new CoverArray($data7);

        $returned = $cover7->push(30);
        $this->assertSame($cover7, $returned);

        // Test chaining push calls
        // Тест цепочки вызовов push
        $data8 = ['start'];
        $expected8 = $data8;
        array_push($expected8, 'middle1', 'middle2', 'end1', 'end2');

        $cover8 = new CoverArray($data8);
        $cover8->push('middle1', 'middle2')->push('end1', 'end2');

        $this->assertSame($expected8, $cover8->getDataAsArray());

        // Test pushing with associative array (keys are preserved for string keys, numeric reindexed)
        // Тест добавления с ассоциативным массивом (строковые ключи сохраняются, числовые переиндексируются)
        $data9 = ['a' => 'apple', 'b' => 'banana'];
        $expected9 = $data9;
        array_push($expected9, 'cherry', 'date');

        $cover9 = new CoverArray($data9);
        $cover9->push('cherry', 'date');

        $this->assertSame($expected9, $cover9->getDataAsArray());
    }

    /**
     * Tests the rand() method (array_rand equivalent).
     *
     * This test verifies that the rand() method correctly returns
     * random key(s) from the CoverArray, with optional number of
     * entries to pick, mirroring PHP's array_rand() function behavior.
     *
     *
     * Тестирование метода rand() (эквивалент array_rand).
     *
     * Этот тест проверяет, что метод rand() корректно возвращает
     * случайный(ые) ключ(и) из CoverArray, с опциональным количеством
     * выбираемых записей, отражая поведение функции array_rand() PHP.
     *
     * @see CoverArray::rand()
     * @see array_rand()
     */
    public function testRandMethod(): void
    {
        // Test with single random element (default behavior)
        // Тест с одним случайным элементом (поведение по умолчанию)
        $data1 = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry', 'd' => 'date'];
        $cover1 = new CoverArray($data1);
        $result1 = $cover1->rand();
        $this->assertContains($result1, array_keys($data1));

        // Test with multiple random elements
        // Тест с несколькими случайными элементами
        $data2 = ['PHP', 'MySql', 'HTML', 'CSS', 'JavaScript'];
        $num2 = 3;
        $cover2 = new CoverArray($data2);
        $result2 = $cover2->rand($num2);

        // Verify we got a CoverArray with the correct number of elements
        // Проверяем, что получили CoverArray с правильным количеством элементов
        $this->assertInstanceOf(CoverArray::class, $result2);
        $this->assertCount($num2, $result2);

        // Verify all returned keys are valid and unique
        // Проверяем, что все возвращенные ключи валидны и уникальны
        $resultArray = $result2->getDataAsArray();
        foreach ($resultArray as $key) {
            $this->assertArrayHasKey($key, $data2);
        }
        $this->assertCount($num2, array_unique($resultArray));

        // Test with all elements requested (should return all keys shuffled)
        // Тест с запросом всех элементов (должен вернуть все ключи в перемешанном порядке)
        $data3 = ['x' => 1, 'y' => 2, 'z' => 3];
        $num3 = 3;
        $cover3 = new CoverArray($data3);
        $result3 = $cover3->rand($num3);

        $this->assertInstanceOf(CoverArray::class, $result3);
        $this->assertCount($num3, $result3);

        // Verify all keys are present
        // Проверяем, что все ключи присутствуют
        $resultArray3 = $result3->getDataAsArray();
        $this->assertEqualsCanonicalizing(array_keys($data3), $resultArray3);

        // Test with associative array
        // Тест с ассоциативным массивом
        $data4 = ['country' => 'Russia', 'region' => 'Moscow region', 'city' => 'Podolsk'];
        $expected4 = array_rand($data4, 2);

        $cover4 = new CoverArray($data4);
        $result4 = $cover4->rand(2);

        $this->assertInstanceOf(CoverArray::class, $result4);
        $this->assertCount(2, $result4);

        $resultArray4 = $result4->getDataAsArray();
        foreach ($resultArray4 as $key) {
            $this->assertArrayHasKey($key, $data4);
        }

        // Test with numeric indexed array
        // Тест с числовым индексированным массивом
        $data5 = ['PHP', 'MySql', 'HTML', 'CSS', 'JavaScript'];
        $num5 = 1;

        $cover5 = new CoverArray($data5);
        $result5 = $cover5->rand($num5);

        // When num=1, array_rand returns a single value, not an array
        // Когда num=1, array_rand возвращает одиночное значение, а не массив
        $this->assertIsInt($result5);
        $this->assertArrayHasKey($result5, $data5);

        // Test with empty array
        // Тест с пустым массивом
        $data6 = [];
        $cover6 = new CoverArray($data6);

        // With empty array and num=1
        // С пустым массивом и num=1
        $this->expectException(ValueError::class);
        $cover6->rand(1);

        // Test that original array is not modified
        // Тест, что исходный массив не изменяется
        $data7 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $cover7 = new CoverArray($data7);

        $before = $cover7->getDataAsArray();
        $cover7->rand(2);
        $after = $cover7->getDataAsArray();

        $this->assertSame($before, $after, 'Original array should not be modified');

        // Test with single element array
        // Тест с массивом из одного элемента
        $data8 = ['only' => 'element'];
        $cover8 = new CoverArray($data8);
        $result8 = $cover8->rand();

        $this->assertSame('only', $result8);
    }


    // Additional CoverArray-specific methods (not direct equivalents of PHP array functions)

    /**
     * Tests the eachRecursive() method.
     *
     * This test verifies that the eachRecursive() method correctly applies
     * a callback function to all elements of a multidimensional CoverArray,
     * returning a new instance with transformed values at all nesting levels.
     *
     *
     * Тестирование метода eachRecursive().
     *
     * Этот тест проверяет, что метод eachRecursive() корректно применяет
     * callback-функцию ко всем элементам многомерного CoverArray,
     * возвращая новый экземпляр с преобразованными значениями на всех уровнях вложенности.
     *
     * @see CoverArray::eachRecursive()
     */
    public function testEachRecursiveMethod(): void
    {
        $data = $this->data->get('languages');
        $expected = [
            'backend' => ['0: PHP', '1: MySql'],
            'frontend' => ['0: HTML', '1: CSS', '2: JavaScript']
        ];

        $this->assertSame(
            $expected,
            $data->eachRecursive(
                fn(mixed $value, mixed $key): string => "$key: $value"
            )->getDataAsArray()
        );
    }

    /**
     * Tests the prepend() and unshift() methods (array_unshift equivalent).
     *
     * This test verifies that the prepend() method (and its unshift() alias)
     * correctly adds one or more elements to the beginning of the CoverArray,
     * shifting existing elements to higher indices, mirroring PHP's array_unshift().
     *
     *
     * Тестирование методов prepend() и unshift() (эквивалент array_unshift).
     *
     * Этот тест проверяет, что метод prepend() (и его псевдоним unshift())
     * корректно добавляет один или несколько элементов в начало CoverArray,
     * сдвигая существующие элементы на более высокие индексы, отражая array_unshift() PHP.
     *
     * @see CoverArray::prepend()
     * @see CoverArray::unshift()
     * @see array_unshift()
     */
    public function testPrependMethod(): void
    {
        $this->data->get('languages.backend')->prepend('C++');
        $this->assertSame('C++', $this->data->get('languages.backend')->first());

        $this->data->get('languages.backend')->prepend(['Python', 'Ruby']);
        $this->assertSame(['Python', 'Ruby'], $this->data->get('languages.backend')->first()->getDataAsArray());

        $this->data->get('languages.backend')->unshift('Java', 'C#');
        $this->assertSame('C#', $this->data->get('languages.backend')->first());
    }


    /**
     * Tests the reverse() method (array_reverse equivalent).
     *
     * This test verifies that the reverse() method correctly returns
     * a new CoverArray with elements in reverse order, with optional
     * key preservation, mirroring PHP's array_reverse() function.
     *
     *
     * Тестирование метода reverse() (эквивалент array_reverse).
     *
     * Этот тест проверяет, что метод reverse() корректно возвращает
     * новый CoverArray с элементами в обратном порядке, с опциональным
     * сохранением ключей, отражая функцию array_reverse() PHP.
     *
     * @see CoverArray::reverse()
     * @see array_reverse()
     */
    public function testReverseMethod(): void
    {
        $this->assertSame(
            [0 => 'MySql', 1 => 'PHP'],
            $this->data->get('languages.backend')->reverse()->getDataAsArray()
        );
        $this->assertSame(
            [1 => 'MySql', 0 => 'PHP'],
            $this->data->get('languages.backend')->reverse(true)->getDataAsArray()
        );
    }

    /**
     * Tests the unique() method (array_unique equivalent).
     *
     * This test verifies that the unique() method correctly removes
     * duplicate values from the CoverArray, returning a new instance
     * with only unique elements, mirroring PHP's array_unique() function.
     *
     *
     * Тестирование метода unique() (эквивалент array_unique).
     *
     * Этот тест проверяет, что метод unique() корректно удаляет
     * повторяющиеся значения из CoverArray, возвращая новый экземпляр
     * только с уникальными элементами, отражая функцию array_unique() PHP.
     *
     * @see CoverArray::unique()
     * @see array_unique()
     */
    public function testUniqueMethod(): void
    {
        $this->data->get('languages.backend')->append('PHP');
        $this->data->get('languages.backend')->append('PHP');
        $this->data->get('languages.backend')->append('PHP');

        $this->assertSame(
            ['PHP', 'MySql', 'PHP', 'PHP', 'PHP'],
            $this->data->get('languages.backend')->getDataAsArray()
        );

        $this->assertSame(
            ['PHP', 'MySql'],
            $this->data->get('languages.backend')->unique()->getDataAsArray()
        );
    }

    /**
     * Tests the in() method (in_array equivalent).
     *
     * This test verifies that the in() method correctly checks
     * whether a value exists in the CoverArray, with optional
     * strict type comparison, mirroring PHP's in_array() function.
     *
     *
     * Тестирование метода in() (эквивалент in_array).
     *
     * Этот тест проверяет, что метод in() корректно проверяет,
     * существует ли значение в CoverArray, с опциональным
     * строгим сравнением типов, отражая функцию in_array() PHP.
     *
     * @see CoverArray::in()
     * @see in_array()
     */
    public function testInMethod(): void
    {
        $this->assertTrue($this->data->get('birthday')->in(1982, true));
        $this->assertTrue($this->data->get('birthday')->in(1982, false));

        $this->assertTrue($this->data->get('birthday')->in('1982', false));
        $this->assertFalse($this->data->get('birthday')->in('1982', true));
    }
}