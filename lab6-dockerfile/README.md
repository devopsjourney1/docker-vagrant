# Docker Labs - Docker Networks -  Lab 5

These labs should be following along the video:



``` shell
docker images
docker image build -t ubuntu:flask .
docker run -d --hostname webserv1 --name webserv1 -p 80:5000 ubuntu:flask
docker exec webserv1 ps
curl localhost
```

docker image build -t ubuntu:dbot .