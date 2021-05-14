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
- /admin/php/config/cert.php
    -- viewCertificate

- /admin/php/admin/settings.php
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

- /admin/php/admin/user-profile.php
    -- retrieveUserId
    -- retrieveUserDetails
    -- updateUserAccount
    -- updateUserPassword

- /admin/php/lxd/certificates.php
    -- addCertificateUsingForm
    -- addCertificateUsingJSON
    -- deleteCertificate
    -- listCertificates
    -- loadCertificate
    -- updateCertificate

- /admin/php/lxd/cluster-members.php
    -- deleteClusterMember
    -- listClusterMembers
    -- listClusterMembersForSelectOption

- /admin/php/lxd/images.php
    -- deleteImage
    -- downloadImage
    -- listImages
    -- listImagesForSelectOption
    -- loadImage
    -- refreshImage
    -- updateImage
    
- /admin/php/lxd/instances-single.php
    -- displayInstanceInfo
    -- displayInstanceStateInfo
    -- establishInstanceWebSocketConsoleConnection
    -- listInstanceBackups
    -- listInstanceDiskDevices
    -- listInstanceLogs
    -- listInstanceNetworkDevices
    -- listInstanceProfiles
    -- listInstanceProxyDevices
    -- listInstanceSnapshots
    -- retrieveInstanceState
    -- retrieveHostAndPort
    -- updateInstanceBootConfiguration
    -- updateInstanceCpuLimits
    -- updateInstanceMemoryLimits
    -- updateInstanceSecurityConfiguration
    -- updateInstanceSnapshotConfiguration

- /admin/php/lxd/instances.php
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

- /admin/php/lxd/network-acls.php
    -- createNetworkAclUsingForm
    -- createNetworkAclUsingJSON
    -- deleteNetworkAcl
    -- listNetworkAcls
    -- loadNetworkAcl
    -- renameNetworkAcl
    -- updateNetworkAcl

- /admin/php/lxd/networks.php
    -- createNetworkUsingForm
    -- createNetworkUsingJSON
    -- deleteNetwork
    -- listNetworks
    -- loadNetwork
    -- renameNetwork
    -- updateNetwork

- /admin/php/lxd/operations.php
    -- deleteOperation
    -- displayOperationStatus
    -- listOperations
    -- loadOperation

- /admin/php/lxd/profiles.php
    -- createProfileUsingForm
    -- createProfileUsingJSON
    -- deleteProfile
    -- listProfiles
    -- listProfilesForSelectOption
    -- loadProfile
    -- renameProfile
    -- updateProfile

- /admin/php/lxd/projects.php
    -- createProject
    -- deleteProject
    -- listProjects
    -- listProjectsForTopNavigation
    -- loadProject
    -- renameProject
    -- updateProject

- /admin/php/lxd/remotes-single.php
    -- displayClusterInfo
    -- displayImageInfo
    -- displayInstanceInfo
    -- displayLxdInfo
    -- displayNetworkInfo
    -- displayNetworkAclInfo
    -- displayProfileInfo
    -- displayProjectInfo
    -- displayStorageInfo
    -- displaySysInfo

- /admin/php/lxd/remotes.php
    -- addRemote
    -- deleteRemote
    -- listRemotes
    -- listRemotesForTopNavigation  



- /admin/php/lxd/simplestreams.php
    -- addSimplestreams
    -- deleteSimplestreams
    -- listSimplestreams
    -- listSimplestreamsForSelectOption


- /admin/php/lxd/storage-pools.php
    -- createStoragePoolUsingForm
    -- createStoragePoolUsingJSON
    -- deleteStoragePool
    -- listStoragePools
    -- loadStoragePool
    -- updateStoragePool

