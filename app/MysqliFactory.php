<?php

/**
 * This file is part of HeloAuthPHP.
 *
 * HeloAuthPHP is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.

 * HeloAuthPHP is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 *     along with HeloAuthPHP.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Created by PhpStorm.
 * User: Donald Subert
 * Date: 4/7/2015
 * Time: 1:11 PM
 */

namespace HeloAuth\Sql;


use Exception;
use InvalidArgumentException;
use mysqli;

class MysqliFactory {

    const PATH = "db-properties.ini";

    const PRP_HOST = "host";
    const PRP_USER_NAME = "userName";
    const PRP_PASSWORD = "password";
    const PRP_DATABASE = "database";

    /**
     * create
     *
     * creates an instance of a mysqli object, configured by the db-properties.ini properties file
     *
     * @throws SqlException if there is a problem creating the mysqli object
     * @throws InvalidArgumentException if there
     */
    public static function create()
    {
        $dbProperties = parse_ini_file(MysqliFactory::PATH);
        if (!$dbProperties)
        {
            throw new Exception("Unable to resolve " . MysqliFactory::PATH);
        }

        if (!empty($dbProperties[MysqliFactory::PRP_HOST])
            && !empty($dbProperties[MysqliFactory::PRP_USER_NAME])
            && !empty($dbProperties[MysqliFactory::PRP_PASSWORD])
            && !empty($dbProperties[MysqliFactory::PRP_DATABASE]))
        {
            $host = $dbProperties[MysqliFactory::PRP_HOST];
            $userName = $dbProperties[MysqliFactory::PRP_USER_NAME];
            $password = $dbProperties[MysqliFactory::PRP_PASSWORD];
            $database = $dbProperties[MysqliFactory::PRP_DATABASE];

            $mysqli = new \mysqli($host, $userName, $password, $database);
            if (!$mysqli)
            {
                throw new SqlException($mysqli->error, $mysqli->errno);
            }

            return $mysqli;
        }
        else{
            throw new InvalidArgumentException();
        }
    }
}