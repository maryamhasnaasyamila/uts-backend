<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Carbon\Carbon;



class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $news = News::all();

        if ($news) {
            $data = [
                'message' => "Data semua Berita",
                'data' => $news
            ];

            #mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Data kosong',
            ];

            # mereturn pesan erorr dan kode 404
            return response()->json($data, 404);
        }
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
        //
        $validateData = $request->validate([
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
            'content' =>  'required',
            'url' => 'required',
            'url_image' => 'required',
            'published_at' => 'date|required',
            'category' => 'required',
            // 'timestamp' => 'timestamp|required',
        ]);

        $validateData['published_at'] = Carbon::now();

        # menggunakan News dengan eloquent create untuk insert data
        $news = News::create($validateData);

        $data = [
            'message' => 'Berita berhasil ditambahkan',
            'data' => $news,
        ];

        # mengembalikan data (json) status code 201
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $news = News::find($id);

        if ($news) {
            $data = [
                'message' => 'Detail Berita',
                'data' => $news,
            ];

            #mengembalikan data json status code 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Detail Berita tidak ada',
            ];

            # mengembalikan data json status code 200
            return response()->json($data, 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $news = News::find($id);

        if ($news) {
            # mendapatkan data request 
            $input = [
                'title' => $request->title ?? $news->title,
                'author' => $request->author ?? $news->author,
                'description' => $request->description ?? $news->description,
                'content' => $request->content ?? $news->content,
                'url' => $request->url ?? $news->url,
                'url_image' => $request->url_image ?? $news->url_image,
                'published_at' => $request->published_at ?? $news->published_at,
                'category' => $request->category ?? $news->category,
            ];

            # mengupdate data
            $news->update($input);

            $data = [
                'message' => 'Berita berhasil diupdate',
                'data' => $news
            ];

            # mengirimkan respon json dengan statu code 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Data kosong',
            ];

            # mengembalikan data json status code 404
            return response()->json($data, 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $news = News::find($id);

        if ($news) {
            # menghapus data News menggunakan eloquent delete
            $news->delete();

            $data = [
                'message' => "Data berita $id berhasil dihapus",
            ];

            # mengembalikan data json status code 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Data kosong',
            ];

            # mengembalikan data json status code 404
            return response()->json($data, 404);
        }
    }
    
    public function search($title)
    {
        # mencari data news berdasarkan title
        $news = News::where("title", 'LIKE', "%{$title}%")->get();

        if (count($news) > 0) {
            $data = [
                'message' => 'Berita berdasarkan Judul',
                'data' => $news
            ];

            #mengembalikan data json status code 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Data kosong',
            ];

            # mengembalikan data json status code 200
            return response()->json($data, 200);
        }
    }

    public function sport()
    {
        $news = News::where("category","sport")->get();
 
        $data = [
            'message' => 'Berita berdasarkan kategori Sport',
            'data' => $news,
        ];

        return response()->json($data, 200);
    }

    public function finance()
    {
        $news = News::where("category","finance")->get();
 
        $data = [
            'message' => 'Berita berdasarkan kategori Finance',
            'data' => $news,
        ];

        return response()->json($data, 200);
    }

    public function automotive()
    {
        $news = News::where("category","automotive")->get();
 
        $data = [
            'message' => 'Berita berdasarkan kategori Automotive',
            'data' => $news,
        ];

        return response()->json($data, 200);
    }
}
