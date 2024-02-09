# Crud places
To start the project, make sure you have Docker installed on the machine.
After configuring your Docker, access the project folder in the root.


# commands

Open the terminal at the root of the project, and run the following commands
docker-compose build
docker-compose up -d

After that it will download all the images necessary to run the project,
now configure the .ev file with the bank credentials


After all necessary configuration, access the App container and run some commands

# commands commands  before you inside the container
docker-compose exec app bash  

# commands commands inside the container

composer install
php artisan migrate

# If you have any permission errors, run these commands
cat storage/logs/laravel.log
chmod -R 755 storage bootstrap

If everything goes well, the application will be served on port 8989 on your host for exemple
http://127.0.0.1:8989/

