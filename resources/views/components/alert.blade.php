
<div class="row">
    <div class="col-md-12">

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h5><strong>Algo deu errado! Revise os campos abaixo:</strong></h5>
                @foreach ($errors->all() as $error)
                    <ul>
                        <li> {{ $error }} <br> </li>
                    </ul>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ session('success') }}
            </div>
        @endif

    </div>
</div>

