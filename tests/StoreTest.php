<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Store.php";
    require_once "src/Brand.php";

    $server = 'mysql:host=localhost:8889;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StoreTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
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

        function testUpdate()
        {
            $name = "Foot Locker";
            $test_store = new Store($name);
            $test_store->save();

            $new_name = "Foot Locker Express";
            $test_store->update($new_name);

            $this->assertEquals($new_name, $test_store->getName());
        }

        function testDelete()
        {
            $name = "Foot Locker";
            $test_store = new Store($name);
            $test_store->save();

            $name2 = "Nike Outlet";
            $test_store2 = new Store($name2);
            $test_store2->save();

            $test_store->delete();

            $this->assertEquals([$test_store2], Store::getAll());
        }

        function testAddBrand()
        {
            $name = "Foot Locker";
            $test_store = new Store($name);
            $test_store->save();

            $brand_name = "Air Jordan";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $test_store->addBrand($test_brand);
            $result = $test_store->getBrands();

            $this->assertEquals([$test_brand], $result);
        }

        function testGetBrands()
        {
            $name = "Foot Locker";
            $test_store = new Store($name);
            $test_store->save();

            $brand_name = "Air Jordan";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $brand_name2 = "Nike";
            $test_brand2 = new Brand($brand_name2);
            $test_brand2->save();

            $test_store->addBrand($test_brand);
            $test_store->addBrand($test_brand2);
            $result = $test_store->getBrands();

            $this->assertEquals([$test_brand, $test_brand2], $result);
        }
    }

?>
