<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('getPackageDetails')) {

    function getPackageDetails($id, $user_id) {
        // print_r($id);die;
        $ci1 = & get_instance();
        $query = $ci1->db->where('package_id', $id)
                ->where('type', 'Credit')
                ->where('user_id', $user_id)
                ->select_sum('quantity')
                ->get('package_purchase')
                ->row_array();
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

}


if (!function_exists('checkUserPayment')) {

    function checkUserPayment($user_id) {
        // print_r($id);die;
        $ci1 = & get_instance();
        $query = $ci1->db->where('user_id', $user_id)
                ->select('payment_status')
                ->get('users')
                ->row_array();
        if (!empty($query['payment_status'])) {
            return $query;
        } else {
            return false;
        }
    }

}



if (!function_exists('getPackageDetail')) {

    function getPackageDetail($id) {
        // print_r($id);die;
        $ci1 = & get_instance();
        $query = $ci1->db->where('id', $id)
                ->get('packages')
                ->row_array();
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

}
if (!function_exists('getCartCount')) {

    function getCartCount() {
        
        $user_id = (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) ? $_SESSION['user_id'] : '';
        $ci1 = & get_instance();
        $data = $ci1->db->where('user_id', $user_id)
                        ->get('cart')->num_rows();
        if ($data > 0) {
            return $data;
        } else {
            return false;
        }
    }

}

if (!function_exists('totalCartAmount')) {
    

function totalCartAmount(){
        $user_id = (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) ? $_SESSION['user_id'] : '';
    $ci1 = & get_instance();
        $data = $ci1->db->where('user_id', $user_id)
               ->select_sum('price') 
                ->get('cart')
                ->row_array();
        if($data['price'] > 0){
            
            return $data['price'];
        } else {
        return false;
            
        }
    }
}

if (!function_exists('getCartDetail')) {

    function getCartDetail() {
        $user_id = (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) ? $_SESSION['user_id'] : '';
        $ci1 = & get_instance();
        $data = $ci1->db->where('user_id', $user_id)
                 ->get('cart')->result_array();
        
         if($data){
             
             return $data;
         } else {
             return false;
         }
    }

}






if (!function_exists('getProductDetail')) {

    function getProductDetail($id) {
        // print_r($id);die;
        $ci1 = & get_instance();
        $query = $ci1->db->where('id', $id)
                ->get('products')
                ->row_array();
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

}


if (!function_exists('getDeliveryAddress')) {

    function getDeliveryAddress($id) {
        // print_r($id);die;
        $ci1 = & get_instance();
        $query = $ci1->db->where('order_id', $id)
                ->where('is_delivery','Yes')
                ->get('address')
                ->row_array();
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

}


if (!function_exists('getShippingAddress')) {

    function getShippingAddress($id) {
        // print_r($id);die;
        $ci1 = & get_instance();
        $query = $ci1->db->where('order_id', $id)
                ->where('is_shipping','Yes')
                ->get('address')
                ->row_array();
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

}



if (!function_exists('getPackageBalance')) {

    function getPackageBalance($id, $user_id) {
        // print_r($id);die;
        $ci1 = & get_instance();
        $query = $ci1->db->where('package_id', $id)
                ->where('type', 'Debit')
                ->where('user_id', $user_id)
                ->select_sum('quantity')
                ->get('package_purchase')
                ->row_array();
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

}


if (!function_exists('getPackageUnitPrice')) {

    function getPackageUnitPrice($id = '') {
        // print_r($id);die;
        $ci1 = & get_instance();
        $query = $ci1->db->where('id', $id)
                ->select('unit_price')
                ->get('packages')
                ->row_array();
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

}

if (!function_exists('getUserRequestMoney')) {

    function getUserRequestMoney($id = '') {
        // print_r($id);die;
        $ci1 = & get_instance();
        $query = $ci1->db->where('id', $id)
                ->select('withdraw_amount,user_id')
                ->get('user_withdraw_money')
                ->row_array();
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

}


if (!function_exists('getWalletAmount')) {

    function getWalletAmount($id = '') {
        $ci1 = & get_instance();
        $ci1->db->where('user_id', $id);
        $ci1->db->select('wallet_amount');
        $amount = $ci1->db->get('wallet')->row_array();
        if (!empty($amount)) {
            return $amount;
        } else {
            return false;
        }
    }

}

if (!function_exists('getNotificationCount')) {

    function getNotificationCount($id = '') {
        // print_r($id);die;
        $ci1 = & get_instance();
        $query = $ci1->db->where('to_user_id', $id)
                ->where('status', 0)
                ->get('notification')
                ->num_rows();
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

}



if (!function_exists('transactionDetail')) {

    function transactionDetail($id = '') {

        $ci1 = & get_instance();
        $query = $ci1->db->where('commission_transactions.to_user_id', $id)
                ->select('commission_transactions.*, users.first_name, users.last_name, users.image')
                ->join('users', 'users.user_id= commission_transactions.from_user_id')
                ->order_by('id', 'DESC')
                ->limit(5)
                ->get('commission_transactions')
                ->result_array();
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

}

if (!function_exists('getTotalcommission')) {

    function getTotalcommission($id = '') {

        $ci1 = & get_instance();
        $query = $ci1->db->where('to_user_id', $id)
                ->select_sum('commission_amount')
                ->get('commission_transactions')
                ->row_array();
        if (!empty($query)) {
            return $commission = $query['commission_amount'];
        } else {
            return false;
        }
    }

}



if (!function_exists('checkPurchasedQuanitity')) {

    function checkPurchasedQuanitity($disId = '', $pId = '') {
        // print_r($id);die;
        $ci1 = & get_instance();
        $query = $ci1->db->where('distributor_id', $disId)
                ->where('package_id', $pId)
                ->select_sum('order_qty')
                ->get('orders')
                ->row_array();

        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

}


if (!function_exists('dedcutQuantity')) {

    function dedcutQuantity($id = '') {
        // print_r($id);die;
        $ci1 = & get_instance();
        $query = $ci1->db->where('id', $id)
                ->get('packages')
                ->row_array();

        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

}



if (!function_exists('getUserDetails')) {

    function getUserDetails($id = '') {
        // echo $id;die;
        $ci1 = & get_instance();
        $query = $ci1->db->where('user_id', $id)
                ->get('users')
                ->row_array();


        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

}

if (!function_exists('getUserDetailss')) {

    function getUserDetailss($id = '') {
        // echo $id;die;
        $ci1 = & get_instance();
        $query = $ci1->db->where('users.user_id', $id)
                ->select('users.address ,city.name as cityName')
                ->join('city', 'city.id=users.city')
                ->get('users')
                ->row_array();
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

}

if (!function_exists('getorderDetails')) {

    function getorderDetails($id = '') {
        // echo $id;die;
        $ci1 = & get_instance();
        $query = $ci1->db->where('to_user_id', $id)
                ->select('added_date')
                ->get('commission_transactions')
                ->row_array();

        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

}



if (!function_exists('getDistributorOrder')) {

    function getDistributorOrder($id = '') {
        // echo $id;die;
        $ci1 = & get_instance();
        $query = $ci1->db->where('user_id', $id)
                ->where('status', 'TXN_SUCCESS')
                ->select('package_id')
                ->get('orders')
                ->result_array();

        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

}


if (!function_exists('getPackageDetailss')) {

    function getPackageDetailss($ids = array()) {

        $ids1 = '';
        $newarr = array();
        if (!empty($ids)) {
            // print_r($ids);die;

            foreach ($ids as $key => $value) {
                $newarr[] = $value['package_id'];
            }
            // debug($newarr);die;
            // if(!empty($newarr)){
            //   $ids1 = implode(",'", $newarr);   
            // }
        }
        // echo $id;die;
        $ci1 = & get_instance();
        $query = $ci1->db->where_in('id', $newarr)
                ->select()
                ->get('packages')
                ->result_array();
        //      debug($res);die;
        // echo $ci1->db->last_query();die;

        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

}





if (!function_exists('downloadInvoicePdf')) {

    function downloadInvoicePdf($html, $filename) {
        require_once(APPPATH . 'libraries/dompdf/dompdf_config.php');

        $dompdf = new DOMPDF();

        $dompdf->load_html($html);
        $dompdf->set_paper("A4", 'portrait');
        $dompdf->render();

        $file_to_save = APPPATH . "../assets/invoice_pdf_attachment/" . $filename;

        //Save the pdf file on the server
        file_put_contents($file_to_save, $dompdf->output());
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename);
        ob_clean();
        flush();
        readfile($file_to_save);

        die;
    }

}



if (!function_exists('sendEstimateMail')) {

    function sendEstimateMail($html, $filename, $to) {
        require_once(APPPATH . 'libraries/dompdf/dompdf_config.php');

        $dompdf = new DOMPDF();

        $dompdf->load_html($html);
        $dompdf->set_paper("A4", 'portrait');
        $dompdf->render();

        $file_to_save = APPPATH . "../assets/estimate_pdf_attachment/" . $filename;

        //Save the pdf file on the server
        file_put_contents($file_to_save, $dompdf->output());

        $from_email = 'info@premad.in';
        $to_email = $to;

        //Load email library 
        //  $this->load->library('email');
        // $this->load->helper('email');

        $ci = & get_instance();
        $ci->load->library('email');

        $ci->email->from($from_email, 'Kkservices Admin');
        $ci->email->to($to_email);
        $ci->email->subject('Estimate mail');
        $ci->email->message('Testing the email class.');

        $path = base_url() . 'assets/estimate_pdf_attachment' . '/' . $filename;
        //  print_r($path);die;
        $ci->email->attach($path);

        if ($ci->email->send()) {
            return true;
        } else {
            return false;
        }
        die;
    }

}


if (!function_exists('sendInvoiceMail')) {

    function sendInvoiceMail($html, $filename, $to) {
        // print_r($to);die;
        require_once(APPPATH . 'libraries/dompdf/dompdf_config.php');

        $dompdf = new DOMPDF();

        $dompdf->load_html($html);
        $dompdf->set_paper("A4", 'portrait');
        $dompdf->render();

        $file_to_save = APPPATH . "../assets/invoice_pdf_attachment/" . $filename;

        //Save the pdf file on the server
        file_put_contents($file_to_save, $dompdf->output());

        $from_email = 'info@premad.in';
        $to_email = $to;

        //Load email library 
        //  $this->load->library('email');
        // $this->load->helper('email');

        $ci1 = & get_instance();
        $ci1->load->library('email');

        $ci1->email->from($from_email, 'Kkservices Admin');
        $ci1->email->to($to_email);
        $ci1->email->subject('Invoice mail');
        $ci1->email->message('Testing the email class.');

        $path1 = base_url() . 'assets/invoice_pdf_attachment' . '/' . $filename;
        //  print_r($path);die;
        $ci1->email->attach($path1);

        if ($ci1->email->send()) {
            return true;
        } else {
            return false;
        }
        die;
    }

    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full)
            $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

}