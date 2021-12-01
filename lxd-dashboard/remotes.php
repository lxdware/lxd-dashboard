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
                      REMOTE HOSTS
                    </h2>
                    <div class="page-header-subtitle">
                      Add and manage remote LXD host servers
                    </div>
                  </div>
                  <div class="col-12 col-xl-auto mt-4">
                    <div class="input-group input-group-joined border-0" style="width: 26rem">
                      <span class="input-group-text bg-transparent border-0">
                        <a class="btn btn-outline-primary mr-3" href="#" data-toggle="modal" data-target="#clientCertModal" title="View Certificate" aria-hidden="true">
                          <i class="fas fa-plus fa-sm fa-fw"></i> View Certificate
                        </a> 
                        <a class="btn btn-outline-primary" href="#" data-toggle="modal" data-target="#addLxdModal" title="Add Host" aria-hidden="true">
                          <i class="fas fa-plus fa-sm fa-fw"></i>  Add Host
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
              <!-- Remote Host List -->
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
                    <table class="table" id="lxdListTable" width="100%" cellspacing="0">
                    </table>
                  </div>
                </div>
              </div>
              <!-- End Remote Host List -->
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

  <!-- Add Remote Host Modal-->
  <div class="modal fade" id="addLxdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add LXD Host</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <p class="ml-4 mb-4">
            Before adding a remote host, the LXD server must first trust your client certificate. <br />
            Click <a href="#" onclick="loadInstructionsModal()">here</a> for instructions on trusting certificates.
          </p>
          
          <div class="row">
            <label class="col-3 col-form-label text-right">Address: <span class="text-danger">*</span></label>
            <div class="col-7">
              <div class="form-group">
                <input type="text" class="form-control" id="hostInput" required="required" name="host">
              </div>
            </div>
          <div class="col-1">
            <i class="far fa-sm fa-question-circle" title='(Required) - Enter in the IP address or FQDN of the LXD server'></i>
          </div>
          </div>

          <div class="row">
            <label class="col-3 col-form-label text-right">Port: <span class="text-danger">*</span></label>
            <div class="col-7">
              <div class="form-group">
                <input type="number" class="form-control"  id="portInput" required="required" value="8443" name="port">
              </div>
            </div>
            <div class="col-1">
              <i class="far fa-sm fa-question-circle" title='(Required) - Enter in the listening network port to connect to the LXD server. Default: 8443'></i>
            </div>
          </div>

          <div class="row">
            <label class="col-3 col-form-label text-right">Alias: </label>
            <div class="col-7">
              <div class="form-group">
                <input type="text" class="form-control"  id="aliasInput" name="alias">
              </div>
            </div>
            <div class="col-1">
              <i class="far fa-sm fa-question-circle" title='Enter in a friendly name to identify the LXD server in the dashboard.'></i>
            </div>
          </div>

          <div class="row">
            <label class="col-3 col-form-label text-right">External Address: </label>
            <div class="col-7">
              <div class="form-group">
                <input type="text" class="form-control" id="externalHostInput" required="required" name="host">
              </div>
            </div>
          <div class="col-1">
            <i class="far fa-sm fa-question-circle" title='Enter in the IP address or FQDN of the LXD server used for making remote websocket connections. If empty, the host address will be used.'></i>
          </div>
          </div>

          <div class="row">
            <label class="col-3 col-form-label text-right">External Port: </label>
            <div class="col-7">
              <div class="form-group">
                <input type="number" class="form-control"  id="externalPortInput" required="required" name="port">
              </div>
            </div>
            <div class="col-1">
              <i class="far fa-sm fa-question-circle" title='Enter in the listening network port to connect to the LXD server used for making remote websocket connections. If empty, the host port will be used.'></i>
            </div>
          </div>

        </div> <!-- End Modal Body-->
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="#" onclick="addRemote()" data-dismiss="modal">Submit</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Remote Host Modal-->
  <div class="modal fade" id="editLxdHost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit LXD Host</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">  

          <div class="row">
            <label class="col-3 col-form-label text-right">Address: <span class="text-danger">*</span></label>
            <div class="col-7">
              <div class="form-group">
                <input type="text" class="form-control" id="hostEditInput" required="required" name="host">
              </div>
            </div>
          <div class="col-1">
            <i class="far fa-sm fa-question-circle" title='(Required) - Enter in the IP address or FQDN of the LXD server'></i>
          </div>
          </div>

          <div class="row">
            <label class="col-3 col-form-label text-right">Port: <span class="text-danger">*</span></label>
            <div class="col-7">
              <div class="form-group">
                <input type="number" class="form-control"  id="portEditInput" required="required" value="8443" name="port">
              </div>
            </div>
            <div class="col-1">
              <i class="far fa-sm fa-question-circle" title='(Required) - Enter in the listening network port to connect to the LXD server. Default: 8443'></i>
            </div>
          </div>

          <div class="row">
            <label class="col-3 col-form-label text-right">Alias: </label>
            <div class="col-7">
              <div class="form-group">
                <input type="text" class="form-control"  id="aliasEditInput" name="alias">
              </div>
            </div>
            <div class="col-1">
              <i class="far fa-sm fa-question-circle" title='Enter in a friendly name to identify the LXD server in the dashboard.'></i>
            </div>
          </div>

          <div class="row">
            <label class="col-3 col-form-label text-right">External Address: </label>
            <div class="col-7">
              <div class="form-group">
                <input type="text" class="form-control" id="externalHostEditInput" required="required" name="host">
              </div>
            </div>
          <div class="col-1">
            <i class="far fa-sm fa-question-circle" title='Enter in the IP address or FQDN of the LXD server used for making remote websocket connections. If empty, the host address will be used.'></i>
          </div>
          </div>

          <div class="row">
            <label class="col-3 col-form-label text-right">External Port: </label>
            <div class="col-7">
              <div class="form-group">
                <input type="number" class="form-control"  id="externalPortEditInput" required="required" name="port">
              </div>
            </div>
            <div class="col-1">
              <i class="far fa-sm fa-question-circle" title='Enter in the listening network port to connect to the LXD server used for making remote websocket connections. If empty, the host port will be used.'></i>
            </div>
          </div>

          <input type="hidden" id="idEditInput">

        </div> <!-- End Modal Body-->
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="#" onclick="updateRemote()" data-dismiss="modal">Submit</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Instructions Modal-->
  <div class="modal fade" id="instructionsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Instructions</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <p>
                Copy the client certificate
                and paste it into a new file on your remote LXD server such as <strong><em>lxdware.crt</em></strong>. <br />
                <pre id="instructionsClientCert"></pre>
              </p> 
              <p>Import the certificate file on your remote LXD server by running the command:<br /> 
                <code class="text-danger">lxc config trust add lxdware.crt</code>
              </p>
              <p>
                For LXD hosts that are not part of a cluster, use the following command to listen for incoming connections:<br />
                <code class="text-danger">lxc config set core.https_address [::]</code> 
              </p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Dismiss</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Client Cert Modal-->
  <div class="modal fade" id="clientCertModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">LXD Client Certificate</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <pre><div id="clientCert"></div></pre>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Dismiss</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Remote Host Modal-->
  <div class="modal fade" id="deleteRemote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete Remote Host</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Are you sure you want to delete this host?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="#" onclick="deleteRemote()" data-dismiss="modal">Yes</a>
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

    $('#lxdListTable').DataTable().ajax.reload(null, false);
  }

  function loadPageContent(){
    
    //Display current logged in username
    $("#username").load("./backend/admin/settings.php?action=displayUsername");

    $('#lxdListTable').DataTable( {
      ajax: "./backend/lxd/remotes.php?action=listRemotes",
      columns: [
        {},
        { title: "Host" },
        { title: "Port" },
        { title: "Alias" },
        { title: "External Address" },
        { title: "External Port" },
        { title: "Protocol" },
        { title: "Action" }
      ],
      order: [],
      columnDefs: [
        { targets: 0, orderable: false, width: "25px" }
      ]
    });

    //Load the basic info for the certificate
    $.get("./backend/config/cert.php?action=viewCertificate", function (data) {
      $("#clientCert").html(data);
    });

    //Set the page content to reload in 7 seconds
    setInterval(() => { reloadPageContent(); }, 7000);

  }

  function addRemote(){
    var hostName = $("#hostInput").val();
    var portNumber = $("#portInput").val();
    var aliasName = $("#aliasInput").val();
    console.log("Info: adding remote host " + hostName + ":" + portNumber);
    $.get("./backend/lxd/remotes.php?host=" + encodeURI(hostName) + 
    "&port=" + encodeURI(portNumber) + 
    "&alias=" + encodeURI(aliasName) + 
    "&external_host=" + encodeURI($("#externalHostInput").val()) + 
    "&external_port=" + encodeURI($("#externalPortInput").val()) + 
    "&action=addRemote",  function (data) {
      operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.status_code >= 400){
        alert(operationData.metadata.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function deleteRemote(remoteID){
    console.log("Info: removing remote host, id number " + remoteID);
    $.get("./backend/lxd/remotes.php?id=" + encodeURI(remoteID) + "&action=deleteRemote",  function (data) {
      operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.status_code >= 400){
        alert(operationData.metadata.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function loadInstructionsModal(){
    $.get("./backend/config/cert.php?action=viewCertificate", function (data) {
      $("#instructionsClientCert").html(data);
      $("#instructionsModal").modal('show');
    });
  }

  function editRemote(id){
    console.log("Info: loading edit host " + id);
    $.get("./backend/lxd/remotes.php?remote=" + encodeURI(id) + "&action=loadRemote", function (data) {
      operationData = JSON.parse(data);
      console.log(operationData);
      idEditInput
      $("#idEditInput").val(operationData.id);
      $("#hostEditInput").val(operationData.host);
      $("#portEditInput").val(operationData.port);
      $("#aliasEditInput").val(operationData.alias);
      $("#externalHostEditInput").val(operationData.external_host); 
      $("#externalPortEditInput").val(operationData.external_port); 
      $("#editLxdHost").modal('show');
    });
  }

  function updateRemote(){
    id = $("#idEditInput").val();
    console.log("Info: updating host " + id);
    $.get("./backend/lxd/remotes.php?remote=" + encodeURI(id) +
    "&host=" + encodeURI($("#hostEditInput").val()) + 
    "&port=" + encodeURI($("#portEditInput").val()) + 
    "&alias=" + encodeURI($("#aliasEditInput").val()) + 
    "&external_host=" + encodeURI($("#externalHostEditInput").val()) + 
    "&external_port=" + encodeURI($("#externalPortEditInput").val()) + 
    "&action=updateRemote", function (data) {
      operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.status_code >= 400){
        alert(operationData.metadata.error);
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

    //Load the card contents
    loadPageContent();

    //Load the about info for the about modal
    $.get("./backend/config/about.php", function (data) {
      $("#about").html(data);
    });

  });

</script>

</html>