@extends('front.layouts.app')
<style>
   .main-menu ul li a {
      color: #000;
   }

   .header-main.transparent-menu.sticky {
      background: rgb(218 189 164 / 48%);
   }

      .header-main.transparent-menu.sticky.is-sticky {
            background: #000000cc;
      }

   .sticky.is-sticky .main-menu ul li a {
      color: #fff;
   }

   .header-main.transparent-menu.sticky img.sticky-logo {
      display: none;
   }

   .header-main.transparent-menu.sticky.is-sticky img.sticky-logo {
      display: block;
   }

   .header-main.transparent-menu.sticky.is-sticky img.simple-logo {
      display: none;
   }
</style>
@section('content')
   <div class="latest-blog-area mt-100 pt-100 pb-90 pt-sm-58 pb-sm-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center pb-44">
                        <h2>blog</h2>
                    </div>
                </div>
            </div>
            <div class="row">
               @if($results->isNotEmpty())
                  @include('front.modules.blog.load-more-data', ['results' => $results])
               @else
                  <div class="noresults-row text-center">
                     <h6>No Blogs found.</h6>
                  </div>
               @endif
            </div>
        </div>
    </div>

@endsection
@push('scripts')
<script>
function fetchProducts() {
   let url = "{{ route('blog.blog') }}";
   $.ajax({
      url: url,
      type: 'GET',
      data: {
         ajax: 1,
      },
      success: function(res) {
         if (res.html) {
            $('#blog_list').html(res.html);
            totalCount = res.totalResults; // ✅ reset totalCount on filter
            offset = limit; // ✅ reset offset
         }
      },
      error: function(xhr) {
            console.log(xhr.responseText);
      }
   });
}

let offset = {{ $limit }};
let limit = {{ $limit }};
let totalCount = {{ $totalResults }};
let url   = "{{ route('blog.blog') }}";
let loading = false;

function onScrollHandler() {
   if (loading) return;
   if (offset >= totalCount) {
      window.removeEventListener('scroll', onScrollHandler);
      return;
   }
   let threshold = window.innerWidth <= 768 ? 1200 : 800;
   if (window.innerHeight + window.scrollY >= document.body.offsetHeight - threshold) {
      loadMore();
   }
}

window.addEventListener('scroll', onScrollHandler);
fetchProducts();
function loadMore() {
   loading = true;
   document.getElementById('loading').style.display = 'block';

   $.ajax({
      url: url,
      data: '&offset=' + offset + '&limit=' + limit + '&ajax=1',
      success: function (res) {
         if (!res.html || $.trim(res.html) === '') {
            window.removeEventListener('scroll', onScrollHandler);
            document.getElementById('loading').innerHTML = '<p>No more records</p>';
         } else {
            $('#blog_list').append(res.html);
            offset += limit;
            totalCount = res.totalResults; // ✅ update filtered count
            document.getElementById('loading').style.display = 'none';

            if (offset >= totalCount) {
               window.removeEventListener('scroll', onScrollHandler);
               document.getElementById('loading').innerHTML = '<p>No more records</p>';
            }
         }
      },
      error: function () {
         document.getElementById('loading').innerHTML = '<p>Error loading data</p>';
      },
      complete: function () {
         loading = false;
      }
   });
}
</script>
@endpush