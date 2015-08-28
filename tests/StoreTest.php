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
            $phone_number = "555-555-5555";
            $address = "123 ABC Street";
            $test_store = new Store($name, $phone_number, $address);

            $result = $test_store->getName();

            $this->assertEquals($name, $result);
        }

        function testGetPhoneNumber()
        {
            $name = "Foot Locker";
            $phone_number = "555-555-5555";
            $address = "123 ABC Street";
            $test_store = new Store($name, $phone_number, $address);

            $result = $test_store->getPhoneNumber();

            $this->assertEquals($phone_number, $result);
        }

        function testGetAddress()
        {
            $name = "Foot Locker";
            $phone_number = "555-555-5555";
            $address = "123 ABC Street";
            $test_store = new Store($name, $phone_number, $address);

            $result = $test_store->getAddress();

            $this->assertEquals($address, $result);
        }

        function testGetId()
        {
            $name = "Foot Locker";
            $phone_number = "555-555-5555";
            $address = "123 ABC Street";
            $test_store = new Store($name, $phone_number, $address);

            $result = $test_store->getId();

            $this->assertEquals(null, $result);
        }

        function testSave()
        {
            $name = "Foot Locker";
            $phone_number = "555-555-5555";
            $address = "123 ABC Street";
            $test_store = new Store($name, $phone_number, $address);
            $test_store->save();

            $result = Store::getAll();

            $this->assertEquals([$test_store], $result);
        }

        function testGetAll()
        {
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

            $result = Store::getAll();

            $this->assertEquals([$test_store, $test_store2], $result);
        }

        function testDeleteAll()
        {
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

            Store::deleteAll();
            $result = Store::getAll();

            $this->assertEquals([], $result);
        }

        function testFind()
        {
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

            $result = Store::find($test_store->getId());

            $this->assertEquals($test_store, $result);
        }

        function testUpdate()
        {
            $name = "Foot Locker";
            $phone_number = "555-555-5555";
            $address = "123 ABC Street";
            $test_store = new Store($name, $phone_number, $address);
            $test_store->save();

            $new_name = "Foot Locker Express";
            $new_phone_number = "333-333-333";
            $new_address = "789 XYZ Court";
            $updated_store = new Store($new_name, $new_phone_number, $new_address, $test_store->getId());

            $test_store->update($new_name, $new_phone_number, $new_address);

            $this->assertEquals($updated_store, $test_store);
        }

        function testDelete()
        {
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

            $test_store->delete();

            $this->assertEquals([$test_store2], Store::getAll());
        }

        function testAddBrand()
        {
            $name = "Foot Locker";
            $phone_number = "555-555-5555";
            $address = "123 ABC Street";
            $test_store = new Store($name, $phone_number, $address);
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
            $phone_number = "555-555-5555";
            $address = "123 ABC Street";
            $test_store = new Store($name, $phone_number, $address);
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
