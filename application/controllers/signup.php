<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Signup extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        //if ($id > 0) {
			
            $post = $this->input->post();
            if ($post) {
                $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
                $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
                $this->form_validation->set_rules('email', 'Email', 'valid_email|trim|required|is_unique[users.email]');
                $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[password2]');
                $this->form_validation->set_rules('password2', 'Confirm password', 'trim|required');

                if ($this->form_validation->run()) {
					$packageId = $post['planSelect'];
					switch($packageId)
					{
						case 1:
							$expDate=Date('Y-m-d', strtotime("+30 days"));
						break;
						case 2:
							$expDate=Date('Y-m-d', strtotime("+180 days"));
						break;
						case 3:
							$expDate=Date('Y-m-d', strtotime("+365 days"));
						break;
					}
                    $insert_data = array(
						'fname' => $post['fname'],
                        'lname' => $post['lname'],
                        'email' => $post['email'],
                        'password' => md5($post['password']),
                        'phone' => $post['phone'],
                        'package_id' => $packageId,
                        'website' => $post['website'],
						'package_expiry_date' => $expDate
                    );
                    $ret = $this->common_model->insertData('users', $insert_data);
                    # create session
                    $data = array('id' => $ret,
                        'email' => $post['email']
                    );
                    $this->session->set_userdata('front_session', $data);

                    if ($ret > 0) {
                        $flash_arr = array('flash_type' => 'success',
                            'flash_msg' => 'Welcome to DX chat.'
                        );
                    } else {
                        $flash_arr = array('flash_type' => 'error',
                            'flash_msg' => 'An error occurred while processing.'
                        );
                    }
                    $this->session->set_flashdata('flash_arr', $flash_arr);
                    redirect(base_url() . "dashboard");
                }
            }

           // $data['view'] = "signup";
        //} else {
            $data['packages'] = $this->common_model->selectData('package_details', '*', array('status' => 1));
            $data['view'] = "index";
        //}

        $this->load->view('content', $data);
    }

}

/* End of file signup.php */
/* Location: ./application/controllers/signup.php */
