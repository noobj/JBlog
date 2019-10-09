<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Post;
use \Evernote\Client as Client;

class Upload2Evernote extends Command
{
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
        $posts = Post::where('evernote_uploaded', false)->limit(100)->get();

        if($posts->isEmpty()) {
            echo "No notes need to be uploaded.\n";
        }

        $token = env('EVERNOTE_DEV_TOKEN');
        $sandbox = true;

        $client = new Client($token, $sandbox);

        // get the notebook by name,*****works but ugly*********
        $notebooks = $client->listNotebooks();
        $specifiedNotebook = array_filter($notebooks,
            function ($notebook) {
                return $notebook->name == '123';
            }
        );

        // upload every single post and update the uploaded_flag to 1
        foreach ($posts as $post) {
            $note         = new \Evernote\Model\Note();
            $note->title  = $post->title;
            $note->content = new \Evernote\Model\PlainTextNoteContent($post->body);
            $post->evernote_uploaded = true;
            $post->save();

            // ********array_pop****** the ugly part
            $client->uploadNote($note, array_pop($specifiedNotebook));

            echo "[".$post->title."] has been uploaded.\n";
        }
    }
}
