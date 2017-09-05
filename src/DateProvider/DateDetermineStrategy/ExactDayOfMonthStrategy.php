<?php
/**
 * @author: Vova Lando <vova.lando@gmail.com>
 * @package: LoanPaymentsCalculator
 * @subpackage:
 * @created: 15/06/2017 11:04
 */
namespace cog\LoanPaymentsCalculator\DateProvider\DateDetermineStrategy;

class ExactDayOfMonthStrategy implements DateDetermineStrategyInterface
{
    /**
     * @param \DateTime $startDate
     *
     * @return \DateTime
     */
    public function calculateNextDate(\DateTime $startDate)
    {
        $endDate = clone $startDate;
        return $endDate->add(new \DateInterval('P1M'));
    }
}
