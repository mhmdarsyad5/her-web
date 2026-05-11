@if (setting('favicon'))
<link rel="icon" href="{{ asset('storage/' . setting('favicon')) }}?v={{ time() }}" type="image/svg+xml">
@endif
