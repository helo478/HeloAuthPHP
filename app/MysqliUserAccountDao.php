<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 4/8/2015
 * Time: 12:26 PM
 */

namespace HeloAuth\Dao;


use HeloAuth\Sql\MysqliFactory;

class MysqliUserAccountDao implements IUserAccountDao {

    function createUserAccount($userName, $passwordHash, $emailAddress, $fname='', $lname='')
    {
        $mysqli = MysqliFactory::create();

        $sql = "
            INSERT INTO `user_accounts`
            (`user_name`, `password_hash`, `email_address`, `fname`, `lname`)
            VALUES (?, ?, ?, ?, ?)
        ";

        $stmt = $mysqli->prepare($sql);
        if (!$stmt)
        {
            die('Prepared statement for createUser() failed: '
                . $mysqli->error);
        }

        $stmt->bind_param("sssss",
            $userName, $passwordHash, $emailAddress, $fname, $lname);

        $result = $stmt->execute();

        $mysqli->close();

        return $result;
    }

    function logIn($userName, $passwordHash)
    {
        $mysqli = MysqliFactory::create();

        $sql = "
            SELECT password_hash FROM `user_accounts` WHERE `user_name` = ?
        ";

        $stmt = $mysqli->prepare($sql);
        if (!$stmt)
        {
            die('Prepared statement for logIn() failed: ' .
                $mysqli->error);
        }

        $stmt->bind_param("s", $userName);

        $result = $stmt->execute();
        if (!$result) // If the user name was not found
        {
            return 0;
        }

        $persistedPasswordHash = $stmt->fetch();

        $mysqli->close();

        return $passwordHash == $persistedPasswordHash;
    }

    function clearAll()
    {
        $mysqli = MysqliFactory::create();

        $sql = "DELETE FROM `user_accounts`";
        $mysqli->query($sql);

        $mysqli->close();
    }
}