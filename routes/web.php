<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear', function() {   
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('logs:clear');
    return 'View cache has been cleared';
});

Route::get('/',function(){return redirect()->route('admin.login');});
Route::get('admin',function(){return redirect()->route('admin.login');});
Route::get('login',function(){return redirect()->route('admin.login');});

Route::prefix('backend')->group(function () {
    route::namespace('App\Http\Controllers\backend')->group(function(){
        Route::prefix('login')->controller(AdminController::class)->group(function(){
            Route::match(['get', 'post'],'', 'login')->name('admin.login');
        });
        Route::middleware('admin')->group(function (){

            Route::prefix('reports')->controller(ReportController::class)->group(function(){
                Route::prefix('asset-innventory')->group(function(){
                    Route::get('','assetInventoryIndex')->name('asset-innventory.assetInventoryIndex');
                    Route::get('asset-inventory-assetlist','assetInventoryAssetList')->name('asset-innventory.assetInventoryAssetList');
                });

                // Route::post('store','store')->name('reportsasset-innventory.assetInventoryAssetList.store');
            });

            Route::prefix('designations')->controller(DesignationController::class)->group(function(){
                Route::get('','index')->name('designations.index');
                Route::get('create','createOrEdit')->name('designations.create');
                Route::get('edit/{id?}','createOrEdit')->name('designations.edit');
                Route::post('store','store')->name('designations.store');
                Route::put('update/{id}','update')->name('designations.update');
                Route::delete('delete/{id}','destroy')->name('designations.destroy');
            });

            Route::prefix('employees')->controller(EmployeeController::class)->group(function(){
                Route::get('','index')->name('employees.index');
                Route::get('create','createOrEdit')->name('employees.create');
                Route::get('edit/{id?}','createOrEdit')->name('employees.edit');
                Route::post('store','store')->name('employees.store');
                Route::put('update/{id}','update')->name('employees.update');
                Route::delete('delete/{id}','destroy')->name('employees.destroy');
            });


            Route::prefix('departments')->controller(DepartmentController::class)->group(function(){
                Route::get('','index')->name('departments.index');
                Route::get('create','createOrEdit')->name('departments.create');
                Route::get('edit/{id?}','createOrEdit')->name('departments.edit');
                Route::post('store','store')->name('departments.store');
                Route::put('update/{id}','update')->name('departments.update');
                Route::delete('delete/{id}','destroy')->name('departments.destroy');
            });
            

            Route::prefix('assets-statuses')->controller(AssetStatusController::class)->group(function(){
                Route::get('','index')->name('assets-statuses.index');
                Route::get('create','create')->name('assets-statuses.create');
                Route::post('store','store')->name('assets-statuses.store');
                Route::get('assets-statuses-list','assetStatusList')->name('assets-statuses.list');
                Route::get('assets-statuses-list-temp','assetStatusListTemp')->name('assets-statuses.list-temp');
                Route::post('update-temp','updateTemp')->name('assets-statuses.update-temp');

            });

            Route::prefix('assets-transfers')->controller(AssetTransferController::class)->group(function(){
                Route::prefix('outgoing')->group(function(){
                    Route::get('','outgoing')->name('assets-transfers.outgoing');
                    Route::get('create','create')->name('assets-transfers.create');

                    Route::post('store-wrq','storeTransferFromRequisition')->name('assets-transfers.storeTransferFromRequisition');
                    Route::post('store-worq','storeTransferWithoutRequisition')->name('assets-transfers.storeTransferWithoutRequisition');
                    Route::get('asset-list-worq/{cat_id}','getAssetListByCat')->name('assets-transfers.asset-list-worq');;


                    Route::delete('delete/{id}','destroy')->name('assets-transfers.destroy');
                    Route::get('assets-transfers-outgoing-list','assetsTransferOutgoingList')->name('assets-transfers.outgoing-list');
                    Route::get('assets-transfers-incoming-list','assetsTransferIncomingList')->name('assets-transfers.incoming-list');
                    Route::get('requisition-details/{req_id}','requisitionDetails')->name('assets-transfers.requisition-details');
                });
                Route::prefix('incoming')->group(function(){
                    Route::get('','incoming')->name('assets-transfers.incoming');
                    Route::get('assets-transfers-list','assetsTransferList')->name('assets-transfers.list');
                    Route::get('asset-list/{cat_id}','assetList')->name('assets-transfers.asset-list');
                    Route::get('receive/{id}','receive')->name('assets-transfers.receive');
                });
            });


            Route::prefix('transfer-requisitions')->controller(TransferRequisitionController::class)->group(function(){
                Route::get('outgoing','outgoing')->name('transfer-requisitions.index');
                Route::get('create','createOrEdit')->name('transfer-requisitions.create');
                Route::get('edit/{id?}','createOrEdit')->name('transfer-requisitions.edit');
                Route::post('store','store')->name('transfer-requisitions.store');
                Route::put('update/{id}','update')->name('transfer-requisitions.update');
                Route::delete('delete/{id}','destroy')->name('transfer-requisitions.destroy');
                Route::get('transfer-requisitions','transferRequisitions')->name('transfer-requisitions.transfer-requisitions');
                Route::get('transfer-requisitions/{cat_id}','assetList')->name('transfer-requisitions.asset-list');
                Route::get('requisitions-details/{req_id}','requisitionDetails')->name('transfer-requisitions.details');
                Route::get('get-cat-list/{branch_id}','getCatList')->name('transfer-requisitions.get-cat-list');


                Route::get('incoming','incoming')->name('transfer-requisitions.incoming-requisition');
                Route::get('incoming-tr-list','incomingTR')->name('transfer-requisitions.incoming-tr-list');
                Route::get('edit-incoming/{id?}','editIncoming')->name('transfer-requisitions.edit-incoming');
                Route::put('update-incomming/{id}','updateIncoming')->name('transfer-requisitions.update-incomming');
            });
            Route::prefix('assign-assets')->controller(AssignAssetController::class)->group(function(){
                Route::get('','index')->name('assign-assets.index');
                Route::get('create','createOrEdit')->name('assign-assets.create');
                Route::post('store','store')->name('assign-assets.store');
                Route::get('assign-assets','assignAssets')->name('assign-assets.assign-assets');
                Route::get('assign-assets/{cat_id}','assetList')->name('assign-assets.asset-list');
            });
            Route::prefix('assets')->controller(AssetController::class)->group(function(){
                Route::get('','index')->name('assets.index');
                Route::get('create','createOrEdit')->name('assets.create');
                Route::get('edit/{id?}','createOrEdit')->name('assets.edit');
                Route::post('store','store')->name('assets.store');
                Route::put('update/{id}','update')->name('assets.update');
                Route::delete('delete/{id}','destroy')->name('assets.destroy');
                Route::get('assets','assets')->name('assets.assets');
            });
            Route::prefix('branches')->controller(BranchController::class)->group(function(){
                Route::get('','index')->name('branches.index');
                Route::get('create','createOrEdit')->name('branches.create');
                Route::get('edit/{id?}','createOrEdit')->name('branches.edit');
                Route::post('store','store')->name('branches.store');
                Route::put('update/{id}','update')->name('branches.update');
                Route::delete('delete/{id}','destroy')->name('branches.destroy');
                Route::get('all-branches','allBranches')->name('branches.all-branches');
            });
            Route::prefix('categories')->controller(CategoryController::class)->group(function(){
                Route::get('','index')->name('categories.index');
                Route::get('create','createOrEdit')->name('categories.create');
                Route::get('edit/{id?}','createOrEdit')->name('categories.edit');
                Route::post('store','store')->name('categories.store');
                Route::put('update/{id}','update')->name('categories.update');
                Route::delete('delete/{id}','destroy')->name('categories.destroy');
                Route::get('all-categories','allCategories')->name('categories.all-categories');
            });
            Route::prefix('sub-categories')->controller(SubCategoryController::class)->group(function(){
                Route::get('','index')->name('sub-categories.index');
                Route::get('create','createOrEdit')->name('sub-categories.create');
                Route::get('edit/{id?}','createOrEdit')->name('sub-categories.edit');
                Route::post('store','store')->name('sub-categories.store');
                Route::put('update/{id}','update')->name('sub-categories.update');
                Route::delete('delete/{id}','destroy')->name('sub-categories.destroy');
                Route::get('all-sub-categories','allSubCategories')->name('sub-categories.all-sub-categories');
            });

            Route::prefix('menus')->controller(MenuController::class)->group(function(){
                Route::get('','index')->name('menus.index');
                Route::get('create','createOrEdit')->name('menus.create');
                Route::get('edit/{id?}/{addmenu?}','createOrEdit')->name('menus.edit');
                Route::post('store','store')->name('menus.store'); 
                Route::put('update/{id}','update')->name('menus.update');
                Route::delete('delete/{id}','destroy')->name('menus.destroy');
            });

            Route::prefix('frontend-menus')->controller(FrontendMenuController::class)->group(function(){
                Route::get('','index')->name('frontend-menus.index');
                Route::get('create','createOrEdit')->name('frontend-menus.create');
                Route::get('edit/{id?}/{addmenu?}','createOrEdit')->name('frontend-menus.edit');
                Route::post('store','store')->name('frontend-menus.store'); 
                Route::put('update/{id}','update')->name('frontend-menus.update');
                Route::delete('delete/{id}','destroy')->name('frontend-menus.destroy');
            });
            
            Route::prefix('logout')->controller(AdminController::class)->group(function(){
                Route::post('', 'logout')->name('admin.logout');
            });
            Route::prefix('dashboard')->controller(DashboardController::class)->group(function(){
                Route::get('','index')->name('dashboard.index');
                Route::get('asset-list','assetList')->name('dashboard.asset-list');
                Route::get('in-transit-asset-list','inTransitAssetList')->name('dashboard.in-transit-asset-list');
            });
            Route::prefix('basic-infos')->controller(BasicInfoController::class)->group(function(){
                Route::get('','index')->name('basic-infos.index');
                Route::put('update/{id}','update')->name('basic-infos.update');
                Route::get('edit/{id?}','edit')->name('basic-infos.edit');
            });
            Route::prefix('admin')->group(function(){
                Route::prefix('roles')->controller(RoleController::class)->group(function(){
                    Route::get('','index')->name('roles.index');
                    Route::get('create','createOrEdit')->name('roles.create');
                    Route::get('edit/{id?}','createOrEdit')->name('roles.edit');
                    Route::post('store','store')->name('roles.store');
                    Route::put('update/{id}','update')->name('roles.update');
                    Route::delete('delete/{id}','destroy')->name('roles.destroy');
                    Route::get('all-roles','allRoles')->name('roles.all-roles');
                });
                Route::prefix('admins')->controller(AdminController::class)->group(function(){
                    Route::get('','index')->name('admins.index');
                    Route::get('create','createOrEdit')->name('admins.create');
                    Route::get('edit/{id?}','createOrEdit')->name('admins.edit');
                    Route::post('store','store')->name('admins.store');
                    Route::put('update/{id}','update')->name('admins.update');
                    Route::delete('delete/{id}','destroy')->name('admins.destroy');
                    Route::get('all-admins','allAdmins')->name('admins.all-admins');
                    Route::get('get-employees/{branch_id}','employeeList')->name('admins.employees-list');
                });
            });

         



            Route::prefix('password')->controller(AdminController::class)->group(function(){
                Route::match(['get', 'post'],'update/{id?}','updatePassword')->name('admin.password.update');
                Route::post('check-password','checkPassword')->name('admin.password.check');
            });
            Route::prefix('profile')->controller(AdminController::class)->group(function(){
                Route::match(['get', 'post'],'update-details/{id?}','updateDetails')->name('profile.update-details');;
            });
        });
    });
});

route::namespace('App\Http\Controllers\frontend')->group(function(){
    Route::controller(HomeController::class)->group(function(){
        Route::get('/home',function(){
            return redirect()->route('admin.login');
        })->name('home.index');
    });
});


require __DIR__.'/auth.php';
