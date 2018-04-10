<?php

require 'init.php';

$app = new App(true);

$app->add(new \atk4\login\Auth())
    ->setModel(new \atk4\login\Model\User($app->db));

$app->add('CRUD')->setModel(new Guest($app->db));
