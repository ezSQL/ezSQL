<?php

require_once 'shared/ez_sql_core.php';

require 'vendor/autoload.php';
use PHPUnit\Framework\TestCase;

/**
 * Test class for ezSQL_pdo.
 * Generated by PHPUnit on 2012-04-02 at 00:23:22.
 */

/**
 * Test class for ezSQL_pdo.
 * Generated by PHPUnit
 *
 * Needs database tear up to run test, that creates database and a user with
 * appropriate rights.
 * Run database tear down after tests to get rid of the database and the user.
 * The PDO tests where done with a PostgreSQL database, please use the scripts
 * of PostgreSQL
 *
 * @author  Stefanie Janine Stoelting <mail@stefanie-stoelting.de>
 * @name    ezSQL_pdoTest
 * @uses    postgresql_test_db_tear_up.sql
 * @uses    postgresql_test_db_tear_down.sql
 * @uses    mysql_test_db_tear_up.sql
 * @uses    mysql_test_db_tear_down.sql
 * @uses    ez_test.sqlite
 * @package ezSQL
 * @subpackage unitTests
 * @license FREE / Donation (LGPL - You may do what you like with ezSQL - no exceptions.)
 */
class ezSQL_pdoTest extends TestCase {

    /**
     * constant string user name
     */
    const TEST_DB_USER = 'ez_test';

    /**
     * constant string password
     */
    const TEST_DB_PASSWORD = 'ezTest';

    /**
     * constant string database name
     */
    const TEST_DB_NAME = 'ez_test';

    /**
     * constant string database host
     */
    const TEST_DB_HOST = 'localhost';

    /**
     * constant string database connection charset
     */
    const TEST_DB_CHARSET = 'utf8';

    /**
     * constant string database port
     */
    const TEST_DB_PORT = '5432';
    
    /**
     * constant string path and file name of the SQLite test database
     */
    const TEST_SQLITE_DB = 'tests/pdo/ez_test.sqlite';

