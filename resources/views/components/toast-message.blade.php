<div>
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Error!</h5>
                @foreach ($errors->all() as $error)
                    <li type="circle">{{ $error }}</li>
                @endforeach
        </div>
    @endif
    @if (session('success') || session('error'))
        <div class="alert alert-{{session('success') ? 'success' : 'danger'}} alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Alert!</h5>
            @if (session('success'))
                {!! session('success') !!}
            @else
                {!! session('error') !!}
            @endif
        </div>
    @endif
</div>