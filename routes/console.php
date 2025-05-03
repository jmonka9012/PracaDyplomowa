<?php

use Illuminate\Support\Facades\Schedule;


Schedule::command('events:archive')->daily();
