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

    $app->post("/delete_all", function() use ($app) {
        Brand::deleteAll();
        Store::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/brands", function() use ($app) {
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'form_check' => false));
    });

    $app->get("/brands_add_form", function() use ($app) {
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'form_check' => true));
    });

    $app->post("/add_brand", function() use ($app) {
        $brand = new Brand($_POST['brand_name']);
        $brand->save();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'form_check' => false));
    });

    $app->get("/brands/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        return $app['twig']->render('brand.html.twig', array('brand' => $brand, 'brand_stores' => $brand->getStores(), 'all_stores' => Store::getAll()));
    });

    $app->post("/brands/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        $store = Store::find($_POST['store_id']);
        $brand->addStore($store);
        return $app['twig']->render('brand.html.twig', array('brand' => $brand, 'brand_stores' => $brand->getStores(), 'all_stores' => Store::getAll()));
    });

    $app->get("/stores", function() use ($app) {
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'form_check' => false));
    });

    $app->get("/stores_add_form", function() use ($app) {
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'form_check' => true));
    });

    $app->post("/add_store", function() use ($app) {
        $store = new Store($_POST['name'], $_POST['phone_number'], $_POST['address']);
        $store->save();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'form_check' => false));
    });

    $app->get("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'store_brands' => $store->getBrands(), 'all_brands' => Brand::getAll()));
    });

    $app->post("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $brand = Brand::find($_POST['brand_id']);
        $store->addBrand($brand);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'store_brands' => $store->getBrands(), 'all_brands' => Brand::getAll()));
    });


    return $app;

?>
