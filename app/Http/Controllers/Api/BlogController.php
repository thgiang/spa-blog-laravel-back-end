<?php

namespace App\Http\Controllers\Api;

use App\Blog;
use App\Category;
use DOMDocument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Vedmant\FeedReader\Facades\FeedReader;

class BlogController extends Controller
{
    public function search(Request $request)
    {
        if (!$request->keyword) {
            return response()->json([]);
        }
        $from = 0;
        if ($request->page && is_numeric($request->page) && $request->page > 1) {
            $from = ($request->page - 1) * 10;
        }
        $elasticUrl = env('ESLASTICSEARCH_URL', 'http://localhost:9200');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $elasticUrl . "/_search?pretty",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{\"_source\": [\"updated_at\",\"cat_name\",\"id\",\"cat_id\",\"description\",\"thumbnail\",\"title\"],\"query\":{\"bool\":{\"should\":[{\"match\":{\"content\":\"" . $request->keyword . "\"}},{\"match\":{\"title\":\"" . $request->keyword . "\"}}]}},\"from\":" . $from . ",\"size\":10,\"sort\":[],\"aggs\":{}}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
        exit();
    }

    public function dummy()
    {

        $randomNews = json_decode(file_get_contents('news.json'));
        $categories = Category::get()->toArray();
        foreach ($randomNews->feed->entry as $news) {
            $category = $categories[rand(0, count($categories) - 1)];

            $blog = new Blog();
            $blog->title = $news->title->__text;
            $blog->content = $news->content->__text;
            $blog->thumbnail = "http://2.bp.blogspot.com/-Yu0-6uQplqQ/VfejYOVUomI/AAAAAAAANkc/RkEi-ykFYEs/s1600/business_that-is-fun-idea_142K.jpg";

            preg_match('/src*=*["\']?([^"\']*)/i', $blog->content, $matches);
            if (isset($matches[1]) && !strpos($matches[1], 'youtube') !== false) {
                $blog->thumbnail = $matches[1];
            }

            $blog->cat_id = $category['id'];
            $blog->user_id = rand(0, 10);

            $blog->description = mb_substr(strip_tags($blog->content), 0, 300);
            $blog->save();
        }
    }

    public function index()
    {

        /*
        for($i = 0; $i < 1000; $i++) {
            $blog = new Blog();
            $blog->title = "Bài viết số với một cái tên dài ".($i+1);
            $blog->user_id = 1;
            $blog->thumbnail = "https://picsum.photos/600/400";
            $blog->slug = "bai-viet-so-".($i+1);
            $blog->description = "Theo hội nghị Digiday Content Marketing vào đầu năm 2016, một trong những khó khăn lớn nhất mà các content marketer đang gặp phải là thiếu hụt về kinh phí. Các chiến dịch content marketing thường khó thu hút kinh phí hơn so với các hình thức marketing khác, vốn thường mang lại lợi nhuận chỉ sau một thời gian ngắn.";
            $content = "";
            for($x = 0; $x < rand(2, 7); $x++) {
                $content .=  "Theo hội nghị Digiday Content Marketing vào đầu năm 2016, một trong những khó khăn lớn nhất mà các content marketer đang gặp phải là thiếu hụt về kinh phí. Các chiến dịch content marketing thường khó thu hút kinh phí hơn so với các hình thức marketing khác, vốn thường mang lại lợi nhuận chỉ sau một thời gian ngắn. ";
            }
            $blog->content = $content;
            $blog->save();
        }
        exit();
        */
        $perPage = request('per_page', 16);
        $blogs = Blog::with('category')->orderBy('id', 'DESC')->paginate($perPage);
        foreach ($blogs as $blog) {
            $blog->cat_name = $blog->category->name;
        }
        return response()->json($blogs);
    }

    public function getBlogsByCategory($id)
    {
        $perPage = request('per_page', 16);
        if ($id > 0) {
            $blogs = Blog::with('category')->where('cat_id', $id)->orderBy('id', 'DESC')->paginate($perPage);
        } else {
            $blogs = Blog::with('category')->orderBy('id', 'DESC')->paginate($perPage);
        }

        return response()->json($blogs);
    }

    public function show($id)
    {
        return response()->json(Blog::where('id', $id)->first());
    }
}
