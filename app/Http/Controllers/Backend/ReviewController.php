<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    public function __construct()
    {
        // Admin dan Operator bisa mengakses `index` dan `show`
        $this->middleware('can:semuaRole', ['only' => ['index', 'show']]);

        // Operator bisa mengakses `create`, `edit`, `store`, `update`, dan `destroy`
        $this->middleware('can:isOperator', ['only' => ['create', 'edit', 'store', 'update', 'destroy']]);
    }
    public function index(): View
    {
        return view('backend.review.index', [
            'reviews' => Review::with('transaction:id,code')->paginate(10),
        ]);
    }

    public function show(string $uuid): View
    {
        $review = Review::with('transaction:id,code,name,type')
        ->whereUuid($uuid)->firstOrFail();

        return view('backend.review.show', [
            'review' => $review
        ]);
    }

    public function destroy(string $uuid): JsonResponse
    {
        $review = Review::where('uuid', $uuid)->firstOrFail();
        $review->delete();

        return response()->json([
            'message' => 'Review deleted successfully'
        ]);
    }
}
