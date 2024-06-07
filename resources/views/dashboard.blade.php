<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    @include('includes.header')
</head>

<body class="h-screen bg-slate-100">
    <div class="h-full max-w-[800px] mx-auto p-4">
        <div class="flex flex-col">
            {{-- Welcome message & logout --}}
            <div class="w-full flex items-center gap-4">
                <h1 class="text-xl font-bold">Dashboard</h1>
                <h1 class="text-md ml-auto font-semibold">{{ $user->name }} ({{ $user->email }})</h1>
                <a href="#"
                    class="px-4 py-2 text-sm font-medium text-white bg-slate-800 hover:bg-slate-700 rounded-md transition">Logout</a>
            </div>
            {{-- Table --}}
            <div class="mt-4">
                <h2 class="text-start text-xl font-semibold mb-4 pl-2 border-l-4 border-l-slate-800">Registered Users
                </h2>
            </div>
            <div class="w-full overflow-auto ">
                <table class="z-20 h-full min-w-[600px] w-full shadow-md rounded-lg ">
                    <thead class=" bg-gray-800 text-white">
                        <tr>
                            <th class="text-start py-3 px-4 uppercase font-semibold text-sm">Name</th>
                            <th class="text-start py-3 px-4 uppercase font-semibold text-sm">Email</th>
                            <th class="text-start py-3 px-4 uppercase font-semibold text-sm">Created At</th>
                            <th class="text-start py-3 px-4 uppercase font-semibold text-sm">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-800">
                        @foreach ($users as $index => $u)
                            <tr
                                class="{{ $index % 2 == 0 ? 'bg-slate-200 hover:bg-slate-200/75' : 'bg-slate-300 hover:bg-slate-300/75' }} border-b cursor-pointer transition">
                                <td class="py-3 px-4">
                                    <span>{{ $u->name }}</span>
                                </td>
                                <td class="py-3 px-4">{{ $u->email }}</td>
                                <td class="py-3 px-4">{{ $u->created_at->format('Y-m-d') }}</td>

                                <td class="py-3 px-4 relative">
                                    <button type="button"
                                        class="text-slate-800 hover:bg-slate-300 p-2 focus:outline-none rounded-full transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                            <path
                                                d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
</body>

</html>
