<?php

require 'vendor/autoload.php';

require 'init.php';

$app = new App();

$columns = $app->add('Columns');

$left = $columns->addColumn();
$right = $columns->addColumn();

$right->add(['Message', 'Welcome to the party!', 'info'])->text
    ->addParagraph('Our party is using "Bring Your Own Drink™" policy, so be sure '.
    'to grab a beer or lemonade');

$form = $left->add('Form');
$form->setModel(new Guest($app->db));
$form->onSubmit(function($form) {

    // store new guest data
    $form->model->save();

    $sid = "AC9a1f7cc91b2b06a3e6e9a472cdbb165b"; // Your Account SID from www.twilio.com/console
    $token = "4d6e23d8fb4ae27d4ffede41e2281037"; // Your Auth Token from www.twilio.com/console

    $client = new Twilio\Rest\Client($sid, $token);
    $message = $client->messages->create(
      '07427599339', // Text this number
      array(
        'from' => '447533027709', // From a valid Twilio number
        'body' => 'Guest '.$form->model['name'].' will be coming. ('.$form->model['phone'].')'
      )
    );

    return $form->success('Thank you, we will wait for you, '.$form->model['name']);

});
