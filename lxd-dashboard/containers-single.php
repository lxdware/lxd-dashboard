<!--
LXDWARE LXD Dashboard - A web-based interface for managing LXD servers
Copyright (C) 2020-PRESENT  LXDWARE.COM

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

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link rel="stylesheet" href="vendor/xterm/css/xterm.css"/>

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
                      <a href="#" id="remoteBreadCrumb"></a>
                       / 
                      <a href="#" id="containersBreadCrumb"></a>
                    </div>
                    <h2 class="page-header-title mt-2">
                      <span id="name"></span>
                    </h2>
                    <div class="page-header-subtitle" style="min-height: 21.5px;">
                      <span id="description"></span>
                    </div>
                  </div>
                  <div class="col-12 col-xl-auto mt-4">
                    <div class="input-group input-group-joined border-0 dropdown no-arrow" style="width: 12rem">
                      <span class="input-group-text bg-transparent border-0">
                        <a class="mr-2 h5" href="#" role="button" id="startLink" onclick="startInstance()" style="display: none;" Title="Start">
                          <i class="fas fa-play fa-lg fa-fw"></i></a>
                        <a class="mr-2 h5" href="#" role="button" id="stopLink" onclick="stopInstance()" style="display: none;" title="Stop">
                          <i class="fas fa-stop fa-lg fa-fw"></i></a>
                        <a class="mr-2 h5" href="#" role="button" id="unfreezeLink" onclick="unfreezeInstance()" style="display: none;" title="UnFreeze">
                          <i class="fas fa-pause fa-lg fa-fw"></i></a>
                        <a class="dropdown-toggle mr-2 h5" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Actions">
                          <i class="fas fa-bars fa-lg fa-fw"></i></a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                          <!--<div class="dropdown-header">Options:</div>-->
                          <a class="dropdown-item text-primary" href="#" onclick="editInstance()" id="editInstanceOption"><i class="fas fa-edit fa-sm fa-fw mr-2"></i>Edit</a>
                          <a class="dropdown-item text-primary" href="#" onclick="restartInstance()" id="restartInstanceOption"><i class="fas fa-redo fa-sm fa-fw mr-2"></i>Restart</a>
                          <a class="dropdown-item text-primary" href="#" onclick="stopInstanceForcefully()" id="stopInstanceForcefullyOption"><i class="fas fa-plug fa-sm fa-fw mr-2"></i>Force Stop</a>
                          <a class="dropdown-item text-primary" href="#" onclick="freezeInstance()" id="freezeInstanceOption"><i class="fas fa-pause fa-sm fa-fw mr-2"></i>Freeze</a>
                          <a class="dropdown-item text-primary" href="#" data-toggle="modal" data-target="#snapshotInstanceModal" id="snapshotInstanceOption"><i class="fas fa-clone fa-sm fa-fw mr-2"></i>Snapshot</a>
                          <a class="dropdown-item text-primary" href="#" data-toggle="modal" data-target="#attachInstanceProfileModal" id="attachInstanceProfileOption"><i class="fas fa-address-card fa-sm fa-fw mr-2"></i>Attach Profile</a>
                          <a class="dropdown-item text-primary" href="#" data-toggle="modal" data-target="#renameInstanceModal" id="renameInstanceOption"><i class="fas fa-edit fa-sm fa-fw mr-2"></i>Rename</a>
                          <a class="dropdown-item text-primary" href="#" data-toggle="modal" data-target="#copyInstanceModal" id="copyInstanceOption"><i class="fas fa-copy fa-sm fa-fw mr-2"></i>Copy</a>
                          <a class="dropdown-item text-primary" href="#" data-toggle="modal" data-target="#migrateInstanceModal" id="migrateInstanceOption"><i class="fas fa-suitcase fa-sm fa-fw mr-2"></i>Migrate</a>
                          <a class="dropdown-item text-primary" href="#" onclick="initializeCreateBackup()" id="backupInstanceOption"><i class="fas fa-save fa-sm fa-fw mr-2"></i>Backup</a>
                          <a class="dropdown-item text-primary" href="#" data-toggle="modal" data-target="#publishInstanceModal" id="publishInstanceOption"><i class="fas fa-box-open fa-sm fa-fw mr-2"></i>Publish</a>
                          <a class="dropdown-item text-primary" href="#" data-toggle="modal" data-target="#deleteInstanceModal" id="deleteInstanceOption"><i class="fas fa-trash-alt fa-sm fa-fw mr-2"></i>Delete</a>
                        </div>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </header>

          <div class="row mt-n5 ml-2 mr-2">

            <div class="col-12 mt-n3">
              <!-- Container List -->
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary"> 
                    <ul class="nav nav-pills card-header-pills" id="cardPill" role="tablist">              
                      <li class="nav-item"><a class="nav-link active" id="nav-overview-tab" href="#nav-overview" data-toggle="pill" role="tab" aria-controls="nav-overview" aria-selected="true">Overview</a></li>
                      <li class="nav-item"><a class="nav-link" id="nav-config-tab" href="#nav-config" data-toggle="pill" role="tab" aria-controls="nav-config" aria-selected="false">Config</a></li>
                      <li class="nav-item"><a class="nav-link" id="nav-snapshots-tab" href="#nav-snapshots" data-toggle="pill" role="tab" aria-controls="nav-snapshots" aria-selected="false">Snapshots</a></li>
                      <li class="nav-item"><a class="nav-link" id="nav-profiles-tab" href="#nav-profiles" data-toggle="pill" role="tab" aria-controls="nav-profiles" aria-selected="false">Profiles</a></li>
                      <li class="nav-item"><a class="nav-link" id="nav-interfaces-tab" href="#nav-interfaces" data-toggle="pill" role="tab" aria-controls="nav-interfaces" aria-selected="false">Interfaces</a></li>

                      <li class="nav-item dropdown" style="line-height: normal;">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Devices</a>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" id="nav-network-devices-tab" href="#nav-network-devices" data-toggle="pill" role="tab" aria-controls="nav-network-devices" aria-selected="false">Network</a>
                          <a class="dropdown-item" id="nav-disk-devices-tab" href="#nav-disk-devices" data-toggle="pill" role="tab" aria-controls="nav-disk-devices" aria-selected="false">Disk</a>
                          <a class="dropdown-item" id="nav-gpu-devices-tab" href="#nav-gpu-devices" data-toggle="pill" role="tab" aria-controls="nav-gpu-devices" aria-selected="false">GPU</a>
                          <a class="dropdown-item" id="nav-proxy-devices-tab" href="#nav-proxy-devices" data-toggle="pill" role="tab" aria-controls="nav-proxy-devices" aria-selected="false">Proxy</a>
                          <a class="dropdown-item" id="nav-unix-devices-tab" href="#nav-unix-devices" data-toggle="pill" role="tab" aria-controls="nav-unix-devices" aria-selected="false">Unix</a>
                          <a class="dropdown-item" id="nav-usb-devices-tab" href="#nav-usb-devices" data-toggle="pill" role="tab" aria-controls="nav-usb-devices" aria-selected="false">USB</a>
                        </div>
                      </li>

                      <li class="nav-item"><a class="nav-link" id="nav-backups-tab" href="#nav-backups" data-toggle="pill" role="tab" aria-controls="nav-backups" aria-selected="false">Backups</a></li>
                      <li class="nav-item"><a class="nav-link" id="nav-logs-tab" href="#nav-logs" data-toggle="pill" role="tab" aria-controls="nav-logs" aria-selected="false">Logs</a></li>
                      <li class="nav-item"><a class="nav-link" id="nav-console-tab" href="#nav-console" data-toggle="pill" role="tab" aria-controls="nav-console" aria-selected="false">Console</a></li>
                      <li class="nav-item"><a class="nav-link" id="nav-exec-tab" href="#nav-exec" data-toggle="pill" role="tab" aria-controls="nav-exec" aria-selected="false">Exec</a></li>
                    </ul>
                  </h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle mr-2" href="#" onclick="reloadPageContent()" title="Refresh" aria-hidden="true">
                      <i class="fa fa-sync fa-1x fa-fw"></i></a>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="col-12">
                    
                    <div class="tab-content" id="nav-tabContent">

                      <div class="tab-pane fade show active" id="nav-overview" role="tabpanel" aria-labelledby="nav-overview-tab">
                        <!-- Overview Tab -->
                        <div class="text-right mb-3 mt-n1">
                          <button type="button" class="btn btn-outline-primary"  id="editInstanceButton" onclick="editInstance()" title="Edit Instance"><i class="fas fa-edit fa-1x fa-fw"></i> Edit</button>
                        </div>
                        <div class="row">
                          <div class="col-xl-6 col-lg-12">
                            <!-- General Card -->
                            <div class="card col-12 border-0 mb-2">
                              <!-- Card Header - Dropdown -->
                              <div class="card-header border-0 bg-transparent py-2 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary">General</h5>
                              </div>
                              <!-- Card Body -->
                              <div class="card-body pt-1">
                                <div class="row">
                                  <div class="col-12">
                                    <table class="table table-sm">
                                      <tr><td class="pr-3 font-weight-bold">Type:</td> <td><span id="type"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Status:</td> <td><span id="status"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Image:</td> <td><span id="image"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Location:</td> <td><span id="location"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Created:</td> <td><span id="created"></span></td></tr>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- End General Card -->

                            <!-- State Card -->
                            <div class="card col-12 border-0 mb-2">
                              <!-- Card Header - Dropdown -->
                              <div class="card-header border-0 bg-transparent py-1 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary">State</h5>
                              </div>
                              <!-- Card Body -->
                              <div class="card-body pt-1">
                                <div class="row">
                                  <div class="col-12">
                                    <table class="table table-sm">
                                      <tr><td class="pr-3 font-weight-bold">Memory:</td> <td><span id="memory"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Swap:</td> <td><span id="swap"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">PID:</td> <td><span id="pid"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Processes:</td> <td><span id="processes"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">IPv4 Addresses:</td> <td><span id="ipv4Addresses"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">IPv6 Addresses:</td> <td><span id="ipv6Addresses"></span></td></tr>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- End State Card -->

                          </div>
                          <div class="col-xl-6 col-lg-12">

                            <div class="row">
                              <div class="card col-6 border-0">
                                 <!-- Card Header - Dropdown -->
                                <div class="card-header border-0 bg-transparent text-center mb-2 py-1">
                                  <h5 class="m-0 font-weight-bold text-primary">CPU Usage</h5>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body pt-1">
                                  <!-- CPU Progress Circle -->
                                  <div class="progress-circle mx-auto" id="cpuPercentageGauge" data-value='0'>
                                    <span class="progress-circle-left">
                                      <span class="progress-circle-bar border-primary"></span>
                                    </span>
                                    <span class="progress-circle-right">
                                      <span class="progress-circle-bar border-primary"></span>
                                    </span>
                                    <div class="progress-circle-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                      <div class="h2 font-weight-bold" id="cpuPercentage">0.0</div><sup class="small">%</sup>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="card col-6 border-0">
                                <!-- Card Header - Dropdown -->
                               <div class="card-header border-0 bg-transparent text-center mb-2 py-1">
                                 <h5 class="m-0 font-weight-bold text-primary">Memory Usage</h5>
                               </div>
                               <!-- Card Body -->
                               <div class="card-body pt-1">
                                 <!-- Memory Progress Circle -->
                                 <div class="progress-circle mx-auto" id="memoryPercentageGauge" data-value='0'>
                                   <span class="progress-circle-left">
                                     <span class="progress-circle-bar border-primary"></span>
                                   </span>
                                   <span class="progress-circle-right">
                                     <span class="progress-circle-bar border-primary"></span>
                                   </span>
                                   <div class="progress-circle-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                     <div class="h2 font-weight-bold" id="memoryPercentage">0.0</div><sup class="small">%</sup>
                                   </div>
                                 </div>
                               </div>
                             </div>

                            </div>
                           

                          
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="nav-config" role="tabpanel" aria-labelledby="nav-config-tab">
                        <!-- Config List -->
                        <div class="text-right mb-3 mt-n1">
                          <button type="button" class="btn btn-outline-primary"  id="editInstanceButton" onclick="editInstance()" title="Edit Instance"><i class="fas fa-edit fa-1x fa-fw"></i> Edit</button>
                        </div>
                        <div class="row">
                          <div class="col-md-12 col-lg-6 col-xl-4">
                            <!-- Boot Configuration Card -->
                            <div class="card col-12 border-0 mb-2">
                              <!-- Card Header - Dropdown -->
                              <div class="card-header border-0 bg-transparent py-1 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary">Boot Configuration</h5>
                              </div>
                              <!-- Card Body -->
                              <div class="card-body pt-1">
                                <div class="row">
                                  <div class="col-12">
                                    <table class="table table-sm">
                                      <tr><td class="pr-3 font-weight-bold">Autostart:</td> <td><span id="bootAutostart"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Autostart Delay:</td> <td><span id="bootAutostartDelay"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Autostart Priority:</td> <td><span id="bootAutostartPriority"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Host Shutdown Timeout:</td> <td><span id="bootHostShutdownTimeout"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Stop Priority:</td> <td><span id="bootStopPriority"></span></td></tr>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- End Boot Configuration Card -->

                            <!-- Limits Configuration Card -->
                            <div class="card col-12 border-0 mb-2">
                              <!-- Card Header - Dropdown -->
                              <div class="card-header border-0 bg-transparent py-1 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary">Limits</h5>
                              </div>
                              <!-- Card Body -->
                              <div class="card-body pt-1">
                                <div class="row">
                                  <div class="col-12">
                                    <table class="table table-sm">
                                      <tr><td class="pr-3 font-weight-bold">CPU:</td> <td><span id="limitsCpu"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">CPU Allowance:</td> <td><span id="limitsCpuAllowance"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">CPU Priority:</td> <td><span id="limitsCpuPriority"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Disk Priority:</td> <td><span id="limitsDiskPriority"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Memory:</td> <td><span id="limitsMemory"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Memory Enforce:</td> <td><span id="limitsMemoryEnforce"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Memory Swap:</td> <td><span id="limitsMemorySwap"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Memory Swap Priority:</td> <td><span id="limitsMemorySwapPriority"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Network Priority:</td> <td><span id="limitsNetworkPriority"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Processes:</td> <td><span id="limitsProcesses"></span></td></tr>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- End Limits Configuration Card -->

                            <!-- Limits Hugepages Card -->
                            <div class="card col-12 border-0 mb-2">
                              <!-- Card Header - Dropdown -->
                              <div class="card-header border-0 bg-transparent py-1 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary">Limits - Hugepages</h5>
                              </div>
                              <!-- Card Body -->
                              <div class="card-body pt-1">
                                <div class="row">
                                  <div class="col-12">
                                    <table class="table table-sm">
                                      <tr><td class="pr-3 font-weight-bold">64KB:</td> <td><span id="limitsHugepages64KB"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">1MB:</td> <td><span id="limitsHugepages1MB"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">2MB:</td> <td><span id="limitsHugepages2MB"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">1GB:</td> <td><span id="limitsHugepages1GB"></span></td></tr>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- End Limits Hugepages Card -->
                          </div>
                          <div class="col-md-12 col-lg-6 col-xl-4">
                            <!-- Migration Configuration Card -->
                            <div class="card col-12 border-0 mb-2">
                              <!-- Card Header - Dropdown -->
                              <div class="card-header border-0 bg-transparent py-1 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary">Migration Configuration</h5>
                              </div>
                              <!-- Card Body -->
                              <div class="card-body pt-1">
                                <div class="row">
                                  <div class="col-12">
                                    <table class="table table-sm">
                                      <tr><td class="pr-3 font-weight-bold">Incremental Memory:</td> <td><span id="migrationIncrementalMemory"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Incr. Mem. Goal:</td> <td><span id="migrationIncrementalMemoryGoal"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Incr. Mem. Iterations:</td> <td><span id="migrationIncrementalMemoryIterations"></span></td></tr>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- End Migration Configuration Card -->

                            <!-- Other Configuration Card -->
                            <div class="card col-12 border-0 mb-2">
                              <!-- Card Header - Dropdown -->
                              <div class="card-header border-0 bg-transparent py-1 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary">Other Configuration</h5>
                              </div>
                              <!-- Card Body -->
                              <div class="card-body pt-1">
                                <div class="row">
                                  <div class="col-12">
                                    <table class="table table-sm">
                                      <tr><td class="pr-3 font-weight-bold">Cluster Evacuate:</td> <td><span id="clusterEvacuate"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Kernel Modules:</td> <td><span id="linuxKernelModules"></span></td></tr>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- End Other Configuration Card -->

                            <!-- NVIDIA Configuration Card -->
                            <div class="card col-12 border-0 mb-2">
                              <!-- Card Header - Dropdown -->
                              <div class="card-header border-0 bg-transparent py-1 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary">NVIDIA Configuration</h5>
                              </div>
                              <!-- Card Body -->
                              <div class="card-body pt-1">
                                <div class="row">
                                  <div class="col-12">
                                    <table class="table table-sm">
                                      <tr><td class="pr-3 font-weight-bold">Driver Capabilities:</td> <td><span id="nvidiaDriverCapabilities"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Runtime:</td> <td><span id="nvidiaRuntime"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Require Cuda:</td> <td><span id="nvidiaRequireCuda"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Require Driver:</td> <td><span id="nvidiaRequireDriver"></span></td></tr>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- End NVIDIA Configuration Card -->

                            <!-- Raw Configuration Card -->
                            <div class="card col-12 border-0 mb-2">
                              <!-- Card Header - Dropdown -->
                              <div class="card-header border-0 bg-transparent py-1 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary">Raw Configuration</h5>
                              </div>
                              <!-- Card Body -->
                              <div class="card-body pt-1">
                                <div class="row">
                                  <div class="col-12">
                                    <table class="table table-sm">
                                      <tr><td class="pr-3 font-weight-bold">Apparmor:</td> <td><span id="rawApparmor"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Idmap:</td> <td><span id="rawIdmap"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Lxc:</td> <td><span id="rawLxc"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Seccomp:</td> <td><span id="rawSeccomp"></span></td></tr>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- End Raw Configuration Card -->

                            <!-- Snapshot Configuration Card -->
                            <div class="card col-12 border-0 mb-2">
                              <!-- Card Header - Dropdown -->
                              <div class="card-header border-0 bg-transparent py-1 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary">Snapshot Configuration</h5>
                              </div>
                              <!-- Card Body -->
                              <div class="card-body pt-1">
                                <div class="row">
                                  <div class="col-12">
                                    <table class="table table-sm">
                                      <tr><td class="pr-3 font-weight-bold">Schedule:</td> <td><span id="snapshotsSchedule"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Schedule Stopped:</td> <td><span id="snapshotsScheduleStopped"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Pattern:</td> <td><span id="snapshotsPattern"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Expiry:</td> <td><span id="snapshotsExpiry"></span></td></tr>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- End Snapshot Configuration -->
                          </div>
                          <div class="col-md-12 col-lg-6 col-xl-4">
                            <!-- Security Configuration Card -->
                            <div class="card col-12 border-0 mb-2">
                              <!-- Card Header - Dropdown -->
                              <div class="card-header border-0 bg-transparent py-1 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary">Security Configuration</h5>
                              </div>
                              <!-- Card Body -->
                              <div class="card-body pt-1">
                                <div class="row">
                                  <div class="col-12">
                                    <table class="table table-sm">
                                      <tr><td class="pr-3 font-weight-bold">Devlxd:</td> <td><span id="securityDevLxd"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Devlxd Images:</td> <td><span id="securityDevLxdImages"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Idmap Base:</td> <td><span id="securityIdmapBase"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Idmap Isolated:</td> <td><span id="securityIdmapIsolated"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Idmap Size:</td> <td><span id="securityIdmapSize"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Nesting:</td> <td><span id="securityNesting"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Privileged:</td> <td><span id="securityPrivileged"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Protection Delete:</td> <td><span id="securityProtectionDelete"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Protection Shift:</td> <td><span id="securityProtectionShift"></span></td></tr>
                                    </table>
                                  </div>
                                </div>
                              </div>
                              </div>
                              <!-- End Security Configuration Card -->

                              <!-- Security Syscalls Card -->
                              <div class="card col-12 border-0 mb-2">
                              <!-- Card Header - Dropdown -->
                              <div class="card-header border-0 bg-transparent py-1 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary">Security - Syscalls</h5>
                              </div>
                              <!-- Card Body -->
                              <div class="card-body pt-1">
                                <div class="row">
                                  <div class="col-12">
                                    <table class="table table-sm">
                                      <tr><td class="pr-3 font-weight-bold">Allow:</td> <td><span id="securitySyscallsAllow"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Deny:</td> <td><span id="securitySyscallsDeny"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Deny Compat:</td> <td><span id="securitySyscallsDenyCompat"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Deny Default:</td> <td><span id="securitySyscallsDenyDefault"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Intercept Bpf:</td> <td><span id="securitySyscallsInterceptBpf"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Intercept Bpf Devices:</td> <td><span id="securitySyscallsInterceptBpfDevices"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Intercept Mknod:</td> <td><span id="securitySyscallsInterceptMknod"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Intercept Mount:</td> <td><span id="securitySyscallsInterceptMount"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Intercept Mount Allowed:</td> <td><span id="securitySyscallsInterceptMountAllowed"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Intercept Mount Fuse:</td> <td><span id="securitySyscallsInterceptMountFuse"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Intercept Mount Shift:</td> <td><span id="securitySyscallsInterceptMountShift"></span></td></tr>
                                      <tr><td class="pr-3 font-weight-bold">Intercept Setxattr:</td> <td><span id="securitySyscallsInterceptSetxattr"></span></td></tr>
                                    </table>
                                  </div>
                                </div>
                              </div>
                              </div>
                              <!-- End Security Syscalls Card -->
                          </div>
                        </div>
                        <!-- End Config List -->
                      </div>
                      <div class="tab-pane fade" id="nav-snapshots" role="tabpanel" aria-labelledby="nav-snapshots-tab">
                        <!-- Snapshot List -->
                        <div class="text-right mb-3 mt-n1">
                          <button type="button" class="btn btn-outline-primary"  id="" data-toggle="modal" data-target="#snapshotInstanceModal" title="Create Snapshot" onclick=""><i class="fas fa-plus fa-sm fa-fw"></i>Snapshot</button>
                        </div>
                        <div class="table-responsive">
                          <table class="table" id="snapshotTableList" width="100%" cellspacing="0">
                          </table>
                        </div>
                        <!-- End Snapshot List -->
                      </div>
                      <div class="tab-pane fade" id="nav-profiles" role="tabpanel" aria-labelledby="nav-profiles-tab">
                        <!-- Profiles List -->
                        <div class="text-right mb-3 mt-n1">
                          <button type="button" class="btn btn-outline-primary"  id="" data-toggle="modal" data-target="#attachInstanceProfileModal" title="Attach Profile" onclick=""><i class="fas fa-plus fa-sm fa-fw"></i>Profile</button>
                        </div>
                        <div class="table-responsive">
                          <table class="table" id="profileTableList" width="100%" cellspacing="0">
                          </table>
                        </div>
                        <!-- End Profiles List -->
                      </div>
                      <div class="tab-pane fade" id="nav-interfaces" role="tabpanel" aria-labelledby="nav-interfaces-tab">
                        <!-- Interfaces List -->
                        <div class="text-right mb-3 mt-n1" style="min-height: 38px;">
                        </div>
                        <div class="table-responsive">
                          <table class="table" id="interfaceTableList" width="100%" cellspacing="0">
                          </table>
                        </div>
                        <!-- End Interfaces List -->
                      </div>
                      <div class="tab-pane fade" id="nav-network-devices" role="tabpanel" aria-labelledby="nav-network-devices-tab">
                        <!-- Network Devices List -->
                        <div class="text-right mb-3 mt-n1">
                          <button type="button" class="btn btn-outline-primary"  id="" title="Add Network Device" onclick="loadAddNetworkDeviceModal()"><i class="fas fa-plus fa-sm fa-fw"></i>Network Device</button>
                        </div>
                        <div class="table-responsive">
                          <table class="table" id="networkDeviceTableList" width="100%" cellspacing="0">
                          </table>
                        </div>
                        <!-- End Network Devices List -->
                      </div>
                      <div class="tab-pane fade" id="nav-disk-devices" role="tabpanel" aria-labelledby="nav-disk-devices-tab">
                        <!-- Disk Device List -->
                        <div class="text-right mb-3 mt-n1">
                          <button type="button" class="btn btn-outline-primary"  id="" title="Add Disk Device" onclick="loadAddDiskDeviceModal()"><i class="fas fa-plus fa-sm fa-fw"></i>Disk Device</button>
                        </div>
                        <div class="table-responsive">
                          <table class="table" id="diskDeviceTableList" width="100%" cellspacing="0">
                          </table>
                        </div>
                        <!-- End Disk Device List -->
                      </div>
                      <div class="tab-pane fade" id="nav-gpu-devices" role="tabpanel" aria-labelledby="nav-gpu-devices-tab">
                        <!-- GPU Device List -->
                        <div class="text-right mb-3 mt-n1">
                          <button type="button" class="btn btn-outline-primary"  id="" data-toggle="modal" data-target="#addGPUDeviceModal" title="Add GPU Device" onclick=""><i class="fas fa-plus fa-sm fa-fw"></i>GPU Device</button>
                        </div>
                        <div class="table-responsive">
                          <table class="table" id="gpuDeviceTableList" width="100%" cellspacing="0">
                          </table>
                        </div>
                        <!-- End GPU Device List -->
                      </div>
                      <div class="tab-pane fade" id="nav-proxy-devices" role="tabpanel" aria-labelledby="nav-proxy-devices-tab">
                        <!-- Proxy Device List -->
                        <div class="text-right mb-3 mt-n1">
                          <button type="button" class="btn btn-outline-primary"  id="" data-toggle="modal" data-target="#addProxyDeviceModal" title="Add Proxy Device" onclick=""><i class="fas fa-plus fa-sm fa-fw"></i>Proxy Device</button>
                        </div>
                        <div class="table-responsive">
                          <table class="table" id="proxyDeviceTableList" width="100%" cellspacing="0">
                          </table>
                        </div>
                        <!-- End Proxy Device List -->
                      </div>
                      <div class="tab-pane fade" id="nav-unix-devices" role="tabpanel" aria-labelledby="nav-unix-devices-tab">
                        <!-- Unix Device List -->
                        <div class="text-right mb-3 mt-n1">
                          <button type="button" class="btn btn-outline-primary"  id="" data-toggle="modal" data-target="#addUnixDeviceModal" title="Add Unix Device" onclick=""><i class="fas fa-plus fa-sm fa-fw"></i>Unix Device</button>
                        </div>
                        <div class="table-responsive">
                          <table class="table" id="unixDeviceTableList" width="100%" cellspacing="0">
                          </table>
                        </div>
                        <!-- End Unix Device List -->
                      </div>
                      <div class="tab-pane fade" id="nav-usb-devices" role="tabpanel" aria-labelledby="nav-usb-devices-tab">
                        <!-- USB Device List -->
                        <div class="text-right mb-3 mt-n1">
                          <button type="button" class="btn btn-outline-primary"  id="" data-toggle="modal" data-target="#addUSBDeviceModal" title="Add USB Device" onclick=""><i class="fas fa-plus fa-sm fa-fw"></i>USB Device</button>
                        </div>
                        <div class="table-responsive">
                          <table class="table" id="usbDeviceTableList" width="100%" cellspacing="0">
                          </table>
                        </div>
                        <!-- End USB Device List -->
                      </div>
                      <div class="tab-pane fade" id="nav-backups" role="tabpanel" aria-labelledby="nav-backups-tab">
                        <!-- Backups List -->     
                        <div class="text-right mb-3 mt-n1">
                          <button type="button" class="btn btn-outline-primary"  id="" title="Create Backup" onclick="initializeCreateBackup()"><i class="fas fa-plus fa-sm fa-fw"></i>Backup</button>
                        </div>
                        <div class="table-responsive">
                          <table class="table" id="backupTableList" width="100%" cellspacing="0">
                          </table>
                        </div>
                        <!-- End Backups List -->
                      </div>
                      <div class="tab-pane fade" id="nav-logs" role="tabpanel" aria-labelledby="nav-logs-tab">
                        <!-- Logs List -->
                        <div class="text-right mb-3 mt-n1" style="min-height: 38px;">
                        </div>
                        <div class="table-responsive">
                          <table class="table" id="logTableList" width="100%" cellspacing="0">
                          </table>
                        </div>
                        <!-- End Logs List -->
                      </div>
                      <div class="tab-pane fade" id="nav-console" role="tabpanel" aria-labelledby="nav-console-tab">
                        <br>
                        <!-- Console Tab -->
                        <div class="text-right mb-3 mt-n1">
                          <button type="button" class="btn btn-outline-primary" id="startConsoleButton" title="Start Serial Console" onclick="establishInstanceWebSocketConsoleConnection()">Start Console</button>
                          <button type="button" class="btn btn-outline-primary"  style="display: none;" id="stopConsoleButton" title="Stop Serial Console" onclick="closeWebSocketConsoleConnection()">Stop Console</button>
                        </div>
                        <div id="terminal-console"></div>
                        <!-- End Console Tab -->
                      </div>
                      <div class="tab-pane fade" id="nav-exec" role="tabpanel" aria-labelledby="nav-exec-tab">
                        <br>
                        <!-- Exec Tab -->
                        <div class="text-right mb-3 mt-n1">
                          <button type="button" class="btn btn-outline-primary" id="startExecButton" title="Start Exec Terminal" onclick="establishInstanceWebSocketExecConnection()">Start Exec</button>
                          <button type="button" class="btn btn-outline-primary"  style="display: none;" id="stopExecButton" title="Stop Exec Terminal" onclick="closeWebSocketExecConnection()">Stop Exec</button>
                          <select id="execShellInput" class="btn" name="execShellInput">
                            <option value="bash" selected>/bin/bash</option>
                            <option value="sh">/bin/sh</option>
                          </select>
                        </div>
                        <div id="terminal-exec"></div>
                        <!-- End Exec Tab -->
                      </div>

                    </div>

                  </div>
                </div>
              </div>
              <!-- End Container List -->
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

  <!-- New Snapshot Modal-->
  <div class="modal fade" id="snapshotInstanceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Snapshot</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <label class="col-3 col-form-label text-right">Name: </label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="snapshotName" class="form-control" placeholder="" name="snapshot">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Enter a unique name to identify this snapshot. If a name is not provided it will be autogenerated.'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">Stateful:</label>
              <div class="col-7 text-right">
                <div class="form-group">
                  <select id="snapshotStateful" class="form-control" name="snapshotStateful">
                    <option value="false" selected>false</option>
                    <option value="true">true</option>
                  </select>
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Select whether or not to create a stateful snapshot. Default: false'></i>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="#" onclick="snapshotInstance()" data-dismiss="modal">Submit</a>
          </div>
      </div>
    </div>
  </div>

  <!-- Rename Instance Modal-->
  <div class="modal fade" id="renameInstanceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Rename Instance</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <label class="col-3 col-form-label text-right">Name: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="newInstanceName" class="form-control" placeholder="">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='(Required) - Enter in a new name for this instance.'></i>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="#" onclick="renameInstance()" data-dismiss="modal">Submit</a>
          </div>
      </div>
    </div>
  </div>

  <!-- Migrate Instance Modal-->
  <div class="modal fade" id="migrateInstanceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Migrate Instance</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <label class="col-3 col-form-label text-right">Host: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <select id="selectClusterInput" class="form-control" name="cluster">
                  </select>
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Select the cluster member to migrate this instance to.'></i>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="#" onclick="migrateInstance()" data-dismiss="modal">Submit</a>
          </div>
      </div>
    </div>
  </div>

  <!-- Copy Instance Modal-->
  <div class="modal fade" id="copyInstanceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Copy Instance</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <label class="col-3 col-form-label text-right">Name: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="copyName" class="form-control" placeholder="" name="copy">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Enter in the name of the new copied instance.'></i>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="#" onclick="copyInstance()" data-dismiss="modal">Submit</a>
          </div>
      </div>
    </div>
  </div>

  <!-- Create Instance from Snapshot Modal-->
  <div class="modal fade" id="createInstanceFromSnapshotModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Instance from Snapshot</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <label class="col-3 col-form-label text-right">Name: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="instanceNameForSnapshotCreate" class="form-control" placeholder="" name="copysnap">
                  <input type="hidden" id="snapNameForSnapshotCreate">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Enter in a name for the new instance.'></i>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="#" onclick="createInstanceFromSnapshot()" data-dismiss="modal">Submit</a>
          </div>
      </div>
    </div>
  </div>

  <!-- Publish Image from Snapshot Modal-->
  <div class="modal fade" id="publishImageFromSnapshotModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Publish Image from Snapshot</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <label class="col-3 col-form-label text-right">Description: </label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="publishSnapshotDescriptionInput" class="form-control" placeholder="" name="description">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Enter in a description for the new image.'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">OS: </label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="publishSnapshotOsInput" class="form-control" placeholder="" name="os">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Enter in the operating system name for the new image.'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">Release: </label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="publishSnapshotReleaseInput" class="form-control" placeholder="" name="release">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Enter in the release version for the new image.'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">Public:</label>
              <div class="col-7">
                <div class="form-group">
                  <select id="publishSnapshotPublicInput" class="form-control" name="public">
                    <option value="false" selected>false</option>
                    <option value="true">true</option>
                  </select>
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Select whether or not this image is public. Default: false'></i>
              </div>
            </div>
            <input type="hidden" id="publishSnapshotHiddenName">
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="#" onclick="publishImageFromSnapshot()" data-dismiss="modal">Submit</a>
          </div>
      </div>
    </div>
  </div>

  <!-- Backup Instance Modal-->
  <div class="modal fade" id="backupInstanceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Backup Instance</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <label class="col-3 col-form-label text-right">Name: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="backupName" class="form-control" placeholder="" name="backupName">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='(Required) - Enter in the name of the backup. A file extension will be appended to this name.'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">Instance Only:</label>
              <div class="col-7 text-right">
                <div class="form-group">
                  <select id="backupInstanceOnly" class="form-control" name="backupInstanceOnly">
                    <option value="false" selected>false</option>
                    <option value="true">true</option>
                  </select>
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Select whether or not to backup just the instance itself. Default: false'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">Optimized Storage:</label>
              <div class="col-7 text-right">
                <div class="form-group">
                  <select id="backupOptimizedStorage" class="form-control" name="backupOptimizedStorage">
                    <option value="false" selected>false</option>
                    <option value="true">true</option>
                  </select>
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Select whether or not to optimize storage size. Default: false'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">Compression:</label>
              <div class="col-7">
                <div class="form-group">
                  <select id="backupCompressionAlgorithm" class="form-control" name="backupCompressionAlgorithm">
                    <option value="bzip2">bzip2</option>
                    <option value="gzip" selected>gzip</option>
                    <option value="lzma">lzma</option>
                    <option value="none">none</option>
                    <option value="xz">xz</option>
                    <option value="zstd">zstd</option>
                  </select>
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Select which compression algorithm to use. Default: gzip'></i>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="#" onclick="createBackup()" data-dismiss="modal">Submit</a>
          </div>
      </div>
    </div>
  </div>
  
  <!-- Delete Instance Modal-->
  <div class="modal fade" id="deleteInstanceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete Instance</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Are you sure you want to delete this instance?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="#" onclick="deleteInstance()" data-dismiss="modal">Yes</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Attach Profile Modal-->
  <div class="modal fade" id="attachInstanceProfileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Attach Profile</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <label class="col-3 col-form-label text-right">Profile:</label>
              <div class="col-7">
                <div class="form-group">
                  <select id="selectProfileInput" class="form-control" name="profile">
                  </select>
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Select an existing profile to attach to this instance.'></i>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="#" onclick="attachInstanceProfile()" data-dismiss="modal">Submit</a>
          </div>
      </div>
    </div>
  </div>

  <!-- Add Disk Device Modal-->
  <div class="modal fade" id="addDiskDeviceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Disk Device</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <label class="col-3 col-form-label text-right">Device Name: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="diskNameInput" class="form-control" placeholder="" name="diskNameInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='(Required) - Enter a unique name to identify this instance device.'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">Pool:</label>
              <div class="col-7">
                <div class="form-group">
                  <select id="diskPoolInput" onchange="changeStorageVolumeInput()" class="form-control" name="diskPoolInput">
                  </select>
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='For LXD managed storage volumes, select the storage pool where the source storage volume is located.'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">Source: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="diskSourceInput" class="form-control" placeholder="" name="diskSourceInput">
                  <select style="display:none;" id="diskSourceSelectInput" class="form-control" name="diskSourceSelectInput">
                  </select>
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='(Required) - Select the storage volume or enter the filepath of the storage device.'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">Path: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="diskPathInput" class="form-control" placeholder="" name="diskPathInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='(Required) - Enter a filepath for where this disk will be mounted within the instance. For example, /mnt/vol1'></i>
              </div>
            </div>

            <hr>

            <div id="accordionDiskProperties">
              <h2>
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#additionalDiskProperties" aria-expanded="false" aria-controls="additionalDiskProperties">
                  Additional Properties
                </button>
              </h2> 
              <div id="additionalDiskProperties" class="collapse" aria-labelledby="additionalDiskProperties">
                <div class="row">
                  <label class="col-3 col-form-label text-right">Limits.Read:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="diskLimitsReadInput" class="form-control" placeholder="" name="diskLimitsReadInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the I/O limit. Be sure to include the suffix. Default: (not set)'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Limits.Write:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="diskLimitsWriteInput" class="form-control" placeholder="" name="diskLimitsWriteInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the I/O limit. Be sure to inlude the suffix. Default: (not set)'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Limits.Max:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="diskLimitsMaxInput" class="form-control" placeholder="" name="diskLimitsMaxInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the I/O limit. Be sure to inlude the suffix. Default: (not set)'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Required:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="diskRequiredInput" onchange="" class="form-control" name="diskRequiredInput">
                        <option value="">(not set)</option>
                        <option value="true">true</option>
                        <option value="false">false</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title="Select whether to fail if the source disk doesn't exist. Default: true"></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Read Only:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="diskReadOnlyInput" onchange="" class="form-control" name="diskReadOnlyInput">
                        <option value="">(not set)</option>
                        <option value="true">true</option>
                        <option value="false">false</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title="Select whether to make the mount disk read-only or not. Default: false"></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Size:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="diskSizeInput" class="form-control" placeholder="" name="diskSizeInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the disk size in bytes. Be sure to include the suffix. This is only supported for the rootfs (/). Default: (not set)'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Size.State:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="diskSizeStateInput" class="form-control" placeholder="" name="diskSizeStateInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the size of the filesystem volume used for saving runtime state in virtual machines. Be sure to inlude the suffix. Default: (not set)'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Recursive:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="diskRecursiveInput" onchange="" class="form-control" name="diskRecursiveInput">
                        <option value="">(not set)</option>
                        <option value="true">true</option>
                        <option value="false">false</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title="Select whether or not to recursively mount the source path. Default: false"></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Propagation:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="diskPropagationInput" onchange="" class="form-control" name="diskPropagationInput">
                        <option value="">(not set)</option>
                        <option value="private">private</option>
                        <option value="rprivate">rprivate</option>
                        <option value="rshared">rshared</option>
                        <option value="rslave">rslave</option>
                        <option value="runbindable">runbindable</option>
                        <option value="shared">shared</option>
                        <option value="slave">slave</option>
                        <option value="unbindable">unbindable</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Select how a bind-mount is shared between the instance and the host. Default: private'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Shift:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="diskShiftInput" onchange="" class="form-control" name="diskShiftInput">
                        <option value="">(not set)</option>
                        <option value="true">true</option>
                        <option value="false">false</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title="Select wheter to setup a shifting overlay to translate the source uid/gid to match the instance. Default: false"></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Raw Mount Options:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="diskRawMountOptionsInput" class="form-control" placeholder="" name="diskRawMountOptionsInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in filesystem specific mount options. Default: (not set)'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Ceph User Name:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="diskCephUserNameInput" class="form-control" placeholder="" name="diskCephUserNameInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Used if the source is ceph or cephfs. Enter a ceph user_name. Default: admin'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Ceph Cluster Name:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="diskCephClusterNameInput" class="form-control" placeholder="" name="diskCephClusterNameInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Used if the source is ceph or cephfs. Enter a ceph cluster_name. Default: ceph'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Boot Priority:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="diskBootPriorityInput" class="form-control" placeholder="" name="diskBootPriorityInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in a boot priority number for VMs (highest numbers boot first). Default: (not set)'></i>
                  </div>
                </div>
              </div>

            </div>

          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="#" onclick="addInstanceDiskDevice()" data-dismiss="modal">Submit</a>
          </div>
      </div>
    </div>
  </div>

  <!-- Add GPU Device Modal-->
  <div class="modal fade" id="addGPUDeviceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add GPU Device</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <label class="col-3 col-form-label text-right">Device Name: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="gpuDeviceNameInput" class="form-control" placeholder="" name="gpuDeviceNameInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='(Required) - Enter a unique name to identify this instance device'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">GPU Type:</label>
              <div class="col-7">
                <div class="form-group">
                  <select id="gpuTypeInput" class="form-control" name="gpuTypeInput">
                    <option value="">(not set)</option>
                    <option value="physical">physical</option>
                    <option value="mig">mig</option>
                  </select>
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Select which GPU type to use. Default: physical'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">Vendor Id:</label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="gpuVendoridInput" class="form-control" placeholder="" name="gpuVendoridInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Enter in the vendor id of the GPU device'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">Product Id: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="gpuProductidInput" class="form-control" placeholder="" name="gpuProductidInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Enter in the product id of the GPU device'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">MIG CI: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <input type="number" id="gpuMigCiInput" class="form-control" placeholder="" name="gpuMigCiInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Enter in the existing MIG compute instance ID. Default: (not set)'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">MIG GI: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <input type="number" id="gpuMigGiInput" class="form-control" placeholder="" name="gpuMigGiInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Enter in the existing MIG GPU instance ID. Default: (not set)'></i>
              </div>
            </div>

            <hr>

            <div id="accordionProxyProperties">
              <h2>
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#additionalProxyProperties" aria-expanded="false" aria-controls="additionalProxyProperties">
                  Additional Properties
                </button>
              </h2> 
              <div id="additionalProxyProperties" class="collapse" aria-labelledby="additionalProxyProperties">

                <div class="row">
                  <label class="col-3 col-form-label text-right">ID:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="gpuIdInput" class="form-control" placeholder="" name="gpuIdInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the card ID of the GPU. Default: (not set)'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">PCI:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="gpuPciInput" class="form-control" placeholder="" name="gpuPciInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the PCI address of the GPU. Default: (not set)'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">UID:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="gpuUidInput" class="form-control" placeholder="" name="gpuUidInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the UID number of the device owner. Default: 0'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">GID:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="gpuGidInput" class="form-control" placeholder="" name="gpuGidInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the GID number of the device owner. Default: 0'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Mode:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="gpuModeInput" class="form-control" placeholder="" name="gpuModeInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the permissions mode for the device in the instance. Default: 0600'></i>
                  </div>
                </div>

              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="#" onclick="addInstanceGPUDevice()" data-dismiss="modal">Submit</a>
          </div>
      </div>
    </div>
  </div>

  <!-- Add Network Device Modal-->
  <div class="modal fade" id="addNetworkDeviceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Network Device</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <label class="col-3 col-form-label text-right">Device Name: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="networkNameInput" class="form-control" placeholder="" name="networkNameInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='(Required) - Enter a unique name to identify this instance device.'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">Property Set: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <select id="networkPropertySetInput" onchange="changePropertySetInput()" onchange="" class="form-control" name="networkPropertySetInput">
                    <option value="network">network</option>
                    <option value="nictype">nictype</option>
                  </select>
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Select "network" to link to an existing LXD managed network or "nictype" to define your network.'></i>
              </div>
            </div>
            <div class="row" id="networkNicTypeRow" style="display: none;">
              <label class="col-3 col-form-label text-right">NIC Type: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <select id="networkNicTypeInput" onchange="changeNicTypeInput()" onchange="" class="form-control" name="networkNicTypeInput">
                    <option value="bridged">bridged</option>
                    <option value="ipvlan">ipvlan</option>
                    <option value="macvlan">macvlan</option>
                    <option value="p2p">p2p</option>
                    <option value="physical">physical</option>
                    <option value="routed">routed</option>
                    <option value="sriov">sriov</option>
                  </select>
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Select the network device type. Bridged devices use an existing bridge on the host. MacVlan devices setup a device based on an existing parent but using a different MAC address. P2P devices create a virtual device pair. Physical devices create a straight passthrough from the host interface. An sriov device passes a virtual function of an SR-IOV enabled network into the instance.'></i>
              </div>
            </div>
            <div class="row" id="networkParentTypeRow">
              <label class="col-3 col-form-label text-right">Parent Type: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <select id="networkParentTypeInput" onchange="changeParentTypeInput()" class="form-control" name="networkParentTypeInput">
                    <option value="bridge">bridge</option>
                    <option value="macvlan">macvlan</option>
                    <option value="ovn">ovn</option>
                    <option value="sriov">sriov</option>
                  </select>
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Select the network type of the parent device.'></i>
              </div>
            </div>
            <div class="row" id="networkParentRow" style="display: none;">
              <label class="col-3 col-form-label text-right">Parent: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <select id="networkParentInput" class="form-control" name="networkParentInput">
                  </select>
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='(Required) - Select the parent network device from the host'></i>
              </div>
            </div>
            <div class="row" id="networkNetworkRow">
              <label class="col-3 col-form-label text-right">Network: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <select id="networkNetworkInput" class="form-control" name="networkNetworkInput">
                  </select>
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='(Required) - Select the LXD network to link this device to.'></i>
              </div>
            </div>
            <div class="row" id="networkInterfaceNameRow">
              <label class="col-3 col-form-label text-right">Interface Name:</label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="networkInterfaceNameInput" class="form-control" placeholder="" name="networkInterfaceNameInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Enter in a name for the interface inside the instance. Default: (kernel assigned)'></i>
              </div>
            </div>

            <hr>

            <div id="accordionNetworkProperties">
              <h2>
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#additionalNetworkProperties" aria-expanded="false" aria-controls="additionalNetworkProperties">
                  Additional Properties
                </button>
              </h2> 
              <div id="additionalNetworkProperties" class="collapse" aria-labelledby="additionalNetworkProperties">
                <div class="row" id="networkMtuRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">MTU:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="networkMtuInput" class="form-control" placeholder="" name="networkMtuInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='The MTU of the new interface. Default: (inherited from parent)'></i>
                  </div>
                </div>
                <div class="row" id="networkModeRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">Mode:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="networkModeInput" onchange="" class="form-control" name="networkModeInput">
                        <option value="">(not set)</option>
                        <option value="l2">l2</option>
                        <option value="l3s">l3s</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Select the IPVLAN mode. Default: (l3s)'></i>
                  </div>
                </div>
                <div class="row" id="networkHwaddrRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">HWADDR:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="networkHwaddrInput" class="form-control" placeholder="" name="networkHwaddrInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in a MAC address for the interface. Default: (randomly assigned)'></i>
                  </div>
                </div>
                <div class="row" id="networkHostNameRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">Host Name:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="networkHostNameInput" class="form-control" placeholder="" name="networkHostNameInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the name of the interface inside the host. Default: (randomly assigned)'></i>
                  </div>
                </div>
                <div class="row" id="networkLimitsIngressRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">Limits.Ingress:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="networkLimitsIngressInput" class="form-control" placeholder="" name="networkLimitsIngressInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the I/O limit for incoming traffic. Be sure to include the suffix. Default: (not set)'></i>
                  </div>
                </div>
                <div class="row" id="networkLimitsEgressRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">Limits.Egress:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="networkLimitsEgressInput" class="form-control" placeholder="" name="networkLimitsEgressInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the I/O limit for outgoing traffic. Be sure to include the suffix. Default: (not set)'></i>
                  </div>
                </div>
                <div class="row" id="networkLimitsMaxRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">Limits.Max:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="networkLimitsMaxInput" class="form-control" placeholder="" name="networkLimitsMaxInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the I/O limit. Be sure to inluce the suffix. Default: (not set)'></i>
                  </div>
                </div>
                <div class="row" id="networkIpv4AddressRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">IPv4 Address:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="networkIpv4AddressInput" class="form-control" placeholder="" name="networkIpv4AddressInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in an IPv4 address to assign to the instance through DHCP. Default: (not set)'></i>
                  </div>
                </div>
                <div class="row" id="networkIpv4GatewayRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">IPv4 Gateway:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="networkIpv4GatewayInput" class="form-control" placeholder="" name="networkIpv4GatewayInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='If using l3s mode, enter either "auto" or "none for using an automatic default gateway. If using l2 mode, enter in the address of the gateway. Default: (auto)'></i>
                  </div>
                </div>
                <div class="row" id="networkIpv4HostTableRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">IPv4 Host Table:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="networkIpv4HostTableInput" class="form-control" placeholder="" name="networkIpv4HostTableInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in a custom policy routing table ID to add IPv4 static routes to. Default: (not set)'></i>
                  </div>
                </div>
                <div class="row" id="networkIpv4HostAddressRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">IPv4 Host Address:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="networkIpv4HostAddressInput" class="form-control" placeholder="" name="networkIpv4HostAddressInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the IPv4 address to add to the host-side veth interface. Default: (169.254.0.1)'></i>
                  </div>
                </div>
                <div class="row" id="networkIpv4RoutesRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">IPv4 Routes:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="networkIpv4RoutesInput" class="form-control" placeholder="" name="networkIpv4RoutesInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in a comma seperated list of IPv4 static routes. Default: (not set)'></i>
                  </div>
                </div>
                <div class="row" id="networkIpv4RoutesExternalRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">IPv4 Routes External:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="networkIpv4RoutesExternalInput" class="form-control" placeholder="" name="networkIpv4RoutesExternalInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in a comma seperated list of static routes to route to the NIC and publish on the uplink. Default: (not set)'></i>
                  </div>
                </div>
                <div class="row" id="networkIpv6AddressRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">IPv6 Address:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="networkIpv6AddressInput" class="form-control" placeholder="" name="networkIpv6AddressInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in an IPv6 address to assign to the instance through DHCP. Default: (not set)'></i>
                  </div>
                </div>
                <div class="row" id="networkIpv6GatewayRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">IPv6 Gateway:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="networkIpv6GatewayInput" class="form-control" placeholder="" name="networkIpv6GatewayInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='If using l3s mode, enter either "auto" or "none for using an automatic default gateway. If using l2 mode, enter in the address of the gateway. Default: (auto or not set)'></i>
                  </div>
                </div>
                <div class="row" id="networkIpv6HostTableRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">IPv6 Host Table:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="networkIpv6HostTableInput" class="form-control" placeholder="" name="networkIpv6HostTableInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in a custom policy routing table ID to add IPv4 static routes to. Default: (not set)'></i>
                  </div>
                </div>
                <div class="row" id="networkIpv6HostAddressRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">IPv6 Host Address:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="networkIpv6HostAddressInput" class="form-control" placeholder="" name="networkIpv6HostAddressInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the IPv6 address to add to the host-side veth interface. Default: (fe80::1)'></i>
                  </div>
                </div>
                <div class="row" id="networkIpv6RoutesRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">IPv6 Routes:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="networkIpv6RoutesInput" class="form-control" placeholder="" name="networkIpv6RoutesInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in a comma seperated list of IPv4 static routes. Default: (not set)'></i>
                  </div>
                </div>
                <div class="row" id="networkIpv6RoutesExternalRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">IPv6 Routes External:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="networkIpv6RoutesExternalInput" class="form-control" placeholder="" name="networkIpv6RoutesExternalInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in a comma seperated list of static routes to route to the NIC and publish on the uplink. Default: (not set)'></i>
                  </div>
                </div>
                <div class="row" id="networkSecurityMacFilteringRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">Security.MAC.Filtering:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="networkSecurityMacFilteringInput" onchange="" class="form-control" name="networkSecurityMacFilteringInput">
                        <option value="">(not set)</option>
                        <option value="true">true</option>
                        <option value="false">false</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title="Select wheter to prevent the instance from spoofing another's MAC address. Default: false"></i>
                  </div>
                </div>
                <div class="row" id="networkSecurityIpv4FilteringRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">Security.IPv4.Filtering:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="networkSecurityIpv4FilteringInput" onchange="" class="form-control" name="networkSecurityIpv4FilteringInput">
                        <option value="">(not set)</option>
                        <option value="true">true</option>
                        <option value="false">false</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title="Select wheter to prevent the instance from spoofing another's IPv4 address (enables mac_filtering). Default: false"></i>
                  </div>
                </div>
                <div class="row" id="networkSecurityIpv6FilteringRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">Security.IPv6.Filtering:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="networkSecurityIpv6FilteringInput" onchange="" class="form-control" name="networkSecurityIpv6FilteringInput">
                        <option value="">(not set)</option>
                        <option value="true">true</option>
                        <option value="false">false</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title="Select wheter to prevent the instance from spoofing another's IPv6 address (enables mac_filtering). Default: false"></i>
                  </div>
                </div>
                <div class="row" id="networkMaasSubnetIpv4Row" style="display: none;">
                  <label class="col-3 col-form-label text-right">MAAS Subnet IPv4:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="networkMaasSubnetIpv4Input" class="form-control" placeholder="" name="networkMaasSubnetIpv4Input">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title="Enter in the MAAS IPv4 subnet to register the instance in. Default: (not set)"></i>
                  </div>
                </div>
                <div class="row" id="networkMaasSubnetIpv6Row" style="display: none;">
                  <label class="col-3 col-form-label text-right">MAAS Subnet IPv6:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="networkMaasSubnetIpv6Input" class="form-control" placeholder="" name="networkMaasSubnetIpv6Input">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title="Enter in the MAAS IPv6 subnet to register the instance in. Default: (not set)"></i>
                  </div>
                </div>
                <div class="row" id="networkBootPriorityRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">Boot Priority:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="networkBootPriorityInput" class="form-control" placeholder="" name="networkBootPriorityInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title="Enter in a boot priority number for VMs (highest number boots first). Default: (not set)"></i>
                  </div>
                </div>
                <div class="row" id="networkVlanRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">VLAN:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="networkVlanInput" class="form-control" placeholder="" name="networkVlanInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in a VLAN ID to use for untagged traffic. Enter "none" to remove the port from the default VLAN. Default: (not set)'></i>
                  </div>
                </div>
                <div class="row" id="networkVlanTaggedRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">VLAN Tagged:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="networkVlanTaggedInput" class="form-control" placeholder="" name="networkVlanTaggedInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title="Enter in a comma seperated list of VLAN IDs to join. Default: (not set)"></i>
                  </div>
                </div>
                <div class="row" id="networkSecurityPortIsolationRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">Security Port Isolation:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="networkSecurityPortIsolationInput" onchange="" class="form-control" name="networkSecurityPortIsolationInput">
                        <option value="">(not set)</option>
                        <option value="true">true</option>
                        <option value="false">false</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title="Select whether to prevent the NIC from communicating with other port isolated NICs in the network. Default: false"></i>
                  </div>
                </div>
                <div class="row" id="networkGvrpRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">GVRP:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="networkGvrpInput" onchange="" class="form-control" name="networkGvrpInput">
                        <option value="">(not set)</option>
                        <option value="true">true</option>
                        <option value="false">false</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title="Select whether to register the VLAN using the GARP VLAN Registration Protocol. Default: false"></i>
                  </div>
                </div>
                <div class="row" id="networkSecurityAclsRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">Security ACLs:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="networkSecurityAclsInput" class="form-control" placeholder="" name="networkSecurityAclsInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title="Enter in a comma separated list of Network ACLs. Default: (not set)"></i>
                  </div>
                </div>
                <div class="row" id="networkSecurityAclsDefaultIngressActionRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">Security ACLs Default Ingress Action:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="networkSecurityAclsDefaultIngressActionInput" onchange="" class="form-control" name="networkSecurityAclsDefaultIngressActionInput">
                        <option value="">(not set)</option>
                        <option value="allow">allow</option>
                        <option value="reject">reject</option>
                        <option value="drop">drop</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title="Select an action to use for ingress traffic without any matching ACL rules. Default: (reject)"></i>
                  </div>
                </div>
                <div class="row" id="networkSecurityAclsDefaultEgressActionRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">Security ACLs Default Egress Action:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="networkSecurityAclsDefaultEgressActionInput" onchange="" class="form-control" name="networkSecurityAclsDefaultEgressActionInput">
                        <option value="">(not set)</option>
                        <option value="allow">allow</option>
                        <option value="reject">reject</option>
                        <option value="drop">drop</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title="Select an action to use for egress traffic without any matching ACL rules. Default: (reject)"></i>
                  </div>
                </div>
                <div class="row" id="networkSecurityAclsDefaultIngressLoggedRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">Security ACLs Default Ingress Logged:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="networkSecurityAclsDefaultIngressLoggedInput" onchange="" class="form-control" name="networkSecurityAclsDefaultIngressLoggedInput">
                        <option value="">(not set)</option>
                        <option value="true">true</option>
                        <option value="false">false</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title="Select whether to log ingress traffic without any matching ACL rules. Default: (false)"></i>
                  </div>
                </div>
                <div class="row" id="networkSecurityAclsDefaultEgressLoggedRow" style="display: none;">
                  <label class="col-3 col-form-label text-right">Security ACLs Default Egress Logged:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="networkSecurityAclsDefaultEgressLoggedInput" onchange="" class="form-control" name="networkSecurityAclsDefaultEgressLoggedInput">
                        <option value="">(not set)</option>
                        <option value="true">true</option>
                        <option value="false">false</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title="Select whether to log egress traffic without any matching ACL rules. Default: (false)"></i>
                  </div>
                </div>
              </div>

            </div>

          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="#" onclick="addInstanceNetworkDevice()" data-dismiss="modal">Submit</a>
          </div>
      </div>
    </div>
  </div>

  <!-- Add Proxy Device Modal-->
  <div class="modal fade" id="addProxyDeviceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Proxy Device</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <label class="col-3 col-form-label text-right">Device Name: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="proxyDeviceNameInput" class="form-control" placeholder="" name="proxyDeviceNameInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='(Required) - Enter a unique name to identify this instance device'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">Listen: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="proxyListenInput" class="form-control" placeholder="" name="proxyListenInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='(Required) - Enter in the connection type, address, and port to bind and listen to, using the format <type>:<addr>:<port>[-<port>][,<port>]. For example, tcp:0.0.0.0:8080'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">Connect: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="proxyConnectInput" class="form-control" placeholder="" name="proxyConnectInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='(Required) - Enter in the connection type, address, and port to connect to, using the format <type>:<addr>:<port>[-<port>][,<port>]. For example, tcp:127.0.0.1:8080'></i>
              </div>
            </div>

            <hr>

            <div id="accordionProxyProperties">
              <h2>
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#additionalProxyProperties" aria-expanded="false" aria-controls="additionalProxyProperties">
                  Additional Properties
                </button>
              </h2> 
              <div id="additionalProxyProperties" class="collapse" aria-labelledby="additionalProxyProperties">
                <div class="row">
                  <label class="col-3 col-form-label text-right">Bind:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="proxyBindInput" onchange="" class="form-control" name="proxyBindInput">
                        <option value="">(not set)</option>
                        <option value="host">host</option>
                        <option value="instance">instance</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Select which side to bind on. Default: host'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">UID:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="proxyUidInput" class="form-control" placeholder="" name="proxyUidInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the UID number of the owner to the listening Unix socket. Default: 0'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">GID:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="proxyGidInput" class="form-control" placeholder="" name="proxyGidInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the GID number of the owner ot the listening Unix socket. Default: 0'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Mode:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="proxyModeInput" class="form-control" placeholder="" name="proxyModeInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the permissions mode for the listening Unix socket. Default: 0644'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">NAT:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="proxyNatInput" onchange="" class="form-control" name="proxyNatInput">
                        <option value="">(not set)</option>
                        <option value="true">true</option>
                        <option value="false">false</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Select whether or not to optimize proxying via NAT. Default: false'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Proxy Protocol:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="proxyProxyProtocolInput" onchange="" class="form-control" name="proxyProxyProtocolInput">
                        <option value="">(not set)</option>
                        <option value="true">true</option>
                        <option value="false">false</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Select whether to use the HAProxy PROXY protocol to when sending information. Default: false'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Security UID:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="proxySecurityUidInput" class="form-control" placeholder="" name="proxySecurityUidInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the UID for security privileges. Default: 0'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Security GID:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="proxySecurityGidInput" class="form-control" placeholder="" name="proxySecurityGidInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the GID for security privileges. Default: 0'></i>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="#" onclick="addInstanceProxyDevice()" data-dismiss="modal">Submit</a>
          </div>
      </div>
    </div>
  </div>

  <!-- Add Unix Device Modal-->
  <div class="modal fade" id="addUnixDeviceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Unix Device</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <label class="col-3 col-form-label text-right">Device Name: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="unixDeviceNameInput" class="form-control" placeholder="" name="unixDeviceNameInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='(Required) - Enter a unique name to identify this instance device'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">Type: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <select id="unixTypeInput" class="form-control" name="unixTypeInput">
                    <option value="unix-block">unix-block</option>
                    <option value="unix-char">unix-char</option>
                  </select>
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Select which Unix type to use'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">Source: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="unixSourceInput" class="form-control" placeholder="" name="unixSourceInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Enter in source filepath on the host'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">Path: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="unixPathInput" class="form-control" placeholder="" name="unixPathInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Enter in the filepath inside the instance'></i>
              </div>
            </div>

            <hr>

            <div id="accordionProxyProperties">
              <h2>
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#additionalProxyProperties" aria-expanded="false" aria-controls="additionalProxyProperties">
                  Additional Properties
                </button>
              </h2> 
              <div id="additionalProxyProperties" class="collapse" aria-labelledby="additionalProxyProperties">
                <div class="row">
                  <label class="col-3 col-form-label text-right">Major:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="unixMajorInput" class="form-control" placeholder="" name="unixMajorInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the device major number'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Minor:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="unixMinorInput" class="form-control" placeholder="" name="unixMinorInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the device minor number'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">UID:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="unixUidInput" class="form-control" placeholder="" name="unixUidInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the UID number of the device owner in the instance. Default: 0'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">GID:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="unixGidInput" class="form-control" placeholder="" name="unixGidInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the GID number of the device owner in the instance. Default: 0'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Mode:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="unixModeInput" class="form-control" placeholder="" name="unixModeInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the permissions mode for the listening Unix socket. Default: 0660'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Required:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="unixRequiredInput" class="form-control" name="unixRequiredInput">
                        <option value="">(not set)</option>
                        <option value="true">True</option>
                        <option value="false">False</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Select whether or not this device is required to start the instance. Default: true'></i>
                  </div>
                </div>

              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="#" onclick="addInstanceUnixDevice()" data-dismiss="modal">Submit</a>
          </div>
      </div>
    </div>
  </div>

  <!-- Add USB Device Modal-->
  <div class="modal fade" id="addUSBDeviceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add USB Device</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <label class="col-3 col-form-label text-right">Device Name: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="usbDeviceNameInput" class="form-control" placeholder="" name="usbDeviceNameInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='(Required) - Enter a unique name to identify this instance device'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">Vendor Id: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="usbVendoridInput" class="form-control" placeholder="" name="usbVendoridInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Enter in the vendor id of the usb device'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">Product Id: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="usbProductidInput" class="form-control" placeholder="" name="usbProductidInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Enter in the product id of the usb device'></i>
              </div>
            </div>

            <hr>

            <div id="accordionProxyProperties">
              <h2>
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#additionalProxyProperties" aria-expanded="false" aria-controls="additionalProxyProperties">
                  Additional Properties
                </button>
              </h2> 
              <div id="additionalProxyProperties" class="collapse" aria-labelledby="additionalProxyProperties">

                <div class="row">
                  <label class="col-3 col-form-label text-right">UID:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="usbUidInput" class="form-control" placeholder="" name="usbUidInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the UID number of the owner to the listening Unix socket. Default: 0'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">GID:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="usbGidInput" class="form-control" placeholder="" name="usbGidInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the GID number of the owner ot the listening Unix socket. Default: 0'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Mode:</label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="number" id="usbModeInput" class="form-control" placeholder="" name="usbModeInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the permissions mode for the listening Unix socket. Default: 0644'></i>
                  </div>
                </div>

              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="#" onclick="addInstanceUSBDevice()" data-dismiss="modal">Submit</a>
          </div>
      </div>
    </div>
  </div>

  <!-- Publish Instance Modal-->
  <div class="modal fade" id="publishInstanceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Publish Image from Instance</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <label class="col-3 col-form-label text-right">Description: </label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="publishInstanceDescriptionInput" class="form-control" placeholder="" name="description">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Enter in a description for the new image.'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">OS: </label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="publishInstanceOsInput" class="form-control" placeholder="" name="os">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Enter in the operating system name for the new image.'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">Release: </label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="publishInstanceReleaseInput" class="form-control" placeholder="" name="release">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Enter in the release version for the new image.'></i>
              </div>
            </div>
            <div class="row">
              <label class="col-3 col-form-label text-right">Public:</label>
              <div class="col-7">
                <div class="form-group">
                  <select id="publishInstancePublicInput" class="form-control" name="public">
                    <option value="false" selected>false</option>
                    <option value="true">true</option>
                  </select>
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Select whether or not this image is public. Default: false'></i>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="#" onclick="publishInstance()" data-dismiss="modal">Submit</a>
          </div>
      </div>
    </div>
  </div>

  <!-- Load Log Modal-->
  <div class="modal fade" id="loadLogModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Log Contents</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <label class="col-12 col-form-label" id="logNameInput"></label>
              <div class="col-12">
                <div class="form-group text-right">
                  <pre>
                    <textarea name="log_data" class="form-control" id="logDataInput" rows="16" ></textarea>
                  </pre>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
          </div>
      </div>
    </div>
  </div>

  <!-- Edit Instance Modal-->
  <div class="modal fade" id="editInstanceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Container</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="form-tab" data-toggle="tab" href="#form" role="tab" aria-controls="form" aria-selected="true">Form</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="json-tab" data-toggle="tab" href="#json" role="tab" aria-controls="json" aria-selected="false">JSON</a>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="form" role="tabpanel" aria-labelledby="form-tab">
                <br />
                <div class="row">
                  <label class="col-3 col-form-label text-right">Description: </label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="containerDescriptionInput" class="form-control" required="required" placeholder="">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in a description for this container'></i>
                  </div>
                </div>
                <hr>
                <nav>
                  <div class="nav nav-pills justify-content-center" id="nav-tab" role="tablist">
                    <a class="nav-link active" id="nav-boot-tab" data-toggle="tab" href="#nav-boot" role="tab" aria-controls="nav-boot" aria-selected="true">Boot</a>
                    <a class="nav-link" id="nav-limits-tab" data-toggle="tab" href="#nav-limits" role="tab" aria-controls="nav-limits" aria-selected="false">Limits</a>
                    <a class="nav-link" id="nav-migration-tab" data-toggle="tab" href="#nav-migration" role="tab" aria-controls="nav-migration" aria-selected="false">Migration</a>
                    <a class="nav-link" id="nav-nvidia-tab" data-toggle="tab" href="#nav-nvidia" role="tab" aria-controls="nav-nvidia" aria-selected="false">Nvidia</a>
                    <a class="nav-link" id="nav-other-tab" data-toggle="tab" href="#nav-other" role="tab" aria-controls="nav-other" aria-selected="false">Other</a>
                    <a class="nav-link" id="nav-raw-tab" data-toggle="tab" href="#nav-raw" role="tab" aria-controls="nav-raw" aria-selected="false">Raw</a>
                    <a class="nav-link" id="nav-security-tab" data-toggle="tab" href="#nav-security" role="tab" aria-controls="nav-security" aria-selected="false">Security</a>
                    <a class="nav-link" id="nav-snapshots-config-tab" data-toggle="tab" href="#nav-snapshots-config" role="tab" aria-controls="nav-snapshots-config" aria-selected="false">Snapshots</a>
                  </div>
                </nav>
                <hr class="mt-2">
                <div class="tab-content" id="nav-tabContent">
                  <div class="tab-pane fade show active" id="nav-boot" role="tabpanel" aria-labelledby="nav-boot-tab">
                    <br>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Autostart: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="containerBootAutostartInput" onchange="" class="form-control" name="containerBootAutostartInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether to automatically start the container with LXD starts. If not set, defaults to container last state.'></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Autostart Delay: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="containerBootAutostartDelayInput" class="form-control" placeholder="" name="containerBootAutostartDelayInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the number of seconds to wait after the container starts to boot up the next container. Default: 0.'></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Autostart Priority: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="containerBootAutostartPriorityInput" class="form-control" placeholder="" name="containerBootAutostartPriorityInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in a number to determine the order the container boots, higher numbers being first. Default: 0.'></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Host Shutdown Timeout: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="containerBootHostShutdownTimeoutInput" class="form-control" placeholder="" name="containerBootHostShutdownTimeoutInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in a the number of seconds to wait on host shutdown before forcefull shutdown of container. Default: 30.'></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Stop Priority: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="containerBootStopPriorityInput" class="form-control" placeholder="" name="containerBootStopPriorityInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in a number to determine the order the container shutsdown, higher numbers being first. Default: 0.'></i>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="nav-limits" role="tabpanel" aria-labelledby="nav-limits-tab">
                    <br>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">CPU: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="containerLimitsCpuInput" class="form-control" placeholder="" name="containerLimitsCpuInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the number or range of CPUs to expose to the container.'></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">CPU Allowance: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="containerLimitsCpuAllowanceInput" class="form-control" placeholder="" name="containerLimitsCpuAllowanceInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the amount of Host CPU allowed to the container. This can be a percentage or a chunk of time. For example, 50% or 25ms/100ms. Default: 100%) '></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">CPU Priority: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="containerLimitsCpuPriorityInput" class="form-control" placeholder="" name="containerLimitsCpuPriorityInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in an integer between 0 (min) and 10 (max) to schedule the CPU priority compared to other containers. Default: 10.'></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Disk Priority: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="containerLimitsDiskPriorityInput" class="form-control" placeholder="" name="containerLimitsDiskPriorityInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in an integer between 0 (min) and 10 (max) to schedule disk I/O request priority compared to other containers. Default: 5.'></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Hugepages - 64KB: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="containerLimitsHugepages64KBInput" class="form-control" placeholder="" name="containerLimitsHugepages64KBInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in a fixed value in bytes to limit the number of 64 KB hugepages. Default: (not set).'></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Hugepages - 1MB: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="containerLimitsHugepages1MBInput" class="form-control" placeholder="" name="containerLimitsHugepages1MBInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in a fixed value in bytes to limit the number of 1 MB hugepages. Default: (not set).'></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Hugepages - 2MB: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="containerLimitsHugepages2MBInput" class="form-control" placeholder="" name="containerLimitsHugepages2MBInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in a fixed value in bytes to limit the number of 2 MB hugepages. Default: (not set).'></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Hugepages - 1GB: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="containerLimitsHugepages1GBInput" class="form-control" placeholder="" name="containerLimitsHugepages1GBInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in a fixed value in bytes to limit the number of 1 GB hugepages. Default: (not set).'></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Memory: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="containerLimitsMemoryInput" class="form-control" placeholder="" name="containerLimitsMemoryInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in a percentage of the host's memory or enter in a fixed value of bytes."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Memory Enforce: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="containerLimitsMemoryEnforceInput" onchange="" class="form-control" name="containerLimitsMemoryEnforceInput">
                            <option value="">(not set)</option>
                            <option value="hard">hard</option>
                            <option value="soft">soft</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether to put a hard stop on the memory limit or use a soft stop to exceed the limit if extra memory is available. Default: hard."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Memory Swap: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="containerLimitsMemorySwapInput" onchange="" class="form-control" name="containerLimitsMemorySwapInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether to encorage swapping less used pages for the container. Default: true."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Memory Swap Priority: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="containerLimitsMemorySwapPriorityInput" class="form-control" placeholder="" name="containerLimitsMemorySwapPriorityInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in the priority that the container will be less likely to swap to disk, with 10 being the maxium less likeliness. Default 10."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Network Priority: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="containerLimitsNetworkPriorityInput" class="form-control" placeholder="" name="containerLimitsNetworkPriorityInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in the priority for the container network when the host is under, with 10 being the priority. Default 0."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Processes: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="containerLimitsProcessesInput" class="form-control" placeholder="" name="containerLimitsProcessesInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in the maximum number of processes that can run in an container. Default (not set)."></i>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="nav-migration" role="tabpanel" aria-labelledby="nav-migration-tab">
                    <br>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Incremental Memory: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="containerMigrationIncrementalMemoryInput" onchange="" class="form-control" name="containerMigrationIncrementalMemoryInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether to allow incremental memory transfer of the container's memory to reduce downtime. Default: false."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Incremental Memory Goal: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="containerMigrationIncrementalMemoryGoalInput" class="form-control" placeholder="" name="containerMigrationIncrementalMemoryGoalInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in the percentage number of memory to have in sync before stopping the container. Default: 70."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Incremental Memory Iterations: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="containerMigrationIncrementalMemoryIterationsInput" class="form-control" placeholder="" name="containerMigrationIncrementalMemoryIterationsInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in the maximum number of transfer operations to go through before stopping the container. Default: 10."></i>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="nav-nvidia" role="tabpanel" aria-labelledby="nav-nvidia-tab">
                    <br>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Driver Capabilities: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="containerNvidiaDriverCapabilitiesInput" class="form-control" placeholder="" name="containerNvidiaDriverCapabilitiesInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in what driver capabilities the container needs (sets libnvidia-container NVIDIA_DRIVER_CAPABILITIES). Default: compute,utility."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Runtime: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="containerNvidiaRuntimeInput" onchange="" class="form-control" name="containerNvidiaRuntimeInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether to pass the host NVIDIA and CUDA runtime libraries into the container. Default: false."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Require Cuda: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="containerNvidiaRequireCudaInput" class="form-control" placeholder="" name="containerNvidiaRequireCudaInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in the version expression for the required CUDA version (sets libnvidia-container NVIDIA_REQUIRE_CUDA). Default: (not set)."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Require Driver: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="containerNvidiaRequireDriverInput" class="form-control" placeholder="" name="containerNvidiaRequireDriverInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in the version expression for the required driver version (sets libnvidia-container NVIDIA_REQUIRE_DRIVER). Default: (not set)."></i>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="nav-other" role="tabpanel" aria-labelledby="nav-other-tab">
                    <br>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Cluster Evacuate: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="containerClusterEvacuateInput" onchange="" class="form-control" name="containerClusterEvacuateInput">
                            <option value="">(not set)</option>
                            <option value="auto">auto</option>
                            <option value="migrate">migrate</option>
                            <option value="stop">stop</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select what to do when evacuating the container. Default: auto'></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Kernel Modules: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="containerLinuxKernelModulesInput" class="form-control" placeholder="" name="containerLinuxKernelModulesInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in a comma separated list of kernel modules to load before starting the container. Default (not set)."></i>
                      </div>
                    </div>

                  </div>
                  <div class="tab-pane fade" id="nav-raw" role="tabpanel" aria-labelledby="nav-raw-tab">
                    <br>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Apparmor: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="containerRawApparmorInput" class="form-control" placeholder="" name="containerRawApparmorInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in apparmor profile entries to be appended to the profile. Default: (not set)."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Idmap: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="containerRawIdmapInput" class="form-control" placeholder="" name="containerRawIdmapInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in a raw idmap configuration (e.g. 'both 1000 1000'). Default: (not set)."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Lxc: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="containerRawLxcInput" class="form-control" placeholder="" name="containerRawLxcInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in a raw LXC configuration to be appended to current configuration. Default: (not set)."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Seccomp: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="containerRawSeccompInput" class="form-control" placeholder="" name="containerRawSeccompInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in a raw Seccomp configuration. Default: (not set)."></i>
                      </div>
                    </div>

                  </div>
                  <div class="tab-pane fade" id="nav-security" role="tabpanel" aria-labelledby="nav-security-tab">
                    <br>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Devlxd: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="containerSecurityDevLxdInput" onchange="" class="form-control" name="containerSecurityDevLxdInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether to control the presence of /dev/lxd in the container. Default: true."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Devlxd Images: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="containerSecurityDevLxdImagesInput" onchange="" class="form-control" name="containerSecurityDevLxdImagesInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether to make the /1.0/images API available over devlxd. Default: false."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Idmap Base: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="containerSecurityIdmapBaseInput" class="form-control" placeholder="" name="containerSecurityIdmapBaseInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in the base Host ID to use for allocation. Default: (auto detection)."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Idmap Isolated: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="containerSecurityIdmapIsolatedInput" onchange="" class="form-control" name="containerSecurityIdmapIsolatedInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether to use an idmap for the container that is unique amoung containers with isolate enabled. Default: false."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Idmap Size: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="containerSecurityIdmapSizeInput" class="form-control" placeholder="" name="containerSecurityIdmapSizeInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in the size of the idmap to use. Default: (not set)."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Nesting: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="containerSecurityNestingInput" onchange="" class="form-control" name="containerSecurityNestingInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether to support running LXD inside the container. Default: false."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Privileged: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="containerSecurityPrivilegedInput" onchange="" class="form-control" name="containerSecurityPrivilegedInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether to run the container in privileged mode. Default: false."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Protection Delete: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="containerSecurityProtectionDeleteInput" onchange="" class="form-control" name="containerSecurityProtectionDeleteInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether to prevent the container from being deleted. Default: false."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Protection Shift: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="containerSecurityProtectionShiftInput" onchange="" class="form-control" name="containerSecurityProtectionShiftInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether to prevent the container filesystem from being uid/gid shifted on startup. Default: false."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Syscalls Allow: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="containerSecuritySyscallsAllowInput" class="form-control" placeholder="" name="containerSecuritySyscallsAllowInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in a '\n' separated list of syscalls to allow. Default: (not set)."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Syscalls Deny: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="containerSecuritySyscallsDenyInput" class="form-control" placeholder="" name="containerSecuritySyscallsDenyInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in a '\n' separated list of syscalls to deny. Default: (not set)."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Syscalls Deny Compat: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="containerSecuritySyscallsDenyCompatInput" onchange="" class="form-control" name="containerSecuritySyscallsDenyCompatInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether to enable on x86_64 the blocking of compat_* syscalls. Default: false."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Syscalls Deny Default: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="containerSecuritySyscallsDenyDefaultInput" onchange="" class="form-control" name="containerSecuritySyscallsDenyDefaultInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether to enable the default syscall deny. Default: true."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Syscalls Intercept Bpf: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="containerSecuritySyscallsInterceptBpfInput" onchange="" class="form-control" name="containerSecuritySyscallsInterceptBpfInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether to handle tehe bpf system call. Default: false."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Syscalls Intercept Bpf Devices: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="containerSecuritySyscallsInterceptBpfDevicesInput" onchange="" class="form-control" name="containerSecuritySyscallsInterceptBpfDevicesInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether to allow bpf programs for the devices cgroup in the unified hierarchy to be loaded. Default: false."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Syscalls Intercept Mknod: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="containerSecuritySyscallsInterceptMknodInput" onchange="" class="form-control" name="containerSecuritySyscallsInterceptMknodInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether to handle the mknod and mknodat system calls. Default: false."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Syscalls Intercept Mount: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="containerSecuritySyscallsInterceptMountInput" onchange="" class="form-control" name="containerSecuritySyscallsInterceptMountInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether to handle the mount system calls. Default: false."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Syscalls Intercept Mount Allowed: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="containerSecuritySyscallsInterceptMountAllowedInput" class="form-control" placeholder="" name="containerSecuritySyscallsInterceptMountAllowedInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in a comma-separated list of filesystems that are safe to mount for processes within the container. Default: (not set)."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Syscalls Intercept Mount Fuse: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="containerSecuritySyscallsInterceptMountFuseInput" class="form-control" placeholder="" name="containerSecuritySyscallsInterceptMountFuseInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in redirect mounts of a given filesystem to their fuse implemenation (e.g. ext4=fuse2fs). Default: (not set)."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Syscalls Intercept Mount Shift: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="containerSecuritySyscallsInterceptMountShiftInput" onchange="" class="form-control" name="containerSecuritySyscallsInterceptMountShiftInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select Whether to mount shiftfs on top of filesystems handled through mount syscall interception. Default: false."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Syscalls Intercept Mount Setxattr: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="containerSecuritySyscallsInterceptSetxattrInput" onchange="" class="form-control" name="containerSecuritySyscallsInterceptSetxattrInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether to handle the setxattr system call. Default: false."></i>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="nav-snapshots-config" role="tabpanel" aria-labelledby="nav-snapshots-config-tab">
                    <br>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Schedule: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="containerSnapshotsScheduleInput" class="form-control" placeholder="" name="containerSnapshotsScheduleInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in a cron expression (<minute> <hour> <dom> <month> <dow>), or a comma separated list of schedule aliases <@hourly> <@daily> <@midnight> <@weekly> <@monthly> <@annually> <@yearly> <@startup>. Default: (not set)."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Schedule Stopped: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="containerSnapshotsScheduleStoppedInput" onchange="" class="form-control" name="containerSnapshotsScheduleStoppedInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether stopped containers are to be snapshoted automatically. Default: false."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Pattern: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="containerSnapshotsPatternInput" class="form-control" placeholder="" name="containerSnapshotsPatternInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in a pongo2 template string representing the snapshot name. Default: snap%d."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Expiry: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="containerSnapshotsExpiryInput" class="form-control" placeholder="" name="containerSnapshotsExpiryInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in time controls when snapshots are to be deleted (expects expressions like 1M 2H 3d 4w 5m 6y). Default: (not set)."></i>
                      </div>
                    </div>
                    
                  </div>
                </div>
              
                <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                  <a class="btn btn-primary" href="#" onclick="updateInstanceForm()" data-dismiss="modal">Ok</a>
                </div>
              </div>
              <div class="tab-pane fade" id="json" role="tabpanel" aria-labelledby="json-tab">
                <br />
                <div class="row">
                  <label class="col-12 col-form-label" id="instanceNameEditInput"></label>
                  <div class="col-12">
                    <div class="form-group text-right">
                      <pre>
                        <textarea name="json" class="form-control" id="jsonEditInput" rows="16" placeholder="Enter JSON data"></textarea>
                      </pre>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                  <a class="btn btn-primary" href="#" onclick="updateInstanceJson()" data-dismiss="modal">Save</a>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>

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

  <!-- Web Socket Connection Error Modal-->
  <div class="modal fade" id="webSocketConnectionErrorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">WebSocket Connection Error</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div id="webSocketConnectionError"></div>
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
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="vendor/xterm/lib/xterm.js"></script>

