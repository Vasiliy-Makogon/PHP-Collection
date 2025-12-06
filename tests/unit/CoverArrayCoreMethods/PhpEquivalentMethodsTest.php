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
        $this->assertTrue($this->data->get('languages')->all(function ($value) {
            return is_iterable($value);
        }));

        $this->assertFalse($this->data->get('languages.backend')->all(function ($value) {
            return is_int($value);
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
        $this->assertTrue($this->data->get('languages.backend')->any(function ($value, $key) {
            return $value == 'PHP' && $key == 0;
        }));

        $this->assertFalse($this->data->get('languages')->any(function ($value, $key) {
            return $key == 'undefined';
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
        $data = $this->data->get('address');
        $expected = [
            'country' => 'Russia',
            'region' => 'Moscow region',
            'city' => 'Podolsk',
            'street' => 'Kirov st.'
        ];

        // original function
        $this->assertSame(
            $expected,
            array_change_key_case($data->getDataAsArray())
        );

        $this->assertSame(
            $expected,
            $data->changeKeyCase()->getDataAsArray()
        );

        $expected = [
            'COUNTRY' => 'Russia',
            'REGION' => 'Moscow region',
            'CITY' => 'Podolsk',
            'STREET' => 'Kirov st.'
        ];

        // original function
        $this->assertSame(
            $expected,
            array_change_key_case($data->getDataAsArray(), CASE_UPPER)
        );

        $this->assertSame(
            $expected,
            $data->changeKeyCase(CASE_UPPER)->getDataAsArray()
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
    public function testChunkMethod()
    {
        $data = $this->data->get('address');
        $expected = [
            0 => [0 => 'Russia', 1 => 'Moscow region'],
            1 => [0 => 'Podolsk', 1 => 'Kirov st.']
        ];

        // original function
        $this->assertSame(
            $expected,
            array_chunk($data->getDataAsArray(), 2)
        );

        $this->assertSame(
            $expected,
            $data->chunk(2)->getDataAsArray()
        );

        $expected = [
            0 => ['country' => 'Russia', 'region' => 'Moscow region'],
            1 => ['city' => 'Podolsk', 'street' => 'Kirov st.']
        ];

        // original function
        $this->assertSame(
            $expected,
            array_chunk($data->getDataAsArray(), 2, true)
        );

        $this->assertSame(
            $expected,
            $data->chunk(2, true)->getDataAsArray()
        );

        $this->expectException(ValueError::class);
        $this->assertSame(
            $expected,
            $data->chunk(0, true)->getDataAsArray()
        );
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
        $data = new NewTypeArray([
            ['id' => 2135, 'first_name' => 'John', 'last_name' => 'Doe'],
            ['id' => 3245, 'first_name' => 'Sally', 'last_name' => 'Smith'],
            ['id' => 5342, 'first_name' => 'Jane', 'last_name' => 'Jones'],
            ['id' => 5623, 'first_name' => 'Peter', 'last_name' => 'Doe']
        ]);
        $expected = ['John', 'Sally', 'Jane', 'Peter'];

        // original function
        $this->assertSame(
            $expected,
            array_column($data->getDataAsArray(), 'first_name')
        );

        $this->assertSame(
            $expected,
            $data->column('first_name')->getDataAsArray()
        );

        $expected = [
            2135 => 'John',
            3245 => 'Sally',
            5342 => 'Jane',
            5623 => 'Peter'
        ];

        // original function
        $this->assertSame(
            $expected,
            array_column($data->getDataAsArray(), 'first_name', 'id')
        );

        $this->assertSame(
            $expected,
            $data->column('first_name', 'id')->getDataAsArray()
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
        $valuesData = $this->data->get('address')->values();
        $keysData = $this->data->get('address')->keys();

        $expected = [
            'country' => 'Russia',
            'region' => 'Moscow region',
            'city' => 'Podolsk',
            'street' => 'Kirov st.'
        ];

        // original function
        $this->assertSame(
            $expected,
            array_combine(
                $keysData->getDataAsArray(),
                $valuesData->getDataAsArray()
            )
        );

        // arguments as array
        $this->assertSame(
            $expected,
            NewTypeArray::combine(
                $keysData->getDataAsArray(),
                $valuesData->getDataAsArray()
            )->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            NewTypeArray::combine(
                $keysData,
                $valuesData
            )->getDataAsArray()
        );
    }

    /**
     * Tests the countValues() method (array_count_values equivalent).
     *
     * This test verifies that the countValues() method correctly counts
     * the occurrences of each distinct value in the CoverArray,
     * mirroring the behavior of PHP's array_count_values() function.
     *
     *
     * Тестирование метода countValues() (эквивалент array_count_values).
     *
     * Этот тест проверяет, что метод countValues() корректно подсчитывает
     * вхождения каждого уникального значения в CoverArray,
     * отражая поведение функции array_count_values() PHP.
     *
     * @see CoverArray::countValues()
     * @see array_count_values()
     */
    public function testCountValuesMethod(): void
    {
        $data = $this->data->get('languages.backend');
        $expected = ['PHP' => 1, 'MySql' => 1];

        // original function
        $this->assertSame(
            $expected,
            array_count_values($data->getDataAsArray())
        );

        $this->assertSame(
            $expected,
            $data->countValues()->getDataAsArray()
        );
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
        $data = $this->data->get('languages.frontend');
        $expected = [];

        $additionalData1 = new NewTypeArray(['HTML']);
        $additionalData2 = new NewTypeArray(['CSS', 'JavaScript']);

        // original function
        $this->assertSame(
            $expected,
            array_diff(
                $data->getDataAsArray(),
                $additionalData1->getDataAsArray(),
                $additionalData2->getDataAsArray()
            )
        );

        // arguments as array
        $this->assertSame(
            $expected,
            $data->diff(
                $additionalData1->getDataAsArray(),
                $additionalData2->getDataAsArray()
            )->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $data->diff(
                $additionalData1,
                $additionalData2
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
        $data = $this->data->get('address');
        $expected = ['country' => 'Russia'];

        $additionalData1 = new NewTypeArray([
            'country' => 'another',
            'region' => 'Moscow region',
            'city' => 'Podolsk',
            'street' => 'Kirov st.'
        ]);
        $additionalData2 = new NewTypeArray([
            'another' => 'another',
        ]);

        // original function
        $this->assertSame(
            $expected,
            array_diff_assoc(
                $data->getDataAsArray(),
                $additionalData1->getDataAsArray(),
                $additionalData2->getDataAsArray()
            )
        );

        // arguments as array
        $this->assertSame(
            $expected,
            $data->diffAssoc(
                $additionalData1->getDataAsArray(),
                $additionalData2->getDataAsArray()
            )->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $data->diffAssoc(
                $additionalData1,
                $additionalData2
            )->getDataAsArray()
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
        $data = $this->data->get('address');
        $expected = ['city' => 'Podolsk'];

        $additionalData1 = new NewTypeArray([
            'country' => 'Russia',
            'region' => 'Moscow region',
        ]);
        $additionalData2 = new NewTypeArray([
            'street' => 'Kirov st.'
        ]);

        // original function
        $this->assertSame(
            $expected,
            array_diff_key(
                $data->getDataAsArray(),
                $additionalData1->getDataAsArray(),
                $additionalData2->getDataAsArray()
            )
        );

        // arguments as array
        $this->assertSame(
            $expected,
            $data->diffKey(
                $additionalData1->getDataAsArray(),
                $additionalData2->getDataAsArray()
            )->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $data->diffKey(
                $additionalData1,
                $additionalData2
            )->getDataAsArray()
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
        $data = $this->data->get('address');
        $expected = ['city' => 'Podolsk'];

        $additionalData1 = new NewTypeArray([
            'country' => 'Russia',
            'region' => 'Moscow region',
        ]);
        $additionalData2 = new NewTypeArray([
            'street' => 'Kirov st.'
        ]);

        $callback = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            return $a <=> $b;
        };

        // original function
        $this->assertSame(
            $expected,
            array_diff_uassoc(
                $data->getDataAsArray(),
                $additionalData1->getDataAsArray(),
                $additionalData2->getDataAsArray(),
                $callback
            )
        );

        // arguments as array
        $this->assertSame(
            $expected,
            $data->diffUassoc(
                $callback,
                $additionalData1->getDataAsArray(),
                $additionalData2->getDataAsArray()
            )->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $data->diffUassoc(
                $callback,
                $additionalData1,
                $additionalData2
            )->getDataAsArray()
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
        $data = $this->data->get('address');
        $expected = ['city' => 'Podolsk'];

        $additionalData1 = new NewTypeArray([
            'country' => 'Russia',
            'region' => 'Moscow region',
        ]);
        $additionalData2 = new NewTypeArray([
            'street' => 'Kirov st.'
        ]);

        $callback = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            return $a <=> $b;
        };

        // original function
        $this->assertSame(
            $expected,
            array_diff_ukey(
                $data->getDataAsArray(),
                $additionalData1->getDataAsArray(),
                $additionalData2->getDataAsArray(),
                $callback
            )
        );

        // arguments as array
        $this->assertSame(
            $expected,
            $data->diffUkey(
                $callback,
                $additionalData1->getDataAsArray(),
                $additionalData2->getDataAsArray()
            )->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $data->diffUkey(
                $callback,
                $additionalData1,
                $additionalData2
            )->getDataAsArray()
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
        $expected = [2 => 'foo', 3 => 'foo'];
        $start_index = 2;
        $count = 2;
        $value = 'foo';

        // original function
        $this->assertSame(
            $expected,
            array_fill($start_index, $count, $value)
        );

        $this->assertSame(
            $expected,
            NewTypeArray::fill(
                $start_index,
                $count,
                $value
            )->getDataAsArray()
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
        $keysData = new NewTypeArray(['foo', 5, 10, 'bar']);
        $value = 'banana';
        $expected = ['foo' => 'banana', 5 => 'banana', 10 => 'banana', 'bar' => 'banana'];

        // original function
        $this->assertSame(
            $expected,
            array_fill_keys($keysData->getDataAsArray(), $value)
        );

        // arguments as array
        $this->assertSame(
            $expected,
            NewTypeArray::fillKeys(
                $keysData->getDataAsArray(),
                $value
            )->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            NewTypeArray::fillKeys(
                $keysData,
                $value
            )->getDataAsArray()
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
        // pass value as the only argument to callback

        $data = $this->data->get('languages.backend');
        $expected = ['PHP'];
        $callback = function ($value) {
            return preg_match('~P~', $value);
        };

        // original function
        $this->assertSame(
            $expected,
            array_filter(
                $data->getDataAsArray(),
                $callback
            )
        );

        $this->assertSame(
            ['PHP'],
            $data->filter($callback)->getDataAsArray()
        );

        // pass key as the only argument to callback

        $data = $this->data->get('languages');
        $expected = ['backend' => ['PHP', 'MySql']];
        $callback = function ($key) {
            return $key === 'backend';
        };

        // original function
        $this->assertSame(
            $expected,
            array_filter(
                $data->getDataAsArray(),
                $callback,
                ARRAY_FILTER_USE_KEY
            )
        );

        $this->assertSame(
            $expected,
            $data->filter(
                $callback,
                ARRAY_FILTER_USE_KEY
            )->getDataAsArray()
        );

        // pass both value and key as arguments to callback

        $data = $this->data->get('languages');
        $expected = ['backend' => ['PHP', 'MySql']];
        $callback = function ($value, $key) {
            return $key === 'backend' && is_iterable($value) && $value[0] === 'PHP';
        };

        // original function
        $this->assertSame(
            $expected,
            array_filter(
                $data->getDataAsArray(),
                $callback,
                ARRAY_FILTER_USE_BOTH
            )
        );

        $this->assertSame(
            $expected,
            $data->filter(
                $callback,
                ARRAY_FILTER_USE_BOTH
            )->getDataAsArray()
        );

        // without callback

        $data = NewTypeArray::fromExplode(',', ',0')
            ->append(null);
        $expected = [];

        // original function
        $this->assertSame(
            $expected,
            array_filter($data->getDataAsArray())
        );

        $this->assertSame(
            $expected,
            $data->filter()->getDataAsArray()
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
    public function testFindMethod()
    {
        $this->assertSame(1982, $this->data->get('birthday')->find(function ($value) {
            return $value > 1000;
        }));

        $this->assertNull($this->data->find(function ($value) {
            return false;
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
    public function testFindKeyMethod()
    {
        $this->assertSame(2, $this->data->get('birthday')->findKey(function ($value) {
            return $value == 1982;
        }));

        $this->assertNull($this->data->findKey(function ($value) {
            return false;
        }));
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
        $data = $this->data->get('address');
        $expected = [
            'Russia' => 'country',
            'Moscow region' => 'region',
            'Podolsk' => 'city',
            'Kirov st.' => 'street'
        ];

        // original function
        $this->assertSame(
            $expected,
            array_flip($data->getDataAsArray())
        );

        $this->assertSame(
            $expected,
            $data->flip()->getDataAsArray()
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
        $data = $this->data->get('languages.frontend');

        $additionalData1 = clone $data;
        $additionalData1->offsetUnset(0); // remove 'HTML' by index

        $additionalData2 = clone $data;
        $additionalData2->offsetUnset(1); // remove 'CSS' by index

        $expected = [2 => 'JavaScript'];

        // original function
        $this->assertSame(
            $expected,
            array_intersect(
                $data->getDataAsArray(),
                $additionalData1->getDataAsArray(),
                $additionalData2->getDataAsArray()
            )
        );

        // arguments as array
        $this->assertSame(
            $expected,
            $data->intersect(
                $additionalData1->getDataAsArray(),
                $additionalData2->getDataAsArray()
            )->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $data->intersect(
                $additionalData1,
                $additionalData2
            )->getDataAsArray()
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
        $data = $this->data->get('languages.frontend');

        $additionalData1 = clone $data;
        $additionalData1->offsetUnset(0); // remove 'HTML' by index
        $additionalData1->append('HTML');

        $additionalData2 = clone $data;
        $additionalData2->offsetUnset(1); // remove 'CSS' by index
        $additionalData2->append('CSS');

        $expected = [2 => 'JavaScript'];

        // original function
        $this->assertSame(
            $expected,
            array_intersect_assoc(
                $data->getDataAsArray(),
                $additionalData1->getDataAsArray(),
                $additionalData2->getDataAsArray()
            )
        );

        // arguments as array
        $this->assertSame(
            $expected,
            $data->intersectAssoc(
                $additionalData1->getDataAsArray(),
                $additionalData2->getDataAsArray()
            )->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $data->intersectAssoc(
                $additionalData1,
                $additionalData2
            )->getDataAsArray()
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
        $data = $this->data->get('address');

        $additionalData1 = clone $data;
        $additionalData1->offsetUnset('region');

        $additionalData2 = clone $data;
        $additionalData2->offsetUnset('city');

        $expected = ['country' => 'Russia', 'street' => 'Kirov st.'];

        // original function
        $this->assertSame(
            $expected,
            array_intersect_key(
                $data->getDataAsArray(),
                $additionalData1->getDataAsArray(),
                $additionalData2->getDataAsArray()
            )
        );

        // arguments as array
        $this->assertSame(
            $expected,
            $data->intersectKey(
                $additionalData1->getDataAsArray(),
                $additionalData2->getDataAsArray()
            )->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $data->intersectKey(
                $additionalData1,
                $additionalData2
            )->getDataAsArray()
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
        $data = $this->data->get('address');
        $expected = ['country' => 'Russia', 'street' => 'Kirov st.'];

        $additionalData1 = clone $data;
        $additionalData1->offsetUnset('region');
        $additionalData1->offsetSet('REGION', 'Moscow region');

        $additionalData2 = clone $data;
        $additionalData2->offsetUnset('city');
        $additionalData2->offsetSet('city', 'PODOLSK');

        // original function
        $this->assertSame(
            $expected,
            array_intersect_uassoc(
                $data->getDataAsArray(),
                $additionalData1->getDataAsArray(),
                $additionalData2->getDataAsArray(),
                'strcmp'
            )
        );

        // arguments as array
        $this->assertSame(
            $expected,
            $data->intersectUassoc(
                'strcmp',
                $additionalData1->getDataAsArray(),
                $additionalData2->getDataAsArray()
            )->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $data->intersectUassoc(
                'strcmp',
                $additionalData1,
                $additionalData2
            )->getDataAsArray()
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
        $data = $this->data->get('address');
        $expected = ['country' => 'Russia', 'city' => 'Podolsk', 'street' => 'Kirov st.'];

        $additionalData1 = clone $data;
        $additionalData1->offsetUnset('region');
        $additionalData1->offsetSet('REGION', 'Moscow region');

        $additionalData2 = clone $data;
        $additionalData2->offsetUnset('city');
        $additionalData2->offsetSet('city', 'PODOLSK');

        $key_compare_func = function ($key1, $key2) {
            if ($key1 == $key2) {
                return 0;
            } else {
                if ($key1 > $key2) {
                    return 1;
                } else {
                    return -1;
                }
            }
        };

        // original function
        $this->assertSame(
            $expected,
            array_intersect_ukey(
                $data->getDataAsArray(),
                $additionalData1->getDataAsArray(),
                $additionalData2->getDataAsArray(),
                $key_compare_func
            )
        );

        // arguments as array
        $this->assertSame(
            $expected,
            $data->intersectUkey(
                $key_compare_func,
                $additionalData1->getDataAsArray(),
                $additionalData2->getDataAsArray()
            )->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $data->intersectUkey(
                $key_compare_func,
                $additionalData1,
                $additionalData2
            )->getDataAsArray()
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
        $this->assertTrue($this->data->get('birthday')->isList());
        $this->assertTrue((new NewTypeArray())->isList());
        $this->assertFalse($this->data->isList());
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
        $this->assertTrue($this->data->get('birthday')->keyExists('1'));
        $this->assertTrue($this->data->get('address')->keyExists('city'));
        $this->assertFalse($this->data->keyExists('undefined'));
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
        $this->assertSame('country', $this->data->get('address')->keyFirst());
        $this->assertSame(0, $this->data->get('birthday')->keyFirst());
        $this->assertNull((new NewTypeArray())->keyFirst());
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
        $this->assertSame('street', $this->data->get('address')->keyLast());
        $this->assertSame(2, $this->data->get('birthday')->keyLast());
        $this->assertNull((new NewTypeArray())->keyLast());
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
    public function testKeysMethod()
    {
        $data = $this->data->get('address');
        $expected = ['country', 'region', 'city', 'street'];

        // original function
        $this->assertSame(
            $expected,
            array_keys($data->getDataAsArray())
        );

        $this->assertSame(
            $expected,
            $data->keys()->getDataAsArray()
        );

        $data = $this->data->get('languages');
        $expected = ['backend', 'frontend'];

        // original function
        $this->assertSame(
            $expected,
            array_keys($data->getDataAsArray())
        );

        $this->assertSame(
            $expected,
            $data->keys()->getDataAsArray()
        );

        $data = $this->data->get('languages.backend');
        $expected = [0];

        // original function
        $this->assertSame(
            $expected,
            array_keys($data->getDataAsArray(), 'PHP', true)
        );

        $this->assertSame(
            $expected,
            $data->keys('PHP', true)->getDataAsArray()
        );
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
        $data = $this->data->get('address');

        // The returned array will preserve the keys of the array argument if and only if exactly one array is passed.
        $expected = [
            'country' => '--Russia',
            'region' => '--Moscow region',
            'city' => '--Podolsk',
            'street' => '--Kirov st.'
        ];

        // original function
        $this->assertSame(
            $expected,
            array_map(
                fn(mixed $value): string => "--$value",
                $data->getDataAsArray()
            )
        );

        $this->assertSame(
            $expected,
            $data->map(
                fn(mixed $value): string => "--$value"
            )->getDataAsArray()
        );

        // If more than one array is passed, the returned array will have sequential integer keys.
        $expected = [
            0 => 'country: Russia',
            1 => 'region: Moscow region',
            2 => 'city: Podolsk',
            3 => 'street: Kirov st.'
        ];

        // original function
        $this->assertSame(
            $expected,
            array_map(
                fn(mixed $value, mixed $key): string => "$key: $value",
                $data->getDataAsArray(),
                $data->keys()->getDataAsArray()
            )
        );

        $this->assertSame(
            $expected,
            $data->map(
                fn(mixed $value, mixed $key): string => "$key: $value",
                $data->keys()->getDataAsArray()
            )->getDataAsArray()
        );
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
        $data = $this->data->get('languages.backend');
        $merge = $this->data->get('languages.frontend');
        $expected = ['PHP', 'MySql', 'HTML', 'CSS', 'JavaScript'];

        // original function
        $this->assertSame(
            $expected,
            array_merge(
                $data->getDataAsArray(),
                $merge->getDataAsArray(),
            )
        );

        // arguments as array
        $this->assertSame(
            $expected,
            $data->merge(
                $merge->getDataAsArray()
            )->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $data->merge($merge)->getDataAsArray()
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
        $data1 = new NewTypeArray(['color' => ['favorite' => 'red'], 5]);
        $data2 = new NewTypeArray([10, 'color' => ['favorite' => 'green', 'blue']]);
        $expected = [
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

        // original function
        $this->assertSame(
            $expected,
            array_merge_recursive(
                $data1->getDataAsArray(),
                $data2->getDataAsArray(),
            )
        );

        // arguments as array
        $this->assertSame(
            $expected,
            $data1->mergeRecursive(
                $data2->getDataAsArray()
            )->getDataAsArray()
        );
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
     * Tests the getFirst() method (array_first equivalent).
     *
     * This test verifies that the getFirst() method correctly returns
     * the first element of the CoverArray, or null for empty arrays,
     * providing convenient access to the initial element.
     *
     *
     * Тестирование метода getFirst() (эквивалент array_first).
     *
     * Этот тест проверяет, что метод getFirst() корректно возвращает
     * первый элемент CoverArray, или null для пустых массивов,
     * предоставляя удобный доступ к начальному элементу.
     *
     * @see CoverArray::getFirst()
     * @see array_first()
     */
    public function testGetFirstMethod(): void
    {
        $this->assertSame('PHP', $this->data->get('languages.backend')->getFirst());
        $this->assertSame(null, (new NewTypeArray())->getFirst());
    }

    /**
     * Tests the getLast() method (array_last equivalent).
     *
     * This test verifies that the getLast() method correctly returns
     * the last element of the CoverArray, or null for empty arrays,
     * providing convenient access to the final element.
     *
     *
     * Тестирование метода getLast() (эквивалент array_last).
     *
     * Этот тест проверяет, что метод getLast() корректно возвращает
     * последний элемент CoverArray, или null для пустых массивов,
     * предоставляя удобный доступ к конечному элементу.
     *
     * @see CoverArray::getLast()
     * @see array_last()
     */
    public function testGetLastMethod(): void
    {
        $this->assertSame('MySql', $this->data->get('languages.backend')->getLast());
        $this->assertSame(null, (new NewTypeArray())->getLast());
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
        $this->assertSame('C++', $this->data->get('languages.backend')->getFirst());

        $this->data->get('languages.backend')->prepend(['Python', 'Ruby']);
        $this->assertSame(['Python', 'Ruby'], $this->data->get('languages.backend')->getFirst()->getDataAsArray());

        $this->data->get('languages.backend')->unshift('Java', 'C#');
        $this->assertSame('C#', $this->data->get('languages.backend')->getFirst());
    }

    /**
     * Tests the append() and push() methods (array_push equivalent).
     *
     * This test verifies that the append() method (and its push() alias)
     * correctly adds one or more elements to the end of the CoverArray,
     * maintaining existing indices, mirroring PHP's array_push() function.
     *
     *
     * Тестирование методов append() и push() (эквивалент array_push).
     *
     * Этот тест проверяет, что метод append() (и его псевдоним push())
     * корректно добавляет один или несколько элементов в конец CoverArray,
     * сохраняя существующие индексы, отражая функцию array_push() PHP.
     *
     * @see CoverArray::append()
     * @see CoverArray::push()
     * @see array_push()
     */
    public function testAppendMethod(): void
    {
        $this->data->get('languages.backend')->append('C++');
        $this->assertSame('C++', $this->data->get('languages.backend')->getLast());

        $this->data->get('languages.backend')->append(['Python', 'Ruby']);
        $this->assertSame(['Python', 'Ruby'], $this->data->get('languages.backend')->getLast()->getDataAsArray());

        $this->data->get('languages.backend')->push('Java', 'C#');
        $this->assertSame('C#', $this->data->get('languages.backend')->getLast());
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