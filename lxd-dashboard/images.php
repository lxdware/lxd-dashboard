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

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
                    </div>
                    <h2 class="page-header-title mt-2">
                      IMAGES
                    </h2>
                    <div class="page-header-subtitle">
                      Download and manage operating system images
                    </div>
                  </div>
                  <div class="col-12 col-xl-auto mt-4">
                    <div class="input-group input-group-joined border-0" style="width: 14rem">
                      <span class="input-group-text bg-transparent border-0">
                        <a class="btn btn-outline-primary" href="#" data-toggle="modal" data-target="#downloadImageModal" title="Download Image" aria-hidden="true">
                          <i class="fas fa-plus fa-sm fa-fw"></i> Image
                        </a>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </header>

          <div class="row mt-n5 ml-2 mr-2">

            <div class="col-12 mt-n3">
              <!-- Image List -->
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold">
                    <span class="ml-1">Images</span>
                  </h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle mr-2" href="#" onclick="reloadPageContent()" title="Refresh" aria-hidden="true">
                      <i class="fa fa-sync fa-1x fa-fw"></i></a>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table" id="imageListTable" width="100%" cellspacing="0">
                    </table>
                  </div>
                </div>
              </div>
              <!-- End Image List -->
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

  <!-- Download Image Modal-->
  <div class="modal fade" id="downloadImageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Download Image</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="catalog-tab" data-toggle="tab" href="#catalog" role="tab" aria-controls="catalog" aria-selected="true">Catalog</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="form-tab" data-toggle="tab" href="#form" role="tab" aria-controls="form" aria-selected="false">Form</a>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="catalog" role="tabpanel" aria-labelledby="catelog-tab">
              <div class="row mt-4">

                <!--Ubuntu 20.04 Official Download-->
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-3 mb-4">
                  <div class="card shadow">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Ubuntu</h6>
                      <div class="dropdown no-arrow">
                        <button class="btn btn-success btn-xs" href="#" onclick="" title="" aria-hidden="true">
                          OFFICAL</button>
                      </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body pb-0">
                      <div class="row">
                        <div class="col-4">
                          <img class="mb-2" src="vendor/images/ubuntu.png" style="width: 65px; height: 65px;"><br>
                        </div>
                        <div class="col-8 text-center mt-3">
                          <span class="h5">20.04</span>
                        </div>
                      </div>
                      
                      <span class="font-weight-bold">Image</span>: <span class="">20.04</span> <br />
                      <span class="font-weight-bold">Repository</span>: <span class="">ubuntu</span>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-right">
                      <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Download
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('container','20.04','ubuntu')">Container</a>
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('virtual-machine','20.04','ubuntu')">Virtual Machine</a>
                        </div>
                      </div> 
                    </div>
                  </div>
                </div>
                <!--End Ubuntu 20.04 Download-->

                <!--CentOS 8 Download-->
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-3 mb-4">
                  <div class="card shadow">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Centos</h6>
                      <div class="dropdown no-arrow">
                        <button class="btn btn-outline-success btn-xs" href="#" onclick="" title="" aria-hidden="true">
                          COMMUNITY</button>
                      </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body pb-0">
                      <div class="row">
                        <div class="col-4">
                          <img class="mb-2" src="vendor/images/centos.png" style="width: 65px; height: 65px;"><br>
                        </div>
                        <div class="col-8 text-center mt-3">
                          <span class="h5">8</span>
                        </div>
                      </div>
                      
                      <span class="font-weight-bold">Image</span>: <span class="">centos/8</span> <br />
                      <span class="font-weight-bold">Repository</span>: <span class="">images</span>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-right">
                      <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Download
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('container','centos/8','images')">Container</a>
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('virtual-machine','centos/8','images')">Virtual Machine</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--End CentOS 8 Download-->

                <!--Debian Bullseye Download-->
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-3 mb-4">
                  <div class="card shadow">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Debian</h6>
                      <div class="dropdown no-arrow">
                        <button class="btn btn-outline-success btn-xs" href="#" onclick="" title="" aria-hidden="true">
                          COMMUNITY</button>
                      </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body pb-0">
                      <div class="row">
                        <div class="col-4">
                          <img class="mb-2" src="vendor/images/debian.png" style="width: 65px; height: 65px;"><br>
                        </div>
                        <div class="col-8 text-center mt-3">
                          <span class="h5">Bullseye</span>
                        </div>
                      </div>
                      
                      <span class="font-weight-bold">Image</span>: <span class="">debian/bullseye</span> <br />
                      <span class="font-weight-bold">Repository</span>: <span class="">images</span>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-right">
                      <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Download
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('container','debian/bullseye','images')">Container</a>
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('virtual-machine','debian/bullseye','images')">Virtual Machine</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--End Debian Bullseye Download-->

                <!--OpenSUSE 15.3 Download-->
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-3 mb-4">
                  <div class="card shadow">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">OpenSUSE</h6>
                      <div class="dropdown no-arrow">
                        <button class="btn btn-outline-success btn-xs" href="#" onclick="" title="" aria-hidden="true">
                          COMMUNITY</button>
                      </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body pb-0">
                      <div class="row">
                        <div class="col-4">
                          <img class="mb-2" src="vendor/images/opensuse.png" style="width: 65px; height: 65px;"><br>
                        </div>
                        <div class="col-8 text-center mt-3">
                          <span class="h5">15.3</span>
                        </div>
                      </div>
                      
                      <span class="font-weight-bold">Image</span>: <span class="">opensuse/15.3</span> <br />
                      <span class="font-weight-bold">Repository</span>: <span class="">images</span>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-right">
                      <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Download
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('container','opensuse/15.3','images')">Container</a>
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('virtual-machine','opensuse/15.3','images')">Virtual Machine</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--End openSUSE 15.3 Download-->

                <!--Alpine Linux 3.14 Download-->
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-3 mb-4">
                  <div class="card shadow">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Alpine Linux</h6>
                      <div class="dropdown no-arrow">
                        <button class="btn btn-outline-success btn-xs" href="#" onclick="" title="" aria-hidden="true">
                          COMMUNITY</button>
                      </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body pb-0">
                      <div class="row">
                        <div class="col-4">
                          <img class="mb-2" src="vendor/images/alpine.png" style="width: 65px; height: 65px;"><br>
                        </div>
                        <div class="col-8 text-center mt-3">
                          <span class="h5">3.14</span>
                        </div>
                      </div>
                      
                      <span class="font-weight-bold">Image</span>: <span class="">alpine/3.14</span> <br />
                      <span class="font-weight-bold">Repository</span>: <span class="">images</span>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-right">
                      <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Download
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('container','alpine/3.14','images')">Container</a>
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('virtual-machine','alpine/3.14','images')">Virtual Machine</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--End Alpine Linux Download-->

                <!--Arch Linux Current Download-->
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-3 mb-4">
                  <div class="card shadow">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Arch Linux</h6>
                      <div class="dropdown no-arrow">
                        <button class="btn btn-outline-success btn-xs" href="#" onclick="" title="" aria-hidden="true">
                          COMMUNITY</button>
                      </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body pb-0">
                      <div class="row">
                        <div class="col-4">
                          <img class="mb-2" src="vendor/images/archlinux.png" style="width: 65px; height: 65px;"><br>
                        </div>
                        <div class="col-8 text-center mt-3">
                          <span class="h5">Current</span>
                        </div>
                      </div>
                      
                      <span class="font-weight-bold">Image</span>: <span class="">archlinux/current</span> <br />
                      <span class="font-weight-bold">Repository</span>: <span class="">images</span>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-right">
                      <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Download
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('container','archlinux/current','images')">Container</a>
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('virtual-machine','archlinux/current','images')">Virtual Machine</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--End Arch Linux Download-->

                <!--CentOS 7 Download-->
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-3 mb-4">
                  <div class="card shadow">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Centos</h6>
                      <div class="dropdown no-arrow">
                        <button class="btn btn-outline-success btn-xs" href="#" onclick="" title="" aria-hidden="true">
                          COMMUNITY</button>
                      </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body pb-0">
                      <div class="row">
                        <div class="col-4">
                          <img class="mb-2" src="vendor/images/centos.png" style="width: 65px; height: 65px;"><br>
                        </div>
                        <div class="col-8 text-center mt-3">
                          <span class="h5">7</span>
                        </div>
                      </div>
                      
                      <span class="font-weight-bold">Image</span>: <span class="">centos/7</span> <br />
                      <span class="font-weight-bold">Repository</span>: <span class="">images</span>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-right">
                      <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Download
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('container','centos/7','images')">Container</a>
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('virtual-machine','centos/7','images')">Virtual Machine</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--End CentOS 7 Download-->

                <!--Gentoo Current Download-->
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-3 mb-4">
                  <div class="card shadow">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Gentoo</h6>
                      <div class="dropdown no-arrow">
                        <button class="btn btn-outline-success btn-xs" href="#" onclick="" title="" aria-hidden="true">
                          COMMUNITY</button>
                      </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body pb-0">
                      <div class="row">
                        <div class="col-4">
                          <img class="mb-2" src="vendor/images/gentoo.png" style="width: 65px; height: 65px;"><br>
                        </div>
                        <div class="col-8 text-center mt-3">
                          <span class="h5">Current</span>
                        </div>
                      </div>
                      
                      <span class="font-weight-bold">Image</span>: <span class="">gentoo/current</span> <br />
                      <span class="font-weight-bold">Repository</span>: <span class="">images</span>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-right">
                      <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Download
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('container','gentoo/current','images')">Container</a>
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('virtual-machine','gentoo/current','images')">Virtual Machine</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--End Gentoo Download-->

                <!--Kali Current Download-->
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-3 mb-4">
                  <div class="card shadow">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Kali</h6>
                      <div class="dropdown no-arrow">
                        <button class="btn btn-outline-success btn-xs" href="#" onclick="" title="" aria-hidden="true">
                          COMMUNITY</button>
                      </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body pb-0">
                      <div class="row">
                        <div class="col-4">
                          <img class="mb-2" src="vendor/images/kali.png" style="width: 65px; height: 65px;"><br>
                        </div>
                        <div class="col-8 text-center mt-3">
                          <span class="h5">Current</span>
                        </div>
                      </div>
                      
                      <span class="font-weight-bold">Image</span>: <span class="">kali/current</span> <br />
                      <span class="font-weight-bold">Repository</span>: <span class="">images</span>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-right">
                      <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Download
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('container','kali/current','images')">Container</a>
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('virtual-machine','kali/current','images')">Virtual Machine</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--End Kali Download-->

                <!--OpenSUSE Tumbleweed Download-->
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-3 mb-4">
                  <div class="card shadow">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">OpenSUSE</h6>
                      <div class="dropdown no-arrow">
                        <button class="btn btn-outline-success btn-xs" href="#" onclick="" title="" aria-hidden="true">
                          COMMUNITY</button>
                      </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body pb-0">
                      <div class="row">
                        <div class="col-4">
                          <img class="mb-2" src="vendor/images/opensuse.png" style="width: 65px; height: 65px;"><br>
                        </div>
                        <div class="col-8 text-center mt-3">
                          <span class="h5">Tumbleweed</span>
                        </div>
                      </div>
                      
                      <span class="font-weight-bold">Image</span>: <span class="" style="font-size: .99rem;">opensuse/tumbleweed</span> <br />
                      <span class="font-weight-bold">Repository</span>: <span class="">images</span>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-right">
                      <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Download
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('container','opensuse/tumbleweed','images')">Container</a>
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('virtual-machine','opensuse/tumbleweed','images')">Virtual Machine</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--End openSUSE Tumbleweed Download-->

                <!--OpenWrt 21.02 Download-->
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-3 mb-4">
                  <div class="card shadow">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">OpenWrt</h6>
                      <div class="dropdown no-arrow">
                        <button class="btn btn-outline-success btn-xs" href="#" onclick="" title="" aria-hidden="true">
                          COMMUNITY</button>
                      </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body pb-0">
                      <div class="row">
                        <div class="col-4">
                          <img class="mb-2" src="vendor/images/openwrt.png" style="width: 65px; height: 65px;"><br>
                        </div>
                        <div class="col-8 text-center mt-3">
                          <span class="h5">21.02</span>
                        </div>
                      </div>
                      
                      <span class="font-weight-bold">Image</span>: <span class="" style="font-size: .99rem;">openwrt/21.02</span> <br />
                      <span class="font-weight-bold">Repository</span>: <span class="">images</span>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-right">
                      <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Download
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('container','openwrt/21.02','images')">Container</a>
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('virtual-machine','openwrt/21.02','images')">Virtual Machine</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--End OpenWrt 21.02 Download-->

                <!--Ubuntu 21.10 Download-->
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-3 mb-4">
                  <div class="card shadow">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Ubuntu</h6>
                      <div class="dropdown no-arrow">
                        <button class="btn btn-outline-success btn-xs" href="#" onclick="" title="" aria-hidden="true">
                          COMMUNITY</button>
                      </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body pb-0">
                      <div class="row">
                        <div class="col-4">
                          <img class="mb-2" src="vendor/images/ubuntu.png" style="width: 65px; height: 65px;"><br>
                        </div>
                        <div class="col-8 text-center mt-3">
                          <span class="h5">21.10</span>
                        </div>
                      </div>
                      
                      <span class="font-weight-bold">Image</span>: <span class="">ubuntu/21.10</span> <br />
                      <span class="font-weight-bold">Repository</span>: <span class="">images</span>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-right">
                      <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Download
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('container','ubuntu/21.10','images')">Container</a>
                          <a class="dropdown-item" href="#" data-dismiss="modal" onclick="downloadCatalogImage('virtual-machine','ubuntu/21.10','images')">Virtual Machine</a>
                        </div>
                      </div> 
                    </div>
                  </div>
                </div>
                <!--End Ubuntu 21.10 Download-->

              </div>
            </div>
            <div class="tab-pane fade" id="form" role="tabpanel" aria-labelledby="form-tab">

              <div class="row mt-4">
                <label class="col-2 col-form-label text-right">Image/Alias: <span class="text-danger">*</span></label>
                <div class="col-8">
                  <div class="form-group">
                    <input type="text" class="form-control" id="imageNameInput" required="required" placeholder="" name="image">
                  </div>
                </div>
                <div class="col-1">
                  <i class="far fa-sm fa-question-circle" data-toggle="tooltip" data-html="true" title='(Required) - Enter in the repository specific name. For example, ubuntu/20.04 would be used for the images repository and simply 20.04 would be used for the ubuntu repositories.'></i>
                </div>
  
                <label class="col-2 col-form-label text-right">Repository: <span class="text-danger">*</span></label>
                <div class="col-8">
                  <div class="form-group">
                    <select id="selectRepoInput" class="form-control" name="repo">
                    </select>
                  </div>
                </div>
                <div class="col-1">
                  <i class="far fa-sm fa-question-circle" title='(Required) - Select a repository from the configured simplestreams.'></i>
                </div>
  
                <label class="col-2 col-form-label text-right">Image Type:</label>
                <div class="col-8 text-right">
                  <div class="form-group">
                    <select id="selectTypeInput" class="form-control" name="image_type">
                      <option value="container" selected>container</option>
                      <option value="virtual-machine">virtual-machine</option>
                    </select>
                  </div>
                </div>
                <div class="col-1">
                  <i class="far fa-sm fa-question-circle" title='Select whether to download a container based image or virtual machine. Default: container'></i>
                </div>

              </div>

              <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="#" onclick="downloadImage()" data-dismiss="modal">Ok</a>
              </div>

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <a href="#" data-toggle="modal" data-target="#trademarkNotices" title="Download Image" aria-hidden="true">Trademark notices</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Image Modal-->
  <div class="modal fade" id="editImageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Image</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <label class="col-12 col-form-label" id="imageNameEditInput"></label>
              <div class="col-12">
                <div class="form-group text-right">
                  <pre>
                    <textarea name="json" class="form-control" id="jsonEditInput" rows="16" ></textarea>
                  </pre>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="#" onclick="updateImage()" data-dismiss="modal">Submit</a>
          </div>
      </div>
    </div>
  </div>

  <!-- Trademark Notices Modal-->
  <div class="modal fade" id="trademarkNotices" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Trademark Notices</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div>
                The LXD Dashboard has made all efforts to keep within trademark usage guidlines when using the logos and names of Linux operating systems. Resources for acceptable use guidlines are provided below. The LXD Dashboard is not affliated with any of the Linux operating systems.
                <ul>
                  <li>Alpine is a trademark of Alpine Linux Development Team. Information on Alpine Linux trademark guidelines can be found here <a href="https://alpinelinux.org/" target="_blank">https://alpinelinux.org/</a></li>
                  <li>Arch Linux is a registered trademark of Aaron Griffin and Judd Vinet, on behalf of Arch Linux. Information on Arch Linux trademark guidelines can be found here <a href="https://wiki.archlinux.org/title/DeveloperWiki:TrademarkPolicy" target="_blank">https://wiki.archlinux.org/title/DeveloperWiki:TrademarkPolicy</a></li>
                  <li>CentOS is a trademarks of Red Hat, Inc. (“Red Hat”). Information on CentOS Linux trademark guidelines can be found here <a href="https://www.centos.org/legal/trademarks/" target="_blank">https://www.centos.org/legal/trademarks/</a></li>
                  <li>Debian is a registered trademark owned by Software in the Public Interest, Inc. Information on Debian Linux trademark guidelines can be found here <a href="https://www.debian.org/trademark" target="_blank">https://www.debian.org/trademark</a></li>
                  <li>Gentoo is a registered trademark of the Gentoo Foundation, Inc. Information on the Gentoo Linux trademark guidelines can be found here <a href="https://www.gentoo.org/inside-gentoo/foundation/name-logo-guidelines.html" target="_blank">https://www.gentoo.org/inside-gentoo/foundation/name-logo-guidelines.html</a></li>
                  <li>Kali Linux is a registered trademark of Offensive Security. Information on Kali Linux trademark guidelines can be found here <a href="https://www.kali.org/docs/policy/trademark/" target="_blank">https://www.kali.org/docs/policy/trademark/</a></li>
                  <li>OpenSUSE is a registered trademark of SUSE LLC. Information on the OpenSUSE trademark guidelines can be found here <a href="https://en.opensuse.org/openSUSE:Trademark_guidelines" target="_blank">https://en.opensuse.org/openSUSE:Trademark_guidelines</a></li>
                  <li>OpenWrt trademark is a registered United States trademark of Software Freedom Conservancy (SFC). Information on OpenWrt trademark guidelines can be found here <a href="https://openwrt.org/trademark" target="blank">https://openwrt.org/trademark</a></li>
                  <li>Ubuntu is a registered trademark of Canonical Ltd. Information on Ubuntu Linux trademark guidelines can be found here <a href="https://design.ubuntu.com/brand/ubuntu-logo/" target="_blank">https://design.ubuntu.com/brand/ubuntu-logo/</a></li>           
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Dismiss</button>
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

