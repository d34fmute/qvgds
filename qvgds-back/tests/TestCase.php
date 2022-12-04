<?php

namespace QVGDS\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\HasApiTokens;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, HasApiTokens;
}
