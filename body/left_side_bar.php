<?php
?>
<html lang="EN">
<head>

    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
            <aside id="left-sidebar">
                <div id="nav-brand-container">
                    <div class = "sidebar-row">
                        <a id="nav-brand"> GoodMovies
                        </a>
                        <i id="bars" class="fas fa-bars"></i>
                    </div>
                </div>
                    <div id="profile-pic-container">
                        <div class = "sidebar-row">
                            <img src="../profileImage/<?php echo  $_SESSION['user']['profile_image']; ?>" height="60px" width="60px">
                            <ul id="button-container">
                                <li><strong><?php echo $_SESSION["user"]["full_name"]?></strong><span class="active"></span>

                                </li>
                                <li style="color:#4f5967; font-size:10px;font-weight: 800">ADMINISTRATOR</li>
                                    <li>
                                        <a class = "btn btn-edit-profile " href="../profile.php">Edit Profile</a>
                                    </li>

                            </ul>
                        </div>
                    </div>
                <i class="fa-sharp fa-thin fa-video"></i>
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                        <div class="w3-dropdown-click">
                            <button class="w3-button"  onclick="myDropFunc()">
                                Movies <i class="fa fa-caret-down"></i>
                            </button>

                            <div id="demoDrop" class="w3-dropdown-content w3-bar-block w3-white w3-card">
                                <a href="../admin/list-movies.php" class="w3-bar-item w3-button">List Of Movies</a>
                                <a href="../admin/add-movie.php" class="w3-bar-item w3-button">Add New Movie</a>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
            <script>
                function myDropFunc() {
                    let x = document.getElementById("demoDrop");
                    if (x.className.indexOf("w3-show") === -1) {
                        x.className += " w3-show";
                        x.previousElementSibling.className += " w3-green";
                    } else {
                        x.className = x.className.replace(" w3-show", "");
                        x.previousElementSibling.className =
                            x.previousElementSibling.className.replace(" w3-green", "");
                    }
                }
            </script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>