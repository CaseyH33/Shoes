<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Store.php";

    $app = new Silex\Application();
    $app['debug'] = true;
    $server = 'mysql:host=localhost:8889;dbname=shoes';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    //Main page render
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    //Deletes all stores and brands
    $app->post("/delete_all", function() use ($app) {
        Brand::deleteAll();
        Store::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    //Renders page with all brands listed
    $app->get("/brands", function() use ($app) {
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'form_check' => false));
    });

    //Renders page with all brands listed and an add brand form
    $app->get("/brands_add_form", function() use ($app) {
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'form_check' => true));
    });

    //Renders page with all brands listed and posts the new brand added
    $app->post("/add_brand", function() use ($app) {
        $brand = new Brand($_POST['brand_name']);
        $brand->save();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'form_check' => false));
    });

    //Renders an individual brands page with all associated stores listed
    $app->get("/brands/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        return $app['twig']->render('brand.html.twig', array('brand' => $brand, 'brand_stores' => $brand->getStores(), 'all_stores' => Store::getAll()));
    });

    //Renders an individual brands page and posts an added store to the brand
    $app->post("/brands/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        $store = Store::find($_POST['store_id']);
        $brand->addStore($store);
        return $app['twig']->render('brand.html.twig', array('brand' => $brand, 'brand_stores' => $brand->getStores(), 'all_stores' => Store::getAll()));
    });

    //Renders a page with a list of all stores
    $app->get("/stores", function() use ($app) {
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'form_check' => false));
    });

    //Renders a page with a list off all stores and a form to add a new store
    $app->get("/stores_add_form", function() use ($app) {
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'form_check' => true));
    });

    //Renders a page with a list of all stores and posts the new store added
    $app->post("/add_store", function() use ($app) {
        $store = new Store($_POST['name'], $_POST['phone_number'], $_POST['address']);
        $store->save();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'form_check' => false));
    });

    //Renders an individual stores page with a list of all associated brands
    $app->get("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'store_brands' => $store->getBrands(), 'all_brands' => Brand::getAll()));
    });

    //Renders an individual stores with a list of all associated brands and posts a new associated brand
    $app->post("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $brand = Brand::find($_POST['brand_id']);
        $store->addBrand($brand);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'store_brands' => $store->getBrands(), 'all_brands' => Brand::getAll()));
    });

    //Renders a page to edit or delete a store
    $app->get("/edit_store", function() use ($app) {
        $store = Store::find($_GET['store_id']);
        return $app['twig']->render('store_edit.html.twig', array('store' => $store));
    });

    //Renders an individual stores page with updated information
    $app->patch("/stores/{id}", function($id) use ($app) {
        $name = $_POST['name'];
        $phone_number = $_POST['phone_number'];
        $address = $_POST['address'];
        $store = Store::find($id);
        $store->update($name, $phone_number, $address);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'store_brands' => $store->getBrands(), 'all_brands' => Brand::getAll()));
    });

    //Deletes an individual store and renders a page with a list of all stores
    $app->delete("/stores/{id}", function ($id) use ($app) {
        $store = Store::find($id);
        $store->delete();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'form_check' => false));
    });

    return $app;

?>
