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