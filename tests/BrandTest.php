<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";

    $server = 'mysql:host=localhost:8889;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BrandTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Brand::deleteAll();
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


    }

 ?>
