<?php
namespace App\Utils\OpenAI;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\DomainLogic\Prompts\Prompts;

class OpenAIAPIClient
{
    protected $openAIAPIKey;
    protected $openAIEndpoint;
    public function __construct()
    {
        $this->client = new Client([
            'verify' => false,
        ]);
        $this->openAIAPIKey = env('OPENAI_API_KEY');
        $this->openAIEndpoint = env('OPENAI_ENDPOINT');
    }

    /**
    * テキストのみでAIに質問をして回答を取得する
    * @param string $prompt プロンプトテキスト
    */
    public function fetchAnswer(string $prompt): string|array
    {
        $payload = [
            "messages" => [
                [
                    "role" => "user",
                    "content" => $prompt,
                    "model" => "gpt-4o",
                ]
            ],
                "temperature" => 0.1,
                "top_p" => 0.95,
                "max_tokens" => 4000
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
                'api-key' => $this->openAIAPIKey,
        ])->withOptions([
            'verify' => false,  // SSL証明書の確認を無効にする
        ])->post($this->openAIEndpoint, $payload);
        
        if ($response->failed()) {
            Log::error('Failed to fetch data from API', ['status' => $response->status(), 'error' => $response->body()]);
            return "Error in fetching the answer.";
        }
        $data = $response->getBody()->getContents();
        $decoded_data = json_decode($data, true);
        $content = $decoded_data['choices'][0]['message']['content'];
        return $content;
    }

    /**
     * 画像のOCRを実行し、AIで質問に回答する
     * @param string $prompt プロンプトテキスト
     * @param string $encodedImage Base64エンコードされた画像
     */
    public function fetchAnswerWithImage(string $prompt, string $encodedImage): string|array
    {
        $payload = [
            "messages" => [
                [
                    "role" => "user",
                    "content" => [
                        ["type" => "text", "text" => $prompt],
                        [
                            "type" => "image_url",
                            "image_url" => [
                                "url" => "data:image/jpg;base64,{$encodedImage}"
                            ],
                        ],
                    ]
                ]
            ],
            "temperature" => 0.1,
            "top_p" => 0.95,
            "max_tokens" => 4000
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'api-key' => $this->openai_api_key,
            ])->withOptions([
                'verify' => false,  // Disable SSL verification
            ])->post($this->openai_endpoint, $payload);

            // ステータスコードが200でなければエラーを返す
            if ($response->failed()) {
                Log::error('Failed to fetch data from API', ['status' => $response->status(), 'error' => $response->body()]);
                return "Error in fetching the answer.";
            }

            $data = $response->getBody()->getContents();
            $decoded_data = json_decode($data, true);
            $content = $decoded_data['choices'][0]['message']['content'];
            return $content;

        } catch (\Exception $e) {
            Log::error('Failed to make the request.', ['error' => $e->getMessage()]);
            return "Error in fetching the answer.";
        }
    }



    /**
     * 企業情報を抽出する
     * @param array $params
     * @return array|null
     */
    public function extractCompanyInfo(array $params): ?array
    {
        $prompt = <<<EOD
        以下の情報について、その企業もしくは団体の
        事業内容を要約してください(200字程度)。
        EOD;

        try {
            if (empty($params['url'])) {
                $keyword = "{$params['company_name']} {$params['zip_code']} 事業内容";
                $response = $this->client->request('GET', "{$this->apiUrl}/keyword_query", [
                    'query' => [
                        'keyword' => $keyword,
                        'prompt' => $prompt,
                    ],
                ]);
            } else {
                $response = $this->client->request('POST', "{$this->apiUrl}/url_query", [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                    ],
                    'query' => [
                        'url' => $params['url'],
                        'prompt' => $prompt,
                    ],
                ]);
            }

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error('Failed to extract company info', ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function search_by_keyword(Request $request) {
        $response = $this->client->request('POST', $this->apiUrl . '/fetch_news', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'keyword1' => $request->input('keyword1'),
                'keyword2' => $request->input('keyword2'),
                'keyword3' => $request->input('keyword3'),
                'search_num' => $request->input('search_num'),
            ],
        ]);
    
        // JSONレスポンスをオブジェクトとしてデコード
        return json_decode($response->getBody()->getContents());
    }

    public function search_by_url(Request $request){
        $response = $this->client->request('POST', $this->apiUrl . '/fetch_news_by_url_keyword', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'url' => $request->input('url'),
                'keyword1' => $request->input('keyword1'),
                'keyword2' => $request->input('keyword2'),
                'keyword3' => $request->input('keyword3'),
            ],
        ]);
        $data = json_decode($response->getBody()->getContents());
        return  $data;
    }

    public function fetch_image_url(String $keyword){
        $response = $this->client->request('GET', $this->apiUrl . '/create_image', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'keyword' => $keyword,
            ],
        ]);
        $data = json_decode($response->getBody()->getContents());
        return  $data;
    }
}