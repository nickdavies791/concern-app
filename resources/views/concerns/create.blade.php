@extends('layouts.argon')

@section('content')
    <div class="row">
        <div class="col-xl-10 mx-auto">
            @component('partials.cards.card')
                @slot('title') Report a Concern @endslot
                @slot('body')
                    <div class="card-body">
                        @include('partials.errors.errors')
                        <form method="POST" action="{{ route('concerns.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Find a Student</label>
                                <student-select></student-select>
                            </div>
                            <div class="form-group">
                                <label>Observation or Disclosure</label>
                                <concern-type-select></concern-type-select>
                            </div>
                            <div class="form-group">
                                <label>Details</label>
                                <textarea required name="body" class="form-control" data-toggle="popover" data-trigger="focus" data-content="Provide full details regarding the concern and include any action taken." placeholder="Include the details of the concern"></textarea>
                            </div>
                            <div class="form-group">
                                @csrf
                                <label>Add Supporting Files</label>
                                <div style="font-size: 14px" class="custom-file form-control-alternative">
                                    <input name="files[]" type="file" multiple class="custom-file-input form-control form-control-alternative">
                                    <label class="custom-file-label border-0">Select</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date of Concern</label>
                                        <datetime required type="datetime" v-model="datetime" name="concern_date" input-id="concern_date" input-class="form-control" placeholder="Provide a date"></datetime>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Assign a tag</label>
                                        <tag-select></tag-select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <a href="#" class="text-primary" data-toggle="modal" data-target="#body-map">Include a Body Map</a>
                                <input type="hidden" id="url" name="image" value="">
                            </div>
                            <div class="form-group">
                                <label>Notify Group(s)</label>
                                <group-select></group-select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Please check all details before saving. The Safeguarding Team will be notified.">Save Concern</button>
                        </form>
                    </div>
                @endslot
            @endcomponent
        </div>
    </div>
@endsection
<script>
    import ConcernTypeSelect from "../../js/components/ConcernTypeSelect";
    export default {
        components: {ConcernTypeSelect}
    }
</script>