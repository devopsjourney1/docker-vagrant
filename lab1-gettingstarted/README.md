# Docker Labs - Installing Docker -  Lab 1

These labs should be following along the video:


# Lab Guide

## Setup Vagrant environment and Install Docker


1. Turn on Vagrant Instance
``` shell
vagrant up
```

2. SSH into node1
``` shell
vagrant ssh node1
```

3. Install Docker
``` shell
apt update
apt-get install docker.io
```

Two pieces of Docker. The client and the server. They are decoupled.

4. Verify Installation
``` shell
docker version
docker info
```

5. Setup Aliases
``` shell
docker='docker'
d='docker'
alias stopdocks='docker stop $(docker ps -a -q)'
alias rmdocks='docker rm $(docker ps -a -q)'
```

## Download our First Image
1. Check to see current images, by default there is none

``` shell
docker images
```

2. Pull the image 'ubuntu:14.04'
``` shell
docker pull ubuntu:14.04
```

3. See that the image now exists
``` shell
docker images
```


## Run our first container
1. See that no docker containers are running
``` shell
docker ps -a
```
2. Start a container
``` shell
docker run -it ubuntu:14.04
# See that you are in the container.. now exit out.
exit
# See that the container stopped
docker ps -a
```
3. Start a container in detached mode
``` shell
docker run -d -it ubuntu:14.04
docker ps -a
docker attach <container id>
```
