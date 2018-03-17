<?php

class RecipientsService
{
    /** @var Database|null $db */
    private $db = null;

    public function __construct()
    {
        $this->db = new Database([
            'type' => 'mysql',
            'host' => 'wp126.webpack.hosteurope.de',
            'database' => 'db1091580-kunden',
            'user' => 'db1091580-kdn',
            'password' => 'pantenkunden'
        ]);
    }

    public function getList($limit = 0) {
        $recipients = $this->db->table('wallstreet_newsletter');
        $results = $recipients->limit($limit)->all();

        $return = '';
        foreach ($results as $recipient) {
            $return .= $recipient->email_md5() . ', ';
        }
        return $return;
    }

}