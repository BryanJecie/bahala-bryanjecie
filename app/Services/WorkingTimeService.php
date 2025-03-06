<?php

namespace App\Services;

use App\Domains\Dashboard\Models\StoreHour;
use Carbon\Carbon;

class WorkingTimeService extends BaseService
{
    public function __construct(StoreHour $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        $hours = $this->model::all();

        return $hours;
    }

    public function status(?string $selectedDate = null)
    {
        $now = carbon()->now();
        $currentDay = strtolower($now->format('l'));

        if ($selectedDate) {
            $currentDay = strtolower(carbon()->parse($selectedDate)->format('l'));
        }

        $storeHours = $this->model::where('day', $currentDay)->first();

        if (!$storeHours) {
            return [
                'status' => 'closed',
                'next_opening' => $this->getNextOpeningTime($currentDay)
            ];
        }

        $openingTime = carbon()->parse($storeHours->open_time);
        $closingTime = carbon()->parse($storeHours->close_time);
        $lunchStart = carbon()->parse($storeHours->lunch_start);
        $lunchEnd = carbon()->parse($storeHours->lunch_end);

        if (($now->between($openingTime, $closingTime)) && !$now->between($lunchStart, $lunchEnd)) {
            return [
                'status' => 'open'
            ];
        }

        return [
            'status' => 'closed',
            'next_opening' => $this->getNextOpeningTime($currentDay)
        ];
    }

    public function configure($day, array $data = []) //: StoreHour
    {
        $model = $this->model::updateOrCreate(['day' => strtolower($day)], $data);

        return $model;
    }

    private function getNextOpeningTime($selectedDate = null)
    {
        $daysOfWeek = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $currentDayIndex = array_search(strtolower($selectedDate), $daysOfWeek);

        for ($i = 1; $i <= 7; $i++) {
            $nextDayIndex = ($currentDayIndex + $i) % 7;
            $nextDay = $daysOfWeek[$nextDayIndex];
            $storeHours = $this->model::where('day', $nextDay)->first();

            if ($storeHours) {
                return $storeHours->day . ' at ' . $storeHours->open_time;
            }
        }
        return 'Unknown';
    }
}
