<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $user = $this->ModelUser->getWhere(["email" => $this->session->userdata("email")])->row();
        if ($user) {
            if ($user->role_id == 2) {
                redirect("home");
            }
        } else {
            $this->session->set_flashdata("alert", '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
  Silahkan login terlebih dahulu<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>');
            redirect("autentifikasi");
        }
    }

    public function index()
    {
        $this->load->view('admin/sidebar_admin');
        $this->load->view('admin/dashboard');
        $this->load->view('admin/footer_admin');
    }
    public function transaction()
    {
        $data = [
            "transactions" => $this->ModelTransaction->get()->result()
        ];
        $this->load->view('admin/sidebar_admin', $data);
        $this->load->view('admin/transaction', $data);
        $this->load->view('admin/footer_admin', $data);
    }
    public function user()
    {
        $data = [
            "users" => $this->ModelUser->get()->result()
        ];
        $this->load->view('admin/sidebar_admin', $data);
        $this->load->view('admin/user', $data);
        $this->load->view('admin/footer_admin', $data);
    }
    public function user_delete($user_id)
	{
		$this->ModelUser->deleteWhere(["id" => $user_id]);
		$this->session->set_flashdata("alert", '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Selamat!</strong> Data pengguna telah berhasil dihapus.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				</div>');
		redirect("admin/user");
    }
    
    public function product()
    {
        $data = [
            "products" => $this->ModelProduct->get()->result()
        ];
        $this->load->view('admin/sidebar_admin', $data);
        $this->load->view('admin/product', $data);
        $this->load->view('admin/footer_admin', $data);
    }
    public function role()
    {
        $data = [
            "roles" => $this->ModelRole->get()->result()
        ];
        $this->load->view('admin/sidebar_admin', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('admin/footer_admin', $data);
    }
    public function message()
    {
        $data = [
            "messages" => $this->ModelMessage->get()->result()
        ];
        $this->load->view('admin/sidebar_admin', $data);
        $this->load->view('admin/message', $data);
        $this->load->view('admin/footer_admin', $data);
    }
    public function transaction_process($id)
    {
        $status = $this->input->post("status");

        $data = [
            "status" => $status
        ];

        $this->ModelTransaction->update($data, $id);

        redirect("admin/transaction");
    }
    public function logout()
    {
        $this->session->unset_userdata("email");
        $this->session->unset_userdata("role_id");
        redirect("autentifikasi");
    }
    public function role_delete($role_id)
	{
		$this->ModelRole->deleteWhere(["id" => $role_id]);
		$this->session->set_flashdata("alert", '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Selamat!</strong> Data role telah berhasil dihapus.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				</div>');
		redirect("admin/role_list");
	}
    // public function hapusMessage($id) {
    //     $this->ModelMessage->delete($id);
    //     redirect('admin/message');
    // }
}