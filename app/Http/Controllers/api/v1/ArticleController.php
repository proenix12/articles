<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\StoreArticleRequest;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $articles = Article::with('tagged')->get();
        return response()->json($articles);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreArticleRequest $request)
    {

        $validated = $request->validated();

        $article = Article::create([
            'title' => $validated['title'],
            'article_body' => $validated['article_body'],
            'article_photo_path' => $this->articleImage($validated['file'])
        ]);
        $article->tag((array)$validated['tag_name']);

        return response()->json(['success' => 'Article ' . $article->title . ' was added'], 200);
    }


    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $article = Article::withAnyTag((array)$request->tag_name)->get();
        return response()->json($article);

    }

    public function articleTagAttach(Request $request, $id)
    {
        try {
            $article = Article::findOrFail($id);
            $article->tag($request->tag_name);
            return response()->json(['success' => 'Tag:'. $request->tag_name .' was added to' . $article->title . 'article'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Article not found'], 404);
        }
    }

    public function articleTagUntag(Request $request, $id)
    {
        try {
            $article = Article::findOrFail($id);
            $article->untag($request->tag_name);
            return response()->json(['success' => 'Tag:'. $request->tag_name .' was deleted from' . $article->title . 'article'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Article not found'], 404);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     */
    public function update(UpdateArticleRequest $request, $id)
    {
        try {

            $validated = $request->validated();

            $article = Article::findOrFail($id);
            if ($request->has('file')) {

                $article->article_photo_path = $this->articleImage($validated['file']);
            }

            $article->update($request->all());

            if ($request->has('tag_name')) {
                $article->retag((array)$request->tag_name);
            }

            if ($article->save()) {
                return response()->json(['success' => 'Article ' . $article->title . ' was updated'], 200);
            } else {
                return response()->json(['error' => 'something went wrong try again'], 400);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Article not found'], 404);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        try {
            $article = Article::findOrFail($id);
            unlink(public_path() . $article->article_photo_path);
            $article->delete();
            return response()->json(['success' => 'Article ' . $article->title . ' was deleted']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Article not found'], 404);
        }

    }


    public function articleImage($articlePhoto): string
    {
        $imagePath = $articlePhoto;
        $uniqueFileName = uniqid() . Str::random(35) . '.' . $imagePath->getClientOriginalExtension();
        $path = $articlePhoto->storeAs('uploads', $uniqueFileName, 'public');
        return '/storage/' . $path;
    }
}
