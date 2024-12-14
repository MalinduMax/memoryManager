<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    @vite('resources/css/app.css')
</head>
<body class="h-full">
    <div class="min-h-full">

        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
              <h1 class="text-3xl font-bold tracking-tight text-gray-900">Memory Management System</h1>
            </div>
          </header>
          <main>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <div class="container">
                    <div class="block px-4 py-6 border border-gray-200 rounde-lg">
                    <form action="{{ route('welcome.allocate') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="size" class="font-bold">Process Size:</label>
                            <input type="number" name="size" class="form-control border-black size-50" required>
                        </div>
                        <button type="submit" class="mt-4 relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:active:bg-gray-700 dark:focus:border-blue-800">Allocate Memory</button>
                    </form>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <h2 class="py-4 text-xl font-bold tracking-tight text-gray-900">Memory Blocks</h2>
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3">ID</th>
                                <th class="px-6 py-3">Size</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Allocated To</th>
                                <th class="px-6 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($blocks as $block)
                                <tr>
                                    <td class="px-6 py-4">{{ $block->id }}</td>
                                    <td class="px-6 py-4">{{ $block->size }}</td>
                                    <td class="px-6 py-4">{{ $block->allocated ? 'Allocated' : 'Free' }}</td>
                                    <td class="px-6 py-4">{{ $block->allocated_to ?? 'N/A' }}</td>
                                    <td>
                                        @if ($block->allocated)
                                            <form action="{{ route('welcome.release', $block->id) }}" method="POST">
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
            </div>
          </main>
    </div>

</body>
</html>
