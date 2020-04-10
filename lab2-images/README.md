# Docker Labs - Docker Images -  Lab 2

These labs should be following along the video:


## Lab Instructions
1. See current Images
``` shell
docker images
```

2. Search Docker images
``` shell
docker search ubuntu
```

3. Download docker images, and list images
``` shell
docker pull ubuntu:latest
docker pull nginx:latest
docker image ls
```

4. Create a container, install python, commit the image
``` shell
docker run -it ubuntu:14.04
apt-get update -y && apt-get install python -y
exit
docker ps -a
docker commit <container id> ubuntu:python 
```

5. See images
``` shell
docker image ls
docker history ubuntu:python
```
6. Create a container with your new image
``` shell
docker run -it ubuntu:python
```