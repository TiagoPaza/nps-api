<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\PlanActivity
 *
 * @property int $id
 * @property int $questions_current
 * @property int $plan_id
 * @property int $user_id
 * @property-read Plan $plan
 * @property-read User $user
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @mixin Eloquent\Model
 */
class PlanActivity extends Model
{
    use SoftDeletes;

    /*
     * The name of table
     */
    protected $table = 'plans_activities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'questions_current', 'plan_id', 'user_id'
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
        'plan', 'user'
    ];

    /*
     * Function to relate model
     */
    public function plan()
    {
        return $this->belongsTo('App\Plan');
    }

    /*
     * Function to relate model
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
