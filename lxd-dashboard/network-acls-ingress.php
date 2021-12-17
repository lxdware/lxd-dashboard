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
                      <a href="#" id="networkAclsBreadCrumb"></a>
                    </div>
                    <h2 class="page-header-title mt-2">
                      <span id="networkAclBreadCrumb"></span> - Ingress Rules
                    </h2>
                    <div class="page-header-subtitle">
                      Create and manage network ingress rules
                    </div>
                  </div>
                  <div class="col-12 col-xl-auto mt-4">
                    <div class="input-group input-group-joined border-0" style="width: 14rem">
                      <span class="input-group-text bg-transparent border-0">
                        <a class="btn btn-outline-primary" href="#" data-toggle="modal" data-target="#addTrafficRuleModal" title="Add Traffic Rule" aria-hidden="true">
                          <i class="fas fa-plus fa-sm fa-fw"></i> Rule
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
              <!-- Ingress Rules List -->
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold">
                    <span class="ml-1">Ingress Rules</span>
                  </h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle mr-2" href="#" onclick="reloadPageContent()" title="Refresh" aria-hidden="true">
                      <i class="fa fa-sync fa-1x fa-fw"></i></a>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table" id="ingressListTable" width="100%" cellspacing="0">
                    </table>
                  </div>
                </div>
              </div>
              <!-- End Ingress Rules List -->
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

  <!-- Add Traffic Rule Modal-->
  <div class="modal fade" id="addTrafficRuleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Traffic Rule</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="row">
              <label class="col-3 col-form-label text-right">Action: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <select id="actionTrafficRuleInput" onchange="" class="form-control" name="actionTrafficRuleInput">
                    <option value="allow">allow</option>
                    <option value="reject">reject</option>
                    <option value="drop">drop</option>
                  </select>
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='(Required) - Select the action to be applied to this rule.'></i>
              </div>
            </div>

            <div class="row">
              <label class="col-3 col-form-label text-right">State: <span class="text-danger">*</span></label>
              <div class="col-7">
                <div class="form-group">
                  <select id="stateTrafficRuleInput" onchange="" class="form-control" name="stateTrafficRuleInput">
                    <option value="enabled">enabled</option>
                    <option value="disabled">disabled</option>
                    <option value="logged">logged</option>
                  </select>
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='(Required) - Select the state to be applied to this rule.'></i>
              </div>
            </div>

            <div class="row">
              <label class="col-3 col-form-label text-right">Description: </label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="descriptionTrafficRuleInput" class="form-control" placeholder="" name="descriptionTrafficRuleInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Enter in a description for this rule.'></i>
              </div>
            </div>

            <div class="row">
              <label class="col-3 col-form-label text-right">Source: </label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="sourceTrafficRuleInput" class="form-control" placeholder="" name="sourceTrafficRuleInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Enter in a comma separated list of CIDR address, IP ranges, source ACL names, @external, or @internal. Leaving this unset will default to any.'></i>
              </div>
            </div> 

            <div class="row">
              <label class="col-3 col-form-label text-right">Destination: </label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="destinationTrafficRuleInput" class="form-control" placeholder="" name="destinationTrafficRuleInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Enter in a comma separated list of CIDR address, IP ranges, source ACL names, @external, or @internal. Leaving this unset will default to any.'></i>
              </div>
            </div>
            
            <div class="row">
              <label class="col-3 col-form-label text-right">Protocol: </label>
              <div class="col-7">
                <div class="form-group">
                  <select id="protocolTrafficRuleInput" onchange="" class="form-control" name="protocolTrafficRuleInput">
                    <option value="">(not set)</option>
                    <option value="icmp4">icmp4</option>
                    <option value="icmp6">icmp6</option>
                    <option value="tcp">tcp</option>
                    <option value="udp">udp</option>
                  </select>
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Select the traffic protocl for this rule. Leaving this unset will default to any.'></i>
              </div>
            </div>

            <div class="row">
              <label class="col-3 col-form-label text-right">Source Port: </label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="sourcePortTrafficRuleInput" class="form-control" placeholder="" name="sourcePortTrafficRuleInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Used with TCP or UDP rules. Enter in a comma seperated list of ports or port ranges. Leaving this unset will default to any.'></i>
              </div>
            </div>

            <div class="row">
              <label class="col-3 col-form-label text-right">Destination Port: </label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="destinationPortTrafficRuleInput" class="form-control" placeholder="" name="destinationPortTrafficRuleInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Used with TCP or UDP rules. Enter in a comma seperated list of ports or port ranges. Leaving this unset will default to any.'></i>
              </div>
            </div>

            <div class="row">
              <label class="col-3 col-form-label text-right">ICMP Type: </label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="icmpTypeTrafficRuleInput" class="form-control" placeholder="" name="icmpTypeTrafficRuleInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Used with ICMP rules. Enter in an ICMP type number. Leaving this unset will default to any.'></i>
              </div>
            </div>

            <div class="row">
              <label class="col-3 col-form-label text-right">ICMP Code: </label>
              <div class="col-7">
                <div class="form-group">
                  <input type="text" id="icmpCodeTrafficRuleInput" class="form-control" placeholder="" name="icmpCodeTrafficRuleInput">
                </div>
              </div>
              <div class="col-1">
                <i class="far fa-sm fa-question-circle" title='Used with ICMP rules. Enter in an ICMP code number. Leaving this unset will default to any.'></i>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="#" onclick="addTrafficRule()" data-dismiss="modal">Submit</a>
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
  const networkAcl = urlParams.get('network_acl');

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

    $('#ingressListTable').DataTable().ajax.reload(null, false);

    pageReloadTimeout = setTimeout(() => { reloadPageContent(); }, 7000);
  }

  function loadPageContent(){

    //Display current logged in username
    $("#username").load("./backend/admin/settings.php?action=displayUsername");

    $('#ingressListTable').DataTable( {
      ajax: "./backend/lxd/network-acls.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&network_acl=" + encodeURI(networkAcl) + "&action=listIngressRules",
      columns: [
        {},
        { title: "Action" },
        { title: "State" },
        { title: "Description" },
        { title: "Source" },
        { title: "Destination" },
        { title: "Protocol" },
        { title: "Source Port" },
        { title: "Destination Port" },
        { title: "ICMP Type" },
        { title: "ICMP Code" },
        { title: "Actions" }
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

  function addTrafficRule(){
    var typeTrafficRuleInput = "ingress";
    var actionTrafficRuleInput = $("#actionTrafficRuleInput").val();
    var stateTrafficRuleInput = $("#stateTrafficRuleInput").val();
    var descriptionTrafficRuleInput = $("#descriptionTrafficRuleInput").val();
    var sourceTrafficRuleInput = $("#sourceTrafficRuleInput").val();
    var destinationTrafficRuleInput = $("#destinationTrafficRuleInput").val();
    var protocolTrafficRuleInput = $("#protocolTrafficRuleInput").val();
    var sourcePortTrafficRuleInput = $("#sourcePortTrafficRuleInput").val();
    var destinationPortTrafficRuleInput = $("#destinationPortTrafficRuleInput").val();
    var icmpTypeTrafficRuleInput = $("#icmpTypeTrafficRuleInput").val();
    var icmpCodeTrafficRuleInput = $("#icmpCodeTrafficRuleInput").val();
    console.log("Info: adding " + typeTrafficRuleInput + " rule ");
    $.get("./backend/lxd/network-acls.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&network_acl=" + encodeURI(networkAcl) + "&type=" + encodeURI(typeTrafficRuleInput) + "&traffic_action=" + encodeURI(actionTrafficRuleInput) + "&state=" + encodeURI(stateTrafficRuleInput) + "&description=" + encodeURI(descriptionTrafficRuleInput) + "&source=" + encodeURI(sourceTrafficRuleInput) + "&destination=" + encodeURI(destinationTrafficRuleInput) + "&protocol=" + encodeURI(protocolTrafficRuleInput) + "&source_port=" + encodeURI(sourcePortTrafficRuleInput) + "&destination_port=" + encodeURI(destinationPortTrafficRuleInput) + "&icmp_type=" + encodeURI(icmpTypeTrafficRuleInput) + "&icmp_code=" + encodeURI(icmpCodeTrafficRuleInput) + "&action=addTrafficRule",  function (data) {
      //Sync operation type
      var operationData = JSON.parse(data);
      console.log(operationData);
      if (operationData.error_code >= 400){
        alert(operationData.error);
      }
      setTimeout(() => { reloadPageContent(); }, 1000);
    });
  }

  function deleteIngressRule(ingressRuleToDelete){
    console.log("Info: deleting ingress rule " + ingressRuleToDelete);
    $.get("./backend/lxd/network-acls.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName) + "&network_acl=" + encodeURI(networkAcl) + "&rule=" + encodeURI(ingressRuleToDelete) + "&action=deleteIngressRule",  function (data) {
      //Sync type
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
    $('#networkAclsBreadCrumb').text("network-acls");
    $('#networkAclsBreadCrumb').attr("href", "network-acls.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName));
    $('#networkAclBreadCrumb').text(networkAcl);

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