<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TherapistResource;
use App\Models\Therapist;
use Illuminate\Http\Request;


class TherapistController extends Controller
{

    /* CONTROLLER Constructor */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
        $this->authorizeResource(Therapist::class, 'therapist');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query  = Therapist::query();
        return TherapistResource::collection(
            $query->latest()->paginate()
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validate request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'treatment_fields' => 'required|json',
            'education' => 'required|string',
            'phone_number' => 'required|string|max:11',
            'profile_picture' => 'nullable|string',
            'description' => 'required|string',
            'price' => 'required|numeric|between:0,9999.999',
            'work_experience' => 'required|integer|min:0',
            'therapist_code' => 'required|string',
        ],
        [
            'name.required' => 'نام خود را وارد کنید',
            'name.max' => 'نام نباید بیشتر از 255 کاراکتر باشد.',
            'treatment_fields.required' => 'فیلد‌های درمان الزامی هستند.',
            'treatment_fields.json' => 'فیلد‌های درمان باید یک رشته JSON معتبر باشند.',
            'education.required' => 'تحصیلات الزامی است.',
            'phone_number.required' => 'شماره تلفن الزامی است.',
            'phone_number.max' => 'شماره تلفن نباید بیشتر از 11 کاراکتر باشد.',
            'profile_picture.string' => 'تصویر پروفایل باید یک رشته معتبر باشد.',
            'description.required' => 'توضیحات الزامی است.',
            'price.required' => 'قیمت الزامی است.',
            'price.numeric' => 'قیمت باید یک عدد معتبر باشد.',
            'price.between' => 'قیمت باید بین 0 و 9999.999 باشد.',
            'work_experience.required' => 'تجربه کاری الزامی است.',
            'work_experience.integer' => 'تجربه کاری باید یک عدد صحیح باشد.',
            'work_experience.min' => 'تجربه کاری نباید کمتر از 0 باشد.',
            'therapist_code.required' => 'کد نظام روانشناسی خود یا معرف را وارد کنید', 
        ] 
    );

        //Check if therapist already exist
        $existingTherapist = Therapist::where('user_id', $request->user()->id)
            ->first();

        if ($existingTherapist) {
            return response()->json(['error' => 'قبلا ثبت نام کرده اید, جهت ویرایش اطلاعات وارد بخش ویرایش اطلاعات شوید'], 409);
        }

        $therapist = Therapist::create([
            ...$validatedData,
            'user_id' => $request->user()->id
        ]);

        if ($therapist) {
            //If the create was successfull
            return response()->json(['message' => 'اطلاعات شما با موفقیت تکمیل شد و پس از تایید در قسمت درمانگر ها نمایش داده خواهد شد'], 200);
        } else {
            //If there was issue with the create 
            return response()->json(['error' => 'در ثبت اطلاعات مشکلی پیش آمد', 500]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Therapist $therapist)
    {

        return new TherapistResource($therapist);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Therapist $therapist)
    {
        // Validate request data
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'treatment_fields' => 'nullable|json',
            'education' => 'nullable|string',
            'phone_number' => 'nullable|string|max:11',
            'profile_picture' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|between:0,9999.999',
            'work_experience' => 'nullable|integer|min:0',
        ]);


        $updated = $therapist->update($validatedData);

        if ($updated) {
            //If the update was successfull
            return response()->json(['message' => 'مشخصات شما با موفقیت به روز رسانی شد'], 200);
        } else {
            //If there was issue with the update
            return response()->json(['error' => 'به روز رسانی با مشکل مواجه شد', 500]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Therapist $therapist)
    {
        // Attempt to delete the therapist
        try {
            $therapist->delete();
            return response()->json(['message' => 'درمانگر با موفقیت پاک شد'], 200);
        } catch (\Exception $e) {
            // If there's an issue with the deletion
            return response()->json(['error' => 'متاسفانه درمانگر پاک نشد'], 500);
        }
    }
}
