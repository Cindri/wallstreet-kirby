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
        $this->newsletterTable = $this->db->table('wallstreet_newsletter_2018');
    }

    static function debug($debug) {
        ob_start();
        var_dump($debug);
        $out = ob_get_contents();
        ob_end_clean();
        file_put_contents('debug.txt', $out);
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
    public function getActiveRecipient($email, $fax) {
        if (!empty($email)) {
            $this->newsletterTable->where(
                ['email' => $email]
            )->andWhere(
                ['date_unregister' => 0]
            );
        }
        if (!empty($fax)) {
            $this->newsletterTable->orWhere(
                ['fax' => $fax]
            )->andWhere(
                ['date_unregister' => 0]
            );
        }
        $recipient = $this->newsletterTable->order('datum DESC')->first();

        return $recipient;
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
            'bestaetigt' => 0,
            'uniqueid' => $unique
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
            ->where(['uniqueid' => $unique])
            ->andWhere(['date_confirmed' => 0 ]);

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
        $values['date_unregister_request'] = 0;
        $this->newsletterTable
            ->values($values);
        $this->newsletterTable
            ->where(['uniqueid' => $unique]);
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

        // Erstelle zuerst den Query, der den korrekten Datensatz auswählt. Er darf alte Anmeldungen nicht manipulieren
        if (!empty($email)) {
            $this->newsletterTable
                ->orWhere(['email' => $email])
                ->andWhere(['date_unregister_request' => 0])
                ->andWhere(['date_unregister' => 0]);
        }
        if (!empty($fax)) {
            $this->newsletterTable
                ->orWhere(['fax' => $fax])
                ->andWhere(['date_unregister_request' => 0])
                ->andWhere(['date_unregister' => 0]);
        }
        $recipient = $this->newsletterTable->select('uniqueid')->first();

        if (empty($recipient)) {
            return false;
        }

        $unique = $recipient->uniqueid();
        $values = [
            'date_unregister_request' => $curDate->getTimestamp(),
            'date_unregister' => $curDate->getTimestamp(),
            'bestaetigt' => 0
        ];
        $this->newsletterTable
            ->values($values)
            ->where(['uniqueid' => $unique]);
        $this->newsletterTable->update();
        return $unique;
    }

    /**
     * Deaktiviert einen Empfänger. Eine neue Registrierung wird in einem neuen Datensatz erfasst.
     * @param $unique
     * @return bool
     */
    public function unregisterRecipient($unique) {
        $curDate = new DateTime();
        $values['date_unregister'] = $curDate->getTimestamp();
        $values['bestaetigt'] = 0;
        $this->newsletterTable->values($values);
        $this->newsletterTable->where('date_unregister_request', '<>', 0);
        $this->newsletterTable->andWhere(['uniqueid' => $unique]);
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


    // Statische Hilfsfunktionen


    /**
     * Validiert die Formulareingaben bei der Registrierung / Abmeldung
     * @param string $email
     * @param string $vorwahl
     * @param string $fax
     * @return bool
     */
    public static function validateRegistration($email, $vorwahl, $fax) {
        $regexVorwahl = '/((\+|00)\d{1,3}|0)\s{0,1}\d{2,6}/';
        $regexFax = '/(\d|\s){3,12}/';
        $matchEmail = true;
        if (!empty($email)) {
            $matchEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
        }
        $matchVorwahl = true;
        if (!empty($vorwahl)) {
            $matchVorwahl = boolval(preg_match($regexVorwahl, $vorwahl));
        }
        $matchFax = true;
        if (!empty($fax)) {
            $matchFax = boolval(preg_match($regexFax, $fax));
        }

        $result = ($matchVorwahl && $matchFax && $matchEmail);

        return $result;
    }

    /**
     * Normalisiert eingegebene Faxnummer zu gleicher Form (um Duplikate bei verschiedene Eingabeformaten auszuschließen)
     * @param $vorwahl
     * @param $fax
     * @return string
     */
    public static function normalizeFax($vorwahl, $fax) {
        $realVorwahl = str_replace('+', '00', $vorwahl);
        $realVorwahl = str_replace(' ', '', $realVorwahl);

        $realFax = str_replace(' ', '', $fax);

        return $realVorwahl . $realFax;
    }

}