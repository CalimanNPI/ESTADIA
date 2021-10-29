<?php

namespace App\Http\Controllers;

use App\Http\Requests\blogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    /**function __construct()
    {
        $this->middleware('permission:ver-blog|crear-blog|editar-blog|borrar-blog')->only('index');
        $this->middleware('permission:crear-blog', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-blog', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-blog', ['only' => ['destroy']]);
    }*/

    public function index()
    {
        return BlogResource::collection(Blog::all());
    }

    public function create()
    {
        return view('blogs.create');
    }

    public function store(blogRequest $request)
    {
        if($request->hasFile('archivo')){
            $file = $request->archivo->getClientOriginalName();
            info($file);
        }
        $blog = Blog::create($request->validated());
        return new BlogResource($blog);
        //return redirect()->route('blog.index');
    }

    public function show(Blog $blog)
    {
        return response()->json(['message' => 'task was successful']);
        return new BlogResource($blog);
    }

    public function edit(Blog $blog)
    {
        return view('blogs.edit', compact('blog'));
    }

    public function update(Blog $blog, blogRequest $request,)
    {
        $blog->update($request->validated());
        return new BlogResource($blog);
       // return redirect()->route('blog.index');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return response()->noContent();
    }
}
