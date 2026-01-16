<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Calendar as GoogleCalendar;
use Google\Service\Calendar\Event;

class GoogleCalendarService
{
    public $service;

    public function __construct()
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/palazzo-de-la-sengle-e2416428d0d7.json'));
        $client->addScope(Calendar::CALENDAR);

        $this->service = new Calendar($client);
    }




public function createCalendar($summary)
{

    $calendar = new GoogleCalendar();
    $calendar->setSummary($summary);
    $calendar->setTimeZone('Europe/Rome');


    $createdCalendar = $this->service->calendars->insert($calendar);


    return $createdCalendar;
}


    public function checkAvailability($calendarId, $start, $end)
    {
        $events = $this->service->events->listEvents($calendarId, [
            'timeMin' => $start->toAtomString(),
            'timeMax' => $end->toAtomString(),
            'singleEvents' => true,
            'orderBy' => 'startTime',
        ]);

        return count($events->getItems()) === 0;
    }

    public function createEvent($calendarId, $booking)
    {
        $event = new Event([
            'summary' => 'Booking: Room ' . $booking->room->room_number,
            'description' => 'Booked by: ' . $booking->user->name,
            'start' => [
                'dateTime' => $booking->check_in->toAtomString(),
                'timeZone' => 'Europe/Rome',
            ],
            'end' => [
                'dateTime' => $booking->check_out->toAtomString(),
                'timeZone' => 'Europe/Rome',
            ],
        ]);

        return $this->service->events->insert($calendarId, $event);
    }
}
