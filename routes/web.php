<?php

use App\Livewire\User\PasswordReset;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Front\BlogComponent;
use App\Livewire\Front\CartComponent;
use App\Livewire\User\LoginComponent;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Livewire\Front\CompareComponent;
use App\Livewire\Front\ContactComponent;
use App\Livewire\Front\ProductComponent;
use App\Livewire\User\RegisterComponent;
use App\Livewire\User\ResetUserPassword;
use App\Livewire\User\WishlistComponent;
use App\Livewire\Front\CheckoutComponent;
use App\Livewire\Front\FrontendComponent;
use App\Livewire\Front\LoadShopComponent;
use App\Livewire\Admin\DemoFrontComponent;
use App\Livewire\Front\Components\MiniCart;
use App\Livewire\Front\NavigationComponent;
use App\Livewire\Front\BlogDetailsComponent;
use App\Livewire\Api\Auth\VendorAuthComponent;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('front.index');
});
Route::get('front/index',FrontendComponent::class)->name('front.index');
Auth::routes();
Route::get('front/blog',BlogComponent::class)->name('front.blog');
Route::get('blog/details/{id}',BlogDetailsComponent::class)->name('blog.details');
Route::middleware('guest')->group(function(){
    Route::get('/login',function(){
        return redirect()->route('user.login');
    });
    Route::get('/register',function(){
        return redirect()->route('user.register');
    });
    Route::get('password/request',function(){
        return redirect()->route('user.password-reset');
    });
    Route::get('user/login',LoginComponent::class)->name('user.login');
    Route::get('user/register',RegisterComponent::class)->name('user.register');
    Route::get('/user/password-reset',PasswordReset::class)->name('user.password-reset');
    Route::get('user/change-password/{token}/{email}', ResetUserPassword::class)->name('user.change-password');
});
Route::get('compare/products',CompareComponent::class)->name('compare.products');
Route::get('product/details/{slug}',ProductComponent::class)->name('product.details');

