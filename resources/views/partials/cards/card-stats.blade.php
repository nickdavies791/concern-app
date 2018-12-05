<div class="card card-stats mb-4 mb-xl-0">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">{{ $title }}</h5>
                <span class="h2 font-weight-bold mb-0">{{ $stats }}</span>
            </div>
            <div class="col-auto">
                <div class="icon icon-shape bg-{{ $color }} text-white rounded-circle shadow">
                    <i class="{{ $main_icon }}"></i>
                </div>
            </div>
        </div>
        <p class="mt-3 mb-0 text-muted text-sm">
            <span class="text-{{ $sub_icon_color }} mr-2"><i class="{{ $sub_icon }}"></i> {{ $value }}</span>
            <span class="text-nowrap">{{ $overview }}</span>
        </p>
    </div>
</div>