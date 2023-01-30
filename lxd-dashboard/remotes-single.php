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
      
      <div id="sidebarLinks"></div>

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

           <!-- Topbar Notification -->
           <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <ul class="navbar-nav ml-auto"> 
  
              <li class="nav-item dropdown no-arrow" id="notificationArea" style="display: none;">
                <div class="nav-link dropdown-toggle">
                  <span id="notification" class="mr-2 d-none d-lg-inline text-danger">Notification</span>
                </div>
              </li>
              
            </ul>
          </div>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto"> 

            <li class="nav-item dropdown">
              <label class="h6 mt-4 mr-2 ml-4">Host: </label>
            </li>
            <li class="nav-item dropdown">
              <div class="input-group mt-3">
                <select class="form-control" id="remoteListNav" style="width:150px;" onchange="location = this.value;">
                </select>
              </div>
            </li>

            <li class="nav-item dropdown">
              <label class="h6 mt-4 mr-2 ml-4">Project: </label>
            </li>
            <li class="nav-item dropdown">
              <div class="input-group mt-3">
                <select class="form-control" id="projectListNav" style="width:150px;" onchange="location = this.value;">
                </select>
              </div>
            </li>

            <!-- Nav Divider -->
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
                <a class="dropdown-item" href="logs.php">
                  <i class="fas fa-history fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logs
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
                      <span id="">Host</span>
                    </div>
                    <h2 class="page-header-title mt-2" id="remoteBreadCrumb">
                      HOST
                    </h2>
                    <div class="page-header-subtitle">
                      Overview of the remote LXD server
                    </div>
                  </div>
                  <div class="col-12 col-xl-auto mt-4">
                    <div class="input-group input-group-joined border-0" style="width: 8rem">
                      <span class="input-group-text bg-transparent border-0">
                        <a class="mr-2 h5" href="#" role="button" id="startLink" onclick="reloadPageContent()" Title="Refresh">
                          <i class="fa fa-sync fa-lg fa-fw"></i></a>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </header>

          <div class="row mt-n5 ml-2 mr-2">

            <div class="col-12 mt-n3">
              <div class="row">

                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 py-2 mb-4">
                  <div class="card shadow h-100">
                    <a href="#" class="stretched-link" id="containersLink"></a>
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col-7 mt-n4">
                          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Containers
                          </div>
                          <div class="h5 mb-0 font-weight-bold text-gray-600 align-middle">
                            <i class="fas fa-cube fa-1x mr-2 text-primary"></i>
                            <span id="runningContainers">0</span> / <span id="totalContainers">0</span> running
                          </div>
                        </div>
                        <div class="col-5">
                          <!-- Container Progress Circle -->
                          <div class="progress-circle-xs mx-auto" id="containerPercentageGauge" data-value='0.0'>
                            <span class="progress-circle-left-xs">
                              <span class="progress-circle-bar-xs border-primary"></span>
                            </span>
                            <span class="progress-circle-right-xs">
                              <span class="progress-circle-bar-xs border-primary"></span>
                            </span>
                            <div class="progress-circle-value-xs w-100 h-100 rounded-circle d-flex align-items-center justify-content-center mt-1">
                              <div class="h6 font-weight-bold" id="containerPercentage">0.0</div><sup class="small">%</sup>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 py-2 mb-4">
                  <div class="card shadow h-100">
                    <a href="#" class="stretched-link" id="virtualMachinesLink"></a>
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col-7 mt-n4">
                          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Virtual Machines
                          </div>
                          <div class="h5 mb-0 font-weight-bold text-gray-600 align-middle">
                            <i class="fas fa-cube fa-1x mr-2 text-primary"></i>
                            <span id="runningVirtualMachines">0</span> / <span id="totalVirtualMachines">0</span> running
                          </div>
                        </div>
                        <div class="col-5">
                          <!-- Virtual Machine Progress Circle -->
                          <div class="progress-circle-xs mx-auto" id="virtualMachinePercentageGauge" data-value='0.0'>
                            <span class="progress-circle-left-xs">
                              <span class="progress-circle-bar-xs border-primary"></span>
                            </span>
                            <span class="progress-circle-right-xs">
                              <span class="progress-circle-bar-xs border-primary"></span>
                            </span>
                            <div class="progress-circle-value-xs w-100 h-100 rounded-circle d-flex align-items-center justify-content-center mt-1">
                              <div class="h6 font-weight-bold" id="virtualMachinePercentage">0.0</div><sup class="small">%</sup>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 py-2 mb-4">
                  <div class="card shadow h-100">
                    <a href="#" class="stretched-link" id="clusterMembersLink"></a>
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col-7 mt-n4">
                          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Cluster Members
                          </div>
                          <div class="h5 mb-0 font-weight-bold text-gray-600 align-middle">
                            <i class="fas fa-layer-group fa-1x mr-2 text-primary"></i>
                            <span id="onlineClusterMembers">0</span> / <span id="totalClusterMembers">0</span> online  
                          </div>
                        </div>
                        <div class="col-5">
                          <!-- Cluster Member Progress Circle -->
                          <div class="progress-circle-xs mx-auto" id="clusterPercentageGauge" data-value='0.0'>
                            <span class="progress-circle-left-xs">
                              <span class="progress-circle-bar-xs border-primary"></span>
                            </span>
                            <span class="progress-circle-right-xs">
                              <span class="progress-circle-bar-xs border-primary"></span>
                            </span>
                            <div class="progress-circle-value-xs w-100 h-100 rounded-circle d-flex align-items-center justify-content-center mt-1">
                              <div class="h6 font-weight-bold" id="clusterPercentage">0.0</div><sup class="small">%</sup>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 py-2 mb-4">
                  <div class="card shadow h-100">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col-7 mt-n4">
                          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Host Memory
                          </div>
                          <div class="h5 mb-0 font-weight-bold text-gray-600 align-middle">
                            <i class="fas fa-memory fa-1x mr-2 text-primary"></i>
                            <!--<span id="memoryPercentage">0</span>%-->
                            <span>used</span>
                          </div>
                        </div>
                        <div class="col-5">
                          <!-- Memory Progress Circle -->
                          <div class="progress-circle-xs mx-auto" id="memoryPercentageGauge" data-value='0.0'>
                            <span class="progress-circle-left-xs">
                              <span class="progress-circle-bar-xs border-primary"></span>
                            </span>
                            <span class="progress-circle-right-xs">
                              <span class="progress-circle-bar-xs border-primary"></span>
                            </span>
                            <div class="progress-circle-value-xs w-100 h-100 rounded-circle d-flex align-items-center justify-content-center mt-1">
                              <div class="h6 font-weight-bold" id="memoryPercentage">0.0</div><sup class="small">%</sup>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-lg-4 col-xl-2 py-2 mb-4">
                  <div class="card shadow h-100">
                    <a href="#" class="stretched-link" id="imagesLink"></a>
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col-7">
                          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Images
                          </div>
                          <div class="h5 mb-0 font-weight-bold text-gray-600 align-middle">
                            <span id="totalImages">0</span>
                          </div>
                        </div>
                        <div class="col-5">
                          <i class="fas fa-box-open fa-3x text-gray-200"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
  
                <div class="col-sm-6 col-lg-4 col-xl-2 py-2 mb-4">
                  <div class="card shadow h-100">
                    <a href="#" class="stretched-link" id="profilesLink"></a>
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col-7">
                          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Profiles
                          </div>
                          <div class="h5 mb-0 font-weight-bold text-gray-600 align-middle">
                            <span id="totalProfiles">0</span>
                          </div>
                        </div>
                        <div class="col-5">
                          <i class="fas fa-money-check fa-3x text-gray-200"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
  
                <div class="col-sm-6 col-lg-4 col-xl-2 py-2 mb-4">
                  <div class="card shadow h-100">
                    <a href="#" class="stretched-link" id="networksLink"></a>
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col-7">
                          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Networks
                          </div>
                          <div class="h5 mb-0 font-weight-bold text-gray-600 align-middle">
                            <span id="totalNetworks">0</span>
                          </div>
                        </div>
                        <div class="col-5">
                          <i class="fas fa-network-wired fa-3x text-gray-200"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
  
                <div class="col-sm-6 col-lg-4 col-xl-2 py-2 mb-4">
                  <div class="card shadow h-100">
                    <a href="#" class="stretched-link" id="storagePoolsLink"></a>
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col-7">
                          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Storage Pools
                          </div>
                          <div class="h5 mb-0 font-weight-bold text-gray-600 align-middle">
                            <span id="totalStoragePools">0</span>
                          </div>
                        </div>
                        <div class="col-5">
                          <i class="fas fa-hdd fa-3x text-gray-200"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-lg-4 col-xl-2 py-2 mb-4">
                  <div class="card shadow h-100">
                    <a href="#" class="stretched-link" id="projectsLink"></a>
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col-7">
                          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Projects
                          </div>
                          <div class="h5 mb-0 font-weight-bold text-gray-600 align-middle">
                            <span id="totalProjects">0</span>
                          </div>
                        </div>
                        <div class="col-5">
                          <i class="fas fa-chart-bar fa-3x text-gray-200"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-lg-4 col-xl-2 py-2 mb-4">
                  <div class="card shadow h-100">
                    <a href="#" class="stretched-link" id="networkAclsLink"></a>
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col-7">
                          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Network ACLs
                          </div>
                          <div class="h5 mb-0 font-weight-bold text-gray-600 align-middle">
                            <span id="totalNetworkAcls">0</span>
                          </div>
                        </div>
                        <div class="col-5">
                          <i class="fas fa-shield-alt fa-3x text-gray-200"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            
              <div class="col-sm-12 col-md-6 mb-4">
                <div class="card shadow h-100">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">LXD Information</h6>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <strong>Operating System</strong>: <span id="osName"></span> <span id="osVersion"></span><br />
                    <strong>LXD Version</strong>: <span id="serverVersion"></span><br />
                    <strong>Hostname</strong>: <span id="serverName"></span><br />
                    <strong>Kernel</strong>: <span id="kernel"></span> <span id="kernelArchitecture"></span><br />
                    <strong>Firewall</strong>: <span id="firewall"></span><br />
                    <br />
                    <strong>Driver</strong>: <span id="driver"></span><br />
                    <strong>Driver Version</strong>: <span id="driverVersion"></span><br />
                    <br />
                    <strong>Storage Type</strong>: <span id="storage"></span><br />
                    <strong>Storage Version</strong>: <span id="storageVersion"></span><br />
                  </div>
                </div>
              </div>

              <div class="col-sm-12 col-md-6 mb-4">
                <div class="card shadow h-100">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Resource Information</h6>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <strong>System Vendor</strong>: <span id="systemVendor"></span> <br />
                    <strong>System Product</strong>: <span id="systemProduct"></span> <br />
                    <strong>Total Memory</strong>: <span id="memoryTotal"></span> <span id="memoryUnit"></span><br />
                    <br />
                    <strong>CPU Information</strong>:
                    <ul>
                      <li><strong>Architecture</strong>: <span id="architecture"></span> </li>
                      <li><strong>CPU Count</strong>: <span id="cpus"></span> </li>
                      <li><strong>Socket</strong>: <span id="sockets"></span> </li>
                      <ul id="socketList"></ul>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="col-sm-12 col-md-7 mb-4">
                <div class="card shadow h-100">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Disk Storage Information</h6>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <table class="table">
                      <thead>
                        <th>ID</th>
                        <th>Model</th>
                        <th>Type</th>
                        <th>Size</th>
                      </thead>
                      <tbody id="diskList"></tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="col-sm-12 col-md-5 mb-4">
                <div class="card shadow h-100">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">IP Addresses Information</h6>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <strong>Addresses</strong>: <br />
                    <ul id="addressList"></ul>
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

  <!-- Page level plugins -->

