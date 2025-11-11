<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Makassar");

require 'vendor/autoload.php';

use Midtrans\Midtrans;

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->midtrans = $this->config->item('midtrans');;
		// Load the Midtrans library
		\Midtrans\Config::$serverKey = $this->midtrans['server_key'];
		\Midtrans\Config::$isProduction = $this->midtrans['is_production'];
		\Midtrans\Config::$isSanitized = $this->midtrans['is_sanitized'];
		\Midtrans\Config::$is3ds = $this->midtrans['is_3ds'];

		$this->load->model('Endpoint_model', 'endpointModel');

		$this->load->helper('MY_bulan_helper');
		$this->load->helper('MY_ribuan_helper');
	}

	public function yooo()
	{
		echo count($this->config->item('endpoint'));
	}
	public function index($inet = false)
	{
		if ($this->security->xss_clean($inet)) {
			// $this->_getOrder($this->security->xss_clean($inet));
			$data = array(
				'active' => '',
				'no_internet' => $this->security->xss_clean($inet),
			);
		} else {
			$data = array(
				'active' => 'firstpage',
				'no_internet' => '',
			);
		}

		$this->load->view('client/templates/header.php', $data);
		$this->load->view('client/invoice/invoice_get.php',);
		$this->load->view('client/templates/footer.php');
	}

	public function payment()
	{
		// "https://myposonet.com/posonet-midtrans/payment/finish?order_id=912389982821218&status_code=200&transaction_status=settlement"
		$order_id = $this->input->get('order_id', TRUE);
		$status_code = $this->input->get('status_code', TRUE);
		$transaction_status = $this->input->get('transaction_status', TRUE);

		if ($status_code == 200 && $transaction_status == 'settlement') {
			$this->payment_success($order_id, $status_code, $transaction_status);
		} elseif ($status_code == 200 && $transaction_status == 'pending') {
			$this->payment_waiting($order_id, $status_code, $transaction_status);
		} else {
			// $this->payment_failed($order_id, $status_code, $transaction_status);
			redirect('/');
		}
	}

	public function payment_success($order_id, $status_code, $transaction_status)
	{	
		$data = array(
			'active' => '',
			'order_id' => $order_id,
			'status_code' => $status_code,
			'transaction_status' => $transaction_status,
		);

		if ($status_code == 200 && $transaction_status == 'settlement') {
			// Update invoice status in the database
			$retriveData = $this->endpointModel->getPaymentDetails($order_id);
			// echo json_encode($retriveData);
			// exit();
			if ($retriveData->status) {
				$getData = $retriveData->data;
				if ($getData->payment_type == 'cstore') {
					$type_bayar = $getData->store;
				} elseif ($getData->payment_type == 'bank_transfer') {
					$type_bayar = strtoupper(json_decode($getData->va_numbers)[0]->bank) . ' - ' . json_decode($getData->va_numbers)[0]->va_number;
				} else {
					$type_bayar = $getData->payment_type;
				}

				$data = array(
					'order_id' => $getData->order_id,
					'transaction_time' => $getData->transaction_time,
					'settlement_time' => $getData->settlement_time,
					'transaction_status' => $getData->transaction_status,
					'transaction_id' => $getData->transaction_id,
					'status_code' => $getData->status_code,
					'payment_type' => $type_bayar,
					'issuer' => $getData->issuer,
					'gross_amount' => ribuan($getData->gross_amount),
					'merchant_id' => $getData->merchant_id,
					'nama_pelanggan' => $getData->nama_pelanggan,
					'no_internet' => $getData->no_pelanggan,
					'telp' => $getData->telp,
					'expired' => tgl_lokal($getData->expired),
				);

				$this->session->set_flashdata('success', 'Pembayaran berhasil. Terima kasih telah bertransaksi dengan kami.');
				$this->load->view('client/notif/payment_success',$data);
				
			} else {
				$this->session->set_flashdata('error', 'Pembayaran gagal atau tidak valid. Silakan coba lagi.');
				redirect();
			}
		} else {
			$this->session->set_flashdata('error', 'Pembayaran gagal atau tidak valid. Silakan coba lagi.');
			redirect();
		}
	}

	// public function payment_waiting($order_id, $status_code, $transaction_status)
	public function payment_waiting()
	{
		// $this->load->view('client/templates/header.php',
		// $data = array(
		// 	'active' => '',
		// ));
		$this->load->view('client/notif/notif_payment_waiting.php');
		// $this->load->view('client/templates/footer.php');
	}

	
	public function payment_failed($order_id, $status_code, $transaction_status)
	{
		$this->load->view('client/templates/header.php',
		$data = array(
			'active' => '',
		));
		$this->load->view('client/notif/notif_payment_failed.php');
		$this->load->view('client/templates/footer.php');
	}

	private function _getOrder($no_inet)
	{
		$response = $this->endpointModel->getInvoice($no_inet);
		
		$res = $response->data;

		if (!$response->status) {
			// If no data found, redirect to the invoice get page with an error message
			$this->session->set_flashdata('error', 'Nomor internet tidak ditemukan.');
			redirect(site_url());
		} 

		// Tampilkan tagihan jika hari ini 17 hari sebelum expired atau setelah expired
		$today = strtotime(date('Y-m-d'));
		$expired_date = strtotime($res->expired_date);

		// 15 hari sebelum expired
		$before_expired = strtotime('-17 days', $expired_date);
		if (empty($res->kode_invoice)) {
			$this->session->set_flashdata('error', 'Tagihan belum dapat ditampilkan. (INVOICE BELUM TERSEDIA)');
			redirect(site_url());
		} elseif ($today >= $before_expired || $today > $expired_date) {
			// Tagihan ditampilkan
			$this->_show_invoice($res);
		} else {
			// Jika tidak memenuhi syarat, redirect ke halaman utama atau tampilkan pesan
			$this->session->set_flashdata('error', 'Tagihan belum dapat ditampilkan. (LUNAS)');
			redirect(site_url());
		}
	}

	private function _show_invoice($res)
	{
		$this->load->view('client/templates/header.php',
		$data = array(
			'active' => 'getOrder',
		));
		$this->load->view('client/invoice/invoice_detail.php',
		$data = array(
			'no_internet' => $res->no_pelanggan,
			'tanggal' => date('Y-m-d H:i:s'),
			'nama_pelanggan' => $res->nama_pelanggan,
			'nama_paket' => $res->nama_paket,
			'telp' => $res->telp,
			'expired' => $res->status_berlangganan == 'ISOLIR' ? tgl_lokal($res->expired_date) : tgl_lokal($res->next_expired),
			'status_berlangganan' => $res->status_berlangganan . ' pada ' . tgl_lokal($res->expired_date),
			'v_jumlah_pembayaran' => $res->payment_status == 'LUNAS' ? 0 : ribuan($res->trx_amount), // Assuming 100000 is the amount for unpaid invoices
			'jumlah_pembayaran' => $res->trx_amount, // Assuming 100000 is the amount for unpaid invoices
			'status_pembayaran' => $res->payment_status,
			'kode_invoice' => ($res->kode_invoice != null) ? $res->kode_invoice : $res->no_pelanggan . date('ymdHi'),
			'next_expired_local' => tgl_lokal($res->next_expired),
			'next_expired' => $res->next_expired,
		));
		$this->load->view('client/templates/footer.php');
	}

	public function getInvoice() {
		$no_inet = $this->input->post("no_internet", TRUE);
		$this->_getOrder($no_inet);
	}

	public function placeOrder() {

		$data = array(
			'no_internet' => $this->input->post("no_internet", TRUE),
			'nama_pelanggan' => $this->input->post("nama_pelanggan", TRUE),
			'nama_paket' => $this->input->post("nama_paket", TRUE),
			'telp' => $this->input->post("telp", TRUE),
			// 'status_pembayaran' => $this->input->post("status_pembayaran", TRUE),
			'next_expired' => $this->input->post("next_expired", TRUE),
			'jumlah_pembayaran' => $this->input->post("jumlah_pembayaran", TRUE),
			'kode_invoice' => $this->input->post("kode_invoice", TRUE),
		);

		$transaction_details = array(
			'order_id' => $data['no_internet'] . '-' . $data['kode_invoice'] . '-' . rand(100, 999),
			'gross_amount' => $data['jumlah_pembayaran'],
		);

		//update invoice to new order_id
		// $this->endpointModel->updateInvoiceOrderId($data['kode_invoice'], $transaction_details['order_id']);

		$item_details = array(
			array(
				'id' => 'Prepaid',
				'price' => $data['jumlah_pembayaran'],
				'quantity' =>  1,
				'name' => '[' . $data['kode_invoice'] . '] INET' . str_replace(' ','',$data['nama_paket']) . ' Exp ' . $data['next_expired'],
			),
		);

		$customer_details = array(
			'first_name' => $data['no_internet'],
			'last_name' => $data['nama_pelanggan'],
			'phone' => $data['telp'],
		);

		$params = array(
			'transaction_details' => $transaction_details,
			'item_details' => $item_details,
			'customer_details' => $customer_details,
		);

		$snapToken = '';

		try {
			$snapToken = \Midtrans\Snap::getSnapToken($params);
		} catch (Exception $e) {
			echo $e->getMessage();
		}

		
		echo json_encode(array(
			'snap_token' => $snapToken,
			'status' => true,
		));
	}

	public function cobaa(){
		echo json_encode($this->endpointModel->getPaymentDetails('2002-91238998282-327'));
		
	}
	public function qr(){
		$this->load->model('Ruangwa_model', 'wa');
		// $qr = $this->wa->getQr();
		$qr = $this->wa->sendMessage();
		// echo json_encode($qr);
		echo $qr;
		
	}

}
