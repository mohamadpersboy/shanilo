<?php

namespace App\Http\Controllers\Admin\Specific;

use App\Grid\Admin\ProductMessageGrid;
use App\Models\Base\User;
use App\Models\ProductMessage;
use App\Models\Specific\Product;
use App\Models\Specific\ProductCategory;
use App\Models\Specific\Shop;
use DataTables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SrkGrid\GridView\Grid;


class ProductController extends Controller
{
    public function index()
    {
        $items = [
            ["title" => 'مدیریت محصولات وبسایت', "link" => route('admin.product.index')]
        ];
        $data = [
            'items' => $items,
            'products' => Product::count(),
            'shops' => Shop::orderBy('title')->get(),
            'users' => User::where('role_id', '>', 2)->orderBy('name')->orderBy('family')->get(),
            'categories' => ProductCategory::orderBy('title')->get(),
        ];
        return view('admin.specific.product.index', $data);
    }

    public function edit(Product $product)
    {
        $grid = Grid::make(ProductMessageGrid::class, ProductMessage::query()->with('user'));
        $items = [
            ["title" => 'مدیریت محصولات وبسایت', "link" => route('admin.product.index')],
            ["title" => 'ویرایش وضعیت محصول', "link" => route('admin.product.edit', $product)],
        ];
        $data = [
            'items' => $items,
            'product' => $product,
            'edit' => true,
            'grid' => $grid
        ];
        return view('admin.specific.product.edit', $data);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->only('display'));
        return back()->with('msg', __('messages.edit_item'));
    }

    public function show(Product $product)
    {
        auth()->login($product->shop->user);
        return redirect()->route('front.profile.product.edit', $product);
    }

    public function destroy(Request $request, $product)
    {
        $products = Product::find($request->input('ids'));
        foreach ($products as $index => $product) {
            $product->delete();
        }
    }

    public function getProductDetails(Product $product)
    {
        $productDetails = $product->details;
        $data = [];
        foreach ($productDetails as $productDetail) {
            $data[] = [
                'title' => $productDetail->color->title,
                'value' => $productDetail->id,
            ];
        }
        return $data;
    }

    public function DataTable(Request $request)
    {
        $model = $this->setFilters();

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
            ->editColumn('shop_id', function ($model) {
                return $model->shop->title;
            }, 1)
            ->addColumn('image', function ($model) {
                return '<img src="' . $model->takeImage('main', '60/60') . '"/>';
            }, 1)
            ->addColumn('show', function ($model) {
                return '<a href="' . route('admin.product.edit', $model->id) . '" class="btn_style3 blue"><i class="i-edit"></i></a>';
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
                return '<a href="' . route('admin.product.edit', $model->id) . '" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->addColumn('show', function ($model) {
                return '<a target="_blank" href="' . route('admin.product.show', $model->id) . '" class="btn_style3 blue"><i class="icon-eye2"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }

    protected function setFilters()
    {
        $builder = Product::query();
        if ($title = \request('title')) {
            $builder->where('title', 'like', "%{$title}%");
        }
        if ($shop = \request('shop')) {
            $builder->where('shop_id', $shop);
        }
        if ($user = \request('user')) {
            $builder->whereHas('shop', function (Builder $builder) use ($user) {
                $builder->where('user_id', $user);
            });
        }
        if ($category = \request('category')) {
            $builder->whereHas('productCategories', function (Builder $builder) use ($category) {
                $builder->where('id', $category);
            });
        }
        if ($sellType = \request('sellType')) {
            $builder->whereHas('details', function (Builder $builder) use ($sellType) {
                $builder->whereHas($sellType);
            });
        }
        if (\request()->has('display') && \request('display') != "") {
            $builder->where('display', \request('display'));
        }

        $builder->orderBy('created_at', 'desc')->orderBy('display');
        return $builder;
    }
}
