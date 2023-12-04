<?php

namespace Days\Day03;

use Tools\AbstractTask;
use Tools\Enum\TaskResultEnum;

class Task extends AbstractTask {

    const GEAR = '*';

    public function execute(): int {

        $data = $this->loadDataAsArray();

        $result1 = $this->task1($data);
        $result2 = $this->task2($data);

        $this->taskResult($result1, $result2);

        return TaskResultEnum::SUCCESS;
    }

    protected function task1(array $data): int {
        $total = 0;
        for ($y = 0; $y < count($data); $y++) {
            $currentNumber = null;
            $isImportant = false;

            for ($x = 0; $x < count($data[$y]); $x++) {
                $cursor = $data[$y][$x];
                if (is_numeric($cursor)) {
                    $currentNumber .= $cursor;
                    if (
                            (isset($data[$y - 1][$x - 1]) && Helper::isPart($data[$y - 1][$x - 1])) ||
                            (isset($data[$y - 1][$x]) && Helper::isPart($data[$y - 1][$x])) ||
                            (isset($data[$y - 1][$x + 1]) && Helper::isPart($data[$y - 1][$x + 1])) ||
                            (isset($data[$y][$x - 1]) && Helper::isPart($data[$y][$x - 1])) ||
                            (isset($data[$y][$x + 1]) && Helper::isPart($data[$y][$x + 1])) ||
                            (isset($data[$y + 1][$x - 1]) && Helper::isPart($data[$y + 1][$x - 1])) ||
                            (isset($data[$y + 1][$x]) && Helper::isPart($data[$y + 1][$x])) ||
                            (isset($data[$y + 1][$x + 1]) && Helper::isPart($data[$y + 1][$x + 1]))
                    ) {
                        $isImportant = true;
                    }
                } elseif ($isImportant) {
                    $total += $currentNumber;
                    $isImportant = false;
                    $currentNumber = null;
                } else {
                    $currentNumber = null;
                }
            }
            // last number in the line
            if ($isImportant) {
                $total += $currentNumber;
            }
        }

        return $total;
    }

    protected function task2(array $data): int {
        $gears = [];
        for ($y = 0; $y < count($data); $y++) {
            $currentNumber = null;
            $isImportant = false;

            for ($x = 0; $x < count($data[$y]); $x++) {
                $cursor = $data[$y][$x];
                if ($cursor == self::GEAR) {
                    $gears[] = [
                        Helper::getNumber($x - 1, $data[$y - 1]),
                        Helper::getNumber($x, $data[$y - 1]),
                        Helper::getNumber($x + 1, $data[$y - 1]),
                        Helper::getNumber($x - 1, $data[$y]),
                        Helper::getNumber($x + 1, $data[$y]),
                        Helper::getNumber($x - 1, $data[$y + 1]),
                        Helper::getNumber($x, $data[$y + 1]),
                        Helper::getNumber($x + 1, $data[$y + 1])
                    ];
                }
            }
        }

        $total = 0;
        foreach ($gears as $numbers) {
            $numbers = array_filter($numbers, fn($item) => $item);
            if (count($numbers) > 1) {
                $total += array_product($numbers);
            }
        }

        return $total;
    }
}
