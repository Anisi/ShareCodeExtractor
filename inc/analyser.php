<?php

date_default_timezone_set('Asia/Tehran');
include_once('simple_html_dom.php');

class analyser {

    private $result = array(); // for keeping final results
    private $temp_try = array();
    private $target_user_names = array();
    private $base_url = NULL;
    private $start_time = 0;
    private $problem_id = NULL;
    private $last_record_id = array();

    public function __construct() {
        $this->last_record_id = $_SESSION["last_record"];
        $this->start_time = $_SESSION["starttime"];
        $this->target_user_names = $_SESSION["user_names"];
    }

    public function __destruct() {
        $_SESSION["last_record"] = $this->last_record_id;
    }

    private function main_analyser() {

        $page = 1;
        $total_pages = 1;
        $first_crawling = FALSE;
        if ($this->last_record_id[$this->problem_id] === NULL) {
            $first_crawling = TRUE;
        }

        // getting total number of pages
        $ranking_list = file_get_html($this->base_url . $page);

        // check that last extracted element of current problem
        // still is on first page or not
        $last_record_id = NULL;
        if ($first_crawling) {
            $last_record = "tr[id=" . $this->last_record_id[$this->problem_id] . "]";
            $last_record_id = trim($ranking_list->find($last_record, 0)->id);
        }
        // NULL, means it's first crawling of current problem
        else {
            $records = $ranking_list->find('tr[class=run_row]');
            $records_count = count($records) - 1;
            // if no result found
            if ($records_count < 0) {
                return FALSE;
            }
            $last_record_id = trim($records[$records_count]->id);
        }

        // is not first crawling and still is on first page
        if (!$first_crawling AND strcmp($this->last_record_id[$this->problem_id], $last_record_id) === 0 ) {
            $total_pages = 1;
        }
        // is not on first page
        else {
            // get & set total page num
            $pages_dom = $ranking_list->find('#paging ul', 0)->last_child();
            if (@$pages_dom->children(0)->tag == "a")
                $total_pages = intval($pages_dom->children(0)->innertext);
            else {
                $total_pages = intval($pages_dom->innertext);
            }
        }

        // crawl pages until a run_row be out of the contest time
        for ($page = 1; $page <= $total_pages; $page++) {

            // prevent repeat getting content of page 1
            // because page 1's content is in var right now
            if ($page !== 1) {
                $ranking_list = file_get_html($this->base_url . $page);
            }

            // checking error in getting content of url
            if ($ranking_list !== FALSE) {
                // just process run_rows
                foreach ($ranking_list->find('tr[class=run_row]') as $element) {
                    $result = $this->result_extractor($element);
                    // terminate if records are older than contest's start time
                    if ($result === 0) {
                        $total_pages = 0;
                        break;
                    }
                }
            } else {
                $this->result["error"] = FALSE;
                return FALSE;
            }
            //set_time_limit(15);
        }

        // setting final tries in result array, depending on $temp_try
        foreach ($this->result as $user_name_hashed => $user_result) {
            $this->result[$user_name_hashed]["try"] = $this->temp_try[$user_name_hashed];
        }
    }

    private function result_extractor($row) {

        // getting username from current element (table row)
        // tr->td->center->a->{value}
        $user_name = strtolower(trim($row->children(1)->children(0)->children(0)->innertext));
        $user_name_hashed = md5($user_name);

        // ignore if username doesn't exist in target_user_names
        if (!empty($this->target_user_names) AND ! array_key_exists($user_name_hashed, $this->target_user_names)) {
            //echo 'user' . $user_name . '<br>';
            return FALSE;
        }
        // ignore if problem is outmoded for current user
//        if (!empty($this->target_user_names) AND $this->target_user_names[$user_name_hashed][$this->problem_id] === 0) {
//            //echo 'outmoded' . $user_name . '<br>';
//            return FALSE;
//        }
        // getting user time from current element (table row)
        // tr->td->center->{value}
        $user_submit_time = $row->children(2)->children(0)->innertext;
        $user_submit_time = strtotime($user_submit_time);

        // ignore if is before starting contest
        if ($user_submit_time <= $this->start_time) {
            //echo 'time' . $user_name . '<br>';
            return 0;
        }

        // counting tries
        if (isset($this->temp_try[$user_name_hashed])) {
            $this->temp_try[$user_name_hashed] ++;
        } else {
            $this->temp_try[$user_name_hashed] = 1;
        }

        // replace/set latest info
        if (!isset($this->result[$user_name_hashed]) OR $this->result[$user_name_hashed]['time'] < $user_submit_time) {

            // getting user result from current element (table row) and set TRUE if accepted
            // tr->td->center->span->{value}
            $user_result = $row->children(7)->children(1)->children(0)->innertext;
            $user_result = strtolower(trim($user_result));

            if (strcmp($user_result, 'accepted') === 0) {
                $user_result = TRUE;
            } else {
                $user_result = FALSE;
            }

            // replace latest user info, if already found
            if (isset($this->result[$user_name_hashed])) {
                $this->result[$user_name_hashed]['result'] = $user_result;
                $this->result[$user_name_hashed]['time'] = $user_submit_time;
            }
            // set initial user info, if not found
            else {
                $this->result[$user_name_hashed]['result'] = $user_result;
                $this->result[$user_name_hashed]['time'] = $user_submit_time;
            }
        }
    }

    public function get_result($problem_id) {
        $this->base_url = "http://sharecode.io/runs/problemset/problem/" . $problem_id . '/';
        $this->problem_id = $problem_id;

        // declaring array cell of last_record_id for current problem
        // if doesn't exist
        if (!isset($this->last_record_id[$this->problem_id])) {
            $this->last_record_id[$this->problem_id] = NULL;
        }

        $this->main_analyser();
        return $this->result;
    }

}

?>