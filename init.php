<?php
require 'vendor/autoload.php';

class App extends \atk4\ui\App
{
    function __construct($is_admin = false) {

        parent::__construct('Party App');

        // Depending on the use, select appropriate layout for our pages
        if ($is_admin) {
            $this->initLayout('Admin');

            $this->layout->menuLeft->addItem(['Dashboard', 'icon'=>'birthday cake'], ['dashboard']);
            $this->layout->menuLeft->addItem(['Guest Admin', 'icon'=>'users'], ['admin']);
        } else {
            $this->initLayout('Centered');
        }

        $this->dbConnect('mysql://root:root@localhost/party-app');
    }
}

class Guest extends \atk4\data\Model
{
    public $table = 'guest';
    function init() {
        parent::init();

        $this->addFields([
            ['name', 'required'=>true],
            'surname',
            ['phone', 'required'=>true],
            'email'
        ]);
        $this->addField('age', ['required'=>true]);
        $this->addField('gender', ['enum'=>['male','female']]);
        $this->addField('units_of_drink', ['ui'=>[
            'hint'=>'Bring Your Own Drink™ - how much bottles will you bring?'
        ]]);
    }
}

class Dashboard extends \atk4\ui\View
{
    public $defaultTemplate = __DIR__.'/dashboard.html';

    function setModel($m) {
        $model = parent::setModel($m);



        $this->template['guests'] = $model->action('count')->getOne();
        $this->template['drinks'] = $model->action('fx', ['sum', 'units_of_drink'])->getOne();

        return $model;
    }
}
