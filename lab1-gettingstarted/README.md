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
sudo apt update
sudo apt-get install docker.io
```

Two pieces of Docker. The client and the server. They are decoupled.

4. Verify Installation
``` shell
sudo docker version
sudo docker info
```

5. Setup Aliases
``` shell
sudo docker='sudo docker'
d='sudo docker'
alias stopdocks='sudo docker stop $(docker ps -a -q)'
alias rmdocks='sudo docker rm $(docker ps -a -q)'
```

## Download our First Image
1. Check to see current images, by default there is none

``` shell
sudo docker images
```

2. Pull the image 'ubuntu:14.04'
``` shell
sudo docker pull ubuntu:14.04
```

3. See that the image now exists
``` shell
sudo docker images
```


## Run our first container
1. See that no docker containers are running
``` shell
sudo docker ps -a
```
2. Start a container
``` shell
sudo docker run -it ubuntu:14.04
# See that you are in the container.. now exit out.
exit
# See that the container stopped
sudo docker ps -a
```
3. Start a container in detached mode
``` shell
sudo docker run -d -it ubuntu:14.04
sudo docker ps -a
sudo docker attach <container id>
```
