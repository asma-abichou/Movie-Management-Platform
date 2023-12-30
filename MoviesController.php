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
       $movie_id = $this->crud->create($movie_data,'movies');
        //ged genres from the request
        $movie_genres = isset($_POST['genres']) ? $_POST['genres'] : "" ;
        $this->createMovieGenres($movie_genres, $movie_id);
        $this->saveAndUploadCoverImage($movie_id);

        Session::set('success-message', 'Movie Added Successfully');

        header('Location: list-movies.php');
    }

    public function createMovieGenres($movies_genres, $movie_id)
    {
        foreach ($movies_genres as $key => $genre_id) {
            $movies_genres = $this->crud->read("SELECT * FROM mv_genres where mvg_ref_movie = $movie_id");
            if(empty($movies_genres)){
                $movie_genres_arr = [
                    'mvg_ref_genre' => $genre_id,
                    'mvg_ref_movie' => $movie_id
                ];
                $this->crud->create($movie_genres_arr, 'mv_genres');
            }

        }

    }

    //get the movies from the DataBase and return them
    public function getMovies(){
        //give all genres movies
        $query = "SELECT mv_id, mv_title,img_path, gnr_name, GROUP_CONCAT(gnr_name) genres, mv_year_released
                     FROM `movies`
                    LEFT JOIN mv_genres on mvg_ref_movie = mv_id 
                    LEFT JOIN genres on mvg_ref_genre = gnr_id
                    LEFT JOIN images on img_ref_movie = mv_id
                    GROUP BY mv_id
                    ORDER BY mv_id DESC";
        $results = $this->crud->read($query);
        return $results;
    }

    public function getMovie($mv_id){
        //give all genres movies
        $query = "SELECT mv_id, mv_title,img_path, gnr_name, GROUP_CONCAT(gnr_name) genres, mv_year_released
                     FROM `movies`
                    LEFT JOIN mv_genres on mvg_ref_movie = mv_id 
                    LEFT JOIN genres on mvg_ref_genre = gnr_id
                    LEFT JOIN images on img_ref_movie = mv_id
                    WHERE mv_id = $mv_id
                    GROUP BY mv_id
                    ORDER BY mv_id DESC";
        $results = $this->crud->read($query);
        return $results;
    }

    //upload cover img for our movie
    public function saveAndUploadCoverImage($movie_id){
        // Directory path
        $dir = "../images/movie_covers/movie_$movie_id/"; //movie_1
        // If the directory doesn't exist, create it with the permissions 0744
        if( !file_exists($dir)){
            mkdir($dir, 0744, true);
        }
        // Append the basename of the uploaded file to the directory path
        $dir = $dir . "/" . basename($_FILES["cover_image"]["name"]);

        // Upload the image to the specified directory
        // Note: The second argument of move_uploaded_file should be the full destination path, not just the directory
        move_uploaded_file($_FILES["cover_image"]["tmp_name"],$dir);
        $image_info=[
            // Using str_replace to remove any occurrences of '../' in the directory path
            'img_path' => str_replace('../','',$dir),
            'img_ref_movie' => $movie_id
        ];
        $this->crud->create($image_info, 'images');
    }

    public function editMovie($movie_id){
        $year_released = $_POST['mv_year_released'];
        $mv_title = $_POST['mv_title'];

        $sql = "UPDATE movies
                set mv_year_released = '$year_released', mv_title = '$mv_title'
                WHERE mv_id = $movie_id";

        $this->crud->update($sql);
        $this->createMovieGenres($_POST['genres'], $movie_id);

        $this->deletedSelectedGenre($movie_id);
        if(!empty($_FILES['cover_image']['name'])){
            $this->crud->delete("delete from images where img_ref_movie = $movie_id");
            $this->saveAndUploadCoverImage($movie_id);
        }
        Session::set('success-message', 'Movie Added Successfully');

        header('Location: list-movies.php');
    }

    public function deletedSelectedGenre($movie_id){
        // Retrieve all genres associated with the specified movie
        $movie_genres = $this->crud->read("SELECT * FROM mv_genres WHERE mvg_ref_movie = $movie_id");
        // Iterate through each genre associated with the movie
        foreach ($movie_genres as $key => $movie_genre){
            // Get the genre ID
            $genre_id = $movie_genre['mvg_ref_genre'];

            // Check if the genre is not selected in the form (not present in $_POST['genres'])
            if(!in_array($genre_id, $_POST['genres']))
                // If not selected, delete the association between the genre and the movie
                $this->crud->delete("DELETE FROM mv_genres WHERE mvg_ref_genre = $genre_id");
        }
    }
}