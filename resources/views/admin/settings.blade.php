@extends('layouts.admin-app')
@section('title', 'Settings')
@section('content')
<div class="p-8">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold mb-4">System Settings</h2>
        <div class="space-y-4">
            <div><label class="block font-semibold mb-2">Site Name</label><input type="text" value="Sports Management System" class="w-full border rounded-lg p-2"></div>
            <div><label class="block font-semibold mb-2">Contact Email</label><input type="email" value="admin@sports.com" class="w-full border rounded-lg p-2"></div>
            <div><label class="block font-semibold mb-2">Timezone</label><select class="w-full border rounded-lg p-2"><option>UTC</option><option>America/New_York</option><option>Europe/London</option></select></div>
            <button class="bg-purple-600 text-white px-4 py-2 rounded-lg w-full">Save Settings</button>
        </div>
    </div>
</div>
@endsection
