<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModels();
        $this->loadLibraries();
        $this->loadArrayLibraries();
    }

    public function loadModels(): void
    {
        $this->load->model('Settings/Role');
        $this->load->model('User');
        $this->load->model('User', 'user');
        $this->load->model('User', name: 'user');
        $this->load->model(model: 'User', name: 'user');
        $this->load->model(name: 'user', model: 'User');
        $this->load->model('CustomModelDir/CustomModelName');
        $this->load->model('CustomModelDir2/CustomModelName2', 'custom_model_name2');
    }

    public function loadLibraries(): void
    {
        $this->load->library('session');
        $this->load->library('session', null, 'app_session');
        $this->load->library('session', new stdClass(), 'app_session');
        $this->load->library('session', object_name: 'app_session');
        $this->load->library(library: 'session', object_name: 'app_session');
        $this->load->library(object_name: 'app_session', library: 'session');
        $this->load->library('CustomLibraryDir/CustomLibraryName');
        $this->load->library('CustomLibraryDir2/CustomLibraryName2', null, 'custom_library_name_2');
    }

    public function loadArrayLibraries(): void
    {
        $this->load->library(['email' => 'app_email']);
        $this->load->library(library: ['email', 'form_validation']);
        $this->load->library(['email', 'form_validation']);
        $this->load->library(array('email' => 'app_email', 'form_validation' => 'app_form_validation'));
    }
}
