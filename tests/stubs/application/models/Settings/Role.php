<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends CI_Model
{
    public function __construct()
    {
        $this->load->library('profiler');
    }
}
