<?php
defined ('BASEPATH') OR exit ('No direct script access allowed');
class Profile extends CI_Controller{//membuat controller mahasiswa
	function __construct(){
		parent:: __construct();
		$this->load->model('Pinjam_model');
		 $this->load->library('session');//load file berkabel mahasiswa_model dari model
	}
	
	public function index(){
			$data['user'] = $this->Pinjam_model->getAll()->result();
			$this->template->views('crud/profile',$data);
	}
}