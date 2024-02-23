<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto toast-header-title"></strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body"></div>
    </div>
</div>

@if ($errors->any() || session('success'))
    @push('scripts')
        <script type="module">
            $(() => {
                const errors = @json($errors->all());
                const success = @json(session('success'));

                if (errors.length) {
                    $.fn.createToast(errors, 'Ops! Algo deu errado', 'bg-danger');
                }

                if (success) {
                    $.fn.createToast(success, 'Sucesso!', 'bg-success');
                }

            });
        </script>
    @endpush
@endif
