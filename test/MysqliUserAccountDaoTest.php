<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 4/8/2015
 * Time: 12:38 PM
 */


namespace HeloAuth\Dao;

require_once("app/IUserAccountDao.php");
require_once("app/MysqliUserAccountDao.php");

use HeloAuth\Sql\MysqliFactory;

class MysqliUserAccountDaoTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var MysqliUserAccountDao
     */
    private $dao;

    private $table = 'user_accounts';

    private $userName1 = "Hankinator";
    private $emailAddress1 = "hankinator@vmail.com";
    private $fname1 = "Hank";
    private $lname1 = "Venture";
    private $passwordHash1 = "ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEF";

    private $userName2 = "Brockpocalypse";
    private $passwordHash2 = "qwertyuiopasdfghjklzxcvbnm";
    private $emailAddress2 = "brockpocalypsenow@vmail.com";
    private $fname2 = "Brock";
    private $lname2 = "Samson";


    function setUp()
    {
        $this->dao = new MysqliUserAccountDao();
        $this->dao->clearAll();
    }

    function tearDown()
    {
        $this->dao = new MysqliUserAccountDao();
        $this->dao->clearAll();
    }

    function testConstructor_shouldNotError()
    {
        $this->dao = new MysqliUserAccountDao();
    }

    function testCreateUser_shouldAddARowToTable()
    {
        $this->dao->createUserAccount($this->userName1, $this->passwordHash1, $this->emailAddress1, $this->fname1,
            $this->lname1);

        $expected = 1;
        $actual = $this->_getRowCount();
        $message = "Calling createUserAccount with a valid userName, passwordHash,
            emailAddress, fname, and lname should result in a new row in the table";

        $this->assertEquals($expected, $actual, $message);
    }

    function testCreateUser_shouldReturnTrue()
    {
        $actual = $this->dao->createUserAccount($this->userName1, $this->passwordHash1, $this->emailAddress1,
            $this->fname1, $this->lname1);
        $message = "Calling createUserAccount with a valid userName, passwordHash,
            emailAddress, fname, and lname, should return true";

        $this->assertTrue($actual, $message);
    }

    function testCreateUser_2NewUsers_shouldReturnTrue()
    {
        $this->dao->createUserAccount($this->userName1, $this->passwordHash1, $this->emailAddress1, $this->fname1,
            $this->lname1);

        $actual = $this->dao->createUserAccount($this->userName2, $this->passwordHash2, $this->emailAddress2,
            $this->fname2, $this->lname2);
        $message = "As long as userName, and emailAddress are unique, calling createUserAccount
            for a second time should return true";

        $this->assertTrue($actual, $message);
    }

    function testCreateUser_2NewUsers_shouldAdd2RowsToTable()
    {
        $this->dao->createUserAccount($this->userName1, $this->passwordHash1, $this->emailAddress1, $this->fname1,
            $this->lname1);
        $this->dao->createUserAccount($this->userName2, $this->passwordHash2, $this->emailAddress2,
            $this->fname2, $this->lname2);

        $expected = 2;
        $actual = $this->_getRowCount($this->table);
        $message = "As long as userName, and emailAddress are unique, calling createUserAccount
            for a second time should add another row to the table";

        $this->assertEquals($expected, $actual, $message);
    }

    function testCreateUser_duplicateUserName_shouldReturnFalse()
    {
        $this->dao->createUserAccount($this->userName1, $this->passwordHash1, $this->fname1,
            $this->lname1, $this->emailAddress1);

        $actual = $this->dao->createUserAccount($this->userName1, $this->passwordHash2, $this->emailAddress2,
            $this->fname2,  $this->lname2);
        $message = "If createUserAccount is called with a userName that is already in the table,
            should return false";

        $this->assertFalse($actual, $message);
    }

    function testCreateUser_duplicatePasswordHash_shouldReturnTrue()
    {
        $this->dao->createUserAccount($this->userName1, $this->passwordHash1, $this->fname1,
            $this->lname1, $this->emailAddress1);

        $actual = $this->dao->createUserAccount($this->userName2, $this->passwordHash1, $this->emailAddress2,
            $this->fname2,  $this->lname2);
        $message = "If createUserAccount is called with a passwordHash that is already in the table,
            but otherwise unique column values, should return true";

        $this->assertTrue($actual, $message);
    }

    function testCreateUser_duplicateEmailAddress_shouldReturnFalse()
    {
        $this->dao->createUserAccount($this->userName1, $this->passwordHash1, $this->emailAddress1, $this->fname1,
            $this->lname1);

        $actual = $this->dao->createUserAccount($this->userName2, $this->passwordHash2, $this->emailAddress1,
            $this->fname2,  $this->lname2);
        $message = "If createUserAccount is called with an emailAddress that is already in the table,
            should return false";

        $this->assertFalse($actual, $message);
    }

    function testCreateUser_duplicatefname_shouldReturnTrue()
    {
        $this->dao->createUserAccount($this->userName1, $this->passwordHash1, $this->fname1,
            $this->lname1, $this->emailAddress1);

        $actual = $this->dao->createUserAccount($this->userName2, $this->passwordHash2, $this->emailAddress2,
            $this->fname1,  $this->lname2);
        $message = "If createUserAccount is called with an fname that is already in the table,
            but otherwise unique column values, should return true";

        $this->assertTrue($actual, $message);
    }

    function testCreateUser_duplicatelname_shouldReturnTrue()
    {
        $this->dao->createUserAccount($this->userName1, $this->passwordHash1, $this->fname1,
            $this->lname1, $this->emailAddress1);

        $actual = $this->dao->createUserAccount($this->userName2, $this->passwordHash2, $this->emailAddress2,
            $this->fname2,  $this->lname1);
        $message = "If createUserAccount is called with an lname that is already in the table,
            but otherwise unique column values, should return true";

        $this->assertTrue($actual, $message);
    }

    function testClearAll_tableShouldHave0Rows()
    {
        $this->dao->createUserAccount($this->userName1, $this->passwordHash1, $this->fname1,
            $this->lname1, $this->emailAddress1);
        $this->dao->clearAll();

        $expected = 0;
        $actual = $this->_getRowCount();
        $message = "Calling clearAll should remove all rows from the table";

        $this->assertEquals($expected, $actual, $message);
    }

    private function _getRowCount()
    {
        $mysqli = MysqliFactory::create();
        $sql = "SELECT COUNT(*) FROM $this->table";
        $result = $mysqli->query($sql);
        $rowCount = $result->fetch_array()[0];
        $mysqli->close();
        return $rowCount;
    }
}
