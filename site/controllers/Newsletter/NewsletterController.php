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

    /** @var string */
    private $baseUrl;

    public function __construct($lang = 'de', $data = [])
    {
        $this->lang = $lang;
        $this->data = $data;
        $this->recipientsService = new RecipientsService();
        $this->powerlunchService = new PowerlunchService($lang);
        $this->mailService = new MailingService();
        $this->baseUrl = site()->url();
    }

    /**
     * Route zum Hinzufügen von Empfängern
     * @return object
     */
    public function addAction()
    {
        $email = r::postData('email', '');
        $vorwahl = r::postData('vorwahl', '');
        $fax = r::postData('fax', '');

        // Nur eine der beiden Felder (aber mindestens eine der beiden) ausgefüllt? (Vorwahl + Fax getrenn)
        if ((empty($email) && empty($vorwahl.$fax)) || (!empty($email) && !empty($vorwahl.$fax))) {
            return \Response::error(ERROR_MSG[$this->lang]['error_newsletter_requirements'], 200);
        }

        // Eingaben gültig?
        if (!RecipientsService::validateRegistration($email, $vorwahl, $fax)) {
            return Response::error(ERROR_MSG[$this->lang]['newsletter_registration_fail'], 200);
        }

        // Einheitlich formatierte Faxnummer
        $fax = RecipientsService::normalizeFax($vorwahl, $fax);

        // Ist für die E-Mail-Adresse und/oder Fax-Nummer bereits ein Datensatz angelegt? Falls ja: Ist er "abgeschlossen", d.h. ausgetragen? Falls nein: Update! Ansonsten neuer Datensatz
        if ($recipient = $this->recipientsService->getActiveRecipient($email, $fax)) {
            if (!empty($recipient->date_unregister())) {
                 $unique = $this->recipientsService->addNewRecipient($email, $fax);
                 if (!empty($email)) {
                     $this->mailService->send('registration_customer', $email, ['baseurl' => $this->baseUrl, 'unique' => $unique], 'Bestätigung der Anmeldung für Freunde-Liste Wallstreet im Hamilton');
                 }
                 $this->mailService->send('registration_admin', c::get('owner')['mail'], ['baseurl' => $this->baseUrl, 'email' => $email, 'fax' => $fax, 'unique' => $unique, 'PS' => 'Neue Anmeldung!'], 'Infomail Freunde-Liste Wallstreet im Hamilton');
            }
            else {
                $unique = $this->recipientsService->updateRecipient($recipient->uniqueid(), $email, $fax);
                if (!empty($email)) {
                    $this->mailService->send('update_registration_customer', $email, ['baseurl' => $this->baseUrl, 'unique' => $unique, 'PS' => ''], 'Ihre Anmeldung Freunde-Liste Wallstreet im Hamilton');
                }
            }
        }
        else {
            $unique = $this->recipientsService->addNewRecipient($email, $fax);
            if (!empty($email)) {
                $this->mailService->send('registration_customer', $email, ['baseurl' => $this->baseUrl, 'unique' => $unique], 'Bestätigung der Anmeldung für Freunde-Liste Wallstreet im Hamilton');
            }
            $this->mailService->send('registration_admin', c::get('owner')['mail'], ['baseurl' => $this->baseUrl, 'email' => $email, 'fax' => $fax, 'unique' => $unique, 'PS' => 'Neue Anmeldung!'], 'Infomail Freunde-Liste Wallstreet im Hamilton');
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
                return new Response('Ihre Eintragung wurde erfolgreich bestätigt. Sie sind nun in die Freunde-Liste des Wallstreet im Hamilton aufgenommen.');
            }
        }
        return new Response('Fehler beim Bestätigen der Registrierung. Dies tritt normalerweise auf, wenn eine Registrierung mehrfach bestätigt wurde. Sollte dies nicht zutreffen, versuchen Sie es später noch einmal oder kontaktieren Sie den Administrator der Seite.');
    }

    /**
     * Route zum Erstellen einer Austragungs-Anfrage
     * @return object
     */
    public function signoutRequestAction()
    {
        $email = r::postData('email', '');
        $vorwahl = r::postData('vorwahl', '');
        $fax = r::postData('fax', '');

        // Nur eine der beiden Felder (aber mindestens eine der beiden) ausgefüllt? (Vorwahl + Fax getrenn)
        if ((empty($email) && (empty($fax) || empty($vorwahl))) || (!empty($email) && (!empty($fax) || !empty($vorwahl)))) {
            return \Response::error(ERROR_MSG[$this->lang]['error_newsletter_requirements'], 200);
        }

        // Eingaben gültig?
        if (!RecipientsService::validateRegistration($email, $vorwahl, $fax)) {
            return Response::error(ERROR_MSG[$this->lang]['newsletter_registration_fail'], 200);
        }

        // Einheitlich formatierte Faxnummer
        $fax = RecipientsService::normalizeFax($vorwahl, $fax);

        if ($unique = $this->recipientsService->requestUnregisterRecipient($email, $fax)) {
            if (!empty($email)) {
                $this->mailService->send('unregister_request_customer', strval($email), ['baseurl' => $this->baseUrl, 'unique' => $unique], 'Abmeldung Freunde-Liste Wallstreet im Hamilton');
            }
            $this->mailService->send('unregister_request_admin', c::get('owner')['mail'], ['baseurl' => $this->baseUrl, 'email' => $email, 'fax' => $fax, 'unique' => $unique], 'Infomail Freunde-Liste Wallstreet im Hamilton');
            return \Response::success('Ihre Abmeldung war erfolgreich!');
        } else {
            $this->mailService->send('unregister_request_admin', c::get('owner')['mail'], ['baseurl' => $this->baseUrl, 'email' => $email, 'fax' => $fax], 'Infomail Freunde-Liste Wallstreet im Hamilton');
            return \Response::success('Ihre Abmeldung war erfolgreich!');
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
                $this->mailService->send('unregister_confirm_admin', 'davidpeter1337@gmail.com', ['baseurl' => $this->baseUrl, 'unique' => $unique], 'Wallstreet Freunde-Liste: Austragen erfolgreich!');
                return new Response('User erfolgreich ausgetragen.');
            }
        }
        return new Response('Fehler beim Austragen aus dem Newsletter.');
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
        $apiData['startDatePdf'] = $weekDates['startPdf'];
        $apiData['endDatePdf'] = $weekDates['endPdf'];
        $apiData['days'] = [];
        foreach ($mealDays as $dayName => $mealDay) {
            $apiData['days'][$dayName]['datum'] = $mealDay['date']->getTimestamp();
            $i = 1;
            foreach ($mealDay['meals'] as $meal) {
                if ($i > 3) break;
                $apiData['days'][$dayName]['name' . $i] = $meal->name()->value();
                $apiData['days'][$dayName]['beschr' . $i] = $meal->description()->value();
                $apiData['days'][$dayName]['preis' . $i] = str_replace('.', ',', number_format(floatval($meal->price()->toString()), 2));
                $i++;
            }
        }

        return Response::json($apiData);
    }

}