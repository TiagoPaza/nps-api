<?php

namespace App\Observers;

use App\QuestionReply;
use Spatie\ResponseCache\ResponseCache;

class QuestionReplyObserver
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
     * Listen to the QuestionReply created event.
     *
     * @param QuestionReply $questionReply
     * @return void
     */
    public function created(QuestionReply $questionReply)
    {
        $this->cache->flush();
    }

    /**
     * Listen to the QuestionReply created event.
     *
     * @param QuestionReply $questionReply
     * @return void
     */
    public function updated(QuestionReply $questionReply)
    {
        $this->cache->flush();
    }

    /**
     * Listen to the QuestionReply deleted event.
     *
     * @param QuestionReply $questionReply
     * @return void
     */
    public function deleted(QuestionReply $questionReply)
    {
        $this->cache->flush();
    }
}
