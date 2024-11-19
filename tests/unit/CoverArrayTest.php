<?php

declare(strict_types=1);

use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class CoverArrayTest extends TestCase
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

    // Start testing methods of the Simple class

    /**
     * @see CoverArray::__get()
     */
    public function testMagicGetMethod(): void
    {
        $this->assertSame('Vasiliy', $this->data->name);
        $this->assertNull($this->data->nonexistent);
    }

    /**
     * @see CoverArray::__set()
     */
    public function testMagicSetMethod(): void
    {
        $this->data->scalarValue = 1;
        $this->data->stdClassValue = new stdClass();
        $this->data->arrayValue = [1, 2, 3]; // array converted to self class type
        $this->data->newTypeArrayValue = new NewTypeArray([1, 2, 3]);
        $this->data->coverArrayValue = new CoverArray([1, 2, 3]);

        $this->assertSame(1, $this->data->scalarValue);
        $this->assertInstanceOf(stdClass::class, $this->data->stdClassValue);
        $this->assertInstanceOf(NewTypeArray::class, $this->data->arrayValue);
        $this->assertInstanceOf(NewTypeArray::class, $this->data->newTypeArrayValue);
        $this->assertInstanceOf(CoverArray::class, $this->data->coverArrayValue);
    }

    /**
     * @see CoverArray::__isset()
     */
    public function testMagicIssetMethod(): void
    {
        $this->assertTrue(isset($this->data->name));
        $this->assertFalse(isset($this->data->nonexistent));
    }

    /**
     * @see CoverArray::__unset()
     */
    public function testMagicUnsetMethod(): void
    {
        unset($this->data->name);
        $this->assertFalse(isset($this->data->name));
    }

    /**
     * @see CoverArray::item()
     */
    public function testItemMethod(): void
    {
        $this->assertSame('PHP', $this->data->get('languages.backend')->item(0));
        $this->assertSame('Vasiliy', $this->data->item('name'));
        $this->assertNull($this->data->item('nonexistent'));
        $this->assertNull($this->data->item(100));
    }

    /**
     * @see CoverArray::getData()
     */
    public function testGetDataMethod(): void
    {
        $this->assertIsArray($this->data->getData());
    }

    /**
     * @see CoverArray::setData()
     */
    public function testSetDataMethod(): void
    {
        $this->data->get('languages.backend')->setData(new CoverArray([
            2 => 'C++',
            3 => 'C#'
        ]));
        $this->data->get('languages.backend')->setData([
            4 => 'Python',
            5 => 'Ruby'
        ]);

        $this->assertSame(
            ['PHP', 'MySql', 'C++', 'C#', 'Python', 'Ruby'],
            $this->data->get('languages.backend')->getDataAsArray()
        );

        $this->assertEmpty((new NewTypeArray())->setData(null));
        $this->assertEmpty((new NewTypeArray())->setData([]));
    }

    /**
     * @see CoverArray::clear()
     */
    public function testClearMethod(): void
    {
        $this->assertEmpty($this->data->clear());
    }

    // End of testing of methods of class Simple

    // Start testing methods of the CoverArray class

    /**
     * @see CoverArray::setData()
     */
    public function testConstructorOnEmptyValue(): void
    {
        $this->assertEmpty(new NewTypeArray(null));
        $this->assertEmpty(new NewTypeArray());
    }

    /**
     * @return void
     * @see CoverArray::__call()
     */
    public function testCallMagicMethod(): void
    {
        $this->assertInstanceOf(
            CoverArray::class,
            $this->data->get('languages.backend')->reverse()
        );
    }

    /**
     * @return void
     * @see CoverArray::__call()
     */
    public function testCallMagicMethodWithNotExistsMethodOrFunction(): void
    {
        $this->assertInstanceOf(
            CoverArray::class,
            $this->data->get('languages.backend')->reverse()
        );

        $this->expectException(BadMethodCallException::class);
        $this->data->get('languages.backend')->__notExistsMethodOrFunction__();
    }

    /**
     * @return void
     * @see CoverArray::__call()
     */
    /*public function testCallMagicMethodWithArrayFunctionWithoutArrayReturnType(): void
    {
        $this->assertInstanceOf(
            CoverArray::class,
            $this->data->get('languages.backend')->reverse()
        );

        $this->expectException(BadMethodCallException::class);
        $this->data->get('languages.backend')->sum();
    }*/

    /**
     * @see CoverArray::__toString()
     */
    public function testToStringMethod(): void
    {
        $this->assertSame('', (string) $this->data);
    }

    /**
     * @see CoverArray::count()
     */
    public function testCountMethod(): void
    {
        $this->assertCount(4, $this->data);
        $this->assertCount(3, $this->data->get('languages.frontend'));
    }

    /**
     * @see CoverArray::getIterator()
     */
    public function testIsIterable(): void
    {
        $this->assertIsIterable($this->data);
    }

    /**
     * @see CoverArray::offsetSet()
     */
    public function testOffsetSetMethod(): void
    {
        $this->data['workplaces'] = ['Mvideo', 'Svyaznoy'];
        $this->data['pets'] = new NewTypeArray(['cat']);

        $this->assertSame(
            ['Mvideo', 'Svyaznoy'],
            $this->data->get('workplaces')->getDataAsArray()
        );
        $this->assertSame(
            ['cat'],
            $this->data->get('pets')->getDataAsArray()
        );

        $this->assertInstanceOf(NewTypeArray::class, $this->data->get('workplaces'));
        $this->assertInstanceOf(NewTypeArray::class, $this->data->get('pets'));
    }

    /**
     * @see CoverArray::offsetGet()
     */
    public function testOffsetGetMethod(): void
    {
        $this->assertSame('Vasiliy', $this->data['name']);
        $this->assertSame('PHP', $this->data['languages']['backend'][0]);
        $this->assertInstanceOf(NewTypeArray::class, $this->data['languages']['backend']);
        $this->assertInstanceOf(CoverArray::class, $this->data['languages']['backend']);
        $this->assertNull($this->data['nonexistent']);
    }

    /**
     * @see CoverArray::offsetExists()
     */
    public function testOffsetExistsMethod(): void
    {
        $this->assertTrue(isset($this->data['name']));
        $this->assertFalse(isset($this->data['nonexistent']));
    }

    /**
     * @see CoverArray::offsetUnset()
     */
    public function offsetUnset(): void
    {
        unset($this->data['name']);
        $this->assertFalse(isset($this->data['name']));
    }

    /**
     * @see CoverArray::__serialize()
     */
    public function testSerializeMethod(): void
    {
        $this->assertSame(
            'O:33:"Krugozor\Cover\Tests\NewTypeArray":2:{i:0;s:3:"PHP";i:1;s:5:"MySql";}',
            serialize($this->data->get('languages.backend'))
        );
    }

    /**
     * @see CoverArray::__unserialize()
     */
    public function testUnserializeMethod(): void
    {
        $this->assertEquals(
            unserialize('O:33:"Krugozor\Cover\Tests\NewTypeArray":2:{i:0;s:3:"PHP";i:1;s:5:"MySql";}'),
            $this->data->get('languages.backend')
        );
    }

    /**
     * @see CoverArray::getDataAsArray()
     */
    public function testGetDataAsArrayMethod(): void
    {
        $this->assertIsArray($this->data->getDataAsArray());
    }

    /**
     * @see CoverArray::get()
     */
    public function testGetMethod(): void
    {
        $this->assertSame('PHP', $this->data->get('languages.backend.0'));
        $this->assertSame('PHP', $this->data->get('languages.backend')->get('0'));

        $this->assertNull($this->data->get('languages.backend.0.0'));
        $this->assertNull($this->data->get('nonexistent.nonexistent.nonexistent'));
        $this->assertNull($this->data->get('1000.nonexistent.nonexistent.nonexistent'));
        $this->assertNull($this->data->get(''));
    }

    /**
     * @see CoverArray::fromExplode()
     */
    public function testFromExplodeMethod(): void
    {
        $o = NewTypeArray::fromExplode(',', '1,2,3');
        $this->assertInstanceOf(NewTypeArray::class, $o);
        $this->assertSame(['1', '2', '3'], $o->getDataAsArray());

        $o = NewTypeArray::fromExplode(',', '1,2,3', 2);
        $this->assertSame(['1', '2,3'], $o->getDataAsArray());

        $this->expectException(ValueError::class);
        NewTypeArray::fromExplode('', '1,2,3');
    }

    /**
     * @see CoverArray::implode()
     */
    public function testImplodeMethod(): void
    {
        $this->assertSame('PHP, MySql', $this->data->get('languages.backend')->implode(', '));
    }

    public function testInstanceOfSelf(): void
    {
        $this->assertInstanceOf(NewTypeArray::class, $this->data);
        $this->assertInstanceOf(NewTypeArray::class, $this->data->get('languages'));
        $this->assertInstanceOf(NewTypeArray::class, $this->data->get('languages.backend'));
        $this->assertInstanceOf(NewTypeArray::class, $this->data->get('languages.frontend'));

        $this->assertInstanceOf(CoverArray::class, $this->data);
        $this->assertInstanceOf(CoverArray::class, $this->data->get('languages'));
        $this->assertInstanceOf(CoverArray::class, $this->data->get('languages.backend'));
        $this->assertInstanceOf(CoverArray::class, $this->data->get('languages.frontend'));
    }

    // Start testing native php functions for arrays

    /**
     * @see CoverArray::changeKeyCase()
     */
    public function testChangeKeyCaseMethod(): void
    {
        $this->assertSame(
            ['PHP', 'MySql'],
            $this->data->get('languages.backend')->changeKeyCase()->getDataAsArray()
        );

        $this->assertSame(
            ['COUNTRY' => 'Russia', 'REGION' => 'Moscow region', 'CITY' => 'Podolsk', 'STREET' => 'Kirov st.'],
            $this->data->get('address')->changeKeyCase(CASE_UPPER)->getDataAsArray()
        );
    }

    /**
     * @see CoverArray::chunk()
     */
    public function testChunkMethod()
    {
        $this->assertSame(
            [
                0 => [0 => 'Russia', 1 => 'Moscow region'],
                1 => [0 => 'Podolsk', 1 => 'Kirov st.']
            ],
            $this->data->get('address')->chunk(2)->getDataAsArray()
        );

        $this->assertSame(
            [
                0 => ['country' => 'Russia', 'region' => 'Moscow region'],
                1 => ['city' => 'Podolsk', 'street' => 'Kirov st.']
            ],
            $this->data->get('address')->chunk(2, true)->getDataAsArray()
        );

        $this->expectException(ValueError::class);
        $this->assertSame(
            [
                0 => ['country' => 'Russia', 'region' => 'Moscow region'],
                1 => ['city' => 'Podolsk', 'street' => 'Kirov st.']
            ],
            $this->data->get('address')->chunk(0, true)->getDataAsArray()
        );

        $this->assertInstanceOf(
            NewTypeArray::class,
            $this->data->get('address')->chunk(2)
        );
    }

    /**
     * @see CoverArray::column()
     */
    public function testColumnMethod(): void
    {
        $data = (new NewTypeArray())->setData([
            ['id' => 2135, 'first_name' => 'John', 'last_name' => 'Doe'],
            ['id' => 3245, 'first_name' => 'Sally', 'last_name' => 'Smith'],
            ['id' => 5342, 'first_name' => 'Jane', 'last_name' => 'Jones'],
            ['id' => 5623, 'first_name' => 'Peter', 'last_name' => 'Doe']
        ]);

        $this->assertSame(
            ['John', 'Sally', 'Jane', 'Peter'],
            $data->column('first_name')->getDataAsArray()
        );

        $this->assertSame(
            [2135 => 'John', 3245 => 'Sally', 5342 => 'Jane', 5623 => 'Peter'],
            $data->column('first_name', 'id')->getDataAsArray()
        );

        $this->assertInstanceOf(
            NewTypeArray::class,
            $data->column('first_name')
        );
    }

    /**
     * @see CoverArray::combine()
     */
    public function testCombineMethod(): void
    {
        // as array
        $this->assertEquals(
            ['Russia' => 'country', 'Moscow region' => 'region', 'Podolsk' => 'city', 'Kirov st.' => 'street'],
            NewTypeArray::combine(
                $this->data->get('address')->values()->getDataAsArray(),
                $this->data->get('address')->keys()->getDataAsArray(),
            )->getDataAsArray()
        );

        // as cover array
        $this->assertEquals(
            ['Russia' => 'country', 'Moscow region' => 'region', 'Podolsk' => 'city', 'Kirov st.' => 'street'],
            NewTypeArray::combine(
                $this->data->get('address')->values(),
                $this->data->get('address')->keys(),
            )->getDataAsArray()
        );
    }

    /**
     * @see CoverArray::countValues()
     */
    public function testCountValuesMethod(): void
    {
        // as array
        $this->assertEquals(
            ['MySql' => 1, 'PHP' => 1],
            $this->data->get('languages.backend')->countValues()->getDataAsArray()
        );
    }

    /**
     * @see CoverArray::diff()
     */
    public function testDiffMethod(): void
    {
        // as array
        $this->assertEquals(
            [],
            $this->data->get('languages.frontend')->diff(
                ['HTML'],
                ['CSS', 'JavaScript']
            )->getDataAsArray()
        );

        // as cover array
        $this->assertEquals(
            [2 => 'JavaScript'],
            $this->data->get('languages.frontend')->diff(
                new NewTypeArray(['HTML']),
                new CoverArray(['CSS'])
            )->getDataAsArray()
        );
    }

    /**
     * @see CoverArray::diffAssoc()
     */
    public function testDiffAssocMethod(): void
    {
        // as array
        $this->assertEquals(
            ['country' => 'Russia'],
            $this->data->get('address')->diffAssoc([
                'country' => 'another',
                'region' => 'Moscow region',
                'city' => 'Podolsk',
                'street' => 'Kirov st.'
            ], [
                'another' => 'another',
            ])->getDataAsArray()
        );

        // as cover array
        $this->assertEquals(
            ['country' => 'Russia'],
            $this->data->get('address')->diffAssoc(
                new NewTypeArray([
                    'country' => 'another',
                    'region' => 'Moscow region',
                    'city' => 'Podolsk',
                    'street' => 'Kirov st.'
                ]),
                new NewTypeArray([
                    'another' => 'another',
                ])
            )->getDataAsArray()
        );
    }

    /**
     * @see CoverArray::diffKey()
     */
    public function testDiffKeyMethod(): void
    {
        // as array
        $this->assertEquals(
            ['city' => 'Podolsk'],
            $this->data->get('address')->diffKey([
                'country' => 'Russia',
                'region' => 'Moscow region',
            ], [
                'street' => 'Kirov st.'
            ])->getDataAsArray()
        );

        // as cover array
        $this->assertEquals(
            ['city' => 'Podolsk'],
            $this->data->get('address')->diffKey(
                new NewTypeArray([
                    'country' => 'Russia',
                    'region' => 'Moscow region',
                ]),
                new NewTypeArray([
                    'street' => 'Kirov st.'
                ])
            )->getDataAsArray()
        );
    }



    ///
    ///
    ///
    ///
    ///


    /**
     * @see CoverArray::prepend()
     * @see CoverArray::unshift()
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
     * @see CoverArray::append()
     * @see CoverArray::push()
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
     * @see CoverArray::getLast()
     */
    public function testGetLastMethod(): void
    {
        $this->assertSame('MySql', $this->data->get('languages.backend')->getLast());
        $this->assertSame(null, (new NewTypeArray())->getLast());
    }

    /**
     * @see CoverArray::getFirst()
     */
    public function testGetFirstMethod(): void
    {
        $this->assertSame('PHP', $this->data->get('languages.backend')->getFirst());
        $this->assertSame(null, (new NewTypeArray())->getFirst());
    }


    /**
     * @see CoverArray::reverse()
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
     * @see CoverArray::filter()
     */
    public function testFilterMethod(): void
    {
        // pass value as the only argument to callback instead
        $this->assertSame(['PHP'], $this->data->get('languages.backend')->filter(function ($value) {
            return preg_match('~P~', $value);
        })->getDataAsArray());

        $this->assertSame(['backend' => ['PHP', 'MySql']], $this->data->get('languages')->filter(function ($key) {
            return $key === 'backend';
        }, ARRAY_FILTER_USE_KEY)->getDataAsArray());

        // pass both value and key as arguments to callback instead of the value
        $this->assertSame(['backend' => ['PHP', 'MySql']],
            $this->data->get('languages')->filter(function ($value, $key) {
                return $key === 'backend' && $value->in('PHP');
            }, ARRAY_FILTER_USE_BOTH)->getDataAsArray());
    }


    /**
     * @see CoverArray::map()
     */
    public function testMapMethod(): void
    {
        $this->assertSame(
            ['0: PHP', '1: MySql'],
            $this->data->get('languages.backend')->map(
                fn(mixed $value, mixed $key): string => "$key: $value"
            )->getDataAsArray()
        );
    }

    /**
     * @see CoverArray::mapRecursive()
     */
    public function testMapRecursiveMethod(): void
    {
        $this->assertSame(
            ['backend' => ['0: PHP', '1: MySql'], 'frontend' => ['0: HTML', '1: CSS', '2: JavaScript']],
            $this->data->get('languages')->mapRecursive(
                fn(mixed $value, mixed $key): string => "$key: $value"
            )->getDataAsArray()
        );
    }

    /**
     * @see CoverArray::unique()
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
     * @see CoverArray::in()
     */
    public function testInMethod(): void
    {
        $this->assertTrue($this->data->get('birthday')->in(1982, true));
        $this->assertTrue($this->data->get('birthday')->in(1982, false));

        $this->assertTrue($this->data->get('birthday')->in('1982', false));
        $this->assertFalse($this->data->get('birthday')->in('1982', true));
    }
}