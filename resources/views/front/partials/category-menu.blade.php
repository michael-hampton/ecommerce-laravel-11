<ul class="dropdown-menu">
    @foreach(\App\Models\Category::where('active', true)->orderBy('name', 'asc')->where('menu_status', true)->get() as $allCategory)
        <li><a class="dropdown-item" href="{{route('shop.index', ['categoryId' => $allCategory->id])}}">
                {{$allCategory->name}}
                @if($allCategory->subcategories->count() > 0)  &raquo; @endif
            </a>

            @if($allCategory->subcategories->count() > 0)
                <ul class="submenu dropdown-menu">
                    @foreach($allCategory->subcategories as $subcategory)
                        <li><a class="dropdown-item" href="{{route('shop.index', ['categoryId' => $subcategory->id])}}">
                                {{$subcategory->name}}
                                @if($subcategory->subcategories->count() > 0)  &raquo; @endif
                            </a>
                            @if($subcategory->subcategories->count() > 0)
                                <ul class="submenu dropdown-menu">
                                    @foreach($subcategory->subcategories as $grandparent)
                                        <li><a class="dropdown-item"
                                               href="{{route('shop.index', ['categoryId' => $grandparent->id])}}">{{$grandparent->name}}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>
