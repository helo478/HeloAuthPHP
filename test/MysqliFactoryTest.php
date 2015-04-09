<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 4/7/2015
 * Time: 2:03 PM
 */

namespace HeloAuth\Sql;

include_once("app/MysqliFactory.php");

use PHPUnit_Framework_TestCase;

class MysqliFactoryTest extends PHPUnit_Framework_TestCase {

    public function testCreate_shouldReturnValidMysqli()
    {
        $actual = MysqliFactory::create();
        $expected = 'mysqli';

        $this->assertNotNull($actual);
        $this->assertInstanceOf($expected, $actual, "The returned object should be of type mysqli");
    }

}
