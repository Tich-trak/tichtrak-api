<x-mail::message>

# Hello {{$user->name}},

We hope this email finds you well. It seems like you've forgotten your password for our
Educational Evaluation System. No worries, we've got you covered!

To reset your password and regain access to your account, please follow these simple steps:

1. Click on the "Forgot Password" link below:
{{env('APP_URL') .  '/api/v1/reset_token/' . $token}}

2. You will be directed to a password reset page. Please enter your registered email address associated with your account.

3. Once you've submitted your email address, you will receive a verification code in your inbox.
Please enter the verification code on the password reset page.

4. After successful verification, you can set a new password for your account.

Please ensure your new password meets the following criteria:
   - At least 8 characters long
   - Includes a combination of letters (uppercase and lowercase), numbers, and special characters

5. Click on the "Reset Password" button to finalize the process.

If you did not request this password reset or believe you received this email in error, please disregard it.
Your account will remain secure, and no changes will be made.

For security purposes, we recommend that you do not share your password or verification code with anyone.
If you encounter any issues during the password reset process or have any concerns about the security of your account,
please don't hesitate to contact our support team at tichtrak@gmail.com.

<x-mail::button :url="env('APP_URL') . '/api/v1/reset_token/' . $token" color="primary">
Reset Password
</x-mail::button>

# Button Not Working?? Try pasting the link below into your Browser

{{env('APP_URL') .  '/api/v1/reset_token/' . $token}}

<x-mail::subcopy>
Thank you for being a valued member of our educational community. We strive to provide you with the best experience,
and your account security is of utmost importance to us.
</x-mail::subcopy>

Thanks,<br>
{{ config('app.name') }}

</x-mail::message>
