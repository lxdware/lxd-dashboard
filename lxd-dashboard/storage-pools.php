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
                      STORAGE POOLS
                    </h2>
                    <div class="page-header-subtitle">
                      Create and manage LXD storage pools
                    </div>
                  </div>
                  <div class="col-12 col-xl-auto mt-4">
                    <div class="input-group input-group-joined border-0" style="width: 14rem">
                      <span class="input-group-text bg-transparent border-0">
                        <a class="btn btn-outline-primary" href="#" onclick="loadCreateStoragePoolModal()" title="New Storage Pool" aria-hidden="true">
                          <i class="fas fa-plus fa-sm fa-fw"></i> Storge Pool
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
              <!-- Storage Pool List -->
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold">
                    <span class="ml-1">Storage Pools</span>
                  </h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle mr-2" href="#" onclick="reloadPageContent()" title="Refresh" aria-hidden="true">
                      <i class="fa fa-sync fa-1x fa-fw"></i></a>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table" id="storagePoolListTable" width="100%" cellspacing="0">
                    </table>
                  </div>
                </div>
              </div>
              <!-- End Storage Pool List -->
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

  <!-- Create Storage Pool Modal-->
  <div class="modal fade" id="createStoragePoolModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Storage Pool</h5>
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
                      <input type="text" id="storagePoolNameInput" class="form-control" placeholder="" name="storage_pool_name">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='(Required) - Enter in the name of the storage pool.'></i>
                  </div>
                </div>

                <div class="row">
                  <label class="col-3 col-form-label text-right">Description: </label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="storagePoolDescriptionInput" class="form-control" placeholder="" name="storage_pool_description">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in a description for the storage pool.'></i>
                  </div>
                </div>

                <div class="row">
                  <label class="col-3 col-form-label text-right">Driver: <span class="text-danger">*</span></label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="storagePoolDriverInput" class="form-control" onclick="changeStoragePoolDriverInput()"name="storage_pool_driver">
                        <option value="btrfs">btrfs</option>
                        <option value="ceph">ceph</option>
                        <option value="cephfs">cephfs</option>
                        <option value="dir" selected>dir</option>
                        <option value="lvm">lvm</option>
                        <option value="zfs">zfs</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='(Required) - Select the storage pool driver.'></i>
                  </div>
                </div>

                <div class="row" id="storagePoolSizeRow">
                  <label class="col-3 col-form-label text-right">Size: </label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="storagePoolSizeInput" class="form-control" name="storage_pool_size">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in the size of the storage pool. Including the suffix for units other than bytes. Default: 30GB'></i>
                  </div>
                </div>

                <div class="row" id="storagePoolSourceRow">
                  <label class="col-3 col-form-label text-right">Source: </label>
                  <div class="col-7">
                    <div class="form-group">
                      <input type="text" id="storagePoolSourceInput" class="form-control" placeholder="" name="storagePoolSourceInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i id="storagePoolSourceHint" class="far fa-sm fa-question-circle" title='Required for the cephfs driver type. Enter in a filepath to the block device, loop file, or filesystem entry. Default: (not set)'></i>
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

                    <div class="row" id="storagePoolBtrfsMountOptionsRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">btrfs.mount_options: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storagePoolBtrfsMountOptionsInput" class="form-control" placeholder="" name="storagePoolBtrfsMountOptionsInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the btrfs mount options for block devices. Default: user_subvol_rm_allowed'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolCephClusterNameRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">ceph.cluster_name: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storagePoolCephClusterNameInput" class="form-control" placeholder="" name="storagePoolCephClusterNameInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the name of the ceph cluster where new storage pools are created. Default: ceph'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolCephOsdForceReuseRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">ceph.osd.force_reuse: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="storagePoolCephOsdForceReuseInput" onchange="" class="form-control" name="storagePoolCephOsdForceReuseInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to force using an osd storage pool that is already in use by another LXD instance. Default: false'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolCephOsdPgNumRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">ceph.osd.pg_num: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="storagePoolCephOsdPgNumInput" class="form-control" placeholder="" name="storagePoolCephOsdPgNumInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the number of placement groups for the osd storage pool. Default: 32'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolCephOsdPoolNameRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">ceph.osd.pool_name: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storagePoolCephOsdPoolNameInput" class="form-control" placeholder="" name="storagePoolCephOsdPoolNameInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the name of the osd storage pool. Default: (inherited from Storage Pool name)'></i>
                      </div>
                    </div>
                    
                    <div class="row" id="storagePoolCephOsdDataPoolNameRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">ceph.osd.data_pool_name: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storagePoolCephOsdDataPoolNameInput" class="form-control" placeholder="" name="storagePoolCephOsdDataPoolNameInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the name of the osd data pool. Default: (not set)'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolCephRbdCloneCopyRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">ceph.rbd.clone_copy: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="storagePoolCephRbdCloneCopyInput" onchange="" class="form-control" name="storagePoolCephRbdCloneCopyInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to use RBD lightweight clones rather than using full dataset copies. Default: true'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolCephRbdFeaturesRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">ceph.rbd.features: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storagePoolCephRbdFeaturesInput" class="form-control" placeholder="" name="storagePoolCephRbdFeaturesInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in a comma separated list of RBD features to enable. Default: layering'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolCephUserNameRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">ceph.user.name: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storagePoolCephUserNameInput" class="form-control" placeholder="" name="storagePoolCephUserNameInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the name of the ceph user. Default: admin'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolCephfsClusterNameRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">cephfs.cluster_name: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storagePoolCephfsClusterNameInput" class="form-control" placeholder="" name="storagePoolCephfsClusterNameInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the name of the ceph cluster used when creating new storage pools. Default: ceph'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolCephfsPathRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">cephfs.path: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storagePoolCephfsPathInput" class="form-control" placeholder="" name="storagePoolCephfsPathInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the base filepath for the CEPHFS mount. Default: /'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolCephfsUserNameRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">cephfs.user.name: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storagePoolCephfsUserNameInput" class="form-control" placeholder="" name="storagePoolCephfsUserNameInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the name of the CEPHFS user. Default: admin'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolLvmThinpoolNameRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">lvm.thinpool_name: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storagePoolLvmThinpoolNameInput" class="form-control" placeholder="" name="storagePoolLvmThinpoolNameInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the name of the thin pool where volumes are created. Default: LXDThinPool'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolLvmUseThinpoolRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">lvm.use_thinpool: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="storagePoolLvmUseThinpoolInput" onchange="" class="form-control" name="storagePoolLvmUseThinpoolInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to use thinpools for logical volumes. Default: true'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolLvmVgNameRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">lvm.vg_name: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storagePoolLvmVgNameInput" class="form-control" placeholder="" name="storagePoolLvmVgNameInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the name of the volume group to create. Default: (inherited from Storage Pool name)'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolLvmVgForceReuseRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">lvm.vg.force_reuse: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="storagePoolLvmVgForceReuseInput" onchange="" class="form-control" name="storagePoolLvmVgForceReuseInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to force using an existing non-empty volume group. Default: false'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolVolumeLvmStripesRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">volume.lvm.stripes: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storagePoolVolumeLvmStripesInput" class="form-control" placeholder="" name="storagePoolVolumeLvmStripesInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the number of stripes to use when creating new volumes. Default: (not set)'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolVolumeLvmStripesSizeRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">volume.lvm.stripes.size: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storagePoolVolumeLvmStripesSizeInput" class="form-control" placeholder="" name="storagePoolVolumeLvmStripesSizeInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the size of stripes to use. It must be at least 4096 bytes and be a multiple of 512. Default: (not set)'></i>
                      </div>
                    </div>
                    
                    <div class="row" id="storagePoolRsyncBwlimitRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">rsync.bwlimit: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storagePoolRsyncBwlimitInput" class="form-control" placeholder="" name="storagePoolRsyncBwlimitInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the socket I/O upper limit when rsync is used to transfer storage entities. Default: 0 (unlimited)'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolRsyncCompressionRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">rsync.compression: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="storagePoolRsyncCompressionInput" onchange="" class="form-control" name="storagePoolRsyncCompressionInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to use compression while migrating storage pools. Default: true'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolVolatileInitialSourceRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">volatile.initial_source: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storagePoolVolatileInitialSourceInput" class="form-control" placeholder="" name="storagePoolVolatileInitialSourceInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the filepath of the actual source passed during the creation process. Default: (not set). For example, /dev/sdb'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolVolatilePoolPristineRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">volatile.pool.pristine: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="storagePoolVolatilePoolPristineInput" onchange="" class="form-control" name="storagePoolVolatilePoolPristineInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not the pool has been empty since it was created. Default: true.'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolVolumeBlockFilesystemRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">volume.block.filesystem: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storagePoolVolumeBlockFilesystemInput" class="form-control" placeholder="" name="storagePoolVolumeBlockFilesystemInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the filesystem to use for new volumes. Default: ext4'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolVolumeBlockMountOptionsRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">volume.block.mount_options: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storagePoolVolumeBlockMountOptionsInput" class="form-control" placeholder="" name="storagePoolVolumeBlockMountOptionsInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in mount options for block devices. Default: discard'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolVolumeSizeRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">volume.size: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storagePoolVolumeSizeInput" class="form-control" placeholder="" name="storagePoolVolumeSizeInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in default storage volume size. Default: unlimited (10GB for block devices)'></i>
                      </div>
                    </div>
                    
                    <div class="row" id="storagePoolVolumeZfsRemoveSnapshotsRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">volume.zfs.remove_snapshots: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="storagePoolVolumeZfsRemoveSnapshotsInput" onchange="" class="form-control" name="storagePoolVolumeZfsRemoveSnapshotsInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to remove snapshots as needed. Default: false.'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolVolumeZfsUseRefquotaRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">volume.zfs.use_refquota: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="storagePoolVolumeZfsUseRefquotaInput" onchange="" class="form-control" name="storagePoolVolumeZfsUseRefquotaInput ">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to use refquota instead of quota. Default: false.'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolZfsCloneCopyRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">zfs.clone_copy: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="storagePoolZfsCloneCopyInput" onchange="" class="form-control" name="storagePoolZfsCloneCopyInput ">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                            <option value="rebase">rebase</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to use ZFS lightweight clones rather than full dataset copies. Select "rebase" to copy based on the initial image. Default: true.'></i>
                      </div>
                    </div>

                    <div class="row" id="storagePoolZfsPoolNameRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">zfs.pool_name: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="storagePoolZfsPoolNameInput" class="form-control" placeholder="" name="storagePoolZfsPoolNameInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in name of the zfs pool. Default: (inherited from Storage Pool name)'></i>
                      </div>
                    </div>

                  </div>
                </div>

                <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                  <a class="btn btn-primary" href="#" onclick="createStoragePoolUsingForm()" data-dismiss="modal">Submit</a>
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
                  <a class="btn btn-primary" href="#" onclick="createStoragePoolUsingJSON()" data-dismiss="modal">Submit</a>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>

  <!-- Edit Storage Pool Modal-->
  <div class="modal fade" id="editStoragePoolModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Storage Pool</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <label class="col-4 col-form-label" id="storagePoolNameEditInput"></label>
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
            <a class="btn btn-primary" href="#" onclick="updateStoragePool()" data-dismiss="modal">Submit</a>
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
  var storagePoolToUpdate = "";

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

    $('#storagePoolListTable').DataTable().ajax.reload(null, false);

    pageReloadTimeout = setTimeout(() => { reloadPageContent(); }, 7000);
  }

  function loadPageContent(){

    //Display current logged in username
    $("#username").load("./backend/admin/settings.php?action=displayUsername");

    $('#storagePoolListTable').DataTable( {
      ajax: "./backend/lxd/storage-pools.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listStoragePools",
      columns: [
        {},
        { title: "Name" },
        { title: "Description" },
        { title: "Driver" },
        { title: "Status" },
        { title: "Source" },
        { title: "Size" },
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

  function createStoragePoolUsingJSON(){
    var storagePoolCreateJSON = $("#jsonCreateInput").val();
    console.log("Info: creating storage pool");
    $.post("./backend/lxd/storage-pools.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=createStoragePoolUsingJSON", {json: storagePoolCreateJSON},  function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function createStoragePoolUsingForm(){
    var storagePoolNameInput = $("#storagePoolNameInput").val();
    var storagePoolDescriptionInput = $("#storagePoolDescriptionInput").val();
    var storagePoolDriverInput = $("#storagePoolDriverInput").val();
    var storagePoolSizeInput = $("#storagePoolSizeInput").val();
    var storagePoolSourceInput = $("#storagePoolSourceInput").val();

    var storagePoolBtrfsMountOptionsInput = $("#storagePoolBtrfsMountOptionsInput").val();
    var storagePoolCephClusterNameInput = $("#storagePoolCephClusterNameInput").val();
    var storagePoolCephOsdForceReuseInput = $("#storagePoolCephOsdForceReuseInput").val();
    var storagePoolCephOsdPgNumInput = $("#storagePoolCephOsdPgNumInput").val();
    var storagePoolCephOsdPoolNameInput = $("#storagePoolCephOsdPoolNameInput").val();
    var storagePoolCephOsdDataPoolNameInput = $("#storagePoolCephOsdDataPoolNameInput").val();
    var storagePoolCephRbdCloneCopyInput = $("#storagePoolCephRbdCloneCopyInput").val();
    var storagePoolCephRbdFeaturesInput = $("#storagePoolCephRbdFeaturesInput").val();
    var storagePoolCephUserNameInput = $("#storagePoolCephUserNameInput").val();
    var storagePoolCephfsClusterNameInput = $("#storagePoolCephfsClusterNameInput").val();
    var storagePoolCephfsPathInput = $("#storagePoolCephfsPathInput").val();
    var storagePoolCephfsUserNameInput = $("#storagePoolCephfsUserNameInput").val();
    var storagePoolLvmThinpoolNameInput = $("#storagePoolLvmThinpoolNameInput").val();
    var storagePoolLvmUseThinpoolInput = $("#storagePoolLvmUseThinpoolInput").val();
    var storagePoolLvmVgNameInput = $("#storagePoolLvmVgNameInput").val();
    var storagePoolLvmVgForceReuseInput = $("#storagePoolLvmVgForceReuseInput").val();
    var storagePoolVolumeLvmStripesInput = $("#storagePoolVolumeLvmStripesInput").val();
    var storagePoolVolumeLvmStripesSizeInput = $("#storagePoolVolumeLvmStripesSizeInput").val();
    var storagePoolRsyncBwlimitInput = $("#storagePoolRsyncBwlimitInput").val();
    var storagePoolRsyncCompressionInput = $("#storagePoolRsyncCompressionInput").val();
    var storagePoolVolatileInitialSourceInput = $("#storagePoolVolatileInitialSourceInput").val();
    var storagePoolVolatilePoolPristineInput = $("#storagePoolVolatilePoolPristineInput").val();
    var storagePoolVolumeBlockFilesystemInput = $("#storagePoolVolumeBlockFilesystemInput").val();
    var storagePoolVolumeBlockMountOptionsInput = $("#storagePoolVolumeBlockMountOptionsInput").val();
    var storagePoolVolumeSizeInput = $("#storagePoolVolumeSizeInput").val();
    var storagePoolVolumeZfsRemoveSnapshotsInput = $("#storagePoolVolumeZfsRemoveSnapshotsInput").val();
    var storagePoolVolumeZfsUseRefquotaInput = $("#storagePoolVolumeZfsUseRefquotaInput").val();
    var storagePoolZfsCloneCopyInput = $("#storagePoolZfsCloneCopyInput").val();
    var storagePoolZfsPoolNameInput = $("#storagePoolZfsPoolNameInput").val();

    console.log("Info: creating storage pool");
    $.get("./backend/lxd/storage-pools.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + 
    "&name=" + encodeURI(storagePoolNameInput) + 
    "&description=" + encodeURI(storagePoolDescriptionInput) + 
    "&size=" + encodeURI(storagePoolSizeInput) + 
    "&driver=" + encodeURI(storagePoolDriverInput) + 
    "&source=" + encodeURI(storagePoolSourceInput) + 

    "&btrfs_mount_options=" + encodeURI(storagePoolBtrfsMountOptionsInput) + 
    "&ceph_cluster_name=" + encodeURI(storagePoolCephClusterNameInput) + 
    "&ceph_osd_force_reuse=" + encodeURI(storagePoolCephOsdForceReuseInput) + 
    "&ceph_osd_pg_num=" + encodeURI(storagePoolCephOsdPgNumInput) + 
    "&ceph_osd_pool_name=" + encodeURI(storagePoolCephOsdPoolNameInput) + 
    "&ceph_osd_data_pool_name=" + encodeURI(storagePoolCephOsdDataPoolNameInput) + 
    "&ceph_rbd_clone_copy=" + encodeURI(storagePoolCephRbdCloneCopyInput) + 
    "&ceph_rbd_features=" + encodeURI(storagePoolCephRbdFeaturesInput) + 
    "&ceph_user_name=" + encodeURI(storagePoolCephUserNameInput) + 
    "&cephfs_cluster_name=" + encodeURI(storagePoolCephfsClusterNameInput) + 
    "&cephfs_path=" + encodeURI(storagePoolCephfsPathInput) + 
    "&cephfs_user_name=" + encodeURI(storagePoolCephfsUserNameInput) + 
    "&lvm_thinpool_name=" + encodeURI(storagePoolLvmThinpoolNameInput) + 
    "&lvm_use_thinpool=" + encodeURI(storagePoolLvmUseThinpoolInput) + 
    "&lvm_vg_name=" + encodeURI(storagePoolLvmVgNameInput) + 
    "&lvm_vg_force_reuse=" + encodeURI(storagePoolLvmVgForceReuseInput) + 
    "&volume_lvm_stripes=" + encodeURI(storagePoolVolumeLvmStripesInput) + 
    "&volume_lvm_stripes_size=" + encodeURI(storagePoolVolumeLvmStripesSizeInput) + 
    "&rsync_bwlimit=" + encodeURI(storagePoolRsyncBwlimitInput) + 
    "&rsync_compression=" + encodeURI(storagePoolRsyncCompressionInput) + 
    "&volatile_initial_source=" + encodeURI(storagePoolVolatileInitialSourceInput) + 
    "&volatile_pool_pristine=" + encodeURI(storagePoolVolatilePoolPristineInput) + 
    "&volume_block_filesystem=" + encodeURI(storagePoolVolumeBlockFilesystemInput) + 
    "&volume_block_mount_options=" + encodeURI(storagePoolVolumeBlockMountOptionsInput) + 
    "&volume_size=" + encodeURI(storagePoolVolumeSizeInput) + 
    "&volume_zfs_remove_snapshots=" + encodeURI(storagePoolVolumeZfsRemoveSnapshotsInput) + 
    "&volume_zfs_use_refquota=" + encodeURI(storagePoolVolumeZfsUseRefquotaInput) + 
    "&zfs_clone_copy=" + encodeURI(storagePoolZfsCloneCopyInput) + 
    "&zfs_pool_name=" + encodeURI(storagePoolZfsPoolNameInput) + 

    "&action=createStoragePoolUsingForm", function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function loadStoragePoolJson(storagePoolToLoad){
    console.log("Info: loading storage pool " + storagePoolToLoad);
    storagePoolToUpdate = storagePoolToLoad;
    $.get("./backend/lxd/storage-pools.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&storage_pool=" + encodeURI(storagePoolToLoad) + "&action=loadStoragePool", function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      $("#storagePoolNameEditInput").text("Name: " + storagePoolToLoad);
      $("#jsonEditInput").val(JSON.stringify(operationData.metadata, null, 2));
      $("#editStoragePoolModal").modal('show');
    });
  }

  function updateStoragePool(){
    var storagePoolUpdateJSON = $("#jsonEditInput").val();
    console.log("Info: updating storage pool " + storagePoolToUpdate);
    $.post("./backend/lxd/storage-pools.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&storage_pool=" + encodeURI(storagePoolToUpdate) + "&action=updateStoragePool", {json: storagePoolUpdateJSON},  function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function deleteStoragePool(storagePoolToDelete){
    console.log("Info: deleting storage pool " + storagePoolToDelete);
    $.get("./backend/lxd/storage-pools.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&storage_pool=" + encodeURI(storagePoolToDelete) + "&action=deleteStoragePool",  function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function loadCreateStoragePoolModal(){
    console.log("Info: loading create storage pool modal");
    changeStoragePoolDriverInput();
    $("#createStoragePoolModal").modal('show');
  }

  function changeStoragePoolDriverInput(){
    var storagePoolDriverInput = $("#storagePoolDriverInput").val();
    if (storagePoolDriverInput == "btrfs"){
      $("#storagePoolSourceHint").removeClass("text-danger");

      $("#storagePoolSizeRow").show()
      $("#storagePoolBtrfsMountOptionsRow").show()
      $("#storagePoolCephClusterNameRow").hide()
      $("#storagePoolCephOsdForceReuseRow").hide()
      $("#storagePoolCephOsdPgNumRow").hide()
      $("#storagePoolCephOsdPoolNameRow").hide()
      $("#storagePoolCephOsdDataPoolNameRow").hide()
      $("#storagePoolCephRbdCloneCopyRow").hide()
      $("#storagePoolCephRbdFeaturesRow").hide()
      $("#storagePoolCephUserNameRow").hide()
      $("#storagePoolCephfsClusterNameRow").hide()
      $("#storagePoolCephfsPathRow").hide()
      $("#storagePoolCephfsUserNameRow").hide()
      $("#storagePoolLvmThinpoolNameRow").hide()
      $("#storagePoolLvmUseThinpoolRow").hide()
      $("#storagePoolLvmVgNameRow").hide()
      $("#storagePoolLvmVgForceReuseRow").hide()
      $("#storagePoolVolumeLvmStripesRow").hide()
      $("#storagePoolVolumeLvmStripesSizeRow").hide()
      $("#storagePoolRsyncBwlimitRow").show()
      $("#storagePoolRsyncCompressionRow").show()
      $("#storagePoolVolatileInitialSourceRow").show()
      $("#storagePoolVolatilePoolPristineRow").hide()
      $("#storagePoolVolumeBlockFilesystemRow").hide()
      $("#storagePoolVolumeBlockMountOptionsRow").hide()
      $("#storagePoolVolumeSizeRow").show()
      $("#storagePoolVolumeZfsRemoveSnapshotsRow").hide()
      $("#storagePoolVolumeZfsUseRefquotaRow").hide()
      $("#storagePoolZfsCloneCopyRow").hide()
      $("#storagePoolZfsPoolNameRow").hide()  
    }
    if (storagePoolDriverInput == "ceph"){
      $("#storagePoolSourceHint").removeClass("text-danger");

      $("#storagePoolSizeRow").hide()
      $("#storagePoolBtrfsMountOptionsRow").hide()
      $("#storagePoolCephClusterNameRow").show()
      $("#storagePoolCephOsdForceReuseRow").show()
      $("#storagePoolCephOsdPgNumRow").show()
      $("#storagePoolCephOsdPoolNameRow").show()
      $("#storagePoolCephOsdDataPoolNameRow").show()
      $("#storagePoolCephRbdCloneCopyRow").show()
      $("#storagePoolCephRbdFeaturesRow").show()
      $("#storagePoolCephUserNameRow").show()
      $("#storagePoolCephfsClusterNameRow").hide()
      $("#storagePoolCephfsPathRow").hide()
      $("#storagePoolCephfsUserNameRow").hide()
      $("#storagePoolLvmThinpoolNameRow").hide()
      $("#storagePoolLvmUseThinpoolRow").hide()
      $("#storagePoolLvmVgNameRow").hide()
      $("#storagePoolLvmVgForceReuseRow").hide()
      $("#storagePoolVolumeLvmStripesRow").hide()
      $("#storagePoolVolumeLvmStripesSizeRow").hide()
      $("#storagePoolRsyncBwlimitRow").show()
      $("#storagePoolRsyncCompressionRow").show()
      $("#storagePoolVolatileInitialSourceRow").show()
      $("#storagePoolVolatilePoolPristineRow").show()
      $("#storagePoolVolumeBlockFilesystemRow").show()
      $("#storagePoolVolumeBlockMountOptionsRow").show()
      $("#storagePoolVolumeSizeRow").show()
      $("#storagePoolVolumeZfsRemoveSnapshotsRow").hide()
      $("#storagePoolVolumeZfsUseRefquotaRow").hide()
      $("#storagePoolZfsCloneCopyRow").hide()
      $("#storagePoolZfsPoolNameRow").hide()  
    }
    if (storagePoolDriverInput == "cephfs"){
      $("#storagePoolSourceHint").addClass("text-danger");

      $("#storagePoolSizeRow").hide()
      $("#storagePoolBtrfsMountOptionsRow").hide()
      $("#storagePoolCephClusterNameRow").hide()
      $("#storagePoolCephOsdForceReuseRow").hide()
      $("#storagePoolCephOsdPgNumRow").hide()
      $("#storagePoolCephOsdPoolNameRow").hide()
      $("#storagePoolCephOsdDataPoolNameRow").hide()
      $("#storagePoolCephRbdCloneCopyRow").hide()
      $("#storagePoolCephRbdFeaturesRow").hide()
      $("#storagePoolCephUserNameRow").hide()
      $("#storagePoolCephfsClusterNameRow").show()
      $("#storagePoolCephfsPathRow").show()
      $("#storagePoolCephfsUserNameRow").show()
      $("#storagePoolLvmThinpoolNameRow").hide()
      $("#storagePoolLvmUseThinpoolRow").hide()
      $("#storagePoolLvmVgNameRow").hide()
      $("#storagePoolLvmVgForceReuseRow").hide()
      $("#storagePoolVolumeLvmStripesRow").hide()
      $("#storagePoolVolumeLvmStripesSizeRow").hide()
      $("#storagePoolRsyncBwlimitRow").show()
      $("#storagePoolRsyncCompressionRow").show()
      $("#storagePoolVolatileInitialSourceRow").show()
      $("#storagePoolVolatilePoolPristineRow").show()
      $("#storagePoolVolumeBlockFilesystemRow").show()
      $("#storagePoolVolumeBlockMountOptionsRow").show()
      $("#storagePoolVolumeSizeRow").show()
      $("#storagePoolVolumeZfsRemoveSnapshotsRow").hide()
      $("#storagePoolVolumeZfsUseRefquotaRow").hide()
      $("#storagePoolZfsCloneCopyRow").hide()
      $("#storagePoolZfsPoolNameRow").hide()  
    }
    if (storagePoolDriverInput == "dir"){
      $("#storagePoolSourceHint").removeClass("text-danger");

      $("#storagePoolSizeRow").hide()
      $("#storagePoolBtrfsMountOptionsRow").hide()
      $("#storagePoolCephClusterNameRow").hide()
      $("#storagePoolCephOsdForceReuseRow").hide()
      $("#storagePoolCephOsdPgNumRow").hide()
      $("#storagePoolCephOsdPoolNameRow").hide()
      $("#storagePoolCephOsdDataPoolNameRow").hide()
      $("#storagePoolCephRbdCloneCopyRow").hide()
      $("#storagePoolCephRbdFeaturesRow").hide()
      $("#storagePoolCephUserNameRow").hide()
      $("#storagePoolCephfsClusterNameRow").hide()
      $("#storagePoolCephfsPathRow").hide()
      $("#storagePoolCephfsUserNameRow").hide()
      $("#storagePoolLvmThinpoolNameRow").hide()
      $("#storagePoolLvmUseThinpoolRow").hide()
      $("#storagePoolLvmVgNameRow").hide()
      $("#storagePoolLvmVgForceReuseRow").hide()
      $("#storagePoolVolumeLvmStripesRow").hide()
      $("#storagePoolVolumeLvmStripesSizeRow").hide()
      $("#storagePoolRsyncBwlimitRow").show()
      $("#storagePoolRsyncCompressionRow").show()
      $("#storagePoolVolatileInitialSourceRow").show()
      $("#storagePoolVolatilePoolPristineRow").hide()
      $("#storagePoolVolumeBlockFilesystemRow").hide()
      $("#storagePoolVolumeBlockMountOptionsRow").hide()
      $("#storagePoolVolumeSizeRow").show()
      $("#storagePoolVolumeZfsRemoveSnapshotsRow").hide()
      $("#storagePoolVolumeZfsUseRefquotaRow").hide()
      $("#storagePoolZfsCloneCopyRow").hide()
      $("#storagePoolZfsPoolNameRow").hide()  
    }
    if (storagePoolDriverInput == "lvm"){
      $("#storagePoolSourceHint").removeClass("text-danger");

      $("#storagePoolSizeRow").show()
      $("#storagePoolBtrfsMountOptionsRow").hide()
      $("#storagePoolCephClusterNameRow").hide()
      $("#storagePoolCephOsdForceReuseRow").hide()
      $("#storagePoolCephOsdPgNumRow").hide()
      $("#storagePoolCephOsdPoolNameRow").hide()
      $("#storagePoolCephOsdDataPoolNameRow").hide()
      $("#storagePoolCephRbdCloneCopyRow").hide()
      $("#storagePoolCephRbdFeaturesRow").hide()
      $("#storagePoolCephUserNameRow").hide()
      $("#storagePoolCephfsClusterNameRow").hide()
      $("#storagePoolCephfsPathRow").hide()
      $("#storagePoolCephfsUserNameRow").hide()
      $("#storagePoolLvmThinpoolNameRow").show()
      $("#storagePoolLvmUseThinpoolRow").show()
      $("#storagePoolLvmVgNameRow").show()
      $("#storagePoolLvmVgForceReuseRow").show()
      $("#storagePoolVolumeLvmStripesRow").show()
      $("#storagePoolVolumeLvmStripesSizeRow").show()
      $("#storagePoolRsyncBwlimitRow").show()
      $("#storagePoolRsyncCompressionRow").show()
      $("#storagePoolVolatileInitialSourceRow").show()
      $("#storagePoolVolatilePoolPristineRow").hide()
      $("#storagePoolVolumeBlockFilesystemRow").show()
      $("#storagePoolVolumeBlockMountOptionsRow").show()
      $("#storagePoolVolumeSizeRow").show()
      $("#storagePoolVolumeZfsRemoveSnapshotsRow").hide()
      $("#storagePoolVolumeZfsUseRefquotaRow").hide()
      $("#storagePoolZfsCloneCopyRow").hide()
      $("#storagePoolZfsPoolNameRow").hide()  
    }
    if (storagePoolDriverInput == "zfs"){
      $("#storagePoolSourceHint").removeClass("text-danger");

      $("#storagePoolSizeRow").show()
      $("#storagePoolBtrfsMountOptionsRow").hide()
      $("#storagePoolCephClusterNameRow").hide()
      $("#storagePoolCephOsdForceReuseRow").hide()
      $("#storagePoolCephOsdPgNumRow").hide()
      $("#storagePoolCephOsdPoolNameRow").hide()
      $("#storagePoolCephOsdDataPoolNameRow").hide()
      $("#storagePoolCephRbdCloneCopyRow").hide()
      $("#storagePoolCephRbdFeaturesRow").hide()
      $("#storagePoolCephUserNameRow").hide()
      $("#storagePoolCephfsClusterNameRow").hide()
      $("#storagePoolCephfsPathRow").hide()
      $("#storagePoolCephfsUserNameRow").hide()
      $("#storagePoolLvmThinpoolNameRow").hide()
      $("#storagePoolLvmUseThinpoolRow").hide()
      $("#storagePoolLvmVgNameRow").hide()
      $("#storagePoolLvmVgForceReuseRow").hide()
      $("#storagePoolVolumeLvmStripesRow").hide()
      $("#storagePoolVolumeLvmStripesSizeRow").hide()
      $("#storagePoolRsyncBwlimitRow").show()
      $("#storagePoolRsyncCompressionRow").show()
      $("#storagePoolVolatileInitialSourceRow").show()
      $("#storagePoolVolatilePoolPristineRow").hide()
      $("#storagePoolVolumeBlockFilesystemRow").hide()
      $("#storagePoolVolumeBlockMountOptionsRow").hide()
      $("#storagePoolVolumeSizeRow").show()
      $("#storagePoolVolumeZfsRemoveSnapshotsRow").show()
      $("#storagePoolVolumeZfsUseRefquotaRow").show()
      $("#storagePoolZfsCloneCopyRow").show()
      $("#storagePoolZfsPoolNameRow").show()  
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