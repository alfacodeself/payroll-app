<div class="card">
    <div class="card-header align-items-center">
        <h5 class="card-title">Edit Departement</h5>
    </div>
    <div class="card-body">
        <form action="{{ $url }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-2">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    name="name" value="{{ old('name', $name) }}" placeholder="Departement Name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-2">
                <label for="logo" class="form-label">Logo</label>
                <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo"
                    name="logo" accept="image/*" placeholder="Departement Logo">
                @error('logo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <small class="text-muted">Leave this field empty if you don't want to change the logo.</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-dark d-block w-100">Update Departement</button>
        </form>
    </div>
</div>
