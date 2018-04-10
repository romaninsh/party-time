<?php

require 'init.php';

$app = new App();

$app->add('\atk4\schema\MigratorConsole')
    ->migrateModels([
        new \atk4\login\Model\User($app->db),
    ]);

$user = new \atk4\login\Model\User($app->db);
$user->tryLoadAny();
if ($user->loaded()) {
    exit;
}

$app->add(['Header', 'Create your first user']);

$app->add('Form')->setModel(new \atk4\login\Model\User($app->db));
