<?php

class paginate {

    var $total;
    var $table;
    var $db;
    var $totalpage;
    var $page;

    function __construct($table,$cond=null) {
        $this->db = new model_query();
        $this->table = $table;
        $this->db->pageLimit=10;
        $this->total = isset($cond)?$this->db->total($this->table,$cond):$this->db->total($this->table);
        $this->totalpage = ceil($this->total / $this->db->pageLimit);
        $this->page = url::get('page');
    }

    function get_all_page_num() {

        $output = '';

        if (!isset($_GET["page"]))
            $_GET["page"] = 1;
        if ($this->db->pageLimit != 0)
            $pages = $this->totalpage; //ceil($count / $perpage);
        if ($pages > 1) {
            if ($_GET["page"] == 1)
                $output .= '<li class="page-item  disabled"><a href="javascript:void(0);" class="page-link disabled">&#8810;</a></li><li class="page-item disabled"><a href="javascript:void(0);" class="page-link disabled">&#60;</span></li>';
            else
                $output .= '<li class="page-item"><a href="javascript:void(0);" class="page-link page" data-page="' . (1) . '" >&#8810;</a></li><li class="page-item"><a href="javascript:void(0);" class="page-link page" data-page="' . ($_GET["page"] - 1) . '" >&#60;</a></li>';

            if ($_GET["page"] < 4) {
                $start = 1;
                $end = 5;
            } else {
                $start = ($_GET["page"] - 2);
                $end = ($_GET["page"] + 2);
            }

            $endpage = ($pages - 3);
            if ($_GET["page"] > $endpage) {
                $start = ($pages - 4);
            }


            for ($i = $start; $i <= $end; $i++) {
                if ($i < 1)
                    continue;
                if ($i > $pages)
                    break;
                if ($_GET["page"] == $i) {
                    $output .= '<li class="page-item active"><a href="javascript:void(0);" id=' . $i . ' class="page-link active">' . $i . '</a></li>';
                } else {
                    $output .= '<li class="page-item"><a href="javascript:void(0);" class="page-link page" data-page="' . $i . '" >' . $i . '</a></li>';
                }
            }

            if ($_GET["page"] < $pages)
                $output .= '<li class="page-item"><a href="javascript:void(0);" class="page-link page" data-page="' . ($_GET["page"] + 1) . '" >></a></li><li href="javascript:void(0);" class="page-item"><a href="javascript:void(0);" class="page-link page" data-page="' . ($pages) . '" >&#8811;</a>';
            else
                $output .= '<li class="page-item disabled"><a href="javascript:void(0);" class="page-link disabled">></a></li><li class="page-item disabled"><a href="javascript:void(0);" class="page-link disabled">&#8811;</a></li>';
        }

        return $output;
    }

    function get_showing() {
        $show = '';
        $page = ($this->page) ? $this->page : 1;
        $total = number_format($this->total);
        $first_no = $this->db->pageLimit * ($page - 1) + 1;
        $last_no = $this->db->pageLimit * $page;
        
        if ($this->total<$last_no)
            $last_no= $this->total;
          

        $show = "Showing $first_no to $last_no of $total entries";
        return $show;
    }

    function get_paginate() {
        $display = '';
        $page_num = $this->get_all_page_num();
        $showing = $this->get_showing();

        if (!empty($page_num) || !empty($showing)) {
            $display .= '<ul class="pagination mt-3 float-left">' . $showing . '</ul>';
            $display .= '<ul class="pagination mt-3 float-right">' . $page_num . '</ul>';
        }

        return $display;
    }

}
