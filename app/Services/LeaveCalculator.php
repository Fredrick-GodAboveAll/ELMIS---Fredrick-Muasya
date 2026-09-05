<?php
namespace App\Services;
use InvalidArgumentException;

class LeaveCalculator
{
    /**
     * Calculate leave days between two dates using the specified method.
     * @param string $startDate YYYY-MM-DD
     * @param string $endDate YYYY-MM-DD
     * @param string $calculationMethod 'working_days'|'calendar_days'
     * @return int
     * @throws InvalidArgumentException
     */
    public function calculate(string $startDate, string $endDate, ?string $calculationMethod = null): int
    {
        if (trim($startDate) === '') {
            throw new InvalidArgumentException('Start date is required.');
        }

        if (trim($endDate) === '') {
            throw new InvalidArgumentException('End date is required.');
        }

        try {
            $start = new \DateTime($startDate);
            $end = new \DateTime($endDate);
        } catch (\Exception $e) {
            throw new InvalidArgumentException('Invalid date format. Use YYYY-MM-DD.');
        }

        // global rule: leave cannot start on weekend
        $startDow = (int) $start->format('N');
        if ($startDow >= 6) {
            throw new InvalidArgumentException('Leave cannot start on Saturday or Sunday.');
        }

        // Normalize times to midnight for safe comparisons
        $start->setTime(0, 0, 0);
        $end->setTime(0, 0, 0);

        if ($start > $end) {
            throw new InvalidArgumentException('Start date cannot be after end date.');
        }

        if (!in_array($calculationMethod, ['working_days', 'calendar_days'], true)) {
            throw new InvalidArgumentException('Invalid calculation method.');
        }

        if ($calculationMethod === 'calendar_days') {
            // inclusive difference
            $diff = $start->diff($end);
            return (int) $diff->days + 1;
        }

        // working_days: count Mon-Fri only
        return $this->countWorkingDays($start, $end);
    }

    private function countWorkingDays(\DateTime $start, \DateTime $end): int
    {
        $count = 0;
        $period = new \DatePeriod($start, new \DateInterval('P1D'), (clone $end)->modify('+1 day'));
        foreach ($period as $dt) {
            $dow = (int) $dt->format('N'); // 1 (Mon) - 7 (Sun)
            if ($dow >= 1 && $dow <= 5) {
                $count++;
            }
        }
        return $count;
    }

    /**
     * Given a start date and number of days, compute the inclusive end date
     * according to the calculation method supplied by the Leave Type.
     * @param string $startDate
     * @param int $days
     * @param string|null $calculationMethod
     * @return string YYYY-MM-DD
     * @throws InvalidArgumentException
     */
    public function calculateEndDate(string $startDate, int $days, ?string $calculationMethod = null): string
    {
        if (trim($startDate) === '') {
            throw new InvalidArgumentException('Start date is required.');
        }

        if (!is_int($days) || $days < 1) {
            throw new InvalidArgumentException('Days must be an integer greater than zero.');
        }

        try {
            $start = new \DateTime($startDate);
        } catch (\Exception $e) {
            throw new InvalidArgumentException('Invalid start date format. Use YYYY-MM-DD.');
        }

        // global rule: leave cannot start on weekend
        $startDow = (int) $start->format('N');
        if ($startDow >= 6) {
            throw new InvalidArgumentException('Leave cannot start on Saturday or Sunday.');
        }

        if (!in_array($calculationMethod, ['working_days', 'calendar_days'], true)) {
            throw new InvalidArgumentException('Invalid calculation method.');
        }

        if ($calculationMethod === 'calendar_days') {
            // inclusive: end = start + (days - 1)
            $end = (clone $start)->modify('+' . ($days - 1) . ' days');
            return $end->format('Y-m-d');
        }

        // working_days: iterate until we've counted $days Mon-Fri days
        $count = 0;
        $dt = clone $start;
        while (true) {
            $dow = (int) $dt->format('N');
            if ($dow >= 1 && $dow <= 5) {
                $count++;
                if ($count >= $days) {
                    return $dt->format('Y-m-d');
                }
            }
            $dt->modify('+1 day');
        }
    }

    /**
     * Calculate the return-to-work date (next working day after the end date).
     * @param string $endDate YYYY-MM-DD
     * @return string YYYY-MM-DD
     */
    public function calculateReturnDate(string $endDate): string
    {
        try {
            $end = new \DateTime($endDate);
        } catch (\Exception $e) {
            throw new InvalidArgumentException('Invalid end date format. Use YYYY-MM-DD.');
        }

        $dt = (clone $end)->modify('+1 day');
        while (true) {
            $dow = (int) $dt->format('N');
            if ($dow >= 1 && $dow <= 5) {
                return $dt->format('Y-m-d');
            }
            $dt->modify('+1 day');
        }
    }
}
