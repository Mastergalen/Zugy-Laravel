<?php

class AdminOrdersTest extends TestCase
{
    public function testOrdersIndex()
    {
        $this->visit('admin/order');
    }
}