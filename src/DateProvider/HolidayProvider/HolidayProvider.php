<?php

/**
 * @author: Vova Lando <vova.lando@gmail.com>
 * @package: LoanPaymentsCalculator
 * @subpackage: DateProvider
 * @created: 14/06/2017 15:08
 */
namespace cog\LoanPaymentsCalculator\DateProvider\HolidayProvider;

/**
 * Interface HolidayProvider
 */
interface HolidayProvider
{
    /**
     * @param \DateTime $date
     *
     * @return bool
     */
    public function isHoliday(\DateTime $date);
}
