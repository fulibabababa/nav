<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DataInsert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:insert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'insert default data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
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
        $this->info("Data insert success!");
    }
}
