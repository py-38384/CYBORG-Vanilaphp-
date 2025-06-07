<?php

    $urlpattern = [
        "/" => ['base_controller','home'],
        "/browse" => ['base_controller','browse'],
        "/details" => ['base_controller','details'],
        "/streams" => ['base_controller','streams'],
        "/profile" => ['base_controller','profile'],
    ];

    route($urlpattern);