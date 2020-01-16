<?php

class User
{
    protected $_username;
    protected $_password;
    protected $_loginmethod;

    protected $_db;
    protected $_user;

    public function __construct(PDO $db, $username, $password, $login_by_cookie = false)
    {
        $this->_db = $db;

        $this->_username = $username;
        $this->_password = $password;
    }

    public function login()
    {
        $user = $this->checkCredentials();
        if ($user) {
            $this->_user = $user;
            $_SESSION['user_id'] = $user['id'];
            return $user['id'];
        }
        return false;
    }

    protected function checkCredentials()
    {
        $stmt = $this->_db->prepare("SELECT * FROM `users` WHERE `username`=?");
        $stmt->execute(array($this->_username));
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $submitted_password = sha1($user['salt'] . $this->_password);
            if ($submitted_password == $user['password']) {
                return $user;
            }
        }
    }

    public function getUser()
    {
        return $this->_user;
    }
}
