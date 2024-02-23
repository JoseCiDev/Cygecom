@if (!App::isProduction())
    @php
        $stringFromFile = file('../.git/HEAD', FILE_USE_INCLUDE_PATH);
        $firstLine = $stringFromFile[0];
        $explodedString = explode('/', $firstLine, 3);
        $branchName = $explodedString[2];
    @endphp

    <div class="env" style="background-color: rgb(251, 52, 52); position: fixed; top: 80px; left: 0; width: 100%; z-index: 1;">
        <h3 style="text-align: center; margin: 0px; color: rgb(40, 40, 40); padding:2px">
            {{ App::environment() }}: {{ $branchName }}
        </h3>
    </div>
@endif
