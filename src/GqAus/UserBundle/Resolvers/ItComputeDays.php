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

        $days = $daysDifference;

        if ($days < 0) {
            return 0;
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
            $dateTo = date('Y-m-d H:i:s');
        }
        
        $diff = strtotime($dateFrom) - strtotime($dateTo);
        $days = floor(($diff) / (60 * 60 * 24));
								
        if ($days < 0) {
        				$days = 0;
        }

        return $days;
    }
}
