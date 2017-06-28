<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->language = TMINI::get_be_ini('common/dashboard');
    }

    public function index() {
        $this->template->title('tuanmjnh');
        $this->template->append_metadata('<script src="/js/jquery.flot.js"></script>');
        $this->template->append_metadata('<script src="/js/jquery.flot2.js"></script>');
        $this->template->append_metadata('<script src="/js/jquery.flot3.js"></script>');
        $this->template->append_asset('css/plugins/morris/morris-0.4.3.min.css');
        $this->template->append_asset('css/plugins/timeline/timeline.css');
        //$this->load->view("login/login");
        $this->template
                ->set_layout('default') // application/views/layouts/two_col.php
                ->build('common/dashboard'); // views/welcome_message
    }

//        $this->load->language('common/dashboard');
//
//        $this->document->setTitle($this->language->get('heading_title'));
//
//        $data['heading_title'] = $this->language->get('heading_title');
//
//        $data['text_sale'] = $this->language->get('text_sale');
//        $data['text_map'] = $this->language->get('text_map');
//        $data['text_activity'] = $this->language->get('text_activity');
//        $data['text_recent'] = $this->language->get('text_recent');
//
//        $data['breadcrumbs'] = array();
//
//        $data['breadcrumbs'][] = array(
//            'text' => $this->language->get('text_home'),
//            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
//        );
//
//        $data['breadcrumbs'][] = array(
//            'text' => $this->language->get('heading_title'),
//            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
//        );
//
//        // Check install directory exists
//        if (is_dir(dirname(DIR_APPLICATION) . '/install')) {
//            $data['error_install'] = $this->language->get('error_install');
//        } else {
//            $data['error_install'] = '';
//        }
//
//        $data['token'] = $this->session->data['token'];
//
//        $data['header'] = $this->load->controller('common/header');
//        $data['column_left'] = $this->load->controller('common/column_left');
//        $data['order'] = $this->load->controller('dashboard/order');
//        $data['sale'] = $this->load->controller('dashboard/sale');
//        $data['customer'] = $this->load->controller('dashboard/customer');
//        $data['online'] = $this->load->controller('dashboard/online');
//        $data['map'] = $this->load->controller('dashboard/map');
//        $data['chart'] = $this->load->controller('dashboard/chart');
//        $data['activity'] = $this->load->controller('dashboard/activity');
//        $data['recent'] = $this->load->controller('dashboard/recent');
//        $data['footer'] = $this->load->controller('common/footer');
//
//        // Run currency update
//        if ($this->config->get('config_currency_auto')) {
//            $this->load->model('localisation/currency');
//
//            $this->model_localisation_currency->refresh();
//        }
//
//        $this->response->setOutput($this->load->view('common/dashboard', $data));
//    }
}
