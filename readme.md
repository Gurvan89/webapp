# Do it yourself Book
Application to manage DIY projects with crochet, sewing or knitting. For me it's a small project to discover the new version of Symfony (5). In this part (webApp), I created APIs to handle new projects (CRUD). I also developed unit tests to test these APIs.
## Main tree
>deploy : some script to create environment
>
>postman : api's example via postman config
>
>src : code source with php7.4 and framework Symfony 5

## Dependencies
This application works with Php 7.4 and Symfony 5. You must also have an apache server and an SQL database.
To do this, you can configure the environment with containers in the docker directory of this repository. 
There are two dockers, one to configure mysql database and another to create php with an apache environment.
Follow readme in each corresponding directory.

## Once all dependencies are running
When everything is ready, you can run **setup_app.sh (diy_book/setup_app.sh**) in docker to create and update database.
You have to execute this script in docker web_app because you need to be in configured environment.

## Postman
You can import postman config in your own postman to have some examples of these APIs