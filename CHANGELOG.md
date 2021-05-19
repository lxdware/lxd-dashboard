# v2.0.2
- Bug Fix: Replaced PHP round() function with number_format() to force the format of two decimal places on instance-single and remote-single pages.

# v2.0.1
- Bug Fix: Added strtolower() when comparing if cluster member is fully operational. Both "Fully operational" and "fully operational" messages now result to true when providing a list of cluster members to migrate an instance to.

# v2.0.0
- initial release of the LXDWARE LXD dashboard version 2.0.0