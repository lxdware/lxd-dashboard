# v2.2.0
- Feature: Additional configuration properties have been added to the web form for creating Storage Pools and Storage Volumes, including clustered servers
- Feature: Additional configuration properties have been added to the web form for creating Projects
- Feature: Added cluster configuration to the creation of networks from form entries
- Feature: Filtered the default view of Storage Volumes to show only custom type storage volumes by default and provided link to remove this filter

# v2.1.0
- Feature: Users can now add network, disk, and proxy devices directly to an instance from a form
- Feature: Users can now remove network, disk, and proxy devices from an instance using the dashboard
- Feature: Additional configuration properties have been added to the web form for creating Networks
- Feature: Users can add/remove Network ACL egress/ingress rules using the dashboard
- Feature: The Exec terminal experience has been added to instances
- Feature: Users can click on the "Check for updates" button in the About modal to get a version status

# v2.0.3
- Bug Fix: Continuing the bug fix from previous version, used float type casting for memory variables on remote-single page rather than letting PHP automatically deciding on variable type.

# v2.0.2
- Bug Fix: Replaced PHP round() function with number_format() to force the format of two decimal places on instance-single and remote-single pages.

# v2.0.1
- Bug Fix: Added strtolower() when comparing if cluster member is fully operational. Both "Fully operational" and "fully operational" messages now result to true when providing a list of cluster members to migrate an instance to.

# v2.0.0
- initial release of the LXDWARE LXD dashboard version 2.0.0