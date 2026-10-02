<div class="filter_style2 flex">
    <input type="hidden" id="category" value="{{$selectedCategory?$selectedCategory->id:''}}">
    <input type="hidden" id="brand" value="{{$selectedBrand}}">
    <input type="hidden" id="limit" value="{{$limit}}">
    <div class="category_select">
        <div class="category_btn flex">
            <span class="icon"><i class="i-012-list"></i></span>
            <span class="text tooltip bottom">دسته بندی</span>
        </div>
        <div class="category_sub">
            <ul class="step no_bullet flex">
                @foreach($parentCategories as $index=>$parentCategory)
                    <li class="item {{in_array($parentCategory->id,$selectedCategories)?'active':''}}">
                        <a href="{{$parentCategory->path()}}" title="{{$parentCategory->title}}"
                           class="link flex pjax-link" data-no-query="true">
                            <span class="icon"><i class="{{$parentCategory->icon}}"></i></span>
                            <span class="text">{{$parentCategory->title}}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div><!-- category_select -->
    @if(count($selectedCategories))
        <div class="filtering_show">
            <div class="filter_selected">
                <ul class="step no_bullet flex">
                    @foreach($breadcrumbs as $index=>$breadcrumb)
                        <li class="item"><a href="{{$breadcrumb->path()}}"
                                            title="{{$breadcrumb->path()}}" class="link pjax-link"
                                            data-no-query="true">{{$breadcrumb->title}}</a></li>
                    @endforeach
                    @if(!hasBrand($breadcrumbs) && $filterItems->count())
                        <li class="item">
                            <div class="link active">...</div>
                        </li>
                    @endif
                </ul>
            </div>
            @if($filterItems->count())
                <div class="filter_choose">
                    <div class="title_part flex">
                        <div class="title">{{$filterLevel}}</div>
                        را انتخاب کنید:
                    </div>
                    <ul class="step no_bullet flex">
                        @foreach($filterItems->sortBy('position') as $index=>$filterItem)
                            <li class="item"><a href="{{$filterItem->path()}}" title=""
                                                class="link box_shadow_style1 pjax-link"
                                                data-no-query="true">{{$filterItem->title}}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div><!-- filtering_show -->
    @endif
</div><!-- filter_style2 -->