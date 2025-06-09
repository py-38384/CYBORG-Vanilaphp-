<?php
    use System\Route;
    use Controllers\BaseController;
    
    Route::get("/",[BaseController::class,'home']);
    Route::get("/browse",[BaseController::class,'home']);
    Route::get("/details",[BaseController::class,'details']);
    Route::get("/streams",[BaseController::class,'streams']);
    Route::get("/profile",[BaseController::class,'profile']);