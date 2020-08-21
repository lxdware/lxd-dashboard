# dashboard
This LXD dashboard by LXDWARE is a full-featured web interface that makes it easy to manage the containers and virtual machines on your LXD servers. Some of the features include:

- Creating/launching new LXD container and virtual machine instances
- Starting, stopping, renaming, and deleting LXD instances
- Cloning/Copying instances
- Creating, restoring and deleting snapshots of instances
- Downloading LXD container and virtual machine images to your host
- Creating, editing, and applying LXD profiles
- Creating and editing networks, storage pools, and projects
- Selecting between projects on a host

This project is an HTML5 web based dashboard used to control the LXD/LXC containers of remote servers. The software runs within a Docker container and is built using Ubuntu, NGINX, and PHP.

To get started using this web dashboard first install docker on your computer. Then for a persistent container run:

docker run -d --name dashboard -p 80:80 -e ADMIN_PASS="lxdware" -v ~/lxdware/data:/var/lxdware/data lxdware/dashboard

For more information visit https://lxdware.com or view the docker information at https://hub.docker.com/r/lxdware/dashboard