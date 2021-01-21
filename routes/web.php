<?php
use App\Http\Controllers\LanguageController;
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

Route::get('dashboard','EmployeeController@dashboard')->name('dashboard');
Route::get('inventory-list','DashboardController@inventoryList')->name('inventory-list');
Route::post('employeelogin','EmployeeController@login')->name('employeelogin');
Route::get('check-in','DashboardController@inventoryadd')->name('check-in');


  /* Check-out module rotues */
  Route::get('check-out','DashboardController@inventoryCheckout')->name('check-out');
  Route::post('storecheckout','CheckoutController@store')->name('storecheckout');


  /*Quickbook online module route */
  // Route::get('qbo/oauth','QuickBookController@qboOauth');
  // Route::get('qbo/success','QuickBookController@qboSuccess');
  // Route::get('qbo/disconnect','QuickBookController@qboDisconnect');

  Route::group(['middleware' => 'auth'], function(){


    /* Customer-Invoice module routes */
    Route::get('/checktoken','InvoiceController@checktoken')->name('checktoken');
    Route::any('/generate_pdf','InvoiceController@generate_pdf')->name('generate_pdf');
    Route::get('/page-customer-invoice','InvoiceController@projectinventoryitem');
    Route::any('/getitemsproject/{id}', 'InvoiceController@getitemsproject');
    Route::post('/store_invoice','InvoiceController@store_invoice')->name('store_invoice');

    /* Project module routes */
    Route::get('/project-list','ProjectController@index');
    Route::view('/add-project','pages/project-add')->name('add-project');
    Route::post('/storeproject','ProjectController@store')->name('storeproject');
    Route::get('/deleteproject/{id}','ProjectController@destroy')->name('deleteproject');
    Route::get('/editproject/{id}','ProjectController@edit')->name('editproject');
    Route::post('/updateproject','ProjectController@update')->name('updateproject');

    /* Color module routes */
    Route::get('/color-list','ColorController@index');
    Route::view('/add-color','pages/color-add')->name('add-color');
    Route::post('/storecolor','ColorController@store')->name('storecolor');
    Route::get('/deletecolor/{id}','ColorController@destroy')->name('deletecolor');
    Route::get('/editcolor/{id}','ColorController@edit')->name('editcolor');
    Route::post('/updatecolor','ColorController@update')->name('updatecolor');

    /* Serevice module routes */
    Route::get('/service-list','ServiceController@index');
    Route::view('/add-service','pages/service-add')->name('add-service');
    Route::post('/storeinventory','ServiceController@store')->name('storeinventory');
    Route::get('/deleteservice/{id}','ServiceController@destroy')->name('deleteservice');
    Route::get('/editservice/{id}','ServiceController@edit')->name('editservice');
    Route::post('/updateservice','ServiceController@update')->name('updateservice');

    /* Inventory module routes */
    Route::get('/page-inventory-list','InventoryController@index');
    Route::post('/createinventory','InventoryController@store')->name('createinventory');
    Route::get('/deleteinventory/{id}','InventoryController@destroy')->name('deleteinventory');
    Route::get('/editinventory/{id}','InventoryController@editInventory')->name('editinventory');
    Route::get('/viewinventory/{id}','InventoryController@viewinventory')->name('viewinventory');
    Route::post('/updateinventory','InventoryController@updateinventory')->name('updateinventory');

    /* customre module routes */
    Route::get('/customer','CustomerController@index')->name('customer');
    Route::post('/customer/store','CustomerController@store')->name('createemployee');
    Route::post('/createemployeeajax','CustomerController@storeajax')->name('createemployeeajax');
    Route::get('/editcustomer/{id}','CustomerController@edit')->name('editcustomer');
    Route::get('/deletecustomer/{id}','CustomerController@destroy')->name('deletecustomer');
    Route::post('/updatecustomer','CustomerController@update')->name('updatecustomer');

    /* user module routes */
    Route::post('/createuser','UsersController@store')->name('createuser');
    Route::get('/deleteuser/{id}','UsersController@destroy')->name('deleteuser');
    Route::get('/edituser/{id}','UsersController@editUser')->name('edituser');
    Route::post('/updateuser','UsersController@updateUser')->name('updateuser');
    Route::view('/change-password', 'pages.change-password')->name('change-password');
    Route::post('/changePassword', 'UsersController@changePassword')->name('changePassword');
    Route::get('/logout','UsersController@logout')->name('logout');

    // dashboard Routes
    Route::get('/','DashboardController@dashboardEcommerce')->name('/');
    Route::get('/dashboard-ecommerce','DashboardController@dashboardEcommerce');
    Route::get('/dashboard-analytics','DashboardController@dashboardAnalytics');

    //Application Routes
    Route::get('/app-email','ApplicationController@emailApplication');
    Route::get('/app-chat','ApplicationController@chatApplication');
    Route::get('/app-todo','ApplicationController@todoApplication');
    Route::get('/app-calendar','ApplicationController@calendarApplication');
    Route::get('/app-kanban','ApplicationController@kanbanApplication');
    Route::get('/app-invoice-view','ApplicationController@invoiceApplication');
    Route::get('/app-invoice-list','ApplicationController@invoiceListApplication');
    Route::get('/app-invoice-edit','ApplicationController@invoiceEditApplication');
    Route::get('/app-invoice-add','ApplicationController@invoiceAddApplication');
    Route::get('/app-file-manager','ApplicationController@fileManagerApplication');

    // Content Page Routes
    Route::get('/content-grid','ContentController@gridContent');
    Route::get('/content-typography','ContentController@typographyContent');
    Route::get('/content-text-utilities','ContentController@textUtilitiesContent');
    Route::get('/content-syntax-highlighter','ContentController@contentSyntaxHighlighter');
    Route::get('/content-helper-classes','ContentController@contentHelperClasses');
    Route::get('/colors','ContentController@colorContent');
    // icons
    Route::get('/icons-livicons','IconsController@liveIcons');
    Route::get('/icons-boxicons','IconsController@boxIcons');
    // card
    Route::get('/card-basic','CardController@basicCard');
    Route::get('/card-actions','CardController@actionCard');
    Route::get('/widgets','CardController@widgets');
    // component route
    Route::get('/component-alerts','ComponentController@alertComponenet');
    Route::get('/component-buttons-basic','ComponentController@buttonComponenet');
    Route::get('/component-breadcrumbs','ComponentController@breadcrumbsComponenet');
    Route::get('/component-carousel','ComponentController@carouselComponenet');
    Route::get('/component-collapse','ComponentController@collapseComponenet');
    Route::get('/component-dropdowns','ComponentController@dropdownComponenet');
    Route::get('/component-list-group','ComponentController@listGroupComponenet');
    Route::get('/component-modals','ComponentController@modalComponenet');
    Route::get('/component-pagination','ComponentController@paginationComponenet');
    Route::get('/component-navbar','ComponentController@navbarComponenet');
    Route::get('/component-tabs-component','ComponentController@tabsComponenet');
    Route::get('/component-pills-component','ComponentController@pillComponenet');
    Route::get('/component-tooltips','ComponentController@tooltipsComponenet');
    Route::get('/component-popovers','ComponentController@popoversComponenet');
    Route::get('/component-badges','ComponentController@badgesComponenet');
    Route::get('/component-pill-badges','ComponentController@pillBadgesComponenet');
    Route::get('/component-progress','ComponentController@progressComponenet');
    Route::get('/component-media-objects','ComponentController@mediaObjectComponenet');
    Route::get('/component-spinner','ComponentController@spinnerComponenet');
    Route::get('/component-bs-toast','ComponentController@toastsComponenet');
    // extra component
    Route::get('/ex-component-avatar','ExComponentController@avatarComponent');
    Route::get('/ex-component-chips','ExComponentController@chipsComponent');
    Route::get('/ex-component-divider','ExComponentController@dividerComponent');
    // form elements
    Route::get('/form-inputs','FormController@inputForm');
    Route::get('/form-input-groups','FormController@inputGroupForm');
    Route::get('/form-number-input','FormController@numberInputForm');
    Route::get('/form-select','FormController@selectForm');
    Route::get('/form-radio','FormController@radioForm');
    Route::get('/form-checkbox','FormController@checkboxForm');
    Route::get('/form-switch','FormController@switchForm');
    Route::get('/form-textarea','FormController@textareaForm');
    Route::get('/form-quill-editor','FormController@quillEditorForm');
    Route::get('/form-file-uploader','FormController@fileUploaderForm');
    Route::get('/form-date-time-picker','FormController@datePickerForm');
    Route::get('/form-layout','FormController@formLayout');
    Route::get('/form-wizard','FormController@formWizard');
    Route::get('/form-validation','FormController@formValidation');
    Route::get('/form-repeater','FormController@formRepeater');
    // table route
    Route::get('/table','TableController@basicTable');
    Route::get('/extended','TableController@extendedTable');
    Route::get('/datatable','TableController@dataTable');
    // page Route
    Route::get('/page-user-profile','PageController@userProfilePage');
    Route::get('/page-faq','PageController@faqPage');
    Route::get('/page-knowledge-base','PageController@knowledgeBasePage');
    Route::get('/page-knowledge-base/categories','PageController@knowledgeCatPage');
    Route::get('/page-knowledge-base/categories/question','PageController@knowledgeQuestionPage');
    Route::get('/page-search','PageController@searchPage');
    Route::get('/page-account-settings','PageController@accountSettingPage');
    // User Route
    Route::get('/page-users-list','UsersController@listUser');
    Route::get('/page-users-view','UsersController@viewUser');
    Route::get('/page-users-edit','UsersController@editUser');
    // Authentication  Route
    Route::get('/auth-login','AuthenticationController@loginPage');
    Route::get('/auth-register','AuthenticationController@registerPage');
    Route::get('/auth-forgot-password','AuthenticationController@forgetPasswordPage');
    Route::get('/auth-reset-password','AuthenticationController@resetPasswordPage');
    Route::get('/auth-lock-screen','AuthenticationController@authLockPage');
    // Miscellaneous
    Route::get('/page-coming-soon','MiscellaneousController@comingSoonPage');
    Route::get('/error-404','MiscellaneousController@error404Page');
    Route::get('/error-500','MiscellaneousController@error500Page');
    Route::get('/page-not-authorized','MiscellaneousController@notAuthPage');
    Route::get('/page-maintenance','MiscellaneousController@maintenancePage');
    // Charts Route
    Route::get('/chart-apex','ChartController@apexChart');
    Route::get('/chart-chartjs','ChartController@chartJs');
    Route::get('/chart-chartist','ChartController@chartist');
    Route::get('/maps-google','ChartController@googleMap');
    // extension route
    Route::get('/ext-component-sweet-alerts','ExtensionsController@sweetAlert');
    Route::get('/ext-component-toastr','ExtensionsController@toastr');
    Route::get('/ext-component-noui-slider','ExtensionsController@noUiSlider');
    Route::get('/ext-component-drag-drop','ExtensionsController@dragComponent');
    Route::get('/ext-component-tour','ExtensionsController@tourComponent');
    Route::get('/ext-component-swiper','ExtensionsController@swiperComponent');
    Route::get('/ext-component-treeview','ExtensionsController@treeviewComponent');
    Route::get('/ext-component-block-ui','ExtensionsController@blockUIComponent');
    Route::get('/ext-component-media-player','ExtensionsController@mediaComponent');
    Route::get('/ext-component-miscellaneous','ExtensionsController@miscellaneous');
    Route::get('/ext-component-i18n','ExtensionsController@i18n');
    // locale Route
    Route::get('lang/{locale}',[LanguageController::class,'swap']);

    // acess controller
    Route::get('/access-control', 'AccessController@index');
    Route::get('/access-control/{roles}', 'AccessController@roles');
    Route::get('/ecommerce', 'AccessController@home')->middleware('role:Admin');
});
Auth::routes();
