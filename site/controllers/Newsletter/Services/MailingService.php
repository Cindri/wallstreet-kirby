<?php

class MailingService
{
    /** @var string */
    private $placeholderDelimiter = '%%';

    /**
     * Erstellt den MailingService. Template siehe Dateien im Ordner "templates"
     * @param string $placeholderDelimiter
     */
    public function __construct($placeholderDelimiter = '%%')
    {
        $this->placeholderDelimiter = $placeholderDelimiter;


        // Definiere eigenen E-Mail Adapter
        email::$services['html_email'] = function($email) {

            $headers = array(
                'From: ' . $email->from,
                'Reply-To: ' . $email->replyTo,
                'Return-Path: ' . $email->replyTo,
                'Message-ID: <' . time() . '-' . $email->from . '>',
                'X-Mailer: PHP v' . phpversion(),
                'Content-Type: text/html; charset=utf-8',
                'Content-Transfer-Encoding: 8bit',
            );

            ini_set('sendmail_from', $email->from);
            $send = mail($email->to, str::utf8($email->subject), str::utf8($email->body), implode(PHP_EOL, $headers));
            ini_restore('sendmail_from');

            if(!$send) {
                throw new Error('The email could not be sent');
            }
        };

    }

    public function setPlaceholderDelimiter($delimiter) {
        $this->placeholderDelimiter = $delimiter;
    }

    /**
     * Sendet eine E-Mail mit Daten für das Template
     * @param string $template
     * @param string $to
     * @param string $subject
     * @param array $data
     * @return bool
     */
    public function send($template, $to, $data = [], $subject = 'Wallstreet Powerlunch') {
        if (!empty($template)) {
            $mailString = $this->getRenderedMailBody($template, $data);
            $owner = c::get('owner');
            $email = email([
                'to' => $to,
                'from' => $owner['mail'],
                'subject' => $subject,
                'service' => 'html_email',
                'body' => $mailString
            ]);
            return $email->send();
        }
        return false;
    }

    private function getRawTemplateContent($template) {
        $filename = $template . '.mail';
        $filepath = 'site/controllers/Newsletter/Services/templates/' . $filename;

        $rawString = trim(file_get_contents($filepath));
        return $rawString;
    }

    private function getRenderedMailBody($template, $data) {
        $rawString = $this->getRawTemplateContent($template);
        $mailString = $rawString;
        foreach ($data as $key => $value) {
            $mailString = str_replace($this->placeholderDelimiter . $key . $this->placeholderDelimiter, $value, $mailString);
        }
        return $mailString;
    }

}