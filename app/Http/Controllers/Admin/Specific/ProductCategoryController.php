<?php

namespace App\Http\Controllers\Admin\Specific;

use App\Http\Requests\Admin\Specific\ProductCategoryRequest;
use App\Models\Specific\ProductCategory;
use App\Models\Specific\TechnicalSpecification;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $items = [
            ["title" => 'مدیریت دسته بندی محصولات', "link" => route('admin.productCategory.index')]
        ];
        $data = [
            'items' => $items,
            'productCategories' => ProductCategory::count()
        ];
        return view('admin.specific.productcategory.index', $data);
    }

    public function show()
    {

    }

    public function create()
    {

        $items = [
            ["title" => 'مدیریت دسته بندی محصولات', "link" => route('admin.productCategory.index')],
            ["title" => 'افزودن دسته بندی محصول', "link" => route('admin.productCategory.create')],
        ];
        $data = [
            'items' => $items,
            'parentCategories' => ProductCategory::visible()->get()->whereIn('level', [1, 2])->sortBy('title'),
            'technicalSpecifications' => TechnicalSpecification::visible()->orderBy('title')->get()
        ];
        return view('admin.specific.productcategory.create', $data);
    }

    public function store(ProductCategoryRequest $request)
    {
        $productCategory = ProductCategory::create($request->all());
        if ($technicalSpecifications = $request->get('technical_specifications')) {
            $productCategory->technicalSpecifications()->attach($technicalSpecifications);
        }
        return back()->with('msg', __('messages.add_item'));
    }

    public function edit(ProductCategory $productCategory)
    {
        $items = [
            ["title" => 'مدیریت دسته بندی محصولات', "link" => route('admin.productCategory.index')],
            ["title" => 'ویرایش دسته بندی محصول', "link" => route('admin.productCategory.edit', $productCategory)],
        ];
        $data = [
            'items' => $items,
            'productCategory' => $productCategory,
            'parentCategories' => ProductCategory::visible()->where('id', '!=', $productCategory->id)->get()->whereIn('level', [1, 2])->sortBy('level'),
            'technicalSpecifications' => TechnicalSpecification::visible()->orderBy('title')->get(),
            'selectedTechnicalSpecifications' => $productCategory->technicalSpecifications()->get()->pluck('id')->toArray(),
            'edit' => true,
        ];
        return view('admin.specific.productcategory.edit', $data);
    }

    public function update(ProductCategoryRequest $request, ProductCategory $productCategory)
    {
        if ($parentId = $request->get('parent_id')) {
            if ($productCategory->children()->where('id', $parentId)->exists()) {
                return back()->with('err', 'شما نمی توانید یکی از بچه های این دسته بندی را بعنوان والد همین دسته بندی انتخاب کنید.');
            }
        }
        $productCategory->update($request->all());
        $technicalSpecifications = $request->get('technical_specifications') ?: [];
        $productCategory->technicalSpecifications()->sync($technicalSpecifications);
        return back()->with('msg', __('messages.add_item'));
    }

    public function destroy(Request $request, $productCategory)
    {
        $productCategories = ProductCategory::find($request->input('ids'));
        foreach ($productCategories as $index => $productCategory) {
            if (env('APP_SOFT_DELETES')) {
                $productCategory->delete();
            } else {
                $productCategory->forceDelete();
            }
        }
    }

    public function DataTable(Request $request)
    {
        $model = ProductCategory::query();
        return DataTables::eloquent($model)
            ->setRowAttr(['data-itemId' => '{{$id}}'])
            ->addColumn('sorting', function ($model) {
                return '<div class="sort_container"
                                data-model="' . get_class($model) . '"
                                data-database="mysql">
                            <a class="sort sort_handle_style1 ui-sortable-handle"><span class="hide">' . $model->position . '</span></a></div>';
            }, 0)
            ->addColumn('check', function ($model) {
                return '<label class="checkradio_style1 type2"><input type="checkbox" name="id[]" value="' . $model->id . '" data-select-row=""><span class="box"></span></label>';
            }, 1)
            ->editColumn('parent_id', function ($model) {
                return $model->parent_id ? "<label class='label label-success'>{$model->parent->title}</label>" : "<label class='label label-default'>ندارد</label>";
            }, 1)
            ->editColumn('display', function ($model) {
                return '<label class="checkradio_style2 switchery-sm"><input name="display" type="checkbox" class="js-switch switch_for_all"
                               data-id="' . $model->id . '"
                               data-model="' . get_class($model) . '"
                               data-database="mysql"
                               data-link="' . route('admin.switch.update', $model->id) . '"
                               value="1" ' . ($model->display == 1 ? 'checked="checked"' : '') . ' >
                            </label>';
            }, 1)
            ->editColumn('created_at', '{{ShowDate($created_at)}} <br> {{ShowTime($created_at)}}')
            ->editColumn('updated_at', '{{ShowDate($updated_at)}} <br> {{ShowTime($updated_at)}}')
            ->addColumn('edit', function ($model) {
                return '<a href="' . route('admin.productCategory.edit', $model->id) . '" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
