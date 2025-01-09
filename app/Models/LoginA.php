<?php
namespace App\Models;
use CodeIgniter\Model;
class LoginA extends Model
{
    public function getDataUsers($username, $password)
    {
        $db = \Config\Database::connect();
        $queryString = 'SELECT fullname FROM account WHERE 
                        username = "'.$username.'" 
                        AND password = "'.$password.'"';
        $query = $db->query($queryString);
        $results = $query->getResult();
        return count($results);
    }
}