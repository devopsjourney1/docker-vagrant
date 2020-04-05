# Docker Labs - Docker Networks -  Lab 5

These labs should be following along the video:

# Docker Containers
1. List docker networks
``` shell
docker network ls
```

2. Create two new docket networks
``` shell
docker network create frontend
docker network create backend
```

3. Inspect the networks
``` shell
docker network inspect frontend
docker network inspect backend
```

4. Attach the networks to web01 container
``` shell
docker network connect frontend web01
docker network connect backend web01
```

5. Create a new container named db01 with backend network attached
``` shell
docker run -d -it --name db01 -h db01 ubuntu:14.04
docker network connect backend db01
docker attach db01
ping web01
```