<?php

class nominal extends controller {

    var $table;

    function __construct() {
        parent::__construct();
        $this->table = 'nominal_roll';
        $this->db->pageLimit = 10;
    }

    function show_employee_record() {

        $option = url::post('option');
        $search = url::post('search');

        //New Array
        $data = array();
        $display = '';
        $header = $this->db->get_fieldname($this->table);

        $page = 1;
        if (!empty($_GET["page"])) {
            $page = $_GET["page"];
        }

        $this->db->orderBy('ippis_no', 'ASC');
        switch ($option) {
            case'search':
                $cmd = $this->db->get_data_($this->table, array('ippis_no' => $search, 'full_name' => $search));
                $data = $this->db->pagination($this->table, $page, array('ippis_no' => $search, 'full_name' => $search), 'OR');
                $show_page_num = new paginate($this->table, array('ippis_no' => $cmd['ippis_no']));
                $paginate = $show_page_num->get_paginate();
                break;
            default :
                $data = $this->db->pagination($this->table, $page); //("SELECT $col FROM $cmd LIMIT $offset,$pagelimit");
                $show_page_num = new paginate($this->table);
                $paginate = $show_page_num->get_paginate();
        }

        $display = '<div class="table-responsive"><table class="list nowrap" width="100%"  ><thead><tr>';

        for ($i = 0; $i < count($header); $i++) {
            $display .= '<th class="bold p-2">' . ucwords(str_replace('_', " ", $header[$i])) . '</th>';
        }
        $display .= '</thead></tr>';


        foreach ($data as $value) {
            $display .= '<tr>';
            for ($i = 0; $i < count($header); $i++) {
                $val = ($header[$i] === 'staff_id') ? '<td><a class="preview" data-id="' . $value[$header[$i]] . '">' . $value[$header[$i]] . '</a></td>' : '<td>' . $value[$header[$i]] . '</td>';
                $display .= $val;
            }
            $display .= '</tr>';
        }

        $display .= ' </table> </div>';
        $display .= isset($paginate) ? $paginate : "";

        return $display;
    }

    function get_nominal_data($id) {
        $data = $this->db->get_data_('nominal_roll', array('ippis_no' => $id, 'full_name' => $id));
        return$data;
    }

    function populate_field($col) {
        $output = '';
        $this->db->orderBy($col, "asc");
        $data = $this->db->query_array("SELECT DISTINCT $col FROM nominal_roll");
      $output = '<option>--Select New Mda--</option>';
        foreach ($data as $value) {
            $output .= '<option value="' . strtoupper($value[$col]) . '">' . strtoupper($value[$col]) . '</option>';
        }
        echo $output;
    }

   
}
