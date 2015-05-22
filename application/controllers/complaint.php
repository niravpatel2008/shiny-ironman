<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Complaint extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        
            $post = $this->input->post();
            if ($post) {
                $this->form_validation->set_rules('subdomain', 'Subdomain', 'trim|required');
				$this->form_validation->set_rules('name', 'Name', 'trim|required');
				$this->form_validation->set_rules('email', 'Email', 'valid_email|trim|required');
                $this->form_validation->set_rules('comment', 'Comments', 'trim|required');

                if ($this->form_validation->run()) {
					
                    $insert_data = array(
						't_name' => $post['name'],
                        't_email' => $post['email'],
                        't_phone' => $post['phone'],                        
						't_subdomain' => $post['subdomain'],
						't_comment' => $post['comment'],
						't_created_date' => date('Y-m-d H:i:s'),
						't_status' => 'Pending'
                    );
					$ret = $this->common_model->insertData('ticket', $insert_data); 
					
					 if ($ret > 0) {
					$emailTpl = $this->load->view('email_templates/complaint', '', true);
					$search = array('{name}','{email}','{phone}','{subdomain}','{comment}');
					$replace = array($post['name'],$post['email'],$post['phone'],$post['subdomain'],$post['comment']);
					$emailTpl = str_replace($search, $replace, $emailTpl);
					
					sendEmail(ADMIN_EMAIL, SUBJECT_COMPLAINT, $emailTpl, FROM_EMAIL, FROM_NAME);
					 $flash_arr = array('flash_type' => 'success',
                            'flash_msg' => 'Your complain submitted successfully.'
                        );
					 }
					 else
					 {
						$flash_arr = array('flash_type' => 'error',
                            'flash_msg' => 'Your complain submission fail.'
                        );
					 }
					 $this->session->set_flashdata('flash_arr', $flash_arr);
					 redirect("dashboard");
                }
				else
				{
					$retFlg = -1;
					echo $retFlg;
					redirect("complaint");
					exit;
				}
            }
		$data['view'] = "index";
        $this->load->view('care/content', $data);
    }
	

	public function returnpay() {
					$get = $this->input->get();
					$token = $get['token'];
					$payment_data = $this->session->userdata('payment_session');
					$insert_data = $payment_data['user_data'];
					$payment = $payment_data['payment'];

					if (!isset($insert_data))
						redirect(base_url());

					if ($payment['TOKEN'] != $token)
						redirect(base_url());
					
					$ret = $this->common_model->insertData('users', $insert_data);
                    # create session
                    $data = array('u_id' => $ret,
                        'u_email' => $post['email']
                    );
                    $this->session->set_userdata('front_session', $data);

                    if ($ret > 0) {
						$this->common_model->setupApplication($insert_data);
						
						## send mail
						//$login_details = array('u_email' => $user[0]->email,'u_password' => $newpassword);
						$userRes = $user[0];
						$emailTpl = $this->load->view('email_templates/signup', '', true);

						$search = array('{name}','{username}','{password}','{OrgName}');
						$replace = array($post['fname']." ".$post['lname'],$post['email'],$post['password'],'ChatAdmin');
						$emailTpl = str_replace($search, $replace, $emailTpl);

						$ret = sendEmail($userRes->u_email, SUBJECT_LOGIN_INFO, $emailTpl, FROM_EMAIL, FROM_NAME);

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
					
					redirect(base_url()."dashboard");
	}

	public function cancelpay() {
			redirect(base_url());
	}
}

/* End of file signup.php */
/* Location: ./application/controllers/signup.php */
