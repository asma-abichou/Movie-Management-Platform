<?php
include "../session.php";
include_once "../MoviesController.php";

$dbConnection = getDbConnection();

if(!isset($_SESSION["user"]))
{
    header('location: ../index.php');
    die();
}

$moviesController = new MoviesController();
$movie = $moviesController->getMovie($_GET['id']);


if(($_SERVER['REQUEST_METHOD'] == 'POST')){

        $moviesController->editMovie($_GET['id']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Movies</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <link rel="apple-touch-icon" sizes="120x120" href="../images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <link href="../css/datepicker.min.css" rel="stylesheet" type="text/css">
    <link href="../css/chosen.min.css" rel="stylesheet" type="text/css">



    <!-- Include English language -->
   <script src="js/plugins/datepicker/dist/js/i18n/datepicker.en.js"></script>

    <style>
        .page-link {
            background-color: unset !important;
            padding: 6px 12px 6px 12px !important;
            color:white;
            border: none;
        }
        .page-item {
            padding-bottom:4px;
        }
    </style>


</head>
<body>
<div class="container-fluid">
    <div class="row">
     <div class ="col-sm-12" style="padding-left:0px;padding-right:0px;">
        <div id="main-container">
            <?php
            include_once "../body/left_side_bar.php";
            ?>
            <div id="main-panel">
                <div id="notifications-container">
                        <h3>Movies</h3>
                        <ul style="display: flex;margin-left:auto">
                            <li>
                                <a class="nav-link">
                                    <i class="fas fa-address-card"></i>
                                </a>

                            </li>
                            <li>
                                <a class="nav-link">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </li>
                            <li>
                                <a class="nav-link">
                                    <i class="fas fa-bell"></i>
                                </a>
                            </li>
                            <li>
                                <a class="nav-link">
                                    <img src="../images/<?php echo  $_SESSION['user']['profile_image']; ?>" height="25px" width="25px">
                                </a>

                            </li>
                            <li>
                                <a class="nav-link">
                                    John Doe
                                    <i class="fas fa-chevron-down"></i>
                                </a>
                            </li>
                        </ul>
                </div>
                <div class="row">
        <div class="col-sm-12">
            <div id="add-movie-header">
                <h4>Add Movie</h4>
            </div>
            <div id="add-movie-form-container">
                <form class="form-horizontal" method="post" id="add-movie-form" action='<?php $_SERVER['PHP_SELF'] ?>' autocomplete="off" enctype="multipart/form-data" />

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Title:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="title" placeholder="" name="mv_title" value="<?= $movie[0]['mv_title'] ?>">
                                        <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="pwd">Genre:</label>
                        <div class="col-sm-10">

                                <?php
                                include_once "../Crud.php";
                                //create an object of our crud class
                                $crud = new Crud();
                                $movie_id = $movie[0]['mv_id'];
                                //get all the genres from the database and we display them
                                $genres = $crud->read('select * from genres',false);

                                $current_genres = $crud->read("select * from mv_genres
                                                  join genres on gnr_id = mvg_ref_genre   
                                                  where mvg_ref_movie = $movie_id");
                                ?>
                            <select data-placeholder="Select Genre(s)..." multiple class="form-control genre"  name="genres[]" id="genre[]">
                                <?php foreach($genres as $key => $genre){ ?>}
                                    <option value="<?=$genre['gnr_id']?>"><?=$genre['gnr_name']?></option>
                               <?php }?>
                                <?php foreach($current_genres as $key=>$genre){ ?>}
                                    <option value="<?= $genre['gnr_id'] ?>" selected="selected"><?=$genre['gnr_name']?></option>
                                <?php }?>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="year">Year Released:</label>
                        <div class="col-sm-10">
                            <input id="datepicker" name="mv_year_released" data-date-format="yyyy-mm-dd" class="form-control" type="text" value="<?= $movie[0]['mv_year_released'] ?>">
                                        <span class="help-block"></span>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="year">Cover Image:</label>
                        <img src="../<?= $movie[0]['img_path'] ?>" width="194" height="259" alt="" style="margin-bottom: 15px">
                        <div class="col-sm-10">
                            <input type="file" name="cover_image" class="form-control" id="customFile" value="">
                                        <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn pull-right">Submit</button>
                            <a href="list-movies.php" class="btn pull-right" style="margin-right: 5px;">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div> 
    </div>
    <!-- Footer -->
        <footer class="page-footer font-small blue">

            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">© 2019 Copyright:
                <a href="https://mdbootstrap.com/education/bootstrap/"> Good Movies</a>
            </div>
            <!-- Copyright -->

        </footer>


        </div>
        </div>
    </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

    <script src="../js/datepicker.min.js"></script>
    <script src="../js/datepicker.en.js"></script>
    <script src="../js/chosen.jquery.js"></script>
    <script>
        $('#datepicker').datepicker({
            language: 'en',
        })
        $('.genre').chosen('Select Genre(s)');
    </script>

</body>
</html>