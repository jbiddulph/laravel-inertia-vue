<?php

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\CustomerController;

// HOME USERS TABLE
Route::get('/', function(Request $request) {
    return inertia('Home', [
        'users' => User::when($request->search, function($query) use 
        ($request) {
            $query
            ->where('name', 'like', '%' . $request->search . '%')
            ->orWhere('email', 'like', '%' . $request->search . '%');
        })->paginate(5)->withQueryString(),

        'searchTerm' => $request->search,
        'can' => [
            'delete_user' =>
                Auth::user() ? 
                    Auth::user()->can('delete', User::class) : 
                        null
        ]
    ]);
})->name('home');

// ITEMS
Route::get('/items', function(Request $request) {
    return inertia('Items', [
        'items' => Item::when($request->search, function($query) use 
        ($request) {
            $query
            ->where('item_name', 'like', '%' . $request->search . '%')
            ->orWhere('item_description', 'like', '%' . $request->search . '%');
        })->paginate(5)->withQueryString(),

        'searchTerm' => $request->search,
        'can' => [
            'delete_user' =>
                Auth::user() ? 
                    Auth::user()->can('delete', User::class) : 
                        null
        ]
    ]);
})->name('items');

// AUTH
Route::middleware('auth')->group(function () {
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // Customers
    Route::inertia('/customers/create', 'Customers/Create')->name('customerCreate');
    Route::post('/customers/create', [CustomerController::class, 'create']);
    // Items
    Route::inertia('/items/create', 'Items/Create')->name('itemCreate');
    Route::post('/items/create', [ItemsController::class, 'create']);
});

Route::middleware('guest')->group(function () {
    Route::inertia('/register', 'Auth/Register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::inertia('/login', 'Auth/Login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});



Route::get('/check-auth', function () {
    if (Auth::check()) {
        return 'User is authenticated with ID: ' . Auth::id();
    } else {
        return 'User is not authenticated';
    }
});