<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    public static $snakeAttributes = false;
    /**
     * モデルに対応するテーブル名
     *
     * @var string
     */
    protected $table = 'user_profiles';

    /**
     * 一括代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'company_name',
        'department',
        'position',
        'zip_code',
        'address',
        'company_url',
        'company_overview',
    ];

    /**
     * リレーション: User (1対1の関係)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
