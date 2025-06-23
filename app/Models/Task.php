<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="Task",
 *      required={"user_id","title","description","priority","status"},
 *      @OA\Property(
 *          property="title",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="description",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="priority",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="boolean",
 *      ),
 *      @OA\Property(
 *          property="completed_at",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
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
 *      ),
 *      @OA\Property(
 *          property="status",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      )
 * )
 */class Task extends Model
{
    use HasFactory;    public $table = 'tasks';

    public $fillable = [
        'user_id',
        'parent_id',
        'title',
        'description',
        'priority',
        'completed_at',
        'status'
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'priority' => 'boolean',
        'completed_at' => 'datetime',
        'status' => 'string'
    ];

    public static array $rules = [
        'user_id' => 'required',
        'parent_id' => 'nullable',
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:65535',
        'priority' => 'required|boolean',
        'completed_at' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'status' => 'required|string|max:255'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
