<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Services\ProfileService;
use App\Utils\OpenAI\OpenAIAPIClient;
use App\DomainLogic\Prompts\Prompts;

class ProfileController extends Controller
{
    protected $userId;
    protected $profileService;

    public function __construct()
    {
        $client = new OpenAIAPIClient();
        $this->userId = Auth::user()->id;
        $this->profileService = new ProfileService();
    }

    /**
     * ユーザー情報を閲覧する
     */
    public function edit(Request $request): Response
    {
        $profile = $this->profileService->get($this->userId);
        return Inertia::render('Profile/Edit', [
            'profile' => $profile,
        ]);
    }

    /**
     * ユーザー情報を更新する。
     * @param Request
     * @return RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): Response | RedirectResponse
    {
        $this->profileService->save($request); //ユーザー情報をアップデート
        $answer = $this->profileService->getClassificationNumberByCompanyOverview($request->company_overview); //会社概要から経済産業分類を取得
        dd($answer);
        return Inertia::render('Profile/Completed');
    }


    /**
     * ユーザー情報を完了する画面
     * 遷移のついでにユーザーのタグ付けを行う
     */
    public function completed(Request $request): Response
    {
        $this->profileService->complete($this->userId);
        return Inertia::render('Profile/Complete');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
