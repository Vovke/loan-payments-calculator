<?php
/**
 * @author: Vova Lando <vova.lando@gmail.com>
 * @package: LoanPaymentsCalculator
 * @subpackage:
 * @created: 14/06/2017 16:31
 */
namespace cog\LoanPaymentsCalculator\Schedule;

use cog\LoanPaymentsCalculator\DateProvider\DateProvider;
use cog\LoanPaymentsCalculator\Period\Period;

class Schedule
{
    /**
     * @var \DateTime
     */
    private $scheduleStartDate;

    /**
     * @var int
     */
    private $numberOfPeriods;

    /**
     * @var DateProvider
     */
    private $dateProvider;

    public function __construct(\DateTime $scheduleStartDate, $numberOfPeriods, DateProvider $dateProvider)
    {
        $this->scheduleStartDate = $scheduleStartDate;
        $this->numberOfPeriods = $numberOfPeriods;
        $this->dateProvider = $dateProvider;
    }

    public function generatePeriods()
    {
        $periods = [];
        for ($i = 0; $i < $this->numberOfPeriods; $i++) {
            $startDate = $i === 0 ? $this->scheduleStartDate : $periods[$i - 1]->endDate;
            $endDate = $this->dateProvider->calculate($startDate);
            $periods[$i] = new Period($startDate, $endDate);
        }

        return $periods;
    }
}
