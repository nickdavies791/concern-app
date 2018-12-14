@if ($errors->any())
    <div class="alert alert-secondary">
        <h5>You have errors</h5>
        <ul class="m-0 list-unstyled">
            @foreach ($errors->all() as $error)
                <li class="d-flex align-items-center mb-2">
                    <i class="fas fa-exclamation-circle text-danger mr-2"></i>
                    {{ $error }}
                </li>
            @endforeach
        </ul>
    </div>
@endif
