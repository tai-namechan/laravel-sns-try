<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdentityProvider extends Model
{
    // IdentityProviderモデルの設定
    // プロバイダーの情報はユーザーに属するのでbelongTo
    protected $fillable = ['user_id', 'provider_name', 'provider_id'];

    function user()
    {
        return $this->belongsTo(User::class);
    }
}
