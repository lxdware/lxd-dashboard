<?php
/*
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
*/

//Start session if not already started
if (!isset($_SESSION)) {
    session_start();
}

/*
# Controlled Actions:
- /admin/backend/config/cert.php
    -- createCertificateFiles
    -- deleteCertificateFiles
    -- listCertificateFiles
    -- viewCertificate

- /admin/backend/admin/settings.php
    -- addRoleToGroup
    -- addUserToGroup
    -- createGroup
    -- createUser
    -- deleteGroup
    -- deleteUser
    -- listGroups
    -- listGroupsAssignedToUserForSelect
    -- listGroupsNotAssignedToUserForSelect
    -- listRolesAssignedToGroupForSelect
    -- listRolesNotAssignedToGroupForSelect
    -- listUsers
    -- removeGroupFromUser
    -- removeRoleFromGroup
    -- updateLogPreferences
    -- updateOutboundRequestPreferences
    -- updateRefreshRatePreferences

- /admin/backend/admin/user-profile.php
    -- retrieveUserId
    -- retrieveUserDetails
    -- updateUserAccount
    -- updateUserPassword

- /admin/backend/lxd/certificates.php
    -- addCertificateUsingForm
    -- addCertificateUsingJSON
    -- deleteCertificate
    -- listCertificates
    -- loadCertificate
    -- updateCertificate

- /admin/backend/lxd/cluster-members.php
    -- deleteClusterMember
    -- listClusterMembers
    -- listClusterMembersForSelectOption

- /admin/backend/lxd/images.php
    -- deleteImage
    -- downloadImage
    -- listImages
    -- listImagesForSelectOption
    -- loadImage
    -- refreshImage
    -- updateImage
    
- /admin/backend/lxd/containers-single.php
    -- addInstanceDiskDevice
    -- addInstanceGPUDevice
    -- addInstanceNetworkDevice
    -- addInstanceProxyDevice
    -- addInstanceUnixDevice
    -- addInstanceUSBDevice
    -- displayInstanceInfo
    -- displayInstanceStateInfo
    -- establishInstanceWebSocketConsoleConnection
    -- establishInstanceWebSocketExecConnection
    -- listInstanceBackups
    -- listInstanceDiskDevices
    -- listInstanceGPUDevices
    -- listInstanceInterfaces
    -- listInstanceLogs
    -- listInstanceNetworkDevices
    -- listInstanceProfiles
    -- listInstanceProxyDevices
    -- listInstanceSnapshots
    -- listInstanceUnixDevices
    -- listInstanceUSBDevices
    -- removeInstanceDevice
    -- retrieveGaugeStats
    -- retrieveHostAndPort
    -- retrieveInstanceState

- /admin/backend/lxd/containers.php
    -- attachInstanceProfile
    -- copyInstance
    -- createInstanceBackup
    -- createInstanceFromSnapshot
    -- createInstanceUsingForm
    -- createInstanceUsingJSON
    -- deleteInstance
    -- deleteInstanceBackup
    -- deleteInstanceLog
    -- deleteInstanceSnapshot
    -- detachInstanceProfile
    -- downloadInstanceExportFile
    -- exportInstanceBackup
    -- freezeInstance
    -- listInstances
    -- listInstancesForSelectOption
    -- loadInstanceInformation
    -- loadInstanceLog
    -- migrateInstance
    -- publishInstance
    -- publishInstanceSnapshot
    -- renameInstance
    -- restartInstance
    -- restoreInstanceSnapshot
    -- snapshotInstance
    -- startInstance
    -- stopInstance
    -- stopInstanceForcefully
    -- unfreezeInstance
    -- updateInstanceInformation
    -- updateInstanceUsingForm

- /admin/backend/lxd/network-acls.php
    -- addTrafficRule
    -- createNetworkAclUsingForm
    -- createNetworkAclUsingJSON
    -- deleteEgressRule
    -- deleteIngressRule
    -- deleteNetworkAcl
    -- listEgressRules
    -- listIngressRules
    -- listNetworkAcls
    -- loadNetworkAcl
    -- renameNetworkAcl
    -- updateNetworkAcl

- /admin/backend/lxd/networks.php
    -- createNetworkUsingForm
    -- createNetworkUsingJSON
    -- deleteNetwork
    -- listNetworks
    -- listNetworksForSelectOption
    -- loadNetwork
    -- renameNetwork
    -- updateNetwork

- /admin/backend/lxd/operations.php
    -- deleteOperation
    -- displayOperationStatus
    -- listOperations
    -- loadOperation

- /admin/backend/lxd/profiles.php
    -- createProfileUsingForm
    -- createProfileUsingJSON
    -- deleteProfile
    -- listProfiles
    -- listProfilesForSelectOption
    -- loadProfile
    -- renameProfile
    -- updateProfile

- /admin/backend/lxd/projects.php
    -- createProjectUsingForm
    -- createProjectUsingJSON
    -- deleteProject
    -- listProjects
    -- listProjectsForSelectOption
    -- loadProject
    -- renameProject
    -- updateProject

- /admin/backend/lxd/remotes-single.php
    -- displayClusterInfo
    -- displayContainerInfo
    -- displayImageInfo
    -- displayInstanceInfo
    -- displayLxdInfo
    -- displayNetworkInfo
    -- displayNetworkAclInfo
    -- displayProfileInfo
    -- displayProjectInfo
    -- displayStorageInfo
    -- displaySysInfo
    -- displayVirtualMachineInfo
    -- validateRemoteConnection

- /admin/backend/lxd/remotes.php
    -- addRemote
    -- deleteRemote
    -- listRemotes
    -- listRemotesForSelectOption
    -- loadRemote
    -- updateRemote

- /admin/backend/lxd/simplestreams.php
    -- addSimplestreams
    -- deleteSimplestreams
    -- listSimplestreams
    -- listSimplestreamsForSelectOption

- /admin/backend/lxd/storage-pools.php
    -- createStoragePoolUsingForm
    -- createStoragePoolUsingJSON
    -- deleteStoragePool
    -- listStoragePools
    -- listStoragePoolsForSelectOption
    -- loadStoragePool
    -- updateStoragePool

- /admin/backend/lxd/storage-volumes.php
    -- createStorageVolumeUsingForm
    -- createStorageVolumeUsingJSON
    -- deleteStorageVolume
    -- listStorageVolumes
    -- listStorageVolumesForSelectOption
    -- loadStorageVolume
    -- updateStorageVolume

- /admin/backend/lxd/virtual-machines-single.php
    -- addInstanceDiskDevice
    -- addInstanceGPUDevice
    -- addInstanceNetworkDevice
    -- addInstanceProxyDevice
    -- addInstanceUSBDevice
    -- displayInstanceInfo
    -- displayInstanceStateInfo
    -- establishInstanceWebSocketConsoleConnection
    -- establishInstanceWebSocketExecConnection
    -- listInstanceBackups
    -- listInstanceDiskDevices
    -- listInstanceGPUDevices
    -- listInstanceInterfaces
    -- listInstanceLogs
    -- listInstanceNetworkDevices
    -- listInstanceProfiles
    -- listInstanceProxyDevices
    -- listInstanceSnapshots
    -- listInstanceUSBDevices
    -- removeInstanceDevice
    -- retrieveGaugeStats
    -- retrieveHostAndPort
    -- retrieveInstanceState

- /admin/backend/lxd/virtual-machines.php
    -- attachInstanceProfile
    -- copyInstance
    -- createInstanceBackup
    -- createInstanceFromSnapshot
    -- createInstanceUsingForm
    -- createInstanceUsingJSON
    -- deleteInstance
    -- deleteInstanceBackup
    -- deleteInstanceLog
    -- deleteInstanceSnapshot
    -- detachInstanceProfile
    -- downloadInstanceExportFile
    -- exportInstanceBackup
    -- freezeInstance
    -- listInstances
    -- listInstancesForSelectOption
    -- loadInstanceInformation
    -- loadInstanceLog
    -- migrateInstance
    -- publishInstance
    -- publishInstanceSnapshot
    -- renameInstance
    -- restartInstance
    -- restoreInstanceSnapshot
    -- snapshotInstance
    -- startInstance
    -- stopInstance
    -- stopInstanceForcefully
    -- unfreezeInstance
    -- updateInstanceInformation
    -- updateInstanceUsingForm


# Default Roles: 
- ADMIN
- OPERATOR
- USER
- AUDITOR

# Extended Roles:
- CERTIFICATE_OPERATOR
- CLUSTER_MEMBER_OPERATOR
- IMAGE_OPERATOR
- INSTANCE_OPERATOR
- NETWORK_OPERATOR
- OPERATION_OPERATOR
- PROFILE_OPERATOR
- PROJECT_OPERATOR
- REMOTE_OPERATOR
- SIMPLESTREAMS_OPERATOR
- STORAGE_POOL_OPERATOR
- STORAGE_VOLUME_OPERATOR
*/


