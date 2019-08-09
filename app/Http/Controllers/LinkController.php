<?php

namespace App\Http\Controllers;

use App\Http\Requests\WebRegisterRequest;
use App\Models\Category;
use App\Models\Link;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use QL\QueryList;

class LinkController extends Controller
{
    public function index()
    {
        $categories = Category::with([
            'links' => function ($query) {
                $query->where('status', Link::STATUS_SUCCESS);
            }
        ])->status(Category::ONLINE)->get();

        return view('index', compact('categories'));
    }

    public function employ()
    {
        $categories = Category::with('links')->canRegister(Category::CAN_REGISTER)->get();

        $links = Link::with('category')->orderByDesc('id')->paginate(20);

        return view('employ', compact('categories', 'links'));
    }

    public function register(WebRegisterRequest $request)
    {
        $data                = request()->only(['web_name', 'link', 'category_id']);
        $data['top_domain']  = url_top_domain($data['link']);
        $data['domain_name'] = url_domain_name($data['link']);
        Link::create($data);

        return redirect()->back();
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
        $rank        = 1;
        $data->each(function ($item) use (&$rank) {
            $category = Category::create(['category_name' => $item['category_name']]);
            $list     = $item['list'];
            $list     = array_map(function ($v) use ($category, &$rank) {
                $v['category_id'] = $category->id;
                $v['type']        = 'self';
                $v['status']      = 1;
                $v['domain_name'] = url_domain_name($v['link']);
                $v['top_domain']  = url_top_domain($v['link']);
                $v['rank']        = $rank;
                $rank++;
                return $v;
            }, $list);
            DB::table('links')->insert($list);
        });
    }

    public function check()
    {

        $links = Link::other()->notInBlackList()->get();
        $urls  = $links->pluck('link');
        if ($urls->isEmpty()) {
        }
        QueryList::multiGet($urls->toArray())
            ->concurrency(5)
            // 设置GuzzleHttp的一些其他选项
            ->withOptions([
                'timeout' => 60
            ])
            ->success(function (QueryList $ql, Response $response, $index) use ($links) {
                $link = $links[$index];
                echo $link->web_name;

                $text = $ql->find('a[href="http://nav.showtime.test"]')->text();
                if (empty($text) || !Str::contains($text, '可儿福利导航')) {
                    if ($link->isOverMaxFailure()) {
                        $link->status = Link::STATUS_BLACKLIST;
                    } else {
                        $link->increment('failure_times');
                    }
                } else {
                    $link->status = Link::STATUS_SUCCESS;
                }
                $link->save();
            })
            ->error(function (QueryList $ql, $reason, $index) use ($links) {
                $link = $links[$index];
                echo $link->web_name;

                if ($link->isOverMaxFailure()) {
                    $link->status = Link::STATUS_BLACKLIST;
                } else {
                    $link->increment('failure_times');
                }

                $link->save();
            })
            ->send();
    }
}
