<?php

namespace App\Http\Controllers\Front\Specific\Profile;

use App\Http\Controllers\Front\Base\ProfileController;
use App\Http\Requests\Front\Specific\ProductRequest;
use App\Models\Base\Attachment;
use App\Models\ProductMessage;
use App\Models\Specific\Brand;
use App\Models\Specific\Product;
use App\Models\Specific\ProductCategory;
use App\Models\Specific\ProductProperty;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Self_;
use SrkGrid\GridView\Grid;

class ProductController extends ProfileController
{
    const THUMBNAIL_SIZES = ['560/290', '270/150', '210/105', '100/100', '100/50', '70/65', '60/60'];
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # products
    # Handles product operations from user dashboard
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function index()
    {
        $products = \Auth::user()->products;
        if ($shop_id = request()->get('shop_id')) {
            $products->where('shop_id', $shop_id);
        }
        if ($inStock = request()->get('in_stock')) {
            if ($inStock == 'yes') {
                $products->whereHas('details')->whereDoesntHave('details', function (Builder $builder) {
                    $builder->where('count', '<=', 0);
                });
            } else {
                $products->whereHas('details', function (Builder $builder) {
                    $builder->where('count', '=', 0);
                });
            }
        }
        if ($title = \request()->get('title')) {
            $products->where('title', 'like', "%$title%");
        }
        $data = [
            'pageTitle' => 'پروفایل من | لیست محصولات',
            'user' => \Auth::user(),
            'activeMenu' => 'products',
            'products' => $products->latest()->paginate(PROFILE_PAGINATION_COUNT),
            'shops' => \Auth::user()->shops()->orderBy('title')->get(),
            'selectedTitle' => \request()->get('title'),
            'selectedInStock' => \request()->get('in_stock'),
            'selectedShopId' => \request()->get('shop_id')
        ];
        return view('front.pages.profile.product.index', $data);
    }

    public function create()
    {
        $data = [
            'pageTitle' => 'پروفایل من | ایجاد محصول',
            'user' => \Auth::user(),
            'activeMenu' => 'products',
            'shops' => \Auth::user()->shops()->orderBy('title')->get(),
            'brands' => Brand::visible()->orderBy('title')->get(),
            'firstLevelCategories' => ProductCategory::visible()->parents()->orderBy('title')->get()
        ];
        return view('front.pages.profile.product.create', $data);
    }

    /**
     * @param ProductRequest $request
     * @return array
     * @throws \Exception
     * @throws \Throwable
     */
    public function store(ProductRequest $request)
    {
        $request->merge(['display' => 0]);
        $product = \DB::transaction(function () use ($request) {
            //create product
            $product = Product::create($request->all());
            //set technical specifications and attach
            $this->syncTechnicalSpecifications($request, $product);
            //set categories and attach
            $this->syncCategories($request, $product);
            //set properties and save
            $this->addProperties($request, $product);
            //upload photo
            $product->createImage($request->file('pic'), 'main', $request->get('cropper'), self::THUMBNAIL_SIZES);
            return $product;
        });
        setSession([
            'header' => 'ثبت محصول موفق',
            'type' => 'success',
            'message' => 'محصول با موفقیت ثبت گردید و پس از تایید مدیر وبسایت نمایش داده خواهد شد.'
        ], 'notification');
        return [
            'url' => route('front.profile.product.edit', $product)
        ];
    }

    public function edit(Product $product)
    {
        if (!canEditProduct($product)) {
            abort(404);
        }
        $data = [
            'pageTitle' => 'پروفایل من | ویرایش محصول',
            'user' => \Auth::user(),
            'activeMenu' => 'products',
            'product' => $product,
            'edit' => true,
            'brands' => Brand::visible()->orderBy('title')->get(),
            'shops' => \Auth::user()->shops()->orderBy('title')->get(),
            'firstLevelCategories' => ProductCategory::visible()->parents()->orderBy('title')->get(),
            'secondLevelCategories' => $product->productCategories()->visible()->get()->where('level', 1)->first()->children,
            'thirdLevelCategories' => $product->productCategories()->visible()->get()->where('level', 2)->first()->children,
            'productCategoriesList' => $product->productCategories()->pluck('id')->toArray(),
            'productMessages' => ProductMessage::query()->with(['user'])->latest('id')->where('product_id', '=', $product->id)->get()
        ];

        return view('front.pages.profile.product.edit', $data);

    }

