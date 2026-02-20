@extends('layouts.guest')
@section('title', $design->title)

@section('content')

    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- LEFT CONTENT -->
            <div class="md:col-span-2">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">
                    {{ $design->title }}
                </h1>

                <p class="text-sm text-gray-500 mb-2">
                    <span class="font-semibold">Category:</span>
                    {{ $design->category?->name ?? 'Uncategorized' }}
                </p>

                <p class="text-gray-700 leading-relaxed mb-6">
                    {{ $design->description }}
                </p>

                <p class="text-lg font-semibold mb-6">
                    Price:
                    @if ($design->is_free)
                        <span class="text-green-600">Free</span>
                    @else
                        <span class="text-indigo-600">${{ number_format($design->price, 2) }}</span>
                    @endif
                </p>

                @if ($design->is_free)
                    <a href="{{ route('front.buy.design.download', $design->slug) }}" onclick="freeDownload(event)"
                        class="inline-flex items-center px-6 py-3 rounded-lg bg-green-600 text-white font-medium hover:bg-green-700 transition">
                        Free Download
                    </a>
                @else
                    <button onclick="openInquiryModal()"
                        class="inline-flex items-center px-6 py-3 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition">
                        Send Inquiry to Buy
                    </button>
                @endif
            </div>

            <!-- RIGHT IMAGE -->
            <div>
                <img src="{{ asset('storage/' . $design->preview_image) }}" alt="Preview"
                    class="w-full rounded-xl shadow-lg border">
            </div>

        </div>
    </div>

    <!-- INQUIRY MODAL -->
    <div id="inquiryModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

        <div class="bg-white w-full max-w-lg rounded-xl shadow-xl p-6 relative">

            <button onclick="closeInquiryModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                ✕
            </button>

            <h2 class="text-xl font-semibold mb-4">
                Send Inquiry for {{ $design->title }}
            </h2>

            <form action="{{ route('front.buy.design.inquiry') }}" method="POST" onsubmit="confirmInquiry(event)">
                @csrf
                <input type="hidden" name="design_id" value="{{ $design->id }}">

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Your Name</label>
                    <input type="text" name="name" required
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Your Email</label>
                    <input type="email" name="email" required
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-1">Message</label>
                    <textarea name="message" rows="4" required
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">Hi, I am interested in purchasing your design: {{ $design->title }}</textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeInquiryModal()"
                        class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                        Cancel
                    </button>

                    <button type="submit" class="px-6 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                        Send Inquiry
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script>
        function openInquiryModal() {
            document.getElementById('inquiryModal').classList.remove('hidden');
            document.getElementById('inquiryModal').classList.add('flex');
        }

        function closeInquiryModal() {
            document.getElementById('inquiryModal').classList.add('hidden');
            document.getElementById('inquiryModal').classList.remove('flex');
        }

        function confirmInquiry(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Send Inquiry?',
                text: 'This will notify the designer about your interest.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, send it'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
            });
        }

        function freeDownload(e) {
            e.preventDefault();
            const url = e.target.href;

            Swal.fire({
                icon: 'success',
                title: 'Download Started',
                text: 'Your free design is downloading now.'
            });

            window.location.href = url;
        }
    </script>

@endsection
