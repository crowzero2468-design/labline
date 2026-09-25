<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Login::index');

$routes->get('login', 'Login::index');
$routes->post('login', 'Login::login');

$routes->post('signup', 'Login::signup');

$routes->get('logout', 'Login::logout');
$routes->post('logout', 'Login::logout');

$routes->get('dashboard', 'Dashboard::index');
$routes->get('dashboard/map', 'MapController::index');
$routes->get('dashboard/user', 'UserController::index');
$routes->get('dashboard/users', 'UserController::index');
$routes->get('dashboard/support', 'SupportController::index');
$routes->get('dashboard/history', 'SupportController::history');
$routes->get('dashboard/history/export', 'SupportController::exportHistory');
$routes->get('dashboard/history/export-clinic-counts', 'SupportController::exportClinicCounts');
$routes->get('support', 'SupportController::index');
$routes->get('history', 'SupportController::history');
$routes->get('map', 'MapController::index');
$routes->post('dashboard/import', 'Dashboard::importExcel');
$routes->post('dashboard/save', 'Dashboard::saveRecord');
$routes->post('dashboard/update', 'Dashboard::updateRecord');
$routes->post('dashboard/user/toggle-status', 'UserController::toggleStatus');
$routes->post('dashboard/user/update', 'UserController::update');
$routes->post('dashboard/user/delete', 'UserController::delete');
$routes->post('dashboard/support/save', 'SupportController::store');
$routes->post('dashboard/support/update-status', 'SupportController::updateStatus');
$routes->post('dashboard/attach-contract', 'Dashboard::attachContract');



$routes->post('support/save', 'SupportController::store');
$routes->post('support/update-status', 'SupportController::updateStatus');
$routes->get('404', 'UnknownController::index');

// PMS routes
$routes->get('dashboard/pms', 'Pms::index');
$routes->get('pms', 'Pms::index');
$routes->post('dashboard/pms/save', 'Pms::save');
$routes->post('pms/save', 'Pms::save');
// export
$routes->get('pms/export', 'Pms::export');
// mfs/fsr endpoints
$routes->post('pms/save_mfs', 'Pms::save_mfs');
$routes->post('pms/save_fsr', 'Pms::save_fsr');
$routes->post('dashboard/pms/save_mfs', 'Pms::save_mfs');
$routes->post('dashboard/pms/save_fsr', 'Pms::save_fsr');

$routes->get('mfs', 'Mfs::index');
$routes->post('mfs/save', 'Mfs::save');
$routes->get('mfs/export', 'Mfs::export');
$routes->get('mfs/edit/(:num)', 'Mfs::edit/$1');
$routes->post('mfs/update/(:num)', 'Mfs::update/$1');
$routes->post('mfs/delete/(:num)', 'Mfs::delete/$1');



$routes->get('fsr', 'Fsr::index');
$routes->post('fsr/save', 'Fsr::save');
$routes->get('fsr/edit/(:num)', 'Fsr::edit/$1');
$routes->post('fsr/update/(:num)', 'Fsr::update/$1');
$routes->post('fsr/delete/(:num)', 'Fsr::delete/$1');
$routes->get('fsr/export', 'Fsr::export');

$routes->get('dashboard/receipts', 'Receipt::index');
$routes->post('dashboard/receipts/upload', 'Receipt::upload');
$routes->post('dashboard/receipts/delete/(:num)', 'Receipt::delete/$1');
$routes->get('pms/receipt/(:num)', 'Pms::receipt/$1');
$routes->post('pms/receipt/upload/(:num)', 'Pms::uploadReceipt/$1');

$routes->get('pms/view-mfs/(:num)', 'Pms::viewMfs/$1');
$routes->get('pms/view-fsr/(:num)', 'Pms::viewFsr/$1');
$routes->get('pms/edit/(:num)', 'Pms::edit/$1');
$routes->post('pms/update/(:num)', 'Pms::update/$1');
$routes->post('pms/delete/(:num)', 'Pms::delete/$1');
$routes->post('pms/import', 'Pms::importExcel');



$routes->get('monitoring', 'MonthlyController::index');

$routes->get('rotor_replace', 'RotorController::index');
$routes->post('rotor_replace/save', 'RotorController::save');
$routes->get('rotor_replace/print', 'RotorController::printReport');
$routes->post('rotor_replace/update', 'RotorController::update');
$routes->post('rotor_replace/advance-status', 'RotorController::advanceStatus');
$routes->post('rotor_replace/delete/(:num)', 'RotorController::delete/$1');


$routes->post( 'cancelled-account/save', 'CancelledAccount::save' );