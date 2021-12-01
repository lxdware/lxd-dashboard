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
                       /
                      <a href="#" id="storagePoolsBreadCrumb"></a>
                    </div>
                    <h2 class="page-header-title mt-2">
                      STORAGE VOLUMES
                    </h2>
                    <div class="page-header-subtitle">
                      Create and manage LXD storage volumes
                    </div>
                  </div>
                  <div class="col-12 col-xl-auto mt-4">
                    <div class="input-group input-group-joined border-0" style="width: 14rem">
                      <span class="input-group-text bg-transparent border-0">
                        <a class="btn btn-outline-primary" href="#" data-toggle="modal" data-target="#createStorageVolumeModal" title="New Storage Volume" aria-hidden="true">
                          <i class="fas fa-plus fa-sm fa-fw"></i> Storage Volume
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
              <!-- Storage Volume List -->
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold">
                    <span class="ml-1">Storage Volumes</span>
                  </h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle mr-2" href="#" onclick="reloadPageContent()" title="Refresh" aria-hidden="true">
                      <i class="fa fa-sync fa-1x fa-fw"></i></a>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="text-right mb-3">
                    <a class="text-primary" id="allVolumeTypesLink">View all volume types</a>
                  </div>
                  <div class="table-responsive">
                    <table class="table" id="storageVolumeListTable" width="100%" cellspacing="0">
                    </table>
                  </div>
                </div>
              </div>
              <!-- End Storeage Volume List -->
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

  <!-- Create Storage Volume Modal-->
  <div class="modal fade" id="createStorageVolumeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Storage Volume</h5>
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
                  <label class="col-3 col-form-label text-right">Name: <span class="text-danger">*</span></label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="storageVolumeNameInput" class="form-control" placeholder="" name="storage_volume_name">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='(Required) - Enter in the name of the storage volume.'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Content Type: <span class="text-danger">*</span></label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="storageVolumeContentTypeInput" class="form-control" name="content_type">
                        <option value="block" selected>block</option>
                        <option value="filesystem">filesystem</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='(Required) - Select the content type.'></i>
                  </div>
                </div>
                <div class="row">
                  <label class="col-3 col-form-label text-right">Size: </label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="storageVolumeSizeInput" class="form-control" value="" name="storage_volume_size">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the size for the storage volume. Include a suffix for units other than bytes.'></i>
                  </div>
                </div>

                <hr>

                <div id="accordionConfigurationProperties">
                  <h2>
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#configurationProperties" aria-expanded="false" aria-controls="configurationProperties">
                      Configuration Properties
                    </button>
                  </h2> 
                  <div id="configurationProperties" class="collapse" aria-labelledby="configurationProperties">

                    <div class="row" id="storageVolumeBlockFilesystemRow">
                      <label class="col-4 col-form-label text-right">block.filesystem: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storageVolumeBlockFilesystemInput" class="form-control" placeholder="" name="storageVolumeBlockFilesystemInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the filesystem of the storage volume. Used in LVM based storage pools.'></i>
                      </div>
                    </div>

                    <div class="row" id="storageVolumeBlockMountOptionsRow">
                      <label class="col-4 col-form-label text-right">block.mount_options: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storageVolumeBlockMountOptionsInput" class="form-control" placeholder="" name="storageVolumeBlockMountOptionsInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in mount options for the block devices. Used in LVM based storage pools.'></i>
                      </div>
                    </div>

                    <div class="row" id="storageVolumeSecurityShiftedRow">
                      <label class="col-4 col-form-label text-right">security.shifted: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="storageVolumeSecurityShiftedInput" onchange="" class="form-control" name="storageVolumeSecurityShiftedInput ">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to enable id shifting overlay. Default: false.'></i>
                      </div>
                    </div>

                    <div class="row" id="storageVolumeSecurityUnmappedRow">
                      <label class="col-4 col-form-label text-right">security.unmapped: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="storageVolumeSecurityUnmappedInput" onchange="" class="form-control" name="storageVolumeSecurityUnmappedInput ">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to disable id mapping. Default: false.'></i>
                      </div>
                    </div>

                    <div class="row" id="storageVolumeLvmStripesRow">
                      <label class="col-4 col-form-label text-right">lvm.stripes: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storageVolumeLvmStripesInput" class="form-control" placeholder="" name="storageVolumeLvmStripesInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the number of stripes to use for the volume.'></i>
                      </div>
                    </div>
                    
                    <div class="row" id="storageVolumeLvmStripesSizeRow">
                      <label class="col-4 col-form-label text-right">lvm.stripes.size: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storageVolumeLvmStripesSizeInput" class="form-control" placeholder="" name="storageVolumeLvmStripesSizeInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the size of stripes to use. Be sure to use at least 4096 bytes. Value must be a multiple of 512.'></i>
                      </div>
                    </div>

                    <div class="row" id="storageVolumeSnapshotsExpiryRow">
                      <label class="col-4 col-form-label text-right">snapshots.expiry: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storageVolumeSnapshotsExpiryInput" class="form-control" placeholder="" name="storageVolumeSnapshotsExpiryInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the time length when snapshots are to be deleted. For example, 1M, 2H, 3d, 4w, 5m, or 6y.'></i>
                      </div>
                    </div>

                    <div class="row" id="storageVolumeSnapshotsScheduleRow">
                      <label class="col-4 col-form-label text-right">snapshots.schedule: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storageVolumeSnapshotsScheduleInput" class="form-control" placeholder="" name="storageVolumeSnapshotsScheduleInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in a cron expression or a comma separated list of schedule aliases. For example, <minute> <hour> <dom> <month> <dow> or  <@hourly> <@daily> <@midnight> <@weekly> <@monthly> <@annually> <@yearly>.'></i>
                      </div>
                    </div>

                    <div class="row" id="storageVolumeSnapshotsPatternRow">
                      <label class="col-4 col-form-label text-right">snapshots.pattern: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storageVolumeSnapshotsPatternInput" class="form-control" placeholder="" name="storageVolumeSnapshotsPatternInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in a Pongo2 template string to represent the snapshot name. Default: snap%d'></i>
                      </div>
                    </div>

                    <div class="row" id="storageVolumeZfsRemoveSnapshotsRow">
                      <label class="col-4 col-form-label text-right">zfs.remove_snapshots: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="storageVolumeZfsRemoveSnapshotsInput" onchange="" class="form-control" name="storageVolumeZfsRemoveSnapshotsInput ">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to remove snapshots as needed. Default: (same as parent storage pool) '></i>
                      </div>
                    </div>

                    <div class="row" id="storageVolumeZfsUseRefquotaRow">
                      <label class="col-4 col-form-label text-right">zfs.use_refquota: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="storageVolumeZfsUseRefquotaInput" onchange="" class="form-control" name="storageVolumeZfsUseRefquotaInput ">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to use refquota instead of quota. Default: (same as parent storage pool) '></i>
                      </div>
                    </div>

                  </div>
                </div>

                <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                  <a class="btn btn-primary" href="#" onclick="createStorageVolumeUsingForm()" data-dismiss="modal">Submit</a>
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
                  <a class="btn btn-primary" href="#" onclick="createStorageVolumeUsingJSON()" data-dismiss="modal">Submit</a>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>

  <!-- Edit Storage Volume Modal-->
  <div class="modal fade" id="editStorageVolumeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Storage Volume</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <label class="col-12 col-form-label" id="storageVolumeNameEditInput"></label>
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
            <a class="btn btn-primary" href="#" onclick="updateStorageVolume()" data-dismiss="modal">Submit</a>
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
  const storagePoolName = urlParams.get('pool');  
  var storageVolumeToUpdate = "";
  var volumeType = urlParams.get('type'); 

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

    //Check Authorization
    $.get("./backend/aaa/authentication.php?action=validateAuthentication", function (data) {
      operationData = JSON.parse(data);
      if (operationData.status_code != 200) {
        console.log(operationData);
        window.location.href = './index.php'
      }
    });

    $('#storageVolumeListTable').DataTable().ajax.reload(null, false);
  }
  
  function loadPageContent(){

    //Display current logged in username
    $("#username").load("./backend/admin/settings.php?action=displayUsername");

    $('#storageVolumeListTable').DataTable( {
      ajax: "./backend/lxd/storage-volumes.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&pool=" + encodeURI(storagePoolName) + "&type=" + encodeURI(volumeType) + "&action=listStorageVolumes",
      columns: [
        {},
        { title: "Name" },
        { title: "Type" },
        { title: "Location" },
        { title: "Content Type" },
        { title: "Used by" },
        { title: "Action" }
      ],
      order: [],
      columnDefs: [
        { targets: 0, orderable: false, width: "25px" }
      ]
    });

    //Check for any running operations
    operationTimeout = setTimeout(() => { operationStatusCheck(); }, 1000);

    //Set the page content to reload in 7 seconds
    setInterval(() => { reloadPageContent(); }, 7000);
  }

  function createStorageVolumeUsingForm(){
    var storageVolumeNameInput = $("#storageVolumeNameInput").val();
    var storageVolumeContentTypeInput = $("#storageVolumeContentTypeInput").val();
    var storageVolumeSizeInput = $("#storageVolumeSizeInput").val();

    var storageVolumeBlockFilesystemInput = $("#storageVolumeBlockFilesystemInput").val();
    var storageVolumeBlockMountOptionsInput = $("#storageVolumeBlockMountOptionsInput").val();
    var storageVolumeSecurityShiftedInput = $("#storageVolumeSecurityShiftedInput").val();
    var storageVolumeSecurityUnmappedInput = $("#storageVolumeSecurityUnmappedInput").val();
    var storageVolumeLvmStripesInput = $("#storageVolumeLvmStripesInput").val();
    var storageVolumeLvmStripesSizeInput = $("#storageVolumeLvmStripesSizeInput").val();
    var storageVolumeSnapshotsExpiryInput = $("#storageVolumeSnapshotsExpiryInput").val();
    var storageVolumeSnapshotsScheduleInput = $("#storageVolumeSnapshotsScheduleInput").val();
    var storageVolumeSnapshotsPatternInput = $("#storageVolumeSnapshotsPatternInput").val();
    var storageVolumeZfsRemoveSnapshotsInput = $("#storageVolumeZfsRemoveSnapshotsInput").val();
    var storageVolumeZfsUseRefquotaInput = $("#storageVolumeZfsUseRefquotaInput").val();

    console.log("Info: creating storage volume " + storageVolumeNameInput + " in " + storagePoolName);
    $.get("./backend/lxd/storage-volumes.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + 
    "&name=" + encodeURI(storageVolumeNameInput) + 
    "&content_type=" + encodeURI(storageVolumeContentTypeInput) + 
    "&size=" + encodeURI(storageVolumeSizeInput) + 
    "&storage_pool=" + encodeURI(storagePoolName) + 

    "&block_filesystem=" + encodeURI(storageVolumeBlockFilesystemInput) + 
    "&block_mount_options=" + encodeURI(storageVolumeBlockMountOptionsInput) + 
    "&security_shifted=" + encodeURI(storageVolumeSecurityShiftedInput) + 
    "&security_unmapped=" + encodeURI(storageVolumeSecurityUnmappedInput) + 
    "&lvm_stripes=" + encodeURI(storageVolumeLvmStripesInput) + 
    "&lvm_stripes_size=" + encodeURI(storageVolumeLvmStripesSizeInput) + 
    "&snapshots_expiry=" + encodeURI(storageVolumeSnapshotsExpiryInput) + 
    "&snapshots_schedule=" + encodeURI(storageVolumeSnapshotsScheduleInput) + 
    "&snapshots_pattern=" + encodeURI(storageVolumeSnapshotsPatternInput) + 
    "&zfs_remote_snapshots=" + encodeURI(storageVolumeZfsRemoveSnapshotsInput) + 
    "&zfs_use_refquota=" + encodeURI(storageVolumeZfsUseRefquotaInput) + 

    
    "&action=createStorageVolumeUsingForm", function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function createStorageVolumeUsingJSON(){
    var storageVolumeCreateJSON = $("#jsonCreateInput").val();
    console.log("Info: creating storage volume");
    $.post("./backend/lxd/storage-volumes.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&storage_pool=" + encodeURI(storagePoolName) + "&action=createStorageVolumeUsingJSON", {json: storageVolumeCreateJSON},  function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function loadStorageVolumeJson(storageVolumeToLoad){
    console.log("Info: loading storage volume " + storageVolumeToLoad);
    storageVolumeToUpdate = storageVolumeToLoad;
    $.get("./backend/lxd/storage-volumes.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&name=" + encodeURI(storageVolumeToLoad) + "&storage_pool=" + encodeURI(storagePoolName) + "&action=loadStorageVolume", function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      $("#storageVolumeNameEditInput").text("Name: " + storageVolumeToLoad);
      $("#jsonEditInput").val(JSON.stringify(operationData.metadata, null, 2));
      $("#editStorageVolumeModal").modal('show');
    });
  }

  function updateStorageVolume(){
    var storageVolumeUpdateJSON = $("#jsonEditInput").val();
    console.log("Info: updating storage volume " + storageVolumeToUpdate);
    $.post("./backend/lxd/storage-volumes.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&name=" + encodeURI(storageVolumeToUpdate) + "&storage_pool=" + encodeURI(storagePoolName) + "&action=updateStorageVolume", {json: storageVolumeUpdateJSON},  function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function deleteStorageVolume(storageVolumeToDelete){
    console.log("Info: deleting storage volume " + storageVolumeToDelete);
    $.get("./backend/lxd/storage-volumes.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&name=" + encodeURI(storageVolumeToDelete) + "&storage_pool=" + encodeURI(storagePoolName) + "&action=deleteStorageVolume",  function (data) {
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
    $('#storagePoolsBreadCrumb').text("Storage Pools");
    $('#storagePoolsBreadCrumb').attr("href", "storage-pools.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName));

    //Set top navbar dropdowns
    $("#remoteListNav").load("./backend/lxd/remotes.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listRemotesForSelectOption");
    $("#projectListNav").load("./backend/lxd/projects.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listProjectsForSelectOption");

    //Load the card contents
    loadPageContent();
    
    //Load the about info for the about modal
    $.get("./backend/config/about.php", function (data) {
      $("#about").html(data);
    });

    //Setup hyperlink to show all volume types
    if (volumeType != "custom"){
      $('#allVolumeTypesLink').hide()
    }
    else{
      $('#allVolumeTypesLink').attr("href", "storage-volumes.html?pool=" + encodeURI(storagePoolName) + "&remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName));
      $('#allVolumeTypesLink').show() 
    }

  });


</script>

</html>