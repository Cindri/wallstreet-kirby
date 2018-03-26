<?php

require_once('Services/RecipientsService.php');
require_once('Services/PowerlunchService.php');

class NewsletterController
{

    private $lang;

    private $data = [];

    /** @var RecipientsService|null $recipientsService */
    private $recipientsService = null;

    /** @var PowerlunchService|null */
    private $powerlunchService = null;

    public function __construct($lang = 'de', $data = [])
    {
        $this->lang = $lang;
        $this->data = $data;
        $this->recipientsService = new RecipientsService();
        $this->powerlunchService = new PowerlunchService($lang);
    }

    /**
     * Route zum Hinzufügen von Empfängern
     * @return object
     */
    public function addAction()
    {
        $email = r::postData('email', '');
        $fax = r::postData('fax', '');
        $name = r::postData('name', '');
        $street = r::postData('street', '');
        $city = r::postData('city', '');
        $phone = r::postData('phone', '');

        if (empty($email) && empty($fax) || !empty($fax) && empty($phone)) {
            return \Response::error(ERROR_MSG[$this->lang]['error_newsletter_requirements'], 200);
        }

        if ($insertId = $this->recipientsService->addNewRecipient($email, $fax, $name, $street, $city, $phone)) {
            return \Response::success(ERROR_MSG[$this->lang]['newsletter_registration_success'], $this->lang . $insertId);
        } else {
            return \Response::error(ERROR_MSG[$this->lang]['newsletter_registration_fail'], 200);
        }
    }

    /**
     * Route zum Bestätigen von Empfängern
     * @return object
     */
    public function confirmAction()
    {
        $code = get('code', '');
        $type = get('art', 'email');
        if (!empty($code)) {
            if ($this->recipientsService->confirmRecipient($code, $type)) {
                return \Response::success('Confirm erfolgreich');
            }
        }
        return \Response::error('Fehler beim Bestätigen');
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
     * Route zum Austragen von Empfängern
     * @return object
     */
    public function signoutAction()
    {
        $code = get('code', '');
        $type = get('art', 'email');
        if (!empty($code)) {
            if ($this->recipientsService->deleteRecipient($code, $type)) {
                return \Response::success('User erfolgreich ausgetragen');
            }
        }
        return \Response::error('Fehler beim Austragen aus dem Newsletter');
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

        // Mapping der Kirby-Datenstrukur auf die Struktur, die im alten Verteiler verwendet wird
        $apiData = [];
        foreach ($mealDays as $dayName => $mealDay) {
            $apiData[$dayName]['datum'] = $mealDay['date']->getTimestamp();
            $i = 1;
            foreach ($mealDay['meals'] as $meal) {
                if ($i > 3) break;
                $apiData[$dayName]['name' . $i] = $meal->name()->value();
                $apiData[$dayName]['beschr' . $i] = $meal->description()->value();
                $apiData[$dayName]['preis' . $i] = number_format(floatval($meal->price()->toString()), 2);
                $i++;
            }
        }

        return Response::json($apiData);
    }

}