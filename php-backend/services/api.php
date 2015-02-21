<?php

require_once("Rest.inc.php");

class API extends REST {

    public $data = "";

    const DB_SERVER = "127.0.0.1";
    const DB_USER = "root";
    const DB_PASSWORD = "root";
    const DB = "resource_tracker_db";

    private $db = NULL;
    private $mysqli = NULL;

    public function __construct() {
        parent::__construct();    // Init parent contructor
        $this->dbConnect();     // Initiate Database connection
    }

    /*
     *  Connect to Database
     */

    private function dbConnect() {
        $this->mysqli = new mysqli(self::DB_SERVER, self::DB_USER, self::DB_PASSWORD, self::DB);
    }

    /*
     * Dynmically call the method based on the query string
     */

    public function processApi() {
        $func = strtolower(trim(str_replace("/", "", $_REQUEST['x'])));
        if ((int) method_exists($this, $func) > 0)
            $this->$func();
        else
            $this->response('', 404); // If the method not exist with in this class "Page not found".
    }

//                Login---------------------------------------------------------
    private function login() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
        $email = $this->_request['email'];
        $password = $this->_request['pwd'];
        if (!empty($email) and ! empty($password)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $query = "SELECT uid, name, email FROM users WHERE email = '$email' AND password = '" . md5($password) . "' LIMIT 1";
                $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);

                if ($r->num_rows > 0) {
                    $result = $r->fetch_assoc();
                    // If success everythig is good send header as "OK" and user details
                    $this->response($this->json($result), 200);
                }
                $this->response('', 204); // If no records "No Content" status
            }
        }

        $error = array('status' => "Failed", "msg" => "Invalid Email address or Password");
        $this->response($this->json($error), 400);
    }

