<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Customer_model extends CI_Model
{
    private $_tablename = 'tbl_customers';

    public function addNewCustomer($customerInfo){
        $this->db->trans_start();
        $this->db->insert($this->_tablename, $customerInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function checkSameCustomer($arrWhere) {
        // $this->db->where('payment_status', $arrWhere['payment_status']);
        // $this->db->where('qr_code_ref', $arrWhere['qr_code_ref']);
        $this->db->where('user_email', $arrWhere['user_email']);
        $this->db->where('street_addr1', $arrWhere['street_addr1']);
        $this->db->where('city1', $arrWhere['city1']);
        $this->db->where('state1', $arrWhere['state1']);
        $this->db->where('zip_code1', $arrWhere['zip_code1']);
        $this->db->where('country1', $arrWhere['country1']);
        $this->db->where('street_addr2', $arrWhere['street_addr2']);
        $this->db->where('city2', $arrWhere['city2']);
        $this->db->where('state2', $arrWhere['state2']);
        $this->db->where('zip_code2', $arrWhere['zip_code2']);
        $this->db->where('country2', $arrWhere['country2']);
        $this->db->where('at_work_by', $arrWhere['at_work_by']);
        $this->db->where('off_work_at', $arrWhere['off_work_at']);
        $this->db->where('nstatus = 1');
        $query = $this->db->get($this->_tablename);
        $result = $query->row();
        if (isset($result))
            return intval($result->id);
        else
            return 0;
    }

    public function getAllCustomers() {
        $this->db->where('nstatus = 1');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get($this->_tablename);
        return $query->result();
    }

    public function deleteCustomer($customerId) {
        $this->db->where('id', $customerId);
        $this->db->delete($this->_tablename);
        return $this->db->affected_rows();
    }

    public function getCustomerById($customerId) {
        $this->db->where('id', $customerId);
        $this->db->where('nstatus = 1');
        $query = $this->db->get($this->_tablename);
        return $query->row();
    }

    public function editCustomer($customerId, $customerInfo) {
        $this->db->where('id', $customerId);
        $this->db->update($this->_tablename, $customerInfo);
        return true;
    }
}