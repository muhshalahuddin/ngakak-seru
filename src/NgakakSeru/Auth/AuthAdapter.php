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
        $result = new Result(Result::SUCCESS, 'andy');

        return $result;
    }
}
