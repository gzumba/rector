<?php

declare(strict_types=1);

namespace Rector\StrictCodeQuality\Tests\Rector\Stmt\VarInlineAnnotationToAssertRector;

use Iterator;
use Rector\StrictCodeQuality\Rector\Stmt\VarInlineAnnotationToAssertRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

final class VarInlineAnnotationToAssertRectorTest extends AbstractRectorTestCase
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
        return VarInlineAnnotationToAssertRector::class;
    }
}
