<?php


class User extends Config
{
    public function insert($table, $data, $format)
    {
        return parent::insertDB($table, $data, $format);
    }
    public function select($table, $data, $format)
    {
        return parent::selectDB('SELECT * FROM ' . $table . '  WHERE email = ? LIMIT 1', array($data['email']), array('s'));
    }
    public function test_uniq($table,$data){
        return parent::test_uniq_DB($table,$data);
    }

    public function insert_test($table,$data,$format){
        return parent::test_insert($table,$data,$format);
    }
    public function selected($table, $id, $select = '*', $where_id = 'id', $selector="=")
    {
        return parent::selected($table, $id, $select, $where_id, $selector);
    }
    public function update_db($table, $id, $updates, $where_id = 'id = ')
    {
        parent::update_db($table, $id, $updates, $where_id);
    }
    public function delete($table, $where_data = '0')
    {
        parent::delete($table, $where_data);
    }
}