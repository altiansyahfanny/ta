<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cetak extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('pdf_report');
    check_login(); // Pengecekan role dan akses
  }

  public function index()
  {
    $this->load->view('Print/sk_izin_usaha');
  }
}