    /**
     * @var ezSQL_pdo
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        if (!extension_loaded('pdo_mysql')) {
            $this->markTestSkipped(
              'The pdo_mysql Lib is not available.'
            );
        }
        if (!extension_loaded('pdo_pgsql')) {
            $this->markTestSkipped(
              'The pdo_pgsql Lib is not available.'
            );
        }
        if (!extension_loaded('pdo_sqlite')) {
            $this->markTestSkipped(
              'The pdo_sqlite Lib is not available.'
            );
        }
        require_once 'pdo/ez_sql_pdo.php';
        $this->object = new ezSQL_pdo;
    } // setUp

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        $this->object = null;
    } // tearDown
    
    /**
     * @covers ezSQL_pdo::connect
     */
    public function testPosgreSQLConnect() {
        $this->assertTrue($this->object->connect('pgsql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));
    } // testPosgreSQLConnect

    /**
     * @covers ezSQL_pdo::quick_connect
     */
    public function testPosgreSQLQuick_connect() {
        $this->assertTrue($this->object->quick_connect('pgsql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));
    } // testPosgreSQLQuick_connect

    /**
     * @covers ezSQL_pdo::select
     */
    public function testPosgreSQLSelect() {
        $this->assertTrue($this->object->select('pgsql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));
    } // testPosgreSQLSelect

    /**
     * @covers ezSQL_pdo::escape
     */
    public function testPosgreSQLEscape() {
        $this->assertTrue($this->object->connect('pgsql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));

        $result = $this->object->escape("This is'nt escaped.");

        $this->assertEquals("This is''nt escaped.", $result);
    } // testPosgreSQLEscape

    /**
     * @covers ezSQL_pdo::sysdate
     */
    public function testPosgreSQLSysdate() {
        $this->assertEquals("datetime('now')", $this->object->sysdate());
    } // testPosgreSQLSysdate

    /**
     * @covers ezSQL_pdo::catch_error
     */
    public function testPosgreSQLCatch_error() {
        $this->assertTrue($this->object->connect('pgsql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));

        $this->assertNull($this->object->catch_error());
    } // testPosgreSQLCatch_error

    /**
     * @covers ezSQL_pdo::query
     */
    public function testPosgreSQLQuery() {
        $this->assertTrue($this->object->connect('pgsql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));

        $this->assertEquals(0, $this->object->query('CREATE TABLE unit_test(id integer, test_key varchar(50), PRIMARY KEY (ID))'));

        $this->assertEquals(0, $this->object->query('DROP TABLE unit_test'));
    } // testPosgreSQLQuery

    /**
     * @covers ezSQL_pdo::disconnect
     */
    public function testPosgreSQLDisconnect() {
        $this->assertTrue($this->object->connect('pgsql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));

        $this->object->disconnect();

        $this->assertTrue(true);
    } // testPosgreSQLDisconnect

    /**
     * @covers ezSQL_pdo::get_set
     */
    public function testPostgreSQLGet_set() {
        $expected = "test_var1 = '1', test_var2 = 'ezSQL test', test_var3 = 'This is''nt escaped.'";
        
        $params = array(
            'test_var1' => 1,
            'test_var2' => 'ezSQL test',
            'test_var3' => "This is'nt escaped."
        );
        
        $this->assertTrue($this->object->connect('pgsql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));

        $this->assertequals($expected, $this->object->get_set($params));
    } // testPostgreSQLGet_set
     
    /**
     * Here starts the MySQL PDO unit test
     */

    /**
     * @covers ezSQL_pdo::connect
     */
    public function testMySQLConnect() {
        $this->assertTrue($this->object->connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));
    } // testMySQLConnect

    /**
     * @covers ezSQL_pdo::quick_connect
     */
    public function testMySQLQuick_connect() {
        $this->assertTrue($this->object->quick_connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));
    } // testMySQLQuick_connect

    /**
     * @covers ezSQL_pdo::select
     */
    public function testMySQLSelect() {
        $this->assertTrue($this->object->select('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));
    } // testMySQLSelect

    /**
     * @covers ezSQL_pdo::escape
     */
    public function testMySQLEscape() {
        $this->assertTrue($this->object->connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));

        $result = $this->object->escape("This is'nt escaped.");

        $this->assertEquals("This is\'nt escaped.", $result);
    } // testMySQLEscape

    /**
     * @covers ezSQL_pdo::sysdate
     */
    public function testMySQLSysdate() {
        $this->assertEquals("datetime('now')", $this->object->sysdate());
    } // testMySQLSysdate

    /**
     * @covers ezSQL_pdo::catch_error
     */
    public function testMySQLCatch_error() {
        $this->assertTrue($this->object->connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));

        $this->assertNull($this->object->catch_error());
    } // testMySQLCatch_error

    /**
     * @covers ezSQL_pdo::query
     */
    public function testMySQLQuery() {
        $this->assertTrue($this->object->connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));

        $this->assertEquals(0, $this->object->query('CREATE TABLE unit_test(id integer, test_key varchar(50), PRIMARY KEY (ID))'));

        $this->assertEquals(0, $this->object->query('DROP TABLE unit_test'));
    } // testMySQLQuery

    /**
     * @covers ezSQL_pdo::disconnect
     */
    public function testMySQLDisconnect() {
        $this->assertTrue($this->object->connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));

        $this->object->disconnect();

        $this->assertTrue(true);
    } // testMySQLDisconnect

    /**
     * @covers ezSQL_pdo::connect
     */
    public function testMySQLConnectWithOptions() {
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );         
        
        $this->assertTrue($this->object->connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD, $options));
    } // testMySQLConnectWithOptions

    /**
     * @covers ezSQL_pdo::get_set
     */
    public function testMySQLGet_set() {
        $expected = "test_var1 = '1', test_var2 = 'ezSQL test', test_var3 = 'This is\'nt escaped.'";
        
        $params = array(
            'test_var1' => 1,
            'test_var2' => 'ezSQL test',
            'test_var3' => "This is'nt escaped."
        );
        
        $this->assertTrue($this->object->connect('mysql:host=' . self::TEST_DB_HOST . ';dbname=' . self::TEST_DB_NAME . ';port=' . self::TEST_DB_PORT, self::TEST_DB_USER, self::TEST_DB_PASSWORD));

        $this->assertequals($expected, $this->object->get_set($params));
    } // testMySQLGet_set
     
    /**
     * Here starts the SQLite PDO unit test
     */

    /**
     * @covers ezSQL_pdo::connect
     */
    public function testSQLiteConnect() {
        $this->assertTrue($this->object->connect('sqlite:' . self::TEST_SQLITE_DB, '', '', array(), true));
    } // testSQLiteConnect

    /**
     * @covers ezSQL_pdo::quick_connect
     */
    public function testSQLiteQuick_connect() {
        $this->assertTrue($this->object->quick_connect('sqlite:' . self::TEST_SQLITE_DB, '', '', array(), true));
    } // testSQLiteQuick_connect

    /**
     * @covers ezSQL_pdo::select
     */
    public function testSQLiteSelect() {
        $this->assertTrue($this->object->select('sqlite:' . self::TEST_SQLITE_DB, '', '', array(), true));
    } // testSQLiteSelect

    /**
     * @covers ezSQL_pdo::escape
     */
    public function testSQLiteEscape() {
        $this->assertTrue($this->object->connect('sqlite:' . self::TEST_SQLITE_DB, '', '', array(), true));

        $result = $this->object->escape("This is'nt escaped.");

        $this->assertEquals("This is''nt escaped.", $result);
    } // testSQLiteEscape

    /**
     * @covers ezSQL_pdo::sysdate
     */
    public function testSQLiteSysdate() {
        $this->assertEquals("datetime('now')", $this->object->sysdate());
    } // testSQLiteSysdate

    /**
     * @covers ezSQL_pdo::catch_error
     */
    public function testSQLiteCatch_error() {
        $this->assertTrue($this->object->connect('sqlite:' . self::TEST_SQLITE_DB, '', '', array(), true));

        $this->assertNull($this->object->catch_error());
    } // testSQLiteCatch_error

    /**
     * @covers ezSQL_pdo::query
     */
    public function testSQLiteQuery() {
        $this->assertTrue($this->object->connect('sqlite:' . self::TEST_SQLITE_DB, '', '', array(), true));

        $this->assertEquals(0, $this->object->query('CREATE TABLE unit_test(id integer, test_key varchar(50), PRIMARY KEY (ID))'));

        $this->assertEquals(0, $this->object->query('DROP TABLE unit_test'));
    } // testSQLiteQuery

    /**
     * @covers ezSQL_pdo::disconnect
     */
    public function testSQLiteDisconnect() {
        $this->assertTrue($this->object->connect('sqlite:' . self::TEST_SQLITE_DB, '', '', array(), true));

        $this->object->disconnect();

        $this->assertTrue(true);
    } // testSQLiteDisconnect

    /**
     * @covers ezSQL_pdo::get_set
     */
    public function testSQLiteGet_set() {
        $expected = "test_var1 = '1', test_var2 = 'ezSQL test', test_var3 = 'This is''nt escaped.'";
        
        $params = array(
            'test_var1' => 1,
            'test_var2' => 'ezSQL test',
            'test_var3' => "This is'nt escaped."
        );
        
        $this->assertTrue($this->object->connect('sqlite:' . self::TEST_SQLITE_DB, '', '', array(), true));

        $this->assertequals($expected, $this->object->get_set($params));
    } // testSQLiteGet_set
     
} // ezSQL_pdoTest