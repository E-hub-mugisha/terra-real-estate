<h2 class="text-2xl font-bold mb-6">
    Available Properties in {{ $district }}
</h2>

<h3 class="text-xl font-semibold mb-3">Houses</h3>

@forelse($houses as $house)
    <div class="border p-4 mb-4 rounded">
        <h4 class="font-bold">{{ $house->title }}</h4>
        <p>RWF {{ number_format($house->price) }}</p>
    </div>
@empty
    <p>No houses available.</p>
@endforelse


<h3 class="text-xl font-semibold mt-8 mb-3">Lands</h3>

@forelse($lands as $land)
    <div class="border p-4 mb-4 rounded">
        <h4 class="font-bold">{{ $land->title }}</h4>
        <p>RWF {{ number_format($land->price) }}</p>
    </div>
@empty
    <p>No land available.</p>
@endforelse
