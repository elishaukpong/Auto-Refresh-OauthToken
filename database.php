<?php

$databaseConfig = $config['database'];
 
 try{
    $conn = new PDO(
        $databaseConfig['connection'] . ';dbname=' . $databaseConfig['database'],
        $databaseConfig['username'],
        $databaseConfig['password'],
        $databaseConfig['options']
    );

}catch(PDOException $e){

    die($e->getMessage());
    
}


function getAuthTokenFromDB($connection, $table = 'token')
{
    $statement = $connection->prepare("select * from {$table}");

    $statement->execute();
	
    return $statement->fetchAll(PDO::FETCH_CLASS);
}


function insert($connection, $parameters, $table='token')
{
    $sql =	"insert into {$table} (" . implode( ', ', array_keys($parameters)) . ") 
			values (:" . implode( ', :', array_keys($parameters)) . ")";      
    
    try{
        $statement = $connection->prepare($sql);
        $statement->execute($parameters);
    }catch(Exception $e){
        echo $e->getMessage();
        die();
    }

}

function update($connection, $parameters, $table='token')
{
    $sql =	"UPDATE {$table} SET access_token=:access_token, refresh_token=:refresh_token, token_expire_time=:token_expire_time 	WHERE id=1";
    
    try{
        $statement = $connection->prepare($sql);
        $statement->execute($parameters);
    }catch(Exception $e){
        echo $e->getMessage();
        die();
    }

}
