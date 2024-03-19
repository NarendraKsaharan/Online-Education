<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPageRequest;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Models\Page;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PageController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('page_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Page::with(['parent_page'])->select(sprintf('%s.*', (new Page)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'page_show';
                $editGate      = 'page_edit';
                $deleteGate    = 'page_delete';
                $crudRoutePart = 'pages';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('parent_page_title', function ($row) {
                return $row->parent_page ? $row->parent_page->title : '';
            });

            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });
            $table->editColumn('heading', function ($row) {
                return $row->heading ? $row->heading : '';
            });
            $table->editColumn('show_in_menu', function ($row) {
                return $row->show_in_menu ? Page::SHOW_IN_MENU_SELECT[$row->show_in_menu] : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Page::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'parent_page']);

            return $table->make(true);
        }

        $pages = Page::get();

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        abort_if(Gate::denies('page_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $parent_pages = Page::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.pages.create', compact('parent_pages'));
    }

    public function store(StorePageRequest $request)
    {
        $page = Page::create($request->all());

        foreach ($request->input('page_image', []) as $file) {
            $page->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('page_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $page->id]);
        }

        return redirect()->route('admin.pages.index');
    }

    public function edit(Page $page)
    {
        abort_if(Gate::denies('page_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $parent_pages = Page::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $page->load('parent_page');

        return view('admin.pages.edit', compact('page', 'parent_pages'));
    }

    public function update(UpdatePageRequest $request, Page $page)
    {
        $page->update($request->all());

        if (count($page->page_image) > 0) {
            foreach ($page->page_image as $media) {
                if (! in_array($media->file_name, $request->input('page_image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $page->page_image->pluck('file_name')->toArray();
        foreach ($request->input('page_image', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $page->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('page_image');
            }
        }

        return redirect()->route('admin.pages.index');
    }

    public function show(Page $page)
    {
        abort_if(Gate::denies('page_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $page->load('parent_page', 'parentPagePages');

        return view('admin.pages.show', compact('page'));
    }

    public function destroy(Page $page)
    {
        abort_if(Gate::denies('page_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $page->delete();

        return back();
    }

    public function massDestroy(MassDestroyPageRequest $request)
    {
        $pages = Page::find(request('ids'));

        foreach ($pages as $page) {
            $page->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('page_create') && Gate::denies('page_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Page();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
