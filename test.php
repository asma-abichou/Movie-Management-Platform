<?php

include_once "Paginator.php";
/*
$paginator = new Paginator(20,5);
echo $paginator->get_pagination_links();*/

include_once "validator.php";
/*
$data = [
  'name'=>'Asma',
  'surname'=>'Abichou',
  'age'=>25,
    'date_of_birth'=>'06-08-1998'
];
$validation_rules = [
    'name'=>'required',
    'surname'=>'required',
    'age'=>'number',
    'date_of_birth'=>'date'
];
$validator = new Validator ($data,$validation_rules);
$validator->validate();
if($validator->passes()){
    echo "The validation want well";
}else {
    echo "The validation fails";
}*/
include_once "userController.php";

//$crud = new Crud();
//$crud->create(['name'=>'Admin User', 'username'=>'admin','password'=>nd5('admin123')],'users');
//$user_controller = new UserController();
//$user_controller->login('admin', 'admin123');

phpinfo();

