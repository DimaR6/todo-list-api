<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="LuckyDraw",
 *      required={"user_id","random_number","result","win_amount"},
 *      @OA\Property(
 *          property="result",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="win_amount",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */class LuckyDraw extends Model
{
    use HasFactory;    public $table = 'lucky_draws';

    public $fillable = [
        'user_id',
        'random_number',
        'result',
        'win_amount'
    ];

    protected $casts = [
        'result' => 'string',
        'win_amount' => 'decimal:2'
    ];

    public static array $rules = [
        'user_id' => 'required',
        'random_number' => 'required',
        'result' => 'required|string|max:255',
        'win_amount' => 'required|numeric',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