    /**
     * @param ProductRequest $request
     * @param Product $product
     * @return array
     * @throws \Exception
     * @throws \Throwable
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product = \DB::transaction(function () use ($request, $product) {
            //update product
            $product->update($request->all());
            //sync technical specifications
            $this->syncTechnicalSpecifications($request, $product);
            //sync product categories
            $this->syncCategories($request, $product);
            //update properties
            $this->updateProperties($request, $product);
            //update photo
            if ($request->file('pic')) {
                $product->redirect = true;
                $product->updateImage($request->file('pic'), 'main', $request->get('cropper'), self::THUMBNAIL_SIZES);
            }
            return $product;
        });
        $data = [
            'header' => 'ویرایش محصول موفق',
            'type' => 'success',
            'message' => 'محصول با موفقیت ویرایش گردید.',
        ];
        if ($product->redirect) {
            setSession($data, 'notification');
            return [
                'url' => back()->getTargetUrl()
            ];
        } else {
            return $data;
        }
    }

    public function destroy(Product $product)
    {
        if (!canEditProduct($product)) {
            abort(404);
        }
        if (env('APP_SOFT_DELETES')) {
            $product->delete();
        } else {
            $product->forceDelete();
        }
        if (\Auth::user()->products->count()) {
            return [
                'deletedItem' => "#product-{$product->id}"
            ];
        } else {
            return [
                'url' => back()->getTargetUrl()
            ];
        }
    }

    public function uploadGalleryImage(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
            'product_sid' => 'required|check_hash:' . $request->get('product_id'),
            'pic' => 'required|mimes:jpeg,jpg,png,gif'
        ], [
            'product_sid.check_hash' => 'اطلاعات ارسال شده نامعتبر است.'
        ], [
            'product_id' => 'محصول'
        ]);
        $product = Product::find($request->get('product_id'));
        if (!canEditProduct($product)) {
            abort(401);
        }
        $galleryImage = \DB::transaction(function () use ($request, $product) {
            $galleryImage = $product->createImage($request->file('pic'), 'gallery', $request->get('cropper'), self::THUMBNAIL_SIZES);
            $product->update(['display' => 0]);
            return $galleryImage;
        });

        return [
            'view' => \View::make('front.partial.ajax.product-gallery-image', compact('product', 'galleryImage'))->render()
        ];
    }

    public function destroyGalleryImage(Product $product, Attachment $attachment)
    {
        if (!canEditProduct($product)) {
            abort(401);
        }
        $product->attachments()->where('id', $attachment->id)->delete();
        return [
            'deletedItem' => "#galleryImage-{$attachment->id}"
        ];
    }

    /**
     * @param $request
     * @param $product
     */
    protected function syncTechnicalSpecifications(Request $request, Product $product)
    {
        $technicalSpecificationIds = $request->get('technicalSpecificationIds') ?: [];
        $technicalSpecificationValues = $request->get('technicalSpecificationValues') ?: [];
        $technicalSpecifications = [];
        foreach ($technicalSpecificationIds as $index => $technicalSpecificationId) {
            if (!$technicalSpecificationValues[$index]) {
                continue;
            }
            $technicalSpecifications[$technicalSpecificationIds[$index]] = ['value' => $technicalSpecificationValues[$index]];
        }
        $product->productCategoryTechnicalSpecifications()->sync($technicalSpecifications);
    }

    protected function syncCategories(Request $request, Product $product)
    {
        $categories = [$request->get('category_1'), $request->get('category_2'), $request->get('category_3')];
        $product->productCategories()->sync($categories);
    }

    protected function addProperties(Request $request, Product $product)
    {
        $props = $request->get('properties') ?: [];
        $properties = [];
        foreach ($props as $prop) {
            if (!$prop) {
                continue;
            }
            $properties[] = new ProductProperty(['title' => $prop]);
        }
        $product->properties()->saveMany($properties);
    }

    protected function updateProperties(Request $request, Product $product)
    {
        $productProperties = $product->properties;
        foreach ($productProperties as $productProperty) {
            if ($request->has("property_{$productProperty->id}")) {
                $newPropertyValue = $request->get("property_{$productProperty->id}");
                if ($newPropertyValue) {
                    $productProperty->update(['title' => $newPropertyValue]);
                } else {
                    $productProperty->delete();
                    $product->redirect = true;
                }
            } else {
                $product->redirect = true;
                $productProperty->delete();
            }
        }
        if ($request->get('properties') && array_filter($request->get('properties'))) {
            $product->redirect = true;
            $this->addProperties($request, $product);
        }

    }
}
