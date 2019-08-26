<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\QuestionReply
 *
 * @property int $id
 * @property string $evaluation
 * @property string $response_optional
 * @property int $question_id
 * @property-read Question $question
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @mixin Eloquent\Model
 */
class QuestionReply extends Model
{
    use SoftDeletes;

    /*
     * The name of table
     */
    protected $table = 'questions_replies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'evaluation', 'response_optional', 'question_id'
    ];

    protected $dates = [
        'deleted_at'
    ];

    /**
     * We always want product info for orders so eager load to save n+1 queries.
     *
     * @var array
     */
    protected $with = [
        'question'
    ];

    /*
     * Function to relate model
     */
    public function question()
    {
        return $this->belongsTo('App\Question');
    }
}
