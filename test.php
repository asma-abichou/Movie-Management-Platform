<?php
 include_once "DBConfig.php";
 include_once "Crud.php";

$data_array = [
    'mv_year_released' => '1997-03-01',
    'mv_title' => 'Rush Hour 1'

];

 $crud = new Crud();
 //$crud->create($data_array, 'movies');
//$results = $crud->read('SELECT * from movies');
//$crud->update("UPDATE movies SET mv_title = 'Titanic 2' where mv_id =1");
//$crud->delete("DELETE from movies where mv_id = 5");