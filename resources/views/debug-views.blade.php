<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Blog Views Debug Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">🔧 Blog Views Debug Test</h1>
        
        <div class="mb-6">
            <h2 class="text-xl font-bold mb-3">📊 Current Statistics</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                @php
                    $stats = [
                        'total' => App\Models\Blog::count(),
                        'zeroViews' => App\Models\Blog::where('views_count', 0)->count(),
                        'hasViews' => App\Models\Blog::where('views_count', '>', 0)->count(),
                        'totalViews' => App\Models\Blog::sum('views_count')
                    ];
                @endphp
                
                <div class="bg-blue-50 p-4 rounded">
                    <div class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</div>
                    <div class="text-sm text-gray-600">Total Articles</div>
                </div>
                <div class="bg-red-50 p-4 rounded">
                    <div class="text-2xl font-bold text-red-600">{{ $stats['zeroViews'] }}</div>
                    <div class="text-sm text-gray-600">Zero Views</div>
                </div>
                <div class="bg-green-50 p-4 rounded">
                    <div class="text-2xl font-bold text-green-600">{{ $stats['hasViews'] }}</div>
                    <div class="text-sm text-gray-600">Has Views</div>
                </div>
                <div class="bg-purple-50 p-4 rounded">
                    <div class="text-2xl font-bold text-purple-600">{{ $stats['totalViews'] }}</div>
                    <div class="text-sm text-gray-600">Total Views</div>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-bold mb-3">🧪 JavaScript Test</h2>
            <div class="bg-gray-50 p-4 rounded">
                @php $testBlog = App\Models\Blog::where('views_count', 0)->first(); @endphp
                
                @if($testBlog)
                <div data-blog-id="{{ $testBlog->id }}">
                    <p class="mb-2"><strong>Test Blog:</strong> {{ $testBlog->title }}</p>
                    <p class="mb-2"><strong>ID:</strong> {{ $testBlog->id }}</p>
                    <p class="mb-3"><strong>Current Views:</strong> <span id="current-views">{{ $testBlog->views_count }}</span></p>
                    
                    <button onclick="testViewIncrement()" 
                            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 mr-2">
                        🧪 Test Manual View Increment
                    </button>
                    
                    <button onclick="testJavaScriptTracking()" 
                            class="bg-green-600 text-white px-6 py-2 rounded hover:green-blue-700 mr-2">
                        🔧 Test JavaScript Tracking
                    </button>
                    
                    <button onclick="checkConsoleMessages()" 
                            class="bg-purple-600 text-white px-6 py-2 rounded hover:bg-purple-700">
                        📝 Show Console Messages
                    </button>
                </div>
                @else
                <p class="text-green-600">✅ All articles have been viewed!</p>
                @endif
            </div>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-bold mb-3">📋 Test Results</h2>
            <div id="test-results" class="bg-gray-50 p-4 rounded min-h-[100px]">
                <p class="text-gray-600">Click test buttons above to see results...</p>
            </div>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-bold mb-3">🔍 Console Messages</h2>
            <div id="console-messages" class="bg-black text-green-400 p-4 rounded font-mono text-sm min-h-[150px] overflow-y-auto">
                <div>Waiting for console messages...</div>
            </div>
        </div>
    </div>

<script>
// Capture console messages
const originalLog = console.log;
const originalError = console.error;
const messagesContainer = document.getElementById('console-messages');
let messages = [];

function addMessage(type, message) {
    const timestamp = new Date().toLocaleTimeString();
    messages.push(`[${timestamp}] ${type.toUpperCase()}: ${message}`);
    messagesContainer.innerHTML = messages.slice(-20).join('<br>');
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

console.log = function(...args) {
    addMessage('log', args.join(' '));
    originalLog.apply(console, args);
};

console.error = function(...args) {
    addMessage('error', args.join(' '));
    originalError.apply(console, args);
};

function updateResults(message, type = 'info') {
    const resultsDiv = document.getElementById('test-results');
    const timestamp = new Date().toLocaleTimeString();
    const colorClass = type === 'success' ? 'text-green-600' : 
                      type === 'error' ? 'text-red-600' : 
                      'text-blue-600';
    
    resultsDiv.innerHTML += `<div class="${colorClass}">[${timestamp}] ${message}</div>`;
    resultsDiv.scrollTop = resultsDiv.scrollHeight;
}

async function testViewIncrement() {
    updateResults('🧪 Testing manual view increment via API...');
    
    try {
        const blogId = document.querySelector('[data-blog-id]').dataset.blogId;
        const response = await fetch(`/api/blog/${blogId}/view`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        if (response.ok) {
            const result = await response.json();
            updateResults(`✅ API Success: ${JSON.stringify(result)}`, 'success');
            
            // Update display
            document.getElementById('current-views').textContent = result.views_count;
        } else {
            updateResults(`❌ API Error: ${response.status} ${response.statusText}`, 'error');
        }
    } catch (error) {
        updateResults(`❌ Network Error: ${error.message}`, 'error');
    }
}

function testJavaScriptTracking() {
    updateResults('🔧 Testing JavaScript blog engagement loading...');
    
    // Check if blog-engagement.js loaded
    if (window.BlogEngagement) {
        updateResults('✅ BlogEngagement class found', 'success');
    } else {
        updateResults('❌ BlogEngagement class not found', 'error');
    }
    
    // Check data-blog-id
    const blogId = document.querySelector('[data-blog-id]')?.dataset.blogId;
    if (blogId) {
        updateResults(`✅ Blog ID found: ${blogId}`, 'success');
    } else {
        updateResults('❌ Blog ID not found in data-blog-id attribute', 'error');
    }
    
    // Check CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    if (csrfToken) {
        updateResults(`✅ CSRF token found: ${csrfToken.substring(0, 10)}...`, 'success');
    } else {
        updateResults('❌ CSRF token not found', 'error');
    }
}

function checkConsoleMessages() {
    updateResults('📝 Console messages captured and displayed above');
    console.log('🔍 Manual console test message');
    console.log('📊 Current timestamp:', new Date().toISOString());
}

// Log initial state
console.log('🚀 Debug page loaded');
console.log('📝 Blog ID from data attribute:', document.querySelector('[data-blog-id]')?.dataset.blogId || 'NOT FOUND');
console.log('🔑 CSRF token available:', !!document.querySelector('meta[name="csrf-token"]'));

// Try to load blog-engagement.js manually
updateResults('🔄 Attempting to load blog engagement system...');
</script>

@vite('resources/js/blog-engagement.js')

</body>
</html>