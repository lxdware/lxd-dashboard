<!--
LXDWARE LXD Dashboard - A web-based interface for managing LXD servers
Copyright (C) 2020-2021  LXDWARE.COM

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
-->

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <link rel="icon" type="image/png" href="assets/images/logo-light.svg">

  <title>LXD Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/fonts/nunito.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="vendor/sb-admin-2/css/sb-admin-2.css" rel="stylesheet">
  <link href="assets/css/style.css?version=3.0" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-dark sidebar sidebar-dark accordion sidebar-divider-right" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-0">
          <img src="assets/images/logo-dark.svg" style="width: 2rem;"></img>
          <!-- <i class="fas fa-cube" style="width: 2rem;"></i> -->
        </div>
        <div class="sidebar-brand-text mx-3">LXDWARE</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="remotes.php">
          <i class="fas fa-fw fa-server"></i>
          <span>Hosts</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">  

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle" onclick="setSidebarToggleValue()"></button>
      </div>
    </ul>
    <!-- End of Sidebar -->


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle fa-1x fa-fw mr-2 text-gray-600"></i>
                <span id="username" class="mr-2 d-none d-lg-inline text-gray-600"></span>
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="user-profile.php">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="settings.php">
                  <i class="fas fa-cog fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#aboutModal">
                  <i class="fas fa-info-circle fa-sm fa-fw mr-2 text-gray-400"></i>
                  About
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" onclick="logout()">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <header class="page-header page-header-dark bg-gradient-primary-to-secondary">
            <div class="container-xl px-4">
              <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between mt-n5 ml-n5 mr-n5 bg-dark pb-6">
                  <div class="col-auto mt-4 ml-3">
                    <div class="page-header-subtitle">
                      <span id="remoteBreadCrumb">LXD Dashboard</span>
                    </div>
                    <h2 class="page-header-title mt-2">
                      USER PROFILE
                    </h2>
                    <div class="page-header-subtitle">
                      Edit user profile
                    </div>
                  </div>
                  <div class="col-12 col-xl-auto mt-4">
                    <div class="input-group input-group-joined border-0" style="width: 14rem">
                      <span class="input-group-text bg-transparent border-0">
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </header>

          <div class="row mt-n5 ml-2 mr-2">

            <div class="col-12 mt-n3">

              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary"> 
                    <ul class="nav nav-pills card-header-pills" id="cardPill" role="tablist">              
                      <li class="nav-item"><a class="nav-link active" id="nav-account-tab" href="#nav-account" data-toggle="pill" role="tab" aria-controls="nav-account" aria-selected="true">Account</a></li>
                      <li class="nav-item"><a class="nav-link" id="nav-password-tab" href="#nav-password" data-toggle="pill" role="tab" aria-controls="nav-password" aria-selected="false">Password</a></li>
                    </ul>
                  </h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="col-12">
                    
                    <div class="tab-content" id="nav-tabContent">

                      <div class="tab-pane fade show active" id="nav-account" role="tabpanel" aria-labelledby="nav-account-tab">
                        <!-- Profile Form -->
                        <div class="row">
                          <label class="col-2 col-form-label text-right">Username:</label>
                          <div class="col-4">
                            <div class="form-group">
                              <input type="text" id="usernameInput" class="form-control" placeholder="" readonly>
                            </div>
                          </div>
                        </div>
      
                        <div class="row">
                          <label class="col-2 col-form-label text-right">First Name:</label>
                          <div class="col-4">
                            <div class="form-group">
                              <input type="text" id="firstNameInput" class="form-control" placeholder="">
                            </div>
                          </div>
                        </div>
      
                        <div class="row">
                          <label class="col-2 col-form-label text-right">Last Name:</label>
                          <div class="col-4">
                            <div class="form-group">
                              <input type="text" id="lastNameInput" class="form-control" placeholder="">
                            </div>
                          </div>
                        </div>
      
                        <div class="row">
                          <label class="col-2 col-form-label text-right">Email:</label>
                          <div class="col-4">
                            <div class="form-group">
                              <input type="text" id="emailInput" class="form-control" placeholder="">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <label class="col-2 col-form-label text-right">Account Type:</label>
                          <div class="col-4">
                            <div class="form-group">
                              <input type="text" id="typeInput" class="form-control" placeholder="" readonly>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-6 text-right">
                            <div class="form-group">
                              <a class="btn btn-primary" href="#" onclick="updateUserAccount()" data-dismiss="modal">Submit</a>
                            </div>
                          </div>
                        </div>
                        <!-- End Profile Form-->
                      </div>
                      <div class="tab-pane fade" id="nav-password" role="tabpanel" aria-labelledby="nav-password-tab">
                        <!-- Password Reset Form -->
                        <div class="row">
                          <label class="col-2 col-form-label text-right">New Password:</label>
                          <div class="col-4">
                            <div class="form-group">
                              <input type="password" id="newPasswordInput" class="form-control" placeholder="">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <label class="col-2 col-form-label text-right">Confirm Password:</label>
                          <div class="col-4">
                            <div class="form-group">
                              <input type="password" id="confirmPasswordInput" class="form-control" placeholder="">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-6 text-right">
                            <div class="form-group">
                              <a class="btn btn-primary" href="#" onclick="updateUserPassword()" data-dismiss="modal">Submit</a>
                            </div>
                          </div>
                        </div>
                        <!-- End Password Reset Form -->
                      </div>

                    </div>

                  </div>
                </div>
              </div>

            </div>

          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; LXDWARE 2020 - Present</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- About Modal-->
  <div class="modal fade" id="aboutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">About</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div id="about"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Dismiss</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="vendor/sb-admin-2/js/sb-admin-2.min.js"></script>

