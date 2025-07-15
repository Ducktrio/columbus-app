<div class="toast-container position-static">

@if(session('error'))
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">


        <div class="toast show" role="alert">
            <div class="toast-header">
                <span class="d-inline-block bg-danger rounded me-2" style="width: 1rem; height: 1rem;"></span>

                <strong class="me-auto">Error</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body text-bg-danger">
                {{ session('error') }}
                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@elseif(session('success'))
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">


        <div class="toast show" role="alert">
            <div class="toast-header">
                <span class="d-inline-block bg-success rounded me-2" style="width: 1rem; height: 1rem;"></span>

                <strong class="me-auto">System Log</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('success') }}
            </div>
        </div>
    </div>
@elseif(session('info'))
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">


        <div class="toast show" role="alert">
            <div class="toast-header">
                <span class="d-inline-block bg-primary rounded me-2" style="width: 1rem; height: 1rem;"></span>

                <strong class="me-auto">System Log</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('info') }}
            </div>
        </div>
    </div>
@endif
</div>

<script>
    // Fade out and remove toast after 3 seconds
    document.addEventListener('DOMContentLoaded', function () {
        const toasts = document.querySelectorAll('.toast.show');
        toasts.forEach(function(toast) {
            setTimeout(function() {
                toast.style.transition = 'opacity 0.5s';
                toast.style.opacity = '0';
                setTimeout(function() {
                    toast.parentElement.style.display = 'none';
                }, 500); // Wait for fade out
            }, 3000); // 3 seconds
        });
    });
</script>
