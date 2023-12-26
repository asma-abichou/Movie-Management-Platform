<?php
include_once "Crud.php";
class MoviesController
{
    private Crud $crud;
    public function __construct()
    {
        $this->crud = new Crud();
    }
    public function addMovie()
    {
        $movie_data = [
            'mv_title' => $_POST['mv_title'],
            'mv_year_released' => $_POST['mv_year_released'],
        ];
        //insert the data to movies table
        $this->crud->create($movie_data,'movies');
    }

}