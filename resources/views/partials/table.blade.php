<table class="table table-hover table-bordered">
    <thead>
        <tr>
            @foreach ($thead as $th)
                <th>{{ $th }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @forelse ($departements as $departement)
            <tr>
                <td>{{ $departements->firstItem() + $loop->index }}</td>
                <td>
                    <img src="{{ $departement->logo }}" alt="Logo" style="max-width: 50px;">
                </td>
                <td>{{ $departement->name }}</td>
                <td>{!! $departement->status !!}</td>
                <td>
                    <a href="{{ route('company.departements.edit', [$company, $departement->slug]) }}" class="btn btn-sm btn-warning">
                        Edit
                    </a>
                    <button class="btn btn-sm btn-danger">Delete</button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">There's no departement</td>
            </tr>
        @endforelse
    </tbody>
</table>