</body>

<script>
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const remoteId = urlParams.get('remote');
  const instanceName = urlParams.get('instance');
  const projectName = urlParams.get('project');
  var instanceStateDetails = "";
  var consoleControlSocket;
  var consoleDataSocket;
  var consoleTerminal;
  var execControlSocket;
  var execDataSocket;
  var execSocket;
  var execTerminal;
  var activeTab = "#nav-overview";
  var reloadTime = 5000;

  function logout(){
    $.get("./backend/aaa/authentication.php?action=deauthenticateUser", function (data) {
      operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.status_code == 200) {
        window.location.href = './index.php'
      }
    });
  }

  function displayMenuOptions(data){
    jsonData = JSON.parse(data);
    switch (jsonData.metadata.status){
      case "Stopped":
        $('#startLink').show();
        $('#stopLink').hide();
        $('#restartInstanceOption').hide();
        $('#stopInstanceForcefullyOption').hide();
        $('#freezeInstanceOption').hide();
        $('#unfreezeLink').hide();
        $('#snapshotInstanceOption').show();
        $('#attachInstanceProfileOption').show();
        $('#editInstanceOption').show();
        $('#renameInstanceOption').show();
        $('#copyInstanceOption').show();
        $('#migrateInstanceOption').show();
        $('#publishInstanceOption').show();
        $('#deleteInstanceOption').show();
        $('#startExecButton').prop('disabled', true);
        $('#startConsoleButton').prop('disabled', true);
        break;
      case "Frozen":
        $('#startLink').hide();
        $('#stopLink').hide();
        $('#restartInstanceOption').hide();
        $('#stopInstanceForcefullyOption').hide();
        $('#freezeInstanceOption').hide();
        $('#unfreezeLink').show();
        $('#snapshotInstanceOption').show();
        $('#attachInstanceProfileOption').hide();
        $('#editInstanceOption').hide();
        $('#renameInstanceOption').hide();
        $('#copyInstanceOption').show();
        $('#migrateInstanceOption').hide();
        $('#publishInstanceOption').hide();
        $('#deleteInstanceOption').hide();
        $('#startExecButton').prop('disabled', true);
        $('#startConsoleButton').prop('disabled', true);
        break;
      default:
        $('#startLink').hide();
        $('#stopLink').show();
        $('#restartInstanceOption').show();
        $('#stopInstanceForcefullyOption').show();
        $('#freezeInstanceOption').show();
        $('#unfreezeLink').hide();
        $('#snapshotInstanceOption').show();
        $('#attachInstanceProfileOption').show();
        $('#editInstanceOption').show();
        $('#renameInstanceOption').hide();
        $('#copyInstanceOption').hide();
        $('#migrateInstanceOption').hide();
        $('#publishInstanceOption').hide();
        $('#deleteInstanceOption').hide();
        $('#startExecButton').prop('disabled', false);
        $('#startConsoleButton').prop('disabled', false);
    }
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
  
  function reloadPageContent(){

    clearTimeout(pageReloadTimeout);

    //Check Authorization
    $.get("./backend/aaa/authentication.php?action=validateAuthentication", function (data) {
      operationData = JSON.parse(data);
      if (operationData.status_code != 200) {
        console.log(operationData);
        window.location.href = './index.php'
      }
    });

    //Display instance menu options based on state
    $.get("./backend/lxd/containers-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&action=retrieveInstanceState", displayMenuOptions)

    //Reload based on which tab is active
    switch(activeTab) {
      
      case "#nav-overview":
        $.get("./backend/lxd/containers-single.php?instance=" + encodeURI(instanceName) + "&remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayInstanceInfo", function (data) {
          data = JSON.parse(data);
          data = data.metadata;
          dataConfig = data.config;

          $("#name").text(data.name);
          if (data.hasOwnProperty('description')) { $("#description").text(data.description); }
          if (data.hasOwnProperty('type')) { $("#type").text(data.type); }
          $("#status").text(data.status);
          if (dataConfig.hasOwnProperty('image.description')) { $("#image").text(dataConfig["image.description"]); }
          $("#location").text(data.location);
          $("#created").text(data.created_at);

          //Load Instance Progress Gauges
          if (data.status == "Running"){
            $.get("./backend/lxd/containers-single.php?instance=" + encodeURI(instanceName) + "&remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=retrieveGaugeStats", function (data) {
              data = JSON.parse(data);
              $("#cpuPercentage").text(data[0]);
              $("#cpuPercentageGauge").attr('data-value',data[0]);
              $("#memoryPercentage").text(data[1]);
              $("#memoryPercentageGauge").attr('data-value',data[1]);
              formatProgressGauge();
            });
          }
          else {
            $("#cpuPercentage").text("0.0");
            $("#cpuPercentageGauge").attr('data-value',"0.0");
            $("#memoryPercentage").text("0.0");
            $("#memoryPercentageGauge").attr('data-value',"0.0");
            formatProgressGauge();
          }

        });
        
        $.get("./backend/lxd/containers-single.php?instance=" + encodeURI(instanceName) + "&remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayInstanceStateInfo", function (data) {
          data = JSON.parse(data);
          $("#memory").text(data.memory)
          $("#swap").text(data.swap)
          $("#pid").text(data.pid)
          $("#processes").text(data.processes)
          $("#ipv4Addresses").text(data.ipv4Addresses)
          $("#ipv6Addresses").text(data.ipv6Addresses)
        });
        break;

      case "#nav-config":
        $.get("./backend/lxd/containers-single.php?instance=" + encodeURI(instanceName) + "&remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayInstanceInfo", function (data) {
          data = JSON.parse(data);
          data = data.metadata;
          dataConfig = data.config;

          $("#name").text(data.name);
          if (data.hasOwnProperty('description')) { $("#description").text(data.description); }
          if (data.hasOwnProperty('type')) { $("#type").text(data.type); }
          $("#status").text(data.status);
          if (dataConfig.hasOwnProperty('image.description')) { $("#image").text(dataConfig["image.description"]); }
          $("#location").text(data.location);
          $("#created").text(data.created_at);

          if (dataConfig.hasOwnProperty('boot.autostart')) { $("#bootAutostart").text(dataConfig['boot.autostart']); } else { $("#bootAutostart").text(""); }
          if (dataConfig.hasOwnProperty('boot.autostart.delay')) { $("#bootAutostartDelay").text(dataConfig['boot.autostart.delay']); } else { $("#bootAutostartDelay").text(""); }
          if (dataConfig.hasOwnProperty('boot.autostart.priority')) { $("#bootAutostartPriority").text(dataConfig['boot.autostart.priority']); } else { $("#bootAutostartPriority").text(""); }
          if (dataConfig.hasOwnProperty('boot.host_shutdown_timeout')) { $("#bootHostShutdownTimeout").text(dataConfig['boot.host_shutdown_timeout']); } else { $("#bootHostShutdownTimeout").text(""); }
          if (dataConfig.hasOwnProperty('boot.stop.priority')) { $("#bootStopPriority").text(dataConfig['boot.stop.priority']); } else { $("#bootStopPriority").text(""); }

          if (dataConfig.hasOwnProperty('cluster.evacuate')) { $("#clusterEvacuate").text(dataConfig['cluster.evacuate']); } else { $("#clusterEvacuate").text(""); }

          if (dataConfig.hasOwnProperty('limits.cpu')) { $("#limitsCpu").text(dataConfig['limits.cpu']); } else { $("#limitsCpu").text(""); }
          if (dataConfig.hasOwnProperty('limits.cpu.allowance')) { $("#limitsCpuAllowance").text(dataConfig['limits.cpu.allowance']); } else { $("#limitsCpuAllowance").text(""); }
          if (dataConfig.hasOwnProperty('limits.cpu.priority')) { $("#limitsCpuPriority").text(dataConfig['limits.cpu.priority']); } else { $("#limitsCpuPriority").text(""); }
          if (dataConfig.hasOwnProperty('limits.disk.priority')) { $("#limitsDiskPriority").text(dataConfig['limits.disk.priority']); } else { $("#limitsDiskPriority").text(""); }
          if (dataConfig.hasOwnProperty('limits.hugepages.64KB')) { $("#limitsHugepages64KB").text(dataConfig['limits.hugepages.64KB']); } else { $("#limitsHugepages64KB").text(""); }
          if (dataConfig.hasOwnProperty('limits.hugepages.1MB')) { $("#limitsHugepages1MB").text(dataConfig['limits.hugepages.1MB']); } else { $("#limitsHugepages1MB").text(""); }
          if (dataConfig.hasOwnProperty('limits.hugepages.2MB')) { $("#limitsHugepages2MB").text(dataConfig['limits.hugepages.2MB']); } else { $("#limitsHugepages2MB").text(""); }
          if (dataConfig.hasOwnProperty('limits.hugepages.1GB')) { $("#limitsHugepages1GB").text(dataConfig['limits.hugepages.1GB']); } else { $("#limitsHugepages1GB").text(""); }
          if (dataConfig.hasOwnProperty('limits.memory')) { $("#limitsMemory").text(dataConfig['limits.memory']); } else { $("#limitsMemory").text(""); }
          if (dataConfig.hasOwnProperty('limits.memory.enforce')) { $("#limitsMemoryEnforce").text(dataConfig['limits.memory.enforce']); } else { $("#limitsMemoryEnforce").text(""); }
          if (dataConfig.hasOwnProperty('limits.memory.swap')) { $("#limitsMemorySwap").text(dataConfig['limits.memory.swap']); } else { $("#limitsMemorySwap").text(""); }
          if (dataConfig.hasOwnProperty('limits.memory.swap.priority')) { $("#limitsMemorySwapPriority").text(dataConfig['limits.memory.swap.priority']); } else { $("#limitsMemorySwapPriority").text(""); }
          if (dataConfig.hasOwnProperty('limits.network.priority')) { $("#limitsNetworkPriority").text(dataConfig['limits.network.priority']); } else { $("#limitsNetworkPriority").text(""); }
          if (dataConfig.hasOwnProperty('limits.processes')) { $("#limitsProcesses").text(dataConfig['limits.processes']); } else { $("#limitsProcesses").text(""); }

          if (dataConfig.hasOwnProperty('linux.kernel_modules')) { $("#linuxKernelModules").text(dataConfig['linux.kernel_modules']); } else { $("#linuxKernelModules").text(""); }

          if (dataConfig.hasOwnProperty('migration.incremental.memory')) { $("#migrationIncrementalMemory").text(dataConfig['migration.incremental.memory']); } else { $("#migrationIncrementalMemory").text(""); }
          if (dataConfig.hasOwnProperty('migration.incremental.memory.goal')) { $("#migrationIncrementalMemoryGoal").text(dataConfig['migration.incremental.memory.goal']); } else { $("#migrationIncrementalMemoryGoal").text(""); }
          if (dataConfig.hasOwnProperty('migration.incremental.memory.iterations')) { $("#migrationIncrementalMemoryIterations").text(dataConfig['migration.incremental.memory.iterations']); } else { $("#migrationIncrementalMemoryIterations").text(""); }

          if (dataConfig.hasOwnProperty('nvidia.driver.capabilities')) { $("#nvidiaDriverCapabilities").text(dataConfig['nvidia.driver.capabilities']); } else { $("#nvidiaDriverCapabilities").text(""); }
          if (dataConfig.hasOwnProperty('nvidia.runtime')) { $("#nvidiaRuntime").text(dataConfig['nvidia.runtime']); } else { $("#nvidiaRuntime").text(""); }
          if (dataConfig.hasOwnProperty('nvidia.require.cuda')) { $("#nvidiaRequireCuda").text(dataConfig['nvidia.require.cuda']); } else { $("#nvidiaRequireCuda").text(""); }
          if (dataConfig.hasOwnProperty('nvidia.require.driver')) { $("#nvidiaRequireDriver").text(dataConfig['nvidia.require.driver']); } else { $("#nvidiaRequireDriver").text(""); }

          if (dataConfig.hasOwnProperty('raw.apparmor')) { $("#rawApparmor").text(dataConfig['raw.apparmor']); } else { $("#rawApparmor").text(""); }
          if (dataConfig.hasOwnProperty('raw.idmap')) { $("#rawIdmap").text(dataConfig['raw.idmap']); } else { $("#rawIdmap").text(""); }
          if (dataConfig.hasOwnProperty('raw.lxc')) { $("#rawLxc").text(dataConfig['raw.lxc']); } else { $("#rawLxc").text(""); }
          if (dataConfig.hasOwnProperty('raw.seccomp')) { $("#rawSeccomp").text(dataConfig['raw.seccomp']); } else { $("#rawSeccomp").text(""); }

          if (dataConfig.hasOwnProperty('security.devlxd')) { $("#securityDevLxd").text(dataConfig['security.devlxd']); } else { $("#securityDevLxd").text(""); }
          if (dataConfig.hasOwnProperty('security.devlxd.images')) { $("#securityDevLxdImages").text(dataConfig['security.devlxd.images']); } else { $("#securityDevLxdImages").text(""); }
          if (dataConfig.hasOwnProperty('security.idmap.base')) { $("#securityIdmapBase").text(dataConfig['security.idmap.base']); } else { $("#securityIdmapBase").text(""); }
          if (dataConfig.hasOwnProperty('security.idmap.isolated')) { $("#securityIdmapIsolated").text(dataConfig['security.idmap.isolated']); } else { $("#securityIdmapIsolated").text(""); }
          if (dataConfig.hasOwnProperty('security.idmap.size')) { $("#securityIdmapSize").text(dataConfig['security.idmap.size']); } else { $("#securityIdmapSize").text(""); }
          if (dataConfig.hasOwnProperty('security.nesting')) { $("#securityNesting").text(dataConfig['security.nesting']); } else { $("#securityNesting").text(""); }
          if (dataConfig.hasOwnProperty('security.privileged')) { $("#securityPrivileged").text(dataConfig['security.privileged']); } else { $("#securityPrivileged").text(""); }
          if (dataConfig.hasOwnProperty('security.protection.delete')) { $("#securityProtectionDelete").text(dataConfig['security.protection.delete']); } else { $("#securityProtectionDelete").text(""); }
          if (dataConfig.hasOwnProperty('security.protection.shift')) { $("#securityProtectionShift").text(dataConfig['security.protection.shift']); } else { $("#securityProtectionShift").text(""); }
          if (dataConfig.hasOwnProperty('security.syscalls.allow')) { $("#securitySyscallsAllow").text(dataConfig['security.syscalls.allow']); } else { $("#securitySyscallsAllow").text(""); }
          if (dataConfig.hasOwnProperty('security.syscalls.deny')) { $("#securitySyscallsDeny").text(dataConfig['security.syscalls.deny']); } else { $("#securitySyscallsDeny").text(""); }
          if (dataConfig.hasOwnProperty('security.syscalls.deny_compat')) { $("#securitySyscallsDenyCompat").text(dataConfig['security.syscalls.deny_compat']); } else { $("#securitySyscallsDenyCompat").text(""); }
          if (dataConfig.hasOwnProperty('security.syscalls.deny_default')) { $("#securitySyscallsDenyDefault").text(dataConfig['security.syscalls.deny_default']); } else { $("#securitySyscallsDenyDefault").text(""); }
          if (dataConfig.hasOwnProperty('security.syscalls.intercept.bpf')) { $("#securitySyscallsInterceptBpf").text(dataConfig['security.syscalls.intercept.bpf']); } else { $("#securitySyscallsInterceptBpf").text(""); }
          if (dataConfig.hasOwnProperty('security.syscalls.intercept.bpf.devices')) { $("#securitySyscallsInterceptBpfDevices").text(dataConfig['security.syscalls.intercept.bpf.devices']); } else { $("#securitySyscallsInterceptBpfDevices").text(""); }
          if (dataConfig.hasOwnProperty('security.syscalls.intercept.mknod')) { $("#securitySyscallsInterceptMknod").text(dataConfig['security.syscalls.intercept.mknod']); } else { $("#securitySyscallsInterceptMknod").text(""); }
          if (dataConfig.hasOwnProperty('security.syscalls.intercept.mount')) { $("#securitySyscallsInterceptMount").text(dataConfig['security.syscalls.intercept.mount']); } else { $("#securitySyscallsInterceptMount").text(""); }
          if (dataConfig.hasOwnProperty('security.syscalls.intercept.mount.allowed')) { $("#securitySyscallsInterceptMountAllowed").text(dataConfig['security.syscalls.intercept.mount.allowed']); } else { $("#securitySyscallsInterceptMountAllowed").text(""); }
          if (dataConfig.hasOwnProperty('security.syscalls.intercept.mount.fuse')) { $("#securitySyscallsInterceptMountFuse").text(dataConfig['security.syscalls.intercept.mount.fuse']); } else { $("#securitySyscallsInterceptMountFuse").text(""); }
          if (dataConfig.hasOwnProperty('security.syscalls.intercept.mount.shift')) { $("#securitySyscallsInterceptMountShift").text(dataConfig['security.syscalls.intercept.mount.shift']); } else { $("#securitySyscallsInterceptMountShift").text(""); }
          if (dataConfig.hasOwnProperty('security.syscalls.intercept.setxattr')) { $("#securitySyscallsInterceptSetxattr").text(dataConfig['security.syscalls.intercept.setxattr']); } else { $("#securitySyscallsInterceptSetxattr").text(""); }

          if (dataConfig.hasOwnProperty('snapshots.schedule')) { $("#snapshotsSchedule").text(dataConfig['snapshots.schedule']); } else { $("#snapshotsSchedule").text(""); }
          if (dataConfig.hasOwnProperty('snapshots.schedule.stopped')) { $("#snapshotsScheduleStopped").text(dataConfig['snapshots.schedule.stopped']); } else { $("#snapshotsScheduleStopped").text(""); }
          if (dataConfig.hasOwnProperty('snapshots.pattern')) { $("#snapshotsPattern").text(dataConfig['snapshots.pattern']); } else { $("#snapshotsPattern").text(""); }
          if (dataConfig.hasOwnProperty('snapshots.expiry')) { $("#snapshotsExpiry").text(dataConfig['snapshots.expiry']); } else { $("#snapshotsExpiry").text(""); }
          
        });
        break;

      case "#nav-snapshots":
        $('#snapshotTableList').DataTable().ajax.reload(null, false);
        break;

      case "#nav-profiles":
        $('#profileTableList').DataTable().ajax.reload(null, false);
        break;

      case "#nav-interfaces":
        $('#interfaceTableList').DataTable().ajax.reload(null, false);
        break;

      case "#nav-network-devices":
        $('#networkDeviceTableList').DataTable().ajax.reload(null, false);
        break;

      case "#nav-disk-devices":
        $('#diskDeviceTableList').DataTable().ajax.reload(null, false);
        break;

      case "#nav-gpu-devices":
        $('#gpuDeviceTableList').DataTable().ajax.reload(null, false);
        break;

      case "#nav-proxy-devices":
        $('#proxyDeviceTableList').DataTable().ajax.reload(null, false);
        break;

      case "#nav-unix-devices":
        $('#unixDeviceTableList').DataTable().ajax.reload(null, false);
        break;

      case "#nav-usb-devices":
        $('#usbDeviceTableList').DataTable().ajax.reload(null, false);
        break;

      case "#nav-backups":
        $('#backupTableList').DataTable().ajax.reload(null, false);
        break;

      case "#nav-logs":
        $('#logTableList').DataTable().ajax.reload(null, false);
        break;

      case "#nav-console":
        // code block
        break;

      case "#nav-exec":
        // code block
        break;

      default:
        // code block
    } 

    //Set reload page content
    pageReloadTimeout = setTimeout(() => { reloadPageContent(); }, reloadTime);

  }

  function loadPageContent(){

    //Display current logged in username
    $("#username").load("./backend/admin/settings.php?action=displayUsername");

    //Display instance menu options based on state
    $.get("./backend/lxd/containers-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&action=retrieveInstanceState", displayMenuOptions)
    
    //Load Instance Information Cards
    $.get("./backend/lxd/containers-single.php?instance=" + encodeURI(instanceName) + "&remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayInstanceInfo", function (data) {
      data = JSON.parse(data);
      data = data.metadata;
      dataConfig = data.config;

      $("#name").text(data.name);
      if (data.hasOwnProperty('description')) { $("#description").text(data.description); }
      if (data.hasOwnProperty('type')) { $("#type").text(data.type); }
      $("#status").text(data.status);
      if (dataConfig.hasOwnProperty('image.description')) { $("#image").text(dataConfig["image.description"]); }
      $("#location").text(data.location);
      $("#created").text(data.created_at);

      if (dataConfig.hasOwnProperty('linux.kernel_modules')) { $("#linuxKernelModules").text(dataConfig['linux.kernel_modules']); }

      if (dataConfig.hasOwnProperty('boot.autostart')) { $("#bootAutostart").text(dataConfig['boot.autostart']); }
      if (dataConfig.hasOwnProperty('boot.autostart.delay')) { $("#bootAutostartDelay").text(dataConfig['boot.autostart.delay']); }
      if (dataConfig.hasOwnProperty('boot.autostart.priority')) { $("#bootAutostartPriority").text(dataConfig['boot.autostart.priority']); }
      if (dataConfig.hasOwnProperty('boot.host_shutdown_timeout')) { $("#bootHostShutdownTimeout").text(dataConfig['boot.host_shutdown_timeout']); }
      if (dataConfig.hasOwnProperty('boot.stop.priority')) { $("#bootStopPriority").text(dataConfig['boot.stop.priority']); }

      if (dataConfig.hasOwnProperty('limits.cpu')) { $("#limitsCpu").text(dataConfig['limits.cpu']); }
      if (dataConfig.hasOwnProperty('limits.cpu.allowance')) { $("#limitsCpuAllowance").text(dataConfig['limits.cpu.allowance']); }
      if (dataConfig.hasOwnProperty('limits.cpu.priority')) { $("#limitsCpuPriority").text(dataConfig['limits.cpu.priority']); }
      if (dataConfig.hasOwnProperty('limits.disk.priority')) { $("#limitsDiskPriority").text(dataConfig['limits.disk.priority']); }
      if (dataConfig.hasOwnProperty('limits.hugepages.64KB')) { $("#limitsHugepages64KB").text(dataConfig['limits.hugepages.64KB']); }
      if (dataConfig.hasOwnProperty('limits.hugepages.1MB')) { $("#limitsHugepages1MB").text(dataConfig['limits.hugepages.1MB']); }
      if (dataConfig.hasOwnProperty('limits.hugepages.2MB')) { $("#limitsHugepages2MB").text(dataConfig['limits.hugepages.2MB']); }
      if (dataConfig.hasOwnProperty('limits.hugepages.1GB')) { $("#limitsHugepages1GB").text(dataConfig['limits.hugepages.1GB']); }
      if (dataConfig.hasOwnProperty('limits.memory')) { $("#limitsMemory").text(dataConfig['limits.memory']); }
      if (dataConfig.hasOwnProperty('limits.memory.enforce')) { $("#limitsMemoryEnforce").text(dataConfig['limits.memory.enforce']); }
      if (dataConfig.hasOwnProperty('limits.memory.swap')) { $("#limitsMemorySwap").text(dataConfig['limits.memory.swap']); }
      if (dataConfig.hasOwnProperty('limits.memory.swap.priority')) { $("#limitsMemorySwapPriority").text(dataConfig['limits.memory.swap.priority']); }
      if (dataConfig.hasOwnProperty('limits.network.priority')) { $("#limitsNetworkPriority").text(dataConfig['limits.network.priority']); }
      if (dataConfig.hasOwnProperty('limits.processes')) { $("#limitsProcesses").text(dataConfig['limits.processes']); }

      if (dataConfig.hasOwnProperty('cluster.evacuate')) { $("#clusterEvacuate").text(dataConfig['cluster.evacuate']); }
      if (dataConfig.hasOwnProperty('migration.incremental.memory')) { $("#migrationIncrementalMemory").text(dataConfig['migration.incremental.memory']); }
      if (dataConfig.hasOwnProperty('migration.incremental.memory.goal')) { $("#migrationIncrementalMemoryGoal").text(dataConfig['migration.incremental.memory.goal']); }
      if (dataConfig.hasOwnProperty('migration.incremental.memory.iterations')) { $("#migrationIncrementalMemoryIterations").text(dataConfig['migration.incremental.memory.iterations']); }

      if (dataConfig.hasOwnProperty('nvidia.driver.capabilities')) { $("#nvidiaDriverCapabilities").text(dataConfig['nvidia.driver.capabilities']); }
      if (dataConfig.hasOwnProperty('nvidia.runtime')) { $("#nvidiaRuntime").text(dataConfig['nvidia.runtime']); }
      if (dataConfig.hasOwnProperty('nvidia.require.cuda')) { $("#nvidiaRequireCuda").text(dataConfig['nvidia.require.cuda']); }
      if (dataConfig.hasOwnProperty('nvidia.require.driver')) { $("#nvidiaRequireDriver").text(dataConfig['nvidia.require.driver']); }

      if (dataConfig.hasOwnProperty('raw.apparmor')) { $("#rawApparmor").text(dataConfig['raw.apparmor']); }
      if (dataConfig.hasOwnProperty('raw.idmap')) { $("#rawIdmap").text(dataConfig['raw.idmap']); }
      if (dataConfig.hasOwnProperty('raw.lxc')) { $("#rawLxc").text(dataConfig['raw.lxc']); }
      if (dataConfig.hasOwnProperty('raw.seccomp')) { $("#rawSeccomp").text(dataConfig['raw.seccomp']); }

      if (dataConfig.hasOwnProperty('security.devlxd')) { $("#securityDevLxd").text(dataConfig['security.devlxd']); }
      if (dataConfig.hasOwnProperty('security.devlxd.images')) { $("#securityDevLxdImages").text(dataConfig['security.devlxd.images']); }
      if (dataConfig.hasOwnProperty('security.idmap.base')) { $("#securityIdmapBase").text(dataConfig['security.idmap.base']); }
      if (dataConfig.hasOwnProperty('security.idmap.isolated')) { $("#securityIdmapIsolated").text(dataConfig['security.idmap.isolated']); }
      if (dataConfig.hasOwnProperty('security.idmap.size')) { $("#securityIdmapSize").text(dataConfig['security.idmap.size']); }
      if (dataConfig.hasOwnProperty('security.nesting')) { $("#securityNesting").text(dataConfig['security.nesting']); }
      if (dataConfig.hasOwnProperty('security.privileged')) { $("#securityPrivileged").text(dataConfig['security.privileged']); }
      if (dataConfig.hasOwnProperty('security.protection.delete')) { $("#securityProtectionDelete").text(dataConfig['security.protection.delete']); }
      if (dataConfig.hasOwnProperty('security.protection.shift')) { $("#securityProtectionShift").text(dataConfig['security.protection.shift']); }
      if (dataConfig.hasOwnProperty('security.syscalls.allow')) { $("#securitySyscallsAllow").text(dataConfig['security.syscalls.allow']); }
      if (dataConfig.hasOwnProperty('security.syscalls.deny')) { $("#securitySyscallsDeny").text(dataConfig['security.syscalls.deny']); }
      if (dataConfig.hasOwnProperty('security.syscalls.deny_compat')) { $("#securitySyscallsDenyCompat").text(dataConfig['security.syscalls.deny_compat']); }
      if (dataConfig.hasOwnProperty('security.syscalls.deny_default')) { $("#securitySyscallsDenyDefault").text(dataConfig['security.syscalls.deny_default']); }
      if (dataConfig.hasOwnProperty('security.syscalls.intercept.bpf')) { $("#securitySyscallsInterceptBpf").text(dataConfig['security.syscalls.intercept.bpf']); }
      if (dataConfig.hasOwnProperty('security.syscalls.intercept.bpf.devices')) { $("#securitySyscallsInterceptBpfDevices").text(dataConfig['security.syscalls.intercept.bpf.devices']); }
      if (dataConfig.hasOwnProperty('security.syscalls.intercept.mknod')) { $("#securitySyscallsInterceptMknod").text(dataConfig['security.syscalls.intercept.mknod']); }
      if (dataConfig.hasOwnProperty('security.syscalls.intercept.mount')) { $("#securitySyscallsInterceptMount").text(dataConfig['security.syscalls.intercept.mount']); }
      if (dataConfig.hasOwnProperty('security.syscalls.intercept.mount.allowed')) { $("#securitySyscallsInterceptMountAllowed").text(dataConfig['security.syscalls.intercept.mount.allowed']); }
      if (dataConfig.hasOwnProperty('security.syscalls.intercept.mount.fuse')) { $("#securitySyscallsInterceptMountFuse").text(dataConfig['security.syscalls.intercept.mount.fuse']); }
      if (dataConfig.hasOwnProperty('security.syscalls.intercept.mount.shift')) { $("#securitySyscallsInterceptMountShift").text(dataConfig['security.syscalls.intercept.mount.shift']); }
      if (dataConfig.hasOwnProperty('security.syscalls.intercept.setxattr')) { $("#securitySyscallsInterceptSetxattr").text(dataConfig['security.syscalls.intercept.setxattr']); }

      if (dataConfig.hasOwnProperty('snapshots.schedule')) { $("#snapshotsSchedule").text(dataConfig['snapshots.schedule']); }
      if (dataConfig.hasOwnProperty('snapshots.schedule.stopped')) { $("#snapshotsScheduleStopped").text(dataConfig['snapshots.schedule.stopped']); }
      if (dataConfig.hasOwnProperty('snapshots.pattern')) { $("#snapshotsPattern").text(dataConfig['snapshots.pattern']); }
      if (dataConfig.hasOwnProperty('snapshots.expiry')) { $("#snapshotsExpiry").text(dataConfig['snapshots.expiry']); }
        
      //Load Instance Progress Gauges
      if (data.status == "Running"){
        $.get("./backend/lxd/containers-single.php?instance=" + encodeURI(instanceName) + "&remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=retrieveGaugeStats", function (data) {
          data = JSON.parse(data);
          $("#cpuPercentage").text(data[0]);
          $("#cpuPercentageGauge").attr('data-value',data[0]);
          $("#memoryPercentage").text(data[1]);
          $("#memoryPercentageGauge").attr('data-value',data[1]);
          formatProgressGauge();
        });
      }
      else {
        $("#cpuPercentage").text("0.0");
        $("#cpuPercentageGauge").attr('data-value',"0.0");
        $("#memoryPercentage").text("0.0");
        $("#memoryPercentageGauge").attr('data-value',"0.0");
        formatProgressGauge();
      }

    });
    
     //Load Instance State Information for Card
    $.get("./backend/lxd/containers-single.php?instance=" + encodeURI(instanceName) + "&remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=displayInstanceStateInfo", function (data) {
        data = JSON.parse(data);
        $("#memory").text(data.memory)
        $("#swap").text(data.swap)
        $("#pid").text(data.pid)
        $("#processes").text(data.processes)
        $("#ipv4Addresses").text(data.ipv4Addresses)
        $("#ipv6Addresses").text(data.ipv6Addresses)
    });
    
    //Check for any running operations
    operationTimeout = setTimeout(() => { operationStatusCheck(); }, 1000);

    //Set reload page content
    $.get("./backend/admin/settings.php?action=retrievePageRefreshRateValues", function (data) {
      operationData = JSON.parse(data);
      if (operationData.containers_single_page_rate >= 1)
        reloadTime = operationData.containers_single_page_rate * 1000;
      pageReloadTimeout = setTimeout(() => { reloadPageContent(); }, reloadTime);
    });

  }

  function loadTabContent(loadTab){
    //Load based on which tab is active
    switch(loadTab) {

      case "#nav-snapshots":
        if ( ! $.fn.DataTable.isDataTable( '#snapshotTableList' ) ) {
          //Load Snapshots Table
          $('#snapshotTableList').DataTable( {
            ajax: "./backend/lxd/containers-single.php?instance=" + encodeURI(instanceName) + "&remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listInstanceSnapshots",
            columns: [
              {},
              { title: "Name" },
              { title: "Stateful/Stateless" },
              { title: "Size" },
              { title: "Created" },
              { title: "Expires" },
              { title: "Actions" }
            ],
            order: [],
            columnDefs: [
              { targets: 0, orderable: false, width: "25px" }
            ]
          });
        }
        break;

      case "#nav-profiles":
        if ( ! $.fn.DataTable.isDataTable( '#profileTableList' ) ) {
          //Load Profiles Table
          $('#profileTableList').DataTable( {
            ajax: "./backend/lxd/containers-single.php?instance=" + encodeURI(instanceName) + "&remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listInstanceProfiles",
            columns: [
              {},
              { title: "Name" },
              { title: "Description" },
              { title: "Actions" }
            ],
            order: [],
            columnDefs: [
              { targets: 0, orderable: false, width: "25px" }
            ]
          });
        }
        break;

      case "#nav-interfaces":
        if ( ! $.fn.DataTable.isDataTable( '#interfaceTableList' ) ) {
          //Load Interfaces Table
          $('#interfaceTableList').DataTable( {
            ajax: "./backend/lxd/containers-single.php?instance=" + encodeURI(instanceName) + "&remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listInstanceInterfaces",
            columns: [
              {},
              { title: "Name" },
              { title: "HW Address" },
              { title: "IPv4" },
              { title: "IPv6" },
              { title: "State" }
            ],
            order: [],
            columnDefs: [
              { targets: 0, orderable: false, width: "25px" }
            ]
          });
        }
        break;

      case "#nav-network-devices":
        if ( ! $.fn.DataTable.isDataTable( '#networkDeviceTableList' ) ) {
          //Load Network Devices Table
          $('#networkDeviceTableList').DataTable( {
            ajax: "./backend/lxd/containers-single.php?instance=" + encodeURI(instanceName) + "&remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listInstanceNetworkDevices",
            columns: [
              {},
              { title: "Name" },
              { title: "Type" },
              { title: "Parent" },
              { title: "Network" },
              { title: "Interface Name" },
              { title: "Action" }
            ],
            order: [],
            columnDefs: [
              { targets: 0, orderable: false, width: "25px" }
            ]
          });
        }
        break;

      case "#nav-disk-devices":
        if ( ! $.fn.DataTable.isDataTable( '#diskDeviceTableList' ) ) {
          //Load Disk Devices Table
          $('#diskDeviceTableList').DataTable( {
            ajax: "./backend/lxd/containers-single.php?instance=" + encodeURI(instanceName) + "&remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listInstanceDiskDevices",
            columns: [
              {},
              { title: "Name" },
              { title: "Path" },
              { title: "Usage" },
              { title: "Type" },
              { title: "Action" }
            ],
            order: [],
            columnDefs: [
              { targets: 0, orderable: false, width: "25px" }
            ]
          });
        }
        break;

      case "#nav-gpu-devices":
        if ( ! $.fn.DataTable.isDataTable( '#gpuDeviceTableList' ) ) {
          //Load GPU Devices Table
          $('#gpuDeviceTableList').DataTable( {
            ajax: "./backend/lxd/containers-single.php?instance=" + encodeURI(instanceName) + "&remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listInstanceGPUDevices",
            columns: [
              {},
              { title: "Name" },
              { title: "Vendor" },
              { title: "Product" },
              { title: "ID" },
              { title: "PCI" },
              { title: "Type" },
              { title: "Action" }
            ],
            order: [],
            columnDefs: [
              { targets: 0, orderable: false, width: "25px" }
            ]
          });
        }
        break;

      case "#nav-proxy-devices":
        if ( ! $.fn.DataTable.isDataTable( '#proxyDeviceTableList' ) ) {
          //Load Proxy Devices Table
          $('#proxyDeviceTableList').DataTable( {
            ajax: "./backend/lxd/containers-single.php?instance=" + encodeURI(instanceName) + "&remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listInstanceProxyDevices",
            columns: [
              {},
              { title: "Name" },
              { title: "Connect" },
              { title: "Listen" },
              { title: "Type" },
              { title: "Action" }
            ],
            order: [],
            columnDefs: [
              { targets: 0, orderable: false, width: "25px" }
            ]
          });
        }
        break;

      case "#nav-unix-devices":
        if ( ! $.fn.DataTable.isDataTable( '#unixDeviceTableList' ) ) {
          //Load Unix Devices Table
          $('#unixDeviceTableList').DataTable( {
            ajax: "./backend/lxd/containers-single.php?instance=" + encodeURI(instanceName) + "&remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listInstanceUnixDevices",
            columns: [
              {},
              { title: "Name" },
              { title: "Source" },
              { title: "Path" },
              { title: "Mode" },
              { title: "Required" },
              { title: "Type" },
              { title: "Action" }
            ],
            order: [],
            columnDefs: [
              { targets: 0, orderable: false, width: "25px" }
            ]
          });
        }
        break;

      case "#nav-usb-devices":
        if ( ! $.fn.DataTable.isDataTable( '#usbDeviceTableList' ) ) {
          //Load USB Devices Table
          $('#usbDeviceTableList').DataTable( {
            ajax: "./backend/lxd/containers-single.php?instance=" + encodeURI(instanceName) + "&remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listInstanceUSBDevices",
            columns: [
              {},
              { title: "Name" },
              { title: "Vendor" },
              { title: "Product" },
              { title: "Mode" },
              { title: "Required" },
              { title: "Type" },
              { title: "Action" }
            ],
            order: [],
            columnDefs: [
              { targets: 0, orderable: false, width: "25px" }
            ]
          });
        }
        break;

      case "#nav-backups":
        if ( ! $.fn.DataTable.isDataTable( '#backupTableList' ) ) {
          //Load Backups Table
          $('#backupTableList').DataTable( {
            ajax: "./backend/lxd/containers-single.php?instance=" + encodeURI(instanceName) + "&remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listInstanceBackups",
            columns: [
              {},
              { title: "Name" },
              { title: "Created" },
              { title: "Expires" },
              { title: "Instance Only" },
              { title: "Optimized Storage" },
              { title: "File Size" },
              { title: "Actions" }
            ],
            order: [],
            columnDefs: [
              { targets: 0, orderable: false, width: "25px" }
            ]
          });
        }
        break;

      case "#nav-logs":
        if ( ! $.fn.DataTable.isDataTable( '#logTableList' ) ) {
          //Load Logs Table
          $('#logTableList').DataTable( {
            ajax: "./backend/lxd/containers-single.php?instance=" + encodeURI(instanceName) + "&remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listInstanceLogs",
            columns: [
              {},
              { title: "Name" },
              { title: "Actions" }
            ],
            order: [],
            columnDefs: [
              { targets: 0, orderable: false, width: "25px" }
            ]
          });
        }
        break;

      default:
        // code block
      }

    pageReloadTimeout = setTimeout(() => { reloadPageContent(); }, 7000);

  }

  function startInstance(){
    console.log("Info: starting instance " + instanceName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&action=startInstance",  function (data) {
      //Async operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      operationStatusCheck();
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function stopInstance(){
    console.log("Info: stopping instance " + instanceName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&action=stopInstance",  function (data) {
      //Async operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      operationStatusCheck();
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function stopInstanceForcefully(){
    console.log("Info: forcefully stopping instance " + instanceName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&action=stopInstanceForcefully",  function (data) {
      //Async operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      operationStatusCheck();
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function restartInstance(){
    console.log("Info: restarting instance " + instanceName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&action=restartInstance",  function (data) {
      //Async operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      operationStatusCheck();
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function freezeInstance(){
    console.log("Info: freezing instance " + instanceName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&action=freezeInstance",  function (data) {
      //Async operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      operationStatusCheck();
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function unfreezeInstance(){
    console.log("Info: unfreezing instance " + instanceName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&action=unfreezeInstance",  function (data) {
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.status_code == 100 && operationData.metadata.status_code < 400){
        operationStatusCheck();
      }
      if (operationData.metadata.status_code >= 400){
        alert(operationData.metadata.err);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function snapshotInstance(){
    var snapshotName = $("#snapshotName").val();
    var snapshotStateful = $("#snapshotStateful").val();
    console.log("Info: creating snapshot " + snapshotName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&name=" + encodeURI(snapshotName) + "&stateful=" + encodeURI(snapshotStateful) + "&action=snapshotInstance", function (data) {
      //Async operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      operationStatusCheck();
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function renameInstance(){
    var newInstanceName = $("#newInstanceName").val();
    console.log("Info: renaming instance " + instanceName + " to " + newInstanceName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&name=" + encodeURI(newInstanceName) + "&action=renameInstance", function (data) {
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.status_code == 100 && operationData.metadata.status_code < 400){
        operationStatusCheck();
        redirectURL = "containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(newInstanceName);
        window.location.replace(redirectURL);
      }
      if (operationData.metadata.status_code >= 400){
        alert(operationData.metadata.err);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function copyInstance(){
    var copyName = $("#copyName").val();
    console.log("Info: copying instance " + instanceName + " to " + copyName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&name=" + encodeURI(copyName) + "&action=copyInstance", function (data) {
      //Async operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      operationStatusCheck();
    });
  }

  function loadCreateInstanceFromSnapshotModal(snap){
      $("#snapNameForSnapshotCreate").val(snap);
      $("#createInstanceFromSnapshotModal").modal('show');
  }

  function loadPublishImageFromSnapshotModal(snap){
      $("#publishSnapshotHiddenName").val(snap);
      $("#publishImageFromSnapshotModal").modal('show');
  }

  function createInstanceFromSnapshot(){
    var copyName = $("#instanceNameForSnapshotCreate").val();
    var snapName = $("#snapNameForSnapshotCreate").val();
    console.log("Info: creating instance " + copyName + " from snapshot " + instanceName + "/" + snapName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&snapshot=" + encodeURI(snapName) + "&name=" + encodeURI(copyName) + "&action=createInstanceFromSnapshot", function (data) {
      //Async operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      operationStatusCheck();
    });
  }

  function publishImageFromSnapshot(){
    var description = $("#publishSnapshotDescriptionInput").val();
    var publicDownload = $("#publishSnapshotPublicInput").val();
    var os = $("#publishSnapshotOsInput").val();
    var release = $("#publishSnapshotReleaseInput").val();
    var snapName = $("#publishSnapshotHiddenName").val();
    var instanceSnapshotName = instanceName + "/" + snapName;
    console.log("Info: publishing image " + description + " from snapshot " + instanceSnapshotName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceSnapshotName) + "&description=" + encodeURI(description) + "&public=" + encodeURI(publicDownload) + "&os=" + encodeURI(os) + "&release=" + encodeURI(release) + "&action=publishInstanceSnapshot", function (data) {
      //Async operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      operationStatusCheck();
    });
  }

  function migrateInstance(){
    var clusterInput = $("#selectClusterInput").val();
    console.log("Info: migrating instance " + instanceName + " to " + clusterInput);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&location=" + encodeURI(clusterInput) + "&action=migrateInstance", function (data) {
      //Async operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      operationStatusCheck();
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function deleteInstance(){
    console.log("Info: deleting instance " + instanceName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&action=deleteInstance", function (data) {
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.status_code == 100 && operationData.metadata.status_code < 400){
        operationStatusCheck();
        redirectURL = "containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName)
        window.location.replace(redirectURL);
      }
      if (operationData.error_code == 404){
        redirectURL = "containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName)
        window.location.replace(redirectURL);
      }
      if (operationData.metadata.status_code >= 400){
        alert(operationData.metadata.err)
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function attachInstanceProfile(){
    var profileName = $("#selectProfileInput").val();
    console.log("Info: attaching profile " + profileName + " to instance " + instanceName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&name=" + encodeURI(profileName) + "&action=attachInstanceProfile", function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function detachInstanceProfile(profileName){
    console.log("Info: detaching profile " + profileName + " from instance " + instanceName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&name=" + encodeURI(profileName) + "&action=detachInstanceProfile", function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function restoreInstanceSnapshot(snapshotName){
    console.log("Info: restoring snapshot " + snapshotName + " to instance " + instanceName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&name=" + encodeURI(snapshotName) + "&action=restoreInstanceSnapshot", function (data) {
      //Async operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      operationStatusCheck();
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function deleteInstanceSnapshot(snapshotName){
    console.log("Info: deleting snapshot " + snapshotName + " from instance " + instanceName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&name=" + encodeURI(snapshotName) + "&action=deleteInstanceSnapshot", function (data) {
      //Async operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      operationStatusCheck();
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }
  
  function publishInstance(){
    var description = $("#publishInstanceDescriptionInput").val();
    var publicDownload = $("#publishInstancePublicInput").val();
    var os = $("#publishInstanceOsInput").val();
    var release = $("#publishInstanceReleaseInput").val();
    console.log("Info: publishing image " + description + " from instance " + instanceName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&description=" + encodeURI(description) + "&public=" + encodeURI(publicDownload) + "&os=" + encodeURI(os) + "&release=" + encodeURI(release) + "&action=publishInstance", function (data) {
      //Async operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      operationStatusCheck();
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function loadInstanceLog(logPath){
    console.log("Info: loading log " + logPath);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&path=" + encodeURI(logPath) + "&action=loadInstanceLog", function (data) {
      $("#logNameInput").text(logPath);
      $("#logDataInput").val(data);
      $("#loadLogModal").modal('show');
    });
  }

  function deleteInstanceLog(logPath){
    console.log("Info: deleting log " + logPath);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&path=" + encodeURI(logPath) + "&action=deleteInstanceLog", function (data) {
      //Async operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      operationStatusCheck();
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function initializeCreateBackup(){

    var now = new Date();
    var year = now.getFullYear();
    var month = now.getMonth() + 1;
    
    var day = now.getDate();
    var hour = now.getHours();
    var min = now.getMinutes();
    var sec = now.getSeconds();

    if (month < 10) 
      month = '0' + month;
    if (day < 10) 
      day = '0' + day;
    if (hour < 10) 
      hour = '0' + hour;
    if (min < 10) 
      min = '0' + min;
    if (sec < 10) 
      sec = '0' + sec;

    var backupName = instanceName + "-" + year + month + day + hour + min + sec;
    $("#backupName").val(backupName);
    $("#backupInstanceModal").modal('show');
  }

  function createBackup(){
    var backupName = $("#backupName").val();
    var backupInstanceOnly = $("#backupInstanceOnly").val();
    var backupOptimizedStorage = $("#backupOptimizedStorage").val();
    var backupCompressionAlgorithm = $("#backupCompressionAlgorithm").val();
    console.log("Info: backing up instance " + instanceName + " to " + backupName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&name=" + encodeURI(backupName) + "&instance_only=" + encodeURI(backupInstanceOnly) + "&optimized_storage=" + encodeURI(backupOptimizedStorage) + "&compression_algorithm=" + encodeURI(backupCompressionAlgorithm) + "&action=createInstanceBackup", function (data) {
      //Async operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      operationStatusCheck();
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function exportInstanceBackup(backupName){
    console.log("Info: exporting backup " + backupName + " from instance " + instanceName + " to a file");
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&name=" + encodeURI(backupName) + "&action=exportInstanceBackup", function (data) {
      reloadPageContent();
    });
  }

  function deleteInstanceBackup(backupName){
    console.log("Info: deleting backup " + backupName + " from instance " + instanceName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&name=" + encodeURI(backupName) + "&action=deleteInstanceBackup", function (data) {
      //Async operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      operationStatusCheck();
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function loadAddDiskDeviceModal(){
    console.log("Info: loading disk device modal");
    $("#diskPoolInput").load("./backend/lxd/storage-pools.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listStoragePoolsForSelectOption");
    $("#addDiskDeviceModal").modal('show');
  }

  function loadAddNetworkDeviceModal(){
    console.log("Info: loading network device modal");
    $("#networkParentInput").load("./backend/lxd/networks.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listNetworksForSelectOption");
    changeParentTypeInput();
    $("#addNetworkDeviceModal").modal('show');
  }

  function changeStorageVolumeInput(){
    var diskPoolInput = $("#diskPoolInput").val();
    if (diskPoolInput == ""){
      $("#diskSourceInput").show()
      $("#diskSourceSelectInput").hide()
    }
    else{
      //show and populate select field
      $("#diskSourceSelectInput").load("./backend/lxd/storage-volumes.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&pool=" + encodeURI(diskPoolInput) + "&action=listStorageVolumesForSelectOption");
      $("#diskSourceInput").hide()
      $("#diskSourceSelectInput").show()
    }
    
  }

  function changePropertySetInput(){
    var networkPropertySetInput = $("#networkPropertySetInput").val()
    if (networkPropertySetInput == "network"){
      $("#networkNetworkRow").show();
      $("#networkParentTypeRow").show();
      $("#networkNicTypeRow").hide();
      $("#networkParentTypeInput").val('bridge');
      changeParentTypeInput();
    }
    if (networkPropertySetInput == "nictype"){
      $("#networkNetworkRow").hide();
      $("#networkParentTypeRow").hide();
      $("#networkNicTypeRow").show();
      changeNicTypeInput();
    }
  }

  function changeParentTypeInput(){
    var networkParentTypeInput = $("#networkParentTypeInput").val();
    $("#networkNetworkInput").load("./backend/lxd/networks.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&type=" + encodeURI(networkParentTypeInput) + "&managed_only=true" + "&action=listNetworksForSelectOption");
    if (networkParentTypeInput == "bridge"){
      $("#networkParentRow").hide()
      $("#networkNetworkRow").show()
      $("#networkInterfaceNameRow").show()
      $("#networkMtuRow").hide()
      $("#networkHwaddrRow").show()
      $("#networkHostNameRow").show()
      $("#networkLimitsIngressRow").show()
      $("#networkLimitsEgressRow").show()
      $("#networkLimitsMaxRow").show()
      $("#networkIpv4AddressRow").show()
      $("#networkIpv6AddressRow").show()
      $("#networkIpv4RoutesRow").show()
      $("#networkIpv6RoutesRow").show()
      $("#networkSecurityMacFilteringRow").show()
      $("#networkSecurityIpv4FilteringRow").show()
      $("#networkSecurityIpv6FilteringRow").show()
      $("#networkMaasSubnetIpv4Row").hide()
      $("#networkMaasSubnetIpv6Row").hide()
      $("#networkBootPriorityRow").show()
      $("#networkVlanRow").show()
      $("#networkVlanTaggedRow").show()
      $("#networkSecurityPortIsolationRow").show()
      $("#networkGvrpRow").hide()
      $("#networkModeRow").hide()
      $("#networkIpv4GatewayRow").hide()
      $("#networkIpv4HostTableRow").hide()
      $("#networkIpv6GatewayRow").hide()
      $("#networkIpv6HostTableRow").hide()
      $("#networkIpv4HostAddressRow").hide()
      $("#networkIpv6HostAddressRow").hide()
      $("#networkIpv4RoutesExternalRow").hide()
      $("#networkIpv6RoutesExternalRow").hide()
      $("#networkSecurityAclsRow").hide()
      $("#networkSecurityAclsDefaultIngressActionRow").hide()
      $("#networkSecurityAclsDefaultEgressActionRow").hide()
      $("#networkSecurityAclsDefaultIngressLoggedRow").hide()
      $("#networkSecurityAclsDefaultEgressLoggedRow").hide()
    }
    if (networkParentTypeInput == "macvlan"){
      $("#networkParentRow").hide()
      $("#networkNetworkRow").show()
      $("#networkInterfaceNameRow").show()
      $("#networkMtuRow").hide()
      $("#networkHwaddrRow").show()
      $("#networkHostNameRow").hide()
      $("#networkLimitsIngressRow").hide()
      $("#networkLimitsEgressRow").hide()
      $("#networkLimitsMaxRow").hide()
      $("#networkIpv4AddressRow").hide()
      $("#networkIpv6AddressRow").hide()
      $("#networkIpv4RoutesRow").hide()
      $("#networkIpv6RoutesRow").hide()
      $("#networkSecurityMacFilteringRow").hide()
      $("#networkSecurityIpv4FilteringRow").hide()
      $("#networkSecurityIpv6FilteringRow").hide()
      $("#networkMaasSubnetIpv4Row").hide()
      $("#networkMaasSubnetIpv6Row").hide()
      $("#networkBootPriorityRow").show()
      $("#networkVlanRow").show()
      $("#networkVlanTaggedRow").hide()
      $("#networkSecurityPortIsolationRow").hide()
      $("#networkGvrpRow").show()
      $("#networkModeRow").hide()
      $("#networkIpv4GatewayRow").hide()
      $("#networkIpv4HostTableRow").hide()
      $("#networkIpv6GatewayRow").hide()
      $("#networkIpv6HostTableRow").hide()
      $("#networkIpv4HostAddressRow").hide()
      $("#networkIpv6HostAddressRow").hide()
      $("#networkIpv4RoutesExternalRow").hide()
      $("#networkIpv6RoutesExternalRow").hide()
      $("#networkSecurityAclsRow").hide()
      $("#networkSecurityAclsDefaultIngressActionRow").hide()
      $("#networkSecurityAclsDefaultEgressActionRow").hide()
      $("#networkSecurityAclsDefaultIngressLoggedRow").hide()
      $("#networkSecurityAclsDefaultEgressLoggedRow").hide()
    }
    if (networkParentTypeInput == "ovn"){
      $("#networkParentRow").hide()
      $("#networkNetworkRow").show()
      $("#networkInterfaceNameRow").show()
      $("#networkMtuRow").hide()
      $("#networkHwaddrRow").show()
      $("#networkHostNameRow").show()
      $("#networkLimitsIngressRow").hide()
      $("#networkLimitsEgressRow").hide()
      $("#networkLimitsMaxRow").hide()
      $("#networkIpv4AddressRow").show()
      $("#networkIpv6AddressRow").show()
      $("#networkIpv4RoutesRow").show()
      $("#networkIpv6RoutesRow").show()
      $("#networkSecurityMacFilteringRow").hide()
      $("#networkSecurityIpv4FilteringRow").hide()
      $("#networkSecurityIpv6FilteringRow").hide()
      $("#networkMaasSubnetIpv4Row").hide()
      $("#networkMaasSubnetIpv6Row").hide()
      $("#networkBootPriorityRow").show()
      $("#networkVlanRow").hide()
      $("#networkVlanTaggedRow").hide()
      $("#networkSecurityPortIsolationRow").hide()
      $("#networkGvrpRow").hide()
      $("#networkModeRow").hide()
      $("#networkIpv4GatewayRow").hide()
      $("#networkIpv4HostTableRow").hide()
      $("#networkIpv6GatewayRow").hide()
      $("#networkIpv6HostTableRow").hide()
      $("#networkIpv4HostAddressRow").hide()
      $("#networkIpv6HostAddressRow").hide()

      $("#networkIpv4RoutesExternalRow").show()
      $("#networkIpv6RoutesExternalRow").show()
      $("#networkSecurityAclsRow").show()
      $("#networkSecurityAclsDefaultIngressActionRow").show()
      $("#networkSecurityAclsDefaultEgressActionRow").show()
      $("#networkSecurityAclsDefaultIngressLoggedRow").show()
      $("#networkSecurityAclsDefaultEgressLoggedRow").show()
    }
    if (networkParentTypeInput == "sriov"){
      $("#networkParentRow").hide()
      $("#networkNetworkRow").show()
      $("#networkInterfaceNameRow").show()
      $("#networkMtuRow").hide()
      $("#networkHwaddrRow").show()
      $("#networkHostNameRow").hide()
      $("#networkLimitsIngressRow").hide()
      $("#networkLimitsEgressRow").hide()
      $("#networkLimitsMaxRow").hide()
      $("#networkIpv4AddressRow").hide()
      $("#networkIpv6AddressRow").hide()
      $("#networkIpv4RoutesRow").hide()
      $("#networkIpv6RoutesRow").hide()
      $("#networkSecurityMacFilteringRow").show()
      $("#networkSecurityIpv4FilteringRow").hide()
      $("#networkSecurityIpv6FilteringRow").hide()
      $("#networkMaasSubnetIpv4Row").hide()
      $("#networkMaasSubnetIpv6Row").hide()
      $("#networkBootPriorityRow").show()
      $("#networkVlanRow").show()
      $("#networkVlanTaggedRow").hide()
      $("#networkSecurityPortIsolationRow").hide()
      $("#networkGvrpRow").hide()
      $("#networkModeRow").hide()
      $("#networkIpv4GatewayRow").hide()
      $("#networkIpv4HostTableRow").hide()
      $("#networkIpv6GatewayRow").hide()
      $("#networkIpv6HostTableRow").hide()
      $("#networkIpv4HostAddressRow").hide()
      $("#networkIpv6HostAddressRow").hide()
      $("#networkIpv4RoutesExternalRow").hide()
      $("#networkIpv6RoutesExternalRow").hide()
      $("#networkSecurityAclsRow").hide()
      $("#networkSecurityAclsDefaultIngressActionRow").hide()
      $("#networkSecurityAclsDefaultEgressActionRow").hide()
      $("#networkSecurityAclsDefaultIngressLoggedRow").hide()
      $("#networkSecurityAclsDefaultEgressLoggedRow").hide()
    }
  }

  function changeNicTypeInput(){
    var networkNicTypeInput = $("#networkNicTypeInput").val();
    if (networkNicTypeInput == "bridged"){
      $("#networkParentRow").show()
      $("#networkNetworkRow").hide()
      $("#networkInterfaceNameRow").show()
      $("#networkMtuRow").show()
      $("#networkHwaddrRow").show()
      $("#networkHostNameRow").show()
      $("#networkLimitsIngressRow").show()
      $("#networkLimitsEgressRow").show()
      $("#networkLimitsMaxRow").show()
      $("#networkIpv4AddressRow").show()
      $("#networkIpv6AddressRow").show()
      $("#networkIpv4RoutesRow").show()
      $("#networkIpv6RoutesRow").show()
      $("#networkSecurityMacFilteringRow").show()
      $("#networkSecurityIpv4FilteringRow").show()
      $("#networkSecurityIpv6FilteringRow").show()
      $("#networkMaasSubnetIpv4Row").show()
      $("#networkMaasSubnetIpv6Row").show()
      $("#networkBootPriorityRow").show()
      $("#networkVlanRow").show()
      $("#networkVlanTaggedRow").show()
      $("#networkSecurityPortIsolationRow").show()
      $("#networkGvrpRow").hide()
      $("#networkModeRow").hide()
      $("#networkIpv4GatewayRow").hide()
      $("#networkIpv4HostTableRow").hide()
      $("#networkIpv6GatewayRow").hide()
      $("#networkIpv6HostTableRow").hide()
      $("#networkIpv4HostAddressRow").hide()
      $("#networkIpv6HostAddressRow").hide()
      $("#networkIpv4RoutesExternalRow").hide()
      $("#networkIpv6RoutesExternalRow").hide()
      $("#networkSecurityAclsRow").hide()
      $("#networkSecurityAclsDefaultIngressActionRow").hide()
      $("#networkSecurityAclsDefaultEgressActionRow").hide()
      $("#networkSecurityAclsDefaultIngressLoggedRow").hide()
      $("#networkSecurityAclsDefaultEgressLoggedRow").hide()
    }
    if (networkNicTypeInput == "macvlan"){
      $("#networkParentRow").show()
      $("#networkNetworkRow").hide()
      $("#networkInterfaceNameRow").show()
      $("#networkMtuRow").show()
      $("#networkHwaddrRow").show()
      $("#networkHostNameRow").hide()
      $("#networkLimitsIngressRow").hide()
      $("#networkLimitsEgressRow").hide()
      $("#networkLimitsMaxRow").hide()
      $("#networkIpv4AddressRow").hide()
      $("#networkIpv6AddressRow").hide()
      $("#networkIpv4RoutesRow").hide()
      $("#networkIpv6RoutesRow").hide()
      $("#networkSecurityMacFilteringRow").hide()
      $("#networkSecurityIpv4FilteringRow").hide()
      $("#networkSecurityIpv6FilteringRow").hide()
      $("#networkMaasSubnetIpv4Row").show()
      $("#networkMaasSubnetIpv6Row").show()
      $("#networkBootPriorityRow").show()
      $("#networkVlanRow").show()
      $("#networkVlanTaggedRow").hide()
      $("#networkSecurityPortIsolationRow").hide()
      $("#networkGvrpRow").show()
      $("#networkModeRow").hide()
      $("#networkIpv4GatewayRow").hide()
      $("#networkIpv4HostTableRow").hide()
      $("#networkIpv6GatewayRow").hide()
      $("#networkIpv6HostTableRow").hide()
      $("#networkIpv4HostAddressRow").hide()
      $("#networkIpv6HostAddressRow").hide()
      $("#networkIpv4RoutesExternalRow").hide()
      $("#networkIpv6RoutesExternalRow").hide()
      $("#networkSecurityAclsRow").hide()
      $("#networkSecurityAclsDefaultIngressActionRow").hide()
      $("#networkSecurityAclsDefaultEgressActionRow").hide()
      $("#networkSecurityAclsDefaultIngressLoggedRow").hide()
      $("#networkSecurityAclsDefaultEgressLoggedRow").hide()
    }
    if (networkNicTypeInput == "sriov"){
      $("#networkParentRow").show()
      $("#networkNetworkRow").hide()
      $("#networkInterfaceNameRow").show()
      $("#networkMtuRow").show()
      $("#networkHwaddrRow").show()
      $("#networkHostNameRow").hide()
      $("#networkLimitsIngressRow").hide()
      $("#networkLimitsEgressRow").hide()
      $("#networkLimitsMaxRow").hide()
      $("#networkIpv4AddressRow").hide()
      $("#networkIpv6AddressRow").hide()
      $("#networkIpv4RoutesRow").hide()
      $("#networkIpv6RoutesRow").hide()
      $("#networkSecurityMacFilteringRow").show()
      $("#networkSecurityIpv4FilteringRow").hide()
      $("#networkSecurityIpv6FilteringRow").hide()
      $("#networkMaasSubnetIpv4Row").show()
      $("#networkMaasSubnetIpv6Row").show()
      $("#networkBootPriorityRow").show()
      $("#networkVlanRow").show()
      $("#networkVlanTaggedRow").hide()
      $("#networkSecurityPortIsolationRow").hide()
      $("#networkGvrpRow").hide()
      $("#networkModeRow").hide()
      $("#networkIpv4GatewayRow").hide()
      $("#networkIpv4HostTableRow").hide()
      $("#networkIpv6GatewayRow").hide()
      $("#networkIpv6HostTableRow").hide()
      $("#networkIpv4HostAddressRow").hide()
      $("#networkIpv6HostAddressRow").hide()
      $("#networkIpv4RoutesExternalRow").hide()
      $("#networkIpv6RoutesExternalRow").hide()
      $("#networkSecurityAclsRow").hide()
      $("#networkSecurityAclsDefaultIngressActionRow").hide()
      $("#networkSecurityAclsDefaultEgressActionRow").hide()
      $("#networkSecurityAclsDefaultIngressLoggedRow").hide()
      $("#networkSecurityAclsDefaultEgressLoggedRow").hide()
    }
    if (networkNicTypeInput == "physical"){
      $("#networkParentRow").show()
      $("#networkNetworkRow").hide()
      $("#networkInterfaceNameRow").show()
      $("#networkMtuRow").show()
      $("#networkHwaddrRow").show()
      $("#networkHostNameRow").hide()
      $("#networkLimitsIngressRow").hide()
      $("#networkLimitsEgressRow").hide()
      $("#networkLimitsMaxRow").hide()
      $("#networkIpv4AddressRow").hide()
      $("#networkIpv6AddressRow").hide()
      $("#networkIpv4RoutesRow").hide()
      $("#networkIpv6RoutesRow").hide()
      $("#networkSecurityMacFilteringRow").hide()
      $("#networkSecurityIpv4FilteringRow").hide()
      $("#networkSecurityIpv6FilteringRow").hide()
      $("#networkMaasSubnetIpv4Row").show()
      $("#networkMaasSubnetIpv6Row").show()
      $("#networkBootPriorityRow").show()
      $("#networkVlanRow").show()
      $("#networkVlanTaggedRow").hide()
      $("#networkSecurityPortIsolationRow").hide()
      $("#networkGvrpRow").show()
      $("#networkModeRow").hide()
      $("#networkIpv4GatewayRow").hide()
      $("#networkIpv4HostTableRow").hide()
      $("#networkIpv6GatewayRow").hide()
      $("#networkIpv6HostTableRow").hide()
      $("#networkIpv4HostAddressRow").hide()
      $("#networkIpv6HostAddressRow").hide()
      $("#networkIpv4RoutesExternalRow").hide()
      $("#networkIpv6RoutesExternalRow").hide()
      $("#networkSecurityAclsRow").hide()
      $("#networkSecurityAclsDefaultIngressActionRow").hide()
      $("#networkSecurityAclsDefaultEgressActionRow").hide()
      $("#networkSecurityAclsDefaultIngressLoggedRow").hide()
      $("#networkSecurityAclsDefaultEgressLoggedRow").hide()
    }
    if (networkNicTypeInput == "ipvlan"){
      $("#networkParentRow").show()
      $("#networkNetworkRow").hide()
      $("#networkInterfaceNameRow").show()
      $("#networkMtuRow").show()
      $("#networkHwaddrRow").show()
      $("#networkHostNameRow").hide()
      $("#networkLimitsIngressRow").hide()
      $("#networkLimitsEgressRow").hide()
      $("#networkLimitsMaxRow").hide()
      $("#networkIpv4AddressRow").show()
      $("#networkIpv6AddressRow").show()
      $("#networkIpv4RoutesRow").hide()
      $("#networkIpv6RoutesRow").hide()
      $("#networkSecurityMacFilteringRow").hide()
      $("#networkSecurityIpv4FilteringRow").hide()
      $("#networkSecurityIpv6FilteringRow").hide()
      $("#networkMaasSubnetIpv4Row").hide()
      $("#networkMaasSubnetIpv6Row").hide()
      $("#networkBootPriorityRow").hide()
      $("#networkVlanRow").show()
      $("#networkVlanTaggedRow").hide()
      $("#networkSecurityPortIsolationRow").hide()
      $("#networkGvrpRow").show()
      $("#networkModeRow").show()
      $("#networkIpv4GatewayRow").show()
      $("#networkIpv4HostTableRow").show()
      $("#networkIpv6GatewayRow").show()
      $("#networkIpv6HostTableRow").show()
      $("#networkIpv4HostAddressRow").hide()
      $("#networkIpv6HostAddressRow").hide()
      $("#networkIpv4RoutesExternalRow").hide()
      $("#networkIpv6RoutesExternalRow").hide()
      $("#networkSecurityAclsRow").hide()
      $("#networkSecurityAclsDefaultIngressActionRow").hide()
      $("#networkSecurityAclsDefaultEgressActionRow").hide()
      $("#networkSecurityAclsDefaultIngressLoggedRow").hide()
      $("#networkSecurityAclsDefaultEgressLoggedRow").hide()
    }
    if (networkNicTypeInput == "p2p"){
      $("#networkParentRow").hide()
      $("#networkNetworkRow").hide()
      $("#networkInterfaceNameRow").show()
      $("#networkMtuRow").show()
      $("#networkHwaddrRow").show()
      $("#networkHostNameRow").show()
      $("#networkLimitsIngressRow").show()
      $("#networkLimitsEgressRow").show()
      $("#networkLimitsMaxRow").show()
      $("#networkIpv4AddressRow").hide()
      $("#networkIpv6AddressRow").hide()
      $("#networkIpv4RoutesRow").show()
      $("#networkIpv6RoutesRow").show()
      $("#networkSecurityMacFilteringRow").hide()
      $("#networkSecurityIpv4FilteringRow").hide()
      $("#networkSecurityIpv6FilteringRow").hide()
      $("#networkMaasSubnetIpv4Row").hide()
      $("#networkMaasSubnetIpv6Row").hide()
      $("#networkBootPriorityRow").show()
      $("#networkVlanRow").hide()
      $("#networkVlanTaggedRow").hide()
      $("#networkSecurityPortIsolationRow").hide()
      $("#networkGvrpRow").hide()
      $("#networkModeRow").hide()
      $("#networkIpv4GatewayRow").hide()
      $("#networkIpv4HostTableRow").hide()
      $("#networkIpv6GatewayRow").hide()
      $("#networkIpv6HostTableRow").hide()
      $("#networkIpv4HostAddressRow").hide()
      $("#networkIpv6HostAddressRow").hide()
      $("#networkIpv4RoutesExternalRow").hide()
      $("#networkIpv6RoutesExternalRow").hide()
      $("#networkSecurityAclsRow").hide()
      $("#networkSecurityAclsDefaultIngressActionRow").hide()
      $("#networkSecurityAclsDefaultEgressActionRow").hide()
      $("#networkSecurityAclsDefaultIngressLoggedRow").hide()
      $("#networkSecurityAclsDefaultEgressLoggedRow").hide()
    }
    if (networkNicTypeInput == "routed"){
      $("#networkParentRow").show()
      $("#networkNetworkRow").hide()
      $("#networkInterfaceNameRow").show()
      $("#networkMtuRow").show()
      $("#networkHwaddrRow").show()
      $("#networkHostNameRow").show()
      $("#networkLimitsIngressRow").show()
      $("#networkLimitsEgressRow").show()
      $("#networkLimitsMaxRow").show()
      $("#networkIpv4AddressRow").show()
      $("#networkIpv6AddressRow").show()
      $("#networkIpv4RoutesRow").hide()
      $("#networkIpv6RoutesRow").hide()
      $("#networkSecurityMacFilteringRow").hide()
      $("#networkSecurityIpv4FilteringRow").hide()
      $("#networkSecurityIpv6FilteringRow").hide()
      $("#networkMaasSubnetIpv4Row").hide()
      $("#networkMaasSubnetIpv6Row").hide()
      $("#networkBootPriorityRow").hide()
      $("#networkVlanRow").show()
      $("#networkVlanTaggedRow").hide()
      $("#networkSecurityPortIsolationRow").hide()
      $("#networkGvrpRow").show()
      $("#networkModeRow").hide()
      $("#networkIpv4GatewayRow").show()
      $("#networkIpv4HostTableRow").show()
      $("#networkIpv6GatewayRow").show()
      $("#networkIpv6HostTableRow").show()
      $("#networkIpv4HostAddressRow").show()
      $("#networkIpv6HostAddressRow").show()
      $("#networkIpv4RoutesExternalRow").hide()
      $("#networkIpv6RoutesExternalRow").hide()
      $("#networkSecurityAclsRow").hide()
      $("#networkSecurityAclsDefaultIngressActionRow").hide()
      $("#networkSecurityAclsDefaultEgressActionRow").hide()
      $("#networkSecurityAclsDefaultIngressLoggedRow").hide()
      $("#networkSecurityAclsDefaultEgressLoggedRow").hide()
    }
  }

  function addInstanceDiskDevice(){
    var diskNameInput = $("#diskNameInput").val();
    var diskPoolInput = $("#diskPoolInput").val();
    var diskSourceInput = $("#diskSourceInput").val();
    var diskSourceSelectInput = $("#diskSourceSelectInput").val();
    var diskPathInput = $("#diskPathInput").val();
    var diskLimitsReadInput = $("#diskLimitsReadInput").val();
    var diskLimitsWriteInput = $("#diskLimitsWriteInput").val();
    var diskLimitsMaxInput = $("#diskLimitsMaxInput").val();
    var diskRequiredInput = $("#diskRequiredInput").val();
    var diskReadOnlyInput = $("#diskReadOnlyInput").val();
    var diskSizeInput = $("#diskSizeInput").val();
    var diskSizeStateInput = $("#diskSizeStateInput").val();
    var diskRecursiveInput = $("#diskRecursiveInput").val();
    var diskPropagationInput = $("#diskPropagationInput").val();
    var diskShiftInput = $("#diskShiftInput").val();
    var diskRawMountOptionsInput = $("#diskRawMountOptionsInput").val();
    var diskCephUserNameInput = $("#diskCephUserNameInput").val();
    var diskCephClusterNameInput = $("#diskCephClusterNameInput").val();
    var diskBootPriorityInput = $("#diskBootPriorityInput").val();

    if (diskPoolInput != ""){
      diskSourceInput = diskSourceSelectInput
    }

    console.log("Info: adding disk device " + diskNameInput + " to instance " + instanceName);
    $.get("./backend/lxd/containers-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + 
    "&name=" + encodeURI(diskNameInput) + 
    "&pool=" + encodeURI(diskPoolInput) + 
    "&source=" + encodeURI(diskSourceInput) + 
    "&path=" + encodeURI(diskPathInput) + 
    "&limits_read=" + encodeURI(diskLimitsReadInput) + 
    "&limits_write=" + encodeURI(diskLimitsWriteInput) + 
    "&limits_max=" + encodeURI(diskLimitsMaxInput) + 
    "&required=" + encodeURI(diskRequiredInput) + 
    "&read_only=" + encodeURI(diskReadOnlyInput) + 
    "&size=" + encodeURI(diskSizeInput) + 
    "&size_state=" + encodeURI(diskSizeStateInput) + 
    "&recursive=" + encodeURI(diskRecursiveInput) + 
    "&propagation=" + encodeURI(diskPropagationInput) + 
    "&shift=" + encodeURI(diskShiftInput) + 
    "&raw_mount_options=" + encodeURI(diskRawMountOptionsInput) + 
    "&ceph_user_name=" + encodeURI(diskCephUserNameInput) + 
    "&ceph_cluster_name=" + encodeURI(diskCephClusterNameInput) + 
    "&boot_priority=" + encodeURI(diskBootPriorityInput) + 
    "&action=addInstanceDiskDevice", function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function addInstanceGPUDevice(){
    var gpuDeviceNameInput = $("#gpuDeviceNameInput").val();

    console.log("Info: adding gpu device " + gpuDeviceNameInput + " to instance " + instanceName);
    $.get("./backend/lxd/containers-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + 
    "&name=" + encodeURI(gpuDeviceNameInput) + 
    "&type=" + encodeURI($("#gpuTypeInput").val()) + 
    "&vendorid=" + encodeURI($("#gpuVendoridInput").val()) + 
    "&productid=" + encodeURI($("#gpuProductidInput").val()) + 
    "&id=" + encodeURI($("#gpuIdInput").val()) +
    "&pci=" + encodeURI($("#gpuPciInput").val()) +
    "&uid=" + encodeURI($("#gpuUidInput").val()) + 
    "&gid=" + encodeURI($("#gpuGidInput").val()) + 
    "&mode=" + encodeURI($("#gpuModeInput").val()) + 
    "&mig_ci=" + encodeURI($("#gpuMigCiInput").val()) + 
    "&mig_gi=" + encodeURI($("#gpuMigGiInput").val()) + 
    "&action=addInstanceGPUDevice", function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function addInstanceNetworkDevice(){
    var networkNameInput = $("#networkNameInput").val();
    var networkPropertySetInput = $("#networkPropertySetInput").val();
    var networkNicTypeInput = $("#networkNicTypeInput").val();
    var networkParentTypeInput = $("#networkParentTypeInput").val();
    var networkParentInput = $("#networkParentInput").val();
    var networkNetworkInput = $("#networkNetworkInput").val();
    var networkInterfaceNameInput = $("#networkInterfaceNameInput").val();
    var networkMtuInput = $("#networkMtuInput").val();
    var networkModeInput = $("#networkModeInput").val();
    var networkHwaddrInput = $("#networkHwaddrInput").val();
    var networkHostNameInput = $("#networkHostNameInput").val();
    var networkLimitsIngressInput = $("#networkLimitsIngressInput").val();
    var networkLimitsEgressInput = $("#networkLimitsEgressInput").val();
    var networkLimitsMaxInput = $("#networkLimitsMaxInput").val();
    var networkIpv4AddressInput = $("#networkIpv4AddressInput").val();
    var networkIpv4GatewayInput = $("#networkIpv4GatewayInput").val();
    var networkIpv4HostTableInput = $("#networkIpv4HostTableInput").val();
    var networkIpv4HostAddressInput = $("#networkIpv4HostAddressInput").val();
    var networkIpv4RoutesInput = $("#networkIpv4RoutesInput").val();
    var networkIpv4RoutesExternalInput = $("#networkIpv4RoutesExternalInput").val();
    var networkIpv6AddressInput = $("#networkIpv6AddressInput").val();
    var networkIpv6GatewayInput = $("#networkIpv6GatewayInput").val();
    var networkIpv6HostTableInput = $("#networkIpv6HostTableInput").val();
    var networkIpv6HostAddressInput = $("#networkIpv6HostAddressInput").val();
    var networkIpv6RoutesInput = $("#networkIpv6RoutesInput").val();
    var networkIpv6RoutesExternalInput = $("#networkIpv6RoutesExternalInput").val();
    var networkSecurityMacFilteringInput = $("#networkSecurityMacFilteringInput").val();
    var networkSecurityIpv4FilteringInput = $("#networkSecurityIpv4FilteringInput").val();
    var networkSecurityIpv6FilteringInput = $("#networkSecurityIpv6FilteringInput").val();
    var networkMaasSubnetIpv4Input = $("#networkMaasSubnetIpv4Input").val();
    var networkMaasSubnetIpv6Input = $("#networkMaasSubnetIpv6Input").val();
    var networkBootPriorityInput = $("#networkBootPriorityInput").val();
    var networkVlanInput = $("#networkVlanInput").val();
    var networkVlanTaggedInput = $("#networkVlanTaggedInput").val();
    var networkSecurityPortIsolationInput = $("#networkSecurityPortIsolationInput").val();
    var networkGvrpInput = $("#networkGvrpInput").val();
    var networkSecurityAclsInput = $("#networkSecurityAclsInput").val();
    var networkSecurityAclsDefaultIngressActionInput = $("#networkSecurityAclsDefaultIngressActionInput").val();
    var networkSecurityAclsDefaultEgressActionInput = $("#networkSecurityAclsDefaultEgressActionInput").val();
    var networkSecurityAclsDefaultIngressLoggedInput = $("#networkSecurityAclsDefaultIngressLoggedInput").val();
    var networkSecurityAclsDefaultEgressLoggedInput = $("#networkSecurityAclsDefaultEgressLoggedInput").val();

    console.log("Info: adding network device " + networkNameInput + " to instance " + instanceName);
    $.get("./backend/lxd/containers-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + 
    "&name=" + encodeURI(networkNameInput) +
    "&property_set=" + encodeURI(networkPropertySetInput) +
    "&nictype=" + encodeURI(networkNicTypeInput) + 
    "&parent_type=" + encodeURI(networkParentTypeInput) + 
    "&parent=" + encodeURI(networkParentInput) + 
    "&network=" + encodeURI(networkNetworkInput) + 
    "&interface_name=" + encodeURI(networkInterfaceNameInput) + 
    "&mtu=" + encodeURI(networkMtuInput) + 
    "&mode=" + encodeURI(networkModeInput) + 
    "&hwaddr=" + encodeURI(networkHwaddrInput) + 
    "&host_name=" + encodeURI(networkHostNameInput) + 
    "&limits_ingress=" + encodeURI(networkLimitsIngressInput) + 
    "&limits_egress=" + encodeURI(networkLimitsEgressInput) + 
    "&limits_max=" + encodeURI(networkLimitsMaxInput) + 
    "&ipv4_address=" + encodeURI(networkIpv4AddressInput) + 
    "&ipv4_gateway=" + encodeURI(networkIpv4GatewayInput) + 
    "&ipv4_host_table=" + encodeURI(networkIpv4HostTableInput) + 
    "&ipv4_host_address=" + encodeURI(networkIpv4HostAddressInput) + 
    "&ipv4_routes=" + encodeURI(networkIpv4RoutesInput) + 
    "&ipv4_routes_external=" + encodeURI(networkIpv4RoutesExternalInput) + 
    "&ipv6_address=" + encodeURI(networkIpv6AddressInput) + 
    "&ipv6_gateway=" + encodeURI(networkIpv6GatewayInput) + 
    "&ipv6_host_table=" + encodeURI(networkIpv6HostTableInput) + 
    "&ipv6_host_address=" + encodeURI(networkIpv6HostAddressInput) + 
    "&ipv6_routes=" + encodeURI(networkIpv6RoutesInput) + 
    "&ipv6_routes_external=" + encodeURI(networkIpv6RoutesExternalInput) + 
    "&security_mac_filtering=" + encodeURI(networkSecurityMacFilteringInput) + 
    "&security_ipv4_filtering=" + encodeURI(networkSecurityIpv4FilteringInput) + 
    "&security_ipv6_filtering=" + encodeURI(networkSecurityIpv6FilteringInput) + 
    "&maas_subnet_ipv4=" + encodeURI(networkMaasSubnetIpv4Input) + 
    "&maas_subnet_ipv6=" + encodeURI(networkMaasSubnetIpv6Input) + 
    "&boot_priority=" + encodeURI(networkBootPriorityInput) + 
    "&vlan=" + encodeURI(networkVlanInput) + 
    "&vlan_tagged=" + encodeURI(networkVlanTaggedInput) + 
    "&security_port_isolation=" + encodeURI(networkSecurityPortIsolationInput) + 
    "&gvrp=" + encodeURI(networkGvrpInput) + 
    "&security_acls=" + encodeURI(networkSecurityAclsInput) + 
    "&security_acls_default_ingress_action=" + encodeURI(networkSecurityAclsDefaultIngressActionInput) + 
    "&security_acls_default_egress_action=" + encodeURI(networkSecurityAclsDefaultEgressActionInput) + 
    "&security_acls_default_ingress_logged=" + encodeURI(networkSecurityAclsDefaultIngressLoggedInput) + 
    "&security_acls_default_egress_logged=" + encodeURI(networkSecurityAclsDefaultEgressLoggedInput) + 
    "&action=addInstanceNetworkDevice", function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function addInstanceProxyDevice(){
    var proxyDeviceNameInput = $("#proxyDeviceNameInput").val();
    var proxyListenInput = $("#proxyListenInput").val();
    var proxyConnectInput = $("#proxyConnectInput").val();
    var proxyBindInput = $("#proxyBindInput").val();
    var proxyUidInput = $("#proxyUidInput").val();
    var proxyGidInput = $("#proxyGidInput").val();
    var proxyModeInput = $("#proxyModeInput").val();
    var proxyNatInput = $("#proxyNatInput").val();
    var proxyProxyProtocolInput = $("#proxyProxyProtocolInput").val();
    var proxySecurityUidInput = $("#proxySecurityUidInput").val();
    var proxySecurityGidInput = $("#proxySecurityGidInput").val();

    console.log("Info: adding proxy device " + proxyDeviceNameInput + " to instance " + instanceName);
    $.get("./backend/lxd/containers-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&name=" + encodeURI(proxyDeviceNameInput) + "&listen=" + encodeURI(proxyListenInput) + "&connect=" + encodeURI(proxyConnectInput) + "&bind=" + encodeURI(proxyBindInput) + "&uid=" + encodeURI(proxyUidInput) + "&gid=" + encodeURI(proxyGidInput) + "&mode=" + encodeURI(proxyModeInput) + "&nat=" + encodeURI(proxyNatInput) + "&proxy_protocol=" + encodeURI(proxyProxyProtocolInput) + "&security_uid=" + encodeURI(proxySecurityUidInput) + "&security_gid=" + encodeURI(proxySecurityGidInput) + "&action=addInstanceProxyDevice", function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function addInstanceUnixDevice(){
    var unixDeviceNameInput = $("#unixDeviceNameInput").val();
    var unixSourceInput = $("#unixSourceInput").val();
    var unixPathInput = $("#unixPathInput").val();
    var unixMajorInput = $("#unixMajorInput").val();
    var unixMinorInput = $("#unixMinorInput").val();
    var unixUidInput = $("#unixUidInput").val();
    var unixGidInput = $("#unixGidInput").val();
    var unixModeInput = $("#unixModeInput").val();
    var unixRequiredInput = $("#unixRequiredInput").val();

    console.log("Info: adding Unix device " + unixDeviceNameInput + " to instance " + instanceName);
    $.get("./backend/lxd/containers-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + 
    "&name=" + encodeURI(unixDeviceNameInput) + 
    "&type=" + encodeURI($("#unixTypeInput").val()) + 
    "&source=" + encodeURI(unixSourceInput) + 
    "&path=" + encodeURI(unixPathInput) + 
    "&major=" + encodeURI(unixMajorInput) + 
    "&minor=" + encodeURI(unixMinorInput) + 
    "&uid=" + encodeURI(unixUidInput) + 
    "&gid=" + encodeURI(unixGidInput) + 
    "&mode=" + encodeURI(unixModeInput) + 
    "&required=" + encodeURI(unixRequiredInput) + 
    "&action=addInstanceUnixDevice", function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function addInstanceUSBDevice(){
    var usbDeviceNameInput = $("#usbDeviceNameInput").val();
    var usbVendoridInput = $("#usbVendoridInput").val();
    var usbProductidInput = $("#usbProductidInput").val();
    var usbUidInput = $("#usbUidInput").val();
    var usbGidInput = $("#usbGidInput").val();
    var usbModeInput = $("#usbModeInput").val();

    console.log("Info: adding usb device " + usbDeviceNameInput + " to instance " + instanceName);
    $.get("./backend/lxd/containers-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + 
    "&name=" + encodeURI(usbDeviceNameInput) + 
    "&vendorid=" + encodeURI(usbVendoridInput) + 
    "&productid=" + encodeURI(usbProductidInput) + 
    "&uid=" + encodeURI(usbUidInput) + 
    "&gid=" + encodeURI(usbGidInput) + 
    "&mode=" + encodeURI(usbModeInput) + 
    "&action=addInstanceUSBDevice", function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function removeInstanceDevice(deviceName){
    console.log("Info: removing device " + deviceName + " from instance " + instanceName);
    $.get("./backend/lxd/containers-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&name=" + encodeURI(deviceName) + "&action=removeInstanceDevice", function (data) {
      //Async operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      operationStatusCheck();
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function editInstance(){
    console.log("Info: viewing instance " + instanceName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&action=loadInstanceInformation", function (data) {
      //Sync operation type
      var data = JSON.parse(data);
      console.log(data);
      if (data.error_code >= 400){
        alert(data.error);
      }
      data = data.metadata;
      dataConfig = data.config;
      if (data.hasOwnProperty('description')) { $("#containerDescriptionInput").val(data.description); }
      if (dataConfig.hasOwnProperty('linux.kernel_modules')) { $("#containerLinuxKernelModulesInput").val(dataConfig['linux.kernel_modules']); }

      if (dataConfig.hasOwnProperty('boot.autostart')) { $("#containerBootAutostartInput").val(dataConfig['boot.autostart']); }
      if (dataConfig.hasOwnProperty('boot.autostart.delay')) { $("#containerBootAutostartDelayInput").val(dataConfig['boot.autostart.delay']); }
      if (dataConfig.hasOwnProperty('boot.autostart.priority')) { $("#containerBootAutostartPriorityInput").val(dataConfig['boot.autostart.priority']); }
      if (dataConfig.hasOwnProperty('boot.host_shutdown_timeout')) { $("#containerBootHostShutdownTimeoutInput").val(dataConfig['boot.host_shutdown_timeout']); }
      if (dataConfig.hasOwnProperty('boot.stop.priority')) { $("#containerBootStopPriorityInput").val(dataConfig['boot.stop.priority']); }

      if (dataConfig.hasOwnProperty('limits.cpu')) { $("#containerLimitsCpuInput").val(dataConfig['limits.cpu']); }
      if (dataConfig.hasOwnProperty('limits.cpu.allowance')) { $("#containerLimitsCpuAllowanceInput").val(dataConfig['limits.cpu.allowance']); }
      if (dataConfig.hasOwnProperty('limits.cpu.priority')) { $("#containerLimitsCpuPriorityInput").val(dataConfig['limits.cpu.priority']); }
      if (dataConfig.hasOwnProperty('limits.disk.priority')) { $("#containerLimitsDiskPriorityInput").val(dataConfig['limits.disk.priority']); }
      if (dataConfig.hasOwnProperty('limits.hugepages.64KB')) { $("#containerLimitsHugepages64KBInput").val(dataConfig['limits.hugepages.64KB']); }
      if (dataConfig.hasOwnProperty('limits.hugepages.1MB')) { $("#containerLimitsHugepages1MBInput").val(dataConfig['limits.hugepages.1MB']); }
      if (dataConfig.hasOwnProperty('limits.hugepages.2MB')) { $("#containerLimitsHugepages2MBInput").val(dataConfig['limits.hugepages.2MB']); }
      if (dataConfig.hasOwnProperty('limits.hugepages.1GB')) { $("#containerLimitsHugepages1GBInput").val(dataConfig['limits.hugepages.1GB']); }
      if (dataConfig.hasOwnProperty('limits.memory')) { $("#containerLimitsMemoryInput").val(dataConfig['limits.memory']); }
      if (dataConfig.hasOwnProperty('limits.memory.enforce')) { $("#containerLimitsMemoryEnforceInput").val(dataConfig['limits.memory.enforce']); }
      if (dataConfig.hasOwnProperty('limits.memory.swap')) { $("#containerLimitsMemorySwapInput").val(dataConfig['limits.memory.swap']); }
      if (dataConfig.hasOwnProperty('limits.memory.swap.priority')) { $("#containerLimitsMemorySwapPriorityInput").val(dataConfig['limits.memory.swap.priority']); }
      if (dataConfig.hasOwnProperty('limits.network.priority')) { $("#containerLimitsNetworkPriorityInput").val(dataConfig['limits.network.priority']); }
      if (dataConfig.hasOwnProperty('limits.processes')) { $("#containerLimitsProcessesInput").val(dataConfig['limits.processes']); }

      if (dataConfig.hasOwnProperty('cluster.evacuate')) { $("#containerClusterEvacuateInput").val(dataConfig['cluster.evacuate']); }
      if (dataConfig.hasOwnProperty('migration.incremental.memory')) { $("#containerMigrationIncrementalMemoryInput").val(dataConfig['migration.incremental.memory']); }
      if (dataConfig.hasOwnProperty('migration.incremental.memory.goal')) { $("#containerMigrationIncrementalMemoryGoalInput").val(dataConfig['migration.incremental.memory.goal']); }
      if (dataConfig.hasOwnProperty('migration.incremental.memory.iterations')) { $("#containerMigrationIncrementalMemoryIterationsInput").val(dataConfig['migration.incremental.memory.iterations']); }

      if (dataConfig.hasOwnProperty('nvidia.driver.capabilities')) { $("#containerNvidiaDriverCapabilitiesInput").val(dataConfig['nvidia.driver.capabilities']); }
      if (dataConfig.hasOwnProperty('nvidia.runtime')) { $("#containerNvidiaRuntimeInput").val(dataConfig['nvidia.runtime']); }
      if (dataConfig.hasOwnProperty('nvidia.require.cuda')) { $("#containerNvidiaRequireCudaInput").val(dataConfig['nvidia.require.cuda']); }
      if (dataConfig.hasOwnProperty('nvidia.require.driver')) { $("#containerNvidiaRequireDriverInput").val(dataConfig['nvidia.require.driver']); }

      if (dataConfig.hasOwnProperty('raw.apparmor')) { $("#containerRawApparmorInput").val(dataConfig['raw.apparmor']); }
      if (dataConfig.hasOwnProperty('raw.idmap')) { $("#containerRawIdmapInput").val(dataConfig['raw.idmap']); }
      if (dataConfig.hasOwnProperty('raw.lxc')) { $("#containerRawLxcInput").val(dataConfig['raw.lxc']); }
      if (dataConfig.hasOwnProperty('raw.seccomp')) { $("#containerRawSeccompInput").val(dataConfig['raw.seccomp']); }

      if (dataConfig.hasOwnProperty('security.devlxd')) { $("#containerSecurityDevLxdInput").val(dataConfig['security.devlxd']); }
      if (dataConfig.hasOwnProperty('security.devlxd.images')) { $("#containerSecurityDevLxdImagesInput").val(dataConfig['security.devlxd.images']); }
      if (dataConfig.hasOwnProperty('security.idmap.base')) { $("#containerSecurityIdmapBaseInput").val(dataConfig['security.idmap.base']); }
      if (dataConfig.hasOwnProperty('security.idmap.isolated')) { $("#containerSecurityIdmapIsolatedInput").val(dataConfig['security.idmap.isolated']); }
      if (dataConfig.hasOwnProperty('security.idmap.size')) { $("#containerSecurityIdmapSizeInput").val(dataConfig['security.idmap.size']); }
      if (dataConfig.hasOwnProperty('security.nesting')) { $("#containerSecurityNestingInput").val(dataConfig['security.nesting']); }
      if (dataConfig.hasOwnProperty('security.privileged')) { $("#containerSecurityPrivilegedInput").val(dataConfig['security.privileged']); }
      if (dataConfig.hasOwnProperty('security.protection.delete')) { $("#containerSecurityProtectionDeleteInput").val(dataConfig['security.protection.delete']); }
      if (dataConfig.hasOwnProperty('security.protection.shift')) { $("#containerSecurityProtectionShiftInput").val(dataConfig['security.protection.shift']); }
      if (dataConfig.hasOwnProperty('security.syscalls.allow')) { $("#containerSecuritySyscallsAllowInput").val(dataConfig['security.syscalls.allow']); }
      if (dataConfig.hasOwnProperty('security.syscalls.deny')) { $("#containerSecuritySyscallsDenyInput").val(dataConfig['security.syscalls.deny']); }
      if (dataConfig.hasOwnProperty('security.syscalls.deny_compat')) { $("#containerSecuritySyscallsDenyCompatInput").val(dataConfig['security.syscalls.deny_compat']); }
      if (dataConfig.hasOwnProperty('security.syscalls.deny_default')) { $("#containerSecuritySyscallsDenyDefaultInput").val(dataConfig['security.syscalls.deny_default']); }
      if (dataConfig.hasOwnProperty('security.syscalls.intercept.bpf')) { $("#containerSecuritySyscallsInterceptBpfInput").val(dataConfig['security.syscalls.intercept.bpf']); }
      if (dataConfig.hasOwnProperty('security.syscalls.intercept.bpf.devices')) { $("#containerSecuritySyscallsInterceptBpfDevicesInput").val(dataConfig['security.syscalls.intercept.bpf.devices']); }
      if (dataConfig.hasOwnProperty('security.syscalls.intercept.mknod')) { $("#containerSecuritySyscallsInterceptMknodInput").val(dataConfig['security.syscalls.intercept.mknod']); }
      if (dataConfig.hasOwnProperty('security.syscalls.intercept.mount')) { $("#containerSecuritySyscallsInterceptMountInput").val(dataConfig['security.syscalls.intercept.mount']); }
      if (dataConfig.hasOwnProperty('security.syscalls.intercept.mount.allowed')) { $("#containerSecuritySyscallsInterceptMountAllowedInput").val(dataConfig['security.syscalls.intercept.mount.allowed']); }
      if (dataConfig.hasOwnProperty('security.syscalls.intercept.mount.fuse')) { $("#containerSecuritySyscallsInterceptMountFuseInput").val(dataConfig['security.syscalls.intercept.mount.fuse']); }
      if (dataConfig.hasOwnProperty('security.syscalls.intercept.mount.shift')) { $("#containerSecuritySyscallsInterceptMountShiftInput").val(dataConfig['security.syscalls.intercept.mount.shift']); }
      if (dataConfig.hasOwnProperty('security.syscalls.intercept.setxattr')) { $("#containerSecuritySyscallsInterceptSetxattrInput").val(dataConfig['security.syscalls.intercept.setxattr']); }

      if (dataConfig.hasOwnProperty('snapshots.schedule')) { $("#containerSnapshotsScheduleInput").val(dataConfig['snapshots.schedule']); }
      if (dataConfig.hasOwnProperty('snapshots.schedule.stopped')) { $("#containerSnapshotsScheduleStoppedInput").val(dataConfig['snapshots.schedule.stopped']); }
      if (dataConfig.hasOwnProperty('snapshots.pattern')) { $("#containerSnapshotsPatternInput").val(dataConfig['snapshots.pattern']); }
      if (dataConfig.hasOwnProperty('snapshots.expiry')) { $("#containerSnapshotsExpiryInput").val(dataConfig['snapshots.expiry']); }
      
      $("#instanceNameEditInput").text("Name: " + instanceName);
      $("#jsonEditInput").val(JSON.stringify(data, null, 2));
      $("#editInstanceModal").modal('show');
    });
  }

  function updateInstanceForm(){
    var instanceDescription = $("#containerDescriptionInput").val();
    var linuxKernelModules = $("#containerLinuxKernelModulesInput").val();

    var bootAutostart = $("#containerBootAutostartInput").val();
    var bootAutostartDelay = $("#containerBootAutostartDelayInput").val();
    var bootAutostartPriority = $("#containerBootAutostartPriorityInput").val();
    var bootHostShutdownTimeout = $("#containerBootHostShutdownTimeoutInput").val();
    var bootStopPriority = $("#containerBootStopPriorityInput").val();

    var limitsCpu = $("#containerLimitsCpuInput").val();
    var limitsCpuAllowance = $("#containerLimitsCpuAllowanceInput").val();
    var limitsCpuPriority = $("#containerLimitsCpuPriorityInput").val();
    var limitsDiskPriority = $("#containerLimitsDiskPriorityInput").val();
    var limitsHugepages64KB = $("#containerLimitsHugepages64KBInput").val();
    var limitsHugepages1MB = $("#containerLimitsHugepages1MBInput").val();
    var limitsHugepages2MB = $("#containerLimitsHugepages2MBInput").val();
    var limitsHugepages1GB = $("#containerLimitsHugepages1GBInput").val();
    var limitsMemory = $("#containerLimitsMemoryInput").val();
    var limitsMemoryEnforce = $("#containerLimitsMemoryEnforceInput").val();
    var limitsMemorySwap = $("#containerLimitsMemorySwapInput").val();
    var limitsMemorySwapPriority = $("#containerLimitsMemorySwapPriorityInput").val();
    var limitsNetworkPriority = $("#containerLimitsNetworkPriorityInput").val();
    var limitsProcesses = $("#containerLimitsProcessesInput").val();

    var clusterEvacuate = $("#containerClusterEvacuateInput").val();
    var migrationIncrementalMemory = $("#containerMigrationIncrementalMemoryInput").val();
    var migrationIncrementalMemoryGoal = $("#containerMigrationIncrementalMemoryGoalInput").val();
    var migrationIncrementalMemoryIterations = $("#containerMigrationIncrementalMemoryIterationsInput").val();

    var nvidiaDriverCapabilities = $("#containerNvidiaDriverCapabilitiesInput").val();
    var nvidiaRuntime = $("#containerNvidiaRuntimeInput").val();
    var nvidiaRequireCuda = $("#containerNvidiaRequireCudaInput").val();
    var nvidiaRequireDriver = $("#containerNvidiaRequireDriverInput").val();

    var rawApparmor = $("#containerRawApparmorInput").val();
    var rawIdmap = $("#containerRawIdmapInput").val();
    var rawLxc = $("#containerRawLxcInput").val();
    var rawSeccomp = $("#containerRawSeccompInput").val();
    
    var securityDevLxd = $("#containerSecurityDevLxdInput").val();
    var securityDevLxdImages = $("#containerSecurityDevLxdImagesInput").val();
    var securityIdmapBase = $("#containerSecurityIdmapBaseInput").val();
    var securityIdmapIsolated = $("#containerSecurityIdmapIsolatedInput").val();
    var securityIdmapSize = $("#containerSecurityIdmapSizeInput").val();
    var securityNesting = $("#containerSecurityNestingInput").val();
    var securityPrivileged = $("#containerSecurityPrivilegedInput").val();
    var securityProtectionDelete = $("#containerSecurityProtectionDeleteInput").val();
    var securityProtectionShift = $("#containerSecurityProtectionShiftInput").val();
    var securitySyscallsAllow = $("#containerSecuritySyscallsAllowInput").val();
    var securitySyscallsDeny = $("#containerSecuritySyscallsDenyInput").val();
    var securitySyscallsDenyCompat = $("#containerSecuritySyscallsDenyCompatInput").val();
    var securitySyscallsDenyDefault = $("#containerSecuritySyscallsDenyDefaultInput").val();
    var securitySyscallsInterceptBpf = $("#containerSecuritySyscallsInterceptBpfInput").val();
    var securitySyscallsInterceptBpfDevices = $("#containerSecuritySyscallsInterceptBpfDevicesInput").val();
    var securitySyscallsInterceptMknod = $("#containerSecuritySyscallsInterceptMknodInput").val();
    var securitySyscallsInterceptMount = $("#containerSecuritySyscallsInterceptMountInput").val();
    var securitySyscallsInterceptMountAllowed = $("#containerSecuritySyscallsInterceptMountAllowedInput").val();
    var securitySyscallsInterceptMountFuse = $("#containerSecuritySyscallsInterceptMountFuseInput").val();
    var securitySyscallsInterceptMountShift = $("#containerSecuritySyscallsInterceptMountShiftInput").val();
    var securitySyscallsInterceptSetxattr = $("#containerSecuritySyscallsInterceptSetxattrInput").val();

    var snapshotsSchedule = $("#containerSnapshotsScheduleInput").val();
    var snapshotsScheduleStopped = $("#containerSnapshotsScheduleStoppedInput").val();
    var snapshotsPattern = $("#containerSnapshotsPatternInput").val();
    var snapshotsExpiry = $("#containerSnapshotsExpiryInput").val();

    console.log("Info: updating container " + instanceName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) +
    "&description=" + encodeURI(instanceDescription) + 
    "&boot_autostart=" + encodeURI(bootAutostart) + 
    "&boot_autostart_delay=" + encodeURI(bootAutostartDelay) + 
    "&boot_autostart_priority=" + encodeURI(bootAutostartPriority) + 
    "&boot_host_shutdown_timeout=" + encodeURI(bootHostShutdownTimeout) + 
    "&boot_stop_priority=" + encodeURI(bootStopPriority) + 
    "&cluster_evacuate=" + encodeURI(clusterEvacuate) + 
    "&limits_cpu=" + encodeURI(limitsCpu) + 
    "&limits_cpu_allowance=" + encodeURI(limitsCpuAllowance) + 
    "&limits_cpu_priority=" + encodeURI(limitsCpuPriority) + 
    "&limits_disk_priority=" + encodeURI(limitsDiskPriority) + 
    "&limits_hugepages_64kb=" + encodeURI(limitsHugepages64KB) + 
    "&limits_hugepages_1mb=" + encodeURI(limitsHugepages1MB) + 
    "&limits_hugepages_2mb=" + encodeURI(limitsHugepages2MB) + 
    "&limits_hugepages_1gb=" + encodeURI(limitsHugepages1GB) + 
    "&limits_memory=" + encodeURI(limitsMemory) + 
    "&limits_memory_enforce=" + encodeURI(limitsMemoryEnforce) + 
    "&limits_memory_swap=" + encodeURI(limitsMemorySwap) + 
    "&limits_memory_swap_priority=" + encodeURI(limitsMemorySwapPriority) + 
    "&limits_network_priority=" + encodeURI(limitsNetworkPriority) + 
    "&limits_processes=" + encodeURI(limitsProcesses) + 
    "&linux_kernel_modules=" + encodeURI(linuxKernelModules) + 
    "&migration_incremental_memory=" + encodeURI(migrationIncrementalMemory) + 
    "&migration_incremental_memory_goal=" + encodeURI(migrationIncrementalMemoryGoal) + 
    "&migration_incremental_memory_iterations=" + encodeURI(migrationIncrementalMemoryIterations) + 
    "&nividia_driver_capabilities=" + encodeURI(nvidiaDriverCapabilities) + 
    "&nvidia_runtime=" + encodeURI(nvidiaRuntime) + 
    "&nvidia_require_cuda=" + encodeURI(nvidiaRequireCuda) + 
    "&nvidia_require_driver=" + encodeURI(nvidiaRequireDriver) + 
    "&raw_apparmor=" + encodeURI(rawApparmor) + 
    "&raw_idmap=" + encodeURI(rawIdmap) + 
    "&raw_lxc=" + encodeURI(rawLxc) + 
    "&raw_seccomp=" + encodeURI(rawSeccomp) + 
    "&security_devlxd=" + encodeURI(securityDevLxd) + 
    "&security_devlxd_images=" + encodeURI(securityDevLxdImages) + 
    "&security_idmap_base=" + encodeURI(securityIdmapBase) + 
    "&security_idmap_isolated=" + encodeURI(securityIdmapIsolated) + 
    "&security_idmap_size=" + encodeURI(securityIdmapSize) + 
    "&security_nesting=" + encodeURI(securityNesting) + 
    "&security_privileged=" + encodeURI(securityPrivileged) + 
    "&security_protection_delete=" + encodeURI(securityProtectionDelete) + 
    "&security_protection_shift=" + encodeURI(securityProtectionShift) + 
    "&security_syscalls_allow=" + encodeURI(securitySyscallsAllow) + 
    "&security_syscalls_deny=" + encodeURI(securitySyscallsDeny) + 
    "&security_syscalls_deny_compat=" + encodeURI(securitySyscallsDenyCompat) + 
    "&security_syscalls_deny_default=" + encodeURI(securitySyscallsDenyDefault) + 
    "&security_syscalls_intercept_bpf=" + encodeURI(securitySyscallsInterceptBpf) + 
    "&security_syscalls_intercept_bpf_devices=" + encodeURI(securitySyscallsInterceptBpfDevices) + 
    "&security_syscalls_intercept_mknod=" + encodeURI(securitySyscallsInterceptMknod) + 
    "&security_syscalls_intercept_mount=" + encodeURI(securitySyscallsInterceptMount) + 
    "&security_syscalls_intercept_mount_allowed=" + encodeURI(securitySyscallsInterceptMountAllowed) + 
    "&security_syscalls_intercept_mount_fuse=" + encodeURI(securitySyscallsInterceptMountFuse) + 
    "&security_syscalls_intercept_mount_shift=" + encodeURI(securitySyscallsInterceptMountShift) + 
    "&security_syscalls_intercept_setxattr=" + encodeURI(securitySyscallsInterceptSetxattr) + 
    "&snapshots_schedule=" + encodeURI(snapshotsSchedule) + 
    "&snapshots_schedule_stopped=" + encodeURI(snapshotsScheduleStopped) + 
    "&snapshots_pattern=" + encodeURI(snapshotsPattern) + 
    "&snapshots_expiry=" + encodeURI(snapshotsExpiry) + 
    "&action=updateInstanceUsingForm",  function (data) {
      //Sync type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function updateInstanceJson(){
    var instanceUpdateJSON = $("#jsonEditInput").val();
    console.log("Info: updating instance " + instanceName);
    $.post("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&action=updateInstanceInformation", {json: instanceUpdateJSON},  function (data) {
      //Async operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      operationStatusCheck();
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  
  }

  function convertArrayBuffer2String(buf) {
    var encoding = 'utf8';
    var decoder = new TextDecoder(encoding);
	  var str = decoder.decode(buf);
    return str
  }

  function convertString2ArrayBuffer(str) {
    var buf = new ArrayBuffer(str.length);
    var bufView = new Uint8Array(buf);
    for (var i=0, strLen=str.length; i < strLen; i++) {
      bufView[i] = str.charCodeAt(i);
    }
    return buf;
  }

  function establishInstanceWebSocketConsoleConnection() {
    $.get("./backend/lxd/containers-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&action=retrieveHostAndPort", function (data) {
      var operationData = JSON.parse(data);
      console.log(operationData);
      var host = operationData.host;
      var port = operationData.port;

      //Check to see if we can connect to the LXD remote host over a secure connection
      fetch('https://' + host + ':' + port + '/1.0', { mode: 'no-cors' })
      .then(response => {
        //If we made it here then the self-signed LXD certificate would have been already trusted by the user's browser we can setup a secure websocket connection
        $.get("./backend/lxd/containers-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&action=establishInstanceWebSocketConsoleConnection", function (data) {
          var operationData = JSON.parse(data);
          var operation = operationData.operation;
          var consoleControlURL = "wss://" + host + ":" + port + operation + "/websocket?secret=" + operationData.control;
          var consoleDataURL = "wss://" + host + ":" + port + operation + "/websocket?secret=" + operationData.secret;

          if(operation == "" && operationData.secret == ""){
            alert("Unable to connect via websocket");
            return;
          }
          
          //Create a new "control" websocket
          consoleControlSocket = new WebSocket(consoleControlURL);

          //Listen for "control" websocket errors
          consoleControlSocket.onerror = function (e) {
            console.log("There was a WebSocket error: " + e);
          }

          //Listen for "control" websocket opening connection
          consoleControlSocket.onopen = function (e) {
            console.log( "Console Control WebSocket ReadyState: " + consoleControlSocket.readyState ); 
          };
  
          //Listen for "control" websocket messages
          consoleControlSocket.onmessage = function (e) {      
            if (e.data instanceof ArrayBuffer) {
              if (convertArrayBuffer2String(e.data) != null){
                consoleTerminal.write(convertArrayBuffer2String(e.data));
              }
            }
          };

          //Listen for "control" websocket closing
          consoleControlSocket.onclose = function (e) {
            console.log(e);
          };

          //Create a new "data" websocket
          consoleDataSocket = new WebSocket(consoleDataURL);
            
          //Listen for "data" websocket errors
          consoleDataSocket.onerror = function (e) {
            console.log("There was a WebSocket error: " + e);
          }

          //Listen for "data" websocket opening connection
          consoleDataSocket.onopen = function (e) {
            //Set binaryType to ArrayBuffer. This should be default value
            consoleDataSocket.binaryType = 'arraybuffer';
            
            console.log( "Console Data WebSocket ReadyState: " + consoleDataSocket.readyState );
            consoleTerminal.write("--- Encrypted Connection Opened via WebSocket --- \r\n");

            //Send return to show login screen on console connections
            setTimeout(() => { consoleDataSocket.send(convertString2ArrayBuffer('\r')); }, 1000);
            
            //Switch console action buttons
            $("#startConsoleButton").hide();
            $("#stopConsoleButton").show();
          };
      
          //Listen for "data" websocket messages
          consoleDataSocket.onmessage = function (e) {      
            if (e.data instanceof ArrayBuffer) {
              if (convertArrayBuffer2String(e.data) != null){
                consoleTerminal.write(convertArrayBuffer2String(e.data));
              }
            }
          };

          //Listen for "data" websocket closing
          consoleDataSocket.onclose = function (e) {
            console.log(e);
            consoleTerminal.write("\r\n--- Encrypted Connection Closed ---\r\n");
            $("#stopConsoleButton").hide();
            $("#startConsoleButton").show();
          };

        });

      })
      .catch((error) => {
        console.log("Error: ", error)
        //If we make it here then we had an error connection to LXD server. Most likely the Self-Signed Certificate is not yet trusted by the user's browser
        data = 'There was an error connecting to your LXD server. <br />The LXD server may be using a self-signed certificate. <br />Visit <a href="https://' + host + ':' + port + '" target="_blank">https://' + host + ':' + port +'</a> to accept the certificate if not yet trusted.';
        $("#webSocketConnectionError").html(data);
        $('#webSocketConnectionErrorModal').modal('show');
      })

    });

  }

  function establishInstanceWebSocketExecConnection() {
    $.get("./backend/lxd/containers-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&action=retrieveHostAndPort", function (data) {
      var operationData = JSON.parse(data);
      console.log(operationData);
      var host = operationData.host;
      var port = operationData.port;

      //Check to see if we can connect to the LXD remote host over a secure connection
      fetch('https://' + host + ':' + port + '/1.0', { mode: 'no-cors' })
      .then(response => {
        //If we made it here then the self-signed LXD certificate would have been already trusted by the user's browser we can setup a secure websocket connection
        var execShellInput = $("#execShellInput").val();
        $.get("./backend/lxd/containers-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&shell=" + encodeURI(execShellInput) + "&action=establishInstanceWebSocketExecConnection", function (data) {
          var operationData = JSON.parse(data);
          var operation = operationData.operation;
          var execControlURL = "wss://" + host + ":" + port + operation + "/websocket?secret=" + operationData.control;
          var execDataURL = "wss://" + host + ":" + port + operation + "/websocket?secret=" + operationData.secret;

          if(operation == "" && operationData.secret == ""){
            alert("Unable to connect via websocket");
            return;
          }
          
          //Create a new "control" websocket
          execControlSocket = new WebSocket(execControlURL);

          //Listen for "control" websocket errors
          execControlSocket.onerror = function (e) {
            console.log("There was a WebSocket error: " + e);
          }

          //Listen for "control" websocket opening connection
          execControlSocket.onopen = function (e) {
            console.log( "Exec Control WebSocket ReadyState: " + execControlSocket.readyState ); 
          };
  
          //Listen for "control" websocket messages
          execControlSocket.onmessage = function (e) {      
            if (e.data instanceof ArrayBuffer) {
              if (convertArrayBuffer2String(e.data) != null){
                execTerminal.write(convertArrayBuffer2String(e.data));
              }
            }
          };

          //Listen for "control" websocket closing
          execControlSocket.onclose = function (e) {
            console.log(e);
          };

          //Create a new "data" websocket
          execDataSocket = new WebSocket(execDataURL);
            
          //Listen for "data" websocket errors
          execDataSocket.onerror = function (e) {
            console.log("There was a WebSocket error: " + e);
          }

          //Listen for "data" websocket opening connection
          execDataSocket.onopen = function (e) {
            //Set binaryType to ArrayBuffer. This should be default value
            execDataSocket.binaryType = 'arraybuffer';
            
            console.log( "Exec Data WebSocket ReadyState: " + execDataSocket.readyState );
            execTerminal.write("--- Encrypted Connection Opened via WebSocket --- \r\n");

            //Switch console action buttons
            $("#startExecButton").hide();
            $("#stopExecButton").show();
          };
      
          //Listen for "data" websocket messages
          execDataSocket.onmessage = function (e) {      
            if (e.data instanceof ArrayBuffer) {
              if (convertArrayBuffer2String(e.data) != null){
                execTerminal.write(convertArrayBuffer2String(e.data));
              }
            }
          };

          //Listen for "data" websocket closing
          execDataSocket.onclose = function (e) {
            console.log(e);
            execTerminal.write("\r\n--- Encrypted Connection Closed ---\r\n");
            $("#stopExecButton").hide();
            $("#startExecButton").show();
          };

        });

      })
      .catch((error) => {
        console.log("Error: ", error)
        //If we make it here then we had an error connection to LXD server. Most likely the Self-Signed Certificate is not yet trusted by the user's browser
        data = 'There was an error connecting to your LXD server. <br />The LXD server may be using a self-signed certificate. <br />Visit <a href="https://' + host + ':' + port + '" target="_blank">https://' + host + ':' + port +'</a> to accept the certificate if not yet trusted.';
        $("#webSocketConnectionError").html(data);
        $('#webSocketConnectionErrorModal').modal('show');
      })

    });

  }

  function closeWebSocketConsoleConnection() {
    //Closing the "control" websocket for console operations will stop the operation without crashing existing host's WebSockets.
    consoleControlSocket.close();
    consoleDataSocket.close();
  }

  function closeWebSocketExecConnection() {
    //Sending Ctrl+d (exit) three times to back out of potential nested shells or logins up to three deep. If not logged out, WebSocket operation may continue to run.
    execDataSocket.send(convertString2ArrayBuffer('\04 \r \04 \r \04 \r'))

    //Closing the "control" websocket for console operations will stop the operation without crashing existing host WebSockets.
    execControlSocket.close();
    execDataSocket.close();
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
      $(".progress-circle").each(function() {
        var value = $(this).attr('data-value');
        var left = $(this).find('.progress-circle-left .progress-circle-bar');
        var right = $(this).find('.progress-circle-right .progress-circle-bar');

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
    $('#remoteBreadCrumb').attr("href", "remotes-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName));
    $('#containersBreadCrumb').text("Containers");
    $('#containersBreadCrumb').attr("href", "containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName));

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

        //Populate the select options fields used in modals
        $("#selectProfileInput").load("./backend/lxd/profiles.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listProfilesForSelectOption");
        $("#selectClusterInput").load("./backend/lxd/cluster-members.php?remote=" + encodeURI(remoteId) + "&action=listClusterMembersForSelectOption");

        //When tab changes, set active tab for content refresh
        $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
          clearTimeout(pageReloadTimeout);  //clear reload because new tab is being loaded
          activeTab = $(e.target).attr("href"); // activated tab
          loadTabContent(activeTab); //call new tab to load
        });

        //Initialize xterm for Console
        consoleTerminal = new Terminal({
          cursorBlink: "block"
        });

        //Setup listener for Console terminal
        consoleTerminal.onData( (data) => {
          if (consoleDataSocket.readyState === 1) {
            consoleDataSocket.send(convertString2ArrayBuffer(data))
          }
        });

        //Initialize xterm for Exec
        execTerminal = new Terminal({
          cursorBlink: "block"
        });

        //Setup listener for Exec terminal
        execTerminal.onData( (data) => {
          if (execDataSocket.readyState === 1) {
            execDataSocket.send(convertString2ArrayBuffer(data))
          }
        });

        //Open Console terminal
        consoleTerminal.open(document.getElementById("terminal-console"));

        //Open Exec terminal
        execTerminal.open(document.getElementById("terminal-exec"));

        //Add Event Listener for page unloading to close WebSocket connections
        window.addEventListener("beforeunload", function () {
          //Check to see if the Console WebSocket was initiated
          if (typeof consoleDataSocket == "object"){
            if(consoleDataSocket.readyState == WebSocket.OPEN){
              closeWebSocketConsoleConnection()
            }
          }
          //Check to see if the Exec WebSocket was initiated
          if (typeof execDataSocket == "object"){
            if(execDataSocket.readyState == WebSocket.OPEN){
              closeWebSocketExecConnection();
            }
          }
        });

      }
      else {
        alert("Unable to connect to remote host. HTTP status code: " + operationData.status_code);
      }
    });

    //Load the about info for the about modal
    $.get("./backend/config/about.php", function (data) {
      $("#about").html(data);
    });

  });

</script>

</html>