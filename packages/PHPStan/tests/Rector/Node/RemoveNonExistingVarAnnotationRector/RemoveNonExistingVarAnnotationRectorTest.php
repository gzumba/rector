<?php

declare(strict_types=1);

namespace Rector\PHPStan\Tests\Rector\Node\RemoveNonExistingVarAnnotationRector;

use Iterator;
use Rector\PHPStan\Rector\Node\RemoveNonExistingVarAnnotationRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

final class RemoveNonExistingVarAnnotationRectorTest extends AbstractRectorTestCase
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
        return RemoveNonExistingVarAnnotationRector::class;
    }
}
