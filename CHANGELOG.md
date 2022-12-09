# v3.6.0
- Merged pull request adding cloud init user data option for new containers via form
- Fixed typo preventing OS version number from showing in remotes-single.php page, under LXD Information

# v3.5.0
- Updated container image catalog based on results from from https://us.lxd.images
- Merged pull request updating MySQL statements for auto increment and now time

# v3.4.0
- Added additional delete option for powered-off instances on the containers and virtual machines pages
- Fixed bug in populating both profile and cluster member options in drop-down box for virtual machine configurations
- Added verification for numeric values in instance memory gauge display

# v3.3.0
- Updated PDO try-catch exception for PHP 8
- Created recursive PHP in_array for SQLite Pragma array search in PHP 8
- Improved handling of external port for remotes
- Fixed bug with scope of curl variables

# v3.2.0
- added removal confirmation of remote hosts
- added preference choices for logging and logs page
- added preferences for custom page refresh rates
- added preferences for custom API connection and operation timeout
- improved CPU gauge, changing from top to /proc/stat readings
- improved handling connection to unresponsive remote hosts
- fixed bug with adding hosts due to data type

# v3.1.0
- improved performance of page loads
- updated instance backups to include a filesize of exported files
- updated exporting backup image to using a script to spawn it off into a background process
- updated remote host table header
- updated link to display all volume types on storage volumes page
- reduced curl connection timeout

# v3.0.0
- initial release of the LXDWARE LXD dashboard version 3.0.0