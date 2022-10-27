<?php

use App\Http\Controllers\Dashboard\Pages\ClientStatusController;
use Illuminate\Support\Facades\Route;






Route::get("/", function () {

    return redirect()->route("dashboard.clients.index");

});

Route::get("tables/clients", \App\Http\Controllers\Dashboard\Tables\ClientsController::class)->name("tables.clients");


Route::post('client/{client}/status/change', ClientStatusController::class)->name("client.change.status");


Route::resource("clients", App\Http\Controllers\Dashboard\Pages\ClientsController::class)->only(["index","store","destroy"]);
