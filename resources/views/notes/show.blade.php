<x-app-layout>

<div class="container py-5 bg-light my-5 rounded-3">
    <h2 class="text-warning">Note: {{ $note->title }}</h2>
    <p><strong>Title:</strong> {{ $note->title }}</p>
    <p><strong>Content:</strong></p>
    <p>{{ $note->content }}</p>
    <div class="mt-3">
        <a href="{{ route('notes.edit', ['note' => $note]) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('notes.destroy', ['note' => $note]) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
        </form>
        <a href="{{ route('notes.index') }}" class="btn btn-secondary">Back to Notes</a>
    </div>
</div>

</x-app-layout>

