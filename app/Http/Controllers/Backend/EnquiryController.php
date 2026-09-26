<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function index(Request $request): View
    {
        $query = Enquiry::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        if ($status = $request->input('status')) {
            if ($status === 'unread') {
                $query->whereNull('read_at');
            } elseif ($status === 'read') {
                $query->whereNotNull('read_at');
            }
        }

        $enquiries = $query->latest()->paginate(20)->withQueryString();

        return view('backend.enquiries.index', compact('enquiries'));
    }

    public function show(Enquiry $enquiry): View
    {
        if (!$enquiry->read_at) {
            $enquiry->update(['read_at' => now()]);
        }

        return view('backend.enquiries.show', compact('enquiry'));
    }

    public function toggleRead(Enquiry $enquiry): RedirectResponse
    {
        $enquiry->update([
            'read_at' => $enquiry->read_at ? null : now(),
        ]);

        return back()->with('success', $enquiry->read_at ? 'Marked as read.' : 'Marked as unread.');
    }

    public function destroy(Enquiry $enquiry): RedirectResponse
    {
        $enquiry->delete();

        return redirect()->route('admin.enquiries.index')->with('success', 'Enquiry deleted.');
    }
}
