<?php

namespace Recca0120\EloquentLogrotate;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Database\Schema\Blueprint;

trait Logrotate
{
    /**
     * $logrotateTableCreated.
     *
     * @var array
     */
    protected static $logrotateTableCreated = [];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return $this->createLogrotateTable(parent::getTable());
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
        $logrotateTypeFormat = property_exists($this, 'logrotateTypeFormat') === true ? $this->logrotateTypeFormat : [
            'yearly' => 'Y',
            'monthly' => 'Ym',
            'weekly' => 'YW',
            'daily' => 'Ymd',
            'hourly' => 'YmdH',
        ];

        return $table.'_'.Carbon::now()->format(Arr::get($logrotateTypeFormat, $logrotateType, 'Ym'));
    }

    /**
     * {@inheritdoc}
     *
     * @param string $table
     * @return string
     */
    protected function createLogrotateTable($table)
    {
        $logrotateTable = $this->getLogrotateTable($table);
        $schema = $this->getConnection()->getSchemaBuilder();
        if (isset(static::$logrotateTableCreated[$logrotateTable]) === false && $schema->hasTable($logrotateTable) === false) {
            $schema->create($logrotateTable, function (Blueprint $table) {
                $this->logrotateTableSchema($table);
            });
            static::$logrotateTableCreated[$logrotateTable] = true;
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
