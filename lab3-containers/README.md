# Docker Labs - Docker Images -  Lab 3

These labs should be following along the video:


# Docker Containers
1. See that containers exit out when they have completed execution.
``` shell
docker run ubuntu:14.04 ls -l
docker run ubuntu:14.04 date
docker run ubuntu:14.04 hostname
docker run -d -it ubuntu:14.04 
```j

2. Set an environment variable
``` shell
docker run -d -it --name test1 -e MYSQL_PASSWORD='SecurePassword' ubuntu:14.04 bash
docker exec test env
```

3. Map a Volume to a container
``` shell
docker run -d -it --name test2 -v ~/data:/~/data ubuntu:14.04 bash
docker exec test2 ls /~/data
docker exec test2 cat /~/data/myfile.txt
```


4. Start a NGINX container that forwards host port 8000 to container port 80
``` shell
docker run -d --name web01 -h web01 -p 8000:80 nginx
curl localhost:8000
```

5. Managing containers
``` shell
docker restart web01
docker stop web01
# notice that you can't get to the page anymore
curl localhost:8000
docker start web01
docker top web01
docker stats
```

6. Using Docker Logs
```shell
docker attach test
ls -l
exit
docker logs test
```