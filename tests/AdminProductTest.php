<?php

class AdminProductTest extends TestCase
{

    public function testIndexProductView()
    {
        $this->visit('admin/catalogue');
    }

    public function testAddProductView()
    {
        $this->visit('admin/catalogue/create');
    }
}