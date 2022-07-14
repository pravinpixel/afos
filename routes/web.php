<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// frontend routes starts
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/pdf', [App\Http\Controllers\OrderController::class, 'generatePDF']);

Route::get('/online/student', [App\Http\Controllers\OrderController::class, 'index'])->name('online.student');
Route::get('/online/food', [App\Http\Controllers\OrderController::class, 'get_food_info'])->name('online.food');
Route::get('/confirm/order', [App\Http\Controllers\OrderController::class, 'order_info'])->name('confirm.order');
Route::get('/order/confirmation', [App\Http\Controllers\OrderController::class, 'confirmation'])->name('confirmation.order');

Route::post('/check/student', [App\Http\Controllers\OrderController::class, 'check_student'])->name('check.student');
Route::post('/student/list', [App\Http\Controllers\OrderController::class, 'student_list'])->name('student.list');
Route::post('/init/order', [App\Http\Controllers\OrderController::class, 'initialize_order'])->name('order.student.initialize');
Route::post('/change/student', [App\Http\Controllers\OrderController::class, 'change_student'])->name('order.student.change');
Route::post('/select/food', [App\Http\Controllers\OrderController::class, 'select_food'])->name('order.select.food');
Route::post('/delete/food', [App\Http\Controllers\OrderController::class, 'delete_food'])->name('order.delete.food');
Route::post('/food/list', [App\Http\Controllers\OrderController::class, 'order_list'])->name('order.food.list');
Route::post('/food/payment', [App\Http\Controllers\OrderController::class, 'confirm_payment'])->name('confirm.food.payment');

Route::post('/order/pre-confirmation', [App\Http\Controllers\OrderController::class, 'pre_confirmation'])->name('pre-confirmation');
Route::any('/fiinal/process', [App\Http\Controllers\OrderController::class, 'final_process'])->name('final.process');
Route::any('/payment/success', [App\Http\Controllers\OrderController::class, 'success_page'])->name('success.page');
Route::any('/payment/failed', [App\Http\Controllers\OrderController::class, 'fail_page'])->name('fail.page');

// frontend routes ends
Route::get('/backend/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm' ])->name('login');
Route::post('/login/submit', [App\Http\Controllers\Auth\LoginController::class, 'check_login' ])->name('login.submit');
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout' ])->name('logout');


