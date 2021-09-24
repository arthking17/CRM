<div class="accordion custom-accordion" id="custom-accordion-logs-info">
    <div class="card mb-0">
        <div class="card-header" id="heading-logs-info">
            <h5 class="m-0 position-relative">
                <a class="custom-accordion-title text-reset d-block" data-bs-toggle="collapse"
                    href="#collapse-logs-info" aria-expanded="true" aria-controls="collapse-logs-info">
                    <h4 class="mb-1 mt-1 text-uppercase p-1"><i class="fe-activity"></i>Activity <i
                            class="mdi mdi-chevron-down accordion-arrow"></i></h4>
                </a>
            </h5>
        </div>

        <div id="collapse-logs-info" class="collapse show" aria-labelledby="headingFour"
            data-bs-parent="#custom-accordion-logs-info" data-simplebar style="max-height: 500px;">
            <div class="card-body">
                @if(isset($logs))
                    @if (count($logs) == 0)
                        <p class="text-center"> empty</p>
                    @endif
                    @foreach ($logs as $log)
                        <div class="card border-info border mb-3">
                            <div class="card-body" id="card-note-body">
                                <h6 class="card-title text-info">{{ $log->log_date }}</h6>
                                <p class="card-text">
                                    Action | ID of resource
                                <h4 class="text-info">{{ $log->action }} | @if (!$log->element_id) All @else {{ $log->element_id }} @endif
                                </h4>
                                </p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center">click on a row of users in the table to view the activity of the row user in that side.</p>
                @endif
            </div>
        </div>
    </div>
</div>
