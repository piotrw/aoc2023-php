<?php

namespace Days\Day09;

use Tools\AbstractTask;
use Tools\Enum\TaskResultEnum;

class Task extends AbstractTask {

    public function execute(): int {

        $report = $this->loadData();

        $result1 = $this->task1($report);
        $result2 = $this->task2($report);

        $this->taskResult($result1, $result2);

        return TaskResultEnum::SUCCESS;
    }

    public function task1(array $report): int {
        $total = 0;
        foreach ($report as $history) {
            $numbers = explode(' ', $history);
            $total += $this->calcRight($numbers) + end($numbers);
        }
        
        return $total;
    }

    public function calcRight(array $numbers) {
        $line = [];
        for ($i = 0; $i < count($numbers) - 1; $i++) {
            $line[] = $numbers[$i + 1] - $numbers[$i];
        }

        if (array_sum($line) == 0) {
            return 0;
        }

        return end($line) + $this->calcRight($line);
    }

    public function task2(array $report): int {
        $total = 0;
        foreach ($report as $history) {
            $numbers = explode(' ', $history);
            $total += reset($numbers) - $this->calcLeft($numbers);
        }

        return $total;
    }

    public function calcLeft($numbers) {
        $line = [];
        for ($i = 0; $i < count($numbers) - 1; $i++) {
            $line[] = $numbers[$i + 1] - $numbers[$i];
        }

        if (array_sum($line) == 0) {
            return 0;
        }

        return $line[0] - $this->calcLeft($line);
    }
}
