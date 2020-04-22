<div class="container">
    @foreach ($users as $user)
        {{ $user->email }}
    @endforeach
</div>

{{ $users->withQueryString()->links() }}