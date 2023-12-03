docker build -t myjenkins-blueocean:2.426.1-1 .
docker run -d -p 8083:8080 myjenkins-blueocean:2.426.1-1