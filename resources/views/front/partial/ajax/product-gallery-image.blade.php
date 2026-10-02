<div id="galleryImage-{{$galleryImage->id}}" class="box" style="background-image: url('{{$product->takeImageWithName($galleryImage->file_name,'100/50')}}');">
    <div data-block="#galleryImage-{{$galleryImage->id}}" data-url="{{route('front.profile.product.gallery.destroy',[$product,$galleryImage])}}" class="dlt_btn btn-delete"><i class="i-cancel"></i></div>
</div>