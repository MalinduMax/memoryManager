<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MemoryManager</title>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <div class="container">
        <h1>Memory Management Simulation</h1>

        <form action="{{ route('memory.allocate') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="process_size">Process Size:</label>
                <input type="number" name="process_size" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Allocate Memory</button>
        </form>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <h2>Memory Blocks</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Size</th>
                    <th>Status</th>
                    <th>Allocated To</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($blocks as $block)
                    <tr>
                        <td>{{ $block->id }}</td>
                        <td>{{ $block->size }}</td>
                        <td>{{ $block->allocated ? 'Allocated' : 'Free' }}</td>
                        <td>{{ $block->allocated_to ?? 'N/A' }}</td>
                        <td>
                            @if ($block->allocated)
                                <form action="{{ route('memory.release', $block->id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-danger">Release</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endsection
</body>
</html>
