<?php

class User
{
    private $username;

    private $paquet;

    public function __construct($username, $paquet)
    {
        $this->username = $username;
        $this->paquet = $paquet;
    }


    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function afficheUsername()
    {
        $message = "Le username du user est : " . $this->getUsername();
        return $message;
    }

    /**
     * Get the value of paquet
     */ 
    public function getPaquet()
    {
        return $this->paquet;
    }

    /**
     * Set the value of paquet
     *
     * @return  self
     */ 
    public function setPaquet($paquet)
    {
        $this->paquet = $paquet;

        return $this;
    }
}

?>
