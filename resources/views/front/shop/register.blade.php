<x-app-layout>
    <div class="max-w-2xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Register Your Shop</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('shops.register.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium">Shop Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block font-medium">Description</label>
                <textarea name="description" class="w-full border rounded p-2" rows="4">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Logo</label>
                    <input type="file" name="logo" accept="image/*" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-medium">Cover Image</label>
                    <input type="file" name="cover_image" accept="image/*" class="w-full border rounded p-2">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Phone *</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="07XXXXXXXX" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">WhatsApp Number *</label>
                    <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number') }}" placeholder="07XXXXXXXX" class="w-full border rounded p-2" required>
                </div>
            </div>

            <div>
                <label class="block font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded p-2">
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block font-medium">Province</label>
                    <input type="text" name="province" value="{{ old('province') }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-medium">District</label>
                    <input type="text" name="district" value="{{ old('district') }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-medium">Sector</label>
                    <input type="text" name="sector" value="{{ old('sector') }}" class="w-full border rounded p-2">
                </div>
            </div>

            <div>
                <label class="block font-medium">Address</label>
                <textarea name="address" class="w-full border rounded p-2" rows="2">{{ old('address') }}</textarea>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Submit for Approval
            </button>
        </form>
    </div>
</x-app-layout>