<?php

declare(strict_types=1);

namespace Rector\CodeQuality\Tests\Rector\If_\ConsecutiveNullCompareReturnsToNullCoalesceQueueRector;

use Iterator;
use Rector\CodeQuality\Rector\If_\ConsecutiveNullCompareReturnsToNullCoalesceQueueRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

final class ConsecutiveNullCompareReturnsToNullCoalesceQueueRectorTest extends AbstractRectorTestCase
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
        return ConsecutiveNullCompareReturnsToNullCoalesceQueueRector::class;
    }
}
