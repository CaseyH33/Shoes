<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";
    require_once "src/Store.php";

    $server = 'mysql:host=localhost:8889;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BrandTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Brand::deleteAll();
            Store::deleteAll();
        }

        function testGetBrandName()
        {
            $brand_name = "Air Jordan";
            $test_brand = new Brand($brand_name);

            $result = $test_brand->getBrandName();

            $this->assertEquals($brand_name, $result);
        }

        function testGetId()
        {
            $brand_name = "Air Jordan";
            $test_brand = new Brand($brand_name);

            $result = $test_brand->getId();

            $this->assertEquals(null, $result);
        }

        function testSave()
        {
            $brand_name = "Air Jordan";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $result = Brand::getAll();

            $this->assertEquals([$test_brand], $result);
        }

        function testGetAll()
        {
            $brand_name = "Air Jordan";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $brand_name2 = "Nike";
            $test_brand2 = new Brand($brand_name2);
            $test_brand2->save();

            $result = Brand::getAll();

            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

        function testFind()
        {
            $brand_name = "Air Jordan";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $brand_name2 = "Nike";
            $test_brand2 = new Brand($brand_name2);
            $test_brand2->save();

            $result = Brand::find($test_brand->getId());

            $this->assertEquals($test_brand, $result);
        }

        function testAddStore()
        {
            $brand_name = "Air Jordan";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $name = "Foot Locker";
            $phone_number = "555-555-5555";
            $address = "123 ABC Street";
            $test_store = new Store($name, $phone_number, $address);
            $test_store->save();

            $test_brand->addStore($test_store);
            $result = $test_brand->getStores();

            $this->assertEquals([$test_store], $result);
        }

        function testGetStores()
        {
            $brand_name = "Air Jordan";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $name = "Foot Locker";
            $phone_number = "555-555-5555";
            $address = "123 ABC Street";
            $test_store = new Store($name, $phone_number, $address);
            $test_store->save();

            $name2 = "Nike Outlet";
            $phone_number2 = "444-444-4444";
            $address2 = "456 CBA Ave.";
            $test_store2 = new Store($name2, $phone_number2, $address2);
            $test_store2->save();

            $test_brand->addStore($test_store);
            $test_brand->addStore($test_store2);
            $result = $test_brand->getStores();

            $this->assertEquals([$test_store, $test_store2], $result);
        }

    }

 ?>
