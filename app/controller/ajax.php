<?php

class ajax extends controller {

    function __construct() {
        parent::__construct();
    }

    /**     * ******************************************************
     * CHECK LOGIN CRE
     * *********************************************************
     */
    function check_login() {
        $data = functions::get_post();
        $data['password'] = sha1($data['password']);
        $chk = new auth($data);
        $user = $chk->auth_user_cre();
        echo $user;
    }

    /* ---------------------------------------------------------
     * DISPLAY DASHBOARD INFORMATION
     * *********************************************************
     */

    function dashboard_data() {
        $pst = new class_posting();
        echo $pst->dashboard();
    }

    /* ---------------------------------------------------------
     * DISPLAY EMPLOYEE INFORMATION BASED ON REF NO
     * *********************************************************
     */

    function ref_data() {
        $pst = new class_posting();
        $id = url::post('ref_no');
        $date = url::post('p_date');
        echo $pst->ref_no_data($id, $date);
    }

    /* ---------------------------------------------------------
     * DISPLAY EMPLOYEE DATA
     * *********************************************************
     */

    function employee_data() {
        $emp = new nominal();
        echo $emp->show_employee_record();
    }

    /* --------------------------------------------------------
     * Employee Posting Record
     * *********************************************************
     */

    function employee_posting_data() {
        $pst = new class_posting();
        echo $pst->employee_posting_record();
    }

    /* --------------------------------------------------------
     * Employee Posting History
     * *********************************************************
     */

    function employee_posting_history() {
        $pst = new class_posting();
        echo $pst->get_employee_posting_history();
    }

    /* --------------------------------------------------------
     * Upload csv file
     * *********************************************************
     */

    function upload_file() {
        $rec = url::post('record');
        $tbl = str_replace(' ', '_', strtolower($rec));
        functions::upload_csv_file($tbl);
    }

    /* --------------------------------------------------------
     * Employee info for processing Posting
     * *********************************************************
     */

    function posting_process_data() {
        $pst = new class_posting();
        $id = url::post('id');
        $msg['info'] = $pst->employee_info($id);
        $msg['history'] = $pst->brief_posting_history($id);
        $msg['from'] = $pst->posting_from($id);

        echo json_encode($msg);
    }

    /* --------------------------------------------------------
     * Add Employee Posting request
     * *********************************************************
     */

    function add_employee_posting() {
        $pst = new class_posting();
        $data = functions::get_post();
        $msg = $pst->add_posting($data);
        echo $msg;
    }

    /* --------------------------------------------------------
     * FINAL Submission  Employee Posting request
     * *********************************************************
     */

    function final_submit_employee_posting() {
        $pst = new class_posting();
        $data = functions::get_post();
        $msg = $pst->submit_posting($data);
        echo $msg;
    }

    /* --------------------------------------------------------
     * Populate MdA
     * *********************************************************
     */

    function populate_data() {
        $emp = new nominal();
        $col = url::post('name');
        $res = $emp->populate_field($col);
        echo $res;
    }

    /* --------------------------------------------------------
     * Populate MdA, rank, sgl etc
     * *********************************************************
     */

    function get_sgl_rank() {
        $emp = new nominal();
        $id = url::post('id');
        $res = $emp->get_nominal_data($id);
        echo json_encode($res);
    }

    /* --------------------------------------------------------
     * Get staff to vice in selected mda based on sgl and rank
     * *********************************************************
     */

    function staff_vice() {

        $emp = new class_posting();
        $res = $emp->get_staff_vice();
        echo $res;
//      
    }

    /* --------------------------------------------------------
     * Lookup staff to vice
     * *********************************************************
     */

    function lookup_staff_vice() {
        $emp = new class_posting();
        $id = url::post('search');
        $res = $emp->search_staff_vice($id);
        echo $res;
    }

    /* --------------------------------------------------------
     * Get Emloyee data for Staff to vice
     * *********************************************************
     */

    function staff_to_vice_detail() {
        $pst = new class_posting();
        $id = url::post('ippis_no');
        $msg = $pst->employee_info($id);
        echo $msg;
    }
    
     /* --------------------------------------------------------
     * Posting Proposal data
     * *********************************************************
     */

    function posting_proposal() {
        $pst = new class_posting();
        $msg = $pst->show_posting_proposal();
        echo $msg;
    }

    /* --------------------------------------------------------
     * Show Report
     * *********************************************************
     */

    function show_report() {
        $pst = new class_posting();
        $msg = $pst->get_posting_ref();
        echo $msg;
    }

    /* --------------------------------------------------------
     * Process Posting Report
     * *********************************************************
     */

