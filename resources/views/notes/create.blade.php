<x-app-layout>

<div class="container py-5">
    <h2>Create Note</h2>
    <form method="POST" action="{{ route('notes.store') }}">
        @csrf

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Create Note</button>
    </form>
</div>

</x-app-layout>

