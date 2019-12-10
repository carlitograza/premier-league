<?php

Route::middleware(['api'])->group(function () {
    Route::get("player", "API\PlayerController@index");
    Route::get("player/{id}", "API\PlayerController@single");
});