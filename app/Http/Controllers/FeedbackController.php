<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ProductID' => 'required|exists:product,ProductID',
            'Rating' => 'required|numeric|min:1|max:5',
            'CommentText' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Kiểm tra xem người dùng đã review sản phẩm này chưa
            $existingReview = Feedback::where('ProductID', $request->ProductID)
                ->where('AccountID', Auth::id())
                ->first();

            if ($existingReview) {
                return redirect()->back()
                    ->with('error', 'You have already reviewed this product.');
            }

            Feedback::create([
                'ProductID' => $request->ProductID,
                'AccountID' => Auth::id(),
                'Rating' => $request->Rating,
                'CommentText' => $request->CommentText,
                'SubmissionDate' => now(),
            ]);

            return redirect()->back()
                ->with('success', 'Thank you for your review!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error submitting review: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);

        // Chỉ cho phép xóa review của chính mình hoặc admin
        if ($feedback->AccountID != Auth::id() && Auth::user()->Role != 1) {
            abort(403, 'Unauthorized action.');
        }

        $feedback->delete();

        return redirect()->back()
            ->with('success', 'Review deleted successfully.');
    }
}
