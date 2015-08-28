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

    }

 ?>
