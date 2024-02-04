<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Latest Movies</title>

    <!-- Favicon and theme settings -->
    <link rel="apple-touch-icon" sizes="120x120" href="../images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon/favicon-16x16.png">
    <link rel="manifest" href="http://localhost/site.webmanifest">
    <link rel="mask-icon" href="http://localhost/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="application-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- Bootstrap and Font Awesome -->
    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/components/carousel/">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="../css/style.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body style="background-color: #26262d">

<header>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark" style="background-color: #343a40;">
        <a class="navbar-brand" href="http://localhost/movies_/">GoodMovies</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            MENU
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <!-- Navigation links -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="http://localhost/movies_/">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/movies_/#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="http://localhost/movies_/#">Contact us</a>
                </li>
            </ul>
            <!-- Search form -->
            <section class="yOpR1 wG6fJ">
                <form action="http://localhost/movies_/index.php" method="GET">
                    <input class="form-control" type="text" id="search-movies" placeholder="Find movies" name="search-item" required="" value="">
                </form>
            </section>
            <!-- User actions -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item ">
                    <a class="nav-link" href="profile_user.php">Profile</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="../logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<!-- Carousel -->
<div id="myCarousel" class="carousel slide" data-ride="carousel" style="height: 374px; overflow: hidden; background-size: cover;">
    <!-- Carousel indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0"></li>
        <li data-target="#myCarousel" data-slide-to="1" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <!-- Carousel items -->
    <div class="carousel-inner">
        <!-- Slide 1 -->
        <div class="carousel-item">
            <img class="d-block w-100" src="../images/slide_1.jpg" alt="The God Father">
            <div class="carousel-caption text-left">
                <h1>The God Father</h1>
                <p>The Godfather is a 1972 American crime film directed by Francis Ford Coppola...</p>
                <p><a class="btn btn-lg btn-primary" href="http://localhost/movies_/#" role="button">Watch Now</a></p>
            </div>
        </div>
        <!-- Slide 2 -->
        <div class="carousel-item active">
            <img class="d-block w-100" src="../images/slide_2.jpg" alt="Pulp Fiction">
            <div class="carousel-caption text-right">
                <h1>Pulp Fiction</h1>
                <p>Pulp Fiction is a 1994 American crime film written and directed by Quentin Tarantino...</p>
                <p><a class="btn btn-lg btn-primary" href="http://localhost/movies_/#" role="button">Watch Now</a></p>
            </div>
        </div>
    </div>
    <!-- Carousel navigation controls -->
    <a class="carousel-control-prev" href="http://localhost/movies_/#myCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="http://localhost/movies_/#myCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<main role="main">
    <!-- Movie cards -->
    <div class="container marketing">
        <h3 class="mv-category-title">Most Popular</h3>
        <div class="row">
            <!-- Movie 1 -->
            <div class="col-sm-6 col-md-4 col-lg-3 mt-4">
                <div class="card">
                    <img class="card-img-top" src="../images/movie_covers/murder in miami.PNG" alt="Murder in Miami">
                    <div class="card-block">
                        <h4 class="card-title">Murder in Miami</h4>
                    </div>
                    <div class="card-footer">
                        <div class="mv-details-container">
                            <div>Comedy, Action</div>
                            <div>2019-05-20</div>
                        </div>
                        <div class="pl-right pg">
                            <div class="mv-pg">PG 14</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Movie 2 -->
            <div class="col-sm-6 col-md-4 col-lg-3 mt-4">
                <div class="card">
                    <img class="card-img-top" src="../images/movie_covers/thong_girl.PNG" alt="Thong Girl">
                    <div class="card-block">
                        <h4 class="card-title">Thong Girl</h4>
                    </div>
                    <div class="card-footer">
                        <div class="mv-details-container">
                            <div>Comedy</div>
                            <div>2019-05-19</div>
                        </div>
                        <div class="pl-right pg">
                            <div class="mv-pg">PG 14</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Movie 3 -->
            <div class="col-sm-6 col-md-4 col-lg-3 mt-4">
                <div class="card">
                    <img class="card-img-top" src="../images/movie_covers/things to do.PNG" alt="Things to Do">
                    <div class="card-block">
                        <h4 class="card-title">Things to Do</h4>
                    </div>
                    <div class="card-footer">
                        <div class="mv-details-container">
                            <div>Comedy</div>
                            <div>2019-05-26</div>
                        </div>
                        <div class="pl-right pg">
                            <div class="mv-pg">PG 14</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Movie 4 -->
            <div class="col-sm-6 col-md-4 col-lg-3 mt-4">
                <div class="card">
                    <img class="card-img-top" src="../images/movie_covers/court.PNG" alt="Court">
                    <div class="card-block">
                        <h4 class="card-title">Court</h4>
                    </div>
                    <div class="card-footer">
                        <div class="mv-details-container">
                            <div>Thriller</div>
                            <div>2019-05-28</div>
                        </div>
                        <div class="pl-right pg">
                            <div class="mv-pg">PG 14</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Movie 5 -->
            <div class="col-sm-6 col-md-4 col-lg-3 mt-4">
                <div class="card">
                    <img class="card-img-top" src="../images/movie_covers/date_or_hire.PNG" alt="Date or Hire">
                    <div class="card-block">
                        <h4 class="card-title">Date or Hire</h4>
                    </div>
                    <div class="card-footer">
                        <div class="mv-details-container">
                            <div>Comedy</div>
                            <div>2019-03-04</div>
                        </div>
                        <div class="pl-right pg">
                            <div class="mv-pg">PG 14</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pagination -->
        <div class="row">
            <div class="col-sm-12 text-center mt-4">
                <nav aria-label="" class="pagination-centered" style="display: inline-block; background-color:inherit">
                    <ul class="pagination home-pagination">
                        <li class="page-item active">
                            <a class="page-link" href="http://localhost/movies_/?&amp;page=1">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="http://localhost/movies_/?&amp;page=2">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="http://localhost/movies_/?&amp;page=3">3</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="container-fluid text-center">
    <p class="float-right"><a href="http://localhost/movies_/#">Back to top</a></p>
    <p>© 2023-2024 Company, Inc. · <a href="http://localhost/movies_/#">Privacy</a> · <a href="http://localhost/movies_/#">Terms</a></p>
</footer>

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.6.4.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>