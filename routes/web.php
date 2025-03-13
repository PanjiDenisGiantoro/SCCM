<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AiapplicationController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ComponentpageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UsersController;


Route::middleware(['auth'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });
});


Route::controller(\App\Http\Controllers\LoginController::class)->group(function (){
    Route::get('login','login')->name('login');
    Route::post('login','process')->name('login.process');
});
Route::controller(\App\Http\Controllers\DashboardController::class)->group(function (){
    Route::get('home','home')->name('home');
});

Route::middleware(['auth'])->group(function () {
    Route::controller(\App\Http\Controllers\ClientController::class)->group(function () {
        Route::get('client', 'index')->name('client.index');
        Route::post('client', 'store')->name('client.store');
        Route::get('client/list', 'list')->name('client.list');
        Route::get('client/edit/{id}', 'edit')->name('client.edit');
        Route::put('client/update/{id}', 'update')->name('client.update');
        Route::get('client/status/{id}', 'status')->name('client.status');
        Route::get('client/show/{id}', 'show')->name('client.show');
        Route::get('client/getData', 'getData')->name('client.getData');
    });
});

Route::controller(\App\Http\Controllers\ActivityControlller::class)->group(function () {
    Route::get('activity','index')->name('activity.index');
    Route::get('activity/getData','getData')->name('activity.getData');
});

Route::controller(\App\Http\Controllers\EmailController::class)->group(function (){
    Route::get('emails','sendWelcomeEmail')->name('sendWelcomeEmail');
});

Route::controller(HomeController::class)->group(function () {
    Route::get('calendar','calendar')->name('calendar');
    Route::get('chatmessage','chatMessage')->name('chatMessage');
    Route::get('chatempty','chatEmpty')->name('chatEmpty');
    Route::get('email','email')->name('email');
    Route::get('error','error1')->name('error');
    Route::get('faq','faq')->name('faq');
    Route::get('gallery','gallery')->name('gallery');
    Route::get('kanban','kanban')->name('kanban');
    Route::get('pricing','pricing')->name('pricing');
    Route::get('termscondition','termsCondition')->name('termsCondition');
    Route::get('widgets','widgets')->name('widgets');
    Route::get('chatprofile','chatProfile')->name('chatProfile');
    Route::get('veiwdetails','veiwDetails')->name('veiwDetails');
    });

    // aiApplication
Route::prefix('aiapplication')->group(function () {
    Route::controller(AiapplicationController::class)->group(function () {
        Route::get('/codegenerator', 'codeGenerator')->name('codeGenerator');
        Route::get('/codegeneratornew', 'codeGeneratorNew')->name('codeGeneratorNew');
        Route::get('/imagegenerator','imageGenerator')->name('imageGenerator');
        Route::get('/textgeneratornew','textGeneratorNew')->name('textGeneratorNew');
        Route::get('/textgenerator','textGenerator')->name('textGenerator');
        Route::get('/videogenerator','videoGenerator')->name('videoGenerator');
        Route::get('/voicegenerator','voiceGenerator')->name('voiceGenerator');
    });
});

// Authentication
Route::prefix('authentication')->group(function () {
    Route::controller(AuthenticationController::class)->group(function () {
        Route::get('/forgotpassword', 'forgotPassword')->name('forgotPassword');
        Route::get('/signin', 'signIn')->name('signIn');
        Route::get('/signup', 'signUp')->name('signUp');
    });
});

// chart
Route::prefix('chart')->group(function () {
    Route::controller(ChartController::class)->group(function () {
        Route::get('/columnchart', 'columnChart')->name('columnChart');
        Route::get('/linechart', 'lineChart')->name('lineChart');
        Route::get('/piechart', 'pieChart')->name('pieChart');
    });
});

