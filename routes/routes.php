<?php

use Src\Route as Route;

Route::get('/', function(){
	echo "Página inicial";
});

Route::get(['set' => '/cliente', 'as' => 'clientes.index'], 'Cliente@index');

Route::get(['set' => '/cliente/{id}/show', 'as' => 'clientes.show'], 'Cliente@show');


Route::delete(['set' => 'cliente/delete', 'as' => 'clientes.delete'], 'Cliente@teste');