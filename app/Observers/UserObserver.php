<?php

namespace App\Observers;

use App\User;
use Spatie\ResponseCache\ResponseCache;

class UserObserver
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
     * Listen to the User created event.
     *
     * @param User $user
     * @return void
     */
    public function created(User $user)
    {
        $this->cache->flush();
    }

    /**
     * Listen to the User created event.
     *
     * @param User $user
     * @return void
     */
    public function updated(User $user)
    {
        $this->cache->flush();
    }

    /**
     * Listen to the User deleted event.
     *
     * @param User $user
     * @return void
     */
    public function deleted(User $user)
    {
        $this->cache->flush();
    }
}
