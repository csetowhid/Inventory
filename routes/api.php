<?php

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::apiresource('/employee','Api\EmployeeController');
Route::apiresource('/supplier','Api\SupplierController');
Route::apiresource('/category','Api\CategoryController');
Route::apiresource('/product','Api\ProductController');
Route::apiresource('/expense','Api\ExpenseController');
Route::apiresource('/customer','Api\CustomerController');

Route::Post('/salary/paid/{id}','Api\SalaryController@paid');
Route::get('/salary','Api\SalaryController@allSalary');
Route::get('/salary/view/{id}','Api\SalaryController@viewSalary');
Route::get('/edit/salary/{id}','Api\SalaryController@editSalary');
Route::post('/salary/update/{id}','Api\SalaryController@updateSalary');

Route::post('/stock/update/{id}','Api\SalaryController@stockupdate');


Route::get('/getting/product/{id}','Api\PosController@GetProduct');
//cart
Route::get('/addTocart/{id}','Api\CartController@addTocart');
Route::get('/cart/product','Api\CartController@CartProduct');
Route::get('/remove/cart/{id}','Api\CartController@RemoveCart');
//Increment
Route::get('/increment/{id}','Api\CartController@Increment');
//Decrement
Route::get('/decrement/{id}','Api\CartController@Decrement');
//vat
Route::get('/vats','Api\CartController@Vats');

Route::post('/orderdone','Api\PosController@OrderDone');
Route::get('/orders','Api\OrderController@TodayOrder');
Route::get('/order/details/{id}','Api\OrderController@OrderDetails');
Route::get('/order/orderdetails/{id}','Api\OrderController@OrderDetailsAll');
Route::post('/search/order','Api\OrderController@searchorderdate');
Route::post('/search/month','Api\OrderController@searchordermonth');

//home
Route::get('/today/sell','Api\PosController@TodaySell');
Route::get('/today/income','Api\PosController@TodayIncome');
Route::get('/today/due','Api\PosController@TodayDue');
Route::get('/today/expense','Api\PosController@TodayExpense');
Route::get('/today/stockout','Api\PosController@StockOut');