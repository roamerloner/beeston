<div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Add Size Variation</h4>
        </div>
        <div class="card-body">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            <form wire:submit.prevent="insert_size">
                <div class="basic-form">
                    <div class="mb-3">
                    <label for="" class="form-label">Size</label>
                    <input type="text" class="form-control" wire:model="size" placeholder="">
                    </div>
                    <div class="mb-3">
                    <button type="submit" class="btn btn-sm btn-info">Add Size Variation</button>
                    </div>
                </div>
        </form>
        <div class="table-responsive">
                <table class="table table-primary">
                    <thead>
                        <tr>
                            <th>Sizes</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sizes as $size)
                            <tr>
                                <td>{{ $size->size }}</td>
                                <td>
                                    <button wire:click="delete_size({{ $size->id }})" class="btn btn-sm btn-danger">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
