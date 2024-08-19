<?php

use App\Jobs\GetUnprocessedSuccessfulEmailJob;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    GetUnprocessedSuccessfulEmailJob::dispatch();
})->hourly();
