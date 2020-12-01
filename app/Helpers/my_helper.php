<?php

function check_access($role_id, $menu_id)
{
   $db = \Config\Database::connect();
   $result = $db->table('tbl_user_access_menu')->where(['role_id' => $role_id, 'menu_id' => $menu_id])->get();

   if ($result->getRowArray() > 0) {
      return "checked='checked'";
   }
}


function rupiah($angka)
{

   $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
   return $hasil_rupiah;
}

function auto_paragraf($text)
{

   // memecah string input berdasarkan karakter '\r\n\r\n'
   $pecah = explode("\r\n\r\n", $text);

   // string kosong inisialisasi
   $text = "";

   // untuk setiap substring hasil pecahan, sisipkan <p> di awal dan </p> di akhir
   // lalu menggabungnya menjadi satu string utuh $text
   for ($i = 0; $i <= count($pecah) - 1; $i++) {
      $part = str_replace($pecah[$i], "<p>" . $pecah[$i] . "</p>", $pecah[$i]);
      $text .= $part;
   }
   // menampilkan outputnya
   return $text;
}


function encrypt_url($string)
{
   $output = false;
   /*
   * read security.ini file & get encryption_key | iv | encryption_mechanism value for generating encryption code
   */
   $security       = parse_ini_file("security.ini");
   $secret_key     = $security["encryption_key"];
   $secret_iv      = $security["iv"];
   $encrypt_method = $security["encryption_mechanism"];
   // hash
   $key    = hash("sha256", $secret_key);
   // iv – encrypt method AES-256-CBC expects 16 bytes – else you will get a warning
   $iv     = substr(hash("sha256", $secret_iv), 0, 16);
   //do the encryption given text/string/number
   $result = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
   $output = base64_encode($result);
   return $output;
}
function decrypt_url($string)
{
   $output = false;
   /*
   * read security.ini file & get encryption_key | iv | encryption_mechanism value for generating encryption code
   */
   $security       = parse_ini_file("security.ini");
   $secret_key     = $security["encryption_key"];
   $secret_iv      = $security["iv"];
   $encrypt_method = $security["encryption_mechanism"];
   // hash
   $key    = hash("sha256", $secret_key);
   // iv – encrypt method AES-256-CBC expects 16 bytes – else you will get a warning
   $iv = substr(hash("sha256", $secret_iv), 0, 16);
   //do the decryption given text/string/number
   $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
   return $output;
}
