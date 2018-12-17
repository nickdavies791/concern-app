@if(session('alert.primary'))
    <div class="alert alert-animate alert-primary alert-dismissible fade show" role="alert">
        <span class="alert-inner--icon"><i class="ni ni-notification-70"></i></span>
        <span class="alert-inner--text">{{ $slot }}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif