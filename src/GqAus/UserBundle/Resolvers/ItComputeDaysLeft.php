<?php

namespace GqAus\UserBundle\Resolvers;

use DateTime;

trait ItComputeDaysLeft
{
    /**
     * @param string $dateFrom
     * @param string|null $dateTo
     *
     * @return string
     */
    public function computeDaysLeft($dateFrom, $dateTo = null)
    {
        if (is_null($dateTo)) {
            $dateTo = date('Y-m-d');
        }

        $startDate = new DateTime($dateFrom);
        $endDate = new DateTime($dateTo);

        $interval = $startDate->diff($endDate);

        $days = ($interval->format('%a')) - 180;

        if ($days < 0) {
            return $days * -1;
        }

        return $days;
    }
}
