<?php

protected function schedule(Schedule $schedule)
{
    $schedule->command('payments:allocate-overpayments')->monthlyOn(1, '00:00');
}
