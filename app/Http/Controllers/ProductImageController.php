<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function destroy($id)
    {
        $image = ProductImage::findOrFail($id);
        Storage::delete('public/' . $image->image_path);
        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully');
    }

    public function setMain($id)
    {
        $image = ProductImage::findOrFail($id);

        ProductImage::where('product_id', $image->product_id)
            ->update(['is_main' => false]);

        $image->is_main = true;
        $image->save();

        return redirect()->back()->with('success', 'Main image updated successfully');
    }
}
