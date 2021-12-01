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


if (isset($_SESSION['username'])) {
?>

<!DOCTYPE html>
<html lang="en">
<body class="">
  <p>This open source LXD dashboard is developed by LXDWARE and provides a web-based user interface capable of managing multiple LXD servers from a single location.</p>
  <p>
    <strong>Version</strong>: <span id="versionNumber">v3.0.0</span> <br />
    <strong>License</strong>: AGPL-3.0 <br />
    <strong>URL</strong>: https://lxdware.com <br />
</p>
  
  <div class="text-center">
    <p class="text-primary" id="updateMessage"></p>
    <button class="btn btn-primary" type="button" onclick="checkForNewerRelease()">Check for updates</button>
  </div>

</body>
<script>
  function checkForNewerRelease(){
    var versionNumber = $("#versionNumber").text();
    $.get("https://api.github.com/repos/lxdware/lxd-dashboard/releases", function( data ) {
      console.log("Local version: " + versionNumber)
      console.log("Latest GitHub version: " + data[0].tag_name);
      if (data[0].tag_name == versionNumber){
        $("#updateMessage").text("You are using the latest release");
      }
      else {
        $("#updateMessage").text("There is a newer release " + data[0].tag_name + " available");
      }
    });
  }
</script>
</html>

<?php
}
?>