<?php
/*include_once "Paginator.php";

$paginator = new Paginator(20,5);
echo $paginator->get_pagination_links();*/

include_once "validator.php";

$data = [
  'name'=>'Asma',
  'surname'=>'Abichou',
  'age'=>25
];
$validation_rules = [
    'name'=>'required',
    'surname'=>'required',
    'age'=>'number'
];
$validator = new Validator ($data,$validation_rules);
$validator->validate();