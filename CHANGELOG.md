# v1.2.4
- merged pull request from ssoor fixing bug on operation status for projects other than default
- fixed additional bug in displaying lists and the actions of items within projects other than default

# v1.2.3
- added IPv4 and IPv6 to instance list, making it closer to "lxc list" output
- added the ability to publish an image from a snapshot

# v1.2.2
- added more customized notifications
- added icons to the action in the instance page
- improved modals on the instance and operations page
- clicking on profile names will now display JSON data of profile
- clicking on image descriptions will now display JSON data of image
- clicking on managed network descriptions will now display JSON data of network
- clicking on instance name on instance page will now display JSON data
- added IPv4 and IPv6 to network table
- added the option to create stateful snapshots

# v1.2.1
- improvements to the UI on the index.html page
- set default value for possible undeclared variable in cluster-list-select.php
- fixed DataTables reloading first page of results after table refresh
- removed lxc executable privileges in docker builds
- allowed for empty instances to be created with an image selection of none

# v1.2.0
- removed the adding certificates option temporarily due to it causing an error
- added the option to create instances from snapshots

# v1.1.9
- added the option to delete cluster members as well as forcefully delete them
- modified default simplestreams to match lxc remote list names: images, ubuntu, and ubuntu-daily
- added instance names to many of the notifications, helping to identify operations

# v1.1.8
- changed display name to LXDWARE
- improvements to the notification of running operations
- added an about page displaying the version, license, and source link
- added icons to Host and Project navigation links in the top bar, improving design for smaller screen displays
- changed port input field to number in the "Add LXD Remote Host" Modal of index.html
- changed remote host table in index.html to full width, moving instructions to top
- set a 3 second connection timeout for curl requests, preventing pages from locking up when host is down
- added location option for creating hosts allowing instances to be created on a specific cluster member

# v1.1.7
- added exec option to instances, allowing users to send non-interactive shell commands to the instance

# v1.1.6
- added tabs to the instance page, allowing for better organization
- improved instance log and backup functions and moved them to a navigation tab
- modified auto refresh time on pages to 5 seconds
- backfilled the changelog file
- updated copyright year to 2021

# v1.1.5
- added CHANGELOG.md file
- modified notifications to include any error message when downloading a new image
- added accessibility attributes to semantic icons, providing a popup text when hovering over icon
- changed notification spinner to bootstrap border spinner from grow spinner, making it less obtrusive
- relocated notification area to the left side of top nav bar to help with various notification lengths
- added support for creating storage pools on hosts that belong to a cluster
- added Status column to the table on the storage pools page

# v1.1.4
- added dropdown arrows to host and project dropdowns in the top nav bar

# v1.1.3
- added recursion to the API calls for remainder of the table lists, improving page load time
- redesigned the hosts page
- added copying of instances on clustered hosts
- added instance migration of instance from one host to another on a cluster
- added Hosts link to sidebar navigation
- modified actions to use icons
- improved reloading of page data to give updated information on pages
- improved running operation notifications of tasks to be persistent between pages of the application
- added instance location to instances page

# v1.1.2
- improved instance list by using recursion in API call
- adding memory usage, root disk usage, and removed architecture information since they will be the same architecture as host.

# v1.1.1
- added new logo and branding

# v1.1.0
- used recursion option for rest API to speed up instance page
- added freeze, unfreeze, and kill options for instances
- slight improvements to UI in host page.

# v1.0.9
- added custom login form and logout to HTTP Basic Authentication
- fixed Datatables error for empty hosts table
- UI improvements to card actions
- added timestamp to backup file name of instances

# v1.0.8
- improvements to the user interface

# v1.0.7
- added backup and logs to instance page

# v1.0.6
- improvements to the UI of the host page

# v1.0.5
- updates to handling hosts table

# v1.0.4
- improvements to the UI

# v1.0.3
- improvements to page refreshes and error handling

# v1.0.2
- added support to view instance proxy devices

# v1.0.1
- updates to the way projects are handled using the REST API.

# v1.0.0
- initial release of the LXD dashboard