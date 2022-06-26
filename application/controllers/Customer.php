<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Customer (CustomerController)
 * Customer Class to control all Customer related operations.
 * @author : Jason Bock
 * @version : 1.1
 * @since : 15 November 2016
 */
class Customer extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_model');
        $this->isLoggedIn();
    }
    
    /**
     * This function used to load the first screen of the Customer
     */
    public function index()
    {   
        $this->load->view("customer/customerForm.php");
    }

    public function addCustomer() {
        // $payment_status = $this->input->post('payment_status');
        // $qr_code_ref = $this->input->post('qr_code_ref');
        $email = $this->input->post('email');
        $start_point = $this->input->post('start_point');
        $end_point = $this->input->post('end_point');
        $at_work_by = $this->input->post('at_work_by');
        $off_work_at = $this->input->post('off_work_at');

        $arr_start_point = explode(", ", $start_point);
        $arr_end_point = explode(", ", $end_point);

        $arr_zip_code1 = explode(" ", $arr_start_point[2]);
        $arr_zip_code2 = explode(" ", $arr_end_point[2]);

        $street_addr1 = $arr_start_point[0];
        $city1 = $arr_start_point[1];
        $country1 = $arr_start_point[3];
        $zip_code1 = $arr_zip_code1[count($arr_zip_code1) - 1];
        array_pop($arr_zip_code1);
        $state1 = implode(" ", $arr_zip_code1);

        $street_addr2 = $arr_end_point[0];
        $city2 = $arr_end_point[1];
        $country2 = $arr_end_point[3];
        $zip_code2 = $arr_zip_code2[count($arr_zip_code2) - 1];
        array_pop($arr_zip_code2);
        $state2 = implode(" ", $arr_zip_code2);

        $customerInfo = array(
            'payment_status' => 1,
            'qr_code_ref' => "",
            'user_email' => $email,
            'street_addr1' => $street_addr1,
            'city1' => $city1,
            'state1' => $state1,
            'zip_code1' => $zip_code1,
            'country1' => $country1,
            'street_addr2' => $street_addr2,
            'city2' => $city2,
            'state2' => $state2,
            'zip_code2' => $zip_code2,
            'country2' => $country2,
            'at_work_by' => $at_work_by,
            'off_work_at' => $off_work_at,
            'nstatus' => 1
        );

        $sameId = $this->customer_model->checkSameCustomer($customerInfo);
        if ($sameId > 0) {
            echo "same";
        } else {
            $newId = $this->customer_model->addNewCustomer($customerInfo);
            echo "success";
        }
        exit;
    }

    public function viewAllCustomers()
    {
        $allCustomers = $this->customer_model->getAllCustomers();
        $data['allCustomers'] = $allCustomers;
        $this->load->view("customer/customerTable.php", $data);
    }

    public function deleteCustomer()
    {
        $customerId = $this->input->post('customerId');
        $ret = $this->customer_model->deleteCustomer($customerId);
        if ($ret > 0) {
            echo "success";
        } else {
            echo "failed";
        }
        exit;
    }

    public function customerEdit($customerId){
        $customerInfo = $this->customer_model->getCustomerById($customerId);
        $data['customerInfo'] = $customerInfo;
        $this->load->view("customer/customerEdit.php", $data);
    }

    public function editCustomer() {
        $customerId = $this->input->post('customer_id');
        // $payment_status = $this->input->post('payment_status');
        // $qr_code_ref = $this->input->post('qr_code_ref');
        $email = $this->input->post('email');
        $start_point = $this->input->post('start_point');
        $end_point = $this->input->post('end_point');
        $at_work_by = $this->input->post('at_work_by');
        $off_work_at = $this->input->post('off_work_at');

        $arr_start_point = explode(", ", $start_point);
        $arr_end_point = explode(", ", $end_point);

        $arr_zip_code1 = explode(" ", $arr_start_point[2]);
        $arr_zip_code2 = explode(" ", $arr_end_point[2]);

        $street_addr1 = $arr_start_point[0];
        $city1 = $arr_start_point[1];
        $country1 = $arr_start_point[3];
        $zip_code1 = $arr_zip_code1[count($arr_zip_code1) - 1];
        array_pop($arr_zip_code1);
        $state1 = implode(" ", $arr_zip_code1);

        $street_addr2 = $arr_end_point[0];
        $city2 = $arr_end_point[1];
        $country2 = $arr_end_point[3];
        $zip_code2 = $arr_zip_code2[count($arr_zip_code2) - 1];
        array_pop($arr_zip_code2);
        $state2 = implode(" ", $arr_zip_code2);

        $customerInfo = array(
            'payment_status' => 1,
            'qr_code_ref' => "",
            'user_email' => $email,
            'street_addr1' => $street_addr1,
            'city1' => $city1,
            'state1' => $state1,
            'zip_code1' => $zip_code1,
            'country1' => $country1,
            'street_addr2' => $street_addr2,
            'city2' => $city2,
            'state2' => $state2,
            'zip_code2' => $zip_code2,
            'country2' => $country2,
            'at_work_by' => $at_work_by,
            'off_work_at' => $off_work_at,
            'nstatus' => 1
        );

        $sameId = $this->customer_model->checkSameCustomer($customerInfo);
        if ($sameId > 0) {
            echo "same";
        } else {
            $ret = $this->customer_model->editCustomer($customerId, $customerInfo);
            echo "success";
        }
        exit;
    }
}