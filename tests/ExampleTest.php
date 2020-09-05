<?php

namespace Nguyentranchung\Rookie\Tests;

use Orchestra\Testbench\TestCase;
use Nguyentranchung\Rookie\RookieServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [RookieServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
