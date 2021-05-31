<?php

namespace App\Http\Controllers\Clients\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ProductResource;
use App\Http\Traits\ResponseTrait;
use App\Models\LikeReview;
use App\Models\Product;
use App\Models\Review;
use App\User;
use Faker\Provider\Image;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    use ResponseTrait;

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $product = Product::with('reviews')->find($id);
        if ($product) {
            $response['product'] = new ProductResource($product);
            return self::okResponse($response);
        }
        return self::notFoundResponse();
    }

    /**
     * @param ProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $product = Product::create($data);
        if ($data['cover']) {
            $img = Image::make($data['cover']);
            $path = 'products/' . $product->id . 'cover.jpg';
            Storage::disk('public')->put($path, (string)$img->encode());
            $product->update(['cover' => Storage::disk('public')->url($path)]);
        }
        $response['product'] = new ProductResource($product);
        return self::okResponse($response);
    }

    /**
     * @param ProductUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        $product = Product::find($id);
        if ($product) {
            $data = $request->validated();
            $img = Image::make($data['cover']);
            $path = 'products/' . $product->id . 'cover.jpg';
            Storage::disk('public')->put($path, (string)$img->encode());
            $product->update(['cover' => Storage::disk('public')->url($path)]);

            $response['product'] = new ProductResource($product);
            return self::okResponse($response);
        }
        return self::notFoundResponse();
    }

    /**
     * @param $id
     * @return string
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return self::okResponse(['message' => 'ok']);
        }
        return self::notFoundResponse();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function like($id)
    {
        $like = LikeReview::where('user_id', auth()->id())->where('review_id', $id)->first();
        if ($like) {
            $like->delete();
            return self::okResponse(['like' => 0]);
        }
        LikeReview::create(['user_id' => auth()->id(), 'review_id' => $id]);
        return self::okResponse(['like' => 1]);
    }

    /**
     * @param ReviewRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addReview(ReviewRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $review = Review::create($data);
        return self::okResponse(['review' => $review]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function wishlist($id)
    {
        $user = User::find(auth()->id());
        $user->wishlists()->create(['product_id' => $id]);
        return self::okResponse(['user' => $user]);
    }
}
