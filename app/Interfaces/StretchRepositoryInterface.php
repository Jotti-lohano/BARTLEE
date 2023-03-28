<?php

namespace App\Interfaces;

interface StretchRepositoryInterface 
{
    public function setReminder(array $reminderDetails);
    public function updateReminder($reminderId, array $newreminder);
}