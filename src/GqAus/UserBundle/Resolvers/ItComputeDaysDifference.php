<?php

namespace GqAus\UserBundle\Resolvers;

use DateTime;

trait ItComputeDaysDifference
{
    /**
     * @param string $dateFrom
     * @param string|null $dateTo
     *
     * @return string
     */
    public function computeDaysBetween($dateFrom, $dateTo = null)
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
