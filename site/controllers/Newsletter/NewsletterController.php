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

    public function addAction()
    {
        $page = site()->visit('galerien', $this->lang);
        return [$page, $this->data];
    }

    public function confirmAction()
    {
        return \Response::success('Confirm erfolgreich', $this->data);
    }

    public function listAction()
    {
        $list = $this->recipientsService->getList(20);
        return \Response::success($list, $this->data);
    }

    public function signoutAction()
    {
        return \Response::success('Sign out');
    }

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

    // Idee: Kirby stellt API-ähnliche Routes bereit, auf der das aktuelle Mittagessen als JSON zurückgegeben wird (oder die Season Specials, je nach Wunsch)
    // Der Start erfolgt nach wie vor über die alten Dateien auf dem Panten-Server. Einziger Unterschied: Statt die Datenbank nach den Speisen-Daten zu fragen, müssen die Skripte die Kirby-API
    // per HTTP-Request um die Speisen-Daten fragen und in identische Struktur überführen.


}