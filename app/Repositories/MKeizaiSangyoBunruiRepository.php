<?php
namespace App\Repositories;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Models\MKeizaiSangyoBunrui;

class MKeizaiSangyoBunruiRepository
{
    protected $mKeizaiSangyoBunrui;

    public function __construct()
    {
        $this->mKeizaiSangyoBunrui = new MKeizaiSangyoBunrui();
    }

    public function getAll(): array
    {
        return $this->mKeizaiSangyoBunrui->all()->toArray();
    }

    public function getDaibunruis(): array
    {
        return $this->mKeizaiSangyoBunrui
            ->get(['daibunrui_id', 'daibunrui_name']) 
            ->unique('daibunrui_id') 
            ->toArray();
    }

    public function getDaibunruisString(): string
    {
        return $this->mKeizaiSangyoBunrui
            ->get(['daibunrui_id', 'daibunrui_name'])
            ->unique('daibunrui_id')
            ->map(function ($item) {
                return $item->daibunrui_id . ' ' . $item->daibunrui_name; 
            })
            ->implode("\n");
    }

    public function getDaibunruiNameByDaibunruiId(string $daibunrui_id): string
    {
        return $this->mKeizaiSangyoBunrui
            ->where('daibunrui_id', $daibunrui_id)
            ->get(['daibunrui_id', 'daibunrui_name'])
            ->first();
    }
}