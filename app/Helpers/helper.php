<?php

/**
 * Determines if a given date and time is editable based on a specified limit of hours.
 *
 * @param string $dateTime The date and time to check for editability, formatted as "Y-m-d H:i:s".
 * @param int $limit The limit of hours within which the date and time is considered editable.
 * @param string $timezone The PHP timezone format to be used in date calculations.
 * @return bool|string Returns 'pastDay' if the given date and time is in the past, otherwise returns true if editable or false if not.
 * @example isItEditable("2024-04-20 10:00:00", 48, 'Europa/Istanbul')
 */
function isItEditable($dateTime, $limit, $timezone)
{
    $dateTime = new DateTime($dateTime, new DateTimeZone($timezone));
    $today = new DateTime('now', new DateTimeZone($timezone));
    if ($dateTime < $today) {
        return 'pastDay';
    }
    $interval = $dateTime->diff($today);
    $hours = $interval->h + $interval->days * 24;
    return $hours > $limit;
}

