<div>
    <x-section class="max-w-5xl" title="Import Pilots">
        @include('forms.create-pilot')
    </x-section>

    <x-section class="max-w-5xl" title="Current Seniority List">
        <div class="grid grid-cols-4 gap-3">
            <div class="col-span-4">
                <x-table>
                    <x-slot:head>
                        <x-table.th>SEN#</x-table.th>
                        <x-table.th>EMP#</x-table.th>
                        <x-table.th>DOH</x-table.th>
                        <x-table.th>SEAT#</x-table.th>
                        <x-table.th>DOMICILE</x-table.th>
                        <x-table.th>FLEET</x-table.th>
                        <x-table.th>ACTIVE</x-table.th>
                        <x-table.th>RETIRE</x-table.th>
                        <x-table.th>MONTH</x-table.th>
                    </x-slot:head>
                    <x-slot:body>
                        @forelse ($pilots as $pilot)
                            <tr>
                                <x-table.td>{{ $pilot->seniority_number }}</x-table.td>
                                <x-table.td>{{ $pilot->employee_number }}</x-table.td>
                                <x-table.td>{{ Carbon\Carbon::parse($pilot->doh)->format('m/d/Y') }}</x-table.td>
                                <x-table.td>{{ $pilot->seat }}</x-table.td>
                                <x-table.td>{{ $pilot->domicile }}</x-table.td>
                                <x-table.td>{{ $pilot->fleet }}</x-table.td>
                                <x-table.td>{{ $pilot->active }}</x-table.td>
                                <x-table.td>{{ Carbon\Carbon::parse($pilot->retire)->format('m/d/Y') }}</x-table.td>
                                <x-table.td>{{ Carbon\Carbon::parse($pilot->month)->format('M Y') }}</x-table.td>
                            </tr>
                        @empty
                            <tr>
                                <x-table.td>EMPTY</x-table.td>
                            </tr>
                        @endforelse
                    </x-slot:body>
                </x-table>
                <div class="mt-4">{{ $pilots->links() }}</div>
            </div>
        </div>
    </x-section>
</div>