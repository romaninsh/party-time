<?php

require 'init.php';

$app = new App(true);
$app->add('CRUD')->setModel(new Guest($app->db));
