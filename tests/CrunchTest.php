<?php

namespace GromNaN\JsonCrunch\Tests;

use PHPUnit\Framework\TestCase;
use function GromNaN\JsonCrunch\{crunch, uncrunch};

class CrunchTest extends TestCase
{

    public function getData()
    {
        yield [
            'null primitive',
            null,
            [null],
        ];

        yield [
            'number primitive',
            0,
            [0],
        ];

        yield [
            'boolean primitive',
            true,
            [true],
        ];

        yield [
            'string primitive',
            "string",
            ["string"],
        ];

        yield [
            'empty array',
            [],
            [[]],
        ];

        yield [
            'single-item array',
            [null],
            [null, [0]],
        ];

        yield [
            'multi-primitive all distinct array',
            [null, 0, true, "string"],
            [null, 0, true, "string", [0, 1, 2, 3]],
        ];

        yield [
            'multi-primitive repeated array',
            [true, true, true, true],
            [true, [0, 0, 0, 0]],
        ];

        yield [
            'one-level nested array',
            [[1,2,3]],
            [1, 2, 3, [0, 1, 2], [3]],
        ];

        yield [
            'two-level nested array',
            [[[1,2,3]]],
            [1, 2, 3, [0, 1, 2], [3], [4]],
        ];

        yield [
            'empty object',
            new \stdClass,
            [new \stdClass],
        ];

        yield [
            'single-item object',
            ['a' => null],
            [null, ['a' => 0]],
        ];

        yield [
            'multi-item all distinct object',
            ['a' => null, 'b' => 0, 'c' => true, 'd' => "string"],
            [null, 0, true, "string", ['a' => 0, 'b' => 1, 'c' => 2, 'd' => 3]],
        ];

        yield [
            'multi-item repeated object',
            ['a' => true, 'b' => true, 'c' => true, 'd' => true],
            [true, ['a' => 0, 'b' => 0, 'c' => 0, 'd' => 0]],
        ];

        yield [
            'complex array',
            [['a' => true, 'b' => [1, 2, 3]], [1,2,3]],
            [true, 1, 2, 3, [1, 2, 3], ['a' => 0, 'b' => 4], [5, 4]],
        ];

        yield [
            'complex object',
            ['a' => true, 'b' => [1, 2, 3], 'c' => ['a' => true, 'b' => [1,2,3]]],
            [true, 1, 2, 3, [1, 2, 3], ['a' => 0, 'b' => 4], ['a' => 0, 'b' => 4, 'c' => 5]],
        ];
    }

    /**
     * @dataProvider getData
     */
    public function testCrunch($description, $uncrunched, $crunched)
    {
        $this->assertEquals($crunched, crunch($uncrunched));
    }

    /**
     * @dataProvider getData
     */
    public function testUncrunch($description, $uncrunched, $crunched)
    {
        $this->assertEquals($uncrunched, uncrunch($crunched));
    }
}
