<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Question
 *
 * @property int $id
 * @property string $ask
 * @property string $ask_optional
 * @property-read User $user
 * @property int $user_id
 * @property Carbon|null $expire_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @mixin Eloquent\Model
 */
class Question extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ask', 'ask_optional', 'user_id',
        'expire_at'
    ];

    protected $dates = [
        'expire_at', 'deleted_at'
    ];

    /**
     * We always want product info for orders so eager load to save n+1 queries.
     *
     * @var array
     */
    protected $with = [
        'user'
    ];

    /*
     * Function to relate model
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
