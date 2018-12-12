<div class="modal fade" id="body-map" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content" style="width: 900px;">

            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Body Map</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body pb-0">
                <!-- The area that will be used to draw -->
                <canvas id="canvas-bodymap" width="800" height="702"></canvas>
                <!-- The image drawn onto the canvas -->
                <img class="d-none" id="image-bodymap" src="{{ asset('images/body-map.png') }}" width="800" height="702">
            </div>

            <div class="modal-footer">
                <button id="clear" type="button" class="mx-auto btn btn-primary">Clear</button>
                <button id="save" type="button" class="mx-auto btn btn-primary" data-dismiss="modal">Save Body Map</button>
            </div>

        </div>
    </div>
</div>
