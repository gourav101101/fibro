<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreEnquiryRequest;
use App\Models\Enquiry;
use Illuminate\Http\JsonResponse;

class EnquiryController extends Controller
{
    public function store(StoreEnquiryRequest $request): JsonResponse
    {
        Enquiry::create($request->safe()->except(['consent', 'website']));

        return response()->json(['message' => 'Your enquiry has been received.'], 201);
    }
}
