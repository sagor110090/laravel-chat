<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Route::view('/', 'welcome');
Volt::route('/chat', 'frontend.chatbox')->middleware(['auth'])->name('chat');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