- /admin/php/lxd/storage-volumes.php
    -- createStorageVolumeUsingForm
    -- createStorageVolumeUsingJSON
    -- deleteStorageVolume
    -- listStorageVolumes
    -- loadStorageVolume
    -- updateStorageVolume


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
            "viewCertificate",
            "addRoleToGroup",
            "addUserToGroup",
            "createGroup",
            "createUser",
            "deleteGroup",
            "deleteUser",
            "listGroups",
            "listGroupsAssignedToUserForSelect",
            "listGroupsNotAssignedToUserForSelect",
            "listRolesAssignedToGroupForSelect",
            "listRolesNotAssignedToGroupForSelect",
            "listUsers",
            "removeGroupFromUser",
            "removeRoleFromGroup",
            "retrieveUserId",
            "retrieveUserDetails",
            "updateUserAccount",
            "updateUserPassword",
            "addCertificateUsingForm",
            "addCertificateUsingJSON",
            "deleteCertificate",
            "listCertificates",
            "loadCertificate",
            "updateCertificate",
            "deleteClusterMember",
            "listClusterMembers",
            "listClusterMembersForSelectOption",
            "deleteImage",
            "downloadImage",
            "listImages",
            "listImagesForSelectOption",
            "loadImage",
            "refreshImage",
            "updateImage",
            "displayInstanceInfo",
            "displayInstanceStateInfo",
            "establishInstanceWebSocketConsoleConnection",
            "listInstanceBackups",
            "listInstanceDiskDevices",
            "listInstanceLogs",
            "listInstanceNetworkDevices",
            "listInstanceProfiles",
            "listInstanceProxyDevices",
            "listInstanceSnapshots",
            "retrieveInstanceState",
            "retrieveHostAndPort",
            "updateInstanceBootConfiguration",
            "updateInstanceCpuLimits",
            "updateInstanceMemoryLimits",
            "updateInstanceSecurityConfiguration",
            "updateInstanceSnapshotConfiguration",
            "attachInstanceProfile",
            "copyInstance",
            "createInstanceBackup",
            "createInstanceFromSnapshot",
            "createInstanceUsingForm",
            "createInstanceUsingJSON",
            "deleteInstance",
            "deleteInstanceBackup",
            "deleteInstanceLog",
            "deleteInstanceSnapshot",
            "detachInstanceProfile",
            "downloadInstanceExportFile",
            "exportInstanceBackup",
            "freezeInstance",
            "listInstances",
            "listInstancesForSelectOption",
            "loadInstanceInformation",
            "loadInstanceLog",
            "migrateInstance",
            "publishInstance",
            "publishInstanceSnapshot",
            "renameInstance",
            "restartInstance",
            "restoreInstanceSnapshot",
            "snapshotInstance",
            "startInstance",
            "stopInstance",
            "stopInstanceForcefully",
            "unfreezeInstance",
            "updateInstanceInformation",
            "createNetworkAclUsingForm",
            "createNetworkAclUsingJSON",
            "deleteNetworkAcl",
            "listNetworkAcls",
            "loadNetworkAcl",
            "renameNetworkAcl",
            "updateNetworkAcl",
            "createNetworkUsingForm",
            "createNetworkUsingJSON",
            "deleteNetwork",
            "listNetworks",
            "loadNetwork",
            "renameNetwork",
            "updateNetwork",
            "deleteOperation",
            "displayOperationStatus",
            "listOperations",
            "loadOperation",
            "createProfileUsingForm",
            "createProfileUsingJSON",
            "deleteProfile",
            "listProfiles",
            "listProfilesForSelectOption",
            "loadProfile",
            "renameProfile",
            "updateProfile",
            "createProject",
            "deleteProject",
            "listProjects",
            "listProjectsForTopNavigation",
            "loadProject",
            "renameProject",
            "updateProject",
            "displayClusterInfo",
            "displayImageInfo",
            "displayInstanceInfo",
            "displayLxdInfo",
            "displayNetworkInfo",
            "displayNetworkAclInfo",
            "displayProfileInfo",
            "displayProjectInfo",
            "displayStorageInfo",
            "displaySysInfo",
            "addRemote",
            "deleteRemote",
            "listRemotes",
            "listRemotesForTopNavigation",  
            "addSimplestreams",
            "listSimplestreams",
            "listSimplestreamsForSelectOption",
            "deleteSimplestreams",
            "createStoragePoolUsingForm",
            "createStoragePoolUsingJSON",
            "deleteStoragePool",
            "listStoragePools",
            "loadStoragePool",
            "updateStoragePool",
            "createStorageVolumeUsingForm",
            "createStorageVolumeUsingJSON",
            "deleteStorageVolume",
            "listStorageVolumes",
            "loadStorageVolume",
            "updateStorageVolume"
        );
        $controls = array_merge($controls, $admin_controls);
        break;

      case "OPERATOR":
        //Default role granting operation of all LXD services
        $operator_controls = array(
            "viewCertificate",
            "listGroups",
            "listGroupsAssignedToUserForSelect",
            "listGroupsNotAssignedToUserForSelect",
            "listRolesAssignedToGroupForSelect",
            "listRolesNotAssignedToGroupForSelect",
            "listUsers",
            "retrieveUserId",
            "retrieveUserDetails",
            "addCertificateUsingForm",
            "addCertificateUsingJSON",
            "deleteCertificate",
            "listCertificates",
            "loadCertificate",
            "updateCertificate",
            "deleteClusterMember",
            "listClusterMembers",
            "listClusterMembersForSelectOption",
            "deleteImage",
            "downloadImage",
            "listImages",
            "listImagesForSelectOption",
            "loadImage",
            "refreshImage",
            "updateImage",
            "displayInstanceInfo",
            "displayInstanceStateInfo",
            "establishInstanceWebSocketConsoleConnection",
            "listInstanceBackups",
            "listInstanceDiskDevices",
            "listInstanceLogs",
            "listInstanceNetworkDevices",
            "listInstanceProfiles",
            "listInstanceProxyDevices",
            "listInstanceSnapshots",
            "retrieveInstanceState",
            "retrieveHostAndPort",
            "updateInstanceBootConfiguration",
            "updateInstanceCpuLimits",
            "updateInstanceMemoryLimits",
            "updateInstanceSecurityConfiguration",
            "updateInstanceSnapshotConfiguration",
            "attachInstanceProfile",
            "copyInstance",
            "createInstanceBackup",
            "createInstanceFromSnapshot",
            "createInstanceUsingForm",
            "createInstanceUsingJSON",
            "deleteInstance",
            "deleteInstanceBackup",
            "deleteInstanceLog",
            "deleteInstanceSnapshot",
            "detachInstanceProfile",
            "downloadInstanceExportFile",
            "exportInstanceBackup",
            "freezeInstance",
            "listInstances",
            "listInstancesForSelectOption",
            "loadInstanceInformation",
            "loadInstanceLog",
            "migrateInstance",
            "publishInstance",
            "publishInstanceSnapshot",
            "renameInstance",
            "restartInstance",
            "restoreInstanceSnapshot",
            "snapshotInstance",
            "startInstance",
            "stopInstance",
            "stopInstanceForcefully",
            "unfreezeInstance",
            "updateInstanceInformation",
            "createNetworkAclUsingForm",
            "createNetworkAclUsingJSON",
            "deleteNetworkAcl",
            "listNetworkAcls",
            "loadNetworkAcl",
            "renameNetworkAcl",
            "updateNetworkAcl",
            "createNetworkUsingForm",
            "createNetworkUsingJSON",
            "deleteNetwork",
            "listNetworks",
            "loadNetwork",
            "renameNetwork",
            "updateNetwork",
            "deleteOperation",
            "displayOperationStatus",
            "listOperations",
            "loadOperation",
            "createProfileUsingForm",
            "createProfileUsingJSON",
            "deleteProfile",
            "listProfiles",
            "listProfilesForSelectOption",
            "loadProfile",
            "renameProfile",
            "updateProfile",
            "createProject",
            "deleteProject",
            "listProjects",
            "listProjectsForTopNavigation",
            "loadProject",
            "renameProject",
            "updateProject",
            "displayClusterInfo",
            "displayImageInfo",
            "displayInstanceInfo",
            "displayLxdInfo",
            "displayNetworkInfo",
            "displayNetworkAclInfo",
            "displayProfileInfo",
            "displayProjectInfo",
            "displayStorageInfo",
            "displaySysInfo",
            "addRemote",
            "deleteRemote",
            "listRemotes",
            "listRemotesForTopNavigation",  
            "addSimplestreams",
            "listSimplestreams",
            "listSimplestreamsForSelectOption",
            "deleteSimplestreams",
            "createStoragePoolUsingForm",
            "createStoragePoolUsingJSON",
            "deleteStoragePool",
            "listStoragePools",
            "loadStoragePool",
            "updateStoragePool",
            "createStorageVolumeUsingForm",
            "createStorageVolumeUsingJSON",
            "deleteStorageVolume",
            "listStorageVolumes",
            "loadStorageVolume",
            "updateStorageVolume"
        );
        $controls = array_merge($controls, $operator_controls);
        break;

      case "USER":
        //Default role with controls for basic LXD services
        $user_controls = array(
            "viewCertificate",
            "listGroups",
            "listGroupsAssignedToUserForSelect",
            "listGroupsNotAssignedToUserForSelect",
            "listRolesAssignedToGroupForSelect",
            "listRolesNotAssignedToGroupForSelect",
            "listUsers",
            "retrieveUserId",
            "retrieveUserDetails",
            "listCertificates",
            "loadCertificate",
            "listClusterMembers",
            "listClusterMembersForSelectOption",
            "listImages",
            "listImagesForSelectOption",
            "loadImage",
            "refreshImage",
            "displayInstanceInfo",
            "displayInstanceStateInfo",
            "establishInstanceWebSocketConsoleConnection",
            "listInstanceBackups",
            "listInstanceDiskDevices",
            "listInstanceLogs",
            "listInstanceNetworkDevices",
            "listInstanceProfiles",
            "listInstanceProxyDevices",
            "listInstanceSnapshots",
            "retrieveInstanceState",
            "retrieveHostAndPort",
            "attachInstanceProfile",
            "createInstanceBackup",
            "detachInstanceProfile",
            "exportInstanceBackup",
            "freezeInstance",
            "listInstances",
            "listInstancesForSelectOption",
            "loadInstanceInformation",
            "loadInstanceLog",
            "migrateInstance",
            "restartInstance",
            "restoreInstanceSnapshot",
            "snapshotInstance",
            "startInstance",
            "stopInstance",
            "stopInstanceForcefully",
            "unfreezeInstance",
            "listNetworkAcls",
            "loadNetworkAcl",
            "listNetworks",
            "loadNetwork",
            "displayOperationStatus",
            "listOperations",
            //"loadOperations", //Not in list because it could contain secrets that can be used to take over console connection
            "listProfiles",
            "listProfilesForSelectOption",
            "loadProfile",
            "listProjects",
            "listProjectsForTopNavigation",
            "loadProject",
            "displayClusterInfo",
            "displayImageInfo",
            "displayInstanceInfo",
            "displayLxdInfo",
            "displayNetworkInfo",
            "displayNetworkAclInfo",
            "displayProfileInfo",
            "displayProjectInfo",
            "displayStorageInfo",
            "displaySysInfo",
            "listRemotes",
            "listRemotesForTopNavigation",  
            "listSimplestreams",
            "listSimplestreamsForSelectOption",
            "listStoragePools",
            "loadStoragePool",
            "listStorageVolumes",
            "loadStorageVolume"
        );
        $controls = array_merge($controls, $user_controls);
        break;

      case "AUDITOR":
        //Default role with controls similar to read-only
        $auditor_controls = array(
            "listGroups",
            "listGroupsAssignedToUserForSelect",
            "listGroupsNotAssignedToUserForSelect",
            "listRolesAssignedToGroupForSelect",
            "listRolesNotAssignedToGroupForSelect",
            "listUsers",
            "retrieveUserId",
            "retrieveUserDetails",
            "listCertificates",
            "loadCertificate",
            "listClusterMembers",
            "listClusterMembersForSelectOption",
            "listImages",
            "listImagesForSelectOption",
            "loadImage",
            "displayInstanceInfo",
            "displayInstanceStateInfo",
            "listInstanceBackups",
            "listInstanceDiskDevices",
            "listInstanceLogs",
            "listInstanceNetworkDevices",
            "listInstanceProfiles",
            "listInstanceProxyDevices",
            "listInstanceSnapshots",
            "retrieveInstanceState",
            "loadInstanceInformation",
            "loadInstanceLog",
            "retrieveHostAndPort",
            "listInstances",
            "listInstancesForSelectOption",
            "loadInstanceInformation",
            "loadInstanceLog",
            "listNetworkAcls",
            "loadNetworkAcl",
            "listNetworks",
            "loadNetwork",
            "displayOperationStatus",
            "listOperations",
            //"loadOperations", //Not in list because it could contain secrets that can be used to take over console connection
            "listProfiles",
            "listProfilesForSelectOption",
            "loadProfile",
            "listProjects",
            "listProjectsForTopNavigation",
            "loadProject",
            "displayClusterInfo",
            "displayImageInfo",
            "displayInstanceInfo",
            "displayLxdInfo",
            "displayNetworkInfo",
            "displayNetworkAclInfo",
            "displayProfileInfo",
            "displayProjectInfo",
            "displayStorageInfo",
            "displaySysInfo",
            "listRemotes",
            "listRemotesForTopNavigation",
            "listSimplestreams",
            "listSimplestreamsForSelectOption",
            "listStoragePools",
            "loadStoragePool",
            "listStorageVolumes",
            "loadStorageVolume"
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
