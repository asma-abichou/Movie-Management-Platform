<?php
?>
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
                    <div class = "sidebar-row">
                        <div id="sidebar-items">
                            <ul>

                                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Dropdown
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><button class="dropdown-item" type="button">Dropdown item</button></li>
                                        <li><button class="dropdown-item" type="button">Dropdown item</button></li>
                                        <li><button class="dropdown-item" type="button">Dropdown item</button></li>
                                    </ul>


                                  <!--  <a href="#listOfMovies" data-toggle="collapse" aria-expanded="false">
                                        <i class="fas fa-file-video"></i>
                                            <span>Movies</span>
                                                <i class="fas fa-chevron-right float-right"></i>
                                    </a>
                                    <div class="collapse collapse-content" id="listOfMovies">
                                        <ul>
                                            <li><a href="#">Add new movie</a></li>
                                            <li><a href="#">List of movies</a></li>
                                        </ul>
                                    </div>-->
                                </li>
                            </ul>
                        </div>
                    </div>
            </aside>
