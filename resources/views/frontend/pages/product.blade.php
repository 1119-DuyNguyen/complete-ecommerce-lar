@php use App\Models\Product;
$currentParameter=request()->query();
$currentParameter['page']='';
@endphp
@extends('frontend.layouts.master')

@section('title')
    {{$settings->site_name}} || Product
@endsection
<style>
    ul.tree {
        padding-left: 1.5rem;
        list-style: none;
        /*background-color: #fff;*/
    }
    ul.tree li {
        position: relative;
    }
    ul.tree li:before {
        position: absolute;
        top: 0;
        left: -15px;
        display: block;
        width: 15px;
        height: 1em;
        content: "";
        border-bottom: 1px dotted #666;
        border-left: 1px dotted #666;
    }
    /* hide the vertical line on the first item */
    ul.tree > li:first-child:before {
        border-left: none;
    }
    ul.tree li:after {
        position: absolute;
        top: 1.1em;
        bottom: 1px;
        left: -15px;
        display: block;
        content: "";
        border-left: 1px dotted #666;
    }

    /* hide the lines on the last item */
    ul.tree li:last-child:after {
        display: none;
    }

    /* inserted via JS  */
    .js-toggle-icon {
        position: relative;
        z-index: 1;
        display: inline-block;
        width: 14px;
        margin-right: 2px;
        margin-left: -23px;
        line-height: 14px;
        text-align: center;
        cursor: pointer;
        background-color: #fff;
        border: 1px solid #666;
        border-radius: 2px;
    }

