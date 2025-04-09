<?php

use App\Console\Commands\ArchiveOldEvents;
use Illuminate\Support\Facades\Schedule;


Schedule::command('events:archive')->daily();
