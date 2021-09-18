<div class="row">

    <div class="col-lg-10">
        <div class="card">
            <div class="card-body">
                <div id="view-list-sip_accounts">
                    @include('sip_accounts.list')
                </div>
            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->

    <div class="col-lg-2" id="sip_accounts-info-card">
        @include('sip_accounts.info-tab')
    </div>
</div>
<!-- end row -->