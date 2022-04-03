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
                    </div>
                    <h2 class="page-header-title mt-2">
                      CONTAINERS
                    </h2>
                    <div class="page-header-subtitle">
                      Select a container for more options specific to the instance.
                    </div>
                  </div>
                  <div class="col-12 col-xl-auto mt-4">
                    <div class="input-group input-group-joined border-0" style="width: 14rem">
                      <span class="input-group-text bg-transparent border-0">
                        <a class="btn btn-outline-primary" href="#" data-toggle="modal" data-target="#createInstanceModal" title="New Container" aria-hidden="true">
                          <i class="fas fa-plus fa-sm fa-fw"></i> Container
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
              <!-- Instance List -->
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold">
                    <span class="ml-1">Container List</span>
                  </h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle mr-2" href="#" onclick="reloadPageContent()" title="Refresh" aria-hidden="true">
                      <i class="fa fa-sync fa-1x fa-fw"></i></a>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table" id="instanceListTable" width="100%" cellspacing="0">
                    </table>
                  </div>
                </div>
              </div>
              <!-- End Instance List -->
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

  <!-- Create Instance Modal-->
  <div class="modal fade" id="createInstanceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Container</h5>
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
                  <label class="col-3 col-form-label text-right">Name: <span class="text-danger">*</span> </label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="containerNameInput" class="form-control" required="required" placeholder="">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in a name for this container'></i>
                  </div>
                </div>

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

                <div class="row">
                  <label class="col-3 col-form-label text-right">Image: </label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="containerImageInput" class="form-control" name="containerImageInput">
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Select a downloaded image to use to build the container'></i>
                  </div>
                </div>

                <div class="row">
                  <label class="col-3 col-form-label text-right">Profile: </label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="containerProfileInput" class="form-control" name="containerProfileInput">
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Select the initial profile to attach to this container. Additional profiles can be attached after the container is created. Default: default'></i>
                  </div>
                </div>

                <div class="row">
                  <label class="col-3 col-form-label text-right">Instance Type: </label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="containerInstanceTypeInput" class="form-control" name="containerInstanceTypeInput">
                        <option value="" selected>(not set)</option>
                        <option disabled>--- AWS Instance Types ---</option>
                        <option value="aws:c1.medium">c1.medium</option>
                        <option value="aws:c1.xlarge">c1.xlarge</option>
                        <option value="aws:c3.2xlarge">c3.2xlarge</option>
                        <option value="aws:c3.4xlarge">c3.4xlarge</option>
                        <option value="aws:c3.8xlarge">c3.8xlarge</option>
                        <option value="aws:c3.large">c3.large</option>
                        <option value="aws:c3.xlarge">c3.xlarge</option>
                        <option value="aws:c4.2xlarge">c4.2xlarge</option>
                        <option value="aws:c4.4xlarge">c4.4xlarge</option>
                        <option value="aws:c4.8xlarge">c4.8xlarge</option>
                        <option value="aws:c4.large">c4.large</option>
                        <option value="aws:c4.xlarge">c4.xlarge</option>
                        <option value="aws:c5.large">c5.large</option>
                        <option value="aws:c5.xlarge">c5.xlarge</option>
                        <option value="aws:c5.2xlarge">c5.2xlarge</option>
                        <option value="aws:c5.4xlarge">c5.4xlarge</option>
                        <option value="aws:c5.9xlarge">c5.9xlarge</option>
                        <option value="aws:c5.18xlarge">c5.18xlarge</option>
                        <option value="aws:cc2.8xlarge">cc2.8xlarge</option>
                        <option value="aws:cg1.4xlarge">cg1.4xlarge</option>
                        <option value="aws:cr1.8xlarge">cr1.8xlarge</option>
                        <option value="aws:d2.xlarge">d2.xlarge</option>
                        <option value="aws:d2.2xlarge">d2.2xlarge</option>
                        <option value="aws:d2.4xlarge">d2.4xlarge</option>
                        <option value="aws:d2.8xlarge">d2.8xlarge</option>
                        <option value="aws:f1.2xlarge">f1.2xlarge</option>
                        <option value="aws:f1.16xlarge">f1.16xlarge</option>
                        <option value="aws:g2.2xlarge">g2.2xlarge</option>
                        <option value="aws:g2.8xlarge">g2.8xlarge</option>
                        <option value="aws:g3.4xlarge">g3.4xlarge</option>
                        <option value="aws:g3.8xlarge">g3.8xlarge</option>
                        <option value="aws:g3.16xlarge">g3.16xlarge</option>
                        <option value="aws:hi1.4xlarge">hi1.4xlarge</option>
                        <option value="aws:hs1.8xlarge">hs1.8xlarge</option>
                        <option value="aws:i2.xlarge">i2.xlarge</option>
                        <option value="aws:i2.2xlarge">i2.2xlarge</option>
                        <option value="aws:i2.4xlarge">i2.4xlarge</option>
                        <option value="aws:i2.8xlarge">i2.8xlarge</option>
                        <option value="aws:i3.large">i3.large</option>
                        <option value="aws:i3.xlarge">i3.xlarge</option>
                        <option value="aws:i3.2xlarge">i3.2xlarge</option>
                        <option value="aws:i3.4xlarge">i3.4xlarge</option>
                        <option value="aws:i3.8xlarge">i3.8xlarge</option>
                        <option value="aws:i3.16xlarge">i3.16xlarge</option>
                        <option value="aws:m1.small">m1.small</option>
                        <option value="aws:m1.medium">m1.medium</option>
                        <option value="aws:m1.large">m1.large</option>
                        <option value="aws:m1.xlarge">m1.xlarge</option>
                        <option value="aws:m2.xlarge">m2.xlarge</option>
                        <option value="aws:m2.2xlarge">m2.2xlarge</option>
                        <option value="aws:m2.4xlarge">m2.4xlarge</option>
                        <option value="aws:m3.medium">m3.medium</option>
                        <option value="aws:m3.large">m3.large</option>
                        <option value="aws:m3.xlarge">m3.xlarge</option>
                        <option value="aws:m3.2xlarge">m3.2xlarge</option>
                        <option value="aws:m4.large">m4.large</option>
                        <option value="aws:m4.xlarge">m4.xlarge</option>
                        <option value="aws:m4.2xlarge">m4.2xlarge</option>
                        <option value="aws:m4.4xlarge">m4.4xlarge</option>
                        <option value="aws:m4.10xlarge">m4.10xlarge</option>
                        <option value="aws:m4.16xlarge">m4.16xlarge</option>
                        <option value="aws:p2.xlarge">p2.xlarge</option>
                        <option value="aws:p2.8xlarge">p2.8xlarge</option>
                        <option value="aws:p2.16xlarge">p2.16xlarge</option>
                        <option value="aws:r3.large">r3.large</option>
                        <option value="aws:r3.xlarge">r3.xlarge</option>
                        <option value="aws:r3.2xlarge">r3.2xlarge</option>
                        <option value="aws:r3.4xlarge">r3.4xlarge</option>
                        <option value="aws:r3.8xlarge">r3.8xlarge</option>
                        <option value="aws:r4.large">r4.large</option>
                        <option value="aws:r4.xlarge">r4.xlarge</option>
                        <option value="aws:r4.2xlarge">r4.2xlarge</option>
                        <option value="aws:r4.4xlarge">r4.4xlarge</option>
                        <option value="aws:r4.8xlarge">r4.8xlarge</option>
                        <option value="aws:r4.16xlarge">r4.16xlarge</option>
                        <option value="aws:t1.micro">t1.micro</option>
                        <option value="aws:t2.nano">t2.nano</option>
                        <option value="aws:t2.micro">t2.micro</option>
                        <option value="aws:t2.small">t2.small</option>
                        <option value="aws:t2.medium">t2.medium</option>
                        <option value="aws:t2.large">t2.large</option>
                        <option value="aws:t2.xlarge">t2.xlarge</option>
                        <option value="aws:t2.2xlarge">t2.2xlarge</option>
                        <option value="aws:t3.nano">t3.nano</option>
                        <option value="aws:t3.micro">t3.micro</option>
                        <option value="aws:t3.small">t3.small</option>
                        <option value="aws:t3.medium">t3.medium</option>
                        <option value="aws:t3.large">t3.large</option>
                        <option value="aws:t3.xlarge">t3.xlarge</option>
                        <option value="aws:t3.2xlarge">t3.2xlarge</option>
                        <option value="aws:x1.16xlarge">x1.16xlarge</option>
                        <option value="aws:x1.32xlarge">x1.32xlarge</option>
                        <option disabled>--- Azure Instance Types ---</option>
                        <option value="azure:A5">A5</option>
                        <option value="azure:A6">A6</option>
                        <option value="azure:A7">A7</option>
                        <option value="azure:A8">A8</option>
                        <option value="azure:A9">A9</option>
                        <option value="azure:A10">A10</option>
                        <option value="azure:A11">A11</option>
                        <option value="azure:ExtraSmall">ExtraSmall</option>
                        <option value="azure:Small">Small</option>
                        <option value="azure:Medium">Medium</option>
                        <option value="azure:Large">Large</option>
                        <option value="azure:ExtraLarge">ExtraLarge</option>
                        <option value="azure:Standard_A1_v2">Standard_A1_v2</option>
                        <option value="azure:Standard_A2m_v2">Standard_A2m_v2</option>
                        <option value="azure:Standard_A2_v2">Standard_A2_v2</option>
                        <option value="azure:Standard_A4m_v2">Standard_A4m_v2</option>
                        <option value="azure:Standard_A4_v2">Standard_A4_v2</option>
                        <option value="azure:Standard_A8m_v2">Standard_A8m_v2</option>
                        <option value="azure:Standard_A8_v2">Standard_A8_v2</option>
                        <option value="azure:Standard_D1">Standard_D1</option>
                        <option value="azure:Standard_D1_v2">Standard_D1_v2</option>
                        <option value="azure:Standard_D2">Standard_D2</option>
                        <option value="azure:Standard_D2_v2">Standard_D2_v2</option>
                        <option value="azure:Standard_D3">Standard_D3</option>
                        <option value="azure:Standard_D3_v2">Standard_D3_v2</option>
                        <option value="azure:Standard_D4">Standard_D4</option>
                        <option value="azure:Standard_D4_v2">Standard_D4_v2</option>
                        <option value="azure:Standard_D5_v2">Standard_D5_v2</option>
                        <option value="azure:Standard_D11">Standard_D11</option>
                        <option value="azure:Standard_D11_v2">Standard_D11_v2</option>
                        <option value="azure:Standard_D12">Standard_D12</option>
                        <option value="azure:Standard_D12_v2">Standard_D12_v2</option>
                        <option value="azure:Standard_D13">Standard_D13</option>
                        <option value="azure:Standard_D13_v2">Standard_D13_v2</option>
                        <option value="azure:Standard_D14">Standard_D14</option>
                        <option value="azure:Standard_D14_v2">Standard_D14_v2</option>
                        <option value="azure:Standard_D15_v2">Standard_D15_v2</option>
                        <option value="azure:Standard_G1">Standard_G1</option>
                        <option value="azure:Standard_G2">Standard_G2</option>
                        <option value="azure:Standard_G3">Standard_G3</option>
                        <option value="azure:Standard_G4">Standard_G4</option>
                        <option value="azure:Standard_G5">Standard_G5</option>
                        <option value="azure:Standard_H8">Standard_H8</option>
                        <option value="azure:Standard_H8m">Standard_H8m</option>
                        <option value="azure:Standard_H16">Standard_H16</option>
                        <option value="azure:Standard_H16m">Standard_H16m</option>
                        <option value="azure:Standard_H16mr">Standard_H16mr</option>
                        <option value="azure:Standard_H16r">Standard_H16r</option>
                        <option disabled>--- GCE Instance Types ---</option>
                        <option value="gce:f1-micro">f1-micro</option>
                        <option value="gce:g1-small">g1-small</option>
                        <option value="gce:n1-highcpu-2">n1-highcpu-2</option>
                        <option value="gce:n1-highcpu-4">n1-highcpu-4</option>
                        <option value="gce:n1-highcpu-8">n1-highcpu-8</option>
                        <option value="gce:n1-highcpu-16">n1-highcpu-16</option>
                        <option value="gce:n1-highcpu-32">n1-highcpu-32</option>
                        <option value="gce:n1-highcpu-64">n1-highcpu-64</option>
                        <option value="gce:n1-highmem-2">n1-highmem-2</option>
                        <option value="gce:n1-highmem-4">n1-highmem-4</option>
                        <option value="gce:n1-highmem-8">n1-highmem-8</option>
                        <option value="gce:n1-highmem-16">n1-highmem-16</option>
                        <option value="gce:n1-highmem-32">n1-highmem-32</option>
                        <option value="gce:n1-highmem-64">n1-highmem-64</option>
                        <option value="gce:n1-standard-1">n1-standard-1</option>
                        <option value="gce:n1-standard-2">n1-standard-2</option>
                        <option value="gce:n1-standard-4">n1-standard-4</option>
                        <option value="gce:n1-standard-8">n1-standard-8</option>
                        <option value="gce:n1-standard-16">n1-standard-16</option>
                        <option value="gce:n1-standard-32">n1-standard-32</option>
                        <option value="gce:n1-standard-64">n1-standard-64</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Select from a variety of preconfigured container configurations. Default: (not set)'></i>
                  </div>
                </div>
    
                <div class="row">
                  <label class="col-3 col-form-label text-right">Location: </label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="containerLocationInput" class="form-control" name="containerLocationInput">
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Select the LXD cluster member to deploy this container on. Default: none'></i>
                  </div>
                </div>

                <hr class="mb-2">
                <nav>
                  <div class="nav nav-pills justify-content-center" id="nav-tab" role="tablist">
                    <a class="nav-link active" id="nav-boot-tab" data-toggle="tab" href="#nav-boot" role="tab" aria-controls="nav-boot" aria-selected="true">Boot</a>
                    <a class="nav-link" id="nav-limits-tab" data-toggle="tab" href="#nav-limits" role="tab" aria-controls="nav-limits" aria-selected="false">Limits</a>
                    <a class="nav-link" id="nav-migration-tab" data-toggle="tab" href="#nav-migration" role="tab" aria-controls="nav-migration" aria-selected="false">Migration</a>
                    <a class="nav-link" id="nav-nvidia-tab" data-toggle="tab" href="#nav-nvidia" role="tab" aria-controls="nav-nvidia" aria-selected="false">Nvidia</a>
                    <a class="nav-link" id="nav-other-tab" data-toggle="tab" href="#nav-other" role="tab" aria-controls="nav-other" aria-selected="false">Other</a>
                    <a class="nav-link" id="nav-raw-tab" data-toggle="tab" href="#nav-raw" role="tab" aria-controls="nav-raw" aria-selected="false">Raw</a>
                    <a class="nav-link" id="nav-security-tab" data-toggle="tab" href="#nav-security" role="tab" aria-controls="nav-security" aria-selected="false">Security</a>
                    <a class="nav-link" id="nav-snapshots-tab" data-toggle="tab" href="#nav-snapshots" role="tab" aria-controls="nav-snapshots" aria-selected="false">Snapshots</a>
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
                  <div class="tab-pane fade" id="nav-snapshots" role="tabpanel" aria-labelledby="nav-snapshots-tab">
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
                  <a class="btn btn-primary" href="#" onclick="createInstanceUsingForm()" data-dismiss="modal">Ok</a>
                </div>
              </div>
              <div class="tab-pane fade" id="json" role="tabpanel" aria-labelledby="json-tab">
                <br />
                <div class="row">
                  <div class="col-12">
                    <div class="form-group text-right">
                      <pre>
                        <textarea name="json" class="form-control" id="jsonCreateInput" rows="16" placeholder="Enter JSON data"></textarea>
                      </pre>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                  <a class="btn btn-primary" href="#" onclick="createInstanceUsingJSON()" data-dismiss="modal">Submit</a>
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

    $('#instanceListTable').DataTable().ajax.reload(null, false);

    //Set reload page content
    pageReloadTimeout = setTimeout(() => { reloadPageContent(); }, reloadTime);
  }
  
  function loadPageContent(){

    //Display current logged in username
    $("#username").load("./backend/admin/settings.php?action=displayUsername");

    $('#instanceListTable').DataTable( {
      ajax: "./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listInstances",
      columns: [
        {},
        { title: "Name" },
        { title: "OS" },
        { title: "Location" },
        { title: "IPv4" },
        { title: "IPv6" },
        { title: "Memory" },
        { title: "Root Disk" },
        { title: "Status" },
        { title: "Action" }
      ],
      order: [],
      columnDefs: [
        { targets: 0, orderable: false, width: "25px" }
      ]
    });
    
    //Check for any running operations
    operationTimeout = setTimeout(() => { operationStatusCheck(); }, 1000);

    //Set reload page content
    $.get("./backend/admin/settings.php?action=retrievePageRefreshRateValues", function (data) {
      operationData = JSON.parse(data);
      if (operationData.containers_page_rate >= 1)
        reloadTime = operationData.containers_page_rate * 1000;
      pageReloadTimeout = setTimeout(() => { reloadPageContent(); }, reloadTime);
    });

  }

  function createInstanceUsingForm(){
    var instanceName = $("#containerNameInput").val();
    var instanceDescription = $("#containerDescriptionInput").val();
    var fingerprint = $("#containerImageInput").val();
    var profileName = $("#containerProfileInput").val();
    var containerType = $("#containerInstanceTypeInput").val();
    var location = $("#containerLocationInput").val();
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

    console.log("Info: creating container " + instanceName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + 
    "&name=" + encodeURI(instanceName) + 
    "&description=" + encodeURI(instanceDescription) + 
    "&fingerprint=" + encodeURI(fingerprint) + 
    "&profile=" + encodeURI(profileName) + 
    "&instance_type=" + encodeURI(containerType) + 
    "&location=" + encodeURI(location) + 
    "&linux_kernel_modules=" + encodeURI(linuxKernelModules) + 

    "&boot_autostart=" + encodeURI(bootAutostart) + 
    "&boot_autostart_delay=" + encodeURI(bootAutostartDelay) + 
    "&boot_autostart_priority=" + encodeURI(bootAutostartPriority) + 
    "&boot_host_shutdown_timeout=" + encodeURI(bootHostShutdownTimeout) + 
    "&boot_stop_priority=" + encodeURI(bootStopPriority) + 

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

    "&cluster_evacuate=" + encodeURI(clusterEvacuate) + 
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

    "&action=createInstanceUsingForm",  function (data) {
      //Sync type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function createInstanceUsingJSON(){
    var containerCreateJSON = $("#jsonCreateInput").val();
    console.log("Info: creating container");
    $.post("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=createInstanceUsingJSON", {json: containerCreateJSON},  function (data) {
      //Sync type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function startInstance(instanceName){
    console.log("Info: starting container " + instanceName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&action=startInstance",  function (data) {
      //Async type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      operationStatusCheck();
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function stopInstance(instanceName){
    console.log("Info: stopping container " + instanceName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&action=stopInstance",  function (data) {
      //Async type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      operationStatusCheck();
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function unfreezeInstance(instanceName){
    console.log("Info: unfreezing container " + instanceName);
    $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&action=unfreezeInstance",  function (data) {
      //Async type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      operationStatusCheck();
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function confirmDeleteInstance(instanceName){
    console.log("Info: confirming deletion of container " + instanceName);
    if (confirm("Are you sure you want to delete container " + instanceName + "?") == true) {
      $.get("./backend/lxd/containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&action=deleteInstance", function (data) {
        var operationData = JSON.parse(data);
        console.log(operationData);
        if (operationData.metadata.status_code >= 400){
          alert(operationData.metadata.err)
        }
        setTimeout(() => { reloadPageContent(); }, 1000);
      });
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

    //Load in the sidebar
    $("#sidebarLinks").load("./sidebar.php?version=3.0");
    
    //Setup Page Breadcrumb Links/Information
    $('#remoteBreadCrumb').load("./backend/lxd/remote-breadcrumb.php?remote=" + encodeURI(remoteId));
    $('#remoteBreadCrumb').attr("href", "remotes-single.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName));

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
        $("#containerProfileInput").load("./backend/lxd/profiles.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listProfilesForSelectOption");
        $("#containerLocationInput").load("./backend/lxd/cluster-members.php?remote=" + encodeURI(remoteId) + "&include_none=true&action=listClusterMembersForSelectOption");
        $("#containerImageInput").load("./backend/lxd/images.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&image_type=container&action=listImagesForSelectOption");
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