//                Customer Service----------------------------------------------

    private function customers() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $query = "SELECT distinct c.customerNumber, c.customerName, c.email, c.address, c.city, c.state, c.postalCode, c.country FROM angularcode_customers c order by c.customerNumber desc";
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);

        if ($r->num_rows > 0) {
            $result = array();
            while ($row = $r->fetch_assoc()) {
                $result[] = $row;
            }
            $this->response($this->json($result), 200); // send user details
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function customer() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "SELECT distinct c.customerNumber, c.customerName, c.email, c.address, c.city, c.state, c.postalCode, c.country FROM angularcode_customers c where c.customerNumber=$id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            if ($r->num_rows > 0) {
                $result = $r->fetch_assoc();
                $this->response($this->json($result), 200); // send user details
            }
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function insertCustomer() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        $customer = json_decode(file_get_contents("php://input"), true);
        $column_names = array('customerName', 'email', 'city', 'address', 'country');
        $keys = array_keys($customer);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the customer received. If blank insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $customer[$desired_key];
            }
            $columns = $columns . $desired_key . ',';
            $values = $values . "'" . $$desired_key . "',";
        }
        $query = "INSERT INTO angularcode_customers(" . trim($columns, ',') . ") VALUES(" . trim($values, ',') . ")";
        if (!empty($customer)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Customer Created Successfully.", "data" => $customer);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); //"No Content" status
    }

    private function updateCustomer() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
        $customer = json_decode(file_get_contents("php://input"), true);
        $id = (int) $customer['id'];
        $column_names = array('customerName', 'email', 'city', 'address', 'country');
        $keys = array_keys($customer['customer']);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the customer received. If key does not exist, insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $customer['customer'][$desired_key];
            }
            $columns = $columns . $desired_key . "='" . $$desired_key . "',";
        }
        $query = "UPDATE angularcode_customers SET " . trim($columns, ',') . " WHERE customerNumber=$id";
        if (!empty($customer)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Customer " . $id . " Updated Successfully.", "data" => $customer);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // "No Content" status
    }

    private function deleteCustomer() {
        if ($this->get_request_method() != "DELETE") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "DELETE FROM angularcode_customers WHERE customerNumber = $id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Successfully deleted one record.");
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // If no records "No Content" status
    }

    //                Currency Service----------------------------------------------
    private function currencies() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $query = "SELECT distinct c.currency_id, c.currency_name FROM currency c order by c.currency_name desc";
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);

        if ($r->num_rows > 0) {
            $result = array();
            while ($row = $r->fetch_assoc()) {
                $result[] = $row;
            }
            $this->response($this->json($result), 200); // send user details
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function currency() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "SELECT distinct c.currency_id, c.currency_name FROM currency c where c.currency_id=$id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            if ($r->num_rows > 0) {
                $result = $r->fetch_assoc();
                $this->response($this->json($result), 200); // send user details
            }
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function insertCurrency() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        $currency = json_decode(file_get_contents("php://input"), true);
        $column_names = array('currency_name');
        $keys = array_keys($currency);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the currency received. If blank insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $currency[$desired_key];
            }
            $columns = $columns . $desired_key . ',';
            $values = $values . "'" . $$desired_key . "',";
        }
        $query = "INSERT INTO currency(" . trim($columns, ',') . ") VALUES(" . trim($values, ',') . ")";
        if (!empty($currency)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Currency Created Successfully.", "data" => $currency);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); //"No Content" status
    }

    private function updateCurrency() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
        $currency = json_decode(file_get_contents("php://input"), true);
        $id = (int) $currency['id'];
        $column_names = array('currency_name');
        $keys = array_keys($currency['currency']);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the currency received. If key does not exist, insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $currency['currency'][$desired_key];
            }
            $columns = $columns . $desired_key . "='" . $$desired_key . "',";
        }
        $query = "UPDATE currency SET " . trim($columns, ',') . " WHERE currency_id=$id";
        if (!empty($currency)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Currency " . $id . " Updated Successfully.", "data" => $currency);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // "No Content" status
    }

    private function deleteCurrency() {
        if ($this->get_request_method() != "DELETE") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "DELETE FROM currency WHERE currency_id = $id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Successfully deleted one record.");
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // If no records "No Content" status
    }
    
    
    //  Region Service----------------------------------------------
    private function regions() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $query = "SELECT distinct r.region_id, r.region_name FROM region r order by r.region_name desc";
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);

        if ($r->num_rows > 0) {
            $result = array();
            while ($row = $r->fetch_assoc()) {
                $result[] = $row;
            }
            $this->response($this->json($result), 200); // send user details
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function region() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "SELECT distinct r.region_id, r.region_name FROM region r where r.region_id=$id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            if ($r->num_rows > 0) {
                $result = $r->fetch_assoc();
                $this->response($this->json($result), 200); // send user details
            }
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function insertRegion() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        $region = json_decode(file_get_contents("php://input"), true);
        $column_names = array('region_name');
        $keys = array_keys($region);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the region received. If blank insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $region[$desired_key];
            }
            $columns = $columns . $desired_key . ',';
            $values = $values . "'" . $$desired_key . "',";
        }
        $query = "INSERT INTO region(" . trim($columns, ',') . ") VALUES(" . trim($values, ',') . ")";
        if (!empty($region)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Region Created Successfully.", "data" => $region);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); //"No Content" status
    }

    private function updateRegion() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
        $region = json_decode(file_get_contents("php://input"), true);
        $id = (int) $region['id'];
        $column_names = array('region_name');
        $keys = array_keys($region['region']);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the region received. If key does not exist, insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $region['region'][$desired_key];
            }
            $columns = $columns . $desired_key . "='" . $$desired_key . "',";
        }
        $query = "UPDATE region SET " . trim($columns, ',') . " WHERE region_id=$id";
        if (!empty($region)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Region " . $id . " Updated Successfully.", "data" => $region);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // "No Content" status
    }

    private function deleteRegion() {
        if ($this->get_request_method() != "DELETE") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "DELETE FROM region WHERE region_id = $id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Successfully deleted one record.");
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // If no records "No Content" status
    }
    
    
    
    //  FinancialYear Service----------------------------------------------
    private function financialYears() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $query = "SELECT distinct f.financial_year_id, f.financial_year_name FROM financial_year f order by f.financial_year_name desc";
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);

        if ($r->num_rows > 0) {
            $result = array();
            while ($row = $r->fetch_assoc()) {
                $result[] = $row;
            }
            $this->response($this->json($result), 200); // send user details
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function financialYear() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "SELECT distinct f.financial_year_id, f.financial_year_name FROM financial_year f where f.financial_year_id=$id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            if ($r->num_rows > 0) {
                $result = $r->fetch_assoc();
                $this->response($this->json($result), 200); // send user details
            }
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function insertFinancialYear() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        $financial_year = json_decode(file_get_contents("php://input"), true);
        $column_names = array('financial_year_name');
        $keys = array_keys($financial_year);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the financial_year received. If blank insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $financial_year[$desired_key];
            }
            $columns = $columns . $desired_key . ',';
            $values = $values . "'" . $$desired_key . "',";
        }
        $query = "INSERT INTO financial_year(" . trim($columns, ',') . ") VALUES(" . trim($values, ',') . ")";
        if (!empty($financial_year)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Financial Year Created Successfully.", "data" => $financial_year);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); //"No Content" status
    }

    private function updateFinancialYear() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
        $financial_year = json_decode(file_get_contents("php://input"), true);
        $id = (int) $financial_year['id'];
        $column_names = array('financial_year_name');
        $keys = array_keys($financial_year['financial_year']);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the financial_year received. If key does not exist, insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $financial_year['financial_year'][$desired_key];
            }
            $columns = $columns . $desired_key . "='" . $$desired_key . "',";
        }
        $query = "UPDATE financial_year SET " . trim($columns, ',') . " WHERE financial_year_id=$id";
        if (!empty($financial_year)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Financial Year " . $id . " Updated Successfully.", "data" => $financial_year);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // "No Content" status
    }

    private function deleteFinancialYear() {
        if ($this->get_request_method() != "DELETE") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "DELETE FROM financial_year WHERE financial_year_id = $id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Successfully deleted one record.");
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // If no records "No Content" status
    }
    
    
    //  OrganisationType Service----------------------------------------------
    private function organisationTypes() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $query = "SELECT distinct o.organisation_type_id, o.organisation_type_name FROM organisation_type o order by o.organisation_type_name desc";
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);

        if ($r->num_rows > 0) {
            $result = array();
            while ($row = $r->fetch_assoc()) {
                $result[] = $row;
            }
            $this->response($this->json($result), 200); // send user details
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function organisationType() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "SELECT distinct o.organisation_type_id, o.organisation_type_name FROM organisation_type o where o.organisation_type_id=$id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            if ($r->num_rows > 0) {
                $result = $r->fetch_assoc();
                $this->response($this->json($result), 200); // send user details
            }
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function insertOrganisationType() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        $organisation_type = json_decode(file_get_contents("php://input"), true);
        $column_names = array('organisation_type_name');
        $keys = array_keys($organisation_type);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the organisation_type received. If blank insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $organisation_type[$desired_key];
            }
            $columns = $columns . $desired_key . ',';
            $values = $values . "'" . $$desired_key . "',";
        }
        $query = "INSERT INTO organisation_type(" . trim($columns, ',') . ") VALUES(" . trim($values, ',') . ")";
        if (!empty($organisation_type)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Organisation Type Created Successfully.", "data" => $organisation_type);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); //"No Content" status
    }

    private function updateOrganisationType() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
        $organisation_type = json_decode(file_get_contents("php://input"), true);
        $id = (int) $organisation_type['id'];
        $column_names = array('organisation_type_name');
        $keys = array_keys($organisation_type['organisation_type']);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the organisation_type received. If key does not exist, insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $organisation_type['organisation_type'][$desired_key];
            }
            $columns = $columns . $desired_key . "='" . $$desired_key . "',";
        }
        $query = "UPDATE organisation_type SET " . trim($columns, ',') . " WHERE organisation_type_id=$id";
        if (!empty($organisation_type)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Organisation Type " . $id . " Updated Successfully.", "data" => $organisation_type);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // "No Content" status
    }

    private function deleteOrganisationType() {
        if ($this->get_request_method() != "DELETE") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "DELETE FROM organisation_type WHERE organisation_type_id = $id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Successfully deleted one record.");
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // If no records "No Content" status
    }
    
    
    //  TypeOfSupport Service----------------------------------------------
    private function typeOfSupports() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $query = "SELECT distinct o.type_of_support_id, o.type_of_support_name FROM type_of_support o order by o.type_of_support_name desc";
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);

        if ($r->num_rows > 0) {
            $result = array();
            while ($row = $r->fetch_assoc()) {
                $result[] = $row;
            }
            $this->response($this->json($result), 200); // send user details
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function typeOfSupport() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "SELECT distinct o.type_of_support_id, o.type_of_support_name FROM type_of_support o where o.type_of_support_id=$id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            if ($r->num_rows > 0) {
                $result = $r->fetch_assoc();
                $this->response($this->json($result), 200); // send user details
            }
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function insertTypeOfSupport() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        $type_of_support = json_decode(file_get_contents("php://input"), true);
        $column_names = array('type_of_support_name');
        $keys = array_keys($type_of_support);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the type_of_support received. If blank insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $type_of_support[$desired_key];
            }
            $columns = $columns . $desired_key . ',';
            $values = $values . "'" . $$desired_key . "',";
        }
        $query = "INSERT INTO type_of_support(" . trim($columns, ',') . ") VALUES(" . trim($values, ',') . ")";
        if (!empty($type_of_support)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Type Of Support Created Successfully.", "data" => $type_of_support);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); //"No Content" status
    }

    private function updateTypeOfSupport() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
        $type_of_support = json_decode(file_get_contents("php://input"), true);
        $id = (int) $type_of_support['id'];
        $column_names = array('type_of_support_name');
        $keys = array_keys($type_of_support['type_of_support']);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the type_of_support received. If key does not exist, insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $type_of_support['type_of_support'][$desired_key];
            }
            $columns = $columns . $desired_key . "='" . $$desired_key . "',";
        }
        $query = "UPDATE type_of_support SET " . trim($columns, ',') . " WHERE type_of_support_id=$id";
        if (!empty($type_of_support)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Type Of Support " . $id . " Updated Successfully.", "data" => $type_of_support);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // "No Content" status
    }

    private function deleteTypeOfSupport() {
        if ($this->get_request_method() != "DELETE") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "DELETE FROM type_of_support WHERE type_of_support_id = $id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Successfully deleted one record.");
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // If no records "No Content" status
    }

    
        //  PartnerType Service----------------------------------------------
    private function partnerTypes() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $query = "SELECT distinct o.partner_type_id, o.partner_type_name FROM partner_type o order by o.partner_type_name desc";
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);

        if ($r->num_rows > 0) {
            $result = array();
            while ($row = $r->fetch_assoc()) {
                $result[] = $row;
            }
            $this->response($this->json($result), 200); // send user details
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function partnerType() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "SELECT distinct o.partner_type_id, o.partner_type_name FROM partner_type o where o.partner_type_id=$id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            if ($r->num_rows > 0) {
                $result = $r->fetch_assoc();
                $this->response($this->json($result), 200); // send user details
            }
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function insertPartnerType() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        $partner_type = json_decode(file_get_contents("php://input"), true);
        $column_names = array('partner_type_name');
        $keys = array_keys($partner_type);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the partner_type received. If blank insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $partner_type[$desired_key];
            }
            $columns = $columns . $desired_key . ',';
            $values = $values . "'" . $$desired_key . "',";
        }
        $query = "INSERT INTO partner_type(" . trim($columns, ',') . ") VALUES(" . trim($values, ',') . ")";
        if (!empty($partner_type)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Partner Type Created Successfully.", "data" => $partner_type);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); //"No Content" status
    }

    private function updatePartnerType() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
        $partner_type = json_decode(file_get_contents("php://input"), true);
        $id = (int) $partner_type['id'];
        $column_names = array('partner_type_name');
        $keys = array_keys($partner_type['partner_type']);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the partner_type received. If key does not exist, insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $partner_type['partner_type'][$desired_key];
            }
            $columns = $columns . $desired_key . "='" . $$desired_key . "',";
        }
        $query = "UPDATE partner_type SET " . trim($columns, ',') . " WHERE partner_type_id=$id";
        if (!empty($partner_type)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Partner Type " . $id . " Updated Successfully.", "data" => $partner_type);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // "No Content" status
    }

    private function deletePartnerType() {
        if ($this->get_request_method() != "DELETE") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "DELETE FROM partner_type WHERE partner_type_id = $id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Successfully deleted one record.");
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // If no records "No Content" status
    }
    
    
    //  Authority Service----------------------------------------------
    private function authoritys() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $query = "SELECT distinct o.authority_id, o.authority_name FROM authority o order by o.authority_name desc";
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);

        if ($r->num_rows > 0) {
            $result = array();
            while ($row = $r->fetch_assoc()) {
                $result[] = $row;
            }
            $this->response($this->json($result), 200); // send user details
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function authority() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "SELECT distinct o.authority_id, o.authority_name FROM authority o where o.authority_id=$id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            if ($r->num_rows > 0) {
                $result = $r->fetch_assoc();
                $this->response($this->json($result), 200); // send user details
            }
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function insertAuthority() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        $authority = json_decode(file_get_contents("php://input"), true);
        $column_names = array('authority_name');
        $keys = array_keys($authority);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the authority received. If blank insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $authority[$desired_key];
            }
            $columns = $columns . $desired_key . ',';
            $values = $values . "'" . $$desired_key . "',";
        }
        $query = "INSERT INTO authority(" . trim($columns, ',') . ") VALUES(" . trim($values, ',') . ")";
        if (!empty($authority)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Authority Created Successfully.", "data" => $authority);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); //"No Content" status
    }

    private function updateAuthority() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
        $authority = json_decode(file_get_contents("php://input"), true);
        $id = (int) $authority['id'];
        $column_names = array('authority_name');
        $keys = array_keys($authority['authority']);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the authority received. If key does not exist, insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $authority['authority'][$desired_key];
            }
            $columns = $columns . $desired_key . "='" . $$desired_key . "',";
        }
        $query = "UPDATE authority SET " . trim($columns, ',') . " WHERE authority_id=$id";
        if (!empty($authority)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Authority " . $id . " Updated Successfully.", "data" => $authority);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // "No Content" status
    }

    private function deleteAuthority() {
        if ($this->get_request_method() != "DELETE") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "DELETE FROM authority WHERE authority_id = $id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Successfully deleted one record.");
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // If no records "No Content" status
    }
    
    
    //  CostCategory Service----------------------------------------------
    private function costCategorys() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $query = "SELECT distinct o.cost_category_id, o.cost_category_name FROM cost_category o order by o.cost_category_name desc";
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);

        if ($r->num_rows > 0) {
            $result = array();
            while ($row = $r->fetch_assoc()) {
                $result[] = $row;
            }
            $this->response($this->json($result), 200); // send user details
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function costCategory() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "SELECT distinct o.cost_category_id, o.cost_category_name FROM cost_category o where o.cost_category_id=$id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            if ($r->num_rows > 0) {
                $result = $r->fetch_assoc();
                $this->response($this->json($result), 200); // send user details
            }
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function insertCostCategory() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        $cost_category = json_decode(file_get_contents("php://input"), true);
        $column_names = array('cost_category_name');
        $keys = array_keys($cost_category);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the cost_category received. If blank insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $cost_category[$desired_key];
            }
            $columns = $columns . $desired_key . ',';
            $values = $values . "'" . $$desired_key . "',";
        }
        $query = "INSERT INTO cost_category(" . trim($columns, ',') . ") VALUES(" . trim($values, ',') . ")";
        if (!empty($cost_category)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Cost Category Created Successfully.", "data" => $cost_category);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); //"No Content" status
    }

    private function updateCostCategory() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
        $cost_category = json_decode(file_get_contents("php://input"), true);
        $id = (int) $cost_category['id'];
        $column_names = array('cost_category_name');
        $keys = array_keys($cost_category['cost_category']);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the cost_category received. If key does not exist, insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $cost_category['cost_category'][$desired_key];
            }
            $columns = $columns . $desired_key . "='" . $$desired_key . "',";
        }
        $query = "UPDATE cost_category SET " . trim($columns, ',') . " WHERE cost_category_id=$id";
        if (!empty($cost_category)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Cost Category " . $id . " Updated Successfully.", "data" => $cost_category);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // "No Content" status
    }

    private function deleteCostCategory() {
        if ($this->get_request_method() != "DELETE") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "DELETE FROM cost_category WHERE cost_category_id = $id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Successfully deleted one record.");
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // If no records "No Content" status
    }
    
    //  District Service----------------------------------------------
    private function districts() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $query = "SELECT distinct o.district_id, o.district_name, r.region_name FROM district o inner join region r on o.region_id = r.region_id  order by r.region_name desc";
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);

        if ($r->num_rows > 0) {
            $result = array();
            while ($row = $r->fetch_assoc()) {
                $result[] = $row;
            }
            $this->response($this->json($result), 200); // send user details
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function district() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "SELECT distinct o.district_id, o.district_name FROM district o where o.district_id=$id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            if ($r->num_rows > 0) {
                $result = $r->fetch_assoc();
                $this->response($this->json($result), 200); // send user details
            }
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function insertDistrict() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        $district = json_decode(file_get_contents("php://input"), true);
        $column_names = array('district_name','region_id');
        $keys = array_keys($district);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the district received. If blank insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $district[$desired_key];
            }
            $columns = $columns . $desired_key . ',';
            $values = $values . "'" . $$desired_key . "',";
        }
        $query = "INSERT INTO district(" . trim($columns, ',') . ") VALUES(" . trim($values, ',') . ")";
        if (!empty($district)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "District Created Successfully.", "data" => $district);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); //"No Content" status
    }

    private function updateDistrict() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
        $district = json_decode(file_get_contents("php://input"), true);
        $id = (int) $district['id'];
        $column_names = array('district_name','region_id');
        $keys = array_keys($district['district']);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the district received. If key does not exist, insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $district['district'][$desired_key];
            }
            $columns = $columns . $desired_key . "='" . $$desired_key . "',";
        }
        $query = "UPDATE district SET " . trim($columns, ',') . " WHERE district_id=$id";
        if (!empty($district)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "District " . $id . " Updated Successfully.", "data" => $district);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // "No Content" status
    }

    private function deleteDistrict() {
        if ($this->get_request_method() != "DELETE") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "DELETE FROM district WHERE district_id = $id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Successfully deleted one record.");
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // If no records "No Content" status
    }
    
    //  SubCategoryOfSupport Service----------------------------------------------
    private function subCategoryOfSupports() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $query = "SELECT distinct o.sub_category_of_support_id, o.sub_category_of_support_name, t.type_of_support_name as type_of_support_name FROM sub_category_of_support o inner join type_of_support t on o.type_of_support_id = t.type_of_support_id order by t.type_of_support_name desc";
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);

        if ($r->num_rows > 0) {
            $result = array();
            while ($row = $r->fetch_assoc()) {
                $result[] = $row;
            }
            $this->response($this->json($result), 200); // send user details
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function subCategoryOfSupport() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "SELECT distinct o.sub_category_of_support_id, o.sub_category_of_support_name, t.type_of_support_name as type_of_support_name FROM sub_category_of_support o inner join type_of_support t on o.type_of_support_id = t.type_of_support_id where o.sub_category_of_support_id=$id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            if ($r->num_rows > 0) {
                $result = $r->fetch_assoc();
                $this->response($this->json($result), 200); // send user details
            }
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function insertSubCategoryOfSupport() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        $sub_category_of_support = json_decode(file_get_contents("php://input"), true);
        $column_names = array('sub_category_of_support_name','type_of_support_id');
        $keys = array_keys($sub_category_of_support);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the sub_category_of_support received. If blank insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $sub_category_of_support[$desired_key];
            }
            $columns = $columns . $desired_key . ',';
            $values = $values . "'" . $$desired_key . "',";
        }
        $query = "INSERT INTO sub_category_of_support(" . trim($columns, ',') . ") VALUES(" . trim($values, ',') . ")";
        if (!empty($sub_category_of_support)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "SubCategory Of Support Created Successfully.", "data" => $sub_category_of_support);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); //"No Content" status
    }

    private function updateSubCategoryOfSupport() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
        $sub_category_of_support = json_decode(file_get_contents("php://input"), true);
        $id = (int) $sub_category_of_support['id'];
        $column_names = array('sub_category_of_support_name','type_of_support_id');
        $keys = array_keys($sub_category_of_support['sub_category_of_support']);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the sub_category_of_support received. If key does not exist, insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $sub_category_of_support['sub_category_of_support'][$desired_key];
            }
            $columns = $columns . $desired_key . "='" . $$desired_key . "',";
        }
        $query = "UPDATE sub_category_of_support SET " . trim($columns, ',') . " WHERE sub_category_of_support_id=$id";
        if (!empty($sub_category_of_support)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "SubCategory Of Support " . $id . " Updated Successfully.", "data" => $sub_category_of_support);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // "No Content" status
    }

    private function deleteSubCategoryOfSupport() {
        if ($this->get_request_method() != "DELETE") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "DELETE FROM sub_category_of_support WHERE sub_category_of_support_id = $id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Successfully deleted one record.");
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // If no records "No Content" status
    }
    
    
    
    //  Organisation Service----------------------------------------------
    private function organisations() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $query = "SELECT distinct r.organisation_id, r.organisation_name, ot.organisation_type_name, r.fiscal_year_start, r.provided_pools_fund_for_health, r.signed_mou_with_moh, r.date_started_working_in_districts, a.authority_name, r.contact_name, r.mobile_phone, r.office_phone, r.email FROM organisation r inner join organisation_type ot on r.organisation_type_id = ot.organisation_type_id inner join authority a on r.authority_consulted_Id = a.authority_id order by r.organisation_name desc";
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);

        if ($r->num_rows > 0) {
            $result = array();
            while ($row = $r->fetch_assoc()) {
                $result[] = $row;
            }
            $this->response($this->json($result), 200); // send user details
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function organisation() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "SELECT distinct r.organisation_id, r.organisation_name, ot.organisation_type_name, r.fiscal_year_start, r.provided_pools_fund_for_health, r.signed_mou_with_moh, r.date_started_working_in_districts, a.authority_name, r.contact_name, r.mobile_phone, r.office_phone, r.email FROM organisation r inner join organisation_type ot on r.organisation_type_id = ot.organisation_type_id inner join authority a on r.authority_consulted_Id = a.authority_id where r.organisation_id=$id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            if ($r->num_rows > 0) {
                $result = $r->fetch_assoc();
                $this->response($this->json($result), 200); // send user details
            }
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function insertOrganisation() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        $organisation = json_decode(file_get_contents("php://input"), true);
        $column_names = array('organisation_name','organisation_type_id','fiscal_year_start','provided_pools_fund_for_health','signed_mou_with_moh','date_started_working_in_districts','authority_consulted_Id','contact_name','mobile_phone','office_phone','email');
        $keys = array_keys($organisation);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the organisation received. If blank insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $organisation[$desired_key];
            }
            $columns = $columns . $desired_key . ',';
            $values = $values . "'" . $$desired_key . "',";
        }
        $query = "INSERT INTO organisation(" . trim($columns, ',') . ") VALUES(" . trim($values, ',') . ")";
        if (!empty($organisation)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Organisation Created Successfully.", "data" => $organisation);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); //"No Content" status
    }

    private function updateOrganisation() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
        $organisation = json_decode(file_get_contents("php://input"), true);
        $id = (int) $organisation['id'];
        $column_names = array('organisation_name','organisation_type_id','fiscal_year_start','provided_pools_fund_for_health','signed_mou_with_moh','date_started_working_in_districts','authority_consulted_Id','contact_name','mobile_phone','office_phone','email');
        $keys = array_keys($organisation['organisation']);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the organisation received. If key does not exist, insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $organisation['organisation'][$desired_key];
            }
            $columns = $columns . $desired_key . "='" . $$desired_key . "',";
        }
        $query = "UPDATE organisation SET " . trim($columns, ',') . " WHERE organisation_id=$id";
        if (!empty($organisation)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Organisation " . $id . " Updated Successfully.", "data" => $organisation);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // "No Content" status
    }

    private function deleteOrganisation() {
        if ($this->get_request_method() != "DELETE") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "DELETE FROM organisation WHERE organisation_id = $id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Successfully deleted one record.");
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // If no records "No Content" status
    }

    
    //  Project Service----------------------------------------------
    private function projects() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $query = "SELECT distinct r.project_id, r.project_name, r.project_description, fo.organisation_name as financing_agent, impo.organisation_name as implementer from project r inner join organisation fo on r.organisation_financing_agent_id = fo.organisation_id inner join organisation impo on r.organisation_implementer_id = impo.organisation_id;";
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);

        if ($r->num_rows > 0) {
            $result = array();
            while ($row = $r->fetch_assoc()) {
                $result[] = $row;
            }
            $this->response($this->json($result), 200); // send user details
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function project() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "SELECT distinct r.project_id, r.project_name, r.project_description, fo.organisation_name as financing_agent, impo.organisation_name as implementer from project r inner join organisation fo on r.organisation_financing_agent_id = fo.organisation_id inner join organisation impo on r.organisation_implementer_id = impo.organisation_id where r.project_id=$id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            if ($r->num_rows > 0) {
                $result = $r->fetch_assoc();
                $this->response($this->json($result), 200); // send user details
            }
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function insertProject() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        $project = json_decode(file_get_contents("php://input"), true);
        $column_names = array('project_name','project_description','organisation_financing_agent_id','organisation_implementer_id');
        $keys = array_keys($project);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the project received. If blank insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $project[$desired_key];
            }
            $columns = $columns . $desired_key . ',';
            $values = $values . "'" . $$desired_key . "',";
        }
        $query = "INSERT INTO project(" . trim($columns, ',') . ") VALUES(" . trim($values, ',') . ")";
        if (!empty($project)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Project Created Successfully.", "data" => $project);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); //"No Content" status
    }

    private function updateProject() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
        $project = json_decode(file_get_contents("php://input"), true);
        $id = (int) $project['id'];
        $column_names = array('project_name','project_description','organisation_financing_agent_id','organisation_implementer_id');
        $keys = array_keys($project['project']);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the project received. If key does not exist, insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $project['project'][$desired_key];
            }
            $columns = $columns . $desired_key . "='" . $$desired_key . "',";
        }
        $query = "UPDATE project SET " . trim($columns, ',') . " WHERE project_id=$id";
        if (!empty($project)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Project " . $id . " Updated Successfully.", "data" => $project);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // "No Content" status
    }

    private function deleteProject() {
        if ($this->get_request_method() != "DELETE") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "DELETE FROM project WHERE project_id = $id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Successfully deleted one record.");
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // If no records "No Content" status
    }

    
        //  Partner Service----------------------------------------------
    private function partners() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $query = "SELECT distinct p.partner_id, pt.partner_type_name, p.partner_name, p.partner_contact_name, p.partner_contact_phone, p.partner_contact_email from partner p inner join partner_type pt on p.partner_type_id = pt.partner_type_id;";
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);

        if ($r->num_rows > 0) {
            $result = array();
            while ($row = $r->fetch_assoc()) {
                $result[] = $row;
            }
            $this->response($this->json($result), 200); // send user details
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function partner() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "SELECT distinct p.partner_id, pt.partner_type_name, p.partner_name, p.partner_contact_name, p.partner_contact_phone, p.partner_contact_email from partner p inner join partner_type pt on p.partner_type_id = pt.partner_type_id where p.partner_id=$id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            if ($r->num_rows > 0) {
                $result = $r->fetch_assoc();
                $this->response($this->json($result), 200); // send user details
            }
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function insertPartner() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        $partner = json_decode(file_get_contents("php://input"), true);
        $column_names = array('partner_type_id','partner_name','partner_contact_name','partner_contact_phone','partner_contact_email');
        $keys = array_keys($partner);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the partner received. If blank insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $partner[$desired_key];
            }
            $columns = $columns . $desired_key . ',';
            $values = $values . "'" . $$desired_key . "',";
        }
        $query = "INSERT INTO partner(" . trim($columns, ',') . ") VALUES(" . trim($values, ',') . ")";
        if (!empty($partner)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Partner Created Successfully.", "data" => $partner);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); //"No Content" status
    }

    private function updatePartner() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
        $partner = json_decode(file_get_contents("php://input"), true);
        $id = (int) $partner['id'];
        $column_names = array('partner_type_id','partner_name','partner_contact_name','partner_contact_phone','partner_contact_email');
        $keys = array_keys($partner['partner']);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the partner received. If key does not exist, insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $partner['partner'][$desired_key];
            }
            $columns = $columns . $desired_key . "='" . $$desired_key . "',";
        }
        $query = "UPDATE partner SET " . trim($columns, ',') . " WHERE partner_id=$id";
        if (!empty($partner)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Partner " . $id . " Updated Successfully.", "data" => $partner);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // "No Content" status
    }

    private function deletePartner() {
        if ($this->get_request_method() != "DELETE") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "DELETE FROM partner WHERE partner_id = $id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Successfully deleted one record.");
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // If no records "No Content" status
    }
    
    //  Budget Service----------------------------------------------
    private function budgets() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $query = "SELECT b.budget_id, fc.currency_name as financing_currency, sc.currency_name as spending_currency, f.financial_year_name, b.total_budget, p.project_name, concat(p.project_name, ' ( ', b.total_budget, ' )') as project_and_total_amount FROM budget b inner join currency fc on b.financing_currency_id = fc.currency_id inner join currency sc on b.spending_currency_id = sc.currency_id inner join financial_year f on b.financial_year_id = f.financial_year_id inner join project p on b.project_id = p.project_id;";
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);

        if ($r->num_rows > 0) {
            $result = array();
            while ($row = $r->fetch_assoc()) {
                $result[] = $row;
            }
            $this->response($this->json($result), 200); // send user details
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function budget() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "SELECT b.budget_id, fc.currency_name as financing_currency, sc.currency_name as spending_currency, f.financial_year_name, b.total_budget, p.project_name, concat(p.project_name, ' ( ', b.total_budget, ' )') as project_and_total_amount FROM budget b inner join currency fc on b.financing_currency_id = fc.currency_id inner join currency sc on b.spending_currency_id = sc.currency_id inner join financial_year f on b.financial_year_id = f.financial_year_id inner join project p on b.project_id = p.project_id where p.budget_id=$id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            if ($r->num_rows > 0) {
                $result = $r->fetch_assoc();
                $this->response($this->json($result), 200); // send user details
            }
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function insertBudget() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        $budget = json_decode(file_get_contents("php://input"), true);
        $column_names = array('financing_currency_id','spending_currency_id','financial_year_id','total_budget','project_id');
        $keys = array_keys($budget);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the budget received. If blank insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $budget[$desired_key];
            }
            $columns = $columns . $desired_key . ',';
            $values = $values . "'" . $$desired_key . "',";
        }
        $query = "INSERT INTO budget(" . trim($columns, ',') . ") VALUES(" . trim($values, ',') . ")";
        if (!empty($budget)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Budget Created Successfully.", "data" => $budget);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); //"No Content" status
    }

    private function updateBudget() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
        $budget = json_decode(file_get_contents("php://input"), true);
        $id = (int) $budget['id'];
        $column_names = array('financing_currency_id','spending_currency_id','financial_year_id','total_budget','project_id');
        $keys = array_keys($budget['budget']);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the budget received. If key does not exist, insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $budget['budget'][$desired_key];
            }
            $columns = $columns . $desired_key . "='" . $$desired_key . "',";
        }
        $query = "UPDATE budget SET " . trim($columns, ',') . " WHERE budget_id=$id";
        if (!empty($budget)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Budget " . $id . " Updated Successfully.", "data" => $budget);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // "No Content" status
    }

    private function deleteBudget() {
        if ($this->get_request_method() != "DELETE") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "DELETE FROM budget WHERE budget_id = $id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Successfully deleted one record.");
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // If no records "No Content" status
    }
    
    
     //  TypeOfSupportBudget Service----------------------------------------------
    private function typeOfSupportBudgets() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $query = "SELECT tsb.type_of_support_budget_id, ts.type_of_support_name, b.total_budget, tsb.budget_amount, b.project_and_total_amount FROM type_of_support_budget tsb inner join type_of_support ts on tsb.type_of_support_id = ts.type_of_support_id inner join (SELECT b.budget_id, fc.currency_name as financing_currency, sc.currency_name as spending_currency, f.financial_year_name, b.total_budget, p.project_name, concat(p.project_name, ' ( ', b.total_budget, ' )') as project_and_total_amount FROM budget b inner join currency fc on b.financing_currency_id = fc.currency_id inner join currency sc on b.spending_currency_id = sc.currency_id inner join financial_year f on b.financial_year_id = f.financial_year_id inner join project p on b.project_id = p.project_id) b on tsb.budget_id = b.budget_id;";
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);

        if ($r->num_rows > 0) {
            $result = array();
            while ($row = $r->fetch_assoc()) {
                $result[] = $row;
            }
            $this->response($this->json($result), 200); // send user details
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function typeOfSupportBudget() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "SELECT tsb.type_of_support_budget_id, ts.type_of_support_name, b.total_budget, tsb.budget_amount FROM type_of_support_budget tsb inner join type_of_support ts on tsb.type_of_support_id = ts.type_of_support_id inner join budget b on tsb.budget_id = b.budget_id where tsb.type_of_support_budget_id=$id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            if ($r->num_rows > 0) {
                $result = $r->fetch_assoc();
                $this->response($this->json($result), 200); // send user details
            }
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function insertTypeOfSupportBudget() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        $type_of_support_budget = json_decode(file_get_contents("php://input"), true);
        $column_names = array('type_of_support_id','budget_id','budget_amount');
        $keys = array_keys($type_of_support_budget);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the type_of_support_budget received. If blank insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $type_of_support_budget[$desired_key];
            }
            $columns = $columns . $desired_key . ',';
            $values = $values . "'" . $$desired_key . "',";
        }
        $query = "INSERT INTO type_of_support_budget(" . trim($columns, ',') . ") VALUES(" . trim($values, ',') . ")";
        if (!empty($type_of_support_budget)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Type Of Support Budget Created Successfully.", "data" => $type_of_support_budget);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); //"No Content" status
    }

    private function updateTypeOfSupportBudget() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
        $type_of_support_budget = json_decode(file_get_contents("php://input"), true);
        $id = (int) $type_of_support_budget['id'];
        $column_names = array('type_of_support_id','budget_id','budget_amount');
        $keys = array_keys($type_of_support_budget['type_of_support_budget']);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the type_of_support_budget received. If key does not exist, insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $type_of_support_budget['type_of_support_budget'][$desired_key];
            }
            $columns = $columns . $desired_key . "='" . $$desired_key . "',";
        }
        $query = "UPDATE type_of_support_budget SET " . trim($columns, ',') . " WHERE type_of_support_budget_id=$id";
        if (!empty($type_of_support_budget)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Type Of Support Budget " . $id . " Updated Successfully.", "data" => $type_of_support_budget);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // "No Content" status
    }

    private function deleteTypeOfSupportBudget() {
        if ($this->get_request_method() != "DELETE") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "DELETE FROM type_of_support_budget WHERE type_of_support_budget_id = $id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Successfully deleted one record.");
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // If no records "No Content" status
    }
    
    //  ProjectSubCategoryOfSupportBudget Service----------------------------------------------
    private function projectSubCategoryOfSupportBudgets() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $query = "SELECT p.project_sub_category_of_support_budget_id, tsb.budget_amount as type_of_support_budget_amount, sof.sub_category_of_support_name, p.budget_amount as sub_category_of_support_budget_amount FROM project_sub_category_of_support_budget p inner join type_of_support_budget tsb on p.type_of_support_budget_id = tsb.type_of_support_budget_id inner join sub_category_of_support sof on p.sub_category_of_support_id = sof.sub_category_of_support_id;";
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);

        if ($r->num_rows > 0) {
            $result = array();
            while ($row = $r->fetch_assoc()) {
                $result[] = $row;
            }
            $this->response($this->json($result), 200); // send user details
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function projectSubCategoryOfSupportBudget() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "SELECT p.project_sub_category_of_support_budget_id, tsb.budget_amount as type_of_support_budget_amount, sof.sub_category_of_support_name, p.budget_amount as sub_category_of_support_budget_amount FROM project_sub_category_of_support_budget p inner join type_of_support_budget tsb on p.type_of_support_budget_id = tsb.type_of_support_budget_id inner join sub_category_of_support sof on p.sub_category_of_support_id = sof.sub_category_of_support_id where p.project_sub_category_of_support_budget_id=$id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            if ($r->num_rows > 0) {
                $result = $r->fetch_assoc();
                $this->response($this->json($result), 200); // send user details
            }
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function insertProjectSubCategoryOfSupportBudget() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        $project_sub_category_of_support_budget = json_decode(file_get_contents("php://input"), true);
        $column_names = array('type_of_support_budget_id','sub_category_of_support_id','budget_amount');
        $keys = array_keys($project_sub_category_of_support_budget);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the project_sub_category_of_support_budget received. If blank insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $project_sub_category_of_support_budget[$desired_key];
            }
            $columns = $columns . $desired_key . ',';
            $values = $values . "'" . $$desired_key . "',";
        }
        $query = "INSERT INTO project_sub_category_of_support_budget(" . trim($columns, ',') . ") VALUES(" . trim($values, ',') . ")";
        if (!empty($project_sub_category_of_support_budget)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Project SubCategory Of Support Budget Created Successfully.", "data" => $project_sub_category_of_support_budget);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); //"No Content" status
    }

    private function updateProjectSubCategoryOfSupportBudget() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
        $project_sub_category_of_support_budget = json_decode(file_get_contents("php://input"), true);
        $id = (int) $project_sub_category_of_support_budget['id'];
        $column_names = array('type_of_support_budget_id','sub_category_of_support_id','budget_amount');
        $keys = array_keys($project_sub_category_of_support_budget['project_sub_category_of_support_budget']);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the project_sub_category_of_support_budget received. If key does not exist, insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $project_sub_category_of_support_budget['project_sub_category_of_support_budget'][$desired_key];
            }
            $columns = $columns . $desired_key . "='" . $$desired_key . "',";
        }
        $query = "UPDATE project_sub_category_of_support_budget SET " . trim($columns, ',') . " WHERE project_sub_category_of_support_budget_id=$id";
        if (!empty($project_sub_category_of_support_budget)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Project SubCategory Of Support Budget " . $id . " Updated Successfully.", "data" => $project_sub_category_of_support_budget);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // "No Content" status
    }

    private function deleteProjectSubCategoryOfSupportBudget() {
        if ($this->get_request_method() != "DELETE") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "DELETE FROM project_sub_category_of_support_budget WHERE project_sub_category_of_support_budget_id = $id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Successfully deleted one record.");
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // If no records "No Content" status
    }
    
    
        
     //  NationalBudget Service----------------------------------------------
    private function nationalBudgets() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $query = "SELECT nb.national_budget_id, b.total_budget, nb.budget_amount as national_budget_amount, b.project_and_total_amount FROM national_budget nb inner join (SELECT b.budget_id, fc.currency_name as financing_currency, sc.currency_name as spending_currency, f.financial_year_name, b.total_budget, p.project_name, concat(p.project_name, ' ( ', b.total_budget, ' )') as project_and_total_amount FROM budget b inner join currency fc on b.financing_currency_id = fc.currency_id inner join currency sc on b.spending_currency_id = sc.currency_id inner join financial_year f on b.financial_year_id = f.financial_year_id inner join project p on b.project_id = p.project_id) b on nb.budget_id = b.budget_id;";
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);

        if ($r->num_rows > 0) {
            $result = array();
            while ($row = $r->fetch_assoc()) {
                $result[] = $row;
            }
            $this->response($this->json($result), 200); // send user details
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function nationalBudget() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "SELECT nb.national_budget_id, b.total_budget, nb.budget_amount as national_budget_amount, b.project_and_total_amount FROM national_budget nb inner join (SELECT b.budget_id, fc.currency_name as financing_currency, sc.currency_name as spending_currency, f.financial_year_name, b.total_budget, p.project_name, concat(p.project_name, ' ( ', b.total_budget, ' )') as project_and_total_amount FROM budget b inner join currency fc on b.financing_currency_id = fc.currency_id inner join currency sc on b.spending_currency_id = sc.currency_id inner join financial_year f on b.financial_year_id = f.financial_year_id inner join project p on b.project_id = p.project_id) b on nb.budget_id = b.budget_id where nb.national_budget_id=$id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            if ($r->num_rows > 0) {
                $result = $r->fetch_assoc();
                $this->response($this->json($result), 200); // send user details
            }
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function insertNationalBudget() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        $national_budget = json_decode(file_get_contents("php://input"), true);
        $column_names = array('budget_id','budget_amount');
        $keys = array_keys($national_budget);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the national_budget received. If blank insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $national_budget[$desired_key];
            }
            $columns = $columns . $desired_key . ',';
            $values = $values . "'" . $$desired_key . "',";
        }
        $query = "INSERT INTO national_budget(" . trim($columns, ',') . ") VALUES(" . trim($values, ',') . ")";
        if (!empty($national_budget)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "National Budget Created Successfully.", "data" => $national_budget);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); //"No Content" status
    }

    private function updateNationalBudget() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
        $national_budget = json_decode(file_get_contents("php://input"), true);
        $id = (int) $national_budget['id'];
        $column_names = array('budget_id','budget_amount');
        $keys = array_keys($national_budget['national_budget']);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the national_budget received. If key does not exist, insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $national_budget['national_budget'][$desired_key];
            }
            $columns = $columns . $desired_key . "='" . $$desired_key . "',";
        }
        $query = "UPDATE national_budget SET " . trim($columns, ',') . " WHERE national_budget_id=$id";
        if (!empty($national_budget)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "National Budget " . $id . " Updated Successfully.", "data" => $national_budget);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // "No Content" status
    }

    private function deleteNationalBudget() {
        if ($this->get_request_method() != "DELETE") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "DELETE FROM national_budget WHERE national_budget_id = $id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Successfully deleted one record.");
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // If no records "No Content" status
    }
    
     //  NationalBudgetCostCategory Service----------------------------------------------
    private function nationalBudgetCostCategorys() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $query = "SELECT distinct a.national_budget_cost_category_id,cc.cost_category_name, a.national_budget_amount, concat(b.project_and_total_amount,' - National Budget -', b.national_budget_amount) as project_national_budget  from national_budget_cost_category a inner join cost_category cc on a.cost_category_id = cc.cost_category_id inner join (SELECT nb.national_budget_id, b.total_budget, nb.budget_amount as national_budget_amount, b.project_and_total_amount FROM national_budget nb inner join (SELECT b.budget_id, fc.currency_name as financing_currency, sc.currency_name as spending_currency, f.financial_year_name, b.total_budget, p.project_name, concat(p.project_name, ' ( ', b.total_budget, ' )') as project_and_total_amount FROM budget b inner join currency fc on b.financing_currency_id = fc.currency_id inner join currency sc on b.spending_currency_id = sc.currency_id inner join financial_year f on b.financial_year_id = f.financial_year_id inner join project p on b.project_id = p.project_id) b on nb.budget_id = b.budget_id) b on a.national_budget_id = b.national_budget_id;
