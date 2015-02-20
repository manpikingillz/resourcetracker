//  District Service----------------------------------------------
    private function districts() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $query = "SELECT distinct o.district_id, o.district_name FROM district o order by o.district_name desc";
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
        $column_names = array('district_name');
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
        $column_names = array('district_name');
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