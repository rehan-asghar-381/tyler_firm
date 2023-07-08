<!DOCTYPE html>
<html lang="en">
    @include('front.layout.header')
    <body>
        <div id="page_wrapper">
            @include('front.layout.navbar')
            <div class="full-row">
                <div class="container">
                    @yield('content')
                </div>
            </div>
            @include('front.layout.consultation')
            @include('front.layout.footer')
        </div>
        @include('front.layout.footer-script')
    </body>
</html>