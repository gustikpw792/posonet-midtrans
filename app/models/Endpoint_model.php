<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';

use GuzzleHttp\Client;

class Endpoint_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        
        $this->endpoint = $this->config->item('endpoint'); // Load endpoint configuration
    }

    public function getInvoice($no_internet) {
        try {
            foreach ($this->endpoint as $e) {
                $client = new Client([
                    'base_uri' => $e['base_uri'],
                ]);

                $response = $client->request('GET', 'getInvoice', [
                    'query' => ['no_internet' => $no_internet],
                    'headers' => [
                        'Authorization' => 'Bearer ' . $e['token']
                    ]
                ]);

                $res = json_decode($response->getBody());
                if ($res->status == true) {
                    return $res;
                    exit();
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function updateInvoiceStatus($data, $transaction_status) {
        
        try {
            foreach ($this->endpoint as $e) {
                $client = new Client([
                    'base_uri' => $e['base_uri'],
                ]);

                $response = $client->request('POST', 'updateInvoiceStatus', [
                    'form_params' => $data,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $e['token']
                    ]
                ]);

                $result = json_decode($response->getBody());
                // Check if the response status is true
                if ($result['status']) {
                    return $result;
                    exit();
                }
            }
        } catch (\Exception $e) {
            echo json_encode('error: ' . $e->getMessage());
        }
    }

    public function getPaymentDetails($order_id) {
        try {
            foreach ($this->endpoint as $e) {
                $client = new Client([
                    'base_uri' => $e['base_uri'],
                ]);
                $response = $client->request('GET', 'getPaymentDetails', [
                    'query' => ['order_id' => $order_id],
                    'headers' => [
                        'Authorization' => 'Bearer ' . $e['token']
                    ]
                ]);

                $res = json_decode($response->getBody());
                // Check if the response status is true
                if ($res->status) {
                    return $res;
                    exit();
                }
            }
        } catch (\Exception $e) {
            echo json_encode('error: ' . $e->getMessage());
        }   
    }


}