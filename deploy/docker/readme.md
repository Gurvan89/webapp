# Create container with php 7.4 and Apache called web_app
To create this container we will use dockerfile.
To start we will create an image by running buildApp.sh:
> ``./buildApp.sh``

After that, we can run image previously build with the script run.sh:
>```./run.sh```

Now you can access to this docker with the script command_line.sh:
> ``./command_line.sh``

When the docker is running you can execute php or composer command inside.

You can stop, start or restart this docker with this following command:
>`` sudo docker start/stop/restart web_app``