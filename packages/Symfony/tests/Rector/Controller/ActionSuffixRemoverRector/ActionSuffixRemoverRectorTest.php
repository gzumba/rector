<?php

declare(strict_types=1);

namespace Rector\Symfony\Tests\Rector\Controller\ActionSuffixRemoverRector;

use Iterator;
use Rector\Symfony\Rector\Controller\ActionSuffixRemoverRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

final class ActionSuffixRemoverRectorTest extends AbstractRectorTestCase
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
        return ActionSuffixRemoverRector::class;
    }
}
