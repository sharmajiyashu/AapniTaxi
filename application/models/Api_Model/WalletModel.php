<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class WalletModel extends CI_Model {

    
    public function checkWalletExist($user_id) {
        $this->db->where('user_id',$user_id);
        $query = $this->db->get('wallet');
        if ($query->num_rows() > 0) {
            return  $query->num_rows();
        } else {         
            return  false;
        }
    }

    public function saveWalletAmount($postdata) {
        
        $data = array(
        'user_id'=>$postdata['user_id'],
        'wallet_amount'=>$postdata['wallet_amount'],
        'created_at'=>date('Y-m-d h:i:s'),
        'updated_at'=>date('Y-m-d h:i:s'),
        'created_by'=>$postdata['user_id'],
        'updated_by'=>$postdata['user_id']
        );
        $this->db->insert('wallet', $data);
        $insert = $this->db->insert_id();
        if ($insert > 0) {
            $data2 = [
                'user_id'=>$postdata['user_id'],
                'wallet_amount'=>$postdata['wallet_amount'],
                'transaction_amount'=>$postdata['wallet_amount'],
                'transaction_type'=>'cr',
                'created_by'=>$postdata['user_id'],
                'created_at'=>date('Y-m-d h:i:s')
            ];
            
            $this->db->insert('wallet_history', $data2);
            return  true;
        } else {         
            return  false;
        }
    }
    
    public function updateWalletAmount($postData) {
        
        // now check old  wallet amount
        $this->db->where('user_id',$postData['user_id']);
        $walletArr = $this->db->get('wallet')->row_array();
        // finded wallent amount now we can old wallet amount to add new user added wallet amount
        $totalWalletAmt = $walletArr['wallet_amount'] + $postData['wallet_amount'];
        // update array 
        $data = array(
        'user_id'=>$postData['user_id'],
        'wallet_amount'=>$totalWalletAmt,
        'updated_at'=>date('Y-m-d h:i:s'),
        'updated_by'=>$postData['user_id']
        );
        // update wallet amount
        $this->db->where('user_id',$postData['user_id']);
        $update = $this->db->update('wallet', $data);
        if ($update > 0) {
            $data2 = ['user_id'=>$postData['user_id'],'wallet_amount'=>$totalWalletAmt,'transaction_amount'=>$postData['wallet_amount'],'transaction_type'=>'cr','created_by'=>$postData['user_id'],'created_at'=>date('Y-m-d h:i:s')];
            $this->db->insert('wallet_history', $data2);
            return  true;
        } else {         
            return  false;
        }
    }
    
    
    
    public function getWalletAmount($user_id) {
        $this->db->where('user_id',$user_id);
        $query = $this->db->get('wallet');
        if ($query->num_rows() > 0) {
            return  $query->row_array();
        } else {         
            return  false;
        }
    }
    
    
    public function getWalletHistory($user_id) {
        $this->db->where('user_id',$user_id);
        $query = $this->db->get('wallet_history');
        if ($query->num_rows() > 0) {
            return  $query->result_array();
        } else {         
            return  false;
        }
    }
}
