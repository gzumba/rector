<?php

declare(strict_types=1);

namespace Rector\Php74\Tests\Rector\Assign\NullCoalescingOperatorRector;

use Iterator;
use Rector\Php74\Rector\Assign\NullCoalescingOperatorRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

final class NullCoalescingOperatorRectorTest extends AbstractRectorTestCase
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
        return NullCoalescingOperatorRector::class;
    }
}
