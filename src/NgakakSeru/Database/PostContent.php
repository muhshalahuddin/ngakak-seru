<?php

namespace NgakakSeru\Database;

class PostContent
{
    /*
    * Insert values into the table
    */

    public function insert($pdo, $rows)
    {
        $command = 'INSERT INTO post';
        $row = null;
        $value = null;
        foreach ($rows as $key => $nilainya) {
            $row  .= ",".$key;
            $value .= ", :".$key;
        }

        $command .= "(".substr($row, 1).")";
        $command .= "VALUES(".substr($value, 1).")";

        $stmt =  $pdo->prepare($command);
        $stmt->execute($rows);
        $rowcount = $stmt->rowCount();

        if ($rowcount == 1) {
            return true;
        } else {
            return false;
        }
    }
}
