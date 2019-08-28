<?php

namespace App\Observers;

use App\PlanActivity;
use Spatie\ResponseCache\ResponseCache;

class PlanActivityObserver
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
     * Listen to the PlanActivity created event.
     *
     * @param PlanActivity $planActivity
     * @return void
     */
    public function created(PlanActivity $planActivity)
    {
        $this->cache->flush();
    }

    /**
     * Listen to the PlanActivity created event.
     *
     * @param PlanActivity $planActivity
     * @return void
     */
    public function updated(PlanActivity $planActivity)
    {
        $this->cache->flush();
    }

    /**
     * Listen to the PlanActivity deleted event.
     *
     * @param PlanActivity $planActivity
     * @return void
     */
    public function deleted(PlanActivity $planActivity)
    {
        $this->cache->flush();
    }
}
