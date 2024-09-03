<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Article::with('Wordpress')->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return response()->json($request);
        $article = new Article();
        $article->title = $request->title;
        $article->content = $request->content;
        $article->wordpress_id = $request->wordpress_id;
        $article->status = $request->status;
        $article->save();
        $domain = $article->Wordpress->domain;
        $token = $article->Wordpress->token;
        if ($request->name_tag) {
            foreach ($request->name_tag as $tag) {
                $existGroup = Tag::where('name_tag', $tag)->where('wordpress_id', $request->wordpress_id)->first();
                if ($existGroup) {
                    $response = Http::get($domain . '/wp-json/wp/v2/tags?search=' . $tag);
                    $json = $response->getBody()->getContents();
                    $status = $response->getStatusCode();
                    $json = json_decode($json);
                    $existStatus = false;
                    foreach ($json as $TagData) {
                        if ($TagData->name === $tag) {
                            $wordpressTagId = $TagData->id;
                            $existStatus = true;
                        }
                    }
                    if (!$existStatus) {
                        $postTag = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->POST($domain . '/wp-json/wp/v2/tags', [
                            'name' => $tag,
                        ]);
                        $statusPostTag = $postTag->getStatusCode();
                        $jsonPostTag = $postTag->getBody()->getContents();
                        $jsonPostTag = json_decode($jsonPostTag);
                        $existGroup->wordpress_tag_id = $jsonPostTag->id;
                        $existGroup->save();
                        $existGroup->article()->syncWithoutDetaching($article->id);
                    } else {
                        $existGroup->wordpress_tag_id = $wordpressTagId;
                        $existGroup->save();
                        $existGroup->article()->syncWithoutDetaching($article->id);
                    }
                } else {
                    $response = Http::get($domain . '/wp-json/wp/v2/tags?search=' . $tag);
                    $json = $response->getBody()->getContents();
                    $status = $response->getStatusCode();
                    $json = json_decode($json);

                    $existStatus2 = false;
                    // $wordpressTagId = null;
                    foreach ($json as $TagData) {
                        if ($TagData->name === $tag) {
                            $wordpressTagId = $TagData->id;
                            $existStatus2 = true;
                        }
                    }
                    if (!$existStatus2) {
                        $postTag = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->POST($domain . '/wp-json/wp/v2/tags', [
                            'name' => $tag,
                        ]);
                        $statusPostTag = $postTag->getStatusCode();
                        $jsonPostTag = $postTag->getBody()->getContents();
                        $jsonPostTag = json_decode($jsonPostTag);
                        $newsTag = new Tag();
                        $newsTag->name_tag = $jsonPostTag->name;
                        $newsTag->wordpress_tag_id = $jsonPostTag->id;
                        $newsTag->wordpress_id = $request->wordpress_id;
                        $newsTag->save();
                        $newsTag->article()->syncWithoutDetaching($article->id);
                    } else {
                        $newTag = new Tag();
                        $newTag->name_tag = $tag;
                        $newTag->wordpress_tag_id = $wordpressTagId;
                        $newTag->wordpress_id = $request->wordpress_id;
                        $newTag->save();
                        $newTag->article()->syncWithoutDetaching($article->id);
                    }
                }
            }
        }
        if ($request->name_category) {
            foreach ($request->name_category as $Category) {
                $existCategory = Category::where('name', $Category)->where('wordpress_id', $request->wordpress_id)->first();
                if ($existCategory) {
                    $response1 = Http::get($domain . '/wp-json/wp/v2/categories?search=' . $Category);
                    $json = $response1->getBody()->getContents();
                    $status = $response1->getStatusCode();
                    $json = json_decode($json);
                    $existStatus = false;
                    foreach ($json as $CategoryData) {
                        if ($CategoryData->name === $Category) {
                            $wordpressCategoryId = $CategoryData->id;
                            $existStatus = true;
                        }
                    }
                    if (!$existStatus) {
                        $postCategory = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->POST($domain . '/wp-json/wp/v2/categories', [
                            'name' => $Category,
                        ]);
                        $statusPostTag = $postCategory->getStatusCode();
                        $jsonPostTag = $postCategory->getBody()->getContents();
                        $jsonPostTag = json_decode($jsonPostTag);
                        $existCategory->wordpress_category_id = $jsonPostTag->id;
                        $existCategory->save();
                        $existCategory->articles()->syncWithoutDetaching($article->id);
                    } else {
                        $existCategory->wordpress_category_id = $wordpressCategoryId;
                        $existCategory->save();
                        $existCategory->articles()->syncWithoutDetaching($article->id);
                    }
                } else {
                    $response2 = Http::get($domain . '/wp-json/wp/v2/categories?search=' . $Category);
                    $json = $response2->getBody()->getContents();
                    $status = $response2->getStatusCode();
                    $json = json_decode($json);

                    $existStatus2 = false;
                    foreach ($json as $CategoryData) {
                        if ($CategoryData->name === $Category) {
                            $wordpressCategoryId = $CategoryData->id;
                            $existStatus2 = true;
                        }
                    }
                    if (!$existStatus2) {
                        $postCategory = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->POST($domain . '/wp-json/wp/v2/categories', [
                            'name' => $Category,
                        ]);
                        $statusPostTag = $postCategory->getStatusCode();
                        $jsonPostTag = $postCategory->getBody()->getContents();
                        $jsonPostTag = json_decode($jsonPostTag);
                        $newsCategory = new Category();
                        $newsCategory->name = $jsonPostTag->name;
                        $newsCategory->wordpress_category_id = $jsonPostTag->id;
                        $newsCategory->wordpress_id = $request->wordpress_id;
                        $newsCategory->save();
                        $newsCategory->articles()->syncWithoutDetaching($article->id);
                    } else {
                        $newCategory = new Category();
                        $newCategory->name = $Category;
                        $newCategory->wordpress_category_id = $wordpressCategoryId;
                        $newCategory->wordpress_id = $request->wordpress_id;
                        $newCategory->save();
                        $newCategory->articles()->syncWithoutDetaching($article->id);
                    }
                }
            }
        }
        return response()->json($article);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }

    public function getDataById($id)
    {
        $article = Article::where('wordpress_id', $id)->with('tag')->with('category')->get();
        return response()->json($article);
    }

    public function changeStatus(Request $request)
    {
        // return response()->json($request);
        $article = Article::find($request->id);
        $article->status = 'publish';
        $article->save();
        return response()->json($article);
    }

    public function GetTagsById($id)
    {
        $tag = Tag::where('wordpress_id', $id)->get();
        return response()->json($tag);
    }
    
    public function GetCategoryById($id)
    {
        $category = Category::where('wordpress_id', $id)->get();
        return response()->json($category);
    }
}
