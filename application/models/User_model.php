<?php
    class User_model extends CI_Model {
        public function __construct() {
            parent::__construct();
        }

        function count_users($param_arr) {
            $this->load->database();
            // return $this->db->count_all("members");
            $this->db->select('id,firstname,surname,email,gender,joined_date');
            $this->db->from('members');
            foreach ($param_arr as $key => $val) {
                $this->db->where($key,$val);
            }
            return $this->db->count_all_results();
        }

        function chart_stats_mon($year) {
            $this->load->database();
            $query = $this->db->select('COUNT(id) as total, Month(joined_date) as month')
                        ->from('members')
                        ->where('Year(joined_date)',$year)
                        ->group_by('month')
                        ->order_by('month', 'asc')
                        ->get(); 

            return $query->result();
        }

        function chart_stats() {
            $this->load->database();
            $query = $this->db->select('COUNT(id) as total, Year(joined_date) as year')
                        ->from('members')
                        ->group_by('year')
                        ->order_by('total', 'desc')
                        ->get(); 

            return $query->result();
        }

        function fetch_users($page, $limit, $param_arr ) {
            $start = $page <= 1 ? 0 : ($page-1) * $limit;
            $this->load->database();
            $this->db->select('id,firstname,surname,email,gender,joined_date');
            $this->db->from('members');
            
            foreach ($param_arr as $key => $val) {
                $this->db->where($key,$val);
            }

            $this->db->limit($limit, $start);
            
            $query=$this->db->get();
            return $query->result();
        }
    }
?>