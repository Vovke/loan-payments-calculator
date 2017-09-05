<?php

/**
 * @author: Vova Lando <vova.lando@cashongo.co.uk>
 * @package: LoanPaymentsCalculator
 * @subpackage: DateProvider
 * @created: 14/06/2017 14:55
 */
namespace cog\LoanPaymentsCalculator\DateProvider;

use cog\LoanPaymentsCalculator\DateProvider\DateDetermineStrategy\DateDetermineStrategyInterface;
use cog\LoanPaymentsCalculator\DateProvider\HolidayProvider\HolidayProviderInterface;

class DateProvider
{
    /**
     * @var DateDetermineStrategyInterface
     */
    private $dateDetermineStrategy;

    /**
     * @var HolidayProviderInterface
     */
    private $holidayProvider;

    /**
     * @var bool
     */
    private $shiftForward;

    /**
     * DateProvider constructor.
     *
     * @param DateDetermineStrategyInterface $dateDetermineStrategy
     * @param HolidayProviderInterface       $holidayProvider
     * @param bool                           $shiftForward
     */
    public function __construct(DateDetermineStrategyInterface $dateDetermineStrategy, HolidayProviderInterface $holidayProvider, $shiftForward)
    {
        $this->dateDetermineStrategy = $dateDetermineStrategy;
        $this->holidayProvider = $holidayProvider;
        $this->shiftForward = $shiftForward;
    }

    /**
     * @param \DateTime $startDate
     *
     * @return \DateTime
     */
    public function calculate(\DateTime $startDate)
    {
        $calculatedDate = $this->dateDetermineStrategy->calculateNextDate($startDate);
        if ($this->holidayProvider->isHoliday($calculatedDate)) {
            $calculatedDate = $this->shiftForward ?
                $this->getNextBusinessDay($calculatedDate) :
                $this->getPreviousBusinessDay($calculatedDate);
        }

        return $calculatedDate;
    }

    /**
     * @param \DateTime $date
     *
     * @return \DateTime
     */
    private function getNextBusinessDay(\DateTime $date)
    {
        do {
            $date->modify('+1 day');
        } while ($this->holidayProvider->isHoliday($date));

        return $date;
    }

    /**
     * @param \DateTime $date
     *
     * @return \DateTime
     */
    private function getPreviousBusinessDay(\DateTime $date)
    {
        do {
            $date->modify('-1 day');
        } while ($this->holidayProvider->isHoliday($date));

        return $date;
    }
}
