@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 font-medium text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100']) }}>
        {{ $status }}
    </div>
@endif
