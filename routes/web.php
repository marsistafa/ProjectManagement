<?php

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Support\Facades\Route;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use App\Http\Controllers\RoadMap\DataController;
use App\Http\Controllers\Auth\OidcAuthController;
use App\Http\Controllers\SolutionController;
use App\Http\Controllers\DrawingController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MaterialTicketController;
use App\Http\Controllers\SolutionTicketController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\RequestForQuotationController;
use App\Http\Controllers\RFQTicketController;
use App\Filament\Pages\SolutionsPage;






// Share ticket
Route::get('/tickets/share/{ticket:code}', function (Ticket $ticket) {
    return redirect()->to(route('filament.resources.tickets.view', $ticket));
})->name('filament.resources.tickets.share');

// Validate an account
Route::get('/validate-account/{user:creation_token}', function (User $user) {
    return view('validate-account', compact('user'));
})
    ->name('validate-account')
    ->middleware([
        'web',
        DispatchServingFilamentEvent::class
    ]);

// Login default redirection
Route::redirect('/login-redirect', '/login')->name('login');

// Road map JSON data
Route::get('road-map/data/{project}', [DataController::class, 'data'])
    ->middleware(['verified', 'auth'])
    ->name('road-map.data');

Route::name('oidc.')
    ->prefix('oidc')
    ->group(function () {
        Route::get('redirect', [OidcAuthController::class, 'redirect'])->name('redirect');
        Route::get('callback', [OidcAuthController::class, 'callback'])->name('callback');
    });

// Solution Route (UPDATE THIS WHEN FINISH WITH POSTMAN TESTING!!!!!!!!!!)
// Route::get('/solutions', [SolutionController::class, 'index'])
//     ->middleware(['verified', 'auth'])
//     ->name('solutions.index');

Route::resource('/solutions', SolutionController::class);

Route::resource('/drawings', DrawingController::class);
// Route::post('/drawings', [DrawingController::class, 'store'])->name('drawings.store');


// Route::resource('/materials', MaterialController::class);

Route::resource('/materialtickets', MaterialTicketController::class);

Route::resource('/solutiontickets', SolutionTicketController::class);

Route::resource('/supplier', SupplierController::class);

Route::resource('/rfq', RequestForQuotationController::class);

Route::resource('/rfqtickets', RFQTicketController::class);


Route::get('/view-image/{path}', function ($path) {
    return view('livewire.image-viewer', ['image' => $path]);
})->name('view-image');