</style>
@section('content')



    <!--============================
        PRODUCT PAGE START
    ==============================-->
    <section id="wsus__product_page">
        <div class="container">
            <div class="row">
{{--                <div class="col-xl-12">--}}
{{--                    <div class="wsus__pro_page_bammer">--}}
{{--                        @if ($productpage_banner_section->banner_one->status == 1)--}}
{{--                            <a href="{{$productpage_banner_section->banner_one->banner_url}}">--}}
{{--                                <img class="img-gluid"--}}
{{--                                     src="{{asset($productpage_banner_section->banner_one->banner_image)}}" alt="">--}}
{{--                            </a>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="col-xl-4 col-lg-4" style="margin-top: 1.5rem;">
                    <div class="wsus__sidebar_filter ">
                        <p>filter</p>
                        <span class="wsus__filter_icon">
                            <i class="fas fa-minus" id="minus"></i>
                            <i class="fas fa-plus" id="plus"></i>
                        </span>
                    </div>
                    <div class="wsus__product_sidebar" id="sticky_sidebar">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                        Categories
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                     aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">

                                        <x-recursive-category-tree :categories="$categories" :keyChildList="['subCategories','childCategories']"></x-recursive-category-tree>
{{--                                        <ul>--}}
{{--                                            <li>--}}
{{--                                                <a href="{{route('product.index', array_merge($currentParameter,['category' => '']))}}"--}}
{{--                                                   style="{{ request()->input('category') == '' ?"color: #08C;":"" }}"--}}
{{--                                                >All</a>--}}
{{--                                            </li>--}}
{{--                                            @foreach ($categories as $category)--}}

{{--                                                <li>--}}
{{--                                                    <a href="{{route('product.index', array_merge($currentParameter,['category' => $category->slug]))}}"--}}
{{--                                                    style="{{ request()->input('category') == $category->slug ?"color: #08C;":"" }}"--}}
{{--                                                    >{{$category->name}}</a>--}}
{{--                                                </li>--}}
{{--                                            @endforeach--}}

{{--                                        </ul>--}}

                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" >
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                        Price
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse show"
                                     >
                                    <div class="accordion-body">
                                            <form method="get" action="{{route('product.index', array_merge($currentParameter,['range-min' => request()->input('range-min'),'range-max'=>request()->input('range-max')]))}}">
                                                <span>Min</span>
                                                <input class="text-center" type="number" name="range-min" min="0" style="width: 100%;"  value="{{request()->input('range-min')}}" required />
                                                <span>Max</span>
                                                <input class="text-center" type="number" name="range-max" min="0" style="width: 100%;" value="{{request()->input('range-max')}}" required/>
                                                <input type="hidden" name="category" value="{{$currentParameter['category'] ??""}}" >
                                                <input type="hidden" name="brand" value= "{{$currentParameter['brand'] ?? "" }}" >
                                                {{--                                                <input type="hidden" id="slider_range" name="range"--}}
{{--                                                       class="flat-slider"/>--}}
                                                <button type="submit" class="common_btn mt-3" onclick="">filter</button>
                                            </form>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree3">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree3" aria-expanded="false"
                                            aria-controls="collapseThree">
                                        brand
                                    </button>
                                </h2>
                                <div id="collapseThree3" class="accordion-collapse collapse show"
                                     aria-labelledby="headingThree3" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul>
                                            <li>
                                                <a href="{{route('product.index', array_merge($currentParameter,['brand' => '']))}}"
                                                   style="{{ request()->input('brand') == '' ?"color: #08C;":"" }}"
                                                >all</a>
                                            </li>


                                            @foreach ($brands  as $brand)

                                                <li>
                                                    <a href="{{route('product.index', array_merge($currentParameter,['brand' => $brand->slug]))}}"
                                                       style="{{ request()->input('brand') == $brand->slug ?"color: #08C;":"" }}"
                                                    >{{$brand->name}}</a>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8">
                    <div class="row">
{{--                        <div class="col-xl-12 d-none d-md-block mt-md-4 mt-lg-0">--}}
{{--                            <div class="wsus__product_topbar">--}}
{{--                                <div class="wsus__product_topbar_left">--}}
{{--                                    <div class="nav nav-pills" id="v-pills-tab" role="tablist"--}}
{{--                                         aria-orientation="vertical">--}}
{{--                                        <button--}}
{{--                                            class="nav-link  list-view active"--}}
{{--                                            data-id="grid" id="v-pills-home-tab" data-bs-toggle="pill"--}}
{{--                                            data-bs-target="#v-pills-home" type="button" role="tab"--}}
{{--                                            aria-controls="v-pills-home" aria-selected="true">--}}
{{--                                            <i class="fas fa-th"></i>--}}
{{--                                        </button>--}}
{{--                                        <button--}}
{{--                                            class="nav-link list-view "--}}
{{--                                            data-id="list" id="v-pills-profile-tab" data-bs-toggle="pill"--}}
{{--                                            data-bs-target="#v-pills-profile" type="button" role="tab"--}}
{{--                                            aria-controls="v-pills-profile" aria-selected="false">--}}
{{--                                            <i class="fas fa-list-ul"></i>--}}
{{--                                        </button>--}}
{{--                                    </div>--}}

{{--                                </div>--}}

{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="tab-content" id="v-pills-tabContent">
                            <div
                                class="tab-pane fade {{session()->has('product_list_style') && session()->get('product_list_style') == 'grid' ? 'show active' : ''}} {{!session()->has('product_list_style') ? 'show active' : ''}}"
                                id="v-pills-home" role="tabpanel"
                                aria-labelledby="v-pills-home-tab">
                                <div class="row">
                                    @foreach ($products as $product)
                                    <x-product :product="$product" class="col-xl-4 col-sm-6"></x-product>

                                    @endforeach


                                </div>
                            </div>
{{--                            <div--}}
{{--                                class="tab-pane fade {{session()->has('product_list_style') && session()->get('product_list_style') == 'list' ? 'show active' : ''}}"--}}
{{--                                id="v-pills-profile" role="tabpanel"--}}
{{--                                aria-labelledby="v-pills-profile-tab">--}}
{{--                                <div class="row">--}}
{{--                                    @foreach ($products as $product)--}}
{{--                                        <div class="col-xl-12">--}}
{{--                                            <div class="wsus__product_item wsus__list_view">--}}
{{--                                                @if(productType($product->product_type))--}}
{{--                                                <span class="wsus__new">{{productType($product->product_type)}}</span>--}}
{{--                                                @endif--}}
{{--                                                @if($product->checkDiscount())--}}
{{--                                                    <span class="wsus__minus">-{{calculateDiscountPercent($product->price, $product->offer_price)}}%</span>--}}
{{--                                                @endif--}}

{{--                                                <a class="wsus__pro_link"--}}
{{--                                                   href="{{route('product.show', $product->slug)}}">--}}
{{--                                                    <img src="{{asset($product->thumb_image)}}" alt="product"--}}
{{--                                                         class="img-fluid w-100 img_1"/>--}}

{{--                                                    <img src="--}}
{{--                                                @if(isset($product->productImageGalleries[0]->image))--}}
{{--                                                    {{asset($product->productImageGalleries[0]->image)}}--}}
{{--                                                @else--}}
{{--                                                    {{asset($product->thumb_image)}}--}}
{{--                                                @endif--}}
{{--                                                " alt="product" class="img-fluid w-100 img_2"/>--}}
{{--                                                </a>--}}
{{--                                                <div class="wsus__product_details">--}}
{{--                                                    <a class="wsus__category"--}}
{{--                                                       href="#">{{@$product->category->name}} </a>--}}
{{--                                                    <a class="wsus__pro_name"--}}
{{--                                                       href="{{route('product.show', $product->slug)}}">{{$product->name}}</a>--}}

{{--                                                    @if($product->checkDiscount())--}}
{{--                                                        <p class="wsus__price">{{$settings->currency_icon}}{{$product->offer_price}}--}}
{{--                                                            <del>{{$settings->currency_icon}}{{$product->price}}</del>--}}
{{--                                                        </p>--}}
{{--                                                    @else--}}
{{--                                                        <p class="wsus__price">{{$settings->currency_icon}}{{$product->price}}</p>--}}
{{--                                                    @endif--}}

{{--                                                    <p class="list_description">{{$product->short_description}}</p>--}}
{{--                                                    <ul class="wsus__single_pro_icon">--}}

{{--                                                        <form class="shopping-cart-form">--}}
{{--                                                            <input type="hidden" name="product_id"--}}
{{--                                                                   value="{{$product->id}}">--}}
{{--                                                            @foreach ($product->variants as $variant)--}}
{{--                                                                @if ($variant->status != 0)--}}
{{--                                                                    <select class="d-none" name="variants_items[]">--}}
{{--                                                                        @foreach ($variant->productVariantItems as $variantItem)--}}
{{--                                                                            @if ($variantItem->status != 0)--}}
{{--                                                                                <option--}}
{{--                                                                                    value="{{$variantItem->id}}" {{$variantItem->is_default == 1 ? 'selected' : ''}}>{{$variantItem->name}}--}}
{{--                                                                                    (${{$variantItem->price}})--}}
{{--                                                                                </option>--}}
{{--                                                                            @endif--}}
{{--                                                                        @endforeach--}}
{{--                                                                    </select>--}}
{{--                                                                @endif--}}
{{--                                                            @endforeach--}}
{{--                                                            <input class="" name="qty" type="hidden" min="1" max="100"--}}
{{--                                                                   value="1"/>--}}
{{--                                                        </form>--}}
{{--                                                        <li><a href="#"><i class="far fa-heart" ></i></a></li>--}}
{{--                                                    </ul>--}}

{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    @endforeach--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                    @if (count($products) === 0)
                        <div class="text-center mt-5">
                            <div class="card">
                                <div class="card-body">
                                    <h2>Product not found!</h2>
                                </div>
                            </div>
                        </div>
                        @push('scripts')
                            <script>
                                document.addEventListener("DOMContentLoaded", (event) => {
                                    var href = new URL(window.location.href);
                                    href.searchParams.set('page', '');
                                    history.pushState({},'',href);
                                });


                            </script>
                        @endpush

                    @endif
                </div>

                <div class="col-xl-12 text-center">
                    <div class="mt-5" style="display:flex; justify-content:center">
                        @if ($products->hasPages())
                            {{$products->withQueryString()->links()}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        PRODUCT PAGE END
    ==============================-->


@endsection

@push('scripts')
    <script>
        //js make tree
        $(function() {
            // Hide all lists except the outermost.
            $('ul.tree ul').hide();

            $('ul.tree li > ul').each(function(i) {
                var $subUl = $(this);
                var $parentLi = $subUl.parent('li');
                var $toggleIcon = '<i class="js-toggle-icon">+</i>';

                $parentLi.addClass('has-children');

                $parentLi.prepend( $toggleIcon ).find('.js-toggle-icon').on('click', function() {
                    $(this).text( $(this).text() == '+' ? '-' : '+' );
                    $subUl.slideToggle('fast');
                });
            });
        });

    </script>
@endpush
