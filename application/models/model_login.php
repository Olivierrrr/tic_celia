<?php
    
    class Model_login extends CI_Model {
        
        public function check_login($usr, $pass) {
            $this->load->database();
            $this->db->where("user",$usr);
            $this->db->where("pass",$pass);
            $r = $this->db->get("usuarios");
            if ($this->db->affected_rows() > 0) {
                foreach ($r->result() as $row) $idusr = $row->id;
                $idusr = $row->id;
            }
            else {
                $idusr = 0;
            }
            return $idusr;
        }
    }