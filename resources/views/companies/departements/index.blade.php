@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @include('partials.alert')
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Departements</h5>
                        <button class="btn btn-dark" onclick="create('{{ $company }}')">
                            Create Departement
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Logo</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
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
                                            <td>
                                                @if ($departement->status->value == 'active')
                                                    <span
                                                        class="badge bg-success text-uppercase py-2">{{ $departement->status }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-danger text-uppercase py-2">{{ $departement->status }}</span>
                                                @endif
                                            </td>
                                            <td class="d-flex justify-content-arround">
                                                <button class="btn btn-sm btn-warning mx-1"
                                                    onclick="edit('{{ $company }}', '{{ $departement->slug }}')">
                                                    Edit
                                                </button>
                                                <a class="btn btn-sm btn-info mx-1"
                                                    href="{{ route('company.departements.show', [$company, $departement->slug]) }}">
                                                    Detail
                                                </a>
                                                <form
                                                    action="{{ route('company.departements.destroy', [$company, $departement->slug]) }}"
                                                    method="post" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        class="btn btn-sm btn-{{ $departement->status->value == 'active' ? 'danger' : 'success' }} mx-1"
                                                        type="submit">
                                                        {{ $departement->status->value == 'active' ? 'Deactivate' : 'Activate' }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">There's no departement</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    {{ $departements->onEachSide(3)->links() }}
                </div>
            </div>
            <div class="col-md-4" id="formSection">

            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function create(company) {
            let url = "{{ route('company.departements.create', ':company') }}";
            url = url.replace(':company', company);
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        let htmlContent = xhr.responseText;
                        document.getElementById('formSection').innerHTML = htmlContent;
                    } else {
                        console.error('There was a problem with the request:', xhr.statusText);
                    }
                }
            };
            xhr.open('GET', url, true);
            xhr.send();
        }

        function edit(company, departement) {
            let url = "{{ route('company.departements.edit', [':company', ':departement']) }}";
            url = url.replace(':company', company);
            url = url.replace(':departement', departement);
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        let htmlContent = xhr.responseText;
                        document.getElementById('formSection').innerHTML = htmlContent;
                    } else {
                        console.error('There was a problem with the request:', xhr.statusText);
                    }
                }
            };
            xhr.open('GET', url, true);
            xhr.send();
        }
    </script>
@endpush
