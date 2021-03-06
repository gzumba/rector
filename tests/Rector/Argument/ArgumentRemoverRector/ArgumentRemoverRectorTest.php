<?php

declare(strict_types=1);

namespace Rector\Tests\Rector\Argument\ArgumentRemoverRector;

use Iterator;
use Rector\Rector\Argument\ArgumentRemoverRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Tests\Rector\Argument\ArgumentRemoverRector\Source\Persister;
use Rector\Tests\Rector\Argument\ArgumentRemoverRector\Source\RemoveInTheMiddle;
use Symfony\Component\Yaml\Yaml;

final class ArgumentRemoverRectorTest extends AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(string $file): void
    {
        $this->doTestFile($file);
    }

    public function provideData(): Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }

    /**
     * @return mixed[]
     */
    protected function getRectorsWithConfiguration(): array
    {
        return [
            ArgumentRemoverRector::class =>
            [
                '$positionsByMethodNameByClassType' => [
                    Persister::class => [
                        'getSelectJoinColumnSQL' => [
                            4 => null,
                        ],
                    ],
                    Yaml::class => [
                        'parse' => [
                            1 => ['Symfony\Component\Yaml\Yaml::PARSE_KEYS_AS_STRINGS', 'hey', 55, 5.5],
                        ],
                    ],
                    RemoveInTheMiddle::class => [
                        'run' => [
                            1 => [
                                'name' => 'second',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
