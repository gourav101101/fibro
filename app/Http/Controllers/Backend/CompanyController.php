<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function edit()
    {
        $settings = CompanySetting::all()->pluck('value', 'key')->toArray();
        return view('backend.company.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        // Handle social links separately
        $socialLinks = [];
        if (is_array($request->social_labels)) {
            foreach ($request->social_labels as $index => $label) {
                if (!empty($label)) {
                    $socialLinks[] = [
                        'label' => $label,
                        'href' => $request->social_hrefs[$index] ?? '',
                        'accessibleLabel' => $request->social_accessible[$index] ?? '',
                    ];
                }
            }
        }
        $data['socialLinks'] = json_encode($socialLinks);
        
        unset($data['social_labels'], $data['social_hrefs'], $data['social_accessible']);

        foreach ($data as $key => $value) {
            CompanySetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->route('admin.company.edit')->with('success', 'Company settings updated successfully.');
    }
}
