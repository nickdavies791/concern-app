<!-- Header -->
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-3 col-lg-6">
                    @component('partials.cards.card-stats')
                        @slot('title') Concerns Reported @endslot
                        @slot('stats') 175 @endslot
                        @slot('color') danger @endslot
                        @slot('main_icon') ni ni-chart-bar-32 @endslot
                        @slot('sub_icon') ni ni-bold-up @endslot
                        @slot('sub_icon_color') success @endslot
                        @slot('value') 10% @endslot
                        @slot('overview') Since last month @endslot
                    @endcomponent
                </div>
                <div class="col-xl-3 col-lg-6">
                    @component('partials.cards.card-stats')
                        @slot('title') Concerns in January @endslot
                        @slot('stats') 12 @endslot
                        @slot('color') warning @endslot
                        @slot('main_icon') ni ni-single-02 @endslot
                        @slot('sub_icon') ni ni-bold-down @endslot
                        @slot('sub_icon_color') warning @endslot
                        @slot('value') 1% @endslot
                        @slot('overview') Since last month @endslot
                    @endcomponent
                </div>
                <div class="col-xl-3 col-lg-6">
                    @component('partials.cards.card-stats')
                        @slot('title') Concerns Reported @endslot
                        @slot('stats') 175 @endslot
                        @slot('color') yellow @endslot
                        @slot('main_icon') ni ni-chart-bar-32 @endslot
                        @slot('sub_icon') ni ni-bold-up @endslot
                        @slot('sub_icon_color') success @endslot
                        @slot('value') 10% @endslot
                        @slot('overview') Since last month @endslot
                    @endcomponent
                </div>
                <div class="col-xl-3 col-lg-6">
                    @component('partials.cards.card-stats')
                        @slot('title') Concerns in January @endslot
                        @slot('stats') 12 @endslot
                        @slot('color') primary @endslot
                        @slot('main_icon') ni ni-single-02 @endslot
                        @slot('sub_icon') ni ni-bold-down @endslot
                        @slot('sub_icon_color') warning @endslot
                        @slot('value') 1% @endslot
                        @slot('overview') Since last month @endslot
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
</div>
