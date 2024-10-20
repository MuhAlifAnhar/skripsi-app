<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\Gallery\Image;
use App\Http\Services\FileService;
use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Http\Services\CategoryService;
use App\Http\Services\MenuService;

class MenuController extends Controller
{
    public function __construct(
        private FileService $fileService,
        private CategoryService $categoryService,
        private MenuService $menuService
    ) {
         // Admin dan Operator bisa mengakses `index` dan `show`
        $this->middleware('can:semuaRole', ['only' => ['index', 'show']]);

        // Operator bisa mengakses `create`, `edit`, `store`, `update`, dan `destroy`
        $this->middleware('can:isOperator', ['only' => ['create', 'edit', 'store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.menu.index', [
            'menus' => $this->menuService->select(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.menu.create', [
            'categories' => $this->categoryService->select()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MenuRequest $request)
    {
        $data = $request->validated();

        try {
            $data['image'] = $this->fileService->upload($data['image'], 'images');

            $this->menuService->create($data);

            return redirect()->route('panel.menu.index')->with('success', 'Menu has been created');
        } catch (\Exception $err) {
            $this->fileService->delete($data['image']);

            return redirect()->back()->with('error', $err->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        return view('backend.menu.show', [
            'menu' => $this->menuService->selectFirstBy('uuid', $uuid)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid)
    {
        return view('backend.menu.edit', [
            'menu' => $this->menuService->selectFirstBy('uuid', $uuid),
            'categories' => $this->categoryService->select()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MenuRequest $request, string $uuid)
    {
        $data = $request->validated();

        $getMenu = $this->menuService->selectFirstBy('uuid', $uuid);

        try {
            // jika upload
            if ($request->hasFile('image')) {
                // hapus gambar lama
                if ($getMenu->image) {
                    $this->fileService->delete($getMenu->image);
                }

                // upload gambar baru
                $data['image'] = $this->fileService->upload($data['image'], 'images');
            } else {
                // jika tidak upload
                $data['image'] = $getMenu->image;
            }

            $this->menuService->update($data, $uuid);

            return redirect()->route('panel.menu.index')->with('success', 'Menu has been updated');
        } catch (\Exception $err) {
            if ($request->hasFile('image')) {
                $this->fileService->delete($data['image']);
            }

            return redirect()->back()->with('error', $err->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $getMenu = $this->menuService->selectFirstBy('uuid', $uuid);

        $this->fileService->delete($getMenu->image);

        $getMenu->delete();

        return response()->json([
            'message' => 'Menu has been deleted'
        ]);
    }
}
