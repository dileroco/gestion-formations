<?php

use App\Jobs\AutoArchiveSessions;
use App\Jobs\GenerateWeeklyReport;
use App\Jobs\SendSessionReminders;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new SendSessionReminders)->hourly();
Schedule::job(new AutoArchiveSessions)->daily();
Schedule::job(new GenerateWeeklyReport)->weekly();
