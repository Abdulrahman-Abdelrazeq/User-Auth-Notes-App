<x-app-layout>

<div class="container py-5">
    <h2>Edit Note: {{ $note->title }}</h2>
    <form method="POST" action="{{ route('notes.update', ['note' => $note]) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $note->title) }}" required>
        </div>

        <div class="form-group my-3">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content', $note->content) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Note</button>
    </form>
</div>

</x-app-layout>
