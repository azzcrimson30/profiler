@extends('layouts.dashboard')

@section('title', $category->name . ' - Files')

@section('content')
<div class="page-header flex-between-wrap">
    <div>
        <h1>{{ $category->name }}</h1>
        <p>{{ $category->description }}</p>
    </div>
    <form method="POST" action="{{ route('files.upload', $category->slug) }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" accept="*/*">
        <button class="btn btn-primary" type="submit">Upload</button>
    </form>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr><th>File</th><th>Owner</th><th>Size</th><th>Uploaded</th><th></th></tr>
        </thead>
        <tbody>
            @foreach($files as $f)
                <tr>
                    <td>{{ $f->original_name }}</td>
                    <td>{{ $f->user ? $f->user->name : 'System' }}</td>
                    <td>{{ $f->size ?? '' }}</td>
                    <td>{{ $f->created_at->diffForHumans() }}</td>
                    <td>
                        <a href="{{ route('files.download', $f) }}" class="btn btn-secondary btn-sm">Download</a>
                        @if(auth()->id() === $f->user_id || auth()->user()->isAdmin())
                            <form method="POST" action="{{ route('files.destroy', $f) }}" style="display:inline">@csrf @method('DELETE')<button class="btn btn-danger btn-sm">Delete</button></form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $files->links() }}
</div>

@endsection