";
        $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);

        if ($r->num_rows > 0) {
            $result = array();
            while ($row = $r->fetch_assoc()) {
                $result[] = $row;
            }
            $this->response($this->json($result), 200); // send user details
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function nationalBudgetCostCategory() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "SELECT national_budget_cost_category_id, national_budget_id, cost_category_id, national_budget_amount from national_budget_cost_category where national_budget_cost_category_id=$id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            if ($r->num_rows > 0) {
                $result = $r->fetch_assoc();
                $this->response($this->json($result), 200); // send user details
            }
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function insertNationalBudgetCostCategory() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        $national_budget_cost_category = json_decode(file_get_contents("php://input"), true);
        $column_names = array('national_budget_id','cost_category_id','national_budget_amount');
        $keys = array_keys($national_budget_cost_category);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the national_budget_cost_category received. If blank insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $national_budget_cost_category[$desired_key];
            }
            $columns = $columns . $desired_key . ',';
            $values = $values . "'" . $$desired_key . "',";
        }
        $query = "INSERT INTO national_budget_cost_category(" . trim($columns, ',') . ") VALUES(" . trim($values, ',') . ")";
        if (!empty($national_budget_cost_category)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "National Budget Cost Category Created Successfully.", "data" => $national_budget_cost_category);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); //"No Content" status
    }

    private function updateNationalBudgetCostCategory() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
        $national_budget_cost_category = json_decode(file_get_contents("php://input"), true);
        $id = (int) $national_budget_cost_category['id'];
        $column_names = array('national_budget_id','cost_category_id','national_budget_amount');
        $keys = array_keys($national_budget_cost_category['national_budget_cost_category']);
        $columns = '';
        $values = '';
        foreach ($column_names as $desired_key) { // Check the national_budget_cost_category received. If key does not exist, insert blank into the array.
            if (!in_array($desired_key, $keys)) {
                $$desired_key = '';
            } else {
                $$desired_key = $national_budget_cost_category['national_budget_cost_category'][$desired_key];
            }
            $columns = $columns . $desired_key . "='" . $$desired_key . "',";
        }
        $query = "UPDATE national_budget_cost_category SET " . trim($columns, ',') . " WHERE national_budget_cost_category_id=$id";
        if (!empty($national_budget_cost_category)) {
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "National Budget Cost Category " . $id . " Updated Successfully.", "data" => $national_budget_cost_category);
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // "No Content" status
    }

    private function deleteNationalBudgetCostCategory() {
        if ($this->get_request_method() != "DELETE") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            $query = "DELETE FROM national_budget_cost_category WHERE national_budget_cost_category_id = $id";
            $r = $this->mysqli->query($query) or die($this->mysqli->error . __LINE__);
            $success = array('status' => "Success", "msg" => "Successfully deleted one record.");
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // If no records "No Content" status
    }
    
    /*
     * 	Encode array into JSON
     */

    private function json($data) {
        if (is_array($data)) {
            return json_encode($data);
        }
    }

}

// Initiiate Library

$api = new API;
$api->processApi();
?>