<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Makassar");

require 'vendor/autoload.php';

use Midtrans\Midtrans;

class Notification_handler extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->midtrans = $this->config->item('midtrans');;
		// Load the Midtrans library
		\Midtrans\Config::$serverKey = $this->midtrans['server_key'];
		\Midtrans\Config::$isProduction = $this->midtrans['is_production'];

        $this->load->model('Endpoint_model', 'endpointModel');
    }

    public function index()
    {
        // non-relevant function only used for demo/example purpose
        // $this->printExampleWarningMessage();

        try {
            $notif = new \Midtrans\Notification();
        }
        catch (\Exception $e) {
            exit($e->getMessage());
        }

        $notif = $notif->getResponse();

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;
        
        // echo json_encode($notif);

        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    // echo "Transaction order_id: " . $order_id ." is challenged by FDS";
                } else {
                    // TODO set payment status in merchant's database to 'Success'
                    $return = $this->endpointModel->updateInvoiceStatus($notif, 'capture');
                    // echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
                }
            }
        } else if ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            
            $return = $this->endpointModel->updateInvoiceStatus($notif, 'settlement');

            // echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
        } else if ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'

            $return = $this->endpointModel->updateInvoiceStatus($notif, 'pending');
            // echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
        } else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            // echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
        } else if ($transaction == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
            $this->endpointModel->updateInvoiceStatus($notif, 'expire');

            // echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
        } else if ($transaction == 'cancel') {
            // TODO set payment status in merchant's database to 'Denied'
            // echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
        }

        
    }

    // Example method to handle notifications
    public function printExampleWarningMessage() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            echo 'Notification-handler are not meant to be opened via browser / GET HTTP method. It is used to handle Midtrans HTTP POST notification / webhook.';
        }
        if (strpos(\Midtrans\Config::$serverKey, 'your ') != false ) {
            echo "<code>";
            echo "<h4>Please set your server key from sandbox</h4>";
            echo "In file: " . __FILE__;
            echo "<br>";
            echo "<br>";
            echo htmlspecialchars('Config::$serverKey = \'<your server key>\';');
            die();
        }   
    }

}

