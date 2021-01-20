# v.1.1.6
- added tabs to the instance page, allowing for better organization
- improved instance log and backup functions and moved them to a navigation tab
- modified auto refresh time on pages to 5 seconds
- backfilled the changelog file
- updating copyright year to 2021

# v1.1.5
- added CHANGELOG.md file
- modified notifications to include any error message when downloading a new image
- added accessibility attributes to semantic icons, providing a popup text when hovering over icon
- changed notification spinner to bootstrap border spinner from grow spinner, making it less obtrusive
- relocated notification area to the left side of top nav bar to help with various notification lengths
- added support for creating storage pools on hosts that belong to a cluster
- added Status to the table on the  storage pools page

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
- updates to the way projects are handled using the rest api.

# v1.0.0
- initial release of the LXD dashboard