<body>
   <style>
      .nice-select.currency-manager {
         display: none !important;
      }

      #global-country.currency-manager {
         display: block !important;
      }
   </style>
   <div class="announcement-bar">
      <div class="announcement-slider">
         <p>Free Shipping on Orders Over $50!</p>
         <p>New Arrivals: Shop Now!</p>
         <p>Flash Sale: 50% Off Selected Items!</p>
      </div>
   </div>
   <header class="header" id="fixed-header">
      <div class="container-fluid">
         <div class="d-flex align-items-center justify-content-between">
            <div class="logo">
               <a href="/">
                  @if(!empty($footerData['settings']['Site.logo']))
                  <img src="{{ asset('uploads/settings/' . $footerData['settings']['Site.logo']) }}" alt="Site Logo">
                  @else
                  <img src="{{ asset('uploads/settings/default-logo.png') }}" alt="Default Logo">
                  @endif
               </a>
            </div>
            <nav class="navbar navbar-expand-lg">
               <button class="navbar-toggler" type="button" id="menuToggle">
                  <span class="icon-menu">☰</span>
                  <span class="icon-close">✕</span>
               </button>

               <div class="collapse navbar-collapse main_menu" id="navbarNav">
                  <ul class="navbar-nav ">
                     <li>
                        <a href="/" class="active">Home</a>
                     </li>
                     @foreach($all_categories as $all_categorie)
                     @php
                     $subcategories = $all_categorie->subcategories;
                     $showMegaMenu = $subcategories->count() > 4 && $subcategories->every(fn($sub) => $sub->subcategories->count() > 0);
                     @endphp
                     <li>
                        <a href="{{ getSmartCategoryUrl('category', $all_categorie) }}">
                           {{ $all_categorie->name }}
                           @if($subcategories->count() > 0)
                           <i class="fa fa-angle-down"></i>
                           @endif
                        </a>
                        @if($subcategories->count() > 0)
                        @if($showMegaMenu)
                        {{-- MEGA MENU --}}
                        <div class="full-page-mega-menu">
                           <div class="sub-menu mega-menu mega-menu-column-4">
                              @foreach($subcategories as $subcategory)
                              <div class="list-item {{ $subcategory->subcategories->count() > 0 ? 'has-children' : '' }}">
                                 <h4 class="title">
                                    <a href="{{ getSmartCategoryUrl('subcategory', $all_categorie, $subcategory) }}">
                                       <b>{{ $subcategory->name }}</b>
                                    </a>
                                 </h4>

                                 @if($subcategory->subcategories->count() > 0)
                                 <ul class="child-list">
                                    @foreach($subcategory->subcategories as $child)
                                    <li>
                                       <a href="{{ getSmartCategoryUrl('child', $all_categorie, $subcategory, $child) }}">
                                          {{ $child->name }}
                                       </a>
                                    </li>
                                    @endforeach
                                 </ul>
                                 @endif
                              </div>
                              @endforeach
                           </div>
                        </div>
                        @else
                     <li class="mega_menu_dropdown has_dropdown dropdown-mobile">
                      <a href="{{ getSmartCategoryUrl('category', $all_categorie) }}">
                           {{ $all_categorie->name }}
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                              <path d="M201.4 374.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 306.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z" />
                           </svg>
                        </a>

                        <ul class="sub-menu" tabindex="-1">
                           @foreach($subcategories as $subcategory)
                           <li class="menu-item-has-children" role="none" data-item-title="By Vibes">
                              <a href="{{ getSmartCategoryUrl('subcategory', $all_categorie, $subcategory) }}">
                                 {{ $subcategory->name }}
                              </a>
                              @if($subcategory->subcategories->count() > 0)
                              <ul class="sub-menu" role="menu">
                                 @foreach($subcategory->subcategories as $child)
                                 <li class="" role="none">
                                    <a href="{{ getSmartCategoryUrl('child', $all_categorie, $subcategory, $child) }}"
                                       style="text-decoration: none; color: #333; font-size: 14px; display: block;">
                                       {{ $child->name }}
                                    </a>
                                 </li>
                                 @endforeach

                              </ul>
                              @endif
                           </li>
                           @endforeach
                        </ul>

                     </li>
                     @endif
                     @endif
                     </li>
                     @endforeach

                  </ul>
               </div>
            </nav>
            <div class="right-icon">
               <ul>
                  <li>
                     <a data-bs-toggle="modal" data-bs-target="#Serch-box">
                        <svg
                           xmlns="http://www.w3.org/2000/svg"
                           version="1.1"
                           xmlns:xlink="http://www.w3.org/1999/xlink"
                           width="24"
                           height="24"
                           x="0"
                           y="0"
                           viewBox="0 0 612.01 612.01"
                           style="enable-background: new 0 0 512 512;"
                           xml:space="preserve"
                           class="">
                           <g>
                              <path
                                 d="M606.209 578.714 448.198 423.228C489.576 378.272 515 318.817 515 253.393 514.98 113.439 399.704 0 257.493 0S.006 113.439.006 253.393s115.276 253.393 257.487 253.393c61.445 0 117.801-21.253 162.068-56.586l158.624 156.099c7.729 7.614 20.277 7.614 28.006 0a19.291 19.291 0 0 0 .018-27.585zM257.493 467.8c-120.326 0-217.869-95.993-217.869-214.407S137.167 38.986 257.493 38.986c120.327 0 217.869 95.993 217.869 214.407S377.82 467.8 257.493 467.8z"
                                 fill="#757575"
                                 opacity="1"
                                 data-original="#000000"
                                 class=""></path>
                           </g>
                        </svg>
                     </a>
                  </li>
                  <li>
                     <a data-bs-toggle="modal" data-bs-target="#login">
                        <svg width="32" height="32" viewBox="0 0 32 32" stroke="black" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <circle cx="15.5" cy="10.5" r="4.75" stroke-width="1.5"></circle>
                           <path d="M5 27C5 23 7.86364 16 15.5 16C23.1364 16 26 23.3333 26 27" stroke-width="1.5"></path>
                        </svg>
                     </a>
                  </li>
                  <li>
                     <svg width="32" height="32" viewBox="0 0 32 32" fill="white" xmlns="http://www.w3.org/2000/svg">
                        <path
                           d="M16.0006 7.54098L15.4296 8.02724C15.5721 8.19458 15.7808 8.29098 16.0006 8.29098C16.2204 8.29098 16.4291 8.19458 16.5716 8.02724L16.0006 7.54098ZM14.2653 25.4323L13.7609 25.9873L13.7626 25.9888L14.2653 25.4323ZM16.0006 27L15.4978 27.5565C15.7842 27.8152 16.2201 27.8144 16.5055 27.5546L16.0006 27ZM17.7359 25.4203L17.2321 24.8647L17.231 24.8657L17.7359 25.4203ZM21.386 4.28979C19.0765 4.28979 16.8717 5.3612 15.4296 7.05473L16.5716 8.02724C17.7384 6.65711 19.5307 5.78979 21.386 5.78979V4.28979ZM16.5716 7.05473C15.1295 5.3612 12.9247 4.28979 10.6153 4.28979V5.78979C12.4705 5.78979 14.2629 6.65711 15.4296 8.02724L16.5716 7.05473ZM10.6153 4.28979C6.5151 4.28979 3.2832 7.5217 3.2832 11.6219H4.7832C4.7832 8.35012 7.34353 5.78979 10.6153 5.78979V4.28979ZM3.2832 11.6219C3.2832 14.1301 4.418 16.3475 6.25737 18.5978C8.08811 20.8376 10.6946 23.2008 13.7609 25.9873L14.7697 24.8772C11.6729 22.063 9.16329 19.7828 7.41876 17.6485C5.68287 15.5248 4.7832 13.6374 4.7832 11.6219H3.2832ZM13.7626 25.9888L15.4978 27.5565L16.5034 26.4435L14.7681 24.8758L13.7626 25.9888ZM16.5055 27.5546L18.2408 25.9749L17.231 24.8657L15.4957 26.4454L16.5055 27.5546ZM18.2397 25.9759C21.3062 23.1952 23.9128 20.835 25.7437 18.5965C27.5832 16.3475 28.718 14.1301 28.718 11.6219H27.218C27.218 13.6374 26.3184 15.5247 24.5826 17.6468C22.8383 19.7795 20.3288 22.0566 17.2321 24.8647L18.2397 25.9759ZM28.718 11.6219C28.718 7.5217 25.4861 4.28979 21.386 4.28979V5.78979C24.6577 5.78979 27.218 8.35012 27.218 11.6219H28.718Z"></path>
                     </svg>
                  </li>
                  <li class="icon-ran">
                     <a data-bs-toggle="modal" data-bs-target="#addtocatt">
                        <svg width="32" height="32" viewBox="0 0 32 32" stroke="none" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <path d="M7.1586 28L24.8414 28C26.006 28 26.9243 27.0089 26.8356 25.8477L25.625 10L6.375 10L5.16441 25.8477C5.07571 27.0089 5.994 28 7.1586 28Z" stroke-width="1.5" stroke-linejoin="round"></path>
                           <path d="M21 10C21 7.23858 20.1667 5 16 5C11.8333 5 11 7.23858 11 10" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <span class="center-main">0</span>
                     </a>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </header>

   <style>
      .menu-item-has-children>ul.sub-menu>li.has-children:hover>.child-list {
         display: block !important;
      }
   </style>