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

    $app->get("/delete_all", function() use ($app) {
        Brand::deleteAll();
        Store::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/brands", function() use($app) {
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'form_check' => false));
    });

    $app->get("/brands_add_form", function() use($app) {
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'form_check' => true));
    });

    $app->post("/add_brand", function() use ($app) {
        $brand = new Brand($_POST['brand_name']);
        $brand->save();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'form_check' => false));
    }


    return $app;

?>
