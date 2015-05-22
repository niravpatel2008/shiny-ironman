<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->front_session = $this->session->userdata('front_session');
        is_front_login();
    }

    public function index() {

		$where = array('u_id' => $this->front_session['u_id']);
		$user = $this->common_model->joinData('users','user_plan',"users.u_id=user_plan.up_u_id", '*', $where);
		$data['user'] = $user;
        $data['view'] = "index";
        $this->load->view('care/content', $data);
    }
	
	public function profile() {
	
		 $post = $this->input->post();
		 
            if ($post) {
				
                $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
                $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');

                if ($this->form_validation->run()) {
					
                    $insert_data = array(
						'u_fname' => $post['fname'],
                        'u_lname' => $post['lname'],
                        'u_phone' => $post['phone'],
                    );
                    $ret = $this->common_model->updateData('users', $insert_data, 'u_id = ' . $this->front_session['u_id']);
					$flash_arr = array('flash_type' => 'success',
                            'flash_msg' => 'Profile successfully updated'
                        );
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
			
		$where = array('u_id' => $this->front_session['u_id']);
		$user = $this->common_model->selectData('users', '*', $where);
        $data['user'] = $user[0];
        $data['view'] = "profile";
        $this->load->view('care/content', $data);
    }
	
	public function purchase() {
	
		 $post = $this->input->post();
		 
            if ($post) {
				
				$this->form_validation->set_rules('website', 'Website', 'trim|required|is_unique[user_plan.up_website]');
				$this->form_validation->set_rules('subdomain', 'Subdomain', 'trim|required|is_unique[user_plan.up_subdomain]');
                $this->form_validation->set_rules('planSelect', 'Select Plan', 'trim|required');

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
                   $plan_data = array(
						'up_u_id'=>$this->front_session['u_id'],
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
					$param["return_url"] = base_url()."dashboard/returnpay";
					$param["cancel_url"] = base_url().PAYPAL_API_CANCEL;
					// Display the response if successful or the debug info
					if ($paypal->setExpressCheckout($param)) {
						$res=$paypal->getResponse();
						$url = $paypal->getRedirectURL();
						$payment["payment"] =  $paypal->getResponse();
						$payment["plan_data"] =  $plan_data;
						$this->session->set_userdata('ppayment_session', $payment);
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
		
		$data['packages'] = getPackages();
        $data['view'] = "purchase";
        $this->load->view('care/content', $data);
    }
	
	public function returnpay() {
			$get = $this->input->get();
			$token = $get['token'];
			$payment_data = $this->session->userdata('ppayment_session');
			
			$plan_data = $payment_data['plan_data'];
			$payment = $payment_data['payment'];

			if (!isset($plan_data))
				redirect(base_url());

			if ($payment['TOKEN'] != $token)
				redirect(base_url());
			
			$plan = $this->common_model->insertData('user_plan', $plan_data);
			
			if ($plan > 0) {
				$this->common_model->setupApplication($plan_data);
				
				## send mail
				// $emailTpl = $this->load->view('email_templates/signup', '', true);

				// $search = array('{name}','{username}','{password}','{OrgName}');
				// $replace = array($post['fname']." ".$post['lname'],$post['email'],$post['password'],'ChatAdmin');
				// $emailTpl = str_replace($search, $replace, $emailTpl);

				// $ret = sendEmail($userRes->u_email, SUBJECT_LOGIN_INFO, $emailTpl, FROM_EMAIL, FROM_NAME);

				$flash_arr = array('flash_type' => 'success',
					'flash_msg' => 'Welcome to DX chat again.'
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
	 public function purchaseplan() {
		
        $data['view'] = "purchaseplan";
        $this->load->view('care/content', $data);
    }

    public function change_password() {

        $post = $this->input->post();
        if ($post) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[password2]');
            $this->form_validation->set_rules('password2', 'Confirm password', 'trim|required');


            if ($this->form_validation->run()) {
                # update password
                $data = array('u_password' => md5(trim($post['password'])));
                $ret = $this->common_model->updateData('users', $data, 'u_id = ' . $this->front_session['u_id']);

                if ($ret > 0) {
                    $flash_arr = array('flash_type' => 'success',
                        'flash_msg' => 'Password changed successfully.'
                    );
                    $this->session->set_flashdata('flash_arr', $flash_arr);
                    redirect("dashboard");
                } else {
                    $flash_arr = array('flash_type' => 'error',
                        'flash_msg' => 'An error occured while processing.'
                    );
                    $this->session->set_flashdata('flash_arr', $flash_arr);
                    redirect("dashboard/change_password");
                }
            }
        }

        $data['view'] = "change_password";
        $this->load->view('care/content', $data);
    }

	public function plan_upgrade()
	{
		$post = $this->input->post();
		$where = array('u_id' => $this->front_session['u_id']);
		$user = $this->common_model->selectData('users', '*', $where);
        if ($post) {
            # upgrade plan
			$hdnUid = $post['hdnUid'];
			$data = array('up_package_id' => (trim($post['planSelect'])));
			$ret = $this->common_model->updateData('users', $data, 'u_id = '. $hdnUid);

			if ($ret > 0) {
				## send mail
				//$login_details = array('u_email' => $user[0]->email,'u_password' => $newpassword);
				$userRes = $user[0];
				$emailTpl = $this->load->view('email_templates/renewaftersubscription', '', true);

				$search = array('{name}', '{OrgName}');
				$replace = array($userRes->u_fname." ".$userRes->u_lname,'ChatAdmin');
				$emailTpl = str_replace($search, $replace, $emailTpl);

				$ret = sendEmail($userRes->u_email, SUBJECT_LOGIN_INFO, $emailTpl, FROM_EMAIL, FROM_NAME);

				$flash_arr = array('flash_type' => 'success',
					'flash_msg' => 'Congratulations !! Plan has been upgraded Successfully.'
				);
				$this->session->set_flashdata('flash_arr', $flash_arr);
				redirect("dashboard");
			} else {
				$flash_arr = array('flash_type' => 'error',
					'flash_msg' => 'An error occured while processing.'
				);
				$this->session->set_flashdata('flash_arr', $flash_arr);
				redirect("dashboard/plan_upgrade");
			}
            
        }
		
		$data['user'] = $user[0];
		$data['packages'] = getPackages();
        $data['view'] = "plan_upgrade";
        $this->load->view('care/content', $data);	
	}

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
