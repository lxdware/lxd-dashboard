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
                      SETTINGS
                    </h2>
                    <div class="page-header-subtitle">
                      Edit system settings
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
                      <li class="nav-item"><a class="nav-link active" id="nav-users-tab" href="#nav-users" data-toggle="pill" role="tab" aria-controls="nav-users" aria-selected="true">Users</a></li>
                      <li class="nav-item"><a class="nav-link" id="nav-groups-tab" href="#nav-groups" data-toggle="pill" role="tab" aria-controls="nav-groups" aria-selected="false">Groups</a></li>
                      <li class="nav-item"><a class="nav-link" id="nav-certs-tab" href="#nav-certs" data-toggle="pill" role="tab" aria-controls="nav-certs" aria-selected="false">Certificates</a></li>
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

                      <div class="tab-pane fade show active" id="nav-users" role="tabpanel" aria-labelledby="nav-users-tab">
                        <!-- Users List -->
                        <div class="text-right mb-3 mt-n1">
                          <button type="button" class="btn btn-outline-primary"  id="" data-toggle="modal" data-target="#createUserModal" title="New User" onclick=""><i class="fas fa-plus fa-sm fa-fw"></i>User</button>
                        </div>
                        <div class="table-responsive">
                          <table class="table" id="userListTable" width="100%" cellspacing="0">
                          </table>
                        </div>
                        <!-- End Users List -->
                      </div>
                      <div class="tab-pane fade" id="nav-groups" role="tabpanel" aria-labelledby="nav-groups-tab">
                        <!-- Groups List -->
                        <div class="text-right mb-3 mt-n1">
                          <button type="button" class="btn btn-outline-primary"  id="" data-toggle="modal" data-target="#createGroupModal" title="New Group" onclick=""><i class="fas fa-plus fa-sm fa-fw"></i>Group</button>
                        </div>
                        <div class="table-responsive">
                          <table class="table" id="groupListTable" width="100%" cellspacing="0">
                          </table>
                        </div>
                        <!-- End Groups List -->
                      </div>
                      <div class="tab-pane fade" id="nav-certs" role="tabpanel" aria-labelledby="nav-certs-tab">
                        <!-- Local Certificates List -->
                        <div class="text-right mb-3 mt-n1" style="min-height: 38px;">
                          <!--<button type="button" class="btn btn-outline-primary"  id="" data-toggle="modal" data-target="#createCertModal" title="New Certificate" onclick=""><i class="fas fa-plus fa-sm fa-fw"></i>Certificate</button>-->
                        </div>
                        <div class="table-responsive">
                          <table class="table" id="certListTable" width="100%" cellspacing="0">
                          </table>
                        </div>
                        <!-- End Local Certificates List -->
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

  <!-- Add User Modal-->
  <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create User</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="row">
            <label class="col-3 col-form-label text-right">Username: <span class="text-danger">*</span></label>
            <div class="col-7">
              <div class="form-group">
                <input type="text" id="usernameInput" class="form-control" required="required" placeholder="" name="usernameInput">
              </div>
            </div>
            <div class="col-1">
              <i class="far fa-sm fa-question-circle" title='(Required) - Enter in a username for the user.'></i>
            </div>
          </div>

          <div class="row">
            <label class="col-3 col-form-label text-right">Password: <span class="text-danger">*</span></label>
            <div class="col-7">
              <div class="form-group">
                <input type="password" id="passwordInput" class="form-control" required="required" placeholder="" name="passwordInput">
              </div>
            </div>
            <div class="col-1">
              <i class="far fa-sm fa-question-circle" title='(Required) - Enter in a password for the user.'></i>
            </div>
          </div>

          <div class="row">
            <label class="col-3 col-form-label text-right">First Name: </label>
            <div class="col-7">
              <div class="form-group">
                <input type="text" id="firstNameInput" class="form-control" placeholder="" name="firstNameInput">
              </div>
            </div>
            <div class="col-1">
              <i class="far fa-sm fa-question-circle" title='Enter in the firstname of the user.'></i>
            </div>
          </div>

          <div class="row">
            <label class="col-3 col-form-label text-right">Last Name: </label>
            <div class="col-7">
              <div class="form-group">
                <input type="text" id="lastNameInput" class="form-control" placeholder="" name="lastNameInput">
              </div>
            </div>
            <div class="col-1">
              <i class="far fa-sm fa-question-circle" title='Enter in the lastname of the user.'></i>
            </div>
          </div>

          <div class="row">
            <label class="col-3 col-form-label text-right">Email: </label>
            <div class="col-7">
              <div class="form-group">
                <input type="text" id="emailInput" class="form-control" required="required" placeholder="" name="emailInput">
              </div>
            </div>
            <div class="col-1">
              <i class="far fa-sm fa-question-circle" title='Enter in the email address of the user.'></i>
            </div>
          </div>

        </div> <!-- End Modal Body-->
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="#" onclick="createUser()" data-dismiss="modal">Submit</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Group Modal-->
  <div class="modal fade" id="addGroupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Group</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="row">
            <label class="col-3 col-form-label text-right">Group:</label>
            <div class="col-7 text-right">
              <div class="form-group">
                <select id="groupIdForAddGroupInput" class="form-control" name="groupIdForAddGroupInput">
                </select>
              </div>
            </div>
            <div class="col-1">
              <i class="far fa-sm fa-question-circle" title='Select the group to add.'></i>
            </div>
          </div>

          <input type="hidden" id="userIdForAddGroupInput" name="userIdForAddGroupInput">

        </div> <!-- End Modal Body-->
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="#" onclick="addGroup()" data-dismiss="modal">Submit</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Remove Group Modal-->
  <div class="modal fade" id="removeGroupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Remove Group</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="row">
            <label class="col-3 col-form-label text-right">Group:</label>
            <div class="col-7 text-right">
              <div class="form-group">
                <select id="groupIdForRemoveGroupInput" class="form-control" name="groupIdForRemoveGroupInput">
                </select>
              </div>
            </div>
            <div class="col-1">
              <i class="far fa-sm fa-question-circle" title='Select the group to remove.'></i>
            </div>
          </div>

          <input type="hidden" id="userIdForRemoveGroupInput" name="userIdForRemoveGroupInput">

        </div> <!-- End Modal Body-->
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="#" onclick="removeGroup()" data-dismiss="modal">Submit</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete User Modal-->
  <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Are you sure you want to delete this user?</div>
        <input type="hidden" id="userIdForDeleteUserInput" name="userIdForDeleteUserInput">
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="#" onclick="deleteUser()" data-dismiss="modal">Yes</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Create Group Modal-->
  <div class="modal fade" id="createGroupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create Group</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="row">
            <label class="col-3 col-form-label text-right">Name: <span class="text-danger">*</span></label>
            <div class="col-7">
              <div class="form-group">
                <input type="text" id="nameInput" class="form-control" required="required" placeholder="" name="nameInput">
              </div>
            </div>
            <div class="col-1">
              <i class="far fa-sm fa-question-circle" title='(Required) - Enter in a name for the group.'></i>
            </div>
          </div>

          <div class="row">
            <label class="col-3 col-form-label text-right">Description </label>
            <div class="col-7">
              <div class="form-group">
                <input type="text" id="descriptionInput" class="form-control" required="required" placeholder="" name="descriptionInput">
              </div>
            </div>
            <div class="col-1">
              <i class="far fa-sm fa-question-circle" title='Enter in a description for the group.'></i>
            </div>
          </div>

        </div> <!-- End Modal Body-->
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="#" onclick="createGroup()" data-dismiss="modal">Submit</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Role Modal-->
  <div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="row">
            <label class="col-3 col-form-label text-right">Role:</label>
            <div class="col-7 text-right">
              <div class="form-group">
                <select id="roleIdForAddRoleInput" class="form-control" name="roleIdForAddRoleInput">
                </select>
              </div>
            </div>
            <div class="col-1">
              <i class="far fa-sm fa-question-circle" title='Select the role to add.'></i>
            </div>
          </div>

          <input type="hidden" id="groupIdForAddRoleInput" name="groupIdForAddRoleInput">

        </div> <!-- End Modal Body-->
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="#" onclick="addRole()" data-dismiss="modal">Submit</a>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Remove Role Modal-->
  <div class="modal fade" id="removeRoleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Remove Role</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="row">
            <label class="col-3 col-form-label text-right">Role:</label>
            <div class="col-7 text-right">
              <div class="form-group">
                <select id="roleIdForRemoveRoleInput" class="form-control" name="roleIdForRemoveRoleInput">
                </select>
              </div>
            </div>
            <div class="col-1">
              <i class="far fa-sm fa-question-circle" title='Select the role to remove.'></i>
            </div>
          </div>

          <input type="hidden" id="groupIdForRemoveRoleInput" name="groupIdForRemoveRoleInput">

        </div> <!-- End Modal Body-->
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="#" onclick="removeRole()" data-dismiss="modal">Submit</a>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Create Cert Modal-->
  <div class="modal fade" id="createCertModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create Certificate</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="row">
            <label class="col-3 col-form-label text-right">Name: <span class="text-danger">*</span></label>
            <div class="col-7">
              <div class="form-group">
                <input type="text" id="certNameInput" class="form-control" required="required" placeholder="" name="certNameInput">
              </div>
            </div>
            <div class="col-1">
              <i class="far fa-sm fa-question-circle" title='(Required) - Enter in a name used to create the new certificate files.'></i>
            </div>
          </div>

          <div class="row">
            <label class="col-3 col-form-label text-right">Days: </label>
            <div class="col-7">
              <div class="form-group">
                <input type="number" id="certDaysInput" class="form-control" value="3650" placeholder="" name="certDaysInput">
              </div>
            </div>
            <div class="col-1">
              <i class="far fa-sm fa-question-circle" title='Enter in the number of days the certificate is valid. Default: 3650'></i>
            </div>
          </div>

        </div> <!-- End Modal Body-->
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="#" onclick="createCert()" data-dismiss="modal">Submit</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Group Modal-->
  <div class="modal fade" id="deleteGroupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete Group</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Are you sure you want to delete this group?</div>
        <input type="hidden" id="groupIdForDeleteGroupInput" name="groupIdForDeleteGroupInput">
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="#" onclick="deleteGroup()" data-dismiss="modal">Yes</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Cert Modal-->
 <div class="modal fade" id="deleteCertModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Certificate</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Are you sure you want to delete this certificate?</div>
      <input type="hidden" id="filenameForDeleteCertificateInput" name="filenameForDeleteCertificateInput">
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary" href="#" onclick="deleteCert()" data-dismiss="modal">Yes</a>
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

  function logout(){
    $.get("./backend/aaa/authentication.php?action=deauthenticateUser", function (data) {
      operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.status_code == 200) {
        window.location.href = './index.php'
      }
    });
  }

  function reloadPageContent() {

    //Check Authorization
    $.get("./backend/aaa/authentication.php?action=validateAuthentication", function (data) {
      operationData = JSON.parse(data);
      if (operationData.status_code != 200) {
        console.log(operationData);
        window.location.href = './index.php'
      }
    });

    $('#userListTable').DataTable().ajax.reload(null, false);
    $('#groupListTable').DataTable().ajax.reload(null, false);
    $('#certListTable').DataTable().ajax.reload(null, false);
  }

  function loadPageContent(){

    //Display current logged in username
    $("#username").load("./backend/admin/settings.php?action=displayUsername");

    $('#userListTable').DataTable( {
      ajax: "./backend/admin/settings.php?action=listUsers",
      columns: [
        {},
        { title: "Username" },
        { title: "Email" },
        { title: "Account Type" },
        { title: "Groups" },
        { title: "Action" }
      ],
      order: [],
      columnDefs: [
        { targets: 0, orderable: false, width: "25px" }
      ]
    });

    $('#groupListTable').DataTable( {
      ajax: "./backend/admin/settings.php?action=listGroups",
      columns: [
        {},
        { title: "Name" },
        { title: "Description" },
        { title: "Roles" },
        { title: "Action" }
      ],
      order: [],
      columnDefs: [
        { targets: 0, orderable: false, width: "25px" }
      ]
    });

    $('#certListTable').DataTable( {
      ajax: "./backend/config/cert.php?action=listCertificateFiles",
      columns: [
        {},
        { title: "Filename" },
        { title: "Issuer CN" },
        { title: "Valid From" },
        { title: "Valid To" },
        { title: "Action" }
      ],
      order: [],
      columnDefs: [
        { targets: 0, orderable: false, width: "25px" }
      ]
    });

    //Set the page content to reload in 7 seconds
    setInterval(() => { reloadPageContent(); }, 7000);
  }

  function createUser(){
    var usernameInput = $("#usernameInput").val();
    var passwordInput = $("#passwordInput").val();
    var firstNameInput = $("#firstNameInput").val();
    var lastNameInput = $("#lastNameInput").val();
    var emailInput = $("#emailInput").val();
    console.log("Info: creating user " + usernameInput);
    $.post('./backend/admin/settings.php?action=createUser', {username: usernameInput, password: passwordInput, first_name: firstNameInput, last_name: lastNameInput, email: emailInput}, function (data) {
        var operationData = JSON.parse(data);
        console.log(operationData);
        if (operationData.status_code >= 400) {
          alert(operationData.metadata.error);
        }
        setTimeout(() => { reloadPageContent(); }, 1000)
    });
  }

  function deleteUser(){
    var userIdForDeleteUserInput = $("#userIdForDeleteUserInput").val();
    console.log("Info: deleting user, id: " + userIdForDeleteUserInput);
    $.get("./backend/admin/settings.php?id=" + encodeURI(userIdForDeleteUserInput) + "&action=deleteUser",  function (data) {
      operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.status_code >= 400){
        alert(operationData.metadata.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function addGroup(){
    var userIdForAddGroupInput = $("#userIdForAddGroupInput").val();
    var groupIdForAddGroupInput = $("#groupIdForAddGroupInput").val();
    console.log("Info: adding group to user");
    $.get("./backend/admin/settings.php?id=" + encodeURI(userIdForAddGroupInput) + "&group_id=" + encodeURI(groupIdForAddGroupInput) + "&action=addUserToGroup",  function (data) {
      operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.status_code >= 400){
        alert(operationData.metadata.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function removeGroup(){
    var userIdForRemoveGroupInput = $("#userIdForRemoveGroupInput").val();
    var groupIdForRemoveGroupInput = $("#groupIdForRemoveGroupInput").val();
    console.log("Info: removing group from user");
    $.get("./backend/admin/settings.php?id=" + encodeURI(userIdForRemoveGroupInput) + "&group_id=" + encodeURI(groupIdForRemoveGroupInput) + "&action=removeGroupFromUser",  function (data) {
      operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.status_code >= 400){
        alert(operationData.metadata.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function loadAddGroupModal(userId){
    $("#groupIdForAddGroupInput").load("./backend/admin/settings.php?id=" + userId + "&action=listGroupsNotAssignedToUserForSelect");
    $("#userIdForAddGroupInput").val(userId);
    $("#addGroupModal").modal('show');
  }

  function loadRemoveGroupModal(userId){
    $("#groupIdForRemoveGroupInput").load("./backend/admin/settings.php?id=" + userId + "&action=listGroupsAssignedToUserForSelect");
    $("#userIdForRemoveGroupInput").val(userId);
    $("#removeGroupModal").modal('show');
  }

  function loadDeleteUserModal(userId){
    $("#userIdForDeleteUserInput").val(userId);
    $("#deleteUserModal").modal('show');
  }

  function createGroup(){
    var nameInput = $("#nameInput").val();
    var descriptionInput = $("#descriptionInput").val();
    console.log("Info: adding group " + nameInput);
    $.get("./backend/admin/settings.php?name=" + encodeURI(nameInput) + "&description=" + encodeURI(descriptionInput) + "&action=createGroup",  function (data) {
      operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.status_code >= 400){
        alert(operationData.metadata.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function deleteGroup(){
    var groupIdForDeleteGroupInput = $("#groupIdForDeleteGroupInput").val();
    console.log("Info: deleting group, id " + groupIdForDeleteGroupInput);
    $.get("./backend/admin/settings.php?id=" + encodeURI(groupIdForDeleteGroupInput) + "&action=deleteGroup",  function (data) {
      operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.status_code >= 400){
        alert(operationData.metadata.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function addRole(){
    var groupIdForAddRoleInput = $("#groupIdForAddRoleInput").val();
    var roleIdForAddRoleInput = $("#roleIdForAddRoleInput").val();
    console.log("Info: adding role to group");
    $.get("./backend/admin/settings.php?id=" + encodeURI(groupIdForAddRoleInput) + "&role_id=" + encodeURI(roleIdForAddRoleInput) + "&action=addRoleToGroup",  function (data) {
      operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.status_code >= 400){
        alert(operationData.metadata.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function removeRole(){
    var groupIdForRemoveRoleInput = $("#groupIdForRemoveRoleInput").val();
    var roleIdForRemoveRoleInput = $("#roleIdForRemoveRoleInput").val();
    console.log("Info: removing role from group");
    $.get("./backend/admin/settings.php?id=" + encodeURI(groupIdForRemoveRoleInput) + "&role_id=" + encodeURI(roleIdForRemoveRoleInput) + "&action=removeRoleFromGroup",  function (data) {
      operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.status_code >= 400){
        alert(operationData.metadata.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function loadAddRoleModal(groupId){
    $("#roleIdForAddRoleInput").load("./backend/admin/settings.php?id=" + groupId + "&action=listRolesNotAssignedToGroupForSelect");
    $("#groupIdForAddRoleInput").val(groupId);
    $("#addRoleModal").modal('show');
  }

  function loadRemoveRoleModal(groupId){
    $("#roleIdForRemoveRoleInput").load("./backend/admin/settings.php?id=" + groupId + "&action=listRolesAssignedToGroupForSelect");
    $("#groupIdForRemoveRoleInput").val(groupId);
    $("#removeRoleModal").modal('show');
  }

  function loadDeleteGroupModal(groupId){
    $("#groupIdForDeleteGroupInput").val(groupId);
    $("#deleteGroupModal").modal('show');
  }

  function loadDeleteCertModal(certFilename){
    $("#filenameForDeleteCertificateInput").val(certFilename);
    $("#deleteCertModal").modal('show');
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

  function createCert(){
    var certNameInput = $("#certNameInput").val();
    var certDaysInput = $("#certDaysInput").val();
    console.log("Info: creating cert " + certNameInput);
    $.get('./backend/config/cert.php?name=' + encodeURI(certNameInput) + '&days=' + encodeURI(certDaysInput) + '&action=createCertificateFiles',  function (data) {
        var operationData = JSON.parse(data);
        console.log(operationData);
        if (operationData.status_code >= 400) {
          alert(operationData.metadata.error);
        }
        setTimeout(() => { reloadPageContent(); }, 1000)
    });
  }

  function deleteCert(){
    var filenameForDeleteCertificateInput = $("#filenameForDeleteCertificateInput").val();
    console.log("Info: deleting cert " + filenameForDeleteCertificateInput);
    $.get('./backend/config/cert.php?name=' + encodeURI(filenameForDeleteCertificateInput) + '&action=deleteCertificateFiles',  function (data) {
        var operationData = JSON.parse(data);
        console.log(operationData);
        if (operationData.status_code >= 400) {
          alert(operationData.metadata.error);
        }
        setTimeout(() => { reloadPageContent(); }, 1000)
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

    //Load the card contents
    loadPageContent();
    
    //Load the about info for the about modal
    $.get("./backend/config/about.php", function (data) {
      $("#about").html(data);
    });    

  });

</script>

</html>