// Componentpage
Route::prefix('componentspage')->group(function () {
    Route::controller(ComponentpageController::class)->group(function () {
        Route::get('/alert', 'alert')->name('alert');
        Route::get('/avatar', 'avatar')->name('avatar');
        Route::get('/badges', 'badges')->name('badges');
        Route::get('/button', 'button')->name('button');
        Route::get('/calendar', 'calendar')->name('calendar');
        Route::get('/card', 'card')->name('card');
        Route::get('/carousel', 'carousel')->name('carousel');
        Route::get('/colors', 'colors')->name('colors');
        Route::get('/dropdown', 'dropdown')->name('dropdown');
        Route::get('/imageupload', 'imageUpload')->name('imageUpload');
        Route::get('/list', 'list')->name('list');
        Route::get('/pagination', 'pagination')->name('pagination');
        Route::get('/progress', 'progress')->name('progress');
        Route::get('/radio', 'radio')->name('radio');
        Route::get('/starrating', 'starRating')->name('starRating');
        Route::get('/switch', 'switch')->name('switch');
        Route::get('/tabs', 'tabs')->name('tabs');
        Route::get('/tags', 'tags')->name('tags');
        Route::get('/tooltip', 'tooltip')->name('tooltip');
        Route::get('/typography', 'typography')->name('typography');
        Route::get('/videos', 'videos')->name('videos');
    });
});

// Dashboard
Route::prefix('dashboard')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/index2', 'index2')->name('index2');
        Route::get('/index3', 'index3')->name('index3');
        Route::get('/index4', 'index4')->name('index4');
        Route::get('/index5','index5')->name('index5');
        Route::get('/wallet','wallet')->name('wallet');
    });
});

// Forms
Route::prefix('forms')->group(function () {
    Route::controller(FormsController::class)->group(function () {
        Route::get('/form-layout', 'formLayout')->name('formLayout');
        Route::get('/form-validation', 'formValidation')->name('formValidation');
        Route::get('/form', 'form')->name('form');
        Route::get('/wizard', 'wizard')->name('wizard');
    });
});

// invoice/invoiceList
Route::prefix('invoice')->group(function () {
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('/invoice-add', 'invoiceAdd')->name('invoiceAdd');
        Route::get('/invoice-edit', 'invoiceEdit')->name('invoiceEdit');
        Route::get('/invoice-list', 'invoiceList')->name('invoiceList');
        Route::get('/invoice-preview', 'invoicePreview')->name('invoicePreview');
    });
});

// Settings
Route::prefix('settings')->group(function () {
    Route::controller(SettingsController::class)->group(function () {
        Route::get('/company', 'company')->name('company');
        Route::get('/currencies', 'currencies')->name('currencies');
        Route::get('/language', 'language')->name('language');
        Route::get('/notification', 'notification')->name('notification');
        Route::get('/notification-alert', 'notificationAlert')->name('notificationAlert');
        Route::get('/payment-gateway', 'paymentGateway')->name('paymentGateway');
        Route::get('/theme', 'theme')->name('theme');
    });
});

// Table
Route::prefix('table')->group(function () {
    Route::controller(TableController::class)->group(function () {
        Route::get('/tablebasic', 'tableBasic')->name('tableBasic');
        Route::get('/tabledata', 'tableData')->name('tableData');
    });
});

// Users
Route::prefix('users')->group(function () {
    Route::controller(UsersController::class)->group(function () {
        Route::get('/add-user', 'addUser')->name('addUser');
        Route::get('/users-grid', 'usersGrid')->name('usersGrid');
        Route::get('/users-list', 'usersList')->name('usersList');
        Route::get('/view-profile', 'viewProfile')->name('viewProfile');
    });
});


// Users
Route::prefix('user')->group(function () {
    Route::controller(\App\Http\Controllers\UserController::class)->group(function () {
        Route::get('/list', 'index')->name('user.list');
        Route::get('create','create')->name('user.create');
        Route::get('/getData','getData')->name('user.getData');
        Route::get('/edit/{id}','edit')->name('user.edit');
        Route::put('/update/{id}','update')->name('user.update');
        Route::get('/status/{id}','status')->name('user.status');
        Route::get('/show/{id}','show')->name('user.show');
        Route::post('user','store')->name('user.store');
        Route::put('userupdate/{id}','updatePassword')->name('user.password');
        Route::put('user.update_profile/{id}','update_profile')->name('user.update_profile');
        Route::get('getalluser','getalluser')->name('user.getalluser');
    });
});


