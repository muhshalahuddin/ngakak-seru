<?php

namespace NgakakSeru\Auth;

use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result;

class AuthAdapter extends AbstractAdapter
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function authenticate()
    {
        $statement = $this->pdo->prepare('SELECT password FROM users WHERE username = :username');
        $statement->bindValue('username', $this->getIdentity());
        $statement->execute();

        $row = $statement->fetch();

        if ($row === false) {
            $result = new Result(Result::FAILURE_IDENTITY_NOT_FOUND, $this->getIdentity());
        } elseif ($row['password'] !== md5($this->getCredential())) {
            $result = new Result(Result::FAILURE_CREDENTIAL_INVALID, $this->getIdentity());
        } elseif ($row['password'] === md5($this->getCredential())) {
            $result = new Result(Result::SUCCESS, $this->getIdentity());
        } else {
            $result = new Result(Result::FAILURE, $this->getIdentity());
        }

        return $result;
    }
}
