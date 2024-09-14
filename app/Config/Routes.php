<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->set404Override(
    function () {
        echo "Plz enter valid url";
    }
);
$routes->group('',['filter'=>'noauthCheck'], function($routes) {
    $routes->get('/', 'Home::index');
    $routes->post('/login', 'Home::login');
});
$routes->group('',['filter'=>'authCheck'], function($routes){
    $routes->get('/logout', 'Ecommerce::logout');
    $routes->get('/fruitables', 'Ecommerce::index');
    $routes->get('/shop', 'Ecommerce::shop');
    $routes->get('/cart', 'Ecommerce::cart');
    $routes->get('/checkout', 'Checkout::index');
    $routes->post('/COD', 'Checkout::COD');
    $routes->post('/payment_stripe', 'Checkout::payment_stripe');
    $routes->get('/success', 'Checkout::success');
    $routes->get('/thank_you_1', 'Checkout::thank_you_1');
    $routes->get('/clear-cart', 'Checkout::clearCart');
    $routes->post('/process_payment', 'Checkout::processPayment');
    $routes->get('/paypal_success', 'Checkout::success1');
    $routes->get('/product/(:num)', 'Ecommerce::show/$1');
    $routes->get('/contact', 'Ecommerce::contact');
    $routes->post('/addCart/(:num)', 'Ecommerce::addCart/$1');
    $routes->post('/deleteCart/(:num)', 'Ecommerce::deleteCart/$1');
    $routes->post('/updateCart', 'Ecommerce::updateCart');
    $routes->post('/view_data', 'Ecommerce::view_data');
    $routes->post('/fruit_data', 'Ecommerce::fruit_data');
    $routes->post('/vegetable_data', 'Ecommerce::vegetable_data');
    $routes->post('/searchbar_data', 'Ecommerce::searchbar_data');
    $routes->post('/lowtohigh_data', 'Ecommerce::lowtohigh_data');
    $routes->post('/hightolow_data', 'Ecommerce::hightolow_data');
    $routes->post('/atoz_data', 'Ecommerce::atoz_data');
    $routes->post('/ztoa_data', 'Ecommerce::ztoa_data');

});