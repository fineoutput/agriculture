<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Author : Rishi Shrivastava
 * Description : This model is used for login Process
 */
class login_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	//This function is used to validate admin login
	public function validate($data)
	{
		$user_email=$data['user_email'];
		$password=$data['user_password'];
		$this->db->select('*');
		$this->db->where('user_email',$user_email);
		$this->db->where('user_password',md5($password));
		$this->db->where('is_active',1);
		$this->db->from('tbl_users');
		$query=$this->db->get();
		if($query->num_rows == 1)
		{
			$row=$query->row();
			$login_user=array('user_id' => $row->user_id,
							   'user_email' => $row->user_email,
							   'user_name' => $row->user_name,
							   'user_role' => $row->user_role,
                               'is_active' => $row->is_active,
							   'pwd_2'=>$row->pwd_2
							   );							   
			$this->session->set_userdata(ADMIN_SESSIONS,$login_user);
			return "admin";					
		}else{
			$this->db->select('*');
			$this->db->where('director_mail',$user_email);
			$this->db->where('director_password',md5($password));
			$this->db->where('is_active',1);
			$this->db->from('tbl_college_director');
			$query=$this->db->get();
			if($query->num_rows == 1)
			{
				$row=$query->row();
				$login_user=array('user_id' => $row->ct_director_id,
								   'user_email' => $row->director_mail,
								   'user_name' => $row->director_name,
								   'user_role' => 2,
								   'is_active' => $row->is_active,
								   'passwrd_reset'=>$row->passwrd_reset
								   );							   
				$this->session->set_userdata(DIRECTOR_SESSIONS,$login_user);
				return "director";					
			}else{
					$this->db->select('*');
					$this->db->where('principal_mail',$user_email);
					$this->db->where('principal_password',md5($password));
					$this->db->where('is_active',1);
					$this->db->from('tbl_college_principal');
					$query=$this->db->get();
					if($query->num_rows == 1)
					{
						$row=$query->row();
						$login_user=array('user_id' => $row->ct_principal_id,
										   'user_email' => $row->principal_mail,
										   'user_name' => $row->principal_name,
										   'user_role' => 3,
										   'is_active' => $row->is_active,
										   'passwrd_reset'=>$row->password_reset
										   );							   
						$this->session->set_userdata(PRINCIPAL_SESSIONS,$login_user);
						return "Principal";					
					}else{
						$this->db->select('*');
						$this->db->where('hod_mail',$user_email);
						$this->db->where('hod_password',md5($password));
						$this->db->where('is_active',1);
						$this->db->from('tbl_college_hod');
						$query=$this->db->get();
						if($query->num_rows == 1)
						{
							$row=$query->row();
							$login_user=array('user_id' => $row->ct_hod_id,
											   'user_email' => $row->hod_mail,
											   'user_name' => $row->hod_name,
											   'user_role' => 4,
											   'is_active' => $row->is_active,
											   'passwrd_reset'=>$row->password_reset
											   );							   
							$this->session->set_userdata(HOD_SESSIONS,$login_user);
							return "HOD";					
						}else{
								$this->db->select('*');
								$this->db->where('teacher_mail',$user_email);
								$this->db->where('teacher_password',md5($password));
								$this->db->where('is_active',1);
								$this->db->from('tbl_college_teacher');
								$query=$this->db->get();
								// echo $this->db->last_query();
								// exit;
								if($query->num_rows == 1)
								{
									$row=$query->row();
									$login_user=array('user_id' => $row->ct_teacher_id,
													   'user_email' => $row->teacher_mail,
													   'user_name' => $row->teacher_name,
													   'user_role' => 4,
													   'is_active' => $row->is_active,
													   'passwrd_reset'=>$row->password_reset
													   );							   
									$this->session->set_userdata(TEACHER_SESSIONS,$login_user);
									return "teacher";					
								}else{
									$this->db->select('*');
									$this->db->where('student_email',$user_email);
									$this->db->where('student_password',md5($password));
									$this->db->where('is_active',1);
									$this->db->from('tbl_college_student');
									$query=$this->db->get();
									// echo $this->db->last_query();
									// exit;
									if($query->num_rows == 1)
									{
										$row=$query->row();
										$login_user=array('user_id' => $row->ct_student_id,
														   'user_email' => $row->student_email,
														   'user_name' => $row->student_name,
														   'user_role' => 4,
														   'is_active' => $row->is_active,
														   'passwrd_reset'=>$row->password_reset
														   );							   
										$this->session->set_userdata(STUDENT_SESSIONS,$login_user);
										return "student";					
									}
									
								}
							
						}
						
						
					}
			}
			
		}
	return "NA";
}

//Log out Function
/*
	public function make_logout()
	{
		$user_data=$this->session->userdata('logged_in');
		$user_name=$user_data['user_name'];
		$cur_time=date('Y/m/d H:i:s');
		$edit_data = array(
               'user_lastlogin' => $cur_time               
            );

		$this->db->where('user_name', $user_name);
		if($this->db->update('tbl_user', $edit_data))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

*/	

}