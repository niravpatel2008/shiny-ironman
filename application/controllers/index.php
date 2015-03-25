<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['view'] = "index";
        $this->load->view('content', $data);
    }

    public function about() {
        $data['view'] = "about";
        $this->load->view('content', $data);
    }

    public function contact() {
        $data['view'] = "contact";
        $this->load->view('content', $data);
    }

    public function signin() {
        $post = $this->input->post();
        if ($post) {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');

            if ($this->form_validation->run()) {
                $where = array('email' => $post['email'],
                    'password' => md5(trim($post['password']))
                );
                $user = $this->common_model->selectData('users', '*', $where);
                if (count($user) > 0) {
                    # create session
                    $data = array('id' => $user[0]->id,
                        'email' => $user[0]->email
                    );
                    $this->session->set_userdata('front_session', $data);
                    redirect("dashboard");
                } else {
                    $flash_arr = array('flash_type' => 'error',
                        'flash_msg' => 'Invalid username or password.'
                    );
                    $this->session->set_flashdata('flash_arr', $flash_arr);
                    redirect("signin");
                }
            }
        }

        $data['view'] = "signin";
        $this->load->view('content', $data);
    }

    public function signout() {
        $this->session->sess_destroy();
        redirect(base_url());
    }

}

/* End of file index.php */
/* Location: ./application/controllers/index.php */