// Users
Route::prefix('organitation')->group(function () {
    Route::controller(\App\Http\Controllers\OrganizationController::class)->group(function () {
        Route::get('/list', 'index')->name('groups.list');
        Route::get('/getData','getData')->name('groups.getData');
        Route::get('/edit/{id}','edit')->name('groups.edit');
        Route::put('/update/{id}','update')->name('groups.update');
        Route::get('/status/{id}','status')->name('groups.status');
        Route::get('/show/{id}','show')->name('groups.show');
        Route::post('groups','store')->name('groups.store');
        Route::get('/destroy/{id}','destroy')->name('groups.destroy');
        Route::get('create','create')->name('groups.create');
        Route::get('/getDivision/{id}','getDivision')->name('groups.getDivision');
        Route::get('/structure','structure')->name('groups.structure');
        Route::get('/dataStructure','dataStructure')->name('groups.dataStructure');
        Route::get('/groups/getData', [\App\Http\Controllers\OrganizationController::class, 'getData'])->name('groups.getData');
        Route::get('/groups/getDivisionsUsers', [\App\Http\Controllers\OrganizationController::class, 'getDivisionsUsers'])->name('groups.getDivisionsUsers');
        Route::get('/groups/getUsers', [\App\Http\Controllers\OrganizationController::class, 'getUsers'])->name('groups.getUsers');
        Route::get('/divisions/getDetails', 'getDetails')->name('divisions.getDetails');

    });
});
// Users
Route::prefix('division')->group(function () {
    Route::controller(\App\Http\Controllers\DivisionController::class)->group(function () {
        Route::get('/list', 'index')->name('division.list');
        Route::get('/getData','getData')->name('division.getData');
        Route::get('/edit/{id}','edit')->name('division.edit');
        Route::put('/update/{id}','update')->name('division.update');
        Route::get('/status/{id}','status')->name('division.status');
        Route::get('/show/{id}','show')->name('division.show');
        Route::post('division','store')->name('division.store');
        Route::get('/destroy/{id}','destroy')->name('division.destroy');
        Route::get('create','create')->name('division.create');
        Route::get('/data_user/{id}','data_user')->name('division.data_user');



    });
});


Route::prefix('role')->group(function () {
    Route::controller(\App\Http\Controllers\RoleController::class)->group(function () {
        Route::get('/list', 'index')->name('role.list');
        Route::get('/getData','getData')->name('role.getData');
        Route::get('/edit/{id}','edit')->name('role.edit');
        Route::put('/update/{id}','update')->name('role.update');
        Route::get('/status/{id}','status')->name('role.status');
        Route::get('/show/{id}','show')->name('role.show');
        Route::post('role','store')->name('role.store');
        Route::get('/destroy/{id}','destroy')->name('role.destroy');
        Route::get('create','create')->name('role.create');
    });
});



Route::prefix('asset')->group(function () {
    Route::controller(\App\Http\Controllers\AssetController::class)->group(function () {
        Route::get('/list', 'index')->name('asset.list');
        Route::get('/getData','getData')->name('asset.getData');
        Route::get('/edit/{id}','edit')->name('asset.edit');
        Route::put('/update/{id}','update')->name('asset.update');
        Route::get('/status/{id}','status')->name('asset.status');
        Route::get('/show/{id}','show')->name('asset.show');
        Route::post('asset','store')->name('asset.store');
        Route::get('/destroy/{id}','destroy')->name('asset.destroy');
        Route::get('create','create')->name('asset.create');
        Route::get('facility','facility')->name('asset.facility');
        Route::get('getDataFacility','getDataFacility')->name('asset.getDataFacility');
        Route::get('getDataPart/{code}','getDataPart')->name('asset.getDataPart');
        Route::get('/listBom','listBom')->name('asset.listBom');
        Route::get('/getpartBom','getpartBom')->name('asset.getpartBom');
        Route::get('/getFacilities','getFacilities')->name('asset.getFacilities');
        Route::get('/getLocationDetails','getLocationDetails')->name('asset.getLocationDetails');
    });
});

