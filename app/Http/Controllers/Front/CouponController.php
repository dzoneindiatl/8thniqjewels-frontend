<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    public function index()
    {
        $user = Auth::guard('customer')->user();

        if (!$user || (int) $user->user_role_id !== 5) {
            return response()->json([
                'success' => false,
                'message' => 'Only affiliate accounts can view coupons.',
            ], 403);
        }

        $table = (new Coupon())->getTable();
        if (!Schema::hasColumn($table, 'created_by')) {
            return response()->json(['success' => true, 'coupons' => []]);
        }

        $couponPage = Coupon::where('created_by', $user->id)
            ->orderByDesc('id')
            ->paginate(10);

        $coupons = collect($couponPage->items())->map(function (Coupon $coupon) {
                return [
                    'id' => $coupon->id,
                    'name' => $coupon->name ?? $coupon->coupon_name ?? '',
                    'coupon_code' => $coupon->coupon_code,
                    'discount_type' => $coupon->discount_type,
                    'discount_value' => $coupon->discount_value,
                    'min_cart_value' => $coupon->min_cart_value ?? $coupon->min_amount ?? null,
                    'max_discount' => $coupon->max_discount,
                    'start_date' => $coupon->start_date ? substr((string) $coupon->start_date, 0, 10) : '',
                    'end_date' => $coupon->end_date ? substr((string) $coupon->end_date, 0, 10) : '',
                    'is_unlimited' => (int) ($coupon->is_unlimited ?? 0),
                    'available_coupons' => $coupon->available_coupons,
                    'per_user_avalibity' => $coupon->per_user_avalibity,
                    'is_active' => (int) ($coupon->is_active ?? 0),
                ];
            })->values();

        return response()->json([
            'success' => true,
            'coupons' => $coupons,
            'pagination' => [
                'current_page' => $couponPage->currentPage(),
                'last_page' => $couponPage->lastPage(),
                'per_page' => $couponPage->perPage(),
                'total' => $couponPage->total(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::guard('customer')->user();

        if (!$user || (int) $user->user_role_id !== 5) {
            return response()->json([
                'success' => false,
                'message' => 'Only affiliate accounts can create coupons.',
            ], 403);
        }

        $columns = Schema::getColumnListing((new Coupon())->getTable());
        $couponId = filter_var($request->input('coupon_id'), FILTER_VALIDATE_INT);
        $uniqueCouponCode = Rule::unique('coupons', 'coupon_code');
        if ($couponId !== false && $couponId !== null) {
            $uniqueCouponCode->ignore($couponId);
        }

        $validator = Validator::make($request->all(), [
            'coupon_id' => ['nullable', 'integer', 'exists:coupons,id'],
            'name' => ['required', 'string', 'max:255'],
            'coupon_code' => ['required', 'string', 'max:100', 'regex:/^[A-Za-z0-9]+$/', $uniqueCouponCode],
            'discount_type' => ['required', Rule::in(['flat', 'percentage'])],
            'discount_value' => ['required', 'numeric', 'gt:0'],
            'min_cart_value' => ['nullable', 'numeric', 'min:0'],
            'max_discount' => ['nullable', 'numeric', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'is_unlimited' => ['required', 'boolean'],
            'available_coupons' => ['required_if:is_unlimited,0', 'nullable', 'integer', 'min:1'],
            'per_user_avalibity' => ['required', 'integer', 'min:1'],
            'is_active' => ['required', 'boolean'],
        ], [
            'coupon_code.unique' => 'The coupon code has already been taken.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please correct the highlighted fields.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $maximumPercentage = min(100, (float) ($user->referal_max_percentage ?? 0));
        if ($data['discount_type'] === 'percentage' && $data['discount_value'] > $maximumPercentage) {
            return response()->json([
                'success' => false,
                'message' => 'Please correct the highlighted fields.',
            'errors' => ['discount_value' => ["Percentage discounts cannot exceed {$maximumPercentage}%."]],
            ], 422);
        }

        if (!empty($data['start_date']) && !empty($data['end_date']) && $data['end_date'] < $data['start_date']) {
            return response()->json([
                'success' => false,
                'message' => 'Please correct the highlighted fields.',
                'errors' => ['end_date' => ['The end date must be on or after the start date.']],
            ], 422);
        }

        $coupon = new Coupon();
        if (!empty($couponId)) {
            if (!in_array('created_by', $columns, true)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Editing existing coupons is not available.',
                ], 422);
            }

            $coupon = Coupon::where('created_by', $user->id)->find($couponId);
            if (!$coupon) {
                return response()->json([
                    'success' => false,
                    'message' => 'Coupon not found.',
                ], 404);
            }
        }

        $attributes = [
            'name' => $data['name'],
            'coupon_name' => $data['name'],
            'coupon_code' => $data['coupon_code'],
            'discount_type' => $data['discount_type'],
            'discount_value' => $data['discount_value'],
            'max_discount' => $data['max_discount'] ?? null,
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'is_unlimited' => (int) $data['is_unlimited'],
            'available_coupons' => (int) $data['is_unlimited'] === 1 ? 0 : (int) $data['available_coupons'],
            'per_user_avalibity' => $data['per_user_avalibity'],
            'is_active' => (int) $data['is_active'],
            'show_on_detail' => 1,
            'coupon_type' => 2,
            'user_type' => 1,
        ];

        $minimumCartColumn = in_array('min_cart_value', $columns, true)
            ? 'min_cart_value'
            : (in_array('min_amount', $columns, true) ? 'min_amount' : null);
        if ($minimumCartColumn) {
            $attributes[$minimumCartColumn] = $data['min_cart_value'] ?? null;
        }

        if (!$coupon->exists && in_array('created_by', $columns, true)) {
            $attributes['created_by'] = $user->id;
        }

        $coupon->fill(array_intersect_key($attributes, array_flip($columns)));
        $coupon->save();

        return response()->json([
            'success' => true,
            'message' => 'Coupon saved successfully.',
            'coupon_id' => $coupon->id,
        ]);
    }
}