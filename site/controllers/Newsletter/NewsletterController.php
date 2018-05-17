<?php

require_once('Services/RecipientsService.php');
require_once('Services/PowerlunchService.php');

class NewsletterController
{

    private $lang;

    private $data = [];

    /** @var RecipientsService|null  */
    private $recipientsService = null;

    /** @var PowerlunchService|null */
    private $powerlunchService = null;

    /** @var MailingService|null  */
    private $mailService = null;

    public function __construct($lang = 'de', $data = [])
    {
        $this->lang = $lang;
        $this->data = $data;
        $this->recipientsService = new RecipientsService();
        $this->powerlunchService = new PowerlunchService($lang);
        $this->mailService = new MailingService();
    }

    /**
     * Route zum Hinzufügen von Empfängern
     * @return object
     */
    public function addAction()
    {
        $email = r::postData('email', '');
        $fax = r::postData('fax', '');

        if (empty($email) && empty($fax) || !empty($fax) && empty($phone)) {
            return \Response::error(ERROR_MSG[$this->lang]['error_newsletter_requirements'], 200);
        }

        if ($recipient = $this->recipientsService->getActiveRecipient($email, $fax)) {
            if (!empty($recipient->date_unregister())) {
                 $unique = $this->recipientsService->addNewRecipient($email, $fax);
                 $this->mailService->send('registration_customer', 'davidpeter1337@gmail.com', ['baseurl' => 'http://upload.panten.de', 'unique' => $unique]);
                 $this->mailService->send('registration_admin', c::get('owner')['mail'], ['baseurl' => 'http://upload.panten.de', 'email' => $email, 'fax' => $fax, 'unique' => $unique, 'PS' => 'Nutzer war schon einmal regisriert.']);
            }
            else {
                $unique = $this->recipientsService->updateRecipient($recipient->unique(), $email, $fax);
                $this->mailService->send('update_registration_customer', 'davidpeter1337@gmail.com', ['baseurl' => 'http://upload.panten.de', 'unique' => $unique]);
                $this->mailService->send('update_registration_admin', c::get('owner')['mail'], ['baseurl' => 'http://upload.panten.de', 'email' => $email, 'fax' => $fax, 'unique' => $unique]);
            }
        }
        else {
            $unique = $this->recipientsService->addNewRecipient($email, $fax);
            $this->mailService->send('registration_customer', 'davidpeter1337@gmail.com', ['baseurl' => 'http://upload.panten.de', 'unique' => $unique]);
            $this->mailService->send('registration_admin', c::get('owner')['mail'], ['baseurl' => 'http://upload.panten.de', 'email' => $email, 'fax' => $fax, 'unique' => $unique, 'PS' => 'Dies ist ein neuer Nutzer!']);
        }

        if ($unique) {
            return \Response::success(ERROR_MSG[$this->lang]['newsletter_registration_success']);
        }
        else {
            return \Response::error(ERROR_MSG[$this->lang]['newsletter_registration_fail'], 200);
        }
    }

    /**
     * Route zum Bestätigen von Empfängern
     * @return object
     */
    public function confirmAction()
    {
        $unique = get('unique', '');

        if (!empty($unique)) {
            if ($this->recipientsService->confirmRecipient($unique)) {
                $this->mailService->send('confirmation_admin', c::get('owner')['mail'], ['unique' => $unique]);
                return \Response::success('Ihre Eintragung wurde erfolgreich bestätigt. Sie sind nun in die Freunde-Liste des Wallstreet im Hamilton aufgenommen.');
            }
        }
        return \Response::error('Fehler beim Bestätigen der Registrierung. Versuchen Sie es später noch einmal oder kontaktieren Sie den Administrator der Seite.');
    }

    public function signoutRequestAction()
    {
        $email = r::postData('email', '');
        $fax = r::postData('fax', '');

        if (empty($email) && empty($fax) || !empty($fax) && empty($phone)) {
            return \Response::error(ERROR_MSG[$this->lang]['error_newsletter_requirements'], 200);
        }

        if ($unique = $this->recipientsService->requestUnregisterRecipient($email, $fax)) {
            $this->mailService->send('unregister_request_customer', strval($email), ['baseurl' => 'http://upload.panten.de', 'unique' => $unique]);
            $this->mailService->send('unregister_request_admin', c::get('owner')['mail'], ['baseurl' => 'http://upload.panten.de', 'unique' => $unique]);
            return \Response::success('Bitte bestätigen Sie die Austragung durch Klick auf den Link in der E-Mail oder schicken Sie das Fax, welches Sie in Kürze erhalten, unterschrieben zurück.');
        } else {
            return \Response::error(ERROR_MSG[$this->lang]['error_newsletter_requirements'], 200);
        }
    }

    /**
     * Route zum Austragen von Empfängern
     * @return object
     */
    public function signoutAction()
    {
        $unique = get('unique', '');

        if (!empty($unique)) {
            if ($this->recipientsService->unregisterRecipient($unique)) {
                $this->mailService->send('unregister_confirm_admin', 'davidpeter1337@gmail.com', ['baseurl' => 'http://upload.panten.de', 'unique' => $unique], 'Wallstreet Freunde-Liste: Austragen erfolgreich!');
                return \Response::success('User erfolgreich ausgetragen.');
            }
        }
        return \Response::error('Fehler beim Austragen aus dem Newsletter.');
    }

    /**
     * Route zum Auflisten von Empfängern
     * @return object
     */
    public function listAction()
    {
        $list = $this->recipientsService->getList(20);
        return \Response::success($list, $this->data);
    }

    /**
     * Route, die das aktuelle Powerlunch im Format des alten PDF-Generierungs-Codes bereitstellt
     * @return object
     */
    public function apiPowerlunchListAction()
    {
        /** @var \Kirby\Panel\Models\Page $week */
        $week = $this->powerlunchService->getCurrentWeek();

        $mealDays = $this->powerlunchService->getMealsOfCurrentWeek($week);

        $weekDates = $this->powerlunchService->getWeekDates($week);

        // Mapping der Kirby-Datenstrukur auf die Struktur, die im alten Verteiler verwendet wird
        $apiData = [];
        $apiData['startDate'] = $weekDates['start'];
        $apiData['endDate'] = $weekDates['end'];
        $apiData['days'] = [];
        foreach ($mealDays as $dayName => $mealDay) {
            $apiData['days'][$dayName]['datum'] = $mealDay['date']->getTimestamp();
            $i = 1;
            foreach ($mealDay['meals'] as $meal) {
                if ($i > 3) break;
                $apiData['days'][$dayName]['name' . $i] = $meal->name()->value();
                $apiData['days'][$dayName]['beschr' . $i] = $meal->description()->value();
                $apiData['days'][$dayName]['preis' . $i] = number_format(floatval($meal->price()->toString()), 2);
                $i++;
            }
        }

        return Response::json($apiData);
    }

}