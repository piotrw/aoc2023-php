<?php

namespace Days\Day03;

/**
 * Description of Helper
 *
 * @author piotrw
 */
class Helper {

    const NOTHING = '.';
    const DIRECTION_BOTH = 'both';
    const DIRECTION_LEFT = 'left';
    const DIRECTION_RIGHT = 'right';

    static public function isPart(string $field) {
        return !is_numeric($field) && $field !== self::NOTHING;
    }

    static public function getNumber(int $pos, array &$line, $direction = self::DIRECTION_BOTH): ?string {
        if ($pos < 0 || $pos >= count($line) || self::isPart($line[$pos]) || $line[$pos] === self::NOTHING) {
            return '';
        }

        $num = $line[$pos];
        $line[$pos] = self::NOTHING; // clear number to avoid duplicates

        switch ($direction) {
            case self::DIRECTION_LEFT:
                $num = self::getNumber($pos - 1, $line, self::DIRECTION_LEFT) . $num;
                break;
            case self::DIRECTION_RIGHT:
                $num .= self::getNumber($pos + 1, $line, self::DIRECTION_RIGHT);
                break;
            case self::DIRECTION_BOTH:
                $num = self::getNumber($pos - 1, $line, self::DIRECTION_LEFT) . $num . self::getNumber($pos + 1, $line, self::DIRECTION_RIGHT);
                break;
        }

        return $num;
    }
}
