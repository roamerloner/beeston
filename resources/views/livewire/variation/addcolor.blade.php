<div>
    <div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Add Color Variation</h4>
            </div>
            <div class="card-body">
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                <form wire:submit.prevent="insert_color">
                    <div class="basic-form">
                        <div class="mb-3">
                            <label for="" class="form-label">Color Name</label>
                            <input type="text" class="form-control" wire:model="color_name" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Color Code</label>
                            <input type="color" class="" wire:model="color_code" placeholder="">
                        </div>
                        <div class="mb-3">
                        <button type="submit" class="btn btn-sm btn-info">Add Color Variation</button>
                        </div>
                    </div>
            </form>
            <div class="table-responsive">
                    <table class="table table-primary">
                        <thead>
                            <tr>
                                <th>Color</th>
                                <th>Color Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($colors as $color)
                                <tr>
                                    <td>{{ $color->color_name }}</td>
                                    <td>
                                        {{ $color->color_code }}
                                        <span class="badge" style="background: {{ $color->color_code }}"> &nbsp;</span>
                                    </td>
                                    <td>
                                        <button wire:click="delete_color({{ $color->id }})" class="btn btn-sm btn-danger">Delete</button>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
