<?php

declare(strict_types=1);

namespace Rector\CakePHP\Tests\Rector\Name\ImplicitShortClassNameUseStatementRector;

use Iterator;
use Rector\CakePHP\Rector\Name\ImplicitShortClassNameUseStatementRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

final class ImplicitShortClassNameUseStatementRectorTest extends AbstractRectorTestCase
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
        return ImplicitShortClassNameUseStatementRector::class;
    }
}
