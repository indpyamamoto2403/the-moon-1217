<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;

class UserRepository
{
    public function save(Request $request): void
    {
        // Userインスタンスをidで取得、存在しない場合は新規作成
        $user = User::where('id', $request->user_id)->first();

        // 更新したい値をセット
        $user->name = $request->name;
        $user->email = $request->email;

        // 値を保存
        $user->save();
    }
    public function get(int $id): ?UserProfile
    {
        return User::find($id);
    }
}