</body>

<script>
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const remoteId = urlParams.get('remote'); 
  const projectName = urlParams.get('project');
  var selectList = "";
  var imageToUpdate = "";

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

    $('#imageListTable').DataTable().ajax.reload(null, false);

    //Load the select List for Download Image Modal
    $.get("./backend/lxd/simplestreams.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listSimplestreamsForSelectOption", function (data) {
      if (selectList != data){  
        $("#selectRepoInput").html(data);
        selectList = data;
      }
    });

    pageReloadTimeout = setTimeout(() => { reloadPageContent(); }, 7000);
  }
  
  function loadPageContent(){

    //Display current logged in username
    $("#username").load("./backend/admin/settings.php?action=displayUsername");

     $('#imageListTable').DataTable( {
      ajax: "./backend/lxd/images.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listImages",
      columns: [
        {},
        { title: "Description" },
        { title: "Fingerprint" },
        { title: "Type" },
        { title: "Size" },
        { title: "Action" }
      ],
      order: [],
      columnDefs: [
        { targets: 0, orderable: false, width: "25px" }
      ]
    });

    //Load the select List for Download Image Modal
    $.get("./backend/lxd/simplestreams.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listSimplestreamsForSelectOption", function (data) {
      if (selectList != data){  
        $("#selectRepoInput").html(data);
        selectList = data;
      }
    });

    //Check for any running operations
    operationTimeout = setTimeout(() => { operationStatusCheck(); }, 1000);

    //Reload page content in 7 secondsons
    pageReloadTimeout = setTimeout(() => { reloadPageContent(); }, 7000);
  }
    
  function refreshImage(imageFingerprint){
    console.log("Info: refreshing image " + imageFingerprint);
    $.get("./backend/lxd/images.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&fingerprint=" + encodeURI(imageFingerprint) + "&action=refreshImage",  function (data) {
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

  function deleteImage(imageFingerprint){
    console.log("Info: deleting image " + imageFingerprint);
    $.get("./backend/lxd/images.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&fingerprint=" + encodeURI(imageFingerprint) + "&action=deleteImage",  function (data) {
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

  function downloadImage(){
    var imageName = $("#imageNameInput").val();
    var repoName = $("#selectRepoInput").val();
    var imageType = $("#selectTypeInput").val();
    console.log("Info: downloading image " + imageName + " from " + repoName);
    $.get("./backend/lxd/images.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&image=" + encodeURI(imageName) + "&repo=" + encodeURI(repoName) + "&image_type=" + encodeURI(imageType) + "&action=downloadImage",  function (data) {
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

  function downloadCatalogImage(imageType, imageName, repoName){
    if (repoName == 'ubuntu') { repoName = 'https://cloud-images.ubuntu.com/releases'}
    if (repoName == 'images') { repoName = 'https://images.linuxcontainers.org'}
    console.log("Info: downloading image " + imageName + " from " + repoName);
    $.get("./backend/lxd/images.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&image=" + encodeURI(imageName) + "&repo=" + encodeURI(repoName) + "&image_type=" + encodeURI(imageType) + "&action=downloadImage",  function (data) {
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

  function loadImageJson(imageToLoad){
    console.log("Info: loading image " + imageToLoad);
    imageToUpdate = imageToLoad;
    $.get("./backend/lxd/images.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&fingerprint=" + encodeURI(imageToLoad) + "&action=loadImage", function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      $("#imageNameEditInput").text("Fingerprint: " + imageToLoad);
      $("#jsonEditInput").val(JSON.stringify(operationData.metadata, null, 2));
      $("#editImageModal").modal('show');
    });
  }

  function updateImage(){
    var imageUpdateJSON = $("#jsonEditInput").val();
    console.log("Info: updating image " + imageToUpdate);
    $.post("./backend/lxd/images.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&fingerprint=" + encodeURI(imageToUpdate) + "&action=updateImage", {json: imageUpdateJSON},  function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
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

    //Set top navbar dropdowns
    $("#remoteListNav").load("./backend/lxd/remotes.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listRemotesForSelectOption");
    $("#projectListNav").load("./backend/lxd/projects.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listProjectsForSelectOption");

    //Load the card contents
    loadPageContent();

    //Load the about info for the about modal
    $.get("./backend/config/about.php", function (data) {
      $("#about").html(data);
    });

  });

</script>

</html>