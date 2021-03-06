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
     * @param string $start Das Startdatum, falls abweichende Woche statt aktueller ausgegeben werden soll
     * @return Page
     */
    public function getCurrentWeek($start = "") {
        $allWeeks = $this->powerlunchPage->children();
        if (!empty($start)) {
            $currentDate = new DateTime($start);
        } else {
            $currentDate = new DateTime();
        }
        $filter = function($week) use ($currentDate) {
            $startDate = new DateTime($week->start_date());
            $endDate = new DateTime($week->end_date());
            $endDate->modify('+23 hours 59 minutes');
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
        $currentWeekEndDate->modify('+23 hours 59 minutes');

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

    /**
     * Gibt das Start- und Enddatum einer Powerlunch-Woche zurück. Verwendet wegen Callback-Problem
     * @param Page|null $week Die Woche (Unterseite), aus der die Daten ermittelt werden sollen
     * @return array Ein Array mit Start- und Enddatum
     */
    public function getWeekDates($week) {
        if (!$week instanceof Page) {
            return [];
        }

        $currentWeekStartDate = new DateTime($week->start_date());
        $currentWeekEndDate = new DateTime($week->end_date());
        $currentStartPdf = new DateTime($week->start_date_pdf());
        $currentEndPdf = new DateTime($week->end_date_pdf());

        return ['start' => $currentWeekStartDate->format('d.m.Y'),
                'end' => $currentWeekEndDate->format('d.m.Y'),
                'startPdf' => $currentStartPdf->format('d.m.Y'),
                'endPdf' => $currentEndPdf->format('d.m.Y')];
    }

}
