<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('backup:run --disable-notifications')->dailyAt('01:45');