Route::prefix('equipment')->group(function () {
    Route::controller(\App\Http\Controllers\EquipmentController::class)->group(function () {
        Route::get('/list', 'index')->name('equipment.list');
        Route::get('/getData','getData')->name('equipment.getData');
        Route::get('/edit/{id}','edit')->name('equipment.edit');
        Route::put('/update/{id}','update')->name('equipment.update');
        Route::get('/status/{id}','status')->name('equipment.status');
        Route::get('/show/{id}','show')->name('equipment.show');
        Route::post('equipment','store')->name('equipment.store');
        Route::get('/destroy/{id}','destroy')->name('equipment.destroy');
        Route::get('create','create')->name('equipment.create');
    });
});
Route::prefix('tools')->group(function () {
    Route::controller(\App\Http\Controllers\ToolsController::class)->group(function () {
        Route::get('/list', 'index')->name('tools.list');
        Route::get('/getData','getData')->name('tools.getData');
        Route::get('/edit/{id}','edit')->name('tools.edit');
        Route::put('/update/{id}','update')->name('tools.update');
        Route::get('/status/{id}','status')->name('tools.status');
        Route::get('/show/{id}','show')->name('tools.show');
        Route::post('tools','store')->name('tools.store');
        Route::get('/destroy/{id}','destroy')->name('tools.destroy');
        Route::get('create','create')->name('tools.create');
    });
});

Route::prefix('work')->group(function () {
    Route::controller(\App\Http\Controllers\WorkOrderController::class)->group(function () {
        Route::get('/list', 'index')->name('wo.list');
        Route::get('/getData','getData')->name('wo.getData');
        Route::get('/edit/{id}','edit')->name('wo.edit');
        Route::put('/update/{id}','update')->name('wo.update');
        Route::get('/status/{id}','status')->name('wo.status');
        Route::get('/show/{id}','show')->name('wo.show');
        Route::post('wo','store')->name('wo.store');
        Route::get('/destroy/{id}','destroy')->name('wo.destroy');
        Route::get('create','create')->name('wo.create');
    });
});
Route::prefix('scheduler')->group(function () {
    Route::controller(\App\Http\Controllers\SchedulerController::class)->group(function () {
        Route::get('/list', 'index')->name('scheduler.list');
        Route::get('/getData','getData')->name('scheduler.getData');
        Route::get('/edit/{id}','edit')->name('scheduler.edit');
        Route::put('/update/{id}','update')->name('scheduler.update');
        Route::get('/status/{id}','status')->name('scheduler.status');
        Route::get('/show/{id}','show')->name('scheduler.show');
        Route::post('scheduler','store')->name('scheduler.store');
        Route::get('/destroy/{id}','destroy')->name('scheduler.destroy');
        Route::get('create','create')->name('scheduler.create');
    });
});
Route::prefix('task')->group(function () {
    Route::controller(\App\Http\Controllers\TaskController::class)->group(function () {
        Route::get('/list', 'index')->name('task.list');
        Route::get('/getData','getData')->name('task.getData');
        Route::get('/edit/{id}','edit')->name('task.edit');
        Route::put('/update/{id}','update')->name('task.update');
        Route::get('/status/{id}','status')->name('task.status');
        Route::get('/show/{id}','show')->name('task.show');
        Route::post('task','store')->name('task.store');
        Route::get('/destroy/{id}','destroy')->name('task.destroy');
        Route::get('create','create')->name('task.create');
    });
});

