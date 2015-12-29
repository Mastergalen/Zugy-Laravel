<?php

class FilePermissionsTest extends TestCase
{
    public function testProductImageUpload()
    {
        $path = public_path() . '/uploads';

        $this->assertTrue(is_writable($path));
    }

    public function testBootstrapCache()
    {
        $path = base_path() . '/bootstrap/cache';

        $this->assertTrue(is_writable($path));
    }

    public function testStorage()
    {
        $path = storage_path();

        $this->assertTrue(is_writable($path));
    }
}