<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Category;
use App\Models\Slide;
use App\Models\Content;
use App\Models\DiscountCode;
use App\Models\DiscountType;
use Illuminate\Http\Request;

class DefinitionController extends Controller
{
    public function sections()
    {
        $sections = Section::orderBy('order')->paginate(10);
        return view('definitions.sections', compact('sections'));
    }

    public function storeSection(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Section::create([
            'name' => $request->name,
            'eng' => $request->eng,
            'order' => Section::max('order') + 1
        ]);

        return redirect()->route('definitions.sections')->with('success', 'Bölüm başarıyla eklendi.');
    }

    public function updateSection(Request $request, Section $section)
    {
        if ($request->has('order')) {
            $section->update(['order' => $request->order]);
        } else {
            $request->validate([
                'name' => 'required|string|max:255'
            ]);

            $section->update([
                'name' => $request->name,
                'eng' => $request->eng
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function deleteSection(Section $section)
    {
        $section->delete();
        return response()->json(['success' => true]);
    }

    public function categories()
    {
        $sections = Section::orderBy('order')->get();
        $categories = Category::with('section')->orderBy('order')->paginate(10);
        return view('definitions.categories', compact('sections', 'categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'name' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only(['section_id', 'name', 'eng', 'percentage', 'link']);
        $data['order'] = Category::max('order') + 1;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/categories'), $filename);
            $data['file'] = $filename;
        }

        Category::create($data);

        return redirect()->route('definitions.categories')->with('success', 'Kategori başarıyla eklendi.');
    }

    public function updateCategory(Request $request, Category $category)
    {
        if ($request->has('order')) {
            $category->update(['order' => $request->order]);
            return response()->json(['success' => true]);
        }

        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'name' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only(['section_id', 'name', 'eng', 'percentage', 'link']);

        if ($request->hasFile('file')) {
            // Eski dosyayı sil
            if ($category->file) {
                $oldFile = public_path('uploads/categories/' . $category->file);
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/categories'), $filename);
            $data['file'] = $filename;
        }

        $category->update($data);
        return response()->json(['success' => true]);
    }

    public function deleteCategory(Category $category)
    {
        if ($category->file) {
            $file = public_path('uploads/categories/' . $category->file);
            if (file_exists($file)) {
                unlink($file);
            }
        }

        $category->delete();
        return response()->json(['success' => true]);
    }

    public function slides()
    {
        $sections = Section::orderBy('order')->get();
        $slides = Slide::with('section')->orderBy('order')->paginate(10);
        return view('definitions.slides', compact('sections', 'slides'));
    }

    public function storeSlide(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'title' => 'required|string|max:255',
            'photo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only([
            'section_id', 'title', 'eng', 'description', 'eng_description',
            'description1', 'eng_description1', 'link', 'style'
        ]);
        $data['order'] = Slide::max('order') + 1;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/slides'), $filename);
            $data['photo'] = $filename;
        }

        Slide::create($data);

        return redirect()->route('definitions.slides')->with('success', 'Slayt başarıyla eklendi.');
    }

    public function updateSlide(Request $request, Slide $slide)
    {
        if ($request->has('order')) {
            $slide->update(['order' => $request->order]);
            return response()->json(['success' => true]);
        }

        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'title' => 'required|string|max:255',
            'photo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only([
            'section_id', 'title', 'eng', 'description', 'eng_description',
            'description1', 'eng_description1', 'link', 'style'
        ]);

        if ($request->hasFile('photo')) {
            // Eski fotoğrafı sil
            if ($slide->photo) {
                $oldPhoto = public_path('uploads/slides/' . $slide->photo);
                if (file_exists($oldPhoto)) {
                    unlink($oldPhoto);
                }
            }

            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/slides'), $filename);
            $data['photo'] = $filename;
        }

        $slide->update($data);
        return response()->json(['success' => true]);
    }

    public function deleteSlide(Slide $slide)
    {
        if ($slide->photo) {
            $photo = public_path('uploads/slides/' . $slide->photo);
            if (file_exists($photo)) {
                unlink($photo);
            }
        }

        $slide->delete();
        return response()->json(['success' => true]);
    }

    public function contents()
    {
        $sections = Section::orderBy('order')->get();
        $contents = Content::with('section')->orderBy('order')->paginate(10);
        return view('definitions.contents', compact('sections', 'contents'));
    }

    public function storeContent(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'type' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'photo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only([
            'section_id', 'type', 'title', 'eng', 'description',
            'eng_description', 'link'
        ]);
        $data['order'] = Content::max('order') + 1;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/contents'), $filename);
            $data['photo'] = $filename;
        }

        Content::create($data);

        return redirect()->route('definitions.contents')->with('success', 'İçerik başarıyla eklendi.');
    }

    public function updateContent(Request $request, Content $content)
    {
        if ($request->has('order')) {
            $content->update(['order' => $request->order]);
            return response()->json(['success' => true]);
        }

        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'type' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'photo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only([
            'section_id', 'type', 'title', 'eng', 'description',
            'eng_description', 'link'
        ]);

        if ($request->hasFile('photo')) {
            // Eski fotoğrafı sil
            if ($content->photo) {
                $oldPhoto = public_path('uploads/contents/' . $content->photo);
                if (file_exists($oldPhoto)) {
                    unlink($oldPhoto);
                }
            }

            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/contents'), $filename);
            $data['photo'] = $filename;
        }

        $content->update($data);
        return response()->json(['success' => true]);
    }

    public function deleteContent(Content $content)
    {
        if ($content->photo) {
            $photo = public_path('uploads/contents/' . $content->photo);
            if (file_exists($photo)) {
                unlink($photo);
            }
        }

        $content->delete();
        return response()->json(['success' => true]);
    }

    public function contentsList(Request $request)
    {
        $query = Content::with('section')->orderBy('order');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('eng', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhereHas('section', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('section_id')) {
            $query->where('section_id', $request->section_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $contents = $query->paginate(10)->withQueryString();
        $sections = Section::orderBy('order')->get();

        return view('definitions.contents-list', compact('contents', 'sections'));
    }

    public function discountCodes()
    {
        $discountCodes = DiscountCode::orderBy('order')->paginate(10);
        return view('definitions.discount-codes', compact('discountCodes'));
    }

    public function storeDiscountCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:discount_codes',
            'description' => 'nullable|string',
            'rate' => 'required|numeric|min:0|max:100'
        ]);

        DiscountCode::create([
            'code' => $request->code,
            'description' => $request->description,
            'rate' => $request->rate,
            'order' => DiscountCode::max('order') + 1
        ]);

        return redirect()->route('definitions.discount-codes')->with('success', 'İskonto kodu başarıyla eklendi.');
    }

    public function updateDiscountCode(Request $request, DiscountCode $discountCode)
    {
        if ($request->has('order')) {
            $discountCode->update(['order' => $request->order]);
            return response()->json(['success' => true]);
        }

        $request->validate([
            'code' => 'required|string|max:255|unique:discount_codes,code,' . $discountCode->id,
            'description' => 'nullable|string',
            'rate' => 'required|numeric|min:0|max:100'
        ]);

        $discountCode->update([
            'code' => $request->code,
            'description' => $request->description,
            'rate' => $request->rate
        ]);

        return response()->json(['success' => true]);
    }

    public function deleteDiscountCode(DiscountCode $discountCode)
    {
        $discountCode->delete();
        return response()->json(['success' => true]);
    }

    public function discountTypes()
    {
        $discountTypes = DiscountType::orderBy('order')->paginate(10);
        return view('definitions.discount-types', compact('discountTypes'));
    }

    public function storeDiscountType(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'eng' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'eng_description' => 'nullable|string',
            'rate' => 'required|numeric|min:0|max:100'
        ]);

        DiscountType::create([
            'name' => $request->name,
            'eng' => $request->eng,
            'description' => $request->description,
            'eng_description' => $request->eng_description,
            'rate' => $request->rate,
            'order' => DiscountType::max('order') + 1
        ]);

        return redirect()->route('definitions.discount-types')->with('success', 'İskonto tipi başarıyla eklendi.');
    }

    public function updateDiscountType(Request $request, DiscountType $discountType)
    {
        if ($request->has('order')) {
            $discountType->update(['order' => $request->order]);
            return response()->json(['success' => true]);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'eng' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'eng_description' => 'nullable|string',
            'rate' => 'required|numeric|min:0|max:100'
        ]);

        $discountType->update([
            'name' => $request->name,
            'eng' => $request->eng,
            'description' => $request->description,
            'eng_description' => $request->eng_description,
            'rate' => $request->rate
        ]);

        return response()->json(['success' => true]);
    }

    public function deleteDiscountType(DiscountType $discountType)
    {
        $discountType->delete();
        return response()->json(['success' => true]);
    }

    public function discountTypesList(Request $request)
    {
        $query = DiscountType::orderBy('order');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('eng', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $discountTypes = $query->paginate(10)->withQueryString();
        return view('definitions.discount-types-list', compact('discountTypes'));
    }

    public function transfer()
    {
        return view('definitions.transfer');
    }

    public function startTransfer(Request $request)
    {
        $request->validate([
            'type' => 'required|string'
        ]);

        // Burada aktarım işlemi gerçekleştirilecek
        // Örnek olarak başarılı yanıt dönüyoruz
        return response()->json(['success' => true, 'message' => 'Aktarım başarıyla başlatıldı.']);
    }

    public function fileImport()
    {
        return view('definitions.file-import');
    }

    public function startFileImport(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240'
        ]);

        // Dosyayı geçici olarak kaydet
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/imports'), $filename);

        // Başarılı yanıt dön
        return response()->json([
            'success' => true,
            'message' => 'Dosya başarıyla yüklendi ve aktarım başlatıldı.'
        ]);
    }

    public function photoUpload()
    {
        return view('definitions.photo-upload');
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'photo' => 'required|file|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Dosyayı yükle
        $file = $request->file('photo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/photos'), $filename);

        // Başarılı yanıt dön
        return response()->json([
            'success' => true,
            'message' => 'Fotoğraf başarıyla yüklendi.',
            'filename' => $filename
        ]);
    }
}
