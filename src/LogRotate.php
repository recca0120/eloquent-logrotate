<?php

namespace Recca0120\EloquentLogRotate;

use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;

trait LogRotate
{
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
        $now = Carbon::now();
        $logRotateTable = $table.'_'.$now->format('Ymd');

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
