# Docker Labs - Docker Container Inspection -  Lab 4

These labs should be following along the video:


# Docker Containers
1. Inspect one of your containers
``` shell
docker inspect web01
docker inspect web01 >> web01.json
```

2. Add a filter to check some settings
``` shell
docker inspect -f '{{.Config.Image}}' web01
docker inspect -f '{{.Config.Env}}' web01
docker inspect -f '{{.Config.Hostname}}' web01
docker inspect -f '{{.Mounts}}' test2
docker inspect -f '{{.State.Pid}}' test2
```

3. Advanced filter to loop through interfaces and reveal IP address
``` shell
docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' web01
```