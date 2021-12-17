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
                      PROJECTS
                    </h2>
                    <div class="page-header-subtitle">
                      Create and manage projects
                    </div>
                  </div>
                  <div class="col-12 col-xl-auto mt-4">
                    <div class="input-group input-group-joined border-0" style="width: 14rem">
                      <span class="input-group-text bg-transparent border-0">
                        <a class="btn btn-outline-primary" href="#" data-toggle="modal" data-target="#createProjectModal" title="New Project" aria-hidden="true">
                          <i class="fas fa-plus fa-sm fa-fw"></i> Project
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
              <!-- Project List -->
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold">
                    <span class="ml-1">Projects</span>
                  </h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle mr-2" href="#" onclick="reloadPageContent()" title="Refresh" aria-hidden="true">
                      <i class="fa fa-sync fa-1x fa-fw"></i></a>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table" id="projectListTable" width="100%" cellspacing="0">
                    </table>
                  </div>
                </div>
              </div>
              <!-- End Project List -->
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

  <!-- Create Project Modal-->
  <div class="modal fade" id="createProjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Project</h5>
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
                    <div class="form-group text-right">
                      <input type="text" class="form-control" id="projectNameInput" required="required" placeholder="" name="projectNameInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='(Required) - Enter in a name for the project.'></i>
                  </div>
                </div>

                <div class="row">
                  <label class="col-3 col-form-label text-right">Description: </label>
                  <div class="col-7">
                    <div class="form-group text-right">
                      <input type="text" class="form-control" id="projectDescriptionInput" required="required" placeholder="" name="projectDescriptionInput">
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Enter in a description for the project.'></i>
                  </div>
                </div>

                <div class="row" id="projectFeaturesImagesRow">
                  <label class="col-3 col-form-label text-right">features.images: </label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="projectFeaturesImagesInput" onchange="" class="form-control" name="projectFeaturesImagesInput">
                        <option value="">(not set)</option>
                        <option value="true">true</option>
                        <option value="false">false</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Select whether or not to seperate images and image aliases for this project. Default: true.'></i>
                  </div>
                </div>

                <div class="row" id="projectFeaturesNetworksRow">
                  <label class="col-3 col-form-label text-right">features.networks: </label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="projectFeaturesNetworksInput" onchange="" class="form-control" name="projectFeaturesNetworksInput ">
                        <option value="">(not set)</option>
                        <option value="true">true</option>
                        <option value="false">false</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Select whether or not to seperate networks for this project. Default: false.'></i>
                  </div>
                </div>

                <div class="row" id="projectFeaturesProfilesRow">
                  <label class="col-3 col-form-label text-right">features.profiles: </label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="projectFeaturesProfilesInput" onchange="" class="form-control" name="projectFeaturesProfilesInput">
                        <option value="">(not set)</option>
                        <option value="true">true</option>
                        <option value="false">false</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Select whether or not to seperate profiles for this project. Default: true.'></i>
                  </div>
                </div>

                <div class="row" id="projectFeaturesStorageVolumesRow">
                  <label class="col-3 col-form-label text-right">features.storage.volumes: </label>
                  <div class="col-7">
                    <div class="form-group">
                      <select id="projectFeaturesStorageVolumesInput" onchange="" class="form-control" name="projectFeaturesStorageVolumesInput">
                        <option value="">(not set)</option>
                        <option value="true">true</option>
                        <option value="false">false</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-1">
                    <i class="far fa-sm fa-question-circle" title='Select whether or not to seperate storage volumes for this project. Default: true.'></i>
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

                    <div class="row" id="projectBackupsCompressionAlgorithmRow">
                      <label class="col-4 col-form-label text-right">backups.compression_algorithm: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="projectBackupsCompressionAlgorithmInput" onchange="" class="form-control" name="projectBackupsCompressionAlgorithmInput">
                            <option value="">(not set)</option>
                            <option value="bzip2">bzip2</option>
                            <option value="gzip">gzip</option>
                            <option value="lzma">lzma</option>
                            <option value="none">none</option>
                            <option value="xz">xz</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select the compression algorithm to use for backups in the project. Default: (not set)'></i>
                      </div>
                    </div>

                    <div class="row" id="projectImagesAutoUpdateCachedRow">
                      <label class="col-4 col-form-label text-right">images.auto_update_cached: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="projectImagesAutoUpdateCachedInput" onchange="" class="form-control" name="projectImagesAutoUpdateCachedInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to automatically update images that LXD caches. Default: (not set).'></i>
                      </div>
                    </div>

                    <div class="row" id="projectImagesAutoUpdateIntervalRow">
                      <label class="col-4 col-form-label text-right">images.auto_update_interval: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="projectImagesAutoUpdateIntervalInput" class="form-control" placeholder="" name="projectImagesAutoUpdateIntervalInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the hourly interval for the system to look for updates on cached images. Use 0 to disable.'></i>
                      </div>
                    </div>

                    <div class="row" id="projectImagesCompressionAlgorithmRow">
                      <label class="col-4 col-form-label text-right">images.compression_algorithm: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="projectImagesCompressionAlgorithmInput" onchange="" class="form-control" name="projectImagesCompressionAlgorithmInput">
                            <option value="">(not set)</option>
                            <option value="bzip2">bzip2</option>
                            <option value="gzip">gzip</option>
                            <option value="lzma">lzma</option>
                            <option value="none">none</option>
                            <option value="xz">xz</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select the compression algorithm to use for images in the project. Default: (not set)'></i>
                      </div>
                    </div>

                    <div class="row" id="projectImagesDefaultArchitectureRow">
                      <label class="col-4 col-form-label text-right">images.default_architecture: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="projectImagesDefaultArchitectureInput" class="form-control" placeholder="" name="projectImagesDefaultArchitectureInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the default architecture that should be used in a mixed architecture cluster.'></i>
                      </div>
                    </div>

                    <div class="row" id="projectImagesRemoteCacheExpiryRow">
                      <label class="col-4 col-form-label text-right">images.remote_cache_expiry: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="projectImagesRemoteCacheExpiryInput" class="form-control" placeholder="" name="projectImagesRemoteCacheExpiryInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the number of days unused cached remote images will be flushed from the project.'></i>
                      </div>
                    </div>

                    <div class="row" id="projectLimitsContainersRow">
                      <label class="col-4 col-form-label text-right">limits.containers: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="projectLimitsContainersInput" class="form-control" placeholder="" name="projectLimitsContainersInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the maximum number of containers that can be created within the project. Default: (not set)'></i>
                      </div>
                    </div>

                    <div class="row" id="projectLimitsCpuRow">
                      <label class="col-4 col-form-label text-right">limits.cpu: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="projectLimitsCpuInput" class="form-control" placeholder="" name="projectLimitsCpuInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the maximum value for the total sum of all individual "limits.cpu" configs set on instances within the project. Default: (not set)'></i>
                      </div>
                    </div>

                    <div class="row" id="projectLimitsDiskRow">
                      <label class="col-4 col-form-label text-right">limits.disk: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="projectLimitsDiskInput" class="form-control" placeholder="" name="projectLimitsDiskInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the maximum value of total disk space used by all volumes and images within the project. Default: (not set)'></i>
                      </div>
                    </div>

                    <div class="row" id="projectLimitsInstancesRow">
                      <label class="col-4 col-form-label text-right">limits.instances: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="projectLimitsInstancesInput" class="form-control" placeholder="" name="projectLimitsInstancesInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the maximum number of instances that can be created within the project. Default: (not set)'></i>
                      </div>
                    </div>

                    <div class="row" id="projectLimitsMemoryRow">
                      <label class="col-4 col-form-label text-right">limits.memory: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="projectLimitsMemoryInput" class="form-control" placeholder="" name="projectLimitsMemoryInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the maximum value for the total sum of all individual "limits.memory" configs set on instances within the project. Default: (not set)'></i>
                      </div>
                    </div>

                    <div class="row" id="projectLimitsNetworksRow">
                      <label class="col-4 col-form-label text-right">limits.networks: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="projectLimitsNetworksInput" class="form-control" placeholder="" name="projectLimitsNetworksInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the maximum number of networks within the project. Default: (not set)'></i>
                      </div>
                    </div>

                    <div class="row" id="projectLimitsProcessesRow">
                      <label class="col-4 col-form-label text-right">limits.processes: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="projectLimitsProcessesInput" class="form-control" placeholder="" name="projectLimitsProcessesInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the maximum value for the total sum of all individual "limits.processes" configs set on instances within the project. Default: (not set)'></i>
                      </div>
                    </div>

                    <div class="row" id="projectLimitsVirtualMachinesRow">
                      <label class="col-4 col-form-label text-right">limits.virtual-machines: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="number" id="projectLimitsVirtualMachinesInput" class="form-control" placeholder="" name="projectLimitsVirtualMachinesInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in the maximum number of virtual machines that can be created within the project. Default: (not set)'></i>
                      </div>
                    </div>

                    <div class="row" id="projectRestrictedRow">
                      <label class="col-4 col-form-label text-right">restricted: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="projectRestrictedInput" onchange="changeRestrictedOptionsDisplay()" class="form-control" name="projectRestrictedInput">
                            <option value="">(not set)</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether to block access to security-sensitive LXD features. Default: false'></i>
                      </div>
                    </div>

                    <div class="row" id="projectRestrictedBackupsRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">restricted.backups: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="projectRestrictedBackupsInput" onchange="" class="form-control" name="projectRestrictedBackupsInput">
                            <option value="">(not set)</option>
                            <option value="allow">allow</option>
                            <option value="block">block</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to prevent the creation of instances or volume backups within the project. Default: block'></i>
                      </div>
                    </div>

                    <div class="row" id="projectRestrictedClusterTargetRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">restricted.cluster.target: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="projectRestrictedClusterTargetInput" onchange="" class="form-control" name="projectRestrictedClusterTargetInput">
                            <option value="">(not set)</option>
                            <option value="allow">allow</option>
                            <option value="block">block</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to prevent the use of low-level container options like raw.lxc, raw.idmap, volatile, etc. within the project. Default: block'></i>
                      </div>
                    </div>

                    <div class="row" id="projectRestrictedContainersLowlevelRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">restricted.containers.lowlevel: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="projectRestrictedContainersLowlevelInput" onchange="" class="form-control" name="projectRestrictedContainersLowlevelInput">
                            <option value="">(not set)</option>
                            <option value="allow">allow</option>
                            <option value="block">block</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to prevent the use of low-level container options like raw.lxc, raw.idmap, volatile, etc. within the project. Default: block'></i>
                      </div>
                    </div>

                    <div class="row" id="projectRestrictedContainersNestingRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">restricted.containers.nesting: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="projectRestrictedContainersNestingInput" onchange="" class="form-control" name="projectRestrictedContainersNestingInput">
                            <option value="">(not set)</option>
                            <option value="allow">allow</option>
                            <option value="block">block</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to prevent setting "security.nesting=true" within the project. Default: block'></i>
                      </div>
                    </div>

                    <div class="row" id="projectRestrictedContainersPrivilegeRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">restricted.containers.privilege: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="projectRestrictedContainersPrivilegeInput" onchange="" class="form-control" name="projectRestrictedContainersPrivilegeInput">
                            <option value="">(not set)</option>
                            <option value="allow">allow</option>
                            <option value="isolated">isolated</option>
                            <option value="unprivileged">unprivileged</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select "allow" for no restrictions, "isolated" to prevent setting both "security.privileged=true" and "security.idmap.isolated=true", and select "unprivileged" to prevent setting "security.privileged=true". Default: unprivileged'></i>
                      </div>
                    </div>

                    <div class="row" id="projectRestrictedDevicesDiskRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">restricted.devices.disk: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="projectRestrictedDevicesDiskInput" onchange="" class="form-control" name="projectRestrictedDevicesDiskInput">
                            <option value="">(not set)</option>
                            <option value="allow">allow</option>
                            <option value="block">block</option>
                            <option value="managed">managed</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select "allow" for no restrictions, "block" to prevent using disk devices except root, and "managed" to allow the use of disk devices if "pool=" is set. Default: managed'></i>
                      </div>
                    </div>

                    <div class="row" id="projectRestrictedDevicesGpuRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">restricted.devices.gpu: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="projectRestrictedDevicesGpuInput" onchange="" class="form-control" name="projectRestrictedDevicesGpuInput">
                            <option value="">(not set)</option>
                            <option value="allow">allow</option>
                            <option value="block">block</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to allow the use of "gpu" type devices. Default: blocked'></i>
                      </div>
                    </div>

                    <div class="row" id="projectRestrictedDevicesInfinibandRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">restricted.devices.infiniband: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="projectRestrictedDevicesInfinibandInput" onchange="" class="form-control" name="projectRestrictedDevicesInfinibandInput">
                            <option value="">(not set)</option>
                            <option value="allow">allow</option>
                            <option value="block">block</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to allow the use of "infiniband" type devices. Default: blocked'></i>
                      </div>
                    </div>

                    <div class="row" id="projectRestrictedDevicesNicRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">restricted.devices.nic: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="projectRestrictedDevicesNicInput" onchange="" class="form-control" name="projectRestrictedDevicesNicInput">
                            <option value="">(not set)</option>
                            <option value="allow">allow</option>
                            <option value="block">block</option>
                            <option value="managed">managed</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select "allow" for no restrictions, "block" to prevent using all network devices, and "managed" to allow the use of network devices if "network=" is set. Default: managed'></i>
                      </div>
                    </div>

                    <div class="row" id="projectRestrictedDevicesPciRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">restricted.devices.pci: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="projectRestrictedDevicesPciInput" onchange="" class="form-control" name="projectRestrictedDevicesPciInput">
                            <option value="">(not set)</option>
                            <option value="allow">allow</option>
                            <option value="block">block</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to allow the use of "pci" type devices. Default: blocked'></i>
                      </div>
                    </div>

                    <div class="row" id="projectRestrictedDevicesProxyRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">restricted.devices.proxy: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="projectRestrictedDevicesProxyInput" onchange="" class="form-control" name="projectRestrictedDevicesProxyInput">
                            <option value="">(not set)</option>
                            <option value="allow">allow</option>
                            <option value="block">block</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to allow the use of "proxy" type devices. Default: blocked'></i>
                      </div>
                    </div>

                    <div class="row" id="projectRestrictedDevicesUnixBlockRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">restricted.devices.unix-block: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="projectRestrictedDevicesUnixBlockInput" onchange="" class="form-control" name="projectRestrictedDevicesUnixBlockInput">
                            <option value="">(not set)</option>
                            <option value="allow">allow</option>
                            <option value="block">block</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to allow the use of "unix-block" type devices. Default: blocked'></i>
                      </div>
                    </div>

                    <div class="row" id="projectRestrictedDevicesUnixCharRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">restricted.devices.unix-char: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="projectRestrictedDevicesUnixCharInput" onchange="" class="form-control" name="projectRestrictedDevicesUnixCharInput">
                            <option value="">(not set)</option>
                            <option value="allow">allow</option>
                            <option value="block">block</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to allow the use of "unix-char" type devices. Default: blocked'></i>
                      </div>
                    </div>

                    <div class="row" id="projectRestrictedDevicesUnixHotplugRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">restricted.devices.unix-hotplug: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="projectRestrictedDevicesUnixHotplugInput" onchange="" class="form-control" name="projectRestrictedDevicesUnixHotplugInput">
                            <option value="">(not set)</option>
                            <option value="allow">allow</option>
                            <option value="block">block</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to allow the use of "unix-hotplug" type devices. Default: blocked'></i>
                      </div>
                    </div>

                    <div class="row" id="projectRestrictedDevicesUsbRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">restricted.devices.usb: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="projectRestrictedDevicesUsbInput" onchange="" class="form-control" name="projectRestrictedDevicesUsbInput">
                            <option value="">(not set)</option>
                            <option value="allow">allow</option>
                            <option value="block">block</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to allow the use of "usb" type devices. Default: blocked'></i>
                      </div>
                    </div>

                    <div class="row" id="projectRestrictedNetworksSubnetsRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">restricted.networks.subnets: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="projectRestrictedNetworksSubnetsInput" class="form-control" placeholder="" name="projectRestrictedNetworksSubnetsInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in a comma seperated list of network subnets allocated for use in this project. Use the format <uplink>:<subnet>. Default: blocked'></i>
                      </div>
                    </div>

                    <div class="row" id="projectRestrictedNetworksUplinksRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">restricted.networks.uplinks: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <input type="text" id="projectRestrictedNetworksUplinksInput" class="form-control" placeholder="" name="projectRestrictedNetworksUplinksInput">
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Enter in a comma seperated list of network names that can be used as uplinks for this project. Default: blocked'></i>
                      </div>
                    </div>

                    <div class="row" id="projectRestrictedSnapshotsRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">restricted.snapshots: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="projectRestrictedSnapshotsInput" onchange="" class="form-control" name="projectRestrictedSnapshotsInput">
                            <option value="">(not set)</option>
                            <option value="allow">allow</option>
                            <option value="block">block</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to allow the creation of instance and volume snaphots. Default: blocked'></i>
                      </div>
                    </div>

                    <div class="row" id="projectRestrictedVirtualMachinesLowlevelRow" style="display: none;">
                      <label class="col-4 col-form-label text-right">restricted.virtual-machines.lowlevel: </label>
                      <div class="col-6">
                        <div class="form-group">
                          <select id="projectRestrictedVirtualMachinesLowlevelInput" onchange="" class="form-control" name="projectRestrictedVirtualMachinesLowlevelInput">
                            <option value="">(not set)</option>
                            <option value="allow">allow</option>
                            <option value="block">block</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1">
                        <i class="far fa-sm fa-question-circle" title='Select whether or not to allow the use of low-level virtual-machine options like raw.qemu, volatile, etc. Default: blocked'></i>
                      </div>
                    </div>

                  </div>
                </div>


                <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                  <a class="btn btn-primary" href="#" onclick="createProjectUsingForm()" data-dismiss="modal">Submit</a>
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
                  <a class="btn btn-primary" href="#" onclick="createProjectUsingJSON()" data-dismiss="modal">Submit</a>
                </div>
              </div>
            </div>

          </div>
  
      </div>
    </div>
  </div>

  <!-- Edit Project Modal-->
  <div class="modal fade" id="editProjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Project</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <label class="col-4 col-form-label" id="projectNameEditInput"></label>
              <div class="col-12">
                <div class="form-group text-right">
                  <pre>
                    <textarea name="json" class="form-control" id="jsonInput" rows="16" ></textarea>
                  </pre>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="#" onclick="updateProject()" data-dismiss="modal">Submit</a>
          </div>
      </div>
    </div>
  </div>

  <!-- Rename Project Modal-->
  <div class="modal fade" id="renameProjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="renameProjectModalLabel">Rename Project</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <label class="col-3 col-form-label text-right" id="newProjectNameLabel">Name: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="newProjectName" class="form-control" placeholder="">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Enter in a new name for the project.'></i>
              </div>
            </div>
            <input type="hidden" id ="projectToRename" name="projectToRename">
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="#" onclick="renameProject()" data-dismiss="modal">Ok</a>
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
  var projectToUpdate = "";

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

    $('#projectListTable').DataTable().ajax.reload(null, false);

    pageReloadTimeout = setTimeout(() => { reloadPageContent(); }, 7000);
  }

  function loadPageContent(){

    //Display current logged in username
    $("#username").load("./backend/admin/settings.php?action=displayUsername");

    $('#projectListTable').DataTable( {
      ajax: "./backend/lxd/projects.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=listProjects",
      columns: [
        {},
        { title: "Name" },
        { title: "Description" },
        { title: "Features Images" },
        { title: "Features Networks" },
        { title: "Features Profiles" },
        { title: "Features Storage Volumes" },
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

  function createProjectUsingForm(){
    var projectNameInput = $("#projectNameInput").val();
    var projectDescriptionInput = $("#projectDescriptionInput").val();
    var projectFeaturesImagesInput = $("#projectFeaturesImagesInput").val();
    var projectFeaturesNetworksInput = $("#projectFeaturesNetworksInput").val();
    var projectFeaturesProfilesInput = $("#projectFeaturesProfilesInput").val();
    var projectFeaturesStorageVolumesInput = $("#projectFeaturesStorageVolumesInput").val();
    var projectBackupsCompressionAlgorithmInput = $("#projectBackupsCompressionAlgorithmInput").val();
    var projectImagesAutoUpdateCachedInput = $("#projectImagesAutoUpdateCachedInput").val();
    var projectImagesAutoUpdateIntervalInput = $("#projectImagesAutoUpdateIntervalInput").val();
    var projectImagesCompressionAlgorithmInput = $("#projectImagesCompressionAlgorithmInput").val();
    var projectImagesDefaultArchitectureInput = $("#projectImagesDefaultArchitectureInput").val();
    var projectImagesRemoteCacheExpiryInput = $("#projectImagesRemoteCacheExpiryInput").val();
    var projectLimitsContainersInput = $("#projectLimitsContainersInput").val();
    var projectLimitsCpuInput = $("#projectLimitsCpuInput").val();
    var projectLimitsDiskInput = $("#projectLimitsDiskInput").val();
    var projectLimitsInstancesInput = $("#projectLimitsInstancesInput").val();
    var projectLimitsMemoryInput = $("#projectLimitsMemoryInput").val();
    var projectLimitsNetworksInput = $("#projectLimitsNetworksInput").val();
    var projectLimitsProcessesInput = $("#projectLimitsProcessesInput").val();
    var projectLimitsVirtualMachinesInput = $("#projectLimitsVirtualMachinesInput").val();
    var projectRestrictedInput = $("#projectRestrictedInput").val();
    var projectRestrictedBackupsInput = $("#projectRestrictedBackupsInput").val();
    var projectRestrictedClusterTargetInput = $("#projectRestrictedClusterTargetInput").val();
    var projectRestrictedContainersLowlevelInput = $("#projectRestrictedContainersLowlevelInput").val();
    var projectRestrictedContainersNestingInput = $("#projectRestrictedContainersNestingInput").val();
    var projectRestrictedContainersPrivilegeInput = $("#projectRestrictedContainersPrivilegeInput").val();
    var projectRestrictedDevicesDiskInput = $("#projectRestrictedDevicesDiskInput").val();
    var projectRestrictedDevicesGpuInput = $("#projectRestrictedDevicesGpuInput").val();
    var projectRestrictedDevicesInfinibandInput = $("#projectRestrictedDevicesInfinibandInput").val();
    var projectRestrictedDevicesNicInput = $("#projectRestrictedDevicesNicInput").val();
    var projectRestrictedDevicesPciInput = $("#projectRestrictedDevicesPciInput").val();
    var projectRestrictedDevicesProxyInput = $("#projectRestrictedDevicesProxyInput").val();
    var projectRestrictedDevicesUnixBlockInput = $("#projectRestrictedDevicesUnixBlockInput").val();
    var projectRestrictedDevicesUnixCharInput = $("#projectRestrictedDevicesUnixCharInput").val();
    var projectRestrictedDevicesUnixHotplugInput = $("#projectRestrictedDevicesUnixHotplugInput").val();
    var projectRestrictedDevicesUsbInput = $("#projectRestrictedDevicesUsbInput").val();
    var projectRestrictedNetworksSubnetsInput = $("#projectRestrictedNetworksSubnetsInput").val();
    var projectRestrictedNetworksUplinksInput = $("#projectRestrictedNetworksUplinksInput").val();
    var projectRestrictedSnapshotsInput = $("#projectRestrictedSnapshotsInput").val();
    var projectRestrictedVirtualMachinesLowlevelInput = $("#projectRestrictedVirtualMachinesLowlevelInput").val();
    
    console.log("Info: creating project " + projectNameInput);
    $.get("./backend/lxd/projects.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + 
    "&name=" + encodeURI(projectNameInput) + 
    "&description=" + encodeURI(projectDescriptionInput) + 
    "&features_images=" + encodeURI(projectFeaturesImagesInput) + 
    "&features_networks=" + encodeURI(projectFeaturesNetworksInput) + 
    "&features_profiles=" + encodeURI(projectFeaturesProfilesInput) + 
    "&features_storage_volumes=" + encodeURI(projectFeaturesStorageVolumesInput) + 
    "&backups_compression_algorithm=" + encodeURI(projectBackupsCompressionAlgorithmInput) + 
    "&images_auto_update_cached=" + encodeURI(projectImagesAutoUpdateCachedInput) + 
    "&images_auto_update_interval=" + encodeURI(projectImagesAutoUpdateIntervalInput) + 
    "&images_compression_algorithm=" + encodeURI(projectImagesCompressionAlgorithmInput) + 
    "&images_default_architecture=" + encodeURI(projectImagesDefaultArchitectureInput) + 
    "&images_remote_cache_expiry=" + encodeURI(projectImagesRemoteCacheExpiryInput) + 
    "&limits_containers=" + encodeURI(projectLimitsContainersInput) + 
    "&limits_cpu=" + encodeURI(projectLimitsCpuInput) + 
    "&limits_disk=" + encodeURI(projectLimitsDiskInput) + 
    "&limits_instances=" + encodeURI(projectLimitsInstancesInput) + 
    "&limits_memory=" + encodeURI(projectLimitsMemoryInput) + 
    "&limits_networks=" + encodeURI(projectLimitsNetworksInput) + 
    "&limits_processes=" + encodeURI(projectLimitsProcessesInput) + 
    "&limits_virtual_machines=" + encodeURI(projectLimitsVirtualMachinesInput) + 
    "&restricted=" + encodeURI(projectRestrictedInput) + 
    "&restricted_backups=" + encodeURI(projectRestrictedBackupsInput) + 
    "&restricted_cluster_target=" + encodeURI(projectRestrictedClusterTargetInput) + 
    "&restricted_containers_lowlevel=" + encodeURI(projectRestrictedContainersLowlevelInput) + 
    "&restricted_containers_nesting=" + encodeURI(projectRestrictedContainersNestingInput) + 
    "&restricted_containers_privilege=" + encodeURI(projectRestrictedContainersPrivilegeInput) + 
    "&restricted_devices_disk=" + encodeURI(projectRestrictedDevicesDiskInput) + 
    "&restricted_devices_gpu=" + encodeURI(projectRestrictedDevicesGpuInput) + 
    "&restricted_devices_infiniband=" + encodeURI(projectRestrictedDevicesInfinibandInput) + 
    "&restricted_devices_nic=" + encodeURI(projectRestrictedDevicesNicInput) + 
    "&restricted_devices_pci=" + encodeURI(projectRestrictedDevicesPciInput) + 
    "&restricted_devices_proxy=" + encodeURI(projectRestrictedDevicesProxyInput) + 
    "&restricted_devices_unix_block=" + encodeURI(projectRestrictedDevicesUnixBlockInput) + 
    "&restricted_devices_unix_char=" + encodeURI(projectRestrictedDevicesUnixCharInput) + 
    "&restricted_devices_unix_hotplug=" + encodeURI(projectRestrictedDevicesUnixHotplugInput) + 
    "&restricted_devices_usb=" + encodeURI(projectRestrictedDevicesUsbInput) + 
    "&restricted_networks_subnets=" + encodeURI(projectRestrictedNetworksSubnetsInput) + 
    "&restricted_networks_uplinks=" + encodeURI(projectRestrictedNetworksUplinksInput) + 
    "&restricted_snapshots=" + encodeURI(projectRestrictedSnapshotsInput) + 
    "&restricted_virtual_machines_lowlevel=" + encodeURI(projectRestrictedVirtualMachinesLowlevelInput) + 
    "&action=createProjectUsingForm",  function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function createProjectUsingJSON(){
    var projectCreateJSON = $("#jsonCreateInput").val();
    console.log("Info: creating project");
    $.post("./backend/lxd/projects.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&action=createProjectUsingJSON", {json: projectCreateJSON},  function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function loadProjectJson(projectToLoad){
    console.log("Info: loading project " + projectToLoad);
    projectToUpdate = projectToLoad;
    $.get("./backend/lxd/projects.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&name=" + encodeURI(projectToLoad) + "&action=loadProject", function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      $("#projectNameEditInput").text("Name: " + projectToLoad);
      $("#jsonInput").val(JSON.stringify(operationData.metadata, null, 2));
      $("#editProjectModal").modal('show');
    });
  }

  function loadRenameProject(projectToRename){
    console.log("Loading rename modal for project " + projectToRename)
    $("#renameProjectModalLabel").text("Rename project: " + projectToRename);
    $("#projectToRename").val(projectToRename);
    $("#renameProjectModal").modal('show');
  }

  function updateProject(){
    var projectUpdateJSON = $("#jsonInput").val();
    console.log("Info: updating project " + projectToUpdate);
    $.post("./backend/lxd/projects.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectToUpdate) + "&action=updateProject",{json: projectUpdateJSON},  function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function renameProject(){
    var projectNewName = $("#newProjectName").val();
    var projectToRename = $("#projectToRename").val();
    console.log("Info: renaming project " + projectToRename);
    $.get("./backend/lxd/projects.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectToRename) + "&name=" + encodeURI(projectNewName) + "&action=renameProject",  function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 2000);
    });
  }

  function deleteProject(projectToDelete){
    console.log("Info: deleting project " + projectToDelete);
    $.get("./backend/lxd/projects.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&name=" + encodeURI(projectToDelete) + "&action=deleteProject", function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function changeRestrictedOptionsDisplay(){
    var projectRestrictedInput = $("#projectRestrictedInput").val();

    if (projectRestrictedInput == "true"){
      $("#projectRestrictedBackupsRow").show();
      $("#projectRestrictedClusterTargetRow").show();
      $("#projectRestrictedContainersLowlevelRow").show();
      $("#projectRestrictedContainersNestingRow").show();
      $("#projectRestrictedContainersPrivilegeRow").show();
      $("#projectRestrictedDevicesDiskRow").show();
      $("#projectRestrictedDevicesGpuRow").show();
      $("#projectRestrictedDevicesInfinibandRow").show();
      $("#projectRestrictedDevicesNicRow").show();
      $("#projectRestrictedDevicesPciRow").show();
      $("#projectRestrictedDevicesProxyRow").show();
      $("#projectRestrictedDevicesUnixBlockRow").show();
      $("#projectRestrictedDevicesUnixCharRow").show();
      $("#projectRestrictedDevicesUnixHotplugRow").show();
      $("#projectRestrictedDevicesUsbRow").show();
      $("#projectRestrictedNetworksSubnetsRow").show();
      $("#projectRestrictedNetworksUplinksRow").show();
      $("#projectRestrictedSnapshotsRow").show();
      $("#projectRestrictedVirtualMachinesLowlevelRow").show();
    }
    else {
      $("#projectRestrictedBackupsRow").hide();
      $("#projectRestrictedClusterTargetRow").hide();
      $("#projectRestrictedContainersLowlevelRow").hide();
      $("#projectRestrictedContainersNestingRow").hide();
      $("#projectRestrictedContainersPrivilegeRow").hide();
      $("#projectRestrictedDevicesDiskRow").hide();
      $("#projectRestrictedDevicesGpuRow").hide();
      $("#projectRestrictedDevicesInfinibandRow").hide();
      $("#projectRestrictedDevicesNicRow").hide();
      $("#projectRestrictedDevicesPciRow").hide();
      $("#projectRestrictedDevicesProxyRow").hide();
      $("#projectRestrictedDevicesUnixBlockRow").hide();
      $("#projectRestrictedDevicesUnixCharRow").hide();
      $("#projectRestrictedDevicesUnixHotplugRow").hide();
      $("#projectRestrictedDevicesUsbRow").hide();
      $("#projectRestrictedNetworksSubnetsRow").hide();
      $("#projectRestrictedNetworksUplinksRow").hide();
      $("#projectRestrictedSnapshotsRow").hide();
      $("#projectRestrictedVirtualMachinesLowlevelRow").hide();
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