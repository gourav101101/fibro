@extends('backend.layouts.admin')
@section('title', 'Company Settings')
@section('header', 'Company Settings')

@section('content')
<div class="admin-detail">
    <div class="admin-detail-header">
        <h3>Company Details</h3>
    </div>
    <div class="admin-detail-body">
        <form method="POST" action="{{ route('admin.company.update') }}">
            @csrf @method('PUT')
            
            @if($errors->any())
                <div class="admin-alert admin-alert-error">
                    <ul style="margin:0;padding-left:20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="admin-form-grid">
                <div>
                    <h4 style="margin-bottom:12px;font-size:14px;color:var(--admin-text-muted)">Contact Information</h4>
                    <div class="admin-form-group">
                        <label for="name">Company Name</label>
                        <input type="text" id="name" name="name" class="admin-input" value="{{ old('name', $settings['name'] ?? '') }}">
                    </div>
                    <div class="admin-form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="admin-input" value="{{ old('email', $settings['email'] ?? '') }}">
                    </div>
                    <div class="admin-form-group">
                        <label for="mobile">Mobile Number (Display)</label>
                        <input type="text" id="mobile" name="mobile" class="admin-input" value="{{ old('mobile', $settings['mobile'] ?? '') }}">
                    </div>
                    <div class="admin-form-group">
                        <label for="mobileHref">Mobile Number (Link href)</label>
                        <input type="text" id="mobileHref" name="mobileHref" class="admin-input" value="{{ old('mobileHref', $settings['mobileHref'] ?? '') }}">
                    </div>
                    <div class="admin-form-group">
                        <label for="whatsappHref">WhatsApp Link</label>
                        <input type="text" id="whatsappHref" name="whatsappHref" class="admin-input" value="{{ old('whatsappHref', $settings['whatsappHref'] ?? '') }}">
                    </div>
                </div>
                
                <div>
                    <h4 style="margin-bottom:12px;font-size:14px;color:var(--admin-text-muted)">Address</h4>
                    <div class="admin-form-group">
                        <label for="address">Address Line 1</label>
                        <input type="text" id="address" name="address" class="admin-input" value="{{ old('address', $settings['address'] ?? '') }}">
                    </div>
                    <div class="admin-form-group">
                        <label for="locality">Locality (City, State, Zip)</label>
                        <input type="text" id="locality" name="locality" class="admin-input" value="{{ old('locality', $settings['locality'] ?? '') }}">
                    </div>
                    
                    <h4 style="margin-top:24px;margin-bottom:12px;font-size:14px;color:var(--admin-text-muted)">Social Links</h4>
                    @php
                        $socials = isset($settings['socialLinks']) ? json_decode($settings['socialLinks'], true) : [];
                    @endphp
                    @for($i = 0; $i < 3; $i++)
                        <div style="display:flex;gap:8px;margin-bottom:12px;">
                            <div class="admin-form-group" style="flex:1;margin:0">
                                <input type="text" name="social_labels[]" class="admin-input" value="{{ old('social_labels.'.$i, $socials[$i]['label'] ?? '') }}" placeholder="Label (e.g. LinkedIn)">
                            </div>
                            <div class="admin-form-group" style="flex:2;margin:0">
                                <input type="text" name="social_hrefs[]" class="admin-input" value="{{ old('social_hrefs.'.$i, $socials[$i]['href'] ?? '') }}" placeholder="URL">
                            </div>
                            <input type="hidden" name="social_accessible[]" value="{{ old('social_accessible.'.$i, $socials[$i]['accessibleLabel'] ?? '') }}">
                        </div>
                    @endfor
                </div>
            </div>
            
            <div class="admin-detail-actions">
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </div>
        </form>
    </div>
</div>
@endsection
