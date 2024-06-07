<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
    @include('includes.header')
</head>

<body class="h-screen bg-slate-100">
    <div class="h-full max-w-[800px] mx-auto p-4">
        <div class="flex flex-col">
            {{-- Welcome message & logout --}}
            <div class="w-full flex items-center gap-4">
                <h1 class="text-xl font-bold">Dashboard</h1>
                <h1 class="text-md ml-auto font-semibold">{{ $user->name }} ({{ $user->email }})</h1>
                <a href="logout"
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
                                    <button type="button" onclick="toggleActions('{{ $u->id }}')"
                                        class="text-slate-800 hover:bg-slate-300 p-2 focus:outline-none rounded-full transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                            <path
                                                d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3" />
                                        </svg>
                                    </button>

                                    {{-- Dropdown Actions --}}
                                    <div id="actionsDropdown-{{ $u->id }}"
                                        class="absolute z-10 -left-[72px] -top-8 w-20 bg-white border border-slate-200 rounded-md shadow-lg hidden">
                                        <a href="#"
                                            onclick="editUser('{{ $u->id }}', '{{ $u->name }}')"
                                            class="block px-4 py-2 text-sm text-slate-800 hover:bg-slate-200 transition">Edit</a>
                                        @auth
                                            <form id="deleteForm-{{ $u->id }}"
                                                action="{{ route('delete-user', $u->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    {{ auth()->check() && $u->id === auth()->id() ? 'disabled' : '' }}
                                                    class="{{ $u->id !== auth()->id() ? 'cursor-pointer' : 'cursor-not-allowed hover:bg-white text-red-300' }} block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100 transition">
                                                    Delete
                                                </button>
                                            </form>
                                        @endauth
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="editModal" class="bg-slate-800/25 backdrop-blur-sm fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white p-4 rounded-lg">
                <h2 class="text-lg font-semibold mb-2">Edit a user</h2>
                <form method="POST" id="editForm">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" id="editUserId" name="userId">
                    <div class="mb-4">
                        <label for="editUserName" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="editUserName" name="name" autocomplete="name"
                            class="p-2 mt-1 border focus:ring-slate-500 focus:border-slate-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">
                    </div>
                    <div class="flex justify-start">
                        <button type="button" onclick="cancelEditUser()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-300 hover:bg-gray-400 rounded-md mr-2 transition">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-slate-800 hover:bg-slate-700 rounded-md transition">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </div>

    <script>
        let openDropdownId = null;

        // Toggles the drop down action menu
        function toggleActions(userId) {
            const actionsDropdown = document.getElementById(`actionsDropdown-${userId}`);

            if (openDropdownId !== null && openDropdownId !== userId) {
                const openDropdown = document.getElementById(`actionsDropdown-${openDropdownId}`);
                openDropdown.classList.add('hidden');
            }

            actionsDropdown.classList.toggle('hidden');
            openDropdownId = openDropdownId === userId ? null : userId;
        }

        function editUser(userId, userName) {
            // Populate modal fields with user data
            document.getElementById('editUserId').value = userId;
            document.getElementById('editUserName').value = userName;

            // Update form action with the correct URL
            document.getElementById('editForm').action = `/users/${userId}`;

            // Hide actions dropdown
            const actionsDropdown = document.getElementById(`actionsDropdown-${userId}`);
            actionsDropdown.classList.add('hidden');

            // Show the modal
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('fixed', 'inset-0');

            // Focus on the name input field
            document.getElementById('editUserName').focus();
        }

        function cancelEditUser() {
            // Hide the modal
            document.getElementById('editModal').classList.remove('fixed', 'inset-0');
            document.getElementById('editModal').classList.add('hidden');
        }

        document.getElementById('editForm').addEventListener('submit', function(event) {
            event.preventDefault();

            // Get form data
            let formData = new FormData(event.target);

            // Send form data to the server via Fetch API
            fetch(event.target.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    cancelEditUser();
                    location.reload();
                    return response.json();
                })
                .then(data => {
                    // Handle success response
                    console.log(data);
                    // Close modal
                    cancelEditUser();
                    // You may reload the page or update the UI as needed
                })
                .catch(error => {
                    // Handle error
                    console.error('There was a problem with your fetch operation:', error);
                });
        });

        // Close actions dropdown when clicking outside of it
        const backdrop = document.getElementById('editModal');
        backdrop.addEventListener('click', (e) => {
            if (e.target.matches('div')) {
                backdrop.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
