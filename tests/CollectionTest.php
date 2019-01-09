<?php

namespace Platform\Tests;

use Illuminate\Support\Collection;

class CollectionTest extends TestCase
{
    public function test_collect_it_validate()
    {
        $callbackTrue = collect(['foo', 'foo'])->validate(function ($item) {
            return $item === 'foo';
        });
        $callbackFalse = collect(['foo', 'eee'])->validate(function ($item) {
            return $item === 'foo';
        });
        $this->assertTrue($callbackTrue);
        $this->assertFalse($callbackFalse);
        $this->assertTrue(collect(['a@i.com', 'b@i.com'])->validate('email'));
        $this->assertFalse(collect(['a@i.com', 'b'])->validate('email'));
    }

    public function test_collect_it_transpose()
    {
        $collect = collect([
            ['Jane', 'Bob', 'Mary'],
            ['jane@example.com', 'bob@example.com', 'mary@example.com'],
            ['Doctor', 'Plumber', 'Dentist'],
        ])->transpose()->toArray();

        $array = [
            ['Jane', 'jane@example.com', 'Doctor'],
            ['Bob', 'bob@example.com', 'Plumber'],
            ['Mary', 'mary@example.com', 'Dentist'],
        ];

        $this->assertEquals($collect, $array);
    }

    public function test_collect_it_glob()
    {
        $collect = Collection::glob(__DIR__.'/Support/*.php');

        $this->assertEquals(1, $collect->count());
    }

    public function test_collect_it_sectionBy()
    {
        $collect = collect([
            ['name' => 'Lesson 1', 'module' => 'Basics'],
            ['name' => 'Lesson 2', 'module' => 'Basics'],
            ['name' => 'Lesson 3', 'module' => 'Advanced'],
            ['name' => 'Lesson 4', 'module' => 'Advanced'],
            ['name' => 'Lesson 5', 'module' => 'Basics'],
        ])->sectionBy('module')->toArray();

        $array = [
            [
                'Basics',
                [
                    ['name' => 'Lesson 1', 'module' => 'Basics'],
                    ['name' => 'Lesson 2', 'module' => 'Basics'],
                ],
            ],
            [
                'Advanced',
                [
                    ['name' => 'Lesson 3', 'module' => 'Advanced'],
                    ['name' => 'Lesson 4', 'module' => 'Advanced'],
                ],
            ],
            [
                'Basics',
                [
                    ['name' => 'Lesson 5', 'module' => 'Basics'],
                ],
            ],
        ];

        $this->assertEquals($collect, $array);
    }

    public function test_collect_it_filterTree()
    {
        $array = [
            ['id' => 1, 'name' => 'a', 'parent' => 0],
            ['id' => 2, 'name' => 'b', 'parent' => 3],
            ['id' => 3, 'name' => 'c', 'parent' => 1],
        ];

        $filter = [
            [
                'id'       => 1,
                'name'     => 'a',
                'parent'   => 0,
                'children' => [
                    [
                        'id'       => 3,
                        'name'     => 'c',
                        'parent'   => 1,
                        'children' => [
                            ['id' => 2, 'name' => 'b', 'parent' => 3],
                        ],
                    ],
                ],
            ],
        ];

        $collect = collect($array)->filterTree()->toArray();

        $this->assertEquals($collect, $filter);
    }

    public function test_collect_it_formatMenu()
    {
        $array = [
            [
                'id'       => 1,
                'path'     => 'a',
                'children' => [
                    ['id' => 2, 'path' => 'b'],
                    ['id' => 3, 'path' => 'c'],
                ],
            ],
        ];

        $format = [
            [
                'id'       => 1,
                'path'     => '/a',
                'children' => [
                    ['id' => 2, 'path' => '/a/b'],
                    ['id' => 3, 'path' => '/a/c'],
                ],
            ],
        ];

        $collect = collect($array)->formatMenu()->toArray();

        $this->assertEquals($collect, $format);
    }

    public function test_collect_it_filterMenu()
    {
        $list  = ['a', 'b'];
        $array = [
            [
                'id'       => 1,
                'list'     => 'a',
                'children' => [
                    [
                        'id'   => 2,
                        'list' => 'c',
                    ],
                    [
                        'id' => 3,
                    ],
                ],
            ],
            [
                'id' => 4,
            ],
            [
                'id'       => 5,
                'children' => [
                    [
                        'id'   => 6,
                        'list' => 'v',
                    ],
                ],
            ],
            [
                'id'       => 7,
                'children' => [
                    [
                        'id' => 8,
                    ],
                ],
            ],
        ];

        $filter = [
            [
                'id'       => 1,
                'list'     => 'a',
                'children' => [
                    [
                        'id' => 3,
                    ],
                ],
            ],
            [
                'id'       => 7,
                'children' => [
                    [
                        'id' => 8,
                    ],
                ],
            ],
        ];

        $collect = collect($array)->filterMenu($list, 'list')->values()->toArray();

        $this->assertEquals($collect, $filter);
    }
}
