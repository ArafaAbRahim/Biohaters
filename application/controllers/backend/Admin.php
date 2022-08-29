<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct() {

		parent::__construct();

		$this->lang->load('content', $_SESSION['lang']);

		if (!isset($_SESSION['user_auth']) || $_SESSION['user_auth'] != true) {
			redirect('login', 'refresh');
		}
		if ($_SESSION['userType'] != 'admin')
			redirect('login', 'refresh');
		//Model Loading
		$this->load->model('AdminModel');
		$this->load->library("pagination");
		$this->load->helper("url");
		$this->load->helper("text");

		date_default_timezone_set("Asia/Dhaka");
	}

	public function index() {
		
		$data['title']      = 'Admin Panel • HRSOFTBD News Portal Admin Panel';
		$data['page']       = 'backEnd/dashboard_view';
		$data['activeMenu'] = 'dashboard_view';
		
		
		$this->load->view('backEnd/master_page', $data);
	}

	public function theme_setting($param1 = '', $param2 = '', $param3 = ''){


		
		$theme_data_temp    = $this->db->get('tbl_backend_theme')->result();
		$data['theme_data'] = array();
		foreach($theme_data_temp as $value){
			$data['theme_data'][$value->name]	= $value->value;
		}

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$long_title = $this->input->post('long_title', true);
			$this->AdminModel->theme_text_update('long_title', $long_title);

			$short_title = $this->input->post('short_title', true);
			$this->AdminModel->theme_text_update('short_title', $short_title);
			
			$tagline = $this->input->post('tagline', true);
			$this->AdminModel->theme_text_update('tagline', $tagline);
			
			$share_title = $this->input->post('share_title', true);
			$this->AdminModel->theme_text_update('share_title', $share_title);

			$share_title = $this->input->post('version', true);
			$this->AdminModel->theme_text_update('version', $share_title);

			$share_title = $this->input->post('organization', true);
			$this->AdminModel->theme_text_update('organization', $share_title);


			if (!empty($_FILES['logo']['name'])) {

				$path_parts                 = pathinfo($_FILES["logo"]['name']);
				$newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
				$dir                        = date("YmdHis", time());
				$config_c['file_name']      = $newfile_name . '_' . $dir;
				$config_c['remove_spaces']  = TRUE;
				$config_c['upload_path']    = 'assets/themeLogo/';
				$config_c['max_size']       = '20000'; //  less than 20 MB
				$config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

				$this->load->library('upload', $config_c);
				$this->upload->initialize($config_c);
				if (!$this->upload->do_upload('logo')) {

				} else {

					$upload_c = $this->upload->data();
					$logo['logo'] = $config_c['upload_path'] . $upload_c['file_name'];
					$this->image_size_fix($logo['logo'], 300, 300);
				}
				$this->AdminModel->theme_text_update('logo',$logo['logo']);
			}

			

			if (!empty($_FILES['share_banner']['name'])) {

				$path_parts                 = pathinfo($_FILES["share_banner"]['name']);
				$newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
				$dir                        = date("YmdHis", time());
				$config['file_name']      = $newfile_name . '_' . $dir;
				$config['remove_spaces']  = TRUE;
				$config['upload_path']    = 'assets/themeBanner/';
				$config['max_size']       = '20000'; //  less than 20 MB
				$config['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('share_banner')) {

				} else {

					$upload = $this->upload->data();
					$share_banner['share_banner'] = $config['upload_path'] . $upload['file_name'];
					$this->image_size_fix($share_banner['share_banner'], 600, 315);
				}
				$this->AdminModel->theme_text_update('share_banner',$share_banner['share_banner']);
				
			}

			
			
			$this->session->set_flashdata('message', 'Theme Info Updated Successfully!');
			redirect('admin/theme-setting','refresh');
		}

		$data['page']       = 'backEnd/admin/theme_setting';
		$data['activeMenu'] = 'theme_setting';

		$this->load->view('backEnd/master_page', $data);
	}

	//Add User
	public function add_user($param1 = '') 
	{
		$messagePage['divissions'] = $this->db->get('tbl_divission')->result_array();
		$messagePage['userType']   = $this->db->get('user_type')->result();

		$messagePage['title']      = 'Add User Admin Panel • HRSOFTBD News Portal Admin Panel';
		$messagePage['page']       = 'backEnd/admin/add_user';
		$messagePage['activeMenu'] = 'add_user';
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$saveData['firstname'] = $this->input->post('first_name', true);
			$saveData['lastname']  = $this->input->post('last_name', true);
			$saveData['username']  = $this->input->post('user_name', true);
			$saveData['email']     = $this->input->post('email', true);
			$saveData['phone']     = $this->input->post('phone', true);
			$saveData['password']  = sha1($this->input->post('password', true));
			$saveData['address']   = $this->input->post('address', true);
			$saveData['roadHouse'] = $this->input->post('road_house', true);
			$saveData['userType']  = $this->input->post('user_type', true);
			$saveData['photo']     = 'assets/userPhoto/defaultUser.jpg';

			if (!empty($_FILES['photo']['name'])) {

				$path_parts                 = pathinfo($_FILES["photo"]['name']);
				$newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
				$dir                        = date("YmdHis", time());
				$config_c['file_name']      = $newfile_name . '_' . $dir;
				$config_c['remove_spaces']  = TRUE;
				$config_c['upload_path']    = 'assets/userPhoto/';
				$config_c['max_size']       = '20000'; //  less than 20 MB
				$config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

				$this->load->library('upload', $config_c);
				$this->upload->initialize($config_c);
				if (!$this->upload->do_upload('photo')) {

				} else {

					$upload_c = $this->upload->data();
					$saveData['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
					$this->image_size_fix($saveData['photo'], 400, 400);
				}
				
			}

			//This will returns as third parameter num_rows, result_array, result
			$username_check = $this->AdminModel->isRowExist('user', array('username' => $saveData['username']), 'num_rows');
			$email_check = $this->AdminModel->isRowExist('user', array('email' => $saveData['email']), 'num_rows');

			if ($username_check > 0 || $email_check > 0) {
				//Invalid message
				$messagePage['page'] = 'backEnd/admin/insertFailed';
				$messagePage['noteMessage'] = "<hr> UserName: " . $saveData['username'] . " can not be create.";
				if ($username_check > 0) {

					$messagePage['noteMessage'] .= '<br> Cause this username is already exist.';
				} else if ($email_check > 0) {

					$messagePage['noteMessage'] .= '<br> Cause this email is already exist.';
				}
			} else {
				//success
				$insertId = $this->AdminModel->saveDataInTable('user', $saveData, 'true');

				$messagePage['page'] = 'backEnd/admin/insertSuccessfull';
				$messagePage['noteMessage'] = "<hr> UserName: " . $saveData['username'] . " has been created successfully.";

				// Category allocate for users
				if (!empty($this->input->post('selectCategory', true))) {

					foreach ($this->input->post('selectCategory', true) as $cat_value) {

						$this->db->insert('category_user', array('userId' => $insertId, 'categoryId' => $cat_value));
					}
				}
			}
		}


		$this->load->view('backEnd/master_page', $messagePage);
	}

	//Edit User
	public function edit_user($param1 = '') 
	{
		// Update using post method 
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			if(strlen($this->input->post('password', true)) > 3){
                $saveData['password']  = sha1($this->input->post('password', true));
            }

			$saveData['firstname'] = $this->input->post('first_name', true);
			$saveData['lastname']  = $this->input->post('last_name', true);
			$saveData['phone']     = $this->input->post('phone', true);
			$saveData['address']   = $this->input->post('address', true);
			$saveData['roadHouse'] = $this->input->post('road_house', true);
			$saveData['userType']  = $this->input->post('user_type', true);
			$user_id               = $param1;

			if (!empty($_FILES['photo']['name'])) {

				$path_parts                 = pathinfo($_FILES["photo"]['name']);
				$newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
				$dir                        = date("YmdHis", time());
				$config_c['file_name']      = $newfile_name . '_' . $dir;
				$config_c['remove_spaces']  = TRUE;
				$config_c['upload_path']    = 'assets/userPhoto/';
				$config_c['max_size']       = '20000'; //  less than 20 MB
				$config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

				$this->load->library('upload', $config_c);
				$this->upload->initialize($config_c);
				if (!$this->upload->do_upload('photo')) {

				} else {

					$upload_c = $this->upload->data();
					$saveData['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
					$this->image_size_fix($saveData['photo'], 400, 400);
				}
				
			}

			if (isset($saveData['photo']) && file_exists($saveData['photo'])) {
	
				$result = $this->db->select('photo')->from('user')->where('id',$user_id)->get()->row()->photo;

				if (file_exists($result)) {
					unlink($result);
				}  
			}

			$this->db->where('id', $user_id);
			$this->db->update('user', $saveData);
			
			$data['page']        = 'backEnd/admin/insertSuccessfull';
			$data['noteMessage'] = "<hr> Data has been Updated successfully.";

		} else if ($this->AdminModel->isRowExist('user', array('id' => $param1), 'num_rows') > 0) {

			$data['userDetails']   = $this->AdminModel->isRowExist('user', array('id' => $param1), 'result_array');

			$myupozilla_id         = $this->db->get_where('tbl_upozilla', array("id"=>$data['userDetails'][0]['address']))->row();

			$data['myzilla_id']    = $myupozilla_id->zilla_id;
			$data['mydivision_id'] = $myupozilla_id->division_id;

			$data['divissions']    = $this->db->get('tbl_divission')->result();
		
			$data['distrcts']      = $this->db->get_where('tbl_zilla',array('divission_id'=>$data['mydivision_id']))->result();
			$data['upozilla']      = $this->db->get_where('tbl_upozilla',array('zilla_id'=>$data['myzilla_id']))->result();

			$data['userType'] = $this->db->get('user_type')->result_array();
			$data['user_id']  = $param1;
			$data['page']     = 'backEnd/admin/edit_user';

		} else {

			$data['page']        = 'errors/invalidInformationPage';
			$data['noteMessage'] = $this->lang->line('wrong_info_search');
		}

		$data['user_type'] 	= $this->db->select('id, value, name')->get('user_type')->result();
		$data['title']      = 'Users List Admin Panel • HRSOFTBD News Portal Admin Panel';
		$data['activeMenu'] = 'user_list';
		$this->load->view('backEnd/master_page', $data);
	}

	//Suspend User
	public function suspend_user($id, $setvalue)
	{
		$this->db->where('id', $id);
		$this->db->update('user', array('status' => $setvalue));
		$this->session->set_flashdata('message', 'Data Saved Successfully.');
		
		redirect('admin/user_list', 'refresh');
	}

	//Delete User
	public function delete_user($id)
	{
		$old_image_url=$this->db->where('id', $id)->get('user')->row();
		$this->db->where('id', $id)->delete('user');
		if(isset($old_image_url->photo)){
			unlink($old_image_url->photo);
		}

		$this->session->set_flashdata('message', 'Data Deleted.');
		redirect('admin/user_list', 'refresh');
	}

	//User List
	public function user_list() 
	{
		$this->db->where('userType !=', 'admin');
		$data['myUsers']    = $this->db->get('user')->result_array();
		$data['title']      = 'Users List Admin Panel • HRSOFTBD News Portal Admin Panel';
		$data['page']       = 'backEnd/admin/user_list';
		$data['activeMenu'] = 'user_list';
		$this->load->view('backEnd/master_page', $data);
	}

	public function image_size_fix($filename, $width = 600, $height = 400, $destination = '') {

		// Content type
		// header('Content-Type: image/jpeg');
		// Get new dimensions
		list($width_orig, $height_orig) = getimagesize($filename);

		// Output 20 May, 2018 updated below part
		if ($destination == '' || $destination == null)
			$destination = $filename;

		$extention = pathinfo($destination, PATHINFO_EXTENSION);
		if ($extention != "png" && $extention != "PNG" && $extention != "JPEG" && $extention != "jpeg" && $extention != "jpg" && $extention != "JPG") {
 
			return true;
		}
		// Resample
		$image_p = imagecreatetruecolor($width, $height);
		$image   = imagecreatefromstring(file_get_contents($filename));
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

		

		if ($extention == "png" || $extention == "PNG") {
			imagepng($image_p, $destination, 9);
		} else if ($extention == "jpg" || $extention == "JPG" || $extention == "jpeg" || $extention == "JPEG") {
			imagejpeg($image_p, $destination, 70);
		} else {
			imagepng($image_p, $destination);
		}
		return true;
	}

	public function get_division() {

		$result = $this->db->select('id, name')->get('tbl_divission')->result();
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}

	public function get_zilla_from_division($division_id = 1) {

		$result = $this->db->select('id, name')->where('divission_id', $division_id)->get('tbl_zilla')->result();
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}

	public function get_upozilla_from_division_zilla($zilla_id = 1) {

		$result = $this->db->select('id, name')->where('zilla_id', $zilla_id)->get('tbl_upozilla')->result();
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}

	public function download_file($file_name = '', $fullpath='') {

		$this->load->helper('download');

		$filePath = $file_name;

		if($file_name=='full' && ($fullpath != '' || $fullpath != null)) $filePath = $fullpath;

		if($_GET['file_path']) $filePath = $_GET['file_path'];
		
		if (file_exists($filePath)) {

			force_download($filePath, NULL);

		} else {

			die('The provided file path is not valid.');
		}
	}
	
	public function profile($param1 = '')
	{

		$user_id            = $this->session->userdata('userid');
		$data['user_info']  = $this->AdminModel->get_user($user_id);


		$myzilla_id         = $data['user_info']->zilla_id;
		$mydivision_id      = $data['user_info']->division_id;

		$data['divissions'] = $this->db->get('tbl_divission')->result();

		$data['distrcts']   = $this->db->get_where('tbl_zilla', array('divission_id' => $mydivision_id))->result();
		$data['upozilla']   = $this->db->get_where('tbl_upozilla', array('zilla_id'  => $myzilla_id))->result();

		if ($param1 == 'update_photo') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			    
			    
			    //exta work
                $path_parts               = pathinfo($_FILES["photo"]['name']);
                $newfile_name             = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
                $dir                      = date("YmdHis", time());
                $config['file_name']      = $newfile_name . '_' . $dir;
                $config['remove_spaces']  = TRUE;
                //exta work
                $config['upload_path']    = 'assets/userPhoto/';
                $config['max_size']       = '20000'; //  less than 20 MB
                $config['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('photo')) {

                    // case - failure
					$upload_error = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('message', "Failed to update image.");

                } else {

                    $upload                 = $this->upload->data();
                    $newphotoadd['photo']   = $config['upload_path'] . $upload['file_name'];

                    $old_photo              = $this->db->where('id', $user_id)->get('user')->row()->photo;
                    
                    if(file_exists($old_photo)) unlink($old_photo);

                    //$this->image_size_fix($newphotoadd['photo'], 200, 200);

                    $this->db->where('id', $user_id)->update('user', $newphotoadd);

                    $this->session->set_userdata('userPhoto', $newphotoadd['photo']);
					$this->session->set_flashdata('message', 'User Photo Updated Successfully!');
					
					redirect('admin/profile','refresh');
                }
                
			  }
			  
		}else if($param1 == 'update_pass'){

		   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		       
			   $old_pass    = sha1($this->input->post('old_pass', true)); 
			   $new_pass    = sha1($this->input->post('new_pass', true)); 
			   $user_id     = $this->session->userdata('userid');

			   $get_user    = $this->db->get_where('user',array('id'=>$user_id, 'password'=>$old_pass));
			   $user_exist  = $get_user->row();

			   if($user_exist){
			       
					$this->db->where('id',$user_id)
							->update('user',array('password'=>$new_pass));
					$this->session->set_flashdata('message', 'Password Updated Successfully');
					redirect('admin/profile','refresh');
					
			   }else{
			       
				    $this->session->set_flashdata('message', 'Password Update Failed');
				    redirect('admin/profile','refresh');
				   
			   }
			   
			}
			
		}else if($param1 == 'update_info'){

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			    
				$update_data['firstname']   = $this->input->post('firstname', true);
				$update_data['lastname']    = $this->input->post('lastname', true);
				$update_data['roadHouse']   = $this->input->post('roadHouse', true);
				$update_data['address']     = $this->input->post('address', true);


				$db_email     = $this->db->where('id!=', $user_id)->where('email', $this->input->post('email', true))->get('user')->num_rows();
				$db_username  = $this->db->where('id!=', $user_id)->where('username', $this->input->post('username', true))->get('user')->num_rows();


				if ( $db_username == 0) {

					 $update_data['username']    = $this->input->post('username', true);
					 
				}if ( $db_email == 0) {

					 $update_data['email']       = $this->input->post('email', true);
					 
				}


				$current_password = sha1($this->input->post('password', true));

				$db_password      = $data['user_info']->password;

				if ($current_password == $db_password) {

					if ($this->AdminModel->update_pro_info($update_data, $user_id)) {
    			    
	    			    $this->session->set_userdata('username_first', $update_data['firstname']);
	    			    $this->session->set_userdata('username_last', $update_data['lastname']);
	    			    $this->session->set_userdata('username', $update_data['username']);
	    			    
	    				$this->session->set_flashdata('message', 'Information Updated Successfully!');
	    				redirect('admin/profile', 'refresh');
	    				
	    			} else {
	    			    
	    				$this->session->set_flashdata('message', 'Information Update Failed!');
	    				redirect('admin/profile', 'refresh');
	    				
	    			} 

				} else {

					$this->session->set_flashdata('message', 'Current Password Does Not Match!');
	    			redirect('admin/profile', 'refresh');
				}
				
				

    			
				
			}
		}
		
		$data['title']      = 'Profile Admin Panel • HRSOFTBD News Portal Admin Panel';
		$data['activeMenu'] = 'Profile';
		$data['page']       = 'backEnd/admin/profile';
		
		$this->load->view('backEnd/master_page',$data);
	}

	public function testimonial($param1 = 'add', $param2 = '', $param3 = '')
	{
		if ($param1 == 'add') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$insert_testimonials['student_id']     	= $this->input->post('student_id', true);
				$insert_testimonials['name']        	= $this->input->post('name', true);
				$insert_testimonials['feedback']    	= $this->input->post('feedback', true);
				$insert_testimonials['priority']    	= $this->input->post('priority', true);
				$insert_testimonials['is_active'] 		= $this->input->post('is_active', true);
				$insert_testimonials['insert_by']   	= $_SESSION['userid'];
				$insert_testimonials['insert_time'] 	= date('Y-m-d H:i:s');


				$add_testimonials = $this->db->insert('tbl_testimonial',$insert_testimonials);

				if ($add_testimonials) {

					$this->session->set_flashdata('message','Testimonials Added Successfully!');
					redirect('admin/testimonial/list','refresh');

				} else {

				   $this->session->set_flashdata('message','Testimonials Add Failed!');
					redirect('admin/testimonial/list','refresh');
				}
			}

			$data['student_list']    = $this->db->select('id, student_name, student_roll')->where('verified', 1)->order_by('id','asc')->get('tbl_student')->result();

			$data['title']             = 'Testimonials Add';
			$data['activeMenu']        = 'testimonials_add';
			$data['page']              = 'backEnd/admin/testimonials_add';
			
		} elseif ($param1 == 'list' ) {

			$data['testimonials'] = $this->AdminModel->get_testimonial_data();

			$data['title']        = 'Testimonials List';
			$data['activeMenu']   = 'testimonials_list';			
			$data['page']         = 'backEnd/admin/testimonials_list';
		   
		} elseif ($param1 == 'edit' && $param2 > 0) {

			$data['edit_info']   = $this->db->get_where('tbl_testimonial',array('id'=>$param2));

			if ($data['edit_info']->num_rows() > 0) {

				$data['edit_info']    = $data['edit_info']->row();

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					$update_testimonials['student_id']     	= $this->input->post('student_id', true);
					$update_testimonials['name']        	= $this->input->post('name', true);
					$update_testimonials['feedback']    	= $this->input->post('feedback', true);
					$update_testimonials['priority']    	= $this->input->post('priority', true);
					$update_testimonials['is_active'] 		= $this->input->post('is_active', true);

					$update_testimonial = $this->db->where('id', $param2)->update('tbl_testimonial',$update_testimonials);

					if ($update_testimonial) {

						$this->session->set_flashdata('message','Testimonials  Updated Successfully!');
						redirect('admin/testimonial/list','refresh');

					} else {

					   $this->session->set_flashdata('message','Testimonials Update Failed!');
						redirect('admin/testimonial/list','refresh');
					}
				}

			} else {

				$this->session->set_flashdata('message','Wrong Attempt!');
				redirect('admin/testimonial/list','refresh');
			}

			$data['student_list']    = $this->db->select('id, student_name, student_roll')->where('verified', 1)->order_by('id','asc')->get('tbl_student')->result();

			$data['title']      = 'Testimonials Edit';
			$data['activeMenu'] = 'testimonials_edit';
			$data['page']       = 'backEnd/admin/testimonials_edit';
			
		   
		} elseif($param1 == 'delete' && $param2 > 0) {

			$delete_testimonial = $this->db->where('id', $param2)->delete('tbl_testimonial');
			
		   if ($delete_testimonial) {

				$this->session->set_flashdata('message','Testimonials  Deleted Successfully!');
				redirect('admin/testimonial/list','refresh');

			} else {

			   $this->session->set_flashdata('message','Testimonials Deleted Failed!');
				redirect('admin/testimonial/list','refresh');
			}
			
		} else {

			$this->session->set_flashdata('message', 'Wrong Attempt!');
			redirect('admin/testimonial/list','refresh');

		}

		$this->load->view('backEnd/master_page',$data);        
	}

	public function page_settings($param1 = 'add', $param2 = '', $param3 = '') {
        
    	if ($param1 == 'add') {

    		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	    		$page_settings_data['name']           = $this->input->post('name', true);
	    		$page_settings_data['title']          = $this->input->post('title', true);
	    		$page_settings_data['body']           = $this->input->post('body');
	    		$page_settings_data['is_menu']        = $this->input->post('is_menu', true);
	    		$page_settings_data['priority']       = $this->input->post('priority', true);
	    		$page_settings_data['parent_page_id'] = $this->input->post('parent_page_id', true);

	    		if (!empty($_FILES["attatched"]['name'])){

					//exta work
					$path_parts                 = pathinfo($_FILES["attatched"]['name']);
					$newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
					$dir                        = date("YmdHis", time());
					$config['file_name']      = $newfile_name . '_' . $dir;
					$config['remove_spaces']  = TRUE;
					$config['upload_path']    = 'assets/pageSettings/';
					$config['max_size']       = '20000'; //  less than 20 MB
					$config['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG|pdf|docx';

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('attatched')) {

					} else {

						$upload = $this->upload->data();
						$page_settings_data['attatched']   = $config['upload_path'] . $upload['file_name'];

						$file_parts = pathinfo($page_settings_data['attatched']);
	                    if ($file_parts['extension'] != "pdf") {
	                        $this->image_size_fix($page_settings_data['attatched'], $width = 440, $height = 320);
	                    }
					}
				}

				$check_name_exist = $this->db->where('name', $page_settings_data['name'])->get('tbl_common_pages');
				if ($check_name_exist->num_rows() > 0) {

					$this->session->set_flashdata('message','This Page Already Exists!');
					redirect('admin/page_settings', 'refresh');

				}else{

					$page_settings = $this->db->insert('tbl_common_pages', $page_settings_data);

					if ($page_settings) {

						$this->session->set_flashdata('message','Page Created Successfully!');
						redirect('admin/page_settings', 'refresh');

					} else {

						$this->session->set_flashdata('message','Page Create Failed!');
						redirect('admin/page_settings', 'refresh');
					}
					
				}
			}

			$data['title']         = 'Page Setting Add';
            $data['page']          = 'backEnd/admin/page_settings_add';
            $data['activeMenu']    = 'page_settings_add';
            $data['page_settings'] = $this->db->select('id, name')->get('tbl_common_pages')->result();

    	}elseif ($param1 == 'edit' && (int) $param2 > 0) {

			$data['table_info']    = $this->db->where('id', $param2)->get('tbl_common_pages')->row();
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                //exta work
				$path_parts                 	= pathinfo($_FILES["attatched"]['name']);
				$newfile_name               	= preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
				$dir                        	= date("YmdHis", time());
				$config['file_name']        	= $newfile_name . '_' . $dir;
				$config['remove_spaces']    	= TRUE;
				$config['max_size']         	= '20000'; //  less than 20 MB
				$config['allowed_types']    	= 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG|pdf|docx';
                $config['upload_path']      	= 'assets/pageSettings';

                $old_file_url                   = $data['table_info'];
                $update_data['title']           = $this->input->post('title', true);
                $update_data['body']            = $this->input->post('body');
                $update_data['is_menu']         = $this->input->post('is_menu', true);
	    		$update_data['priority']        = $this->input->post('priority', true);
	    		$update_data['parent_page_id']  = $this->input->post('parent_page_id', true);

                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('attatched')) {

                    $this->session->set_flashdata('message', 'Data Updated Successfully');
                    $this->db->where('id', $param2)->update('tbl_common_pages', $update_data);
					
                    redirect('admin/page_settings/list','refresh');
                } else {

                    $upload = $this->upload->data();

                    $update_data['attatched'] = $config['upload_path'] . '/' . $upload['file_name'];
                    $this->db->where('id', $param2)->update('tbl_common_pages', $update_data);
                    $file_parts = pathinfo($update_data['attatched']);
                    if ($file_parts['extension'] != "pdf") {
                        $this->image_size_fix($update_data['attatched'], $width = 440, $height = 320);
                    }
                    if(file_exists($old_file_url->attatched)) unlink($old_file_url->attatched);
                    $this->session->set_flashdata('message', 'Data Updated Successfully');
                	redirect('admin/page_settings/list', 'refresh');

                }
            }

           
           
            $data['page_settings'] = $this->db->select('id, name')->where('id !=', $param2)->get('tbl_common_pages')->result();



			$data['title']         = 'Page Setting Update';
            $data['page']          = 'backEnd/admin/page_settings_edit';
            $data['activeMenu']    = 'page_settings_edit';
        }elseif ($param1 == 'list') {

        	$data['title']      = 'Page Setting List';
            $data['page']       = 'backEnd/admin/page_settings_list';
            $data['activeMenu'] = 'page_settings_list';
        	$data['table_info'] = $this->db->get('tbl_common_pages')->result_array();
        }elseif ($param1 == 'delete' && (int) $param2 > 0) {

        	$attatched = $this->db->where('id', $param2)->get('tbl_common_pages')->row()->attatched;

        	if (file_exists($attatched)) {

        		unlink($attatched);
        	}

        	$page_settings_delete = $this->db->where('id', $param2)->delete('tbl_common_pages');

        	

			if ($page_settings_delete) {

				$this->session->set_flashdata('message','Page Deleted Successfully!');
				redirect('admin/page_settings/list','refresh');

			} else {

				$this->session->set_flashdata('message','Page Delete Failed!');
				redirect('admin/page_settings/list','refresh');
			}
        }else {

        	$this->session->set_flashdata('message','Wrong Attempt!');
			redirect('admin/page_settings/list','refresh');
        }

        $this->load->view('backEnd/master_page', $data);
    }

    public function sms_send($param1 = 'list', $param2 = '', $param3 = '')
	{
		if ($param1 == 'list') {

			$data['title']         = 'SMS Send';
			$data['activeMenu']    = 'sms_send';
			$data['page']          = 'backEnd/admin/sms_send_list';
			//$data['sms_send_list'] = $this->db->order_by('send_date_time','desc')->get('tbl_sms_send_list')->result();


		} elseif ($param1 == 'setting') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$setting_data['username'] = $this->input->post('username', true);
				$setting_data['password'] = $this->input->post('password', true);

				$update_setting = $this->db->where('id', 1)->update('tbl_sms_send_setting', $setting_data);

				if ($update_setting) {

					$this->session->set_flashdata('message','SMS Setting Updated Successfully!');
					redirect('admin/sms_send/setting','refresh');

				} else {

					$this->session->set_flashdata('message','SMS Setting Update Failed!');
					redirect('admin/sms_send/setting','refresh');

				}
				
			}

			$data['title']        = 'SMS Send';
			$data['activeMenu']   = 'sms_send';
			$data['page']         = 'backEnd/admin/sms_send_setting';
			//$data['setting_info'] = $this->db->where('id',1)->get('tbl_sms_send_setting')->row();

		} elseif ($param1 == 'new_sms') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$sms_send_data['send_date_time']   = date('Y-m-d H:i:s');
				$sms_send_data['message']          = $this->input->post('message', true);
				$sms_send_data['receiver_numbers'] = $this->input->post('receiver_numbers', true);
				$sms_send_data['insert_by']        = $_SESSION['userid'];

				$sms_send_add = $this->db->insert('tbl_sms_send_list', $sms_send_data);

				if ($sms_send_add) {

					$this->session->set_flashdata('message','Message Send Successfully!');
					redirect('admin/sms_send/new_sms','refresh');

				} else {

					$this->session->set_flashdata('message','Message Send Failed!');
					redirect('admin/sms_send/new_sms','refresh');

				}
				
			}

			$data['title']         = 'SMS Send';
			$data['activeMenu']    = 'sms_send';
			$data['page']          = 'backEnd/admin/sms_send_new';
			
		} else{

			$this->session->set_flashdata('message','Wrong Attempt!');
			redirect('admin/sms_send/list','refresh');
		}

		$this->load->view('backEnd/master_page', $data);
	}

	public function get_sms_number($sms_to)
	{
		if ($sms_to == 1) {

			$result = $this->db->select('mobile')->get('tbl_members')->result();

			$mobile = '';

			foreach ($result as $key => $value) {

				if($mobile != '') if($value->mobile != '') $mobile .= ',';
				$mobile .= $value->mobile;
				
			}

			echo json_encode($mobile, JSON_UNESCAPED_UNICODE);

		} else {

			$result = $this->db->select('phone as mobile')->get('tbl_committee')->result();

			$mobile = '';

			foreach ($result as $key => $value) {

				if($mobile != '') if($value->mobile != '') $mobile .= ',';
				$mobile .= $value->mobile;
				
			}
			echo json_encode($mobile, JSON_UNESCAPED_UNICODE);
		}
		
	}

	public function mail_setting()
	{

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			foreach ($this->input->post('mail_setting_id', true) as $key => $id_value) {

				$id    = $id_value;
				$value = $this->input->post('value', true)[$key];

				$this->db->where('id', $id)->update('tbl_mail_send_setting', array('value'=>$value));

			}

			$this->session->set_flashdata('message','Mail Send Setting Updated Successfully!');
			redirect('admin/mail_setting','refresh');
		}

		$data['title']             = 'Mail Setting';
		$data['activeMenu']        = 'mail_setting';
		$data['page']              = 'backEnd/admin/mail_setting';
		$data['mail_setting_info'] = $this->db->get('tbl_mail_send_setting')->result();
		$this->load->view('backEnd/master_page', $data);
	}

	public function course_category($param1 = 'add', $param2 = '', $param3 = '')
	{
		if ($param1 == 'add') {

		   if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			   	$category_data['title']   		= $this->input->post('title', true);
			   	$category_data['insert_by']   	= $_SESSION['userid'];
				$category_data['insert_time'] 	= date('Y-m-d H:i:s');
			   
			   $add_course_category = $this->db->insert('tbl_course_category',$category_data);

			   if ($add_course_category) {

					$this->session->set_flashdata('message','Course Category Added Successfully!');
					redirect('admin/course_category','refresh');

			   } else {

					$this->session->set_flashdata('message','Course Category Add Failed!');
					redirect('admin/course_category','refresh');
			   }
			   
		   }
		}elseif ($param1 == 'edit' && $param2 > 0) {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$category_data['title']   		= $this->input->post('title', true);				

				$update_course_sub_category = $this->db->where('id',$param2)->update('tbl_course_category',$category_data);

			    	if ($update_course_sub_category) {

					$this->session->set_flashdata('message','Course Category Updated Successfully!');
					redirect('admin/course_category','refresh');

			    	} else {

				   $this->session->set_flashdata('message','Course Category Update Failed!');
					redirect('admin/course_category','refresh');
				}
			}

			$data['edit_info'] = $this->db->get_where('tbl_course_category',array('id'=>$param2));

			if ($data['edit_info']->num_rows() > 0) {

				$data['edit_info']    = $data['edit_info']->row();

			} else {

				$this->session->set_flashdata('message','Wrong Attempt!');
				redirect('admin/course_category','refresh');
			}
		
		   
		}elseif ($param1 == 'delete' && $param2 > 0) {

			$delete_course_category = $this->db->where('id',$param2)->delete('tbl_course_category');

			if ($delete_course_category) {

				$this->session->set_flashdata('message','Course Category Deleted Successfully!');
				redirect('admin/course_category','refresh');

		   } else {

			   $this->session->set_flashdata('message','Course Category Delete Failed!');
				redirect('admin/course_category','refresh');
		   }
		}

		$data['course_category_list']    = $this->db->order_by('id','desc')->get('tbl_course_category')->result();

		$data['title']      = 'Course Category';
		$data['activeMenu'] = 'course_category';
		$data['page']       = 'backEnd/admin/course_category';
		
		$this->load->view('backEnd/master_page',$data);
	}

	public function course_sub_category ($param1 = 'add', $param2 = '', $param3 = '') 
	{

		if ($param1 == 'add') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$sub_category_data['title']         		= $this->input->post('title', true);
				$sub_category_data['course_category_id']   	= $this->input->post('course_category_id', true);
				$sub_category_data['insert_by']     		= $_SESSION['userid'];
				$sub_category_data['insert_time']   		= date('Y-m-d H:i:s');
				
				$add_course_sub_category = $this->db->insert('tbl_course_sub_category',$sub_category_data);

				if ($add_course_sub_category) {

				$this->session->set_flashdata('message','Course Sub Category Added Successfully!');
					redirect('admin/course_sub_category','refresh');

				} else {

				 $this->session->set_flashdata('message','Course Sub Category Add Failed!');
					redirect('admin/course_sub_category','refresh');
				}
			}

		} elseif ($param1 == 'edit' && $param2 > 0) {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$sub_category_data['title']         		= $this->input->post('title', true);
				$sub_category_data['course_category_id']   	= $this->input->post('course_category_id', true);

				$update_course_sub_category = $this->db->where('id',$param2)->update('tbl_course_sub_category',$sub_category_data);

			    	if ($update_course_sub_category) {

					$this->session->set_flashdata('message','Course Sub Category Updated Successfully!');
					redirect('admin/course_sub_category','refresh');

			    	} else {

				   $this->session->set_flashdata('message','Course Sub Category Update Failed!');
					redirect('admin/course_sub_category','refresh');
				}
			}

			$data['edit_info'] = $this->db->get_where('tbl_course_sub_category',array('id'=>$param2));

			if ($data['edit_info']->num_rows() > 0) {

				$data['edit_info']    = $data['edit_info']->row();

			} else {

				$this->session->set_flashdata('message','Wrong Attempt!');
				redirect('admin/course_sub_category','refresh');
			}
		
		   
		} elseif($param1 == 'delete' && $param2 > 0) {

			$delete_course_sub_category = $this->db->where('id',$param2)->delete('tbl_course_sub_category');
			
		   if ($delete_course_sub_category) {

				$this->session->set_flashdata('message','Course Sub Category Deleted Successfully!');
				redirect('admin/course_sub_category','refresh');

			} else {

			   $this->session->set_flashdata('message','Course Sub Category Deleted Failed!');
				redirect('admin/course_sub_category','refresh');
			}
			
		} else {

			$this->session->set_flashdata('message', 'Wrong Attempt!');
			redirect('admin/course_sub_category','refresh');

		}

		$data['courese_category_data'] 	 	= $this->db->select('id,title')->get('tbl_course_category')->result();
		$data['course_sub_category_list'] 	= $this->AdminModel->get_course_sub_category();

		$data['title']        	     = 'Manage Course Sub Category';
		$data['activeMenu']   	     = 'course_sub_category';
		$data['page']         		 = 'backEnd/admin/course_sub_category';
		
	
		$this->load->view('backEnd/master_page',$data);
	}

	public function day($param1 = 'add', $param2 = '', $param3 = '')
	{
		if ($param1 == 'add') {

		   if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			   	$day_data['day_to_day']   		= $this->input->post('day_to_day', true);
			   	$day_data['insert_by']   		= $_SESSION['userid'];
				$day_data['insert_time'] 		= date('Y-m-d H:i:s');
			   
			   	$add_day = $this->db->insert('tbl_day_setting',$day_data);

			   if ($add_day) {

					$this->session->set_flashdata('message','Day Added Successfully!');
					redirect('admin/day','refresh');

			   } else {

					$this->session->set_flashdata('message','Day Add Failed!');
					redirect('admin/day','refresh');
			   }
			   
		   }
		}elseif ($param1 == 'edit' && $param2 > 0) {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$day_data['day_to_day']   		= $this->input->post('day_to_day', true);				

				$update_day = $this->db->where('id',$param2)->update('tbl_day_setting',$day_data);

			    	if ($update_day) {

					$this->session->set_flashdata('message','Day Updated Successfully!');
					redirect('admin/day','refresh');

			    	} else {

				   $this->session->set_flashdata('message','Day Update Failed!');
					redirect('admin/day','refresh');
				}
			}

			$data['edit_info'] = $this->db->get_where('tbl_day_setting',array('id'=>$param2));

			if ($data['edit_info']->num_rows() > 0) {

				$data['edit_info']    = $data['edit_info']->row();

			} else {

				$this->session->set_flashdata('message','Wrong Attempt!');
				redirect('admin/day','refresh');
			}
		
		   
		}elseif ($param1 == 'delete' && $param2 > 0) {

			$delete_day = $this->db->where('id',$param2)->delete('tbl_day_setting');

			if ($delete_day) {

				$this->session->set_flashdata('message','Day Deleted Successfully!');
				redirect('admin/day','refresh');

		   } else {

			   $this->session->set_flashdata('message','Day Delete Failed!');
				redirect('admin/day','refresh');
		   }
		}

		$data['day_list']    = $this->db->order_by('id','desc')->get('tbl_day_setting')->result();

		$data['title']      = 'Day';
		$data['activeMenu'] = 'day';
		$data['page']       = 'backEnd/admin/day';
		
		$this->load->view('backEnd/master_page',$data);
	}

	public function time($param1 = 'add', $param2 = '', $param3 = '')
	{
		if ($param1 == 'add') {

		   if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			   	$time_data['time_to_time']   	= $this->input->post('time_to_time', true);
			   	$time_data['insert_by']   		= $_SESSION['userid'];
				$time_data['insert_time'] 		= date('Y-m-d H:i:s');
			   
			   	$add_time = $this->db->insert('tbl_time_setting',$time_data);

			   if ($add_time) {

					$this->session->set_flashdata('message','Time Added Successfully!');
					redirect('admin/time','refresh');

			   } else {

					$this->session->set_flashdata('message','Time Add Failed!');
					redirect('admin/time','refresh');
			   }
			   
		   }
		}elseif ($param1 == 'edit' && $param2 > 0) {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$time_data['time_to_time']   		= $this->input->post('time_to_time', true);				

				$update_time = $this->db->where('id',$param2)->update('tbl_time_setting',$time_data);

			    	if ($update_time) {

					$this->session->set_flashdata('message','Time Updated Successfully!');
					redirect('admin/time','refresh');

			    	} else {

				   $this->session->set_flashdata('message','Time Update Failed!');
					redirect('admin/time','refresh');
				}
			}

			$data['edit_info'] = $this->db->get_where('tbl_time_setting',array('id'=>$param2));

			if ($data['edit_info']->num_rows() > 0) {

				$data['edit_info']    = $data['edit_info']->row();

			} else {

				$this->session->set_flashdata('message','Wrong Attempt!');
				redirect('admin/time','refresh');
			}
		
		   
		}elseif ($param1 == 'delete' && $param2 > 0) {

			$delete_time = $this->db->where('id',$param2)->delete('tbl_time_setting');

			if ($delete_time) {

				$this->session->set_flashdata('message','Time Deleted Successfully!');
				redirect('admin/time','refresh');

		   } else {

			   $this->session->set_flashdata('message','Time Delete Failed!');
				redirect('admin/time','refresh');
		   }
		}

		$data['time_list']    = $this->db->order_by('id','desc')->get('tbl_time_setting')->result();

		$data['title']      = 'Time';
		$data['activeMenu'] = 'time';
		$data['page']       = 'backEnd/admin/time';
		
		$this->load->view('backEnd/master_page',$data);
	}

	public function course($param1 = 'add', $param2 = '', $param3 = '')
	{
		if ($param1 == 'add') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$insert_courses['course_title']        		= $this->input->post('course_title', true);				
				$insert_courses['course_category_id']    	= $this->input->post('course_category_id', true);
				$insert_courses['course_sub_category_id']   = $this->input->post('course_sub_category_id', true);				
				$insert_courses['course_price']    			= $this->input->post('course_price', true);
				$insert_courses['course_discount']    		= $this->input->post('course_discount', true);
				$insert_courses['course_level']    			= $this->input->post('course_level', true);
				$insert_courses['course_trailer']    		= $this->input->post('course_trailer', true);
				$insert_courses['is_exclusive']    			= $this->input->post('is_exclusive', true);
				$insert_courses['course_description'] 		= $this->input->post('course_description', true);
				$insert_courses['publish_status']    		= $this->input->post('publish_status', true);
				$insert_courses['is_free_course']    		= $this->input->post('is_free_course', true);
				$insert_courses['day_setting_id']    		= $this->input->post('day_setting_id', true);
				$insert_courses['time_setting_id']    		= $this->input->post('time_setting_id', true);	
				$insert_courses['course_tags']     			= "";	
				$insert_courses['requirements']				= "";
				$insert_courses['outcomes']					= "";									

				$insert_courses['insert_by']   				= $_SESSION['userid'];
				$insert_courses['insert_time'] 				= date('Y-m-d H:i:s');				

				foreach($this->input->post('course_tags',true) as $key => $single_tag) {
					if(strlen($single_tag) > 1) {
					  if($key > 0) $insert_courses['course_tags'] .=  "**";
					  $insert_courses['course_tags'] .= $single_tag;
					}
				}

				foreach($this->input->post('requirements',true) as $key => $single_requirement) {
					if(strlen($single_requirement) > 1) {
					  if($key > 0) $insert_courses['requirements'] .=  "**";
					  $insert_courses['requirements'] .= $single_requirement;
					}
				}

				foreach($this->input->post('outcomes',true) as $key => $single_outcome) {
					if(strlen($single_outcome) > 1) {
					  if($key > 0) $insert_courses['outcomes'] .=  "**";
					  $insert_courses['outcomes'] .= $single_outcome;
					}
				}

				if (!empty($_FILES['course_photo']['name'])) {

					$path_parts                 = pathinfo($_FILES["course_photo"]['name']);
					$newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
					$dir                        = date("YmdHis", time());
					$config_c['file_name']      = $newfile_name . '_' . $dir;
					$config_c['remove_spaces']  = TRUE;
					$config_c['upload_path']    = 'assets/coursesPhoto/';
					$config_c['max_size']       = '20000'; //  less than 20 MB
					$config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

					$this->load->library('upload', $config_c);
					$this->upload->initialize($config_c);
					if (!$this->upload->do_upload('course_photo')) {

					} else {

						$upload_c = $this->upload->data();
						$insert_courses['course_photo'] = $config_c['upload_path'] . $upload_c['file_name'];
						//$this->image_size_fix($insert_courses['course_photo'], 400, 400);
					}
					
				}

				$add_courses = $this->db->insert('tbl_courses',$insert_courses);

				if ($add_courses) {

					$this->session->set_flashdata('message','Course Added Successfully!');
					redirect('admin/course/list','refresh');

				} else {

				   $this->session->set_flashdata('message','Course Add Failed!');
					redirect('admin/course/list','refresh');
				}
			}

			$data['category_data'] 	 	= $this->db->select('id,title')->get('tbl_course_category')->result();
			$data['sub_category_data'] 	= $this->db->select('id,title')->get('tbl_course_sub_category')->result();
			$data['day_data'] 	 		= $this->db->select('id, day_to_day')->get('tbl_day_setting')->result();
			$data['time_data'] 	 		= $this->db->select('id, time_to_time')->get('tbl_time_setting')->result();

			$data['title']             = 'Course Add';
			$data['activeMenu']        = 'course_add';
			$data['page']              = 'backEnd/admin/course_add';
			
		} elseif ($param1 == 'list' ) {

			$data['courses'] = $this->AdminModel->get_course_data(); 

			$data['title']        = 'Course List';
			$data['activeMenu']   = 'course_list';			
			$data['page']         = 'backEnd/admin/course_list';
		   
		} elseif ($param1 == 'edit' && $param2 > 0) {

			$data['edit_info']   = $this->db->get_where('tbl_courses',array('id'=>$param2));

			if ($data['edit_info']->num_rows() > 0) {

				$data['edit_info']    = $data['edit_info']->row();

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					$update_courses['course_title']        		= $this->input->post('course_title', true);				
					$update_courses['course_category_id']    	= $this->input->post('course_category_id', true);
					$update_courses['course_sub_category_id']   = $this->input->post('course_sub_category_id', true);				
					$update_courses['course_price']    			= $this->input->post('course_price', true);
					$update_courses['course_discount']    		= $this->input->post('course_discount', true);
					$update_courses['course_level']    			= $this->input->post('course_level', true);
					$update_courses['course_trailer']    		= $this->input->post('course_trailer', true);
					$update_courses['is_exclusive']    			= $this->input->post('is_exclusive', true);
					$update_courses['course_description'] 		= $this->input->post('course_description', true);
					$update_courses['publish_status']    		= $this->input->post('publish_status', true);
					$update_courses['is_free_course']    		= $this->input->post('is_free_course', true);
					$update_courses['day_setting_id']    		= $this->input->post('day_setting_id', true);
					$update_courses['time_setting_id']    		= $this->input->post('time_setting_id', true);
					$update_courses['course_tags']     			= "";	
					$update_courses['requirements']				= "";
					$update_courses['outcomes']					= "";									

					foreach($this->input->post('course_tags',true) as $key => $single_tag) {
						if(strlen($single_tag) > 1) {
						  if($key > 0) $update_courses['course_tags'] .=  "**";
						  $update_courses['course_tags'] .= $single_tag;
						}
					}
	
					foreach($this->input->post('requirements',true) as $key => $single_requirement) {
						if(strlen($single_requirement) > 1) {
						  if($key > 0) $update_courses['requirements'] .=  "**";
						  $update_courses['requirements'] .= $single_requirement;
						}
					}
	
					foreach($this->input->post('outcomes',true) as $key => $single_outcome) {
						if(strlen($single_outcome) > 1) {
						  if($key > 0) $update_courses['outcomes'] .=  "**";
						  $update_courses['outcomes'] .= $single_outcome;
						}
					}
	
					if (!empty($_FILES['course_photo']['name'])) {
	
						$path_parts                 = pathinfo($_FILES["course_photo"]['name']);
						$newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
						$dir                        = date("YmdHis", time());
						$config_c['file_name']      = $newfile_name . '_' . $dir;
						$config_c['remove_spaces']  = TRUE;
						$config_c['upload_path']    = 'assets/coursesPhoto/';
						$config_c['max_size']       = '20000'; //  less than 20 MB
						$config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';
	
						$this->load->library('upload', $config_c);
						$this->upload->initialize($config_c);
						if (!$this->upload->do_upload('course_photo')) {
	
						} else {
	
							$upload_c = $this->upload->data();
							$update_courses['course_photo'] = $config_c['upload_path'] . $upload_c['file_name'];
							//$this->image_size_fix($insert_courses['course_photo'], 400, 400);
						}
						
					}

					if ($this->AdminModel->update_courses($update_courses, $param2)) {

						$this->session->set_flashdata('message','courses  Updated Successfully!');
						redirect('admin/course/list','refresh');

					} else {

					   $this->session->set_flashdata('message','courses Update Failed!');
						redirect('admin/course/list','refresh');
					}
				}

			} else {

				$this->session->set_flashdata('message','Wrong Attempt!');
				redirect('admin/course/list','refresh');
			}

			$data['category_data'] 	 	= $this->db->select('id,title')->get('tbl_course_category')->result();
			$data['sub_category_data'] 	= $this->db->select('id,title')->get('tbl_course_sub_category')->result();
			$data['day_data'] 	 		= $this->db->select('id, day_to_day')->get('tbl_day_setting')->result();
			$data['time_data'] 	 		= $this->db->select('id, time_to_time')->get('tbl_time_setting')->result();


			$data['title']      = 'Course Edit';
			$data['activeMenu'] = 'course_edit';
			$data['page']       = 'backEnd/admin/course_edit';
			
		   
		} elseif($param1 == 'delete' && $param2 > 0) {
			
		   if ($this->AdminModel->delete_courses($param2)) {

				$this->session->set_flashdata('message','courses  Deleted Successfully!');
				redirect('admin/course/list','refresh');

			} else {

			   $this->session->set_flashdata('message','courses Deleted Failed!');
				redirect('admin/course/list','refresh');
			}
			
		} else {

			$this->session->set_flashdata('message', 'Wrong Attempt!');
			redirect('admin/course/list','refresh');

		}

		$this->load->view('backEnd/master_page',$data);        
	}

	public function lecture_quiz($param1 = 'add', $param2 = '', $param3 = '')
	{
		if ($param1 == 'add') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$lecture_quiz_data['course_id']        	= $this->input->post('course_id', true);				
				$lecture_quiz_data['lecture_id'] 		= $this->input->post('lecture_id', true);
				$lecture_quiz_data['quiz_question'] 	= $this->input->post('quiz_question', true);
				$lecture_quiz_data['option_1'] 			= $this->input->post('option_1', true);
				$lecture_quiz_data['option_2'] 			= $this->input->post('option_2', true);
				$lecture_quiz_data['option_3'] 			= $this->input->post('option_3', true);
				$lecture_quiz_data['option_4'] 			= $this->input->post('option_4', true);
				$lecture_quiz_data['option_5'] 			= $this->input->post('option_5', true);	
				$lecture_quiz_data['correct_options'] 	= $this->input->post('correct_options', true);	
				$lecture_quiz_data['explanation'] 		= $this->input->post('explanation', true);				
				$lecture_quiz_data['insert_time'] 		= date('Y-m-d H:i:s');
				$lecture_quiz_data['insert_by'] 		= $_SESSION['userid'];

				$add_course_lectures = $this->db->insert('tbl_lecture_quiz',$lecture_quiz_data);

				if ($add_course_lectures) {

					$this->session->set_flashdata('message','Lecture Quiz Added Successfully!');
					redirect('admin/lecture_quiz/list','refresh');

				} else {

				   $this->session->set_flashdata('message','Lecture Quiz Add Failed!');
					redirect('admin/lecture_quiz/list','refresh');
				}
			}

			$data['course_data'] 	  		= $this->db->select('id, course_title')->get('tbl_courses')->result();			

			$data['title']             = 'Lecture Quiz Add';
			$data['activeMenu']        = 'lecture_quiz_add';
			$data['page']              = 'backEnd/admin/lecture_quiz_add';
			
		} elseif ($param1 == 'list' ) {

			$data['lecture_quiz_list'] = $this->AdminModel->get_lecture_quiz_data();

			$data['title']        = 'Lecture Quiz List';
			$data['activeMenu']   = 'lecture_quiz_list';			
			$data['page']         = 'backEnd/admin/lecture_quiz_list';
		   
		} elseif ($param1 == 'edit' && $param2 > 0) {

			$data['edit_info']   = $this->db->get_where('tbl_lecture_quiz',array('id'=>$param2));

			if ($data['edit_info']->num_rows() > 0) {

				$data['edit_info']    = $data['edit_info']->row();

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					$lecture_quiz_data['course_id']        	= $this->input->post('course_id', true);				
					$lecture_quiz_data['lecture_id'] 		= $this->input->post('lecture_id', true);
					$lecture_quiz_data['quiz_question'] 	= $this->input->post('quiz_question', true);
					$lecture_quiz_data['option_1'] 			= $this->input->post('option_1', true);
					$lecture_quiz_data['option_2'] 			= $this->input->post('option_2', true);
					$lecture_quiz_data['option_3'] 			= $this->input->post('option_3', true);
					$lecture_quiz_data['option_4'] 			= $this->input->post('option_4', true);
					$lecture_quiz_data['option_5'] 			= $this->input->post('option_5', true);	
					$lecture_quiz_data['correct_options'] 	= $this->input->post('correct_options', true);	
					$lecture_quiz_data['explanation'] 		= $this->input->post('explanation', true);
				
					$update_lecture_quiz = $this->db->where('id',$param2)->update('tbl_lecture_quiz', $lecture_quiz_data);

					if ($update_lecture_quiz) {

						$this->session->set_flashdata('message','Lecture Quiz Updated Successfully!');
						redirect('admin/lecture_quiz/list','refresh');

					} else {

					   $this->session->set_flashdata('message','Lecture Quiz Update Failed!');
						redirect('admin/lecture_quiz/list','refresh');
					}
				}

			} else {

				$this->session->set_flashdata('message','Wrong Attempt!');
				redirect('admin/lecture_quiz/list','refresh');
			}

			$data['course_data'] 	  		= $this->db->select('id, course_title')->get('tbl_courses')->result();			
			$data['course_lecture_data'] 	= $this->db->select('id, title')->get('tbl_course_lecture')->result();

			$data['title']      = 'Lecture Quiz Edit';
			$data['activeMenu'] = 'lecture_quiz_edit';
			$data['page']       = 'backEnd/admin/lecture_quiz_edit';
			
		   
		} elseif($param1 == 'delete' && $param2 > 0) {

			$delete_lecture_quiz = $this->db->where('id',$param2)->delete('tbl_lecture_quiz');
			
		   if ($delete_lecture_quiz) {

				$this->session->set_flashdata('message','Lecture Quiz  Deleted Successfully!');
				redirect('admin/lecture_quiz/list','refresh');

			} else {

			   $this->session->set_flashdata('message','Lecture Quiz Deleted Failed!');
				redirect('admin/lecture_quiz/list','refresh');
			}
			
		} else {

			$this->session->set_flashdata('message', 'Wrong Attempt!');
			redirect('admin/lecture_quiz/list','refresh');

		}

		$this->load->view('backEnd/master_page',$data);        
	}
	
	public function lecture_sections ($param1 = 'add', $param2 = '', $param3 = '') 
	{

		if ($param1 == 'add') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$lecture_sections_data['course_id']         = $this->input->post('course_id', true);
				$lecture_sections_data['section_name']   	= $this->input->post('section_name', true);
				$lecture_sections_data['insert_by']     	= $_SESSION['userid'];
				$lecture_sections_data['insert_time']   	= date('Y-m-d H:i:s');
				
				$add_lecture_sections = $this->db->insert('tbl_course_lecture_sections', $lecture_sections_data);

				if ($add_lecture_sections) {

				$this->session->set_flashdata('message','Lecture Section Added Successfully!');
					redirect('admin/lecture_sections','refresh');

				} else {

				 $this->session->set_flashdata('message','Lecture Section Add Failed!');
					redirect('admin/lecture_sections','refresh');
				}
			}

		} elseif ($param1 == 'edit' && $param2 > 0) {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$lecture_sections_data['course_id']         = $this->input->post('course_id', true);
				$lecture_sections_data['section_name']   	= $this->input->post('section_name', true);

				$update_lecture_sections = $this->db->where('id',$param2)->update('tbl_course_lecture_sections', $lecture_sections_data);

			    	if ($update_lecture_sections) {

					$this->session->set_flashdata('message','Lecture Section Updated Successfully!');
					redirect('admin/lecture_sections','refresh');

			    	} else {

				   $this->session->set_flashdata('message','Lecture Section Update Failed!');
					redirect('admin/lecture_sections','refresh');
				}
			}

			$data['edit_info'] = $this->db->get_where('tbl_course_lecture_sections',array('id'=>$param2));

			if ($data['edit_info']->num_rows() > 0) {

				$data['edit_info']    = $data['edit_info']->row();

			} else {

				$this->session->set_flashdata('message','Wrong Attempt!');
				redirect('admin/lecture_sections','refresh');
			}
		
		   
		} elseif($param1 == 'delete' && $param2 > 0) {

			$delete_lecture_sections = $this->db->where('id',$param2)->delete('tbl_course_lecture_sections');
			
		   if ($delete_lecture_sections) {

				$this->session->set_flashdata('message','Lecture Section Deleted Successfully!');
				redirect('admin/lecture_sections','refresh');

			} else {

			   $this->session->set_flashdata('message','Lecture Section Deleted Failed!');
				redirect('admin/lecture_sections','refresh');
			}
			
		} else {

			$this->session->set_flashdata('message', 'Wrong Attempt!');
			redirect('admin/lecture_sections','refresh');

		}

		$data['course_data'] 	 		= $this->db->select('id, course_title')->get('tbl_courses')->result();
		$data['lecture_sections_list'] 	= $this->AdminModel->get_lecture_sections_data();

		$data['title']        	     = 'Manage Lecture Section';
		$data['activeMenu']   	     = 'lecture_sections';
		$data['page']         		 = 'backEnd/admin/lecture_sections';
		
	
		$this->load->view('backEnd/master_page',$data);
	}

	public function course_lecture($param1 = 'add', $param2 = '', $param3 = '')
	{
		if ($param1 == 'add') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$course_lectures_data['course_id']        			= $this->input->post('course_id', true);
				$course_lectures_data['instructor_id']    			= $this->input->post('instructor_id', true);
				$course_lectures_data['course_lecture_section_id'] 	= $this->input->post('course_lecture_section_id', true);
				$course_lectures_data['title'] 						= $this->input->post('title', true);
				$course_lectures_data['sort_description'] 			= $this->input->post('sort_description', true);
				$course_lectures_data['lecture_price'] 				= $this->input->post('lecture_price', true);
				$course_lectures_data['lecture_discount'] 			= $this->input->post('lecture_discount', true);
				$course_lectures_data['video_server'] 				= $this->input->post('video_server', true);
				$course_lectures_data['video_link'] 				= $this->input->post('video_link', true);				
				$course_lectures_data['insert_time'] 				= date('Y-m-d H:i:s');
				$course_lectures_data['last_update'] 				= date('Y-m-d H:i:s');
				$course_lectures_data['keywords'] 					= "";

				foreach($this->input->post('keywords',true) as $key => $single_keyword) {
					if(strlen($single_keyword) > 1) {
					  if($key > 0) $course_lectures_data['keywords'] .=  "**";
					  $course_lectures_data['keywords'] .= $single_keyword;
					}
				}
				
				$add_course_lectures = $this->db->insert('tbl_course_lecture',$course_lectures_data);

				if ($add_course_lectures) {

					$this->session->set_flashdata('message','Course Lecture Added Successfully!');
					redirect('admin/course_lecture/list','refresh');

				} else {

				   $this->session->set_flashdata('message','Course Lecture Add Failed!');
					redirect('admin/course_lecture/list','refresh');
				}
			}

			$data['course_data'] 	  		= $this->db->select('id, course_title')->get('tbl_courses')->result();
			$data['instructor_data'] 		= $this->db->select('id, firstname, lastname')->where('userType', 'instructor')->get('user')->result();
			$data['lecture_section_data'] 	= $this->db->select('id, section_name')->get('tbl_course_lecture_sections')->result();

			$data['title']             = 'Course Lecture Add';
			$data['activeMenu']        = 'course_lecture_add';
			$data['page']              = 'backEnd/admin/course_lecture_add';
			
		} elseif ($param1 == 'list' ) {

			$data['course_lectures_list'] = $this->AdminModel->get_course_lecture_data();

			$data['title']        = 'Course Lecture List';
			$data['activeMenu']   = 'course_lecture_list';			
			$data['page']         = 'backEnd/admin/course_lecture_list';
		   
		} elseif ($param1 == 'edit' && $param2 > 0) {

			$data['edit_info']   = $this->db->get_where('tbl_course_lecture',array('id'=>$param2));

			if ($data['edit_info']->num_rows() > 0) {

				$data['edit_info']    = $data['edit_info']->row();

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					$course_lectures_data['course_id']        			= $this->input->post('course_id', true);
					$course_lectures_data['instructor_id']    			= $this->input->post('instructor_id', true);
					$course_lectures_data['course_lecture_section_id'] 	= $this->input->post('course_lecture_section_id', true);
					$course_lectures_data['title'] 						= $this->input->post('title', true);
					$course_lectures_data['sort_description'] 			= $this->input->post('sort_description', true);
					$course_lectures_data['lecture_price'] 				= $this->input->post('lecture_price', true);
					$course_lectures_data['lecture_discount'] 			= $this->input->post('lecture_discount', true);
					$course_lectures_data['video_server'] 				= $this->input->post('video_server', true);
					$course_lectures_data['video_link'] 				= $this->input->post('video_link', true);								
					$course_lectures_data['last_update'] 				= date('Y-m-d H:i:s');
					$course_lectures_data['keywords'] 					= "";

					foreach($this->input->post('keywords',true) as $key => $single_keyword) {
						if(strlen($single_keyword) > 1) {
							if($key > 0) $course_lectures_data['keywords'] .=  "**";
							$course_lectures_data['keywords'] .= $single_keyword;
						}
					}

					$update_course_lectures = $this->db->where('id',$param2)->update('tbl_course_lecture', $course_lectures_data);

					if ($update_course_lectures) {

						$this->session->set_flashdata('message','Course Lecture Updated Successfully!');
						redirect('admin/course_lecture/list','refresh');

					} else {

					   $this->session->set_flashdata('message','Course Lecture Update Failed!');
						redirect('admin/course_lecture/list','refresh');
					}
				}

			} else {

				$this->session->set_flashdata('message','Wrong Attempt!');
				redirect('admin/course_lecture/list','refresh');
			}

			$data['course_data'] 	  		= $this->db->select('id, course_title')->get('tbl_courses')->result();
			$data['instructor_data'] 		= $this->db->select('id, firstname, lastname')->where('userType', 'instructor')->get('user')->result();
			$data['lecture_section_data'] 	= $this->db->select('id, section_name')->get('tbl_course_lecture_sections')->result();

			$data['title']      = 'Course Lecture Edit';
			$data['activeMenu'] = 'course_lecture_edit';
			$data['page']       = 'backEnd/admin/course_lecture_edit';
			
		   
		} elseif($param1 == 'delete' && $param2 > 0) {

			$delete_course_lecture = $this->db->where('id',$param2)->delete('tbl_course_lecture');
			
		   if ($delete_course_lecture) {

				$this->session->set_flashdata('message','Course Lecture  Deleted Successfully!');
				redirect('admin/course_lecture/list','refresh');

			} else {

			   $this->session->set_flashdata('message','Course Lecture Deleted Failed!');
				redirect('admin/course_lecture/list','refresh');
			}
			
		} else {

			$this->session->set_flashdata('message', 'Wrong Attempt!');
			redirect('admin/course_lecture/list','refresh');

		}

		$this->load->view('backEnd/master_page',$data);        
	}

	public function get_course_from_category($course_category_id = 1) {

		$result = $this->db->select('id, course_title')->where('course_category_id', $course_category_id)->get('tbl_courses')->result();
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}
	
	public function get_lecture_from_course_category( $course_id = 1) {

		$result = $this->db->select('id, title')->where('course_id', $course_id)->get('tbl_course_lecture')->result();
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}

	public function get_course_amount($course_id = 1) {

		$result = $this->db->select('id, course_price, course_discount')->where('id', $course_id)->get('tbl_courses')->row();
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}

	public function get_lecture_amount($lecture_id = 1) {

		$result = $this->db->select('id, lecture_price, lecture_discount')->where('id', $lecture_id)->get('tbl_course_lecture')->row();
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}

	public function purchase_course($param1 = 'add', $param2 = '', $param3 = '')
	{
		if ($param1 == 'add') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$purchase_courses_data['course_id']        			= $this->input->post('course_id', true);
				$purchase_courses_data['instructor_id']    			= $this->input->post('instructor_id', true);
				$purchase_courses_data['purchase_course_section_id'] 	= $this->input->post('purchase_course_section_id', true);
				$purchase_courses_data['title'] 						= $this->input->post('title', true);
				$purchase_courses_data['sort_description'] 			= $this->input->post('sort_description', true);
				$purchase_courses_data['lecture_price'] 				= $this->input->post('lecture_price', true);
				$purchase_courses_data['lecture_discount'] 			= $this->input->post('lecture_discount', true);
				$purchase_courses_data['video_server'] 				= $this->input->post('video_server', true);
				$purchase_courses_data['video_link'] 				= $this->input->post('video_link', true);				
				$purchase_courses_data['insert_time'] 				= date('Y-m-d H:i:s');
				$purchase_courses_data['last_update'] 				= date('Y-m-d H:i:s');
				$purchase_courses_data['keywords'] 					= "";

				foreach($this->input->post('keywords',true) as $key => $single_keyword) {
					if(strlen($single_keyword) > 1) {
					  if($key > 0) $purchase_courses_data['keywords'] .=  "**";
					  $purchase_courses_data['keywords'] .= $single_keyword;
					}
				}
				
				$add_purchase_courses = $this->db->insert('tbl_purchase_course',$purchase_courses_data);

				if ($add_purchase_courses) {

					$this->session->set_flashdata('message','Course Lecture Added Successfully!');
					redirect('admin/purchase_course/list','refresh');

				} else {

				   $this->session->set_flashdata('message','Course Lecture Add Failed!');
					redirect('admin/purchase_course/list','refresh');
				}
			}

			$data['category_list'] 	  		= $this->db->select('id, title')->get('tbl_course_category')->result();			

			$data['title']             = 'Course Lecture Add';
			$data['activeMenu']        = 'purchase_course_add';
			$data['page']              = 'backEnd/admin/purchase_course_add';
			
		} elseif ($param1 == 'list' ) {

			$data['purchase_courses_list'] = $this->AdminModel->get_purchase_course_data();

			$data['title']        = 'Course Lecture List';
			$data['activeMenu']   = 'purchase_course_list';			
			$data['page']         = 'backEnd/admin/purchase_course_list';
		   
		} elseif ($param1 == 'edit' && $param2 > 0) {

			$data['edit_info']   = $this->db->get_where('tbl_purchase_course',array('id'=>$param2));

			if ($data['edit_info']->num_rows() > 0) {

				$data['edit_info']    = $data['edit_info']->row();

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					$purchase_courses_data['course_id']        			= $this->input->post('course_id', true);
					$purchase_courses_data['instructor_id']    			= $this->input->post('instructor_id', true);
					$purchase_courses_data['purchase_course_section_id'] 	= $this->input->post('purchase_course_section_id', true);
					$purchase_courses_data['title'] 						= $this->input->post('title', true);
					$purchase_courses_data['sort_description'] 			= $this->input->post('sort_description', true);
					$purchase_courses_data['lecture_price'] 				= $this->input->post('lecture_price', true);
					$purchase_courses_data['lecture_discount'] 			= $this->input->post('lecture_discount', true);
					$purchase_courses_data['video_server'] 				= $this->input->post('video_server', true);
					$purchase_courses_data['video_link'] 				= $this->input->post('video_link', true);								
					$purchase_courses_data['last_update'] 				= date('Y-m-d H:i:s');
					$purchase_courses_data['keywords'] 					= "";

					foreach($this->input->post('keywords',true) as $key => $single_keyword) {
						if(strlen($single_keyword) > 1) {
							if($key > 0) $purchase_courses_data['keywords'] .=  "**";
							$purchase_courses_data['keywords'] .= $single_keyword;
						}
					}

					$update_purchase_courses = $this->db->where('id',$param2)->update('tbl_purchase_course', $purchase_courses_data);

					if ($update_purchase_courses) {

						$this->session->set_flashdata('message','Course Lecture Updated Successfully!');
						redirect('admin/purchase_course/list','refresh');

					} else {

					   $this->session->set_flashdata('message','Course Lecture Update Failed!');
						redirect('admin/purchase_course/list','refresh');
					}
				}

			} else {

				$this->session->set_flashdata('message','Wrong Attempt!');
				redirect('admin/purchase_course/list','refresh');
			}

			$data['course_data'] 	  		= $this->db->select('id, course_title')->get('tbl_courses')->result();
			$data['instructor_data'] 		= $this->db->select('id, firstname, lastname')->where('userType', 'instructor')->get('user')->result();
			$data['lecture_section_data'] 	= $this->db->select('id, section_name')->get('tbl_purchase_course_sections')->result();

			$data['title']      = 'Course Lecture Edit';
			$data['activeMenu'] = 'purchase_course_edit';
			$data['page']       = 'backEnd/admin/purchase_course_edit';
			
		   
		} elseif($param1 == 'delete' && $param2 > 0) {

			$delete_purchase_course = $this->db->where('id',$param2)->delete('tbl_purchase_course');
			
		   if ($delete_purchase_course) {

				$this->session->set_flashdata('message','Course Lecture  Deleted Successfully!');
				redirect('admin/purchase_course/list','refresh');

			} else {

			   $this->session->set_flashdata('message','Course Lecture Deleted Failed!');
				redirect('admin/purchase_course/list','refresh');
			}
			
		} else {

			$this->session->set_flashdata('message', 'Wrong Attempt!');
			redirect('admin/purchase_course/list','refresh');

		}

		$this->load->view('backEnd/master_page',$data);        
	}
	
	public function payment_method($param1 = 'add', $param2 = '', $param3 = '')
	{
		if ($param1 == 'add') {

		   if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			   	$payment_method_data['name']   				= $this->input->post('name', true);
				$payment_method_data['priority']   			= $this->input->post('priority', true);
				$payment_method_data['input_field_format']  = "";

				foreach($this->input->post('input_field_format',true) as $key => $single_field) {
					if(strlen($single_field) > 1) {
						if($key > 0) $payment_method_data['input_field_format'] .=  "**";
						$payment_method_data['input_field_format'] .= $single_field;
					}
				}
			  
			   
			   	$add_payment_method = $this->db->insert('tbl_payment_method',$payment_method_data);

			   if ($add_payment_method) {

					$this->session->set_flashdata('message','Payment Method Added Successfully!');
					redirect('admin/payment_method','refresh');

			   } else {

					$this->session->set_flashdata('message','Payment Method Add Failed!');
					redirect('admin/payment_method','refresh');
			   }
			   
		   }
		}elseif ($param1 == 'edit' && $param2 > 0) {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$payment_method_data['name']   				= $this->input->post('name', true);
				$payment_method_data['priority']   			= $this->input->post('priority', true);
				$payment_method_data['input_field_format']  = "";

				foreach($this->input->post('input_field_format',true) as $key => $single_field) {
					if(strlen($single_field) > 1) {
						if($key > 0) $payment_method_data['input_field_format'] .=  "**";
						$payment_method_data['input_field_format'] .= $single_field;
					}
				}			

				$update_payment_method = $this->db->where('id',$param2)->update('tbl_payment_method',$payment_method_data);

			    	if ($update_payment_method) {

					$this->session->set_flashdata('message','Payment Method Updated Successfully!');
					redirect('admin/payment_method','refresh');

			    	} else {

				   $this->session->set_flashdata('message','Payment Method Update Failed!');
					redirect('admin/payment_method','refresh');
				}
			}

			$data['edit_info'] = $this->db->get_where('tbl_payment_method',array('id'=>$param2));

			if ($data['edit_info']->num_rows() > 0) {

				$data['edit_info']    = $data['edit_info']->row();

			} else {

				$this->session->set_flashdata('message','Wrong Attempt!');
				redirect('admin/payment_method','refresh');
			}
		
		   
		}elseif ($param1 == 'delete' && $param2 > 0) {

			$delete_payment_method = $this->db->where('id',$param2)->delete('tbl_payment_method');

			if ($delete_payment_method) {

				$this->session->set_flashdata('message','Payment Method Deleted Successfully!');
				redirect('admin/payment_method','refresh');

		   } else {

			   $this->session->set_flashdata('message','Payment Method Delete Failed!');
				redirect('admin/payment_method','refresh');
		   }
		}

		$data['payment_method_list']    = $this->db->order_by('priority','asc')->get('tbl_payment_method')->result();

		$data['title']      = 'Payment Method';
		$data['activeMenu'] = 'payment_method';
		$data['page']       = 'backEnd/admin/payment_method';
		
		$this->load->view('backEnd/master_page',$data);
	}

	public function common_pages($param1 = 'add', $param2 = '', $param3 = '')
	{
		if ($param1 == 'add') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$insert_common_pages['title']        	= $this->input->post('title', true);
				$insert_common_pages['body']    		= $this->input->post('body', true);
				$insert_common_pages['insert_by']   	= $_SESSION['userid'];
				$insert_common_pages['insert_time'] 	= date('Y-m-d H:i:s');

				if (!empty($_FILES['photo']['name'])) {

					$path_parts                 = pathinfo($_FILES["photo"]['name']);
					$newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
					$dir                        = date("YmdHis", time());
					$config_c['file_name']      = $newfile_name . '_' . $dir;
					$config_c['remove_spaces']  = TRUE;
					$config_c['upload_path']    = 'assets/commonPagePhoto/';
					$config_c['max_size']       = '20000'; //  less than 20 MB
					$config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

					$this->load->library('upload', $config_c);
					$this->upload->initialize($config_c);
					if (!$this->upload->do_upload('photo')) {

					} else {

						$upload_c = $this->upload->data();
						$insert_common_pages['photo'] = $config_c['upload_path'] . $upload_c['file_name'];						
					}
					
				}

				$add_common_pages = $this->db->insert('tbl_common_pages',$insert_common_pages);

				if ($add_common_pages) {

					$this->session->set_flashdata('message','Common Page Added Successfully!');
					redirect('admin/common_pages/list','refresh');

				} else {

				   $this->session->set_flashdata('message','Common Page Add Failed!');
					redirect('admin/common_pages/list','refresh');
				}
			}

			$data['title']             = 'Common Page Add';
			$data['activeMenu']        = 'common_pages_add';
			$data['page']              = 'backEnd/admin/common_pages_add';
			
		} elseif ($param1 == 'list' ) {

			$data['common_pages'] = $this->db->get('tbl_common_pages')->result(); 

			$data['title']        = 'Common Page List';
			$data['activeMenu']   = 'common_pages_list';			
			$data['page']         = 'backEnd/admin/common_pages_list';
		   
		} elseif ($param1 == 'edit' && $param2 > 0) {

			$data['edit_info']   = $this->db->get_where('tbl_common_pages',array('id'=>$param2));

			if ($data['edit_info']->num_rows() > 0) {

				$data['edit_info']    = $data['edit_info']->row();

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					$update_common_pages['title']   = $this->input->post('title', true);
					$update_common_pages['body']    = $this->input->post('body', true);		

					if (!empty($_FILES['photo']['name'])) {

						$path_parts                 = pathinfo($_FILES["photo"]['name']);
						$newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
						$dir                        = date("YmdHis", time());
						$config_c['file_name']      = $newfile_name . '_' . $dir;
						$config_c['remove_spaces']  = TRUE;
						$config_c['upload_path']    = 'assets/commonPagePhoto/';
						$config_c['max_size']       = '20000'; //  less than 20 MB
						$config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

						$this->load->library('upload', $config_c);
						$this->upload->initialize($config_c);
						if (!$this->upload->do_upload('photo')) {

						} else {

							$upload_c = $this->upload->data();
							$update_common_pages['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
							//$this->image_size_fix($update_common_pagess['photo'], 400, 400);
						}
						
					}

					if ($this->AdminModel->update_common_pagess($update_common_pages, $param2)) {

						$this->session->set_flashdata('message','Common Page  Updated Successfully!');
						redirect('admin/common_pages/list','refresh');

					} else {

					   $this->session->set_flashdata('message','Common Page Update Failed!');
						redirect('admin/common_pages/list','refresh');
					}
				}

			} else {

				$this->session->set_flashdata('message','Wrong Attempt!');
				redirect('admin/common_pages/list','refresh');
			}

			$data['title']      = 'Common Page Edit';
			$data['activeMenu'] = 'common_pages_edit';
			$data['page']       = 'backEnd/admin/common_pages_edit';
			
		   
		} elseif($param1 == 'delete' && $param2 > 0) {
			
		   if ($this->AdminModel->delete_common_pages($param2)) {

				$this->session->set_flashdata('message','Common Page  Deleted Successfully!');
				redirect('admin/common_pages/list','refresh');

			} else {

			   $this->session->set_flashdata('message','Common Page Deleted Failed!');
				redirect('admin/common_pages/list','refresh');
			}
			
		} else {

			$this->session->set_flashdata('message', 'Wrong Attempt!');
			redirect('admin/common_pages/list','refresh');

		}

		$this->load->view('backEnd/master_page',$data);        
	}

	public function shortcut($param1 = 'add', $param2 = '', $param3 = '')
	{
		if ($param1 == 'add') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$insert_shortcut['title']        	= $this->input->post('title', true);
				$insert_shortcut['value']    		= $this->input->post('value', true);
				$insert_shortcut['insert_by']   	= $_SESSION['userid'];
				$insert_shortcut['insert_time'] 	= date('Y-m-d H:i:s');

				if (!empty($_FILES['icon']['name'])) {

					$path_parts                 = pathinfo($_FILES["icon"]['name']);
					$newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
					$dir                        = date("YmdHis", time());
					$config_c['file_name']      = $newfile_name . '_' . $dir;
					$config_c['remove_spaces']  = TRUE;
					$config_c['upload_path']    = 'assets/shortcutPhoto/';
					$config_c['max_size']       = '20000'; //  less than 20 MB
					$config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

					$this->load->library('upload', $config_c);
					$this->upload->initialize($config_c);
					if (!$this->upload->do_upload('icon')) {

					} else {

						$upload_c = $this->upload->data();
						$insert_shortcut['icon'] = $config_c['upload_path'] . $upload_c['file_name'];						
					}
					
				}

				$add_shortcut = $this->db->insert('tbl_shortcuts',$insert_shortcut);

				if ($add_shortcut) {

					$this->session->set_flashdata('message','Shortcut Added Successfully!');
					redirect('admin/shortcut/list','refresh');

				} else {

				   $this->session->set_flashdata('message','Shortcut Add Failed!');
					redirect('admin/shortcut/list','refresh');
				}
			}

			$data['title']             = 'Shortcut Add';
			$data['activeMenu']        = 'shortcut_add';
			$data['page']              = 'backEnd/admin/shortcut_add';
			
		} elseif ($param1 == 'list' ) {

			$data['shortcut'] = $this->db->get('tbl_shortcuts')->result(); 

			$data['title']        = 'Shortcut List';
			$data['activeMenu']   = 'shortcut_list';			
			$data['page']         = 'backEnd/admin/shortcut_list';
		   
		} elseif ($param1 == 'edit' && $param2 > 0) {

			$data['edit_info']   = $this->db->get_where('tbl_shortcuts',array('id'=>$param2));

			if ($data['edit_info']->num_rows() > 0) {

				$data['edit_info']    = $data['edit_info']->row();

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					$update_shortcut['title']   = $this->input->post('title', true);
					$update_shortcut['value']    = $this->input->post('value', true);		

					if (!empty($_FILES['icon']['name'])) {

						$path_parts                 = pathinfo($_FILES["icon"]['name']);
						$newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
						$dir                        = date("YmdHis", time());
						$config_c['file_name']      = $newfile_name . '_' . $dir;
						$config_c['remove_spaces']  = TRUE;
						$config_c['upload_path']    = 'assets/shortcutPhoto/';
						$config_c['max_size']       = '20000'; //  less than 20 MB
						$config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

						$this->load->library('upload', $config_c);
						$this->upload->initialize($config_c);
						if (!$this->upload->do_upload('icon')) {

						} else {

							$upload_c = $this->upload->data();
							$update_shortcut['icon'] = $config_c['upload_path'] . $upload_c['file_name'];
							//$this->image_size_fix($update_shortcuts['photo'], 400, 400);
						}
						
					}

					if ($this->AdminModel->update_shortcuts($update_shortcut, $param2)) {

						$this->session->set_flashdata('message','Shortcut  Updated Successfully!');
						redirect('admin/shortcut/list','refresh');

					} else {

					   $this->session->set_flashdata('message','Shortcut Update Failed!');
						redirect('admin/shortcut/list','refresh');
					}
				}

			} else {

				$this->session->set_flashdata('message','Wrong Attempt!');
				redirect('admin/shortcut/list','refresh');
			}

			$data['title']      = 'Shortcut Edit';
			$data['activeMenu'] = 'shortcut_edit';
			$data['page']       = 'backEnd/admin/shortcut_edit';
			
		   
		} elseif($param1 == 'delete' && $param2 > 0) {
			
		   if ($this->AdminModel->delete_shortcut($param2)) {

				$this->session->set_flashdata('message','Shortcut Deleted Successfully!');
				redirect('admin/shortcut/list','refresh');

			} else {

			   $this->session->set_flashdata('message','Shortcut Deleted Failed!');
				redirect('admin/shortcut/list','refresh');
			}
			
		} else {

			$this->session->set_flashdata('message', 'Wrong Attempt!');
			redirect('admin/shortcut/list','refresh');

		}

		$this->load->view('backEnd/master_page',$data);        
	}

	public function messenger($param1 = 'add', $param2 = '', $param3 = '')
	{
		if ($param1 == 'add') {

		   if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			   	$messenger_data['student_id']   	= $this->input->post('student_id', true);
				$messenger_data['message_text']   	= $this->input->post('message_text', true);
				$messenger_data['office_message']   = $this->input->post('office_message', true);
			   	$messenger_data['replay_user_id']   = $_SESSION['userid'];
				$messenger_data['message_time'] 	= date('Y-m-d H:i:s');
			   
			   	$add_messenger = $this->db->insert('tbl_messenger',$messenger_data);

			   if ($add_messenger) {

					$this->session->set_flashdata('message','Messenger Added Successfully!');
					redirect('admin/messenger','refresh');

			   } else {

					$this->session->set_flashdata('message','Messenger Add Failed!');
					redirect('admin/messenger','refresh');
			   }
			   
		   }

		}

		$data['student_list']    = $this->db->select('id, student_name, student_photo, student_roll')->where('verified', 1)->order_by('id','asc')->limit(10)->get('tbl_student')->result();

		$student_id    = $this->db->get('tbl_student')->row()->id;
		$data['messenger_list']    = $this->db->where('student_id', $student_id)->order_by('message_time','desc')->get('tbl_messenger')->result();

		$data['title']      = 'messenger';
		$data['activeMenu'] = 'messenger';
		$data['page']       = 'backEnd/admin/messenger';
		
		$this->load->view('backEnd/master_page',$data);
	}

	public function get_student_wise_message_list()
    {
        $data = array();  
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $student_id = $this->input->post('student_id', true);
			$data['student_id'] = $student_id;
            $data['message_list'] = $this->AdminModel->get_messages_student_wise($student_id);
            $this->load->view('backend/admin/get_student_wise_message_list', $data);
        }

    }

}
