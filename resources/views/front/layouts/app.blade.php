<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!-- Include Head -->
@include('front.includes.head')
    
    <body>
        <div class="wrapper">
            @include('front.includes.header')
            
            @yield('content')
                
            <!-- </div> -->

            <!-- Include Footer -->
            @include('front.includes.footer')
            @include('front.includes.script')
        </div>
    </body>
</html>
