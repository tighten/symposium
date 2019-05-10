<?php

namespace App\CallingAllPapers;

use stdClass;
use UnexpectedValueException;

class Event
{
    public $id;
    public $dateCfpEnd;
    public $dateCfpStart;
    public $dateEventEnd;
    public $dateEventStart;
    public $description;
    /** @var string The URI to the event's homepage */
    public $eventUri;
    public $iconUri;
    public $lastChange;
    public $latitude;
    public $location;
    public $longitude;
    public $name;
    public $sources;
    public $tags;
    public $timezone;
    /** @var string The URI to the event's CFP */
    public $uri;

    private function __construct()
    {
    }

    public static function createFromStdClass(stdClass $object)
    {
        $event = new self;

        if (preg_match('|v1/cfp/([a-z0-9]{40})|', $object->_rel->cfp_uri ?? null, $matches)) {
            // The end of the CFP URI contains a SHA-1 of the URI of conference's homepage
            // Some conferences use the same URI from year to year, so we append the date
            // to this URI in order to ensure each year's conference is represented separately

            if (self::isValidDateString($object->dateEventStart)) {
                $year = substr($object->dateEventStart, 0, 4);
            } elseif (self::isValidDateString($object->dateCfpEnd)) {
                $year = substr($object->dateCfpEnd, 0, 4);
            } else {
                throw new UnexpectedValueException("No valid year found on {$object->_rel->cfp_uri}");
            }
            $event->id = $matches[1] . $year;
        } else {
            throw new UnexpectedValueException('Hash not found on CallingAllPapers event');
        }

        foreach (get_object_vars($event) as $property => $unused) {
            if ($property == 'id') {
                continue;
            }

            $event->$property = $object->$property ?? null;

            if (substr($property, 0, 4) == 'date' && !self::isValidDateString($event->$property)) {
                $event->$property = null;
            }
        }
        return $event;
    }

    private static function isValidDateString(string $date)
    {
        return $date !== '1970-01-01T00:00:00+00:00';
    }
}
