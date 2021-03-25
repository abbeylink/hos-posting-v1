<?php

class class_posting extends controller {

    var $table;

    function __construct() {
        parent::__construct();
        $this->table = 'posting_data';
        $this->db->pageLimit = 10;
    }

    function employee_posting_record() {

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

        $this->db->orderBy('posting_date', 'DESC');
        switch ($option) {
            case'search':
                $cmd = $this->db->get_data_($this->table, array('ippis_no' => $search, 'ref_no' => $search, 'full_name' => $search));
                $data = $this->db->pagination($this->table, $page, array($header[0] => $search, $header[1] => $search, $header[2] => $search), 'OR');
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
            $col = $header[$i];
            if ($header[$i] === 'posting_date') {
                $col = 'last_posting_date';
            }
            $display .= '<th class="bold p-2">' . ucfirst(str_replace('_', " ", $col)) . '</th>';
        }
        $display .= '</thead></tr>';

        foreach ($data as $value) {
            $display .= '<tr>';
            for ($i = 0; $i < count($header); $i++) {
                switch ($header[$i]) {
                    case'ippis_no':
                        $val = '<td><a data-toggle="tooltip" title="View Staff Posting History"  style="cursor:pointer;color:blue" class="view_history" data-id="' . $value[$header[$i]] . '">' . $value[$header[$i]] . '</a></td>';
                        break;
                    case'posting_date':
                    case'effective_date':
                        $v = functions::date_format($value[$header[$i]]);
                        $val = '<td>' . $v . '</td>';
                        break;
                    default :
                        $val = '<td>' . $value[$header[$i]] . '</td>';
                }

                $display .= $val;
            }
            $display .= '</tr>';
        }

        $display .= ' </table> </div>';
        $display .= isset($paginate) ? $paginate : "";

        return $display;
    }

    //Retrieve employee information from nominal roll
    function employee_info($id) {
        $data = $this->db->get_data_('nominal_roll', array('ippis_no' => $id, 'full_name' => $id));
        $fields = array('ippis_no', 'full_name', 'sex', 'dob', 'dofa', 'dopa', 'department', 'phone');

        $output = '';
        $output = '<div class="table-responsive"><table class="table list nowrap dis_rec"  width="100%">';
        $output .= '<tr>';
        for ($i = 0; $i < count($fields); $i++) {
            $k = $fields[$i];
            $col = ucwords(str_replace('_', " ", $k));
            $val = $data[$fields[$i]];

            if ($i % 2 === 0) {
                $output .= "</tr><tr>";
            }
            switch ($k) {
                case'ippis_no':
                    $output .= ' <td  colspan="5" class="text-dark "><strong> ' . $col . '    :</strong></td><td  class="text-dark get_ippis" data-id="' . $val . '"> ' . $val . ' </td>';
                    break;
                default :
                    $output .= ' <td  colspan="5" class="text-dark "><strong> ' . $col . '    :</strong></td><td  class="text-dark " > ' . $val . ' </td>';
            }
        }
        $output .= '</tr>';
        $output .= '</table></div>';

        return $output;
    }

    //Get last 3 posting histry of employee
    function brief_posting_history($id) {
        $display = '';
        $fields = array('ref_no', 'posting_date', 'previous_mda', 'present_mda', 'remark');

        $data = $this->db->fetch_all_cond_or('posting_history', array('ippis_no' => $id, 'full_name' => $id), $fields, 3);
        $this->db->orderBy('posting_date', 'DESC');
        $display = '<div class="table-responsive"><table class="list nowrap" width="100%"  ><thead><tr>';

        for ($i = 0; $i < count($fields); $i++) {
            $col = $fields[$i];
            if ($fields[$i] === 'posting_date') {
                $col = 'last_posting_date';
            }
            $display .= '<th class="bold p-2">' . ucfirst(str_replace('_', " ", $col)) . '</th>';
        }
        $display .= '</thead></tr>';

        foreach ($data as $value) {
            $display .= '<tr>';
            for ($i = 0; $i < count($fields); $i++) {
                switch ($fields[$i]) {
                    case'posting_date':
                        $val = functions::date_format($value[$fields[$i]]);
                        break;
                    default :
                        $val = $value[$fields[$i]];
                }
                $display .= '<td>' . $val . '</td>';
                ;
            }
            $display .= '</tr>';
        }

        $display .= ' </table> </div>';

        return $display;
    }