</body>

<script>
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const remoteId = urlParams.get('remote'); 
  const projectName = urlParams.get('project');
  var reloadTime = 10000;

  function logout(){
    $.get("./backend/aaa/authentication.php?action=deauthenticateUser", function (data) {
      operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.status_code == 200) {
        window.location.href = './index.php'
      }
    });
  }

  function operationStatusCheck(){
    clearTimeout(operationTimeout);
    //check to see if there are any running operations
    $.get("./backend/lxd/operations.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayOperationStatus", function (data) {
      //Check to see if we have running operations
      if (data) {
        //Display notification area if there are running tasks
        $('#notificationArea').show();
        $('#notification').text("Notice: " + data);
        //Set the page to check operations again in 2 seconds
        operationTimeout = setTimeout(() => { operationStatusCheck(); }, 2000);
      }
      else {
        //Hide notification area if no running tasks
        $('#notificationArea').hide();
        $('#notification').text("");
        //Set the page to check operations again in 4 seconds
        operationTimeout = setTimeout(() => { operationStatusCheck(); }, 4000);
      }
    });
  }

  function reloadPageContent() {

    clearTimeout(pageReloadTimeout);

    //Check Authorization
    $.get("./backend/aaa/authentication.php?action=validateAuthentication", function (data) {
      operationData = JSON.parse(data);
      if (operationData.status_code != 200) {
        console.log(operationData);
        window.location.href = './index.php'
      }
    });
    
    //Resource Info
    $.get("./backend/lxd/remotes-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displaySysInfo", function (data) {
      stats = JSON.parse(data);
      $("#memoryPercentage").text(stats.memoryPercentage);
      $("#memoryPercentageGauge").attr('data-value',stats.memoryPercentage);
      formatProgressGauge();
    });

    //Container Info
    $.get("./backend/lxd/remotes-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayContainerInfo", function (data) {
      stats = JSON.parse(data);
      $("#runningContainers").text(stats.runningContainers);
      $("#totalContainers").text(stats.totalContainers);
      containerPercentage = stats.runningContainers / stats.totalContainers * 100
      if (isNaN(containerPercentage)){
        containerPercentage = 0;
      }
      else {
        containerPercentage = containerPercentage.toFixed(0);
      }
      $("#containerPercentage").text(containerPercentage);
      $("#containerPercentageGauge").attr('data-value',containerPercentage);
      formatProgressGauge();
    });

    //Virtual Machine Info
    $.get("./backend/lxd/remotes-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayVirtualMachineInfo", function (data) {
      stats = JSON.parse(data);
      $("#runningVirtualMachines").text(stats.runningVirtualMachines);
      $("#totalVirtualMachines").text(stats.totalVirtualMachines);
      virtualMachinePercentage = stats.runningVirtualMachines / stats.totalVirtualMachines * 100
      if (isNaN(virtualMachinePercentage)){
        virtualMachinePercentage = 0;
      }
      else {
        virtualMachinePercentage = virtualMachinePercentage.toFixed(0);
      }
      $("#virtualMachinePercentage").text(virtualMachinePercentage);
      $("#virtualMachinePercentageGauge").attr('data-value',virtualMachinePercentage);
      formatProgressGauge();
    });

    //Cluster Member Info
    $.get("./backend/lxd/remotes-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayClusterInfo", function (data) {
      stats = JSON.parse(data);
      $("#onlineClusterMembers").text(stats.onlineClusterMembers);
      $("#totalClusterMembers").text(stats.totalClusterMembers);
      clusterPercentage = stats.onlineClusterMembers / stats.totalClusterMembers * 100
      if (isNaN(clusterPercentage)){
        clusterPercentage = 0;
      }
      else {
        clusterPercentage = clusterPercentage.toFixed(0);
      }
      $("#clusterPercentage").text(clusterPercentage);
      $("#clusterPercentageGauge").attr('data-value',clusterPercentage);
      formatProgressGauge();
    });

    //Image Info
    $.get("./backend/lxd/remotes-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayImageInfo", function (data) {
      stats = JSON.parse(data);
      $("#totalImages").text(stats.totalImages);
    });

    //Network Info
    $.get("./backend/lxd/remotes-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayNetworkInfo", function (data) {
      stats = JSON.parse(data);
      $("#totalNetworks").text(stats.totalNetworks);
    });

    //Network ACL Info
    $.get("./backend/lxd/remotes-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayNetworkAclInfo", function (data) {
      stats = JSON.parse(data);
      $("#totalNetworkAcls").text(stats.totalNetworkAcls);
    });

    //Profile Info
    $.get("./backend/lxd/remotes-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayProfileInfo", function (data) {
      stats = JSON.parse(data);
      $("#totalProfiles").text(stats.totalProfiles);
    });

    //Project Info
    $.get("./backend/lxd/remotes-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayProjectInfo", function (data) {
      stats = JSON.parse(data);
      $("#totalProjects").text(stats.totalProjects);
    });

    //Storage Pool Info
    $.get("./backend/lxd/remotes-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayStorageInfo", function (data) {
      stats = JSON.parse(data);
      $("#totalStoragePools").text(stats.totalStoragePools);
    });

    //Set reload page content
    pageReloadTimeout = setTimeout(() => { reloadPageContent(); }, reloadTime);
  }

  function loadPageContent(){

    //Display current logged in username
    $("#username").load("./backend/admin/settings.php?action=displayUsername");

    //Resource Info
    $.get("./backend/lxd/remotes-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displaySysInfo", function (data) {
      stats = JSON.parse(data);

      $("#systemVendor").text(stats.systemVendor);
      $("#systemProduct").text(stats.systemProduct);
      $("#architecture").text(stats.architecture);
      $("#cpus").text(stats.cpus);
      $("#memoryTotal").text(stats.memoryTotal);
      $("#memoryUnit").text(stats.memoryUnit);

      $("#memoryPercentage").text(stats.memoryPercentage);
      $("#memoryPercentageGauge").attr('data-value',stats.memoryPercentage);
      formatProgressGauge();

      sockets = stats.sockets;
      sockets.forEach(element => {
        $("#socketList").append('<li>Socket '+element.socket+': '+element.name+'</li>');
      });

      disks = stats.storageDisks;
      disks.forEach(element => {
        if (element.type == "cdrom"){
          return;
        }
          tableRow = '<tr>';
          tableRow += '<td>'+element.id+'</td>';
          tableRow += '<td>'+element.model+'</td>';
          tableRow += '<td>'+element.type+'</td>';
          if (element.size < 1099511627776){
            diskTotal = Math.round(element.size/1024/1024/1024 * 100) / 100;
            diskUnit = "GiB";
          }
          else {
            diskTotal = Math.round(element.size/1024/1024/1024/1024 * 100) / 100;
            diskUnit = "TiB";
          }
          tableRow += '<td>'+diskTotal + ' ' +diskUnit +'</td>';
          tableRow += '</tr>';
          $('#diskList').append(tableRow);

        
      });

    });

    //LXD Info
    $.get("./backend/lxd/remotes-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayLxdInfo", function (data) {
      stats = JSON.parse(data);

      $("#driver").text(stats.driver);
      $("#driverVersion").text(stats.driverVersion);
      $("#firewall").text(stats.firewall);
      $("#kernel").text(stats.kernel);
      $("#kernelArchitecture").text(stats.kernelArchitecture);
      $("#kernelVersion").text(stats.kernelVersion);
      $("#osName").text(stats.osName);
      $("#osVersion").text(stats.osVersion)

      $("#serverVersion").text(stats.serverVersion);
    
      $("#serverName").text(stats.serverName);
      $("#storage").text(stats.storage);
      $("#storageVersion").text(stats.storageVersion);

      addresses = stats.addresses;
      addresses.forEach(element => {
        $("#addressList").append('<li>'+element+'</li>');
      });

    });

    //Container Info
    $.get("./backend/lxd/remotes-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayContainerInfo", function (data) {
      stats = JSON.parse(data);
      $("#runningContainers").text(stats.runningContainers);
      $("#totalContainers").text(stats.totalContainers);
      containerPercentage = stats.runningContainers / stats.totalContainers * 100
      if (isNaN(containerPercentage)){
        containerPercentage = 0;
      }
      else {
        containerPercentage = containerPercentage.toFixed(0);
      }
      $("#containerPercentage").text(containerPercentage);
      $("#containerPercentageGauge").attr('data-value',containerPercentage);
      formatProgressGauge();
    });

    //Virtual Machine Info
    $.get("./backend/lxd/remotes-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayVirtualMachineInfo", function (data) {
      stats = JSON.parse(data);
      $("#runningVirtualMachines").text(stats.runningVirtualMachines);
      $("#totalVirtualMachines").text(stats.totalVirtualMachines);
      virtualMachinePercentage = stats.runningVirtualMachines / stats.totalVirtualMachines * 100
      if (isNaN(virtualMachinePercentage)){
        virtualMachinePercentage = 0;
      }
      else {
        virtualMachinePercentage = virtualMachinePercentage.toFixed(0);
      }
      $("#virtualMachinePercentage").text(virtualMachinePercentage);
      $("#virtualMachinePercentageGauge").attr('data-value',virtualMachinePercentage);
      formatProgressGauge();
      
    });

    //Cluster Member Info
    $.get("./backend/lxd/remotes-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayClusterInfo", function (data) {
      stats = JSON.parse(data);
      $("#onlineClusterMembers").text(stats.onlineClusterMembers);
      $("#totalClusterMembers").text(stats.totalClusterMembers);
      clusterPercentage = stats.onlineClusterMembers / stats.totalClusterMembers * 100
      if (isNaN(clusterPercentage)){
        clusterPercentage = 0;
      }
      else {
        clusterPercentage = clusterPercentage.toFixed(0);
      }
      $("#clusterPercentage").text(clusterPercentage);
      $("#clusterPercentageGauge").attr('data-value',clusterPercentage);
      formatProgressGauge();
    });

    //Image Info
    $.get("./backend/lxd/remotes-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayImageInfo", function (data) {
      stats = JSON.parse(data);
      $("#totalImages").text(stats.totalImages);
    });

    //Network Info
    $.get("./backend/lxd/remotes-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayNetworkInfo", function (data) {
      stats = JSON.parse(data);
      $("#totalNetworks").text(stats.totalNetworks);
    });

    //Network ACL Info
    $.get("./backend/lxd/remotes-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayNetworkAclInfo", function (data) {
      stats = JSON.parse(data);
      $("#totalNetworkAcls").text(stats.totalNetworkAcls);
    });

    //Profile Info
    $.get("./backend/lxd/remotes-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayProfileInfo", function (data) {
      stats = JSON.parse(data);
      $("#totalProfiles").text(stats.totalProfiles);
    });

    //Project Info
    $.get("./backend/lxd/remotes-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayProjectInfo", function (data) {
      stats = JSON.parse(data);
      $("#totalProjects").text(stats.totalProjects);
    });

    //Storage Pool Info
    $.get("./backend/lxd/remotes-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayStorageInfo", function (data) {
      stats = JSON.parse(data);
      $("#totalStoragePools").text(stats.totalStoragePools);
    });

    //Check for any running operations
    operationTimeout = setTimeout(() => { operationStatusCheck(); }, 1000);

    //Set reload page content
    $.get("./backend/admin/settings.php?action=retrievePageRefreshRateValues", function (data) {
      operationData = JSON.parse(data);
      if (operationData.remotes_single_page_rate >= 1)
        reloadTime = operationData.remotes_single_page_rate * 1000;
      pageReloadTimeout = setTimeout(() => { reloadPageContent(); }, reloadTime);
    });

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

  function formatProgressGauge() {
    //Set the cirular progress bar
    $(function() {
      $(".progress-circle-xs").each(function() {
        var value = $(this).attr('data-value');
        var left = $(this).find('.progress-circle-left-xs .progress-circle-bar-xs');
        var right = $(this).find('.progress-circle-right-xs .progress-circle-bar-xs');

        if (value >= 0 && value <= 100) {
          if (value <= 50) {
            right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
            left.css('transform', 'rotate(' + percentageToDegrees(0) + 'deg)')
          } else {
            right.css('transform', 'rotate(180deg)')
            left.css('transform', 'rotate(' + percentageToDegrees(value - 50) + 'deg)')
          }
        }
      })
      function percentageToDegrees(percentage) {
        return percentage / 100 * 360
      }
    });
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
    
    //Load in the sidebar
    $("#sidebarLinks").load("./sidebar.php?version=3.0");

    //Setup Page Breadcrumb Links/Information
    $('#remoteBreadCrumb').load("./backend/lxd/remote-breadcrumb.php?remote=" + encodeURI(remoteId));

    //Validate remote host connection returns 200 status
    $.get("./backend/lxd/remotes-single.php?remote=" + encodeURI(remoteId) + "&action=validateRemoteConnection", function (data) {
      operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.status_code == 200) {
        //Set top navbar dropdowns
        $("#remoteListNav").load("./backend/lxd/remotes.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listRemotesForSelectOption");
        $("#projectListNav").load("./backend/lxd/projects.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listProjectsForSelectOption");

        //Load Page Content
        loadPageContent();
      }
      else {
        alert("Unable to connect to remote host. HTTP status code: " + operationData.status_code);
      }
    });

    //Set hyperlink references for cards
    $("#containersLink").attr("href", "containers.php?remote="+remoteId+"&project="+projectName)
    $("#virtualMachinesLink").attr("href", "virtual-machines.php?remote="+remoteId+"&project="+projectName)
    $("#clusterMembersLink").attr("href", "cluster-members.php?remote="+remoteId+"&project="+projectName)
    $("#imagesLink").attr("href", "images.php?remote="+remoteId+"&project="+projectName)
    $("#profilesLink").attr("href", "profiles.php?remote="+remoteId+"&project="+projectName)
    $("#networksLink").attr("href", "networks.php?remote="+remoteId+"&project="+projectName)
    $("#storagePoolsLink").attr("href", "storage-pools.php?remote="+remoteId+"&project="+projectName)
    $("#projectsLink").attr("href", "projects.php?remote="+remoteId+"&project="+projectName)
    $("#networkAclsLink").attr("href", "network-acls.php?remote="+remoteId+"&project="+projectName)
   
    //Load the about info for the about modal
    $.get("./backend/config/about.php", function (data) {
      $("#about").html(data);
    });

  });

</script>

</html>