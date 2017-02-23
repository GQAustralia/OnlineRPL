<?php

namespace GqAus\UserBundle\Resolvers;

use DateTime;

trait ItComputeDays
{
    /**
     * @param string $dateFrom
     * @param string|null $dateTo
     *
     * @return string
     */
    public function computeDaysLeft($dateFrom, $dateTo = null)
    {
        $daysDifference = $this->computeDaysDifference($dateFrom, $dateTo = null);

        $days = $daysDifference - 180;

        if ($days < 0) {
            return $days * -1;
        }

        return $days;
    }

    /**
     * @param $dateFrom
     * @param null $dateTo
     *
     * @return string
     */
    public function computeDaysDifference($dateFrom, $dateTo = null)
    {
        if (is_null($dateTo)) {
            $dateTo = date('Y-m-d');
        }

        $startDate = new DateTime($dateFrom);
        $endDate = new DateTime($dateTo);

        $interval = $startDate->diff($endDate);

        return $interval->format('%a');
    }
}
