<?php return [
  'opening-hours' => [
    'monday' => ['09:00-12:00', '13:00-18:00'],
    'tuesday' => ['09:00-12:00', '13:00-18:00'],
    'wednesday' => ['09:00-12:00'],
    'thursday' => ['09:00-12:00', '13:00-18:00'],
    'friday' => ['09:00-12:00', '13:00-20:00'],
    'saturday' => ['09:00-12:00', '13:00-16:00'],
    'sunday' => [],
    'exceptions' => [
      '2016-11-11' => ['09:00-12:00'],
      '2016-12-25' => [],
      '01-01' => [], // Recurring on each 1st of january
      '12-25' => ['09:00-12:00'], // Recurring on each 25th of december
    ],
  ],
  'holidaysAreClosed' => true,
  'holidays' => [
    'region' => 'us',
    'with' => [
      'boss-birthday' => '09-26',
      'last-monday'   => '= last Monday of October',
    ],
  ],
];
