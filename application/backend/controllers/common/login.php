<?php defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {

    private $error = array();

    public function __construct() {
        parent::__construct();
        //$this->load->module('template');
        $this->load->model('login/mdl_login');
        $this->language = TMINI::get_be_ini('common/login');
    }

    public function index() {
//        $this->mdl_login->redirect_continue();
//        $data['pTitle'] = LKEY::GET('loginCmsPTitle');
//        $data['pTitle'] = 'Login';
//        $data += $this->loadAssets();
//        $this->load->view('login', $data);
        $this->logout();
        $theme = 'default';
        //Load Assets
        $data = $this->loadAssets();
        //Load language
        $data += $this->language;

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->login();
            redirect(TM_BASE_URL_CMS);
        }
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
            $data['success'] = '';
        }
        if (isset($_SESSION['Authencation']) || isset($_COOKIE['Authencation']))
            $data['success'] = $this->language['msg_success'];
        else
            $data['success'] = '';
        $data['router_login'] = TM_BASE_URL_CMS_Login;
        $this->load->view("$theme/common/login", $data);
    }

    public function login() {
        //$rs = $this->mdl_login->return_continue();
        $this->error['warning'] = '';
        try {

            if (!$this->validate())
                throw new Exception(validation_errors()); //throw new Exception(LKEY::GET('msgInputError'));
            $acc = $this->mdl_login->_logging($this->input->post());
            if ($acc === 1)
                throw new Exception($this->language['error_login']);
            if ($acc === 2)
                throw new Exception($this->language['error_login']);
        } catch (Exception $e) {
            $this->error['warning'] = $e->getMessage();
        }
    }

    public function logout() {
        try {
            $this->mdl_login->logout();
        } catch (Exception $e) {
            echo json_encode($e->getMessage());
        }
    }

    public function loadAssets() {
        $data['css'] = array(
            TMLib::AddAsset('css/bootstrap.css'),
            TMLib::AddAsset('font-awesome/css/font-awesome.css'),
            TMLib::AddAsset('css/login.css'),
            TMLib::AddAsset('css/plus.css'),
        );
        $data['js'] = array(
            TMLib::AddAsset('Scripts/jquery-1.11.3.min.js'),
            TMLib::AddAsset('Scripts/jquery.cookie.js'),
            TMLib::AddAsset('Scripts/bootstrap.min.js'),
            TMLib::AddAsset('Scripts/jquery.session.js'),
            TMLib::AddAsset('Scripts/jquery.validate.min.js'),
            TMLib::AddAsset('Scripts/additional-methods.min.js'),
            TMLib::AddAsset('Scripts/TMLibrary.js')
        );
        $data['icon'] = TMLib::AddAsset('favicon.ico');
        return $data;
    }

    public function validate() {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', $this->language['entry_username'], 'required|min_length[4]|max_length[32]|alpha_numeric');
        $this->form_validation->set_rules('password', $this->language['entry_password'], 'required|min_length[4]|max_length[32]');
        //Set Message
        $this->form_validation->set_message('min_length', $this->language['error_min_length']);
        $this->form_validation->set_message('max_length', $this->language['error_max_length']);
        $this->form_validation->set_message('alpha_numeric', $this->language['error_alpha_numeric']);
        return $this->form_validation->run();
    }

}
