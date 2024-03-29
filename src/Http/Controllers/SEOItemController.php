<?php

namespace Corals\Utility\SEO\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Utility\SEO\DataTables\SEOItemsDataTable;
use Corals\Utility\SEO\Http\Requests\SEOItemsRequest;
use Corals\Utility\SEO\Models\SEOItem;
use Corals\Utility\SEO\Services\SEOItemService;

class SEOItemController extends BaseController
{
    protected $SEOItemService;

    public function __construct(SEOItemService $SEOItemService)
    {
        $this->SEOItemService = $SEOItemService;

        $this->resource_url = config('utility-seo.models.seo_item.resource_url');

        $this->resource_model = new SEOItem();

        $this->title = 'utility-seo::module.seo_item.title';
        $this->title_singular = 'utility-seo::module.seo_item.title_singular';

        parent::__construct();
    }

    public function index(SEOItemsRequest $request, SEOItemsDataTable $dataTable)
    {
        return $dataTable->render('utility-seo::seo_item.index');
    }

    /**
     * @param SEOItemsRequest $request
     * @return $this
     */
    public function create(SEOItemsRequest $request)
    {
        $seo_item = new SEOItem();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('utility-seo::seo_item.create_edit')->with(compact('seo_item'));
    }

    /**
     * @param SEOItemsRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(SEOItemsRequest $request)
    {
        try {
            $this->SEOItemService->store($request, SEOItem::class);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, SEOItem::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param SEOItemsRequest $request
     * @param SEOItem $seo_item
     * @return SEOItem
     */
    public function show(SEOItemsRequest $request, SEOItem $seo_item)
    {
        return $seo_item;
    }

    /**
     * @param SEOItemsRequest $request
     * @param SEOItem $seo_item
     * @return $this
     */
    public function edit(SEOItemsRequest $request, SEOItem $seo_item)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $seo_item->getIdentifier()])]);

        return view('utility-seo::seo_item.create_edit')->with(compact('seo_item'));
    }

    /**
     * @param SEOItemsRequest $request
     * @param SEOItem $seo_item
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(SEOItemsRequest $request, SEOItem $seo_item)
    {
        try {
            $this->SEOItemService->update($request, $seo_item);

            flash(trans('Corals::messages.success.updated', ['item' => $seo_item->getIdentifier()]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, SEOItem::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param SEOItemsRequest $request
     * @param SEOItem $seo_item
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SEOItemsRequest $request, SEOItem $seo_item)
    {
        try {
            $this->SEOItemService->destroy($request, $seo_item);

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $seo_item->getIdentifier()])];
        } catch (\Exception $exception) {
            log_exception($exception, SEOItem::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}
