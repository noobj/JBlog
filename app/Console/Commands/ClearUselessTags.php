<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Tag;

class ClearUselessTags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tags:clear-useless';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean tags where doesn\'t have any post';

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
        $tags = Tag::all();

        foreach ($tags as $tag) {
            if ($tag->posts->first() === Null) {
                echo '[' . $tag->name . "] has been deleted.\n";
                $tag->delete();
            }
        }
    }
}