function getControls($roles){
  $controls = array();
  
  foreach($roles as $role){
    switch ($role) {
      case "ADMIN":
        //Default role granting all controls
        $admin_controls = array(
            "addCertificateUsingForm",
            "addCertificateUsingJSON",
            "addInstanceDiskDevice",
            "addInstanceGPUDevice",
            "addInstanceNetworkDevice",
            "addInstanceProxyDevice",
            "addInstanceUnixDevice",
            "addInstanceUSBDevice",
            "addRemote",
            "addRoleToGroup",
            "addSimplestreams",
            "addTrafficRule",
            "addUserToGroup",
            "attachInstanceProfile",
            "copyInstance",
            "createCertificateFiles",
            "createGroup",
            "createInstanceBackup",
            "createInstanceFromSnapshot",
            "createInstanceUsingForm",
            "createInstanceUsingJSON",
            "createNetworkAclUsingForm",
            "createNetworkAclUsingJSON",
            "createNetworkUsingForm",
            "createNetworkUsingJSON",
            "createProfileUsingForm",
            "createProfileUsingJSON",
            "createProjectUsingForm",
            "createProjectUsingJSON",
            "createStoragePoolUsingForm",
            "createStoragePoolUsingJSON",
            "createStorageVolumeUsingForm",
            "createStorageVolumeUsingJSON",
            "createUser",
            "deleteCertificate",
            "deleteCertificateFiles",
            "deleteClusterMember",
            "deleteEgressRule",
            "deleteGroup",
            "deleteImage",
            "deleteIngressRule",
            "deleteInstance",
            "deleteInstanceBackup",
            "deleteInstanceLog",
            "deleteInstanceSnapshot",
            "deleteNetwork",
            "deleteNetworkAcl",
            "deleteOperation",
            "deleteProject",
            "deleteProfile",
            "deleteRemote",
            "deleteSimplestreams",
            "deleteStoragePool",
            "deleteStorageVolume",
            "deleteUser",
            "detachInstanceProfile",
            "displayClusterInfo",
            "displayContainerInfo",
            "displayImageInfo",
            "displayInstanceInfo",
            "displayInstanceStateInfo",
            "displayLxdInfo",
            "displayNetworkAclInfo",
            "displayNetworkInfo",
            "displayOperationStatus",
            "displayProfileInfo",
            "displayProjectInfo",
            "displayStorageInfo",
            "displaySysInfo",
            "displayVirtualMachineInfo",
            "downloadInstanceExportFile", 
            "downloadImage",
            "establishInstanceWebSocketConsoleConnection",
            "establishInstanceWebSocketExecConnection",
            "exportInstanceBackup",
            "freezeInstance",
            "listCertificateFiles",
            "listCertificates",
            "listClusterMembers",
            "listClusterMembersForSelectOption",
            "listEgressRules",
            "listGroups",
            "listGroupsAssignedToUserForSelect",
            "listGroupsNotAssignedToUserForSelect",
            "listImages",
            "listImagesForSelectOption",
            "listIngressRules",
            "listInstanceBackups",
            "listInstanceDiskDevices",
            "listInstanceGPUDevices",
            "listInstanceInterfaces",
            "listInstanceLogs",
            "listInstanceNetworkDevices",
            "listInstanceProfiles",
            "listInstanceProxyDevices",
            "listInstances",
            "listInstancesForSelectOption",
            "listInstanceSnapshots",
            "listInstanceUnixDevices",
            "listInstanceUSBDevices",
            "listNetworkAcls",
            "listNetworks",
            "listNetworksForSelectOption",
            "listOperations",
            "listProfiles",
            "listProfilesForSelectOption",
            "listProjects",
            "listProjectsForSelectOption",
            "listRemotes",
            "listRemotesForSelectOption",  
            "listRolesAssignedToGroupForSelect",
            "listRolesNotAssignedToGroupForSelect",
            "listSimplestreams",
            "listSimplestreamsForSelectOption",
            "listStoragePools",
            "listStoragePoolsForSelectOption",
            "listStorageVolumes",
            "listStorageVolumesForSelectOption",
            "listUsers",
            "loadCertificate",  
            "loadImage",
            "loadInstanceInformation",
            "loadInstanceLog",
            "loadNetwork",
            "loadNetworkAcl",
            "loadOperation",
            "loadProfile",
            "loadProject",
            "loadRemote",
            "loadStoragePool",
            "loadStorageVolume",
            "migrateInstance",
            "publishInstance",
            "publishInstanceSnapshot",
            "refreshImage",
            "removeGroupFromUser",
            "removeInstanceDevice",
            "removeRoleFromGroup",
            "renameInstance",
            "renameNetwork",
            "renameNetworkAcl",
            "renameProfile",
            "renameProject",
            "restartInstance",
            "restoreInstanceSnapshot",
            "retrieveGaugeStats",
            "retrieveHostAndPort",
            "retrieveInstanceState",
            "retrieveUserDetails",
            "retrieveUserId",
            "snapshotInstance",
            "startInstance",
            "stopInstance",
            "stopInstanceForcefully",
            "unfreezeInstance",
            "updateCertificate",
            "updateImage",
            "updateInstanceInformation",
            "updateInstanceUsingForm",
            "updateLogPreferences",
            "updateNetwork",
            "updateNetworkAcl",
            "updateOutboundRequestPreferences",
            "updateProfile",
            "updateProject",
            "updateRefreshRatePreferences",
            "updateRemote",
            "updateStoragePool",
            "updateStorageVolume",
            "updateUserAccount",
            "updateUserPassword",
            "validateRemoteConnection",
            "viewCertificate"
        );
        $controls = array_merge($controls, $admin_controls);
        break;

      case "OPERATOR":
        //Default role granting operation of all LXD services
        $operator_controls = array(
            "addCertificateUsingForm",
            "addCertificateUsingJSON",
            "addInstanceDiskDevice",
            "addInstanceGPUDevice",
            "addInstanceNetworkDevice",
            "addInstanceProxyDevice",
            "addInstanceUnixDevice",
            "addInstanceUSBDevice",
            "addRemote",
            "addSimplestreams",
            "addTrafficRule",
            "attachInstanceProfile",
            "copyInstance",
            "createInstanceBackup",
            "createInstanceFromSnapshot",
            "createInstanceUsingForm",
            "createInstanceUsingJSON",
            "createNetworkAclUsingForm",
            "createNetworkAclUsingJSON",
            "createNetworkUsingForm",
            "createNetworkUsingJSON",
            "createProfileUsingForm",
            "createProfileUsingJSON",
            "createProjectUsingForm",
            "createProjectUsingJSON",
            "createStoragePoolUsingForm",
            "createStoragePoolUsingJSON",
            "createStorageVolumeUsingForm",
            "createStorageVolumeUsingJSON",
            "deleteCertificate",
            "deleteClusterMember",
            "deleteEgressRule",
            "deleteImage",
            "deleteIngressRule",
            "deleteInstance",
            "deleteInstanceBackup",
            "deleteInstanceLog",
            "deleteInstanceSnapshot",
            "deleteNetwork",
            "deleteNetworkAcl",
            "deleteOperation",
            "deleteProject",
            "deleteProfile",
            "deleteRemote",
            "deleteSimplestreams",
            "deleteStoragePool",
            "deleteStorageVolume",
            "detachInstanceProfile",
            "displayClusterInfo",
            "displayContainerInfo",
            "displayImageInfo",
            "displayInstanceInfo",
            "displayInstanceStateInfo",
            "displayLxdInfo",
            "displayNetworkAclInfo",
            "displayNetworkInfo",
            "displayOperationStatus",
            "displayProfileInfo",
            "displayProjectInfo",
            "displayStorageInfo",
            "displaySysInfo",
            "displayVirtualMachineInfo",
            "downloadInstanceExportFile", 
            "downloadImage",
            "establishInstanceWebSocketConsoleConnection",
            "establishInstanceWebSocketExecConnection",
            "exportInstanceBackup",
            "freezeInstance",
            "listCertificateFiles",
            "listCertificates",
            "listClusterMembers",
            "listClusterMembersForSelectOption",
            "listEgressRules",
            "listGroups",
            "listGroupsAssignedToUserForSelect",
            "listGroupsNotAssignedToUserForSelect",
            "listImages",
            "listImagesForSelectOption",
            "listIngressRules",
            "listInstanceBackups",
            "listInstanceDiskDevices",
            "listInstanceGPUDevices",
            "listInstanceInterfaces",
            "listInstanceLogs",
            "listInstanceNetworkDevices",
            "listInstanceProfiles",
            "listInstanceProxyDevices",
            "listInstances",
            "listInstancesForSelectOption",
            "listInstanceSnapshots",
            "listInstanceUnixDevices",
            "listInstanceUSBDevices",
            "listNetworkAcls",
            "listNetworks",
            "listNetworksForSelectOption",
            "listOperations",
            "listProfiles",
            "listProfilesForSelectOption",
            "listProjects",
            "listProjectsForSelectOption",
            "listRemotes",
            "listRemotesForSelectOption",  
            "listRolesAssignedToGroupForSelect",
            "listRolesNotAssignedToGroupForSelect",
            "listSimplestreams",
            "listSimplestreamsForSelectOption",
            "listStoragePools",
            "listStoragePoolsForSelectOption",
            "listStorageVolumes",
            "listStorageVolumesForSelectOption",
            "listUsers",
            "loadCertificate",  
            "loadImage",
            "loadInstanceInformation",
            "loadInstanceLog",
            "loadNetwork",
            "loadNetworkAcl",
            "loadOperation",
            "loadProfile",
            "loadProject",
            "loadRemote",
            "loadStoragePool",
            "loadStorageVolume",
            "migrateInstance",
            "publishInstance",
            "publishInstanceSnapshot",
            "refreshImage",
            "removeInstanceDevice",
            "renameInstance",
            "renameNetwork",
            "renameNetworkAcl",
            "renameProfile",
            "renameProject",
            "restartInstance",
            "restoreInstanceSnapshot",
            "retrieveGaugeStats",
            "retrieveHostAndPort",
            "retrieveInstanceState",
            "retrieveUserDetails",
            "retrieveUserId",
            "snapshotInstance",
            "startInstance",
            "stopInstance",
            "stopInstanceForcefully",
            "unfreezeInstance",
            "updateCertificate",
            "updateImage",
            "updateInstanceInformation",
            "updateInstanceUsingForm",
            "updateNetwork",
            "updateNetworkAcl",
            "updateProfile",
            "updateProject",
            "updateRemote",
            "updateStoragePool",
            "updateStorageVolume",
            "validateRemoteConnection",
            "viewCertificate"
        );
        $controls = array_merge($controls, $operator_controls);
        break;

      case "USER":
        //Default role with controls for basic LXD services
        $user_controls = array(
            "attachInstanceProfile",
            "createInstanceBackup",
            "detachInstanceProfile",
            "displayClusterInfo",
            "displayContainerInfo",
            "displayImageInfo",
            "displayInstanceInfo",
            "displayInstanceStateInfo",
            "displayLxdInfo",
            "displayNetworkInfo",
            "displayNetworkAclInfo",
            "displayOperationStatus",
            "displayProfileInfo",
            "displayProjectInfo",
            "displayStorageInfo",
            "displaySysInfo",
            "displayVirtualMachineInfo",
            "establishInstanceWebSocketConsoleConnection",
            "exportInstanceBackup",
            "freezeInstance",
            "listCertificateFiles",
            "listCertificates",
            "listClusterMembers",
            "listClusterMembersForSelectOption",
            "listEgressRules",
            "listGroups",
            "listGroupsAssignedToUserForSelect",
            "listGroupsNotAssignedToUserForSelect",
            "listImages",
            "listImagesForSelectOption",
            "listIngressRules",
            "listInstanceBackups",
            "listInstanceDiskDevices",
            "listInstanceGPUDevices",
            "listInstanceInterfaces",
            "listInstanceLogs",
            "listInstanceNetworkDevices",
            "listInstanceProfiles",
            "listInstanceProxyDevices",
            "listInstances",
            "listInstancesForSelectOption",
            "listInstanceSnapshots",
            "listInstanceUnixDevices",
            "listInstanceUSBDevices",
            "listNetworkAcls",
            "listNetworks",
            "listNetworksForSelectOption",
            "listOperations",
            "listProfiles",
            "listProfilesForSelectOption",
            "listProjects",
            "listProjectsForSelectOption",
            "listRemotes",
            "listRemotesForSelectOption", 
            "listRolesAssignedToGroupForSelect",
            "listRolesNotAssignedToGroupForSelect", 
            "listSimplestreams",
            "listSimplestreamsForSelectOption",
            "listStoragePools",
            "listStoragePoolsForSelectOption",
            "listStorageVolumes",
            "listStorageVolumesForSelectOption",
            "listUsers",
            "loadCertificate",
            "loadImage",
            "loadInstanceInformation",
            "loadInstanceLog",
            "loadNetwork",
            "loadNetworkAcl",
            "loadProfile",
            "loadProject",
            "loadRemote",
            "loadStoragePool",
            "loadStorageVolume",
            "migrateInstance",
            "refreshImage",
            "restartInstance",
            "restoreInstanceSnapshot",
            "retrieveGaugeStats",
            "retrieveHostAndPort",
            "retrieveInstanceState",
            "retrieveUserDetails",
            "retrieveUserId",
            "snapshotInstance",
            "startInstance",
            "stopInstance",
            "stopInstanceForcefully",
            "unfreezeInstance",
            "validateRemoteConnection",
            "viewCertificate"
        );
        $controls = array_merge($controls, $user_controls);
        break;

      case "AUDITOR":
        //Default role with controls similar to read-only
        $auditor_controls = array(
            "displayClusterInfo",
            "displayContainerInfo",
            "displayImageInfo",
            "displayInstanceInfo",
            "displayInstanceStateInfo",
            "displayLxdInfo",
            "displayNetworkAclInfo",
            "displayNetworkInfo",
            "displayOperationStatus",  
            "displayProfileInfo",
            "displayProjectInfo",
            "displayStorageInfo",
            "displaySysInfo",
            "displayVirtualMachineInfo",
            "listCertificateFiles",
            "listCertificates",
            "listClusterMembers",
            "listClusterMembersForSelectOption",
            "listEgressRules",
            "listGroups",
            "listGroupsAssignedToUserForSelect",
            "listGroupsNotAssignedToUserForSelect",
            "listImages",
            "listImagesForSelectOption",
            "listIngressRules",
            "listInstanceBackups",
            "listInstanceDiskDevices",
            "listInstanceGPUDevices",
            "listInstanceInterfaces",
            "listInstanceLogs",
            "listInstanceNetworkDevices",
            "listInstanceProfiles",
            "listInstanceProxyDevices",
            "listInstances",
            "listInstancesForSelectOption",
            "listInstanceSnapshots",
            "listInstanceUnixDevices",
            "listInstanceUSBDevices",
            "listNetworkAcls",
            "listNetworks",
            "listNetworksForSelectOption",
            "listOperations",
            "listProfiles",
            "listProfilesForSelectOption",
            "listProjects",
            "listProjectsForSelectOption",
            "listRemotes",
            "listRemotesForSelectOption",
            "listRolesAssignedToGroupForSelect",
            "listRolesNotAssignedToGroupForSelect",
            "listSimplestreams",
            "listSimplestreamsForSelectOption",
            "listStoragePools",
            "listStoragePoolsForSelectOption",
            "listStorageVolumes",
            "listStorageVolumesForSelectOption",
            "listUsers",
            "loadCertificate",
            "loadImage",
            "loadInstanceInformation",
            "loadInstanceLog",
            "loadNetwork",
            "loadNetworkAcl",
            "loadProfile",
            "loadProject",
            "loadRemote",
            "loadStoragePool",
            "loadStorageVolume",
            "retrieveGaugeStats",
            "retrieveHostAndPort",
            "retrieveInstanceState",
            "retrieveUserDetails",
            "retrieveUserId",
            "validateRemoteConnection"
        );
        $controls = array_merge($controls, $auditor_controls);
        break;
    }
  }

  //Make sure array only has unique values
  $controls = array_unique($controls);
  
  return $controls;
}

function validateAuthorization($control) {
  $return_val = false;

  if (in_array($control, $_SESSION['controls'])){
    $return_val = true;
  }
  
  return $return_val;
}
?>
