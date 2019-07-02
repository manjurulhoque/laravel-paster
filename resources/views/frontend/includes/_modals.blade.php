<!-- Embed Modal -->
<div class="modal" id="embedModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Embed Code</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <textarea class="form-control" id="embed_code"><iframe src="{{ route('paste.embed', $paste->slug) }}"
                                                                       style="border:none;width:100%;min-height:400px;"></iframe>
                </textarea>
                <span id="embed_response" class="text-success"></span>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success btn-sm" id="embed-clipboard" data-clipboard-target="#embed_code">Copy
                </button>
                <button class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Report Modal -->
<div class="modal" id="reportModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Report About the Paste</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="post" action="{{ route('paste.report', $paste->slug) }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $paste->id }}">
                    <label>Reason</label>
                    <textarea class="form-control" name="reason" placeholder="Enter your reason.."></textarea>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning btn-sm">Report</button>
                    <button class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>