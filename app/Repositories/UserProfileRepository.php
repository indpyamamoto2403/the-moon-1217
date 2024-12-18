<?php
namespace App\Repositories;

use App\Models\UserProfile;
use Illuminate\Http\Request;

class UserProfileRepository
{
    public function save(Request $request): void
    {
        // ユーザー情報を保存または更新
        $data = [
            'user_id' => $request->user_id,
            'name' => $request->name,
            'email' => $request->email,
            'company_name' => $request->company_name,
            'department' => $request->department,
            'position' => $request->position,
            'zipCode' => $request->zip_code,
            'address' => $request->address,
            'company_url' => $request->company_url,
            'company_overview' => $request->company_overview,
        ];

        UserProfile::updateOrCreate(
            ['user_id' => $request->user_id],
            $data
        );
    }
    public function get(int $id): ?UserProfile
    {
        // ユーザー情報を取得
        return UserProfile::where("user_id", $id)->first();
    }
}