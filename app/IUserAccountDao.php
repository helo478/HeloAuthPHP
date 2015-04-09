<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 4/8/2015
 * Time: 12:26 PM
 */

namespace HeloAuth\Dao;


interface IUserAccountDao {

    function createUserAccount($userName, $passwordHash, $emailAddress, $fname, $lname);
    function logIn($userName, $passwordHash);
    function clearAll();
}