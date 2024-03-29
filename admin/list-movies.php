<?php
    include_once "../session.php";
    include_once "../MoviesController.php";

    if(!isset($_SESSION["user"]))
    {
        header('location: ../index.php');
        die();
    }
    //var_dump($_SESSION["user"]);

    $moviesController = new MoviesController();

    $per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 5;
    $movies = $moviesController->getMovies($per_page);

    //$pagination_links = $moviesController->pagination_links;

    if(isset($_GET['action']) && $_GET['action'] == "delete-movie"){
        $movie_id = $_GET['movie_id'];
        $moviesController->deleteMovie($movie_id);

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Movies</title>
    <meta charset="utf-8">
    <meta charset="utf-8">
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
    <link href="../css/jquery.toast.min.css" rel="stylesheet" type="text/css">
    <link href="../css/jquery-confirm.min.css" rel="stylesheet" type="text/css">

    <!-- Include English language -->
    <script src="js/plugins/datepicker/dist/js/i18n/datepicker.en.js"></script>

    <style>
        .page-link {
            background-color: unset !important;
            padding: 6px 12px 6px 12px !import ant;
            color:white;
            border: none;
        }
        .page-item {
            padding-bottom:4px;
        }
    </style>
</head>
<body>
<main>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12" style="padding-left:0px; padding-right:0px;">

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
                                <img src="../profileImage/<?php echo  $_SESSION['user']['profile_image']; ?> " height="25px" width="25px">
                            </a>
                        </li>
                        <li>
                            <a class="nav-link">
                                <?php echo $_SESSION["user"]["full_name"]?>
                                <i class="fas fa-chevron-down"></i>
                            </a>
                            <a class="nav-link" href="../logout.php">
                                Log Out
                            </a>
                            <a class="nav-link" href="../currentPassword.php">
                                Change Password
                            </a>
                        </li>
                    </ul>
            </div>
            <div class="row">

            <div id="users-container">
                <div id="pagination-container">
                    <ul style="display:flex; position:relative;margin-top:6px">
                        <li>Show</li>
                        <li>
                            <select name="per_page" id="per_page">
                                <option >5</option>
                                <option selected>10</option>
                                <option  >15</option>
                                <option >20</option>
                            </select>
                        </li>
                        <li>entries</li>
                    </ul>


                <?php
                include_once "../MoviesController.php";
                include_once "Paginator.php";
                $moviesController = new MoviesController();
                $movies = $moviesController->getMovies();


                $pagination_links = $moviesController->pagination_links;
                ?>
                    <ul style="display:flex;margin-left: auto" class="paginator-ul">
                        <?= $pagination_links ?>
                    </ul>
                </div>
                <table id="movies">
                    <tr>
                        <th>Movie Title</th> <th>Genre(s)</th> <th>Year Released</th><th>Cover Imagge</th> <th>Actions</th>
                    </tr>
                    <?php foreach($movies as $key=>$movie){ ?>
                        <tr>
                                <td><?= $movie['mv_title']?></td>
                                <td><?= $movie['genres']?></td>
                                <td><?= $movie['mv_year_released']?></td>
                                <td style="width:15px"><img src="../<?=$movie['img_path']?>" height="25px" width="25px"></td>
                                <td style="width:15px">
                                    <a href="edit-movie.php?id=<?= $movie['mv_id'] ?>">edit</a>
                                    <a class="delete-movie" data-movie-id="<?= $movie['mv_id'] ?>" href="#">delete</a>
                                </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>            
        </div>
            <!-- Footer -->
            <footer class="page-footer font-small blue">

                <!-- Copyright -->
                <div class="footer-copyright text-center py-3">© 2019 Copyright:
                    <a href="https://mdbootstrap.com/education/bootstrap/"> goodmovies</a>
                </div>
                <!-- Copyright -->

            </footer>
            <!-- Footer -->
            </div>

        </div>
    </div>
</div>
    </div>
<script src="../js/jquery.toast.min.js"></script>
<script src="../js/jquery-confirm.min.js"></script>
<?php if(Session::exists('success-message')) { ?>
<script>
    $.toast({
        text : "<?= Session::get('success-message') ?>",
        // It can be plain, fade or slide
        bgColor : 'green',              // Background color for toast
        textColor : '#eee',            // text color
        allowToastClose : false,       // Show the close button or not
        hideAfter : 5000,              // `false` to make it sticky or time in miliseconds to hide after
        stack : 5,                     // `false` to show one stack at a time count showing the number of toasts that can be shown at once
        textAlign : 'left',            // Alignment of text i.e. left, right, center
        position : 'bottom-left'
    })
</script>
<?php }
   Session::destroy('success-message');
?>
<script>
    $('.delete-movie').click(function(){
        let movie_id = $(this).attr('data-movie-id');

        $.confirm({
            title: 'Confirm!',
            content: 'Are You Sure To Delete This Movie ?!',
                buttons: {
                    cancel: function () {

                    },
                yes: {
                    text: 'Yes',
                    btnClass: 'btn-blue',
                    keys: ['enter', 'shift'],
                    action: function(){
                        window.location.href="list-movies?action=delete-movie&movie-id="+movie_id;
                    }
                }
            }
        });
    });
</script>
</main>
</body>
</html>