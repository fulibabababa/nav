<?php

namespace App\Http\Controllers;

use App\Http\Requests\WebRegisterRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use QL\QueryList;

class LinkController extends Controller
{
    public function index()
    {
        $categories = Category::with('links')->status(Category::ONLINE)->get();

        return view('index', compact('categories'));
    }

    public function employ()
    {
        $categories = Category::with('links')->canRegister(Category::CAN_REGISTER)->get();

        return view('employ', compact('categories'));
    }

    public function register(WebRegisterRequest $request)
    {
        $data = request()->only(['web_name', 'link', 'category_id']);
        dd($data);
    }

    /**
     *
     */
    public function hack()
    {
        $queryList = QueryList::get('http://91dh2.xyz/', null, [
            'cache'     => storage_path('temp'),
            'cache_ttl' => 60 * 10// 缓存有效时间,单位：秒,可以不设置缓存有效时间
        ]);
        $data      = $queryList->range('.banner .web')->rules([
            'category_name' => ['.web_class_title', 'text'],
            'list'          => ['.web_list', 'html']
        ])->query()->getData(function ($category) {
            $category['list']          = QueryList::html($category['list'])->range('li')->rules([
                'web_name' => ['a', 'text'],
                'link'     => ['a', 'href'],
            ])->queryData();
            $category['category_name'] = trim($category['category_name']);
            return $category;
        });
        echo json_encode($data);
    }

    public function insert()
    {
        $json_string = file_get_contents(base_path('database/data.json'));
        $data        = collect(json_decode($json_string, true));
        $data->each(function ($item) {
            $category = Category::create(['category_name' => $item['category_name']]);
            $list     = $item['list'];
            $list     = array_map(function ($v) use ($category) {
                $v['category_id'] = $category->id;
                $v['type']        = 'self';
                $v['status']      = 1;
                return $v;
            }, $list);
            DB::table('links')->insert($list);
        });
    }
}
