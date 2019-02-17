<!-- Header -->
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            @adminOrSafeguarding
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-3 col-lg-6">
                    @component('partials.cards.card-stats')
                        @slot('title') Resolved This Year @endslot
                        @slot('stats') {{ $countResolvedThisAcademicYear }} @endslot
                        @slot('color') danger @endslot
                        @slot('main_icon') ni ni-chart-bar-32 @endslot
                    @endcomponent
                </div>
                <div class="col-xl-3 col-lg-6">
                    @component('partials.cards.card-stats')
                        @slot('title') Resolved Last Month @endslot
                        @slot('stats') {{ $countResolvedLastMonth }} @endslot
                        @slot('color') warning @endslot
                        @slot('main_icon') ni ni-single-02 @endslot
                    @endcomponent
                </div>
                <div class="col-xl-3 col-lg-6">
                    @component('partials.cards.card-stats')
                        @slot('title') Reported This Year @endslot
                        @slot('stats') {{ $countReportedThisAcademicYear }} @endslot
                        @slot('color') yellow @endslot
                        @slot('main_icon') ni ni-chart-bar-32 @endslot
                    @endcomponent
                </div>
                <div class="col-xl-3 col-lg-6">
                    @component('partials.cards.card-stats')
                        @slot('title') Reported Last Month @endslot
                        @slot('stats') {{ $countReportedLastMonth }} @endslot
                        @slot('color') primary @endslot
                        @slot('main_icon') ni ni-single-02 @endslot
                    @endcomponent
                </div>
            </div>
            @endadminOrSafeguarding
        </div>
    </div>
</div>
