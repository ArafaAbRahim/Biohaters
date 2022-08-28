<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php
class AdminModel extends CI_Model
{

	// $returnmessage can be num_rows, result_array, result
	public function isRowExist($tableName = '', $data = '', $returnmessage = '', $user_id = NULL)
	{

		$this->db->where($data);
		if ($user_id !== NULL) {
			$this->db->where('userId', $user_id);
		}
		if ($returnmessage == 'num_rows') {
			return $this->db->get($tableName)->num_rows();
		} else if ($returnmessage == 'result_array') {
			return $this->db->get($tableName)->result_array();
		} else {
			return $this->db->get($tableName)->result();
		}
	}
	// saveDataInTable table name , array, and return type is null or last inserted ID.
	public function saveDataInTable($tableName, $data, $returnInsertId = 'false')
	{

		$this->db->insert($tableName, $data);
		if ($returnInsertId == 'true') {
			return $this->db->insert_id();
		} else {
			return -1;
		}
	}

	public function check_campaign_ambigus($start_date, $end_date)
	{

		if (date_format(date_create($start_date), "Y-m-d") > date_format(date_create($end_date), "Y-m-d")) {
			return -2;
		}

		$this->db->limit(1);
		$this->db->where('end_date >=', $start_date);
		$this->db->where('available_status', 1);
		$query = $this->db->get('create_campaign')->num_rows();
		if ($query > 0) {
			return -1;
		}
		return 1;
	}

	public function end_date_extends($end_date, $id)
	{

		$this->db->limit(1);
		$this->db->where('start_date >=', $end_date);
		$this->db->where('id', $id);
		$this->db->where('available_status', 1);
		$query = $this->db->get('create_campaign')->num_rows();
		if ($query > 0) {
			return -1;
		}
		$this->db->limit(1);
		$this->db->where('end_date >=', $end_date);
		$this->db->where('id !=', $id);
		$this->db->where('available_status', 1);
		$query2 = $this->db->get('create_campaign')->num_rows();
		if ($query2 > 0) {
			return -1;
		}
		return 1;
	}

	public function fetch_data_pageination($limit, $start, $table, $search = NULL, $approveStatus = NULL, $user_id = NULL)
	{

		$this->db->limit($limit, $start);

		if ($approveStatus !== NULL) {
			$this->db->where('approveStatus', $approveStatus);
		}

		if ($user_id !== NULL) {
			$this->db->where('userId', $user_id);
		}

		if ($search !== NULL) {
			$this->db->like('title', $search);
			$this->db->or_like('body', $search);
			$this->db->or_like('date', $search);
		}

		$this->db->order_by('date', 'desc');
		$query = $this->db->get($table);

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}

	public function fetch_images($limit = 18, $start = 0, $table = '', $search = NULL, $where_data = NULL)
	{

		$this->db->limit($limit, $start);

		if ($search !== NULL) {
			$this->db->like('date', $search);
			$this->db->or_like('photoCaption', $search);
		}
		if ($where_data !== NULL) {
			$this->db->where($where_data);
		}
		$this->db->group_by('photo');
		$this->db->order_by('date', 'desc');
		$query = $this->db->get($table);

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}

	public function usersCategory($userId)
	{

		$this->db->select('category.*');
		$this->db->join('category', 'category_user.categoryId = category.id', 'left');
		$this->db->where('category_user.userId', $userId);
		return $this->db->get('category_user')->result_array();
	}

	public function get_user($user_id)
	{
		$query = $this->db->select('user.*,tbl_upozilla.*')
			->where('user.id', $user_id)
			->from('user')
			->join('tbl_upozilla', 'user.address = tbl_upozilla.id', 'left')
			->get();

		return $query->row();
	}

	public function update_pro_info($update_data, $user_id)
	{
		return $this->db->where('id', $user_id)->update('user', $update_data);
	}

	public function update_testimonials($update_testimonials, $param2)
	{
		if (isset($update_testimonials['photo']) && file_exists($update_testimonials['photo'])) {

			$result = $this->db->select('photo')
				->from('tbl_testimonial')
				->where('id', $param2)
				->get()
				->row()->photo;

			if (file_exists($result)) {
				unlink($result);
			}
		}

		return $this->db->where('id', $param2)->update('tbl_testimonial', $update_testimonials);
	}

	public function delete_testimonials($param2)
	{
		$result = $this->db->select('photo')
			->from('tbl_testimonial')
			->where('id', $param2)
			->get()
			->row()->photo;

		if (file_exists($result)) {
			unlink($result);
		}

		return $this->db->where('id', $param2)->delete('tbl_testimonial');
	}

	public function theme_text_update($name_index, $value)
	{

		if ($name_index == 'logo') {
			$result = $this->db->select('value')->where(array('id' => 6))->get('tbl_backend_theme')->row()->value;

			if (file_exists($result)) {
				unlink($result);
			}
		} elseif ($name_index == 'share_banner') {
			$result = $this->db->select('value')->where(array('id' => 7))->get('tbl_backend_theme')->row()->value;

			if (file_exists($result)) {
				unlink($result);
			}
		}

		$update_theme['value'] = $value;
		$this->db->where('name', $name_index)->update('tbl_backend_theme', $update_theme);
		return true;
	}

