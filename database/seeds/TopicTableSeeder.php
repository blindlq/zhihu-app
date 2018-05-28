<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $topic =factory(Topic::class)->times(10)->make();

        // 将数据集合转换为数组，并插入到数据库中
        Topic::insert($topic->toArray());
    }
}
