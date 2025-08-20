<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';

use GuzzleHttp\Client;

class Endpoint_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        
        $this->endpoint = $this->config->item('endpoint'); // Load endpoint configuration
        // $this->endpoint_two = $this->config->item('endpoint_two'); // Load endpoint configuration

        // $this->_client = new Client([
        //     'base_uri' => $this->endpoint['base_uri']
        // ]);
        // $this->_client_two = new Client([
        //     'base_uri' => $this->endpoint_two['base_uri']
        // ]);
        // Load database if not autoloaded
        // $this->load->database();
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

                $res = json_decode($response->getBody());
                // Check if the response status is true
                if ($res['status']) {
                    return $res;
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



    // Example: Get all endpoints
    public function get_all()
    {
        return $this->db->get('endpoints')->result();
    }

    // Example: Get endpoint by ID
    public function get_by_id($id)
    {
        return $this->db->get_where('endpoints', array('id' => $id))->row();
    }

    // Example: Insert new endpoint
    public function insert($data)
    {
        return $this->db->insert('endpoints', $data);
    }

    // Example: Update endpoint
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('endpoints', $data);
    }

    // Example: Delete endpoint
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('endpoints');
    }
}