<?php
namespace App\Models;
use CodeIgniter\Model;

class LoginA extends Model
{
    protected $DBGroup = 'secondary';
    
    public function getDataUsers($username, $password)
    {
        $db = \Config\Database::connect('secondary'); 
        $queryString = 'SELECT fullname FROM account WHERE 
                        username = "'.$username.'" 
                        AND password = "'.$password.'"';
        $query = $db->query($queryString);
        return count($query->getResult());
    }
}