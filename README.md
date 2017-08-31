# Test Application


## Install the Application


    php composer.phar update
    php composer.phar dump-autoload

## Change DB credentials in src/settings.php, 'db' section


## Insert FB app credentials in src/settings.php, 'fb_app' section

## Create database and run sql script to create table
    CREATE TABLE `users` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `first_name` varchar(30) DEFAULT NULL,
        `last_name` varchar(30) DEFAULT NULL,
        `created_at` datetime DEFAULT NULL,
        `updated_at` datetime DEFAULT NULL,
        `fb_id` varchar(50) DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8