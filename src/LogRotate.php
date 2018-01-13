<?php

namespace Recca0120\EloquentLogRotate;

use Carbon\Carbon;
use Illuminate\Support\Arr;

trait LogRotate
{
    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        $table = parent::getTable();

        $now = Carbon::now();

        return $table.'_'.$now->format('Ymd');
    }
}
