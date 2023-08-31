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

//Verify that user is logged in
if (isset($_SESSION['username'])) {

  //Declare and instantiate GET variables
  $action = (isset($_GET['action'])) ? filter_var(urldecode($_GET['action']), FILTER_SANITIZE_STRING) : "";
  $btrfs_mount_options = (isset($_GET['btrfs_mount_options'])) ? filter_var(urldecode($_GET['btrfs_mount_options']), FILTER_SANITIZE_STRING) : "";
  $ceph_cluster_name = (isset($_GET['ceph_cluster_name'])) ? filter_var(urldecode($_GET['ceph_cluster_name']), FILTER_SANITIZE_STRING) : "";
  $ceph_osd_force_reuse = (isset($_GET['ceph_osd_force_reuse'])) ? filter_var(urldecode($_GET['ceph_osd_force_reuse']), FILTER_SANITIZE_STRING) : "";
  $ceph_osd_pg_num = (isset($_GET['ceph_osd_pg_num'])) ? filter_var(urldecode($_GET['ceph_osd_pg_num']), FILTER_SANITIZE_STRING) : "";
  $ceph_osd_pool_name = (isset($_GET['ceph_osd_pool_name'])) ? filter_var(urldecode($_GET['ceph_osd_pool_name']), FILTER_SANITIZE_STRING) : "";
  $ceph_osd_data_pool_name = (isset($_GET['ceph_osd_data_pool_name'])) ? filter_var(urldecode($_GET['ceph_osd_data_pool_name']), FILTER_SANITIZE_STRING) : "";
  $ceph_rbd_clone_copy = (isset($_GET['ceph_rbd_clone_copy'])) ? filter_var(urldecode($_GET['ceph_rbd_clone_copy']), FILTER_SANITIZE_STRING) : "";
  $ceph_rbd_features = (isset($_GET['ceph_rbd_features'])) ? filter_var(urldecode($_GET['ceph_rbd_features']), FILTER_SANITIZE_STRING) : "";
  $ceph_user_name = (isset($_GET['ceph_user_name'])) ? filter_var(urldecode($_GET['ceph_user_name']), FILTER_SANITIZE_STRING) : "";
  $cephfs_cluster_name = (isset($_GET['cephfs_cluster_name'])) ? filter_var(urldecode($_GET['cephfs_cluster_name']), FILTER_SANITIZE_STRING) : "";
  $cephfs_path = (isset($_GET['cephfs_path'])) ? filter_var(urldecode($_GET['cephfs_path']), FILTER_SANITIZE_STRING) : "";
  $cephfs_user_name = (isset($_GET['cephfs_user_name'])) ? filter_var(urldecode($_GET['cephfs_user_name']), FILTER_SANITIZE_STRING) : "";
  $description = (isset($_GET['description'])) ? filter_var(urldecode($_GET['description']), FILTER_SANITIZE_STRING) : "";
  $driver = (isset($_GET['driver'])) ? filter_var(urldecode($_GET['driver']), FILTER_SANITIZE_STRING) : "";
  $lvm_thinpool_name = (isset($_GET['lvm_thinpool_name'])) ? filter_var(urldecode($_GET['lvm_thinpool_name']), FILTER_SANITIZE_STRING) : "";
  $lvm_use_thinpool = (isset($_GET['lvm_use_thinpool'])) ? filter_var(urldecode($_GET['lvm_use_thinpool']), FILTER_SANITIZE_STRING) : "";
  $lvm_vg_name = (isset($_GET['lvm_vg_name'])) ? filter_var(urldecode($_GET['lvm_vg_name']), FILTER_SANITIZE_STRING) : "";
  $lvm_vg_force_reuse = (isset($_GET['lvm_vg_force_reuse'])) ? filter_var(urldecode($_GET['lvm_vg_force_reuse']), FILTER_SANITIZE_STRING) : "";
  $name = (isset($_GET['name'])) ? filter_var(urldecode($_GET['name']), FILTER_SANITIZE_STRING) : "";
  $project = (isset($_GET['project'])) ? filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING) : "";
  $remote = (isset($_GET['remote'])) ? filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_NUMBER_INT) : "";
  $repo = (isset($_GET['repo'])) ? filter_var(urldecode($_GET['repo']), FILTER_SANITIZE_STRING) : "";
  $rsync_bwlimit = (isset($_GET['rsync_bwlimit'])) ? filter_var(urldecode($_GET['rsync_bwlimit']), FILTER_SANITIZE_STRING) : "";
  $rsync_compression = (isset($_GET['rsync_compression'])) ? filter_var(urldecode($_GET['rsync_compression']), FILTER_SANITIZE_STRING) : "";
  $size = (isset($_GET['size'])) ? filter_var(urldecode($_GET['size']), FILTER_SANITIZE_STRING) : "";
  $source = (isset($_GET['source'])) ? filter_var(urldecode($_GET['source']), FILTER_SANITIZE_STRING) : "";
  $storage_pool = (isset($_GET['storage_pool'])) ? filter_var(urldecode($_GET['storage_pool']), FILTER_SANITIZE_STRING) : "";
  $volatile_initial_source = (isset($_GET['volatile_initial_source'])) ? filter_var(urldecode($_GET['volatile_initial_source']), FILTER_SANITIZE_STRING) : "";
  $volatile_pool_pristine = (isset($_GET['volatile_pool_pristine'])) ? filter_var(urldecode($_GET['volatile_pool_pristine']), FILTER_SANITIZE_STRING) : "";
  $volume_block_filesystem = (isset($_GET['volume_block_filesystem'])) ? filter_var(urldecode($_GET['volume_block_filesystem']), FILTER_SANITIZE_STRING) : "";
  $volume_block_mount_options = (isset($_GET['volume_block_mount_options'])) ? filter_var(urldecode($_GET['volume_block_mount_options']), FILTER_SANITIZE_STRING) : "";
  $volume_lvm_stripes = (isset($_GET['volume_lvm_stripes'])) ? filter_var(urldecode($_GET['volume_lvm_stripes']), FILTER_SANITIZE_STRING) : "";
  $volume_lvm_stripes_size = (isset($_GET['volume_lvm_stripes_size'])) ? filter_var(urldecode($_GET['volume_lvm_stripes_size']), FILTER_SANITIZE_STRING) : "";
  $volume_size = (isset($_GET['volume_size'])) ? filter_var(urldecode($_GET['volume_size']), FILTER_SANITIZE_STRING) : "";
  $volume_zfs_remove_snapshots = (isset($_GET['volume_zfs_remove_snapshots'])) ? filter_var(urldecode($_GET['volume_zfs_remove_snapshots']), FILTER_SANITIZE_STRING) : "";
  $volume_zfs_use_refquota = (isset($_GET['volume_zfs_use_refquota'])) ? filter_var(urldecode($_GET['volume_zfs_use_refquota']), FILTER_SANITIZE_STRING) : "";
  $zfs_clone_copy = (isset($_GET['zfs_clone_copy'])) ? filter_var(urldecode($_GET['zfs_clone_copy']), FILTER_SANITIZE_STRING) : "";
  $zfs_pool_name = (isset($_GET['zfs_pool_name'])) ? filter_var(urldecode($_GET['zfs_pool_name']), FILTER_SANITIZE_STRING) : "";

  //Declare and instantiate POST variables
  $json = (isset($_POST['json'])) ? $_POST['json'] : "";

  //Require code from lxd-dashboard/backend/config/curl.php
  require_once('../config/curl.php');

  //Require code from lxd-dashboard/backend/config/db.php
  require_once('../config/db.php');

  //Require code from lxd-dashboard/backend/aaa/accounting.php
  require_once('../aaa/accounting.php');

  //Query database for remote host record
  $base_url = retrieveHostURL($remote);

  //Run the matching action
  switch ($action) {

    case "createStoragePoolUsingForm":

      //Check to see if host is part of a cluster. Clusted hosts need storage pool created first on each of the hosts
      $url = $base_url . "/1.0/cluster";
      $remote_data = sendCurlRequest($action, "GET", $url);
      $remote_data = json_decode($remote_data, true);
      $cluster_status = $remote_data['metadata'];

      if ($cluster_status['enabled'] == true){
        //Get a list of cluster members
        $url = $base_url . "/1.0/cluster/members?recursion=1";
        $cluster_api_data = sendCurlRequest($action, "GET", $url);
        $cluster_api_data = json_decode($cluster_api_data, true);
        $cluster_api_data = $cluster_api_data['metadata'];

        //Setup Storage Pool data for REST API
        $target_device_array = array();
        $target_device_array['config'] = new ArrayObject();
        $target_device_array['name'] = $name;
        $target_device_array['description'] = $description;
        $target_device_array['driver'] = $driver;
        if (!empty($source)){ $target_device_array['config']['source'] = $source;}
        
        if ($driver == "btrfs"){
          if (!empty($size)){ $target_device_array['config']['size'] = $size;}
        }

        if ($driver == "lvm"){
          if (!empty($size)){ $target_device_array['config']['size'] = $size;}
        }

        if ($driver == "zfs"){
          if (!empty($size)){ $target_device_array['config']['size'] = $size;}
          if (!empty($zfs_pool_name)){ $target_device_array['config']['zfs.pool_name'] = $zfs_pool_name;}
        }

        $target_data = json_encode($target_device_array);

        //Loop through each cluster member to create the storage pool, this will put the storage volume in pending status
        foreach ($cluster_api_data as $cluster_data){
          $url = $base_url . "/1.0/storage-pools?project=" . $project . "&target=".$cluster_data['server_name'];
          $results = sendCurlRequest($action, "POST", $url, $target_data);
        }

        //Now lets create the storage pool without target config options, moving the pending status to created
        $url = $base_url . "/1.0/storage-pools?project=" . $project;

        //Setup Storage Pool data for REST API
        $device_array = array();
        $device_array['config'] = new ArrayObject();
        $device_array['name'] = $name;
        $device_array['description'] = $description;
        $device_array['driver'] = $driver;
        //if (!empty($source)){ $device_array['config']['source'] = $source;} //This is a target node specific setting
        
        if ($driver == "btrfs"){
          //if (!empty($size)){ $device_array['config']['size'] = $size;} //This is a target node specific setting
          if (!empty($btrfs_mount_options)){ $device_array['config']['btrfs.mount_options'] = $btrfs_mount_options;}
          if (!empty($rsync_bwlimit)){ $device_array['config']['rsync.bwlimit'] = $rsync_bwlimit;}
          if (!empty($rsync_compression)){ $device_array['config']['rsync.compression'] = $rsync_compression;}
          if (!empty($volatile_initial_source)){ $device_array['config']['volatile.initial_source'] = $volatile_initial_source;}
          if (!empty($volume_size)){ $device_array['config']['volume.size'] = $volume_size;}
        }

        if ($driver == "ceph"){
          if (!empty($ceph_cluster_name)){ $device_array['config']['ceph.cluster_name'] = $ceph_cluster_name;}
          if (!empty($ceph_osd_force_reuse)){ $device_array['config']['ceph.osd.force_reuse'] = $ceph_osd_force_reuse;}
          if (!empty($ceph_osd_pg_num)){ $device_array['config']['ceph.osd.pg_num'] = $ceph_osd_pg_num;}
          if (!empty($ceph_osd_pool_name)){ $device_array['config']['ceph.osd.pool_name'] = $ceph_osd_pool_name;}
          if (!empty($ceph_osd_data_pool_name)){ $device_array['config']['ceph.osd.data_pool_name'] = $ceph_osd_data_pool_name;}
          if (!empty($ceph_rbd_clone_copy)){ $device_array['config']['ceph.rbd.clone_copy'] = $ceph_rbd_clone_copy;}
          if (!empty($ceph_rbd_features)){ $device_array['config']['ceph.rbd.features'] = $ceph_rbd_features;}
          if (!empty($sourceph_user_namece)){ $device_array['config']['ceph.user.name'] = $ceph_user_name;}
          if (!empty($rsync_bwlimit)){ $device_array['config']['rsync.bwlimit'] = $rsync_bwlimit;}
          if (!empty($rsync_compression)){ $device_array['config']['rsync.compression'] = $rsync_compression;}
          if (!empty($volatile_initial_source)){ $device_array['config']['volatile.initial_source'] = $volatile_initial_source;}
          if (!empty($volatile_pool_pristine)){ $device_array['config']['volatile.pool.pristine'] = $volatile_pool_pristine;}
          if (!empty($volume_block_filesystem)){ $device_array['config']['volume.block.filesystem'] = $volume_block_filesystem;}
          if (!empty($volume_block_mount_options)){ $device_array['config']['volume.block.mount_options'] = $volume_block_mount_options;}
          if (!empty($volume_size)){ $device_array['config']['volume.size'] = $volume_size;}
        }

        if ($driver == "cephfs"){
          if (!empty($cephfs_cluster_name)){ $device_array['config']['cephfs.cluster_name'] = $cephfs_cluster_name;}
          if (!empty($cephfs_path)){ $device_array['config']['cephfs.path'] = $cephfs_path;}
          if (!empty($cephfs_user_name)){ $device_array['config']['cephfs.user.name'] = $cephfs_user_name;}

          //Additional options that might be used in cephfs
          if (!empty($rsync_bwlimit)){ $device_array['config']['rsync.bwlimit'] = $rsync_bwlimit;}
          if (!empty($rsync_compression)){ $device_array['config']['rsync.compression'] = $rsync_compression;}
          if (!empty($volatile_initial_source)){ $device_array['config']['volatile.initial_source'] = $volatile_initial_source;}
          if (!empty($volatile_pool_pristine)){ $device_array['config']['volatile.pool.pristine'] = $volatile_pool_pristine;}
          if (!empty($volume_block_filesystem)){ $device_array['config']['volume.block.filesystem'] = $volume_block_filesystem;}
          if (!empty($volume_block_mount_options)){ $device_array['config']['volume.block.mount_options'] = $volume_block_mount_options;}
          if (!empty($volume_size)){ $device_array['config']['volume.size'] = $volume_size;}
        }

        if ($driver == "dir"){
          if (!empty($rsync_bwlimit)){ $device_array['config']['rsync.bwlimit'] = $rsync_bwlimit;}
          if (!empty($rsync_compression)){ $device_array['config']['rsync.compression'] = $rsync_compression;}
          if (!empty($volatile_initial_source)){ $device_array['config']['volatile.initial_source'] = $volatile_initial_source;}
          if (!empty($volume_size)){ $device_array['config']['volume.size'] = $volume_size;}
        }

        if ($driver == "lvm"){
          //if (!empty($size)){ $device_array['config']['size'] = $size;} //This is a target node specific setting
          if (!empty($lvm_thinpool_name)){ $device_array['config']['lvm.thinpool_name'] = $lvm_thinpool_name;}
          if (!empty($lvm_use_thinpool)){ $device_array['config']['lvm.use_thinpool'] = $lvm_use_thinpool;}
          if (!empty($lvm_vg_name)){ $device_array['config']['lvm.vg_name'] = $lvm_vg_name;}
          if (!empty($lvm_vg_force_reuse)){ $device_array['config']['lvm.vg.force_reuse'] = $lvm_vg_force_reuse;}
          if (!empty($volume_lvm_stripes)){ $device_array['config']['volume.lvm.stripes'] = $volume_lvm_stripes;}
          if (!empty($volume_lvm_stripes_size)){ $device_array['config']['volume.lvm.stripes.size'] = $volume_lvm_stripes_size;}
          if (!empty($rsync_bwlimit)){ $device_array['config']['rsync.bwlimit'] = $rsync_bwlimit;}
          if (!empty($rsync_compression)){ $device_array['config']['rsync.compression'] = $rsync_compression;}
          if (!empty($volatile_initial_source)){ $device_array['config']['volatile.initial_source'] = $volatile_initial_source;}
          if (!empty($volume_block_filesystem)){ $device_array['config']['volume.block.filesystem'] = $volume_block_filesystem;}
          if (!empty($volume_block_mount_options)){ $device_array['config']['volume.block.mount_options'] = $volume_block_mount_options;}
          if (!empty($volume_size)){ $device_array['config']['volume.size'] = $volume_size;}
        }

        if ($driver == "zfs"){
          //if (!empty($size)){ $device_array['config']['size'] = $size;} //This is a target node specific setting
          if (!empty($volume_zfs_remove_snapshots)){ $device_array['config']['volume.zfs.remove_snapshots'] = $volume_zfs_remove_snapshots;}
          if (!empty($volume_zfs_use_refquota)){ $device_array['config']['volume.zfs.use_refquota'] = $volume_zfs_use_refquota;}
          if (!empty($zfs_clone_copy)){ $device_array['config']['zfs.clone_copy'] = $zfs_clone_copy;}
          //if (!empty($zfs_pool_name)){ $device_array['config']['zfs.pool_name'] = $zfs_pool_name;} //This is a target node specific setting
          if (!empty($rsync_bwlimit)){ $device_array['config']['rsync.bwlimit'] = $rsync_bwlimit;}
          if (!empty($rsync_compression)){ $device_array['config']['rsync.compression'] = $rsync_compression;}
          if (!empty($volatile_initial_source)){ $device_array['config']['volatile.initial_source'] = $volatile_initial_source;}
          if (!empty($volume_size)){ $device_array['config']['volume.size'] = $volume_size;}
        }

        $data = json_encode($device_array);
        $results = sendCurlRequest($action, "POST", $url, $data);
      }
      else {
        //This is process of creating storage pool on a non-clustered host
        //Setup Storage Pool data for REST API
        $device_array = array();
        $device_array['config'] = new ArrayObject();
        $device_array['name'] = $name;
        $device_array['description'] = $description;
        $device_array['driver'] = $driver;
        if (!empty($source)){ $device_array['config']['source'] = $source;}
        
        if ($driver == "btrfs"){
          if (!empty($size)){ $device_array['config']['size'] = $size;}
          if (!empty($btrfs_mount_options)){ $device_array['config']['btrfs.mount_options'] = $btrfs_mount_options;}
          if (!empty($rsync_bwlimit)){ $device_array['config']['rsync.bwlimit'] = $rsync_bwlimit;}
          if (!empty($rsync_compression)){ $device_array['config']['rsync.compression'] = $rsync_compression;}
          if (!empty($volatile_initial_source)){ $device_array['config']['volatile.initial_source'] = $volatile_initial_source;}
          if (!empty($volume_size)){ $device_array['config']['volume.size'] = $volume_size;}
        }

        if ($driver == "ceph"){
          if (!empty($ceph_cluster_name)){ $device_array['config']['ceph.cluster_name'] = $ceph_cluster_name;}
          if (!empty($ceph_osd_force_reuse)){ $device_array['config']['ceph.osd.force_reuse'] = $ceph_osd_force_reuse;}
          if (!empty($ceph_osd_pg_num)){ $device_array['config']['ceph.osd.pg_num'] = $ceph_osd_pg_num;}
          if (!empty($ceph_osd_pool_name)){ $device_array['config']['ceph.osd.pool_name'] = $ceph_osd_pool_name;}
          if (!empty($ceph_osd_data_pool_name)){ $device_array['config']['ceph.osd.data_pool_name'] = $ceph_osd_data_pool_name;}
          if (!empty($ceph_rbd_clone_copy)){ $device_array['config']['ceph.rbd.clone_copy'] = $ceph_rbd_clone_copy;}
          if (!empty($ceph_rbd_features)){ $device_array['config']['ceph.rbd.features'] = $ceph_rbd_features;}
          if (!empty($sourceph_user_namece)){ $device_array['config']['ceph.user.name'] = $ceph_user_name;}
          if (!empty($rsync_bwlimit)){ $device_array['config']['rsync.bwlimit'] = $rsync_bwlimit;}
          if (!empty($rsync_compression)){ $device_array['config']['rsync.compression'] = $rsync_compression;}
          if (!empty($volatile_initial_source)){ $device_array['config']['volatile.initial_source'] = $volatile_initial_source;}
          if (!empty($volatile_pool_pristine)){ $device_array['config']['volatile.pool.pristine'] = $volatile_pool_pristine;}
          if (!empty($volume_block_filesystem)){ $device_array['config']['volume.block.filesystem'] = $volume_block_filesystem;}
          if (!empty($volume_block_mount_options)){ $device_array['config']['volume.block.mount_options'] = $volume_block_mount_options;}
          if (!empty($volume_size)){ $device_array['config']['volume.size'] = $volume_size;}
        }

        if ($driver == "cephfs"){
          if (!empty($cephfs_cluster_name)){ $device_array['config']['cephfs.cluster_name'] = $cephfs_cluster_name;}
          if (!empty($cephfs_path)){ $device_array['config']['cephfs.path'] = $cephfs_path;}
          if (!empty($cephfs_user_name)){ $device_array['config']['cephfs.user.name'] = $cephfs_user_name;}

          //Additional options that might be used in cephfs
          if (!empty($rsync_bwlimit)){ $device_array['config']['rsync.bwlimit'] = $rsync_bwlimit;}
          if (!empty($rsync_compression)){ $device_array['config']['rsync.compression'] = $rsync_compression;}
          if (!empty($volatile_initial_source)){ $device_array['config']['volatile.initial_source'] = $volatile_initial_source;}
          if (!empty($volatile_pool_pristine)){ $device_array['config']['volatile.pool.pristine'] = $volatile_pool_pristine;}
          if (!empty($volume_block_filesystem)){ $device_array['config']['volume.block.filesystem'] = $volume_block_filesystem;}
          if (!empty($volume_block_mount_options)){ $device_array['config']['volume.block.mount_options'] = $volume_block_mount_options;}
          if (!empty($volume_size)){ $device_array['config']['volume.size'] = $volume_size;}
        }

        if ($driver == "dir"){
          if (!empty($rsync_bwlimit)){ $device_array['config']['rsync.bwlimit'] = $rsync_bwlimit;}
          if (!empty($rsync_compression)){ $device_array['config']['rsync.compression'] = $rsync_compression;}
          if (!empty($volatile_initial_source)){ $device_array['config']['volatile.initial_source'] = $volatile_initial_source;}
          if (!empty($volume_size)){ $device_array['config']['volume.size'] = $volume_size;}
        }

        if ($driver == "lvm"){
          if (!empty($size)){ $device_array['config']['size'] = $size;}
          if (!empty($lvm_thinpool_name)){ $device_array['config']['lvm.thinpool_name'] = $lvm_thinpool_name;}
          if (!empty($lvm_use_thinpool)){ $device_array['config']['lvm.use_thinpool'] = $lvm_use_thinpool;}
          if (!empty($lvm_vg_name)){ $device_array['config']['lvm.vg_name'] = $lvm_vg_name;}
          if (!empty($lvm_vg_force_reuse)){ $device_array['config']['lvm.vg.force_reuse'] = $lvm_vg_force_reuse;}
          if (!empty($volume_lvm_stripes)){ $device_array['config']['volume.lvm.stripes'] = $volume_lvm_stripes;}
          if (!empty($volume_lvm_stripes_size)){ $device_array['config']['volume.lvm.stripes.size'] = $volume_lvm_stripes_size;}
          if (!empty($rsync_bwlimit)){ $device_array['config']['rsync.bwlimit'] = $rsync_bwlimit;}
          if (!empty($rsync_compression)){ $device_array['config']['rsync.compression'] = $rsync_compression;}
          if (!empty($volatile_initial_source)){ $device_array['config']['volatile.initial_source'] = $volatile_initial_source;}
          if (!empty($volume_block_filesystem)){ $device_array['config']['volume.block.filesystem'] = $volume_block_filesystem;}
          if (!empty($volume_block_mount_options)){ $device_array['config']['volume.block.mount_options'] = $volume_block_mount_options;}
          if (!empty($volume_size)){ $device_array['config']['volume.size'] = $volume_size;}
        }

        if ($driver == "zfs"){
          if (!empty($size)){ $device_array['config']['size'] = $size;}
          if (!empty($volume_zfs_remove_snapshots)){ $device_array['config']['volume.zfs.remove_snapshots'] = $volume_zfs_remove_snapshots;}
          if (!empty($volume_zfs_use_refquota)){ $device_array['config']['volume.zfs.use_refquota'] = $volume_zfs_use_refquota;}
          if (!empty($zfs_clone_copy)){ $device_array['config']['zfs.clone_copy'] = $zfs_clone_copy;}
          if (!empty($zfs_pool_name)){ $device_array['config']['zfs.pool_name'] = $zfs_pool_name;}
          if (!empty($rsync_bwlimit)){ $device_array['config']['rsync.bwlimit'] = $rsync_bwlimit;}
          if (!empty($rsync_compression)){ $device_array['config']['rsync.compression'] = $rsync_compression;}
          if (!empty($volatile_initial_source)){ $device_array['config']['volatile.initial_source'] = $volatile_initial_source;}
          if (!empty($volume_size)){ $device_array['config']['volume.size'] = $volume_size;}
        }

        $data = json_encode($device_array);
        $url = $base_url . "/1.0/storage-pools?project=" . $project;
        $results = sendCurlRequest($action, "POST", $url, $data);
      }

      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $name;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "createStoragePoolUsingJSON":

      //Check to see if host is part of a cluster. Clusted hosts need storage pool created first on each of the hosts
      $url = $base_url . "/1.0/cluster";
      $remote_data = sendCurlRequest($action, "GET", $url);
      $remote_data = json_decode($remote_data, true);
      $cluster_status = $remote_data['metadata'];

      if ($cluster_status['enabled'] == true){
        //Get a list of cluster members
        $url = $base_url . "/1.0/cluster/members?recursion=1";
        $cluster_api_data = sendCurlRequest($action, "GET", $url);
        $cluster_api_data = json_decode($cluster_api_data, true);
        $cluster_api_data = $cluster_api_data['metadata'];

        //Setup Storage Pool data for REST API
        $target_json_array = json_decode($json, true);

        //Setup Storage Pool data for REST API
        $target_device_array = array();
        $target_device_array['config'] = new ArrayObject();
        $target_device_array['name'] = $target_json_array['name'];
        $target_device_array['description'] = $target_json_array['description'];
        $target_device_array['driver'] = $target_json_array['driver'];
        if (!empty($target_json_array['config']['source'])){ $target_device_array['config']['source'] = $target_json_array['config']['source'];}
        
        if ($target_device_array['driver'] == "btrfs"){
          if (!empty($target_json_array['config']['size'])){ $target_device_array['config']['size'] = $target_json_array['config']['size'];}
        }

        if ($target_device_array['driver'] == "lvm"){
          if (!empty($target_json_array['config']['size'])){ $target_device_array['config']['size'] = $target_json_array['config']['size'];}
        }

        if ($target_device_array['driver'] == "zfs"){
          if (!empty($target_json_array['config']['size'])){ $target_device_array['config']['size'] = $target_json_array['config']['size'];}
          if (!empty($target_json_array['config']['zfs.pool_name'])){ $target_device_array['config']['zfs.pool_name'] = $target_json_array['config']['zfs.pool_name'];}
        }

        $target_data = json_encode($target_device_array);

        //Loop through each cluster member to create the storage pool, this will put the storage volume in pending status
        foreach ($cluster_api_data as $cluster_data){
          $url = $base_url . "/1.0/storage-pools?project=" . $project . "&target=".$cluster_data['server_name'];
          $results = sendCurlRequest($action, "POST", $url, $target_data);
        }

        //Now lets create the storage pool without target config options, moving the pending status to created
        $url = $base_url . "/1.0/storage-pools?project=" . $project;

        //Setup Storage Pool data for REST API
        $device_array = json_decode($json, true);
        unset($device_array['config']['source']);
        unset($device_array['config']['size']);
        unset($device_array['config']['zfs.pool_name']);

        $data = json_encode($device_array);
        $results = sendCurlRequest($action, "POST", $url, $data);
      }
      else {
        $url = $base_url . "/1.0/storage-pools?project=" . $project;
        $data = $json;
        $results = sendCurlRequest($action, "POST", $url, $data);
      }
 
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = json_decode($data, true)['name'];
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "deleteStoragePool":
      $url = $base_url . "/1.0/storage-pools/" . $storage_pool . "?project=" . $project;
      $results = sendCurlRequest($action, "DELETE", $url);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $storage_pool;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "listStoragePools":
      if (validateAuthorization($action)) {
        $url = $base_url . "/1.0/storage-pools?recursion=1&project=" . $project;
        $results = sendCurlRequest($action, "GET", $url);
        $results = json_decode($results, true);
        $storage_pools = (isset($results['metadata'])) ? $results['metadata'] : [];
      
        $i = 0;
        echo '{ "data": [';
      
        if ($results['status_code'] == "200"){

          foreach ($storage_pools as $storage_pool){
            
            if ($storage_pool['name'] == "")
            continue;
        
            if ($i > 0){
              echo ",";
            }
            $i++;
        
            echo "[ ";
            echo '"';
            echo "<a href='storage-volumes.php?pool=".$storage_pool['name']."&remote=".$remote."&project=".$project."&type=custom'><i class='fas fa-hdd fa-lg' style='color:#4e73df'></i> </a>";
            echo '",';
        
            echo '"';
            echo "<a href='storage-volumes.php?pool=".$storage_pool['name']."&remote=".$remote."&project=".$project."&type=custom'> ".htmlentities($storage_pool['name'])."</a>";
            echo '",';
        
            echo '"' . htmlentities($storage_pool['description']) . '",';
            echo '"' . htmlentities($storage_pool['driver']) . '",';
            echo '"' . htmlentities($storage_pool['status']) . '",';

            if(isset($storage_pool['config']) && array_key_exists('source', $storage_pool['config']))
              $storage_pool_source = (isset($storage_pool['config']['source'])) ? $storage_pool['config']['source'] : "N/A";
            else
              $storage_pool_source = "N/A";
            echo '"' . htmlentities($storage_pool_source) . '",';

            $storage_pool_size = (isset($storage_pool['config']['size'])) ? $storage_pool['config']['size'] : "N/A";
            echo '"' . htmlentities($storage_pool_size) . '",';
        
            echo '"';
            echo "<a href='#' onclick=loadStoragePoolJson('".$storage_pool['name']."')><i class='fas fa-edit fa-lg' style='color:#ddd' title='Edit' aria-hidden='true'></i></a>";
            echo " &nbsp ";
            echo "<a href='#' onclick=deleteStoragePool('".$storage_pool['name']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";
            echo '"';
        
            echo " ]";
        
          }

        }
      
        echo " ]}";
      }
      else {
        echo '{ "data": [] }';
      }      
      break;

    case "listStoragePoolsForSelectOption":
      if (validateAuthorization($action)) {
        $url = $base_url . "/1.0/storage-pools?recursion=1&project=" . $project;
        $results = sendCurlRequest($action, "GET", $url);
        $results = json_decode($results, true);
        $storage_pools = (isset($results['metadata'])) ? $results['metadata'] : [];
      
        echo '<option value="">(not set)</option>';
        
        foreach ($storage_pools as $storage_pool){
          
          if ($storage_pool['name'] == "")
          continue;
      
          echo '<option value="' . $storage_pool['name'] . '">' . htmlentities($storage_pool['name']) . '</option>';

        }
      }
      break;

    case "loadStoragePool":
      $url = $base_url . "/1.0/storage-pools/" . $storage_pool . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      echo $results;
      break;

    case "updateStoragePool":
      $url = $base_url . "/1.0/storage-pools/" . $storage_pool . "?project=" . $project;
      $data = $json;
      $results = sendCurlRequest($action, "PUT", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $storage_pool;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    default:
      $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"err": "Unable to execute action on remote host", "status_code": "400"}}';
      echo $results;

  }

}
else {
  echo '{"error": "not authenticated", "error_code": "401", "metadata": {"err": "not authenticated", "status_code": "401"}}';
}
  
?>