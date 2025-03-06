<?php

namespace App\Domains\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\WorkingTimeService;
use Illuminate\Http\Request;

class APIStoreController extends Controller
{
    protected $workingTimeService;

    public function __construct(WorkingTimeService $workingTimeService)
    {
        $this->workingTimeService = $workingTimeService;;
    }

    public function index()
    {
        $data = $this->workingTimeService->getAll();

        return $this->response($data);
    }

    public function status(Request $request)
    {
        $data = $this->workingTimeService->status($request->selectedDate);

        return $this->response($data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'day' => 'required|string',
            'open_time' => 'required',
            'close_time' => 'required',
            'lunch_start' => 'nullable',
            'lunch_end' => 'nullable',
        ]);

        $data = $this->workingTimeService->configure(
            $request->day,
            $request->only(['open_time', 'close_time', 'lunch_start', 'lunch_end'])
        );

        return $this->response($data);
    }

    public function destroy(Request $request)
    {
        $this->workingTimeService->deleteById($request->id);

        return $this->response(true);
    }
}
