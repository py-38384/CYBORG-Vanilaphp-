<?php

namespace Controllers;

class BaseController{
    public function home(){
        return view('index');
    }
    public function details(){
        return view('details');
    }
    public function browse(){
        return view('browse');
    }
    public function profile(){
        return view('profile');
    }
    public function streams(){
        return view('streams');
    }
}