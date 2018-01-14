<?php

namespace Recca0120\EloquentLogRotate;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Database\Schema\Blueprint;

trait LogRotate
{
    protected $logRotate = 'monthly';

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return $this->getLogRotateTable(parent::getTable());
    }

    /**
     * {@inheritdoc}
     *
     * @param string $table
     * @return string
     */
    protected function getLogRotateTable($table)
    {
        $logRotateTable = $table.'_'.Carbon::now()->format(Arr::get([
            'daily' => 'Ymd',
            'monthly' => 'Ym',
            'yearly' => 'Y',
        ], $this->logRotate, 'Ymd'));

        $schema = $this->getConnection()->getSchemaBuilder();

        if ($schema->hasTable($logRotateTable) === false) {
            $schema->create($logRotateTable, function (Blueprint $table) {
                $this->createLogRotateTable($table);
            });
        }

        return $logRotateTable;
    }

    /**
     * {@inheritdoc}
     *
     * @param Blueprint $table
     * @return void
     */
    abstract protected function createLogRotateTable(Blueprint $table);
}
