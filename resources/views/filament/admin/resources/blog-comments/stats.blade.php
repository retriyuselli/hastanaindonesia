<div class="p-6">
    <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">Comment Statistics</h2>
    
    <div class="grid grid-cols-2 gap-4">
        <!-- Total Comments -->
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Total Comments</p>
                    <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $total }}</p>
                </div>
                <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                </svg>
            </div>
        </div>

        <!-- Approved -->
        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-600 dark:text-green-400 font-medium">Approved</p>
                    <p class="text-2xl font-bold text-green-900 dark:text-green-100">{{ $approved }}</p>
                </div>
                <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                {{ $total > 0 ? round(($approved / $total) * 100, 1) : 0 }}% of total
            </p>
        </div>

        <!-- Pending -->
        <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-yellow-600 dark:text-yellow-400 font-medium">Pending Review</p>
                    <p class="text-2xl font-bold text-yellow-900 dark:text-yellow-100">{{ $pending }}</p>
                </div>
                <svg class="w-10 h-10 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-1">
                {{ $total > 0 ? round(($pending / $total) * 100, 1) : 0 }}% of total
            </p>
        </div>

        <!-- Today -->
        <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-purple-600 dark:text-purple-400 font-medium">Today</p>
                    <p class="text-2xl font-bold text-purple-900 dark:text-purple-100">{{ $today }}</p>
                </div>
                <svg class="w-10 h-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>

        <!-- This Week -->
        <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-lg p-4 col-span-2">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-indigo-600 dark:text-indigo-400 font-medium">Last 7 Days</p>
                    <p class="text-2xl font-bold text-indigo-900 dark:text-indigo-100">{{ $thisWeek }}</p>
                </div>
                <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
        </div>
    </div>

    @if($pending > 0)
    <div class="mt-4 p-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg">
        <div class="flex items-start gap-2">
            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div>
                <p class="text-sm font-semibold text-amber-900 dark:text-amber-100">Action Required</p>
                <p class="text-xs text-amber-700 dark:text-amber-300 mt-0.5">
                    You have {{ $pending }} comment{{ $pending > 1 ? 's' : '' }} waiting for approval
                </p>
            </div>
        </div>
    </div>
    @endif
</div>
