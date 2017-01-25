<?php

namespace Tests\Fei\Service\Filer\Entity;

use Codeception\Test\Unit;
use Fei\Service\Filer\Entity\Backend;

/**
 * Class BackendTest
 *
 * @package Tests\Fei\Service\Filer\Entity
 */
class BackendTest extends Unit
{
    public function testNameAccessors()
    {
        $backend = new Backend();
        $backend->setName('test');

        $this->assertEquals('test', $backend->getName());
        $this->assertAttributeEquals('test', 'name', $backend);
    }

    public function testCategoriesAccessors()
    {
        $backend = new Backend();
        $backend->setCategories([1, 2, 3]);

        $this->assertEquals([1, 2, 3], $backend->getCategories());
        $this->assertAttributeEquals([1, 2, 3], 'categories', $backend);
    }

    public function testDriverAccessors()
    {
        $backend = new Backend();
        $backend->setDriver('fake-driver');

        $this->assertEquals('fake-driver', $backend->getDriver());
        $this->assertAttributeEquals('fake-driver', 'driver', $backend);
    }

    public function testHostAccessors()
    {
        $backend = new Backend();
        $backend->setHost('http://localhost');

        $this->assertEquals('http://localhost', $backend->getHost());
        $this->assertAttributeEquals($backend->getHost(), 'host', $backend);
    }

    public function testPortAccessors()
    {
        $backend = new Backend();
        $backend->setPort(12345);

        $this->assertEquals(12345, $backend->getPort());
        $this->assertAttributeEquals($backend->getPort(), 'port', $backend);
    }

    public function testDbnameAccessors()
    {
        $backend = new Backend();
        $backend->setDbname('filer');

        $this->assertEquals('filer', $backend->getDbname());
        $this->assertAttributeEquals($backend->getDbname(), 'dbname', $backend);
    }

    public function testUserAccessors()
    {
        $backend = new Backend();
        $backend->setUser('root');

        $this->assertEquals('root', $backend->getUser());
        $this->assertAttributeEquals($backend->getUser(), 'user', $backend);
    }

    public function testPasswordAccessors()
    {
        $backend = new Backend();
        $backend->setPassword('toor');

        $this->assertEquals('toor', $backend->getPassword());
        $this->assertAttributeEquals($backend->getPassword(), 'password', $backend);
    }
}
