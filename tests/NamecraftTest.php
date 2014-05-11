<?php

use Mcprohosting\Namecraft\Namecraft;

class NamecraftTest extends PHPUnit_Framework_TestCase
{

    public function testAddsList()
    {
        $nc = new Namecraft;
        $array = array('foo' => 'bar');

        $nc->addList($array);

        $lists = $nc->lists;

        $this->assertInternalType('array', $lists);
        $this->assertEquals(1, count($lists));
        $this->assertEquals($array, $lists[0]);
    }

    public function testLoadsDefaultLists()
    {
        $nc = new Namecraft;

        $lists = $nc->getLists();

        $this->assertInternalType('array', $lists);
        $this->assertEquals(2, count($lists));
        $this->assertInternalType('array', $lists[0]);
    }

    public function testGeneratesCamelCase()
    {
        $nc = new Namecraft;
        $array = array('Bar');

        $nc->addList($array);
        $nc->addList($array);

        $this->assertEquals('BarBar', $nc->generate('CamelCase'));
    }

    public function testGeneratesDash()
    {
        $nc = new Namecraft;
        $array = array('Bar');

        $nc->addList($array);
        $nc->addList($array);

        $this->assertEquals('bar-bar', $nc->generate('Dash'));
    }

    public function testGeneratesUnderscore()
    {
        $nc = new Namecraft;
        $array = array('Bar');

        $nc->addList($array);
        $nc->addList($array);

        $this->assertEquals('bar_bar', $nc->generate('Underscore'));
    }
} 