Route::prefix('project')->group(function () {
    Route::controller(\App\Http\Controllers\ProjectController::class)->group(function () {
        Route::get('/list', 'index')->name('project.list');
        Route::get('/getData','getData')->name('project.getData');
        Route::get('/edit/{id}','edit')->name('project.edit');
        Route::put('/update/{id}','update')->name('project.update');
        Route::get('/status/{id}','status')->name('project.status');
        Route::get('/show/{id}','show')->name('project.show');
        Route::post('project','store')->name('project.store');
        Route::get('/destroy/{id}','destroy')->name('project.destroy');
        Route::get('create','create')->name('project.create');
    });
});
Route::prefix('part')->group(function () {
    Route::controller(\App\Http\Controllers\PartController::class)->group(function () {
        Route::get('/list', 'index')->name('part.list');
        Route::get('/getData','getData')->name('part.getData');
        Route::get('/edit/{id}','edit')->name('part.edit');
        Route::put('/update/{id}','update')->name('part.update');
        Route::get('/status/{id}','status')->name('part.status');
        Route::get('/show/{id}','show')->name('part.show');
        Route::post('part','store')->name('part.store');
        Route::get('/destroy/{id}','destroy')->name('part.destroy');
        Route::get('create','create')->name('part.create');
        Route::get('/categories','getCategories')->name('categories.get');
        Route::get('/getFacility','getFacility')->name('categories.getFacility');
        Route::post('/categories','storecategories')->name('categories.store');


    });
});
Route::prefix('business')->group(function () {
    Route::controller(\App\Http\Controllers\BusinessController::class)->group(function () {
        Route::get('/list', 'index')->name('business.list');
        Route::get('/getData','getData')->name('business.getData');
        Route::get('/edit/{id}','edit')->name('business.edit');
        Route::put('/update/{id}','update')->name('business.update');
        Route::get('/status/{id}','status')->name('business.status');
        Route::get('/show/{id}','show')->name('business.show');
        Route::post('business','store')->name('business.store');
        Route::get('/destroy/{id}','destroy')->name('business.destroy');
        Route::get('create','create')->name('business.create');
        Route::get('getDataMeterReading','getDataMeterReading')->name('business.getDataMeterReading');
    });
});

Route::prefix('bom')->group(function () {
    Route::controller(\App\Http\Controllers\BOMController::class)->group(function () {
        Route::get('/list', 'index')->name('bom.list');
        Route::get('/getData','getData')->name('bom.getData');
        Route::get('/edit/{id}','edit')->name('bom.edit');
        Route::put('/update/{id}','update')->name('bom.update');
        Route::get('/status/{id}','status')->name('bom.status');
        Route::get('/show/{id}','show')->name('bom.show');
        Route::post('bom','store')->name('bom.store');
        Route::get('/destroy/{id}','destroy')->name('bom.destroy');
        Route::get('create','create')->name('bom.create');
        Route::get('getDataAsset','getDataAsset')->name('bom.getDataAsset');
        Route::get('getDataBom','getDataBom')->name('bom.getDataBom');
        Route::get('getlistBom','getlistBom')->name('bom.getlistBom');
    });
});
Route::prefix('permit')->group(function () {
    Route::controller(\App\Http\Controllers\PermitController::class)->group(function () {
        Route::get('/list', 'index')->name('permit.list');
        Route::get('/getData','getData')->name('permit.getData');
        Route::get('/edit/{id}','edit')->name('permit.edit');
        Route::put('/update/{id}','update')->name('permit.update');
        Route::get('/status/{id}','status')->name('permit.status');
        Route::get('/show/{id}','show')->name('permit.show');
        Route::post('permit','store')->name('permit.store');
        Route::get('/destroy/{id}','destroy')->name('permit.destroy');
        Route::get('create','create')->name('permit.create');
    });
});
Route::prefix('receipt')->group(function () {
    Route::controller(\App\Http\Controllers\ProcurementController::class)->group(function () {
        Route::get('/list', 'index')->name('receipt.list');
        Route::get('/getData','getData')->name('receipt.getData');
        Route::get('/edit/{id}','edit')->name('receipt.edit');
        Route::put('/update/{id}','update')->name('receipt.update');
        Route::get('/status/{id}','status')->name('receipt.status');
        Route::get('/show/{id}','show')->name('receipt.show');
        Route::post('receipt','store')->name('receipt.store');
        Route::get('/destroy/{id}','destroy')->name('receipt.destroy');
        Route::get('create','create')->name('receipt.create');
    });
});
Route::prefix('purchase')->group(function () {
    Route::controller(\App\Http\Controllers\ProcurementController::class)->group(function () {
        Route::get('/list', 'purchase_index')->name('purchase.list');
        Route::get('/getData','getData')->name('purchase.getData');
        Route::get('/edit/{id}','edit')->name('purchase.edit');
        Route::put('/update/{id}','update')->name('purchase.update');
        Route::get('/status/{id}','status')->name('purchase.status');
        Route::get('/show/{id}','show')->name('purchase.show');
        Route::post('purchase','store')->name('purchase.store');
        Route::get('/destroy/{id}','destroy')->name('purchase.destroy');
        Route::get('create','purchase_create')->name('purchase.create');
    });
});

