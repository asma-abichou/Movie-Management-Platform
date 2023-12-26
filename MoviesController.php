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
    }

    public function createMovieGenres($movies_genres, $movie_id)
    {
        foreach ($movies_genres as $key => $genre_id) {
            $movie_genres_arr = [
                'mvg_ref_genre' => $genre_id,
                'mvg_ref_movie' => $movie_id
            ];
        }
        $this->crud->create($movie_genres_arr, 'mv_genres');
    }

    //get the movies from the DataBase and return them
    public function getMovies(){
        //give all genres movies
        $query = "SELECT mv_id, mv_title, gnr_name, GROUP_CONCAT(gnr_name) genres, mv_year_released
                     FROM `movies`
                    LEFT JOIN mv_genres on mvg_ref_movie = mv_id 
                    LEFT JOIN genres on mvg_ref_genre = gnr_id
                    GROUP BY mv_id";
        $results = $this->crud->read($query);
        return $results;
    }

    //upload cover img for our movie
    public function saveAndUploadCoverImage($movie_id){
        // Directory path
        $dir = "images/movie_covers/movie_$movie_id/"; //movie_1
        // If the directory doesn't exist, create it with the permissions 0744
        if(! file_exists($dir)){
            mkdir($dir, 0744);
        }
        // Append the basename of the uploaded file to the directory path
        $dir = $dir."/".basename($_FILES["cover_images"]["name"]);

        // Upload the image to the specified directory
        // Note: The second argument of move_uploaded_file should be the full destination path, not just the directory
        move_uploaded_file($_FILES["cover_images"]["name"],$dir);
        $image_info=[
            'img_path' => $dir,
            'img_ref_movie' => $movie_id
        ];

    }
}