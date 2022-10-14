<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function getSaveFilesDirectory()
    {
        return __DIR__;
    }

    protected function getSaveFilePath(string $save)
    {
        return $this->getSaveFilesDirectory() . '/Files/saves/' . $save;
    }
}
