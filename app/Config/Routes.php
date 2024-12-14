<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Load country alias from config
$config = config('Site');
$country_alias = $config->country_alias ?? ['in', 'us', 'uk']; // Default country aliases if not set
$countryName = implode('|', $country_alias);

// Default routes
$routes->get('/', 'Home::index');
$routes->get('search', 'Home::search');

// Dashboard routes
$routes->get('dashboard/eventhome', 'Dashboard::eventhome');

// Bookmark API routes
$routes->post('api/bookmarks/add', 'Api\Bookmarks::add');
$routes->post('api/bookmarks/remove', 'Api\Bookmarks::remove');

// Authentication routes
$routes->get('login', 'User::login');
$routes->get('logout', 'User::logout');
$routes->get('signup', 'User::signup');
$routes->get('resendActivationLink', 'User::resendActivationLink');
$routes->get('activationLink/(:segment)', 'User::activationLink/$1');

// Event routes
$routes->get('event/preview/(:num)', 'Event::preview/$1');
$routes->get('event/(:segment)', 'Event::index/$1');
$routes->get('event', 'Home::index');

// Dashboard routes
$routes->group('dashboard', static function($routes) {
    $routes->get('/', 'Dashboard\MyEvent::upComingEventList');
    $routes->get('pastEventList', 'Dashboard\MyEvent::pastEventList');
    $routes->get('home/(:num)', 'Dashboard\Event::home/$1');
    $routes->get('home/(:num)/(:segment)', 'Dashboard\Event::home/$1/$2');
    $routes->get('home/(:num)/(:segment)/(:num)', 'Dashboard\Event::home/$1/$2/$3');
});

// Profile routes
$routes->group('profile', static function($routes) {
    $routes->get('/', 'Profile::personalDetail');
    $routes->get('company', 'Profile::companyDetail');
    $routes->get('bank', 'Profile::bankDetail');
    $routes->get('alert', 'Profile::alertSetting');
    $routes->get('changePassword', 'Profile::changePassword');
});

// Content routes
$routes->group('content', static function($routes) {
    $routes->get('faq', 'Content::FAQ');
    $routes->get('about', 'Content::About');
    $routes->get('contact', 'Content::Contact');
    $routes->get('terms', 'Content::Terms');
    $routes->get('privacy', 'Content::Privacy');
});

// Organization routes
$routes->group('o', static function($routes) {
    $routes->get('(:segment)', 'Organization::index/$1');
    $routes->get('(:segment)/events', 'Organization::events/$1');
    $routes->get('(:segment)/members', 'Organization::members/$1');
    $routes->get('(:segment)/login', 'Organization::login/$1');
});

// 404 override
$routes->set404Override('App\Controllers\Nopage::index');

// Country specific routes
$routes->group($countryName, static function($routes) {
    // Add country specific routes here
});

// Existing SEO URLs
$routes->get('career', 'Content::Career');
$routes->get('pricing', 'Content::Pricing');
$routes->get('mediakit', 'Content::Mediakit');
$routes->get('support', 'Content::Support');
$routes->get('contact', 'Content::Contact');
$routes->get('privacypolicy', 'Content::Privacypolicy');
$routes->get('news', 'Content::News');
$routes->get('eventregistration', 'Content::Eventregistration');
$routes->get('selltickets', 'Content::Selltickets');
$routes->get('terms', 'Content::Terms');
$routes->get('client_feedback', 'Content::Client_feedback');
$routes->get('aboutus', 'Content::Aboutus');
$routes->get('consult', 'Content::Consult');
$routes->get('mesitemap', 'Content::Sitemap');
$routes->get('thecollegefever', 'Content::Thecollegefever');
$routes->get('team', 'Content::Team');

// My wallet routes
$routes->group('mywallet', static function($routes) {
    $routes->get('/', 'Mywallet::index');
    $routes->get('transactions', 'Mywallet::walletTransactions');
    $routes->get('addmoney', 'Mywallet::addMoneyToWallet');
    $routes->get('addmoneyresponse', 'Mywallet::processAddMoneyToWallet');
});

// TrueSemantic URL
$routes->get('tsfeedback/(:num)/(:any)/(:num)', 'Tsfeedback::index/$1/$2/$3');

// API routes
$routes->group('api', static function($routes) {
    $routes->post('postebs.php', 'Api\Payment::preview');
    $routes->get('getstatuscmb.php', 'Api\Payment::getTransactionDetails');
});

// Web API routes
$routes->group('web/api/v1', static function($routes) {
    $routes->get('(:any)', 'Webapiv1::$1');
});

// Mobile API routes
$routes->group('mobile/api/v1', static function($routes) {
    $routes->get('(:any)', 'Mobileapiv1::$1');
});

// Global affiliate routes
$routes->group('globalaffiliate', static function($routes) {
    $routes->get('join', 'Content::globalaffiliate_join');
    $routes->get('faq', 'Content::globalaffiliate_faq');
    $routes->get('home', 'Content::globalaffiliate_view');
    $routes->get('why', 'Content::globalaffiliate_why');
});

// Features routes
$routes->group('features', static function($routes) {
    $routes->get('/', 'Content::organizerfeatures_manage');
    $routes->get('promote', 'Content::organizerfeatures_promote');
    $routes->get('communicate', 'Content::organizerfeatures_communicate');
    $routes->get('reports', 'Content::organizerfeatures_reports');
    $routes->get('payment', 'Content::organizerfeatures_payment');
    $routes->get('checkinapp', 'Content::organizerfeatures_checkinapp');
    $routes->get('whitelabelapp', 'Content::organizerfeatures_whitelabelapp');
});

// Why MeraEvents routes
$routes->group('why_meraevents', static function($routes) {
    $routes->get('/', 'Content::why_meraevents_why');
    $routes->get('registration', 'Content::why_meraevents_registration');
    $routes->get('marketing', 'Content::why_meraevents_marketing');
    $routes->get('check_in', 'Content::why_meraevents_check_in');
    $routes->get('appify', 'Content::why_meraevents_appify');
    $routes->get('assistant', 'Content::why_meraevents_assistant');
});

// Blog routes
$routes->group('blog', static function($routes) {
    $routes->get('/', 'Blog::index');
    $routes->get('savecomments', 'Blog::savecomments');
    $routes->get('category/(:any)', 'Blog::category/$1');
    $routes->get('(:any)', 'Blog::details/$1');
});

// CSV routes
$routes->group('csv', static function($routes) {
    $routes->get('/', 'Csv::index');
    $routes->get('upload', 'Csv::upload');
    $routes->get('save', 'Csv::save');
});
