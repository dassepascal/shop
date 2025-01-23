<?php

use Livewire\Volt\Volt;

Volt::route('/', 'index');
Volt::route('/pages/{page:slug}', 'page')->name('pages');
