<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Init section
class Auth extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();
	}

	/**
	* Login user
	*
	*/
	public function login()
	{
		if ($this->aauth->is_loggedin()) {
			redirect('administrator/dashboard','refresh');
		}
		$data = [];
		$this->config->load('site');

		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');


		if ($this->form_validation->run()) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			// Check approval status
			$user_check = $this->db->group_start()
				->where('username', $username)
				->or_where('email', $username)
			->group_end()->get('aauth_users')->row();

			if ($user_check && $user_check->approval_status === 'pending') {
				$data['error'] = '<strong>Akun Menunggu Approval:</strong> Akun demo Anda (<strong>' . htmlspecialchars($user_check->username) . '</strong>) sedang dalam antrean verifikasi & persetujuan oleh Administrator. Silakan hubungi admin atau tunggu hingga akun diaktifkan.';
			} elseif ($user_check && $user_check->approval_status === 'rejected') {
				$data['error'] = '<strong>Permohonan Ditolak:</strong> Akun demo ini belum disetujui untuk akses sistem. Silakan hubungi tim kami untuk bantuan.';
			} else {
				if ($this->aauth->login($username, $password, $this->input->post('remember'))) {
					$ref = $this->session->userdata('redirect');
			
					if ($ref) {
						redirect($ref,'refresh');
					} else {
						redirect('administrator/dashboard','refresh');
					}

				} else {
					$data['error'] = $this->aauth->print_errors(TRUE);
				}
			}
		} else {
			$data['error'] = validation_errors();
		}
		$this->template->build('backend/standart/administrator/login', $data);
	}

	/**
	* Register user member / calon customer
	*
	*/
	public function register()
	{
		$data = [];

		$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'trim|required');
		$this->form_validation->set_rules('company_name', 'Nama Bisnis / Toko', 'trim|required');
		$this->form_validation->set_rules('phone', 'No. WhatsApp / HP', 'trim|required|numeric');
		$this->form_validation->set_rules('email', 'Email Bisnis', 'trim|required|valid_email|is_unique[aauth_users.email]');
		$this->form_validation->set_rules('username', 'Username Login', 'trim|required|min_length[4]|callback__check_username_format|is_unique[aauth_users.username]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');

		$this->form_validation->set_message('is_unique', '%s sudah terdaftar di sistem. Silakan gunakan yang lain.');
		$this->form_validation->set_message('required', '%s wajib diisi.');
		$this->form_validation->set_message('numeric', '%s harus berupa angka.');
		$this->form_validation->set_message('min_length', '%s minimal terdiri dari %s karakter.');
		$this->form_validation->set_message('valid_email', '%s harus berupa format email yang valid.');

		if ($this->form_validation->run()) {
			$save_data = [
				'full_name'       => $this->input->post('full_name'),
				'phone'           => $this->input->post('phone'),
				'company_name'    => $this->input->post('company_name'),
				'approval_status' => 'pending',
				'banned'          => 1 // Non-aktif hingga di-approve
			];
			$save_user = $this->aauth->create_user(
				$this->input->post('email'), 
				$this->input->post('password'), 
				$this->input->post('username'), 
				$save_data
			);

			if ($save_user) {
				// Hapus grup default otomatis dan tetapkan khusus ke Group 7: Calon Customer (Demo)
				$this->db->delete('aauth_user_to_group', ['user_id' => $save_user]);
				$this->aauth->add_member($save_user, 7);

				// Simpan ke database calon pelanggan di CRM contacts jika ada
				if ($this->db->table_exists('crm_contacts')) {
					$this->db->insert('crm_contacts', [
						'nama'       => $this->input->post('full_name'),
						'no_hp'      => $this->input->post('phone'),
						'email'      => $this->input->post('email'),
						'sumber'     => 'Registrasi Demo Calon Customer',
						'catatan'    => 'Calon customer registrasi demo: ' . $this->input->post('company_name'),
						'created_at' => date('Y-m-d H:i:s')
					]);
				}

				$this->session->set_flashdata('success_register', true);
				$this->session->set_flashdata('reg_name', $this->input->post('full_name'));
				$this->session->set_flashdata('reg_user', $this->input->post('username'));
				redirect('administrator/register?success=1');
			} else {
				$aauth_err = $this->aauth->print_errors();
				if (stripos($aauth_err, 'Invalid Username') !== false || stripos($aauth_err, 'username_invalid') !== false) {
					$data['error'] = '<strong>Username Tidak Valid:</strong> Username hanya boleh berisi huruf, angka, titik (.), atau garis bawah (_), tanpa spasi atau tanda @.';
				} elseif (stripos($aauth_err, 'already exists') !== false || stripos($aauth_err, 'username_exists') !== false) {
					$data['error'] = '<strong>Akun Sudah Terdaftar:</strong> Username atau Email tersebut sudah digunakan di sistem. Silakan gunakan kombinasi lain.';
				} else {
					$data['error'] = strip_tags($aauth_err);
				}
			}
		} else {
			$data['error'] = validation_errors();
		}

		$this->template->build('backend/standart/administrator/register_member', $data);
	}

	/**
	* Callback validasi format username agar tidak menggunakan @ atau spasi
	*
	* @param string $username
	* @return bool
	*/
	public function _check_username_format($username)
	{
		if (strpos($username, '@') !== false) {
			$this->form_validation->set_message('_check_username_format', '<strong>Format Username Salah:</strong> Kolom Username Login tidak boleh menggunakan alamat email atau simbol <code>@</code>. Gunakan kombinasi huruf/angka biasa (contoh: <b>yordan123</b> atau <b>temandev</b>).');
			return FALSE;
		}
		if (preg_match('/\s/', $username)) {
			$this->form_validation->set_message('_check_username_format', '<strong>Format Username Salah:</strong> Username tidak boleh mengandung spasi.');
			return FALSE;
		}
		if (!preg_match('/^[a-zA-Z0-9_.-]+$/', $username)) {
			$this->form_validation->set_message('_check_username_format', '<strong>Format Username Salah:</strong> Username hanya boleh berisi huruf, angka, titik (.), atau garis bawah (_).');
			return FALSE;
		}
		return TRUE;
	}

	/**
	* User forgot password
	*
	* @var String $id 
	*/
	public function forgot_password()
	{
		$data = [];

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('captcha', 'Captcha', 'trim|required|callback_valid_captcha');

		$this->form_validation->set_message('is_unique', 'User already used');

		if ($this->form_validation->run()) {
			//custom your action
			$reset = $this->aauth->remind_password($this->input->post('email'));
			if ($reset) {
				set_message('Your password reset link send to your mail');
			} else {
				set_message('Failed to send password reminder', 'danger');
			}
			redirect('administrator/login', 'refresh');
		} else {
			$data['error'] = validation_errors();
		}

		$this->template->build('backend/standart/administrator/forgot_password', $data);
	}

	/**
	* User session logout
	*
	*/
	public function logout()
	{
		$this->aauth->logout();
		redirect('/');
	}
}

/* End of file Auth.php */
/* Location: ./application/controllers/administrator/Auth.php */