<?php

namespace NgakakSeru\Database;

class HomePage
{
    /*
    * Insert values into the table
    */
    public function loadPost($pdo)
    {
        $command = "select * from post order by post_id desc limit 10";
        $query = $pdo->prepare($command);
        $query->execute();
        $count = $query->rowCount();
        $row  = $query->fetchAll();
        return $row;
    }
}
