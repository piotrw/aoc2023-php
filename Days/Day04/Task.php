<?php

namespace Days\Day04;

use Tools\AbstractTask;
use Tools\Enum\TaskResultEnum;

class Task extends AbstractTask {

    public function execute(): int {

        $data = $this->loadData();
        $cards = $this->parseInput($data);

        $result1 = $this->task1($cards);
        $result2 = $this->task2($cards);

        $this->taskResult($result1, $result2);

        return TaskResultEnum::SUCCESS;
    }

    protected function parseInput(array $data): array {
        $cards = [];
        foreach ($data as $line) {
            $matches = [];
            preg_match('/^Card (.+): ([0-9\s]+) \| ([0-9\s]+)/', $line, $matches);
            $cards[trim($matches[1])] = [
                'winning_numbers' => array_map(fn($num) => trim($num), str_split($matches[2], 3)),
                'my_numbers' => array_map(fn($num) => trim($num), str_split($matches[3], 3))
            ];
        }

        return $cards;
    }

    protected function task1(array $cards): int {
        $total = 0;
        foreach ($cards as $card) {
            $points = 0;
            foreach ($card['winning_numbers'] as $number) {
                if (in_array($number, $card['my_numbers'])) {
                    if (!$points) {
                        $points = 1;
                        continue;
                    }
                    $points *= 2;
                }
            }

            $total += $points;
        }

        return $total;
    }

    protected function task2(array $cards): int {
        $copies = [];
        $points = [];
        foreach ($cards as $id => $card) {
            $win_count = 0;
            $points[$id] = 1 + ($copies[$id] ?? 0);
            foreach ($card['winning_numbers'] as $number) {
                if (in_array($number, $card['my_numbers'])) {
                    // if win copy next cards
                    $next_card_index = $id + $win_count + 1;
                    $copies[$next_card_index] = ($copies[$next_card_index] ?? 0) + 1;
                    
                    // if current win card copy exists, copy next cards also
                    if (isset($copies[$id])) {
                        $copies[$next_card_index] = $copies[$next_card_index] + $copies[$id];
                    }

                    $win_count++;
                }
            }
        }
        
        return array_sum($points);
    }
}
