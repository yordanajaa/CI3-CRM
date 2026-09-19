<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Public Webhook Controller for WhatsApp Gateway (Fonnte, Wablas, WAHA, etc.)
 * 
 * This controller extends CI_Controller directly (NOT Admin) so it can be
 * accessed without authentication — required for external webhook callbacks.
 * 
 * Webhook URL to configure in Fonnte Dashboard:
 *   https://yourdomain.com/webhook/fonnte
 * 
 * Alternative URLs (also valid):
 *   https://yourdomain.com/webhook/wa
 *   https://yourdomain.com/webhook/waha
 */
class Webhook extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		// Load database
		$this->load->database();
		
		// Load CRM model
		$this->load->model('crm/model_crm');
		
		// Disable profiler for webhook requests
		$this->output->enable_profiler(FALSE);
	}

	/**
	 * Default index: Health check endpoint
	 */
	public function index()
	{
		header('Content-Type: application/json');
		echo json_encode([
			'success' => true,
			'message' => 'WhatsApp Webhook endpoint is active',
			'endpoints' => [
				'fonnte' => base_url('webhook/fonnte'),
				'waha'   => base_url('webhook/waha'),
			],
			'server_time' => date('Y-m-d H:i:s'),
		], JSON_PRETTY_PRINT);
	}

	/**
	 * Fonnte Webhook Receiver
	 * Accepts POST data from Fonnte when customer replies via WhatsApp.
	 * 
	 * Fonnte sends: sender, message, name, url, location, etc.
	 */
	public function fonnte()
	{
		header('Content-Type: application/json');

		$raw  = file_get_contents('php://input');
		$json = json_decode($raw, true);
		if (!is_array($json)) {
			$json = [];
		}

		// Debug log
		$log_data = date('Y-m-d H:i:s') . " | IP: " . $this->input->ip_address()
			. " | METHOD: " . $this->input->method(TRUE)
			. " | RAW: " . $raw
			. " | POST: " . json_encode($_POST)
			. " | GET: " . json_encode($_GET)
			. "\n";
		$log_path = APPPATH . 'logs/fonnte_webhook_debug.log';
		@file_put_contents($log_path, $log_data, FILE_APPEND);

		// Extract sender
		$sender = '';
		if ($this->input->post('sender')) {
			$sender = $this->input->post('sender');
		} elseif ($this->input->get('sender')) {
			$sender = $this->input->get('sender');
		} elseif (isset($json['sender'])) {
			$sender = $json['sender'];
		} elseif (isset($json['from'])) {
			$sender = $json['from'];
		} elseif (isset($json['phone'])) {
			$sender = $json['phone'];
		} elseif (isset($json['wa_number'])) {
			$sender = $json['wa_number'];
		}
		$sender = trim($sender);

		// Extract message or caption
		$message = '';
		if ($this->input->post('message')) {
			$message = $this->input->post('message');
		} elseif ($this->input->get('message')) {
			$message = $this->input->get('message');
		} elseif (isset($json['message'])) {
			$message = $json['message'];
		} elseif (isset($json['body'])) {
			$message = $json['body'];
		} elseif (isset($json['text'])) {
			$message = $json['text'];
		} elseif (isset($json['caption'])) {
			$message = $json['caption'];
		}
		$message = trim($message);

		// Extract media / document URL
		$media_url = '';
		if ($this->input->post('url')) {
			$media_url = $this->input->post('url');
		} elseif ($this->input->get('url')) {
			$media_url = $this->input->get('url');
		} elseif (isset($json['url'])) {
			$media_url = $json['url'];
		} elseif (isset($json['file'])) {
			$media_url = $json['file'];
		} elseif (isset($json['filename'])) {
			$media_url = $json['filename'];
		}
		$media_url = trim($media_url);

		if (empty($message) && !empty($media_url)) {
			$message = '[Lampiran Media/Dokumen]: ' . $media_url;
		} elseif (!empty($media_url) && strpos($message, $media_url) === false) {
			$message .= "\n\n[Lampiran File]: " . $media_url;
		}

		// Extract name
		$name = '';
		if ($this->input->post('name')) {
			$name = $this->input->post('name');
		} elseif ($this->input->get('name')) {
			$name = $this->input->get('name');
		} elseif (isset($json['name'])) {
			$name = $json['name'];
		} elseif (isset($json['pushname'])) {
			$name = $json['pushname'];
		} elseif (isset($json['sender_name'])) {
			$name = $json['sender_name'];
		}
		$name = trim($name);

		if (empty($sender) || empty($message)) {
			echo json_encode([
				'success' => true,
				'message' => 'Fonnte webhook endpoint is ready and active',
				'received' => [
					'sender' => $sender,
					'message' => $message,
					'name' => $name,
					'url' => $media_url
				]
			]);
			return;
		}

		// Skip outgoing message echoes
		$location  = strtolower($this->input->post('location') ?: (isset($json['location']) ? $json['location'] : ''));
		$direction = strtolower($this->input->post('direction') ?: (isset($json['direction']) ? $json['direction'] : ''));
		$from_me   = $this->input->post('from_me') ?: (isset($json['from_me']) ? $json['from_me'] : null);

		if (
			in_array($location, ['outgoing', 'device', 'sent', 'out']) ||
			in_array($direction, ['outgoing', 'sent', 'out']) ||
			$from_me === true || $from_me === 1 || $from_me === '1' || $from_me === 'true' ||
			stripos($message, 'Sent via fonnte.com') !== false ||
			stripos($message, 'fonnte.com') !== false
		) {
			echo json_encode(['success' => true, 'message' => 'Outgoing message echo skipped', 'skipped' => true]);
			return;
		}

		// Skip group messages
		if (strpos($sender, '@g.us') !== false || (strpos($sender, '-') !== false && strlen($sender) > 15)) {
			echo json_encode(['success' => true, 'message' => 'Group message skipped']);
			return;
		}

		$count = $this->model_crm->log_incoming_reply($sender, $message, $name, $raw);

		echo json_encode([
			'success' => true,
			'message' => 'Berhasil memproses balasan pesan WhatsApp dari ' . $sender,
			'logged' => $count
		]);
	}

	/**
	 * Alias endpoint: webhook/wa -> fonnte handler
	 */
	public function wa()
	{
		return $this->fonnte();
	}

	/**
	 * WAHA Webhook Receiver
	 */
	public function waha()
	{
		header('Content-Type: application/json');

		$raw = file_get_contents('php://input');
		$json = json_decode($raw, true);

		if (!is_array($json) || empty($json['payload'])) {
			echo json_encode(['success' => true, 'message' => 'WAHA webhook ready']);
			return;
		}

		$payload = $json['payload'];
		$sender = isset($payload['from']) ? preg_replace('/@c\.us$/', '', $payload['from']) : '';
		$message = isset($payload['body']) ? $payload['body'] : '';
		$name = isset($payload['notifyName']) ? $payload['notifyName'] : '';

		if (isset($payload['fromMe']) && $payload['fromMe'] === true) {
			echo json_encode(['success' => true, 'message' => 'own message skipped']);
			return;
		}

		if (empty($sender) || empty($message)) {
			echo json_encode(['success' => true, 'message' => 'empty sender/message']);
			return;
		}

		$count = $this->model_crm->log_incoming_reply($sender, $message, $name, $raw);

		echo json_encode([
			'success' => true,
			'logged' => $count
		]);
	}

	/**
	 * Debug: Test webhook with simulated data
	 * GET /webhook/test?phone=08xxx&message=Hello
	 */
	public function test()
	{
		header('Content-Type: application/json');
		$phone   = trim($this->input->get('phone') ?: '');
		$message = trim($this->input->get('message') ?: 'Test pesan masuk dari customer');
		$name    = trim($this->input->get('name') ?: 'Test Customer');

		if (empty($phone)) {
			echo json_encode(['success' => false, 'message' => 'Parameter phone diperlukan. Contoh: /webhook/test?phone=08xxx&message=Halo']);
			return;
		}

		$count = $this->model_crm->log_incoming_reply($phone, $message, $name);

		echo json_encode([
			'success' => true,
			'message' => "Test webhook sukses: Pesan dari {$phone} ({$name}) berhasil dicatat.",
			'logged' => $count
		]);
	}
}
