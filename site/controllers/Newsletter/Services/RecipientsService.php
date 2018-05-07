<?php

class RecipientsService
{
    /** @var Database|null $db */
    private $db = null;

    /** @var Database\Query $newsletterTable */
    private $newsletterTable = null;

    public function __construct()
    {
        $this->db = new Database([
            'type' => 'mysql',
            'host' => 'wp126.webpack.hosteurope.de',
            'database' => 'db1091580-kunden',
            'user' => 'db1091580-kdn',
            'password' => 'pantenkunden'
        ]);
        $this->newsletterTable = $this->db->table('wallstreet_newsletter');
    }

    /**
     * Listet die Spalten der Empfänger-Tabelle auf
     * @param $table
     * @return mixed
     */
    public function columns($table) {
        $results = $this->db->query('SHOW COLUMNS FROM ' . $table);
        return $results;
    }

    /**
     * Zeigt alle (oder die ersten $limit) Empfänger im Verteiler an
     * @param int $limit
     * @return string
     */
    public function getList($limit = 0) {
        $results = $this->newsletterTable->limit($limit)->all();

        $return = '';
        foreach ($results as $recipient) {
            $return .= $recipient->email() . ', ' . $recipient->fax() . "\r\n";
        }
        return $return;
    }

    /**
     * Fügt neuen Empfänger zum Verteiler hinzu
     * @param $email
     * @param string $fax
     * @param string $name
     * @param string $street
     * @param string $city
     * @param string $phone
     * @return mixed
     */
    public function addNewRecipient($email, $fax = '', $name = '', $street = '', $city = '', $phone = '') {
        $curDate = new \DateTime();

        $id = $this->newsletterTable->insert([
            'datum' => $curDate->getTimestamp(),
            'email' => $email,
            'fax' => $fax,
            'email_md5' => md5($email),
            'fax_md5' => md5($fax),
            'name' => $name,
            'strasse' => $street,
            'ort' => $city,
            'telefon' => $phone,
            'bestaetigt' => 0
        ]);

        return $id;
    }

    /**
     * Bestätigt hinzugefügten Empfänger (nach Klick auf den Mail-Link)
     * @param $code
     * @param $type
     * @return bool
     */
    public function confirmRecipient($code, $type) {
        if (empty($code)) {
            return false;
        }
        if (!in_array($type, ['email', 'fax'])) {
            return false;
        }

        $this->newsletterTable->values([
            'bestaetigt' => 1
        ]);
        $this->newsletterTable->where($type . '_md5', '=', $code);

        return $this->newsletterTable->update();
    }

    /**
     * Löscht einen Empfänger aus dem Verteiler
     * @param $code
     * @param $type
     * @return bool
     */
    public function deleteRecipient($code, $type) {
        if (empty($code)) {
            return false;
        }
        if (!in_array($type, ['email', 'fax'])) {
            return false;
        }

        return $this->newsletterTable->where($type . '_md5', '=', $code)->delete();
    }

}