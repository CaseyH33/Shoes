<?php

    class Store
    {
        private $name;
        private $phone_number;
        private $address;
        private $id;

        function __construct($name, $phone_number, $address, $id=null)
        {
            $this->name = $name;
            $this->phone_number = $phone_number;
            $this->address = $address;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getPhoneNumber()
        {
            return $this->phone_number;
        }

        function setPhoneNumber($new_phone_number)
        {
            $this->phone_number = $new_phone_number;
        }

        function getAddress()
        {
            return $this->address;
        }

        function setAddress($new_address)
        {
            $this->address = $new_address;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO stores (name, phone_number, address) VALUES ('{$this->getName()}', '{$this->getPhoneNumber()}', '{$this->getAddress()}');");
            $this->id=$GLOBALS['DB']->lastInsertId();
        }

        function update($new_name, $new_phone_number, $new_address)
        {
            $GLOBALS['DB']->exec("UPDATE stores SET name = '{$new_name}', phone_number = '{$new_phone_number}', address = '{$new_address}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
            $this->setPhoneNumber($new_phone_number);
            $this->setAddress($new_address);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands_stores WHERE store_id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
        }

        function addBrand($brand)
        {
            $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$brand->getId()}, {$this->getId()});");
        }

        function getBrands()
        {
            $returned_brands = $GLOBALS['DB']->query("SELECT brands.* FROM stores
                                    JOIN brands_stores ON (stores.id = brands_stores.store_id)
                                    JOIN brands ON (brands_stores.brand_id = brands.id)
                                    WHERE stores.id = {$this->getId()}
                                    ORDER BY brands.brand_name;");

            $brands = array();
            foreach($returned_brands as $brand) {
                $brand_name = $brand['brand_name'];
                $id = $brand['id'];
                $new_brand = new Brand($brand_name, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }

        static function find($search_id)
        {
            $found_store = null;
            $stores = Store::getAll();
            foreach($stores as $store) {
                $store_id = $store->getId();
                if($store_id == $search_id) {
                    $found_store = $store;
                }
            }
            return $found_store;
        }

        static function getAll()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores ORDER BY name;");
            $stores = array();
            foreach($returned_stores as $store) {
                $name = $store['name'];
                $phone_number = $store['phone_number'];
                $address = $store['address'];
                $id = $store['id'];
                $new_store = new Store($name, $phone_number, $address, $id);
                array_push($stores, $new_store);
            }
            return $stores;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands_stores;");
            $GLOBALS['DB']->exec("DELETE FROM stores;");
        }

    }


 ?>
