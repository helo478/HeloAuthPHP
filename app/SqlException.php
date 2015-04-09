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
 * Time: 1:25 PM
 */

namespace HeloAuth\Sql;


use Exception;

class SqlException extends Exception {

    public function __construct($message, $code) {
        parent::__construct($message, $code);
    }
}