    //get employee present mda
    function posting_from($id) {
        $nom = new nominal();
        $chk_postn_tbl = $this->db->validate_or('posting_data', array('ippis_no' => $id, 'full_name' => $id));
        if ($chk_postn_tbl) {
            $data = $this->db->get_data_('posting_data', array('ippis_no' => $id, 'full_name' => $id));
            $loc = $nom->get_nominal_data($id);
            $data['mda_location'] = $loc['mda_location'];
            $fields = array('present_mda', 'mda_location', 'rank', 'sgl', 'remark', 'posting_date', 'effective_date', 'status');
        } else {
            $data = $nom->get_nominal_data($id);
            $fields = array('mda_name', 'mda_location', 'rank', 'sgl', 'remark', 'posting_date', 'effective_date', 'status');
        }
        $fields[8] = 'retirement_due_date';
        $data['retirement_due_date'] = $this->retirement_date($data['dob'], $data['dofa']);


        $output = '';
        $output = '<div class="table-responsive"><table class="table list nowrap dis_rec"  width="100%">';
        $output .= '<tr>';
        for ($i = 0; $i < count($fields); $i++) {
            $k = ($fields[$i] === 'posting_date') ? "last_posting_date" : $fields[$i];
            $col = ucwords(str_replace('_', " ", $k));
            $val = $data[$fields[$i]];

            if ($i % 2 === 0) {
                $output .= "</tr><tr>";
            }
            switch ($k) {
                case'ippis_no':
                    $output .= ' <td  colspan="5" class="text-dark "><strong> ' . $col . '    :</strong></td><td  class="text-dark get_ippis" data-id="' . $val . '"> ' . $val . ' </td>';
                    break;
                case'present_mda':
                case'mda_name':
                    $output .= ' <td  colspan="5" class="text-dark "><strong> ' . $col . '    :</strong></td><td  class="text-dark "><textarea class="form-control previous_mda" >' . $val . '</textarea>  </td>';

                    break;
                case'last_posting_date':
                case'effective_date':
                    $dat = isset($val) ? functions::date_format($val) : 'No Date Yet';
                    $output .= ' <td  colspan="5" class="text-dark " ><strong style="color:red"> ' . $col . '    :</strong></td><td  class="text-dark " > ' . $dat . ' </td>';
                    break;

                default :
                    $output .= ' <td  colspan="5" class="text-dark "><strong> ' . $col . '    :</strong></td><td  class="text-dark " > ' . $val . ' </td>';
            }
        }
        $output .= '</tr>';
        $output .= '</table></div>';

        return $output;
    }

    function add_posting($data) {
        $msg = '';
        $chk_postn_tbl = $this->db->validate('posting_data', array('ippis_no' => $data['ippis_no']));
        if ($chk_postn_tbl) {
            $user = $this->db->get_data('posting_data', array('ippis_no' => $data['ippis_no']));
            // $prev_mda = $user['present_mda'];
        } else {
            $user = $this->db->get_data('nominal_roll', array('ippis_no' => $data['ippis_no']));
            // $prev_mda = $user['mda_name'];
        }

        $data['status'] = 'Not Resume';
        $data['full_name'] = $user['full_name'];

        //Check for update
        $upd = $this->db->validate('temp_data', array('ippis_no' => $data['ippis_no']));

        if ($upd) {
            $this->db->update_data("temp_data", $data, array('ippis_no' => $data['ippis_no']));
            $msg = ($this->db->count > 0) ? "Records were updated successful" : "No update occur";
        } else {
            $save_data = $this->db->insert_data('temp_data', $data);
            if ($save_data) {
                $this->db->commit();
                $msg = 'Posting has been Added';
            } else {
                $msg = "Insert Failed-Reason:" . $this->db->getLastError();
            }
        }

        // if ($prev_mda !== $data['present_mda']) {
//        } else {
//            $msg = 'Please Check Mda- Present Mda and Previous Mda can not be same';
//        }
        return $msg;
    }

