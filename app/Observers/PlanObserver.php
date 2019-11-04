<?php

namespace App\Observers;

use App\Plan;
use Spatie\ResponseCache\ResponseCache;

class PlanObserver
{
    protected $cache;

    /**
     * @param ResponseCache $cache
     */
    public function __construct(ResponseCache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Listen to the Plan created event.
     *
     * @param Plan $plan
     * @return void
     */
    public function created(Plan $plan)
    {
        $this->cache->clear();
    }

    /**
     * Listen to the Plan created event.
     *
     * @param Plan $plan
     * @return void
     */
    public function updated(Plan $plan)
    {
        $this->cache->clear();
    }

    /**
     * Listen to the Plan deleted event.
     *
     * @param Plan $plan
     * @return void
     */
    public function deleted(Plan $plan)
    {
        $this->cache->clear();
    }
}
