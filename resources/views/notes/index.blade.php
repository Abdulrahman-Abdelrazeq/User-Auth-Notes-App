<x-app-layout>

<div class="container py-5">
    <h2 class="mb-5">Notes</h2>
    @if (session('status'))
        <div class="alert alert-{{ session('status-color') }}">
            {{ session('status') }}
        </div>
    @endif
    <div class="mb-3">
        <a href="{{ route('notes.create') }}" class="btn btn-primary">Create Note</a>
    </div>
    <div class="card">
        <ul class="list-group list-group-flush">
            @foreach ($notes as $note)
                <li class="list-group-item p-4">
                    <a href="{{ route('notes.show', ['note' => $note]) }}">{{ $note->title }}</a>
                    <div class="float-right">
                        <a href="{{ route('notes.edit', ['note' => $note]) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('notes.destroy', ['note' => $note]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="mt-3">
        {{ $notes->links() }}
    </div>
</div>

</x-app-layout>
