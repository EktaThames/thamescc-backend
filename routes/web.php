<?php

// Admin Footer Settings
Route::group(['prefix' => 'admin', 'middleware' => ['web', 'admin']], function () {
    Route::get('footer-settings', [\Webkul\Admin\Http\Controllers\FooterSettingController::class, 'edit'])->name('admin.footer-settings.edit');
    Route::post('footer-settings', [\Webkul\Admin\Http\Controllers\FooterSettingController::class, 'update'])->name('admin.footer-settings.update');
});