    function submit_posting($data) {

        $record = array();

        $added_pst = $this->db->fetch_all('temp_data');
        if ($added_pst) {
            foreach ($added_pst as $value) {
                foreach ($value as $k => $v) {
                    $rec[$k] = $v;
                    $rec['effective_date'] = $data['effective_date'];
                    $rec['ref_no'] = $data['ref_no'];
                    $rec['posting_date'] = $this->db->now();
                }
                $record[] = $rec;
            }

            $save_data = $this->db->insert_multi_data('posting_data', $record);
            if ($save_data) {
                $this->db->commit();
                $this->db->insert_multi_data('posting_history', $record);
                $this->db->query('TRUNCATE TABLE temp_data');
                //$this->db->delete('temp_data');
                $msg = 'Posting has been Processed';
            } else {
                $msg = "Insert Failed-Reason:" . $this->db->getLastError();
            }
        } else {
            $msg = 'No Posting data found ';
        }
        return $msg;
    }

    //DASHBOARD
    function dashboard() {
        $display = '';
        $fields = array('ref_no', 'posting_date');
        $data = $this->db->query_array('SELECT DISTINCT ref_no,posting_date FROM posting_data ORDER BY posting_date DESC LIMIT 10 ');
        $display = '<div class="table-responsive"><table class="list nowrap" width="100%"  ><thead><tr>';

        for ($i = 0; $i < count($fields); $i++) {
            $col = $fields[$i];
            if ($fields[$i] === 'posting_date') {
                $col = 'last_posting_date';
            }
            $display .= '<th class="bold p-2">' . ucfirst(str_replace('_', " ", $col)) . '</th>';
        }
        $display .= '</thead></tr>';

        foreach ($data as $value) {
            $display .= '<tr>';
            for ($i = 0; $i < count($fields); $i++) {
                switch ($fields[$i]) {
                    case'ref_no':
                        $val = '<td style="cursor:pointer" class="get_ref_no" data-id="' . $value['ref_no'] . '" data-id1="' . $value['posting_date'] . '"> ' . $value['ref_no'] . ' </td>';
                        break;
                    default :
                        $v = functions::date_format($value['posting_date']);
                        $val = '<td> ' . $v . ' </td>';
                }
                $display .= $val;
            }
            $display .= '</tr>';
        }

        $display .= ' </table> </div>';
        //print_r($data);
        return $display;
    }

    function ref_no_data($ref, $date) {
        $display = '';
        $fields = array('ippis_no', 'full_name', 'rank', 'sgl', 'posting_date', 'present_mda', 'remark');

        $data = $this->db->fetch_all_cond('posting_data', array('ref_no' => $ref, 'posting_date' => $date));
        $this->db->orderBy('posting_date', 'DESC');
        $display = '<div class="table-responsive"><table class="list nowrap" width="100%"  ><thead><tr>';

        for ($i = 0; $i < count($fields); $i++) {
            $col = $fields[$i];
            if ($fields[$i] === 'posting_date') {
                $col = 'last_posting_date';
            }
            $display .= '<th class="bold p-2">' . ucfirst(str_replace('_', " ", $col)) . '</th>';
            // $display .= '<th class="bold p-2">' . strtoupper(str_replace('_', " ", $fields[$i])) . '</th>';
        }
        $display .= '</thead></tr>';

        foreach ($data as $value) {
            $display .= '<tr>';
            for ($i = 0; $i < count($fields); $i++) {
                switch ($fields[$i]) {
                    case'posting_date':
                        $val = functions::date_format($value[$fields[$i]]);
                        break;
                    default :
                        $val = $value[$fields[$i]];
                }
                $display .= '<td>' . $val . '</td>';
                ;
            }
            $display .= '</tr>';
        }

        $display .= ' </table> </div>';

        return $display;
    }

