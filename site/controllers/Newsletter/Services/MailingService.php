<?php

class MailingService
{
    /** @var string */
    private $mailTarget = '';

    /** @var string */
    private $mailTemplate = '';

    /** @var string */
    private $placeholderDelimiter = '%%';


    /**
     * Erstellt den MailingService. Template siehe Dateien im Ordner "templates"
     * @param string $mailTemplate
     * @param string $placeholderDelimiter
     */
    public function __construct(string $mailTemplate, string $placeholderDelimiter = '%%')
    {
        $this->mailTemplate = $mailTemplate;
        $this->placeholderDelimiter = $placeholderDelimiter;
    }

    public function setTemplate($template) {
        $this->mailTemplate = $template;
    }

    public function setPlaceholderDelimiter($delimiter) {
        $this->placeholderDelimiter = $delimiter;
    }

    /**
     * Sendet eine E-Mail mit Daten für das Template
     * @param string $to
     * @param string $subject
     * @param array $data
     * @return bool
     */
    public function send(string $to, $subject = 'Wallstreet Powerlunch', array $data = []) {
        if (!empty($this->mailTemplate)) {
            $mailString = $this->getRenderedMailBody($data);
            $owner = c::get('owner');
            $email = email([
                'to' => $to,
                'from' => $owner['mail'],
                'subject' => $subject,
                'body' => $mailString
            ]);
            return $email->send();
        }
        return false;
    }

    private function getRawTemplateContent() {
        $filename = $this->mailTemplate . '.mail';
        $filepath = 'site/controllers/Newsletter/Services/templates/' . $filename;

        $rawString = trim(file_get_contents($filepath));
        return $rawString;
    }

    private function getRenderedMailBody($data) {
        $rawString = $this->getRawTemplateContent();
        $mailString = $rawString;
        foreach ($data as $key => $value) {
            $mailString = str_replace($this->placeholderDelimiter . $key . $this->placeholderDelimiter, $value, $mailString);
        }
        return $mailString;
    }

}