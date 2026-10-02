<div class="form-group">
    <label for="question" class="control-label col-lg-2">{{__('content.status')}}:</label>
    <div class="col-lg-9">
        <div class="checkbox checkbox-switchery switchery-sm">
            <label>
                <input  @if(isset($inputName)) name="{{$inputName}}" @else name="display" @endif type="checkbox" class="switchery" value="1" checked="checked">
            </label>
        </div>
    </div>
</div>