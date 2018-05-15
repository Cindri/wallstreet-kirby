<?php

class MailingService
{
    /** @var string */
    private $mailRecipient = '';

    /** @var string */
    private $mailTemplate = '';

    /** @var string */
    private $placeholderDelimiter = '%%';


    /**
     * MailingService constructor.
     * @param string $mailRecipient
     * @param string $mailTemplate
     * @param string $placeholderDelimiter
     */
    public function __construct(string $mailRecipient, string $mailTemplate, string $placeholderDelimiter = '%%')
    {
        $this->mailRecipient = $mailRecipient;
        $this->mailTemplate = $mailTemplate;
        $this->placeholderDelimiter = $placeholderDelimiter;
    }

    public function send(array $data = [], $subject = 'Wallstreet Powerlunch') {
        if (!empty($this->mailRecipient) && !empty($this->mailTemplate)) {
            $mailString = $this->getRenderedString($data);
            $owner = c::get('owner');
            $email = email([
                'to' => $this->mailRecipient,
                'from' => $owner['email'],
                'subject' => $subject,
                'body' => $mailString
            ]);
            return $email->send();
        }
        return false;
    }

    private function getRawTemplateContent() {
        $filename = $this->mailTemplate . '_' . $this->mailRecipient . '.mail';
        $filepath = 'templates/' . $filename;

        $rawString = trim(file_get_contents($filepath));
        return $rawString;
    }

    private function getRenderedString($data) {
        $rawString = $this->getRawTemplateContent();
        $mailString = $rawString;
        foreach ($data as $key => $value) {
            $mailString = str_replace($this->placeholderDelimiter . $key . $this->placeholderDelimiter, $value, $mailString);
        }
        return $mailString;
    }

}