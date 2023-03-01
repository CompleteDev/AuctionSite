<?php
/**
 * Created by PhpStorm.
 * User: mike.richardson
 * Date: 4/10/2019
 * Time: 6:25 AM
 */
//ini_set("include_path", '/home/powerpagesweb/php:' . ini_get("include_path") );
//require 'Mail.php';

class Messaging
{
    private $db;

    public function __construct()
    {
        $this->db = new Mail_Database;
    }

    public function insertEmail($subject, $to, $from, $body)
    {
        $this->db->query('INSERT INTO sendmail(subject,send_to,send_from,body,status) VALUES(:sub,:sto,:sfrom,:mbody,:mstat)');
        $this->db->bind(':sub', $subject);
        $this->db->bind(':sto', $to);
        $this->db->bind(':sfrom', $from);
        $this->db->bind(':mbody', $body);
        $this->db->bind(':mstat', 0);

        $this->db->execute();
    }
}
