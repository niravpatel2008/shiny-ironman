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
		$user = $this->common_model->selectData('users', '*', $where);
        $data['user'] = $user[0];
        $data['view'] = "index";
        $this->load->view('care/content', $data);
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
			$data = array('u_package_id' => (trim($post['planSelect'])));
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
