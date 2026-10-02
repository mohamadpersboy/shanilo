
@foreach($productCategoryTechnicalSpecifications as $index=>$productCategoryTechnicalSpecification)
    <li class="frm_item w50 flex">
        {!! Form::text("technicalSpecificationValues[]",
        (isset($product)&& $technicalSpecification=$product->productCategoryTechnicalSpecifications->where('id',$productCategoryTechnicalSpecification->id)->first())?$technicalSpecification->pivot->value:null
        ,['class'=>'frm_input','placeholder'=>$productCategoryTechnicalSpecification->technicalSpecification->title]) !!}
       {!! Form::hidden("technicalSpecificationIds[]",$productCategoryTechnicalSpecification->id) !!}
        <div class="frm_title">{{$productCategoryTechnicalSpecification->technicalSpecification->title}}</div>
    </li>
@endforeach

