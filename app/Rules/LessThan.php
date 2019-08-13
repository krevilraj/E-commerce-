<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class LessThan implements Rule
{
	/**
	 * @var
	 */
	private $val;

	/**
	 * Create a new rule instance.
	 *
	 * @param $val
	 */
    public function __construct($val)
    {
	    $this->val = $val;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $value < $this->val;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The sale price must be less than regular price.';
    }
}
