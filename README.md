# lxd-dashboard
This LXD dashboard is a web-based user interface allowing users to easily manage LXD/LXC servers. Some of the features include:

- Connect and manage multiple LXD servers
- Create LXD container and virtual machine instances from either a form or JSON input
- Start, stop, rename, and delete LXD instances
- Copy instances to create new instances 
- Create, restore and delete snapshots of instances
- Create instances from snaphots
- Migrate instances between hosts on an LXD cluster
- Download LXD container and virtual machine images to LXD hosts
- Create, edit, apply, and remove LXD profiles
- Create, edit, and delete networks, storage pools, storage volumes, and projects
- Switch between projects on an LXD host
- Send shell commands to instances using exec
- Create and download backups of LXD instance to your local computer

The LXD dashboard can be deployed on either an LXC or Docker container. The software is built primarily using Ubuntu, NGINX, and PHP.

Installation instructions can be found on the LXDWARE web site located at https://lxdware.com/installation