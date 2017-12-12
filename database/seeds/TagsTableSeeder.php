<?php
use App\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::truncate();

        $tag = new Tag;
        $tag->name = "Laravel";
        $tag->save();

        $tag = new Tag;
        $tag->name = "Ruby on Rail's";
        $tag->save();

        $tag = new Tag;
        $tag->name = "Python";
        $tag->save();

        $tag = new Tag;
        $tag->name = "C++";
        $tag->save();
    }
}
