<?php

namespace NgakakSeruTest\Application;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateApplication()
    {
        $factory = new \NgakakSeru\Application\Factory();
        $this->assertInstanceOf('Silex\Application', $factory->createApplication());
    }

    public function testApplication()
    {
        $factory = new \NgakakSeru\Application\Factory();
        $app     = $factory->createApplication();

        $this->assertNotEmpty($app['config']);
    }
}
