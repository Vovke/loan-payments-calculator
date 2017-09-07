<?php
/**
 * @author: Vova Lando <vova.lando@gmail.com>
 * @package: LoanPaymentsCalculator
 * @subpackage:
 * @created: 07/09/2017 13:52
 */

namespace cog\LoanPaymentsCalculator\DateProvider\HolidayProvider;


class NeverHolidayProvider implements HolidayProvider
{
    /**
     * @inheritdoc
     * @codeCoverageIgnore
     */
    public function isHoliday(\DateTime $date)
    {
        return false;
    }

}