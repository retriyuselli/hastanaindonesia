@extends('layouts.app')

@section('title', $event->title . ' - Event HASTANA Indonesia')

@section('content')
<!-- Event Hero Section -->
<section class="text-gray-800 py-6 mt-20">
    <div class="container mx-auto px-4">
        <div class="flex items-center gap-2 text-xs mb-3">
            <a href="{{ route('home') }}" class="hover:underline">Home</a>
            <span>/</span>
            <a href="{{ route('events') }}" class="hover:underline">Event</a>
            <span>/</span>
            <span class="text-blue-800">{{ $event->title }}</span>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-6 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Main Content -->
            <div class="lg:w-2/3">
                <!-- Event Header Card -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-5">
                    <!-- Event Image -->
                    <div class="relative h-80 bg-gray-200">
                        @if($event->image)
                            <img src="{{ $event->image_url }}"
                                 alt="{{ $event->title }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-500 to-blue-700">
                                <i class="fas fa-calendar-alt text-white text-7xl"></i>
                            </div>
                        @endif
                        
                        <!-- Badges -->
                        <div class="absolute top-3 left-3 flex gap-1.5">
                            @if($event->is_featured)
                                <span class="bg-yellow-500 text-white px-2.5 py-1 rounded-full text-xs font-semibold">
                                    <i class="fas fa-star"></i> Featured
                                </span>
                            @endif
                            @if($event->is_trending)
                                <span class="bg-red-500 text-white px-2.5 py-1 rounded-full text-xs font-semibold">
                                    <i class="fas fa-fire"></i> Trending
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Event Info -->
                    <div class="p-5">
                        <!-- Category & Type -->
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-blue-100 text-blue-800 px-2.5 py-1 rounded-full text-xs font-semibold">
                                <i class="fas fa-tag"></i> {{ $event->eventCategory->name ?? 'Uncategorized' }}
                            </span>
                            <span class="bg-gray-100 text-gray-800 px-2.5 py-1 rounded-full text-xs">
                                {{ $event->event_type == 'internal' ? 'Internal' : 'Eksternal' }}
                            </span>
                            <span class="bg-{{ $event->status == 'published' ? 'green' : 'gray' }}-100 text-{{ $event->status == 'published' ? 'green' : 'gray' }}-800 px-2.5 py-1 rounded-full text-xs">
                                {{ ucfirst($event->status) }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">
                            {{ $event->title }}
                        </h1>

                        <!-- Short Description -->
                        @if($event->short_description)
                            <p class="text-base text-gray-600 mb-5">
                                {{ $event->short_description }}
                            </p>
                        @endif

                        <!-- Event Stats -->
                        <div class="flex flex-wrap justify-center gap-5 md:gap-6 p-5 bg-gray-50 rounded-lg">
                            <div class="text-center min-w-[100px]">
                                <i class="fas fa-users text-blue-600 text-xl mb-1.5"></i>
                                <div class="text-xl font-bold text-gray-900">{{ $event->current_participants }}</div>
                                <div class="text-xs text-gray-600">Peserta Terdaftar</div>
                            </div>
                            <div class="text-center min-w-[100px]">
                                <i class="fas fa-ticket-alt text-green-600 text-xl mb-1.5"></i>
                                <div class="text-xl font-bold text-gray-900">
                                    {{ $event->capacity ? $event->remaining_quota : 'Unlimited' }}
                                </div>
                                <div class="text-xs text-gray-600">Sisa Kuota</div>
                            </div>
                            @if($event->rating > 0)
                                <div class="text-center min-w-[100px]">
                                    <i class="fas fa-star text-yellow-500 text-xl mb-1.5"></i>
                                    <div class="text-xl font-bold text-gray-900">{{ number_format($event->rating, 1) }}</div>
                                    <div class="text-xs text-gray-600">Rating</div>
                                </div>
                            @endif
                            <div class="text-center min-w-[100px]">
                                <i class="fas fa-eye text-purple-600 text-xl mb-1.5"></i>
                                <div class="text-xl font-bold text-gray-900">{{ $event->total_reviews }}</div>
                                <div class="text-xs text-gray-600">Reviews</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-lg shadow-lg p-5 mb-5">
                    <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i> Deskripsi Event
                    </h2>
                    <div class="event-description prose max-w-none text-gray-700">
                        {!! $event->description !!}
                    </div>
                </div>

                <style>
                .event-description {
                    font-family: 'Poppins', 'Inter', system-ui, -apple-system, sans-serif;
                    line-height: 1.8;
                    color: #374151;
                }

                /* Paragraphs */
                .event-description p {
                    font-size: 14px;
                    margin-bottom: 1rem;
                    text-align: justify;
                    color: #4b5563;
                }

                /* Drop Cap - First Letter */
                /* .event-description p:first-of-type::first-letter {
                    font-size: 3.5em;
                    font-weight: 700;
                    line-height: 0.9;
                    float: left;
                    margin: 0.1em 0.15em 0 0;
                    color: #3b82f6;
                    font-family: Georgia, serif;
                } */

                /* Headings */
                .event-description h1 {
                    font-size: 26px;
                    font-weight: 700;
                    margin: 1.5rem 0 1rem 0;
                    color: #1f2937;
                    padding-left: 1rem;
                    border-left: 5px solid transparent;
                    background: linear-gradient(90deg, #3b82f6 0%, #8b5cf6 100%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                    position: relative;
                }

                .event-description h1::before {
                    content: '';
                    position: absolute;
                    left: 0;
                    top: 0;
                    bottom: 0;
                    width: 5px;
                    background: linear-gradient(180deg, #3b82f6 0%, #8b5cf6 100%);
                    border-radius: 2px;
                }

                .event-description h2 {
                    font-size: 22px;
                    font-weight: 700;
                    margin: 1.5rem 0 1rem 0;
                    color: #1f2937;
                    padding-left: 1rem;
                    border-left: 4px solid transparent;
                    background: linear-gradient(90deg, #3b82f6 0%, #06b6d4 100%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                    position: relative;
                }

                .event-description h2::before {
                    content: '';
                    position: absolute;
                    left: 0;
                    top: 0;
                    bottom: 0;
                    width: 4px;
                    background: linear-gradient(180deg, #3b82f6 0%, #06b6d4 100%);
                    border-radius: 2px;
                }

                .event-description h3 {
                    font-size: 18px;
                    font-weight: 600;
                    margin: 1.25rem 0 0.75rem 0;
                    color: #1f2937;
                    padding-left: 0.75rem;
                    border-left: 3px solid #3b82f6;
                }

                .event-description h4 {
                    font-size: 16px;
                    font-weight: 600;
                    margin: 1rem 0 0.5rem 0;
                    color: #374151;
                    padding-left: 0.5rem;
                    border-left: 2px solid #60a5fa;
                }

                /* Lists */
                .event-description ul,
                .event-description ol {
                    margin: 1rem 0;
                    padding-left: 1.5rem;
                }

                .event-description ul li {
                    font-size: 14px;
                    margin-bottom: 0.5rem;
                    color: #4b5563;
                    position: relative;
                    padding-left: 1.5rem;
                    list-style: none;
                }

                .event-description ul li::before {
                    content: "▸";
                    position: absolute;
                    left: 0;
                    color: #3b82f6;
                    font-weight: bold;
                    font-size: 16px;
                }

                .event-description ol {
                    counter-reset: item;
                }

                .event-description ol li {
                    font-size: 14px;
                    margin-bottom: 0.5rem;
                    color: #4b5563;
                    position: relative;
                    padding-left: 2rem;
                    list-style: none;
                    counter-increment: item;
                }

                .event-description ol li::before {
                    content: counter(item);
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 24px;
                    height: 24px;
                    background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
                    color: white;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 12px;
                    font-weight: 600;
                }

                /* Blockquote */
                .event-description blockquote {
                    font-size: 14px;
                    padding: 1rem 1rem 1rem 3.5rem;
                    margin: 1.5rem 0;
                    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
                    border-left: 4px solid #3b82f6;
                    border-radius: 0.5rem;
                    position: relative;
                    font-style: italic;
                    color: #1e40af;
                }

                .event-description blockquote::before {
                    content: '"';
                    position: absolute;
                    left: 1rem;
                    top: 0.5rem;
                    font-size: 48px;
                    color: #3b82f6;
                    opacity: 0.3;
                    font-family: Georgia, serif;
                    line-height: 1;
                }

                /* Strong Text */
                .event-description strong {
                    font-weight: 600;
                    color: #1f2937;
                    background: linear-gradient(180deg, transparent 60%, #fef3c7 60%);
                    padding: 0 0.2em;
                }

                /* Emphasis */
                .event-description em {
                    font-style: italic;
                    color: #6366f1;
                }

                /* Links */
                .event-description a {
                    color: #3b82f6;
                    text-decoration: none;
                    font-weight: 500;
                    position: relative;
                    transition: color 0.2s;
                }

                .event-description a::after {
                    content: '';
                    position: absolute;
                    left: 0;
                    bottom: -2px;
                    width: 0;
                    height: 2px;
                    background: linear-gradient(90deg, #3b82f6 0%, #8b5cf6 100%);
                    transition: width 0.3s ease;
                }

                .event-description a:hover {
                    color: #2563eb;
                }

                .event-description a:hover::after {
                    width: 100%;
                }

                /* Code */
                .event-description code {
                    font-size: 13px;
                    padding: 0.2em 0.5em;
                    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
                    border: 1px solid #fbbf24;
                    border-radius: 0.25rem;
                    font-family: 'Courier New', monospace;
                    color: #92400e;
                }

                .event-description pre {
                    background: #1f2937;
                    padding: 1rem;
                    border-radius: 0.5rem;
                    overflow-x: auto;
                    margin: 1rem 0;
                }

                .event-description pre code {
                    background: transparent;
                    border: none;
                    color: #e5e7eb;
                    padding: 0;
                }

                /* Images */
                .event-description img {
                    max-width: 100%;
                    height: auto;
                    border-radius: 0.5rem;
                    margin: 1.5rem auto;
                    display: block;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                    transition: transform 0.3s ease;
                }

                .event-description img:hover {
                    transform: scale(1.02);
                }

                /* Tables */
                .event-description table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 1.5rem 0;
                    font-size: 13px;
                    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                    border-radius: 0.5rem;
                    overflow: hidden;
                }

                .event-description table thead {
                    background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
                    color: white;
                }

                .event-description table th {
                    padding: 0.75rem;
                    text-align: left;
                    font-weight: 600;
                    font-size: 13px;
                }

                .event-description table td {
                    padding: 0.75rem;
                    border-bottom: 1px solid #e5e7eb;
                }

                .event-description table tbody tr:nth-child(even) {
                    background-color: #f9fafb;
                }

                .event-description table tbody tr:hover {
                    background-color: #eff6ff;
                }

                /* Horizontal Rule */
                .event-description hr {
                    border: none;
                    height: 2px;
                    background: linear-gradient(90deg, transparent 0%, #3b82f6 50%, transparent 100%);
                    margin: 2rem 0;
                }

                /* Benefits Description - Same styling as Event Description */
                .benefits-description {
                    font-family: 'Poppins', 'Inter', system-ui, -apple-system, sans-serif;
                    line-height: 1.8;
                    color: #374151;
                }

                /* Paragraphs */
                .benefits-description p {
                    font-size: 14px;
                    margin-bottom: 1rem;
                    text-align: justify;
                    color: #4b5563;
                }

                /* Headings */
                .benefits-description h1 {
                    font-size: 26px;
                    font-weight: 700;
                    margin: 1.5rem 0 1rem 0;
                    color: #1f2937;
                    padding-left: 1rem;
                    border-left: 5px solid transparent;
                    background: linear-gradient(90deg, #10b981 0%, #059669 100%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                    position: relative;
                }

                .benefits-description h1::before {
                    content: '';
                    position: absolute;
                    left: 0;
                    top: 0;
                    bottom: 0;
                    width: 5px;
                    background: linear-gradient(180deg, #10b981 0%, #059669 100%);
                    border-radius: 2px;
                }

                .benefits-description h2 {
                    font-size: 22px;
                    font-weight: 700;
                    margin: 1.5rem 0 1rem 0;
                    color: #1f2937;
                    padding-left: 1rem;
                    border-left: 4px solid transparent;
                    background: linear-gradient(90deg, #10b981 0%, #059669 100%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                    position: relative;
                }

                .benefits-description h2::before {
                    content: '';
                    position: absolute;
                    left: 0;
                    top: 0;
                    bottom: 0;
                    width: 4px;
                    background: linear-gradient(180deg, #10b981 0%, #059669 100%);
                    border-radius: 2px;
                }

                .benefits-description h3 {
                    font-size: 18px;
                    font-weight: 600;
                    margin: 1.25rem 0 0.75rem 0;
                    color: #1f2937;
                    padding-left: 0.75rem;
                    border-left: 3px solid #10b981;
                }

                .benefits-description h4 {
                    font-size: 16px;
                    font-weight: 600;
                    margin: 1rem 0 0.5rem 0;
                    color: #374151;
                    padding-left: 0.5rem;
                    border-left: 2px solid #34d399;
                }

                /* Lists */
                .benefits-description ul,
                .benefits-description ol {
                    margin: 1rem 0;
                    padding-left: 1.5rem;
                }

                .benefits-description ul li {
                    font-size: 14px;
                    margin-bottom: 0.5rem;
                    color: #4b5563;
                    position: relative;
                    padding-left: 1.5rem;
                    list-style: none;
                }

                .benefits-description ul li::before {
                    content: "▸";
                    position: absolute;
                    left: 0;
                    color: #10b981;
                    font-weight: bold;
                    font-size: 16px;
                }

                .benefits-description ol {
                    counter-reset: item;
                }

                .benefits-description ol li {
                    font-size: 14px;
                    margin-bottom: 0.5rem;
                    color: #4b5563;
                    position: relative;
                    padding-left: 2rem;
                    list-style: none;
                    counter-increment: item;
                }

                .benefits-description ol li::before {
                    content: counter(item);
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 24px;
                    height: 24px;
                    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                    color: white;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 12px;
                    font-weight: 600;
                }

                /* Blockquote */
                .benefits-description blockquote {
                    font-size: 14px;
                    padding: 1rem 1rem 1rem 3.5rem;
                    margin: 1.5rem 0;
                    background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
                    border-left: 4px solid #10b981;
                    border-radius: 0.5rem;
                    position: relative;
                    font-style: italic;
                    color: #065f46;
                }

                .benefits-description blockquote::before {
                    content: '"';
                    position: absolute;
                    left: 1rem;
                    top: 0.5rem;
                    font-size: 48px;
                    color: #10b981;
                    opacity: 0.3;
                    font-family: Georgia, serif;
                    line-height: 1;
                }

                /* Strong Text */
                .benefits-description strong {
                    font-weight: 600;
                    color: #1f2937;
                    background: linear-gradient(180deg, transparent 60%, #d1fae5 60%);
                    padding: 0 0.2em;
                }

                /* Emphasis */
                .benefits-description em {
                    font-style: italic;
                    color: #059669;
                }

                /* Links */
                .benefits-description a {
                    color: #10b981;
                    text-decoration: none;
                    font-weight: 500;
                    position: relative;
                    transition: color 0.2s;
                }

                .benefits-description a::after {
                    content: '';
                    position: absolute;
                    left: 0;
                    bottom: -2px;
                    width: 0;
                    height: 2px;
                    background: linear-gradient(90deg, #10b981 0%, #059669 100%);
                    transition: width 0.3s ease;
                }

                .benefits-description a:hover {
                    color: #059669;
                }

                .benefits-description a:hover::after {
                    width: 100%;
                }

                /* Code */
                .benefits-description code {
                    font-size: 13px;
                    padding: 0.2em 0.5em;
                    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
                    border: 1px solid #10b981;
                    border-radius: 0.25rem;
                    font-family: 'Courier New', monospace;
                    color: #065f46;
                }

                .benefits-description pre {
                    background: #064e3b;
                    padding: 1rem;
                    border-radius: 0.5rem;
                    overflow-x: auto;
                    margin: 1rem 0;
                }

                .benefits-description pre code {
                    background: transparent;
                    border: none;
                    color: #a7f3d0;
                    padding: 0;
                }

                /* Images */
                .benefits-description img {
                    max-width: 100%;
                    height: auto;
                    border-radius: 0.5rem;
                    margin: 1.5rem auto;
                    display: block;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                    transition: transform 0.3s ease;
                }

                .benefits-description img:hover {
                    transform: scale(1.02);
                }

                /* Tables */
                .benefits-description table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 1.5rem 0;
                    font-size: 13px;
                    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                    border-radius: 0.5rem;
                    overflow: hidden;
                }

                .benefits-description table thead {
                    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                    color: white;
                }

                .benefits-description table th {
                    padding: 0.75rem;
                    text-align: left;
                    font-weight: 600;
                    font-size: 13px;
                }

                .benefits-description table td {
                    padding: 0.75rem;
                    border-bottom: 1px solid #e5e7eb;
                }

                .benefits-description table tbody tr:nth-child(even) {
                    background-color: #f0fdf4;
                }

                .benefits-description table tbody tr:hover {
                    background-color: #ecfdf5;
                }

                /* Horizontal Rule */
                .benefits-description hr {
                    border: none;
                    height: 2px;
                    background: linear-gradient(90deg, transparent 0%, #10b981 50%, transparent 100%);
                    margin: 2rem 0;
                }



                /* Requirements Description - Same styling as Event Description */
                .requirements-description {
                    font-family: 'Poppins', 'Inter', system-ui, -apple-system, sans-serif;
                    line-height: 1.8;
                    color: #374151;
                    font-size: 16px;

                }

                /* Paragraphs */
                .requirements-description p {
                    font-size: 14px;
                    margin-bottom: 1rem;
                    text-align: justify;
                    color: #4b5563;
                }

                /* Headings */
                .requirements-description h1 {
                    font-size: 26px;
                    font-weight: 700;
                    margin: 1.5rem 0 1rem 0;
                    color: #1f2937;
                    padding-left: 1rem;
                    border-left: 5px solid transparent;
                    background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                    position: relative;
                }

                .requirements-description h1::before {
                    content: '';
                    position: absolute;
                    left: 0;
                    top: 0;
                    bottom: 0;
                    width: 5px;
                    background: linear-gradient(180deg, #f59e0b 0%, #d97706 100%);
                    border-radius: 2px;
                }

                .requirements-description h2 {
                    font-size: 22px;
                    font-weight: 700;
                    margin: 1.5rem 0 1rem 0;
                    color: #1f2937;
                    padding-left: 1rem;
                    border-left: 4px solid transparent;
                    background: linear-gradient(90deg, #f59e0b 0%, #ea580c 100%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                    position: relative;
                }

                .requirements-description h2::before {
                    content: '';
                    position: absolute;
                    left: 0;
                    top: 0;
                    bottom: 0;
                    width: 4px;
                    background: linear-gradient(180deg, #f59e0b 0%, #ea580c 100%);
                    border-radius: 2px;
                }

                .requirements-description h3 {
                    font-size: 18px;
                    font-weight: 600;
                    margin: 1.25rem 0 0.75rem 0;
                    color: #1f2937;
                    padding-left: 0.75rem;
                    border-left: 3px solid #f59e0b;
                }

                .requirements-description h4 {
                    font-size: 16px;
                    font-weight: 600;
                    margin: 1rem 0 0.5rem 0;
                    color: #374151;
                    padding-left: 0.5rem;
                    border-left: 2px solid #fbbf24;
                }

                /* Lists */
                .requirements-description ul,
                .requirements-description ol {
                    margin: 1rem 0;
                    padding-left: 1.5rem;
                }

                .requirements-description ul li {
                    font-size: 16px;
                    margin-bottom: 0.5rem;
                    color: #4b5563;
                    position: relative;
                    padding-left: 1.5rem;
                    list-style: none;
                }

                .requirements-description ul li::before {
                    content: "▸";
                    position: absolute;
                    left: 0;
                    color: #f59e0b;
                    font-weight: bold;
                    font-size: 16px;
                }

                .requirements-description ol {
                    counter-reset: item;
                }

                .requirements-description ol li {
                    font-size: 14px;
                    margin-bottom: 0.5rem;
                    color: #4b5563;
                    position: relative;
                    padding-left: 2rem;
                    list-style: none;
                    counter-increment: item;
                }

                .requirements-description ol li::before {
                    content: counter(item);
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 24px;
                    height: 24px;
                    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
                    color: white;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 12px;
                    font-weight: 600;
                }

                /* Blockquote */
                .requirements-description blockquote {
                    font-size: 14px;
                    padding: 1rem 1rem 1rem 3.5rem;
                    margin: 1.5rem 0;
                    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
                    border-left: 4px solid #f59e0b;
                    border-radius: 0.5rem;
                    position: relative;
                    font-style: italic;
                    color: #92400e;
                }

                .requirements-description blockquote::before {
                    content: '"';
                    position: absolute;
                    left: 1rem;
                    top: 0.5rem;
                    font-size: 48px;
                    color: #f59e0b;
                    opacity: 0.3;
                    font-family: Georgia, serif;
                    line-height: 1;
                }

                /* Strong Text */
                .requirements-description strong {
                    font-weight: 600;
                    color: #1f2937;
                    background: linear-gradient(180deg, transparent 60%, #fef3c7 60%);
                    padding: 0 0.2em;
                }

                /* Emphasis */
                .requirements-description em {
                    font-style: italic;
                    color: #d97706;
                }

                /* Links */
                .requirements-description a {
                    color: #f59e0b;
                    text-decoration: none;
                    font-weight: 500;
                    position: relative;
                    transition: color 0.2s;
                }

                .requirements-description a::after {
                    content: '';
                    position: absolute;
                    left: 0;
                    bottom: -2px;
                    width: 0;
                    height: 2px;
                    background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%);
                    transition: width 0.3s ease;
                }

                .requirements-description a:hover {
                    color: #d97706;
                }

                .requirements-description a:hover::after {
                    width: 100%;
                }

                /* Code */
                .requirements-description code {
                    font-size: 13px;
                    padding: 0.2em 0.5em;
                    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
                    border: 1px solid #fbbf24;
                    border-radius: 0.25rem;
                    font-family: 'Courier New', monospace;
                    color: #92400e;
                }

                .requirements-description pre {
                    background: #451a03;
                    padding: 1rem;
                    border-radius: 0.5rem;
                    overflow-x: auto;
                    margin: 1rem 0;
                }

                .requirements-description pre code {
                    background: transparent;
                    border: none;
                    color: #fbbf24;
                    padding: 0;
                }

                /* Tables */
                .requirements-description table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 1.5rem 0;
                    font-size: 13px;
                    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                    border-radius: 0.5rem;
                    overflow: hidden;
                }

                .requirements-description table thead {
                    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
                    color: white;
                }

                .requirements-description table th {
                    padding: 0.75rem;
                    text-align: left;
                    font-weight: 600;
                    font-size: 13px;
                }

                .requirements-description table td {
                    padding: 0.75rem;
                    border-bottom: 1px solid #e5e7eb;
                }

                .requirements-description table tbody tr:nth-child(even) {
                    background-color: #fffbeb;
                }

                .requirements-description table tbody tr:hover {
                    background-color: #fef3c7;
                }

                /* Horizontal Rule */
                .requirements-description hr {
                    border: none;
                    height: 2px;
                    background: linear-gradient(90deg, transparent 0%, #f59e0b 50%, transparent 100%);
                    margin: 2rem 0;
                }
                </style>

                <!-- Benefits -->
                @if($event->benefits)
                    <div class="bg-white rounded-lg shadow-lg p-5 mb-5">
                        <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center">
                            <i class="fas fa-gift text-green-600 mr-2"></i> Yang Akan Anda Dapatkan
                        </h2>
                        <div class="benefits-description prose max-w-none text-gray-700">
                            {!! $event->benefits !!}
                        </div>
                    </div>
                @endif

                <!-- Requirements -->
                <div class="bg-white rounded-lg shadow-lg p-5 mb-5">
                    <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-clipboard-list text-orange-600 mr-2"></i> Persyaratan
                    </h2>
                    <div class="requirements-description prose max-w-none text-gray-700">
                        {!! $event->requirements !!}
                    </div>
                </div>

                <!-- Related Events -->
                @if($relatedEvents->count() > 0)
                    <div class="bg-white rounded-lg shadow-lg p-5 mb-5">
                        <h2 class="text-xl font-bold text-gray-900 mb-5 flex items-center">
                            <i class="fas fa-calendar-alt text-blue-600 mr-2"></i> Event Terkait
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($relatedEvents as $related)
                                <a href="{{ route('events.show', $related->slug) }}" class="block group">
                                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                                        <div class="h-28 bg-gray-200 relative">
                                            @if($related->image)
                                                <img src="{{ $related->image_url }}" 
                                                     alt="{{ $related->title }}" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                                                    <i class="fas fa-calendar text-white text-2xl"></i>
                                                </div>
                                            @endif
                                            @if($related->is_free)
                                                <span class="absolute top-1.5 right-1.5 bg-green-500 text-white text-xs px-1.5 py-0.5 rounded-full font-semibold">
                                                    GRATIS
                                                </span>
                                            @endif
                                        </div>
                                        <div class="p-2.5">
                                            <h3 class="font-semibold text-sm text-gray-900 group-hover:text-blue-600 line-clamp-2 mb-1.5">
                                                {{ $related->title }}
                                            </h3>
                                            <div class="flex items-center text-xs text-gray-600 gap-2">
                                                <span>
                                                    <i class="fas fa-calendar text-blue-500"></i>
                                                    {{ $related->start_date->format('d M Y') }}
                                                </span>
                                                <span>
                                                    <i class="fas fa-map-marker-alt text-red-500"></i>
                                                    {{ $related->city }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Reviews & Rating Section -->
                <div class="bg-white rounded-lg shadow-lg p-5 mb-5">
                    <h2 class="text-xl font-bold text-gray-900 mb-5 flex items-center">
                        <i class="fas fa-star text-yellow-500 mr-2"></i> Rating & Reviews
                    </h2>

                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-5">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                <p class="text-green-800 text-sm font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-5">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                                <p class="text-red-800 text-sm font-medium">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-5">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                                <div>
                                    <p class="text-red-800 text-sm font-semibold mb-2">Terdapat kesalahan:</p>
                                    <ul class="list-disc list-inside text-red-700 text-xs space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Rating Overview -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6 pb-6 border-b border-gray-200">
                        <!-- Average Rating -->
                        <div class="text-center">
                            <div class="text-5xl font-bold text-gray-900 mb-2">
                                {{ $event->rating > 0 ? number_format($event->rating, 1) : 'N/A' }}
                            </div>
                            <div class="flex justify-center mb-2">
                                @if($event->rating > 0)
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($event->rating))
                                            <i class="fas fa-star text-yellow-400 text-xl"></i>
                                        @elseif($i - 0.5 <= $event->rating)
                                            <i class="fas fa-star-half-alt text-yellow-400 text-xl"></i>
                                        @else
                                            <i class="far fa-star text-gray-300 text-xl"></i>
                                        @endif
                                    @endfor
                                @else
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="far fa-star text-gray-300 text-xl"></i>
                                    @endfor
                                @endif
                            </div>
                            <div class="text-sm text-gray-600">
                                {{ $event->total_reviews }} {{ $event->total_reviews == 1 ? 'review' : 'reviews' }}
                            </div>
                        </div>

                        <!-- Rating Distribution -->
                        <div class="md:col-span-2">
                            @foreach([5, 4, 3, 2, 1] as $star)
                                @php
                                    $distribution = collect($ratingDistribution)->firstWhere('rating', $star);
                                    $count = $distribution['count'] ?? 0;
                                    $percentage = $distribution['percentage'] ?? 0;
                                @endphp
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="flex items-center gap-1 min-w-[80px]">
                                        <span class="text-sm font-medium text-gray-700">{{ $star }}</span>
                                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                                    </div>
                                    <div class="flex-1 bg-gray-200 rounded-full h-2 overflow-hidden">
                                        <div class="bg-yellow-400 h-full transition-all duration-300" 
                                             style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-600 min-w-[60px] text-right">
                                        {{ $count }} ({{ number_format($percentage, 0) }}%)
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Write a Review Section (Only for verified participants) -->
                    @auth
                        @php
                            // Check if user has attended this event
                            $hasAttended = \App\Models\EventParticipant::where('event_hastana_id', $event->id)
                                ->where('user_id', auth()->id())
                                ->where('status', 'attended')
                                ->exists();
                            
                            // Check if user already reviewed
                            $hasReviewed = \App\Models\EventReview::where('event_hastana_id', $event->id)
                                ->where('user_id', auth()->id())
                                ->exists();
                            
                            // Get participant status for debugging
                            $participant = \App\Models\EventParticipant::where('event_hastana_id', $event->id)
                                ->where('user_id', auth()->id())
                                ->first();
                        @endphp

                        @if($hasAttended && !$hasReviewed)
                            <div class="bg-gradient-to-r from-blue-50 to-purple-50 border-2 border-blue-200 rounded-lg p-5 mb-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                                    <i class="fas fa-pen text-blue-600 mr-2"></i> Tulis Review Anda
                                </h3>
                                <p class="text-sm text-gray-600 mb-4">
                                    Anda telah mengikuti event ini. Bagikan pengalaman Anda untuk membantu peserta lainnya!
                                </p>

                                <form action="{{ route('events.review.store', $event->slug) }}" method="POST" id="reviewForm">
                                    @csrf
                                    
                                    <!-- Rating -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Rating <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex items-center gap-2">
                                            <div class="flex gap-1" id="starRating">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <button type="button" 
                                                            class="star-btn text-3xl text-gray-300 hover:text-yellow-400 transition focus:outline-none" 
                                                            data-rating="{{ $i }}">
                                                        <i class="far fa-star"></i>
                                                    </button>
                                                @endfor
                                            </div>
                                            <span id="ratingText" class="text-sm text-gray-600 ml-2"></span>
                                        </div>
                                        <input type="hidden" name="rating" id="ratingInput" required>
                                    </div>

                                    <!-- Review Title -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Judul Review <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" 
                                               name="title" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" 
                                               placeholder="Ringkasan pengalaman Anda..." 
                                               maxlength="100"
                                               required>
                                    </div>

                                    <!-- Review Content -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Review Anda <span class="text-red-500">*</span>
                                        </label>
                                        <textarea name="review" 
                                                  rows="4" 
                                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" 
                                                  placeholder="Ceritakan pengalaman Anda mengikuti event ini..."
                                                  required></textarea>
                                    </div>

                                    <!-- Pros & Cons -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="fas fa-plus-circle text-green-600"></i> Kelebihan (Opsional)
                                            </label>
                                            <textarea name="pros" 
                                                      rows="3" 
                                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm" 
                                                      placeholder="Apa yang Anda suka dari event ini?"></textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="fas fa-minus-circle text-red-600"></i> Kekurangan (Opsional)
                                            </label>
                                            <textarea name="cons" 
                                                      rows="3" 
                                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm" 
                                                      placeholder="Apa yang bisa diperbaiki?"></textarea>
                                        </div>
                                    </div>

                                    <!-- Would Recommend -->
                                    <div class="mb-4">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" 
                                                   name="would_recommend" 
                                                   value="1" 
                                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                            <span class="text-sm font-medium text-gray-700">
                                                <i class="fas fa-thumbs-up text-blue-600"></i> Saya merekomendasikan event ini
                                            </span>
                                        </label>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="flex items-center gap-3">
                                        <button type="submit" 
                                                class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2.5 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition duration-200 shadow-lg hover:shadow-xl text-sm">
                                            <i class="fas fa-paper-plane mr-2"></i> Submit Review
                                        </button>
                                        <button type="reset" 
                                                class="bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg font-semibold hover:bg-gray-300 transition duration-200 text-sm">
                                            <i class="fas fa-redo mr-2"></i> Reset
                                        </button>
                                    </div>
                                </form>

                                <script>
                                // Star Rating System
                                document.addEventListener('DOMContentLoaded', function() {
                                    const stars = document.querySelectorAll('.star-btn');
                                    const ratingInput = document.getElementById('ratingInput');
                                    const ratingText = document.getElementById('ratingText');
                                    let selectedRating = 0;

                                    const ratingLabels = {
                                        1: 'Sangat Buruk',
                                        2: 'Buruk',
                                        3: 'Cukup',
                                        4: 'Bagus',
                                        5: 'Sangat Bagus'
                                    };

                                    stars.forEach(star => {
                                        // Hover effect
                                        star.addEventListener('mouseenter', function() {
                                            const rating = parseInt(this.dataset.rating);
                                            updateStars(rating, false);
                                        });

                                        // Click to select
                                        star.addEventListener('click', function() {
                                            selectedRating = parseInt(this.dataset.rating);
                                            ratingInput.value = selectedRating;
                                            updateStars(selectedRating, true);
                                            ratingText.textContent = ratingLabels[selectedRating];
                                        });
                                    });

                                    // Reset stars on mouse leave
                                    document.getElementById('starRating').addEventListener('mouseleave', function() {
                                        updateStars(selectedRating, true);
                                    });

                                    function updateStars(rating, permanent) {
                                        stars.forEach((star, index) => {
                                            const starIcon = star.querySelector('i');
                                            if (index < rating) {
                                                starIcon.classList.remove('far', 'text-gray-300');
                                                starIcon.classList.add('fas', 'text-yellow-400');
                                            } else {
                                                starIcon.classList.remove('fas', 'text-yellow-400');
                                                starIcon.classList.add('far', 'text-gray-300');
                                            }
                                        });
                                    }
                                });
                                </script>
                            </div>
                        @elseif($hasReviewed)
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                                    <div>
                                        <p class="font-semibold text-green-900 text-sm">Terima kasih atas review Anda!</p>
                                        <p class="text-green-700 text-xs">Review Anda telah dikirim dan sedang menunggu persetujuan admin.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endauth

                    <!-- Reviews List -->
                    @if($reviews->count() > 0)
                        <div class="space-y-4">
                            @foreach($reviews as $review)
                                <div class="border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                                    <!-- Review Header -->
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-start gap-3">
                                            <!-- User Avatar -->
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                                {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2 mb-1">
                                                    <h4 class="font-semibold text-gray-900 text-sm">
                                                        {{ $review->user->name ?? 'Anonymous' }}
                                                    </h4>
                                                    @if($review->is_verified_participant)
                                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full font-semibold flex items-center gap-1">
                                                            <i class="fas fa-check-circle"></i> Verified
                                                        </span>
                                                    @endif
                                                    @if($review->is_featured)
                                                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-0.5 rounded-full font-semibold flex items-center gap-1">
                                                            <i class="fas fa-star"></i> Featured
                                                        </span>
                                                    @endif
                                                </div>
                                                <!-- Rating Stars -->
                                                <div class="flex items-center gap-2 mb-1">
                                                    <div class="flex">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $review->rating)
                                                                <i class="fas fa-star text-yellow-400 text-sm"></i>
                                                            @else
                                                                <i class="far fa-star text-gray-300 text-sm"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <span class="text-xs text-gray-500">
                                                        {{ $review->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Would Recommend Badge -->
                                        @if($review->would_recommend)
                                            <span class="bg-blue-50 text-blue-700 text-xs px-2 py-1 rounded-full font-medium flex items-center gap-1">
                                                <i class="fas fa-thumbs-up"></i> Recommended
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Review Title -->
                                    @if($review->title)
                                        <h5 class="font-semibold text-gray-900 mb-2 text-sm">{{ $review->title }}</h5>
                                    @endif

                                    <!-- Review Content -->
                                    <p class="text-gray-700 text-sm mb-3 leading-relaxed">
                                        {{ $review->review }}
                                    </p>

                                    <!-- Pros & Cons -->
                                    @if($review->pros || $review->cons)
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                                            @if($review->pros)
                                                <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                                    <div class="flex items-center gap-2 mb-2">
                                                        <i class="fas fa-plus-circle text-green-600"></i>
                                                        <span class="font-semibold text-green-900 text-xs">Pros</span>
                                                    </div>
                                                    <p class="text-green-800 text-xs">{{ $review->pros }}</p>
                                                </div>
                                            @endif
                                            @if($review->cons)
                                                <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                                    <div class="flex items-center gap-2 mb-2">
                                                        <i class="fas fa-minus-circle text-red-600"></i>
                                                        <span class="font-semibold text-red-900 text-xs">Cons</span>
                                                    </div>
                                                    <p class="text-red-800 text-xs">{{ $review->cons }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Review Actions -->
                                    <div class="flex items-center gap-4">
                                        <button onclick="markHelpful({{ $review->id }})" 
                                                class="text-gray-600 hover:text-blue-600 text-xs font-medium flex items-center gap-1 transition">
                                            <i class="far fa-thumbs-up"></i>
                                            <span>Helpful ({{ $review->helpful_count }})</span>
                                        </button>
                                        <button onclick="reportReview({{ $review->id }})" 
                                                class="text-gray-600 hover:text-red-600 text-xs font-medium flex items-center gap-1 transition">
                                            <i class="far fa-flag"></i>
                                            <span>Report</span>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($reviews->hasPages())
                            <div class="mt-6">
                                {{ $reviews->links() }}
                            </div>
                        @endif
                    @else
                        <!-- No Reviews -->
                        <div class="text-center py-8">
                            <i class="fas fa-comment-slash text-gray-300 text-5xl mb-3"></i>
                            <p class="text-gray-600 text-sm">Belum ada review untuk event ini.</p>
                            <p class="text-gray-500 text-xs mt-1">Jadilah yang pertama memberikan review!</p>
                        </div>
                    @endif
                </div>

                <script>
                function markHelpful(reviewId) {
                    // TODO: Implement AJAX call to mark review as helpful
                    alert('Thank you for your feedback!');
                }

                function reportReview(reviewId) {
                    if (confirm('Apakah Anda yakin ingin melaporkan review ini?')) {
                        // TODO: Implement AJAX call to report review
                        alert('Review berhasil dilaporkan. Tim kami akan meninjau laporan Anda.');
                    }
                }
                </script>
            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/3">
                <!-- Registration Card -->
                <div class="bg-white rounded-lg shadow-lg p-5 sticky top-24 mb-5">
                    <!-- Price -->
                    <div class="text-center mb-5">
                        @if($event->is_free)
                            <div class="text-3xl font-bold text-green-600 mb-1.5">
                                <i class="fas fa-gift"></i> GRATIS
                            </div>
                            <p class="text-gray-600 text-sm">Event ini gratis untuk semua peserta</p>
                        @else
                            <div class="text-3xl font-bold text-blue-600 mb-1.5">
                                Rp {{ number_format($event->price, 0, ',', '.') }}
                            </div>
                            <p class="text-gray-600 text-sm">Per peserta</p>
                        @endif
                    </div>

                    <!-- Capacity Progress -->
                    @if($event->max_participants || $event->quota)
                        <div class="mb-5">
                            <div class="flex justify-between text-xs text-gray-600 mb-1.5">
                                <span>Kapasitas Terisi</span>
                                <span class="font-semibold">{{ number_format($event->capacity_percentage, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-{{ $event->capacity_percentage >= 90 ? 'red' : ($event->capacity_percentage >= 70 ? 'yellow' : 'green') }}-500 h-full rounded-full transition-all duration-300" 
                                     style="width: {{ min($event->capacity_percentage, 100) }}%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $event->current_participants }} dari {{ $event->capacity }} peserta terdaftar
                            </p>
                        </div>
                    @endif

                    <!-- Register Button -->
                    @php
                        $isAlmostFull = $event->capacity_percentage >= 90;
                        $canRegister = $event->canRegister();
                        $isRegistered = false;
                        
                        // Check if user already registered
                        if (auth()->check()) {
                            $isRegistered = \App\Models\EventParticipant::where('event_hastana_id', $event->id)
                                ->where('user_id', auth()->id())
                                ->whereIn('status', ['pending', 'confirmed', 'attended'])
                                ->exists();
                        }
                    @endphp

                    @if($isRegistered)
                        <!-- Already Registered -->
                        <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-3">
                            <div class="flex items-center gap-2.5 text-green-800 mb-2.5">
                                <i class="fas fa-check-circle text-xl"></i>
                                <div>
                                    <p class="font-bold text-base">Anda Sudah Terdaftar!</p>
                                    <p class="text-xs">Lihat detail registrasi Anda di Event Saya</p>
                                </div>
                            </div>
                            <a href="{{ route('dashboard') }}" class="block w-full text-center bg-green-600 text-white py-2.5 rounded-lg font-semibold hover:bg-green-700 transition duration-200 text-sm">
                                <i class="fas fa-tachometer-alt mr-2"></i>
                                Lihat Dashboard Saya
                            </a>
                        </div>
                    @elseif($canRegister)
                        @if($isAlmostFull)
                            <!-- Almost Full Alert -->
                            <div class="bg-red-50 border border-red-200 rounded-lg p-2.5 mb-2.5 animate-pulse">
                                <div class="flex items-center gap-2 text-red-800 text-xs font-semibold">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span>Hanya {{ $event->remaining_quota }} slot tersisa! Buruan daftar!</span>
                                </div>
                            </div>
                        @endif

                        @auth
                            <!-- User logged in - can register -->
                            <a href="{{ route('events.register', $event->slug) }}" 
                               class="block w-full text-center bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-lg font-bold hover:from-blue-700 hover:to-blue-800 transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 mb-3 text-sm">
                                <i class="fas fa-user-plus mr-2"></i> 
                                @if($event->is_free)
                                    Daftar Gratis Sekarang
                                @else
                                    Daftar & Bayar - Rp {{ number_format($event->price, 0, ',', '.') }}
                                @endif
                            </a>
                        @else
                            <!-- User not logged in - show login prompt -->
                            <div class="mb-3">
                                <a href="{{ route('login') }}?redirect={{ urlencode(route('events.register', $event->slug)) }}" 
                                   class="block w-full text-center bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-lg font-bold hover:from-blue-700 hover:to-blue-800 transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-sm">
                                    <i class="fas fa-sign-in-alt mr-2"></i> Login untuk Mendaftar
                                </a>
                                <p class="text-center text-xs text-gray-600 mt-1.5">
                                    Belum punya akun? 
                                    <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-semibold">Daftar di sini</a>
                                </p>
                            </div>
                            
                            <!-- Info Alert -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-2.5 mb-3">
                                <div class="flex items-start gap-2 text-blue-800 text-xs">
                                    <i class="fas fa-info-circle mt-0.5"></i>
                                    <div>
                                        <span class="font-semibold">Login diperlukan</span>
                                        <span class="block mt-0.5">Anda harus login terlebih dahulu untuk mendaftar event ini.</span>
                                    </div>
                                </div>
                            </div>
                        @endauth

                        <!-- Registration Info (Only for logged in users) -->
                        @auth
                            {{-- <div class="bg-blue-50 border border-blue-200 rounded-lg p-2.5 mb-3">
                                <div class="flex items-start gap-2 text-blue-800 text-xs">
                                    <i class="fas fa-info-circle mt-0.5"></i>
                                    <div>
                                        <span class="font-semibold">Pendaftaran mudah & cepat!</span>
                                        <span class="block mt-0.5">✓ Konfirmasi instan ✓ E-ticket otomatis ✓ Reminder H-1</span>
                                    </div>
                                </div>
                            </div> --}}
                        @endauth
                    @elseif($event->is_full)
                        <!-- Sold Out -->
                        <button disabled class="w-full bg-red-500 text-white py-3 rounded-lg font-bold cursor-not-allowed opacity-75 mb-3 text-sm">
                            <i class="fas fa-times-circle mr-2"></i> SOLD OUT - Event Penuh
                        </button>
                        
                        <!-- Waiting List Option -->
                        <a href="mailto:{{ $event->contact_email ?? 'info@hastanaindonesia.or.id' }}?subject=Waiting List - {{ $event->title }}" 
                           class="block w-full text-center bg-gray-100 text-gray-700 py-2.5 rounded-lg font-semibold hover:bg-gray-200 transition duration-200 mb-3 text-sm">
                            <i class="fas fa-list-ul mr-2"></i> Gabung Waiting List
                        </a>
                    @elseif($event->is_past)
                        <!-- Event Already Passed -->
                        <button disabled class="w-full bg-gray-400 text-white py-3 rounded-lg font-bold cursor-not-allowed mb-3 text-sm">
                            <i class="fas fa-calendar-times mr-2"></i> Event Sudah Berakhir
                        </button>
                    @else
                        <!-- Inactive or Unpublished -->
                        <button disabled class="w-full bg-gray-400 text-white py-3 rounded-lg font-bold cursor-not-allowed mb-3 text-sm">
                            <i class="fas fa-ban mr-2"></i> Pendaftaran Ditutup
                        </button>
                    @endif

                    <!-- Share Button -->
                    <button onclick="shareEvent()" class="w-full bg-gray-100 text-gray-700 py-2.5 rounded-lg font-semibold hover:bg-gray-200 transition duration-200 text-sm">
                        <i class="fas fa-share-alt mr-2"></i> Bagikan Event
                    </button>
                </div>

                <script>
                function shareEvent() {
                    const eventUrl = window.location.href;
                    const eventTitle = "{{ $event->title }}";
                    
                    if (navigator.share) {
                        navigator.share({
                            title: eventTitle,
                            text: 'Yuk ikutan event ini!',
                            url: eventUrl
                        }).catch(err => console.log('Error sharing:', err));
                    } else {
                        // Fallback: Copy to clipboard
                        navigator.clipboard.writeText(eventUrl).then(() => {
                            alert('Link event berhasil dicopy! Bagikan ke teman-temanmu.');
                        }).catch(err => {
                            console.error('Failed to copy:', err);
                        });
                    }
                }
                </script>

                <!-- Event Details -->
                <div class="bg-white rounded-lg shadow-lg p-5 mb-5">
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Detail Event</h3>
                    
                    <div class="space-y-3">
                        <!-- Date & Time -->
                        <div class="flex items-start gap-2.5">
                            <i class="fas fa-calendar-alt text-blue-600 text-lg mt-1"></i>
                            <div>
                                <div class="font-semibold text-gray-900 text-sm">Tanggal & Waktu</div>
                                <div class="text-xs text-gray-600">
                                    {{ $event->start_date->format('l, d F Y') }}
                                    @if($event->start_date->format('Y-m-d') != $event->end_date->format('Y-m-d'))
                                        <br>s/d {{ $event->end_date->format('l, d F Y') }}
                                    @endif
                                </div>
                                @if($event->start_time)
                                    <div class="text-xs text-gray-600">
                                        {{ substr($event->start_time, 0, 5) }} - {{ substr($event->end_time, 0, 5) }} WIB
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="flex items-start gap-2.5">
                            <i class="fas fa-map-marker-alt text-red-600 text-lg mt-1"></i>
                            <div>
                                <div class="font-semibold text-gray-900 text-sm">Lokasi</div>
                                <div class="text-xs text-gray-600">
                                    {{ $event->location }}
                                    @if($event->venue)
                                        <br>{{ $event->venue }}
                                    @endif
                                    <br>{{ $event->city }}{{ $event->province ? ', ' . $event->province : '' }}
                                </div>
                            </div>
                        </div>

                        <!-- Organizer -->
                        @if($event->organizer_name)
                            <div class="flex items-start gap-2.5">
                                <i class="fas fa-building text-purple-600 text-lg mt-1"></i>
                                <div>
                                    <div class="font-semibold text-gray-900 text-sm">Penyelenggara</div>
                                    <div class="text-xs text-gray-600">{{ $event->organizer_name }}</div>
                                </div>
                            </div>
                        @endif

                        <!-- Contact -->
                        @if($event->contact_email || $event->contact_phone)
                            <div class="flex items-start gap-2.5">
                                <i class="fas fa-phone text-green-600 text-lg mt-1"></i>
                                <div>
                                    <div class="font-semibold text-gray-900 text-sm">Kontak</div>
                                    @if($event->contact_email)
                                        <div class="text-xs text-gray-600">
                                            <i class="fas fa-envelope"></i> {{ $event->contact_email }}
                                        </div>
                                    @endif
                                    @if($event->contact_phone)
                                        <div class="text-xs text-gray-600">
                                            <i class="fas fa-phone"></i> {{ $event->contact_phone }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tags -->
                @if($event->tags)
                    <div class="bg-white rounded-lg shadow-lg p-5">
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Tags</h3>
                        <div class="flex flex-wrap gap-1.5">
                            @php
                                $tags = is_string($event->tags) ? json_decode($event->tags, true) : $event->tags;
                            @endphp
                            @if(is_array($tags))
                                @foreach($tags as $tag)
                                    <span class="bg-blue-100 text-blue-800 px-2.5 py-1 rounded-full text-xs">
                                        #{{ $tag }}
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
