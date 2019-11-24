<?php

class Auth extends Config
{
    public function create_db()
    {
        return parent::create_database();
    }

    public function createDB($table, $data)
    {
        return parent::create($table, $data);
    }

    public function selected($table, $id, $select = '*', $where_id = 'id', $selector = "=")
    {
        return parent::selected($table, $id, $select, $where_id, $selector);
    }

    public function test_insert($table, $data, $format)
    {
        return parent::test_insert($table, $data, $format);
    }
    public function  procedure()
    {
        parent::procedure();
    }
}