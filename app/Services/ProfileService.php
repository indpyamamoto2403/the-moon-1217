<?php
namespace App\Services;
use App\Repositories\UserProfileRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\DomainLogic\Prompts\Prompts;
use App\Utils\OpenAI\OpenAIAPIClient;
use App\Repositories\MKeizaiSangyoBunruiRepository;

class ProfileService
{
    protected $userProfileRepository;
    protected $userRepository;
    protected $openAIAPIClient;
    protected $mKeizaiSangyoBunruiRepository;

    public function __construct()
    {
        $this->userProfileRepository = new UserProfileRepository();
        $this->userRepository = new UserRepository();
        $this->openAIAPIClient = new OpenAIAPIClient();
        $this->mKeizaiSangyoBunruiRepository = new MKeizaiSangyoBunruiRepository();
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

    /**
     * 会社概要から経済産業分類を行う。
     * @param string $overview 会社概要のテキスト群
     * @return string|array 経済産業分類ID("A"~"R")
     */
    public function getClassificationNumberByCompanyOverview(string $overview): string
    {
        //$keizai_sangyo_list = $this->mKeizaiSangyoBunruiRepository->getDaibunruisString();
        $daibunrui_name = $this->mKeizaiSangyoBunruiRepository->getDaibunruiNameByDaibunruiId('J');
        dd($daibunrui_name);
        $prompt = Prompts::economyClassification($overview, $keizai_sangyo_list);
        $answer = $this->openAIAPIClient->fetchAnswer($prompt);
        $decoded_answer = json_decode($answer, true);
        return $decoded_answer['classification'];
    }
}