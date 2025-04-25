<div class="d-flex justify-content-between align-items-center mb-4">
    @if($category)
        <div class="col-lg-8">
            <div class="breadcrumb mb-0 d-none d-md-block">
                @if(!empty($category->parent->parent))
                    <a href="#"
                       class="menu-link menu-link_us-s text-uppercase fw-medium">{{$category->parent->parent->name}}</a>
                    <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                @endif
                @if(!empty($category->parent_id))
                    <a href="#"
                       class="menu-link menu-link_us-s text-uppercase fw-medium">{{$category->parent->name}}</a>
                    <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                @endif
                <a href="#"
                   class="menu-link menu-link_us-s text-uppercase fw-medium">{{$category->name}}</a>

            </div><!-- /.breadcrumb -->
            <div class="mt-1 mb-4 text-muted">{{$category->description}}</div>
        </div>
    @elseif(!empty($brand))
        <div class="col-lg-8">
            <h2>{{$brand->name}}</h2>
            <p>{{$brand->description}}</p>
        </div>
    @else
        <h4>Products</h4>
    @endif
    <div class="d-flex gap-2 align-items-center col-lg-4">
        Showing: <select class="form-control me-5 ms-2"
                         aria-label="Sort Items"
                         name="pagesize" id="pagesize">
            @foreach($showOptions as $showOption)
                <option value="{{$showOption}}"
                        @if($size === $showOption) selected="selected" @endif>{{$showOption}}
                    products
                </option>
            @endforeach

        </select>

        <select class="form-control ms-2"
                aria-label="Sort Items"
                name="total-number" id="total-number">
            <option selected>Default Sorting</option>
            @foreach($sortOptions as $sortOption)
                <option value="{{$sortOption['name']}}"
                        @if($orderBy === $sortOption['name']) selected="selected" @endif>{{$sortOption['name']}}</option>
            @endforeach
        </select>
    </div>
</div>
