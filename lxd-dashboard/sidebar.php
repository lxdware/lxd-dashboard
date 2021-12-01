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

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="remotes.php">
  <div class="sidebar-brand-icon rotate-n-0">
    <img src="assets/images/logo-dark.svg" style="width: 2rem;"></img>
    <!-- <i class="fas fa-cube" style="width: 2rem;"></i> -->
  </div>
  <div class="sidebar-brand-text mx-3">LXDWARE</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider">

<div id="hosts">
      <!-- Nav Item - Hosts -->
      <li class="nav-item">
        <a class="nav-link" href="remotes.php">
          <i class="fas fa-fw fa-server"></i>
          <span>Hosts</span></a>
      </li>
</div>

<!-- Divider -->
<hr class="sidebar-divider">

<div id="main">
  <!-- Nav Item - Containers -->
  <li class="nav-item">
    <a class="nav-link" id="containersLinkSidebar" href="#">
      <i id="containersIcon" class="fas fa-fw fa-cube"></i>
      <span id="containersSpan">Containers</span></a>
  </li>

  <!-- Nav Item - Containers -->
  <li class="nav-item">
    <a class="nav-link" id="virtualMachinesLinkSidebar" href="#">
      <i id="virtualMachinesIcon" class="fas fa-fw fa-cube"></i>
      <span id="virtualMachinesSpan">Virtual Machines</span></a>
  </li>

  <!-- Nav Item - Images -->
  <li class="nav-item">
    <a class="nav-link" id="imagesLinkSidebar" href="#">
      <i id="imagesIcon" class="fas fa-fw fa-box-open"></i>
      <span id="imagesSpan">Images</span></a>
  </li>

  <!-- Nav Item - Profiles -->
  <li class="nav-item">
    <a class="nav-link" id="profilesLinkSidebar" href="#">
      <i id="profilesIcon" class="fas fa-fw fa-money-check"></i>
      <span id="profilesSpan">Profiles</span></a>
  </li>

  <!-- Nav Item - Networks -->
  <li class="nav-item">
    <a class="nav-link" id="networksLinkSidebar" href="#">
      <i id="networksIcon" class="fas fa-fw fa-network-wired"></i>
      <span id="networksSpan">Networks</span></a>
  </li>

  <!-- Nav Item - Storage Pools-->
  <li class="nav-item">
    <a class="nav-link" id="storagePoolsLinkSidebar" href="#">
      <i id="storagePoolsIcon" class="fas fa-fw fa-hdd"></i>
      <span id="storagePoolsSpan">Storage Pools</span></a>
  </li>

</div>

<!-- Divider -->
<hr class="sidebar-divider">
<div class="secondary">
  <!-- Nav Item - Cluster Members-->
  <li class="nav-item">
    <a class="nav-link" id="clusterLinkSidebar" href="#">
      <i id="clusterIcon" class="fas fa-fw fa-layer-group"></i>
      <span id="cluterSpan">Cluster Members</span>
    </a>
  </li>

  <!-- Nav Item - Projects-->
  <li class="nav-item">
    <a class="nav-link" id="projectsLinkSidebar" href="#">
      <i id="projectsIcon" class="fas fa-fw fa-chart-bar"></i>
      <span id="projectsSpan">Projects</span>
    </a>
  </li>

  <!-- Nav Item - Network ACLs -->
  <li class="nav-item">
    <a class="nav-link" id="networkAclsLinkSidebar" href="#">
      <i id="networkAclsIcon" class="fas fa-fw fa-shield-alt"></i>
      <span id="networkAclsSpan">Network ACLs</span></a>
  </li>

  <!-- Nav Item - Operations-->
  <li class="nav-item">
    <a class="nav-link" id="operationsLinkSidebar" href="#">
      <i id="operationsIcon" class="fas fa-fw fa-exchange-alt"></i>
      <span id="operationsSpan">Operations</span>
    </a>
  </li>

  <!-- Nav Item - Certificates-->
  <li class="nav-item">
    <a class="nav-link" id="certificatesLinkSidebar" href="#">
      <i id="certificatesIcon" class="fas fa-fw fa-wallet"></i>
      <span id="certificatesSpan">Certificates</span>
    </a>
  </li>