	public function get_course_sub_category()
	{

		$this->db->select('tbl_course_sub_category.*,tbl_course_category.title as category_title');

		$this->db->join('tbl_course_category', 'tbl_course_category.id = tbl_course_sub_category.course_category_id', 'left');

		$res = $this->db->order_by('tbl_course_sub_category.id', 'desc')->get('tbl_course_sub_category');

		if ($res->num_rows() > 0) {

			return $res->result();
		} else {

			return null;
		}
	}

	public function get_course_data()
	{

		$this->db->select('tbl_courses.id, tbl_courses.course_title, tbl_courses.course_price, tbl_courses.is_free_course, tbl_courses.publish_status, tbl_courses.course_level, tbl_course_category.title, tbl_day_setting.day_to_day, tbl_time_setting.time_to_time')
			->from('tbl_courses')
			->join('tbl_course_category', 'tbl_course_category.id = tbl_courses.course_category_id', 'left')
			->join('tbl_day_setting', 'tbl_day_setting.id = tbl_courses.day_setting_id', 'left')
			->join('tbl_time_setting', 'tbl_time_setting.id = tbl_courses.time_setting_id', 'left')
			->order_by('tbl_courses.id', 'desc');

		$result = $this->db->get();

		if ($result->num_rows() > 0) {

			return $result->result();
		} else {

			return array();
		}
	}

	public function update_courses($update_courses, $param2)
	{
		if (isset($update_courses['course_photo']) && file_exists($update_courses['course_photo'])) {

			$result = $this->db->select('course_photo')
				->from('tbl_courses')
				->where('id', $param2)
				->get()
				->row()->course_photo;

			if (file_exists($result)) {
				unlink($result);
			}
		}

		return $this->db->where('id', $param2)->update('tbl_courses', $update_courses);
	}

	public function delete_courses($param2)
	{
		$result = $this->db->select('course_photo')
			->from('tbl_courses')
			->where('id', $param2)
			->get()
			->row()->course_photo;

		if (file_exists($result)) {
			unlink($result);
		}

		return $this->db->where('id', $param2)->delete('tbl_courses');
	}

	public function get_lecture_sections_data()
	{

		$this->db->select('tbl_course_lecture_sections.*,tbl_courses.course_title ');

		$this->db->join('tbl_courses', 'tbl_courses.id = tbl_course_lecture_sections.course_id', 'left');

		$res = $this->db->order_by('tbl_course_lecture_sections.id', 'desc')->get('tbl_course_lecture_sections');

		if ($res->num_rows() > 0) {

			return $res->result();
		} else {

			return null;
		}
	}

	public function get_course_lecture_data()
	{

		$this->db->select('tbl_course_lecture.id, tbl_course_lecture.title, tbl_course_lecture.lecture_price, tbl_course_lecture.lecture_discount, tbl_courses.course_title, user.firstname, user.lastname, tbl_course_lecture_sections.section_name')
			->from('tbl_course_lecture')
			->join('tbl_courses', 'tbl_courses.id = tbl_course_lecture.course_id', 'left')
			->join('user', 'user.id = tbl_course_lecture.instructor_id', 'left')
			->join('tbl_course_lecture_sections', 'tbl_course_lecture_sections.id = tbl_course_lecture.course_lecture_section_id', 'left')
			->order_by('tbl_course_lecture.id', 'desc');

		$result = $this->db->get();

		if ($result->num_rows() > 0) {

			return $result->result();
		} else {

			return array();
		}
	}

	public function update_common_pages($update_common_pages, $param2)
	{
		if (isset($update_common_pages['photo']) && file_exists($update_common_pages['photo'])) {

			$result = $this->db->select('photo')
				->from('tbl_common_pages')
				->where('id', $param2)
				->get()
				->row()->photo;

			if (file_exists($result)) {
				unlink($result);
			}
		}

		return $this->db->where('id', $param2)->update('tbl_common_pages', $update_common_pages);
	}

	public function delete_common_pages($param2)
	{
		$result = $this->db->select('photo')
			->from('tbl_common_pages')
			->where('id', $param2)
			->get()
			->row()->photo;

		if (file_exists($result)) {
			unlink($result);
		}

		return $this->db->where('id', $param2)->delete('tbl_common_pages');
	}

	public function get_lecture_quiz_data()
	{
		$this->db->select('tbl_lecture_quiz.*, tbl_courses.course_title, tbl_course_lecture.title')
			->from('tbl_lecture_quiz')			
			->join('tbl_courses', 'tbl_courses.id = tbl_lecture_quiz.course_id', 'left')
			->join('tbl_course_lecture', 'tbl_course_lecture.id = tbl_lecture_quiz.lecture_id', 'left')
			->order_by('tbl_lecture_quiz.id', 'desc');

		$result = $this->db->get();

		if ($result->num_rows() > 0) {

			return $result->result();
		} else {

			return array();
		}
	}

	public function get_messages_student_wise($student_id = 0)
	{
		$this->db->select('tbl_messenger.*, tbl_student.student_name, user.firstname, user.lastname')
			->from('tbl_messenger')
			->join('tbl_student','tbl_messenger.student_id = tbl_student.id','left')
			->join('user','tbl_messenger.replay_user_id = user.id','left')			
			->order_by('tbl_messenger.message_time', 'asc');
			
		$this->db->where('student_id', $student_id);
											
		$result = $this->db->get();

		if($result->num_rows() > 0){

			return $result->result();

		} else {

			return array();
		}	

		
	}

}

?>