    //Get staff to vice in selected mda based on sgl and rank
    function get_staff_vice() {
       // $mda = url::post('mda');
        $sgl = url::post('sgl');
        $rank = url::post('rank');
        $display = '';
        $header = array('ippis_no', 'full_name', 'rank', 'sgl');
        $option = url::post('option');
        $search = url::post('search');
        $page = 1;
        if (!empty($_GET["page"])) {
            $page = $_GET["page"];
        }

        $this->db->orderBy('full_name', 'ASC');
        switch ($option) {
            case'search':
                $cmd = $this->db->get_data_('nominal_roll', array('ippis_no' => $search, 'full_name' => $search));
                $data = $this->db->pagination('nominal_roll', $page, array('ippis_no' => $search, 'full_name' => $search), 'OR');
                $show_page_num = new paginate('nominal_roll', array('ippis_no' => $cmd['ippis_no']));
                $paginate = $show_page_num->get_paginate();
                break;
            default :
                $data = $this->db->pagination('nominal_roll', $page,array('sgl' => $sgl, 'rank' => $rank)); //("SELECT $col FROM $cmd LIMIT $offset,$pagelimit");
                $show_page_num = new paginate('nominal_roll',array('sgl' => $sgl, 'rank' => $rank));
                $paginate = $show_page_num->get_paginate();
        }

               
       // $data = $this->db->fetch_all_cond('nominal_roll', array('sgl' => $sgl, 'rank' => $rank)); //'mda_name' => $mda,

        $display = '<div class="card card-body"><div class="table-responsive"><table class="list nowrap" width="100%"  ><thead><tr>';

        for ($i = 0; $i < count($header); $i++) {
            $display .= '<th class="bold p-2">' . ucfirst(str_replace('_', " ", $header[$i])) . '</th>';
        }
        $display .= '</thead></tr>';

        foreach ($data as $value) {
            $display .= '<tr>';
            for ($i = 0; $i < count($header); $i++) {
                switch ($header[$i]) {
                    case'ippis_no':
                        $val = '<td><a data-toggle="tooltip" title="Click to continue Process"  style="cursor:pointer;color:blue" class="get_data" data-id="' . $value[$header[$i]] . '" data-id1="' . $value['full_name'] . '">' . $value[$header[$i]] . '</a></td>';
                        break;

                    default :
                        $val = '<td>' . $value[$header[$i]] . '</td>';
                }
                $display .= $val;
            }
            $display .= '</tr>';
        }

        $display .= ' </table> </div>';
         $display .= isset($paginate) ? $paginate : "";
        $display .= '</div>';
       
        return $display;
    }

    //Get data for each staff to vice 
    function search_staff_vice($id) {
//   
        $display = '';
        $header = array('ippis_no', 'full_name', 'rank', 'sgl');

        $this->db->orderBy('full_name', 'ASC');
        $data = $this->db->fetch_all_cond_or('nominal_roll', array('ippis_no' => $id, 'full_name' => $id), array('ippis_no', 'full_name', 'rank', 'sgl'));

        $display = '<div class="card card-body"><div class="table-responsive"><table class="list nowrap" width="100%"  ><thead><tr>';

        for ($i = 0; $i < count($header); $i++) {
            $display .= '<th class="bold p-2">' . ucfirst(str_replace('_', " ", $header[$i])) . '</th>';
        }
        $display .= '</thead></tr>';

        foreach ($data as $value) {
            $display .= '<tr>';
            for ($i = 0; $i < count($header); $i++) {
                $val = ($header[$i] === 'ippis_no') ? '<td><a data-toggle="tooltip" title="Click to continue Process"  style="cursor:pointer;color:blue" class="get_data" data-id="' . $value[$header[$i]] . '">' . $value[$header[$i]] . '</a></td>' : '<td>' . $value[$header[$i]] . '</td>';
                $display .= $val;
            }
            $display .= '</tr>';
        }

        $display .= ' </table> </div>';
        $display .= '</div>';
        return $display;
    }

    //Employee posting History
    function get_employee_posting_history() {

        $option = url::post('option');
        $search = url::post('search');
        $id = url::get('ippis_no');

        //New Array
        $data = array();
        $display = '';
        $header = $this->db->get_fieldname($this->table);

        $page = 1;
        if (!empty($_GET["page"])) {
            $page = $_GET["page"];
        }

        $this->db->orderBy('posting_date', 'DESC');
        switch ($option) {
            case'search':
                $cmd = $this->db->get_data_('posting_history', array('ippis_no' => $search, 'full_name' => $search));
                $data = $this->db->pagination('posting_history', $page, array($header[1] => $search, $header[2] => $search), 'OR');
                $show_page_num = new paginate('posting_history', array('ippis_no' => $cmd['ippis_no']));
                $paginate = $show_page_num->get_paginate();
                break;
            default :
                $data = $this->db->pagination('posting_history', $page, array('ippis_no' => $id)); //("SELECT $col FROM $cmd LIMIT $offset,$pagelimit");
                $show_page_num = new paginate('posting_history', array('ippis_no' => $id));
                $paginate = $show_page_num->get_paginate();
        }

        $display = '<div class="table-responsive"><table class="list nowrap" width="100%"  ><thead><tr>';

        for ($i = 0; $i < count($header); $i++) {
            $col = $header[$i];
            if ($header[$i] === 'posting_date') {
                $col = 'last_posting_date';
            }
            $display .= '<th class="bold p-2">' . ucfirst(str_replace('_', " ", $col)) . '</th>';
        }
        $display .= '</thead></tr>';

        foreach ($data as $value) {
            $display .= '<tr>';
            for ($i = 0; $i < count($header); $i++) {
                switch ($header[$i]) {
                    case'posting_date':
                    case'effective_date':
                        $v = functions::date_format($value[$header[$i]]);
                        $val = '<td>' . $v . '</td>';
                        break;
                    default :
                        $val = '<td>' . $value[$header[$i]] . '</td>';
                }

                $display .= $val;
            }
            $display .= '</tr>';
        }

        $display .= ' </table> </div>';
        $display .= isset($paginate) ? $paginate : "";

        return $display;
    }

