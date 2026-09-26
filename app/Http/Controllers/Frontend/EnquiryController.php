<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreEnquiryRequest;
use App\Mail\NewEnquiryMail;
use App\Models\Enquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Throwable;

class EnquiryController extends Controller
{
    public function store(StoreEnquiryRequest $request): JsonResponse
    {
        $enquiry = Enquiry::create($request->safe()->except(['consent', 'website']));

        try {
            Mail::to(config('mail.enquiries.to.address'), config('mail.enquiries.to.name'))
                ->send(new NewEnquiryMail($enquiry));
        } catch (Throwable $exception) {
            report($exception);
        }

        return response()->json(['message' => 'Your enquiry has been received.'], 201);
    }
}
