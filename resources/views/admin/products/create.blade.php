<form method="POST" enctype="multipart/form-data"
      action="{{route('admin.products.store')}}">
    @csrf
    <input type="hidden" name="charge_featured" id="charge_featured" value="0">
    <div class="d-flex">
        <div class="card p-3 col-lg-6">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label for="inputAddress" class="form-label">Name</label>
                        <input class="form-control" type="text" placeholder="Enter product name" name="name"
                               tabindex="0"
                               value="{{old('name')}}" aria-required="true">
                        <div id="emailHelp" class="form-text">Do not exceed 100 characters when entering the product
                            name.
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="inputAddress" class="form-label">Slug</label>
                        <input class="form-control" type="text" placeholder="Enter product slug" name="slug"
                               tabindex="0"
                               value="{{old('slug')}}" aria-required="true">
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Category</label>
                        <select class="form-control" name="category_id" id="category_id">
                            <option value="">Choose category</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Subcategory</label>
                        <select class="form-control" id="subcategoryDropdown" name="subcategory_id">

                        </select>
                    </div>

                    <div class="col-12">
                        <label for="inputAddress" class="form-label">Brand</label>
                        <select class="" name="brand_id">
                            <option value="">Choose Brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="inputAddress" class="form-label">Short Description</label>
                        <textarea class="form-control" name="short_description" id="short_description">
                            {{old('short_description')}}
                        </textarea>
                        <div id="emailHelp" class="form-text">Do not exceed 100 characters when entering the product
                            name.
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="inputAddress" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description">
                            {{old('description')}}
                        </textarea>
                        <div id="emailHelp" class="form-text">Do not exceed 100 characters when entering the product
                            name.
                        </div>
                    </div>

                    <div class="accordion" id="accordionExample">
                        @foreach($pattributes as $pattribute)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#parent-{{$pattribute->id}}" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                        {{$pattribute->name}}
                                    </button>
                                </h2>
                                <div id="parent-{{$pattribute->id}}" class="accordion-collapse collapse"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        @foreach($pattribute->attributeValues as $attributeValue)
                                            <div class="form-check">
                                                <input class="form-check-input attribute-checkbox" type="checkbox"
                                                       value="{{$attributeValue->id}}"
                                                       name="attribute_values[{{$pattribute->id}}]"
                                                       id="{{$attributeValue->id}}">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    {{$attributeValue->name}}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        <div class="card p-3 ms-3 col-lg-6">
            <div class="card-body">
                <div class="row g-3">
                    <div>
                        <div class="body-title">Upload images <span class="tf-color-1">*</span></div>
                        <div class="upload-image flex-grow">
                            <div class="item" id="imgpreview" style="display:none">
                                <img src="{{asset('images/upload/upload-1.png')}}" class="effect8" alt="">
                            </div>
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                    <input type="file" id="myFile" name="image" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="body-title form-control">Upload Gallery Images</div>
                        <div class="upload-image mb-16">
                            <div id="galUpload" class="item up-load">
                                <label class="uploadfile" for="gFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="text-tiny">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                    <input type="file" id="gFile" name="images[]" accept="image/*" multiple>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Regular Price</label>
                        <input class="form-control" type="text" placeholder="Enter regular price" name="regular_price"
                               tabindex="0" value="{{old('regular_price')}}" aria-required="true">
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Sale Price</label>
                        <input class="form-control" type="text" placeholder="Enter sale price" name="sale_price"
                               tabindex="0" value="{{old('sale_price')}}" aria-required="true">
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">SKU</label>
                        <input class="form-control" type="text" placeholder="Enter SKU" name="SKU" tabindex="0"
                               value="{{old('SKU')}}" aria-required="true">
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Quantity</label>
                        <input class="form-control" type="text" placeholder="Enter quantity" name="quantity"
                               tabindex="0"
                               value="{{old('quantity')}}" aria-required="true">
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Stock</label>
                        <select class="form-control" name="stock_status">
                            <option value="instock">InStock</option>
                            <option value="outofstock">Out of Stock</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Featured</label>
                        <select class="form-control" name="featured" id="featured">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>

            </div>
        </div>

    </div>
</form>

<div class="modal fade" id="featuredModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Make this product a featured product</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to make this item featured? Making the item featured is a great
                    way to boost your sales on this product. It will feature on the home page and will have a higher
                    ranking in search results</p>
                <p>Making this item a featured product will cost you <span class="featured-price"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Confirm</button>
            </div>
        </div>
    </div>
</div>
<script>
    var inputs = []
    /*tinymce.init({
        selector: 'textarea#short_description'
    });*/
    $(function () {
        /*tinymce.init()({
            selector: '#short_description',
            setup: function (editor) {
                editor.on('Change', function () {
                    tinyMCE.triggerSave();
                    var sd_data = $('#short_description').val()
                    this.set('short_description', sd_data)
                })
            }
        });

        tinymce.init()({
            selector: '#description',
            setup: function (editor) {
                editor.on('Change', function (e) {
                    tinyMCE.triggerSave();
                    var sd_data = $('#description').val()
                    this.set('description', sd_data);
                })
            }
        });*/
        $("#myFile").on("change", function (e) {
            const photoInp = $("#myFile");
            const [file] = this.files;
            if (file) {
                $("#imgpreview img").attr('src', URL.createObjectURL(file));
                $("#imgpreview").show();
            }
        });
        $("#gFile").on("change", function (e) {
            $(".gitems").remove();
            const gFile = $("gFile");
            const gphotos = this.files;
            $.each(gphotos, function (key, val) {
                $("#galUpload").prepend(`<div class="item gitems"><img src="${URL.createObjectURL(val)}" alt=""></div>`);
            });
        });
        $("input[name='name']").on("change", function () {
            $("input[name='slug']").val(StringToSlug($(this).val()));
        });

        $('#category_id').on('change', function () {
            $.ajax({
                url: "{{ route('admin.products.getSubcategories') }}",
                type: 'POST',
                data: {categoryId: $(this).val(), _token: "{{ csrf_token() }}"},
                dataType: "json",
                success: function (data) {
                    // log response into console
                    if (data) {
                        var subcategoryDropdown = document.getElementById(('subcategoryDropdown'))
                        subcategoryDropdown.innerHTML = ''

                        // Create empty option
                        let option = document.createElement("option");
                        option.setAttribute('value', '');

                        let optionText = document.createTextNode('Select option');
                        option.appendChild(optionText);

                        subcategoryDropdown.appendChild(option);

                        for (let key in data) {
                            let option = document.createElement("option");
                            option.setAttribute('value', data[key]['id']);

                            let optionText = document.createTextNode(data[key]['name']);
                            option.appendChild(optionText);

                            subcategoryDropdown.appendChild(option);
                        }
                    }
                }
            });
        });

        $('#featured').on('change', function () {
            if ($(this).val() === '1') {
                $('#featuredModal').modal('show');
                var percentage = {{config('shop.featured_product_charge')}}
                    var
                total = ((percentage / 100) * $('[name="regular_price"]').val()).toFixed(2);
                $('.featured-price').html("{{config('shop.currency')}}" + total)
            }

        });

        $('#confirmDelete').on('click', function () {
            $('#charge_featured').val($('.featured-price').html().replace("{{config('shop.currency')}}", ''));
            $('#featuredModal').modal('hide');
        });
    });

    function StringToSlug(Text) {
        return Text.toLowerCase()
            .replace(/[^\w ]+/g, "")
            .replace(/ +/g, "-");
    }
</script>
