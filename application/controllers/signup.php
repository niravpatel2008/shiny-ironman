<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Signup extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        //if ($id > 0) {
			/*$data = array('u_subdomain'=>'neo');
			$this->common_model->setupApplication($data);*/
			
            $post = $this->input->post();
            if ($post) {
                $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
                $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
                $this->form_validation->set_rules('email', 'Email', 'valid_email|trim|required|is_unique[users.u_email]');
                $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[password2]');
                $this->form_validation->set_rules('password2', 'Confirm password', 'trim|required');
				$this->form_validation->set_rules('website', 'Website', 'trim|required|is_unique[users.u_website]');
				$this->form_validation->set_rules('subdomain', 'Subdomain', 'trim|required|is_unique[users.u_subdomain]');

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
						'u_fname' => $post['fname'],
                        'u_lname' => $post['lname'],
                        'u_email' => $post['email'],
                        'u_password' => md5($post['password']),
                        'u_phone' => $post['phone'],
                        'u_package_id' => $packageId,
                        'u_website' => $post['website'],
						'u_subdomain' => $post['subdomain'],
						'u_created_date' => date('Y-m-d'),
						'u_package_expiry_date' => $expDate,
						'u_active' => 1
                    );
                    $ret = $this->common_model->insertData('users', $insert_data);
                    # create session
                    $data = array('u_id' => $ret,
                        'u_email' => $post['email']
                    );
                    $this->session->set_userdata('front_session', $data);

                    if ($ret > 0) {
						$this->common_model->setupApplication($insert_data);
						$flash_arr = array('flash_type' => 'success',
                            'flash_msg' => 'Welcome to DX chat.'
                        );
						$retFlg = 1;
                    } else {
                        $flash_arr = array('flash_type' => 'error',
                            'flash_msg' => 'An error occurred while processing.'
                        );
						$retFlg = 0;
                    }
                    $this->session->set_flashdata('flash_arr', $flash_arr);
					echo $retFlg;
					exit;
                    //redirect(base_url() . "dashboard");
                }
				else
				{
					$retFlg = -1;
					//print_r($this->form_validation);die;
					echo $retFlg;
					exit;
				}
            }
			
           // $data['view'] = "signup";
        //} else {
            $data['packages'] = getPackages();
			$data['view'] = "index";
        //}
		
        $this->load->view('content', $data);
    }

}

/* End of file signup.php */
/* Location: ./application/controllers/signup.php */
