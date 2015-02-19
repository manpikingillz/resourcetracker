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