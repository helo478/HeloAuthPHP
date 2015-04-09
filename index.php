<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 4/7/2015
 * Time: 5:49 PM
 */

include_once("app/MysqliFactory.php");

use HeloAuth\Sql\MysqliFactory;

$object = MysqliFactory::create();

echo "Success";