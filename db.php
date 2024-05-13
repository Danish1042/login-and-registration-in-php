<?php
define("HOSTNAME", "localhost");
define("USERNAME", "root");
define("PASSWORD", "");
define("DATABASE", "login_system_php");

$connection = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);

if(!$connection){
    die("Connection Failed");
}

$table = "CREATE TABLE IF NOT EXISTS `login_system_php`.`users` (`id` INT(11) NOT NULL AUTO_INCREMENT , `name` VARCHAR(255) NOT NULL , `email` VARCHAR(255) NOT NULL , `password` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";

if(!$connection->query($table)){
    echo "Table creation failed: (" . $connection->errno . ") " . $connection->error;
}
?>