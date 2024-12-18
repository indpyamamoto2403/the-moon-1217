<?php
namespace App\Services;
use App\Repositories\UserProfileRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
class ProfileService
{
    protected $userProfileRepository;
    protected $userRepository;
    // コンストラクタでUserRepositoryを依存注入
    public function __construct()
    {
        $this->userProfileRepository = new UserProfileRepository();
        $this->userRepository = new UserRepository();
    }

    // ユーザーを保存
    public function save(Request $request)
    {
        $this->userProfileRepository->save($request);
        $this->userRepository->save($request);
    }

    // IDでユーザーを取得
    public function get(int $id)
    {
        return $this->userProfileRepository->get($id);
    }
}