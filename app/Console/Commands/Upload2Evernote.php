<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Post;
use \Evernote\Client as Client;

class Upload2Evernote extends Command
{
    // the name of notebook would like to upload notes
    const NotebookName = '123';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'evernote:uploadNote';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload new articles to evernote';

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
        // fetch the posts have't been uploaded 100 records at a time
        $posts = Post::where('evernote_uploaded', false)->limit(100)->get();
        // get dev token from env file
        $token = env('EVERNOTE_DEV_TOKEN');
        // for dev env
        $sandbox = true;

        if($posts->isEmpty()) {
            echo "No notes need to be uploaded.\n";
        }


        $client = new Client($token, $sandbox);

        // get the particular notebook by assign name
        $notebooks = $client->listNotebooks();
        $specifiedNotebookIndex = array_search(self::NotebookName,
            array_map(function($notebook) {
                return $notebook->name;
            }, $notebooks)
        );
        $specifiedNotebook = $notebooks[$specifiedNotebookIndex];

        // upload every single post and update the uploaded_flag to 1
        foreach ($posts as $post) {
            $note         = new \Evernote\Model\Note();
            $note->title  = $post->title;
            $note->content = new \Evernote\Model\PlainTextNoteContent($post->body);
            $post->evernote_uploaded = true;
            $post->save();

            $client->uploadNote($note, $specifiedNotebook);

            echo "[".$post->title."] has been uploaded.\n";
        }
    }
}
