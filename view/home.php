<?php
    session_start();
    // // Fetch favorite places
    // $favPlacesSql = "SELECT * FROM favourite_places WHERE user_id = ? LIMIT 5";
    // $stmtFavPlaces = $conn->prepare($favPlacesSql);
    // $stmtFavPlaces->bind_param("i", $userId);
    // $stmtFavPlaces->execute();
    // $favPlacesResult = $stmtFavPlaces->get_result();
    // $favPlaces = [];
    // while ($row = $favPlacesResult->fetch_assoc()) {
    //     $favPlaces[] = $row;
    // }
    // $stmtFavPlaces->close();

    // // Check if user already has 5 favorite places
    // $checkFavCountSql = "SELECT COUNT(*) AS fav_count FROM favourite_places WHERE user_id = ?";
    // $stmtCheckFavCount = $conn->prepare($checkFavCountSql);
    // $stmtCheckFavCount->bind_param("i", $userId);
    // $stmtCheckFavCount->execute();
    // $favCountResult = $stmtCheckFavCount->get_result();
    // $favCount = $favCountResult->fetch_assoc()['fav_count'];
    // $stmtCheckFavCount->close();

    // if ($favCount >= 5) {
    //     echo "You can only have up to 5 favorite places.";
    //     exit();
    // }







    if(isset($_SESSION['status']) || isset($_COOKIE['status'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App Dashboard</title>
    <!--Material CDN-->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/dashboard.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
</head>
<body>
    <!-- main containner -->
    <div class="container">
        <!-- aside container start -->
        <aside>
            <!-- top contents of aside -->
            <div class="top">
                <!-- logo of weather app -->
                <div class="logo">
                    <img src="../assets/images/ashiqur_saron.png">
                    <h2>
                        WEA
                        <span class="danger">
                            DOW
                        </span>
                    </h2>
                </div>
                <!-- close button for side bar -->
                <div class="close" id="close-btn">
                    <span class="material-symbols-outlined">close_small</span>
                </div>
            </div>
            <!-- sidebar contents and all the link buttons -->
            <div class="sidebar">
                <!-- Dashboard Button -->
                <a href="#" class="active" data-section="dashboard">
                    <span class="material-symbols-outlined">dashboard</span>
                    <h3>Dashboard</h3>
                </a>
                <!-- Profile -->
                <a href="#" data-section="profile">
                    <span class="material-symbols-outlined">account_circle</span>
                    <h3>Profile</h3>
                </a>   
                <!--Settings-->
                <a href="#" data-section="settings">
                    <span class="material-symbols-outlined">settings</span>
                    <h3>Settings</h3>
                </a>
                <!-- Radar  -->
                <a href="#" data-section="map">
                    <span class="material-symbols-outlined">map</span>
                    <h3>Radar</h3>
                </a>
               <!--  Notifications-->
                <a href="#" data-section="notifications">
                    <span class="material-symbols-outlined">notifications</span>
                    <h3>Notification</h3>
                    <span class="notification-count">10</span>
                </a>
                <!-- Logout -->
                <a href="../controller/logout.php" >
                    <!-- data-section="logout" -->
                    <span class="material-symbols-outlined">logout</span>
                    <h3>LOGOUT</h3>
                </a>                
                
            </div>
        </aside>
        <!-- main central portion -->
        <main>
            <section id="dashboard-section">
                <h1>Dashboard</h1>
                <!-- current date showcase -->
                <div class="date">
                    <input type="date">
                </div>
                <!-- weather insights class  -->
                <div class="weather-insights">
                    <!-- <div class="search-weather">
                        <div class="search-container">
                            <input id="search" class="form-control" type="text" placeholder="Enter City" aria-label="Search" />
                            <button id="search-btn" class="btn btn-info" type="submit" aria-label="Search for weather">
                                Search
                            </button>
                        </div>
                    </div> -->
                    <!-- live weather card -->
                    <div class="live-weather-card">
                        <h1 class="city-name">HOME</h1>
                        <!-- middle portion showing icon and temperature -->
                        <div class="middle">
                            <!-- left portion showing temperature -->
                            <div class="left">
                                <h3>Temperature</h3>
                                <h1>30 &deg </h1>
                            </div>
                            <!-- right portion showing icon -->
                            <div class="temp-icon">
                                <span class="material-symbols-outlined">sunny</span>
                            </div>
                        </div>
                        <!-- showcasing other weather details [Wind-Speed] -->
                        <div class="weather-details">
                            <h4>Wind Speed:</h4>
                            <p>30 MPH</p>
                        </div>
                        <!-- showcasing other weather details [Humadity] -->
                        <div class="weather-details">
                            <h4>Humadity:</h4>
                            <p>64 %</p>
                        </div>
                        <!-- showcasing other weather details [UV Index] -->
                        <div class="weather-details">
                            <h4>UV Index:</h4>
                            <p>11.19</p>
                        </div>
                        <!-- showcasing other weather details [Feels Like] -->
                        <div class="weather-details">
                            <h4>Feels Like:</h4>
                            <p>Hot</p>
                        </div>

                        

                    </div>
                    <div class="live-weather-card">
                        <h1 class="city-name">OFFICE</h1>
                        <!-- middle portion showing icon and temperature -->
                        <div class="middle">
                            <!-- left portion showing temperature -->
                            <div class="left">
                                <h3>Temperature</h3>
                                <h1>28 &deg </h1>
                            </div>
                            <!-- right portion showing icon -->
                            <div class="temp-icon">
                                <span class="material-symbols-outlined">rainy</span>
                            </div>
                        </div>
                        <!-- showcasing other weather details [Wind-Speed] -->
                        <div class="weather-details">
                            <h4>Wind Speed:</h4>
                            <p>30 MPH</p>
                        </div>
                        <!-- showcasing other weather details [Humadity] -->
                        <div class="weather-details">
                            <h4>Humadity:</h4>
                            <p>64 %</p>
                        </div>
                        <!-- showcasing other weather details [UV Index] -->
                        <div class="weather-details">
                            <h4>UV Index:</h4>
                            <p>11.19</p>
                        </div>
                        <!-- showcasing other weather details [Feels Like] -->
                        <div class="weather-details">
                            <h4>Feels Like:</h4>
                            <p>Hot</p>
                        </div>

                        

                    </div>

                    <div class="live-weather-card">
                        <center>
                            <h1 class="city-name">Search</h1>
                        </center>
                        <!-- middle portion showing icon and temperature -->
                        <div class="middle">
                            <br><br>
                            <!-- left portion showing temperature -->
                            <div class="left">
                                <!-- <h3>Temperature</h3>
                                <h1>30 &deg </h1> -->
                                
                                <input type="text" placeholder="Enter area">
                            </div>
                            <!-- right portion showing icon -->
                            <div class="temp-icon">
                                <!-- <span class="material-symbols-outlined">search</span> -->
                            </div>
                        </div>
                        <!-- showcasing other weather details [Wind-Speed] -->
                        <div class="weather-details">
                            <!-- <h4>Wind Speed:</h4>
                            <p>30 MPH</p> -->

                        </div>
                        <!-- showcasing other weather details [Humadity] -->
                        <div class="weather-details">
                            <!-- <h4>Humadity:</h4>
                            <p>64 %</p> -->
                        </div>
                        <!-- showcasing other weather details [UV Index] -->
                        <div class="weather-details">
                            <!-- <h4>UV Index:</h4>
                            <p>11.19</p> -->
                        </div>
                        <!-- showcasing other weather details [Feels Like] -->
                        <div class="weather-details">
                            <!-- <h4>Feels Like:</h4>
                            <p>Hot</p> -->
                        </div>

                        

                    </div>
                    
                </div>
                <!-- weather forecast section to showcase future 5 days weather -->
                <div class="weather-forecast">
                    <h2>Weather Forecast</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Temperature</th>
                                <th>Wind Speed</th>
                                <th>Humadity</th>
                                <th>UV Index</th>
                                <th></th>
                            </tr>

                        </thead>
                        <tbody>
                            <tr>
                                <td>04-03-2025</td>
                                <td>30 &deg</td>
                                <td>60 MPH</td>
                                <td>86%</td>
                                <td>9.45</td>
                                <td><span class="material-symbols-outlined">sunny</span></td>
                            </tr>
                            <tr>
                                <td>04-03-2025</td>
                                <td>30 &deg</td>
                                <td>60 MPH</td>
                                <td>63%</td>
                                <td>13.75</td>
                                <td><span class="material-symbols-outlined">rainy</span></td>
                            </tr>
                            <tr>
                                <td>04-03-2025</td>
                                <td>22 &deg</td>
                                <td>50 MPH</td>
                                <td>76%</td>
                                <td>11.45</td>
                                <td><span class="material-symbols-outlined">cloudy</span></td>
                            </tr>
                            <tr>
                                <td>04-03-2025</td>
                                <td>30 &deg</td>
                                <td>60 MPH</td>
                                <td>48%</td>
                                <td>11.45</td>
                                <td><span class="material-symbols-outlined">rainy</span></td>
                            </tr>
                            <tr>
                                <td>04-03-2025</td>
                                <td>30 &deg</td>
                                <td>60 MPH</td>
                                <td>76%</td>
                                <td>11.45</td>
                                <td><span class="material-symbols-outlined">sunny</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
                        <section id="profile-section" style="display:none;">
                <h1>Profile</h1>
                <div class="profile-details beautified-profile">
                    <div class="profile-card">
                        <div class="profile-photo-large">
                            <img src="../assets/images/profile-1.jpg" alt="Profile Photo" />
                        </div>
                        <div class="profile-info">
                            <h2>Saron</h2>
                            <p class="profile-role">User</p>
                            <p><span class="material-symbols-outlined">mail</span> saron@gmail.com</p>
                            <p><span class="material-symbols-outlined">location_on</span> Dhaka, Bangladesh</p>
                        </div>
                        <div class="profile-actions">
                            <button class="edit-btn"><span class="material-symbols-outlined">edit</span> Edit Profile</button>
                            <button class="logout-btn" onclick="window.location.href='../controller/logout.php'">
                                <span class="material-symbols-outlined">logout</span> Logout
                            </button>
                        </div>
                    </div>
                </div>
                <style>
                    .beautified-profile {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        min-height: 350px;
                    }
                    .profile-card {
                        background: #fff;
                        border-radius: 16px;
                        box-shadow: 0 4px 24px rgba(0,0,0,0.10);
                        padding: 2rem 2.5rem;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        min-width: 320px;
                        max-width: 350px;
                        width: 100%;
                        transition: box-shadow 0.2s;
                    }
                    .profile-card:hover {
                        box-shadow: 0 8px 32px rgba(0,0,0,0.15);
                    }
                    .profile-photo-large img {
                        width: 120px;
                        height: 120px;
                        border-radius: 50%;
                        object-fit: cover;
                        border: 4px solid #007bff;
                        margin-bottom: 1rem;
                        background: #f0f2f5;
                    }
                    .profile-info {
                        text-align: center;
                        margin-bottom: 1.5rem;
                    }
                    .profile-info h2 {
                        margin: 0 0 0.3rem 0;
                        color: #222;
                        font-size: 1.6rem;
                        font-weight: 700;
                    }
                    .profile-role {
                        color: #007bff;
                        font-weight: 500;
                        margin-bottom: 0.7rem;
                    }
                    .profile-info p {
                        margin: 0.2rem 0;
                        color: #555;
                        font-size: 1rem;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        gap: 0.4em;
                    }
                    .profile-actions {
                        display: flex;
                        gap: 1rem;
                        width: 100%;
                        justify-content: center;
                    }
                    .edit-btn, .logout-btn {
                        background: #007bff;
                        color: #fff;
                        border: none;
                        border-radius: 5px;
                        padding: 0.6rem 1.2rem;
                        font-size: 1rem;
                        cursor: pointer;
                        display: flex;
                        align-items: center;
                        gap: 0.4em;
                        transition: background 0.2s;
                    }
                    .edit-btn:hover {
                        background: #0056b3;
                    }
                    .logout-btn {
                        background: #dc3545;
                    }
                    .logout-btn:hover {
                        background: #b52a37;
                    }
                </style>
            </section>
            <section id="settings-section" style="display:none;">
                    <h1>Settings</h1>
                    <form class="settings-form">
                        <label>
                            <span>Dark Mode</span>
                            <input type="checkbox" id="dark-mode-toggle">
                        </label>
                        <label>
                            <span>Notification Alerts</span>
                            <input type="checkbox" id="notification-toggle" checked>
                        </label>
                        <label>
                            <span>Change Password</span>
                            <input type="password" placeholder="New Password">
                        </label>
                        <button type="submit">Save Settings</button>
                    </form>
            </section>
            <section id="map-section" style="display:none;"> 
                <h1>Weather Map</h1>
                <div id="map" ></div>
                <div id="controls">
                    <button onclick="toggleLayer('rain')">Rain</button>
                    <button onclick="toggleLayer('snow')">Snow</button>
                    <button onclick="toggleLayer('satellite')">Satellite</button>
                    <button onclick="playRadar()">Play Radar</button>
                </div>
            </section>
            <!-- Notifications Section -->
            <section id="notifications-section" style="display:none;">
                <h1>Notifications</h1>
                <div class="notifications-list">
                    <div class="notification">
                        <span class="material-symbols-outlined">warning</span>
                        <div>
                            <p><b>Storm Alert:</b> Heavy storm expected tomorrow.</p>
                            <small class="text-muted">2 minutes ago</small>
                        </div>
                    </div>
                    <div class="notification">
                        <span class="material-symbols-outlined">sunny</span>
                        <div>
                            <p><b>Sunny Day:</b> Clear skies expected today.</p>
                            <small class="text-muted">1 hour ago</small>
                        </div>
                    </div>
                    <div class="notification">
                        <span class="material-symbols-outlined">rainy</span>
                        <div>
                            <p><b>Rain Alert:</b> Light rain in the evening.</p>
                            <small class="text-muted">3 hours ago</small>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <!-- right section of the dashboard -->
        <div class="right">
            <!-- right top section of the dashboard -->
            <div class="top">
                <button id="menu-btn">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <!-- theme toggler button to change to dark mode -->
                <div class="theme-toggler">
                    <span class="material-symbols-outlined active">light_mode</span>
                    <span class="material-symbols-outlined">dark_mode</span>
                </div>
                <!-- right side profile section -->
                <div class="profile">
                    <!-- info of profile -->
                    <div class="info">
                        <p>Hey, <b>Saron</b></p>
                        <small class="text-muted">User</small>
                    </div>
                    <!-- profile image -->
                    <div class="profile-photo">
                        <img src="../assets/images/profile-1.jpg" alt="">
                    </div>
                </div>
            </div>
            <!-- End of top -->
            <!-- right side Recent Notifications section-->
            <div class="recent-notifications">
                <h2>Notifications</h2>
                <!-- notifications alert of storm of recent alert -->
                <div class="notifications">
                    <!-- notification alert 1 -->
                    <div class="notification">
                        <!-- notification alert 1 image -->
                        <div class="alert-image">
                            <span class="material-symbols-outlined">warning</span>
                        </div>
                        <!-- notification alert 1 message -->
                        <div class="message">
                            <p><b>Storm</b> Tommorow</p>
                            <small class="text-muted">2 minitues Ago</small>
                        </div>
                    </div>
                    <!-- notification alert 2 -->
                    <div class="notification">
                        <!-- notification alert 2 image -->
                        <div class="alert-image">
                            <span class="material-symbols-outlined">warning</span>
                        </div>
                        <!-- notification alert 2 message -->
                        <div class="message">
                            <p><b>Sunny</b> Tommorow</p>
                            <small class="text-muted">2 minitues Ago</small>
                        </div>
                    </div>
                    <!-- notification alert 3 -->
                    <div class="notification">
                        <!-- notification alert 3 image -->
                        <div class="alert-image">
                            <span class="material-symbols-outlined">warning</span>
                        </div>
                        <!-- notification alert 3 message -->
                        <div class="message">
                            <p><b>Rainy</b> Tommorow</p>
                            <small class="text-muted">2 minitues Ago</small>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Notifications -->
            <!-- right side favourite places -->

            <!-- <div class="favourite-places"> -->
                <!-- <h2> -->
                    <!-- Favourite Places -->
                <!-- </h2> -->
                <!-- favourite place 1 -->
                <!-- <div class="favourite-place place1"> -->
                    <!-- favourite place 1 icon -->
                    <!-- <div class="icon"> -->
                        <!-- <span class="material-symbols-outlined">home</span> -->
                    <!-- </div> -->
                    <!-- favourite place 1 middle portion -->
                    <!-- <div class="middle"> -->
                        <!-- favourite place 1 info in middle portion -->
                        <!-- <div class="info"> -->
                            <!-- <h2>HOME</h2> -->
                            <!-- <h4><b>30 &deg</b></h4> -->
                            <!-- <h4>Extra Cloudy</h4> -->
                        <!-- </div> -->
                    <!-- </div> -->
                    <!-- favourite place 1 right portion -->
                    <!-- <div class="right"> -->
                        <!-- favourite place 1 right portion icon -->
                        <!-- <span class="material-symbols-outlined">sunny</span> -->
                    <!-- </div> -->

                <!-- </div> -->
                <!-- favourite place add section -->
                <!-- <div class="favourite-place add"> -->
                    <!-- favourite place add section add icon -->
                    <!-- <div> -->
                        <!-- <span class="material-symbols-outlined">add</span> -->
                        <!-- <h3>Add Place</h3> -->
                    <!-- </div> -->
                <!-- </div> -->
            <!-- </div> -->
             <div class="favourite-places">
                <h2>Favourite Places</h2>
                <?php foreach ($favPlaces as $index => $place): ?>
                    <div class="favourite-place place<?php echo $index + 1; ?>">
                        <div class="icon">
                            <span class="material-symbols-outlined">home</span>
                        </div>
                        <div class="middle">
                            <div class="info">
                                <h2><?php echo htmlspecialchars($place['place_name']); ?></h2>
                                <h4><b><?php echo htmlspecialchars($place['location']); ?></b></h4>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (count($favPlaces) < 5): ?>
                    <div class="favourite-place add">
                        <div>
                            <span class="material-symbols-outlined">add</span>
                            <h3>Add Place</h3>
                        </div>
                    </div>
                <?php endif; ?>
            </div>


            <!-- end of favourite place -->
        </div>
    </div>
    <script src="../assets/dashboard.js"></script>
</body>
</html>
<?php
    }else{
        header('location: login.html');
    }

?>

