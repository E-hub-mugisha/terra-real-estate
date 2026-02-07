<form method="POST" action="{{ route('agents.store') }}" enctype="multipart/form-data">
    @csrf

    <input name="full_name" class="form-control" placeholder="Full name">
    <input name="email" type="email" class="form-control" placeholder="Email">
    <input name="phone" class="form-control" placeholder="Phone">

    <input name="role" class="form-control" placeholder="Role (e.g. Senior Agent)">
    <input name="years_experience" type="number" class="form-control" placeholder="Years of experience">
    <input name="rating" type="number" step="0.1" min="0" max="5" class="form-control" placeholder="Rating">

    <textarea name="bio" class="form-control" placeholder="Biography"></textarea>

    <input name="properties_count" type="number" class="form-control" placeholder="Properties handled">
    <input name="top_property" class="form-control" placeholder="Top property">

    <input name="linkedin" class="form-control" placeholder="LinkedIn URL">
    <input name="facebook" class="form-control" placeholder="Facebook URL">
    <input name="instagram" class="form-control" placeholder="Instagram URL">
    <input name="twitter" class="form-control" placeholder="Twitter URL">

    <input type="file" name="profile_image" class="form-control">

    <input name="whatsapp" class="form-control" placeholder="WhatsApp number">
    <input name="office_location" class="form-control" placeholder="Office location">
    <input name="languages" class="form-control" placeholder="English, Kinyarwanda">

    <button class="btn btn-primary w-100 mt-3">Create Agent</button>
</form>
