<?php

/**
 * 
 */
class model_query extends MysqliDb {

    private $com;

    function __construct() {

        parent::__construct($GLOBALS["config"]["host"], $this->d_user(), $this->d_pass(), $GLOBALS["config"]["db_name"],3306);
    }


    /*
     * Get Fieldname from Table
     */

    function get_fieldname($tbl) {
        $name = array();
        $col = $this->pure_query("SHOW COLUMNS FROM $tbl");
        if ($col) {
            while ($row = mysqli_fetch_assoc($col)) {
                $name[] = $row['Field'];
            }
        }

        return$name;
    }

    /*
     * ADD FIELD NAME TO TABLE
     */

    function add_field_name($tbl, $field) {
        $result = $this->pure_query("SHOW COLUMNS FROM $tbl LIKE '$field'");
        $exists = (mysqli_num_rows($result)) ? TRUE : FALSE;
        if (!$exists)
            $this->pure_query("ALTER TABLE $tbl ADD  $field INT(11)  NOT NULL  AFTER nis");
    }

    /*
     * Raw Query 
     */

    function pure_query($sql) {
        $query = $this->queryUnprepared($sql);
        return $query;
    }

    /*
     * Raw Query Return array
     */

    function query_array($sql) {
        $query = $this->queryUnprepared($sql);
        $data = array();
        foreach ($query as $row) {
            $data[] = $row;
        }
        return $data;
    }
    
    /*
     * FUNCTION EXIST /NOT EXIST SELECT * FROM nominal_roll WHERE NOT EXISTS (SELECT pfa_pin FROM staff_enroll WHERE staff_enroll.pfa_pin=nominal_roll.pfa_pin)
     */
    

    /*
     * Insert data into database
     */

    public function insert_data($tbl, $data) {

        return $this->insert($tbl, $data);
    }

    /*
     * Insert Multiple Row into database at once
     */

    public function insert_multi_data($tbl, $data) {
        return $this->insertMulti($tbl, $data);
    }

    /*
     * Update data
     */

    public function update_data($tbl, $data, $where = 'ALL') {
        if ($where != "ALL") {
            foreach ($where as $k => $v) {
                $this->where($k, $v);
            }
        }

        return $this->update($tbl, $data);
    }
    
    

    /*
     * PAGINATION
     */

    function pagination($tbl, $page, $where = null,$op='AND') {
        if ($where != null) {
            if($op==='AND'){
                foreach ($where as $k => $v) {
                    $this->where($k, $v);
                }
            } else {
                foreach ($where as $k => $v) {
                    $this->orwhere($k, $v);
                }
            }
            
        }

        return $this->paginate($tbl, $page, $fields = null);
    }

    /*
     * PAGINATION /JOIN TABLE
     */

    function pagination_join_tbl($tbl, $page, $join_tbl, $where = null) {
        foreach ($join_tbl as $k => $v) {
            $this->join($k, $v, "LEFT");
        }

        if ($where != null) {
            foreach ($where as $k => $v) {
                $this->where($k, $v);
            }
        }

        return $this->paginate($tbl, $page, $fields = null);
    }

    /*
     * Quering data based on date range
     */

    public function fetch_base_on_date($tbl, $date_col, $start, $end, $where = "ALL", $columns = "*") {

        if ($where != "ALL") {
            foreach ($where as $k => $v) {
                $this->where($k, $v);
            }
        }

        $this->where($date_col, Array('BETWEEN' => Array($start, $end)));

        return $this->get($tbl, NULL, $columns);
    }

    /*
     * Delete data from database
     */

    public function delete_data($tbl, $where) {
        foreach ($where as $k => $v) {
            $this->where($k, $v);
        }
        return $this->delete($tbl);
    }

    /*
     * Custom Query
     */

    public function custom_query($sql, $bindParams = null) {

        $query = $this->rawQueryOne($sql, $bindParams);
        return $query;
    }

    /*
     * Get all data from database... Array
     */

    public function fetch_all($tbl, $columns = "*", $numRows = null) {
        return $this->get($tbl, $numRows, $columns);
    }

    /*
     * Get all with condition
     */

    public function fetch_all_cond($tbl, $where, $columns = "*", $numRows = null) {
        foreach ($where as $k => $v) {
            $this->where($k, $v);
        }
        return $this->get($tbl, $numRows, $columns);
    }

    /*
     * Get all with condition OR Statement
     */

    public function fetch_all_cond_or($tbl, $where, $columns = "*", $numRows = null) {
        foreach ($where as $k => $v) {
            $this->orWhere($k, $v);
        }
        return $this->get($tbl, $numRows, $columns);
    }

    /*
     * Select a row from database
     */

    public function get_data($tbl, $where, $columns = "*") {
        foreach ($where as $k => $v) {
            $this->where($k, $v);
        }
        return $this->getOne($tbl, $columns);
    }

    public function get_data_($tbl, $where, $columns = "*") {
        foreach ($where as $k => $v) {
            $this->orwhere($k, $v);
        }
        return $this->getOne($tbl, $columns);
    }

    /*
     * Validate User
     */

    public function validate($tbl, $where) {
        foreach ($where as $k => $v) {
            $this->where($k, $v);
        }
        if ($this->has($tbl)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*
     * Validate User
     */

    public function validate_or($tbl, $where) {
        foreach ($where as $k => $v) {
            $this->orWhere($k, $v);
        }
        if ($this->has($tbl)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*
     * Total Record in database
     */

    public function total($tbl, $cond = null) {
        if ($cond != null) {
            foreach ($cond as $k => $v) {
                $this->where($k, $v);
            }
        }
        $total = $this->getValue($tbl, "count(*)");
        return $total;
//        $stats = $this->getOne($tbl, "sum($col), count(*) as cnt");
//        $total = $stats['cnt'];
    }

    /*
     * Total SPECIFIC COLUMN DISTINCT   SELECT COUNT(DISTINCT reference_id ) FROM `staff_doc` 
     */

    function custom_total($tbl, $col, $cond) {
        $data = $this->custom_query("SELECT COUNT($col ) AS cnt FROM  $tbl WHERE $cond");
        return $data['cnt'];
    }

    /*
     * Join table
     */

    public function join_table($tbl, $join_tbl, $columns = "*", $where = "ALL") {

        foreach ($join_tbl as $k => $v) {
            $this->join($k, $v, "LEFT");
        }

        if ($where != "ALL") {
            foreach ($where as $k => $v) {
                $this->where($k, $v);
            }
        }

        return $this->get($tbl, NULL, $columns);
    }

    function d_user() {
        $u = $this->ssl('de', $GLOBALS["config"]["user"]);
        return $u;
    }

    function d_pass() {
        $p = $this->ssl('de', $GLOBALS["config"]["pass"]);
        return$p;
    }

}

?>