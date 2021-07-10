<?php
defined ('BASEPATH') OR exit ('No direct script access allowed');
class Pinjam extends CI_Controller{//membuat controller mahasiswa
	function __construct(){
		parent:: __construct();
		$this->load->model('Pinjam_model');
		 $this->load->library('session');//load file berkabel Pinjam_model dari model
	}
	
	public function index(){
			$data['user'] = $this->Pinjam_model->getAll()->result();
			$data['id_new'] = $this->Pinjam_model->auto_id();
			$this->template->views('crud/pinjam',$data);
	}

	public function input() {//membuat fucntion input untuk menginput data ke db
		//membuat beberapa variable untuk input
		$id_pinjam = $this->input->post('id_pinjam');
		$nama_peminjam = $this->input->post('nama_peminjam');
		$no_hp = $this->input->post('no_hp');
		$kabel = $this->input->post('kabel');
		$total = $this->input->post('total');
		$tgl_pinjam = $this->input->post('tgl_pinjam');


		$data = array(//membuat array untuk menampung data yang telah diinput
			'id_pinjam' => $id_pinjam,
			'nama_peminjam' => $nama_peminjam,
			'no_hp' => $no_hp,
			'kabel' => $kabel,
			'total' => $total,
			'tgl_pinjam' => $tgl_pinjam,
			'status' => 'pinjam'
		);

		$this->Pinjam_model->input_data($data, 'pinjam');//mengakses User_model dan data yang ada pada table user
		redirect('Pinjam');//setelah data berhasil disimpan, maka kembalikan ke index
	}



//---API---//


	public function Api() {
		$data = $this->Pinjam_model->getAll();
		echo json_encode($data->result_array());;
	}

	public function ApiInsert(){		
		date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
		$date = date('Y-m-d');
		$id_pinjam = $this->Pinjam_model->auto_id();
		$nama_peminjam = $this->input->post('nama_peminjam');
		$no_hp = $this->input->post('no_hp');
		$cable = $this->input->post('kabel');
		$durasi = $this->input->post('total');

		$data = array(//membuat array untuk menampung data yang telah diinput
			'id_pinjam' => $id_pinjam,
			'nama_peminjam' => $nama_peminjam,
			'no_hp' => $no_hp,
			'kabel' => $cable,
			'total' => $durasi,
			'tgl_pinjam' => $date,
			'status' => 'pinjam'
		);
		$this->Pinjam_model->input_data($data, 'pinjam');
		echo json_encode($array);
	}

	public function ApiDelete(){
		$id_pinjam = $this->input->GET('id_pinjam');
		$where = array('id_pinjam'=>$id_pinjam);
		if($this->Pinjam_model->hapusAPI($where, 'pinjam')>0){
			$response=[
				'success'=>true,
				'message'=>'data berhasil dihapus'
			];
		}else{
			$response=[
				'success'=>false,
				'message'=>'data gagal dihapus'
			];
			}
			echo json_encode($response);
		}
		public function DeleteAPI(){
		if($this->input->GET('username')){
			$where=array('username'=>$this->input->post('username'));
			if($this->Pinjam_model->hapus_data($where,'pinjam')){
				$array=array('success'=>true);
			}else{
				$array=array('error'=>true);
			}
			echo json_encode($array);
		}
	}


	public function ApiUpdate(){
		$id_pinjam = $this->input->post('id_pinjam');
		$nama_peminjam = $this->input->post('nama_peminjam');
		$no_hp = $this->input->post('no_hp');
		$cable = $this->input->post('kabel');
		$durasi = $this->input->post('total');
		$tgl_pinjam = $this->input->post('tgl_pinjam');

		$data = array(//membuat array untuk menampung data yang telah diinput
			'nama_peminjam' => $nama_peminjam,
			'no_hp' => $no_hp,
			'kabel' => $cable,
			'total' => $durasi,
			'tgl_pinjam' => $tgl_pinjam
		);
		$where = array(
			'id_pinjam' => $id_pinjam
		);
		$this->Pinjam_model->update_data($where,$data, 'tm_user');
		echo json_encode($array);
	}

public function ApiLogin() {
		$this->load->model('User_model');
		$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$username = $this->input->post('txt_user');
		$password = $this->input->post('txt_pass');
		$response = [];
		$cek = $this->User_model->login($username, $password,'user')->result();
		if($cek != FALSE) {
			foreach ($cek as $row) {
			
				$response = [
					'login' => true,
					'user' => $row->username, 
					'role' => $row->role, 
				];
			}
		} else {
			$response = [
				'login' => true,
				'message' => 'Username atau password salah', 
			];
		}
		echo json_encode($response);
	}

/*function aksi_login(){
		$username = $this->input->post('txt_user');
		$password = $this->input->post('txt_pass');
		$where = array(
			'username' => $username,
			'password' => $password
			);
		$cek = $this->User_model->cek_login('user',$where)->num_rows();
		if($cek > 0){
 
			$data_session = array(
				'nama' => $username,
				'status' => "login"
				);
 
			$this->session->set_userdata($data_session);
			echo json_encode($array);
	}*/
}