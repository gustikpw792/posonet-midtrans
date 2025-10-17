<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class Ruangwa_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->token = 'p6s6rzqKf1kzhXoT2rHHBL7FioBSV6Q4wNVTcfNx8jwxqAKsLQ';
        // $this->endpoint = $this->config->item('endpoint'); // Load endpoint configuration
    }


    public function getQr()
    {
        $client = new Client();
        $options = [
        'form_params' => [
        'token' => $this->token,
        ],'timeout' => 2];
        // $request = new Request('POST', 'https://app.ruangwa.id/api/qrcode');
        $request = new Request('POST', 'https://app.ruangwa.id/api/qrcode_image');
        $res = $client->sendAsync($request, $options)->wait();
        return $res->getBody();
    }

    public function sendMessage()
    {
        $client = new Client();
        $options = [
        'form_params' => [
        'token' => $this->token,
        'number' => '081340310250',
        'message' => 'pesan yang dikirim',
        'date' => date('Y-m-d'),
        'time' => date('h:i:s')
        ]];
        $request = new Request('POST', 'https://app.ruangwa.id/api/send_message');
        $res = $client->sendAsync($request, $options)->wait();
        return $res->getBody();
        // return $options;
    }

    

}