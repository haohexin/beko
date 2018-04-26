<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resource('users', UserController::class);
    $router->resource('userCategories', UserCategoryController::class);

    $router->resource('devices', DeviceController::class);
    $router->resource('deviceCategories', DeviceCategoryController::class);
    $router->resource('deviceFields', DeviceFieldController::class);
    $router->resource('deviceCategoryCurves', DeviceCategoryCurveController::class);
    $router->resource('deviceCategoryArguments', DeviceCategoryArgumentController::class);
    $router->resource('deviceModels', DeviceModelController::class);
    $router->resource('deviceStatus', DeviceStatusController::class);
    $router->resource('controlModes', ControlModeController::class);

    $router->resource('warningCategories', WarningCategoryController::class);
    $router->resource('warningPhones', WarningPhoneController::class);
    $router->resource('warnings', WarningController::class);

    $router->resource('maintainCategories', MaintainCategoryController::class);
    $router->resource('maintainPhones', MaintainPhoneController::class);
    $router->resource('maintains', MaintainController::class);

    $router->resource('serviceData', ServiceDataController::class);

    $router->resource('industries', IndustryController::class);
    $router->resource('addresses', AddressController::class);
});
