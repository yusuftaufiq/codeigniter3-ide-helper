<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('encryption', 'encrypt');
    }
}