Route::prefix('backend')->middleware(['auth'])->group(function(){

    Route::get('/', [App\Http\Controllers\backend\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/download/list', [App\Http\Controllers\backend\DashboardController::class, 'download_list'])->name('download_list');
    Route::post('/orders/count', [App\Http\Controllers\backend\DashboardController::class, 'get_orders_count'])->name('get_orders_count');
    
    Route::prefix('settings')->group(function(){
        Route::get('/', [App\Http\Controllers\backend\SettingController::class, 'index'])->name('settings')->middleware(['checkAccess:visible']);
        Route::post('/tabs', [App\Http\Controllers\backend\SettingController::class, 'get_tab'])->name('get-tab');
        Route::post('/account/save', [App\Http\Controllers\backend\SettingController::class, 'account_save'])->name('account.save');
        Route::post('/settings/save', [App\Http\Controllers\backend\SettingController::class, 'settings_save'])->name('settings.save');
        Route::post('/password/save', [App\Http\Controllers\backend\SettingController::class, 'change_password'])->name('password.save');
    });

    Route::prefix('users')->group(function(){
        Route::get('/', [App\Http\Controllers\backend\UserController::class, 'index'])->name('users')->middleware(['checkAccess:visible']);
        Route::post('/users/add', [App\Http\Controllers\backend\UserController::class, 'add_edit_modal'])->name('users.add_edit')->middleware(['checkAccess:editable']);
        Route::post('/users/save', [App\Http\Controllers\backend\UserController::class, 'save'])->name('users.save')->middleware(['checkAccess:editable']);
        Route::post('/users/delete', [App\Http\Controllers\backend\UserController::class, 'delete'])->name('users.delete')->middleware(['checkAccess:delete']);
        Route::post('/users/status', [App\Http\Controllers\backend\UserController::class, 'change_status'])->name('users.status')->middleware(['checkAccess:editable']);
    });

    Route::prefix('roles')->group(function(){
        Route::get('/', [App\Http\Controllers\backend\RoleController::class, 'index'])->name('roles')->middleware(['checkAccess:visible']);
        Route::post('/roles/add', [App\Http\Controllers\backend\RoleController::class, 'add_edit_modal'])->name('roles.add_edit')->middleware(['checkAccess:editable']);
        Route::post('/roles/save', [App\Http\Controllers\backend\RoleController::class, 'save'])->name('roles.save')->middleware(['checkAccess:editable']);
        Route::post('/roles/delete', [App\Http\Controllers\backend\RoleController::class, 'delete'])->name('roles.delete')->middleware(['checkAccess:delete']);
        Route::post('/roles/status', [App\Http\Controllers\backend\RoleController::class, 'change_status'])->name('roles.status')->middleware(['checkAccess:editable']);
    });

    Route::prefix('locations')->group(function(){
        Route::get('/', [App\Http\Controllers\backend\LocationController::class, 'index'])->name('locations')->middleware(['checkAccess:visible']);
        Route::post('/view', [App\Http\Controllers\backend\LocationController::class, 'view'])->name('locations.view')->middleware(['checkAccess:visible']);
        Route::post('/locations/add', [App\Http\Controllers\backend\LocationController::class, 'add_edit_modal'])->name('locations.add_edit')->middleware(['checkAccess:editable']);
        Route::post('/locations/save', [App\Http\Controllers\backend\LocationController::class, 'save'])->name('locations.save')->middleware(['checkAccess:editable']);
        Route::post('/locations/delete', [App\Http\Controllers\backend\LocationController::class, 'delete'])->name('locations.delete')->middleware(['checkAccess:delete']);
        Route::post('/locations/status', [App\Http\Controllers\backend\LocationController::class, 'change_status'])->name('locations.status')->middleware(['checkAccess:editable']);
    }); 
    
    Route::prefix('institutes')->group(function(){
        Route::get('/', [App\Http\Controllers\backend\InstituteController::class, 'index'])->name('institutes')->middleware(['checkAccess:visible']);
        Route::post('/institutes/add', [App\Http\Controllers\backend\InstituteController::class, 'add_edit_modal'])->name('institutes.add_edit')->middleware(['checkAccess:editable']);
        Route::post('/institutes/save', [App\Http\Controllers\backend\InstituteController::class, 'save'])->name('institutes.save')->middleware(['checkAccess:editable']);
        Route::post('/institutes/delete', [App\Http\Controllers\backend\InstituteController::class, 'delete'])->name('institutes.delete')->middleware(['checkAccess:delete']);
        Route::post('/institutes/status', [App\Http\Controllers\backend\InstituteController::class, 'change_status'])->name('institutes.status')->middleware(['checkAccess:editable']);
    });

    Route::prefix('students')->group(function(){
        Route::get('/', [App\Http\Controllers\backend\StudentController::class, 'index'])->name('students')->middleware(['checkAccess:visible']);
        Route::post('/view', [App\Http\Controllers\backend\StudentController::class, 'view'])->name('students.view')->middleware(['checkAccess:visible']);
        Route::get('/imports', [App\Http\Controllers\backend\StudentController::class, 'import_students'])->name('students.imports')->middleware(['checkAccess:editable']);
        Route::post('/excel/imports', [App\Http\Controllers\backend\StudentController::class, 'import'])->name('students.do.imports')->middleware(['checkAccess:editable']);
    });

    Route::prefix('product-category')->group(function(){
        Route::get('/', [App\Http\Controllers\backend\ProductCategoryController::class, 'index'])->name('product-category')->middleware(['checkAccess:visible']);
        Route::post('/product-category/add', [App\Http\Controllers\backend\ProductCategoryController::class, 'add_edit_modal'])->name('product-category.add_edit')->middleware(['checkAccess:editable']);
        Route::post('/product-category/save', [App\Http\Controllers\backend\ProductCategoryController::class, 'save'])->name('product-category.save')->middleware(['checkAccess:editable']);
        Route::post('/product-category/delete', [App\Http\Controllers\backend\ProductCategoryController::class, 'delete'])->name('product-category.delete')->middleware(['checkAccess:delete']);
        Route::post('/product-category/status', [App\Http\Controllers\backend\ProductCategoryController::class, 'change_status'])->name('product-category.status')->middleware(['checkAccess:editable']);
    });

    Route::prefix('products')->group(function(){
        Route::get('/', [App\Http\Controllers\backend\ProductController::class, 'index'])->name('products')->middleware(['checkAccess:visible']);
        Route::post('/products/add', [App\Http\Controllers\backend\ProductController::class, 'add_edit_modal'])->name('products.add_edit')->middleware(['checkAccess:editable']);
        Route::post('/products/save', [App\Http\Controllers\backend\ProductController::class, 'save_role'])->name('products.save')->middleware(['checkAccess:editable']);
        Route::post('/products/delete', [App\Http\Controllers\backend\ProductController::class, 'delete_product'])->name('products.delete')->middleware(['checkAccess:delete']);
        Route::post('/products/status', [App\Http\Controllers\backend\ProductController::class, 'change_status'])->name('products.status')->middleware(['checkAccess:editable']);
    });

    Route::prefix('payments')->middleware(['checkAccess:visible'])->group(function(){
        Route::get('/', [App\Http\Controllers\backend\PaymentController::class, 'index'])->name('payments');
        Route::post('/view', [App\Http\Controllers\backend\PaymentController::class, 'view'])->name('payments.view');
    });

    Route::prefix('orders')->middleware(['checkAccess:visible'])->group(function(){

        Route::get('/', [App\Http\Controllers\backend\OrderController::class, 'index'])->name('orders');
        Route::post('/view', [App\Http\Controllers\backend\OrderController::class, 'view'])->name('orders.view');

    });

    Route::prefix('reports')->middleware(['checkAccess'])->group(function(){
        Route::get('/', [App\Http\Controllers\backend\ReportController::class, 'index'])->name('reports');
        Route::post('/', [App\Http\Controllers\backend\ReportController::class, 'get_subtypes'])->name('reports.getsubtype');
        Route::post('/download/reports', [App\Http\Controllers\backend\ReportController::class, 'download_excel'])->name('reports.download');
    });

});