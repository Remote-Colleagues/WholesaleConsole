<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<nav class="navbar navbar-expand navbar-light bg-blue topbar mb-3 static-top shadow " style="background-color: #5271FF; ">
    <div class="container-fluid">
        <div class="d-flex flex-column align-items-start">
            <!-- Primary Header -->
            <span class=" font-weight-bold ml-4" style="color: #5271FF">
                    Wc Admin >
                @yield('headerTitle', 'Dashboard')
            </span>

            @isset($secondaryHeader)
                <div class="mt-1">
                    @foreach ($secondaryHeader as $title => $link)
                        <a href="{{ $link }}" class="btn btn-outline-light text-white text-decoration-none py-1 px-3" style="border-radius: 50px; display: inline-block;">
                            {{ $title }}
                            <span>&#9654;</span>
                        </a>

                        @if (!$loop->last)
                            <span class="text-white mx-0"></span>
                        @endif
                    @endforeach
                </div>
            @endisset
        </div>

        <!-- Right Side (Third and Fourth Headers) -->
        <div class="d-flex flex-column align-items-end">
            @isset($thirdHeader)
                <div class="mt-0">
                    @foreach ($thirdHeader as $title => $link)
                        <a href="{{ $link }}" class="text-decoration-none" style="color: #00E1A1">
                            {{ $title }}
                        </a>
                        @if (!$loop->last)
                            <span class="text-white mx-2"></span>
                        @endif
                    @endforeach
                </div>
            @endisset

            @isset($fourthHeader)
                <div class="mt-0">
                    @foreach ($fourthHeader as $title => $link)
                        <a href="{{ $link }}" class="text-decoration-none"  style="color: #00E1A1">
                            {{ $title }}{{ is_numeric($link) ? ': ' . $link : '' }}
                        </a>
                        @if (!$loop->last)
                            <span class="text-white mx-2" ></span>
                        @endif
                    @endforeach
                </div>
            @endisset
        </div>
    </div>
</nav>


<!-- Bootstrap JS & jQuery (important for dropdown functionality) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
