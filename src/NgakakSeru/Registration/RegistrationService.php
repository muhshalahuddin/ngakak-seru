<?php

namespace NgakakSeru\Registration;

class RegistrationService
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function register(array $data)
    {
        $sql = 'INSERT INTO users(username, password, email, created)
                    VALUES(:username, :password, :email, :created)';

        $now = new \DateTime();

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue('username', $data['username']);
        $statement->bindValue('password', md5($data['password']));
        $statement->bindValue('email', $data['email']);
        $statement->bindValue('created', $now->format('Y-m-d H:i:s'));

        $statement->execute();
    }
}
