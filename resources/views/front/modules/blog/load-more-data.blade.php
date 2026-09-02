@forelse ($results as $bloge)          
   <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
      <div class="blog-item">
         <article class="blog-post">
               <div class="blog-post-content">
                  <div class="blog-thumb img-full">
                     <a href="{{ env('WEBSITE_URL').'blog-details/'.@$bloge->blog_slug }}">
                           <img src="{{ asset('uploads/banners/'.$bloge->media) }}" alt="{{ $bloge->title }}">
                     </a>
                  </div>
               </div>
               <div class="blog-content">
                  <h4><a href="{{ env('WEBSITE_URL').'blog-details/'.@$bloge->blog_slug }}">{{ $bloge->title }}</a></h4>
                  <p>
                  <?php echo  $bloge->short_description;  ?>
                  </p>
               </div>
         </article>
      </div>
   </div>
@empty
   <div class="col-12 text-center py-5">
      <i class="fa-solid fa-box-open" style="font-size: 48px; color: #ccc;"></i>
      <p class="mt-3 fs-5">Blog Not Found</p>
   </div>
@endforelse