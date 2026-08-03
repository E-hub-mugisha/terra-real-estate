<x-app-layout>
    <div class="max-w-xl mx-auto py-8 text-center">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif

        <h1 class="text-2xl font-bold mb-4">{{ $shop->name }}</h1>

        <span @class([
            'px-3 py-1 rounded text-sm font-medium',
            'bg-yellow-100 text-yellow-800' => $shop->status === 'pending',
            'bg-green-100 text-green-800'   => $shop->status === 'approved',
            'bg-red-100 text-red-800'       => $shop->status === 'rejected',
            'bg-gray-200 text-gray-700'     => $shop->status === 'suspended',
        ])>
            {{ ucfirst($shop->status) }}
        </span>

        @if ($shop->status === 'rejected' && $shop->rejection_reason)
            <p class="mt-4 text-red-700">Reason: {{ $shop->rejection_reason }}</p>
        @endif

        @if ($shop->status === 'pending')
            <p class="mt-4 text-gray-600">Your shop is awaiting admin review.</p>
        @endif
    </div>
</x-app-layout>