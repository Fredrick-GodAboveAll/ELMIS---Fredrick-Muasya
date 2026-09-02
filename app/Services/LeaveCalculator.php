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
    /**
     * @param string $startDate
     * @param string $endDate
     * @param string|null $calculationMethod explicit method 'working_days'|'calendar_days'
     * @param string|null $leaveType optional leave type key used to infer method when calculationMethod is null
     */
    public function calculate(string $startDate, string $endDate, ?string $calculationMethod = null, ?string $leaveType = null): int
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

        // if calculation method not provided, try to infer from leave type
        if ($calculationMethod === null && $leaveType !== null) {
            $calculationMethod = $this->inferMethodFromLeaveType($leaveType);
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
     * Lightweight internal mapping from leave type key -> calculation method.
     * This is intentionally minimal and can be replaced with a DB lookup later.
     * Keys are case-insensitive.
     *
     * @param string $leaveType
     * @return string|null
     */
    private function inferMethodFromLeaveType(string $leaveType): ?string
    {
        $map = [
            // common examples; edit as needed
            'annual' => 'working_days',
            'sick' => 'working_days',
            'maternity' => 'calendar_days',
            'compassionate' => 'working_days',
            'casual' => 'working_days',
            'paternity' => 'working_days',
        ];

        $key = strtolower(trim($leaveType));
        return $map[$key] ?? null;
    }

    /**
     * Given a start date and number of days, compute the inclusive end date
     * according to the calculation method (or infer from leave type).
     * @param string $startDate
     * @param int $days
     * @param string|null $calculationMethod
     * @param string|null $leaveType
     * @return string YYYY-MM-DD
     * @throws InvalidArgumentException
     */
    public function calculateEndDate(string $startDate, int $days, ?string $calculationMethod = null, ?string $leaveType = null): string
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

        // infer method if needed
        if ($calculationMethod === null && $leaveType !== null) {
            $calculationMethod = $this->inferMethodFromLeaveType($leaveType);
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
