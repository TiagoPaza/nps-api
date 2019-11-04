<?php

namespace App\Observers;

use App\Question;
use Spatie\ResponseCache\ResponseCache;

class QuestionObserver
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
     * Listen to the Question created event.
     *
     * @param Question $question
     * @return void
     */
    public function created(Question $question)
    {
        $this->cache->clear();
    }

    /**
     * Listen to the Question created event.
     *
     * @param Question $question
     * @return void
     */
    public function updated(Question $question)
    {
        $this->cache->clear();
    }

    /**
     * Listen to the Question deleted event.
     *
     * @param Question $question
     * @return void
     */
    public function deleted(Question $question)
    {
        $this->cache->clear();
    }
}
