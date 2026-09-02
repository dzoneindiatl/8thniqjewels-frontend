<div class="search_box_inner_box">
    <div class="search_box_inner_left">
        <h3>Populaer Category</h3><hr>
        <ul class="search_box_inner_list">
            @if($categorys)
                @foreach($categorys as $category)
                <li>
                    <a href="{{ route('category.show', $category->slug) }}">{{ $category->name }} 
                    <img class="hover_arro_sear" src="{{ $category->image ?? asset('assets/front/image/pro_img2.jpeg') }}" alt="img" style="width:50px;height:50px"></a>
                </li>
                @endforeach
            @endif
        </ul>
    </div>
    <div class="search_box_inner_right">
        <h3>Search Product</h3><hr>
        <div class="search_box_right_item">
            @if($products)
                @foreach($products as $product)
                <div class="search_box_right_item_inner">
                    <a href="{{ env('WEBSITE_URL') .'product/'. productSlug($product->name) . '.html/' . productSlug($product->sku) }}">
                        <div class="search_box_img">
                            <img src="{{ $product->images['first']  ?? asset('assets/front/image/pro_img2.jpeg') }}" alt="{{ @$product->name }}" style="width:200px;height:200px">
                        </div>
                        <span class="search_box_title">{{ @$product->name }}</span>
                        <span class="search_box_title">Price :<del>₹{{ @$product->buying_price }}</del> - ₹{{ @$product->selling_price }}</span>
                        <span class="search_box_title">Save : <b>₹{{ ($product->buying_price - $product->selling_price) }}</b></span>
                    </a>
                </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="text-center">
        <a class="learn-more" href="javascript:void(0);">View All <i class="fa fa-long-arrow-right"></i></a>
    </div>
</div>