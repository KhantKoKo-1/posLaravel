<?php

namespace App\Repositories\Shift;

interface ShiftRepositoryInterface
{
    public function shiftValidation();
    public function startShift(array $data);
    public function endShift();
    public function selectOrdersByShiftId(int $shift_id,bool $download);
}
