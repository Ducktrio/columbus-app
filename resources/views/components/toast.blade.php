@if(session('success'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">


    <div class="toast show" role="alert">
        <div class="toast-header">
            <span class="d-inline-block bg-success rounded me-2" style="width: 1rem; height: 1rem;"></span>

            <strong class="me-auto"> System Log</strong>
            <small>seconds ago</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ session('success') }}
        </div>
    </div>
</div>
@endif
