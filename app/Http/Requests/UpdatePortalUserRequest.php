<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Helpers\ResponseHelper;

class UpdatePortalUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Define validation rules
     */
    public function rules(): array
    {
        $rules = [
            'full_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'age' => 'nullable|integer',
            'mobile_no' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'institution' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:20',
            'course_id' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|string', // Changed to accept string (base64)
        ];
        
        // Check if the request contains an array of users (batch update)
        if (is_array($this->json()->all()[0] ?? null)) {
            $rules = [
                '*' => [
                    'full_name' => 'nullable|string|max:255',
                    'email' => 'nullable|email|max:255',
                    'age' => 'nullable|integer',
                    'mobile_no' => 'nullable|string|max:50',
                    'address' => 'nullable|string|max:255',
                    'institution' => 'nullable|string|max:255',
                    'password' => 'nullable|string|max:255',
                    'status' => 'nullable|string|max:20',
                    'course_id' => 'nullable|string|max:255',
                    'profile_picture' => 'nullable|string', // Changed to accept string (base64)
                ]
            ];
        }
        
        return $rules;
    }

    /**
     * Custom validation error messages
     */
    public function messages()
    {
        return [
            'full_name.max' => 'Full name must not exceed 255 characters',
            'email.max' => 'Email must not exceed 255 characters',
            'mobile_no.max' => 'Mobile number must not exceed 50 characters',
            'address.max' => 'Address must not exceed 255 characters',
            'institution.max' => 'Institution must not exceed 255 characters',
            'password.max' => 'Password must not exceed 255 characters',
            'status.max' => 'Status must not exceed 20 characters',
            'course_id.max' => 'Course ID must not exceed 255 characters',
            'profile_picture.string' => 'Profile picture must be a valid image string',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Handle single user update
            if (!is_array($this->json()->all()[0] ?? null)) {
                $this->validateProfilePicture($validator, $this->json('profile_picture'));
            } 
            // Handle batch update
            else {
                $users = $this->json()->all();
                foreach ($users as $index => $user) {
                    if (isset($user['profile_picture'])) {
                        $this->validateProfilePicture($validator, $user['profile_picture'], "users.$index.profile_picture");
                    }
                }
            }
        });
    }

    /**
     * Validate profile picture (base64 string)
     */
    private function validateProfilePicture($validator, $profilePicture, $field = 'profile_picture')
    {
        if (empty($profilePicture)) {
            return;
        }

        // Check if it's a valid base64 image
        if (!is_string($profilePicture) || !preg_match('/^data:image\/(\w+);base64,/', $profilePicture)) {
            $validator->errors()->add($field, 'The profile picture must be a valid base64 encoded image.');
            return;
        }

        // Extract image type
        preg_match('/^data:image\/(\w+);base64,/', $profilePicture, $matches);
        $imageType = $matches[1];

        // Check allowed image types
        $allowedTypes = ['jpeg', 'png', 'jpg', 'webp'];
        if (!in_array($imageType, $allowedTypes)) {
            $validator->errors()->add($field, 'The profile picture must be a file of type: jpeg, png, jpg, webp.');
            return;
        }

        // Check image size (approximate)
        $base64String = substr($profilePicture, strpos($profilePicture, ',') + 1);
        $sizeInBytes = (int) (strlen(rtrim($base64String, '=')) * 3 / 4);
        
        if ($sizeInBytes > 2048 * 1024) { // 2MB
            $validator->errors()->add($field, 'The profile picture must not be greater than 2048 kilobytes.');
        }
    }

    /*
    * Important note: without this function, for any validation error,
    * it reports a 404 error.
    */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ResponseHelper::invalid($validator->errors()->all(), "Error while validating request")
        );
    }
}