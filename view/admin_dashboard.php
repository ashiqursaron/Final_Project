<?php
session_start();
if(isset($_SESSION['status']) || isset($_COOKIE['status'])){

?>










<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/x-icon" href="../assets/images/ashiqur_saron.png">

    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/admin_dashboard.css">
  </head>
  <body>
    <div class="grid-container">

      <!-- Header -->
      <header class="header">
        <div class="menu-icon" onclick="openSidebar()">
          <span class="material-icons-outlined">menu</span>
        </div>
        <div class="header-left">
          <span class="material-icons-outlined">search</span>
        </div>
        <div class="header-right">
          <span class="material-icons-outlined">notifications</span>
          <span class="material-icons-outlined">email</span>
          <span class="material-icons-outlined">account_circle</span>
        </div>
      </header>
      <!-- End Header -->

      <!-- Sidebar -->
      <aside id="sidebar">
        <div class="sidebar-title">
          <div class="sidebar-brand">
            <span class="material-icons-outlined">supervised_user_circle</span> 
             <!-- <img src="../assets/images/ashiqur_saron.png"> -->
            WEATHER
          </div>
          <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
        </div>

        <ul class="sidebar-list">
          <li class="sidebar-list-item">
            <a href="#" class="active" data-section="dashboard">
              <span class="material-icons-outlined">dashboard</span> Dashboard
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="#" data-section="user">
              <span class="material-icons-outlined">groups</span> Users
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="#" data-section="complaint">
              <span class="material-icons-outlined">pending_actions</span> Complaint
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="#" data-section="settings">
              <span class="material-icons-outlined">settings</span> Settings
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="#" data-section="logout">
              <span class="material-icons-outlined">logout</span> Log Out
            </a>
          </li>
        </aside>  
      <!-- End Sidebar -->

      <!-- Main -->
      <main class="main-container">

          <!-- Sections -->
           <section id="dashboard-section">
              

                  <div class="main-cards">

                  <div class="card">
                    <div class="card-inner">
                      <p class="text-primary">Total Users</p>
                      <span class="material-icons-outlined text-blue">groups</span>
                    </div>
                    <span class="text-primary font-weight-bold">249</span>
                  </div>

                  <div class="card">
                    <div class="card-inner">
                      <p class="text-primary">Active Users</p>
                      <span class="material-icons-outlined text-orange">person</span>
                    </div>
                    <span class="text-primary font-weight-bold">83</span>
                  </div>

                  <div class="card">
                    <div class="card-inner">
                      <p class="text-primary">Male User</p>
                      <span class="material-icons-outlined text-green">male</span>
                    </div>
                    <span class="text-primary font-weight-bold">79</span>
                  </div>

                  <div class="card">
                    <div class="card-inner">
                      <p class="text-primary">Female User</p>
                      <span class="material-icons-outlined text-red">female</span>
                    </div>
                    <span class="text-primary font-weight-bold">56</span>
                  </div>

                </div>

                <div class="charts">

                  <div class="charts-card">
                    <p class="chart-title">Monthly Users</p>
                    <div id="bar-chart"></div>
                  </div>

                  <div class="charts-card">
                    <p class="chart-title">Users Growth</p>
                    <div id="area-chart"></div>
                  </div>

                </div>

           </section>
           <section id="user-section" style="display: none;">
            <!-- <p>This is  user section</p> -->

            <div class="container">
                  <div class="header">
                  <div class="filterEntries">
                      <div class="entries">
                          Show <select name="" id="table_size">
                              <option value="10">10</option>
                              <option value="20">20</option>
                              <option value="50">50</option>
                              <option value="100">100</option>
                          </select> entries
                      </div>

                      <div class="filter">
                          <label for="search">Search:</label>
                          <input type="search" name="" id="search" placeholder="Enter name">
                      </div>
                  </div>

                  <div class="addMemberBtn">
                      <button>New member</button>
                  </div>

                </div>

                <table>
                  <thead>
                    <tr class="heading">
                        <th>SL No</th>
                        <th>User Type</th>
                        <th>Picture</th>
                        <th>Full Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Profession</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Start Date</th>

                  </tr>
                  </thead>
                  <tbody class="userInfo">

                  </tbody>
                </table>
                <div class="footer">
                  <span class="showEntries">Showing 1 to 10 of 50 entries</span>
                  <div class="pagination">
                    
                </div>
                </div>
            </div>


            <!--Popup Form-->
            <div class="dark_bg">
              <div class="popup">
                <div class="header">
                  <h2 class="modalTitle">Fill The Form</h2>
                  <button class="closeBtn">&times;</button>
                </div>
                <div class="body">
                  <form action="#" id="myForm">
                    <div class="imgholder">
                      <label for="uploading" class="upload">
                        <input type="file" name="" id="uploading" class="picture">
                        <i class="fa-solid fa-plus"></i>
                      </label>
                      <!-- <img src="./images/vscode.png" alt="" width="150" height="150" class="img"> -->
                      <img src="../assets/images/user.png" alt="Placeholder" width="150" height="150" class="img">
                    </div>
                    <div class="inputFieldContainer">
                      <input type="hidden" id="userId">
                      <div class="nameField">
                        <div class="form_control">
                          <label for="fname">First Name:</label>
                          <input type="text" name="" id="fname" required>
                        </div>
                        <div class="form_control">
                          <label for="lname">Last Name:</label>
                          <input type="text" name="" id="lname" required>
                        </div>
                        
                      </div>
                      <div class="userPassField">
                        <div class="form_control">
                          <label for="username">User Name:</label>
                          <input type="text" name="" id="username" required>
                        </div>
                        <div class="form_control">
                          <label for="password">Password:</label>
                          <input type="password" name="" id="password" required>
                        </div>

                      </div>
                      <div class="emailMobileField">
                        <div class="form_control">
                          <label for="email">email:</label>
                          <input type="text" name="" id="email" required>
                        </div>
                        <div class="form_control">
                          <label for="mobile">Mobile Number:</label>
                          <input type="text" name="" id="mobile" required>
                        </div>

                      </div>
                      <div class="genderProfField">
                        <div class="form_control">
                          <label for="gender">Gender:</label>
                          <input type="text" name="" id="gender" required>
                        </div>
                        <div class="form_control">
                          <label for="profession">Profession</label>
                          <input type="text" name="" id="profession" required>
                        </div>

                      </div>
                      <div class="form_control">
                            <label for="userType">User Type:</label>
                            <input type="text" name="userType" id="type" required>
                            
                      </div>
                      <div class="form_control">
                            <label for="dob">Date of Birth:</label>
                            <input type="date" name="" id="dob" required>
                      </div>

                    </div>
                  </form>
                </div>
                <div class="popupFooter">
                  <button form="myForm" class="submitBtn">Submit</button>
                </div>
              </div>
            </div>



                


            

















           </section>
           <section id="complaint-section" style="display:none;">
            <!-- <p>This is complaint section</p> -->
            <!-- Add this inside <section id="complaint-section"> -->
            <div class="complaint-container">
                <h2>User Complaints & Suggestions</h2>
                <div class="complaint-controls">
                    <label for="deleteDays">Days:</label>
                    <input type="number" id="deleteDays" min="1" placeholder="Enter days">
                    <button id="deleteComplaintsBtn">Delete Recent</button>
                </div>
                <table class="complaint-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Message</th>
                            <th>Posted Date</th>
                        </tr>
                    </thead>
                    <tbody id="complaintTableBody">
                        <!-- Complaints will be loaded here -->
                    </tbody>
                </table>
            </div>
           </section>
           <section id="settings-section" style="display:none;">
            <p>This is settings section</p>
            <!-- Settings Section -->
              <div class="settings-container">
                  <h2>Settings</h2>
                  <form id="settingsForm">
                      <!-- <div class="settings-group">
                          <label for="themeSelect">Theme:</label>
                          <select id="themeSelect">
                              <option value="default">Default</option>
                              <option value="dark">Dark</option>
                              <option value="light">Light</option>
                          </select>
                      </div>
                      <div class="settings-group">
                          <label for="emailNotif">Email Notifications:</label>
                          <input type="checkbox" id="emailNotif" checked>
                      </div> -->
                      <div class="settings-group">
                          <label for="profileName">Profile Name:</label>
                          <input type="text" id="profileName" placeholder="Enter your name">
                      </div>
                      <div class="settings-group">
                          <label for="changePassword">Change Password:</label>
                          <input type="password" id="changePassword" placeholder="New password">
                      </div>
                      <button type="submit" class="settings-btn">Save Changes</button>
                  </form>
              </div>
           </section>





        
      </main>
      <!-- End Main -->

    </div>

    <!-- Scripts -->
    <!-- ApexCharts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
    <!-- Custom JS -->
    <script src="../assets/admin_dashboard.js"></script>
    
    <!-- <script src="js/crud.js"></script> -->
  </body>
</html>










<?php
    }else{
        header('location: login.html');
    }

?>