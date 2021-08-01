<div class="card">
    <div class="card-body" id="card-note">
        <h4 class="mb-1 mt-1 text-uppercase bg-light p-1"><i class="fe-activity"></i>
            Activity
            <a href="javascript: void(0);" data-bs-toggle="" onclick="@if($logs->count() > 0) viewLogs({{ $logs->first()->user_id }}); @endif" data-bs-target="#logs-modal"><i class="mdi mdi-history"></i></a>
        </h4>
        @isset($logs)
        @endisset
        <div class="card mb-3" data-simplebar style="max-height: 400px;">
            @isset($logs)
            @foreach ($logs as $log)
            <div class="card border-success border mb-3">
                <div class="card-body" id="card-note-body">
                    <h6 class="card-title text-success">{{ $log->log_date }}</h6>
                    <p class="card-text">
                        Action | ID of resource
                        <h4 class="text-success">{{ $log->action }} | @if(!$log->element_id) All @else {{ $log->element_id }} @endif</h4>
                    </p>
                </div>
            </div>
            @endforeach
            @endisset
        </div>
    </div>
</div>
