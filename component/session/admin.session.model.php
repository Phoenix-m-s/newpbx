<?php

require_once ROOT_DIR . "common" . DS . "looeic.php";


class adminSessionsModel extends looeic{
    
    protected $TABLE_NAME = 'sessions';
    
    public function deleteExpiredSession($time)
    {

        $conn = dbConn::getConnection();
        $sql = "DELETE FROM " . $this->TABLE_NAME . " WHERE `last_access_time` " . $time;
        $stmt = $conn->prepare ($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result[ 'result' ] = -1;
            return $result;
        }

        $result[ 'result' ] = 1;
        return $result;
    }

}