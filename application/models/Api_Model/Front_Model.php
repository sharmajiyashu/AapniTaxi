<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Front_Model extends CI_Model {

//    function __construct() {
//        parent::__construct();
//        if (!$this->session->userdata('adid'))
//            redirect('admin/login');
//    }

            function ambassador(){

                $data = $this->db->select('personal_details.profile_pic,end_users.first_name,end_users.last_name')
                         ->where('end_users.ambassador', 1)
                         ->join('personal_details','personal_details.user_id = end_users.id','left')
                         ->get('end_users')
                         ->result_array();
                         if ($data) {
                             return $data;
                         }else{
                            return false;
                         }
            }


            function getJobDetails($job_id=NULL){

            $this->db->where("jobs.id", $job_id);
            $this->db->select('jobs.job_title,job_step2.post_name');
            $this->db->join('job_step2', 'job_step2.job_id = jobs.id ');
            $query = $this->db->get('jobs');
            return  $result = $query->row_array();
            }

            function getUserDetail($user_id){

               $data = $this->db->where('id', $user_id)
                         ->select('id,first_name,last_name,email,phone')
                         ->get('end_users')
                         ->row_array();
                         if (!empty($data)) {
                             return $data;
                         }else{
                            return false;
                         }
            }
            


       function latestNews(){

            $this->db->order_by("id", "DESC");
            $query = $this->db->get('news');
            return  $result = $query->result_array();
            }

            function getOffers(){

            $this->db->order_by("id", "DESC");
            // $this->db->limit(4);
            $query = $this->db->get('offer');
            return $result = $query->result_array();
               }

        function getPackage(){

            $this->db->where('status', 'Active');
            $this->db->order_by("id", "DESC");
            $query = $this->db->get('my_package');
            return $result = $query->result_array();
               }

        function getPackageDetails($id=NULL){

            $this->db->where('id', $id);
            $query = $this->db->get('my_package');
            return $result = $query->row_array();
               }


        function savePackagePurchage($data){

            $this->db->insert('package_purchase', $data);
            $insert_id = $this->db->insert_id();

            if (!empty($insert_id)) {
                return $insert_id;
            }else{
                return false;
            }

        }

        function updatePackagePurchage($post_data,$data,$paytm_responce){
            $post_data['paytm_responce'] = $paytm_responce;
         $this->db->where('order_id', $data);
        $sql_query = $this->db->update('package_purchase', $post_data);
        if ($sql_query) {
            return True;
        } else {
            return FALSE;
        }
    }

    function get_UserId($order_id){

        $this->db->where('order_id', $order_id);
        $query = $this->db->get('package_purchase');
        return  $result = $query->row();
    }

    function get_Package_Detatail($order_id){

        $this->db->where('order_id', $order_id);
        $query = $this->db->get('package_purchase');
        return  $result = $query->row_array();
    }




            function get_Job_Detatail($order_id){

                $this->db->where("order_id", $order_id);
                $query = $this->db->get('paytm_payment');
                return  $result = $query->row_array();
                }


        function update_Payment_Status($userData,$status){
        
         $data = array(
            'payment_status ' => $status
        );
          
          $this->db->where('id', $userData);

            $sql_query = $this->db->update('applied_jobs', $data);
            if($sql_query){
                return true;
            } else {
                return FALSE;
            }
        
    }



    function get_UserDetails($id){

        $this->db->where('id', $id);
        $query = $this->db->get('end_users');
        return  $result = $query->row();
    } 


    function get_User_Id($order_id){

        $this->db->where('order_id', $order_id);
        $query = $this->db->get('paytm_payment');
        return  $result = $query->row();
    }


    function get_Job_Category($job_id){

        $this->db->where('job_id', $job_id);
        $query = $this->db->get('job_post_vacancy');
        return  $result = $query->result_array();
    }



    function checkEmail($email){
        $this->db->where('email', $email);
        $query = $this->db->get('end_users');
        $count_rows = $query->num_rows();
        if($count_rows > 0){
            return false;
        } else {
            return true;
        }
    }


    function getJobLoction($state_name){
        $this->db->where('state_id', $state_name);
        $query = $this->db->get('jobs');
        $results = $query->result_array();
       return $results;
    }
    
    function getParentQualification(){
        $this->db->where('status', 'Active');
        $this->db->where('parent_id', '0');
        $query = $this->db->get('qualifications');
        return $query->result_array();
    }



    function save($post_data,$randomNumber) {
        $added_date = date("Y-m-d H:i:s");
        $added_by = isset($_SESSION['adid']) ? $_SESSION['adid'] : '';
        
        $status = 'Inactive';
        $data = array(
            'first_name' => $post_data["first_name"],
            'last_name' => $post_data["last_name"],
            'email' => $post_data["email"],
            'phone' => $post_data["phone"],
            'password' => $post_data["password"],
            'status' => $status,
            //'default_profile' => $post_data["profile"],
            'otp'=>$randomNumber,
            'added_by' => $added_by,
            'added_date' => $added_date
        );
        $sql_query = $this->db->insert('end_users', $data);
        return $this->db->insert_id();
        if ($sql_query) {
            $this->session->set_flashdata('success', 'Registered successfully');
            redirect('front/index');
        } else {
            $this->session->set_flashdata('error', 'Sorry!! some error occurred');
            redirect('front/index');
        }       
    }
    
    
    function api_save($post_data) {
        $added_date = date("Y-m-d H:i:s");
        $status = 'Inactive';
        $data = array(
            'device_id' => $post_data["device_id"],
            'first_name' => $post_data["first_name"],
            'last_name' => $post_data["last_name"],
            'email' => $post_data["email"],
            'phone' => $post_data["phone"],
            'password' => $post_data["password"],
            'status' => $status,
            'default_profile' => '',
            'added_date' => $added_date
        );
        $this->db->db_debug = false;
        $sql_query = $this->db->insert('end_users', $data);
        $db_error = $this->db->error();
//        if(empty($db_error)){
        if(empty($db_error['message'])){
            $insert_id = $this->db->insert_id();
            if ($sql_query) {
                return $validate = array(
                    'status' => 'Success',
                    'msg' => $insert_id
                );
            } else {
                return $validate = array(
                    'status' => 'Failure',
                    'msg' => 'Sorry!! Some error occurred. Kindly try again later.'
                );
            }
        } else {
            return $validate = array(
                'status' => 'Failure',
                'msg' => $db_error['message']
            );
        }
    }

    
    
    function getCategories(){
        $query = $this->db->select()->get('categories');
        return $query->result_array();
    }
    
    
    function getResults() {
        $query = $this->db->select()->get('syllabus');
        return $query->result_array();
    }

    function deleteResult($id) {
        //result id exists of not
        $query = $this->db->select('id')
                ->where('id', $id)
                ->get('syllabus');
        $count_rows = $query->num_rows();
        if ($count_rows > 0) {
            //delete result
            $sql_query = $this->db->where('id', $id)
                    ->delete('syllabus');
            if ($sql_query) {
                $this->session->set_flashdata('success', 'Syllabus deleted successfully');
                redirect('admin/Syllabus/syllabusList');
            }
        } else {
            $this->session->set_flashdata('error', 'Sorry!! Syllabus id does not exists in DB');
            redirect('admin/Syllabus/syllabusList');
        }
    }

    function getResultDetails($id) {
        //result id exists of not
        $query = $this->db->select()
                ->where('id', $id)
                ->get('syllabus');
        $count_rows = $query->num_rows();
        if ($count_rows > 0) {
            return $query->result_array();
        } else {
            $this->session->set_flashdata('error', 'Sorry!! Syllabus id does not exists in DB');
            redirect('admin/Syllabus/syllabusList');
        }
    }

    function updateResult($post_data, $id) {
        $modified_date = date("Y-m-d H:i:s");
        $modified_by = $_SESSION['adid'];
        $status = 'Inactive';
        if (isset($post_data["status"]) && ($post_data["status"] == 'on' || $post_data["status"] == 'Active')) {
            $status = 'Active';
        }
        $data = array(
            'job_id' => $post_data["job"],
            'govt_link' => $post_data["govt_link"],
            'self_link' => $post_data["self_link"],
            'status' => $status,
            'modified_date' => $modified_date,
            'modified_by' => $modified_by
        );



        $this->db->where('id', $id);
        $sql_query = $this->db->update('syllabus', $data);

        if ($sql_query) {
            //get details
            $action_done_by = $_SESSION['adid'];
            $user_data = $this->getUserDetails($action_done_by);
            $description = '[' . $user_data['email'] . '] ' . ' modify the Result.';
            $action_url = 'admin/result/edit';
            parent::AuditTrailLog($user_data[0]->username, $user_data[0]->id, $description, $action_url, NULL, $user_data[0]->email_id);
            $this->session->set_flashdata('success', 'Result Updated successfully');
            redirect('admin/Syllabus/syllabusList');
        } else {
            $this->session->set_flashdata('error', 'Somthing went worng. Error!!');
            redirect('admin/Syllabus/syllabusList');
        }
    }

    function getUserDetails($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('subadmin_user');
        return $query->result();
    }
    
    function getSectors(){
        $this->db->where('status', 'Active');
        $query = $this->db->get('sectors');
        return $query->result_array();
    }
    
    function getStates(){
        $this->db->where('country_id', '101');
        $query = $this->db->get('state');
        return $query->result_array();
    }
    
    function getQualifications(){
        $this->db->where('status', 'Active');
        $query = $this->db->get('qualifications');
        return $query->result_array();
    }
    
    function getLatestJobs(){
        $query = $this->db->select()
                ->where('status', 'Active')
                ->order_by("modified_date", "desc")
                ->limit(8)
                ->get('jobs');
        return $query->result_array();
    }
    
    function getJobs(){
        $query = $this->db->select()
                ->where('status', 'Active')
                ->order_by("added_date", "desc")
                ->get('jobs');
        return $query->result_array();
    }
    
    function getJobDetailsStep1($job_id){
        $query = $this->db->select()
                ->where('id', $job_id)
                ->get('jobs');
        return $query->row_array();
    }
    
    
    function getJobDetailsStep2($job_id){
        $query = $this->db->select()
                ->where('job_id', $job_id)
                ->get('job_step2');
        return $query->row_array();
    }
    
    
    function getJobDetailsStep3($job_id){
        $query = $this->db->select()
                ->where('job_id', $job_id)
                ->get('job_step3');
        return $query->row_array();
    }
    
    
    function getJobDetailsStep4($job_id){
        $query = $this->db->select()
                ->where('job_id', $job_id)
                ->get('job_step4');
        return $query->row_array();
    }
    
    
    function getJobDetailsStep5($job_id){
        $query = $this->db->select()
                ->where('job_id', $job_id)
                ->get('job_step5');
        return $query->row_array();
    }
    
    
    function getJobDetailsStep6($job_id){
        $query = $this->db->select()
                ->where('job_id', $job_id)
                ->get('job_step6');
        return $query->row_array();
    }
    
    
    function getJobDetailsStep7($job_id){
        $query = $this->db->select()
                ->where('job_id', $job_id)
                ->get('job_step7');
        return $query->result_array();
    }
    
    
    function getFormFess($job_id,$categoryId,$postName){
        $query = $this->db->select()
                ->where('job_id', $job_id)
                ->where('category_id', $categoryId)
                ->where('post_name', $postName)
                ->get('job_step7');
        return $query->row_array();
    }
    
    
    function getJobVacancy($job_id,$categoryId,$postName){
        $query = $this->db->select()
                ->where('job_id', $job_id)
                ->where('category_id', $categoryId)
                ->where('post_name', $postName)
                ->get('job_post_vacancy');
        return $query->row_array();
    }
    
    function jobTotalVacancy($job_id){
        $query = $this->db->select('SUM(vacancy)')
                ->where('job_id', $job_id)
                ->get('job_post_vacancy');
        return $query->row_array();
    }
    
    function jobPostTotalVacancy($job_id,$postName){
        $query = $this->db->select('SUM(vacancy)')
                ->where('job_id', $job_id)
                ->where('post_name', $postName)
                ->get('job_post_vacancy');
        return $query->row_array();
    }
    
    
    function getImpLinks($job_id){
        $query = $this->db->select()
                ->where('job_id', $job_id)
                ->get('job_step8');
        return $query->row_array();
    }
    
    
    function getSummary($job_id){
        $query = $this->db->select()
                ->where('job_id', $job_id)
                ->get('job_step9');
        return $query->row_array();
    }

    function get_Job_Title($job_id){
        $query = $this->db->select('job_title')
                ->where('id', $job_id)
                ->get('jobs');
        return $query->row_array();
    }
    
    
    function applyJob($postData=NULL){
          //debug($postData);die();
          // save data queue table for vendor
        $state_id='';
       $que_query = $this->db->where('job_id', $postData['job_id'])
                             ->select('jobs.state_id,job_step2.sector')
                             ->join('job_step2','job_step2.job_id = jobs.id')
                             ->get('jobs')
                             ->row_array();
                           $sector_id =  $que_query['sector'];
                           $state_id =  $que_query['state_id'];
                           $user_id = $_SESSION['uid'];

                             $data = array(
                                   'job_id' => $postData['job_id'],
                                   'state_id' => $state_id,
                                   'sector' => $sector_id,
                                   'user_id' => $user_id,
                                   'added_by'=>$user_id
                                );
                             //debug($data);die;

        $this->db->insert('vendor_queue', $data);
        
        // save data apply job table
        $sql_query = $this->db->insert('applied_jobs', $postData);
        if ($sql_query) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    function save_Paytm_Details($post_data){
        
        $sql_query = $this->db->insert('paytm_payment', $post_data);
        if ($sql_query) {
            $id = $this->db->insert_id();
            
            //get paytm order id
            $p_order_id = $this->getOrderId($id);
            return $p_order_id['order_id'];
        } else {
            return FALSE;
        }
    }
    
    
    function getOrderId($id){
        $query = $this->db->select('order_id')
                ->where('id', $id)
                ->get('paytm_payment');
        return $query->row_array();
    }
    
    function getPaytmOrderCount(){
        $query = $this->db->select('id')
                ->get('paytm_payment');
        $result = $query->result_array();
        return count($result);
        // debug($result);die;
    }


    function update_Paytm_Details($post_data,$data){
         $this->db->where('id', $data);
        $sql_query = $this->db->update('paytm_payment', $post_data);
        if ($sql_query) {
            return True;
        } else {
            return FALSE;
        }
    }



    
    
    function deductWalletPoints($points){
        //get wallet points
        $query = $this->db->select()
                ->where('id', $_SESSION['uid'])
                ->get('end_users');
        $result = $query->row_array();
        if(!empty($result) && isset($result['wallet_points'])){
            $old_points = $result['wallet_points'];
            $newPonits = ($old_points - $points);
            
            $this->session->set_userdata('wallet_points', $newPonits);
            
            //update new points
            $data = array(
                'wallet_points' => $newPonits,
                'modified_date' => date('Y-m-d H:i:s')
            );

            $this->db->where('id', $_SESSION['uid']);
            $sql_query = $this->db->update('end_users', $data);
            if($sql_query){
                return true;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    
    
    function getAppliedJobs($user_id){
        $query = $this->db->select()
                ->where('user_id', $user_id)
                ->get('applied_jobs');
        return $query->result_array();
    }
    
    
    
    function getAlreadyAppliedPosts($job_id,$user_id){
        $query = $this->db->select()
                ->where('job_id', $job_id)
                ->where('user_id', $user_id)
                ->get('applied_jobs');
        return $query->result_array();
    }
    
    
    function getAdmitCardJobs(){
        $query = "Select * from jobs as J, admit_cards as AC where J.id = AC.job_id";
        return $this->db->query($query)->result_array();
    }
    
    
    function getAdmitCardDetails($job_id){
        $query = $this->db->select()
                ->where('job_id', $job_id)
                ->get('admit_cards');
        return $query->row_array();
    }
    
    
    
    function getSyllabusJobs(){
        $query = "Select * from jobs as J, syllabus as S where J.id = S.job_id";
        return $this->db->query($query)->result_array();
    }
    
    
    function getSyllabusDetails($job_id){
        $query = $this->db->select()
                ->where('job_id', $job_id)
                ->get('syllabus');
        return $query->row_array();
    }
    
    
    
    function getresultJobs(){
        $query = "Select * from jobs as J, results as R where J.id = R.job_id";
        return $this->db->query($query)->result_array();
    }
    
    
    function getResultDetails1($job_id){
        $query = $this->db->select()
                ->where('job_id', $job_id)
                ->get('results');
        return $query->row_array();
    }
    
    
    
    function getAnswerKeyJobs(){
        $query = "Select * from jobs as J, answer_keys as AK where J.id = AK.job_id";
        return $this->db->query($query)->result_array();
    }
    
    
    function getAnswerKeyDetails($job_id){
        $query = $this->db->select()
                ->where('job_id', $job_id)
                ->get('answer_keys');
        return $query->row_array();
    }
    
    
    
    
    
    function saveLog($audittraildata) {
        $data = array(
            'user_name' => $audittraildata["AuditTrail"]["user_name"],
            'ip' => $audittraildata["AuditTrail"]["log_ip"],
            'user_id' => $audittraildata["AuditTrail"]["user_id"],
            'action_description' => $audittraildata["AuditTrail"]["description"],
            'action_url' => $audittraildata["AuditTrail"]["action_url"],
            'added_date' => $audittraildata["AuditTrail"]["created_date"],
            'user_role' => $audittraildata["AuditTrail"]["user_role"],
            'email' => $audittraildata["AuditTrail"]["email"]
        );
        $sql_query = $this->db->insert('activity_log', $data);
        if ($sql_query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getAuditData() {
        $query = $this->db->get('activity_log');
        return $query->result();
    }

    function getMobileNumber($id='')
    {   

        $this->db->select('phone');
        $this->db->where('id',$id);
       return $this->db->get('end_users')->result_array();
    }


    function otp_Verify($id,$post_data){

        $query = $this->db->select()
                ->where('id',$id)
                ->where('otp',$post_data['otp'])
                ->get('end_users');
        $result = $query->num_rows();

    if ($result>0) {
        
        $this->db->where(array('id' => $id));
        
        $this->db->update('end_users',array('otp_status'=>1));
        
        $this->session->set_flashdata('success', 'Otp Verfy Successfully');
        redirect('Front/Login');     
    }else{
        $this->session->set_flashdata('error', 'OTP invalid... Try Later!!!...');
           redirect('Front/Otp');     
    }

    }
    
    function checkFormFee($job_id,$cat_id){
        $query = $this->db->select()
                ->where('job_id', $job_id)
                ->where('category_id', $cat_id)
                ->get('job_step7');
        $data = $query->result_array();
        if(!empty($data)){
            return true;
        } else {
            return false;
        }
    }




}
