<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Store.php";

    $server = 'mysql:host=localhost:8889;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StoreTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Store::deleteAll();
        }

        function testGetName()
        {
            $name = "Foot Locker";
            $test_store = new Store($name);

            $result = $test_store->getName();

            $this->assertEquals($name, $result);
        }

        function testGetId()
        {
            $name = "Foot Locker";
            $test_store = new Store($name);

            $result = $test_store->getId();

            $this->assertEquals(null, $result);
        }

        function testSave()
        {
            $name = "Foot Locker";
            $test_store = new Store($name);
            $test_store->save();

            $result = Store::getAll();

            $this->assertEquals([$test_store], $result);
        }

        function testGetAll()
        {
            $name = "Foot Locker";
            $test_store = new Store($name);
            $test_store->save();

            $name2 = "Nike Outlet";
            $test_store2 = new Store($name2);
            $test_store2->save();

            $result = Store::getAll();

            $this->assertEquals([$test_store, $test_store2], $result);
        }

        function testDeleteAll()
        {
            $name = "Foot Locker";
            $test_store = new Store($name);
            $test_store->save();

            $name2 = "Nike Outlet";
            $test_store2 = new Store($name2);
            $test_store2->save();

            Store::deleteAll();
            $result = Store::getAll();

            $this->assertEquals([], $result);
        }

        function testFind()
        {
            $name = "Foot Locker";
            $test_store = new Store($name);
            $test_store->save();

            $name2 = "Nike Outlet";
            $test_store2 = new Store($name2);
            $test_store2->save();

            $result = Store::find($test_store->getId());

            $this->assertEquals($test_store, $result);
        }


    }

?>