    function redirect_posting_report() {
        $refno = url::post('ref_no');
        $date = url::post('date');
    }
    /* --------------------------------------------------------
     * Generate  Proposed Posting 
     * *********************************************************
     */
    function generate_propose_posting() {

        $data = $this->db->query_array("SELECT sno, ippis_no,full_name,rank,sgl,previous_mda,present_mda,department,remark,cadre FROM temp_data ORDER BY sno ASC");
        $field = array('sno','ippis_no', 'full_name', 'rank', 'sgl', 'previous_mda', 'present_mda','department', 'remark','cadre');
        foreach ($field as $value) {
            switch ($value) {
                case'previous_mda':
                    $value = 'present_mda';
                    break;
                case'present_mda':
                    $value = 'approved_mda';
                    break;
            }
            $val = strtoupper(str_replace('_', " ", $value));
            $header[$val] = 'string';
        }
        $name = 'Posting Report';

        if ($data) {
            functions::download_excel($data, $header, $name);
        } else {
            echo'no data';
        }
    }

    /* --------------------------------------------------------
     * Generate Posting Report
     * *********************************************************
     */

    function generate_posting_report() {

        $data = $this->db->query_array("SELECT sno, ippis_no,full_name,rank,sgl,previous_mda,present_mda,department,cadre,remark FROM posting_data WHERE posting_date >= CURDATE()");
                $field = array('sno','ippis_no', 'full_name', 'rank', 'sgl', 'previous_mda', 'present_mda','department', 'remark','cadre');

        foreach ($field as $value) {
            switch ($value) {
                case'previous_mda':
                    $value = 'present_mda';
                    break;
                case'present_mda':
                    $value = 'approved_mda';
                    break;
            }
            $val = strtoupper(str_replace('_', " ", $value));
            $header[$val] = 'string';
        }
        $name = 'Posting Report';

        if ($data) {
            functions::download_excel($data, $header, $name);
        } else {
            echo'no data';
        }
    }

    function download_repot_url() {
        $ref_no = url::post('ref_no');
        $date = url::post('dates');
        echo "/ajax/download_report?ref_no=$ref_no&dates=$date";
    }

    /* --------------------------------------------------------
     * Generate Posting Report
     * *********************************************************
     */

    function download_report() {
        $where['ref_no'] = url::get('ref_no');
        $where['posting_date'] = url::get('dates');
        $this->db->orderBy('sno','ASC');
        $data = $this->db->fetch_all_cond("posting_data", $where, array('sno','ippis_no', 'full_name', 'rank', 'sgl', 'previous_mda', 'present_mda','department', 'remark','cadre'));
        $field = array('sno','ippis_no', 'full_name', 'rank', 'sgl', 'previous_mda', 'present_mda','department', 'remark','cadre');
        foreach ($field as $value) {
            switch ($value) {
                case'previous_mda':
                    $value = 'present_mda';
                    break;
                case'present_mda':
                    $value = 'approved_mda';
                    break;
            }
            $val = strtoupper(str_replace('_', " ", $value));
            $header[$val] = 'string';
        }
        $name = 'Report';

        if ($data) {
            functions::download_excel($data, $header, $name);
        } else {
            echo'no data';
        }
    }

    /* ---------------------------------------------
     * TYPEAHEAD ...AUTO DROPDOWN
     * --------------------------------------------
     */

    function typeahead_all() {

        $res = array();
        $id = url::post('query');
        $name = url::post('name');

        switch ($name) {
            case 'nominal':
                $data = $this->db->query_array("SELECT DISTINCT ippis_no,full_name FROM nominal_roll WHERE ippis_no LIKE'%" . $id . "%' OR full_name LIKE'%" . $id . "%' LIMIT 10");
                break;
            case 'posting':
                $data = $this->db->query_array("SELECT DISTINCT ippis_no,full_name,ref_no FROM posting_data WHERE ippis_no LIKE'%" . $id . "%' OR full_name LIKE'%" . $id . "%' OR ref_no LIKE'%" . $id . "%' LIMIT 10");
                break;
            case 'proposal':
                $data = $this->db->query_array("SELECT DISTINCT ippis_no,full_name,ref_no FROM temp_data WHERE ippis_no LIKE'%" . $id . "%' OR full_name LIKE'%" . $id . "%' OR ref_no LIKE'%" . $id . "%' LIMIT 10");
                break;
            case 'report':
                $data = $this->db->query_array("SELECT DISTINCT ref_no FROM posting_data WHERE  ref_no LIKE'%" . $id . "%' LIMIT 10");
                break;
            case 'mda':
                $data = $this->db->query_array("SELECT DISTINCT mda_name FROM nominal_roll WHERE  mda_name LIKE'%" . $id . "%' LIMIT 10");
                break;
        }

        foreach ($data as $value) {
            foreach ($value as $v) {
                $res[] = $v;
            }
        }

        echo json_encode($res);
    }
    
    function delete_staff(){
        $ippis= url::post('ippis');
        $delete= $this->db->delete_data('temp_data',array('ippis_no'=>$ippis));
        if($delete){
            echo'Data Delete Successful';
        } else {
             echo'No Data Found';
        }
    }
    
    

    function test() {
        $dob = "19-07-1962"; //existing date
        $dofa = "01-03-1994";
        echo date('d-m-Y', strtotime($dob . '+60 years')) . '<br>';
        echo date('d-m-Y', strtotime($dofa . '+35 years'));

        $dates = array('1962-07-19', '1994-03-01');
        echo "Latest Date: " . max($dates) . "\n";
        echo "Earliest Date: " . min($dates) . "\n";
    }

}

?>