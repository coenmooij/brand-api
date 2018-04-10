<?php

namespace CoenMooij\BrandApi\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase;

abstract class AbstractFunctionalTest extends TestCase
{
    use CreatesApplicationTrait, DatabaseMigrations;
}
