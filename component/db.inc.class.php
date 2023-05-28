<?php

/**
 * Created by PhpStorm.
 * User: FaridCS
 * Date: 10/28/2014
 * Time: 12:47 PM
 */
class DataBase
{
    protected static $conn;

    public function __construct()
    {
        try {
            self::$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE . "", DB_USER, DB_PASSWORD);
            //self::$conn =  new PDO('mysql:host=localhost;dbname=newpbx;charset=UTF8;', 'root','123456');
            //print_r_debug(self::$conn);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        } catch (PDOException $e) {

           echo "Connection Error: " . $e->getMessage();
        }
    }

    protected static function getConnection()
    {
        //print_r_debug($conn);
        //die($conn = "mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE . "", DB_USER, DB_PASSWORD));
      //die(self::$conn);
        if (!self::$conn) {
            new DataBase();
        }

        self::$conn->exec('SET character_set_database=UTF8');
        self::$conn->exec('SET character_set_client=UTF8');
        self::$conn->exec('SET character_set_connection=UTF8');
        self::$conn->exec('SET character_set_results=UTF8');
        self::$conn->exec('SET character_set_server=UTF8');
        self::$conn->exec('SET names UTF8');
        return self::$conn;
    }

    public function filterBuilder($fields)
    {
        global $lang;

        $limit = '';
        if (isset($fields['limit']['start']) && $fields['limit']['length'] != -1) {
            $limit = " LIMIT " . intval($fields['limit']['start']) . ", " . intval($fields['limit']['length']);
        }

        $order = '';

        if (isset($fields['order']) && count($fields['order'])) {
            $orderBy = array();
            foreach ($fields['order'] as $sort_fields => $dir) {
                if ($dir != 'DESC' and $dir != 'ASC') {
                    continue;
                }

                $orderBy[] = '`' . $sort_fields . '` ' . $dir;
            }

            $order = ' ORDER BY ' . implode(', ', $orderBy);
        }

        $filter = '';
        $flag_trash = 0;

        if (isset($fields['filter'])) {
            foreach ($fields['filter'] as $filter_fields => $searchKey) {
                if (strpos($filter_fields, 'trash') == 'true') {
                    $flag_trash = 1;
                    if ($fields['useTrash'] !== 'false') {
                        $columnSearch[] = "`" . $filter_fields . "` = '" . $searchKey . "'";
                        continue;
                    }
                }

                $columnSearch[] = "`" . $filter_fields . "` LIKE '%" . $searchKey . "%'";
            }
        }

        if (count($columnSearch)) {
            $filter = $filter === '' ?
                implode(' AND ', $columnSearch) :
                $filter . ' AND ' . implode(' AND ', $columnSearch);
        }

        if ($filter !== '') {
            $result['list']['WHERE'] = ' WHERE ';
        }

        $result['result'] = 1;
        $result['list']['filter'] = $filter;
        $result['list']['order'] = $order;
        $result['list']['limit'] = $limit;
        $result['start'] = $fields['limit']['start'];
        $result['length'] = $fields['limit']['length'];

        return $result;

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        if (!$stmt) {
            $res['result'] = -1;
            $res['no'] = 1;
            $res['msg'] = $conn->errorInfo();
            return $res;
        }

        while ($row = $stmt->fetch()) {
            $this->_set_newsListDb($row['newsID'], $row);
        }

        $res['result'] = 1;
        $res['no'] = 2;
        return $res;
    }

    public static function get($table, $index_column, $columns)
    {
        $sql = "SELECT * FROM `required_camp` WHERE 1";

        $rs = self::$conn->query($sql);

        if (!$rs) {
            print_r(self::$conn->errorInfo());
            die();
        }

        $obj = $rs->fetchAll(PDO::FETCH_ASSOC);

        foreach ($obj as $v) {
            $camp[$v['id']]['name'] = $v['name'];
        }

        /*
        | -----------------------------------------------------------------------------------------------
        | Paging
        | -----------------------------------------------------------------------------------------------
        */
        // Paging
        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " . intval($_GET['iDisplayLength']);
        }

        /*
        | -----------------------------------------------------------------------------------------------
        | Ordering
        | -----------------------------------------------------------------------------------------------
        */
        $sOrder = "";
        if (isset($_GET['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sortDir = (strcasecmp($_GET['sSortDir_' . $i], 'ASC') == 0) ? 'ASC' : 'DESC';
                    $sOrder .= "`" . $columns[intval($_GET['iSortCol_' . $i])] . "` " . $sortDir . ", ";
                }
            }

            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }

        /*
        | -----------------------------------------------------------------------------------------------
        | Filtering
        | NOTE this does not match the built-in DataTables filtering which does it
        | word by word on any field. It's possible to do here, but concerned about efficiency
        | on very large tables, and MySQL's regex functionality is very limited
        | -----------------------------------------------------------------------------------------------
        */
        $sWhere = "";
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $sWhere = "WHERE (";
            for ($i = 0; $i < count($columns); $i++) {
                if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true") {
                    $sWhere .= "`" . $columns[$i] . "` LIKE :search OR ";
                }
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        }

        /*
        | -----------------------------------------------------------------------------------------------
        | Individual column filtering
        | -----------------------------------------------------------------------------------------------
        */
        for ($i = 0; $i < count($columns); $i++) {
            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
                if ($sWhere == "") {
                    $sWhere = "WHERE ";
                } else {
                    $sWhere .= " AND ";
                }
                $sWhere .= "`" . $columns[$i] . "` LIKE :search" . $i . " ";
            }
        }

        /*
        | -----------------------------------------------------------------------------------------------
        | SQL queries get data to display
        | -----------------------------------------------------------------------------------------------
        */
        $sQuery = "SELECT SQL_CALC_FOUND_ROWS `" . str_replace(" , ", " ", implode("`, `", $columns)) . "` FROM `" . $table . "` " . $sWhere . " " . $sOrder . " " . $sLimit;
        $statement = self::$conn->prepare($sQuery);

        // Bind parameters
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $statement->bindValue(':search', '%' . $_GET['sSearch'] . '%', PDO::PARAM_STR);
        }
        for ($i = 0; $i < count($columns); $i++) {
            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
                $statement->bindValue(':search' . $i, '%' . $_GET['sSearch_' . $i] . '%', PDO::PARAM_STR);
            }
        }

        $statement->execute();
        $rResult = $statement->fetchAll();

        $iFilteredTotal = current(self::$conn->query('SELECT FOUND_ROWS()')->fetch());

        /*
        | -----------------------------------------------------------------------------------------------
        | Get total number of rows in table
        | -----------------------------------------------------------------------------------------------
        */
        $sQuery = "SELECT COUNT(`" . $index_column . "`) FROM `" . $table . "`";
        $iTotal = current(self::$conn->query($sQuery)->fetch());

        /*
        | -----------------------------------------------------------------------------------------------
        | Output
        | -----------------------------------------------------------------------------------------------
        */
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );

        /*
        | -----------------------------------------------------------------------------------------------
        | Return array of values
        | -----------------------------------------------------------------------------------------------
        */
        foreach ($rResult as $aRow) {
            $row = array();
            for ($i = 0; $i < count($columns); $i++) {
                if ($columns[$i] == "version") {
                    // Special output formatting for 'version' column
                    $row[] = ($aRow[$columns[$i]] == "0") ? '-' : $aRow[$columns[$i]];
                } elseif ($columns[$i] == "id") {
                    /* Special output formatting for 'id' */
                    $id = $aRow[$columns[$i]];
                    $row[] .= '<a data-id="' . $id . '" href="blackList.php?editId=' . $id . '" class="fa fa-pencil fa-2x editIcon" rel="tooltip" data-original-title="' . EDIT_01 . '"></a>' . '<a data-id="' . $id . '" href="blackList.php?deleteId=' . $id . '" class="fa fa-trash fa-2x deleteIcon" rel="tooltip" data-original-title="Delete"></a>';

                } else if ($columns[$i] != ' ') {
                    if ($columns[$i] == 'isblack') {
                        if ($aRow[$columns[$i]] == 't') {
                            $row[] .= ENABLE_01;
                        } elseif ($aRow[$columns[$i]] == 'n') {
                            $row[] .= DISABLED_01;
                        } else {
                            $row[] .= $aRow[$columns[$i]];
                        }
                    } elseif ($columns[$i] == 'camp_id') {

                        $row[] .= $camp[$aRow[$columns[$i]]]['name'];

                    } elseif ($columns[$i] == 'black_list') {

                        if ($aRow[$columns[$i]] == 't') {
                            $row[] .= ENABLE_01;
                        } elseif ($aRow[$columns[$i]] == 'f') {
                            $row[] .= DISABLED_01;
                        } else {
                            $row[] .= $aRow[$columns[$i]];
                        }

                    } else {
                        $row[] .= $aRow[$columns[$i]];
                    }

                }
            }
            $output['aaData'][] = $row;
        }

        echo json_encode($output);
    }

}
