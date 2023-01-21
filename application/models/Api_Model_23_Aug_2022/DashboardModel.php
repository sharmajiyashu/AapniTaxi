<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class DashboardModel extends MY_Model {

// total Income
    public function totalIncome() {

        $this->db->where('status',1);
        $this->db->where('canceled',0);        
        $this->db->select_sum('price');
        $query = $this->db->get('cab_ride');
        if ($query->result_array()) {
            return  $query->result_array();
        } else {         
            return  $query->result_array();
        }
    }

    // today Income 
    public function todayNewIncome() {
        $startDate = date('Y-m-d 00:00:00');
        $endDate = date('Y-m-d 23:59:59');
        $this->db->where('status',1);
        $this->db->where('canceled',0);        
        $this->db->where('ride_start_time', $startDate);
        $this->db->where('ride_start_time', $endDate);
        $this->db->select_sum('price');
        $query = $this->db->get('cab_ride');
        if ($query->result_array()) {
            return  $query->result_array();
        } else {         
            return  $query->result_array();
        }
    }


    // total Ride
    public function totalRide() {

        $this->db->where('status',1);
        $this->db->where('canceled',0);        
        $query = $this->db->get('cab_ride');
        if ($query->num_rows() > 0) {
            return  $query->num_rows();
        } else {         
            return  false;
        }
    }

    // today Ride 
    public function todayNewRide() {
        $startDate = date('Y-m-d 00:00:00');
        $endDate = date('Y-m-d 23:59:59');

        $this->db->where('status',1);
        $this->db->where('canceled',0);        
        $this->db->where('ride_start_time', $startDate);
        $this->db->where('ride_start_time', $endDate);
        $query = $this->db->get('cab_ride');
        if ($query->num_rows() > 0) {
            return  $query->num_rows();
        } else {         
            return  false;
        }
    }

    // total user register
    public function totalUser() {

        $this->db->where('status',1);
        $this->db->where('type','User');
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            return  $query->num_rows();
        } else {         
            return  false;
        }
    }

    // today new user register 
    public function todayNewUser() {
        $startDate = date('Y-m-d 00:00:00');
        $endDate = date('Y-m-d 23:59:59');

        $this->db->where('status',1);
        $this->db->where('type','User');
        $this->db->where('created_at', $startDate);
        $this->db->where('created_at', $endDate);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            return  $query->num_rows();
        } else {         
            return  false;
        }
    }

    // total driver register
    public function totalDriver() {

        $this->db->where('status','1');        
        $query = $this->db->get('driver');
        if ($query->num_rows() > 0) {
            return  $query->num_rows();
        } else {         
            return  false;
        }
    }

    // today new driver register
    public function todayNewDriver() {
        $startDate = date('Y-m-d 00:00:00');
        $endDate = date('Y-m-d 23:59:59');

        $this->db->where('status',1);        
        $this->db->where('created_at', $startDate);
        $this->db->where('created_at', $endDate);
        $query = $this->db->get('driver');
        if ($query->num_rows() > 0) {
            return  $query->num_rows();
        } else {         
            return  false;
        }
    }

    // total Cab register
    public function totalCab() {
        $this->db->where('status',1);        
        $query = $this->db->get('cab');
        if ($query->num_rows() > 0) {
            return  $query->num_rows();
        } else {         
            return  false;
        }
    }

    // today new cab register
    public function todayNewCab() {
        $startDate = date('Y-m-d 00:00:00');
        $endDate = date('Y-m-d 23:59:59');

        $this->db->where('status',1);        
        $this->db->where('created_at', $startDate);
        $this->db->where('created_at', $endDate);
        $query = $this->db->get('cab');
        if ($query->num_rows() > 0) {
            return  $query->num_rows();
        } else {         
            return  false;
        }
    }



}