    //Generate POsti Report

    function get_posting_ref() {

        $rec_limit = 10;
        $option = url::post('option');
        $search = url::post('search');

        //New Array
        $data = array();
        $display = '';
        $header = array('ref_no', 'posting_date', '');

        $page = 1;
        if (!empty($_GET["page"])) {
            $page = $_GET["page"];
        }
        $offset = $rec_limit * ($page - 1);

        $this->db->orderBy('posting_date', 'DESC');
        switch ($option) {
            case'search':
                $data = $this->db->query_array(" SELECT DISTINCT ref_no,posting_date FROM posting_data WHERE ref_no='$search'  LIMIT $offset, $rec_limit ");
                $show_page_num = new paginate('posting_data', array($header[0] => $search));
                $paginate = $show_page_num->get_paginate();
                break;
            default :

                // $data = $this->db->pagination('posting_data', $page);
                $data = $this->db->query_array(" SELECT DISTINCT ref_no,posting_date FROM posting_data ORDER BY posting_date DESC LIMIT $offset, $rec_limit ");
                $show_page_num = new paginate('posting_data');
                $paginate = $show_page_num->get_paginate();
        }

        $display = '<div class="table-responsive"><table class="list nowrap" width="100%"  ><thead><tr>';

        for ($i = 0; $i < count($header); $i++) {
            $col = $header[$i];
            if ($header[$i] === 'posting_date') {
                $col = 'last_posting_date';
            }
            $display .= '<th class="bold p-2">' . ucfirst(str_replace('_', " ", $col)) . '</th>';
        }
        $display .= '</thead></tr>';

        foreach ($data as $value) {
            $display .= '<tr>';
            $display .= '<td>' . $value['ref_no'] . '</td>
                 <td>' . $value['posting_date'] . '</td>
                 <td><a class="download_rpt" data-id="' . $value['ref_no'] . '" data-id1="' . $value['posting_date'] . '"> download</a></td>';
        }
        $display .= '</tr>';
        $display .= ' </table> </div>';
        $display .= isset($paginate) ? $paginate : "";

        return $display;
    }

    function retirement_date($dob, $dofa) {

        $dob_retired = date('d-m-Y', strtotime($dob . '+60 years')) . '<br>';
        $dofa_retired = date('d-m-Y', strtotime($dofa . '+35 years'));

        $dates = array($dob_retired, $dofa_retired);
        $retire_date = max($dates);
        return$retire_date;
    }
    
   //Posting Proposal 
     function show_posting_proposal() {

        $option = url::post('option');
        $search = url::post('search');

        //New Array
        $data = array();
        $display = '';
        $header = $this->db->get_fieldname('temp_data');

        $page = 1;
        if (!empty($_GET["page"])) {
            $page = $_GET["page"];
        }

        $this->db->orderBy('sno', 'ASC');
        switch ($option) {
            case'search':
                $cmd = $this->db->get_data_('temp_data', array('ippis_no' => $search, 'full_name' => $search));
                $data = $this->db->pagination('temp_data', $page, array('ippis_no' => $search, 'full_name' => $search), 'OR');
                $show_page_num = new paginate('temp_data', array('ippis_no' => $cmd['ippis_no']));
                $paginate = $show_page_num->get_paginate();
                break;
            default :
                $data = $this->db->pagination('temp_data', $page); //("SELECT $col FROM $cmd LIMIT $offset,$pagelimit");
                $show_page_num = new paginate('temp_data');
                $paginate = $show_page_num->get_paginate();
        }

        $display = '<div class="table-responsive"><table class="list nowrap" width="100%"  ><thead><tr>';
// $display .= '<th class="bold p-2"></th>';
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


}
