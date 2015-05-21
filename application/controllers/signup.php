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
				$this->form_validation->set_rules('website', 'Website', 'trim|required|is_unique[user_plan.up_website]');
				$this->form_validation->set_rules('subdomain', 'Subdomain', 'trim|required|is_unique[user_plan.up_subdomain]');

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
						'u_created_date' => date('Y-m-d H:i:s'),
                        'u_phone' => $post['phone'],
						'u_active' => 1
                        
                    );
					$plan_data = array(
                        'up_package_id' => $packageId,
                        'up_website' => $post['website'],
						'up_subdomain' => $post['subdomain'],
						'up_created_date' => date('Y-m-d H:i:s'),
						'up_package_expiry_date' => $expDate,
						'up_status' => 'Active'
                    );
					
					/* Paypal payment code */
					$this->load->helper('paypal');
					$paypal = new wp_paypal_gateway (true);
				 
					// Required Parameter for the getExpresscheckout
					$param = array(
						'amount' => 200,
						'currency_code' => 'USD',
						'payment_action' => 'Sale',
					);
					$param["return_url"] = base_url().PAYPAL_API_RETURN;
					$param["cancel_url"] = base_url().PAYPAL_API_CANCEL;
					// Display the response if successful or the debug info
					if ($paypal->setExpressCheckout($param)) {
						$res=$paypal->getResponse();
						$url = $paypal->getRedirectURL();
						$payment["payment"] =  $paypal->getResponse();
						$payment["user_data"] =  $insert_data;
						$payment["plan_data"] =  $plan_data;
						$this->session->set_userdata('payment_session', $payment);
						redirect($url);
					} else {
						print_r($paypal->debug_info);
					}
					exit;
                }
				else
				{
					$retFlg = -1;
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
	

	public function returnpay() {
					$get = $this->input->get();
					$token = $get['token'];
					$payment_data = $this->session->userdata('payment_session');
					
					$insert_data = $payment_data['user_data'];
					$plan_data = $payment_data['plan_data'];
					
					$payment = $payment_data['payment'];

					if (!isset($insert_data))
						redirect(base_url());

					if ($payment['TOKEN'] != $token)
						redirect(base_url());
					
					$ret = $this->common_model->insertData('users', $insert_data);
					$plan_data['up_u_id']=$ret;
					$plan = $this->common_model->insertData('user_plan', $plan_data);
                    # create session
                    $data = array('u_id' => $ret,
                        'u_email' => $post['email']
                    );
                    $this->session->set_userdata('front_session', $data);

                    if ($plan > 0) {
						$this->common_model->setupApplication($plan_data);
						
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
