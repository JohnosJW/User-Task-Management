<?php


namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Task
 * @package App\Models
 */
class Task extends Model
{
    use SoftDeletes, HasFactory;

    /** @var string  */
    public $table = 'tasks';

    /** @var string  */
    const CREATED_AT = 'created_at';

    /** @var string  */
    const UPDATED_AT = 'updated_at';

    /** @var string  */
    public const STATUS_ACTIVE = 'active';

    /** @var string  */
    public const STATUS_DONE = 'done';

    /** @var string  */
    public const STATUS_REJECTED = 'rejected';

    /** @var string[]  */
    public const STATUS_LIST = [
        self::STATUS_ACTIVE,
        self::STATUS_DONE,
        self::STATUS_REJECTED,
    ];

    /** @var array  */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    public $fillable = [
        'user_id',
        'title',
        'description',
        'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'title' => 'string',
        'description' => 'string',
        'status' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [];

    /**
     * Generate auto saving fields
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->status = self::STATUS_ACTIVE;
            $model->date = Carbon::now();
        });
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }
}
