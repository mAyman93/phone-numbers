<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $countryCodes;
    private $countryRegex;

    public function __construct()
    {
        $this->countryCodes = config('constants.country_codes');
        $this->countryRegex = config('constants.country_regex');
    }

    public function getPhoneNumbers(Request $request)
    {
        $country = $request->country;;
        $state = $request->state;
        if ($request->has('country') || $request->has('state')) {
            $phoneNumbers = Customer::getPhoneNumbers();
        } else {
            $phoneNumbers = Customer::getPhoneNumbersPaginated($request->rowsPerPage);
        }
        $phoneNumbersFormulated = $this->formulatePhoneNumbers($phoneNumbers, $country, $state);
        if (method_exists($phoneNumbersFormulated, 'links')) {
            return response()->json($phoneNumbersFormulated);
        }
        return response()->json(['data' => $phoneNumbersFormulated]);
    }

    public function formulatePhoneNumbers($phoneNumbers, $countryFilter = null, $stateFilter = null)
    {
        foreach ($phoneNumbers as $key => $phoneNumber) {
            $phone = $phoneNumber->phone;
            $countryCode = $this->getCountryCodeFromPhone($phone);
            $country = $this->getCountryFromCode($countryCode);
            $state = $this->validatePhone($phone, $country);
            $phoneNumber->countryCode = '+' . $countryCode;
            $phoneNumber->country = $country;
            $phoneNumber->state = $state ? 'OK' : 'NOK';
            $phoneNumber->phone = explode(" ", $phone)[1];
            if (
                $this->removedByFilter($countryFilter, $country) ||
                $this->removedByFilter($stateFilter, $state)
            ) {
                unset($phoneNumbers[$key]);
            }
        }
        return $phoneNumbers;
    }

    public function getCountryCodeFromPhone($phone)
    {
        $countryCode = explode(" ", $phone)[0];
        $countryCode = ltrim($countryCode, '(');
        $countryCode = rtrim($countryCode, ')');
        return $countryCode;
    }

    public function getCountryFromCode($code)
    {
        if (isset($this->countryCodes[$code])) {
            return $this->countryCodes[$code];
        }
    }

    public function validatePhone($phone, $country)
    {
        if(!isset($this->countryRegex[$country])) {
            return 0;
        }
        $regex = $this->countryRegex[$country];
        return preg_match($regex, $phone);
    }

    public function removedByFilter($filter, $attribute)
    {
        if ($filter == null) {
            return false;
        }
        return $attribute != $filter;
    }
}
