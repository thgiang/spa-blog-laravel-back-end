<?php

namespace App\Listeners;

use App\Blog;
use App\Category;
use App\Events\SaveBlogEvent;
use App\Model\History;
use App\Option;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SaveBlogListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param SaveBlogEvent $event
     * @return void
     */
    public function handle(SaveBlogEvent $event)
    {
        $blog = $event->blog;
        if (!$blog) {
            return;
        }

        $category = Category::where('id', $blog->cat_id)->first();
        if($category) {
            $blog->cat_name = $category->name;
        } else {
            $blog->cat_name = 'Uncategorized';
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('ESLASTICSEARCH_URL', 'http://localhost:9200').'/'.$blog->getIndexName()."/_doc/".$blog->id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($blog),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
    }
}