</body>

<script>
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  var userId = urlParams.get('user');

  function logout(){
    $.get("./backend/aaa/authentication.php?action=deauthenticateUser", function (data) {
      operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.status_code == 200) {
        window.location.href = './index.php'
      }
    });
  }

  function loadPageContent(){

    //Display current logged in username
    $("#username").load("./backend/admin/settings.php?action=displayUsername");

    if (userId) {
      $.get("./backend/admin/user-profile.php?id=" + userId + "&action=retrieveUserDetails", function (data) {
        operationData = JSON.parse(data);
        $("#usernameInput").val(operationData.username);
        $("#firstNameInput").val(operationData.firstName);
        $("#lastNameInput").val(operationData.lastName);
        $("#emailInput").val(operationData.email);
        $("#typeInput").val(operationData.type);
      });
    }
    else {
      $.get("./backend/admin/user-profile.php?action=retrieveUserId", function (data) {
        operationData = JSON.parse(data);
        userId = operationData.id
        $.get("./backend/admin/user-profile.php?id=" + userId + "&action=retrieveUserDetails", function (data) {
          operationData = JSON.parse(data);
          $("#usernameInput").val(operationData.username);
          $("#firstNameInput").val(operationData.firstName);
          $("#lastNameInput").val(operationData.lastName);
          $("#emailInput").val(operationData.email);
          $("#typeInput").val(operationData.type);
        });
      });
    }

  }

  function updateUserAccount(){
    var firstNameInput = $("#firstNameInput").val();
    var lastNameInput = $("#lastNameInput").val();
    var emailInput = $("#emailInput").val();
    console.log("Info: updating user account for " + usernameInput);
    $.get("./backend/admin/user-profile.php?id=" + userId + "&first_name=" + firstNameInput + "&last_name=" + lastNameInput + "&email=" + emailInput + "&action=updateUserAccount", function (data) {
        var operationData = JSON.parse(data);
        console.log(operationData);
        if (operationData.status_code >= 400) {
          alert(operationData.metadata.error);
        }
        else{
          alert("Account updated")
        }
    });
  }

  function updateUserPassword(){
    var newPasswordInput = $("#newPasswordInput").val();
    var confirmPasswordInput = $("#confirmPasswordInput").val();
    if (newPasswordInput == confirmPasswordInput){
      console.log("Info: updating user password for user id " + userId );
      $.post("./backend/admin/user-profile.php?id=" + userId + "&action=updateUserPassword", {password: newPasswordInput}, function (data) {
        var operationData = JSON.parse(data);
        console.log(operationData);
        if (operationData.status_code >= 400) {
          alert(operationData.metadata.error);
        }
        else{
          $("#newPasswordInput").val("");
          $("#confirmPasswordInput").val("")
          alert("Password changed");
        }
      });
    }
    else {
      alert("Your passwords did not match, try again");
    }

  }

  function setSidebarToggleValue(){
    sidebarState = localStorage.getItem('sidebarState');
    if (sidebarState == "collapsed"){
      localStorage.setItem('sidebarState','expanded');
    }
    else {
      localStorage.setItem('sidebarState','collapsed');
    }
  }
  
  function applySidebarToggleValue() {
    sidebarState = localStorage.getItem('sidebarState');
    if (sidebarState == "collapsed"){
      $("body").toggleClass("sidebar-toggled"), 
      $(".sidebar").toggleClass("toggled"), 
      $(".sidebar").hasClass("toggled") && $(".sidebar .collapse").collapse("hide")
    }
  }

  applySidebarToggleValue();

  $(document).ready(function(){

    //Check Authorization
    $.get("./backend/aaa/authentication.php?action=validateAuthentication", function (data) {
      operationData = JSON.parse(data);
      if (operationData.status_code != 200) {
        console.log(operationData);
        window.location.href = './index.php'
      }
    });

    //Load the card contents
    loadPageContent();
    
    //Load the about info for the about modal
    $.get("./backend/config/about.php", function (data) {
      $("#about").html(data);
    });    

  });

</script>

</html>