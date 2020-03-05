# Create container MySql 
To create a container MySql we will use Docker Hub.
To start we will fetch my sql docker with this following command:
> ``docker pull mysql``

After that, starting a MySQL instance is this following command:
>```docker run --name mysql -e MYSQL_ROOT_PASSWORD=my-secret-pw -d mysql:tag```

Now you can access mysql from the command line like this :
> ``sudo docker exec -it mysql /bin/bash``