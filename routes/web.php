<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\FilesController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\FileImportController;
use App\Http\Controllers\Admin\UserAlertsController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Auth\ChangePasswordController;
use Spatie\ArrayToXml\ArrayToXml;

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.files.index')->with('status', session('status'));
    }

    return redirect()->route('admin.files.index');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    // Permissions
    Route::delete('permissions/destroy', [PermissionsController::class, 'massDestroy'])->name('permissions.massDestroy');
    Route::resource('permissions', PermissionsController::class);

    // Roles
    Route::delete('roles/destroy', [RolesController::class , 'massDestroy'])->name('roles.massDestroy');
    Route::resource('roles', RolesController::class);

    // Users
    Route::delete('users/destroy', [UsersController::class , 'massDestroy'])->name('users.massDestroy');
    Route::resource('users', UsersController::class);

    // User Alerts
    Route::delete('user-alerts/destroy', [UserAlertsController::class , 'massDestroy'])->name('user-alerts.massDestroy');
    Route::get('user-alerts/read', [UserAlertsController::class , 'read']);
    Route::resource('user-alerts', UserAlertsController::class)->except(['edit', 'update']);

    //files ID
    Route::delete('files/destroy', [FilesController::class , 'massDestroy'])->name('files.massDestroy');
    Route::resource('files', FilesController::class);

    //impoert Excel
    Route::get('import/files', [FileImportController::class , 'view'])->name('files.view');
    Route::post('import/files', [FileImportController::class, 'import'])->name('files.import');

    //series and type
    Route::get('series', [FilesController::class, 'series'])->name('files.series');
    Route::post('series', [FilesController::class, 'seriesStore'])->name('files.series.store');
    Route::get('series/{id}/edit', [FilesController::class, 'seriesEdit'])->name('files.series.edit');
    Route::post('series/update/{id}', [FilesController::class, 'seriesUpdate'])->name('files.series.update');

    //schedules
    Route::post('schedules/import', [ScheduleController::class, 'massImport'])->name('schedules.massImport');
    Route::post('schedules/reorder', [ScheduleController::class, 'reorder'])->name('schedules.reorder');
    Route::post('schedules/import/{file}', [ScheduleController::class, 'import'])->name('schedules.import');
    Route::get('schedules/builder', [ScheduleController::class, 'builder'])->name('schedules.builder');
    Route::get('schedules/getBuilder', [ScheduleController::class, 'getBuilder'])->name('schedules.getBuilder');
    Route::get('schedules/list', [ScheduleController::class, 'list'])->name('schedules.list');
    Route::resource('schedules', ScheduleController::class)->except(['create', 'show']);
    
    Route::get('test', [FilesController::class, 'test']);
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', [ChangePasswordController::class , 'edit'])->name('password.edit');
        Route::post('password', [ChangePasswordController::class , 'update'])->name('password.update');
        Route::post('profile', [ChangePasswordController::class , 'updateProfile'])->name('password.updateProfile');
        Route::post('profile/destroy', [ChangePasswordController::class , 'destroy'])->name('password.destroyProfile');
    }
});

Route::get('test', function() {
    $array = array (
        'playlist' => 
        array (
          'history' => 
          array (
            'created' => 
            array (
              '@value' => '',
              '@attributes' => 
              array (
                'name' => 'Pebble Beach Systems',
                'datetime' => '2021-04-12T08:37:20',
              ),
            ),
            'modified' => 
            array (
              '@value' => '',
              '@attributes' => 
              array (
                'name' => 'Pebble Beach Systems',
                'datetime' => '2021-04-12T08:37:20',
              ),
            ),
          ),
          'eventlist' => 
          array (
            'event' => 
            array (
              0 => 
              array (
                'eventnote' => '2308LR',
                '@attributes' => 
                array (
                  'type' => 'COMMENT',
                ),
              ),
              1 => 
              array (
                'stream' => '0',
                'onairtime' => '',
                'starttype' => 'SEQ',
                'endtype' => 'NORM',
                'mediaid' => '2308LR',
                'houseid' => '',
                'reconcilekey' => '',
                'title' => '',
                'category' => '?',
                'som' => '00:00:00:00',
                'duration' => '',
                'effect' => 'Take',
                'rate' => 'Fast',
                'customdata' => 
                array (
                  'ListId' => '1',
                ),
                'eventnote' => '',
                '@attributes' => 
                array (
                  'type' => 'MEDIA',
                ),
              ),
              2 => 
              array (
                'eventnote' => 'TTLove Reveng Replay',
                '@attributes' => 
                array (
                  'type' => 'COMMENT',
                ),
              ),
              3 => 
              array (
                'stream' => '0',
                'onairtime' => '',
                'starttype' => 'SEQ',
                'endtype' => 'NORM',
                'mediaid' => 'TTLove Reveng Replay',
                'houseid' => '',
                'reconcilekey' => '',
                'title' => 'TTLove Reveng Replay',
                'category' => '?',
                'som' => '00:00:00:00',
                'duration' => '',
                'effect' => 'None',
                'rate' => 'None',
                'customdata' => 
                array (
                  'ListId' => '1',
                ),
                'eventnote' => '',
                '@attributes' => 
                array (
                  'type' => 'MEDIA',
                ),
              ),
              4 => 
              array (
                'eventnote' => 'PMHow To Be A Millionaire NOBEER',
                '@attributes' => 
                array (
                  'type' => 'COMMENT',
                ),
              ),
              5 => 
              array (
                'stream' => '0',
                'onairtime' => '',
                'starttype' => 'SEQ',
                'endtype' => 'NORM',
                'mediaid' => 'PMHow To Be A Millionaire NOBEER',
                'houseid' => '',
                'reconcilekey' => '',
                'title' => '',
                'category' => '?',
                'som' => '00:00:00:00',
                'duration' => '',
                'effect' => 'None',
                'rate' => 'None',
                'customdata' => 
                array (
                  'ListId' => '1',
                ),
                'eventnote' => '',
                '@attributes' => 
                array (
                  'type' => 'MEDIA',
                ),
              ),
            ),
          ),
        ),
    );
    
    // $result = ArrayToXml::convert($array, 'playlist');
    $result = ArrayToXml::convert($array, [], true, 'UTF-8', '1.1', [], true);
    // dd($result);
    return $result;
});