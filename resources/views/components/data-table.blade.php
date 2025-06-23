<div class="bg-white p-4 shadow rounded-lg">
    <h3 class="text-lg font-semibold mb-3">{{ $title }}</h3>
    <table class="w-full table-auto border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                @foreach($headers as $header)
                    <th class="border px-3 py-2 text-left text-sm font-medium text-gray-700">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>
