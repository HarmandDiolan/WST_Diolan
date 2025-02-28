@if(session()->has('confirmationMessage'))
    <div class="alert alert-{{ session('alertType', 'info') }} alert-dismissible fade show" role="alert">
        {{ session('confirmationMessage') }}
    </div>
@endif

<script>
    $(document).ready(function(){
        // Auto-dismiss the alert after 3 seconds (3000 milliseconds)
        setTimeout(function(){
            $('.alert').alert('close');
        }, 2000);
    });
</script>