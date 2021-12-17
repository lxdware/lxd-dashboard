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
                      VIRTUAL MACHINES
                    </h2>
                    <div class="page-header-subtitle">
                      Select a virtual machine for more options specific to the instance.
                    </div>
                  </div>
                  <div class="col-12 col-xl-auto mt-4">
                    <div class="input-group input-group-joined border-0" style="width: 14rem">
                      <span class="input-group-text bg-transparent border-0">
                        <a class="btn btn-outline-primary" href="#" data-toggle="modal" data-target="#createInstanceModal" title="New Virtual Machine" aria-hidden="true">
                          <i class="fas fa-plus fa-sm fa-fw"></i> Virtual Machine
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
                    <span class="ml-1">Virtual Machine List</span>
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
            <h5 class="modal-title" id="exampleModalLabel">Create Virtual Machine</h5>
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
                      <input type="text" id="instanceNameInput" class="form-control" required="required" placeholder="">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in a name for this instance'></i>
                  </div>
                </div>

                <div class="row">
                  <label class="col-3 col-form-label text-right">Description: </label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="instanceDescriptionInput" class="form-control" required="required" placeholder="">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in a description for this instance'></i>
                  </div>
                </div>

                <div class="row">
                  <label class="col-3 col-form-label text-right">Image: </label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="instanceImageInput" class="form-control" name="instanceImageInput">
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Select a downloaded image to use to build the instance'></i>
                  </div>
                </div>

                <div class="row">
                  <label class="col-3 col-form-label text-right">Profile: </label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="instanceProfileInput" class="form-control" name="instanceProfileInput">
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Select the initial profile to attach to this instance. Additional profiles can be attached after the instance is created. Default: default'></i>
                  </div>
                </div>

                <div class="row">
                  <label class="col-3 col-form-label text-right">Instance Type: </label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="instanceInstanceTypeInput" class="form-control" name="instanceInstanceTypeInput">
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
                    <i class="far fa-sm fa-question-circle" title='Select from a variety of preconfigured instance configurations. Default: (not set)'></i>
                  </div>
                </div>
    
                <div class="row">
                  <label class="col-3 col-form-label text-right">Location: </label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="instanceLocationInput" class="form-control" name="instanceLocationInput">
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Select the LXD cluster member to deploy this instance on. Default: none'></i>
                  </div>
                </div>

                <hr class="mb-2">
                <nav>
                  <div class="nav nav-pills justify-content-center" id="nav-tab" role="tablist">
                    <a class="nav-link active" id="nav-boot-tab" data-toggle="tab" href="#nav-boot" role="tab" aria-controls="nav-boot" aria-selected="true">Boot</a>
                    <a class="nav-link" id="nav-limits-tab" data-toggle="tab" href="#nav-limits" role="tab" aria-controls="nav-limits" aria-selected="false">Limits</a>
                    <a class="nav-link" id="nav-migration-tab" data-toggle="tab" href="#nav-migration" role="tab" aria-controls="nav-migration" aria-selected="false">Migration</a>
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
                          <select id="instanceBootAutostartInput" onchange="" class="form-control" name="instanceBootAutostartInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether to automatically start the instance with LXD starts. If not set, defaults to instance last state.'></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Autostart Delay: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="instanceBootAutostartDelayInput" class="form-control" placeholder="" name="instanceBootAutostartDelayInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the number of seconds to wait after the instance starts to boot up the next instance. Default: 0.'></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Autostart Priority: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="instanceBootAutostartPriorityInput" class="form-control" placeholder="" name="instanceBootAutostartPriorityInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in a number to determine the order the instance boots, higher numbers being first. Default: 0.'></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Host Shutdown Timeout: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="instanceBootHostShutdownTimeoutInput" class="form-control" placeholder="" name="instanceBootHostShutdownTimeoutInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in a the number of seconds to wait on host shutdown before forcefull shutdown of instance. Default: 30.'></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Stop Priority: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="instanceBootStopPriorityInput" class="form-control" placeholder="" name="instanceBootStopPriorityInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in a number to determine the order the instance shutsdown, higher numbers being first. Default: 0.'></i>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="nav-limits" role="tabpanel" aria-labelledby="nav-limits-tab">
                    <br>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">CPU: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="instanceLimitsCpuInput" class="form-control" placeholder="" name="instanceLimitsCpuInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the number or range of CPUs to expose to the instance.'></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Disk Priority: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="instanceLimitsDiskPriorityInput" class="form-control" placeholder="" name="instanceLimitsDiskPriorityInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in an integer between 0 (min) and 10 (max) to schedule disk I/O request priority compared to other instances. Default: 5.'></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Memory: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="instanceLimitsMemoryInput" class="form-control" placeholder="" name="instanceLimitsMemoryInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in a percentage of the host's memory or enter in a fixed value of bytes."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Memory Hugepages: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="instanceLimitsMemoryHugepagesInput" onchange="" class="form-control" name="instanceLimitsMemoryHugepagesInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether to back the instance using hugepages instead of regular system memory. Default: false"></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Network Priority: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="instanceLimitsNetworkPriorityInput" class="form-control" placeholder="" name="instanceLimitsNetworkPriorityInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in the priority for the instance network when the host is under, with 10 being the priority. Default 0."></i>
                      </div>
                    </div>

                  </div>
                  <div class="tab-pane fade" id="nav-migration" role="tabpanel" aria-labelledby="nav-migration-tab">
                    <br>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Stateful: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="instanceMigrationStatefulInput" onchange="" class="form-control" name="instanceMigrationStatefulInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether to allow stateful starting, stopping, and snapshots. Default: false"></i>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="nav-other" role="tabpanel" aria-labelledby="nav-other-tab">
                    <br>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Cluster Evacuate: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="instanceClusterEvacuateInput" onchange="" class="form-control" name="instanceClusterEvacuateInput">
                            <option value="">(not set)</option>
                            <option value="auto">auto</option>
                            <option value="migrate">migrate</option>
                            <option value="stop">stop</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select what to do when evacuating the instance. Default: auto'></i>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="nav-raw" role="tabpanel" aria-labelledby="nav-raw-tab">
                    <br>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Apparmor: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="instanceRawApparmorInput" class="form-control" placeholder="" name="instanceRawApparmorInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in apparmor profile entries to be appended to the profile. Default: (not set)."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Qemu: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="instanceRawQemuInput" class="form-control" placeholder="" name="instanceRawQemuInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Enter in qemu configuration to be appended to the profile. Default: (not set)."></i>
                      </div>
                    </div>

                  </div>
                  <div class="tab-pane fade" id="nav-security" role="tabpanel" aria-labelledby="nav-security-tab">
                    <br>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Devlxd: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="instanceSecurityDevLxdInput" onchange="" class="form-control" name="instanceSecurityDevLxdInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether to control the presence of /dev/lxd in the instance. Default: true."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Protection Delete: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="instanceSecurityProtectionDeleteInput" onchange="" class="form-control" name="instanceSecurityProtectionDeleteInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether to prevent the instance from being deleted. Default: false"></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Secureboot: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="instanceSecuritySecurebootInput" onchange="" class="form-control" name="instanceSecuritySecurebootInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether to enable UEFI secure boot using default Microsoft keys. Default: true"></i>
                      </div>
                    </div>

                  </div>
                  <div class="tab-pane fade" id="nav-snapshots" role="tabpanel" aria-labelledby="nav-snapshots-tab">
                    <br>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Schedule: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="instanceSnapshotsScheduleInput" class="form-control" placeholder="" name="instanceSnapshotsScheduleInput">
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
                          <select id="instanceSnapshotsScheduleStoppedInput" onchange="" class="form-control" name="instanceSnapshotsScheduleStoppedInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title="Select whether stopped instances are to be snapshoted automatically. Default: false."></i>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-4 col-form-label text-right">Pattern: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="instanceSnapshotsPatternInput" class="form-control" placeholder="" name="instanceSnapshotsPatternInput">
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
                          <input type="text" id="instanceSnapshotsExpiryInput" class="form-control" placeholder="" name="instanceSnapshotsExpiryInput">
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

    pageReloadTimeout = setTimeout(() => { reloadPageContent(); }, 7000);
  }
  
  function loadPageContent(){

    //Display current logged in username
    $("#username").load("./backend/admin/settings.php?action=displayUsername");

    $('#instanceListTable').DataTable( {
      ajax: "./backend/lxd/virtual-machines.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listInstances",
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

    //Reload page content in 7 seconds
    pageReloadTimeout = setTimeout(() => { reloadPageContent(); }, 7000);
  }

  function createInstanceUsingForm(){
    var instanceName = $("#instanceNameInput").val();
    var instanceDescription = $("#instanceDescriptionInput").val();
    var fingerprint = $("#instanceImageInput").val();
    var profileName = $("#instanceProfileInput").val();
    var instanceType = $("#instanceInstanceTypeInput").val();
    var location = $("#instanceLocationInput").val();

    var bootAutostart = $("#instanceBootAutostartInput").val();
    var bootAutostartDelay = $("#instanceBootAutostartDelayInput").val();
    var bootAutostartPriority = $("#instanceBootAutostartPriorityInput").val();
    var bootHostShutdownTimeout = $("#instanceBootHostShutdownTimeoutInput").val();
    var bootStopPriority = $("#instanceBootStopPriorityInput").val();
    var clusterEvacuate = $("#instanceClusterEvacuateInput").val();
    var limitsCpu = $("#instanceLimitsCpuInput").val();
    var limitsDiskPriority = $("#instanceLimitsDiskPriorityInput").val();
    var limitsMemory = $("#instanceLimitsMemoryInput").val();
    var limitsMemoryHugepages = $("#instanceLimitsMemoryHugepagesInput").val();
    var limitsNetworkPriority = $("#instanceLimitsNetworkPriorityInput").val();
    var migrationStateful = $("#instanceMigrationStatefulInput").val();
    var rawApparmor = $("#instanceRawApparmorInput").val();
    var rawQemu = $("#instanceRawQemuInput").val();
    var securityDevLxd = $("#instanceSecurityDevLxdInput").val();
    var securityProtectionDelete = $("#instanceSecurityProtectionDeleteInput").val();
    var securitySecureboot = $("#instanceSecuritySecurebootInput").val();
    var snapshotsSchedule = $("#instanceSnapshotsScheduleInput").val();
    var snapshotsScheduleStopped = $("#instanceSnapshotsScheduleStoppedInput").val();
    var snapshotsPattern = $("#instanceSnapshotsPatternInput").val();
    var snapshotsExpiry = $("#instanceSnapshotsExpiryInput").val();

    console.log("Info: creating instance " + instanceName);
    $.get("./backend/lxd/virtual-machines.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + 
    "&name=" + encodeURI(instanceName) + 
    "&description=" + encodeURI(instanceDescription) + 
    "&fingerprint=" + encodeURI(fingerprint) + 
    "&profile=" + encodeURI(profileName) + 
    "&instance_type=" + encodeURI(instanceType) + 
    "&location=" + encodeURI(location) + 

    "&boot_autostart=" + encodeURI(bootAutostart) + 
    "&boot_autostart_delay=" + encodeURI(bootAutostartDelay) + 
    "&boot_autostart_priority=" + encodeURI(bootAutostartPriority) + 
    "&boot_host_shutdown_timeout=" + encodeURI(bootHostShutdownTimeout) + 
    "&boot_stop_priority=" + encodeURI(bootStopPriority) + 
    "&cluster_evacuate=" + encodeURI(clusterEvacuate) + 
    "&limits_cpu=" + encodeURI(limitsCpu) + 
    "&limits_disk_priority=" + encodeURI(limitsDiskPriority) + 
    "&limits_memory=" + encodeURI(limitsMemory) + 
    "&limits_memory_hugepages=" + encodeURI(limitsMemoryHugepages) + 
    "&limits_network_priority=" + encodeURI(limitsNetworkPriority) + 
    "&migration_stateful=" + encodeURI(migrationStateful) + 
    "&raw_apparmor=" + encodeURI(rawApparmor) + 
    "&raw_qemu=" + encodeURI(rawQemu) + 
    "&security_devlxd=" + encodeURI(securityDevLxd) + 
    "&security_protection_delete=" + encodeURI(securityProtectionDelete) + 
    "&security_secureboot=" + encodeURI(securitySecureboot) + 
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
    var instanceCreateJSON = $("#jsonCreateInput").val();
    console.log("Info: creating virtual machine");
    $.post("./backend/lxd/virtual-machines.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=createInstanceUsingJSON", {json: instanceCreateJSON},  function (data) {
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
    console.log("Info: starting virtual machine " + instanceName);
    $.get("./backend/lxd/virtual-machines.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&action=startInstance",  function (data) {
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
    console.log("Info: stopping virtual machine " + instanceName);
    $.get("./backend/lxd/virtual-machines.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&action=stopInstance",  function (data) {
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
    console.log("Info: unfreezing virtual machine " + instanceName);
    $.get("./backend/lxd/virtual-machines.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&instance=" + encodeURI(instanceName) + "&action=unfreezeInstance",  function (data) {
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

    //Populate the select options fields used in modals
    $("#instanceProfileInput").load("./backend/lxd/profiles.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listProfilesForSelectOption");
    $("#instanceLocationInput").load("./backend/lxd/cluster-members.php?remote=" + encodeURI(remoteId) + "&include_none=true&action=listClusterMembersForSelectOption");
    $("#instanceImageInput").load("./backend/lxd/images.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&image_type=virtual-machine&action=listImagesForSelectOption");

  });

</script>

</html>