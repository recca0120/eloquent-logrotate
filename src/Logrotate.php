<?php

namespace Recca0120\EloquentLogrotate;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Database\Schema\Blueprint;

trait Logrotate
{
    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return $this->getLogrotateTable(parent::getTable());
    }

    /**
     * {@inheritdoc}
     *
     * @param string $table
     * @return string
     */
    protected function getLogrotateTable($table)
    {
        $logrotateType = property_exists($this, 'logrotateType') === true ? $this->logrotateType : 'monthly';
        $logrotateTable = $table.'_'.Carbon::now()->format(Arr::get([
            'daily' => 'Ymd',
            'monthly' => 'Ym',
            'yearly' => 'Y',
        ], $logrotateType, 'Ymd'));

        $schema = $this->getConnection()->getSchemaBuilder();
        if ($schema->hasTable($logrotateTable) === false) {
            $schema->create($logrotateTable, function (Blueprint $table) {
                $this->logrotateTableSchema($table);
            });
        }

        return $logrotateTable;
    }

    /**
     * {@inheritdoc}
     *
     * @param Blueprint $table
     * @return void
     */
    abstract protected function logrotateTableSchema(Blueprint $table);
}
