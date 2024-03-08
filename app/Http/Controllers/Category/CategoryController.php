<?php

namespace App\Http\Controllers\Category;

use App\Utility;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdRequest;
use App\Http\Requests\CategoryDelRequest;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        DB::connection()->enableQueryLog();
        $this->categoryRepository = $categoryRepository;
    }

    public function getForm()
    {
        $screen = "Show Category Form !!";
        try {
            Utility::saveInfoLog($screen);
            return view('backend.category.form');
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }

    }

    public function store(CategoryRequest $request)
    {
        $screen = "Category Post Method !!";
        try {
            $response = $this->categoryRepository->createCategory($request->all());
            if ($response == '200') {
                $queryLog = DB::getQueryLog();
                Utility::saveDebugLog($screen, $queryLog);
                return redirect('sg-backend/category/list')->with(['successMessage' => 'Create Category Success'])->withInput();
            }
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            return redirect('sg-backend/category/list')->with(['errorMessage' => ' Create Category Fail'])->withInput();
        }

    }

    public function getList()
    {
        $screen = "Show Category List !!";
        try {
            $categories = $this->categoryRepository->selectAllCategory();
            $queryLog = DB::getQueryLog();
            Utility::saveDebugLog($screen, $queryLog);
            return view('backend.category.list', compact('categories'));
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }

    public function getEdit($id)
    {
        $screen = "Category Edit Screen !!";
        try {
            $category = $this->categoryRepository->selectCategory((int) $id);
            if ($category == null) {
                return response()->view('errors.404', [], 404);
            }
            return view('backend.category.form', compact('category'));
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }

    public function updateForm(CategoryUpdRequest $request)
    {
        $screen = "Category Update Method !!";
        try {
            $response = $this->categoryRepository->updateCategory($request->all());
            if ($response == '200') {
                $queryLog = DB::getQueryLog();
                Utility::saveDebugLog($screen, $queryLog);
                return redirect('sg-backend/category/list')->with(['successMessage' => 'Update Category Success'])->withInput();
            }
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            return redirect('sg-backend/category/list')->with(['errorMessage' => 'Update Category Fail'])->withInput();
        }
    }

    public function categoryDelete(CategoryDelRequest $request)
    {
        $screen = "Category Delete Method!!";
        try {
            $response = $this->categoryRepository->deleteCategory($request->id);
            if ($response == '200') {
                $queryLog = DB::getQueryLog();
                Utility::saveDebugLog($screen, $queryLog);
                return redirect('sg-backend/category/list')->with(['successMessage' => 'Delete Category Success'])->withInput();
            } else {
                return redirect('sg-backend/category/list')->with(['errorMessage' => 'Delete Category Fail'])->withInput();
            }
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }
}
