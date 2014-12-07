<?php
namespace NgakakSeru\Database;

class LoginUser
{
    /*
    * Insert values into the table
    */
    public function login($pdo, $user, $pass)
    {
        $command = "SELECT * FROM users where username= '".$user."' AND password = md5('".$pass."')";
        $query = $pdo->prepare($command);
        $query->execute();
        $count = $query->rowCount();
        $row  = $query->fetch();
        if ($count == 1) {
            $_SESSION['user'] = $row;

            return true;
        } else {
            return false;
        }
    }
}
