<?php

class Config
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASSWORD;
    private $database = DB_BASE;


    protected function create_database()
    {
        try {
            $conn = new PDO("mysql:host=" . $this->host, $this->user, $this->password);
            $conn->exec("CREATE DATABASE IF NOT EXISTS {$this->database} COLLATE utf8_unicode_ci;");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
        return true;

    }

    private function connect()
    {
//            $this->create_database();
        try {
            $conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->user, $this->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//                echo CONNECT_SUCCESS;
        } catch (PDOException $e) {
            echo CONNECT_FAILED . $e->getMessage();
            die;
        }

        return $conn;
    }

    public function create($table, $data)
    {
        if (empty($table))
            return false;
        // Connect to the database
        $db = $this->connect();

        $stmt = $db->prepare("CREATE TABLE IF NOT EXISTS $table ($data)ENGINE InnoDB");
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function procedure()
    {
        $user = $this->connect();
        $user->exec("
CREATE PROCEDURE test()
BEGIN 
SELECT * FROM users WHERE activation_code = '1';
    END;
        ");

    }

    public function selectDB($query, $data = NULL, $format = NULL)
    {

        // Connect to the database
        $db = $this->connect();

        //Prepare our query for binding
        $stmt = $db->prepare($query);
        if (!empty($format) && !empty($data)) {
            //Dynamically bind values
            $this->ref_bindValues($format, $data, $stmt);
        }

        //Execute the query
        $stmt->execute();
        $results = [];
        //Fetch results

        if ($stmt->rowCount() > 0) {
            //Create results object
            while ($row = $stmt->fetchObject()) {
                $results[] = $row;
            }
        }

        return $results;
    }

    public function insertDB($table, $data, $format)
    {
        if (empty($table) || empty($data)) {
            return false;
        }

        // Connect to the database
        $db = $this->connect();

        // Cast $data and $format to arrays
        $data = (array)$data;

        // Build format string
        $format = explode('%', $format);
//            echo "<pre>";
//var_dump($format);die;
        list($fields, $placeholders, $values) =
            $this->prep_query($data);
        //            echo "<pre>";
//var_dump($format);

        // Prepary our query for binding
        $stmt = $db->prepare("INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})");
        // Dynamically bind values
        $this->ref_bindValues($format, $values, $stmt);

        // Check for successful insertion
        if ($stmt->execute()) {
            $_SESSION['last_id'] = $db->lastInsertId();
            return true;
        }

        return false;
    }

    private function ref_values($array)
    {
        $refs = array();
        foreach ($array as $key => $value) {

            $refs[$key] = $array[$key];
        }

        return $refs;
    }

    private function ref_bindValues($format, $value, $stmt)
    {
        $_values = $this->ref_values($value);


        for ($i = 0; $i < count($_values); $i++) {
            switch ($format[$i]) {
                case 's':
                    $stmt->bindValue($i + 1, $_values[$i], PDO::PARAM_STR);
                    break;
                case 'i':
                    $stmt->bindValue($i + 1, $_values[$i], PDO::PARAM_INT);
                    break;
            }
        }
    }

    private function prep_query($data, $type = 'insert')
    {
        // Instantiate $fields and $placeholders for looping
        $fields = '';
        $placeholders = '';
        $values = [];

        // Loop through $data and build $fields, $placeholders, and $values
        foreach ($data as $field => $value) {
            $fields .= "{$field},";
            $values[] = $value;

            if ($type == 'update') {
                $placeholders .= $field . '=?,';
            } else {
                $placeholders .= '?,';
            }

        }

        // Normalize $fields and $placeholders for inserting
        $fields = substr($fields, 0, -1);
        $placeholders = substr($placeholders, 0, -1);
//            var_dump(array($fields, $placeholders, $values));

        return array($fields, $placeholders, $values);
    }

    public function test_uniq_DB($table, $data, $field = 'email')
    {
        $conn = $this->connect();
        $test = !$conn->query("SELECT {$field} FROM {$table} WHERE {$field}='{$data}'")->fetch();
        $conn = null;
        return $test;

    }

    public function test_insert($table, $data, $format)
    {
        $key = '';
        $value = '';
        foreach ($data as $index => $datum) {
            $key .= $index . ',';
            $value .= ':' . $index . ',';
        }
        $format = explode("%", $format);
        $i = 0;
        $key = substr($key, 0, -1);
        $value = substr($value, 0, -1);
        $conn = $this->connect();
        $sql_insert = $conn->prepare("INSERT INTO {$table} ({$key}) VALUES ({$value});");
        foreach ($data as $item => $val) {
            switch ($format[$i]) {
                case 's' :
                    $sql_insert->bindValue(':' . $item, $val, PDO::PARAM_STR);
//                        echo ":{$item}    {$val}" ."<br>";
                    break;
                case 'i':
                    $sql_insert->bindValue(':' . $item, $val, PDO::PARAM_INT);
//                        echo ":{$item}    {$val}" ."<br>";
                    break;
            }
            $i++;
        }
        $sql_insert->execute();
        $conn = null;
        return true;
    }

    public function selected($table, $id, $select = '*', $where_id = 'id', $selector = "=")
    {
        $conn = $this->connect();
        if (!empty($id)) {
            $test = $conn->query("SELECT {$select} FROM {$table} WHERE {$where_id} {$selector} {$id}")->fetchAll(PDO::FETCH_OBJ);
        } else {
            $test = $conn->query("SELECT {$select} FROM {$table};")->fetchAll(PDO::FETCH_OBJ);
        }
        $conn = null;
        return $test;
    }

    public function update_db($table, $id, $updates, $where_id = 'id = ')
    {
        $conn = $this->connect();
        $conn->exec("UPDATE {$table} SET {$updates} WHERE {$where_id}{$id};");
        $conn = null;

    }

    public function delete($table, $where_data = '0')
    {
        $conn = $this->connect();
        $conn->exec("DELETE FROM {$table} WHERE {$where_data}");
        $conn = null;
    }
}

