<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 17.03.2018
 * Time: 13:16
 */

class PowerlunchService
{

    /** @var \Kirby\Panel\Models\Page|null */
    protected $powerlunchPage = null;
    protected $lang;

    public function __construct($lang = 'de')
    {
        $this->lang = $lang;
        $this->powerlunchPage = site()->visit('powerlunch', $lang);
    }

    /**
     * Gibt die aktuelle Powerlunch-Woche zurück
     * @return Page
     */
    public function getCurrentWeek() {
        $allWeeks = $this->powerlunchPage->children();
        $currentDate = new DateTime();
        $filter = function($week) use ($currentDate) {
            $startDate = new DateTime($week->start_date());
            $endDate = new DateTime($week->end_date());
            return ($startDate <= $currentDate && $currentDate <= $endDate);
        };
        /** @var \Kirby\Panel\Models\Page $week */
        $week = $allWeeks->filter($filter)->first();
        return $week;
    }

    /**
     * Gibt ein Array von Speisen der aktuellen Woche zurück (mit Datum)
     * @param Page|null $week Die Woche (Unterseite), aus der die Speisen ermittelt werden sollen
     * @return array Ein "Tages-Block", in dem unter 'date' das Datum des Tages und unter 'meals' die aktuellen Speisen gespeichert sind
     */
    public function getMealsOfCurrentWeek($week) {

        if (!$week instanceof Page) {
            return [];
        }

        $currentWeekStartDate = new DateTime($week->start_date());
        $currentWeekEndDate = new DateTime($week->end_date());

        $dayCounter = $currentWeekStartDate;
        $mealsOfCurrentWeek = array();
        $usedDays = array();
        
        while ($dayCounter <= $currentWeekEndDate) {

            $dayName = $dayCounter->format('l');

            // Tag nur einmal ins Array eintragen (um Datums-Reihenfolge zu erhalten)
            if (in_array($dayName, $usedDays)) {
                break;
            }
            $usedDays[] = $dayName;

            // Samstag und Sonntag gibt es keine Einträge -> überspringen
            if (in_array($dayName, ['Saturday', 'Sunday'])) {
                $dayCounter = $dayCounter->modify('+1 day');
                continue;
            }

            // Methoden- bzw. Feldname aus Wochentag ermitteln
            $dayFieldName = strtolower($dayName);
            $dayField = $week->{$dayFieldName}();
            if ($dayField->exists()) {
                $dayMeals = $week->{$dayFieldName}()->toStructure();
                $mealsOfCurrentWeek[$dayName]['date'] = clone $dayCounter;
                $mealsOfCurrentWeek[$dayName]['meals'] = $dayMeals;
            }

            // Iterator
            $dayCounter = $dayCounter->modify('+1 day');
        }
        return $mealsOfCurrentWeek;
    }

}
