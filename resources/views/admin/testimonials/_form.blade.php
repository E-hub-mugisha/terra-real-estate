@php
    $isEdit     = $t === '__edit__' || ($t instanceof \App\Models\Testimonial && $t->exists);
    $val        = fn(string $field, $default = '') => ($isEdit && $t instanceof \App\Models\Testimonial) ? old($field, $t->$field) : old($field, $default);
    $types      = \App\Models\Testimonial::transactionLabels();
    $statuses   = ['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'];
    $curRating  = ($isEdit && $t instanceof \App\Models\Testimonial) ? $t->rating : 5;
@endphp

<div class="form-grid">

    {{-- Name --}}
    <div class="form-group">
        <label class="form-label">Full name *</label>
        <input type="text" name="name" class="form-control"
               placeholder="e.g. Amina Mukamana"
               value="{{ $val('name') }}" required maxlength="100">
    </div>

    {{-- Email --}}
    <div class="form-group">
        <label class="form-label">Email (optional)</label>
        <input type="email" name="email" class="form-control"
               placeholder="client@email.com"
               value="{{ $val('email') }}" maxlength="150">
    </div>

    {{-- Location --}}
    <div class="form-group">
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-control"
               placeholder="e.g. Kicukiro, Kigali"
               value="{{ $val('location') }}" maxlength="100">
    </div>

    {{-- Transaction type --}}
    <div class="form-group">
        <label class="form-label">Transaction type *</label>
        <select name="transaction_type" class="form-control" required>
            <option value="">Select...</option>
            @foreach($types as $key => $label)
                <option value="{{ $key }}"
                    {{ $val('transaction_type') === $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Rating --}}
    <div class="form-group full">
        <label class="form-label">Rating *</label>
        <input type="hidden" name="rating" value="{{ $val('rating', 5) }}">
        <div class="star-picker">
            @for($i = 1; $i <= 5; $i++)
                <label class="star-picker-label"
                       data-val="{{ $i }}"
                       style="background:{{ $i <= $curRating ? '#e8a020' : '#d3d1c7' }}; display:block;">
                </label>
            @endfor
        </div>
        <div style="font-size:11px; color:#888780; margin-top:4px;">Click to set rating</div>
    </div>

    {{-- Review --}}
    <div class="form-group full">
        <label class="form-label">Review text *</label>
        <textarea name="review" class="form-control" required
                  minlength="10" maxlength="1000"
                  placeholder="Write the client's review...">{{ $val('review') }}</textarea>
        <div style="font-size:11px; color:#888780; margin-top:3px;">Min 10 characters, max 1000</div>
    </div>

    {{-- Status --}}
    <div class="form-group">
        <label class="form-label">Status *</label>
        <select name="status" class="form-control" required>
            @foreach($statuses as $key => $label)
                <option value="{{ $key }}"
                    {{ $val('status', 'approved') === $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Featured --}}
    <div class="form-group" style="justify-content:flex-end; padding-bottom:4px;">
        <label class="form-check">
            <input type="checkbox" name="featured" value="1"
                   {{ ($isEdit && $t instanceof \App\Models\Testimonial && $t->featured) ? 'checked' : '' }}>
            Mark as featured (shown first on homepage)
        </label>
    </div>

    {{-- Admin note --}}
    <div class="form-group full">
        <label class="form-label">Admin note (internal only)</label>
        <input type="text" name="admin_note" class="form-control"
               placeholder="Optional internal note..."
               value="{{ $val('admin_note') }}" maxlength="500">
    </div>

</div>