</div>

<!-- Divider -->
<hr class="sidebar-divider">
<div class="secondary">
  <!-- Nav Item - Image Simplestream Repositories-->
  <li class="nav-item">
    <a class="nav-link" id="simplestreamsLinkSidebar" href="#">
      <i id="simplestreamsIcon" class="fas fa-fw fa-archive"></i>
      <span id="simplestreamsSpan">Simplestreams</span>
    </a>
  </li>
  
</div>


<script>
  $("#containersLinkSidebar").attr("href", "containers.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName));
  $("#virtualMachinesLinkSidebar").attr("href", "virtual-machines.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName));
  $("#imagesLinkSidebar").attr("href", "images.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName));
  $("#profilesLinkSidebar").attr("href", "profiles.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName));
  $("#networksLinkSidebar").attr("href", "networks.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName));
  $("#storagePoolsLinkSidebar").attr("href", "storage-pools.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName));

  $("#clusterLinkSidebar").attr("href", "cluster-members.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName));
  $("#projectsLinkSidebar").attr("href", "projects.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName));
  $("#networkAclsLinkSidebar").attr("href", "network-acls.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName));
  $("#operationsLinkSidebar").attr("href", "operations.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName));
  $("#certificatesLinkSidebar").attr("href", "certificates.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName));

  $("#simplestreamsLinkSidebar").attr("href", "simplestreams.php?remote=" + encodeURI(remoteId) + "&project=" + encodeURI(projectName));

  if (location.pathname == "/containers.php" || location.pathname == "/containers-single.php"){
    $('#containersSpan').css('color','#fff');
    $('#containersIcon').css('color','#fff');
  }

  if (location.pathname == "/virtual-machines.php" || location.pathname == "/virtual-machines-single.php"){
    $('#virtualMachinesSpan').css('color','#fff');
    $('#virtualMachinesIcon').css('color','#fff');
  }
  
  if (location.pathname == "/images.php"){
    $('#imagesSpan').css('color','#fff');
    $('#imagesIcon').css('color','#fff');
  }

  if (location.pathname == "/profiles.php"){
    $('#profilesSpan').css('color','#fff');
    $('#profilesIcon').css('color','#fff');
  }
  
  if (location.pathname == "/networks.php"){
    $('#networksSpan').css('color','#fff');
    $('#networksIcon').css('color','#fff');
  }

  if (location.pathname == "/storage-pools.php" || location.pathname == "/storage-volumes.php"){
    $('#storagePoolsSpan').css('color','#fff');
    $('#storagePoolsIcon').css('color','#fff');
  }

  if (location.pathname == "/cluster-members.php"){
    $('#cluterSpan').css('color','#fff');
    $('#clusterIcon').css('color','#fff');
  }

  if (location.pathname == "/projects.php"){
    $('#projectsSpan').css('color','#fff');
    $('#projectsIcon').css('color','#fff');
  }

  if (location.pathname == "/network-acls.php" || location.pathname == "/network-acls-egress.php" || location.pathname == "/network-acls-ingress.php"){
    $('#networkAclsSpan').css('color','#fff');
    $('#networkAclsIcon').css('color','#fff');
  }

  if (location.pathname == "/operations.php"){
    $('#operationsSpan').css('color','#fff');
    $('#operationsIcon').css('color','#fff');
  }

  if (location.pathname == "/certificates.php"){
    $('#certificatesSpan').css('color','#fff');
    $('#certificatesIcon').css('color','#fff');
  }

  if (location.pathname == "/simplestreams.php"){
    $('#simplestreamsSpan').css('color','#fff');
    $('#simplestreamsIcon').css('color','#fff');
  }

</script>