Route::middleware('has_items')->group(function(){
Route::get('view/cart',CartComponent::class)->name('view.cart');

});
Route::get('/admin/demo-content/{pageId}/{alterPage}',DemoFrontComponent::class)->name('admin.democontent');
Route::get('explore/shop/{type}/{slug}',LoadShopComponent::class)->name('explore.shop');
Route::get('proceed/checkout',CheckoutComponent::class)->name('proceed.checkout');
Route::post('/stripe/post', [App\Http\Controllers\StripePaymentController::class,'stripePost'])->name('stripe.post');
Route::get('/currency/{id}', [App\Http\Controllers\Front\FrontendController::class,'currency'])->name('front.currency');
Route::get('/language/{id}', [App\Http\Controllers\Front\FrontendController::class,'language'])->name('front.language');
Route::get('/front/menu/{slug}',NavigationComponent::class)->name('front.menu');
Route::get('/front/contact',ContactComponent::class)->name('front.contact');
//Admin routes starts
Route::prefix('admin')->group(function(){
        Route::get('/login', [App\Http\Controllers\Admin\LoginController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [App\Http\Controllers\Admin\LoginController::class, 'login'])->name('admin.login.submit');
        Route::get('/forgot', [App\Http\Controllers\Admin\LoginController::class, 'showForgotForm'])->name('admin.forgot');
        Route::post('/forgot', [App\Http\Controllers\Admin\LoginController::class, 'forgot'])->name('admin.forgot.submit');
        Route::get('/logout', [App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('admin.logout');
        //End of admin login routes


    // Notification Count
    Route::get('/all/notf/count', [App\Http\Controllers\Admin\NotificationController::class, 'all_notf_count'])->name('all-notf-count');
    // Notification Count Ends

    // User Notification
    Route::get('/user/notf/show', [App\Http\Controllers\Admin\NotificationController::class, 'user_notf_show'])->name('user-notf-show');
    Route::get('/user/notf/clear', [App\Http\Controllers\Admin\NotificationController::class, 'user_notf_clear'])->name('user-notf-clear');
    // User Notification Ends

    // Order Notification
    Route::get('/order/notf/show', [App\Http\Controllers\Admin\NotificationController::class, 'order_notf_show'])->name('order-notf-show');
    Route::get('/order/notf/clear', [App\Http\Controllers\Admin\NotificationController::class, 'order_notf_clear'])->name('order-notf-clear');
    // Order Notification Ends

    // Product Notification
    Route::get('/product/notf/show', [App\Http\Controllers\Admin\NotificationController::class, 'product_notf_show'])->name('product-notf-show');
    Route::get('/product/notf/clear', [App\Http\Controllers\Admin\NotificationController::class, 'product_notf_clear'])->name('product-notf-clear');
    // Product Notification Ends

    // Conversation Notification
    Route::get('/conv/notf/show', [App\Http\Controllers\Admin\NotificationController::class, 'conv_notf_show'])->name('conv-notf-show');
    Route::get('/conv/notf/clear', [App\Http\Controllers\Admin\NotificationController::class, 'conv_notf_clear'])->name('conv-notf-clear');
    // Conversation Notification Ends

    //------------ ADMIN NOTIFICATION SECTION ENDS ------------

    //------------ ADMIN DASHBOARD & PROFILE SECTION ------------

    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/profile', [App\Http\Controllers\Admin\DashboardController::class, 'profile'])->name('admin.profile');
    Route::post('/profile/update', [App\Http\Controllers\Admin\DashboardController::class, 'profileupdate'])->name('admin.profile.update');
    Route::get('/password', [App\Http\Controllers\Admin\DashboardController::class, 'passwordreset'])->name('admin.password');
    Route::post('/password/update', [App\Http\Controllers\Admin\DashboardController::class, 'changepass'])->name('admin.password.update');

    //------------ ADMIN DASHBOARD & PROFILE SECTION ENDS ------------

    Route::group(['middleware' => 'permissions:orders'], function() {

        Route::get('/orders/datatables/{slug}', [App\Http\Controllers\Admin\OrderController::class, 'datatables'])->name('admin-order-datatables'); // JSON REQUEST
        Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin-order-index');
        Route::get('/order/edit/{id}', [App\Http\Controllers\Admin\OrderController::class, 'edit'])->name('admin-order-edit');
        Route::post('/order/update/{id}', [App\Http\Controllers\Admin\OrderController::class, 'update'])->name('admin-order-update');
        Route::get('/orders/pending', [App\Http\Controllers\Admin\OrderController::class, 'pending'])->name('admin-order-pending');
        Route::get('/orders/processing', [App\Http\Controllers\Admin\OrderController::class, 'processing'])->name('admin-order-processing');
        Route::get('/orders/completed', [App\Http\Controllers\Admin\OrderController::class, 'completed'])->name('admin-order-completed');
        Route::get('/orders/declined', [App\Http\Controllers\Admin\OrderController::class, 'declined'])->name('admin-order-declined');
        Route::get('/order/{id}/show', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('admin-order-show');
        Route::get('/order/{id}/invoice', [App\Http\Controllers\Admin\OrderController::class, 'invoice'])->name('admin-order-invoice');
        Route::get('/order/{id}/print', [App\Http\Controllers\Admin\OrderController::class, 'printpage'])->name('admin-order-print');
        Route::get('/order/{id1}/status/{status}', [App\Http\Controllers\Admin\OrderController::class, 'status'])->name('admin-order-status');
        Route::post('/order/email/', [App\Http\Controllers\Admin\OrderController::class, 'emailsub'])->name('admin-order-emailsub');
        Route::post('/order/{id}/license', [App\Http\Controllers\Admin\OrderController::class, 'license'])->name('admin-order-license');
    
        // Order Tracking
        Route::get('/order/{id}/track', [App\Http\Controllers\Admin\OrderTrackController::class, 'index'])->name('admin-order-track');
        Route::get('/order/{id}/trackload', [App\Http\Controllers\Admin\OrderTrackController::class, 'load'])->name('admin-order-track-load');
        Route::post('/order/track/store', [App\Http\Controllers\Admin\OrderTrackController::class, 'store'])->name('admin-order-track-store');
        Route::get('/order/track/add', [App\Http\Controllers\Admin\OrderTrackController::class, 'add'])->name('admin-order-track-add');
        Route::get('/order/track/edit/{id}', [App\Http\Controllers\Admin\OrderTrackController::class, 'edit'])->name('admin-order-track-edit');
        Route::post('/order/track/update/{id}', [App\Http\Controllers\Admin\OrderTrackController::class, 'update'])->name('admin-order-track-update');
        Route::get('/order/track/delete/{id}', [App\Http\Controllers\Admin\OrderTrackController::class, 'delete'])->name('admin-order-track-delete');
    
        // Order Tracking Ends
    
    });

    Route::group(['middleware' => 'permissions:products'], function() {

        Route::get('/products/datatables', [App\Http\Controllers\Admin\ProductController::class, 'datatables'])->name('admin-prod-datatables'); // JSON REQUEST
        Route::get('/products', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('admin-prod-index');
    
        Route::post('/products/upload/update/{id}', [App\Http\Controllers\Admin\ProductController::class, 'uploadUpdate'])->name('admin-prod-upload-update');
    
        Route::get('/products/deactive/datatables', [App\Http\Controllers\Admin\ProductController::class, 'deactivedatatables'])->name('admin-prod-deactive-datatables'); // JSON REQUEST
        Route::get('/products/deactive', [App\Http\Controllers\Admin\ProductController::class, 'deactive'])->name('admin-prod-deactive');
    
        Route::get('/products/catalogs/datatables', [App\Http\Controllers\Admin\ProductController::class, 'catalogdatatables'])->name('admin-prod-catalog-datatables'); // JSON REQUEST
        Route::get('/products/catalogs/', [App\Http\Controllers\Admin\ProductController::class, 'catalogs'])->name('admin-prod-catalog-index');
    
        // CREATE SECTION
        Route::get('/products/types', [App\Http\Controllers\Admin\ProductController::class, 'types'])->name('admin-prod-types');
        Route::get('/products/physical/create', [App\Http\Controllers\Admin\ProductController::class, 'createPhysical'])->name('admin-prod-physical-create');
        Route::get('/products/digital/create', [App\Http\Controllers\Admin\ProductController::class, 'createDigital'])->name('admin-prod-digital-create');
        Route::get('/products/license/create', [App\Http\Controllers\Admin\ProductController::class, 'createLicense'])->name('admin-prod-license-create');
        Route::post('/products/store', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('admin-prod-store');
        Route::get('/getattributes', [App\Http\Controllers\Admin\ProductController::class, 'getAttributes'])->name('admin-prod-getattributes');
        // CREATE SECTION END
    
        // EDIT SECTION
        Route::get('/products/edit/{id}', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('admin-prod-edit');
        Route::post('/products/edit/{id}', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('admin-prod-update');
        // EDIT SECTION ENDS
    
        // DELETE SECTION
        Route::get('/products/delete/{id}', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('admin-prod-delete');
        // DELETE SECTION ENDS
    
        Route::get('/products/catalog/{id1}/{id2}', [App\Http\Controllers\Admin\ProductController::class, 'catalog'])->name('admin-prod-catalog');
    
    });
    Route::group(['middleware' => 'permissions:affilate_products'], function() {

        Route::get('/products/import/create', [App\Http\Controllers\Admin\ImportController::class, 'createImport'])->name('admin-import-create');
        Route::get('/products/import/edit/{id}', [App\Http\Controllers\Admin\ImportController::class, 'edit'])->name('admin-import-edit');
    
        Route::get('/products/import/datatables', [App\Http\Controllers\Admin\ImportController::class, 'datatables'])->name('admin-import-datatables'); // JSON REQUEST
        Route::get('/products/import/index', [App\Http\Controllers\Admin\ImportController::class, 'index'])->name('admin-import-index');
    
        Route::post('/products/import/store', [App\Http\Controllers\Admin\ImportController::class, 'store'])->name('admin-import-store');
        Route::post('/products/import/update/{id}', [App\Http\Controllers\Admin\ImportController::class, 'update'])->name('admin-import-update');
    
        Route::get('/general-settings/productaffilate/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'productAffilate'])->name('admin-gs-paffilate');
    
        // DELETE SECTION
        Route::get('/affiliate/products/delete/{id}', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('admin-affiliate-prod-delete');
        // DELETE SECTION ENDS
    
    });
    Route::group(['middleware' => 'permissions:customers'], function() {

        Route::get('/users/datatables', [App\Http\Controllers\Admin\UserController::class, 'datatables'])->name('admin-user-datatables'); // JSON REQUEST
        Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin-user-index');
        Route::get('/users/edit/{id}', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin-user-edit');
        Route::post('/users/edit/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin-user-update');
        Route::get('/users/delete/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin-user-delete');
        Route::get('/user/{id}/show', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('admin-user-show');
        Route::get('/users/ban/{id1}/{id2}', [App\Http\Controllers\Admin\UserController::class, 'ban'])->name('admin-user-ban');
        Route::get('/user/default/image', [App\Http\Controllers\Admin\UserController::class, 'image'])->name('admin-user-image');
        Route::get('/users/deposit/{id}', [App\Http\Controllers\Admin\UserController::class, 'deposit'])->name('admin-user-deposit');
        Route::post('/user/deposit/{id}', [App\Http\Controllers\Admin\UserController::class, 'depositUpdate'])->name('admin-user-deposit-update');
    
        Route::get('/users/transactions/datatables', [App\Http\Controllers\Admin\UserController::class, 'transdatatables'])->name('admin-trans-datatables'); // JSON REQUEST  
        Route::get('/users/transactions', [App\Http\Controllers\Admin\UserController::class, 'transactions'])->name('admin-trans-index');
        Route::get('/users/transactions/{id}/show', [App\Http\Controllers\Admin\UserController::class, 'transhow'])->name('admin-trans-show');
    
        // WITHDRAW SECTION
        Route::get('/users/withdraws/datatables', [App\Http\Controllers\Admin\UserController::class, 'withdrawdatatables'])->name('admin-withdraw-datatables'); // JSON REQUEST
        Route::get('/users/withdraws', [App\Http\Controllers\Admin\UserController::class, 'withdraws'])->name('admin-withdraw-index');
        Route::get('/user/withdraw/{id}/show', [App\Http\Controllers\Admin\UserController::class, 'withdrawdetails'])->name('admin-withdraw-show');
        Route::get('/users/withdraws/accept/{id}', [App\Http\Controllers\Admin\UserController::class, 'accept'])->name('admin-withdraw-accept');
        Route::get('/user/withdraws/reject/{id}', [App\Http\Controllers\Admin\UserController::class, 'reject'])->name('admin-withdraw-reject');
        // WITHDRAW SECTION ENDS
    
    });
    Route::group(['middleware' => 'permissions:vendors'], function() {

        Route::get('/vendors/datatables', [App\Http\Controllers\Admin\VendorController::class, 'datatables'])->name('admin-vendor-datatables');
        Route::get('/vendors', [App\Http\Controllers\Admin\VendorController::class, 'index'])->name('admin-vendor-index');
    
        Route::get('/vendors/{id}/show', [App\Http\Controllers\Admin\VendorController::class, 'show'])->name('admin-vendor-show');
        Route::get('/vendors/secret/login/{id}', [App\Http\Controllers\Admin\VendorController::class, 'secret'])->name('admin-vendor-secret');
        Route::get('/vendor/edit/{id}', [App\Http\Controllers\Admin\VendorController::class, 'edit'])->name('admin-vendor-edit');
        Route::post('/vendor/edit/{id}', [App\Http\Controllers\Admin\VendorController::class, 'update'])->name('admin-vendor-update');
    
        Route::get('/vendor/verify/{id}', [App\Http\Controllers\Admin\VendorController::class, 'verify'])->name('admin-vendor-verify');
        Route::post('/vendor/verify/{id}', [App\Http\Controllers\Admin\VendorController::class, 'verifySubmit'])->name('admin-vendor-verify-submit');
    
        Route::get('/add/subscription/{id}', [App\Http\Controllers\Admin\VendorController::class, 'addSubs'])->name('admin-vendor-add-subs');
        Route::post('/add/subscription/{id}', [App\Http\Controllers\Admin\VendorController::class, 'addSubsStore'])->name('admin-vendor-subs-store');
    
        Route::get('/vendors', [App\Http\Controllers\Admin\VendorController::class, 'index'])->name('admin-vendor-index');
        Route::get('/vendor/color', [App\Http\Controllers\Admin\VendorController::class, 'color'])->name('admin-vendor-color');
        Route::get('/vendors/status/{id1}/{id2}', [App\Http\Controllers\Admin\VendorController::class, 'status'])->name('admin-vendor-st');
        Route::get('/vendors/delete/{id}', [App\Http\Controllers\Admin\VendorController::class, 'destroy'])->name('admin-vendor-delete');
    
        Route::get('/vendors/withdraws/datatables', [App\Http\Controllers\Admin\VendorController::class, 'withdrawdatatables'])->name('admin-vendor-withdraw-datatables'); // JSON REQUEST
        Route::get('/vendors/withdraws', [App\Http\Controllers\Admin\VendorController::class, 'withdraws'])->name('admin-vendor-withdraw-index');
        Route::get('/vendors/withdraw/{id}/show', [App\Http\Controllers\Admin\VendorController::class, 'withdrawdetails'])->name('admin-vendor-withdraw-show');
        Route::get('/vendors/withdraws/accept/{id}', [App\Http\Controllers\Admin\VendorController::class, 'accept'])->name('admin-vendor-withdraw-accept');
        Route::get('/vendors/withdraws/reject/{id}', [App\Http\Controllers\Admin\VendorController::class, 'reject'])->name('admin-vendor-withdraw-reject');
    
        // Vendor Registration Section
        Route::get('/general-settings/vendor-registration/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'regvendor'])->name('admin-gs-regvendor');
        // Vendor Registration Section Ends
    
        // Verification Section
        Route::get('/verificatons/datatables/{status}', [App\Http\Controllers\Admin\VerificationController::class, 'datatables'])->name('admin-vr-datatables');
        Route::get('/verificatons', [App\Http\Controllers\Admin\VerificationController::class, 'index'])->name('admin-vr-index');
        Route::get('/verificatons/pendings', [App\Http\Controllers\Admin\VerificationController::class, 'pending'])->name('admin-vr-pending');
    
        Route::get('/verificatons/show', [App\Http\Controllers\Admin\VerificationController::class, 'show'])->name('admin-vr-show');
        Route::get('/verificatons/edit/{id}', [App\Http\Controllers\Admin\VerificationController::class, 'edit'])->name('admin-vr-edit');
        Route::post('/verificatons/edit/{id}', [App\Http\Controllers\Admin\VerificationController::class, 'update'])->name('admin-vr-update');
        Route::get('/verificatons/status/{id1}/{id2}', [App\Http\Controllers\Admin\VerificationController::class, 'status'])->name('admin-vr-st');
        Route::get('/verificatons/delete/{id}', [App\Http\Controllers\Admin\VerificationController::class, 'destroy'])->name('admin-vr-delete');
        // Verification Section Ends
    
    });
    Route::group(['middleware' => 'permissions:vendor_subscription_plans'], function() {

        Route::get('/subscription/datatables', [App\Http\Controllers\Admin\SubscriptionController::class, 'datatables'])->name('admin-subscription-datatables');
        Route::get('/subscription', [App\Http\Controllers\Admin\SubscriptionController::class, 'index'])->name('admin-subscription-index');
        Route::get('/subscription/create', [App\Http\Controllers\Admin\SubscriptionController::class, 'create'])->name('admin-subscription-create');
        Route::post('/subscription/create', [App\Http\Controllers\Admin\SubscriptionController::class, 'store'])->name('admin-subscription-store');
        Route::get('/subscription/edit/{id}', [App\Http\Controllers\Admin\SubscriptionController::class, 'edit'])->name('admin-subscription-edit');
        Route::post('/subscription/edit/{id}', [App\Http\Controllers\Admin\SubscriptionController::class, 'update'])->name('admin-subscription-update');
        Route::get('/subscription/delete/{id}', [App\Http\Controllers\Admin\SubscriptionController::class, 'destroy'])->name('admin-subscription-delete');
    
        Route::get('/vendors/subs/datatables', [App\Http\Controllers\Admin\VendorController::class, 'subsdatatables'])->name('admin-vendor-subs-datatables');
        Route::get('/vendors/subs', [App\Http\Controllers\Admin\VendorController::class, 'subs'])->name('admin-vendor-subs');
        Route::get('/vendors/sub/{id}', [App\Http\Controllers\Admin\VendorController::class, 'sub'])->name('admin-vendor-sub');
    
    });
    
    //------------ ADMIN SUBSCRIPTION SECTION ENDS ------------
    
    //------------ ADMIN CATEGORY SECTION ------------
    
    Route::group(['middleware' => 'permissions:categories'], function() {
    
        Route::get('/category/datatables', [App\Http\Controllers\Admin\CategoryController::class, 'datatables'])->name('admin-cat-datatables'); //JSON REQUEST
        Route::get('/category', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin-cat-index');
        Route::get('/category/create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('admin-cat-create');
        Route::post('/category/create', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('admin-cat-store');
        Route::get('/category/edit/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('admin-cat-edit');
        Route::post('/category/edit/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('admin-cat-update');
        Route::get('/category/delete/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('admin-cat-delete');
        Route::get('/category/status/{id1}/{id2}', [App\Http\Controllers\Admin\CategoryController::class, 'status'])->name('admin-cat-status');
    
        //------------ ADMIN ATTRIBUTE SECTION ------------
    
        Route::get('/attribute/datatables', [App\Http\Controllers\Admin\AttributeController::class, 'datatables'])->name('admin-attr-datatables'); //JSON REQUEST
        Route::get('/attribute', [App\Http\Controllers\Admin\AttributeController::class, 'index'])->name('admin-attr-index');
        Route::get('/attribute/{catid}/attrCreateForCategory', [App\Http\Controllers\Admin\AttributeController::class, 'attrCreateForCategory'])->name('admin-attr-createForCategory');
        Route::get('/attribute/{subcatid}/attrCreateForSubcategory', [App\Http\Controllers\Admin\AttributeController::class, 'attrCreateForSubcategory'])->name('admin-attr-createForSubcategory');
        Route::get('/attribute/{childcatid}/attrCreateForChildcategory', [App\Http\Controllers\Admin\AttributeController::class, 'attrCreateForChildcategory'])->name('admin-attr-createForChildcategory');
        Route::post('/attribute/store', [App\Http\Controllers\Admin\AttributeController::class, 'store'])->name('admin-attr-store');
        Route::get('/attribute/{id}/manage', [App\Http\Controllers\Admin\AttributeController::class, 'manage'])->name('admin-attr-manage');
        Route::get('/attribute/{attrid}/edit', [App\Http\Controllers\Admin\AttributeController::class, 'edit'])->name('admin-attr-edit');
        Route::post('/attribute/edit/{id}', [App\Http\Controllers\Admin\AttributeController::class, 'update'])->name('admin-attr-update');
        Route::get('/attribute/{id}/options', [App\Http\Controllers\Admin\AttributeController::class, 'options'])->name('admin-attr-options');
        Route::get('/attribute/delete/{id}', [App\Http\Controllers\Admin\AttributeController::class, 'destroy'])->name('admin-attr-delete');
    
        // SUBCATEGORY SECTION ------------
    
        Route::get('/subcategory/datatables', [App\Http\Controllers\Admin\SubCategoryController::class, 'datatables'])->name('admin-subcat-datatables'); //JSON REQUEST
        Route::get('/subcategory', [App\Http\Controllers\Admin\SubCategoryController::class, 'index'])->name('admin-subcat-index');
        Route::get('/subcategory/create', [App\Http\Controllers\Admin\SubCategoryController::class, 'create'])->name('admin-subcat-create');
        Route::post('/subcategory/create', [App\Http\Controllers\Admin\SubCategoryController::class, 'store'])->name('admin-subcat-store');
        Route::get('/subcategory/edit/{id}', [App\Http\Controllers\Admin\SubCategoryController::class, 'edit'])->name('admin-subcat-edit');
        Route::post('/subcategory/edit/{id}', [App\Http\Controllers\Admin\SubCategoryController::class, 'update'])->name('admin-subcat-update');
        Route::get('/subcategory/delete/{id}', [App\Http\Controllers\Admin\SubCategoryController::class, 'destroy'])->name('admin-subcat-delete');
        Route::get('/subcategory/status/{id1}/{id2}', [App\Http\Controllers\Admin\SubCategoryController::class, 'status'])->name('admin-subcat-status');
        Route::get('/load/subcategories/{id}/', [App\Http\Controllers\Admin\SubCategoryController::class, 'load'])->name('admin-subcat-load'); //JSON REQUEST
    
        // SUBCATEGORY SECTION ENDS------------
    
        // CHILDCATEGORY SECTION ------------
    
        Route::get('/childcategory/datatables', [App\Http\Controllers\Admin\ChildCategoryController::class, 'datatables'])->name('admin-childcat-datatables'); //JSON REQUEST
        Route::get('/childcategory', [App\Http\Controllers\Admin\ChildCategoryController::class, 'index'])->name('admin-childcat-index');
        Route::get('/childcategory/create', [App\Http\Controllers\Admin\ChildCategoryController::class, 'create'])->name('admin-childcat-create');
        Route::post('/childcategory/create', [App\Http\Controllers\Admin\ChildCategoryController::class, 'store'])->name('admin-childcat-store');
        Route::get('/childcategory/edit/{id}', [App\Http\Controllers\Admin\ChildCategoryController::class, 'edit'])->name('admin-childcat-edit');
        Route::post('/childcategory/edit/{id}', [App\Http\Controllers\Admin\ChildCategoryController::class, 'update'])->name('admin-childcat-update');
        Route::get('/childcategory/delete/{id}', [App\Http\Controllers\Admin\ChildCategoryController::class, 'destroy'])->name('admin-childcat-delete');
        Route::get('/childcategory/status/{id1}/{id2}', [App\Http\Controllers\Admin\ChildCategoryController::class, 'status'])->name('admin-childcat-status');
        Route::get('/load/childcategories/{id}/', [App\Http\Controllers\Admin\ChildCategoryController::class, 'load'])->name('admin-childcat-load'); //JSON REQUEST
    
        // CHILDCATEGORY SECTION ENDS------------
    
    });
    Route::group(['middleware' => 'permissions:bulk_product_upload'], function() {

        Route::get('/products/import', [App\Http\Controllers\Admin\ProductController::class, 'import'])->name('admin-prod-import');
        Route::post('/products/import-submit', [App\Http\Controllers\Admin\ProductController::class, 'importSubmit'])->name('admin-prod-importsubmit');
    
    });
    
    //------------ ADMIN CSV IMPORT SECTION ENDS ------------
    
    //------------ ADMIN PRODUCT DISCUSSION SECTION ------------
    
    Route::group(['middleware' => 'permissions:product_discussion'], function() {
    
        // RATING SECTION ENDS------------
    
        Route::get('/ratings/datatables', [App\Http\Controllers\Admin\RatingController::class, 'datatables'])->name('admin-rating-datatables'); //JSON REQUEST
        Route::get('/ratings', [App\Http\Controllers\Admin\RatingController::class, 'index'])->name('admin-rating-index');
        Route::get('/ratings/delete/{id}', [App\Http\Controllers\Admin\RatingController::class, 'destroy'])->name('admin-rating-delete');
        Route::get('/ratings/show/{id}', [App\Http\Controllers\Admin\RatingController::class, 'show'])->name('admin-rating-show');
    
        // RATING SECTION ENDS------------
    
        // COMMENT SECTION ------------
    
        Route::get('/comments/datatables', [App\Http\Controllers\Admin\CommentController::class, 'datatables'])->name('admin-comment-datatables'); //JSON REQUEST
        Route::get('/comments', [App\Http\Controllers\Admin\CommentController::class, 'index'])->name('admin-comment-index');
        Route::get('/comments/delete/{id}', [App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('admin-comment-delete');
        Route::get('/comments/show/{id}', [App\Http\Controllers\Admin\CommentController::class, 'show'])->name('admin-comment-show');
    
        // COMMENT CHECK
        Route::get('/general-settings/comment/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'comment'])->name('admin-gs-iscomment');
        // COMMENT CHECK ENDS
    
        // COMMENT SECTION ENDS ------------
    
        // REPORT SECTION ------------
    
        Route::get('/reports/datatables', [App\Http\Controllers\Admin\ReportController::class, 'datatables'])->name('admin-report-datatables'); //JSON REQUEST
        Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin-report-index');
        Route::get('/reports/delete/{id}', [App\Http\Controllers\Admin\ReportController::class, 'destroy'])->name('admin-report-delete');
        Route::get('/reports/show/{id}', [App\Http\Controllers\Admin\ReportController::class, 'show'])->name('admin-report-show');
    
        // REPORT CHECK
        Route::get('/general-settings/report/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'isreport'])->name('admin-gs-isreport');
        // REPORT CHECK ENDS
    
        // REPORT SECTION ENDS ------------
    
    });
    
    //------------ ADMIN PRODUCT DISCUSSION SECTION ENDS ------------
    
    
    //------------ ADMIN COUPON SECTION ------------
    
    Route::group(['middleware' => 'permissions:set_coupons'], function() {
    
        Route::get('/coupon/datatables', [App\Http\Controllers\Admin\CouponController::class, 'datatables'])->name('admin-coupon-datatables'); //JSON REQUEST
        Route::get('/coupon', [App\Http\Controllers\Admin\CouponController::class, 'index'])->name('admin-coupon-index');
        Route::get('/coupon/create', [App\Http\Controllers\Admin\CouponController::class, 'create'])->name('admin-coupon-create');
        Route::post('/coupon/create', [App\Http\Controllers\Admin\CouponController::class, 'store'])->name('admin-coupon-store');
        Route::get('/coupon/edit/{id}', [App\Http\Controllers\Admin\CouponController::class, 'edit'])->name('admin-coupon-edit');
        Route::post('/coupon/edit/{id}', [App\Http\Controllers\Admin\CouponController::class, 'update'])->name('admin-coupon-update');
        Route::get('/coupon/delete/{id}', [App\Http\Controllers\Admin\CouponController::class, 'destroy'])->name('admin-coupon-delete');
        Route::get('/coupon/status/{id1}/{id2}', [App\Http\Controllers\Admin\CouponController::class, 'status'])->name('admin-coupon-status');
    
    });
    
    //------------ ADMIN COUPON SECTION ENDS------------
    
    //------------ ADMIN BLOG SECTION ------------
    
    Route::group(['middleware' => 'permissions:blog'], function() {
    
        Route::get('/blog/datatables', [App\Http\Controllers\Admin\BlogController::class, 'datatables'])->name('admin-blog-datatables'); //JSON REQUEST
        Route::get('/blog', [App\Http\Controllers\Admin\BlogController::class, 'index'])->name('admin-blog-index');
        Route::get('/blog/create', [App\Http\Controllers\Admin\BlogController::class, 'create'])->name('admin-blog-create');
        Route::post('/blog/create', [App\Http\Controllers\Admin\BlogController::class, 'store'])->name('admin-blog-store');
        Route::get('/blog/edit/{id}', [App\Http\Controllers\Admin\BlogController::class, 'edit'])->name('admin-blog-edit');
        Route::post('/blog/edit/{id}', [App\Http\Controllers\Admin\BlogController::class, 'update'])->name('admin-blog-update');
        Route::get('/blog/delete/{id}', [App\Http\Controllers\Admin\BlogController::class, 'destroy'])->name('admin-blog-delete');
    
        Route::get('/blog/category/datatables', [App\Http\Controllers\Admin\BlogCategoryController::class, 'datatables'])->name('admin-cblog-datatables'); //JSON REQUEST
        Route::get('/blog/category', [App\Http\Controllers\Admin\BlogCategoryController::class, 'index'])->name('admin-cblog-index');
        Route::get('/blog/category/create', [App\Http\Controllers\Admin\BlogCategoryController::class, 'create'])->name('admin-cblog-create');
        Route::post('/blog/category/create', [App\Http\Controllers\Admin\BlogCategoryController::class, 'store'])->name('admin-cblog-store');
        Route::get('/blog/category/edit/{id}', [App\Http\Controllers\Admin\BlogCategoryController::class, 'edit'])->name('admin-cblog-edit');
        Route::post('/blog/category/edit/{id}', [App\Http\Controllers\Admin\BlogCategoryController::class, 'update'])->name('admin-cblog-update');
        Route::get('/blog/category/delete/{id}', [App\Http\Controllers\Admin\BlogCategoryController::class, 'destroy'])->name('admin-cblog-delete');
    
    });

    Route::group(['middleware' => 'permissions:messages'], function() {

        Route::get('/messages/datatables/{type}', [App\Http\Controllers\Admin\MessageController::class, 'datatables'])->name('admin-message-datatables');
        Route::get('/tickets', [App\Http\Controllers\Admin\MessageController::class, 'index'])->name('admin-message-index');
        Route::get('/disputes', [App\Http\Controllers\Admin\MessageController::class, 'disputes'])->name('admin-message-dispute');
        Route::get('/message/{id}', [App\Http\Controllers\Admin\MessageController::class, 'message'])->name('admin-message-show');
        Route::get('/message/load/{id}', [App\Http\Controllers\Admin\MessageController::class, 'messageshow'])->name('admin-message-load');
        Route::post('/message/post', [App\Http\Controllers\Admin\MessageController::class, 'postmessage'])->name('admin-message-store');
        Route::get('/message/{id}/delete', [App\Http\Controllers\Admin\MessageController::class, 'messagedelete'])->name('admin-message-delete');
        Route::post('/user/send/message', [App\Http\Controllers\Admin\MessageController::class, 'usercontact'])->name('admin-send-message');
    
    });
    
    //------------ ADMIN USER MESSAGE SECTION ENDS ------------
    
    //------------ ADMIN GENERAL SETTINGS SECTION ------------
    
    Route::group(['middleware' => 'permissions:general_settings'], function() {
    
        Route::get('/general-settings/logo', [App\Http\Controllers\Admin\GeneralSettingController::class, 'logo'])->name('admin-gs-logo');
        Route::get('/general-settings/favicon', [App\Http\Controllers\Admin\GeneralSettingController::class, 'fav'])->name('admin-gs-fav');
        Route::get('/general-settings/loader', [App\Http\Controllers\Admin\GeneralSettingController::class, 'load'])->name('admin-gs-load');
        Route::get('/general-settings/contents', [App\Http\Controllers\Admin\GeneralSettingController::class, 'contents'])->name('admin-gs-contents');
        Route::get('/general-settings/footer', [App\Http\Controllers\Admin\GeneralSettingController::class, 'footer'])->name('admin-gs-footer');
        Route::get('/general-settings/affilate', [App\Http\Controllers\Admin\GeneralSettingController::class, 'affilate'])->name('admin-gs-affilate');
        Route::get('/general-settings/error-banner', [App\Http\Controllers\Admin\GeneralSettingController::class, 'errorbanner'])->name('admin-gs-error-banner');
        Route::get('/general-settings/popup', [App\Http\Controllers\Admin\GeneralSettingController::class, 'popup'])->name('admin-gs-popup');
        Route::get('/general-settings/maintenance', [App\Http\Controllers\Admin\GeneralSettingController::class, 'maintain'])->name('admin-gs-maintenance');
    
        //------------ ADMIN PICKUP LOCATION ------------
    
        Route::get('/pickup/datatables', [App\Http\Controllers\Admin\PickupController::class, 'datatables'])->name('admin-pick-datatables'); //JSON REQUEST
        Route::get('/pickup', [App\Http\Controllers\Admin\PickupController::class, 'index'])->name('admin-pick-index');
        Route::get('/pickup/create', [App\Http\Controllers\Admin\PickupController::class, 'create'])->name('admin-pick-create');
        Route::post('/pickup/create', [App\Http\Controllers\Admin\PickupController::class, 'store'])->name('admin-pick-store');
        Route::get('/pickup/edit/{id}', [App\Http\Controllers\Admin\PickupController::class, 'edit'])->name('admin-pick-edit');
        Route::post('/pickup/edit/{id}', [App\Http\Controllers\Admin\PickupController::class, 'update'])->name('admin-pick-update');
        Route::get('/pickup/delete/{id}', [App\Http\Controllers\Admin\PickupController::class, 'destroy'])->name('admin-pick-delete');
    
        //------------ ADMIN PICKUP LOCATION ENDS ------------
    
        //------------ ADMIN SHIPPING ------------
    
        Route::get('/shipping/datatables', [App\Http\Controllers\Admin\ShippingController::class, 'datatables'])->name('admin-shipping-datatables');
        Route::get('/shipping', [App\Http\Controllers\Admin\ShippingController::class, 'index'])->name('admin-shipping-index');
        Route::get('/shipping/create', [App\Http\Controllers\Admin\ShippingController::class, 'create'])->name('admin-shipping-create');
        Route::post('/shipping/create', [App\Http\Controllers\Admin\ShippingController::class, 'store'])->name('admin-shipping-store');
        Route::get('/shipping/edit/{id}', [App\Http\Controllers\Admin\ShippingController::class, 'edit'])->name('admin-shipping-edit');
        Route::post('/shipping/edit/{id}', [App\Http\Controllers\Admin\ShippingController::class, 'update'])->name('admin-shipping-update');
        Route::get('/shipping/delete/{id}', [App\Http\Controllers\Admin\ShippingController::class, 'destroy'])->name('admin-shipping-delete');
    
        //------------ ADMIN SHIPPING ENDS ------------
    
        //------------ ADMIN PACKAGE ------------
    
        Route::get('/package/datatables', [App\Http\Controllers\Admin\PackageController::class, 'datatables'])->name('admin-package-datatables');
        Route::get('/package', [App\Http\Controllers\Admin\PackageController::class, 'index'])->name('admin-package-index');
        Route::get('/package/create', [App\Http\Controllers\Admin\PackageController::class, 'create'])->name('admin-package-create');
        Route::post('/package/create', [App\Http\Controllers\Admin\PackageController::class, 'store'])->name('admin-package-store');
        Route::get('/package/edit/{id}', [App\Http\Controllers\Admin\PackageController::class, 'edit'])->name('admin-package-edit');
        Route::post('/package/edit/{id}', [App\Http\Controllers\Admin\PackageController::class, 'update'])->name('admin-package-update');
        Route::get('/package/delete/{id}', [App\Http\Controllers\Admin\PackageController::class, 'destroy'])->name('admin-package-delete');
    
        //------------ ADMIN PACKAGE ENDS ------------
    
        //------------ ADMIN GENERAL SETTINGS JSON SECTION ------------
    
        Route::get('/general-settings/home/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'ishome'])->name('admin-gs-ishome');
        Route::get('/general-settings/disqus/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'isdisqus'])->name('admin-gs-isdisqus');
        Route::get('/general-settings/loader/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'isloader'])->name('admin-gs-isloader');
        Route::get('/general-settings/email-verify/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'isemailverify'])->name('admin-gs-is-email-verify');
        Route::get('/general-settings/popup/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'ispopup'])->name('admin-gs-ispopup');
        Route::get('/general-settings/admin/loader/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'isadminloader'])->name('admin-gs-is-admin-loader');
        Route::get('/general-settings/talkto/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'talkto'])->name('admin-gs-talkto');
        Route::get('/general-settings/multiple/shipping/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'mship'])->name('admin-gs-mship');
        Route::get('/general-settings/multiple/packaging/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'mpackage'])->name('admin-gs-mpackage');
        Route::get('/general-settings/security/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'issecure'])->name('admin-gs-secure');
        Route::get('/general-settings/stock/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'stock'])->name('admin-gs-stock');
        Route::get('/general-settings/maintain/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'ismaintain'])->name('admin-gs-maintain');
        Route::get('/general-settings/affilate/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'isaffilate'])->name('admin-gs-isaffilate');
        Route::get('/general-settings/capcha/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'iscapcha'])->name('admin-gs-iscapcha');
    
        //------------ ADMIN GENERAL SETTINGS JSON SECTION ENDS ------------
    
    });
    Route::group(['middleware' => 'permissions:home_page_settings'], function () {

        //------------ ADMIN SLIDER SECTION ------------
        Route::get('/slider/datatables', [App\Http\Controllers\Admin\SliderController::class, 'datatables'])->name('admin-sl-datatables'); // JSON REQUEST
        Route::get('/slider', [App\Http\Controllers\Admin\SliderController::class, 'index'])->name('admin-sl-index');
        Route::get('/slider/create', [App\Http\Controllers\Admin\SliderController::class, 'create'])->name('admin-sl-create');
        Route::post('/slider/create', [App\Http\Controllers\Admin\SliderController::class, 'store'])->name('admin-sl-store');
        Route::get('/slider/edit/{id}', [App\Http\Controllers\Admin\SliderController::class, 'edit'])->name('admin-sl-edit');
        Route::post('/slider/edit/{id}', [App\Http\Controllers\Admin\SliderController::class, 'update'])->name('admin-sl-update');
        Route::get('/slider/delete/{id}', [App\Http\Controllers\Admin\SliderController::class, 'destroy'])->name('admin-sl-delete');
        //------------ ADMIN SLIDER SECTION ENDS ------------
    
        //------------ FEATURED LINK SECTION ------------
        Route::get('/featuredlink/datatables', [App\Http\Controllers\Admin\FeaturedLinkController::class, 'datatables'])->name('admin-featuredlink-datatables');
        Route::get('/featuredlink', [App\Http\Controllers\Admin\FeaturedLinkController::class, 'index'])->name('admin-featuredlink-index');
        Route::get('/featuredlink/create', [App\Http\Controllers\Admin\FeaturedLinkController::class, 'create'])->name('admin-featuredlink-create');
        Route::post('/featuredlink/create', [App\Http\Controllers\Admin\FeaturedLinkController::class, 'store'])->name('admin-featuredlink-store');
        Route::get('/featuredlink/edit/{id}', [App\Http\Controllers\Admin\FeaturedLinkController::class, 'edit'])->name('admin-featuredlink-edit');
        Route::post('/featuredlink/edit/{id}', [App\Http\Controllers\Admin\FeaturedLinkController::class, 'update'])->name('admin-featuredlink-update');
        Route::get('/featuredlink/delete/{id}', [App\Http\Controllers\Admin\FeaturedLinkController::class, 'destroy'])->name('admin-featuredlink-delete');
        //------------ FEATURED LINK SECTION ENDS ------------
    
        //------------ FEATURED BANNER SECTION ------------
        Route::get('/featuredbanner/datatables', [App\Http\Controllers\Admin\FeaturedBannerController::class, 'datatables'])->name('admin-featuredbanner-datatables');
        Route::get('/featuredbanner', [App\Http\Controllers\Admin\FeaturedBannerController::class, 'index'])->name('admin-featuredbanner-index');
        Route::get('/featuredbanner/create', [App\Http\Controllers\Admin\FeaturedBannerController::class, 'create'])->name('admin-featuredbanner-create');
        Route::post('/featuredbanner/create', [App\Http\Controllers\Admin\FeaturedBannerController::class, 'store'])->name('admin-featuredbanner-store');
        Route::get('/featuredbanner/edit/{id}', [App\Http\Controllers\Admin\FeaturedBannerController::class, 'edit'])->name('admin-featuredbanner-edit');
        Route::post('/featuredbanner/edit/{id}', [App\Http\Controllers\Admin\FeaturedBannerController::class, 'update'])->name('admin-featuredbanner-update');
        Route::get('/featuredbanner/delete/{id}', [App\Http\Controllers\Admin\FeaturedBannerController::class, 'destroy'])->name('admin-featuredbanner-delete');
        //------------ FEATURED BANNER SECTION ENDS ------------
    
        //------------ ADMIN SERVICE SECTION ------------
        Route::get('/service/datatables', [App\Http\Controllers\Admin\ServiceController::class, 'datatables'])->name('admin-service-datatables'); // JSON REQUEST
        Route::get('/service', [App\Http\Controllers\Admin\ServiceController::class, 'index'])->name('admin-service-index');
        Route::get('/service/create', [App\Http\Controllers\Admin\ServiceController::class, 'create'])->name('admin-service-create');
        Route::post('/service/create', [App\Http\Controllers\Admin\ServiceController::class, 'store'])->name('admin-service-store');
        Route::get('/service/edit/{id}', [App\Http\Controllers\Admin\ServiceController::class, 'edit'])->name('admin-service-edit');
        Route::post('/service/edit/{id}', [App\Http\Controllers\Admin\ServiceController::class, 'update'])->name('admin-service-update');
        Route::get('/service/delete/{id}', [App\Http\Controllers\Admin\ServiceController::class, 'destroy'])->name('admin-service-delete');
        //------------ ADMIN SERVICE SECTION ENDS ------------
    
        //------------ ADMIN BANNER SECTION ------------
        Route::get('/banner/datatables/{type}', [App\Http\Controllers\Admin\BannerController::class, 'datatables'])->name('admin-sb-datatables'); // JSON REQUEST
        Route::get('top/small/banner/', [App\Http\Controllers\Admin\BannerController::class, 'index'])->name('admin-sb-index');
        Route::get('large/banner/', [App\Http\Controllers\Admin\BannerController::class, 'large'])->name('admin-sb-large');
        Route::get('bottom/small/banner/', [App\Http\Controllers\Admin\BannerController::class, 'bottom'])->name('admin-sb-bottom');
        Route::get('top/small/banner/create', [App\Http\Controllers\Admin\BannerController::class, 'create'])->name('admin-sb-create');
        Route::get('large/banner/create', [App\Http\Controllers\Admin\BannerController::class, 'largecreate'])->name('admin-sb-create-large');
        Route::get('bottom/small/banner/create', [App\Http\Controllers\Admin\BannerController::class, 'bottomcreate'])->name('admin-sb-create-bottom');
        Route::post('/banner/create', [App\Http\Controllers\Admin\BannerController::class, 'store'])->name('admin-sb-store');
        Route::get('/banner/edit/{id}', [App\Http\Controllers\Admin\BannerController::class, 'edit'])->name('admin-sb-edit');
        Route::post('/banner/edit/{id}', [App\Http\Controllers\Admin\BannerController::class, 'update'])->name('admin-sb-update');
        Route::get('/banner/delete/{id}', [App\Http\Controllers\Admin\BannerController::class, 'destroy'])->name('admin-sb-delete');
        //------------ ADMIN BANNER SECTION ENDS ------------
    
        //------------ ADMIN REVIEW SECTION ------------
        Route::get('/review/datatables', [App\Http\Controllers\Admin\ReviewController::class, 'datatables'])->name('admin-review-datatables'); // JSON REQUEST
        Route::get('/review', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('admin-review-index');
        Route::get('/review/create', [App\Http\Controllers\Admin\ReviewController::class, 'create'])->name('admin-review-create');
        Route::post('/review/create', [App\Http\Controllers\Admin\ReviewController::class, 'store'])->name('admin-review-store');
        Route::get('/review/edit/{id}', [App\Http\Controllers\Admin\ReviewController::class, 'edit'])->name('admin-review-edit');
        Route::post('/review/edit/{id}', [App\Http\Controllers\Admin\ReviewController::class, 'update'])->name('admin-review-update');
        Route::get('/review/delete/{id}', [App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('admin-review-delete');
        //------------ ADMIN REVIEW SECTION ENDS ------------
    
        //------------ ADMIN PARTNER SECTION ------------
        Route::get('/partner/datatables', [App\Http\Controllers\Admin\PartnerController::class, 'datatables'])->name('admin-partner-datatables');
        Route::get('/partner', [App\Http\Controllers\Admin\PartnerController::class, 'index'])->name('admin-partner-index');
        Route::get('/partner/create', [App\Http\Controllers\Admin\PartnerController::class, 'create'])->name('admin-partner-create');
        Route::post('/partner/create', [App\Http\Controllers\Admin\PartnerController::class, 'store'])->name('admin-partner-store');
        Route::get('/partner/edit/{id}', [App\Http\Controllers\Admin\PartnerController::class, 'edit'])->name('admin-partner-edit');
        Route::post('/partner/edit/{id}', [App\Http\Controllers\Admin\PartnerController::class, 'update'])->name('admin-partner-update');
        Route::get('/partner/delete/{id}', [App\Http\Controllers\Admin\PartnerController::class, 'destroy'])->name('admin-partner-delete');
        //------------ ADMIN PARTNER SECTION ENDS ------------
    
        //------------ ADMIN PAGE SETTINGS SECTION ------------
        Route::get('/page-settings/customize', [App\Http\Controllers\Admin\PageSettingController::class, 'customize'])->name('admin-ps-customize');
        Route::get('/page-settings/big-save', [App\Http\Controllers\Admin\PageSettingController::class, 'big_save'])->name('admin-ps-big-save');
        Route::get('/page-settings/best-seller', [App\Http\Controllers\Admin\PageSettingController::class, 'best_seller'])->name('admin-ps-best-seller');
        //------------ ADMIN HOME PAGE SETTINGS SECTION ENDS ------------
    
    });
    
    Route::group(['middleware' => 'permissions:menu_page_settings'], function () {
    
        //------------ ADMIN MENU PAGE SETTINGS SECTION ------------
        //------------ ADMIN FAQ SECTION ------------
        Route::get('/faq/datatables', [App\Http\Controllers\Admin\FaqController::class, 'datatables'])->name('admin-faq-datatables'); // JSON REQUEST
        Route::get('/faq', [App\Http\Controllers\Admin\FaqController::class, 'index'])->name('admin-faq-index');
        Route::get('/faq/create', [App\Http\Controllers\Admin\FaqController::class, 'create'])->name('admin-faq-create');
        Route::post('/faq/create', [App\Http\Controllers\Admin\FaqController::class, 'store'])->name('admin-faq-store');
        Route::get('/faq/edit/{id}', [App\Http\Controllers\Admin\FaqController::class, 'edit'])->name('admin-faq-edit');
        Route::post('/faq/update/{id}', [App\Http\Controllers\Admin\FaqController::class, 'update'])->name('admin-faq-update');
        Route::get('/faq/delete/{id}', [App\Http\Controllers\Admin\FaqController::class, 'destroy'])->name('admin-faq-delete');
        //------------ ADMIN FAQ SECTION ENDS ------------
    
        //------------ ADMIN PAGE SECTION ------------
        Route::get('/page/datatables', [App\Http\Controllers\Admin\PageController::class, 'datatables'])->name('admin-page-datatables'); // JSON REQUEST
        Route::get('/page', [App\Http\Controllers\Admin\PageController::class, 'index'])->name('admin-page-index');
        Route::get('/page/create', [App\Http\Controllers\Admin\PageController::class, 'create'])->name('admin-page-create');
        Route::post('/page/create', [App\Http\Controllers\Admin\PageController::class, 'store'])->name('admin-page-store');
        Route::get('/page/edit/{id}', [App\Http\Controllers\Admin\PageController::class, 'edit'])->name('admin-page-edit');
        Route::post('/page/update/{id}', [App\Http\Controllers\Admin\PageController::class, 'update'])->name('admin-page-update');
        Route::get('/page/delete/{id}', [App\Http\Controllers\Admin\PageController::class, 'destroy'])->name('admin-page-delete');
        Route::get('/page/header/{id1}/{id2}', [App\Http\Controllers\Admin\PageController::class, 'header'])->name('admin-page-header');
        Route::get('/page/footer/{id1}/{id2}', [App\Http\Controllers\Admin\PageController::class, 'footer'])->name('admin-page-footer');
        //------------ ADMIN PAGE SECTION ENDS ------------
    
        Route::get('/general-settings/contact/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'iscontact'])->name('admin-gs-iscontact');
        Route::get('/general-settings/faq/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'isfaq'])->name('admin-gs-isfaq');
        Route::get('/page-settings/contact', [App\Http\Controllers\Admin\PageSettingController::class, 'contact'])->name('admin-ps-contact');
        Route::post('/page-settings/update/all', [App\Http\Controllers\Admin\PageSettingController::class, 'update'])->name('admin-ps-update');
    
    });
//------------ ADMIN EMAIL SETTINGS SECTION ------------

Route::group(['middleware' => 'permissions:emails_settings'], function () {

    Route::get('/email-templates/datatables', [App\Http\Controllers\Admin\EmailController::class, 'datatables'])->name('admin-mail-datatables');
    Route::get('/email-templates', [App\Http\Controllers\Admin\EmailController::class, 'index'])->name('admin-mail-index');
    Route::get('/email-templates/{id}', [App\Http\Controllers\Admin\EmailController::class, 'edit'])->name('admin-mail-edit');
    Route::post('/email-templates/{id}', [App\Http\Controllers\Admin\EmailController::class, 'update'])->name('admin-mail-update');
    Route::get('/email-config', [App\Http\Controllers\Admin\EmailController::class, 'config'])->name('admin-mail-config');
    Route::get('/groupemail', [App\Http\Controllers\Admin\EmailController::class, 'groupemail'])->name('admin-group-show');
    Route::post('/groupemailpost', [App\Http\Controllers\Admin\EmailController::class, 'groupemailpost'])->name('admin-group-submit');
    Route::get('/issmtp/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'issmtp'])->name('admin-gs-issmtp');

});

//------------ ADMIN EMAIL SETTINGS SECTION ENDS ------------

//------------ ADMIN PAYMENT SETTINGS SECTION ------------

Route::group(['middleware' => 'permissions:payment_settings'], function () {

    // Payment Informations
    Route::get('/payment-informations', [App\Http\Controllers\Admin\GeneralSettingController::class, 'paymentsinfo'])->name('admin-gs-payments');
    Route::get('/general-settings/guest/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'guest'])->name('admin-gs-guest');
    Route::get('/general-settings/paypal/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'paypal'])->name('admin-gs-paypal');
    Route::get('/general-settings/instamojo/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'instamojo'])->name('admin-gs-instamojo');
    Route::get('/general-settings/paystack/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'paystack'])->name('admin-gs-paystack');
    Route::get('/general-settings/stripe/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'stripe'])->name('admin-gs-stripe');
    Route::get('/general-settings/cod/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'cod'])->name('admin-gs-cod');
    Route::get('/general-settings/paytm/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'paytm'])->name('admin-gs-paytm');
    Route::get('/general-settings/molly/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'molly'])->name('admin-gs-molly');
    Route::get('/general-settings/razor/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'razor'])->name('admin-gs-razor');
    Route::get('/general-settings/ssl/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'ssl'])->name('admin-gs-ssl');
    Route::get('/general-settings/voguepay/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'voguepay'])->name('admin-gs-voguepay');
    Route::get('/general-settings/authorize/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'authorizes'])->name('admin-gs-authorize');
    Route::get('/general-settings/mercadopago/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'mercadopago'])->name('admin-gs-mercadopago');
    Route::get('/general-settings/flutter/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'flutter'])->name('admin-gs-flutter');
    Route::get('/general-settings/twocheckout/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'twocheckout'])->name('admin-gs-twocheckout');
    Route::get('/general-settings/buy-now/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'buyNow'])->name('admin-gs-buy-now');

    // Payment Gateways
    Route::get('/paymentgateway/datatables', [App\Http\Controllers\Admin\PaymentGatewayController::class, 'datatables'])->name('admin-payment-datatables'); // JSON REQUEST
    Route::get('/paymentgateway', [App\Http\Controllers\Admin\PaymentGatewayController::class, 'index'])->name('admin-payment-index');
    Route::get('/paymentgateway/create', [App\Http\Controllers\Admin\PaymentGatewayController::class, 'create'])->name('admin-payment-create');
    Route::post('/paymentgateway/create', [App\Http\Controllers\Admin\PaymentGatewayController::class, 'store'])->name('admin-payment-store');
    Route::get('/paymentgateway/edit/{id}', [App\Http\Controllers\Admin\PaymentGatewayController::class, 'edit'])->name('admin-payment-edit');
    Route::post('/paymentgateway/update/{id}', [App\Http\Controllers\Admin\PaymentGatewayController::class, 'update'])->name('admin-payment-update');
    Route::get('/paymentgateway/delete/{id}', [App\Http\Controllers\Admin\PaymentGatewayController::class, 'destroy'])->name('admin-payment-delete');
    Route::get('/paymentgateway/status/{id1}/{id2}', [App\Http\Controllers\Admin\PaymentGatewayController::class, 'status'])->name('admin-payment-status');

    // Currency Settings
    Route::get('/general-settings/currency/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'currency'])->name('admin-gs-iscurrency');
    Route::get('/currency/datatables', [App\Http\Controllers\Admin\CurrencyController::class, 'datatables'])->name('admin-currency-datatables'); // JSON REQUEST
    Route::get('/currency', [App\Http\Controllers\Admin\CurrencyController::class, 'index'])->name('admin-currency-index');
    Route::get('/currency/create', [App\Http\Controllers\Admin\CurrencyController::class, 'create'])->name('admin-currency-create');
    Route::post('/currency/create', [App\Http\Controllers\Admin\CurrencyController::class, 'store'])->name('admin-currency-store');
    Route::get('/currency/edit/{id}', [App\Http\Controllers\Admin\CurrencyController::class, 'edit'])->name('admin-currency-edit');
    Route::post('/currency/update/{id}', [App\Http\Controllers\Admin\CurrencyController::class, 'update'])->name('admin-currency-update');
    Route::get('/currency/delete/{id}', [App\Http\Controllers\Admin\CurrencyController::class, 'destroy'])->name('admin-currency-delete');
    Route::get('/currency/status/{id1}/{id2}', [App\Http\Controllers\Admin\CurrencyController::class, 'status'])->name('admin-currency-status');

});

//------------ ADMIN PAYMENT SETTINGS SECTION ENDS ------------

//------------ ADMIN SOCIAL SETTINGS SECTION ------------

Route::group(['middleware' => 'permissions:social_settings'], function () {

    Route::get('/social', [App\Http\Controllers\Admin\SocialSettingController::class, 'index'])->name('admin-social-index');
    Route::post('/social/update', [App\Http\Controllers\Admin\SocialSettingController::class, 'socialupdate'])->name('admin-social-update');
    Route::post('/social/update/all', [App\Http\Controllers\Admin\SocialSettingController::class, 'socialupdateall'])->name('admin-social-update-all');
    Route::get('/social/facebook', [App\Http\Controllers\Admin\SocialSettingController::class, 'facebook'])->name('admin-social-facebook');
    Route::get('/social/google', [App\Http\Controllers\Admin\SocialSettingController::class, 'google'])->name('admin-social-google');
    Route::get('/social/facebook/{status}', [App\Http\Controllers\Admin\SocialSettingController::class, 'facebookup'])->name('admin-social-facebookup');
    Route::get('/social/google/{status}', [App\Http\Controllers\Admin\SocialSettingController::class, 'googleup'])->name('admin-social-googleup');

});


    //------------ ADMIN LANGUAGE SETTINGS SECTION ------------

Route::group(['middleware' => 'permissions:language_settings'], function () {

    // Multiple Language Section
    Route::get('/general-settings/language/{status}', [App\Http\Controllers\Admin\GeneralSettingController::class, 'language'])->name('admin-gs-islanguage');
    // Multiple Language Section Ends

    Route::get('/languages/datatables', [App\Http\Controllers\Admin\LanguageController::class, 'datatables'])->name('admin-lang-datatables'); // JSON REQUEST
    Route::get('/languages', [App\Http\Controllers\Admin\LanguageController::class, 'index'])->name('admin-lang-index');
    Route::get('/languages/create', [App\Http\Controllers\Admin\LanguageController::class, 'create'])->name('admin-lang-create');
    Route::get('/languages/edit/{id}', [App\Http\Controllers\Admin\LanguageController::class, 'edit'])->name('admin-lang-edit');
    Route::post('/languages/create', [App\Http\Controllers\Admin\LanguageController::class, 'store'])->name('admin-lang-store');
    Route::post('/languages/edit/{id}', [App\Http\Controllers\Admin\LanguageController::class, 'update'])->name('admin-lang-update');
    Route::get('/languages/status/{id1}/{id2}', [App\Http\Controllers\Admin\LanguageController::class, 'status'])->name('admin-lang-st');
    Route::get('/languages/delete/{id}', [App\Http\Controllers\Admin\LanguageController::class, 'destroy'])->name('admin-lang-delete');

    // Admin Panel Language Settings Section
    Route::get('/adminlanguages/datatables', [App\Http\Controllers\Admin\AdminLanguageController::class, 'datatables'])->name('admin-tlang-datatables'); // JSON REQUEST
    Route::get('/adminlanguages', [App\Http\Controllers\Admin\AdminLanguageController::class, 'index'])->name('admin-tlang-index');
    Route::get('/adminlanguages/create', [App\Http\Controllers\Admin\AdminLanguageController::class, 'create'])->name('admin-tlang-create');
    Route::get('/adminlanguages/edit/{id}', [App\Http\Controllers\Admin\AdminLanguageController::class, 'edit'])->name('admin-tlang-edit');
    Route::post('/adminlanguages/create', [App\Http\Controllers\Admin\AdminLanguageController::class, 'store'])->name('admin-tlang-store');
    Route::post('/adminlanguages/edit/{id}', [App\Http\Controllers\Admin\AdminLanguageController::class, 'update'])->name('admin-tlang-update');
    Route::get('/adminlanguages/status/{id1}/{id2}', [App\Http\Controllers\Admin\AdminLanguageController::class, 'status'])->name('admin-tlang-st');
    Route::get('/adminlanguages/delete/{id}', [App\Http\Controllers\Admin\AdminLanguageController::class, 'destroy'])->name('admin-tlang-delete');

});

//------------ ADMIN LANGUAGE SETTINGS SECTION ENDS ------------

//------------ ADMIN SEO TOOL SETTINGS SECTION ------------

Route::group(['middleware' => 'permissions:seo_tools'], function () {

    Route::get('/seotools/analytics', [App\Http\Controllers\Admin\SeoToolController::class, 'analytics'])->name('admin-seotool-analytics');
    Route::post('/seotools/analytics/update', [App\Http\Controllers\Admin\SeoToolController::class, 'analyticsupdate'])->name('admin-seotool-analytics-update');
    Route::get('/seotools/keywords', [App\Http\Controllers\Admin\SeoToolController::class, 'keywords'])->name('admin-seotool-keywords');
    Route::post('/seotools/keywords/update', [App\Http\Controllers\Admin\SeoToolController::class, 'keywordsupdate'])->name('admin-seotool-keywords-update');
    Route::get('/products/popular/{id}', [App\Http\Controllers\Admin\SeoToolController::class, 'popular'])->name('admin-prod-popular');

});

//------------ ADMIN SEO TOOL SETTINGS SECTION ENDS ------------

//------------ ADMIN STAFF SECTION ------------

Route::group(['middleware' => 'permissions:manage_staffs'], function () {

    Route::get('/staff/datatables', [App\Http\Controllers\Admin\StaffController::class, 'datatables'])->name('admin-staff-datatables');
    Route::get('/staff', [App\Http\Controllers\Admin\StaffController::class, 'index'])->name('admin-staff-index');
    Route::get('/staff/create', [App\Http\Controllers\Admin\StaffController::class, 'create'])->name('admin-staff-create');
    Route::post('/staff/create', [App\Http\Controllers\Admin\StaffController::class, 'store'])->name('admin-staff-store');
    Route::get('/staff/edit/{id}', [App\Http\Controllers\Admin\StaffController::class, 'edit'])->name('admin-staff-edit');
    Route::post('/staff/update/{id}', [App\Http\Controllers\Admin\StaffController::class, 'update'])->name('admin-staff-update');
    Route::get('/staff/show/{id}', [App\Http\Controllers\Admin\StaffController::class, 'show'])->name('admin-staff-show');
    Route::get('/staff/delete/{id}', [App\Http\Controllers\Admin\StaffController::class, 'destroy'])->name('admin-staff-delete');

});

//------------ ADMIN STAFF SECTION ENDS ------------

//------------ ADMIN SUBSCRIBERS SECTION ------------

Route::group(['middleware' => 'permissions:subscribers'], function () {

    Route::get('/subscribers/datatables', [App\Http\Controllers\Admin\SubscriberController::class, 'datatables'])->name('admin-subs-datatables'); // JSON REQUEST
    Route::get('/subscribers', [App\Http\Controllers\Admin\SubscriberController::class, 'index'])->name('admin-subs-index');
    Route::get('/subscribers/download', [App\Http\Controllers\Admin\SubscriberController::class, 'download'])->name('admin-subs-download');

});

//------------ ADMIN SUBSCRIBERS ENDS ------------

// ------------ GLOBAL ----------------------

Route::post('/general-settings/update/all', [App\Http\Controllers\Admin\GeneralSettingController::class, 'generalupdate'])->name('admin-gs-update');
Route::post('/general-settings/update/payment', [App\Http\Controllers\Admin\GeneralSettingController::class, 'generalupdatepayment'])->name('admin-gs-update-payment');
Route::post('/general-settings/update/mail', [App\Http\Controllers\Admin\GeneralSettingController::class, 'generalMailUpdate'])->name('admin-gs-update-mail');

// STATUS SECTION
Route::get('/products/status/{id1}/{id2}', [App\Http\Controllers\Admin\ProductController::class, 'status'])->name('admin-prod-status');
// STATUS SECTION ENDS

// FEATURE SECTION
Route::get('/products/feature/{id}', [App\Http\Controllers\Admin\ProductController::class, 'feature'])->name('admin-prod-feature');
Route::post('/products/feature/{id}', [App\Http\Controllers\Admin\ProductController::class, 'featuresubmit'])->name('admin-prod-feature');
// FEATURE SECTION ENDS

// GALLERY SECTION ------------

Route::get('/gallery/show', [App\Http\Controllers\Admin\GalleryController::class, 'show'])->name('admin-gallery-show');
Route::post('/gallery/store', [App\Http\Controllers\Admin\GalleryController::class, 'store'])->name('admin-gallery-store');
Route::get('/gallery/delete', [App\Http\Controllers\Admin\GalleryController::class, 'destroy'])->name('admin-gallery-delete');

// GALLERY SECTION ENDS ------------

Route::post('/page-settings/update/all', [App\Http\Controllers\Admin\PageSettingController::class, 'update'])->name('admin-ps-update');
Route::post('/page-settings/update/home', [App\Http\Controllers\Admin\PageSettingController::class, 'homeupdate'])->name('admin-ps-homeupdate');

// ------------ GLOBAL ENDS ----------------------

// ------------ SUPER ADMIN SECTION ----------------------

Route::group(['middleware' => 'permissions:super'], function () {

    Route::get('/cache/clear', function () {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        return redirect()->route('admin.dashboard')->with('cache', 'System Cache Has Been Removed.');
    })->name('admin-cache-clear');

    Route::get('/check/movescript', [App\Http\Controllers\Admin\DashboardController::class, 'movescript'])->name('admin-move-script');
    Route::get('/generate/backup', [App\Http\Controllers\Admin\DashboardController::class, 'generate_bkup'])->name('admin-generate-backup');
    Route::get('/activation', [App\Http\Controllers\Admin\DashboardController::class, 'activation'])->name('admin-activation-form');
    Route::post('/activation', [App\Http\Controllers\Admin\DashboardController::class, 'activation_submit'])->name('admin-activate-purchase');
    Route::get('/clear/backup', [App\Http\Controllers\Admin\DashboardController::class, 'clear_bkup'])->name('admin-clear-backup');

    // ------------ ROLE SECTION ----------------------

    Route::get('/role/datatables', [App\Http\Controllers\Admin\RoleController::class, 'datatables'])->name('admin-role-datatables');
    Route::get('/role', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('admin-role-index');
    Route::get('/role/create', [App\Http\Controllers\Admin\RoleController::class, 'create'])->name('admin-role-create');
    Route::post('/role/create', [App\Http\Controllers\Admin\RoleController::class, 'store'])->name('admin-role-store');
    Route::get('/role/edit/{id}', [App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('admin-role-edit');
    Route::post('/role/edit/{id}', [App\Http\Controllers\Admin\RoleController::class, 'update'])->name('admin-role-update');
    Route::get('/role/delete/{id}', [App\Http\Controllers\Admin\RoleController::class, 'destroy'])->name('admin-role-delete');


    // ------------ ROLE SECTION ENDS ----------------------

});

// ------------ SUPER ADMIN SECTION ENDS ----------------------


});
    