Route::prefix('space')->group(function () {
    Route::controller(\App\Http\Controllers\SpaceController::class)->group(function () {
        Route::get('/list', 'index')->name('space.list');
        Route::get('/getData','getData')->name('space.getData');
        Route::get('/edit/{id}','edit')->name('space.edit');
        Route::put('/update/{id}','update')->name('space.update');
        Route::get('/status/{id}','status')->name('space.status');
        Route::get('/show/{id}','show')->name('space.show');
        Route::post('space','store')->name('space.store');
        Route::get('/destroy/{id}','destroy')->name('space.destroy');
        Route::get('create','create')->name('space.create');
        Route::get('analytics','analytics')->name('space.analytics');
    });
});
Route::prefix('contractor')->group(function () {
    Route::controller(\App\Http\Controllers\ContractorController::class)->group(function () {
        Route::get('/list', 'index')->name('contractor.list');
        Route::get('/getData','getData')->name('contractor.getData');
        Route::get('/edit/{id}','edit')->name('contractor.edit');
        Route::put('/update/{id}','update')->name('contractor.update');
        Route::get('/status/{id}','status')->name('contractor.status');
        Route::get('/show/{id}','show')->name('contractor.show');
        Route::post('contractor','store')->name('contractor.store');
        Route::get('/destroy/{id}','destroy')->name('contractor.destroy');
        Route::get('create','create')->name('contractor.create');
        Route::get('analytics','analytics')->name('contractor.analytics');
    });
});


Route::prefix('account')->group(function (){
    Route::controller(\App\Http\Controllers\AssetController::class)->group(function () {
        Route::get('/list', 'list_account')->name('account.list');
        Route::post('/store_account', 'store_account')->name('account.store');
        Route::get('/destroy_account/{id}', 'destroy_account')->name('account.destroy');
        Route::get('/charge_list/', 'charge_list')->name('account.charge_list');
        Route::post('/charge_store/', 'charge_store')->name('account.charge_store');
        Route::get('/charge_destroy/{id}', 'charge_delete')->name('account.charge_delete');
    });
});


Route::get('/socket/list', [\App\Http\Controllers\RestController::class, 'index'])->name('socket.list');
Route::post('/socket/store', [\App\Http\Controllers\RestController::class, 'store'])->name('socket.store');
Route::post('/socket/store_alarm', [\App\Http\Controllers\RestController::class, 'store_alarm'])->name('socket.store_alarm');
Route::get('/socket/edit/{id}', [\App\Http\Controllers\RestController::class, 'edit'])->name('socket.edit');
Route::put('/socket/update/{id}', [\App\Http\Controllers\RestController::class, 'update'])->name('socket.update');
Route::get('/socket/delete/{id}', [\App\Http\Controllers\RestController::class, 'destroy'])->name('socket.delete');
Route::get('socket/test/{id}', [\App\Http\Controllers\RestController::class, 'test'])->name('socket.test');
Route::get('socket/show/{id}', [\App\Http\Controllers\RestController::class, 'show'])->name('socket.show');
Route::get('/error-log', [\App\Http\Controllers\RestController::class, 'error'])->name('error.log');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
