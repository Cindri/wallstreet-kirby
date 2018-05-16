<?php

require_once('MailingService.php');

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
     * Gibt die ID eines Empfängers mit einer E-Mail oder Faxnummer zurück
     * @param $email
     * @param $fax
     * @return mixed
     */
    public function getRecipient($email, $fax) {
        $results = $this->newsletterTable->where(['email' => $email])->orWhere(['fax' => $fax])->order('datum DESC');
        foreach ($results as $recipient) {
            return $recipient;
        }
        return false;
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
        $curDate = new DateTime();
        $unique = uniqid(rand(0, 9999));
        $this->newsletterTable->insert([
            'datum' => $curDate->getTimestamp(),
            'email' => $email,
            'fax' => $fax,
            'email_md5' => md5($email),
            'fax_md5' => md5($fax),
            'name' => $name,
            'strasse' => $street,
            'ort' => $city,
            'telefon' => $phone,
            'bestaetigt' => 0,
            'unique' => $unique,
            'date_confirmed' => NULL,
            'date_unregister_request' => NULL,
            'date_unregister' => NULL
        ]);
        return $unique;
    }

    /**
     * Bestätigt hinzugefügten Empfänger (nach Klick auf den Mail-Link)
     * @param $unique
     * @return bool
     */
    public function confirmRecipient($unique) {
        $curDate = new DateTime();
        $this->newsletterTable->values([
            'bestaetigt' => 1,
            'date_confirmed' => $curDate->getTimestamp()
        ]);
        $this->newsletterTable
            ->where(['unique' => $unique]);

        return $this->newsletterTable->update();
    }

    /**
     * Aktualisiert einen Empfänger
     * @param $unique
     * @param string $fax
     * @param string $email
     * @return bool
     */

    public function updateRecipient($unique, $email = '', $fax = '') {

        $values = [];
        $curDate = new DateTime();

        if (!empty($email)) {
            $values['email'] = $email;
        }
        if (!empty($fax)) {
            $values['fax'] = $fax;
        }
        $values['datum'] = $curDate->getTimestamp();

        $this->newsletterTable
            ->values($values);
        $this->newsletterTable
            ->where(['unique' => $unique]);

        $this->newsletterTable->update();
        return $unique;
    }

    /**
     * Erzeugt die Bestätigungs-Mail zum Deaktivieren eines Empfängers
     * @param $email
     * @param $fax
     * @return bool
     */
    public function requestUnregisterRecipient($email, $fax) {
        $curDate = new DateTime();
        $values = [
            'date_unregister_request' => $curDate->getTimestamp()
        ];
        $this->newsletterTable
            ->values($values);
        $this->newsletterTable
            ->where('date_unregister_request', '<>', NULL)
            ->andWhere('date_unregister', '<>', NULL)
            ->andWhere(['email' => $email])
            ->orWhere(['fax' => $fax]);
        $results = $this->newsletterTable->select('unique');
        foreach ($results as $recipient) {
            $unique = $recipient->unique();
        }
        $this->newsletterTable->update();
        return isset($unique) ? $unique : false;
    }

    /**
     * Deaktiviert einen Empfänger. Eine neue Registrierung wird in einem neuen Datensatz erfasst.
     * @param $unique
     * @return bool
     */
    public function unregisterRecipient($unique) {
        $curDate = new DateTime();
        $values['date_unregister'] = $curDate->getTimestamp();
        $this->newsletterTable->where(['unique' => $unique]);
        return $this->newsletterTable->update();
    }

    /**
     * Löscht den Datensatz eines Empfänger aus dem Verteiler
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