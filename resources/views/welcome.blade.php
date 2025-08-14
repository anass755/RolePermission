@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-4">jQuery Test</h2>
        
        <button id="test-btn" class="btn mb-4">
            Click me to test jQuery!
        </button>
        
        <div id="result" class="p-4 bg-gray-100 rounded hidden">
            <p>jQuery is working! 🎉</p>
        </div>
        
        <div class="mt-4">
            <p class="text-sm text-gray-600">
                Open browser console to see jQuery version.
            </p>
        </div>
    </div>
</div>

<script>
    // This script will run after jQuery is loaded by Vite
    $(document).ready(function() {
        $('#test-btn').click(function() {
            $('#result').fadeIn();
            $(this).text('jQuery is working!').addClass('bg-green-500');
        });
    });
</script>
@endsection