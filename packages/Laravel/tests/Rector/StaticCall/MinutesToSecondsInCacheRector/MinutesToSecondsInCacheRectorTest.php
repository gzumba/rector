<?php

declare(strict_types=1);

namespace Rector\Laravel\Tests\Rector\StaticCall\MinutesToSecondsInCacheRector;

use Iterator;
use Rector\Laravel\Rector\StaticCall\MinutesToSecondsInCacheRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

final class MinutesToSecondsInCacheRectorTest extends AbstractRectorTestCase
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

    protected function getRectorClass(): string
    {
        return MinutesToSecondsInCacheRector::class;
    }
}
