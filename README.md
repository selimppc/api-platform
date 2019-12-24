# api-platform
api-patform

Make sure nothing on the required ports:
--------------------------------------
How i can know this ports?
You can find them in the docker-compose.yml file in the project root directory, and they always be like [80, 81, 8080, 8081, 3000, 5432, 1337, 8443, 8444, 443, 444]

How to know this?
Run this command
```
$ sudo lsof -nP | grep LISTEN
```

Kill any process listening on any of the above ports:
```
$ sudo kill -9 $PROCESS_NUMBER
```

Installation:
=============
Pull the required packages and everything needed.
```
$ docker-compose pull
```

Bring the application up and running.
```
$ docker-compose up -d
```

You may face some issue here so better to bring all containers down and run the command again like this
```
$ docker-compose down
$ COMPOSE_HTTP_TIMEOUT=120 docker-compose up -d
```

Now the application should be running and everything in place:
```
$ docker ps
```


URL:
https://localhost:8443/greetings
OR https://localhost
