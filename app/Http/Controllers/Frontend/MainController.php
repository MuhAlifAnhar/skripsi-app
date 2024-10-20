<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Menu;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $chefs = DB::table('chefs')->orderBy('id', 'desc')
            ->limit(6)
            ->get(['name', 'position', 'description', 'photo', 'insta_link', 'linked_link']);

        $events = DB::table('events')->orderBy('id', 'desc')
            ->where('status', 'active')
            ->get(['name', 'description', 'price', 'image', 'status']);

        $images = DB::table('images')->latest()->get(['name', 'file']);

        $reviews = Review::with('transaction:id,code')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('frontend.index', [
            'chefs' => $chefs,
            'events' => $events,
            'menu_starter' => $this->getMenu(1),
            'menu_breakfast' => $this->getMenu(2),
            'menu_lunch' => $this->getMenu(3),
            'menu_dinner' => $this->getMenu(4),
            'images' => $images,
            'reviews' => $reviews
        ]);
    }

    public function getMenu(string $id)
    {
        $menu = Menu::with('category:id,title')->latest()
            ->where('status', 'active')
            ->where('category_id', $id)
            ->limit(6)
            ->get(['category_id', 'name', 'description', 'price', 'image']);

        return $menu;
    }
}
